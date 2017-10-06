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

	    function get_unused_tables()
	    {
	    	$sql = "SELECT
					*
					FROM
					tables
					WHERE is_deleted = FALSE
					AND 
					table_id NOT IN
					(SELECT
					ot.table_id
					FROM
					order_tables ot
					INNER JOIN pos_invoice pi 
					ON pi.pos_invoice_id = ot.pos_invoice_id 
					AND pi.is_paid = FALSE)";

			return $this->db->query($sql)->result();
	    }
	}
?>