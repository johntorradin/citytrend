<?php
	require 'php/config.php';

	$config = new Config;
?>



<!DOCTYPE html>
<html>
<head>
	<?php require 'includes/head.php'; ?>
	<link href="css/sitemap.css" rel="stylesheet" type="text/css">
	<title> CityTrend - Карта сайта </title>
	<meta name="description" content="">
  <meta name="keywords" content="">
</head>
<body>
	<div class="container">
		<img src="media/images/static/white_back.jpg" class="sitemap_back">
		<div class="row no-gutters justify-content-center">
			<div class="sitemap_info">
				<div class="row no-gutters justify-content-center">
					<div class="col">
						<div class="row no-gutters justify-content-center">
							<a href="/" class="sitemap_link sitemap_link_main"><em class="fa fa-home"></em> Главная</a>
						</div>
					</div>
				</div>
				<div class="row no-gutters justify-content-center">
					<div class="col-12">
						<div class="row no-gutters align-items-center justify-content-center">
							<h1 class="sitemap_note">Найти товар:</h1>
						</div>
					</div>
					<div class="col-6 col-lg-3">
						<div class="row no-gutters align-items-center justify-content-center">
							<a href="/katalog?category=одежда" class="sitemap_link sitemap_link_second_line"><em class="fa fa-shopping-bag"></em> Одежда</a>
						</div>
					</div>
					<div class="col-6 col-lg-3">
						<div class="row no-gutters align-items-center justify-content-center">
							<a href="/katalog?category=обувь" class="sitemap_link sitemap_link_second_line"><em class="fa fa-shopping-bag"></em> Обувь</a>
						</div>
					</div>
					<div class="col-6 col-lg-3">
						<div class="row no-gutters align-items-center justify-content-center">
							<a href="/katalog?category=аксессуары" class="sitemap_link sitemap_link_second_line"><em class="fa fa-shopping-bag"></em> Аксессуары</a>
						</div>
					</div>
				</div>
				<div class="row no-gutters justify-content-center">
					<div class="col-12">
						<div class="row no-gutters align-items-center justify-content-center">
							<h1 class="sitemap_note">Разное:</h1>
						</div>
					</div>
					<div class="col-6 col-lg-3">
						<div class="row no-gutters align-items-center justify-content-start">
							<a href="/account_reg" class="sitemap_link"><em class="fa fa-user-circle-o"></em> Регистрация</a>
						</div>
					</div>
					<div class="col-6 col-lg-3">
						<div class="row no-gutters align-items-center justify-content-start">
							<a href="/account_enter" class="sitemap_link"><em class="fa fa-user-circle-o"></em> Авторизация</a>
						</div>
					</div>
					<div class="col-6 col-lg-3">
						<div class="row no-gutters align-items-center justify-content-start">
							<a href="/about_us" class="sitemap_link"><em class="fa fa-info"></em> О нас</a>
						</div>
					</div>
					<div class="col-6 col-lg-3">
						<div class="row no-gutters align-items-center justify-content-start">
							<a href="/rules" class="sitemap_link"><em class="fa fa-book"></em> Правила сайта</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php require 'includes/my_alert.php'; ?>
	</div>
</body>
</html>



<script src="libs/jquery/jquery.js"></script>
<script src="libs/clientjs/client.min.js"></script>
<script src="js/other.js"></script>



<script>
	var client = new ClientJS;
		
	// Когда страница загрузилась
	$(document).ready(function() {

		other.fingerprintCheck();

	});
</script>