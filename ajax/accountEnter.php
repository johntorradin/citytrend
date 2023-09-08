<?php
	// Если в POST нет данных
	if(!$_POST['action']) 
		return;

	$action = $_POST['action'];

	require '../php/accountEnter.php';

	$acc = new AccountEnter;

	// Если нужен первый шаг
	if($action == 'start') {
		$acc->htmlStep1();

		return;
	}

	// Если нужен второй шаг
	if($action == 'step_2') {
		$acc->htmlStep2();

		return;
	}

	// Если нужен третий шаг
	if($action == 'step_3') {
		$email = $_POST['email'];

		$acc->htmlStep3($email);

		return;
	}

	// Если нужно проверить логин
	if($action == 'check_login') {
		$login = $_POST['login'];

		$acc->checkLogin($login);

		return;
	}

	// Если нужно проверить email
	if($action == 'check_email') {
		$email = $_POST['email'];

		$acc->checkEmail($email);

		return;
	}

	// Если нужно проверить код подтверждения
	if($action == 'key_check') {
		$fingerprint = $_POST['fp'];
		$repair_key = $_POST['key'];
		$email = $_POST['email'];

		$acc->repairFinish($fingerprint, $repair_key, $email);

		return;
	}

	// Если нужно проверить капчу
	if($action == 'captcha_check') {
		$response = $_POST['response'];

		$acc->captchaCheck($response);

		return;
	}

	// Если нужен финиш
	if($action == 'finish') {
		$fingerprint = $_POST['fp'];
		$login = $_POST['login'];
		$password = $_POST['password'];

		$acc->finish($fingerprint, $login, $password);
		
		return;
	}
?>