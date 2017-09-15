<!DOCTYPE html>
<html>
<head>
	<title><?php echo $_title; ?></title>
	<?php echo $_def_css_files; ?>
	<?php echo $_def_js_files; ?>
    <link rel="stylesheet" href="assets/plugins/spinner/dist/ladda-themeless.min.css">
	<link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">
    <style type="text/css">
    	.toolbar{
            float: left;
        }

    </style>
</head>
<body class="animated-content">
	<?php echo $_top_navigation; ?>
	<div id="wrapper">
        <div id="layout-static">
        	<div class="static-content-wrapper white-bg">
                <div class="static-content"  >
                    <div class="page-content"><!-- #page-content -->
                    	<div class="container-fluid">
                    		<br>
                    		<div class="panel panel-default">
                    			<div class="panel-body" style="border-top: 5px solid #2196f3;">
                    				<h1>Tables Management</h1>
                    				<table id="tbl_tables" class="table table-bordered table-striped" width="100%">
                    					<thead style="background-color: #03a9f4; color: white;">
                    						<th>Table Name</th>
                    						<th>Table Orientation</th>
                                            <th>Table Type</th>
                    						<th align="center">Action</th>
                    					</thead>
                    					<tbody>
                    					</tbody>
                    				</table>
                    			</div>
                    		</div>
                    	</div>

                        <div id="modal_table" class="modal fade" role="dialog">
                          <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"><i class="fa fa-table"></i> Table</h4>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                    <div class="container-fluid">
                                        <form id="frm_tables">
                                            <div class="col-xs-12">
                                                <label>Table Name:</label>
                                            </div>
                                            <div class="col-xs-12" style="margin-bottom: 20px;">
                                                <input class="form-control" type="text" name="table_name" data-error-msg="Table name is required" required>
                                            </div>
                                            <div class="col-xs-12">
                                                <label>Table Type:</label>
                                            </div>
                                            <div class="col-xs-12" style="margin-bottom: 20px;">
                                                <select class="form-control" type="text" name="table_type_id">
                                                    <?php foreach($table_types as $table_type) { ?>
                                                        <option value="<?php echo $table_type->table_type_id; ?>"><?php echo $table_type->table_type; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-xs-12">
                                                <label>Table Orientation:</label>
                                            </div>
                                            <div class="col-xs-12" style="margin-bottom: 20px;">
                                                <select class="form-control" type="text" name="table_orientation">
                                                    <option value="Landscape">Landscape</option>
                                                    <option value="Portrait">Portrait</option>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button id="btn_save" type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content"><!---content-->
                                    <div class="modal-header">
                                        <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                                        <h4 class="modal-title"><span id="modal_mode"> </span>Confirmation</h4>
                                    </div>

                                    <div class="modal-body">
                                        <p id="modal-body-message">Are you sure you want to delete ?</p>
                                    </div>

                                    <div class="modal-footer">
                                        <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
                                        <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                    </div>
                                </div><!---content-->
                            </div>
                        </div><!---modal-->

                    </div>
                </div>   
            </div>
        </div>
    </div>
    <script src="assets/plugins/spinner/dist/spin.min.js"></script>
    <script src="assets/plugins/spinner/dist/ladda.min.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
    <script type="text/javascript">
    	(function(){
            var dt; var _txnMode; var _selectedID; var _selectRowObj;

    		dt = $('#tbl_tables').DataTable({
    			"bLengthChange":false,
    			"dom": '<"toolbar">frtip',
    			"language": {
    				"searchPlaceholder":"Search Tables"
    			},
                "ajax" : "Tables/transaction/list",
                "columns": [

                    { targets:[0],data: "table_name" },
                    { targets:[1],data: "table_orientation" },
                    { targets:[2],data: "table_type" },
                    {
                        targets:[3],
                        render: function (data, type, full, meta){
                            var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
                            var btn_trash='<button class="btn btn-danger btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';

                            return '<center>'+btn_edit+' '+btn_trash+'</center>';
                        }
                    }
                ]
    		});

    		var createToolBarButton=function(){
                var _btnNew='<button class="btn btn-primary"  id="btn_new" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="New category" >'+
                    '<i class="fa fa-table"></i> New Table</button>';
                $("div.toolbar").html(_btnNew);
            }();

            $('#btn_new').on('click',function(){
                clearFields();
                _txnMode = "new";
                $('#modal_table').modal('show');
            });

            $('#btn_save').on('click',function(){
                if(validateRequiredFields()){
                    if(_txnMode=="new"){
                        createTable().done(function(response){
                            showNotification(response);
                            dt.row.add(response.row_added[0]).draw();
                            clearFields();
                        }).always(function(){
                            $('#modal_table').modal('hide');
                            showSpinningProgress($('#btn_save'));
                        });
                    }else{
                        updateTable().done(function(response){
                            showNotification(response);
                            dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                            clearFields();
                        }).always(function(){
                            $('#modal_table').modal('hide');
                            showSpinningProgress($('#btn_save'));
                        });
                    }
                }
            });

            $('#tbl_tables tbody').on('click','button[name="edit_info"]',function(){
                _txnMode="edit";
                $('#modal_table').modal('show');
                _selectRowObj=$(this).closest('tr');
                var data=dt.row(_selectRowObj).data();
                _selectedID=data.table_id;

                $('input,textarea,select').each(function(){
                    var _elem=$(this);
                    $.each(data,function(name,value){
                        if(_elem.attr('name')==name){
                            _elem.val(value);
                        }
                    });
                });
            });

            $('#tbl_tables tbody').on('click','button[name="remove_info"]',function(){
                _selectRowObj=$(this).closest('tr');
                var data=dt.row(_selectRowObj).data();
                _selectedID=data.table_id;

                $('#modal_confirmation').modal('show');
            });

            $('#btn_yes').click(function(){
                removeTable().done(function(response){
                    showNotification(response);
                    dt.row(_selectRowObj).remove().draw();
                });
            });

            var validateRequiredFields=function(){
                var stat=true;

                $('div.form-group').removeClass('has-error');
                $('input[required],textarea','#frm_tables').each(function(){
                    if($(this).val()==""){
                        showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                        $(this).closest('div.form-group').addClass('has-error');
                        stat=false;
                        return false;
                    }
                });
                return stat;
            };

            var showNotification=function(obj){
                PNotify.removeAll();
                new PNotify({
                    title:  obj.title,
                    text:  obj.msg,
                    type:  obj.stat
                });
            };

            var createTable=function(){
                var _data=$('#frm_tables').serializeArray();

                return $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Tables/transaction/create",
                    "data":_data,
                    "beforeSend": showSpinningProgress($('#btn_save'))
                });
            };

            var updateTable=function(){
                var _data=$('#frm_tables').serializeArray();
                _data.push({name : "table_id" ,value : _selectedID});

                return $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Tables/transaction/update",
                    "data":_data,
                    "beforeSend": showSpinningProgress($('#btn_save'))
                });
            };

            var removeTable=function(){
                return $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Tables/transaction/delete",
                    "data":{table_id : _selectedID}
                });
            };

            var showSpinningProgress=function(e){
                $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
            };

            var clearFields=function(){
                $('input[required],textarea','#frm_tables').val('');
                $('form').find('input:first').focus();
            };

    	})();
    </script>    
</body>
</html>