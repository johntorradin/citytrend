<?php
	// Класс "Аккаунт в Header" (#class)
	class AccountHeader {



		// Загрузить новое фото профиля (#1)
		function addAvatar() {
			session_start();
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$allow_types = array('jpg', 'jpeg');
			$path = '../media/images/avatars/';

			// Если файл не загружен
			if(!isset($_FILES['file'])) {
				$result = 'файл отсутствует';

				echo $result;

				return;
			}

			$connect = $other->dbConnect();
			$user_id = $_SESSION['user_id'];
			$query = "SELECT * FROM log_add_avatars WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			// Если записи не найдены
			if($rows != 0) {
				$log = mysqli_fetch_assoc($result);
				$start_time = $log['unix_time'];
				$end_time = $start_time + ($config->add_avatars_limit_time * 60);
				$now_time = time();
				$remaining_time = ($end_time - $now_time) / 60;
				$remaining_minutes = ceil($remaining_time);

				if($remaining_minutes > 0)
				{
					$result = $remaining_minutes;

					echo "Вы недавно устанавливали фото профиля. Новое фото можно будет загрузить через $result мин.";

					return;
				}
			}

			$file = $_FILES['file'];
			 
			// Если есть ошибки загрузки
			if(!empty($file['error']) || empty($file['tmp_name'])) {
				$result = 'ошибка загрузки';

				echo $result;

				return;
			}

			// Есть есть другие ошибки загрузки
			if($file['tmp_name'] == 'none' || !is_uploaded_file($file['tmp_name'])) {
				$result = 'ошибка загрузки';

				echo $result;

				return;
			}

			$name = $file['name'];
			$parts = pathinfo($name);

	 		// Если загружен недопустимый файл
			if(empty($name) || empty($parts['extension'])) {
				$result = 'недопустимый тип файла';

				echo $result;

				return;
			}

			// Если загружен недопустимый файл
			if(!empty($allow_types) && !in_array(strtolower($parts['extension']), $allow_types)) {
				$result = 'недопустимый тип файла';

				echo $result;

				return;
			}

			$file_size = $file['size'] / 1024 / 1024;

			// Если размер файла больше, чем разрешено
			if($file_size > $config->allow_file_size) {
				$result = 'большой размер файла';

				echo $result;

				return;
			}

			$file_name = $_SESSION['login'];

			// Если файл успешно перемещен в директорию
			if(move_uploaded_file($file['tmp_name'], "$path$file_name.jpg")) {
				$now_time = time();
				$query_2 = "INSERT INTO log_add_avatars(user_id, unix_time) VALUES('$user_id', '$now_time')";
				$result_2 = mysqli_query($connect, $query_2);

				// Если в сессии не указана аватарка
				if($_SESSION['avatar'] == '')
				{
					$query_3 = "UPDATE users SET avatar = 'yes' WHERE id = '$user_id'";
					$result_3 = mysqli_query($connect, $query_3);
					$_SESSION['avatar'] = 'yes';
				}

				$result = 'файл успешно загружен';

				echo $result;
			} 

			// Если файл не перемещен в директорию из-за ошибок
			else {
				$result = 'ошибка загрузки';

				echo $result;
			}

			mysqli_close($connect);
		}



		// Вывод информации о пользователе (#2)
		function selectUserInfo($fp) {
			session_start();
			require_once 'config.php';
			require_once 'other.php';
			$config = new Config;
			$other = new Other;

			$connect = $other->dbConnect();

			// Если пользователь авторизован
			if(isset($_SESSION['login'])) {
				$user_id  = $_SESSION['user_id'];
				$name = $_SESSION['name'];
				$login = $_SESSION['login'];
				$email = $_SESSION['email'];
				$address = $_SESSION['address'];
				$avatar = $_SESSION['avatar'];
				$query = "SELECT COUNT(id) AS 'count' FROM deliverys WHERE user_id = '$user_id'";
				$result = mysqli_query($connect, $query);
				$delivery = mysqli_fetch_assoc($result);
				$count = $delivery['count'];

				// Если счетчик равен нулю
				if($count > 0) 
					$delivery_note = '<span class="delivery_note"></span>';

				// Если адрес пустой
				if($address == '') 
					$address = 'Адрес доставок пока не выбран.';

				// Если аватар пустой
				if($avatar == '') 
					$avatar = 'default.jpg';

				// Если аватар не пустой
				else if($avatar == 'yes') 
					$avatar = $login . '.jpg';

				// Рандомное число для сброса кэша изображения
				$random_num = rand(0, 99999999999999999) / 100000000000000000;

				echo 
<<<_END
	<div class="row no-gutters align-items-center justify-content-between">
	<div class="user_data_line">
		<div class="row no-gutters align-items-center justify-content-between">
			<button onclick="delivery.selectItems(); return false" id="delivery_btn" class="user_data_delivery_btn">
				<div class="row no-gutters align-items-center">
					<em class="fa fa-truck user_data_delivery_icon"></em>Доставки
					$delivery_note
				</div>
			</button>
			<button onclick="purchases.selectItems(); return false" id="purchases_btn" class="user_data_purchases_btn">
				<div class="row no-gutters align-items-center">
					<em class="fa fa-shopping-bag user_data_purchases_icon"></em>Мои покупки
				</div>
			</button>
		</div>
	</div>
	<div class="user_data_line">
		<div class="row no-gutters align-items-center">
			<div id="account_data_avatar" class="account_data_avatar">
				<img id="account_avatar" src="../media/images/avatars/$avatar?v=$random_num" class="account_avatar">
				<em id="account_avatar_edit_icon" class="fa fa-pencil account_avatar_edit_icon"></em>
				<input onmouseover="account.userAvatarMouseDown()" onmouseout="account.userAvatarMouseOut()" onchange="account.addAvatar()" id="account_avatar_input" type="file" class="account_avatar_input">
			</div>
		</div>
	</div>
	<div class="user_data_line">
		<div class="row no-gutters align-items-center">
			<div class="account_data_title">
				<em class="fa fa-user-o"></em> Имя: <span id="user_name">$name</span>
			</div>
		</div>
	</div>
	<div class="user_data_line">
		<div class="row no-gutters align-items-center">
			<div class="account_data_title">
				<em class="fa fa-user-circle-o"></em> Логин: <span id="user_login">$login</span>
			</div>
		</div>
	</div>
	<div class="user_data_line">
		<div class="row no-gutters align-items-center">
			<div class="account_data_title">
				<em class="fa fa-envelope-o"></em> Email: <span id="user_email">$email</span>
			</div>
		</div>
	</div>
	<div class="user_data_line">
		<div class="row no-gutters align-items-center">
			<div class="account_data_title">
				<em class="fa fa-map-marker"></em> Адрес доставок: <span id="user_address">$address</span>
			</div>
		</div>
	</div>
	<div class="user_data_line">
		<div class="row no-gutters justify-content-between">
			<button onclick="account.showEditBox(); return false" id="account_edit" class="account_edit">Изменить данные об аккаунте</button>
			<input name="destroy" value="Выйти из аккаунта" type="submit" id="account_exit" class="account_exit">
		</div>
	</div>
</div>
_END;
			}

			// Если пользователь не авторизован
			else {
				$fp = $other->fixString($fp);
				$query = "SELECT COUNT(id) AS 'count' FROM deliverys WHERE fingerprint = '$fp'";
				$result = mysqli_query($connect, $query);
				$delivery = mysqli_fetch_assoc($result);
				$count = $delivery['count'];

				if($count > 0)
					$delivery_note = '<span class="delivery_note"></span>';

				echo 
<<<_END
<div class="row no-gutters align-items-center justify-content-between">
	<div class="user_data_line">
		<div class="row no-gutters align-items-center justify-content-between">
			<button onclick="delivery.selectItems(); return false" id="delivery_btn" class="user_data_delivery_btn">
				<div class="row no-gutters align-items-center">
					<em class="fa fa-truck user_data_delivery_icon"></em>Доставки
					$delivery_note
				</div>
			</button>
			<button onclick="purchases.selectItems(); return false" id="purchases_btn" class="user_data_purchases_btn">
				<div class="row no-gutters align-items-center">
					<em class="fa fa-shopping-bag user_data_purchases_icon"></em>Мои покупки
				</div>
			</button>
		</div>
	</div>
	<h1 class="account_none_note">
		Для создания нового аккаунта, нажмите на кнопку "Создать аккаунт", после чего Вы будете перенаправлены на страницу регистрации. Для входа в уже существующий аккаунт, нажмите на кнопку "Вход в аккаунт".
	</h1>
	<a href="account_reg" class="account_reg">Создать аккаунт</a>
	<a href="account_enter" class="account_enter">Вход в аккаунт</a>
</div>
_END;
			}

			mysqli_close($connect);
		}



		// Вывести html окна редактирования информации об аккаунте (#3)
		function showEditBox() {
			session_start();
			require_once 'config.php';
			require_once 'other.php';
			$config = new Config;
			$other = new Other;

			$name = $_SESSION['name'];
			$login = $_SESSION['login'];
			$email = $_SESSION['email'];
			$address = $_SESSION['address'];

			echo 
<<<_END
<div class="row no-gutters justify-content-center">
	<div class="col-12">
		<div class="row no-gutters align-items-center">
			<h1 class="user_data_line_title">Изменение данных</h1>
			<h1 class="user_data_line_note">Для изменения значений на новые, необходимо отредактировать поля и нажать на кнопку "Сохранить изменения".</h1>
		</div>
	</div>
	<div class="col-12">
		<div class="user_data_line">
			<div class="row no-gutters align-items-center">
				<div class="col-2 account_data_title">
					<em class="fa fa-user-o"></em> Имя:
				</div>
				<div class="col-8">
					<input onchange="account.nameCheck(this.value)" id="account_edit_field_1" class="account_edit_field" type="text" placeholder="Новое имя..." value="$name">
				</div>
			</div>
		</div>
		<div class="user_data_line">
			<div class="row no-gutters align-items-center">
				<div class="col-2 account_data_title">
					<em class="fa fa-user-circle-o"></em> Логин:
				</div>
				<div class="col-8">
					<input onchange="account.loginCheck(value)" id="account_edit_field_2" class="account_edit_field" type="text" placeholder="Новый логин..." value="$login">
				</div>
			</div>
		</div>
		<div class="user_data_line">
			<div class="row no-gutters align-items-center">
				<div class="col-2 account_data_title">
					<em class="fa fa-envelope-o"></em> Email:
				</div>
				<div class="col-8">
					<input onchange="account.emailCheck(value)" id="account_edit_field_3" class="account_edit_field" type="text" placeholder="Новая почта..." value="$email">
				</div>
			</div>
		</div>
		<div class="user_data_line">
			<div class="row no-gutters">
				<div class="col-2 account_data_title">
					<em class="fa fa-map-marker"></em> Адрес доставок:
				</div>
				<div class="col-8">
					<input onchange="account.addressCheck(value)" id="account_edit_field_4" class="account_edit_field" type="text" placeholder="Новый адрес доставок..." value="$address">
				</div>
			</div>
		</div>
		<div class="user_data_line">
			<div class="row no-gutters">
				<div class="col-2 account_data_title">
					<em class="fa fa-unlock-alt"></em> Изменить пароль:
				</div>
				<div class="col-8">
					<input onchange="account.passwordCheck(value)" id="account_edit_field_5" class="account_edit_field" type="password" placeholder="Новый пароль">
				</div>
			</div>
		</div>
		<div class="user_data_line">
			<div class="row no-gutters">
				<div class="col-2 account_data_title">
					<em class="fa fa-unlock-alt"></em> Ваш текущий пароль:
				</div>
				<div class="col-8">
					<input onchange="account.realPasswordCheck(value)" id="account_edit_field_6" class="account_edit_field" type="password" placeholder="Ваш действующий пароль...">
				</div>
			</div>
		</div>
	</div>
	<div class="col-12">
		<div class="row no-gutters justify-content-between">
			<button onclick="account.hideEditBox()" id="account_edit_cancel" class="account_edit_cancel">Отмена</button>
			<button onclick="account.editFieldsClear()" id="account_edit_clear" class="account_edit_clear">Вернуть значения</button>
			<button onclick="account.editConfirm()" id="account_edit_save" class="account_edit_save">Сохранить изменения</button>
		</div>
	</div>
</div>
_END;
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
				echo 'true';

				return;
			}

			echo 'false';
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
				echo 'true';

				mysqli_close($connect);

				return;
			}

			echo 'false';
		}



		// Проверка текущего пароля пользователя (#6)
		function checkRealPassword($password) {
			session_start();
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$login = $_SESSION['login'];
			$password = $other->fixString($password);
			$salt_1 = $config->salt_1;
			$salt_2 = $config->salt_2;
			$token = hash('ripemd128', "$salt_1$password$salt_2");
			$connect = $other->dbConnect();
			$query = "SELECT * FROM users WHERE login = '$login' AND password = '$token'";
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



		// Подтверждение редактирования данных профиля (#7)
		function editConfirm($email)  {
			session_start();
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$email = $other->fixString($email);
			$user_id = $_SESSION['user_id'];
			$connect = $other->dbConnect();
			$query = "SELECT * FROM log_users_edits WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			// Если записи найдены
			if($rows != 0) {
				$log = mysqli_fetch_assoc($result);
				$start_time = $log['unix_time'];
				$end_time = $start_time + ($config->edit_limit_time * 60);
				$now_time = time();
				$remaining_time = ($end_time - $now_time) / 60;
				$remaining_minutes = ceil($remaining_time);

				// Если оставшееся время больше нуля
				if($remaining_minutes > 0)
				{
					echo "Вы недавно редактировали профиль. Повторное редактирование возможно через $remaining_minutes мин.";

					mysqli_close($connect);

					return;
				}
			}

			// Если email пустой
			if($email == '') {
				echo 
<<<_END
<div class="row no-gutters justify-content-center">
	<div class="col-12">
		<div class="row no-gutters align-items-center">
			<h1 class="user_data_line_title">Подтверждение изменений</h1>
			<h1 class="user_data_line_note">Для подтверждения изменений, нажмите на кнопку "Подтвердить".</h1>
		</div>
	</div>
	<div class="col-12">
		<div class="row no-gutters justify-content-between">
			<button onclick="account.hideEditBox()" id="account_edit_cancel" class="account_edit_cancel">Отмена</button>
			<button onclick="account.editFinish()" id="account_edit_save" class="account_edit_save">Подтвердить</button>
		</div>
	</div>
</div>
_END;

				mysqli_close($connect);

				return;
			}

			// Если email не пустой
			if($email != '') {
				$query_2 = "SELECT * FROM log_edit_keys WHERE email = '$email' ORDER BY id DESC LIMIT 1";
				$result_2 = mysqli_query($connect, $query_2);
				$rows_2 = mysqli_num_rows($result_2);

				// Если записи найдены
				if($rows_2 != 0) {
					$log_2 = mysqli_fetch_assoc($result_2);
					$start_time = $log_2['unix_time'];
					$end_time = $start_time + ($config->edit_key_limit_time * 60);
					$now_time = time();
					$remaining_time = ($end_time - $now_time) / 60;
					$remaining_minutes = ceil($remaining_time);

					// Если оставшееся время меньше или равно нулю
					if($remaining_minutes <= 0) {
						$edit_key = $other->keyGenerate(6);
						$now_time = time();
						$query_2 = "INSERT INTO log_edit_keys(email, unix_time, edit_key) VALUES('$email', '$now_time', '$edit_key')";
						$result_2 = mysqli_query($connect, $query_2);
						$title = 'Изменение почты на сайте';
						$h1_title = 'Изменение почты на сайте CityTrend';
						$text_1 = 'Ваш ключ для изменения почты:';
						$body = "
							<h1>$h1_title</h1>
							<b>$text_1</b>
							<h1>$edit_key</h1>
						";

						$other->mailSend($email, $title, $body);
					}
				}

				// Если записи не найдены
				if($rows_2 == 0) {
					$edit_key = $other->keyGenerate(6);
					$now_time = time();
					$query_2 = "INSERT INTO log_edit_keys(email, unix_time, edit_key) VALUES('$email', '$now_time', '$edit_key')";
					$result_2 = mysqli_query($connect, $query_2);
					$title = 'Изменение почты на сайте';
					$h1_title = 'Изменение почты на сайте CityTrend';
					$text_1 = 'Ваш ключ для изменения почты:';
					$body = "
							<h1>$h1_title</h1>
							<b>$text_1</b>
							<h1>$edit_key</h1>
						";

					$other->mailSend($email, $title, $body);
				}

				echo 
<<<_END
<div class="row no-gutters justify-content-center">
	<div class="col-12">
		<div class="row no-gutters align-items-center">
			<h1 class="user_data_line_title">Подтверждение новой почты</h1>
			<h1 class="user_data_line_note">На указанную Вами почту был выслан код подтверждения. Введите код в поле ниже и нажмите на кнопку "Подтвердить".</h1>
		</div>
	</div>
	<div class="col-12">
		<div class="user_data_line">
			<div class="row no-gutters align-items-center">
				<div class="col-2 account_data_title">
					<em class="fa fa-user-o"></em> Имя:
				</div>
				<div class="col-8">
					<input id="account_edit_field_7" class="account_edit_field" type="password" placeholder="Код подтверждения...">
				</div>
			</div>
		</div>
	</div>
	<div class="col-12">
		<div class="row no-gutters justify-content-between">
			<button onclick="account.hideEditBox()" id="account_edit_cancel" class="account_edit_cancel">Отмена</button>
			<button onclick="account.editFinish()" id="account_edit_save" class="account_edit_save">Подтвердить</button>
		</div>
	</div>
</div>
_END;

				mysqli_close($connect);
			}
		}



		// Финиш редактирования данных (#8)
		function editFinish($key, $name, $login, $email, $address, $password) {
			session_start();
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$key = $other->fixString($key);
			$name = $other->fixString($name);
			$login = $other->fixString($login);
			$email = $other->fixString($email);
			$address = $other->fixString($address);
			$password = $other->fixString($password);
			$connect = $other->dbConnect();

			// Если код подтверждения не пустой
			if($key != '') {
				$query = "SELECT * FROM log_edit_keys WHERE edit_key = '$key' AND email = '$email' ORDER BY id DESC LIMIT 1";
				$result = mysqli_query($connect, $query);
				$rows = mysqli_num_rows($result);

				// Если записи не найдены
				if($rows == 0)
				{
					mysqli_close($connect);

					echo 'error';

					return;
				}
			}

			$user_id = $_SESSION['user_id'];
			$session_name = $_SESSION['name'];

			// Если имя пустое
			if($name == '') 
				$name_set = 'name = \'' . $session_name . '\'';

			// Если имя не пустое
			else {
				$name_set = 'name = \'' . $name . '\'';
				$_SESSION['name'] = $name;
			}

			// Если логин пустой
			if($login == '') 
				$login_set = '';

			// Если логин не пустой
			else {
				$login_set = ', login = \'' . $login . '\'';
				$_SESSION['login'] = $login;
			}

			// Если email пустой
			if($email == '') 
				$email_set = '';

			// Если email не пустой
			else {
				$email_set = ', email = \'' . $email . '\'';
				$_SESSION['email'] = $email;
			}

			$address_set = ', address = \'' . $address . '\'';
			$_SESSION['address'] = $address;

			// Если пароль пустой
			if($password == '') 
				$password_set = '';

			// Если пароль не пустой
			else {
				$salt_1 = $config->salt_1;
				$salt_2 = $config->salt_2;
				$token = hash('ripemd128', "$salt_1$password$salt_2");
				$password_set = ', password = \'' . $token . '\'';
			}

			$query_2 = "UPDATE users SET $name_set$login_set$email_set$address_set$password_set WHERE id = '$user_id'";
			$result_2 = mysqli_query($connect, $query_2);
			$now_time = time();
			$query_3 = "INSERT INTO log_users_edits(user_id, unix_time) VALUES('$user_id', '$now_time')";
			$result_3 = mysqli_query($connect, $query_3);

			mysqli_close($connect);
			echo 'success';
		}



	}
?>