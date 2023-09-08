<?php
	// Если в POST нет данных
	if(!$_POST['action']) 
		return;

	require '../php/delivery.php';

	$delivery = new Delivery;

	$fp = $_POST['fp'];

	if($_POST['action'] == 'selectItems') 
		$delivery->selectItems($fp);
?>