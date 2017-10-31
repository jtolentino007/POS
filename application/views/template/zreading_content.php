<html>
<head>
<style>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Test</title>
<style type="text/css">
    table { page-break-inside:avoid }
    div   { page-break-inside:avoid; } /* This is the key */
    thead { display:table-header-group }
    tfoot { display:table-footer-group }
</style>
<script type="text/javascript">
      window.onload = function() {
	       window.print();
	      setTimeout(function(){
	        var url = window.location.origin;
	        url = url + "/POS/dashboard";  // this number is dynamic actually
	        window.location.href = url;
	      },100);
	   }
 </script>

<style>
	.zreading {
        width: 250px;
        font-family: tahoma;
        font-size: 11px;
        position: absolute;
    }

    @media print {
	  table { page-break-after:auto!important; }
	  tr    { -webkit-region-break-inside: avoid;page-break-inside:avoid!important; page-break-after:auto!important; }
	  td    { -webkit-region-break-inside: avoid;page-break-inside:avoid!important; page-break-after:auto!important; }
	  thead { display:table-header-group!important; }
	  tfoot { display:table-footer-group!important; }
	}
</style>
</head>

<body class="zreading">
<?php
// $fromdate="1900/10/01"; //post value of the date
// $tilldate="2016/09/10"; //post value of the date
// $newfromdate = date("Y-m-d", strtotime($fromdate));
// $newtilldate = date("Y-m-d", strtotime($tilldate));
// $filterdate="'$newfromdate'";
// $filterdate2="'$newtilldate'";

$filter_date = $this->input->get('date',TRUE);

$startdate = $this->input->get('sdate',TRUE);
$enddate = $this->input->get('edate',TRUE);

$starttime = $this->input->get('stime',TRUE);
$endtime = $this->input->get('etime',TRUE);

$sdate = date('Y-m-d', strtotime($startdate));
$edate = date('Y-m-d', strtotime($enddate));

$stime = date('H:i:s', strtotime($starttime));
$etime = date('H:i:s', strtotime($endtime));

$startDateTime = $sdate.' '.$stime;
$endDateTime = $edate.' '.$etime;

$date = date('Y-m-d');
$today = date("m/d/Y", strtotime($date));
$time = date("H:i:s", strtotime($date));


?>
<center><?php echo "<h2 style='font-size:11px;text-align:center;font-family:tahoma;margin:0px;margin-bottom:5px;'>Z-READING</h2>"; ?></center>
<center><?php echo "<h2 style='font-size:11px;text-align:center;font-family:tahoma;margin:0px;margin-bottom:5px;'></h2>"; ?></center>
<center><?php echo "<h3 style='font-size:11px;text-align:center;font-family:tahoma;margin:0px;margin-bottom:5px;'>".$company_info->company_name."</h3>"; ?></center>
<center><?php echo "<h3 style='font-size:11px;text-align:center;font-family:tahoma;margin:0px;margin-bottom:5px;'>".$company_info->company_address."</h3>"; ?></center>
<center><?php echo "<h3 style='font-size:11px;text-align:center;font-family:tahoma;margin:0px;margin-bottom:5px;'>".$company_info->email_address."</h3>"; ?></center>
<center><?php echo "<h3 style='font-size:11px;text-align:center;font-family:tahoma;margin:0px;margin-bottom:5px;'>".$company_info->landline."</h3>"; ?></center>
    <center>
    	<table width="100%" cellpadding="5" style="font-family: tahoma;font-size: 11">
            <tr>
				<td width="100%" valign="top">
                    <companyname>
                        <?php date_default_timezone_set('Asia/Manila'); ?>
                        <strong><?php  echo "Date From ".$sdate." to ".$edate; ?></strong><br>
                        <strong><?php  echo "Time Generated :".date('g:i a');?></strong><br>
                          <strong><?php echo "Cashier : ALL"; ?> </strong>
                    </companyname>
                </td>
            </tr>
        </table>
   </center>
<table style='width:50%;border-collapse: collapse;border-spacing: 0;font-family: tahoma;font-size: 11'>
			<thead>
	            <tr>
					<th style='border-bottom: 1px solid black;text-align: left;'>Receipt No</th>
	        		<th style='border-bottom: 1px solid black;text-align: left;'>Customer</th>
					<th style='border-bottom: 1px solid black;text-align: left;'></th>
					<th style='border-bottom: 1px solid black;text-align: left;'></th>
					<th style='border-bottom: 1px solid black;text-align: right;'></th>
	            </tr>
            </thead>
 <tbody>
