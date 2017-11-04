<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="assets/plugins/spinner/dist/ladda-themeless.min.css">

    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">
   <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
	<?php echo $_def_css_files; ?>
</head>
	<body class="animated-content">

<?php echo $_top_navigation; ?>

	<div id="wrapper">
	    <div id="layout-static">

	        <?php echo $_side_bar_navigation;?>

	        <div class="static-content-wrapper white-bg">
	            <div class="static-content"  >
	                <div class="page-content"><!-- #page-content -->
	                    <div class="container-fluid">
	                        <div data-widget-group="group1">
	                            <div class="row">
	                                <div class="col-md-12">
	                                    <div id="div_card_list">
	                                        <div class="panel panel-default">
	                                            <div class="panel-body table-responsive" style="border-top: 3px solid #2196f3;">
	                                            <h1>Recipes</h1>
	                                            	<button id="btn_new" class="btn btn-primary" style="position: absolute; margin-top: 2px;"><i class="fa fa-plus"></i> New Recipe</button>
	                                                <table id="tbl_ingredients" class="table table-striped table-bordered" cellspacing="0" width="100%">
	                                                    <thead>
		                                                    <tr>
		                                                        <th>Ingredients</th>
		                                                        <th>Unit</th>
		                                                        <th>Action</th>
		                                                    </tr>
	                                                    </thead>
	                                                    <tbody>

	                                                    </tbody>
	                                                </table>
	                                            </div>
	                                            <div class="panel-footer"></div>
	                                        </div>
	                                    </div>

	                                </div>
	                            </div>
	                        </div>
	                        <div id="modal_ingredient" class="modal fade" role="dialog">
							  <div class="modal-dialog">
							    <!-- Modal content-->
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal">&times;</button>
							        <h4 class="modal-title">Ingredient Information</h4>
							      </div>
							      <div class="modal-body">
							        <div class="row">
							        	<div class="container-fluid">
							        		<form id="frm_ingredients">
								        		<label>
								        			<strong>* Ingredient Name :</strong>
								        		</label>
								        		<input type="text" name="ingredient_name" class="form-control" data-error-msg="Ingredient name is required" required>
								        		<label>
								        			<strong>* Ingredient Unit :</strong>
								        		</label>
								        		<select id="cbo_unit" name="ingredient_unit" class="form-control" data-error-msg="Ingredient unit is required" required>
								        			<?php foreach($units_list as $unit) { ?>
								        				<option value="<?php echo $unit->unit_id; ?>"><?php echo $unit->unit_name; ?></option>
								        			<?php } ?>
								        		</select>
							        		</form>
							        	</div>
							        </div>
							      </div>
							      <div class="modal-footer">
							      	<button id="btn_save" class="btn btn-primary">Save</button>
							        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							      </div>
							    </div>
							  </div>
							</div>
							<div id="modal_confirmation" class="modal fade" role="dialog">
							  <div class="modal-dialog">
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal">&times;</button>
							        <h4 class="modal-title">Confirmation</h4>
							      </div>
							      <div class="modal-body text-center">
							        <p>Are you sure you want to delete this ingredient?</p>
							      </div>
							      <div class="modal-footer">
							      	<button type="button" id="btn_yes" class="btn btn-primary">Yes</button>
							        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
							      </div>
							    </div>
							  </div>
							</div>
	                    </div> <!-- .container-fluid -->
	                </div> <!-- #page-content -->
	            </div>

	            <footer role="contentinfo">
	                <div class="clearfix">
	                    <ul class="list-unstyled list-inline pull-left">
	                    </ul>
	                    <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
	                </div>
	            </footer>

	        </div>
	    </div>
	</div>
	<?php echo $_def_js_files; ?>
	<script src="assets/plugins/spinner/dist/spin.min.js"></script>
	<script src="assets/plugins/spinner/dist/ladda.min.js"></script>

	<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
	<!-- Select2 -->
