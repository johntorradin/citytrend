<?php
	// Если в POST нет данных
	if(!$_POST['action']) 
		return;

	$action = $_POST['action'];

	require '../php/katalog.php';

	$katalog = new Katalog;

	// Если нужно получить кол-во вещей
	if($action == 'select_items_count') {
		$category = $_POST['category'];
		$gender = $_POST['gender'];
		$type = $_POST['type'];
		$season = $_POST['season'];
		$firm = $_POST['firm'];
		$material = $_POST['material'];
		$min_price = $_POST['min_price'];
		$max_price = $_POST['max_price'];

		$katalog->selectItemsCount($category, $gender, $type, $season, $firm, $material, $min_price, $max_price);

		return;
	}

	// Если нужно загрузить фильтры
	if($action == 'select_filters') {
		$category = $_POST['category'];

		$katalog->filtersSelect($category);

		return;
	}

	// Если нужно загрузить минимальную и максимальную цену в фильтры
	if($action == 'select_filters_prices') {
		$category = $_POST['category'];

		$katalog->filtersPricesSelect($category);

		return;
	}

	// Если нужно выбрать товары
	if($action == 'select_items') {
		$category = $_POST['category'];
		$gender = $_POST['gender'];
		$type = $_POST['type'];
		$season = $_POST['season'];
		$firm = $_POST['firm'];
		$material = $_POST['material'];
		$min_price = $_POST['min_price'];
		$max_price = $_POST['max_price'];
		$sort = $_POST['sort'];
		$page = $_POST['page'];

		$katalog->selectItems($category, $gender, $type, $season, $firm, $material, $min_price, $max_price, $sort, $page);

		return;
	}

	// Если нужно загрузить пагинатор
	if($action == 'paginator_set') {
		$rows = $_POST['rows'];
		$page = $_POST['page'];

		$katalog->paginatorSet($rows, $page);

		return;
	}
?>