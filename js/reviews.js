// Класс "Отзывы" (#class)
class Reviews {



	artikul 				= ''; // Артикул товара
	step_2_state 			= false; // Состояние загрузки шага №2
	step_3_state 			= false; // Состояние загрузки шага №3
	recommended_check_state = false; // Состояние чекбокса "Рекомендую товар"
	rating 					= 1; // Выбранный рейтинг
	advantages 				= ''; // Выбранные плюсы товара



	// Показать "Шаг №1" (#1)
	showStep1(ak, id, firm, name) {
		this.artikul = ak;

		// Ajax-запрос на загрузку первого шага
		$.ajax({
			async: false,
			url: '/ajax/reviews.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'show_step_1',
				i_ak: ak, 
				i_id: id, 
				i_firm: firm, 
				i_name: name
			}
		})
		.done(function(data) {
			// Если ответ содержит указанный текст
			if( data.includes('Вы можете добавить новый отзыв через') ) {
				other.myAlertShow('error', 'Вы недавно оставляли отзыв об этом товаре. ' + data, false, 0);

				return;
			}

			$('#add_review_form').append(data);

			setTimeout(function() {
		    	$('#search_results').hide();
				$('#purchases_box').hide();

				$('#review_form_box').show();
				$('#review_form_box').css({opacity: '100%'});
				$('.review_form_box').animate({opacity: '100%'}, 300);

				$('#review_form_step_1').show();
				$('#review_form_step_1').animate({opacity: '100%'}, 300);

				$('html, body').css({
					overflow: 'hidden', 
					height: '100%'
				});
		    }, 300);
        });
	}



	// Изменить статус чекбокса "Рекомендую товар" (#2)
	recommend() {
		var state = this.recommended_check_state;

		// Если чекбокс не активирован
		if(state == false) {
			$('#review_form_checkbox').html('<em class="fa fa-check"></em>');
			state = true;
		}

		// Если чекбокс активирован
		else {
			$('#review_form_checkbox').html('');
			state = false;
		}

		this.recommended_check_state = state;
	}



	// Выставить рейтинг (#3)
	ratingSet(id) {
		// Если идентификатор равен указаному
		if(id == 'review_star_1') {
			$('.review_star').removeClass('fa-star');
			$('.review_star').addClass('fa-star-o');
			$('#review_star_1').removeClass('fa-star-o');
			$('#review_star_1').addClass('fa-star');

			this.rating = 1;
			return;
		}

		// Если идентификатор равен указаному
		if(id == 'review_star_2') {
			$('.review_star').removeClass('fa-star');
			$('.review_star').addClass('fa-star-o');
			$('#review_star_1, #review_star_2').removeClass('fa-star-o');
			$('#review_star_1, #review_star_2').addClass('fa-star');
			
			this.rating = 2;
			return;
		}

		// Если идентификатор равен указаному
		if(id == 'review_star_3') {
			$('.review_star').removeClass('fa-star');
			$('.review_star').addClass('fa-star-o');
			$('#review_star_1, #review_star_2, #review_star_3').removeClass('fa-star-o');
			$('#review_star_1, #review_star_2, #review_star_3').addClass('fa-star');
			
			this.rating = 3;
			return;
		}

		// Если идентификатор равен указаному
		if(id == 'review_star_4') {
			$('.review_star').removeClass('fa-star');
			$('.review_star').addClass('fa-star-o');
			$('#review_star_1, #review_star_2, #review_star_3, #review_star_4').removeClass('fa-star-o');
			$('#review_star_1, #review_star_2, #review_star_3, #review_star_4').addClass('fa-star');
			
			this.rating = 4;
			return;
		}

		// Если идентификатор равен указаному
		if(id == 'review_star_5') {
			$('.review_star').removeClass('fa-star-o');
			$('.review_star').addClass('fa-star');

			this.rating = 5;
		}
	}



	// Скрыть контейнер при клике (#4)
	hideBoxOnClick() {
		$('#purchases_box').show();

		$('.review_form_box').animate({opacity: '0'}, 300);
		$('#review_form_box, #review_form_step_1, #review_form_step_2, #review_form_step_3').animate({opacity: '0'}, 300);

		$('html, body').css({
			overflow: 'auto', 
			height: 'auto'
		});

		this.step_2_state = false;
		this.step_3_state = false;

		setTimeout(function(){ 
			$('#review_form_box').hide();
			$('#review_form_step_1, #review_form_step_2, #review_form_step_3').remove();
		}, 300);
	}



	// Скрыть контейнер-форму оставления отзыва при нажатии Escape (#5)
	hideBoxOnEscape() {
		$('.review_form_box').animate({opacity: '0'}, 300);
		$('#review_form_box, #review_form_step_1, #review_form_step_2, #review_form_step_3').animate({opacity: '0'}, 300);

		$('html, body').css({
			overflow: 'auto', 
			height: 'auto'
		});

		this.step_2_state = false;
		this.step_3_state = false;

		setTimeout(function(){ 
			$('#review_form_box').hide();
			$('#review_form_step_1, #review_form_step_2, #review_form_step_3').remove();
		}, 300);
	}



	// Показать "шаг №2" (#6)
	showStep2() {
		var step_2_state = this.step_2_state;

		// Если второй шаг еще не был загружен
		if(step_2_state == false) {
			// Ajax-запрос на загрузку второго шага
			$.ajax({
				async: false,
				url: '/ajax/reviews.php',
				type: 'POST',
				dataType: 'html',
				data: {
					action: 'show_step_2'
				}
			})
			.done(function(data) {
				$('#add_review_form').append(data);
	        })
	        .always(function() {
			    setTimeout(function() {
			    	$('#review_form_step_1').hide();
					$('#review_form_step_1').css({opacity: '0'});

					$('#review_form_step_2').show();
					$('#review_form_step_2').animate({opacity: '100%'}, 300);
			    }, 300);
			});

			step_2_state = true;
		}

		// Если второй шаг уже был загружен
		else {
			$('#review_form_step_1').hide();
			$('#review_form_step_1').css({opacity: '0'});

			$('#review_form_step_2').show();
			$('#review_form_step_2').animate({opacity: '100%'}, 300);
		}

		this.step_2_state = step_2_state;
	}



	// Добавить преимущество товара (#7)
	addAdvantage(tag) {
		// Если тег имеет класс
		if(tag.hasClass('review_form_adv_checked'))
			tag.removeClass('review_form_adv_checked');

		// Если тег не имеет класс
		else
			tag.addClass('review_form_adv_checked');
	}



	// Очистить шаг №2 (#8)
	step_2_clear() {
		$('.review_form_adv').removeClass('review_form_adv_checked');
	}



	// Показать "шаг №3" (#9)
	showStep3() {
		var step_3_state = this.step_3_state;

		var advantages = '';

		$('.review_form_adv_checked').each(function(index, element) {
			advantages += $(element).text() + ' | ';
		});

		advantages = advantages.slice(0,-3);

		// Если преимущества не указаны
		if(advantages == '') {
			other.myAlertShow('error', 'Необходимо выбрать хотя бы один плюс товара!', false, 0);

			return;
		}

		this.advantages = advantages;

		// Если третий шаг еще не был загружен
		if(step_3_state == false) {
			// Ajax-запрос на загрузку третьего шага
			$.ajax({
				async: false,
				url: '/ajax/reviews.php',
				type: 'POST',
				dataType: 'html',
				data: {
					action: 'show_step_3'
				}
			})
			.done(function(data) {
				$('#add_review_form').append(data);
	        })
	        .always(function() {
			    setTimeout(function() {
					$('#review_form_step_2').css({opacity: '0'});

					$('#review_form_step_3').show();
					$('#review_form_step_3').animate({opacity: '100%'}, 300);

					$('#review_form_textarea').focus();
			    }, 300);
			});

			step_3_state = true;
		}

		// Если третий шаг уже был загружен
		else {
			$('#review_form_step_2').hide();
			$('#review_form_step_2').css({opacity: '0'});

			$('#review_form_step_3').show();
			$('#review_form_step_3').animate({opacity: '100%'}, 300);
		}

		this.step_3_state = step_3_state;
	}



	// Вернуться к "шагу №1" (#10)
	backToStep1() {
		$('#review_form_step_2').hide();
		$('#review_form_step_2').css({opacity: '0'});

		$('#review_form_step_1').show();
		$('#review_form_step_1').animate({opacity: '100%'}, 300);
	}



	// Вернуться к "шагу №2" (#11)
	backToStep2() {
		$('#review_form_step_3').hide();
		$('#review_form_step_3').css({opacity: '0'});

		$('#review_form_step_2').show();
		$('#review_form_step_2').animate({opacity: '100%'}, 300);
	}



	// Очистка textarea (#12)
	textareaClear() {
		$('#review_form_textarea').val('').focus();
	}



	// Финиш оставления отзыва (#13)
	finish() {
		var text = $('#review_form_textarea').val();

		// Если текст пустой
		if(text == '') {
			other.myAlertShow('error', 'Необходимо оставить комментарий!', false, 0);

			return;
		}

		var artikul = this.artikul;
		var rating = this.rating;
		var recommended_check_state = this.recommended_check_state.toString();
		var advantages = this.advantages;

		// Ajax-запрос на завершение
		$.ajax({
			async: false,
			url: '/ajax/reviews.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'finish',
				r: rating,
				check: recommended_check_state,
				adv: advantages,
				t: text,
				ak: artikul
			}
		})
		.done(function(result) {
			other.myAlertShow('success', 'Спасибо за Ваш отзыв! Отзыв будет опубликован сразу после проверки модератором.', false, 0);

			var all_reviews_count = Number($('#all_purchases_reviews_count').text());
			all_reviews_count++;

			$('#all_purchases_reviews_count').text(all_reviews_count);

			$('.review_form_box').animate({opacity: '0'}, 300);
			$('#review_form_box, #review_form_step_1, #review_form_step_2, #review_form_step_3').animate({opacity: '0'}, 300);

			$('html, body').css({
				overflow: 'auto', 
				height: 'auto'
			});

			setTimeout(function(){ 
				$('#review_form_box').hide();
				$('#review_form_step_1, #review_form_step_2, #review_form_step_3').remove();
			}, 300);
        });

        this.step_2_state = false;
		this.step_3_state = false;
	}


	
}



// Создание нового экземпляра класса
var reviews = new Reviews();

$('#add_review_form').on('submit', function(e) {
	e.preventDefault();
});