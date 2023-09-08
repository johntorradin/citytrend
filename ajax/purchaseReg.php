<?php
	// Если в POST нет данных
	if(!$_POST['action']) 
		return;

	$action = $_POST['action'];

	require '../php/purchaseReg.php';

	$purchase_reg = new PurchaseReg;

	// Если нужно сохранить данные о покупке в сессию
	if($action == 'set_purchase') {
		$purchase = $_POST['purchase'];

		$purchase_reg->purchaseStringSave($purchase);
	}

	// Если нужно загрузить шаг №1
	if($action == 'step_1') 
		$purchase_reg->step_1();

	// Если нужно загрузить шаг №2
	if($action == 'step_2') 
		$purchase_reg->step_2();

	// Если нужно загрузить шаг №3
	if($action == 'step_3') 
		$purchase_reg->step_3();

	// Если нужно перенаправить на страницу оплаты
	if($action == 'finish') {
		$sum = $_POST['sum'];
		$address = $_POST['address'];
		$fp = $_POST['fp'];
		$purchase_reg->finish($sum, $address, $fp);
	}
?>