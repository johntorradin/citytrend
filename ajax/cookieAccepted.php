<?php
	// Если в POST нет данных
	if(!$_POST['cookie']) 
		return;

	require '../php/other.php';

	$other = new Other;

	$other->cookieAccepted();
?>