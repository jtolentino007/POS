<?php

	class Pos_model extends CORE_Model {
	    protected  $table="pos_invoice";
	    protected  $pk_id="pos_invoice_id";

	    function __construct() {
	        parent::__construct();
	    }

	    function get_unpaid_orders()
	    {
	    	$sql = "SELECT
				pi.*,
				c.customer_name,
				group_concat(t.table_name) table_name
				FROM
				pos_invoice pi
				INNER JOIN order_tables ot ON ot.pos_invoice_id = pi.pos_invoice_id
				LEFT JOIN tables t ON t.table_id = ot.table_id
				LEFT JOIN customers c ON c.customer_id = pi.customer_id
				WHERE is_paid = FALSE
				GROUP BY pos_invoice_id";

			return $this->db->query($sql)->result();
	    }
	}

?>