<?php
	class Display2 extends CORE_Controller
	{
		
		function __construct()
		{
			parent::__construct('');
			$this->load->model(
				array(
					'Company_model',
					'Pos_items_ajax_model',
					'Pos_ajax_model'
				)
			);
		}

		public function index()
		{
			$data['_def_css_files'] = $this->load->view('template/assets/css_pos', '', TRUE);
        	$data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        	$company_info = $this->Company_model->get_list();
        	$data['company'] = $company_info[0];

			$this->load->view('display2_view',$data);
		}

		function getProducts()
		{
			$m_pos_items_ajax = $this->Pos_items_ajax_model;
			$m_pos_ajax = $this->Pos_ajax_model;

			$items = $m_pos_items_ajax->get_list(
				null,
				'pos_invoice_items_ajax.*, products.product_desc, products.img_path, customers.customer_name',
				array(
					array('pos_invoice_ajax','pos_invoice_ajax.customer_id = pos_invoice_items_ajax.customer_id','left'),
					array('customers','customers.customer_id = pos_invoice_items_ajax.customer_id OR customers.customer_id = pos_invoice_ajax.customer_id','left'),
					array('products','products.product_id = pos_invoice_items_ajax.product_id','left')
				)
			);

			$invoice = $m_pos_ajax->get_list(
				null,
				'pos_invoice_items_ajax.*, products.product_desc, products.img_path, customers.customer_name',
				array(
					array('pos_invoice_items_ajax','pos_invoice_items_ajax.customer_id = pos_invoice_ajax.customer_id','left'),
					array('customers','customers.customer_id = pos_invoice_items_ajax.customer_id OR customers.customer_id = pos_invoice_ajax.customer_id','left'),
					array('products','products.product_id = pos_invoice_items_ajax.product_id','left')
				)
			);

			if (count($items) > 0) 
			{
				$response['data'] = $items;
			} else {
				$response['data'] = $invoice;
			}

			echo json_encode($response);
		}
	}
?>