<script src="assets/plugins/select2/select2.full.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			var txnMode;
			var dt;
			var _selectedID;
			var _selectRowObj;
			var cboUnit;

			var initializeControls = function() {
				dt = $('#tbl_ingredients').DataTable({
					"dom": '<"toolbar">frtip',
		            "bLengthChange":false,
		            "ajax" : "Ingredients/getList/ingredients",
		            "columns": [

		                { targets:[0],data: "ingredient_name" },
		                { targets:[1],data: "unit_name" },
		                {
		                	class: 'text-center',
		                    targets:[2],
		                    render: function (data, type, full, meta){
		                        var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
		                        var btn_trash='<button class="btn btn-danger btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';

		                        return '<center>'+btn_edit+'&nbsp;'+btn_trash+'</center>';
		                    }
		                }
		            ]
				});

				cboUnit = $('#cbo_unit').select2();
				cboUnit.select2({ dropdownParent: "#modal_ingredient" });
			}();

			var bindEventHandlers = function() {
				$('#btn_new').on('click', function(){
					txnMode = "new";
					clearFields($('#frm_ingredients'));
					$('#btn_save').prop('disabled',false);
					$('#modal_ingredient').modal('show');
				});

				$('#tbl_ingredients tbody').on('click', 'button[name="edit_info"]', function(){
					txnMode="edit";
					$('#btn_save').prop('disabled',false);
		            $('#modal_ingredient').modal('show');
		            _selectRowObj=$(this).closest('tr');
		            var data=dt.row(_selectRowObj).data();
		            _selectedID=data.ingredient_id;

		            cboUnit.select2('val', data.ingredient_unit);

		            $('input,textarea,select').each(function(){
		                var _elem=$(this);
		                $.each(data,function(name,value){
		                    if(_elem.attr('name')==name){
		                        _elem.val(value);
		                    }
		                });
		            });
				});

				$('#tbl_ingredients tbody').on('click', 'button[name="remove_info"]', function(){
					_selectRowObj=$(this).closest('tr');
		            var data=dt.row(_selectRowObj).data();
		            _selectedID=data.ingredient_id;

					$('#modal_confirmation').modal('show');
				});

				$('#btn_yes').on('click', function(){
					removeIngredient().done(function(response){
						showNotification(response);
						dt.row(_selectRowObj).remove().draw();
						$('#modal_confirmation').modal('toggle');
					});
				});

				$('#btn_save').click(function(){
					if(validateRequiredFields($('#frm_ingredients'))) {
						if (txnMode == "new") {
							createIngredient().done(function(response){
								showNotification(response);
								dt.row.add(response.row_added[0]).draw();
								clearFields($('#frm_ingredients'));
							}).always(function(){
		                        showSpinningProgress($('#btn_save'));
		                    });
						} else {
							updateIngredient().done(function(response){
								showNotification(response);
								dt.row(_selectRowObj).data(response.row_updated[0]).draw();
								clearFields($('#frm_ingredients'));
							}).always(function(){
		                        showSpinningProgress($('#btn_save'));
		                    });
						}
						$('#modal_ingredient').modal('hide');
					}
				});


			}();

			var createIngredient=function() {
				var _data = $('#frm_ingredients').serializeArray();
				
				return $.ajax({
					"dataType":"json",
		            "type":"POST",
		            "url":"Ingredients/saveIngredients",
		            "data":_data,
		            "beforeSend": showSpinningProgress($('#btn_save'))
				});
			};

			var updateIngredient=function() {
				var _data = $('#frm_ingredients').serializeArray();
				_data.push({name: "ingredient_id", value: _selectedID });
				
				return $.ajax({
					"dataType":"json",
		            "type":"POST",
		            "url":"Ingredients/updateIngredients",
		            "data":_data,
		            "beforeSend": showSpinningProgress($('#btn_save'))
				});
			};

			var removeIngredient=function() {
				return $.ajax({
					"dataType":"json",
		            "type":"POST",
		            "url":"Ingredients/deleteIngredient",
		            "data": {ingredient_id : _selectedID}
				});
			};

		    var validateRequiredFields=function(f){
		        var stat=true;

		        $('div.form-group').removeClass('has-error');
		        $('input[required],textarea[required],select[required]',f).each(function(){

		            if($(this).is('select')){
		                if($(this).select2('val')==0||$(this).select2('val')==null){
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

		    var showSpinningProgress=function(e){
		    	$(e).prop('disabled',true);
		        $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
		    };

		    var clearFields=function(f){
		        $('input[required],textarea',f).val('');
		        $('form').find('input:first').focus();
		    };

		    var showNotification=function(obj){
		        PNotify.removeAll(); //remove all notifications
		        new PNotify({
		            title:  obj.title,
		            text:  obj.msg,
		            type:  obj.stat
		        });
		    };
		});
	</script>
</body>
</html>