<?php
$fromdate="1900/10/01"; //post value of the date
$tilldate="2016/09/10"; //post value of the date
$newfromdate = date("Y-m-d", strtotime($fromdate));
$newtilldate = date("Y-m-d", strtotime($tilldate));
$filterdate="'$newfromdate'";
$filterdate2="'$newtilldate'";

$date = date('Y-m-d H:i:s');
$today = date("m/d/Y", strtotime($date));
$time = date("H:i:s", strtotime($date));

$sDate = date('Y-m-d', strtotime($this->input->get('sdate',TRUE)));
$eDate = date('Y-m-d', strtotime($this->input->get('edate',TRUE)));

$user_id = $id;
?>
	
<center><?php echo "<h2 style='text-align:center;margin:0px;margin-bottom:5px;'>X-READING</h2>"; ?></center>
<center><?php echo "<h3 style='text-align:center;margin:0px;margin-bottom:5px;'>".$company_info->company_name."</h3>"; ?></center>
<center><?php echo "<h3 style='text-align:center;margin:0px;margin-bottom:5px;'>".$company_info->company_address."</h3>"; ?></center>
<center><?php echo "<h3 style='text-align:center;margin:0px;margin-bottom:5px;'>".$company_info->email_address."</h3>"; ?></center>
<center><?php echo "<h3 style='text-align:center;margin:0px;margin-bottom:5px;'>".$company_info->landline."</h3>"; ?></center>
<center><table width="100%" cellpadding="5" style="font-family: tahoma;font-size: 11">
        <tr>
           <!-- <td width="45%" valign="top">
                <span>Company Name :</span>
                <companyname>
                    <strong><?php // echo $company_info->company_name; ?></strong><br>
                    <?php// echo "Address :".$company_info->company_address; ?><br>
                    <?php //echo "Email Address :".$company_info->email_address; ?><br>
                    <abbr title="Phone">Phone :</abbr> <?php// echo $company_info->landline; ?>
                </companyname>
            </td>  -->
    <td width="50%" valign="top">
                <companyname>
                    <?php echo ""; ?><br>
                    <strong><?php  echo "Date Generated :<u>".$today."</u><br> Time Generated : <u>".$time."</u>";?></strong><br>
                      <strong><?php echo "Cashier Name : <u>".$user_info->full_name."</u>"; ?></strong>
                </companyname>
            </td>

         <!--    <td width="50%" align="right">
        <img height="50px" width="50px" src="<?php echo $company_info->logo_path; ?>" ></img>
            </td> -->
        </tr>
    </table></center>
