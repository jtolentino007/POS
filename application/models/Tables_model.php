<?php
	class Tables_model extends CORE_Model
	{
	    protected  $table="tables"; //table name
	    protected  $pk_id="table_id"; //primary key id

	    function __construct()
	    {
	        // Call the Model constructor
	        parent::__construct();
	    }
	}
?>