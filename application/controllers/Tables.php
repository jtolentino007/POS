<?php
	defined('BASEPATH') OR exit('No direct script access allowed.');

	class Tables extends CORE_Controller
	{
		
		function __construct()
		{
			parent::__construct('');
			$this->validate_session();
			$this->load->model(
				array(
					'Tables_model',
					'Table_types_model'
				)
			);
		}

		public function index()
		{
			$data['_def_css_files']=$this->load->view('template/assets/css_files','',TRUE);
	        $data['_def_js_files']=$this->load->view('template/assets/js_files','',TRUE);
	        $data['_switcher_settings']=$this->load->view('template/elements/switcher','',TRUE);
	        $data['_side_bar_navigation']=$this->load->view('template/elements/side_bar_navigation','',TRUE);
	        $data['_top_navigation']=$this->load->view('template/elements/top_navigation','',TRUE);
	        $data['_title']="Tables Management";

	        $data['table_types'] = $this->Table_types_model->get_list();

	        $this->load->view('tables_view',$data);
		}

		function transaction($txn=null)
		{
			switch ($txn) {
				case 'unused-tables':
					$m_tables = $this->Tables_model;

					$response['data'] = $m_tables->get_unused_tables();

					echo json_encode($response);
					break;

				case 'list-all-tables':
					$m_tables = $this->Tables_model;

					$response['data'] = $m_tables->list_all_tables();

					echo json_encode($response);
					break;

				case 'list':
					$m_tables = $this->Tables_model;

					$response['data'] = $m_tables->get_list(
						'is_deleted=FALSE',
						'table_id, table_name, table_orientation, tables.table_type_id, tt.table_type',
						array(
							array('table_types tt','tt.table_type_id = tables.table_type_id','left')
						)
					);

					echo json_encode($response);
					break;
				
				case 'create':
					$m_tables = $this->Tables_model;

					$m_tables->table_name = $this->input->post('table_name',TRUE);
					$m_tables->table_type_id = $this->input->post('table_type_id',TRUE);
					$m_tables->table_orientation = $this->input->post('table_orientation',TRUE);
					$m_tables->save();

					$table_id = $m_tables->last_insert_id();

	                $response['title'] = 'Success!';
	                $response['stat'] = 'success';
	                $response['msg'] = 'Table information successfully created.';
	                $response['row_added'] = $this->response_row($table_id);
	                echo json_encode($response);

					break;

				case 'delete':
	                $m_tables=$this->Tables_model;

	                $table_id=$this->input->post('table_id',TRUE);

	                $m_tables->is_deleted=1;

	                if($m_tables->modify($table_id)){
	                    $response['title']='Success!';
	                    $response['stat']='success';
	                    $response['msg']='Table information successfully deleted.';

	                    echo json_encode($response);
	                }

	                break;

				case 'update':
	                $m_tables=$this->Tables_model;

	                $table_id=$this->input->post('table_id',TRUE);
	                $m_tables->table_name = $this->input->post('table_name',TRUE);
					$m_tables->table_type_id = $this->input->post('table_type_id',TRUE);
					$m_tables->table_orientation = $this->input->post('table_orientation',TRUE);

	                $m_tables->modify($table_id);

	                $response['title']='Success!';
	                $response['stat']='success';
	                $response['msg']='Table information successfully updated.';
	                $response['row_updated']=$this->response_row($table_id);
	                echo json_encode($response);

	                break;
				}
		}

		function response_row($table_id)
		{
			$m_tables = $this->Tables_model;
			return $m_tables->get_list(
				$table_id,
				'table_id, table_name, table_orientation, tables.table_type_id, tt.table_type',
				array(
					array('table_types tt','tt.table_type_id = tables.table_type_id','left')
				)
			);
		}
	}
?>