<table width='95%' class="table table-responsive" style='border-collapse: collapse;border-spacing: 0;font-size: 11'>
			<thead>
	            <tr>
					<th colspan="2" style='border-bottom: 2px solid gray;text-align: left;'>Receipt No</th>
	                <th colspan="2" width='12%' style='border-bottom: 2px solid gray;text-align: left;'>Customer</th>
					<th colspan="2" style='border-bottom: 2px solid gray;text-align: left;'>Date</th>
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
			LEFT JOIN customers ON pos_invoice.customer_id=customers.customer_id WHERE user_id='.$user_id.' AND DATE_FORMAT(transaction_timestamp, "%Y-%m-%d") BETWEEN "'.$sDate.'" AND "'.$eDate.'" GROUP BY pos_invoice_id');
	$gtotal = $query->row();
	//$grandtotal = $gtotal->grand_total;

		$grandtotal=0; //start value of grandtotal
		$cash_amount=0;
		$card_amount=0;
		foreach ($query->result() as $row)
		{
	       $receiptno=  $row->receipt_no;
		   $invoiceid=  $row->pos_invoice_id;
		   $customer=  $row->customer_name;
		   $pos_payment_id=  $row->pos_payment_id;

		?>
			<tr>
				<td colspan="2" style='border-bottom: 2px solid gray;border-top: 2px solid gray;text-align: left;text-align: left;'><?php echo $receiptno; ?></td>
				<td colspan="2" style='border-bottom: 2px solid gray;border-top: 2px solid gray;text-align: left; text-transform: uppercase;'><?php echo $customer; ?></td>
				<td colspan="2" style='border-bottom: 2px solid gray;border-top: 2px solid gray;text-align: left;'><?php echo $row->transaction_date; ?></td>
			</tr>

			<thead>
	            <tr>
					<th colspan="3" style='border-bottom: 2px solid gray;text-align: left;'>Item</th>
	                <th width='12%' style='border-bottom: 2px solid gray;text-align: left;'>SRP</th>
					<th style='border-bottom: 2px solid gray;text-align: left;'>Qty</th>
					<th style='border-bottom: 2px solid gray;text-align: right;'>Total</th>
	            </tr>
            </thead>
		<?php
		$query1 = $this->db->query('SELECT products.product_desc,pos_invoice_items.* FROM pos_invoice_items LEFT JOIN products
				ON pos_invoice_items.product_id=products.product_id
				WHERE pos_invoice_id='.$invoiceid);

			foreach ($query1->result() as $prod) { ?>
				<tr>
				<td colspan="3" style='text-align: left;'><?php echo $prod->product_desc; ?></td>
				<td style='text-align: left;'><?php echo number_format($prod->pos_price,2); ?></td>
				<td style='text-align: left;'><?php echo $prod->pos_qty; ?></td>
				<td style='text-align: right;'><?php echo number_format($prod->total,2); ?></td></tr>

				<?php
					$grandtotal+=$prod->total; /*computing for grandtotal*/ } ?>
						<tr>
						<td colspan="5" style='border-bottom:1px solid black;border-top:1px solid black;text-align: left;'><b>Sub Total :</b></td>
						<td style='border-bottom:1px solid black;text-align: right;border-top:1px solid black; font-size: 14px;'><?php echo "<b>".number_format($row->total,2)."</b>"; ?></tr>
						<tr>
						<td colspan="5" style='text-align: left;'>&nbsp;</td>
						</tr>
				<?php

				$getcash = $this->db->query('SELECT pos_payment_details.card_amount FROM pos_payment_details
				WHERE pos_payment_id='.$pos_payment_id);

					foreach($getcash->result() as $row) {
						$card_amount += $row->card_amount;
					}

		} ?>
			</tbody>
			<tfoot width="100%">
				<tr>
	                <td colspan="5" style="border-bottom: 1px solid black; font-size: 14px;"><strong>Grand Total : </strong></td>
	                <td style="border-bottom: 1px solid black;text-align:right; font-size: 14px;"><strong><?php echo number_format($grandtotal,2); ?></strong></td>
	            </tr>
				<tr>
	                <td colspan="5"  style="border-bottom: 1px solid black; font-size: 14px;"><strong>Cash Sale : </strong></td>
	                <td style="border-bottom: 1px solid black;text-align:right; font-size: 14px;"><strong><?php echo number_format($grandtotal-$card_amount,2); ?></strong></td>
	            </tr>
				<tr>
	                <td colspan="5"  style="border-bottom: 1px solid black; font-size: 14px;"><strong>Card Sale : </strong></td>
	                <td style="border-bottom: 1px solid black;text-align:right; font-size: 14px;"><strong><?php echo number_format($card_amount,2); ?></strong></td>
	            </tr>
				<tr>
	                <td colspan="5"  style="border-bottom: 1px solid black; font-size: 14px;"><strong>Gift Cert : </strong></td>
	                <td style="border-bottom: 1px solid black;text-align:right; font-size: 14px;"><strong><?php echo number_format(0,2); ?></strong></td>
	            </tr>
				<tr>
	                <td colspan="5"  style="border-bottom: 1px solid black; font-size: 14px;"><strong>Total : </strong></td>
	                <td style="border-bottom: 1px solid black;text-align:right; font-size: 14px;"><strong><?php echo number_format($grandtotal-$card_amount+$card_amount,2); ?></strong></td>
	            </tr>
            </tfoot>
			</table>