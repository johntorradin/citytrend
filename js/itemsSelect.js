// Класс "Выборка товаров" (#class)
class ItemsSelect {



	discounted_items_state 	 = false; // Состояние загрузки товаров "Топовые скидки"
	new_items_state 		 = false; // Состояние загрузки товаров "Новинки каталога"
	other_items_state 		 = false; // Состояние загрузки товаров "Смотрите также"
	watched_items_state 	 = false; // Состояние загрузки товаров "Вы смотрели"
	top_catalog_items_offset = 0; // Сколько товаров "Топ каталога" пропустить при загрузке
	discounted_items_offset  = 0; // Сколько товаров "Топовые скидки" пропустить при загрузке
	other_items_offset 		 = 0; // Сколько товаров "Смотрите также" пропустить при загрузке



	// Вывод карточек товара на главной (Топ каталога) (#1)
	mainTopCatalogItems(offset) {
		offset = parseInt(offset);
		this.top_catalog_items_offset += offset;
		var offs = String(this.top_catalog_items_offset);

		var content_box = $('.top_catalog_items');
		
		// Ajax-запрос на выборку товаров
		$.ajax({
			async: false,
			url: '/ajax/topCatalogItemsSelect.php',
			type: 'POST',
			dataType: 'html',
			data: {offset: offs}
		})
		.done(function(data) {
			$('#top_items_more_button_box').remove();
        	content_box.append(data)
        })
        .always(function() {
		    setTimeout(function(){
		    	$('#top_catalog_items_h1_title, .top_catalog_item, #top_items_more').show();
				$('#top_catalog_items_h1_title, .top_catalog_item, #top_items_more').animate({opacity: '100%'}, 500);
		    }, 500);
		});	
	}



	// Вывод карточек товара на главной (Топовые скидки) (#2)
	mainDiscountedItems() {
		var content_box = $('.discounted_items');
		var window_top = $(window).scrollTop();
		var window_height = $(window).height();
		var content_box_top = content_box.offset().top;
		var needed_top = content_box_top - (window_height * 1.5);

		// Если отступ окна меньше необходимого отступа
		if(window_top < needed_top) 
			return;

		// Если товары уже были загружены
		if(this.discounted_items_state == true) 
			return;

		// Ajax-запрос на выборку товаров
		$.ajax({
			async: false,
			url: '/ajax/discountedItemsSelect.php',
			type: 'POST',
			dataType: 'html',
			data: {variable: 'discounted_items'}
		})
		.done(function(data) {
			$('#discounted_items_more_button_box').remove();
        	content_box.append(data);
        })
        .always(function() {
		    setTimeout(function(){
		    	$('#discounted_items_h1_title, .discounted_item, #discounted_items_more').show();
				$('#discounted_items_h1_title, .discounted_item, #discounted_items_more').animate({opacity: '100%'}, 500);
		    }, 500);
		});

		this.discounted_items_state = true;
	}



	// Повторный вывод карточек товара на главной (Топовые скидки) (#3)
	mainDiscountedItemsMore(offset) {
		offset = parseInt(offset);
		this.discounted_items_offset += offset;
		var offs = String(this.discounted_items_offset);

		var content_box = $('.discounted_items');

		// Ajax-запрос на выборку товаров
		$.ajax({
			async: false,
			url: '/ajax/discountedItemsSelectMore.php',
			type: 'POST',
			dataType: 'html',
			data: {offset: offs}
		})
		.done(function(data) {
			$('#discounted_items_more_button_box').remove();
        	content_box.append(data);
        })
        .always(function() {
		    setTimeout(function(){
		    	$('#discounted_items_h1_title, .discounted_item, #discounted_items_more').show();
				$('#discounted_items_h1_title, .discounted_item, #discounted_items_more').animate({opacity: '100%'}, 500);
		    }, 500);
		});
	}



