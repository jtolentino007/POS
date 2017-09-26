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

        .form-control {
            padding: 5px!important;
            border:none!important;
            background: transparent!important;
        }

        .form-control:disabled {
            background: transparent!important;
            border:none!important;
        }

        .form-input {
            border: 1px solid #ddd!important;
        }

        .form-input:focus {
            border: 1px solid #2196f3!important;
        }

        .form-control:focus {
            font-weight: 600;
            font-size: 14px!important;
            border:1px solid #2196f3!important;
            background: white!important;
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
            width: 5px;
            height: auto;
            border-radius: 50%!important;
        }

        ::-webkit-scrollbar-track {
            border-radius: 0;
            border-top: 1px solid #ddd;
            border-left: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            border-right: none!important;
        }

        ::-webkit-scrollbar-thumb {
            border-radius: 0;
            background: #8bc34a; 
        }

        .ui-pnotify-title {
            color: white!important;
        }
    </style>
    

    <link rel="stylesheet" type="text/css" href="assets/css/theme.css">
    <style type="text/css">
         .modal-backdrop {
          z-index: -1;
        }
    </style>

    <script type="text/javascript" src="assets/plugins/jquery.fullscreen-master/release/jquery.fullscreen.js"></script>

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
                                        <h1 style="font-weight: 400;"><i class="fa fa-fax" style="color: #ff9800;"></i> POINT OF SALES <small> | Touchscreen</small></h1>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <a href="dashboard" class="btn btn-primary pull-right" style="margin-top: 10px; padding: 15px 17px; border-radius: 50%;">
                                            <i class="fa fa-home" style="font-size: 25px;"></i>
                                        </a>
                                        <button id="btn_tables" class="btn btn-primary pull-right" style="margin-top: 10px; margin-right: 10px; padding: 15px 17px; border-radius: 50%;" title="Tables">
                                            <i class="fa fa-table" style="font-size: 25px;"></i>
                                        </button>
                                        <button id="btn_customers" class="btn btn-primary pull-right" style="margin-top: 10px; margin-right: 10px; padding: 15px 17px; border-radius: 50%;" title="Customers">
                                            <i class="fa fa-users" style="font-size: 25px;"></i>
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
                                                <div class="col-xs-12 col-sm-4">
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
                                        <h3 id="order_title" style="font-weight: 600;">PLEASE SELECT CUSTOMER...</h3>
                                        <div style="height: 500px; overflow-y: auto; border: 1px solid #ddd;">
                                            <form id="frm_items">
                                                <table id="tbl_sales" width="100%" class="table table-responsive table-striped">
                                                    <thead style="background-color: #404040; color: white;">
                                                        <th class="hidden">PRODUCT ID</th>
                                                        <th width="10%">QTY</th>
                                                        <th width="20%">ITEM</th>
                                                        <th width="10%">SRP</th>
                                                        <th width="10%">DISCOUNT</th>
                                                        <th class="hidden" width="10%">TAX RATE</th>
                                                        <th width="10%" align="right">TAX</th>
                                                        <th width="15%">TOTAL</th>
                                                        <th width="10%" align="center"><center>ACTION</center></th>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                        <div class="row">
                                           <div class="container-fluid">
                                                <div class="col-xs-12 col-sm-6">
                                                   <p style="font-weight: 600; font-size: 17px;">Table(s) :</p>
                                                </div>
                                                <div class="col-xs-12 col-sm-6">
                                                   <p id="td_tables" class="text-right" style="font-weight: 600; font-size: 17px;">No selected</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                           <div class="container-fluid">
                                                <div class="col-xs-12 col-sm-6">
                                                   <p style="font-weight: 600; font-size: 17px;">Total Discount :</p>
                                                </div>
                                                <div class="col-xs-12 col-sm-6">
                                                   <p id="td_total_discount" class="text-right" style="font-weight: 600; font-size: 17px;">0.00</p>
                                                </div>
                                           </div>
                                       </div>
                                       <div class="row">
                                           <div class="container-fluid">
                                                <div class="col-xs-12 col-sm-6">
                                                   <p style="font-weight: 600; font-size: 17px;">Total Before Tax :</p>
                                                </div>
                                                <div class="col-xs-12 col-sm-6">
                                                   <p id="td_total_before_tax" class="text-right" style="font-weight: 600; font-size: 17px;">0.00</p>
                                                </div>
                                           </div>
                                       </div>
                                       <div class="row">
                                           <div class="container-fluid">
                                                <div class="col-xs-12 col-sm-6">
                                                   <p style="font-weight: 600; font-size: 17px;">Total Tax :</p>
                                                </div>
                                                <div class="col-xs-12 col-sm-6">
                                                   <p id="td_total_tax" class="text-right" style="font-weight: 600; font-size: 17px;">0.00</p>
                                                </div>
                                           </div>
                                       </div>
                                       <div class="row hidden">
                                           <div class="container-fluid">
                                                <div class="col-xs-12 col-sm-6">
                                                   <p style="font-weight: 600; font-size: 17px;">Total After Tax :</p>
                                                </div>
                                                <div class="col-xs-12 col-sm-6">
                                                   <p id="td_total_after_tax" class="text-right" style="font-weight: 600; font-size: 17px;">0.00</p>
                                                </div>
                                           </div>
                                       </div><hr>
                                        <div class="row">
                                            <div class="container-fluid">
                                               <div class="col-xs-12 col-sm-6">
                                                   <h2 style="font-weight: 600;">Amount Due :</h2>
                                               </div>
                                               <div class="col-xs-12 col-sm-6">
                                                   <h2 id="td_amount_due" class="text-right" style="font-weight: 600;">0.00</h2>
                                               </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="container-fluid" style="padding-top: 20px;">
                                    <div class="col-xs-12 col-sm-1"></div>
                                    <div class="col-xs-12 col-sm-2">
                                        <button id="btn_enter_order" class="btn btn-success btn-block btn-util" style="white-space: normal;">
                                            <h3 style="font-weight: 600; color: white;"><i class="ti ti-receipt"></i><br>ENTER ORDER</h3>
                                        </button>
                                    </div>
                                    <div class="col-xs-12 col-sm-2">
                                        <button id="btn_unpaid" class="btn btn-success btn-block" style="white-space: normal;">
                                            <h3 style="font-weight: 600; color: white;"><i class="fa fa-file-o"></i><br>UNPAID ORDERS</h3>
                                        </button>
                                    </div>
                                    <div class="col-xs-12 col-sm-2">
                                        <button id="btn_cancel_order" class="btn btn-warning btn-block btn-util" style="white-space: normal;">
                                            <h3 style="font-weight: 600; color: white;"><i class="ti ti-na"></i><br>CANCEL</h3>
                                        </button>
                                    </div>
                                    <div class="col-xs-12 col-sm-2">
                                        <button id="btn_void" class="btn btn-danger btn-block btn-util" style="white-space: normal;">
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
                                <div class="row">
                                    <div class="container-fluid">
                                        <div class="col-xs-12 col-sm-6">
                                            <button id="btn_enter_table" type="button" class="btn btn-primary btn-block" style="font-size: 25px;">ENTER</button>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal" style="font-size: 25px;">CLOSE</button>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div id="modal_login" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                          <div class="modal-dialog modal-md">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header text-center">
                                <h4 class="modal-title" style="font-weight: 400;">MANAGER LOGIN</h4>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                    <div class="container-fluid">
                                        <label>USERNAME :</label>
                                        <input name="user_name" type="text" class="form-control form-input" placeholder="Username" data-parsley-minlength="20" placeholder="At least 6 characters" required><br>
                                        <label>PASSWORD :</label>
                                        <input name="user_pword" type="password" class="form-control form-input" id="exampleInputPassword1" placeholder="Password"><br>
                                    </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <div class="row">
                                    <div class="container-fluid">
                                        <div class="col-xs-12 col-sm-6">
                                            <button id="btn_login" type="button" class="btn btn-primary btn-block" style="font-size: 25px;">LOGIN</button>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal" style="font-size: 25px;">CLOSE</button>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div id="modal_customers" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                          <div class="modal-dialog" style="width: 50%;">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header text-center">
                                <h4 class="modal-title" style="font-weight: 400;">CUSTOMERS</h4>
                              </div>
                              <div class="modal-body" style="overflow: auto; height: 600px; background-color: #f3f3f3;">
                                <div class="row">
                                    <div class="container-fluid" id="customer_container">
                                    </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-primary btn-block" data-dismiss="modal" style="font-size: 25px;">CLOSE</button>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div id="modal_unpaid" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                          <div class="modal-dialog modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header text-center">
                                <h4 class="modal-title" style="font-weight: 400;">UNPAID ORDERS</h4>
                              </div>
                              <div class="modal-body" style="overflow: auto; height: 600px;">
                                <div class="row">
                                    <div class="container-fluid">
                                        <table id="tbl_unpaid" class="table table-responsive" width="100%">
                                            <thead>
                                                <th>ORDER #</th>
                                                <th>CUSTOMER</th>
                                                <th>TABLE(S)</th>
                                                <th>AMOUNT</th>
                                                <th><center>ACTION</center></th>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-primary btn-block" data-dismiss="modal" style="font-size: 25px;">CLOSE</button>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div id="modal_new_customer" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                          <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header text-center">
                                <h4 class="modal-title" style="font-weight: 400;">PLEASE ENTER CUSTOMER NAME</h4>
                              </div>
                              <div class="modal-body">
                                <form id="frm_customers">
                                    <div class="row">
                                        <div class="container-fluid">
                                            <input type="text" name="customer_name" class="form-control" style="border: 1px solid #ddd!important;" data-error-msg="Customer Name is required!" required>
                                        </div>
                                    </div>
                                </form>
                              </div>
                              <div class="modal-footer text-center">
                                    <button id="btn_save_customer" type="button" class="btn btn-primary" style="font-size: 25px;">SAVE</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="font-size: 25px;">CLOSE</button>
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
                                            <div class="col-xs-12 col-sm-3">
                                                <button id="btn_amount" class="btn btn-info btn-block btn-margin-bottom" data-amount="20">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        20
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-3">
                                                <button id="btn_amount" class="btn btn-info btn-block btn-margin-bottom" data-amount="50">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        50
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-3">
                                                <button id="btn_amount" class="btn btn-info btn-block btn-margin-bottom" data-amount="100">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        100
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-3">
                                                <button id="btn_amount" class="btn btn-info btn-block btn-margin-bottom" data-amount="200">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        200
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-3">
                                                <button id="btn_amount" class="btn btn-info btn-block btn-margin-bottom" data-amount="500">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        500
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-3">
                                                <button id="btn_amount" class="btn btn-info btn-block btn-margin-bottom" data-amount="1000">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        1000
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-3">
                                                <button id="btn_amount" class="btn btn-success btn-block btn-margin-bottom" data-amount="1">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        1
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-3">
                                                <button id="btn_amount" class="btn btn-success btn-block btn-margin-bottom" data-amount="2">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        2
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-3">
                                                <button id="btn_amount" class="btn btn-success btn-block btn-margin-bottom" data-amount="3">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        3
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-3">
                                                <button id="btn_amount" class="btn btn-success btn-block btn-margin-bottom" data-amount="4">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        4
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-3">
                                                <button id="btn_amount" class="btn btn-success btn-block btn-margin-bottom" data-amount="5">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        5
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-3">
                                                <button id="btn_amount" class="btn btn-success btn-block btn-margin-bottom" data-amount="6">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        6
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-3">
                                                <button id="btn_amount" class="btn btn-success btn-block btn-margin-bottom" data-amount="7">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        7
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-3">
                                                <button id="btn_amount" class="btn btn-success btn-block btn-margin-bottom" data-amount="8">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        8
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-3">
                                                <button id="btn_amount" class="btn btn-success btn-block btn-margin-bottom" data-amount="9">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        9
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-3">
                                                <button id="btn_amount" class="btn btn-success btn-block btn-margin-bottom" data-amount="0">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        0
                                                    </h3>
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-12">
                                                <button id="btn_amount" class="btn btn-danger btn-block btn-margin-bottom" data-amount="CLEAR">
                                                    <h3 style="white-space:normal; color: white; font-weight: 600;">
                                                        CLEAR
                                                    </h3>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="row">
                                                <div class="container-fluid">
                                                    <div class="col-xs-12 col-sm-6">
                                                        <h1>Amount Due :</h1>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-6">
                                                        <h1 id="mod_amount_due" class="pull-right" style="font-weight: 600;">0.00</h1>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="container-fluid">
                                                    <div class="col-xs-12 col-sm-6">
                                                        <h1>Tendered :</h1>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-6">
                                                        <h1 id="mod_tendered" class="pull-right" style="font-weight: 600;">0.00</h1>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="container-fluid">
                                                    <div class="col-xs-12 col-sm-6">
                                                        <h1>Change :</h1>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-6">
                                                        <h1 id="mod_change" class="pull-right" style="font-weight: 600;">0.00</h1>
                                                    </div>
                                                </div>
                                            </div><hr>
                                            <div class="row">
                                                <div class="container-fluid">
                                                    <button id="btn_pay" class="btn btn-primary btn-block">
                                                        <h3><strong>PAY</strong></h3>
                                                    </button>
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
        </div>
    </div>

    <!-- numeric formatter -->
    <script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
    <script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>

    <script type="text/javascript">
        (function(){
            var _btn_product;
            var _currentRow;
            var _customerID;
            var addedProductCodes = [];
            var tablesList = [];
            var currentCustomer;
            var btnTableClickCounter = 0;
            var tableCount = 0;

            var _amountDue = 0;
            var _amountTendered = 0;
            var _change = 0;
            var _posInvoiceID;

            toggleControls(true);

            $('#btn_enter_order').on('click', function(){
                if ($('#tbl_sales tbody tr').length > 0) {
                    var _data = $('#frm_items').serializeArray();

                    _data.push({name: "total_discount", value:$('#td_total_discount').text() });
                    _data.push({name: "before_tax", value: $('#td_total_before_tax').text() });
                    _data.push({name: "total_tax_amount", value: $('#td_total_tax').text() });
                    _data.push({name: "total_after_tax", value: $('#td_total_after_tax').text() });
                    _data.push({ name: "customer_id", value: currentCustomer });

                    $.each($('button#btn_table_trigger'), function(index, value){
                        if ($(this).data('table-click') == '1') {
                            _data.push({name: "table_id[]", value: $(this).data('table-id') });
                        }
                    });

                    $.ajax({
                        "dataType":"json",
                        "type":"POST",
                        "url":"Pos_v2/createInvoice",
                        "data":_data,
                        "beforeSend": showSpinningProgress($(this))
                    }).done(function(response){
                        showNotification(response);
                        toggleControls(true);
                        $('#tbl_sales tbody').html('');
                        resetSummary();
                        btnTableClickCounter = 0;
                        $('#order_title').html('PLEASE SELECT CUSTOMER...')

                    });
                } else {
                    showNotification({title: "Error!", msg: "No order to submit", stat: "error"})
                }
            });

            $('#btn_cancel_order').on('click',function(){
                if ($('#tbl_sales tbody tr').length > 0) {
                    var confirmation = confirm('Are you sure you want to cancel?');
                    if (confirmation == true) {
                        toggleControls(true);
                        $('#tbl_sales tbody').html('');
                        resetSummary();
                        btnTableClickCounter = 0;
                        $('#order_title').html('PLEASE SELECT CUSTOMER...');
                    }
                } else {
                    showNotification({title: "Error!", msg: "No order to cancel", stat: "error"})
                }
            });

            $('.btn-categories').on('click',function(){
                $.ajax({
                    "dataType":"json",
                    "url":"Pos_v2/getList/product-by-category/"+$(this).attr('id')
                }).done(function(data){
                    $('#product_container').html('');
                    $.each(data.response, function(index, value){
                        $('#product_container').append(
                            '<div class="col-xs-12 col-sm-4">' +
                                '<button ' + 
                                    'id="btn_product"'+ 
                                    'class="btn btn-success btn-block btn-wheight"'+
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
                                        '<h5> ₱ ' +
                                            value.sale_cost + 
                                        '</h5>' +
                                '</button>' +
                            '</div>'
                       );
                    });
                });

                $('.modal-title').html($(this).data('name'));
                $('#modal_products').modal('toggle');

            });

            $('#btn_unpaid').on('click', function(){
                $('.modal-title').html('UNPAID ORDERS');

                $.ajax({
                    "dataType":"json",
                    "url":"Pos_v2/getList/get-unpaid"
                }).done(function(data){
                    $('#tbl_unpaid tbody').html('');
                    $.each(data.response, function(index,value) {
                        $('#tbl_unpaid tbody').prepend(
                            '<tr>' + 
                                '<td>' + value.pos_invoice_no + '</td>' +
                                '<td>' + value.customer_name + '</td>' +
                                '<td>' + value.table_name + '</td>' +
                                '<td>' + accounting.formatNumber(value.total_after_tax,2) + '</td>' +
                                '<td>'+
                                    '<center>' +
                                        '<button id="btn_pay_order" class="btn btn-success" data-inv-id="'+value.pos_invoice_id+'" data-amount-due="'+value.total_after_tax+'">'+
                                            'BILL OUT'+
                                        '</button>&nbsp;'+
                                        '<button id="btn_add_order" class="btn btn-primary" data-inv-id="'+value.pos_invoice_id+'" data-amount-due="'+value.total_after_tax+'">'+
                                            'ADDITIONAL ORDER'+
                                        '</button>'+
                                    '</center>'+
                                '</td>' +
                            '</tr>' 
                        );
                    });
                });

                $('#modal_unpaid').modal('toggle');
            });

            $('#tbl_unpaid').on('click','#btn_pay_order',function(){
                $('.modal-title').html('PLEASE ENTER PAYMENT');
                $('#mod_amount_due').html(accounting.formatNumber($(this).data('amount-due'),2));
                _posInvoiceID = $(this).data('inv-id');
                $('#modal_payment').modal('show');
                $('#modal_unpaid').modal('hide');
            });

            $('#btn_pay').on('click',function(){
                if (_amountTendered !== 0) {
                    if (parseFloat(accounting.unformat($('#mod_tendered').text())) >= parseFloat(accounting.unformat($('#mod_amount_due').text()))) {
                        payOrder().done(function(response){
                            showNotification(response);
                            $('#mod_tendered').html('0.00');
                            $('#mod_change').html('0.00');
                            var _amountDue = 0;
                            var _amountTendered = 0;
                            var _change = 0;
                            $('#modal_payment').modal('toggle');
                        });
                    } else {
                        showNotification({title: "Error!", msg: "Cash Tendered must be greater or equal to amount due.", stat: "error"});
                    }
                } else {
                    showNotification({title: "Error!", msg: "No cash tendered.", stat: "error"});
                }
            });

            $('#modal_payment').on('click','#btn_amount', function(){

                if ($(this).data('amount') == 'CLEAR'){
                    _amountTendered = 0;
                    _change = 0;
                }
                else {
                    _amountTendered += parseFloat(accounting.unformat($(this).data('amount')));
                
                    var total_amount_due = parseFloat(accounting.unformat($('#mod_amount_due').text()));
                    var total_amount_tendered = parseFloat(accounting.unformat(_amountTendered));

                    if (total_amount_tendered > total_amount_due)
                        _change = total_amount_tendered - total_amount_due;
                }

                _amountDue = parseFloat(accounting.unformat($('#mod_amount_due').text()));

                $('#mod_change').html(accounting.formatNumber(_change,2));
                $('#mod_tendered').html(accounting.formatNumber(_amountTendered,2));
            });

            $('#modal_customers').on('click', '#btn_customer_trigger',function(){
                if ($(this).data('customer-id') != 0) {
                    $('#order_title').html('ORDER SUMMARY FOR ' + $(this).data('customer-name'));
                    $('#btn_tables').prop('disabled',false);
                    currentCustomer = $(this).data('customer-id');
                }
                else {
                    $('.modal-title').html('PLEASE ENTER CUSTOMER NAME')
                    $('#modal_new_customer').modal('show');
                    $('#frm_customers').find('input:first').focus();
                }

                $('#modal_customers').modal('hide');
            });

            $('#btn_customers').on('click',function(){
                $('.modal-title').html('CUSTOMERS');

                $.ajax({
                    "dataType":"json",
                    "url":"Customers/transaction/list"
                }).done(function(response){
                    $('#customer_container').html('');

                    $('#customer_container').append(
                        '<div class="col-xs-12 col-sm-3">' +
                            '<button ' + 
                                'id="btn_customer_trigger"'+ 
                                'class="btn btn-success btn-wood btn-block btn-wheight"'+
                                'style="border-radius: 0; margin-bottom: 25px;white-space:normal;"'+
                                'data-customer-id="0"' +
                                'data-customer-name="WALK-IN"' +
                                '>' + 
                                    '<span style="font-weight:500; font-size:25px;">' + 
                                        '<i class="fa fa-plus"></i>' + 
                                    '</span>' +
                            '</button>' +
                        '</div>'
                    );

                    $.each(response.data, function(index, value){
                        $('#customer_container').append(
                            '<div class="col-xs-12 col-sm-3">' +
                                '<button ' + 
                                    'id="btn_customer_trigger"'+ 
                                    'class="btn btn-warning btn-wood btn-block btn-wheight"'+
                                    'style="border-radius: 0; margin-bottom: 25px;white-space:normal;"'+
                                    'data-customer-id="'+value.customer_id+'"' +
                                    'data-customer-name="'+value.customer_name+'"' +
                                    '>' + 
                                        '<span style="font-weight:500; font-size:25px;">' + 
                                            value.customer_name + 
                                        '</span>' +
                                '</button>' +
                            '</div>'
                       );
                    });
                });

                $('#modal_customers').modal('toggle');
            });

            $('#tbl_sales tbody').on('click', '#btn_delete', function(){
                var confirmation = confirm('Are you sure you want to void this item?');

                if (confirmation == true) {
                    $(this).closest('tr').remove();
                    recomputeTotal();
                    initializeNumeric();

                    if ($('#tbl_sales tbody tr').length < 1) {
                        $('#btn_void').prop('disabled', true);
                    }
                }
            });

            $('#modal_tables').on('click','#btn_enter_table',function(){
                var tablesListArray = [];

                tablesList = [];

                $.each($('button#btn_table_trigger'), function(index, value){
                    if ($(this).data('table-click') == 1) {
                        tableCount += 1;
                        tablesList.push({name: "table_id", value: $(this).data('table-id') });
                        tablesListArray.push($(this).data('table-name'));
                    }
                });

                if (tablesListArray.length == 2)
                    $('#td_tables').html(tablesListArray.join(' & '));
                else 
                    $('#td_tables').html(tablesListArray.join(', '));

                if (tablesList.length > 0) {
                    $('#modal_tables').modal('toggle');
                    toggleControls(false);
                } else 
                    alert('Please Select Table...')


                if ($('#tbl_sales tbody tr').length == 0) {
                    $('#btn_void').prop('disabled',true);
                }
            });

            $('#btn_login').on('click', function(){
                validateUser().done(function(response){
                    if(response.stat=="success"){
                       $('.btn-remove').removeAttr('disabled');
                       showNotification({title: "Notification", msg: "Manager successfully authenticated", stat: "success"});
                       $('#btn_void').prop('disabled',true);
                       $('#modal_login').modal('toggle');
                    }
                });
            });

            $('#btn_save_customer').on('click', function(){
                if (validateRequiredFields($('#frm_customers'))) {
                    createCustomer().done(function(response){
                        showNotification(response);
                        clearFields($('#frm_customers'));
                        $('#modal_new_customer').modal('toggle');
                        _customerID = response.row_added[0].customer_id;
                        $('#order_title').html('ORDER SUMMARY FOR ' + response.row_added[0].customer_name);
                        $('#btn_tables').prop('disabled',false);
                        currentCustomer = _customerID;
                        $('.form-input').text('');
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }
            });

            $('#btn_void').on('click', function(){
                $('.modal-title').html('MANAGER LOGIN');
                $('#modal_login').modal('show');
                $('.form-input').text('');
            });

            $('#btn_tables').on('click',function(){
                $('.modal-title').html('TABLES');

                btnTableClickCounter += 1;

                if (btnTableClickCounter < 2) {
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
                                        'class="btn btn-warning btn-wood btn-block btn-wheight"'+
                                        'style="border-radius: 0; margin-bottom: 25px;white-space:normal;"'+
                                        'data-table-id="'+value.table_id+'"' +
                                        'data-table-name="'+value.table_name+'"' +
                                        'data-table-click="0"' +
                                        '>' + 
                                            '<h1>' + 
                                                value.table_name + 
                                            '</h1>' +
                                    '</button>' +
                                '</div>'
                           );
                        });
                    });
                }

                $('#modal_tables').modal('toggle');
            });

            $('#table_container').on('click','#btn_table_trigger',function(){
                var checked = '<h1><i class="fa fa-check"></i></h1>';
                var unchecked = '<h1>'+$(this).data('table-name')+'</h1>';

                if ($(this).html() == checked) {
                    $(this).html(unchecked)
                    $(this).data('table-click','0');
                } else {
                    $(this).html(checked)
                    $(this).data('table-click','1');
                }

            });

            $('#product_container').on('click','#btn_product',function(){
               _btn_product = $(this);

                AppendProductToTable();
                reComputeRowTotal();
                recomputeTotal();
                initializeNumeric();

                if ($('#tbl_sales tbody tr').length > 0) {
                    $('#btn_void').prop('disabled', false);
                }
            });

            $('#tbl_sales').on('change','input.numeric', function(){
                reComputeRowTotal();
                recomputeTotal();
            });

            $('#tbl_sales').on('change','input[name="pos_qty[]"]', function(){
                reComputeRowTotal();
                recomputeTotal();
            });

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
                                '<input class="numeric text-right form-control" type="text" value="0" name="tax_amount[]" readonly />'+
                            '</td>'+
                            '<td width="10%">'+
                                '<input id="total" class="numeric text-right form-control" type="text" value="0" name="total[]" readonly />'+
                            '</td>'+
                            '<td width="10%" class="text-center">'+
                            '<button type="button" id="btn_delete" class="btn btn-danger btn-remove" disabled>'+
                                '<i class="fa fa-times"></i>'+
                            '</button>'+
                            '</td>'+
                        '</tr>'
                    );

                    addedProductCodes.push(td_productCode);
                }
            };

            var validateUser=function(){
                var _data={uname : $('input[name="user_name"]').val() , pword : $('input[name="user_pword"]').val()};

                return $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Login/transaction/validate",
                    "data" : _data
                });
            };

            var arrayClean = function(thisArray, thisName) {
                "use strict";
                $.each(thisArray, function(index, item) {
                    if (item.value == thisName) {
                        delete tablesList[index];      
                    }
                });
            };

            var reComputeRowTotal = function() {
                $.each($('#tbl_sales tbody tr'), function(){
                    var rowQty = parseFloat(accounting.unformat($(this).find('td').find('input[name="pos_qty[]"]').val()));
                    var rowSrp = parseFloat(accounting.unformat($(this).find('td').find('input[name="pos_price[]"]').val()));
                    var rowDiscount = parseFloat(accounting.unformat($(this).find('td').find('input[name="pos_discount[]"]').val()));
                    var rowTax = parseFloat(accounting.unformat($(this).find('td').find('input[name="tax_rate[]"]').val()));
                    

                    if(rowDiscount>rowSrp){
                        showNotification({title:"Invalid",stat:"error",msg:"Discount must not greater than unit price."});
                        $(this).find('td').find('input[name="pos_discount[]"]').val('0.00');
                    } else {
                        var discounted_price = rowSrp - rowDiscount;
                        var line_total_discount = rowDiscount * rowQty;
                        var line_total = discounted_price * rowQty;
                        var net_vat = line_total * (rowTax / 100);
                        var vat_input = line_total - net_vat;

                        var rowTotal = (rowQty * rowSrp);
                        
                        if (rowTax == 0.00) {
                            $(this).find('td').find('input[name="tax_amount[]"]').val(accounting.formatNumber(0,2));
                        } else {
                            $(this).find('td').find('input[name="tax_amount[]"]').val(accounting.formatNumber(net_vat,2));
                        }

                        $(this).find('td').find('input[name="total[]"]').val(accounting.formatNumber(line_total,2));
                    }

                });
            };

            var recomputeTotal = function() {
                var totalAmount = 0;
                var totalDiscount = 0;
                var totalBeforeTax = 0;
                var totalAfterTax = 0;
                var totalTax = 0;

                $.each($('#tbl_sales tbody tr'), function(){
                    totalAmount += parseFloat(accounting.unformat($(this).find('td').find('input[name="total[]"]').val()));
                    totalDiscount += parseFloat(accounting.unformat($(this).find('td').find('input[name="pos_discount[]"]').val()));
                    totalTax += parseFloat(accounting.unformat($(this).find('td').find('input[name="tax_amount[]"]').val()));
                    totalBeforeTax = totalAmount - totalTax;
                });

                $('#td_total_after_tax').html(accounting.formatNumber(totalAmount,2));
                $('#td_total_before_tax').html(accounting.formatNumber(totalBeforeTax,2));
                $('#td_total_tax').html(accounting.formatNumber(totalTax,2));
                $('#td_total_discount').html(accounting.formatNumber(totalDiscount,2));
                $('#td_amount_due').html(accounting.formatNumber(totalAmount,2));
            };

            var initializeNumeric = function(){
                $('.numeric').autoNumeric('init');
            };

            var showSpinningProgress=function(e){
                $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
            };

            var clearFields=function(f){
                $('input,textarea,select',f).val('');
                $(f).find('input:first').focus();
            };

            var showNotification=function(obj){
                PNotify.removeAll(); //remove all notifications
                new PNotify({
                    title:  obj.title,
                    text:  obj.msg,
                    type:  obj.stat
                });
            };

            var resetSummary=function(){
                $('#td_tables').html('No selected');
                $('#td_change').html('0.00');
                $('#td_tendered').html('0.00');
                $('#td_amount_due').html('0.00');
                $('#td_total_discount').html('0.00');
                $('#td_total_tax').html('0.00');
                $('#td_total_before_tax').html('0.00');
                $('#td_total_after_tax').html('0.00');
            };

            var validateRequiredFields=function(f){
                var stat=true;
                $('div.form-group').removeClass('has-error');
                $('input[required],textarea[required],select[required]',f).each(function(){
                        if($(this).is('select')){
                            if($(this).val()==0 || $(this).val()==null || $(this).val()==undefined || $(this).val()==""){
                                showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                                $(this).closest('div.form-group').addClass('has-error');
                                $(this).focus();
                                stat=false;
                                return false;
                            }
                        }else{
                            if($(this).val()==""){
                                showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                                $(this).closest('div.form-group').addClass('has-error');
                                $(this).focus();
                                stat=false;
                                return false;
                            }
                        }
                });
                return stat;
            };

            function toggleControls(bValue) {
                $('.btn-categories').prop('disabled',bValue);
                $('.btn-util').prop('disabled',bValue);
                $('#btn_tables').prop('disabled',bValue);
            };

            var payOrder = function() {
                var _data = [];

                _data.push({name: "tendered", value: _amountTendered });
                _data.push({name: "amount_due", value: _amountDue });
                _data.push({name: "change", value: _change });
                _data.push({name: "pos_invoice_id", value: _posInvoiceID });

                return $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Pos_v2/payOrder",
                    "data":_data,
                    "beforeSend": showSpinningProgress($('#btn_pay'))
                });
            };

            var createCustomer = function() {
                var _data=$('#frm_customers').serializeArray();

                return $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Customers/transaction/create",
                    "data":_data,
                    "beforeSend": showSpinningProgress($('#btn_save_customer'))
                });
            };
        })();
    </script>
</body>
</html>