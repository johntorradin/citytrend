<?php
	// Класс "Авторизация аккаунта" (#class)
	class AccountEnter {



		// Вывод начального html для действия "авторизация" (#1)
		function htmlStep1() {
			session_start();
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			// Если сессия активна
			if(isset($_SESSION['login'])) {
				echo
<<<_END
<div id="account_enter_step_1" class="account_enter">
	<div class="row no-gutters justify-content-start">
		<div class="col-12">
			<div class="row no-gutters align-items-center justify-content-start">
				<h1 class="account_data_line_title account_data_line_title_error">Ошибка...</h1>
				<h1 class="account_data_line_note">Для входа в другой аккаунт, необходимо выйти из текущего.</h1>
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

			echo
<<<_END
<div id="account_enter_step_1" class="account_enter">
	<div class="row no-gutters justify-content-start">
		<div class="col-12">
			<div class="row no-gutters align-items-center justify-content-start">
				<h1 class="account_data_line_title">Вход в аккаунт</h1>
				<h1 class="account_data_line_note">Для входа в аккаунт, укажите Ваши данные и нажмите на кнопку "Войти".</h1>
			</div>
		</div>
		<div class="col-12">
			<div class="account_data_line">
				<div class="row no-gutters align-items-center justify-content-start">
					<div class="col-2 account_data_title">
						<em class="fa fa-user-circle-o"></em> Логин:
					</div>
					<div class="col-8">
						<input onchange="account.loginCheck(this.value)" id="account_field_1" class="account_field" type="text" placeholder="Ваш логин...">
					</div>
				</div>
			</div>
			<div class="account_data_line">
				<div class="row no-gutters align-items-center justify-content-start">
					<div class="col-2 account_data_title">
						<em class="fa fa-unlock-alt"></em> Пароль:
					</div>
					<div class="col-8">
						<input onchange="account.passwordCheck(this.value)" id="account_field_2" class="account_field" type="password" placeholder="Ваш пароль...">
					</div>
				</div>
			</div>
			<div class="account_data_line">
				<div class="row no-gutters align-items-center justify-content-start">
					<div class="col-2 account_data_title">
						<em class="fa fa-male"></em> Я - человек!
					</div>
					<div class="col-8">
						<div class="row no-gutters align-items-center">
							<div id="account_recaptcha" class="account_recaptcha">
								<div id="grecaptcha" class="g-recaptcha" data-sitekey="$config->gr_sitekey"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="account_data_line">
				<div class="row no-gutters align-items-center justify-content-start">
					<button onclick="account.goToStep2()" id="account_remember" class="account_remember">Я не помню свой логин / пароль</button>
				</div>
			</div>
		</div>
		<div class="col-12">
			<div class="row no-gutters justify-content-between">
				<a href="/" id="account_go_to_main" class="account_go_to_main">Вернуться на главную</a>
				<button onclick="account.step_1_clear()" id="account_clear" class="account_clear">Очистить</button>
				<button onclick="account.finish()" id="account_enter_finish" class="account_enter">Войти</button>
			</div>
		</div>
	</div>
</div>
_END;
		}



		// Вывод шага №2 (пользователь забыл логин / пароль) (#2)
		function htmlStep2() {
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			echo
<<<_END
<div id="account_enter_step_2" class="account_enter">
	<div class="row no-gutters justify-content-start">
		<div class="col-12">
			<div class="row no-gutters align-items-center justify-content-start">
				<h1 class="account_data_line_title">Восстановление доступа</h1>
				<h1 class="account_data_line_note">Для восстановления доступа к аккаунту, укажите почту от вашего аккаунта в поле ниже.</h1>
			</div>
		</div>
		<div class="col-12">
			<div class="account_data_line">
				<div class="row no-gutters align-items-center justify-content-start">
					<div class="col-2 account_data_title">
						<em class="fa fa-envelope-o"></em> Почта:
					</div>
					<div class="col-8">
						<input onchange="account.emailCheck(this.value)" id="account_field_3" class="account_field" type="text" placeholder="Укажите Вашу электронную почту...">
					</div>
				</div>
			</div>
		</div>
		<div class="col-12">
			<div class="row no-gutters justify-content-between">
				<button onclick="account.backToStep1()" id="account_enter_back" class="account_back">Назад</button>
				<button onclick="account.step_2_clear()" id="account_clear" class="account_clear">Очистить</button>
				<button onclick="account.goToStep3()" id="account_remember_next" class="account_enter">Далее</button>
			</div>
		</div>
	</div>
</div>
_END;
		}



		// Шаг №3 (ввод кода восстановления доступа) (#3)
		function htmlStep3($email) {
			session_start();
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$html = 
<<<_END
<div id="account_enter_step_3" class="account_enter">
	<div class="row no-gutters justify-content-start">
		<div class="col-12">
			<div class="row no-gutters align-items-center justify-content-start">
				<h1 class="account_data_line_title">Проверка эл. почты</h1>
				<h1 class="account_data_line_note">На Вашу эл. почту был выслан код восстановления. Введите этот код в поле ниже.</h1>
			</div>
		</div>
		<div class="col-12">
			<div class="account_data_line">
				<div class="row no-gutters align-items-center justify-content-start">
					<div class="col-2 account_data_title">
						<em class="fa fa-key"></em> Код из письма:
					</div>
					<div class="col-8">
						<input id="account_field_4" class="account_field" type="password" placeholder="Введите код здесь...">
					</div>
				</div>
			</div>
		</div>
		<div class="col-12">
			<div class="row no-gutters justify-content-between">
				<button onclick="account.backToStep2()" id="account_enter_back_2" class="account_back">Назад</button>
				<button onclick="account.step_3_clear()" id="account_clear" class="account_clear">Очистить</button>
				<button onclick="account.repairSuccess()" id="account_enter_next_2" class="account_enter">Готово</button>
			</div>
		</div>
	</div>
</div>
_END;

			$connect = $other->dbConnect();
			$email = $other->fixString($email);
			$query = "SELECT * FROM log_repair_keys WHERE email = '$email' ORDER BY id DESC LIMIT 1";
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
					$repair_key = $other->keyGenerate(6);
					$new_password = $other->passGenerate(10);
					$_SESSION['new_password'] = $new_password;
					$now_time = time();
					$query_2 = "INSERT INTO log_repair_keys(email, unix_time, repair_key) VALUES('$email', '$now_time', '$repair_key')";
					$result_2 = mysqli_query($connect, $query_2);
					$title = 'Восстановление доступа к сайту';
					$h1_title = 'Восстановление доступа к сайту CityTrend';
					$text_1 = 'Ваш ключ для восстановления пароля:';
					$text_2 = 'Ваш новый пароль (изменится после ввода проверочного ключа на сайте):';
					$body = "
						<h1>$h1_title</h1>
						<b>$text_1</b>
						<h1>$repair_key</h1>
						<b>$text_2</b><br>
						<b>$new_password</b>
					";

					$other->mailSend($email, $title, $body);
				}
			}

			// Если записи не найдены
			if($rows == 0) {
				$repair_key = $other->keyGenerate(6);
				$new_password = $other->passGenerate(10);
				$_SESSION['new_password'] = $new_password;
				$now_time = time();
				$query_2 = "INSERT INTO log_repair_keys(email, unix_time, repair_key) VALUES('$email', '$now_time', '$repair_key')";
				$result_2 = mysqli_query($connect, $query_2);
				$title = 'Восстановление доступа к сайту';
				$h1_title = 'Восстановление доступа к сайту CityTrend';
				$text_1 = 'Ваш ключ для восстановления пароля:';
				$text_2 = 'Ваш новый пароль (изменится после ввода проверочного ключа на сайте):';
				$body = "
					<h1>$h1_title</h1>
					<b>$text_1</b>
					<h1>$repair_key</h1>
					<b>$text_2</b><br>
					<b>$new_password</b>
				";

				$other->mailSend($email, $title, $body);
			}

			echo $html;

			mysqli_close($connect);
		}



		// Проверка есть ли в БД указанный логин (#4)
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
				echo 'false';

				return;
			}

			echo 'true';
		}



		// Проверка есть ли в БД указанный email (#5)
		function checkEmail($email) {
			session_start();
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$email = $other->fixString($email);
			$connect = $other->dbConnect();
			$query = "SELECT * FROM users WHERE email = '$email'";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			// Если записи не найдены
			if($rows == 0) {
				echo 'false';

				mysqli_close($connect);

				return;
			}

			echo 'true';
		}



		// Проверка капчи
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
			else echo 'false';
		}



		// Финиш (#6)
		function finish($fingerprint, $login, $password) {
			session_start();
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$fingerprint = $other->fixString($fingerprint);
			$connect = $other->dbConnect();
			$query = "SELECT unix_time FROM log_users_enters WHERE fingerprint = '$fingerprint' ORDER BY id DESC LIMIT 2, 1";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			// Если пользователь авторизовывался более трех раз
			if($rows != 0) {
				$log = mysqli_fetch_assoc($result);
				$start_time = $log['unix_time'];
				$now_time = time();
				$time_diff = ($now_time - $start_time) / 60;
				$time_diff = ceil($time_diff);

				// Если пользователь авторизовывался меньше чем за 10 минут (время устанавливается в конфиге)
				if($time_diff < $config->enter_limit_time) {
					$remaining_time = ($config->enter_limit_time - $time_diff);

					echo "Вы заходите в аккаунт слишком часто! Повторите попытку через $remaining_time мин.";

					return;
				}
			}


			$login = $other->fixString($login);
			$password = $other->fixString($password);
			$salt_1 = $config->salt_1;
			$salt_2 = $config->salt_2;
			$token = hash('ripemd128', "$salt_1$password$salt_2");
			$query_2 = "SELECT * FROM users WHERE login = '$login' AND password = '$token'";
			$result_2 = mysqli_query($connect, $query_2);
			$rows_2 = mysqli_num_rows($result_2);

			// Если записей не найдено
			if($rows_2 == 0) 
				echo 'false';

			// Если записи найдены
			else {
				$user = mysqli_fetch_assoc($result_2);
				$id = $user['id'];
				$name = $user['name'];
				$gender = $user['gender'];
				$login = $user['login'];
				$email = $user['email'];
				$address = $user['address'];
				$avatar = $user['avatar'];
				$cookie_accept = $user['cookie_accept'];

				$_SESSION['user_id'] = $id;
				$_SESSION['name'] = $name;
				$_SESSION['gender'] = $gender;
				$_SESSION['login'] = $login;
				$_SESSION['email'] = $email;
				$_SESSION['address'] = $address;
				$_SESSION['avatar'] = $avatar;
				$_SESSION['cookie_accept'] = $cookie_accept;

				$now_time = time();
				$query_3 = "INSERT INTO log_users_enters(fingerprint, unix_time) VALUES('$fingerprint', '$now_time')";
				$result_3 = mysqli_query($connect, $query_3);

				echo 'true';
			}

			mysqli_close($connect);
		}



		// Финиш восстановления (#7)
		function repairFinish($fingerprint, $repair_key, $email) {
			session_start();
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$fingerprint = $other->fixString($fingerprint);
			$connect = $other->dbConnect();
			$query = "SELECT unix_time FROM log_users_enters WHERE fingerprint = '$fingerprint' ORDER BY id DESC LIMIT 2, 1";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			// Если пользователь авторизовывался более трех раз
			if($rows != 0) {
				$log = mysqli_fetch_assoc($result);
				$start_time = $log['unix_time'];
				$now_time = time();
				$time_diff = ($now_time - $start_time) / 60;
				$time_diff = ceil($time_diff);

				// Если пользователь авторизовывался меньше чем за 10 минут (время устанавливается в конфиге)
				if($time_diff < $config->enter_limit_time) {
					$remaining_time = ($config->enter_limit_time - $time_diff);

					echo "Вы заходите в аккаунт слишком часто! Повторите попытку через $remaining_time мин.";

					return;
				}
			}

			$email = $other->fixString($email);
			$repair_key = $other->fixString($repair_key);
			$new_password = $_SESSION['new_password'];
			$query_2 = "SELECT * FROM log_repair_keys WHERE email = '$email' ORDER BY id DESC LIMIT 1";
			$result_2 = mysqli_query($connect, $query_2);
			$log_2 = mysqli_fetch_assoc($result_2);
			$true_repair_key = $log_2['repair_key'];

			// Если код подтверждения неверный
			if($repair_key != $true_repair_key) {
				echo 'error';

				return;
			}

			$salt_1 = $config->salt_1;
			$salt_2 = $config->salt_2;
			$token = hash('ripemd128', "$salt_1$new_password$salt_2");
			$query_3 = "UPDATE users SET password = '$token' WHERE email = '$email'";
			$result_3 = mysqli_query($connect, $query_3);
			$query_4 = "SELECT * FROM users WHERE email = '$email'";
			$result_4 = mysqli_query($connect, $query_4);
			$user = mysqli_fetch_assoc($result_4);
			$id = $user['id'];
			$name = $user['name'];
			$gender = $user['gender'];
			$login = $user['login'];
			$email = $user['email'];
			$address = $user['address'];
			$avatar = $user['avatar'];
			$cookie_accept = $user['cookie_accept'];

			$_SESSION['user_id'] = $id;
			$_SESSION['name'] = $name;
			$_SESSION['gender'] = $gender;
			$_SESSION['login'] = $login;
			$_SESSION['email'] = $email;
			$_SESSION['address'] = $address;
			$_SESSION['avatar'] = $avatar;
			$_SESSION['cookie_accept'] = $cookie_accept;

			$now_time = time();
			$query_5 = "INSERT INTO log_users_enters(fingerprint, unix_time) VALUES('$fingerprint', '$now_time')";
			$result_5 = mysqli_query($connect, $query_5);

			echo 'success';

			mysqli_close($connect);
		}



	}
?>