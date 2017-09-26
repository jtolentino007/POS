<?php

    class Pos_items_model extends CORE_Model {
        protected  $table="pos_invoice_items";
        protected  $pk_id="pos_invoice_items_id";
        protected  $fk_id="pos_invoice_id";

        function __construct() {
            parent::__construct();
        }
    }
    
?>