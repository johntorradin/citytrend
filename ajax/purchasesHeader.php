<?php
	// Если в POST нет данных
	if(!$_POST['action']) 
		return;

	require '../php/purchasesHeader.php';

	$purchase = new PurchasesHeader;

	$fp = $_POST['fp'];

	// Если нужно загрузить товары
	if($_POST['action'] == 'selectItems') 
		$purchase->selectItems($fp);
?>