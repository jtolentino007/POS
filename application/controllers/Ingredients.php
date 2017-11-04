<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Ingredients extends CORE_Controller
	{
		
		function __construct()
		{
			parent::__construct('');
			$this->validate_session();
			$this->load->model(
				array(
					'Ingredients_model',
					'Units_model'
				)
			);
		}

		public function index()
		{
	        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
	        $data['units_list'] = $this->Units_model->get_list('is_deleted=FALSE');
	        $data['title'] = 'Ingredients Management';
			
	        $this->load->view('ingredients_view', $data);
		}

		function getList($txn = null)
		{
			switch ($txn) {
				case 'ingredients':
					$m_ingredients = $this->Ingredients_model;

					$response['data'] = $m_ingredients->get_list(
						'ingredients.is_deleted=FALSE',
						'ingredients.*, units.unit_name',
						array(
							array('units','units.unit_id = ingredients.ingredient_unit', 'left')
						)
					);

					echo json_encode($response);
					break;
			}
		}

		function saveIngredients()
		{
			$m_ingredients = $this->Ingredients_model;

			$m_ingredients->ingredient_name = $this->input->post('ingredient_name',TRUE);
			$m_ingredients->ingredient_unit = $this->input->post('ingredient_unit',TRUE);
			$m_ingredients->save();

			$ingredient_id = $m_ingredients->last_insert_id();

			$response['title'] = "Success!";
			$response['stat'] = "success";
			$response['msg'] = "Ingredient information successfully saved.";
			$response['row_added'] = $this->response_rows($ingredient_id);

			echo json_encode($response);
		}

		function updateIngredients()
		{
			$m_ingredients = $this->Ingredients_model;

			$ingredient_id = $this->input->post('ingredient_id',TRUE);

			$m_ingredients->ingredient_name = $this->input->post('ingredient_name',TRUE);
			$m_ingredients->ingredient_unit = $this->input->post('ingredient_unit',TRUE);
			$m_ingredients->modify($ingredient_id);

			$response['title'] = "Success!";
			$response['stat'] = "success";
			$response['msg'] = "Ingredient information successfully updated.";
			$response['row_updated'] = $this->response_rows($ingredient_id);
			
			echo json_encode($response);
		}

		function deleteIngredient()
		{
			$m_ingredients = $this->Ingredients_model;
			$ingredient_id = $this->input->post('ingredient_id',TRUE);

			$m_ingredients->is_deleted=1;

            if($m_ingredients->modify($ingredient_id)){
                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Ingredient Information successfully deleted.'.$ingredient_id;

                echo json_encode($response);
            }
		}

		function response_rows($filter_value) 
		{
			$m_ingredients = $this->Ingredients_model;

			return $m_ingredients->get_list(
				'ingredients.ingredient_id='.$filter_value.' AND ingredients.is_deleted=FALSE',
				'ingredients.*, units.unit_name',
				array(
					array('units','units.unit_id = ingredients.ingredient_unit', 'left')
				)
			);
		}
	}
?>