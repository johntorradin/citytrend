<?php
	// Если в GET нет данных
	if(!$_GET['text']) 
		return;

	require '../php/search.php';

	$search = new Search;

	$text = $_GET['text'];

	$search->itemsSelect($text);
?>