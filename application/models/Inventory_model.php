<?php

class Inventory_model extends CORE_Model {
    protected  $table="inventory";
    protected  $pk_id="inventory_id";

    function __construct() {
        parent::__construct();
    }

    function get_inventory_list($inventory_id=null){
        $sql="  SELECT
                  a.*
                FROM
                  inventory as a
                WHERE
                    a.is_deleted=FALSE AND a.is_active=TRUE
                ".($inventory_id==null?"":" AND a.inventory_id=$inventory_id")."
            ";
        return $this->db->query($sql)->result();
    }

    function get_inventory_onhand_list_filter($inventoryfromdate,$inventorytodate){
        $sql="SELECT
              inventory.*,
              inventory.total_in - inventory.total_out stock_onhand
              FROM
              (SELECT
              products.*,
              IFNULL(dii.dr_qty,0) + IFNULL(sd_added.added_stock,0) total_in,
              IFNULL(pii.pos_qty,0) + IFNULL(ii.is_qty,0) + IFNULL(sd_deducted.minus_stock,0) total_out
              FROM products
              LEFT JOIN 
              (SELECT
              dii.product_id,
              SUM(dr_qty) dr_qty
              FROM
              delivery_invoice_items dii
              INNER JOIN delivery_invoice di
              ON di.dr_invoice_id = dii.dr_invoice_id
              WHERE date_received BETWEEN '".$inventoryfromdate."' AND '".$inventorytodate."'
              GROUP BY dii.product_id) dii
              ON dii.product_id = products.product_id
              LEFT JOIN
              (SELECT
              ii.product_id,
              SUM(is_qty) is_qty
              FROM
              issuance_items ii
              INNER JOIN issuance i
              ON i.issuance_id = ii.issuance_id
              WHERE date_issued BETWEEN '".$inventoryfromdate."' AND '".$inventorytodate."'
              GROUP BY ii.product_id) ii
              ON ii.product_id = products.product_id
              LEFT JOIN
              (SELECT
              pii.product_id,
              SUM(pos_qty) pos_qty
              FROM
              pos_invoice_items pii
              INNER JOIN pos_invoice pi
              ON pi.pos_invoice_id = pii.pos_invoice_id
              WHERE transaction_date BETWEEN '".$inventoryfromdate."' AND '".$inventorytodate."'
              GROUP BY pii.product_id) pii
              ON pii.product_id = products.product_id
              LEFT JOIN
              (SELECT
              sd.product_id,
              SUM(added_stock) added_stock
              FROM
              stock_details sd
              WHERE date_adjusted BETWEEN '".$inventoryfromdate."' AND '".$inventorytodate."'
              GROUP BY sd.product_id) sd_added
              ON sd_added.product_id = products.product_id
              LEFT JOIN
              (SELECT
              sd.product_id,
              SUM(minus_stock) minus_stock
              FROM
              stock_details sd
              WHERE date_adjusted BETWEEN '".$inventoryfromdate."' AND '".$inventorytodate."'
              GROUP BY sd.product_id) sd_deducted
              ON sd_deducted.product_id = products.product_id
              WHERE products.is_deleted=0) inventory";
        return $this->db->query($sql)->result();
    }

    function get_inventory_onhand_list_filter2($inventoryfromdate,$inventorytodate){
        $sql="SELECT 
              products.*,
              ((COALESCE(dii.totalreceive,0) + COALESCE(sda.total_added_stock,0)) - (COALESCE(pii.totalsales,0) + COALESCE(sdd.total_deducted_stock,0) + COALESCE(ii.total_issued_qty,0))) as stock_onhand,
              (COALESCE(dii.totalreceive,0) + COALESCE(sda.total_added_stock,0)) as total_in,
              COALESCE(pii.totalsales,0) + COALESCE(sdd.total_deducted_stock,0) + COALESCE(ii.total_issued_qty,0) as total_out 
              FROM 
              products
              LEFT JOIN
              (
              SELECT 
              SUM(dr_qty) as totalreceive,
              product_id 
              FROM 
              delivery_invoice_items
              LEFT JOIN delivery_invoice ON
              delivery_invoice_items.dr_invoice_id=delivery_invoice.dr_invoice_id
              WHERE date_received BETWEEN '".$inventoryfromdate."' AND '".$inventorytodate."'
              GROUP BY product_id
              ) as dii
              ON products.product_id=dii.product_id
              LEFT JOIN
              (
              SELECT 
              SUM(pos_qty) as totalsales,
              product_id 
              FROM pos_invoice_items
              LEFT JOIN pos_invoice ON
              pos_invoice_items.pos_invoice_id=pos_invoice.pos_invoice_id
              WHERE transaction_date BETWEEN '".$inventoryfromdate."' AND '".$inventorytodate."'
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
              WHERE date_adjusted BETWEEN '".$inventoryfromdate."' AND '".$inventorytodate."'
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
              WHERE date_adjusted BETWEEN '".$inventoryfromdate."' AND '".$inventorytodate."'
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
              LEFT JOIN issuance ON
              issuance_items.issuance_id=issuance.issuance_id
              WHERE date_issued BETWEEN '".$inventoryfromdate."' AND '".$inventorytodate."'
              GROUP BY product_id
              ) as ii
              ON products.product_id=ii.product_id WHERE products.is_deleted=0";
        return $this->db->query($sql)->result();
    }

    function get_inventory_onhand_list(){
        $sql="SELECT
              *
              FROM
              (SELECT products.*,
              ( (COALESCE(dii.totalreceive,0)+COALESCE(sda.total_added_stock,0))-(COALESCE(pii.totalsales,0)+COALESCE(sdd.total_deducted_stock,0)+COALESCE(ii.total_issued_qty,0)) )
              as stock_onhand,(COALESCE(dii.totalreceive,0)+COALESCE(sda.total_added_stock,0)) as total_in,COALESCE(pii.totalsales,0)+COALESCE(sdd.total_deducted_stock,0)+COALESCE(ii.total_issued_qty,0) as total_out FROM products
              LEFT JOIN
              (
              SELECT SUM(dr_qty) as totalreceive,product_id FROM delivery_invoice_items
              LEFT JOIN delivery_invoice ON
              delivery_invoice_items.dr_invoice_id=delivery_invoice.dr_invoice_id
              GROUP BY product_id
              ) as dii
              ON products.product_id=dii.product_id
              LEFT JOIN
              (
              SELECT SUM(pos_qty) as totalsales,product_id FROM pos_invoice_items
              LEFT JOIN pos_invoice ON
              pos_invoice_items.pos_invoice_id=pos_invoice.pos_invoice_id
              GROUP BY product_id
              ) as pii
              ON products.product_id=pii.product_id
              LEFT JOIN
              (
              SELECT SUM(added_stock) as total_added_stock,SUM(minus_stock) as total_deducted_stock,product_id FROM stock_details
              GROUP BY product_id
              ) as sda
              ON products.product_id=sda.product_id
              LEFT JOIN
              (
              SELECT SUM(minus_stock) as total_deducted_stock,product_id FROM stock_details
              GROUP BY product_id
              ) as sdd
              ON products.product_id=sdd.product_id
              LEFT JOIN
              (
              SELECT SUM(is_qty) as total_issued_qty,product_id FROM issuance_items
              GROUP BY product_id
              ) as ii
              ON products.product_id=ii.product_id WHERE products.is_deleted=0) product_inventory
              LEFT JOIN vendors v ON v.vendor_id = product_inventory.vendor_id";
              
        return $this->db->query($sql)->result();
    }
}
?>