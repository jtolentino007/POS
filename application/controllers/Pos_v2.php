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
					'Pos_payment_model'
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
			$m_payment->set('transaction_date','NOW()');
			$m_payment->save();

			$pos_payment_id = $m_payment->last_insert_id();

			$m_payment->receipt_no = "INV-".str_pad($pos_payment_id, 8, "0", STR_PAD_LEFT);

			$m_payment->modify($pos_payment_id);

			$m_payment->commit();

			$m_pos->set('is_paid',TRUE);
			$m_pos->modify($this->input->post('pos_invoice_id',TRUE));

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

			$m_pos->begin();

			$m_pos->set('transaction_date','NOW()');
			$m_pos->customer_id = $this->input->post('customer_id',TRUE);
			$m_pos->user_id = $this->session->userdata('user_id');
			$m_pos->total_discount = $this->get_numeric_value($this->input->post('total_discount',TRUE));
			$m_pos->before_tax = $this->get_numeric_value($this->input->post('before_tax',TRUE));
			$m_pos->total_tax_amount = $this->get_numeric_value($this->input->post('total_tax_amount',TRUE));
			$m_pos->total_after_tax = $this->get_numeric_value($this->input->post('total_after_tax',TRUE));
			$m_pos->save();

			$pos_invoice_id = $m_pos->last_insert_id();

			$product_id = $this->input->post('product_id',TRUE);
			$pos_qty = $this->input->post('pos_qty',TRUE);
			$pos_price = $this->input->post('pos_price',TRUE);
			$pos_discount = $this->input->post('pos_discount',TRUE);
			$tax_rate = $this->input->post('tax_rate',TRUE);
			$tax_amount = $this->input->post('tax_amount',TRUE);
			$total = $this->input->post('total',TRUE);
			$table_id = $this->input->post('table_id',TRUE);

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

			$response['title'] = 'Success!';
            $response['stat'] = 'success';
            $response['msg'] = 'Order successfully submitted.';

            echo json_encode($response);
		}
	}
?>