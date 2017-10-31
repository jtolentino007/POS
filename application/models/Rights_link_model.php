<?php
class Rights_link_model extends CORE_Model{
    protected  $table="rights_links"; //table name
    protected  $pk_id="link_id"; //primary key id
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function create_default_link_list(){
        $sql="INSERT INTO `rights_links` (`link_id`, `parent_code`, `link_code`, `link_name`) VALUES
                                          (1,'1','1-1','Stock Receiving'),
                                          (2,'1','1-2','Stock Issuance'),
                                          (3,'1','1-3','POS'),
                                          (4,'1','1-4','Receipts'),
                                          (5,'1','1-5','Daily Sales Report'),
                                          (6,'1','1-6','Inventory Report'),
                                          (7,'1','1-7','Categories'),
                                          (8,'1','1-8','Units'),
                                          (9,'1','1-9','Brands'),
                                          (10,'1','1-10','Discounts'),
                                          (11,'1','1-11','Cards'),
                                          (12,'1','1-12','Generics'),
                                          (13,'1','1-13','Locations'),
                                          (14,'1','1-14','Products'),
                                          (15,'1','1-15','Suppliers'),
                                          (16,'1','1-16','Customers'),
                                          (17,'1','1-17','Stocks'),
                                          (18,'1','1-18','X-Reading'),
                                          (19,'1','1-19','Z-Reading'),
                                          (20,'1','1-20','User Accounts'),
                                          (21,'1','1-21','User Rights'),
                                          (22,'1','1-22','Vendors'),
                                          (23,'1','1-23','Servers')

                                          ON DUPLICATE KEY UPDATE
                                          rights_links.parent_code=VALUES(rights_links.parent_code),
                                          rights_links.link_code=VALUES(rights_links.link_code),
                                          rights_links.link_name=VALUES(rights_links.link_name)
            ";
        $this->db->query($sql);
    }
}
?>