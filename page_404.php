<!DOCTYPE html>
<html>
<head>
	<?php require 'includes/head.php'; ?>
	<link href="css/page_404.css" rel="stylesheet" type="text/css">
	<title> CityTrend - Страница не найдена </title>
	<meta name="description" content="">
  <meta name="keywords" content="">
</head>
<body>
	<div class="container">
		<img src="media/images/static/white_back.jpg" class="page_404_back">
		<div class="row no-gutters justify-content-center page_404_box">
			<div>
				<div class="row no-gutters align-items-center">
					<div class="col-4">
						<img src="../media/images/static/error_smile.png" class="page_404_error_smile">
					</div>
					<div class="col-8">
						<span class="page_404_text">
							Упс...<br>
							Такой страницы не существует.
						</span>
						<div class="row no-gutters">
							<a href="/" class="rules_go_to_main">Вернуться на Главную</a>
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