<?php

class Table_types_model extends CORE_Model {
    protected  $table="table_types";
    protected  $pk_id="table_type_id";

    function __construct() {
        parent::__construct();
    }

    function create_default_table_type(){
        $sql="INSERT INTO
                  table_types(table_type_id,table_type)
              VALUES
                  (1,'Rounded'),
                  (2,'Rectangular')
              ON DUPLICATE KEY UPDATE
                  table_types.table_type=VALUES(table_types.table_type)";

        $this->db->query($sql);
    }
}


?>