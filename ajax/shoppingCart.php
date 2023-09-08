<?php
	// Если в POST нет данных
	if(!$_POST['action']) 
		return;

	require '../php/shoppingCart.php';

	$shopcart = new ShoppingCart;

	// Если нужно кол-во вещей в корзине
	if($_POST['action'] == 'selectCount') {
		$fp = $_POST['fp'];
		$shopcart->selectCount($fp);
	}

	// Если нужны товары корзины
	if($_POST['action'] == 'selectItems') {
		$fp = $_POST['fp'];
		$shopcart->selectItems($fp);
	}

	// Если нужно удалить товар
	if($_POST['action'] == 'deleteItem') {
		$fp = $_POST['fp'];
		$artikul = $_POST['artikul'];
		$color = $_POST['color'];
		$size = $_POST['size'];
		$shopcart->deleteItem($fp, $artikul, $size, $color);
	}

	// Если нужно уменьшить кол-во товара
	if($_POST['action'] == 'item_minus') {
		$fp = $_POST['fp'];
		$artikul = $_POST['artikul'];
		$color = $_POST['color'];
		$size = $_POST['size'];
		$shopcart->itemCountMinus($fp, $artikul, $size, $color);
	}

	// Если нужно увеличить кол-во товара
	if($_POST['action'] == 'item_plus') {
		$fp = $_POST['fp'];
		$artikul = $_POST['artikul'];
		$color = $_POST['color'];
		$size = $_POST['size'];
		$shopcart->itemCountPlus($fp, $artikul, $size, $color);
	}
?>