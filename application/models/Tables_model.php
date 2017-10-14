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

	    function list_all_tables()
	    {
	    	$sql = "SELECT
					*,
					0 pos_invoice_id,
					0 status
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
					AND pi.is_paid = FALSE)

					UNION ALL 

					SELECT
					tables.*,
					pi.pos_invoice_id,
					1 status
					FROM
					(SELECT
					*
					FROM
					(SELECT
					tables.*
					FROM
					tables
					WHERE table_id NOT IN
					(SELECT
					ot.table_id
					FROM
					order_tables ot
					INNER JOIN pos_invoice pi 
					ON pi.pos_invoice_id = ot.pos_invoice_id 
					AND pi.is_paid = FALSE)) available_tables

					UNION

					SELECT
					*
					FROM
					(SELECT
					tables.*
					FROM
					tables
					WHERE table_id IN
					(SELECT
					ot.table_id
					FROM
					order_tables ot
					INNER JOIN pos_invoice pi 
					ON pi.pos_invoice_id = ot.pos_invoice_id 
					AND pi.is_paid = FALSE)) unavailable_tables) tables
					LEFT JOIN order_tables ot ON ot.table_id = tables.table_id
					LEFT JOIN pos_invoice pi ON pi.pos_invoice_id = ot.pos_invoice_id
					WHERE pi.is_paid = FALSE

					ORDER BY table_id, table_name";

			return $this->db->query($sql)->result();
	    }
	}
?>