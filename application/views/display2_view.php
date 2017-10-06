<!DOCTYPE html>
<html>
<head>
	<title>Display</title>

	<link type="text/css" href="assets/css/bootstrap.css" rel="stylesheet">
	<link type="text/css" href="assets/css/animate.css" rel="stylesheet">
	<link type="text/css" href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">

	<link type="text/css" href="assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet">        <!-- Font Awesome -->
	<link type="text/css" href="assets/fonts/themify-icons/themify-icons.css" rel="stylesheet">              <!-- Themify Icons -->
	<link type="text/css" href="assets/css/styles.css" rel="stylesheet">                                     <!-- Core CSS with all styles -->

	<link type="text/css" href="assets/plugins/codeprettifier/prettify.css" rel="stylesheet">                <!-- Code Prettifier -->
	<link type="text/css" href="assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet">              <!-- iCheck -->
	<link href="assets/plugins/notify/pnotify.core.css" rel="stylesheet"> <!-- notification -->
	<style>
		.datepicker{z-index:9999 !important}

	</style>

	<?php echo $_def_js_files; ?>


	<style type="text/css">
		body {
			font-family: 'Segoe UI', sans-serif;
		}
	</style>
</head>
<body style="background-color: white; overflow-x: hidden;">

	<div class="row" style="background: #CC2F28;">
		<div class="container-fluid">
			<div class="col-xs-12 col-sm-6">
				<img src="<?php echo $company->logo_path; ?>" style="height: 100px;">
				<span style="color: white; font-weight: 700; font-size: 30px; text-transform: uppercase;">Customer : </span><span id="customer_name" style="color: white; font-weight: 300; font-size: 30px; text-transform: uppercase;"></span>
			</div>
			<div class="col-xs-12 col-sm-6 text-right">
				<span style="color: white; font-size: 25px;">ORDER SUMMARY</span><br>
				<span style="color: white; font-size: 25px;">TOTAL AMOUNT : ₱ <span id="total_amount">0.00</span></span>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="container-fluid" id="div_items">
		</div>
	</div>
<!-- numeric formatter -->
    <script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
    <script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>
	<script type="text/javascript">
		(function(){
			setInterval(function(){
				$.ajax({
					"url":"Display2/getProducts",
					"dataType":"json"
				}).done(function(response){
					if (response.data.length > 0) {
						$('#customer_name').html(response.data[0].customer_name);
						$('#total_amount').html((response.data[0].grand_total == null ? '0.00' : accounting.formatNumber(response.data[0].grand_total,2)));
						$('#div_items').html('');

						$.each(response.data, function(index,value){
							if (value.product_id !== null) {
								$('#div_items').append(
									'<div class="col-xs-12 col-sm-3 text-center" style="margin-top: 20px;">' + 
										'<img src="'+value.img_path+'" style="margin-left: 10px;  margin-right: 10px; height: 90px; width: 120px; border: 1px solid #ddd;"><br>' + 
										'<span style="font-weight: 700; font-size: 12px;">'+value.pos_qty+'x <br>'+value.product_desc+'</span><br>' +
										'<span style="font-weight: 700; font-size: 12px;"> ₱ '+value.total+'</span>' +
									'</div>'
								);
							}
						});
					} else {
						$('#customer_name').html('NONE');
						$('#total_amount').html('0.00');
						$('#div_items').html('');
					}
				});
			},1000);
		})();
	</script>
</body>
</html>