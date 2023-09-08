<?php
	// Если в POST нет данных
	if(!$_POST['action']) 
		return;

	$action = $_POST['action'];

	require '../php/item.php';

	$item = new Item;

	// Если нужно загрузить заголовок и начальную информацию
	if($action == 'select_title') {
		$id = $_POST['id'];

		$item->titleSelect($id);

		return;
	}

	// Если нужно загрузить слайдер фото
	if($action == 'select_slider') {
		$id = $_POST['id'];

		$item->photoSliderSelect($id);

		return;
	}

	// Если нужно загрузить цвета
	if($action == 'select_colors') {
		$id = $_POST['id'];

		$item->colorSelect($id);

		return;
	}

	// Если нужно загрузить размеры
	if($action == 'select_sizes') {
		$artikul = $_POST['artikul'];
		$color = $_POST['color'];

		$item->sizesSelect($artikul, $color);

		return;
	}

	// Если нужно загрузить характеристики и описание
	if($action == 'select_characters') {
		$id = $_POST['id'];

		$item->charactersSelect($id);

		return;
	}

	// Если нужно загрузить цену
	if($action == 'select_price') {
		$id = $_POST['id'];

		$item->priceSelect($id);

		return;
	}

	// Если нужно загрузить кол-во отзывов
	if($action == 'select_reviews_count') {
		$id = $_POST['id'];

		$item->reviewsCountSelect($id);

		return;
	}

	// Если нужно загрузить отзывы
	if($action == 'select_reviews') {
		$id = $_POST['id'];
		$sort = $_POST['sort'];
		$offset = $_POST['offset'];

		$item->reviewsSelect($id, $sort, $offset);

		return;
	}

	// Если нужно загрузить похожие вещи
	if($action == 'select_similar') {
		$category = $_POST['category'];
		$type = $_POST['type'];

		$item->similarItemsSelect($category, $type);

		return;
	}

	// Если нужно добавить товар в список просмотренных
	if($action == 'add_to_watched') {
		$id = $_POST['id'];
		$fingerprint = $_POST['fingerprint'];

		$item->addItemToWatched($id, $fingerprint);

		return;
	}

	// Если нужно добавить товар в корзину
	if($action == 'add_to_cart') {
		$fingerprint = $_POST['fingerprint'];
		$artikul = $_POST['artikul'];
		$color = $_POST['color'];
		$size = $_POST['size'];

		$item->addItemToCart($fingerprint, $artikul, $color, $size);
	}
?>