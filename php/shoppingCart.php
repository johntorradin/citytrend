<?php 
	// Класс "Корзина" (#class)
	class ShoppingCart {



		// Вывести товары в корзине пользователя (#1)
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
					items.price AS 'price', 
					items.old_price AS 'old_price', 
					items.firm AS 'firm',
					items.name AS 'name',
					items.artikul AS 'artikul',
					shopping_carts.size AS 'size',
					shopping_carts.color AS 'color',
					haves.hex AS 'hex',
					haves.count AS 'haves_count',
					shopping_carts.count AS 'selected_count'
					FROM items 
					JOIN shopping_carts ON shopping_carts.artikul = items.artikul
					JOIN haves ON shopping_carts.artikul = haves.artikul AND shopping_carts.color = haves.color AND shopping_carts.size = haves.size 
	                WHERE shopping_carts.fingerprint = '$fingerprint'
					GROUP BY shopping_carts.id DESC
				";
			}

			// Если пользователь авторизован
			else {
				$user_id = $_SESSION['user_id'];
				$query = "
					SELECT 
					items.id AS 'id', 
					items.price AS 'price', 
					items.old_price AS 'old_price', 
					items.firm AS 'firm',
					items.name AS 'name',
					items.artikul AS 'artikul',
					shopping_carts.size AS 'size',
					shopping_carts.color AS 'color',
					haves.hex AS 'hex',
					haves.count AS 'haves_count',
					shopping_carts.count AS 'selected_count'
					FROM items 
					JOIN shopping_carts ON shopping_carts.artikul = items.artikul
					JOIN haves ON shopping_carts.artikul = haves.artikul AND shopping_carts.color = haves.color AND shopping_carts.size = haves.size
	                WHERE shopping_carts.user_id = '$user_id'
					GROUP BY shopping_carts.id DESC
				";
			}

			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			// Если записи не найдены
			if($rows == 0) {
				echo 
<<<_END
<div class="shopping_cart_is_null">
	<div class="row no-gutters align-items-center">
		<div class="col-3">
			<img src="../media/images/static/error_smile.png" class="shopping_cart_error_smile">
		</div>
		<div class="col-9">
			<div class="row no-gutters is_null_text">
				Корзина пока пуста. <br>Но Вы можете это исправить!
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
<div class="row no-gutters align-items-center justify-content-between shopping_cart_box_top_line">
	<div class="col shopping_cart_box_all_count">
		<div class="shopping_cart_box_all_items">Всего товаров: <span id="cart_items_count">$rows</span></div>
		<div class="shopping_cart_box_all_selected">Выбрано к покупке: <span id="shopcart_checked_count">0</span></div>
		<button onclick="shopcart.buySelectedItems()" class="shopping_cart_selected_buy">Купить выбранное</button>
	</div>
	<div class="shopping_cart_box_all_price">Общая сумма: <span id="cart_price_sum"></span></div>
	<button onclick="shopcart.buyAllItems()" class="shopping_cart_buy_all">Купить всё</button>
	<hr class="shopping_cart_box_line">
</div>
_END;

				for($i = 0; $i < $rows; $i++) {
					$item = mysqli_fetch_assoc($result);
					$id = $item['id'];
					$price = $item['price'];
					$old_price = $item['old_price'];
					$firm = $item['firm'];
					$name = $item['name'];
					$artikul = $item['artikul'];
					$size = $item['size'];
					$color = $item['color'];
					$hex = $item['hex'];
					$haves_count = $item['haves_count'];
					$selected_count = $item['selected_count'];

					// Если кол-во товаров в наличии меньше запрошенного кол-ва
					if($haves_count < $selected_count) {
						$box = '<div class="row no-gutters align-items-center justify-content-between shopping_cart_item_box" data-id="' . $id . '">';
						$item_count_buttons = '<span class="cart_items_count_is_null">Товар закончился.</span>';
						$item_buy_button = '';
						$item_check_button = '';
					}

					// Если кол-во товаров в наличии не меньше запрошенного кол-ва
					else {
						$box = '<div class="row no-gutters align-items-center justify-content-between shopping_cart_item_box shopping_cart_item_box_allow" data-id="' . $id . '">';
						$item_count_buttons = '<button onclick="shopcart.itemCountMinus($(this))" class="shopcart_item_count_btn">-</button><span id="shopcart_item_count">' . $selected_count . '</span><button onclick="shopcart.itemCountPlus($(this))" class="shopcart_item_count_btn">+</button>';
						$item_buy_button = '<button onclick="shopcart.buyItem($(this))" class="shopping_cart_buy">Купить</button>';
						$item_check_button = '<button onclick="shopcart.checkItem($(this))" class="item_check"></button>';
					}

					$name = $other->stringReduce($name, 30);
					$firm = rtrim($firm, "!,.-");

					echo 
<<<_END
$box
	$item_check_button
	<button onclick="shopcart.deleteItem($(this))" class="item_delete"><em class="fa fa-trash-o"></em></button>
		<img src="../media/images/items/$artikul/1.jpg" class="shopping_cart_box_img">
	<div class="col">
		<div class="row no-gutters align-items-center shopping_cart_item_count_edit">
			$item_count_buttons
		</div>
		<div class="row no-gutters align-items-center shopping_cart_item_info">
			код товара: <span id="shopcart_item_artikul">$artikul</span>
		</div>
		<a target="blank" href="/item?id=$id" class="shopping_cart_item_link">$firm - $name</a>
		<div class="row no-gutters align-items-center shopping_cart_item_info">
			<span id="shopcart_item_size">$size</span>&nbsp;размер, цвет:&nbsp;<span style="background: $hex" class="purchases_item_color"></span>&nbsp;<span id="shopcart_item_color">$color</span>
		</div>
		<div class="shopping_cart_item_price">
			<span class="cart_item_price">$price</span> <em class="fa fa-rub"></em>
			<span class="shopping_cart_old_price"><s>$old_price <em class="fa fa-rub"></em></s></span>
		</div>
	</div>
	$item_buy_button
</div>
_END;
				}
			}
		}



		// Вывести в Header кол-во вещей в корзине (#2)
		function selectCount($fp) {
			session_start();
			require_once 'config.php';
			require_once 'other.php';
			$config = new Config;
			$other = new Other;

			$connect = $other->dbConnect();
			
			// Если пользователь НЕ авторизован
			if(!isset($_SESSION['login'])) {
				$fingerprint = $other->fixString($fp);
				$query = "SELECT COUNT(id) AS 'count' FROM shopping_carts WHERE fingerprint = '$fingerprint'";
			}

			// Если пользователь авторизован
			else {
				$user_id = $_SESSION['user_id'];
				$query = "SELECT COUNT(id) AS 'count' FROM shopping_carts WHERE user_id = '$user_id'";
			}

			$result = mysqli_query($connect, $query);
			$shopcart = mysqli_fetch_assoc($result);
			$count = $shopcart['count'];

			// Если кол-во равно нулю
			if($count == 0) return;

			echo '<span class="shopping_cart_count">' . $count . '</span>';

			mysqli_close($connect);
		}



		// Удалить товар из корзины (#3)
		function deleteItem($fp, $artikul, $size, $color) {
			session_start();
			require_once 'config.php';
			require_once 'other.php';
			$config = new Config;
			$other = new Other;

			$connect = $other->dbConnect();
			$artikul = $other->fixString($artikul);
			$size = $other->fixString($size);
			$color = $other->fixString($color);

			// Если пользователь НЕ авторизован
			if(!isset($_SESSION['login'])) {
				$fingerprint = $other->fixString($fp);
				$query = "DELETE FROM shopping_carts WHERE fingerprint = '$fingerprint' AND artikul = '$artikul' AND color = '$color' AND size = '$size'";
			}

			// Если пользователь авторизован
			else {
				$user_id = $_SESSION['user_id'];
				$query = "DELETE FROM shopping_carts WHERE user_id = '$user_id' AND artikul = '$artikul' AND color = '$color' AND size = '$size'";
			}

			$result = mysqli_query($connect, $query);

			mysqli_close($connect);
		}



		// Уменьшить кол-во товара (#4)
		function itemCountMinus($fp, $artikul, $size, $color) {
			session_start();
			require_once 'config.php';
			require_once 'other.php';
			$config = new Config;
			$other = new Other;

			$connect = $other->dbConnect();
			$artikul = $other->fixString($artikul);
			$size = $other->fixString($size);
			$color = $other->fixString($color);

			// Если пользователь НЕ авторизован
			if(!isset($_SESSION['login'])) {
				$fingerprint = $other->fixString($fp);
				$query = "UPDATE shopping_carts SET count = count - 1 WHERE fingerprint = '$fingerprint' AND artikul = '$artikul' AND size = '$size' AND color = '$color'";
			}

			// Если пользователь авторизован
			else {
				$user_id = $_SESSION['user_id'];
				$query = "UPDATE shopping_carts SET count = count - 1 WHERE user_id = '$user_id' AND artikul = '$artikul' AND size = '$size' AND color = '$color'";
			}

			$result = mysqli_query($connect, $query);

			mysqli_close($connect);
		}



		// Увеличить кол-во товара (#5)
		function itemCountPlus($fp, $artikul, $size, $color) {
			session_start();
			require_once 'config.php';
			require_once 'other.php';
			$config = new Config;
			$other = new Other;

			$connect = $other->dbConnect();
			$artikul = $other->fixString($artikul);
			$size = $other->fixString($size);
			$color = $other->fixString($color);

			// Если пользователь НЕ авторизован
			if(!isset($_SESSION['login'])) {
				$fingerprint = $other->fixString($fp);

				$query_1 = "SELECT count FROM haves WHERE artikul = '$artikul' AND size = '$size' AND color = '$color'";
				$query_2 = "SELECT count FROM shopping_carts WHERE artikul = '$artikul' AND size = '$size' AND color = '$color' AND fingerprint = '$fingerprint'";
			}

			// Если пользователь авторизован
			else {
				$user_id = $_SESSION['user_id'];

				$query_1 = "SELECT count FROM haves WHERE artikul = '$artikul' AND size = '$size' AND color = '$color'";
				$query_2 = "SELECT count FROM shopping_carts WHERE artikul = '$artikul' AND size = '$size' AND color = '$color' AND user_id = '$user_id'";
			}

			$result_1 = mysqli_query($connect, $query_1);
			$result_2 = mysqli_query($connect, $query_2);
			$data_1 = mysqli_fetch_assoc($result_1);
			$data_2 = mysqli_fetch_assoc($result_2);
			$haves_count = $data_1['count'];
			$selected_count = $data_2['count'];

			// Если кол-во единиц товара в наличии меньше или равно, чем выбранное кол-во товара для покупки
			if($haves_count <= $selected_count) {
				echo 'На складе отсутствует нужное кол-во товара.';

				return;
			}

			// Если пользователь НЕ авторизован
			if(!isset($_SESSION['login'])) {
				$query_2 = "UPDATE shopping_carts SET count = count + 1 WHERE fingerprint = '$fingerprint' AND artikul = '$artikul' AND size = '$size' AND color = '$color'";
			}

			// Если пользователь авторизован
			else {
				$query_2 = "UPDATE shopping_carts SET count = count + 1 WHERE user_id = '$user_id' AND artikul = '$artikul' AND size = '$size' AND color = '$color'";
			}

			$result = mysqli_query($connect, $query_2);

			echo 'Успех';

			mysqli_close($connect);
		}



	}	
?>