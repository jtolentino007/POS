<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $vendor_name; ?> COPY</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="description" content="Avenxo Admin Theme">
<meta name="author" content="">

<?php echo $_def_js_files; ?>

<script type="text/javascript">
  window.onload = function() {
        window.print();

        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
        
        var url = window.location.origin;

        var _vendor = getParameterByName('vendorid');

        var _newVendorID = parseInt(_vendor) + 1;

        var a = url.indexOf("?");
        var b =  url.substring(a);
        var c = url.replace(b,"");
        var newUrl = c;

        setTimeout(function(){
            url = newUrl + '?vendorid='+_newVendorID; // this number is dynamic actually
            window.location.href = url;
        },10);

        
   }
</script>
<style>
    @media print {
      @page { margin: 0; }
    }

    .receipt {
        width: 250px;
        font-family: tahoma;
        font-size: 11px;
        position: absolute;
    }

    #header {
        text-transform: uppercase;
        text-align: center;
    }

    #middle1 {
        text-align: center;
    }

    #middle2 {
        text-align: center;
    }

    #left1 {
        float: left;
        width: 60px;
    }

    #right1 {
        float: right;
        width: 180px;
    }

    #left2 {
        float: left;
        width: 40px;
    }

    #right2 {
        float: right;
        width: 200px;
    }

    #left3 {
        float: left;
        width: 80px;
        padding-top: 10px;
    }

    #center3 {
        float: left;
        width: 100px;
        padding-top: 10px;
    }

    #right3 {
        float: right;
        width: 54px;
        text-align: right;
        padding-top: 10px;
        padding-left: 0px;
        padding-right: 10px;
    }

    #left4 {
        float: left;
        width: 80px;
        padding-top: 10px;
    }

    #center4 {
        float: left;
        width: 35px;
        padding-top: 10px;
    }

    #right4 {
        float: right;
        width: 119px;
        padding-top: 10px;
    }

    #left5 {
        float: left;
        width: 80px;
        padding-top: 10px;
    }

    #center5 {
        float: left;
        width: 100px;
        padding-top: 10px;
    }

    #right5 {
        float: right;
        width: 54px;
        text-align: right;
        padding-top: 10px;
        padding-left: 0px;
        padding-right: 10px;
    }
       
</style>
</head>

<body class="receipt">
    <div id="wrapper">
        <div id="layout-static">
            <div class="page-content"><!-- #page-content -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="header">
                                <span style="font-size: 14px; font-weight: bolder;"><?php echo $company_info->company_name; ?></span><br><br>
                                <span style="font-size: 12px; font-weight: 600;"><?php echo $vendor_name; ?> COPY</span><br><br>
                            </div>
                            <div class="text-left">
                                <span><strong>TABLE(S)</strong> : <?php echo $tables; ?></span><br>
                                <span><strong>SERVER(S)</strong> : <?php echo $server_names; ?></span><br>
                                <span>
                                    <strong>DATE : </strong>
                                    <?php
                                    date_default_timezone_set('Asia/Manila');
                                    echo date('M. d, Y g:i a'); 
                                    ?>
                                </span>
                            </div>
                        </div>
                    </div><br>

                    <center>

                        <table width="95%" style="border-collapse: collapse;border-spacing: 0;font-family: tahoma;font-size: 11px;border-top: 2px dashed gray;">
                            <thead>
                            <tr>
                                <td width="15%" style="border-bottom: 2px dashed gray;text-align: left;height: 15px;padding: 6px;">Qty</td>
                                <td width="50%" style="border-bottom: 2px dashed gray;text-align: left;height: 15px;padding: 6px;">Description</td>
                                <td width="11%" style="border-bottom: 2px dashed gray;text-align: right;height: 15px;padding: 6px;"></td>
                            </tr>
                            </thead>
                            <tbody id="pos_item">
                            <?php 
                            $count = 0;
                            $qty = 0;
                            foreach($delivery_info as $item){
                            $count++;
                            $qty += $item->pos_qty;
                            ?>
                                <tr>
                                    <td width="15%" style="border-bottom: 1px dashed gray;text-align: left;height: 15px;padding: 6px;"><?php echo number_format($item->pos_qty); ?></td>
                                    <td width="50%" style="border-bottom: 1px dashed gray;text-align: left;height: 15px;padding: 6px;"><?php echo $item->product_desc; ?></td>
                                    <td width="11%" style="border-bottom: 1px dashed gray;text-align: left;height: 15px;padding: 6px;"></td>
                                </tr>
                            <?php } ?>

                            </tbody>
                        </table>
                    </center>
                    <tr><p>.</p></tr>
                    <tr><p>.</p></tr>

                    <div class="row">
                        <div class="col-md-12">
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
