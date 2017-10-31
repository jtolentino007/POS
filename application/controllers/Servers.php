<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Servers extends CORE_Controller
	{
		
		function __construct()
		{
			parent::__construct('');
			$this->validate_session();
			$this->load->model(
				array(
					'Servers_model',
					'Products_model'
				)
			);
		}

		public function index()
		{
			$data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);
	        $data['products'] = $this->Products_model->get_list('category_id = 26 AND is_deleted = FALSE');
	        $data['title'] = 'Servers Management';

	        $this->load->view('servers_view', $data);
		}

		public function getList($txn=null)
		{
			switch ($txn) {
				case 'servers':
						$m_servers = $this->Servers_model;

						$response['data'] = $m_servers->get_list(
							'servers.is_deleted = FALSE'
						);

						echo json_encode($response);
					break;
			}
		}

		public function InsertServer()
		{
			$m_servers = $this->Servers_model;

			$m_servers->server_code = $this->input->post('server_code',TRUE);
			$m_servers->server_name = $this->input->post('server_name',TRUE);
			$m_servers->save();

			$server_id = $m_servers->last_insert_id();

			$response['title'] = "Success!";
			$response['stat'] = "success";
			$response['row_added'] = $this->response_rows($server_id);
			$response['msg'] = "Server Information successfully saved.";

			echo json_encode($response);
		}

		public function UpdateServer()
		{
			$m_servers = $this->Servers_model;

			$server_id = $this->input->post('server_id',TRUE);
			$m_servers->server_code = $this->input->post('server_code',TRUE);
			$m_servers->server_name = $this->input->post('server_name',TRUE);
			$m_servers->modify($server_id);

			$response['title'] = "Success!";
			$response['stat'] = "success";
			$response['row_updated'] = $this->response_rows($server_id);
			$response['msg'] = "Server Information successfully updated.";

			echo json_encode($response);
		}

		public function RemoveServer()
		{
			$m_servers = $this->Servers_model;
			$server_id=$this->input->post('server_id',TRUE);

                $m_servers->is_deleted=1;
                if($m_servers->modify($server_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Server Information successfully deleted.';

                    echo json_encode($response);
                }
		}

		function response_rows($filter_value)
		{
			$m_servers = $this->Servers_model;

			return $m_servers->get_list($filter_value);
		}
	}
?>