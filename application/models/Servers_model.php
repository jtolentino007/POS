<?php
	class Servers_model extends CORE_Model
	{
		protected $table = "servers";
		protected $pk_id = "server_id";

		function __construct()
		{
			parent::__construct();
		}
	}
?>