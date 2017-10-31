<?php
	class Void_logs_model extends CORE_Model
	{
		protected $table = "void_logs";
		protected $pk_id = "void_logs_id";
		function __construct()
		{
			parent::__construct('');
		}
	}
?>