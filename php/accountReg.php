<?php
	// Класс "Регистрация аккаунта" (#class)
	class AccountReg {



		// Вывод начального html для действия "регистрация" (#1)
		function htmlStep1($fp) {
			session_start();
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$html = 
<<<_END
<div id="account_reg_step_1" class="account_reg">
	<div class="row no-gutters justify-content-start">
		<div class="col-12">
			<div class="row no-gutters align-items-center justify-content-start">
				<h1 onclick="account.finish()" class="account_data_line_title">Регистрация</h1>
				<h1 class="account_data_line_note">Для регистрации нового аккаунта, заполните все поля.</h1>
			</div>
		</div>
		<div class="col-12">
			<div class="account_data_line">
				<div class="row no-gutters align-items-center justify-content-start">
					<div class="col-2 account_data_title">
						<em class="fa fa-user-o"></em> Имя:
					</div>
					<div class="col-8">
						<input onchange="account.nameCheck(this.value)" id="account_field_1" class="account_field" maxlength="30" type="text" placeholder="Введите здесь Ваше имя...">
					</div>
				</div>
			</div>
			<div class="account_data_line">
				<div class="row no-gutters align-items-center justify-content-start">
					<div class="col-2 account_data_title">
						<em class="fa fa-venus-double"></em> Пол:
					</div>
					<div class="col-8">
						<div class="row no-gutters justify-content-start account_gender_box">
							<button onclick="account.genderSet('мужчина')" id="account_gender_male_checkbox" class="account_gender_checkbox"><em class="fa fa-check"></em></button><span class="account_gender_male"><em class="fa fa-male"></em> Я - мужчина</span>
						</div>
						<div class="row no-gutters justify-content-start account_gender_box">
							<button onclick="account.genderSet('женщина')" id="account_gender_female_checkbox" class="account_gender_checkbox"></button><span class="account_gender_female"><em class="fa fa-female"></em> Я - женщина</span>
						</div>
					</div>
				</div>
			</div>
			<div class="account_data_line">
				<div class="row no-gutters align-items-center justify-content-start">
					<div class="col-2 account_data_title">
						<em class="fa fa-user-circle-o"></em> Логин:
					</div>
					<div class="col-8">
						<input onchange="account.loginCheck(this.value)" id="account_field_2" class="account_field" maxlength="30" type="text" placeholder="Придумайте логин...">
					</div>
				</div>
			</div>
			<div class="account_data_line">
				<div class="row no-gutters align-items-center justify-content-start">
					<div class="col-2 account_data_title">
						<em class="fa fa-envelope-o"></em> Почта:
					</div>
					<div class="col-8">
						<input onchange="account.emailCheck(this.value)" id="account_field_3" class="account_field" maxlength="60" type="text" placeholder="Укажите Вашу электронную почту...">
					</div>
				</div>
			</div>
			<div class="account_data_line">
				<div class="row no-gutters align-items-center justify-content-start">
					<div class="col-2 account_data_title">
						<em class="fa fa-unlock-alt"></em> Пароль:
					</div>
					<div class="col-8">
						<input onchange="account.passwordCheck(this.value)" id="account_field_4" class="account_field" maxlength="30" type="password" placeholder="Придумайте пароль...">
					</div>
				</div>
			</div>
			<div class="account_data_line">
				<div class="row no-gutters align-items-center justify-content-start">
					<div class="col-2 account_data_title">
						<em class="fa fa-unlock-alt"></em> Повтор пароля:
					</div>
					<div class="col-8">
						<input onchange="account.repeatPasswordCheck(this.value)" id="account_field_5" class="account_field" type="password" maxlength="30" placeholder="Повторите пароль...">
					</div>
				</div>
			</div>
		</div>
		<div class="col-12">
			<div class="row no-gutters justify-content-between">
				<a href="/" id="account_go_to_main" class="account_go_to_main">Вернуться на главную</a>
				<button onclick="account.fieldsClear()" id="account_clear" class="account_clear">Очистить</button>
				<button onclick="account.goToStep2()" id="account_reg_next" class="account_reg">Готово</button>
			</div>
		</div>
	</div>
</div>
_END;

			// Если пользователь авторизован
			if(isset($_SESSION['login'])) {
				echo
<<<_END
<div id="account_reg_step_1" class="account_reg">
	<div class="row no-gutters justify-content-start">
		<div class="col-12">
			<div class="row no-gutters align-items-center justify-content-start">
				<h1 class="account_data_line_title account_data_line_title_error">Ошибка...</h1>
				<h1 class="account_data_line_note">Для регистрации нового аккаунта, необходимо выйти из текущего.</h1>
			</div>
		</div>
		<div class="col-12">
			<div class="row no-gutters justify-content-center">
				<a href="/" id="account_go_to_main" class="account_go_to_main">Вернуться на главную</a>
			</div>
		</div>
	</div>
</div>
_END;
				return;	
			}

			$fp = $other->fixString($fp);
			$connect = $other->dbConnect();
			$query = "SELECT * FROM log_users_regs WHERE fingerprint = '$fp' ORDER BY id DESC LIMIT 1";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			// Если записи найдены
			if($rows != 0) {
				$log = mysqli_fetch_assoc($result);
				$start_time = $log['unix_time'];
				$end_time = $start_time + ($config->reg_limit_time * 60);
				$now_time = time();
				$remaining_time = ($end_time - $now_time) / 60;
				$remaining_minutes = ceil($remaining_time);

				// Если оставшееся время меньше или равно нулю
				if($remaining_minutes <= 0) {
					echo $html;
				}

				// Если оставшееся время больше нуля
				else {
					echo
<<<_END
<div id="account_reg_step_1" class="account_reg">
	<div class="row no-gutters justify-content-start">
		<div class="col-12">
			<div class="row no-gutters align-items-center justify-content-start">
				<h1 class="account_data_line_title account_data_line_title_error">Ошибка...</h1>
				<h1 class="account_data_line_note">Вы недавно зарегистрировали другой аккаунт. Новый аккаунт можно будет зарегистрировать через $remaining_minutes мин.</h1>
			</div>
		</div>
		<div class="col-12">
			<div class="row no-gutters justify-content-center">
				<a href="/" id="account_go_to_main" class="account_go_to_main">Вернуться на главную</a>
			</div>
		</div>
	</div>
</div>
_END;
				}

				mysqli_close($connect);
				return;
			}

			// Если записи не найдены
			if($rows == 0) {
				echo $html;
				mysqli_close($connect);
			}
		}



		// Вывод html шага №2 для действия "регистрация" (#2)
		function htmlStep2() {
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			echo
<<<_END
<div id="account_reg_step_2" class="account_reg">
	<div class="row no-gutters justify-content-start">
		<div class="col-12">
			<div class="row no-gutters align-items-center justify-content-start">
				<h1 class="account_data_line_title">Проверка эл. почты</h1>
				<h1 id="reg_step_2_line_note" class="account_data_line_note">Для продолжения регистрации, пройдите проверку на робота и ознакомьтесь с правилами сайта.</h1>
			</div>
		</div>
		<div class="col-12">
			<div class="account_data_line">
				<div class="row no-gutters align-items-center justify-content-start">
					<div class="col-2 account_data_title">
						<em class="fa fa-male"></em> Я - человек!
					</div>
					<div class="col-8">
						<div class="row no-gutters align-items-center">
							<div id="account_recaptcha" class="account_recaptcha">
								<div id="grecaptcha" class="g-recaptcha" data-sitekey=""></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="account_data_line">
				<div class="row no-gutters align-items-center justify-content-start">
					<div class="col-2 account_data_title">
						<em class="fa fa-book"></em> Правила сайта:
					</div>
					<div class="col-8">
						<div class="row no-gutters align-items-center">
							<button onclick="account.rulesAccept()" id="account_rules_checkbox" class="account_rules_checkbox"></button>
							<span id="account_rules_title" class="account_rules_title">
								Я согласен с <a href="/rules" target="blank" class="account_rules_link">&nbsp;правилами сайта</a>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div id="account_data_mailkey_line" class="account_data_line">
				<div class="row no-gutters align-items-center justify-content-start">
					<div class="col-2 account_data_title">
						<em class="fa fa-key"></em> Код из письма:
					</div>
					<div class="col-8">
						<input id="account_field_6" class="account_field" type="password" placeholder="Введите код здесь...">
					</div>
				</div>
			</div>
		</div>
		<div class="col-12">
			<div class="row no-gutters justify-content-between">
				<button onclick="account.backToStep1()" id="account_reg_back" class="account_back">Назад</button>
				<button onclick="account.goToMailSend()" id="account_reg_mailsend" class="account_reg">Продолжить</button>
				<button onclick="account.finish()" id="account_reg_finish" class="account_reg">Зарегистрироваться</button>
			</div>
		</div>
	</div>
</div>
_END;
		}



		// Проверка есть ли в БД указанный логин (#3)
		function checkLogin($login) {
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$login = $other->fixString($login);
			$connect = $other->dbConnect();
			$query = "SELECT * FROM users WHERE login = '$login'";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			mysqli_close($connect);

			// Если записи не найдены
			if($rows == 0) {
				echo 'true';
				return;
			}

			echo 'false';
		}



		// Проверка есть ли в БД указанный email (#4)
		function checkEmail($email) {
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$email = $other->fixString($email);
			$connect = $other->dbConnect();
			$query = "SELECT * FROM users WHERE email = '$email'";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			mysqli_close($connect);

			// Если записи не найдены
			if($rows == 0) {
				echo 'true';
				return;
			}

			echo 'false';
		}



		// Проверка капчи (#5)
		function captchaCheck($response) {
			session_start();
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$response = $other->fixString($_POST['response']);
  			$secret = $config->gr_secret;
  			$json = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $response), true);
			
			// Если капча прошла проверку
			if($json['success']) {
				$_SESSION['captcha'] = 'verified';

				echo 'true'; 
			}

			// Если капча вернула ошибку
			else 
				echo 'false';
		}



		// Отправка на email пользователя письма с кодом (#6)
		function mailSend($email) {
			session_start();

			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$email = $other->fixString($email);
			$connect = $other->dbConnect();
			$query = "SELECT * FROM log_reg_keys WHERE email = '$email' ORDER BY id DESC LIMIT 1";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			// Если записи найдены
			if($rows != 0) {
				$log = mysqli_fetch_assoc($result);
				$start_time = $log['unix_time'];
				$end_time = $start_time + ($config->repair_key_limit_time * 60);
				$now_time = time();
				$remaining_time = ($end_time - $now_time) / 60;
				$remaining_minutes = ceil($remaining_time);

				// Если оставшееся время меньше или равно нулю
				if($remaining_minutes <= 0) {
					$reg_key = $other->keyGenerate(6);
					$now_time = time();
					$query_2 = "INSERT INTO log_reg_keys(email, unix_time, reg_key) VALUES('$email', '$now_time', '$reg_key')";
					$result_2 = mysqli_query($connect, $query_2);
					$title = 'Регистрация на сайте';
					$h1_title = 'Регистрация на сайте CityTrend';
					$text_1 = 'Ваш ключ для регистрации аккаунта:';
					$body = "
						<h1>$h1_title</h1>
						<b>$text_1</b>
						<h1>$reg_key</h1>
					";

					$other->mailSend($email, $title, $body);
				}
			}

			// Если записи не найдены
			if($rows == 0) {
				$reg_key = $other->keyGenerate(6);
				$now_time = time();
				$query_2 = "INSERT INTO log_reg_keys(email, unix_time, reg_key) VALUES('$email', '$now_time', '$reg_key')";
				$result_2 = mysqli_query($connect, $query_2);
				$title = 'Регистрация на сайте';
				$h1_title = 'Регистрация на сайте CityTrend';
				$text_1 = 'Ваш ключ для регистрации аккаунта:';
				$body = "
					<h1>$h1_title</h1>
					<b>$text_1</b>
					<h1>$reg_key</h1>
				";

				$other->mailSend($email, $title, $body);
			}

			mysqli_close($connect);

			echo 'true';
		}



		// Проверка ключа, который был выслан на email при регистрации (#7)
		function finish($u_key, $name, $gender, $login, $email, $password) {
			session_start();
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$u_key = $other->fixString($u_key);
			$connect = $other->dbConnect();
			$query = "SELECT * FROM log_reg_keys WHERE email = '$email' ORDER BY id DESC LIMIT 1";
			$result = mysqli_query($connect, $query);
			$log = mysqli_fetch_assoc($result);
			$reg_key = $log['reg_key'];

			// Если код подтверждения прошел проверку
			if($reg_key == $u_key) {
				$name = $other->fixString($name);
				$gender = $other->fixString($gender);
				$login = $other->fixString($login);
				$email = $other->fixString($email);
				$password = $other->fixString($password);
				$fingerprint = $_SESSION['fingerprint'];
				$salt_1 = $config->salt_1;
				$salt_2 = $config->salt_2;
				$token = hash('ripemd128', "$salt_1$password$salt_2");
				$query_2 = "INSERT INTO users(fingerprint, name, gender, login, email, password, address, avatar, cookie_accept) VALUES('', '$name', '$gender', '$login', '$email', '$token', '', '', 'yes')";
				$result_2 = mysqli_query($connect, $query_2);
				$query_3 = "SELECT id FROM users WHERE login = '$login'";
				$result_3 = mysqli_query($connect, $query_3);
				$user = mysqli_fetch_assoc($result_3);
				$user_id = $user['id'];
				$time = time(); // Текущее время
				$query_4 = "INSERT INTO log_users_regs(fingerprint, unix_time, user_id) VALUES('$fingerprint', '$time', '$user_id')";
				$result_4 = mysqli_query($connect, $query_4);

				$_SESSION['user_id'] = $user_id;
				$_SESSION['name'] = $name;
				$_SESSION['gender'] = $gender;
				$_SESSION['login'] = $login;
				$_SESSION['email'] = $email;
				$_SESSION['address'] = '';
				$_SESSION['avatar'] = '';

				mysqli_close($connect);

				echo 'success';
			}

			// Если код подтверждения неверный
			else {
				mysqli_close($connect);

				echo 'error';
			}
		}



	}
?>