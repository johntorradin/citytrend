<?php 
	// Класс "Регистрация покупки" (#class)
	class PurchaseReg {



		// Получение строки покупки (#1)
		function purchaseStringSave($purchase) {
			session_start();
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$purchase = $other->fixString($purchase);
			$_SESSION['purchase'] = $purchase;
			$_SESSION['yookassa_payment'] = '';
			$_SESSION['yookassa_sum'] = '';
			$_SESSION['purchase_address'] = '';
		}



		// Вывод шага №1 (#2)
		function step_1() {
			session_start();
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$purchase = $_SESSION['purchase'];
			$pattern = '/[,|]/';
			$purchase = preg_split($pattern, $purchase);
			$purchase = $other->split_arrays($purchase, '');
			$count = count($purchase);

			echo 
<<<_END
<div class="row no-gutters justify-content-center purchase_step_1_main_zone">
	<div class="col-12">
		<div class="row no-gutters justify-content-center">
			<a href="/" class="purchase_go_to_main">Вернуться на главную</a>
			<h1 class="purchase_data_line_title">Покупка товара</h1>
			<h1 class="purchase_data_line_note">Для совершения покупки, нажмите на кнопку "Продолжить".</h1>
		</div>
	</div>
	<div class="col-12">
		<div class="row no-gutters justify-content-center">
			<div class="purchase_all_items_count">Товаров к покупке: <span id="items_count">$count</span></div>
			<div class="purchase_all_price">На сумму: <span id="all_sum"></span></div>
		</div>
	</div>
	<div class="col-12">
		<div class="row no-gutters justify-content-center">
			<button onclick="purchase.step_2()" id="purchase_next" class="purchase_next purchase_next_1">Продолжить</button>
		</div>
	</div>
</div>
<div class="row no-gutters purchase_items_list">
_END;

			$i = 0;

			foreach($purchase as $key) {
				$id = $purchase[$i][0];
				$artikul = $purchase[$i][1];
				$name = $purchase[$i][2];
				$color = $purchase[$i][3];
				$hex = $purchase[$i][4];
				$size = $purchase[$i][5];
				$count = $purchase[$i][6];
				$price = $purchase[$i][7];

				echo 
<<<_END
<div class="col-6 col-lg-4 col-xl-3">
	<div class="purchase_item">
		<div class="purchase_item_price"><span class="item_price">$price</span> <em class="fa fa-rub"></em></div>
		<a class="purchase_item_img_link">
			<img class="purchase_item_img" src="media/images/items/$artikul/1.jpg">
		</a>
		<div class="purchase_item_info_line">
			<a href="/item?id=$id" class="purchase_item_link">$name</a>
		</div>
		<div class="purchase_item_info_line">
			Размер: $size
		</div>
		<div class="purchase_item_info_line">
			<div class="row no-gutters align-items-center">
				Цвет:&nbsp;<div style="background: $hex" class="purchase_item_color_circle"></div><span class="purchase_item_color">&nbsp;$color
			</div>
		</div>
		<div class="purchase_item_info_line">
			<div class="row no-gutters align-items-center">
				Количество: <span class="purchase_item_count">$count</span>
			</div>
		</div>
	</div>
</div>
_END;

				$i++;
			}
		
			echo "</div>";
		}



		// Вывод шага №2 (#3)
		function step_2() {
			session_start();
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			// Если пользователь авторизован
			if(isset($_SESSION['login'])) 
				$address = $_SESSION['address'];

			// Если пользователь не авторизован
			else 
				$address = '';

			echo 
<<<_END
<div class="row no-gutters justify-content-start">
	<div class="col-12">
		<div class="row no-gutters align-items-center justify-content-start">
			<a href="/" class="purchase_go_to_main">Вернуться на главную</a>
			<h1 class="purchase_data_line_title">Доставка</h1>
			<h1 class="purchase_data_line_note">Укажите куда доставить товары и нажмите на кнопку "Продолжить".</h1>
		</div>
	</div>
	<div class="col-12">
		<div class="purchase_data_line">
			<div class="row no-gutters align-items-center">
				<div class="col-2 purchase_data_title">
					<em class="fa fa-map-marker"></em> Адрес доставки:
				</div>
				<div class="col-8">
					<input onchange="purchase.addressCheck(this.value)" id="purchase_field_1" class="purchase_field" type="text" value="$address" placeholder="Введите здесь адрес доставки...">
					<em class="fa fa-times purchase_field_times"></em>
					<span class="purchase_field_error_note"></span>
				</div>
			</div>
		</div>
	</div>
	<div class="col-12">
		<div class="row no-gutters justify-content-between">
			<button onclick="purchase.backToStep1()" id="purchase_back" class="purchase_back">Назад</button>
			<button onclick="purchase.addressClear()" id="purchase_clear" class="purchase_clear">Очистить</button>
			<button onclick="purchase.step_3()" id="purchase_next_2" class="purchase_next">Продолжить</button>
		</div>
	</div>
</div>
_END;
		}



		// Вывод шага №3 (#4)
		function step_3() {
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			echo 
<<<_END
<div class="row no-gutters justify-content-start">
	<div class="col-12">
		<div class="row no-gutters align-items-center justify-content-start">
			<a href="/" class="purchase_go_to_main">Вернуться на главную</a>
			<h1 class="purchase_data_line_title">Оплата</h1>
			<h1 class="purchase_data_line_note">Для оплаты покупки, нажмите на кнопку "Оплатить", после чего Вы будете перенаправлены на страницу выбора метода оплаты.</h1>
		</div>
	</div>
	<div class="col-12">
		<div class="row no-gutters justify-content-center">
			<button onclick="purchase.backToStep2()" id="purchase_back_2" class="purchase_back">Назад</button>
			<button onclick="purchase.finish()" id="purchase_finish" class="purchase_finish">Оплатить</button>
		</div>
	</div>
	<div class="col-12">
		<h1 class="purchase_metods_title">Мы принимаем</h1>
		<div class="row no-gutters justify-content-center purchase_metods_info">
			<div class="purchase_metod">
				<img src="media/images/static/footer_pay_1.png" class="purchase_metod_img">
			</div>
			<div class="purchase_metod">
				<img src="media/images/static/footer_pay_2.png" class="purchase_metod_img">
			</div>
			<div class="purchase_metod">
				<img src="media/images/static/footer_pay_3.png" class="purchase_metod_img">
			</div>
			<div class="purchase_metod">
				<img src="media/images/static/footer_pay_4.png" class="purchase_metod_img">
			</div>
			<div class="purchase_metod">
				<img src="media/images/static/footer_pay_5.png" class="purchase_metod_img">
			</div>
			<div class="purchase_metod">
				<img src="media/images/static/footer_pay_6.png" class="purchase_metod_img">
			</div>
		</div>
	</div>
</div>
_END;
		}



		// Перенаправление на страницу оплаты (#5)
		function finish($sum, $address, $fingerprint) {
			session_start();
			require_once 'config.php';
			require_once 'other.php';
			$config = new Config;
			$other = new Other;

			$sum = $other->fixString($sum);
			$address = $other->fixString($address);
			$fingerprint = $other->fixString($fingerprint);
			$data = array(
				'amount' => array(
			 		'value' => $sum,
			 		'currency' => 'RUB',
			 	),
			 	'capture' => true,
			 	'confirmation' => array(
			 		'type' => 'redirect',
			 		'return_url' => $config->site_url . 'purchase_finish',
			 	),
				'description' => 'Тестовый заказ',
				'metadata' => array(
			 		'order_id' => 1,
			 	)
			);

			$yookassa_shop_id = $config->yookassa_shop_id;
			$yookassa_secret_key = $config->yookassa_secret_key;
			$random_key = $other->gen_uuid();
			 
			$data = json_encode($data, JSON_UNESCAPED_UNICODE);
			 	
			$ch = curl_init('https://api.yookassa.ru/v3/payments');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_USERPWD, $yookassa_shop_id . ':' . $yookassa_secret_key);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Idempotence-Key: ' . $random_key));
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 	
			$res = curl_exec($ch);
			curl_close($ch);	
				
			$res = json_decode($res, true);
			$_SESSION['yookassa_payment'] = $res;
			$_SESSION['yookassa_sum'] = $sum;
			$_SESSION['yookassa_key'] = $random_key;
			$_SESSION['purchase_address'] = $address;
			$_SESSION['purchase_fingerprint'] = $fingerprint;
			print_r($res);
		}



		// Проверка статуса оплаты (#6)
		function checkPayment() {
			session_start();
			require_once 'config.php';
			require_once 'other.php';
			$config = new Config;
			$other = new Other;

			$payment = $_SESSION['yookassa_payment'];
			$payment_id = $payment['id'];
			$key = $_SESSION['yookassa_key'];
			$order_id = $payment['confirmation']['confirmation_url'];
			$yookassa_shop_id = $config->yookassa_shop_id;
			$yookassa_secret_key = $config->yookassa_secret_key;
 
			$ch = curl_init('https://api.yookassa.ru/v3/payments/' . $payment_id);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_USERPWD, $yookassa_shop_id . ':' . $yookassa_secret_key);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Idempotence-Key: ' . $key));
			$res = curl_exec($ch);
			curl_close($ch);
				
			$res = json_decode($res, true);

			$status = $res['status'];

			return $status;
		}



		// Обновление БД после успешной оплаты
		function dbUpdate() {
			session_start();
			require_once 'config.php';
			require_once 'other.php';
			$config = new Config;
			$other = new Other;

			$address = $_SESSION['purchase_address'];
			$purchase = $_SESSION['purchase'];
			$pattern = '/[,|]/';
			$purchase = preg_split($pattern, $purchase);
			$purchase = $other->split_arrays($purchase, '');
			$count = count($purchase);
			$arrivaldate = $other->arrivladateGen();

			$connect = $other->dbConnect();

			$i = 0;

			foreach($purchase as $key) {
				$id = $purchase[$i][0];
				$artikul = $purchase[$i][1];
				$name = $purchase[$i][2];
				$color = $purchase[$i][3];
				$hex = $purchase[$i][4];
				$size = $purchase[$i][5];
				$count = $purchase[$i][6];
				$price = $purchase[$i][7];
				$track_num = $other->keyGenerate(14);

				$query_1 = "UPDATE haves SET count = count - $count WHERE artikul = '$artikul' AND color = '$color' AND size = '$size'";

				// Если пользователь авторизован
				if(isset($_SESSION['login'])) {
					$user_id = $_SESSION['user_id'];
					$query_2 = "DELETE FROM shopping_carts WHERE user_id = '$user_id' AND artikul = '$artikul' AND color = '$color' AND size = '$size'";

					$query_3 = "INSERT INTO deliverys(address, arrivaldate, track_num, user_id, fingerprint, artikul, size, color, hex, count, price, arrived) VALUES('$address', '$arrivaldate', '$track_num', '$user_id', '', '$artikul', '$size', '$color', '$hex', '$count', '$price', 'no')";
				}

				// Если пользователь не авторизован
				else {
					$fingerprint = $_SESSION['purchase_fingerprint'];
					$query_2 = "DELETE FROM shopping_carts WHERE fingerprint = '$fingerprint' AND artikul = '$artikul' AND color = '$color' AND size = '$size'";

					$query_3 = "INSERT INTO deliverys(address, arrivaldate, track_num, user_id, fingerprint, artikul, size, color, hex, count, price, arrived) VALUES('$address', '$arrivaldate', '$track_num', NULL, '$fingerprint', '$artikul', '$size', '$color', '$hex', '$count', '$price', 'no')";
				}

				$result_1 = mysqli_query($connect, $query_1);
				$result_2 = mysqli_query($connect, $query_2);
				$result_3 = mysqli_query($connect, $query_3);

				$i++;
			}

			mysqli_close($connect);

			$_SESSION['purchase'] = '';
			$_SESSION['yookassa_payment'] = '';
			$_SESSION['yookassa_sum'] = '';
			$_SESSION['yookassa_key'] = '';
			$_SESSION['purchase_address'] = '';
			$_SESSION['purchase_fingerprint'] = '';

			echo 
<<<_END
<div class="container">
	<img src="media/images/static/white_back.jpg" class="page_404_back">
	<div class="row no-gutters justify-content-center page_404_box">
		<div>
			<div class="row no-gutters align-items-center">
				<div class="col-4">
					<img src="../media/images/static/success.png" class="purchase_success">
				</div>
				<div class="col-8">
					<span class="page_404_text">
						Отлично!<br>
						Заказ был оформлен!
					</span>
					<div class="row no-gutters">
						<a href="/" class="rules_go_to_main">Вернуться на Главную</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
_END;
		}



	}
?>