<?php
	// Если в POST нет данных
	if($_POST['offset'] == '') 
		return;

	require '../php/itemsSelect.php';

	$iselect = new ItemsSelect;

	$iselect->mainDiscountedItemsMore($_POST['offset']);
?>