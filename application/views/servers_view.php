<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <title><?php echo $title; ?></title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="description" content="Avenxo Admin Theme">
    <meta name="author" content="">

    <?php echo $_def_css_files; ?>

    <link rel="stylesheet" href="assets/plugins/spinner/dist/ladda-themeless.min.css">

    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">

    <style>

        .toolbar{
            float: left;
        }

        td.details-control {
            background: url('assets/img/Folder_Closed.png') no-repeat center center;
            cursor: pointer;
        }
        tr.details td.details-control {
            background: url('assets/img/Folder_Opened.png') no-repeat center center;
        }

        .child_table{
            padding: 5px;
            border: 1px #ff0000 solid;
        }

        .glyphicon.spinning {
            animation: spin 1s infinite linear;
            -webkit-animation: spin2 1s infinite linear;
        }

        @keyframes spin {
            from { transform: scale(1) rotate(0deg); }
            to { transform: scale(1) rotate(360deg); }
        }

        @-webkit-keyframes spin2 {
            from { -webkit-transform: rotate(0deg); }
            to { -webkit-transform: rotate(360deg); }
        }

    </style>

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
                                            <h1>Servers</h1>
                                                <table id="tbl_servers" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Server Code</th>
                                                        <th>Server</th>
                                                        <th><center>Action</center></th>
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
                    </div> <!-- .container-fluid -->

                </div> <!-- #page-content -->
            </div>

            <div id="modal_server" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 id="category_title" class="modal-title"><span id="modal_mode">Server Information</span></h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <form id="frm_server" role="form">
                                    <div class="col-xs-12">
                                        <label><b>* Server Code :</b></label><br>
                                        <input class="form-control" type="text" name="server_code" data-error-msg="Server Code is required" required>
                                    </div><br>
                                    <div class="col-xs-12">
                                        <label><b>* Server Name :</b></label><br>
                                        <input type="text" name="server_name" class="form-control" data-error-msg="Server name is required" required>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="btn_save" class="btn btn-primary" name="btn_save">Save</button>
                            <button id="btn_cancel" class="btn btn-default">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-sm">
                    <div class="modal-content"><!---content-->
                        <div class="modal-header">
                            <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title"><span id="modal_mode"> </span>Confirm Deletion</h4>
                        </div>

                        <div class="modal-body">
                            <p id="modal-body-message">Are you sure ?</p>
                        </div>

                        <div class="modal-footer">
                            <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
                            <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                    </div><!---content-->
                </div>
            </div><!---modal-->

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


<?php echo $_switcher_settings; ?>
<?php echo $_def_js_files; ?>

<script src="assets/plugins/spinner/dist/spin.min.js"></script>
<script src="assets/plugins/spinner/dist/ladda.min.js"></script>

<!-- Select2 -->
<script src="assets/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

<script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj;

    var initializeControls=function(){

        dt=$('#tbl_servers').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "ajax" : "Servers/getList/servers",
            "columns": [

                { targets:[0],data: "server_code" },
                { targets:[1],data: "server_name" },
                {
                    targets:[2],
                    render: function (data, type, full, meta){
                        var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
                        var btn_trash='<button class="btn btn-danger btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';

                        return '<center>'+btn_edit+' '+btn_trash+'</center>';
                    }
                }
            ]
        });

        var createToolBarButton=function(){
            var _btnNew='<button class="btn btn-primary"  id="btn_new" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="New Server" >'+
                '<i class="fa fa-child"></i> New Server</button>';
            $("div.toolbar").html(_btnNew);
        }();
    }();

    var bindEventHandlers=(function(){
        var detailRows = [];

        $('#tbl_servers tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dt.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );

            if ( row.child.isShown() ) {
                tr.removeClass( 'details' );
                row.child.hide();

                detailRows.splice( idx, 1 );
            }
            else {
                tr.addClass( 'details' );

                row.child( format( row.data() ) ).show();

                if ( idx === -1 ) {
                    detailRows.push( tr.attr('id') );
                }
            }
        } );

        $('#btn_new').click(function(){
            _txnMode="new";
            $('#modal_server').modal('show');
            clearFields('#frm_server');
            showList(true);
        });

        $('#tbl_servers tbody').on('click','button[name="edit_info"]',function(){
            _txnMode="edit";
            $('#modal_server').modal('show');
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.server_id;

            $('input,textarea').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name){
                        _elem.val(value);
                    }
                });
            });
            showList(true);
        });

        $('#tbl_servers tbody').on('click','button[name="remove_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.server_id;

            $('#modal_confirmation').modal('show');
        });

        $('#btn_yes').click(function(){
            removeServer().done(function(response){
                showNotification(response);
                dt.row(_selectRowObj).remove().draw();
            });
        });

        $('#btn_cancel').click(function(){
            $('#modal_server').modal('toggle');
        });

        $('#btn_save').click(function(){
            if(validateRequiredFields()){
                if(_txnMode=="new"){
                    createServer().done(function(response){
                        showNotification(response);
                        dt.row.add(response.row_added[0]).draw();
                    }).always(function(){
                        $('#modal_server').modal('toggle');
                        showSpinningProgress($('#btn_save'));
                    });
                }else{
                    updateServer().done(function(response){
                        showNotification(response);
                        dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                    }).always(function(){
                        $('#modal_server').modal('toggle');
                        showSpinningProgress($('#btn_save'));
                    });
                }
            }
        });
    })();

    var validateRequiredFields=function(){
        var stat=true;

        $('div.form-group').removeClass('has-error');
        $('input[required],textarea','#frm_server').each(function(){
            if($(this).val()==""){
                showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                $(this).closest('div.form-group').addClass('has-error');
                stat=false;
                return false;
            }
        });
        return stat;
    };

    var createServer=function(){
        var _data=$('#frm_server').serializeArray();

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Servers/InsertServer",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var updateServer=function(){
        var _data=$('#frm_server').serializeArray();
        _data.push({name : "server_id" ,value : _selectedID});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Servers/UpdateServer",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var removeServer=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Servers/RemoveServer",
            "data":{server_id : _selectedID}
        });
    };

    var showList=function(b){
        if(b){
            $('#div_card_list').show();
            $('#div_card_fields').hide();
        }else{
            $('#div_card_list').hide();
            $('#div_card_fields').show();
        }
    };

    var showNotification=function(obj){
        PNotify.removeAll();
        new PNotify({
            title:  obj.title,
            text:  obj.msg,
            type:  obj.stat
        });
    };

    var showSpinningProgress=function(e){
        $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
    };

    var clearFields=function(){
        $('input[required],textarea','#frm_server').val('');
        $('form').find('input:first').focus();
    };

    function format ( d ) {
        return '<br /><table style="margin-left:10%;width: 80%;">' +
        '<thead>' +
        '</thead>' +
        '<tbody>' +
        '<tr>' +
        '<td>Card Name : </td><td><b>'+ d.card_name+'</b></td>' +
        '</tr>' +
        '</tbody></table><br />';
    };
});

</script>

</body>

</html>