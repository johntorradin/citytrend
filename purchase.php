<?php
	session_start();

	require 'php/config.php';
	require 'php/other.php';
	require 'php/purchaseReg.php';

	$config = new Config;
	$other = new Other;
	$purchase_reg = new PurchaseReg;

	// Если данные для платежа сформированы
	if($_SESSION['yookassa_sum'] != '') {
		$payment = $_SESSION['yookassa_payment'];

		header('Location: ' . $payment['confirmation']['confirmation_url'], true, 301);
	}
?>



<!DOCTYPE html>
<html>
<head>
	<?php require 'includes/head.php'; ?>
	<link href="css/header.css" rel="stylesheet" type="text/css">
	<link href="css/purchase.css" rel="stylesheet" type="text/css">
	<title>CityTrend - Покупка товаров</title>
	<meta name="description" content="">
	<meta name="keywords" content="">
</head>
<body>
	<div class="container">
		<div id="purchase_box">
			<form id="purchase_box_form" class="purchase_form" action="#">
				<!-- Шаг №1 -->
				<div id="purchase_step_1" class="purchase">
					<!-- Данные выводятся через ajax -->
				</div>
				<div id="purchase_step_2" class="purchase">
					<!-- Данные выводятся через ajax -->
				</div>
				<div id="purchase_step_3" class="purchase">
					<!-- Данные выводятся через ajax -->
				</div>
			</form>
		</div>

		<?php require 'includes/my_alert.php'; ?>
	</div>
</body>
</html>



<script src="libs/jquery/jquery.js"></script>
<script src="libs/clientjs/client.min.js"></script>
<script src="js/purchaseReg.js"></script>
<script src="js/other.js"></script>



<script>
	var client = new ClientJS;
	var purchase = new PurchaseReg;
		
	// Когда страница загрузилась
	$(document).ready(function() {

		other.fingerprintCheck();
		purchase.step_1();

		// Когда просходит нажатие клавиши
		$(document).keyup(function(e) {
			// Когда нажата клавиша Escape
			if(e.key === "Escape" || e.keyCode === 27) {
				other.myAlertHide();
			}
		});

	});
</script>