<?php 
	// Класс "Выборка товаров" (#class)
	class ItemsSelect {



		// Вывод карточек товара на главной (Топ каталога) (#1)
		function mainTopCatalogItems($offset) {
			require '../php/config.php';
			require '../php/other.php';
			$config = new Config;
			$other = new Other;

			$offset = $other->fixString($offset);
			$items_count = $config->top_catalog_items_count;
			$connect = $other->dbConnect();
			$query = "SELECT * FROM items WHERE gender IN('мужчина', 'женщина') AND category = 'одежда' ORDER BY rating DESC LIMIT $offset, $items_count";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			// Если кол-во строк для отступа равно нулю
			if($offset == 0) {
				echo 
<<<_END
<div class="main_content_title">
	<div class="row no-gutters justify-content-center">	
		<h1 id="top_catalog_items_h1_title" class="main_content_title_h1">
			<span style="--i:1">Т</span>
			<span style="--i:2">о</span>
			<span style="--i:3">п</span>
			<span style="--i:4"> </span>
			<span style="--i:5">к</span>
			<span style="--i:6">а</span>
			<span style="--i:7">т</span>
			<span style="--i:8">а</span>
			<span style="--i:9">л</span>
			<span style="--i:10">о</span>
			<span style="--i:11">г</span>
			<span style="--i:12">а</span>
		</h1>
	</div>
</div>
_END;
			}

			for($i = 0; $i < $rows; $i++) {
				$item = mysqli_fetch_assoc($result);
				$id = $item['id'];
				$price = $item['price'];
				$old_price = $item['old_price'];
				$firm = $item['firm'];
				$name = $item['name'];
				$rating = $item['rating'];
				$advises = $item['advises'];
				$artikul = $item['artikul'];
				$name = $other->stringReduce($name, 30);
				$firm = rtrim($firm, "!,.-");
				$rating = $other->ratingCount($rating);

				echo
<<<_END
<div class="col-6 col-lg-4 col-xl-3">
	<a href="/item?id=$id" class="top_catalog_item">
		<img src="/media/images/items/$artikul/1.jpg" class="top_catalog_item_image">
		<div class="top_catalog_item_info">
			<div class="row no-gutters align-items-center top_catalog_item_price">
				<span class="actual_price">$price <em class="fa fa-rub"></em></span>
				&nbsp;<span class="old_price"><s>$old_price <em class="fa fa-rub"></em></s></span>
			</div>
			<div class="row no-gutters top_catalog_item_name">
				$firm - $name
			</div>
			<div class="row no-gutters align-items-center">
				<span class="top_catalog_item_rating">Рейтинг товара:</span> 
				<span class="top_catalog_item_stars">$rating</span>
			</div>
			<div class="row no-gutters align-items-center">
				<span class="top_catalog_item_recommented">Товар рекомендуют $advises чел.</span>
			</div>
		</div>
	</a>
</div>
_END;
			}

			// Если кол-во записей больше кол-ва требуемых записей для вывода
			if($rows >= $items_count) {
				echo 
<<<_END
<div id="top_items_more_button_box" class="col-12">
	<div class="row no-gutters justify-content-center">
		<form action="#" id="top_items_more_form">
			<button onclick="iselect.mainTopCatalogItems('$items_count')" id="top_items_more" type="submit" class="top_items_more">Показать больше топовых вещей <em class="fa fa-arrow-down"></em></button>
		</form>
	</div>
</div>
_END;
			}

			mysqli_close($connect);
		}



		// Вывод карточек товара на главной (Топовые скидки) (#2)
		function mainDiscountedItems() {
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$items_count = $config->discounted_items_count;
			$connect = $other->dbConnect();
			$query = "SELECT * FROM items WHERE gender IN('мужчина', 'женщина') AND category = 'одежда' ORDER BY old_price DESC LIMIT $items_count";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			// Если кол-во строк для отступа равно нулю
			if($offset == 0) {
				echo 
<<<_END
<div class="main_content_title">
	<div class="row no-gutters justify-content-start">
		<h1 id="discounted_items_h1_title" class="main_content_title_h1">
			<span style="--i:1">Т</span>
			<span style="--i:2">о</span>
			<span style="--i:3">п</span>
			<span style="--i:4">о</span>
			<span style="--i:5">в</span>
			<span style="--i:6">ы</span>
			<span style="--i:7">е</span>
			<span style="--i:8"> </span>
			<span style="--i:9">с</span>
			<span style="--i:10">к</span>
			<span style="--i:11">и</span>
			<span style="--i:12">д</span>
			<span style="--i:13">к</span>
			<span style="--i:14">и</span>
		</h1>
	</div>
</div>
_END;
			}

			for($i = 0; $i < $rows; $i++) {
				$item = mysqli_fetch_assoc($result);
				$id = $item['id'];
				$price = $item['price'];
				$old_price = $item['old_price'];
				$firm = $item['firm'];
				$name = $item['name'];
				$artikul = $item['artikul'];
				$purchases = $item['purchases'];
				$name = $other->stringReduce($name, 30);
				$firm = rtrim($firm, "!,.-");

				echo
<<<_END
<div class="col-6 col-lg-4 col-xl-3">
	<a href="/item?id=$id" class="discounted_item">
		<img src="/media/images/items/$artikul/1.jpg" class="discounted_item_image">
		<div class="discounted_item_info">
			<div class="row no-gutters align-items-center discounted_item_price">
				<span class="actual_price">$price <em class="fa fa-rub"></em></span>
				&nbsp;<span class="old_price"><s>$old_price <em class="fa fa-rub"></em></s></span>
			</div>
			<div class="row no-gutters discounted_item_name">
				$firm - $name
			</div>
			<div class="row no-gutters align-items-center">
				<span class="other_item_purchases">Покупок товара: $purchases</span>
			</div>
		</div>
	</a>
</div>
_END;
			}

			// Если кол-во записей больше кол-ва требуемых записей для вывода
			if($rows >= $items_count) {
				echo 
<<<_END
<div id="discounted_items_more_button_box" class="col-12">
	<div class="row no-gutters justify-content-center">
		<form action="#" id="discounted_items_more_form">
			<button onclick="iselect.mainDiscountedItemsMore('$items_count')" id="discounted_items_more" type="submit" class="discounted_items_more">Показать больше товаров со скидкой <em class="fa fa-arrow-down"></em></button>
		</form>
	</div>
</div>
_END;
			}

			mysqli_close($connect);
		}



		// Дополнительный вывод карточек товара на главной (Топовые скидки) (#3)
		function mainDiscountedItemsMore($offset) {
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$offset = $other->fixString($offset);
			$items_count = $config->discounted_items_count;
			$connect = $other->dbConnect();
			$query = "SELECT * FROM items WHERE gender IN('мужчина', 'женщина') AND category = 'одежда' ORDER BY old_price DESC LIMIT $offset, $items_count";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			// Если кол-во строк для отступа равно нулю
			if($offset == 0) {
				echo 
<<<_END
<div class="main_content_title">
	<div class="row no-gutters justify-content-start">
		<h1 id="discounted_items_h1_title" class="main_content_title_h1">
			<span style="--i:1">Т</span>
			<span style="--i:2">о</span>
			<span style="--i:3">п</span>
			<span style="--i:4">о</span>
			<span style="--i:5">в</span>
			<span style="--i:6">ы</span>
			<span style="--i:7">е</span>
			<span style="--i:8"> </span>
			<span style="--i:9">с</span>
			<span style="--i:10">к</span>
			<span style="--i:11">и</span>
			<span style="--i:12">д</span>
			<span style="--i:13">к</span>
			<span style="--i:14">и</span>
		</h1>
	</div>
</div>
_END;
			}

			for($i = 0; $i < $rows; $i++) {
				$item = mysqli_fetch_assoc($result);
				$id = $item['id'];
				$price = $item['price'];
				$old_price = $item['old_price'];
				$firm = $item['firm'];
				$name = $item['name'];
				$artikul = $item['artikul'];
				$name = $other->stringReduce($name, 30);
				$firm = rtrim($firm, "!,.-");

				echo
<<<_END
<div class="col-6 col-lg-4 col-xl-3">
	<a href="/item?id=$id" class="discounted_item">
		<img src="/media/images/items/$artikul/1.jpg" class="discounted_item_image">
		<div class="discounted_item_info">
			<div class="row no-gutters align-items-center discounted_item_price">
				<span class="actual_price">$price <em class="fa fa-rub"></em></span>
				&nbsp;<span class="old_price"><s>$old_price <em class="fa fa-rub"></em></s></span>
			</div>
			<div class="row no-gutters discounted_item_name">
				$firm - $name
			</div>
		</div>
	</a>
</div>
_END;
			}

			// Если кол-во записей больше кол-ва требуемых записей для вывода
			if($rows >= $items_count) {
				echo 
<<<_END
<div id="discounted_items_more_button_box" class="col-12">
	<div class="row no-gutters justify-content-center">
		<form action="#" id="discounted_items_more_form">
			<button onclick="iselect.mainDiscountedItemsMore('$items_count')" id="discounted_items_more" type="submit" class="discounted_items_more">Показать больше товаров со скидкой <em class="fa fa-arrow-down"></em></button>
		</form>
	</div>
</div>
_END;
			}

			mysqli_close($connect);
		}



		// Вывод карточек товара на главной (Новинки каталога) (#4)
		function mainNewItems() {
			require '../php/config.php';
			require '../php/other.php';
			$config = new Config;
			$other = new Other;

			$items_count = $config->new_items_count;
			$connect = $other->dbConnect();
			$query = "SELECT * FROM items WHERE gender IN ('мужчина', 'женщина') AND category = 'одежда' ORDER BY pubdate DESC LIMIT $items_count";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			echo
<<<_END
<div class="main_content_title">
	<div class="row no-gutters justify-content-center">
		<h1 id="new_items_h1_title" class="main_content_title_h1">
			<span style="--i:1">Н</span>
			<span style="--i:2">о</span>
			<span style="--i:3">в</span>
			<span style="--i:4">и</span>
			<span style="--i:5">н</span>
			<span style="--i:6">к</span>
			<span style="--i:7">и</span>
			<span style="--i:8"> </span>
			<span style="--i:9">к</span>
			<span style="--i:10">а</span>
			<span style="--i:11">т</span>
			<span style="--i:12">а</span>
			<span style="--i:13">л</span>
			<span style="--i:14">о</span>
			<span style="--i:15">г</span>
			<span style="--i:16">а</span>
		</h1>
	</div>
</div>

<div class="slider_wrapper">
	<div class="slides_visible_box">
		<div id="new_items_slides_box" class="slides_box">
_END;

			for($i = 0; $i < $rows; $i++) {
				$item = mysqli_fetch_assoc($result);
				$id = $item['id'];
				$price = $item['price'];
				$old_price = $item['old_price'];
				$firm = $item['firm'];
				$name = $item['name'];
				$artikul = $item['artikul'];
				$pubdate = $item['pubdate'];
				$name = $other->stringReduce($name, 30);
				$firm = rtrim($firm, "!,.-");

				echo
<<<_END
<div id="slide-$i" class="slide">
	<a href="/item?id=$id" class="new_item_link slide_item_link">
		<img src="../media/images/items/$artikul/1.jpg" class="slide_item_image">
		<div class="slide_item_info">
			<div class="row no-gutters align-items-center slide_item_price">
				<span class="slide_item_actual_price">$price <em class="fa fa-rub"></em></span>
				&nbsp;<span class="old_price"><s>$old_price <em class="fa fa-rub"></em></s></span>
			</div>
			<div class="row no-gutters slide_item_name">
				$firm - $name
			</div>
			<div class="row no-gutters publication_date">
				Новинка! <span>Добавлено: $pubdate</span>
			</div>
		</div>
	</a>
</div>
_END;
			}

			echo
<<<_END
</div>
	</div>
	<button class="slider_button slider_prev"><em class="fa fa-chevron-left"></em></button>
	<button class="slider_button slider_next"><em class="fa fa-chevron-right"></em></button>
</div>
<div class="slider_dots_box">
	<div class="row no-gutters align-items-center">
_END;

			for($i = 1; $i <= $rows; $i++) {
				echo
<<<_END
<button data-num="$i" class="slider_dot"></button>
_END;
			}

			echo
<<<_END
</div>
	</div>
	<div class="col-12">
		<div class="row no-gutters justify-content-end slider_items_more_box">
			<a id="new_items_more" href="/katalog?category=одежда#sort=новинки" class="slider_items_more">Перейти к новинкам <em class="fa fa-external-link-square"></em></a>
		</div>
	</div>
_END;

			mysqli_close($connect);
		}



		// Вывод карточек товара на главной (Возможно Вам понравится) (#5)
		function mainOtherItems() 
		{
			require '../php/config.php';
			require '../php/other.php';
			$config = new Config;
			$other = new Other;

			$items_count = $config->other_items_count;
			$connect = $other->dbConnect();
			$query = "SELECT * FROM items WHERE gender IN ('мужчина', 'женщина') ORDER BY rand(id) LIMIT $items_count";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			echo 
<<<_END
<div class="main_content_title">
	<div class="row no-gutters justify-content-start">
		<h1 id="other_items_h1_title" class="main_content_title_h1">
			<span style="--i:1">В</span>
			<span style="--i:2">о</span>
			<span style="--i:3">з</span>
			<span style="--i:4">м</span>
			<span style="--i:5">о</span>
			<span style="--i:6">ж</span>
			<span style="--i:7">н</span>
			<span style="--i:8">о</span>
			<span style="--i:9"> </span>
			<span style="--i:10">В</span>
			<span style="--i:11">а</span>
			<span style="--i:12">м</span>
			<span style="--i:13"> </span>
			<span style="--i:14">п</span>
			<span style="--i:15">о</span>
			<span style="--i:16">н</span>
			<span style="--i:17">р</span>
			<span style="--i:18">а</span>
			<span style="--i:19">в</span>
			<span style="--i:20">и</span>
			<span style="--i:21">т</span>
			<span style="--i:22">с</span>
			<span style="--i:23">я</span>
		</h1>
	</div>
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
				$purchases = $item['purchases'];
				$name = $other->stringReduce($name, 30);
				$firm = rtrim($firm, "!,.-");

				echo
<<<_END
<div class="col-6 col-lg-4 col-xl-3">
	<a href="/item?id=$id" class="other_item">
		<img src="/media/images/items/$artikul/1.jpg" class="other_item_image">
		<div class="other_item_info">
			<div class="row no-gutters align-items-center other_item_price">
				<span class="actual_price">$price <em class="fa fa-rub"></em></span>
				&nbsp;<span class="old_price"><s>$old_price <em class="fa fa-rub"></em></s></span>
			</div>
			<div class="row no-gutters other_item_name">
				$firm - $name
			</div>
			<div class="row no-gutters align-items-center">
				<span class="other_item_purchases">Покупок товара: $purchases</span>
			</div>
		</div>
	</a>
</div>
_END;
			}

			echo 
<<<_END
<div id="other_items_more_button_box" class="col-12">
	<div class="row no-gutters justify-content-center">
		<form action="#" id="other_items_more_form">
			<button onclick="iselect.mainOtherItemsMore('$items_count')" id="other_items_more" type="submit" class="other_items_more">Показать еще <em class="fa fa-arrow-down"></em></button>
		</form>
	</div>
</div>
_END;

			mysqli_close($connect);
		}



		// Дополнительный вывод карточек товара на главной (Топовые скидки) (#6)
		function mainOtherItemsMore($offset) {
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$offset = $other->fixString($offset);
			$items_count = $config->other_items_count;
			$connect = $other->dbConnect();
			$query = "SELECT * FROM items WHERE gender IN('мужчина', 'женщина') AND category = 'одежда' ORDER BY rand(id) LIMIT $offset, $items_count";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			// Если кол-во строк для отступа равно нулю
			if($offset == 0) {
				echo 
<<<_END
<div class="main_content_title">
	<div class="row no-gutters justify-content-start">
		<h1 id="other_items_h1_title" class="main_content_title_h1">
			<span style="--i:1">В</span>
			<span style="--i:2">о</span>
			<span style="--i:3">з</span>
			<span style="--i:4">м</span>
			<span style="--i:5">о</span>
			<span style="--i:6">ж</span>
			<span style="--i:7">н</span>
			<span style="--i:8">о</span>
			<span style="--i:9"> </span>
			<span style="--i:10">В</span>
			<span style="--i:11">а</span>
			<span style="--i:12">м</span>
			<span style="--i:13"> </span>
			<span style="--i:14">п</span>
			<span style="--i:15">о</span>
			<span style="--i:16">н</span>
			<span style="--i:17">р</span>
			<span style="--i:18">а</span>
			<span style="--i:19">в</span>
			<span style="--i:20">и</span>
			<span style="--i:21">т</span>
			<span style="--i:22">с</span>
			<span style="--i:23">я</span>
		</h1>
	</div>
</div>
_END;
			}

			for($i = 0; $i < $rows; $i++) {
				$item = mysqli_fetch_assoc($result);
				$id = $item['id'];
				$price = $item['price'];
				$old_price = $item['old_price'];
				$firm = $item['firm'];
				$name = $item['name'];
				$artikul = $item['artikul'];
				$purchases = $item['purchases'];
				$name = $other->stringReduce($name, 30);
				$firm = rtrim($firm, "!,.-");

				echo
<<<_END
<div class="col-6 col-lg-4 col-xl-3">
	<a href="/item?id=$id" class="other_item">
		<img src="/media/images/items/$artikul/1.jpg" class="other_item_image">
		<div class="other_item_info">
			<div class="row no-gutters align-items-center other_item_price">
				<span class="actual_price">$price <em class="fa fa-rub"></em></span>
				&nbsp;<span class="old_price"><s>$old_price <em class="fa fa-rub"></em></s></span>
			</div>
			<div class="row no-gutters other_item_name">
				$firm - $name
			</div>
			<div class="row no-gutters align-items-center">
				<span class="other_item_purchases">Покупок товара: $purchases</span>
			</div>
		</div>
	</a>
</div>
_END;
			}

			// Если кол-во записей больше кол-ва требуемых записей для вывода
			if($rows >= $items_count) {
				echo
<<<_END
<div id="other_items_more_button_box" class="col-12">
	<div class="row no-gutters justify-content-center">
		<form action="#" id="other_items_more_form">
			<button onclick="iselect.mainOtherItemsMore('$items_count')" id="other_items_more" type="submit" class="other_items_more">Показать еще <em class="fa fa-arrow-down"></em></button>
		</form>
	</div>
</div>
_END;
			}

			mysqli_close($connect);
		}



		// Вывод карточек товара на главной (Вы смотрели) (#7)
		function watchedItems($fp) {
			session_start();
			require '../php/config.php';
			require '../php/other.php';
			$config = new Config;
			$other = new Other;

			$items_count = $config->watched_items_count;
			$connect = $other->dbConnect();

			// Если пользователь авторизован
			if(isset($_SESSION['login'])) {
				$user_id = $_SESSION['user_id'];
				$query = "
					SELECT 
					items.id AS 'id', 
					items.price AS 'price', 
					items.old_price AS 'old_price', 
					items.firm AS 'firm',
					items.name AS 'name',
					items.artikul AS 'artikul',
					items.purchases AS 'purchases' 
					FROM items 
					JOIN watched_items ON items.id = watched_items.item_id
	                JOIN users ON users.id = '$user_id'
					WHERE watched_items.user_id = users.id
					GROUP BY watched_items.id DESC
					LIMIT $items_count
				";
			}

			// Если пользователь не авторизован
			else {
				$fingerprint = $other->fixString($fp);
				$query = "
					SELECT 
					items.id AS 'id', 
					items.price AS 'price', 
					items.old_price AS 'old_price', 
					items.firm AS 'firm',
					items.name AS 'name',
					items.artikul AS 'artikul',
					items.purchases AS 'purchases' 
					FROM items 
					JOIN watched_items ON items.id = watched_items.item_id
	                JOIN users ON users.fingerprint = '$fingerprint'
					WHERE watched_items.fingerprint = users.fingerprint
					GROUP BY watched_items.id DESC
					LIMIT $items_count
				";
			}

			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			// Если записи не найдены
			if($rows == 0) 
				return;

echo
<<<_END
<div class="watched_items_title">
	<div class="row no-gutters justify-content-start">
		<h1>Вы смотрели</h1>
	</div>
</div>

<div class="slider_wrapper">
	<div class="slides_visible_box">
		<div id="watched_items_slides_box" class="slides_box">
_END;

			for($i = 0; $i < $rows; $i++) {
				$item = mysqli_fetch_assoc($result);
				$id = $item['id'];
				$price = $item['price'];
				$old_price = $item['old_price'];
				$firm = $item['firm'];
				$name = $item['name'];
				$artikul = $item['artikul'];
				$purchases = $item['purchases'];
				$name = $other->stringReduce($name, 30);
				$firm = rtrim($firm, "!,.-");

				echo
<<<_END
<div class="slide">
	<a href="/item?id=$id" class="slide_item_link watched_item_link">
		<img src="/media/images/items/$artikul/1.jpg" class="slide_item_image">
		<div class="slide_item_info">
			<div class="row no-gutters align-items-center slide_item_price">
				<span class="slide_item_actual_price">$price <em class="fa fa-rub"></em></span>
				&nbsp;<span class="old_price"><s>$old_price <em class="fa fa-rub"></em></s></span>
			</div>
			<div class="row no-gutters slide_item_name">
				$firm - $name
			</div>
			<div class="row no-gutters align-items-center">
				<span class="other_item_purchases">Покупок товара: $purchases</span>
			</div>
		</div>
	</a>
</div>
_END;
			}

			echo
<<<_END
</div>
	</div>
	<button class="slider_button slider_prev"><em class="fa fa-chevron-left"></em></button>
	<button class="slider_button slider_next"><em class="fa fa-chevron-right"></em></button>
</div>
<div class="slider_dots_box">
	<div class="row no-gutters align-items-center">
_END;

			for($i = 1; $i <= $rows; $i++) {
				echo
<<<_END
<button data-num="$i" class="slider_dot"></button>
_END;
			}

			echo
<<<_END
</div>
	</div>
_END;

			mysqli_close($connect);
		}


		
	}
?>