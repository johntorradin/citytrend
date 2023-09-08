<?php
	$action = $_POST['action'];

	require '../php/accountHeader.php';

	$account = new AccountHeader;

	// Если нужно загрузить данные аккаунта
	if($action == 'selectUserInfo') {
		$fp = $_POST['fp'];

		$account->selectUserInfo($fp);
		
		return;
	}

	// Если нужно загрузить форму изменения данных
	if($action == 'edit_box_show') {
		$account->showEditBox();

		return;
	}

	// Если нужно проверить логин
	if($action == 'check_login') {
		$login = $_POST['login'];

		$account->checkLogin($login);

		return;
	}

	// Если нужно проверить email
	if($action == 'check_email') {
		$email = $_POST['email'];

		$account->checkEmail($email);

		return;
	}

	// Если нужно проверить пароль от аккаунта
	if($action == 'check_real_password') {
		$password = $_POST['password'];

		$account->checkRealPassword($password);

		return;
	}

	// Если нужно отобразить разметку подтверждения изменений
	if($action == 'edit_confirm') {
		$email = $_POST['email'];

		$account->editConfirm($email);

		return;
	}

	// Если нужен финиш
	if($action == 'edit_finish') {
		$key = $_POST['key'];
		$name = $_POST['name'];
		$login = $_POST['login'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		$password = $_POST['password'];

		$account->editFinish($key, $name, $login, $email, $address, $password);

		return;
	}

	// Если была загружена аватарка
	if(isset($_FILES['file'])) 
		$account->addAvatar();
?>