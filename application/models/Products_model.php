<?php

class Products_model extends CORE_Model {
    protected  $table="products";
    protected  $pk_id="product_id";

    function __construct() {
        parent::__construct();
    }


    function getDepartment()
    {
        $query = $this->db->query('SELECT department_name FROM departments');
        return $query->result();
    }

    function getCode() {
        $query = $this->db->query('SELECT product_code FROM products');
        return $query->result();
    }

    function getProductInventoryInfo($product_id)
    {
        $sql = "SELECT
                *
                FROM
                (
                SELECT products.*,
                ( (COALESCE(dii.totalreceive,0)+COALESCE(sda.total_added_stock,0))-(COALESCE(pii.totalsales,0)+COALESCE(sdd.total_deducted_stock,0)+COALESCE(ii.total_issued_qty,0)) ) as stock_onhand,
                (COALESCE(dii.totalreceive,0)+COALESCE(sda.total_added_stock,0)) as total_in,COALESCE(pii.totalsales,0)+COALESCE(sdd.total_deducted_stock,0)+COALESCE(ii.total_issued_qty,0) as total_out 
                FROM 
                products
                LEFT JOIN
                (
                SELECT SUM(dr_qty) as totalreceive,
                product_id 
                FROM 
                delivery_invoice_items
                LEFT JOIN delivery_invoice ON
                delivery_invoice_items.dr_invoice_id=delivery_invoice.dr_invoice_id
                GROUP BY product_id
                ) as dii
                ON products.product_id=dii.product_id
                LEFT JOIN
                (
                SELECT 
                SUM(pos_qty) as totalsales,
                product_id 
                FROM 
                pos_invoice_items
                LEFT JOIN pos_invoice ON
                pos_invoice_items.pos_invoice_id=pos_invoice.pos_invoice_id
                GROUP BY product_id
                ) as pii
                ON products.product_id=pii.product_id
                LEFT JOIN
                (
                SELECT 
                SUM(added_stock) as total_added_stock,
                SUM(minus_stock) as total_deducted_stock,
                product_id 
                FROM 
                stock_details
                GROUP BY product_id
                ) as sda
                ON products.product_id=sda.product_id
                LEFT JOIN
                (
                SELECT 
                SUM(minus_stock) as total_deducted_stock,
                product_id 
                FROM 
                stock_details
                GROUP BY product_id
                ) as sdd
                ON products.product_id=sdd.product_id
                LEFT JOIN
                (
                SELECT 
                SUM(is_qty) as total_issued_qty,
                product_id 
                FROM 
                issuance_items
                GROUP BY product_id
                ) as ii
                ON products.product_id=ii.product_id WHERE products.is_deleted=0
                AND products.product_id = $product_id
                ) 
                pi

                LEFT JOIN 
                categories c ON c.category_id = pi.category_id
                LEFT JOIN
                units u ON u.unit_id = pi.unit_id
                LEFT JOIN
                brands b ON b.brand_id = pi.brand_id
                LEFT JOIN
                vendors v ON v.vendor_id = pi.vendor_id";

        return $this->db->query($sql)->result();
    }
}
?>