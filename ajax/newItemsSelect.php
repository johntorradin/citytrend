<?php
	// Если в POST нет данных
	if(!$_POST['variable']) 
		return;

	require '../php/itemsSelect.php';

	$iselect = new ItemsSelect;

	$iselect->mainNewItems();
?>