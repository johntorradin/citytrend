<?php
	// Если в POST нет данных
	if(!$_POST['fp']) 
		return;

	require '../php/other.php';

	$other = new Other;

	$other->fingerprintCheck($_POST['fp']);
?>