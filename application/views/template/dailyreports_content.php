<company style="font-weight:bold;font-size:15pt;"><?php echo $company_info->company_name;?> </company>
<address style="font-weight:bold;font-size:12pt;margin:0;"><?php echo $company_info->company_address;?> </address>
<br>
<table class="table table-responsive">
    <thead>
      <tr>
        <th style=>Receipt #</th>
        <th>Item</th>
        <th>SRP</th>
        <th>Qty</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $subTotal = 0;
        $grandTotal = 0;
        foreach($receipts as $receipt){
          ?>
          <tr style="border-top:2px solid black;">
            <td><?php echo $receipt->receipt_no; ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <?php
            foreach($invoice as $invoices){
                  if($receipt->pos_invoice_id==$invoices->pos_invoice_id){  ?>
              <tr>
                <td></td>
                <td><?php echo $invoices->product_desc; ?></td>
                <td><?php echo number_format($invoices->pos_price,2); ?></td>
                <td><?php echo $invoices->pos_qty; ?></td>
                <td><?php echo number_format($invoices->total,2); ?></td>
              </tr>
          <?php
              $subTotal += $invoices->total;
            }
          }
          ?>
          <tr>
            <td colspan="4" align="right">Sub-Total :</td>
            <td><?php echo number_format($subTotal,2); ?></td>
          </tr>
      <?php 
        $grandTotal += $subTotal;
      } ?>
      <tr></tr>
      <tr></tr>
      <tr></tr>
      <tr>
        <td colspan="4" align="right">Grand-Total :</td>
        <td><?php echo number_format($grandTotal,2); ?></td>
      </tr>
    </tbody>
</table>

<style>
    table {
      padding: 5px !important;
    }

    th {
      padding-top: 6px !important;
      padding-bottom: 6px !important;
      padding-left: 6px !important;
      font-size: 14px;
    }

    tr {
      padding: 6px !important;
    }

    td {
      padding-top: 6px !important;
      padding-bottom: 6px !important;
      padding-left: 6px !important;
      font-size: 14px;
    }
</style>
