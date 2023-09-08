<?php 
	// Класс "Доставки" (#class)
	class PurchasesHeader {



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
					purchases.size AS 'size',
					purchases.count AS 'count',
					purchases.price AS 'price',
					purchases.purchdate AS 'purchdate',
					purchases.purchtime AS 'purchtime',
					purchases.color AS 'color',
					purchases.hex AS 'hex'
					FROM items 
					JOIN purchases ON purchases.artikul = items.artikul
	                WHERE purchases.fingerprint = '$fingerprint'
					GROUP BY purchases.id DESC
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
					purchases.size AS 'size',
					purchases.count AS 'count',
					purchases.price AS 'price',
					purchases.purchdate AS 'purchdate',
					purchases.purchtime AS 'purchtime',
					purchases.color AS 'color',
					purchases.hex AS 'hex'
					FROM items 
					JOIN purchases ON purchases.artikul = items.artikul 
	                WHERE purchases.user_id = '$user_id'
					GROUP BY purchases.id DESC
				";
				$query_2 = "SELECT COUNT(id) AS 'count' FROM reviews WHERE user_id = '$user_id'";
				$result_2 = mysqli_query($connect, $query_2);
				$reviews = mysqli_fetch_assoc($result_2);
				$reviews_count = 'Вы оставили отзывов: ' . '<span id="all_purchases_reviews_count">' . $reviews['count'] . '</span>';
			}

			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			// Если записи не найдены
			if($rows == 0) {
				echo 
<<<_END
<div class="purchases_is_null">
	<div class="row no-gutters align-items-center">
		<div class="col-2">
			<img src="../media/images/static/error_smile.png" class="purchases_error_smile">
		</div>
		<div class="col-10">
			<div class="row no-gutters is_null_text">
				Вы еще не купили у нас ни одного товара или товары пока доставляются.
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
	<div class="col all_purchases_count">Всего покупок: $rows</div>
	<div id="all_purchases_reviews" class="col all_purchases_reviews">$reviews_count</div>
	<hr class="purchases_box_line">
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
					$purchdate = $item['purchdate'];
					$purchtime = $item['purchtime'];
					$name = $other->stringReduce($name, 30);
					$firm = rtrim($firm, "!,.-");

					// Если пользователь авторизован
					if(isset($_SESSION['login'])) {
						$button = "<button onclick=\"reviews.showStep1('$artikul', '$id', '$firm', '$name')\" class=\"view_review_form\">Оставить отзыв</button>";
					}
					
					// Если пользователь не авторизован
					else $button = '';

					echo 
<<<_END
<div class="row no-gutters align-items-center justify-content-between purchases_item_box">
	<a href="/item?id=$id" class="purchases_item_img_link">
		<img src="../media/images/items/$artikul/1.jpg" class="purchases_box_img">
	</a>
	<div class="col">
		<div class="row no-gutters align-items-center delivery_item_count">
			Кол-во: $count
		</div>
		<div class="row no-gutters align-items-center purchases_item_info">
			код товара: <span class="purchases_item_artiul">$artikul</span>
		</div>
		<a href="/item?id=$id" class="purchases_item_link">$firm - $name</a>
		<div class="row no-gutters align-items-center purchases_item_info">
			$size размер, цвет:&nbsp;<span style="background: $hex" class="purchases_item_color"></span>&nbsp;$color
		</div>
		<div class="purchases_item_price">$price <em class="fa fa-rub"></em></div>
	</div>
	<div class="col purchases_date">
		Дата и время покупки: <br>
		<span>$purchdate в $purchtime</span>
	</div>
	$button
</div>
_END;
				}
			}

			mysqli_close($connect);
		}



	}
?>