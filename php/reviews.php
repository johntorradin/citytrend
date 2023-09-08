<?php 
	// Класс "Отзывы" (#class)
	class Reviews {



		// Загрузить "Шаг №1" (#1)
		function showStep1($ak, $id, $firm, $name) {
			session_start();
			require_once 'config.php';
			require_once 'other.php';
			$config = new Config;
			$other = new Other;

			$ak = $other->fixString($ak);
			$id = $other->fixString($id);
			$firm = $other->fixString($firm);
			$name = $other->fixString($name);

			$data = 
<<<_END
<div id="review_form_step_1" class="review_form_step_container">
	<div class="row no-gutters justify-content-center review_form_item_link_line">
		<a target="blank" href="/item?id=$id" class="review_form_item_link">$firm - $name</a>
	</div>
	<div class="row no-gutters justify-content-center review_form_item_img_line">
		<img src="../media/images/items/$ak/1.jpg" class="review_form_item_img">
	</div>
	<div class="row no-gutters justify-content-center review_form_rating_line">
		<h1 class="review_form_note">Укажите оценку</h1>
		<span id="review_form_rating" class="review_form_rating">
			<em onclick="reviews.ratingSet($(this).attr('id'))" id="review_star_1" class="review_star fa fa-star"></em>
			<em onclick="reviews.ratingSet($(this).attr('id'))" id="review_star_2" class="review_star fa fa-star-o"></em>
			<em onclick="reviews.ratingSet($(this).attr('id'))" id="review_star_3" class="review_star fa fa-star-o"></em>
			<em onclick="reviews.ratingSet($(this).attr('id'))" id="review_star_4" class="review_star fa fa-star-o"></em>
			<em onclick="reviews.ratingSet($(this).attr('id'))" id="review_star_5" class="review_star fa fa-star-o"></em>
		</span>
	</div>
	<div class="row no-gutters align-items-center justify-content-center review_form_recommend_line">
		<div onclick="reviews.recommend()" id="review_form_checkbox" class="review_form_checkbox"></div>
		<span class="review_form_checkbox_note">Рекомендую товар</span>
	</div>
	<div class="row no-gutters justify-content-between review_form_buttons_line">
		<button onclick="reviews.hideBoxOnClick()" id="review_form_step_1_exit" class="review_form_btn">Отмена</button>
		<button onclick="reviews.showStep2()" id="review_form_step_1_next" class="review_form_btn">Далее <em class="fa fa-angle-double-right"></em></button>
	</div>
</div>
_END;

			$connect = $other->dbConnect();
			$user_id = $_SESSION['user_id'];
			$query = "SELECT * FROM log_add_reviews WHERE user_id = '$user_id' AND artikul = '$ak' ORDER BY id DESC LIMIT 1";
			$result = mysqli_query($connect, $query);
			$rows = mysqli_num_rows($result);

			// Если записи найдены
			if($rows != 0) {
				$log = mysqli_fetch_assoc($result);
				$start_time = $log['unix_time'];
				$end_time = $start_time + ($config->add_reviews_limit_time * 60);
				$now_time = time();
				$remaining_time = ($end_time - $now_time) / 60;
				$remaining_minutes = ceil($remaining_time);

				// Если оставшееся время больше нуля
				if($remaining_minutes > 0) {
					$data = $remaining_minutes;
					echo "Вы можете добавить новый отзыв через $data мин.";
					mysqli_close($connect);
					return;
				}

				// Если оставшееся время меньше или равно нулю
				else {
					echo $data;
					mysqli_close($connect);
				}
			}

			// Если записи не найдены
			else {
				echo $data;
				mysqli_close($connect);
			}
		}



		// Загрузить "Шаг №2" (#2)
		function showStep2() {
			echo 
<<<_END
<div id="review_form_step_2" class="review_form_step_container">
	<div class="row no-gutters justify-content-start review_form_adv_disadv_note_line">
		<h1 class="review_form_adv_disadv_note">Выделите плюсы товара</h1>
	</div>
	<div class="row no-gutters justify-content-center review_form_adv_disadv_line">
		<div class="col">
			<button onclick="reviews.addAdvantage($(this))" class="review_form_adv">+ Дизайн</button>
			<button onclick="reviews.addAdvantage($(this))" class="review_form_adv">+ Материал</button>
			<button onclick="reviews.addAdvantage($(this))" class="review_form_adv">+ Ассортимент размеров</button>
			<button onclick="reviews.addAdvantage($(this))" class="review_form_adv">+ Ассортимент цветов</button>
			<button onclick="reviews.addAdvantage($(this))" class="review_form_adv">+ Качественная бижутерия</button>
		</div>
		<div class="col">
			<button onclick="reviews.addAdvantage($(this))" class="review_form_adv">+ Быстрая доставка</button>
			<button onclick="reviews.addAdvantage($(this))" class="review_form_adv">+ Цена</button>
			<button onclick="reviews.addAdvantage($(this))" class="review_form_adv">+ Подробное отслеживание</button>
			<button onclick="reviews.addAdvantage($(this))" class="review_form_adv">+ Наличие гарантии</button>
			<button onclick="reviews.addAdvantage($(this))" class="review_form_adv">+ Упаковка</button>
		</div>
	</div>
	<div class="row no-gutters justify-content-between review_form_buttons_line">
		<button onclick="reviews.backToStep1()" id="review_form_step_2_back" class="review_form_btn">Назад</button>
		<button onclick="reviews.step_2_clear()" id="review_form_step_2_clear" class="review_form_btn">Очистить</button>
		<button onclick="reviews.showStep3()" id="review_form_step_2_next" class="review_form_btn">Далее <em class="fa fa-angle-double-right"></em></button>
	</div>
</div>
_END;
		}



		// Загрузить "Шаг №3" (#3)
		function showStep3() {
			echo 
<<<_END
<div id="review_form_step_3" class="review_form_step_container">
	<div class="row no-gutters justify-content-center review_form_text_note_line">
		<h1 class="review_form_text_note">Напишите комментарий</h1>
	</div>
	<div class="row no-gutters justify-content-center review_form_textarea_line">
		<textarea id="review_form_textarea" maxlength="300" resize="false" class="review_form_textarea" placeholder="Оставьте Ваш комментарий здесь..."></textarea>
	</div>
	<div class="row no-gutters justify-content-between review_form_buttons_line">
		<button onclick="reviews.backToStep2()" id="review_form_step_3_back" class="review_form_btn">Назад</button>
		<button onclick="reviews.textareaClear()" id="review_form_step_3_clear" class="review_form_btn">Очистить</button>
		<button onclick="reviews.finish()" id="review_form_step_3_finish" class="review_form_btn">Оставить отзыв <em class="fa fa-check"></em></button>
	</div>
</div>
_END;
		}



		// Финиш оставления отзыва (#4)
		function finish($ak, $rating, $check, $adv, $text) {
			session_start();
			require_once 'config.php';
			require_once 'other.php';
			$config = new Config;
			$other = new Other;

			$artikul = $other->fixString($ak);
			$rating = $other->fixString($rating);
			$check = $other->fixString($check);
			$adv = $other->fixString($adv);
			$text = $other->fixString($text);
			$pubdate = date('d.m.Y');
			$pubtime = date('H:i');
			$unix_time = time();

			// Если чекбокс был активирован
			if($check == 'true')
				$check = 'yes';

			// Если чекбокс не был активирован
			else
				$check = 'no';

			$connect = $other->dbConnect();
			$user_id = $_SESSION['user_id'];

			echo "$user_id $artikul $pubdate $pubtime $adv $disadv $text $rating $check $unix_time";

			$query = "INSERT INTO reviews(user_id, artikul, pubdate, pubtime, advantages, comment, rating, advise, allow) VALUES('$user_id', '$artikul' , '$pubdate' , '$pubtime' , '$adv', '$text' , '$rating' , '$check' , 'no')";
			$query_2 = "INSERT INTO log_add_reviews(user_id, artikul, unix_time) VALUES('$user_id', '$artikul', '$unix_time')";
			$result = mysqli_query($connect, $query);
			$result_2 = mysqli_query($connect, $query_2);

			mysqli_close($connect);
		}



	}
?>