	// Вывод карточек товара на главной (Новинки каталога) (#4)
	mainNewItems() {
		var content_box = $('#new_items_slider');
		var window_top = $(window).scrollTop();
		var window_height = $(window).height();
		var content_box_top = content_box.offset().top;
		var needed_top = content_box_top - (window_height * 1.5);

		// Если отступ окна меньше необходимого отступа
		if(window_top < needed_top) 
			return;

		// Если товары уже были загружены
		if(this.new_items_state == true) 
			return;

		// Ajax-запрос на выборку товаров
		$.ajax({
			async: false,
			url: '/ajax/newItemsSelect.php',
			type: 'POST',
			dataType: 'html',
			data: {variable: 'new_items'}
		})
		.done(function(data) {
        	content_box.append(data);
        })
        .always(function() {
		    setTimeout(function(){
		    	$('#new_items_h1_title, .new_item_link, #new_items_more').show();
				$('#new_items_h1_title, .new_item_link, #new_items_more').animate({opacity: '100%'}, 500);

				var slider_box = $('#new_items_slides_box');
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

		this.new_items_state = true;
	}



	// Вывод карточек товара на главной (Возможно Вам понравится) (#5)
	mainOtherItems(offset) {
		var content_box = $('.other_items');
		var window_top = $(window).scrollTop();
		var window_height = $(window).height();
		var content_box_top = content_box.offset().top;
		var needed_top = content_box_top - (window_height * 1.5);

		// Если отступ окна меньше необходимого отступа
		if(window_top < needed_top) 
			return;

		// Если товары уже были загружены
		if(this.other_items_state == true) 
			return;

		// Ajax-запрос на выборку товаров
		$.ajax({
			async: false,
			url: '/ajax/otherItemsSelect.php',
			type: 'POST',
			dataType: 'html',
			data: {variable: 'other_items'}
		})
		.done(function(data) {
        	content_box.append(data);
        })
        .always(function() {
		    setTimeout(function(){
		    	$('#other_items_h1_title, .other_item, #other_items_more').show();
				$('#other_items_h1_title, .other_item, #other_items_more').animate({opacity: '100%'}, 500);
		    }, 500);
		});

		this.other_items_state = true;
	}



	// Повторный вывод карточек товара на главной (Возможно Вам понравится) (#6)
	mainOtherItemsMore(offset) {
		offset = parseInt(offset);
		this.other_items_offset += offset;
		var offs = String(this.other_items_offset);

		var content_box = $('.other_items');

		// Ajax-запрос на выборку товаров
		$.ajax({
			async: false,
			url: '/ajax/otherItemsSelectMore.php',
			type: 'POST',
			dataType: 'html',
			data: {offset: offs}
		})
		.done(function(data) {
			$('#other_items_more_button_box').remove();
        	content_box.append(data);
        })
        .always(function() {
		    setTimeout(function(){
		    	$('#other_items_h1_title, .other_item, #other_items_more').show();
				$('#other_items_h1_title, .other_item, #other_items_more').animate({opacity: '100%'}, 500);
		    }, 500);
		});
	}



	// Вывод карточек товара на главной (Вы смотрели) (#7)
	mainWatchedItems() {
		var content_box = $('#watched_items_slider');
		var window_top = $(window).scrollTop();
		var window_height = $(window).height();
		var content_box_top = content_box.offset().top;
		var needed_top = content_box_top - (window_height * 1.5);

		var fingerprint = other.getUserFingerprint();

		// Если отступ окна меньше необходимого отступа
		if(window_top < needed_top) 
			return;

		// Если товары уже были загружены
		if(this.watched_items_state == true) 
			return;

		// Ajax-запрос на выборку товаров
		$.ajax({
			async: false,
			url: '/ajax/watchedItemsSelect.php',
			type: 'POST',
			dataType: 'html',
			data: {fp: fingerprint}
		})
		.done(function(data) {
        	content_box.append(data);
        })
        .always(function(data) {
		    setTimeout(function(){
		    	$('#watched_items_h1_title, .watched_item_link').show();
				$('#watched_items_h1_title, .watched_item_link').animate({opacity: '100%'}, 500);

				var slider_box = $('#watched_items_slides_box');
				var slider = new Slider(
					slider_box.attr('id'),
					slider_box.children('div.slide').length,
					slider_box.children('div.slide').css('width'),
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

		this.watched_items_state = true;
	}


	
}



// Создание нового экземпляра класса
var iselect = new ItemsSelect();