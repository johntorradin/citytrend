<?php
	require 'php/config.php';

	$config = new Config;
?>



<!DOCTYPE html>
<html>
<head>
	<?php require 'includes/head.php'; ?>
	<link href="css/header.css" rel="stylesheet" type="text/css">
	<link href="css/account.css" rel="stylesheet" type="text/css">
	<title>CityTrend - Регистрация</title>
	<meta name="description" content="">
	<meta name="keywords" content="">
</head>
<body>
	<div class="container">
		<div id="account_reg">
			<form id="account_reg_form" action="#">
				<!-- Данные выводятся через ajax -->
			</form>
		</div>

		<?php require 'includes/my_alert.php'; ?>
	</div>
</body>
</html>



<script src="libs/jquery/jquery.js"></script>
<script src="libs/clientjs/client.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script src="js/other.js"></script>
<script src="js/accountReg.js"></script>



<script>
	var client = new ClientJS;
		
	// Когда страница загрузилась
	$(document).ready(function() {

		other.fingerprintCheck();

		// Когда просходит нажатие клавиши
		$(document).keyup(function(e) {
			// Когда нажата клавиша Escape
			if(e.key === "Escape" || e.keyCode === 27) {
				other.myAlertHide();
			}
		});

	});
</script>