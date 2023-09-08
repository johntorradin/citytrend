<?php
	// Класс "Панель администратора" (#class)
	class AdminPanel {



		// Проверка авторизации в аккаунте админа (#1)
		function checkUser() {
			session_start();
			require_once 'config.php';
			require_once 'other.php';
			$config = new Config;
			$other = new Other;

			// Если пользователь не авторизован
			if(!isset($_SESSION['login'])) {
				header('Location: ' . $config->site_url . 'page_404', true, 301);

				return;
			}

			$login = $_SESSION['login'];

			// Если логин не принадлежит админу
			if($login != $config->ap_user) {
				header('Location: ' . $config->site_url . 'page_404', true, 301);

				return;
			}

			echo 
<<<_END
<form id="ap_form" action="#">
	<div id="ap" class="account_enter">
		<div class="row no-gutters justify-content-start">
			<div class="col-12">
				<div class="row no-gutters align-items-center justify-content-start">
					<h1 class="account_data_line_title">Панель администратора</h1>
					<h1 class="account_data_line_note">Используйте кнопки для управления БД.</h1>
				</div>
			</div>
			<div class="col-12">
				<div class="row no-gutters justify-content-between">
					<a href="/" id="account_go_to_main" class="ap_btn">Вернуться на главную</a>
					<button onclick="panel.selectReviews()" class="ap_btn">Вывести отзывы</button>
					<button onclick="panel.selectDeliverys()" class="ap_btn">Вывести доставки</button>
					<button onclick="panel.selectPurchases()" class="ap_btn">Вывести покупки</button>
				</div>
			</div>
			<div class="col-12">
				<div class="row no-gutters justify-content-center">
					<div class="col-6">
						<textarea class="ap_textarea"></textarea>
					</div>
					<div class="col-6">
						<div class="row no-gutters justify-content-center">
							<div class="col-12">
								<div class="row no-gutters justify-content-center">
									<input id="review_id" placeholder="Введите ID отзыва" type="text" class="ap_input">
								</div>
							</div>
							<div class="col-12">
								<div class="row no-gutters justify-content-center">
									<button onclick="panel.allowReview()" class="ap_btn">Разрешить отзыв</button>
								</div>
							</div>	
							<div class="col-12">
								<div class="row no-gutters justify-content-center">
									<input id="delivery_id" placeholder="Введите ID доставки" type="text" class="ap_input">
								</div>
							</div>
							<div class="col-12">
								<div class="row no-gutters justify-content-center">
									<button onclick="panel.setPurchase()" class="ap_btn">Подтвердить получение</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
_END;
		}



		// Вывести отзывы (#2)
		function selectReviews() {
			require_once 'config.php';
			require_once 'other.php';
			$config = new Config;
			$other = new Other;

			echo "ID / Дата / Логин / Артикул / Текст / Рейтинг / Рекомендую / Публиковать?";
			echo "\n\n";

			$connect = $other->dbConnect();

			$query = "SELECT * FROM reviews ORDER BY id DESC";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			for($i = 0; $i < $rows; $i++) {
				$review = mysqli_fetch_assoc($result);
				$id = $review['id'];
				$pubdate = $review['pubdate'];
				$user_id = $review['user_id'];
				$artikul = $review['artikul'];
				$comment = $review['comment'];
				$rating = $review['rating'];
				$advise = $review['advise'];
				$allow = $review['allow'];

				echo "$id / $pubdate / $user_id / $artikul / $comment / $rating / $advise / $allow";
				echo "\n\n";
			}
		}



		// Вывести доставки (#3)
		function selectDeliverys() {
			require_once 'config.php';
			require_once 'other.php';
			$config = new Config;
			$other = new Other;

			echo "ID / Дата / Логин / Fingerprint / Адрес / Трэк-номер / Артикул / Доставлено?";
			echo "\n\n";

			$connect = $other->dbConnect();
			$query = "SELECT * FROM deliverys ORDER BY id";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			for($i = 0; $i < $rows; $i++) {
				$review = mysqli_fetch_assoc($result);
				$id = $review['id'];
				$arrivaldate = $review['arrivaldate'];
				$user_id = $review['user_id'];
				$fingerprint = $review['fingerprint'];
				$address = $review['address'];
				$track_num = $review['track_num'];
				$artikul = $review['artikul'];
				$arrived = $review['arrived'];

				echo "$id / $arrivaldate / $user_id / $fingerprint / $address / $track_num / $artikul / $arrived";
				echo "\n\n";
			}
		}



		// Вывести покупки (#4)
		function selectPurchases() {
			require_once 'config.php';
			require_once 'other.php';
			$config = new Config;
			$other = new Other;

			echo "ID / Дата / Время / Логин / Fingerprint / Артикул";
			echo "\n\n";

			$connect = $other->dbConnect();
			$query = "SELECT * FROM purchases ORDER BY id DESC";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			for($i = 0; $i < $rows; $i++) {
				$purchase = mysqli_fetch_assoc($result);
				$id = $purchase['id'];
				$purchdate = $purchase['purchdate'];
				$purchtime = $purchase['purchtime'];
				$user_id = $purchase['user_id'];
				$fingerprint = $purchase['fingerprint'];
				$artikul = $purchase['artikul'];

				echo "$id / $purchdate / $purchtime / $user_id / $fingerprint / $artikul";
				echo "\n\n";
			}
		}



		// Разрешить публикацию отзыва (#5)
		function allowReview($id) {
			require_once 'config.php';
			require_once 'other.php';
			$config = new Config;
			$other = new Other;

			$id = $other->fixString($id);
			$connect = $other->dbConnect();
			$query = "UPDATE reviews SET allow = 'yes' WHERE id = '$id'";
			$result = mysqli_query($connect, $query);
		}



		// Подтвердить получение товара (#6)
		function setPurchase($id) {
			require_once 'config.php';
			require_once 'other.php';
			$config = new Config;
			$other = new Other;

			$id = $other->fixString($id);
			$connect = $other->dbConnect();
			$query_1 = "SELECT * FROM deliverys WHERE id = '$id'";
			$result_1 = mysqli_query($connect, $query_1);

			$delivery = mysqli_fetch_assoc($result_1);
			$id = $delivery['id'];
			$user_id = $delivery['user_id'];
			$fingerprint = $delivery['fingerprint'];
			$artikul = $delivery['artikul'];
			$size = $delivery['size'];
			$color = $delivery['color'];
			$hex = $delivery['hex'];
			$count = $delivery['count'];
			$price = $delivery['price'];
			$date = date("d.m.Y");
			$time = date('H:i', time());

			// Если пользователь не указан
			if($user_id == '')
				$user_id = 'NULL';

			$query_2 = "INSERT INTO purchases(purchdate, purchtime, user_id, fingerprint, artikul, size, color, hex, count, price) VALUES('$date', '$time', $user_id, '$fingerprint', '$artikul', '$size', '$color', '$hex', '$count', '$price')";
			$result_2 = mysqli_query($connect, $query_2);

			$query_3 = "DELETE FROM deliverys WHERE id = '$id'";
			$result_3 = mysqli_query($connect, $query_3);
		}



	}
?>