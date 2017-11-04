<?php
	class Recipes_model extends CORE_Model
	{
		protected $table="recipes";
		protected $pk_id="recipe_id";
		
		function __construct()
		{
			parent::__construct('');
		}
	}
?>