<!DOCTYPE html>
<html>
<head>
	<title>Point of Sales</title>
	<?php echo $_def_css_files; ?>
	<?php echo $_def_js_files; ?>
    <style type="text/css">
        .btn-wheight {
            height: 120px;
        }
    </style>
</head>
<body class="animated-content">
	<div id="wrapper">
        <div id="layout-static">
        	<div class="static-content-wrapper" style="background-color: white; border-top: 5px solid #2196f3;">
                <div class="static-content">
                    <div class="page-content">
                    	<div class="container-fluid">
                            <div class="row">
                                <div class="container-fluid">
                                    <div class="col-xs-12 col-sm-6">
                                        <h1><i class="fa fa-fax"></i> Point of Sales</h1>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <a href="dashboard" class="btn btn-primary pull-right" style="margin-top: 10px; padding: 15px 17px; border-radius: 50%;">
                                            <i class="fa fa-home" style="font-size: 25px;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div><hr>
                    		<div class="row">
                                <div class="container-fluid">
                                    <div class="col-xs-12 col-sm-6" style="border-right: 1px solid #ddd;">
                                        <h3 style="font-weight: 600;">PRODUCT CATEGORIES</h3>
                                        <?php foreach($_product_categories as $_product_category) { ?>
                                            <div class="col-xs-12 col-sm-3" style="margin-bottom: 10px;">
                                                <button class="btn btn-primary btn-block btn-wheight btn-categories" id="<?php echo $_product_category->category_id; ?>" style="border-radius: 10px;"> 
                                                    <span style="white-space:normal; color: white; font-weight: 600; font-size: 20px;">
                                                        <?php echo $_product_category->category_desc; ?>
                                                    </span>   
                                                    <h4 style="white-space:normal; color: white; font-weight: 600;">
                                                        <?php echo $_product_category->category_name; ?>
                                                    </h4>
                                                </button>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div style="overflow-x: auto;overflow-y: scroll; height: 500px; border-bottom: 1px solid #ddd;">
                                            <table id="tbl_sales" width="100%" class="table table-bordered table-striped">
                                                <thead style="background-color: #16a085; color: white;">
                                                    <th width="10%">QTY</th>
                                                    <th width="20%">ITEM</th>
                                                    <th width="15%">SRP</th>
                                                    <th width="10%">DISCOUNT</th>
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
                                                   <h2 class="text-right" style="font-weight: 600;">0.00</h2>
                                               </div>
                                               <div class="col-xs-12 col-sm-6">
                                                   <h3 style="font-weight: 600;">Tendered :</h3>
                                               </div>
                                               <div class="col-xs-12 col-sm-6">
                                                   <h3 class="text-right" style="font-weight: 600;">0.00</h3>
                                               </div>
                                               <div class="col-xs-12 col-sm-6">
                                                   <h3 style="font-weight: 600;">Change :</h3>
                                               </div>
                                               <div class="col-xs-12 col-sm-6">
                                                   <h3 class="text-right" style="font-weight: 600;">0.00</h3>
                                               </div>
                                           </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="position: fixed; bottom: 0; width: 100%;">
                                <div class="container-fluid" style="background-color: #ddd; height: 100px; padding-top: 20px;">
                                    <div class="col-xs-12 col-sm-3">
                                        <button class="btn btn-success btn-block" style="white-space: normal;">
                                            <h4 style="font-weight: 600; color: white;">PAY</h4>
                                        </button>
                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                        <button class="btn btn-success btn-block" style="white-space: normal;">
                                            <h4 style="font-weight: 600; color: white;">JOURNAL</h4>
                                        </button>
                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                        <button class="btn btn-success btn-block" style="white-space: normal;">
                                            <h4 style="font-weight: 600; color: white;">CANCEL</h4>
                                        </button>
                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                        <button class="btn btn-success btn-block" style="white-space: normal;">
                                            <h4 style="font-weight: 600; color: white;">VOID</h4>
                                        </button>
                                    </div>
                                </div>
                            </div>
                    	</div>
                        <div id="modal_products" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                          <div class="modal-dialog" style="width: 70%;">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Products</h4>
                              </div>
                              <div id="product_container" class="modal-body">
                                
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        (function(){
            $('.btn-categories').on('click',function(){
                $('#modal_products').modal('toggle');
            });

            $('#product_container').append('<h1>Test</h1>');
        })();
    </script>
</body>
</html>