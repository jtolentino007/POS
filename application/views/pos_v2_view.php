<!DOCTYPE html>
<html>
<head>
	<title>Point of Sales</title>
	<?php echo $_def_css_files; ?>
	<?php echo $_def_js_files; ?>
    <style type="text/css">
        .btn-wheight {
            min-height: 120px;
            height: auto;
            border-radius: 10px!important;
        }

        .btn-margin-bottom {
            margin-bottom: 20px!important;
        }

        input,
        input:disabled {
            background: transparent!important;
            border:none!important;
        }

        input:focus {
            font-weight: 600;
            font-size: 14px!important;
        }

        .btn-wood {
            background-image: url('assets/img/wood-bg.jpg');
            background-repeat: no-repeat;
            background-position: center; 
            border:none;
        }

        .btn-util {
            min-height: 60px;
            margin-bottom: 10px;
        }

        h4 {
            margin: 0;
        }

        hr {
            margin: 0;
        }

        /* Scrollbar styles */
        ::-webkit-scrollbar {
            width: 8px;
            height: auto;
        }

        ::-webkit-scrollbar-track {
            border-radius: 0;
            border: 1px solid #ddd;
        }

        ::-webkit-scrollbar-thumb {
            border-radius: 0;
            background: #8bc34a; 
        }
    </style>
    

<link rel="stylesheet" type="text/css" href="assets/css/theme.css">
    <style type="text/css">
         .modal-backdrop {
          z-index: -1;
        }
    </style>

