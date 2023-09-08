<?php 
	// Класс "Другое" (#class)
	class Other {



		// Проверка отпечатка браузера (#1)
		function fingerprintCheck($fp) {
			session_start();
			
			require 'config.php';
			$config = new Config;

			$fingerprint = $this->fixString($fp);
			$_SESSION['fingerprint'] = $fingerprint;
			$connect = $this->dbConnect();

			// Если пользователь авторизован
			if(isset($_SESSION['login'])) {
				$login = $_SESSION['login'];
				$query = "SELECT cookie_accept FROM users WHERE login = '$login'";
			}

			// Если пользователь не авторизован
			else {	
				$query = "SELECT cookie_accept FROM users WHERE fingerprint = '$fingerprint'";
			}

			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);
			$user = mysqli_fetch_assoc($result);
			$cookie_accept = $user['cookie_accept'];

			$html = 
<<<_END
<div id="cookie_accept_box" class="cookie_accept_box">
	<div class="row no-gutters align-items-start">
		<img class="cookie_img" src="../media/images/static/cookie.jpg">
		<div class="cookie_text_col">
			<div class="cookie_text">
				Мы используем файлы cookie для хранения данных и удобства покупателей.
				Продолжая использовать сайт, Вы даёте своё согласие на работу с этими файлами.
			</div>
			<button onclick="other.cookieBoxHide()" id="cookie_accept_btn" class="cookie_accept_btn">Хорошо, принимаю</button>
		</div>
	</div>
</div>
_END;

			// Если записи не найдены
			if($rows == 0) {
				$insert_query = "INSERT INTO users(fingerprint, name, gender, login, email, password, address, avatar, cookie_accept) VALUES('$fingerprint', '', '', '', '', '', '', '', 'no')";
				$insert_result = mysqli_query($connect, $insert_query);

				echo $html;

				mysqli_close($connect);

				return false;
			}

			// Если пользователь еще не соглашался с правилами куки
			if($cookie_accept == 'no') {
				echo $html;
				return false;
			}

			// Если пользователь соглашался с правилами куки
			if($cookie_accept == 'yes') {
				echo 'yes';
			}
		}



		// Занести инфу о том, что пользователь принял куки в его запись в БД (#2)
		function cookieAccepted() {
			session_start();
			require 'config.php';
			$config = new Config;

			$connect = $this->dbConnect();

			// Если пользователь авторизован
			if(isset($_SESSION['login'])) {
				$login = $_SESSION['login'];
				$query = "UPDATE users SET cookie_accept = 'yes' WHERE login = '$login'";
			}

			// Если пользователь не авторизован
			else {
				$fingerprint = $_SESSION['fingerprint'];
				$query = "UPDATE users SET cookie_accept = 'yes' WHERE fingerprint = '$fingerprint'";
			}

			$result = mysqli_query($connect, $query);

			mysqli_close($connect);
		}



		//Перевод первой буквы в верхний регистр (#3)
		function mb_ucfirst($var, $encoding='UTF-8')
		{
			$var = mb_ereg_replace('^[\ ]+', '', $var);
			$var = mb_strtoupper(mb_substr($var, 0, 1, $encoding), $encoding) .
			mb_substr($var, 1, mb_strlen($var), $encoding);

			return $var;
		}



		// Подключение к БД (#4)
		function dbConnect() {
			require_once 'config.php';
			$config = new Config;

			$connect = new mysqli(
				$config->mysql_host, 
				$config->mysql_user, 
				$config->mysql_pass, 
				$config->mysql_db
			);

			return $connect;
		}



		// Генератор случайного ключа (#5)
		function keyGenerate($length) {
	    	$key = "";

		    $arr = array('0', '1', '2', '3', '4', '5','6', '7', '8', '9');

		    for($i = 0; $i < $length; $i++)
		    {
		    	$key = $key . $arr[mt_rand(0, count($arr) - 1)];
		    }

	  		return $key;
	  	}



	  	// Генератор паролей (#6)
		function passGenerate($length) {
	    	$password = "";

		    $arr = array(
		    	'0', '1', '2', '3', '4', '5','6', '7', '8', '9',
		    	'a', 'b', 'c', 'd', 'e', 'f','g', 'h', 'i', 'j',
		    	'k', 'l', 'm', 'n', 'o', 'p','q', 'r', 's', 't',
		    	'u', 'v', 'w', 'y', 'z', '!', '#', '*'
		    	
		    );

		    for($i = 0; $i < $length; $i++) {
		    	$password = $password . $arr[mt_rand(0, count($arr) - 1)];
		    }

	  		return $password;
	  	}



		// Урезание строки (#7)
		function stringReduce($string, $size) {
			$string = substr($string, 0, $size);
			$string = rtrim($string, "!,.-");
			$string = substr($string, 0, strrpos($string, ' '));
			$string .= '...';

			return $string;
		}


		
		// Обезвреживание строки (#8)
		function fixString($var) {
			$var = stripslashes($var);
			$var = htmlentities($var);
			$var = strip_tags($var);

			return $var;
		}



		//Заменить число рейтинга на кол-во звездочек (#9)
		function ratingCount($r) {
			$star0 	= '<em class="fa fa-star-o"></em>';
			$star05 = '<em class="fa fa-star-half-o"></em>';
			$star1 	= '<em class="fa fa-star"></em>';

			// Если рейтинг меньше 0.5
			if($r < 0.5) {$r = $star0 . $star0 . $star0 . $star0 . $star0; return $r;}

			// Если рейтинг от 0.5 до 1
			if($r >= 0.5 && $r < 1) {$r = $star05 . $star0 . $star0 . $star0 . $star0; return $r;}

			// Если рейтинг от 1 до 1.5
			if($r >= 1 && $r < 1.5) {$r = $star1 . $star0 . $star0 . $star0 . $star0; return $r;}

			// Если рейтинг от 1.5 до 2
			if($r >= 1.5 && $r < 2) {$r = $star1 . $star05 . $star0 . $star0 . $star0; return $r;}

			// Если рейтинг от 2 до 2.5
			if($r >= 2 && $r < 2.5) {$r = $star1 . $star1 . $star0 . $star0 . $star0; return $r;}

			// Если рейтинг от 2.5 до 3
			if($r >= 2.5 && $r < 3) {$r = $star1 . $star1 . $star05 . $star0 . $star0; return $r;}

			// Если рейтинг от 3 до 3.5
			if($r >= 3 && $r < 3.5) {$r = $star1 . $star1 . $star1 . $star0 . $star0; return $r;}

			// Если рейтинг от 3.5 до 4
			if($r >= 3.5 && $r < 4) {$r = $star1 . $star1 . $star1 . $star05 . $star0; return $r;}

			// Если рейтинг от 4 до 4.5
			if($r >= 4 && $r < 4.5) {$r = $star1 . $star1 . $star1 . $star1 . $star0; return $r;}

			// Если рейтинг от 4.5 до 4.8
			if($r >= 4.5 && $r < 4.8) {$r = $star1 . $star1 . $star1 . $star1 . $star05; return $r;}

			// Если рейтинг от 4.8 до 5
			if($r >= 4.8) {$r = $star1 . $star1 . $star1 . $star1 . $star1; return $r;}
		}



		// Отправить письмо на эл. почту (#10)
		function mailSend($email, $title, $body) {
			require_once 'config.php';
			$config = new Config;

			require '../libs/phpmailer/PHPMailer.php';
			require '../libs/phpmailer/SMTP.php';
			require '../libs/phpmailer/Exception.php';

			$mail = new PHPMailer\PHPMailer\PHPMailer();
			
			$mail->isSMTP();   
			$mail->CharSet = "UTF-8";
			$mail->SMTPAuth   = true;
			$mail->Host       = 'smtp.yandex.ru';
			$mail->Username   = $config->forward_email;
			$mail->Password   = $config->forward_email_pass;
			$mail->SMTPSecure = 'ssl';
			$mail->Port       = 465;
			$mail->setFrom($config->forward_email, 'CityTrend');
			$mail->addAddress($email); 
			$mail->isHTML(true);
			$mail->Subject = $title;
			$mail->Body = $body;
			$mail->send();
		}



		// Вывод статистики на странице "О нас" (#11)
		function aboutUsStats() {
			require_once 'config.php';
			$config = new Config;

			$connect = $this->dbConnect();
			$now_date = date('d.m.Y');
			$query = "
				SELECT 
				(SELECT COUNT(id) FROM items) AS 'items_count', 
				(SELECT COUNT(id) FROM purchases) AS 'purchases_count', 
				(SELECT COUNT(id) FROM purchases WHERE purchdate = '$now_date') AS 'purchases_per_day_count', 
				(SELECT COUNT(id) FROM reviews WHERE advise = 'yes') AS 'reviews_count'
			";
			$result = mysqli_query($connect, $query);
			$stat = mysqli_fetch_assoc($result);
			$items_count = $stat['items_count'];
			$purchases_count = $stat['purchases_count'];
			$purchases_per_day_count = $stat['purchases_per_day_count'];
			$reviews_count = $stat['reviews_count'];

			echo 
<<<_END
<div class="col">
	<div class="row no-gutters align-content-center about_us_stat_circle">
		Всего вещей в каталоге: <span>$items_count</span>
	</div>
</div>
<div class="col">
	<div class="row no-gutters align-content-center about_us_stat_circle">
		Совершено покупок: <span>$purchases_count</span>
	</div>
</div>
<div class="col">
	<div class="row no-gutters align-content-center about_us_stat_circle">
		Покупок за сегодня: <span>$purchases_per_day_count</span>
	</div>
</div>
<div class="col">
	<div class="row no-gutters align-content-center about_us_stat_circle">
		Положит. отзывов: <span>$reviews_count</span>
	</div>
</div>
_END;

			mysqli_close($connect);
		}



		// Разделить массив на части (#12)
		function split_arrays($inputArr, $splitStr) {
		    $outputArr = array();
		    $i = 0;
		    
		    foreach($inputArr as $data) {
		    	// Если данные равны указанному разделителю
		        if ($data == $splitStr) {
		            $i++;
		            continue;
		        }

		        $outputArr[$i][] = $data;
		    }

		    return $outputArr;
		}



		// Генерация случайного ключа для ЮКасса (#13)
		function gen_uuid() {
			return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
				mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
				mt_rand( 0, 0xffff ),
				mt_rand( 0, 0x0fff ) | 0x4000,
				mt_rand( 0, 0x3fff ) | 0x8000,
				mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
			);
		}



		// Генерация даты доставки (#14)
		function arrivladateGen() {
			$date_1 = date("d", strtotime("+3 day"));
			$date_2 = date("d", strtotime("+5 day"));
			$mounth = date("M");

			switch ($mounth) {
				case 'Jan' : $mounth = 'января'; break;
				case 'Feb' : $mounth = 'февраля'; break;
				case 'Mar' : $mounth = 'марта'; break;
				case 'Apr' : $mounth = 'апреля'; break;
				case 'May' : $mounth = 'мая'; break;
				case 'Jun' : $mounth = 'июня'; break;
				case 'Jul' : $mounth = 'июля'; break;
				case 'Aug' : $mounth = 'августа'; break;
				case 'Sep' : $mounth = 'сентября'; break;
				case 'Oct' : $mounth = 'октября'; break;
				case 'Nov' : $mounth = 'ноября'; break;
				case 'Dec' : $mounth = 'декабря';
			}

			return "$date_1-$date_2 $mounth";
		}


		
	}
?>