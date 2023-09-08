<?php
	// Если в POST нет данных
	if(!$_POST['fp']) 
		return;

	require '../php/itemsSelect.php';

	$iselect = new ItemsSelect;

	$iselect->watchedItems($_POST['fp']);
?>