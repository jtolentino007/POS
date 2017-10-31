<?php

    class Pos_items_model extends CORE_Model {
        protected  $table="pos_invoice_items";
        protected  $pk_id="pos_invoice_items_id";
        protected  $fk_id="pos_invoice_id";

        function __construct() {
            parent::__construct();
        }

		public function get_servers($invoice_id, $status_filter = null)
		{
			$sql = "SELECT
					GROUP_CONCAT(a.server_name) server_name
					FROM
					(SELECT
					pii.*,
					s.*
					FROM
					pos_invoice_items pii
					LEFT JOIN pos_invoice_servers pis ON pis.pos_invoice_items_id = pii.pos_invoice_items_id
					LEFT JOIN servers s ON s.server_id = pis.server_id
					WHERE pii.pos_invoice_id = $invoice_id".($status_filter == null ? "" : " AND pii.status = ".$status_filter).
					" GROUP BY s.server_id) a";

			return $this->db->query($sql)->result();
		}

		public function get_servers_edit($invoice_id)
		{
			$sql = "SELECT
					a.server_id,
					a.server_name
					FROM
					(SELECT
					pii.*,
					s.*
					FROM
					pos_invoice_items pii
					LEFT JOIN pos_invoice_servers pis ON pis.pos_invoice_items_id = pii.pos_invoice_items_id
					LEFT JOIN servers s ON s.server_id = pis.server_id
					WHERE pii.pos_invoice_id = $invoice_id GROUP BY s.server_id) a";

			return $this->db->query($sql)->result();
		}
    }
    
?>