</head>
<body class="animated-content">
	<div id="wrapper">
        <div id="layout-static">
        	<div class="static-content-wrapper" style="background-color: white;">
                <div class="static-content">
                    <div class="page-content">
                    	<div class="container-fluid">
                            <div class="row">
                                <div class="container-fluid">
                                    <div class="col-xs-12 col-sm-6">
                                        <h1 style="font-weight: 400;"><i class="fa fa-fax" style="color: #ff9800;"></i> POINT OF SALES <small> | Touchscreen</small></h1>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <a href="dashboard" class="btn btn-primary pull-right" style="margin-top: 10px; padding: 15px 17px; border-radius: 50%;">
                                            <i class="fa fa-home" style="font-size: 25px;"></i>
                                        </a>
                                        <button id="btn_tables" class="btn btn-primary pull-right" style="margin-top: 10px; margin-right: 10px; padding: 15px 17px; border-radius: 50%;" title="Tables">
                                            <i class="fa fa-table" style="font-size: 25px;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                    		<div class="row" style="margin-top: 0;">
                                <div class="container-fluid">
                                    <div class="col-xs-12 col-sm-6">
                                        <h3 style="font-weight: 600;">PRODUCT CATEGORIES</h3>
                                        <div style="overflow-y: auto; height: 750px;">
                                            <?php foreach($_product_categories as $_product_category) { ?>
                                                <div class="col-xs-12 col-sm-3" >
                                                    <button 
                                                        class="btn btn-primary btn-block btn-wheight btn-categories" 
                                                        id="<?php echo $_product_category->category_id; ?>" 
                                                        data-name="<?php echo $_product_category->category_name; ?>"
                                                        style="border-radius: 0; margin-bottom: 25px;"> 
                                                        <span style="white-space:normal; color: #b4e7fe; font-weight: 600; font-size: 20px;">
                                                            <?php echo $_product_category->category_desc; ?>
                                                        </span>   
                                                        <h4 style="white-space:normal; color: white; font-weight: 600;">
                                                            <?php echo $_product_category->category_name; ?>
                                                        </h4>
                                                    </button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <h3 id="order_title" style="font-weight: 600;">PLEASE SELECT TABLE</h3>
                                        <div style="height: 500px; overflow-y: auto; border: 1px solid #ddd;">
                                            <table id="tbl_sales" width="100%" class="table table-bordered table-striped">
                                                <thead style="background-color: #03a9f4; color: white;">
                                                    <th class="hidden">PRODUCT ID</th>
                                                    <th width="10%">QTY</th>
                                                    <th width="20%">ITEM</th>
                                                    <th width="10%">SRP</th>
                                                    <th width="10%">DISCOUNT</th>
                                                    <th class="hidden" width="10%">TAX RATE</th>
                                                    <th width="10%">TAX</th>
                                                    <th width="15%">TOTAL</th>
                                                    <th width="10%" align="center"><center>ACTION</center></th>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                           <div class="container-fluid">
                                               <div class="col-xs-12 col-sm-6">
                                                   <h2 style="font-weight: 600;">Amount Due :</h2>
                                               </div>
                                               <div class="col-xs-12 col-sm-6">
                                                   <h2 id="td_amount_due" class="text-right" style="font-weight: 600;">0.00</h2>
                                               </div>
                                               <div class="col-xs-12 col-sm-6">
                                                   <h3 style="font-weight: 600;">Tendered :</h3>
                                               </div>
                                               <div class="col-xs-12 col-sm-6">
                                                   <h3 id="td_tendered" class="text-right" style="font-weight: 600;">0.00</h3>
                                               </div>
                                               <div class="col-xs-12 col-sm-6">
                                                   <h3 style="font-weight: 600;">Change :</h3>
                                               </div>
                                               <div class="col-xs-12 col-sm-6">
                                                   <h3 id="td_change" class="text-right" style="font-weight: 600;">0.00</h3>
                                               </div>
                                           </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="container-fluid" style="padding-top: 20px;">
                                    <div class="col-xs-12 col-sm-2">
                                        <button id="btn_pay" class="btn btn-success btn-block btn-util" style="white-space: normal;">
                                            <h3 style="font-weight: 600; color: white;"><i class="ti ti-hand-stop"></i><br>ENTER PAYMENT</h3>
                                        </button>
                                    </div>
                                    <div class="col-xs-12 col-sm-2">
                                        <button class="btn btn-success btn-block btn-util" style="white-space: normal;">
                                            <h3 style="font-weight: 600; color: white;"><i class="ti ti-package"></i><br>PRODUCTS</h3>
                                        </button>
                                    </div>
                                    <div class="col-xs-12 col-sm-2">
                                        <button class="btn btn-success btn-block btn-util" style="white-space: normal;">
                                            <h3 style="font-weight: 600; color: white;"><i class="ti ti-notepad"></i><br>RECEIPTS</h3>
                                        </button>
                                    </div>
                                    <div class="col-xs-12 col-sm-2">
                                        <button class="btn btn-warning btn-block btn-util" style="white-space: normal;">
                                            <h3 style="font-weight: 600; color: white;"><i class="ti ti-na"></i><br>CANCEL</h3>
                                        </button>
                                    </div>
                                    <div class="col-xs-12 col-sm-2">
                                        <button class="btn btn-danger btn-block btn-util" style="white-space: normal;">
                                            <h3 style="font-weight: 600; color: white;"><i class="ti ti-close"></i><br>VOID</h3>
                                        </button>
                                    </div>
                                    <div class="col-xs-12 col-sm-2">
                                        <button class="btn btn-info btn-block btn-util" style="white-space: normal;">
                                            <h3 style="font-weight: 600; color: white;"><i class="ti ti-package"></i><br>END BATCH</h3>
                                        </button>
                                    </div>
                                </div>
                            </div>
                    	</div>

                        <div id="modal_products" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                          <div class="modal-dialog" style="width: 50%;">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header text-center">
                                <h4 class="modal-title" style="font-weight: 400;"></h4>
                              </div>
                              <div class="modal-body" style="overflow: auto; height: 600px; background-color: #f3f3f3;">
                                <div class="row">
                                    <div class="container-fluid" id="product_container">
                                    </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-primary btn-block" data-dismiss="modal" style="font-size: 25px;">DONE</button>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div id="modal_tables" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                          <div class="modal-dialog" style="width: 50%;">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header text-center">
                                <h4 class="modal-title" style="font-weight: 400;">TABLES</h4>
                              </div>
                              <div class="modal-body" style="overflow: auto; height: 600px; background-color: #f3f3f3;">
                                <div class="row">
                                    <div class="container-fluid" id="table_container">
                                    </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-primary btn-block" data-dismiss="modal" style="font-size: 25px;">CLOSE</button>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div id="modal_payment" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                          <div class="modal-dialog" style="width: 70%;">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header text-center">
                                <h4 class="modal-title" style="font-weight: 400;"><strong>PLEASE ENTER PAYMENT</strong></h4>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                    <div class="container-fluid">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="col-xs-12 col-sm-4">
                                                <button class="btn btn-warning btn-block btn-wheight btn-margin-bottom">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        20
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <button class="btn btn-warning btn-block btn-wheight btn-margin-bottom">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        50
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <button class="btn btn-warning btn-block btn-wheight btn-margin-bottom">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        100
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <button class="btn btn-warning btn-block btn-wheight btn-margin-bottom">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        200
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <button class="btn btn-warning btn-block btn-wheight btn-margin-bottom">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        500
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <button class="btn btn-warning btn-block btn-wheight btn-margin-bottom">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        1000
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <button class="btn btn-success btn-block btn-wheight btn-margin-bottom">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        1
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <button class="btn btn-success btn-block btn-wheight btn-margin-bottom">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        2
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <button class="btn btn-success btn-block btn-wheight btn-margin-bottom">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        3
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <button class="btn btn-success btn-block btn-wheight btn-margin-bottom">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        4
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <button class="btn btn-success btn-block btn-wheight btn-margin-bottom">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        5
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <button class="btn btn-success btn-block btn-wheight btn-margin-bottom">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        6
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <button class="btn btn-success btn-block btn-wheight btn-margin-bottom">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        7
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <button class="btn btn-success btn-block btn-wheight btn-margin-bottom">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        8
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <button class="btn btn-success btn-block btn-wheight btn-margin-bottom">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        9
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <button class="btn btn-success btn-block btn-wheight btn-margin-bottom">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        0
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-8">
                                                <button class="btn btn-primary btn-block btn-wheight btn-margin-bottom">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        CLEAR
                                                    </h3>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <h1><strong>TOTAL</strong></h1>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- numeric formatter -->
    <script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
    <script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>

    <script type="text/javascript">
        (function(){
            var _btn_product;
            var _currentRow;


            $('.btn-categories').on('click',function(){
                $.ajax({
                    "dataType":"json",
                    "url":"Pos_v2/getList/product-by-category/"+$(this).attr('id')
                }).done(function(data){
                    $('#product_container').html('');
                    $.each(data.response, function(index, value){
                        $('#product_container').append(
                            '<div class="col-xs-12 col-sm-3">' +
                                '<button ' + 
                                    'id="btn_product"'+ 
                                    'class="btn btn-warning btn-block btn-wheight"'+
                                    'style="border-radius: 0; margin-bottom: 25px;white-space:normal;"'+
                                    'data-prod-id="'+value.product_id+'"'+
                                    'data-prod-desc="'+value.product_desc+'"'+
                                    'data-prod-srp="'+value.sale_cost+'"'+
                                    'data-prod-tax="'+value.tax_rate+'"'+
                                    '>' + 
                                        '<span style="font-weight:500; font-size:25px;">' + 
                                            value.product_code + 
                                        '</span>' +
                                        '<br/>' + 
                                        '<h4 style="font-weight:500; color:white;">' + 
                                            value.product_desc + 
                                        '</h4>' +
                                '</button>' +
                            '</div>'
                       );
                    });
                });

                $('.modal-title').html($(this).data('name'));
                $('#modal_products').modal('toggle');

            });

            $('#btn_pay').on('click',function(){
                $('#modal_payment').modal('show');
            });

            $('#btn_tables').on('click',function(){
                 $.ajax({
                    "dataType":"json",
                    "url":"Tables/transaction/list"
                }).done(function(response){
                    $('#table_container').html('');
                    $.each(response.data, function(index, value){
                        $('#table_container').append(
                            '<div class="col-xs-12 col-sm-3">' +
                                '<button ' + 
                                    'id="btn_table_trigger"'+ 
                                    'class="btn btn-success btn-wood btn-block btn-wheight"'+
                                    'style="border-radius: 0; margin-bottom: 25px;white-space:normal;"'+
                                    'data-table-id="'+value.table_id+'"' +
                                    '>' + 
                                        '<span style="font-weight:500; font-size:25px;">' + 
                                            value.table_name + 
                                        '</span>' +
                                '</button>' +
                            '</div>'
                       );
                    });
                });

                $('#modal_tables').modal('toggle');
            });

            $('#table_container').on('click','#btn_table_trigger',function(){
                $('#order_title').text('ORDER SUMMARY FOR ' + $(this).text());
                $('#modal_tables').modal('hide');
            });

            $('#product_container').on('click','#btn_product',function(){
               _btn_product = $(this);

                AppendProductToTable();
                reComputeRowTotal();
                recomputeTotal();
                initializeNumeric();
            });

            $('#tbl_sales').on('change','input.numeric', function(){
                reComputeRowTotal();
            });

            $('#tbl_sales').on('change','input[name="pos_qty[]"]', function(){
                reComputeRowTotal();
            });

            var addedProductCodes = [];

            var AppendProductToTable = function() {
                var td_productCode = _btn_product.data('prod-id');
                var index = $.inArray(td_productCode, addedProductCodes);

                if (index >= 0) {
                    $('#tbl_sales tbody tr').each(function(){

                        if($(this).find('td').find('input[name="product_id[]"]').val() == _btn_product.data('prod-id')) {
                            $(this).find('td').find('input[name="pos_qty[]"]').val(parseInt($(this).find('td').find('input[name="pos_qty[]"]').val()) + 1);
                        }
                        
                    });
                } else {
                    $('#tbl_sales > tbody').prepend(
                        '<tr>'+
                            '<td class="hidden" width="10%">' +
                                '<input class="text-center form-control" type="text" value="'+_btn_product.data('prod-id')+'" name="product_id[]">'+
                            '</td>' +
                            '<td width="10%">' +
                                '<input class="text-center form-control" type="text" value="1" name="pos_qty[]">'+
                            '</td>' +
                            '<td width="20%">'+
                                '<input class="form-control" type="hidden" value="'+_btn_product.data('prod-desc')+'">'+_btn_product.data('prod-desc')+
                            '</td>'+
                            '<td width="10%" class="text-center">'+
                                '<input class="numeric text-right form-control" type="text" value="'+_btn_product.data('prod-srp')+'" name="pos_price[]">'+
                            '</td>'+
                            '<td width="10%">'+
                                '<input class="numeric text-right form-control" type="text" value="0" name="pos_discount[]">'+
                            '</td>'+
                            '<td width="15%" class="hidden">'+
                                '<input class="numeric text-right form-control" type="text" value="'+_btn_product.data('prod-tax')+'" name="tax_rate[]">'+
                            '</td>'+
                            '<td width="15%">'+
                                '<input class="numeric text-right form-control" type="text" value="0" name="tax_amount[]" disabled>'+
                            '</td>'+
                            '<td width="10%">'+
                                '<input id="total" class="numeric text-right form-control" type="text" value="0" name="total[]" disabled>'+
                            '</td>'+
                            '<td width="10%" class="text-center">'+
                            '<button id="btn_delete" class="btn btn-danger" disabled>'+
                                '<i class="fa fa-trash-o"></i>'+
                            '</button>'+
                            '</td>'+
                        '</tr>'
                    );

                    addedProductCodes.push(td_productCode);
                }
            };

            var reComputeRowTotal = function() {
                $.each($('#tbl_sales tbody tr'), function(){
                    var rowQty = parseFloat($(this).find('td').find('input[name="pos_qty[]"]').val());
                    var rowSrp = parseFloat($(this).find('td').find('input[name="pos_price[]"]').val());
                    var rowDiscount = parseFloat($(this).find('td').find('input[name="pos_discount[]"]').val());
                    var rowTax = parseFloat($(this).find('td').find('input[name="tax_rate[]"]').val());

                    var rowTotal = (rowQty * rowSrp);

                    $(this).find('td').find('input[name="total[]"]').val(accounting.formatNumber(rowTotal,2));
                });
            };

            var recomputeTotal = function() {
                var totalAmount = 0;

                $.each($('#tbl_sales tbody tr'), function(){
                    totalAmount += parseFloat($(this).find('td').find('input[name="total[]"]').val());
                });

                $('#td_amount_due').html(accounting.formatNumber(totalAmount,2));
            };

            var initializeNumeric = function(){
                $('.numeric').autoNumeric('init');
            };
        })();
    </script>
</body>
</html>