<?php
	require 'php/config.php';
	require 'php/other.php';
	
	$config = new Config;
	$other = new Other;
?>



<!DOCTYPE html>
<html>
<head>
	<?php require 'includes/head.php'; ?>
	<link href="css/about_us.css" rel="stylesheet" type="text/css">
	<title> О компании CityTrend</title>
	<meta name="description" content="">
	<meta name="keywords" content="">
</head>
<body>
	<div class="container">
		<img src="media/images/static/white_back.jpg" class="about_us_back">
		<div class="row no-gutters justify-content-center">
			<div class="about_us_info">
				<div class="row no-gutters">
					<a href="/" class="about_us_go_to_main">Вернуться на Главную</a>
				</div>
				<div class="row no-gutters">
					<h1 class="about_us_title">Контакты</h1>
				</div>
				<div class="row no-gutters">
					<div class="about_us_description">
						<div class="about_us_contact">
							<em class="fa fa-phone"></em> Телефон: <?php echo $config->telephone; ?>
						</div>
						<div class="about_us_contact">
							<em class="fa fa-envelope"></em> Email: <?php echo $config->email; ?>
						</div>
					</div>
				</div>
				<div class="row no-gutters">
					<h1 class="about_us_title">Немного слов о нашей компании</h1>
				</div>
				<div class="row no-gutters">
					<div class="col-12 col-lg-6 about_us_description">
						Мы - молодая компания из Воронежа, основанная в 2022 году. <br>
						В нашей команде молодые и энергичные люди, <br> 
						которые стремятся порадовать своих клиентов. <br>
						Мы предлагаем Вам приобрести у нас <br>
						отличные товары по привлекательным ценам! <br>
						Но что именно мы предлагаем?
					</div>
					<div class="col-12 col-lg-6">
						<img class="abous_us_photo" src="media/images/static/abous_us_photo.jpg">
					</div>
				</div>
				<div class="row no-gutters">
					<h1 class="about_us_title">Мы предлагаем</h1>
				</div>
				<div class="row no-gutters">
					<div class="col-12 col-lg-6 col-xl-4">
						<div class="row no-gutters">
							<a href="/katalog?category=одежда" class="about_us_link">
								<img src="media/images/static/about_us_item_1.jpg" class="about_us_items">
								<span>Качественную <br> одежду</span>
							</a>
						</div>
					</div>
					<div class="col-12 col-lg-6 col-xl-4">
						<div class="row no-gutters">
							<a href="/katalog?category=обувь" class="about_us_link">
								<img src="media/images/static/about_us_item_2.jpg" class="about_us_items">
								<span>Качественную <br> обувь</span>
							</a>
						</div>
					</div>
					<div class="col-12 col-lg-6 col-xl-4">
						<div class="row no-gutters">
							<a href="/katalog?category=аксессуары" class="about_us_link">
								<img src="media/images/static/about_us_item_3.jpg" class="about_us_items">
								<span>Роскошные <br> аксессуары</span>
							</a>
						</div>
					</div>
				</div>
				<div class="row no-gutters">
					<h1 class="about_us_title">Почему покупать у нас выгодно?</h1>
				</div>
				<div class="row no-gutters">
					<div class="about_us_description">
						<div class="about_us_advantage">
							<em class="fa fa-thumbs-up about_us_like"></em> <span>Мы закупаем товар напрямую от производителя.</span>
						</div>
						<div class="about_us_advantage">
							<em class="fa fa-thumbs-up about_us_like"></em> <span>Наценка на товар минимальная.</span>
						</div>
						<div class="about_us_advantage">
							<em class="fa fa-thumbs-up about_us_like"></em> <span>Мы тщательно следим за качеством каждой партии товара.</span>
						</div>
						<div class="about_us_advantage">
							<em class="fa fa-thumbs-up about_us_like"></em> <span>Мы постоянно проводим акции и предлагаем хорошие скидки!</span>
						</div>
					</div>
				</div>
				<div class="row no-gutters">
					<h1 class="about_us_title">CityTrend в цифрах</h1>
				</div>
				<div class="row no-gutters">
					<?php $other->aboutUsStats(); ?>
				</div>
				<div class="row no-gutters">
					<a href="/" class="about_us_go_to_main_2">Вернуться на Главную</a>
				</div>
			</div>
		</div>

		<?php require 'includes/to_top_button.php'; ?>
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

		// Когда просходит скролл по странице
		$(window).scroll(function() {
			other.toTopToggle();
		});

	});
</script>