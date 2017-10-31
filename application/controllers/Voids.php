<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Voids extends CORE_Controller
	{
		
		function __construct()
		{
			parent::__construct('');
			$this->validate_session();
			$this->load->model('Void_logs_model');
		}

		public function index()
		{
			$data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
	        $data['title']="Void Logs";

	        $this->load->view('void_logs_view',$data);
		}

		function getList()
		{
			$m_voids = $this->Void_logs_model;

			$response['data'] = $m_voids->get_list(
				null,
				'pi.pos_invoice_no, p.product_desc, CONCAT(user_fname, " ", user_lname) as user_name, void_logs.*',
				array(
					array('pos_invoice pi', 'pi.pos_invoice_id = void_logs.pos_invoice_id', 'inner'),
					array('products p', 'p.product_id = void_logs.product_id', 'inner'),
					array('user_accounts ua','ua.user_id = void_logs.user_id', 'left')
				),
				'void_logs.void_datetime desc'
			);

			echo json_encode($response);
		}
	}
?>