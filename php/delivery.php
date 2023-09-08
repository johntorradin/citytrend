<?php 
	// Класс "Доставки" (#class)
	class Delivery {



		// Вывести товары в доставках пользователя (#1)
		function selectItems($fp) {
			session_start();
			require_once 'config.php';
			require_once 'other.php';
			$config = new Config;
			$other = new Other;

			$connect = $other->dbConnect();

			// Если пользователь НЕ авторизован
			if(!isset($_SESSION['login'])) {
				$fingerprint = $other->fixString($fp);
				$query = "
					SELECT 
					items.id AS 'id', 
					items.firm AS 'firm',
					items.name AS 'name',
					items.artikul AS 'artikul',
					deliverys.size AS 'size',
					deliverys.count AS 'count',
					deliverys.price AS 'price',
					deliverys.address AS 'address',
					deliverys.arrivaldate AS 'arrivaldate',
					deliverys.track_num AS 'track_num',
					deliverys.color AS 'color',
					deliverys.hex AS 'hex'
					FROM items 
					JOIN deliverys ON deliverys.artikul = items.artikul
	                WHERE deliverys.fingerprint = '$fingerprint' AND deliverys.arrived = 'no'
					GROUP BY deliverys.id DESC
				";
			}

			// Если пользователь авторизован
			else {
				$user_id = $_SESSION['user_id'];
				$query = "
					SELECT 
					items.id AS 'id', 
					items.firm AS 'firm',
					items.name AS 'name',
					items.artikul AS 'artikul',
					deliverys.size AS 'size',
					deliverys.count AS 'count',
					deliverys.price AS 'price',
					deliverys.address AS 'address',
					deliverys.arrivaldate AS 'arrivaldate',
					deliverys.arrived AS 'arrived_state',
					deliverys.track_num AS 'track_num',
					deliverys.color AS 'color',
					deliverys.hex AS 'hex'
					FROM items 
					JOIN deliverys ON deliverys.artikul = items.artikul
	                WHERE deliverys.user_id = '$user_id' AND deliverys.arrived = 'no'
					GROUP BY deliverys.id DESC
				";
			}

			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			// Если записи не найдены
			if($rows == 0) {
				echo 
<<<_END
<div class="delivery_is_null">
	<div class="row no-gutters align-items-center">
		<div class="col-2">
			<img src="../media/images/static/error_smile.png" class="delivery_error_smile">
		</div>
		<div class="col-10">
			<div class="row no-gutters is_null_text">
				На данный момент нет ни одной доставки.
			</div>
			<div class="row no-gutters">
				<a href="katalog" class="go_to_item_list">Перейти в Каталог</a>
			</div>
		</div>
	</div>
</div>
_END;
			}

			// Если записи найдены
			else {
				echo 
<<<_END
<div class="row no-gutters align-items-center justify-content-between top_line">
	<div class="col all_delivery_count">Всего заказов в пути: $rows</div>
	<hr class="delivery_box_line">
</div>
_END;

				for($i = 0; $i < $rows; $i++) {
					$item = mysqli_fetch_assoc($result);
					$id = $item['id'];
					$price = $item['price'];
					$firm = $item['firm'];
					$name = $item['name'];
					$artikul = $item['artikul'];
					$size = $item['size'];
					$color = $item['color'];
					$hex = $item['hex'];
					$count = $item['count'];
					$address = $item['address'];
					$arrivaldate = $item['arrivaldate'];
					$arrived_state = $item['arrived_state'];
					$track_num = $item['track_num'];
					$name = $other->stringReduce($name, 30);
					$firm = rtrim($firm, "!,.-");

					echo 
<<<_END
<div class="row no-gutters align-items-center justify-content-between delivery_item_box">
	<a target="blank" href="/item?id=$id" class="delivery_img_item_link">
		<img src="../media/images/items/$artikul/1.jpg" class="delivery_box_img">
	</a>
	<div class="col">
		<div class="row no-gutters align-items-center delivery_item_arrivaldate">
			Доставка: $arrivaldate
		</div>
		<div class="row no-gutters align-items-center delivery_item_count">
			Кол-во: $count
		</div>
		<div class="row no-gutters align-items-center delivery_item_info">
			код товара: $artikul
		</div>
		<a target="blank" href="/item?id=$id" class="delivery_item_link">$firm - $name</a>
		<div class="row no-gutters align-items-center delivery_item_info">
			$size размер, цвет:&nbsp;<span style="background: $hex" class="purchases_item_color"></span>&nbsp;$color
		</div>
		<div class="delivery_item_price">$price <em class="fa fa-rub"></em></div>
	</div>
	<div class="col delivery_address">
		Адрес доставки: <br>
		<span>$address</span>
	</div>
	<div class="col">
		<div class="row no-gutters justify-content-end">
			<div class="delivery_track_num">Трек-номер: <span>$track_num</span></div>
			<a href="https://www.pochta.ru/tracking" target="blank" class="track_link">Отслеживать</a>
		</div>
	</div>
</div>
_END;
				}
			}
		}



	}
?>