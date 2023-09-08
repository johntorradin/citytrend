<div id="header" class="header">

	<!-- Линия с рекламой -->
	<div class="row no-gutters justify-content-end header_marketing_line">
		<div class="col-12">
			<h3 class="animate-charcter"><?php echo $config->header_news; ?></h3>
		</div>
	</div>

	<!-- Логотип, поиск и кнопки управления -->
	<div class="row no-gutters align-items-center">
		<div class="col-12 col-lg-3">
			<div class="row no-gutters align-items-center logo">
				<a class="logo " href="/">
					<div class="row no-gutters align-items-center">
						<img class="logo" src="../media/images/static/logo.png">
					</div>
				</a>
			</div>
		</div>
		<div class="col-12 col-lg-5">
			<div class="row no-gutters align-items-center search">
				<form id="search" action="#">
					<div class="row no-gutters align-items-center">
						<em id="search_icon" class="fa fa-search search_icon"></em>
						<input onchange="search.itemsSelect(this.value)" id="search_field" class="search_field" type="text" name="search_field" placeholder="Я ищу..." autocomplete="off" maxlength="40">
						<em id="search_close_icon" class="fa fa-times search_close_icon"></em>
					</div>
				</form>
				<!-- Контейнер с результатами поиска -->
				<div id="search_results" class="search_results">
					<div id="search_results_content" class="search_results_content">
						<!-- Начальный html -->
						<div class="search_results_is_null">
							<div class="row no-gutters align-items-center search_results_is_start">
								Введите запрос и здесь отобразятся результаты поиска...
							</div>
						</div>
						<!-- Данные выводятся через ajax -->
					</div>
				</div>	
			</div>
		</div>
		<!-- Меню с кнопками корзины, доставок и профиля -->
		<div class="col-12 col-lg-4">
			<div class="row no-gutters align-items-center justify-content-end header_right_nav">
				<button onclick="shopcart.selectItems()" id="shopping_cart_open_btn" class="header_user_button" href="#">
					<div class="row no-gutters align-items-center">
						<em class="fa fa-shopping-cart header_right_nav_icon"></em>Корзина
						<!-- Данные выводятся через ajax -->
					</div>
				</button>
				<button onclick="account.showBox()" id="user_info_open_btn" class="header_user_button" href="#">
					<div class="row no-gutters align-items-center">
						<em class="fa fa-user-circle-o header_right_nav_icon"></em>Профиль
					</div>
				</button>
			</div>
		</div>
	</div>

	<!-- Контейнер с корзиной пользователя -->
	<div id="shopping_cart_box">
		<div onclick="shopcart.hideBoxOnClick()" id="shopping_cart_box_popup" class="box_popup"></div>
		<div class="shopping_cart_box">
			<form action="#" id="shopping_cart_form">
				<!-- Данные выводятся через ajax -->
			</form>
		</div>
	</div>

<!-- Контейнер с данными о пользователе -->
<div id="user_info_box">
	<div onclick="account.hideBoxOnClick()" id="user_info_box_popup" class="box_popup"></div>
	<div class="user_info_box">
		<form action="?" method="POST" id="user_info_form">
			<button onclick="account.hideBoxOnClick(); return false" id="user_info_box_close" class="box_close"><em class="fa fa-times"></em></button>
		</form>
	</div>
</div>

<!-- Контейнер-форма изменения данных об аккаунте -->
<div id="user_info_edit">
	<div onclick="account.hideEditBox()" id="user_info_edit_popup" class="box_popup"></div>
	<div class="user_info_edit">
		<form action="#" id="user_info_edit_form">
			<button onclick="account.hideEditBox()" id="user_info_edit_close" class="box_close"><em class="fa fa-times"></em></button>
			<!-- Данные выводятся через ajax -->
		</form>
	</div>
</div>

<!-- Контейнер с доставками пользователя -->
<div id="delivery_box">
	<div onclick="delivery.hideBoxOnClick()" id="delivery_box_popup" class="box_popup"></div>
	<div class="delivery_box">
		<button onclick="delivery.hideBoxOnClick()" id="delivery_box_close" class="box_close"><em class="fa fa-times"></em></button>
		<!-- Данные выводятся через ajax -->
		</div>
	</div>

	<!-- Контейнер с покупками пользователя -->
	<div id="purchases_box">
		<div onclick="purchases.hideBoxOnClick()" id="purchases_box_popup" class="box_popup"></div>
		<div class="purchases_box">
			<button onclick="purchases.hideBoxOnClick()" id="purchases_box_close" class="box_close"><em class="fa fa-times"></em></button>
			<!-- Данные выводятся через ajax -->
		</div>
	</div>

	<!-- Контейнер c формой оставления отзыва -->
	<div id="review_form_box">
		<div onclick="reviews.hideBoxOnClick()" id="review_form_box_popup" class="box_popup"></div>
		<div class="review_form_box">
			<form action="#" id="add_review_form">
				<button onclick="reviews.hideBoxOnClick()" id="review_form_box_close" class="box_close"><em class="fa fa-times"></em></button>
				<!-- Данные выводятся через ajax -->
			</form>
		</div>
	</div>

	<!-- Меню, навигация-->
	<div class="row no-gutters align-items-center">
		<ul class="header_nav">
			<li><a id="header_nav_link_first" class="header_nav_link" href="/">Главная</a></li>
			<li><a class="header_nav_link" href="/katalog?category=одежда">Одежда</a></li>
			<li><a class="header_nav_link" href="/katalog?category=обувь">Обувь</a></li>
			<li><a class="header_nav_link" href="/katalog?category=аксессуары">Аксессуары</a></li>
			<li><a class="header_nav_link" href="/sitemap">Карта сайта</a></li>
			<li><a class="header_nav_link" href="/about_us">О нас</a></li>
			<li><a class="header_nav_link" href="/rules">Правила сайта</a></li>
		</ul>
	</div>
</div>