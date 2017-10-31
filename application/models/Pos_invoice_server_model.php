<?php
	class Pos_invoice_server_model extends CORE_Model
	{
		protected $table = "pos_invoice_servers";
		protected $pk_id = "pos_invoice_server_id";
		protected $fk_id = "pos_invoice_items_id";
		function __construct()
		{
			parent::__construct('');
		}
	}
?>