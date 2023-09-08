<?php
	// Если в POST нет данных
	if(!$_POST['variable']) 
		return;

	$var = $_POST['variable'];

	require '../php/config.php';

	$config = new Config;

	echo $config->$var;
?>