<div class="content_katalog">
	<img class="katalog_back" src="../media/images/static/white_back.jpg">

	<!-- Блок "Хлебные крошки" и заголовок -->
	<div id="bread_crumbs" class="row no-gutters align-items-center bread_crumbs">
		<!-- Данные выводятся через ajax -->
	</div>

	<!-- Блок "Фильтры" -->
	<form action="#" id="katalog_form">
		<div id="katalog_filters" class="row no-gutters align-items-center katalog_filters">
			<!-- Данные выводятся через ajax -->
		</div>
	</form>

	<!-- Блок "Сортировать по" -->
	<div class="row no-gutters align-items-center katalog_sorts">
		<div class="sorts_title">
			<em class="fa fa-sort"></em> Сортировать по <em class="fa fa-angle-right"></em>
		</div>
		<div class="sorts_variable">
			<button onclick="katalog.sortChange($(this))" data-sort="популярность" id="sorts_first_btn" class="sorts_variable_btn sorts_variable_active_btn"><em class="fa fa-fire"></em> Популярности</button>
		</div>
		<div class="sorts_variable">
			<button onclick="katalog.sortChange($(this))" data-sort="рейтинг" class="sorts_variable_btn"><em class="fa fa-star"></em> Рейтингу</button>
		</div>
		<div class="sorts_variable">
			<button onclick="katalog.sortChange($(this))" data-sort="цена-вверх" class="sorts_variable_btn"><em class="fa fa-sort-amount-asc"></em> Возрастанию цены</button>
		</div>
		<div class="sorts_variable">
			<button onclick="katalog.sortChange($(this))" data-sort="цена-вниз" class="sorts_variable_btn"><em class="fa fa-sort-amount-desc"></em> Убыванию цены</button>
		</div>
		<div class="sorts_variable">
			<button onclick="katalog.sortChange($(this))" data-sort="новинки" class="sorts_variable_btn"><em class="fa fa-exclamation-circle"></em> Новинкам</button>
		</div>
	</div>

	<!-- Блок "Отсортированные вещи" -->
	<div id="sort_items" class="row no-gutters sort_items">
		<!-- Данные выводятся через ajax -->
	</div>

	<!-- Пагинатор -->
	<form action="#" id="paginator_form">
		<div id="paginator" class="row no-gutters justify-content-center paginator">
			<!-- Данные выводятся через ajax -->
		</div>
	</form>

	<!-- Слайдер "Вы смотрели" -->
	<div id="watched_items_slider" class="row no-gutters slider watched_items_slider">
		<!-- Данные выводятся через ajax -->
	</div>
</div>