<?php
	session_start();
	
	require 'php/config.php';
	require 'php/other.php';
	require 'php/shoppingCart.php';
	require 'php/accountHeader.php';

	$config = new Config;
	$other = new Other;
	$shopcart = new ShoppingCart;
	$account = new AccountHeader;

	if($_POST['destroy']) 
		session_destroy();
?>



<!DOCTYPE html>
<html>
<head>
	<?php require 'includes/head.php'; ?>
	<link href="css/header.css" rel="stylesheet" type="text/css">
	<link href="css/content_katalog.css" rel="stylesheet" type="text/css">
	<link href="css/slider.css" rel="stylesheet" type="text/css">
	<link href="css/footer.css" rel="stylesheet" type="text/css">
	<title>CityTrend - Каталог товаров</title>
	<meta name="description" content="">
  <meta name="keywords" content="">
</head>
<body>
	<div class="container">
		<?php 
			require 'includes/header.php';
			require 'includes/content_katalog.php';
			require 'includes/footer.php';
			require 'includes/to_top_button.php';
			require 'includes/my_alert.php';
		?>
	</div>
</body>
</html>



<script src="libs/jquery/jquery.js"></script>
<script src="libs/jquery/jquery.touch.js"></script>
<script src="libs/jquery/jquery.swipe.js"></script>
<script src="libs/clientjs/client.min.js"></script>
<script src="js/search.js"></script>
<script src="js/shoppingCart.js"></script>
<script src="js/accountHeader.js"></script>
<script src="js/delivery.js"></script>
<script src="js/purchasesHeader.js"></script>
<script src="js/reviews.js"></script>
<script src="js/other.js"></script>
<script src="js/slider.js"></script>
<script src="js/katalog.js"></script>
<script src="js/itemsSelect.js"></script>



<script>
	var client = new ClientJS;
		
	// Когда страница загрузилась
	$(document).ready(function() {

		other.fingerprintCheck();

		shopcart.selectCount();

		account.selectUserInfo();

		katalog.itemsCountSelect();
		katalog.filtersSelect();
		katalog.filtersPricesSelect();
		katalog.itemsSelect();
		katalog.paginatorSet();

		// Когда просходит скролл по странице
		$(window).scroll(function() {
			other.toTopToggle();
			iselect.mainWatchedItems();
		});

		// Когда просходит нажатие мыши по документу
		$(document).mousedown(function(e){
			// Если клик по форме поиска или по контейнеру с результатами поиска, то ничего не происходит
			if(!$(e.target).closest('#search, #search_results').length) {
				search.hideBoxOnClick();
			}		

			// Если клик по фильтрам, то ничего не происходит
			if(!$(e.target).closest('.filters_filter').length) {
				katalog.hideFilters();
			}
		});
		
		// Когда просходит нажатие клавиши
		$(document).keyup(function(e) {
			// Когда нажата клавиша Escape
			if(e.key === "Escape" || e.keyCode === 27) {
				reviews.hideBoxOnEscape();
				purchases.hideBoxOnEscape();
				delivery.hideBoxOnEscape();
				search.hideBoxOnEscape();
				shopcart.hideBoxOnEscape();
				account.hideBoxesOnEscape();
				katalog.hideFilters();
				other.myAlertHide();
			}
		});

	});
</script>