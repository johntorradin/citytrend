<?php 
	// Класс "Поиск" (#class)
	class Search {
		


		// Выборка товаров из БД (#1)
		function itemsSelect($text) {
			require '../php/other.php';
			$other = new Other;

			$text = $other->fixString($text);
			$connect = $other->dbConnect();
			$query = "SELECT id, firm, name, artikul FROM items WHERE artikul LIKE '%$text%' OR category LIKE '%$text%' OR type LIKE '%$text%' OR name LIKE '%$text%' OR gender LIKE '%$text%' OR season LIKE '%$text%' OR firm LIKE '%$text%' ORDER BY id DESC LIMIT 20";

			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			// Если записи не найдены
			if($rows == 0) {
				echo
<<<_END
<div class="search_results_is_null">
	<div class="row no-gutters align-items-center">
		<div class="col-3">
			<img src="../media/images/static/error_smile.png" class="search_error_smile">
		</div>
		<div class="col-9">
			<div class="row no-gutters is_null_text">
				Совпадений не найдено. <br>Попробуйте изменить запрос или
			</div>
			<div class="row no-gutters">
				<a href="katalog" class="go_to_item_list">Перейти в Каталог</a>
			</div>
		</div>
	</div>
</div>
_END;

				return;
			}

			// Если записи найдены
			if($rows != 0) {
				for($i = 0; $i < $rows; $i++) {
					$item = mysqli_fetch_assoc($result);
					$id = $item['id'];
					$firm = $item['firm'];
					$name = $item['name'];
					$artikul = $item['artikul'];
					$firm = rtrim($firm, "!,.-");
					$name = $other->stringReduce($name, 20);

					echo
<<<_END
<a href="/item?id=$id" class="search_result">
	<div class="row no-gutters align-items-center search_result">
		<img class="search_img" src="/media/images/items/$artikul/1.jpg">
		<div class="search_title">$firm - $name (код товара: $artikul)</div>
	</div>
</a>
_END;
				}
			}

			mysqli_close($connect);
		}


		
	}
?>