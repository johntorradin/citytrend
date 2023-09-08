<?php
	session_start();

	require 'php/config.php';
	require 'php/other.php';
	require 'php/adminPanel.php';

	$config = new Config;
	$other = new Other;
	$panel = new AdminPanel;
?>



<!DOCTYPE html>
<html>
<head>
	<?php require 'includes/head.php'; ?>
	<link href="css/header.css" rel="stylesheet" type="text/css">
	<link href="css/account.css" rel="stylesheet" type="text/css">
	<title> CityTrend - Панель администратора </title>
	<meta name="description" content="">
  	<meta name="keywords" content="">
</head>
<body>
	<div class="container">
		<?php $panel->checkUser(); ?>

		<?php require 'includes/my_alert.php'; ?>
	</div>
</body>
</html>



<script src="libs/jquery/jquery.js"></script>
<script src="js/admin_panel.js"></script>