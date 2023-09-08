<?php 
	// Класс "Товар" (#class)
	class Item {



		// Загрузить заголовок и начальную информацию о товаре (#1)
		function titleSelect($id) {
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$connect = $other->dbConnect();
			$id = $other->fixString($id);

			$query = "
				SELECT 
				artikul,
				category, 
				firm, 
				name, 
				purchases, 
				rating
				FROM items
				WHERE id = '$id'
			";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			// Если записи не найдены
			if($rows == 0) {
				echo $config->site_url;

				return;
			}

			$item = mysqli_fetch_assoc($result);
			$artikul = $item['artikul'];
			$firm = $item['firm'];
			$name = $item['name'];
			$purchases = $item['purchases'];
			$rating = $item['rating'];
			$category = $item['category'];
			$rating = $other->ratingCount($rating);
			$short_name = $other->stringReduce($name, 30);
			$short_firm = rtrim($firm, "!,.-");

			echo 
<<<_END
<div id="bread_crumbs" class="row no-gutters align-items-center bread_crumbs">
	<a href="/" class="link">Главная</a>
	&nbsp;/&nbsp;
	<a id="item_category" href="/katalog?category=$category" class="link">$category</a>
	&nbsp;/&nbsp;
	<a href="/item?id=1" class="link actual_place">$firm - $name</a>
	<div class="content_item_title">
		<h1 data-name="$short_firm - $short_name" class="content_item_title_h1">$firm - $name</h1>
	</div>
</div>
<div class="row no-gutters align-items-center content_item_main_info">
	<div class="main_info">Код товара: <span class="main_info_item_id">$artikul</span></div>
	<div class="main_info">Покупок товара: $purchases</div>
	<div class="main_info">
		Средняя оценка: 
		<span class="main_info_stars">
			$rating
		</span>
	</div>
</div>
_END;

			mysqli_close($connect);
		}



		// Вывод слайдера с фото товара (#2)
		function photoSliderSelect($id) {
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$connect = $other->dbConnect();
			$id = $other->fixString($id);

			$query = "SELECT artikul FROM items WHERE id = '$id'";
			$result = mysqli_query($connect, $query);
			$item = mysqli_fetch_assoc($result);
			$artikul = $item['artikul'];
			$photo_count = count(array_diff(scandir("../media/images/items/$artikul/"), [".", ".."]));

			echo 
<<<_END
<div onclick="item.bigImgBoxShow($(this).children().attr('src'))" class="slider_active_image_box">
	<img id="slider_active_image" src="/media/images/items/$artikul/1.jpg" class="slider_active_image">
</div>

<div class="slider_wrapper item_images_slider_wrapper">
	<div class="slides_visible_box">
		<div id="item_images_slides_box" class="slides_box">
_END;

			for($i = 1; $i <= $photo_count; $i++) {
				echo 
<<<_END
<div onclick="item.imgActivate($(this).find('.slide_item_image').attr('src'))" id="slide-$i" class="slide item_images_slide">
	<a class="slide_item_link item_images_slider_link">
		<img src="../media/images/items/$artikul/$i.jpg" class="slide_item_image item_images_slider_image">
	</a>
</div>
_END;
			}

			echo 
<<<_END
</div>
	</div>
	<button class="slider_button item_images_slider_button slider_prev"><em class="fa fa-chevron-left"></em></button>
	<button class="slider_button item_images_slider_button slider_next"><em class="fa fa-chevron-right"></em></button>
</div>
<div class="slider_dots_box">
	<div class="row no-gutters justify-content-center align-items-center">
_END;

			for($i = 1; $i <= $photo_count; $i++) {
				echo
<<<_END
<button data-num="$i" class="slider_dot"></button>
_END;
			}

			echo "</div></div>";

			mysqli_close($connect);
		}



		// Вывод цветов (#3)
		function colorSelect($id) {
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$connect = $other->dbConnect();
			$id = $other->fixString($id);

			$query = "SELECT haves.color AS 'color', haves.hex AS 'hex' FROM haves JOIN items ON haves.artikul = items.artikul WHERE items.id = '$id' GROUP BY haves.color";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			for($i = 1; $i <= $rows; $i++) {
				$item = mysqli_fetch_assoc($result);
				$color = $item['color'];
				$hex = $item['hex'];

				// Когда счетчик стал равен кол-ву записей
				if($i == $rows) {
					echo 
<<<_END
<button onclick="item.sizesSelect($(this), $(this).find('#item_color').text())" class="item_color_btn">
	<div class="row no-gutters align-items-center">
		<div class="item_color_circle" style="background: $hex"></div>&nbsp;<span id="item_color">$color</span>
	</div>
</button>
_END;

					continue;
				}

				echo 
<<<_END
<button onclick="item.sizesSelect($(this), $(this).find('#item_color').text())" class="item_color_btn">
	<div class="row no-gutters align-items-center">
		<div class="item_color_circle" style="background: $hex"></div>&nbsp;<span id="item_color">$color</span>
	</div>
</button>
&nbsp;/&nbsp;
_END;
			}

			mysqli_close($connect);
		}



		// Вывод размеров (#4)
		function sizesSelect($artikul, $color) {
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$connect = $other->dbConnect();
			$artikul = $other->fixString($artikul);
			$color = $other->fixString($color);

			$query = "SELECT size FROM haves WHERE artikul = '$artikul' AND color = '$color' AND count > 0 GROUP BY size";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			// Если записи не найдены
			if($rows == 0) {
				echo '<span class="item_size_start_text">К сожалению товары с выбранным цветом закончились.</span>';

				return;
			}

			for($i = 1; $i <= $rows; $i++) {
				$item = mysqli_fetch_assoc($result);
				$size = $item['size'];

				// Когда счетчик стал равен кол-ву записей
				if($i == $rows) {
					echo 
<<<_END
<button onclick="item.sizeActivate($(this))" class="item_size_btn">$size</button>
_END;

					continue;
				}

				echo 
<<<_END
<button onclick="item.sizeActivate($(this))" class="item_size_btn">$size</button>&nbsp;/
_END;
			}

			mysqli_close($connect);
		}



		// Вывод характеристик и описания (#5)
		function charactersSelect($id) {
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$connect = $other->dbConnect();
			$id = $other->fixString($id);

			$query = "SELECT type, gender, season, material, firm, description FROM items WHERE id = '$id'";
			$result = mysqli_query($connect, $query);
			$item = mysqli_fetch_assoc($result);
			$type = $item['type'];
			$gender = $item['gender'];
			$season = $item['season'];
			$material = $item['material'];
			$firm = $item['firm'];
			$description = $item['description'];

			echo 
<<<_END
<div class="item_characters_list">
	<h1 class="item_characters_list_h1">Доп. информация</h1>
	<table class="item_characters_table">
		<tr class="item_characters_table_tr">
			<td class="item_characters_table_td">Тип:</td>
			<td id="item_type">$type</td>
		</tr>
		<tr class="item_characters_table_tr">
			<td class="item_characters_table_td">На кого:</td>
			<td>$gender</td>
		</tr>
		<tr class="item_characters_table_tr">
			<td class="item_characters_table_td">Сезон:</td>
			<td>$season</td>
		</tr>
		<tr class="item_characters_table_tr">
			<td class="item_characters_table_td">Материал:</td>
			<td>$material</td>
		</tr>
		<tr class="item_characters_table_tr">
			<td class="item_characters_table_td">Фирма:</td>
			<td>$firm</td>
		</tr>
	</table>
</div>
<div class="item_description_box">
	<h1 class="item_description_h1">Описание</h1>
	<p class="item_description_text">
		<span id="item_description">$description</span>
		<button onclick="item.descriptionShow()" class="description_read_more">Развернуть описание <em class="fa fa-caret-down"></em></button>
	</p>
</div>
_END;

			mysqli_close($connect);
		}



		// Загрузить цену (#6)
		function priceSelect($id) {
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$connect = $other->dbConnect();
			$id = $other->fixString($id);

			$query = "SELECT price, old_price FROM items WHERE id = '$id'";
			$result = mysqli_query($connect, $query);
			$item = mysqli_fetch_assoc($result);
			$price = $item['price'];
			$old_price = $item['old_price'];

			$arrivaldate = $other->arrivladateGen();

			echo 
<<<_END
<form action="#" id="item_add_to_cart_form">
	<div class="row no-gutters align-items-center">
		<div class="item_actual_price"><span id="item_actual_price">$price</span> <em class="fa fa-rub"></em></div>
		<div class="item_old_price"><s>$old_price <em class="fa fa-rub"></em></s></div>
	</div>
	<div class="row no-gutters">
		<button onclick="item.buyNow(); return false" class="buy_item_now_btn">Купить сейчас</button>
	</div>
	<div class="row no-gutters">
		<button onclick="item.addToCart(); return false" class="add_item_to_cart_btn">Добавить в корзину</button>
	</div>
	<div class="row no-gutters item_price_box_delivery">
		Доставка:&nbsp;<span class="item_price_box_delivery_date">$arrivaldate</span>
	</div>
</form>
_END;

			mysqli_close($connect);
		}



		// Загрузить кол-во отзывов (#7)
		function reviewsCountSelect($id) {
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$connect = $other->dbConnect();
			$id = $other->fixString($id);

			$query = "SELECT COUNT(reviews.id) AS 'count' FROM reviews JOIN items ON reviews.artikul = items.artikul WHERE items.id = '$id'";
			$result = mysqli_query($connect, $query);
			$item = mysqli_fetch_assoc($result);
			$count = $item['count'];

			echo 
<<<_END
<div class="row no-gutters align-items-center item_reviews_sort_line">
	<div class="sort_line_reviews_count">
		Отзывов: $count
	</div>
_END;
			
			// Если отзывы есть
			if($count != 0) {
				echo 
<<<_END
	<div class="sort_line_sort_title">
		<em class="fa fa-sort"></em> Сортировать по <em class="fa fa-angle-right"></em>
	</div>
	<button onclick="item.reviewsSelect($(this), '0', 'новые')" class="sort_line_sort_btn sort_line_sort_btn_active"><em class="fa fa-clock-o"></em> Сначала новые</button>
	<button onclick="item.reviewsSelect($(this), '0', 'старые')" class="sort_line_sort_btn"><em class="fa fa-clock-o"></em> Сначала старые</button>
	<button onclick="item.reviewsSelect($(this), '0', 'рейтинг-вниз')" class="sort_line_sort_btn"><em class="fa fa-star-o"></em> Сначала высокий рейтинг</button>
	<button onclick="item.reviewsSelect($(this), '0', 'рейтинг-вверх')" class="sort_line_sort_btn"><em class="fa fa-star-o"></em> Сначала низкий рейтинг</button>
_END;
			}

			echo "</div>";

			mysqli_close($connect);
		}



		// Загрузить отзывы (#8)
		function reviewsSelect($id, $sort, $offset) {
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$connect = $other->dbConnect();
			$id = $other->fixString($id);
			$sort = $other->fixString($sort);
			$offset = $other->fixString($offset);
			$limit = $config->reviews_count;

			// Если выбрана сортировка "сначала новые"
			if($sort == 'новые')
				$sort = "ORDER BY reviews.id DESC";

			// Если выбрана сортировка "сначала старые"
			else if($sort == 'старые')
				$sort = "ORDER BY reviews.id";

			// Если выбрана сортировка "сначала высокий рейтинг"
			else if($sort == 'рейтинг-вниз')
				$sort = "ORDER BY reviews.rating DESC";

			// Если выбрана сортировка "сначала низкий рейтинг"
			else if($sort == 'рейтинг-вверх')
				$sort = "ORDER BY reviews.rating";

			$query = "
				SELECT 
				reviews.pubdate AS 'pubdate',
				reviews.pubtime AS 'pubtime',
				reviews.advantages AS 'advantages',
				reviews.comment AS 'comment',
				reviews.rating AS 'rating',
				reviews.advise AS 'advise',	
				users.name AS 'name',
				users.login AS 'login',
				users.avatar AS 'avatar'
				FROM reviews 
				JOIN items ON reviews.artikul = items.artikul
				JOIN users ON reviews.user_id = users.id
				WHERE 
				items.id = '$id' AND
				reviews.allow = 'yes'
				GROUP BY reviews.id
				$sort
				LIMIT $offset, $limit
			";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			// Если записей не найдено
			if($rows == 0) {
				echo 
<<<_END
<div class="item_reviews_is_null">
	<div class="row no-gutters align-items-center">
		<div class="col-3">
			<img src="../media/images/static/error_smile.png" class="item_reviews_error_smile">
		</div>
		<div class="col-9">
			<span class="item_reviews_error_text">У товара пока нет отзывов.</span>
		</div>
	</div>
</div>
_END;

				return;
			}

			for($i = 0; $i < $rows; $i++) {
				$review = mysqli_fetch_assoc($result);
				$pubdate = $review['pubdate'];
				$pubtime = $review['pubtime'];
				$advantages = $review['advantages'];
				$comment = $review['comment'];
				$rating = $review['rating'];
				$advise = $review['advise'];
				$name = $review['name'];
				$login = $review['login'];
				$avatar = $review['avatar'];
				$rating = $other->ratingCount($rating);
				$random_num = rand(0, 99999999999999999) / 100000000000000000;
				$advantages = explode(' | ', $advantages);
				$adv = '';

				foreach($advantages as $a) {
					$adv .= '<span class="review_advantage">' . $a . '</span>';
				}

				// Если у пользователя есть аватарка
				if($avatar == 'yes')
					$src = '../media/images/avatars/' . $login . '.jpg?v=$random_num';

				// Если у пользователя нет аватарки
				else 
					$src = '../media/images/avatars/default.jpg?v=$random_num';

				echo 
<<<_END
<div class="col-12 col-xl-6 review_container">
	<div class="review">
		<div class="row no-gutters review_date">
			$pubdate в $pubtime
		</div>
		<div class="row no-gutters align-items-center review_author">
			Покупатель: <span class="review_author_name">$name</span>
			<div class="review_account_avatar">
				<img src="$src" class="review_account_avatar_img">
			</div>
		</div>
		<div class="row no-gutters align-items-center review_rating">
			<span class="review_rating_title">Оценка:</span> 
			<span class="review_rating_stars">
				$rating
			</span>
		</div>
		<div class="row no-gutters review_advantages_disadvantages">
			<div class="col-12 review_advantages">
				<div class="review_advantages_title">Плюсы:</div>
				$adv
			</div>
		</div>
		<div class="row no-gutters review_comment">
			<div class="review_comment_title">Комментарий:</div>
			<p class="review_comment_text">
				$comment
			</p>
		</div>
	</div>
</div>
_END;
			}

			// Если кол-во записей больше лимита
			if($rows >= $limit) {
				echo 
<<<_END
<div class="col-12">
	<div class="row no-gutters justify-content-center">
		<form action="#" id="download_more_reviews_form">
			<button onclick="item.reviewsSelect($(this), $limit, '')" class="download_more_reviews">Показать больше отзывов <em class="fa fa-arrow-down"></em></button>
		</form>
	</div>
</div>
_END;
			}

			mysqli_close($connect);
		}



		// Вывести похожие вещи (#9)
		function similarItemsSelect($category, $type) {
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$connect = $other->dbConnect();
			$id = $other->fixString($id);
			$category = $other->fixString($category);
			$limit = $config->similar_items_count;
			$query = "SELECT * FROM items WHERE type = '$type' ORDER BY purchases DESC LIMIT $limit";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			echo 
<<<_END
<div class="col-12">
	<div class="row no-gutters justify-content-end similar_items_box_title_box">
		<h1 class="similar_items_box_title">Похожие вещи</h1>
	</div>
</div>
_END;

			for($i = 0; $i < $rows; $i++) {
				$item = mysqli_fetch_assoc($result);
				$id = $item['id'];
				$artikul = $item['artikul'];
				$price = $item['price'];
				$old_price = $item['old_price'];
				$firm = $item['firm'];
				$name = $item['name'];
				$purchases = $item['purchases'];
				$name = $other->stringReduce($name, 30);
				$firm = rtrim($firm, "!,.-");

				echo 
<<<_END
<div class="col-6 col-lg-4 col-xl-12">
	<div class="row no-gutters justify-content-end">
		<a href="/item?id=$id" class="similar_items_item">
			<img src="../media/images/items/$artikul/1.jpg" class="similar_items_item_image">
			<div class="similar_items_item_info">
				<div class="row no-gutters align-items-center similar_items_item_price">
					<span class="actual_price">$price <em class="fa fa-rub"></em></span>
					&nbsp;<span class="old_price"><s>$old_price <em class="fa fa-rub"></em></s></span>
				</div>
				<div class="row no-gutters similar_item_name">
					$firm - $name
				</div>
				<div class="row no-gutters align-items-center">
					<span class="other_item_purchases">Покупок товара: $purchases</span>
				</div>
			</div>
		</a>
	</div>
</div>
_END;
			}

			echo 
<<<_END
<div class="col-12">
	<div class="row no-gutters justify-content-end similar_items_more_box">
		<a href="/katalog?category=$category#type=$type" class="similar_items_more">Перейти к похожим <em class="fa fa-external-link-square"></em></a>
	</div>
</div>
_END;

			mysqli_close($connect);
		}



		// Добавить товар в список просмотренных
		function addItemToWatched($id, $fingerprint) {
			session_start();
			require_once 'config.php';
			require_once 'other.php';
			$config = new Config;
			$other = new Other;

			$id = $other->fixString($id);
			$connect = $other->dbConnect();

			// Если пользователь авторизован
			if(isset($_SESSION['login'])) {
				$user_id = $_SESSION['user_id'];
				$query_1 = "SELECT id FROM watched_items WHERE user_id = '$user_id' AND item_id = '$id'";
				$result_1 = mysqli_query($connect, $query_1);
				$rows_1 = mysqli_num_rows($result_1);

				// Если запись уже есть
				if($rows_1 != 0)
					return;

				$query_2 = "INSERT INTO watched_items(user_id, fingerprint, item_id) VALUES('$user_id', '', '$id')";
				$result_2 = mysqli_query($connect, $query_2);
			}

			// Если пользователь не авторизован
			else {
				$fingerprint = $other->fixString($fingerprint);
				$query_1 = "SELECT id FROM watched_items WHERE fingerprint = '$fingerprint' AND item_id = '$id'";
				$result_1 = mysqli_query($connect, $query_1);
				$rows_1 = mysqli_num_rows($result_1);

				// Если запись уже есть
				if($rows_1 != 0)
					return;

				$query_2 = "INSERT INTO watched_items(user_id, fingerprint, item_id) VALUES(NULL, '$fingerprint', '$id')";
				$result_2 = mysqli_query($connect, $query_2);
			}

			mysqli_close($connect);
		}



		// Добавить товар в корзину
		function addItemToCart($fingerprint, $artikul, $color, $size) {
			session_start();
			require_once 'config.php';
			require_once 'other.php';
			$config = new Config;
			$other = new Other;

			$fingerprint = $other->fixString($fingerprint);
			$artikul = $other->fixString($artikul);
			$color = $other->fixString($color);
			$size = $other->fixString($size);
			$connect = $other->dbConnect();

			// Если пользователь авторизован
			if(isset($_SESSION['login'])) {
				$user_id = $_SESSION['user_id'];
				$query_1 = "SELECT * FROM shopping_carts WHERE user_id = '$user_id' AND artikul = '$artikul' AND size = '$size' AND color = '$color'";
				$result_1 = mysqli_query($connect, $query_1);
				$rows = mysqli_num_rows($result_1);

				// Если запись найдена
				if($rows != 0) {
					echo 'Товар с такими характеристиками уже был добавлен в корзину.';

					return;
				}

				$query_2 = "INSERT INTO shopping_carts(user_id, fingerprint, artikul, size, color, count) VALUES('$user_id', '', '$artikul', '$size', '$color', '1')";
				$result_2 = mysqli_query($connect, $query_2);

				echo 'успех';
			}

			else {
				$fingerprint = $other->fixString($fingerprint);
				$query_1 = "SELECT * FROM shopping_carts WHERE fingerprint = '$fingerprint' AND artikul = '$artikul' AND size = '$size' AND color = '$color'";
				$result_1 = mysqli_query($connect, $query_1);
				$rows = mysqli_num_rows($result_1);

				// Если запись найдена
				if($rows != 0) {
					echo 'Товар с такими характеристиками уже был добавлен в корзину.';

					return;
				}

				$query_2 = "INSERT INTO shopping_carts(user_id, fingerprint, artikul, size, color, count) VALUES(NULL, '$fingerprint', '$artikul', '$size', '$color', '1')";
				$result_2 = mysqli_query($connect, $query_2);

				echo 'успех';
			}

			mysqli_close($connect);
		}



	}
?>