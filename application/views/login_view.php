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
      html {
        height:100%;
      }

      .form-control {
        height: 50px;
        font-size: 20px;
        border:none!important;
        border-bottom: 1px solid #ddd!important;
      }

      .form-control:focus {
        border-bottom-width: 3px!important;
      }

      .btn {
        height: 50px;
        font-size: 20px;
      }

      .panel {
        background: transparent!important;
      }

      body {
        margin:0;
      }

      .content {
        background-color:rgba(255,255,255,.8);
        border-radius:.25em;
        box-shadow:0 0 .25em rgba(0,0,0,.25);
        box-sizing:border-box;
        left:50%;
        padding:10vmin;
        position:fixed;
        text-align:center;
        top:50%;
        transform:translate(-50%, -50%);
      }

      h1 {
        font-family:monospace;
      }

      @keyframes slide {
        0% {
          transform:translateX(-25%);
        }
        100% {
          transform:translateX(25%);
        }
      }
    </style>

    </head>

    <body class="focused-form animated-content" style="background:#2196f3">

<div style="z-index: -9999999;">
    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>
</div>
<div class="container" id="login-form">
	<a href="index.html" class="login-logo"></a>
		<div class="row">
			<div class="col-md-4 col-md-offset-3">
				<div class="panel panel-default" style="width:500px;">
					<div class="panel-body">
            <center><h1 style="font-family: 'Segoe UI', sans-serif; font-weight: 400;">LOGIN <br><small style="color: #2196f3;">POINT OF SALES</small></h1></center><br>
            <form class="form-horizontal" id="validate-form">
              <div class="form-group mb-md">
                  <div class="col-xs-12">
  										<input name="user_name" type="text" class="form-control text-center" placeholder="Username" data-parsley-minlength="20" placeholder="At least 6 characters" required>
                  </div>
							</div>
							<div class="form-group mb-md">
                  <div class="col-xs-12">
  										<input name="user_pword" type="password" class="form-control text-center" id="exampleInputPassword1" placeholder="Password">
                  </div>
							</div>
						</form>
            <br>
            <br>
					</div>
					<div class="panel-footer">
						<div class="col-xs-12">
							<button id="btn_login" class="btn btn-primary ladda-button btn-block" data-style="expand-left" data-spinner-color="white" data-size="l"><span class=""></span> Login</button>
              <button id="btn_close_window" class="btn btn-danger ladda-button btn-block" data-style="expand-left" data-spinner-color="white" data-size="l"><span class=""></span> Close</button>
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

                        if(response.stat=="success" && response.user_group_id!=2){
                            setTimeout(function(){
                                window.location.href = "dashboard";
                            },600);
                        } else {
                            setTimeout(function(){
                                window.location.href = "pos_v2";
                            },600);
                        }

                    }).always(function(){
                        l.stop();
                    });


                });

                $('#btn_close_window').on('click', function(event){
                    window.open('Login/closekiosk','_self')
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
