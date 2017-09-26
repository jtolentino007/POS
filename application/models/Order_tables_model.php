<?php

    class Order_tables_model extends CORE_Model {
        protected  $table="order_tables";
        protected  $pk_id="order_table_id";
        protected  $fk_id="pos_invoice_id";

        function __construct() {
            parent::__construct();
        }
    }
    
?>