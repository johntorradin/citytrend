<?php
	// Класс "Каталог" (#class)
	class Katalog {



		// Вывод кол-ва вещей (#1)
		function selectItemsCount($category, $gender, $type, $season, $firm, $material, $min_price, $max_price) {
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$category = $other->fixString($category);
			$gender = $other->fixString($gender);
			$type = $other->fixString($type);
			$season = $other->fixString($season);
			$firm = $other->fixString($firm);
			$material = $other->fixString($material);
			$min_price = $other->fixString($min_price);
			$max_price = $other->fixString($max_price);
			$connect = $other->dbConnect();
			$query = "
				SELECT 
				id AS 'id'
				FROM items 
				WHERE
				price >= '$min_price' AND 
				price <= '$max_price' AND
				category = '$category' AND
				gender LIKE '%$gender' AND
				type LIKE '%$type' AND
				season LIKE '%$season' AND
				firm LIKE '%$firm' AND
				material LIKE '%$material'
				GROUP BY id
			";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			echo 
<<<_END
<a href="/" class="link">Главная</a>
&nbsp;/&nbsp;
<a href="/katalog?category=$category" class="link actual_place">$category</a>
<div class="katalog_title">
	<h1 class="katalog_title_h1">$category</h1>
	<div class="sort_items_count">Найдено вещей: <span id="katalog_all_items_count">$rows</span></div>
</div>
_END;

			mysqli_close($connect);
		}



		// Вывод кнопок с фильтрами (#2)
		function filtersSelect($category) {
			require_once 'config.php';
			require_once 'other.php';
			$config = new Config;
			$other = new Other;

			$category = $other->fixString($category);
			$connect = $other->dbConnect();
			$query_1 = "SELECT gender FROM items WHERE category = '$category' GROUP BY gender";
			$query_2 = "SELECT type FROM items WHERE category = '$category' GROUP BY type";
			$query_3 = "SELECT season FROM items WHERE category = '$category' GROUP BY season";
			$query_4 = "SELECT firm FROM items WHERE category = '$category' GROUP BY firm";
			$query_5 = "SELECT material FROM items GROUP BY material";
			$result_1 = mysqli_query($connect, $query_1);
			$result_2 = mysqli_query($connect, $query_2);
			$result_3 = mysqli_query($connect, $query_3);
			$result_4 = mysqli_query($connect, $query_4);
			$result_5 = mysqli_query($connect, $query_5);
			$rows_1 = mysqli_num_rows($result_1);
			$rows_2 = mysqli_num_rows($result_2);
			$rows_3 = mysqli_num_rows($result_3);
			$rows_4 = mysqli_num_rows($result_4);
			$rows_5 = mysqli_num_rows($result_5);

			echo 
<<<_END
<div class="filters_title">
	<em class="fa fa-filter"></em>Фильтры <em class="fa fa-angle-right"></em>
</div>
<div class="filters_filter">
	<button onclick="katalog.resetFilters()" class="filters_filter_btn">Сбросить всё</button>
</div>
<div class="filters_filter">
	<button onclick="katalog.toggle(jQuery(this))" class="filters_filter_btn">На кого <em class="fa fa-angle-down"></em></button>
	<div class="filters_list">
		<div><button onclick="katalog.resetSelectFilter('gender', $(this))" class="filters_list_variable">Сбросить</button></div>
_END;

			for($i = 0; $i < $rows_1; $i++) {
				$filter = mysqli_fetch_assoc($result_1);
				$gender = $filter['gender'];

				echo 
<<<_END
		<div><button onclick="katalog.setFilter('gender', $(this))" class="filters_list_variable">$gender</button></div>
_END;
			}

			echo 
<<<_END
	</div>
		</div>
		<div class="filters_filter">
			<button onclick="katalog.toggle(jQuery(this))" class="filters_filter_btn">Тип <em class="fa fa-angle-down"></em></button>
			<div class="filters_list">
				<div><button onclick="katalog.resetSelectFilter('type', $(this)) "class="filters_list_variable">Сбросить</button></div>
_END;
			
			for($i = 0; $i < $rows_2; $i++) {
				$filter = mysqli_fetch_assoc($result_2);
				$type = $filter['type'];

				echo 
<<<_END
				<div><button onclick="katalog.setFilter('type', $(this))" class="filters_list_variable">$type</button></div>
_END;
			}

			echo 
<<<_END
	</div>
		</div>
		<div class="filters_filter">
			<button onclick="katalog.toggle(jQuery(this))" class="filters_filter_btn">Сезон <em class="fa fa-angle-down"></em></button>
			<div class="filters_list">
				<div><button onclick="katalog.resetSelectFilter('season', $(this))"class="filters_list_variable">Сбросить</button></div>
_END;

			for($i = 0; $i < $rows_3; $i++) {
				$filter = mysqli_fetch_assoc($result_3);
				$season = $filter['season'];

				echo 
<<<_END
				<div><button onclick="katalog.setFilter('season', $(this))" class="filters_list_variable">$season</button></div>
_END;
			}

			echo 
<<<_END
	</div>
		</div>
		<div class="filters_filter">
			<button onclick="katalog.toggle(jQuery(this))" class="filters_filter_btn">Фирма <em class="fa fa-angle-down"></em></button>
			<div class="filters_list">
				<div><button onclick="katalog.resetSelectFilter('firm', $(this))"class="filters_list_variable">Сбросить</button></div>
_END;

			for($i = 0; $i < $rows_4; $i++) {
				$filter = mysqli_fetch_assoc($result_4);
				$firm = $filter['firm'];

				echo 
<<<_END
				<div><button onclick="katalog.setFilter('firm', $(this))" class="filters_list_variable">$firm</button></div>
_END;
			}

			echo 
<<<_END
			</div>
				</div>
_END;

			echo 
<<<_END
	</div>
		</div>
		<div class="filters_filter">
			<button onclick="katalog.toggle(jQuery(this))" class="filters_filter_btn">Материал <em class="fa fa-angle-down"></em></button>
			<div class="filters_list">
				<div><button onclick="katalog.resetSelectFilter('material', $(this))"class="filters_list_variable">Сбросить</button></div>
_END;

			$str = '';

			for($i = 0; $i < $rows_5; $i++) {
				$item = mysqli_fetch_assoc($result_5);
				$str .= implode(', ', $item) . ', '; // Занести запись в строку
			}

			$str = substr($str, 0, -2); // Удалить последние 2 символа строки
			$materials = explode(', ', $str); // разделить строку на элементы массива
			$materials = array_unique($materials); // Убрать повторы в массиве

			foreach($materials as $mat) {
				echo 
<<<_END
				<div><button onclick="katalog.setFilter('material', $(this))" class="filters_list_variable">$mat</button></div>
_END;
			}

			echo 
<<<_END
			</div>
				</div>
_END;

			mysqli_close($connect);
		}



		// Вывод минимальной и максимальной цены (#3)
		function filtersPricesSelect($category) {
			require_once 'config.php';
			require_once 'other.php';
			$config = new Config;
			$other = new Other;

			$category = $other->fixString($category);
			$connect = $other->dbConnect();
			$query_1 = "SELECT MIN(price) AS 'price' FROM items WHERE category = '$category'";
			$query_2 = "SELECT MAX(price) AS 'price' FROM items WHERE category = '$category'";
			$result_1 = mysqli_query($connect, $query_1);
			$result_2 = mysqli_query($connect, $query_2);
			$item_1 = mysqli_fetch_assoc($result_1);
			$item_2 = mysqli_fetch_assoc($result_2);
			$min_price = $item_1['price'];
			$max_price = $item_2['price'];

			echo 
<<<_END
<div class="filter_price_title">Цена от</div>
<input onkeyup="katalog.setFilterPrice('min_price', $(this))" onkeydown="if(event.keyCode==13) {return false}" name="min_price" id="filter_min_price_field" class="filter_price_field" type="text" autocomplete="off" value="$min_price">
<div class="filter_price_title">до</div>
<input onkeyup="katalog.setFilterPrice('max_price', $(this))" onkeydown="if(event.keyCode==13) {return false}" name="max_price" id="filter_max_price_field" class="filter_price_field" type="text" autocomplete="off" value="$max_price">
_END;
			
		}



		// Выборка товаров (#4)
		function selectItems($category, $gender, $type, $season, $firm, $material, $min_price, $max_price, $sort, $page) {
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$category = $other->fixString($category);
			$gender = $other->fixString($gender);
			$type = $other->fixString($type);
			$season = $other->fixString($season);
			$firm = $other->fixString($firm);
			$material = $other->fixString($material);
			$min_price = $other->fixString($min_price);
			$max_price = $other->fixString($max_price);
			$sort = $other->fixString($sort);
			$page = $other->fixString($page);

			// Если сортировка равна указанному значению
			if($sort == 'популярность') 
				$sort = "ORDER BY id";

			// Если сортировка равна указанному значению
			else if($sort == 'рейтинг') 
				$sort = "ORDER BY rating DESC";

			// Если сортировка равна указанному значению
			else if($sort == 'цена-вверх') 
				$sort = "ORDER BY price";

			// Если сортировка равна указанному значению
			else if($sort == 'цена-вниз') 
				$sort = "ORDER BY price DESC";

			// Если сортировка равна указанному значению
			else if($sort == 'новинки') 
				$sort = "ORDER BY pubdate DESC";

			$limit = $config->sort_items_count;
			$offset = ($page * $limit) - $limit;
			$connect = $other->dbConnect();
			$query = "
				SELECT 
				id AS 'id',
				artikul AS 'artikul',  
				name AS 'name', 
				firm AS 'firm',
				price AS 'price',
				old_price AS 'old_price',
				purchases AS 'purchases', 
				rating AS 'rating', 
				advises AS 'advises'
				FROM items 
				WHERE
				price >= '$min_price' AND 
				price <= '$max_price' AND
				category = '$category' AND
				gender LIKE '%$gender' AND
				type LIKE '%$type' AND
				season LIKE '%$season' AND
				firm LIKE '%$firm' AND
				material LIKE '%$material'
				GROUP BY id
				$sort
				LIMIT $offset, $limit
			";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			// Если записи не найдены
			if($rows == 0) {
				echo 
<<<_END
<div class="sort_items_is_null">
	<div class="row no-gutters align-items-center">
		<div class="col-3">
			<img src="../media/images/static/error_smile.png" class="sort_items_is_null_smile">
		</div>
		<div class="col-9">
			<span class="sort_items_is_null_text">
				К сожалению, таких вещей не найдено. <br>
				Попробуйте выбрать другие фильтры.
			</span>
		</div>
	</div>
</div>
_END;

				mysqli_close($connect);
				return;
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
				$rating = $item['rating'];
				$advises = $item['advises'];
				$name = $other->stringReduce($name, 30);
				$firm = rtrim($firm, "!,.-");
				$rating = $other->ratingCount($rating);

				echo 
<<<_END
<div class="col-6 col-lg-4 col-xl-3 sort_items_item_container">
	<a href="/item?id=$id" class="sort_items_item">
		<img src="/media/images/items/$artikul/1.jpg" class="sort_items_item_image">
		<div class="sort_items_item_info">
			<div class="row no-gutters align-items-center sort_items_item_price">
				<span class="actual_price">$price <em class="fa fa-rub"></em></span>&nbsp;
				<span class="old_price"><s>$old_price <em class="fa fa-rub"></em></s></span>
			</div>
			<div class="row no-gutters sort_item_name">
				$firm - $name
			</div>
			<div class="row no-gutters align-items-center">
				<span class="sort_items_item_purchases">Покупок товара: $purchases</span>
			</div>
			<div class="row no-gutters align-items-center">
				<span class="sort_items_item_rating">Рейтинг товара:</span> 
				<span class="sort_items_item_stars">
					$rating
				</span>
			</div>
			<div class="row no-gutters align-items-center">
				<span class="sort_items_item_recommented">Товар рекомендуют $advises чел.</span>
			</div>
		</div>
	</a>
</div>
_END;
			}

			mysqli_close($connect);
		}



		// Вывести пагинатор
		function paginatorSet($rows, $page) {
			require 'config.php';
			require 'other.php';
			$config = new Config;
			$other = new Other;

			$page_count = ceil($rows / $config->sort_items_count);
			$page_minus_3 = $page - 3;
			$page_plus_3 = $page + 3;
			$page_count_minus_3 = $page_count - 3;

			// Если максимальная страница равна нулю или равна единице
			if($page_count == 0 || $page_count == 1)
				return;

			// Если текущая страница больше максимальной
			if($page > $page_count)
				return;

			// Если максимальная странице от 2 до 7
			else if($page_count >= 2 && $page_count <= 7) {

				// Если текущая страница больше 1
				if($page > 1) {
					echo '<button onclick="katalog.pagePrev()" class="paginator_btn paginator_first_btn"><em class="fa fa-long-arrow-left"></em> Предыдущая страница</button>';
				}

				// Если текущая страница меньше или равна 1
				if($page <= 1) {
					echo '<button disabled class="paginator_btn paginator_first_btn"><em class="fa fa-long-arrow-left"></em> Предыдущая страница</button>';
				}

				for($i = 1; $i <= $page_count; $i++) {
					// Если счетчик цикла равен текущей странице
					if($i == $page) {
						echo '<button onclick="katalog.pageSet($(this))" class="paginator_btn paginator_btn_active">' . $i . '</button>';

						continue;
					}

					echo '<button onclick="katalog.pageSet($(this))" class="paginator_btn">' . $i . '</button>';
				}

				// Если текущая страница меньше максимальной
				if($page < $page_count) {
					echo '<button onclick="katalog.pageNext()" class="paginator_btn paginator_last_btn">Следующая страница <em class="fa fa-long-arrow-right"></em></button>';
				}

				// Если текущая страница больше или равна максимальной
				if($page >= $page_count) {
					echo '<button disabled class="paginator_btn paginator_last_btn">Следующая страница <em class="fa fa-long-arrow-right"></em></button>';
				}
			}

			// Если максимальная страница больше 7 и текущая меньше 5
			else if($page_count > 7 && $page < 5) {

				// Если текущая страница больше 1
				if($page > 1) {
					echo '<button onclick="katalog.pagePrev()" class="paginator_btn paginator_first_btn"><em class="fa fa-long-arrow-left"></em> Предыдущая страница</button>';
				}

				// Если текущая страница меньше или равна 1
				if($page <= 1) {
					echo '<button disabled class="paginator_btn paginator_first_btn"><em class="fa fa-long-arrow-left"></em> Предыдущая страница</button>';
				}

				for($i = 1; $i <= 7; $i++) {
					// Если счетчик цикла равен текущей странице
					if($i == $page) {
						echo '<button onclick="katalog.pageSet($(this))" class="paginator_btn paginator_btn_active">' . $i . '</button>';
						
						continue;
					}

					echo '<button onclick="katalog.pageSet($(this))" class="paginator_btn">' . $i . '</button>';
				}

				echo '<div class="paginator_dots">...</div>';

				echo '<button onclick="katalog.pageSet($(this))" class="paginator_btn">' . $page_count . '</button>';

				echo '<button onclick="katalog.pageNext()" class="paginator_btn paginator_last_btn">Следующая страница <em class="fa fa-long-arrow-right"></em></button>';
			}

			// Если максимальная страница больше 7 и текущая больше или равна 5, но меньше максимальной минус 3
			else if($page_count > 7 && $page >= 5 && $page < $page_count_minus_3) {

				echo '<button onclick="katalog.pagePrev()" class="paginator_btn paginator_first_btn"><em class="fa fa-long-arrow-left"></em> Предыдущая страница</button>';

				echo '<button onclick="katalog.pageSet($(this))" class="paginator_btn">1</button>';

				echo '<div class="paginator_dots">...</div>';

				for($i = $page_minus_3; $i <= $page_plus_3; $i++) {
					// Если счетчик цикла равен текущей странице
					if($i == $page) {
						echo '<button onclick="katalog.pageSet($(this))" class="paginator_btn paginator_btn_active">' . $i . '</button>';
						
						continue;
					}

					echo '<button onclick="katalog.pageSet($(this))" class="paginator_btn">' . $i . '</button>';
				}

				echo '<div class="paginator_dots">...</div>';

				echo '<button onclick="katalog.pageSet($(this))" class="paginator_btn">' . $page_count . '</button>';

				echo '<button onclick="katalog.pageNext()" class="paginator_btn paginator_last_btn">Следующая страница <em class="fa fa-long-arrow-right"></em></button>';
			}

			// Если максимальная страница больше 7 и текущая больше или равна 5 и больше или равна, чем максимальная минус 3
			else if($page_count > 7 && $page >= 5 && $page >= $page_count_minus_3) {

				echo '<button onclick="katalog.pagePrev()" class="paginator_btn paginator_first_btn"><em class="fa fa-long-arrow-left"></em> Предыдущая страница</button>';

				echo '<button onclick="katalog.pageSet($(this))" class="paginator_btn">1</button>';

				echo '<div class="paginator_dots">...</div>';

				for($i = $page_minus_3; $i <= $page_plus_3; $i++) {
					// Если счетчик цикла равен текущей странице
					if($i == $page) {
						echo '<button onclick="katalog.pageSet($(this))" class="paginator_btn paginator_btn_active">' . $i . '</button>';
						
						continue;
					}

					// Если счетчик цикла стал равен максимальнйо странице
					if($i > $page_count)
						break;

					echo '<button onclick="katalog.pageSet($(this))" class="paginator_btn">' . $i . '</button>';
				}

				// Если текущая страница меньше максимальной
				if($page < $page_count) {
					echo '<button onclick="katalog.pageNext()" class="paginator_btn paginator_last_btn">Следующая страница <em class="fa fa-long-arrow-right"></em></button>';
				}

				// Если текущая страница больше или равна максимальной
				if($page >= $page_count) {
					echo '<button disabled class="paginator_btn paginator_last_btn">Следующая страница <em class="fa fa-long-arrow-right"></em></button>';
				}
			}
		}


		
	}
?>