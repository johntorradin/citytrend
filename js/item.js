// Класс "Товар" (#class)
class Item {



	reviews_count_state = false; // Состояние загрузки кол-ва отзывов
	start_reviews_state = false; // Состояние загрузки начальных отзывов
	similar_items_state = false; // Состояние загрузки похожих товаров
	reviews_offset = 0; // Число пропуска записей
	sort = 'новые';



	// Загрузить заголовок и начальную информацию о товаре (#1)
	titleSelect() {
		var id = other.getParam('id');
		var next = true;
		var site_url = '';

		// Ajax-запрос на получение заголовка и начальной информации
		$.ajax({
			async: false,
			url: '/ajax/item.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'select_title',
				id: id
			}
		})
		.done(function(data) {
			// Если ответ содержит указанный текст
			if(data.includes('://')) {
				site_url = data;
				next = false;
			}

			$('#start_item_info').html(data);

			setTimeout(function() {
				$('#bread_crumbs').show();
				$('#bread_crumbs').animate({opacity: '100%'}, 500);
		    }, 500);
        });

		// Если id товара есть в базе
        if(next == true) {
        	this.addItemToWatched();
        	this.photoSliderSelect();
			this.charactersSelect();
			this.priceSelect();
			this.colorSelect();
        }

        // Если товар не найден
        else 
        	other.goToPage(site_url + 'page_404');
	}



	// Вывод слайдера с фото товара (#2)
	photoSliderSelect() {
		var id = other.getParam('id');

		// Ajax-запрос на получение слайдера фото
		$.ajax({
			async: false,
			url: '/ajax/item.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'select_slider',
				id: id
			}
		})
		.done(function(data) {
			$('#item_images_slider').append(data);
        })
        .always(function() {
		    setTimeout(function() {
		    	$('#item_images_slider').show();
				$('#item_images_slider').animate({opacity: '100%'}, 500);

				var slider_box = $('#item_images_slides_box');
				var slider = new Slider(
					slider_box.attr('id'),
					slider_box.children('.slide').length,
					slider_box.children('.slide').css('width'),
					slider_box.css('width')
				);
				var next = slider.slidesCountCheck();

				// Если функция проверки вернула false
				if(next == false) {
					slider_box.parent().parent().children('.slider_prev, .slider_next').remove();
					slider_box.parents().children('.slider_dots_box').remove();
				}

				// Если функция проверки вернула true
				else {
					slider.setWidth();
					slider.setDots();
					slider_box.parent().parent().children('.slider_next').on('click', function() {
						slider.sliderNext();
					});
					slider_box.parent().parent().children('.slider_prev').on('click', function() {
						slider.sliderPrev();
					});
					slider_box.children('.slide').swipe(function(direction) {
						// Если свайп имеет направление "налево"
						if(direction == 'left') 
							slider.sliderNext();

						// Если свайп имеет направление "направо"
						else if(direction == 'right') 
							slider.sliderPrev();
				    },
				    {
				        preventDefault: true,
				        mouse: true,
				        pen: true,
				        distance: 50
				    });
				}
		    }, 500);
		});
	}



	// Вывод цветов (#3)
	colorSelect() {
		var id = other.getParam('id');

		// Ajax-запрос на получение цветов
		$.ajax({
			async: false,
			url: '/ajax/item.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'select_colors',
				id: id
			}
		})
		.done(function(data) {
			$('#item_colors').append(data);
        })
        .always(function() {
		    setTimeout(function() {
		    	$('#item_colors').show();
				$('#item_colors').animate({opacity: '100%'}, 500);
		    }, 500);
		});
	}



	// Вывод размеров (#4)
	sizesSelect(btn, color) {
		var artikul = $('.main_info_item_id').text();

		// Ajax-запрос на получение размеров
		$.ajax({
			async: false,
			url: '/ajax/item.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'select_sizes',
				artikul: artikul,
				color: color
			}
		})
		.done(function(data) {
			$('.item_size_start_text').remove();
			$('#item_characters_sizes').html(data);
			$('.item_color_btn').removeClass('item_color_btn_active');
			btn.addClass('item_color_btn_active');
        })
        .always(function() {
		    setTimeout(function() {
		    	$('#item_characters_sizes').show();
				$('#item_characters_sizes').animate({opacity: '100%'}, 500);
		    }, 500);
		});
	}



	// Выбор размера (#5)
	sizeActivate(btn) {
		$('.item_size_btn').removeClass('item_size_btn_active');
		btn.addClass('item_size_btn_active');
	}



	// Вывод характеристик и описания (#6)
	charactersSelect() {
		var id = other.getParam('id');

		// Ajax-запрос на получение характеристик и описания
		$.ajax({
			async: false,
			url: '/ajax/item.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'select_characters',
				id: id
			}
		})
		.done(function(data) {
			$('#characters_and_description').append(data);
			$('#item_description').css({'height' : '160px'});
        })
        .always(function() {
		    setTimeout(function() {
		    	$('#characters_and_description').show();
				$('#characters_and_description').animate({opacity: '100%'}, 500);
		    }, 500);
		});
	}



	// Клик по кнопке "Развернуть описание" (#8)
	descriptionShow() {
		$('.description_read_more').remove();
		$('#item_description').animate({'height' : '100%'}, 300);
	}



	// Вывод цены (#9)
	priceSelect() {
		var id = other.getParam('id');

		// Ajax-запрос на получение цены
		$.ajax({
			async: false,
			url: '/ajax/item.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'select_price',
				id: id
			}
		})
		.done(function(data) {
			$('#item_price_box').append(data);
        })
        .always(function() {
		    setTimeout(function() {
		    	$('#item_price_box').show();
				$('#item_price_box').animate({opacity: '100%'}, 500);
		    }, 500);
		});
	}



	// Сделать слайд активным (#10)
	imgActivate(src) {
		$('#slider_active_image').css({opacity: '0'});
		$('#slider_active_image').attr('src', src);
		$('#slider_active_image').animate({opacity: '100%'}, 300);
	}




	// Показать увеличенное фото товара (#11)
	bigImgBoxShow(src) {
		$('#search_results').hide();

		$('#big_item_image').attr('src', src);
		$('.big_item_photo_box').show();
		$('.big_item_photo_box').css({opacity: '100%'});
		$('.big_item_image_container').animate({opacity: '100%'}, 300);

		$('html, body').css({
			overflow: 'hidden', 
			height: '100%'
		});
	}



	// Скрыть увеличенное фото товара при клике на кнопку закрытия (#12)
	bigImgBoxCloseOnClick() {
		$('.big_item_image_container').animate({opacity: '0'}, 300);
		$('.big_item_photo_box').animate({opacity: '0'}, 300);

		$('html, body').css({
			overflow: 'auto', 
			height: 'auto'
		});

		setTimeout(function(){ 
			$('.big_item_photo_box').hide(); 
		}, 300);
	}



	// Скрыть увеличенное фото товара при нажатии Escape (#13)
	bigImgBoxCloseOnEscape() {
		$('.big_item_image_container').animate({opacity: '0'}, 300);
		$('.big_item_photo_box').animate({opacity: '0'}, 300);

		$('html, body').css({
			overflow: 'auto', 
			height: 'auto'
		});

		setTimeout(function(){ 
			$('.big_item_photo_box').hide(); 
		}, 300);
	}



	// Загрузить кол-во отзывов (#14)
	reviewsCountSelect() {
		var id = other.getParam('id');

		// Если кол-во отзывов уже было загружено
		if(this.reviews_count_state == true)
			return;

		// Ajax-запрос на получение кол-ва отзывов
		$.ajax({
			async: false,
			url: '/ajax/item.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'select_reviews_count',
				id: id
			}
		})
		.done(function(data) {
			$('#item_reviews_sort_form').append(data);
        })
        .always(function() {
		    setTimeout(function() {
		    	$('#item_reviews_sort_form').show();
				$('#item_reviews_sort_form').animate({opacity: '100%'}, 500);
		    }, 500);
		});

		this.reviews_count_state = true;
	}



	// Загрузить начальные отзывы (#15)
	startReviewsSelect(sort) {
		var id = other.getParam('id');

		// Если начальные отзывы уже были загружены
		if(this.start_reviews_state == true)
			return;

		// Ajax-запрос на получение начальных отзывов
		$.ajax({
			async: false,
			url: '/ajax/item.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'select_reviews',
				id: id,
				sort: sort,
				offset: '0'
			}
		})
		.done(function(data) {
			$('#item_reviews').append(data);
        })
        .always(function() {
		    setTimeout(function() {
		    	$('#item_reviews').show();
				$('#item_reviews').animate({opacity: '100%'}, 500);
		    }, 500);
		});

		this.start_reviews_state = true;
	}



	// Загрузить отзывы (#16)
	reviewsSelect(btn, offset, sort) {
		var id = other.getParam('id');

		// Если переменная сортировки была передана
		if(sort != '') {
			$('#item_reviews').css({'opacity' : '0'});
			$('#item_reviews').hide();
			$('.review_container, .download_more_reviews').remove('');
			$('.sort_line_sort_btn').removeClass('sort_line_sort_btn_active');
			btn.addClass('sort_line_sort_btn_active');
			this.sort = sort;
			this.reviews_offset = 0;
		}

		// Если переменная сортировки не была передана
		else {
			sort = this.sort;
			this.reviews_offset += offset;
			offset = this.reviews_offset;
			$('.download_more_reviews').remove('');
		}

		// Ajax-запрос на получение отзывов
		$.ajax({
			async: false,
			url: '/ajax/item.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'select_reviews',
				id: id,
				sort: sort,
				offset: offset
			}
		})
		.done(function(data) {
			$('#item_reviews').append(data);
        })
        .always(function() {
		    setTimeout(function() {
		    	$('#item_reviews').show();
				$('#item_reviews').animate({opacity: '100%'}, 500);
		    }, 500);
		});
	}



	// Вывести похожие вещи (#17)
	similarItemsSelect() {
		var type = $('#item_type').text();
		var category = $('#item_category').text();

		// Если похожие вещи уже были загружены
		if(this.similar_items_state == true)
			return;

		// Ajax-запрос на получение похожих вещей
		$.ajax({
			async: false,
			url: '/ajax/item.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'select_similar',
				category: category,
				type: type
			}
		})
		.done(function(data) {
			$('.item_content_similar_items_box').append(data);
        })
        .always(function() {
		    setTimeout(function() {
		    	$('.similar_items_item').show();
				$('.similar_items_item').animate({opacity: '100%'}, 500);
		    }, 500);
		});

		this.similar_items_state = true;
	}



	// Добавить товар в список просмотренных (#18)
	addItemToWatched() {
		var id = other.getParam('id');
		var fingerprint = other.getUserFingerprint();

		// Ajax-запрос на добавление товара в список просмотренных
		$.ajax({
			async: false,
			url: '/ajax/item.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'add_to_watched',
				id: id,
				fingerprint: fingerprint
			}
		});
	}



	// Клик по кнопке "Купить сейчас" (#19)
	buyNow() {
		var id = other.getParam('id');
		var site_url = '';
		var color_btn = $('.item_color_btn');
		var size_btn = $('.item_size_btn');

		// Ajax-запрос на получение адреса сайта из конфига
		$.ajax({
			async: false,
			url: '/ajax/loadConfig.php',
			type: 'POST',
			dataType: 'html',
			data: {variable: 'site_url'}
		})
		.done(function(data) {
			site_url = data;
        });

		// Если цвет не выбран
        if(!color_btn.hasClass('item_color_btn_active')) {
        	other.myAlertShow('error', 'Перед покупкой товара, необходимо выбрать цвет и размер!', false, 0);

        	return;
        }

        // Если размер не выбран
        if(!size_btn.hasClass('item_size_btn_active')) {
        	other.myAlertShow('error', 'Перед покупкой товара, необходимо выбрать цвет и размер!', false, 0);

        	return;
        }

        var color = $('.item_color_btn_active').find('#item_color').text();
        var size = $('.item_size_btn_active').text();
        var count = 1;
        var price = $('#item_actual_price').text();
        var rgb = $('.item_color_btn_active').find('.item_color_circle').css('background-color');
       	var hex = other.rgbToHex(rgb);
       	var artikul = $('.main_info_item_id').text();
       	var name = $('.content_item_title_h1').attr('data-name');
        var purchase = id + ',' + artikul + ',' + name + ',' + color + ',' + hex + ',' + size + ',' + count + ',' + price;

        // Ajax-запрос на создание строки покупки
		$.ajax({
			async: false,
			url: '/ajax/purchaseReg.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'set_purchase',
				purchase: purchase
			}
		})
		.done(function(data) {
			other.goToPage(site_url + 'purchase');
        });
	}



	// Клик по кнопке "Добавить в корзину" (#20)
	addToCart() {
		var artikul = $('.main_info_item_id').text();
		var color_btn = $('.item_color_btn');
		var size_btn = $('.item_size_btn');

		// Если цвет не выбран
        if(!color_btn.hasClass('item_color_btn_active')) {
        	other.myAlertShow('error', 'Перед покупкой товара, необходимо выбрать цвет и размер!', false, 0);

        	return;
        }

        // Если размер не выбран
        if(!size_btn.hasClass('item_size_btn_active')) {
        	other.myAlertShow('error', 'Перед покупкой товара, необходимо выбрать цвет и размер!', false, 0);

        	return;
        }

        var color = $('.item_color_btn_active').find('#item_color').text();
        var size = $('.item_size_btn_active').text();
        var fingerprint = other.getUserFingerprint();

        // Ajax-запрос на добавление товара в корзину
		$.ajax({
			async: false,
			url: '/ajax/item.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'add_to_cart',
				fingerprint: fingerprint,
				artikul: artikul,
				color: color,
				size: size
			}
		})
		.done(function(data) {
			// Если вернулся ответ "успех"
			if(data == 'успех') {
				shopcart.selectCount();

				other.myAlertShow('success', 'Товар в корзине!', false, 0);
			}

			// Если вернулся текст ошибки
			else {
				other.myAlertShow('error', data, false, 0);
			}
        });
	}



}



// Создание нового экземпляра класса
var item = new Item();

$('#download_more_reviews_form, #item_reviews_sort_form, #item_add_to_cart_form').on('submit', function(e) {
	e.preventDefault();
});