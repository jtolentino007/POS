<!DOCTYPE html>
<html lang="en" class="coming-soon">


<head>
    <meta charset="utf-8">
    <title>Login Form</title>


    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="author" content="">

    <?php echo $_def_css_files; ?>

    <link rel="stylesheet" href="assets/plugins/spinner/dist/ladda-themeless.min.css">


    <style>

    </style>

    </head>

    <body class="focused-form animated-content">


<div class="container" id="login-form">
	<a href="index.html" class="login-logo"></a>
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-body" style="border-top:5px solid #2196f3; padding-bottom: 50px;">
            <center><h1>LOGIN <br><small><b>POINT OF SALES</b></small></h1></center><br>
            <form class="form-horizontal" id="validate-form">
              <div class="form-group mb-md">
                  <div class="col-xs-12">
                  	<div class="input-group">
  										<span class="input-group-addon">
  											<i class="ti ti-user"></i>
  										</span>
  										<input name="user_name" type="text" class="form-control" placeholder="Username" data-parsley-minlength="20" placeholder="At least 6 characters" required>
					          </div>
                  </div>
							</div>
							<div class="form-group mb-md">
                  <div class="col-xs-12">
                  	<div class="input-group">
  										<span class="input-group-addon">
  											<i class="ti ti-key"></i>
  										</span>
  										<input name="user_pword" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  									</div>
                  </div>
							</div>
						</form>
					</div>
					<div class="panel-footer">
						<div class="col-xs-12">
							<button id="btn_login" class="btn btn-primary ladda-button btn-block" data-style="expand-left" data-spinner-color="white" data-size="l"><span class=""></span> Login</button>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>

<?php echo $_def_js_files; ?>

<script src="assets/plugins/spinner/dist/spin.min.js"></script>
<script src="assets/plugins/spinner/dist/ladda.min.js"></script>



    <script>
        $(document).ready(function(){


            var bindEventHandlers=(function(){

                $('#btn_login').click(function(){

                    var l = Ladda.create(this);
                    l.start();


                    validateUser().done(function(response){

                        showNotification(response);

                        if(response.stat=="success"){
                            setTimeout(function(){
                                window.location.href = "dashboard";
                            },600);
                        }

                    }).always(function(){
                        l.stop();
                    });


                });


                $('input').keypress(function(evt){
                    if(evt.keyCode==13){ $('#btn_login').click(); }
                });


            })();



            var validateUser=(function(){
                var _data={uname : $('input[name="user_name"]').val() , pword : $('input[name="user_pword"]').val()};

                return $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Login/transaction/validate",
                    "data" : _data,
                    "beforeSend": function(){

                    }
                });
            });


            var showNotification=function(obj){
                PNotify.removeAll(); //remove all notifications
                new PNotify({
                    title:  "Notification",
                    text:  obj.msg,
                    type:  obj.stat
                });
            };




        });
    </script>


</body>

<!-- Mirrored from avenxo.kaijuthemes.com/extras-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 06 Jun 2016 12:14:53 GMT -->
</html>