<?php
	$query = $this->db->query('SELECT 
			receipt_no,
			pos_invoice.*,
			customers.customer_name,
			pos_payment.pos_payment_id,
			SUM(pos_invoice_items.total) total
			FROM pos_payment
			LEFT JOIN pos_invoice ON pos_payment.pos_invoice_id=pos_invoice.pos_invoice_id
			INNER JOIN pos_invoice_items ON pos_invoice_items.pos_invoice_id = pos_invoice.pos_invoice_id
			LEFT JOIN customers ON pos_invoice.customer_id=customers.customer_id 
			WHERE DATE_FORMAT(pos_invoice.transaction_timestamp, "%Y-%m-%d") BETWEEN "'.$sdate.'" AND "'.$edate.'"
			GROUP BY pos_invoice_id');
	
	$gtotal = $query->row();
	$grandtotal=0; //start value of grandtotal
	$cash_amount=0;
	$card_amount=0;
	$itemtotal=0;
	$grandgrandtotal=0;
	$invoice_total = 0;
?>

<?php foreach ($query->result() as $row) { ?>
		<tr>
			<td style='border-bottom: 1px solid gray;border-top: 1px solid gray;text-align: left;text-align: left;'><?php echo $row->receipt_no; ?></td>
			<td style='border-bottom: 1px solid gray;border-top: 1px solid gray;text-align: left; text-transform: uppercase;'><?php echo $row->customer_name; ?></td>
			<td colspan="2" style='border-bottom: 1px solid gray;border-top: 1px solid gray;text-align: left;'><?php echo $row->transaction_date; ?></td>
			<td style='border-bottom: 1px solid gray;border-top: 1px solid gray;text-align: left;'></td>
			<td style='border-bottom: 1px solid gray;border-top: 1px solid gray;text-align: left;'></td>
		</tr>


		<?php
			$query1 = $this->db->query('SELECT 
				products.product_desc,
				pos_invoice_items.*, 
				SUM(pos_invoice_items.pos_qty) new_pos_qty, 
				SUM(pos_invoice_items.total) new_total 
				FROM pos_invoice_items 
				LEFT JOIN products
				ON pos_invoice_items.product_id=products.product_id
				WHERE pos_invoice_id='.$row->pos_invoice_id.'
				GROUP BY product_id');
		?>				

		<tr>
			<td style='border-bottom: 1px solid gray;text-align: left;'>Item</td>
			<td style='border-bottom: 1px solid gray;text-align: left;'>SRP</td>
			<td style='border-bottom: 1px solid gray;text-align: left;'>Qty</td>
			<td style='border-bottom: 1px solid gray;text-align: left;'>Total</td>
		</tr>

		<?php foreach ($query1->result() as $prod) { ?>
			<?php if ($prod->pos_invoice_id == $row->pos_invoice_id) { ?>
				<tr>
					<td style='text-align: left;'><?php echo $prod->product_desc; ?></td>
					<td style='text-align: left;'><?php echo number_format($prod->pos_price,2); ?></td>
					<td style='text-align: left;'><?php echo $prod->new_pos_qty; ?></td>
					<td  style='text-align: right;'><?php echo $prod->new_total; ?></td>
				</tr>
			<?php } ?>
		<?php } ?>
		<tr>
			<td style='text-align: left;'></td><td colspan="2" style='border-bottom:1px solid black;text-align: left;'><b>Sub Total :</b></td>
			<td style='border-bottom:1px solid black;text-align: right;'><?php echo "<b>".number_format($row->total,2)."</b>"; ?>
		</tr>
		<tr>
			<td style='text-align: left;'></td>
			<td style='text-align: left;'></td>
			<td style='text-align: left;'></td>
			<td style='text-align: left;'></td>
			<td style='text-align: left;'></td>
			<td style='text-align: left;'></td>
		</tr>
	<?php $grandgrandtotal += $row->total; ?>
<?php
	$getcash = $this->db->query('SELECT 
		pos_payment_details.card_amount 
		FROM pos_payment_details
		WHERE pos_payment_id='.$row->pos_payment_id);
		foreach($getcash->result() as $row){
			$card_amount += $row->card_amount;
		}
}
?>
</tbody>
			<tfoot>
			<tr>
				<td colspan="4"><strong>SUMMARY BY PRODUCT</strong></td>
			</tr>
			<tr>
				<td style="border-bottom: 1px solid black;"><strong>Items</strong></td>
                <td style="border-bottom: 1px solid black;"><strong>Qty</strong></td>
                <td style="border-bottom: 1px solid black;"><strong>Price</strong></td>
                <td style="border-bottom: 1px solid black;text-align:right;"><strong>Amount</strong></td>
            </tr>
			<?php
				$getproducts = $this->db->query('SELECT
								pos_invoice_items.product_id,
								product_desc,
								pos_invoice.pos_invoice_no, 
								pos_invoice.transaction_date,
								SUM(pos_invoice_items.pos_qty) as prodsum,
								pos_invoice_items.pos_price
								FROM
								pos_payment
								LEFT JOIN pos_invoice ON pos_invoice.pos_invoice_id = pos_payment.pos_invoice_id
								INNER JOIN pos_invoice_items ON pos_invoice_items.pos_invoice_id = pos_payment.pos_invoice_id
								LEFT JOIN products ON products.product_id = pos_invoice_items.product_id
								WHERE DATE_FORMAT(pos_invoice.transaction_timestamp, "%Y-%m-%d") BETWEEN "'.$sdate.'" AND "'.$edate.'" GROUP BY pos_invoice_items.product_id');
				foreach($getproducts->result() as $row){
					$product_id = $row->product_id;
					$product_name = $row->product_desc;

				// 	$getproducts = $this->db->query('SELECT SUM(pos_qty) as prodsum,pos_price FROM pos_invoice_items WHERE product_id='.$product_id.' GROUP BY product_id');
				// foreach($getproducts->result() as $row){
					$itemprice=$row->prodsum*$row->pos_price;
					$itemtotal+=$itemprice;
			?>
			<tr>
				<td style="border-bottom: 1px solid black;"><strong><?php echo $product_name; ?> </strong></td>
                <td style="border-bottom: 1px solid black;"><strong><?php echo $row->prodsum; ?> </strong></td>
                <td style="border-bottom: 1px solid black;"><strong><?php echo $row->pos_price; ?> </strong></td>
                <td style="border-bottom: 1px solid black;text-align:right;"><strong><?php echo number_format($itemprice,2); ?></strong></td>
            </tr>
			<?php
				// }
			}
			?>
			<tr>
				<td style="border-bottom: 1px solid black;"><strong>Total :</strong></td>
                <td style="border-bottom: 1px solid black;"><strong></strong></td>
                <td colspan="2" style="border-bottom: 1px solid black;text-align:right;"><strong><?php echo number_format($itemtotal,2); ?></strong></td>
            </tr>
            </tfoot>
			</table>

</body>
</html>
