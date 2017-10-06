<?php

	class Pos_items_ajax_model extends CORE_Model
	{
		protected $table = "pos_invoice_items_ajax";
		protected $pk_id = "pos_invoice_items_id";

		function __construct()
		{
			parent::__construct('');
		}
	}
?>