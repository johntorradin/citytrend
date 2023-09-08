<?php
	// Если в POST нет данных
	if(!$_POST['action']) 
		return;

	require '../php/reviews.php';

	$reviews = new Reviews;

	// Если нужен первый шаг
	if($_POST['action'] == 'show_step_1') {
		$i_ak = $_POST['i_ak'];
		$i_id = $_POST['i_id'];
		$i_firm = $_POST['i_firm'];
		$i_name = $_POST['i_name'];

		$reviews->showStep1($i_ak, $i_id, $i_firm, $i_name);
	}

	// Если нужен второй шаг
	if($_POST['action'] == 'show_step_2') 
		$reviews->showStep2();

	// Если нужен третий шаг
	if($_POST['action'] == 'show_step_3') 
		$reviews->showStep3();

	// Если нужен финиш
	if($_POST['action'] == 'finish') {
		$ak = $_POST['ak'];
		$rating = $_POST['r'];
		$check = $_POST['check'];
		$adv = $_POST['adv'];
		$text = $_POST['t'];

		$reviews->finish($ak, $rating, $check, $adv, $text);
	}
?>