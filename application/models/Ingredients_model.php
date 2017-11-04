<?php
	class Ingredients_model extends CORE_Model
	{
		protected $table = "ingredients";
		protected $pk_id = "ingredient_id";

		function __construct()
		{
			parent::__construct('');
		}
	}
?>