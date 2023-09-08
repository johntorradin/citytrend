<?php
	// Если в POST нет данных
	if(!$_POST['action']) 
		return;

	$action = $_POST['action'];

	require '../php/accountReg.php';

	$acc = new AccountReg;

	// Если нужен первый шаг
	if($action == 'start') {
		$fp = $_POST['fp'];

		$acc->htmlStep1($fp);

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

	// Если нужен второй шаг
	if($action == 'reg_step_2') {
		$acc->htmlStep2();

		return;
	}

	// Если нужно проверить капчу
	if($action == 'captcha_check') {
		$response = $_POST['response'];

		$acc->captchaCheck($response);

		return;
	}

	// Если нужно отправить письмо
	if($action == 'mail_send') {
		$email = $_POST['email'];

		$acc->mailSend($email);

		return;
	}

	// Если нужно проверить код подтверждения
	if($action == 'key_check') {
		$key = $_POST['key'];
		$name = $_POST['name'];
		$gender = $_POST['gender'];
		$login = $_POST['login'];
		$email = $_POST['email'];
		$password = $_POST['password'];

		$acc->finish($key, $name, $gender, $login, $email, $password);
		
		return;
	}
?>