<?php


	class Batches_model extends CORE_Model
	{
		protected $table="batches";
		protected $pk_id="batch_id";
		
		function __construct()
		{
			parent::__construct();
		}
	}
?>