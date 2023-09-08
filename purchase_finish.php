<?php 
	session_start();

	require 'php/config.php';
	require 'php/other.php';
	require 'php/purchaseReg.php';

	$config = new Config;
	$other = new Other;
	$purchase_reg = new PurchaseReg;
	$status = $purchase_reg->checkPayment();

	// Если платеж не прошел
	if($status != 'succeeded') {
		header('Location: ' . $config->site_url . 'page_404', true, 301);
	}

	// Если платеж прошел успешно
	else 
		$purchase_reg->dbUpdate();
?>



<!DOCTYPE html>
<html>
<head>
	<?php require 'includes/head.php'; ?>
	<link href="css/page_404.css" rel="stylesheet" type="text/css">
	<title> CityTrend - Завершение покупки </title>
	<meta name="description" content="">
  	<meta name="keywords" content="">
</head>
<body></body>
</html>