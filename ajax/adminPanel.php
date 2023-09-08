<?php
	// Если в POST нет данных
	if(!$_POST['action']) 
		return;

	$action = $_POST['action'];

	require '../php/adminPanel.php';

	$panel = new AdminPanel;

	// Если нужно загрузить отзывы
	if($action == 'select_reviews') {
		$panel->selectReviews();

		return;
	}

	// Если нужно загрузить доставки
	if($action == 'select_deliverys') {
		$panel->selectDeliverys();

		return;
	}

	// Если нужно загрузить покупки
	if($action == 'select_purchases') {
		$panel->selectPurchases();

		return;
	}

	// Если нужно разрешить отзыв
	if($action == 'allow_review') {
		$id = $_POST['id'];
		$panel->allowReview($id);

		return;
	}

	// Если нужно подтвердить получение товара
	if($action == 'set_purchase') {
		$id = $_POST['id'];
		$panel->setPurchase($id);
	}
?>