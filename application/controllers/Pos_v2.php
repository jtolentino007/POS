<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Pos_v2 extends CORE_Controller
	{
		
		function __construct()
		{
			parent::__construct('');
			$this->validate_session();
			$this->load->model(
				array(
					'Categories_model',
					'Products_model',
					'Pos_model',
					'Pos_items_model',
					'Order_tables_model',
					'Pos_payment_model',
					'Batches_model',
					'Pos_items_ajax_model',
					'Pos_ajax_model',
					'User_groups_model',
					'Pos_invoice_server_model',
					'Void_logs_model'
				)
			);
		}

		public function index()
		{
			$data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        	$data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        	$data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        	$data['_product_categories'] = $this->Categories_model->get_list(
        		'is_deleted=FALSE',
        		null,
        		null,
        		'category_desc'
        	);
        	$data['user_name'] = $this->session->user_fullname;
        	$data['user_group_id'] = $this->session->user_group_id;
        	$data['user_groups'] = $this->User_groups_model->get_list($this->session->user_group_id)[0];

			$this->db->truncate('pos_invoice_ajax');
			$this->db->truncate('pos_invoice_items_ajax');

			$this->load->view('pos_v2_view',$data);
		}

		public function getList($type=null, $category=null)
		{
			switch ($type) {
				case 'product-by-category':
						$m_products=$this->Products_model;

						$data['response'] = $m_products->get_list(
							'is_active=TRUE AND is_deleted=FALSE AND category_id='.$category
						);

						echo json_encode($data);
					break;

				case 'get-unpaid':
						$m_pos=$this->Pos_model;

						$data['response']=$m_pos->get_unpaid_orders();

						echo json_encode($data);
					break;

				case 'get-receipts':
						$m_payment = $this->Pos_payment_model;

						$data['response']=$m_payment->get_receipt_list();

						echo json_encode($data);
					break;

				case 'pos-items':
						$m_pos_items = $this->Pos_items_model;
						$m_order_tables = $this->Order_tables_model;
						$m_pos_servers = $this->Pos_invoice_server_model;

						$pos_invoice_id = $this->input->get('inv_id',TRUE);

						$response['items'] = $m_pos_items->get_list(
							'pi.pos_invoice_id='.$pos_invoice_id.' AND is_paid=FALSE',
							'pos_invoice_items.pos_invoice_id,
							pos_invoice_items.product_id,
							SUM(pos_invoice_items.pos_qty) pos_qty,
							pos_invoice_items.pos_price,
							SUM(pos_invoice_items.pos_discount) pos_discount,
							pos_invoice_items.tax_rate,
							SUM(pos_invoice_items.tax_amount) tax_amount, 
							SUM(pos_invoice_items.total) total, 
							pi.pos_invoice_no, 
							pi.total_discount, 
							pi.before_tax,
							pi.total_tax_amount, 
							pi.total_after_tax, 
							c.customer_id,
							c.customer_name,
							p.product_desc,
							p.vendor_id',
							array(
								array('pos_invoice pi','pi.pos_invoice_id=pos_invoice_items.pos_invoice_id','inner'),
								array('customers c','c.customer_id=pi.customer_id','left'),
								array('products p','p.product_id=pos_invoice_items.product_id','left')
							),
							null,
							'pos_invoice_items.pos_invoice_id, pos_invoice_items.product_id'
						);

						$response['servers'] = $m_pos_items->get_servers_edit($pos_invoice_id);

						$response['tables'] = $m_order_tables->get_list(
							'pos_invoice_id='.$pos_invoice_id,
							't.*',
							array(
								array('tables t','t.table_id=order_tables.table_id','left')
							)
						);

						echo json_encode($response);
					break;
			}
		}

		public function endBatch()
		{
			$m_pos=$this->Pos_model;
			$m_batches = $this->Batches_model;
		
			$sql="SELECT 
				COUNT(*) 
				non_ended_batch 
				FROM pos_invoice 
				WHERE end_batch = FALSE";


			$sql2="SELECT
				   COUNT(*)
				   no_unpaid
				   FROM pos_invoice
				   WHERE is_paid = FALSE";

			$user_id = $this->session->user_id;

			$result2 = $this->db->query($sql2)->result();
			$result = $this->db->query($sql)->result();
			$no_of_non_ended_batch = $result[0]->non_ended_batch;
			$no_of_unpaid_invoices = $result2[0]->no_unpaid;

			if ($no_of_unpaid_invoices > 0) {
				$response['title'] = "Error!";
				$response['stat'] = "error";	
				$response['msg'] = "There are unpaid invoices, please make sure invoices are paid before ending this batch.";
			} else {
				if ($no_of_non_ended_batch > 0) 
				{
					$query = $this->db->update('pos_invoice', array('is_current_batch ' => FALSE));

					$invoice = $this->db->query('SELECT pos_invoice.pos_invoice_id FROM pos_invoice WHERE end_batch = 0');

					foreach ($invoice->result() as $row)
					{
						$pos_invoice_id = $row->pos_invoice_id;

						$updateArray[] = array(
							'pos_invoice_id'=> $pos_invoice_id,
							'end_batch' => "1",
							'is_current_batch' => "1"
						);
					}
					$this->db->update_batch('pos_invoice', $updateArray, 'pos_invoice_id');

					date_default_timezone_set('Asia/Manila');
					$m_batches->time_out = date("h:i:sa");
					$m_batches->modify($this->session->batch_id);

					$response['title'] = "Success!";
					$response['stat'] = "success";	
					$response['msg'] = "Batch successfully ended";
				} 
				else 
				{
					$response['title'] = "Error!";
					$response['stat'] = "error";
					$response['msg'] = "End Batch Failed, no invoices found.";
				}
			}
			

			echo json_encode($response);
		}

		public function CreateTempInvoice()
		{
			$m_pos_ajax = $this->Pos_ajax_model;

			$this->db->truncate('pos_invoice_ajax');
			$this->db->truncate('pos_invoice_items_ajax');

			$m_pos_ajax->begin();

			$m_pos_ajax->set('transaction_date','NOW()');
			$m_pos_ajax->customer_id = $this->input->post('customer_id',TRUE);
			$m_pos_ajax->user_id = $this->session->userdata('user_id');
			$m_pos_ajax->total_discount = $this->get_numeric_value($this->input->post('total_discount',TRUE));
			$m_pos_ajax->before_tax = $this->get_numeric_value($this->input->post('before_tax',TRUE));
			$m_pos_ajax->total_tax_amount = $this->get_numeric_value($this->input->post('total_tax_amount',TRUE));
			$m_pos_ajax->total_after_tax = $this->get_numeric_value($this->input->post('total_after_tax',TRUE));
			$m_pos_ajax->batch_id = $this->session->batch_id;
			$m_pos_ajax->save();

			$m_pos_ajax->commit();
		}

		public function CreateTempInvoiceItems()
		{
			$m_pos_items_ajax = $this->Pos_items_ajax_model;

			$this->db->truncate('pos_invoice_ajax');
			$this->db->truncate('pos_invoice_items_ajax');

			$pos_invoice_id = $this->input->post('pos_invoice_id',TRUE);
			$customer_id = $this->input->post('customer_id',TRUE);

			$product_id = $this->input->post('product_id', TRUE);
			$pos_qty = $this->input->post('pos_qty', TRUE);
			$pos_price = $this->input->post('pos_price', TRUE);
			$pos_discount = $this->input->post('pos_discount', TRUE);
			$tax_rate = $this->input->post('tax_rate', TRUE);
			$tax_amount = $this->input->post('tax_amount', TRUE);
			$total = $this->input->post('total', TRUE);
			$grand_total = $this->input->post('grand_total', TRUE);
			$status = $this->input->post('status', TRUE);

			for($i=0;$i<count($product_id);$i++) 
			{
				$m_pos_items_ajax->customer_id = $customer_id;
				$m_pos_items_ajax->pos_invoice_id = $pos_invoice_id;
				$m_pos_items_ajax->product_id = $product_id[$i];
				$m_pos_items_ajax->grand_total = $this->get_numeric_value($grand_total);
				$m_pos_items_ajax->pos_qty = $this->get_numeric_value($pos_qty[$i]);
				$m_pos_items_ajax->pos_price = $this->get_numeric_value($pos_price[$i]);
				$m_pos_items_ajax->pos_discount = $this->get_numeric_value($pos_discount[$i]);
				$m_pos_items_ajax->tax_rate = $this->get_numeric_value($tax_rate[$i]);
				$m_pos_items_ajax->total = $this->get_numeric_value($total[$i]);
				$m_pos_items_ajax->tax_amount = $this->get_numeric_value($tax_amount[$i]);
				$m_pos_items_ajax->status = $this->get_numeric_value($status[$i]);
				$m_pos_items_ajax->save();
			}
		}

		public function payOrder()
		{
			$m_payment = $this->Pos_payment_model;
			$m_pos = $this->Pos_model;

			$m_payment->begin();

			$m_payment->amount_due = $this->get_numeric_value($this->input->post('amount_due',TRUE));
			$m_payment->tendered = $this->get_numeric_value($this->input->post('tendered',TRUE));
			$m_payment->change = $this->get_numeric_value($this->input->post('change',TRUE));
			$m_payment->pos_invoice_id = $this->get_numeric_value($this->input->post('pos_invoice_id',TRUE));
			$m_payment->approved_by = $this->get_numeric_value($this->input->post('approved_by',TRUE));
			$m_payment->set('transaction_date','NOW()');
			$m_payment->save();

			$pos_payment_id = $m_payment->last_insert_id();

			$m_payment->receipt_no = "INV-".str_pad($pos_payment_id, 8, "0", STR_PAD_LEFT);

			$m_payment->modify($pos_payment_id);

			$m_payment->commit();

			$m_pos->set('is_paid',TRUE);
			$m_pos->modify($this->input->post('pos_invoice_id',TRUE));

			$response['pos_payment_id'] = $pos_payment_id;
			$response['title'] = 'Success!';
            $response['stat'] = 'success';
            $response['msg'] = 'Order successfully paid.';

            echo json_encode($response);
		}

		public function createInvoice()
		{
			$m_pos = $this->Pos_model;
			$m_pos_items = $this->Pos_items_model;
			$m_order_tables = $this->Order_tables_model;
			$m_voids = $this->Void_logs_model;

			$m_pos->begin();

			$m_pos->set('transaction_date','NOW()');
			$m_pos->customer_id = $this->input->post('customer_id',TRUE);
			$m_pos->user_id = $this->session->userdata('user_id');
			$m_pos->total_discount = $this->get_numeric_value($this->input->post('total_discount',TRUE));
			$m_pos->before_tax = $this->get_numeric_value($this->input->post('before_tax',TRUE));
			$m_pos->total_tax_amount = $this->get_numeric_value($this->input->post('total_tax_amount',TRUE));
			$m_pos->total_after_tax = $this->get_numeric_value($this->input->post('total_after_tax',TRUE));
			$m_pos->batch_id = $this->session->batch_id;
			$m_pos->save();

			$server_id = $this->input->post('server_id',true);
			$pos_invoice_id = $m_pos->last_insert_id();

			$m_pos_servers = $this->Pos_invoice_server_model;

			$product_id = $this->input->post('product_id',TRUE);
			$pos_qty = $this->input->post('pos_qty',TRUE);
			$pos_price = $this->input->post('pos_price',TRUE);
			$pos_discount = $this->input->post('pos_discount',TRUE);
			$tax_rate = $this->input->post('tax_rate',TRUE);
			$tax_amount = $this->input->post('tax_amount',TRUE);
			$total = $this->input->post('total',TRUE);
			$table_id = $this->input->post('table_id',TRUE);
			$server_id = $this->input->post('server_id', TRUE);

			$void_product_id = $this->input->post('product_id_void',TRUE);
			$void_pos_qty = $this->input->post('pos_qty_void',TRUE);
			$void_pos_price = $this->input->post('pos_price_void',TRUE);
			$void_pos_total = $this->input->post('pos_total_void',TRUE);

			for($v=0;$v<count($void_product_id);$v++)
			{
				$m_voids->set('void_datetime','NOW()');
				$m_voids->pos_invoice_id = $pos_invoice_id;
				$m_voids->product_id = $void_product_id[$v];
				$m_voids->pos_qty = $this->get_numeric_value($void_pos_qty[$v]);
				$m_voids->pos_price = $this->get_numeric_value($void_pos_price[$v]);
				$m_voids->pos_total = $this->get_numeric_value($void_pos_total[$v]);
				$m_voids->user_id = $this->session->user_id;
				$m_voids->save();
			}

			for($i=0;$i<count($product_id);$i++)
			{
				$m_pos_items->pos_invoice_id = $pos_invoice_id;
				$m_pos_items->product_id = $product_id[$i];
				$m_pos_items->pos_qty = $this->get_numeric_value($pos_qty[$i]);
				$m_pos_items->pos_price = $this->get_numeric_value($pos_price[$i]);
				$m_pos_items->pos_discount = $this->get_numeric_value($pos_discount[$i]);
				$m_pos_items->tax_rate = $this->get_numeric_value($tax_rate[$i]);
				$m_pos_items->tax_amount = $this->get_numeric_value($tax_amount[$i]);
				$m_pos_items->total = $this->get_numeric_value($total[$i]);
				$m_pos_items->save();

				$pos_invoice_items_id = $m_pos_items->last_insert_id();

				for($s=0;$s<count($server_id);$s++)
				{
					$m_pos_servers->pos_invoice_id = $pos_invoice_id;
					$m_pos_servers->pos_invoice_items_id = $pos_invoice_items_id;
					$m_pos_servers->server_id = $server_id[$s];
					$m_pos_servers->save();
				}
			}

			for($t=0;$t<count($table_id);$t++)
			{
				$m_order_tables->pos_invoice_id=$pos_invoice_id;
				$m_order_tables->table_id=$table_id[$t];
				$m_order_tables->save();
			}

			//update invoice number base on formatted last insert id
            $m_pos->pos_invoice_no='INV-'.date('Ymd').'-'.$pos_invoice_id;
            $m_pos->modify($pos_invoice_id);

			$m_pos->commit();

			$this->db->truncate('pos_invoice_ajax');
			$this->db->truncate('pos_invoice_items_ajax');

			$response['pos_invoice_id'] = $pos_invoice_id;
			$response['response_rows'] = $this->response_rows($pos_invoice_id);
			$response['title'] = 'Success!';
            $response['stat'] = 'success';
            $response['msg'] = 'Order successfully submitted.';

            echo json_encode($response);
		}

		public function addProductToInvoice()
		{
			$m_pos = $this->Pos_model;
			$m_pos_items = $this->Pos_items_model;
			$m_order_tables = $this->Order_tables_model;
			$m_pos_servers = $this->Pos_invoice_server_model;
			$m_voids = $this->Void_logs_model;

			$m_pos->begin();

			$query = $this->db->update('pos_invoice_items', array('status ' => FALSE));

			$pos_invoice_id = $this->input->post('pos_invoice_id',TRUE);
			$m_pos->set('transaction_date','NOW()');
			$m_pos->customer_id = $this->input->post('customer_id',TRUE);
			$m_pos->user_id = $this->session->userdata('user_id');
			$m_pos->total_discount = $this->get_numeric_value($this->input->post('total_discount',TRUE));
			$m_pos->before_tax = $this->get_numeric_value($this->input->post('before_tax',TRUE));
			$m_pos->total_tax_amount = $this->get_numeric_value($this->input->post('total_tax_amount',TRUE));
			$m_pos->total_after_tax = $this->get_numeric_value($this->input->post('total_after_tax',TRUE));
			$m_pos->batch_id = $this->session->batch_id;
			$m_pos->modify($pos_invoice_id);

			$product_id = $this->input->post('product_id',TRUE);
			$pos_qty = $this->input->post('pos_qty',TRUE);
			$pos_price = $this->input->post('pos_price',TRUE);
			$pos_discount = $this->input->post('pos_discount',TRUE);
			$tax_rate = $this->input->post('tax_rate',TRUE);
			$tax_amount = $this->input->post('tax_amount',TRUE);
			$total = $this->input->post('total',TRUE);
			$table_id = $this->input->post('table_id',TRUE);
			$server_id = $this->input->post('server_id',TRUE);

			$void_product_id = $this->input->post('product_id_void',TRUE);
			$void_pos_qty = $this->input->post('pos_qty_void',TRUE);
			$void_pos_price = $this->input->post('pos_price_void',TRUE);
			$void_pos_total = $this->input->post('pos_total_void',TRUE);

			for($v=0;$v<count($void_product_id);$v++)
			{
				$m_voids->set('void_datetime','NOW()');
				$m_voids->pos_invoice_id = $pos_invoice_id;
				$m_voids->product_id = $void_product_id[$v];
				$m_voids->pos_qty = $this->get_numeric_value($void_pos_qty[$v]);
				$m_voids->pos_price = $this->get_numeric_value($void_pos_price[$v]);
				$m_voids->pos_total = $this->get_numeric_value($void_pos_total[$v]);
				$m_voids->user_id = $this->session->user_id;
				$m_voids->save();
			}

			for($i=0;$i<count($product_id);$i++)
			{
				$m_pos_items->pos_invoice_id = $pos_invoice_id;
				$m_pos_items->product_id = $product_id[$i];
				$m_pos_items->pos_qty = $this->get_numeric_value($pos_qty[$i]);
				$m_pos_items->pos_price = $this->get_numeric_value($pos_price[$i]);
				$m_pos_items->pos_discount = $this->get_numeric_value($pos_discount[$i]);
				$m_pos_items->tax_rate = $this->get_numeric_value($tax_rate[$i]);
				$m_pos_items->tax_amount = $this->get_numeric_value($tax_amount[$i]);
				$m_pos_items->total = $this->get_numeric_value($total[$i]);
				$m_pos_items->status = 1;
				$m_pos_items->save();

				$pos_invoice_items_id = $m_pos_items->last_insert_id();

				for($s=0;$s<count($server_id);$s++)
				{
					$m_pos_servers->pos_invoice_id = $pos_invoice_id;
					$m_pos_servers->pos_invoice_items_id = $pos_invoice_items_id;
					$m_pos_servers->server_id = $server_id[$s];
					$m_pos_servers->save();
				}
			}

			$m_pos->commit();

			$response['pos_invoice_id'] = $pos_invoice_id;
			$response['response_rows'] = $this->response_rows($pos_invoice_id);
			$response['title'] = 'Success!';
            $response['stat'] = 'success';
            $response['msg'] = 'Orders successfully added.';

            echo json_encode($response);
		}

		public function updateInvoice()
		{
			$m_pos = $this->Pos_model;
			$m_pos_items = $this->Pos_items_model;
			$m_order_tables = $this->Order_tables_model;
			$m_pos_servers = $this->Pos_invoice_server_model;
			$m_voids = $this->Void_logs_model;

			$m_pos->begin();
			$pos_invoice_id = $this->input->post('pos_invoice_id',TRUE);
			$m_pos->set('transaction_date','NOW()');
			$m_pos->customer_id = $this->input->post('customer_id',TRUE);
			$m_pos->user_id = $this->session->userdata('user_id');
			$m_pos->total_discount = $this->get_numeric_value($this->input->post('total_discount',TRUE));
			$m_pos->before_tax = $this->get_numeric_value($this->input->post('before_tax',TRUE));
			$m_pos->total_tax_amount = $this->get_numeric_value($this->input->post('total_tax_amount',TRUE));
			$m_pos->total_after_tax = $this->get_numeric_value($this->input->post('total_after_tax',TRUE));
			$m_pos->batch_id = $this->session->batch_id;
			$m_pos->modify($pos_invoice_id);

			$m_pos_items->delete_via_fk($pos_invoice_id);
			$m_pos_servers->delete('pos_invoice_id = '.$pos_invoice_id);

			$product_id = $this->input->post('product_id',TRUE);
			$pos_qty = $this->input->post('pos_qty',TRUE);
			$pos_price = $this->input->post('pos_price',TRUE);
			$pos_discount = $this->input->post('pos_discount',TRUE);
			$tax_rate = $this->input->post('tax_rate',TRUE);
			$tax_amount = $this->input->post('tax_amount',TRUE);
			$total = $this->input->post('total',TRUE);
			$table_id = $this->input->post('table_id',TRUE);
			$server_id = $this->input->post('server_id',TRUE);

			$void_product_id = $this->input->post('product_id_void',TRUE);
			$void_pos_qty = $this->input->post('pos_qty_void',TRUE);
			$void_pos_price = $this->input->post('pos_price_void',TRUE);
			$void_pos_total = $this->input->post('pos_total_void',TRUE);

			for($v=0;$v<count($void_product_id);$v++)
			{
				$m_voids->set('void_datetime','NOW()');
				$m_voids->pos_invoice_id = $pos_invoice_id;
				$m_voids->product_id = $void_product_id[$v];
				$m_voids->pos_qty = $this->get_numeric_value($void_pos_qty[$v]);
				$m_voids->pos_price = $this->get_numeric_value($void_pos_price[$v]);
				$m_voids->pos_total = $this->get_numeric_value($void_pos_total[$v]);
				$m_voids->user_id = $this->session->user_id;
				$m_voids->save();
			}

			for($i=0;$i<count($product_id);$i++)
			{
				$m_pos_items->pos_invoice_id = $pos_invoice_id;
				$m_pos_items->product_id = $product_id[$i];
				$m_pos_items->pos_qty = $this->get_numeric_value($pos_qty[$i]);
				$m_pos_items->pos_price = $this->get_numeric_value($pos_price[$i]);
				$m_pos_items->pos_discount = $this->get_numeric_value($pos_discount[$i]);
				$m_pos_items->tax_rate = $this->get_numeric_value($tax_rate[$i]);
				$m_pos_items->tax_amount = $this->get_numeric_value($tax_amount[$i]);
				$m_pos_items->total = $this->get_numeric_value($total[$i]);
				$m_pos_items->save();

				$pos_invoice_items_id = $m_pos_items->last_insert_id();

				for($s=0;$s<count($server_id);$s++)
				{
					$m_pos_servers->pos_invoice_id = $pos_invoice_id;
					$m_pos_servers->pos_invoice_items_id = $pos_invoice_items_id;
					$m_pos_servers->server_id = $server_id[$s];
					$m_pos_servers->save();
				}
			}

			$m_order_tables->delete_via_fk($pos_invoice_id);

			for($t=0;$t<count($table_id);$t++)
			{
				$m_order_tables->pos_invoice_id=$pos_invoice_id;
				$m_order_tables->table_id=$table_id[$t];
				$m_order_tables->save();
			}

			$m_pos->commit();

			$this->db->truncate('pos_invoice_ajax');
			$this->db->truncate('pos_invoice_items_ajax');

			$response['pos_invoice_id'] = $pos_invoice_id;
			$response['response_rows'] = $this->response_rows($pos_invoice_id);
			$response['title'] = 'Success!';
            $response['stat'] = 'success';
            $response['msg'] = 'Order successfully updated.';

            echo json_encode($response);
		}

		public function response_rows($filter_value) 
		{
			$m_pos = $this->Pos_model;
			return $m_pos->get_list(
				$filter_value,
				'pos_invoice.*, pos_invoice_items.*, vendors.*',
				array(
					array('pos_invoice_items','pos_invoice_items.pos_invoice_id = pos_invoice.pos_invoice_id','inner'),
					array('products','products.product_id = pos_invoice_items.product_id','left'),
					array('vendors','vendors.vendor_id = products.vendor_id','left')
				)
			);
		}
	}
?>