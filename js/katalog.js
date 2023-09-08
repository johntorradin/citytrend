// Класс "Каталог" (#class)
class Katalog {



	min_price = 0; // Минимальная цена
	max_price = 0; // Максимальная цена



	// Вывод заголовка, хлебных крошек и кол-ва вещей
	itemsCountSelect() {
		var category = other.getParam('category');
		var gender = other.hashParam('gender');
		var type = other.hashParam('type');
		var season = other.hashParam('season');
		var firm = other.hashParam('firm');
		var material = other.hashParam('material');
		var min_price = other.hashParam('min_price');
		var max_price = other.hashParam('max_price');

		// Если категория не указана
		if(category == 0)
			category = 'одежда';

		// Если категория указана
		else 
			category = decodeURIComponent(category);

		// Если пол не указан
		if(gender == 0)
			gender = '';

		// Если пол указан
		else
			gender = decodeURIComponent(gender);

		// Если тип не указан
		if(type == 0)
			type = '';

		// Если тип указан 
		else
			type = decodeURIComponent(type);

		// Если сезон не указан
		if(season == 0)
			season = '';

		// Если сезон указан
		else
			season = decodeURIComponent(season);

		// Если фирма не указана
		if(firm == 0)
			firm = '';

		// Если фирма указана
		else
			firm = decodeURIComponent(firm);

		// Если материал не указан
		if(material == 0)
			material = '';

		// Если материал указан
		else
			material = decodeURIComponent(material);

		// Если минимальная цена не указана
		if(min_price == 0)
			min_price = 0;

		// Если максимальная цена не указана
		if(max_price == 0)
			max_price = 999999999;

		// Ajax-запрос на получение кол-ва товаров
		$.ajax({
			async: false,
			url: '/ajax/katalog.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'select_items_count',
				category: category,
				gender: gender,
				type: type,
				season: season,
				firm: firm,
				material: material,
				min_price: min_price,
				max_price: max_price
			}
		})
		.done(function(data) {
			$('#bread_crumbs').html(data);
        })
        .always(function() {
		    setTimeout(function() {
		    	$('#bread_crumbs').show();
				$('#bread_crumbs').animate({opacity: '100%'}, 500);
		    }, 500);
		});
	}



	// Вывод фильтров (#2)
	filtersSelect() {
		var category = other.getParam('category');

		// Если категория не указана
		if(category == 0)
			category = 'одежда';

		// Если категория указана
		else 
			category = decodeURIComponent(category);

		// Ajax-запрос на выборку фильтров
		$.ajax({
			async: false,
			url: '/ajax/katalog.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'select_filters',
				category: category
			}
		})
		.done(function(data) {
			$('#katalog_filters').append(data);
        });
	}



	// Вывод минимальной и максимальной цены в фильтры (#3)
	filtersPricesSelect() {
		var category = other.getParam('category');
		var min_price = 0;
		var max_price = 0;

		// Если категория не указана
		if(category == 0)
			category = 'одежда';

		// Если категория указана
		else 
			category = decodeURIComponent(category);

		// Ajax-запрос на выборку фильтров
		$.ajax({
			async: false,
			url: '/ajax/katalog.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'select_filters_prices',
				category: category
			}
		})
		.done(function(data) {
			$('#katalog_filters').append(data);
			min_price = $('#filter_min_price_field').val();
			max_price = $('#filter_max_price_field').val();
        })
        .always(function() {
		    setTimeout(function() {
		    	$('.filters_filter').show();
				$('.filters_filter').animate({opacity: '100%'}, 500);
		    }, 500);
		});

		this.min_price = min_price;
		this.max_price = max_price;
	}



	// Вывод карточек товаров (#4)
	itemsSelect() {
		var category = other.getParam('category');
		var gender = other.hashParam('gender');
		var type = other.hashParam('type');
		var season = other.hashParam('season');
		var firm = other.hashParam('firm');
		var material = other.hashParam('material');
		var min_price = other.hashParam('min_price');
		var max_price = other.hashParam('max_price');
		var sort = other.hashParam('sort');
		var page = other.hashParam('page');

		// Если категория не указана
		if(category == 0)
			category = 'одежда';

		// Если категория указана
		else 
			category = decodeURIComponent(category);

		// Если пол не указан
		if(gender == 0)
			gender = '';

		// Если пол указан
		else
			gender = decodeURIComponent(gender);

		// Если тип не указан
		if(type == 0)
			type = '';

		// Если тип указан 
		else
			type = decodeURIComponent(type);

		// Если сезон не указан
		if(season == 0)
			season = '';

		// Если сезон указан
		else
			season = decodeURIComponent(season);

		// Если фирма не указана
		if(firm == 0)
			firm = '';

		// Если фирма указана
		else
			firm = decodeURIComponent(firm);

		// Если материал не указан
		if(material == 0)
			material = '';

		// Если материал указан
		else
			material = decodeURIComponent(material);

		// Если минимальная цена не указана
		if(min_price == 0)
			min_price = 0;

		// Если максимальная цена не указана
		if(max_price == 0)
			max_price = 999999999;

		// Если сортировка не указана
		if(sort == 0)
			sort = 'популярность';
		
		// Если сортировка указана
		else
			sort = decodeURIComponent(sort);

		// Если страница не указана
		if(page == 0)
			page = '1';

		// Ajax-запрос на выборку товаров
		$.ajax({
			async: false,
			url: '/ajax/katalog.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'select_items',
				category: category,
				gender: gender,
				type: type,
				season: season,
				firm: firm,
				material: material,
				min_price: min_price,
				max_price: max_price,
				sort: sort,
				page: page
			}
		})
		.done(function(data) {
			$('#sort_items').html(data);
        })
        .always(function() {
		    setTimeout(function() {
		    	$('.sort_items_item').show();
				$('.sort_items_item').animate({opacity: '100%'}, 500);
		    }, 500);
		});
	}



	// Показать/скрыть списки с вариантами фильтров (#5)
	toggle(tag) {
		// Если тег скрыт
		if(tag.parent().children('.filters_list').css('display') == 'none') {
			$('.filters_list').hide(200);
			tag.parent().children('.filters_list').toggle(200);
		} 

		// Если тег не скрыт
		else {
			tag.parent().children('.filters_list').toggle(200);
		}
	}



	// Cкрыть списки с вариантами фильтров (#6)
	hideFilters() {
		$('.filters_list').hide(200);
	}



	// Применить фильтр (#7)
	setFilter(filter, button) {
		var value = button.text();
		var hash_filter = other.hashParam(filter);
		hash_filter = decodeURIComponent(hash_filter);

		// Если фильтр не указан
		if(hash_filter == 0) {
			document.location.hash += '#' + filter + '=' + value;
		}

		// Если фильтр указан
		if(hash_filter != 0) {
			var hash = document.location.hash;

			hash = decodeURIComponent(hash);
			hash = hash.replace(hash_filter, value);

			document.location.hash = hash;
		}

		var hash_page = other.hashParam('page');

		// Если страница указана
		if(hash_page != 0) {
			var hash = document.location.hash;

			hash = decodeURIComponent(hash);
			hash = hash.replace(hash_page, '1');

			document.location.hash = hash;
		}

		this.itemsCountSelect();
		this.itemsSelect();
		this.hideFilters();
		this.paginatorSet();

		button.parents().find('.filters_list_variable').removeClass('filters_list_active_variable');
		button.addClass('filters_list_active_variable');
	}



	// Применить фильтр по цене (#8)
	setFilterPrice(filter, input) {
		var value = input.val();
		var filter_value = other.hashParam(filter);
		filter_value = decodeURIComponent(filter_value);

		// Если значение пустое
		if(value == '') {
			var hash = document.location.hash;

			hash = decodeURIComponent(hash);
			hash = hash.replace('#' + filter + '=', '');
			hash = hash.replace(filter_value, '');

			document.location.hash = hash;

			return;
		}

		// Если фильтр не указан
		if(filter_value == 0) {
			document.location.hash += '#' + filter + '=' + value;
		}

		// Если фильтр указан
		if(filter_value != 0) {
			var hash = document.location.hash;

			hash = decodeURIComponent(hash);
			hash = hash.replace(filter_value, value);

			document.location.hash = hash;
		}

		var hash_page = other.hashParam('page');

		// Если страница указана
		if(hash_page != 0) {
			var hash = document.location.hash;

			hash = decodeURIComponent(hash);
			hash = hash.replace(hash_page, '1');

			document.location.hash = hash;
		}

		this.itemsCountSelect();
		this.itemsSelect();
		this.paginatorSet();
	}



	// Сбросить текущий фильтр (#9)
	resetSelectFilter(filter, button) {
		var filter_value = other.hashParam(filter);
		filter_value = decodeURIComponent(filter_value);

		// Если фильтр не указан
		if(filter_value == 0)
			return;

		// Если фильтр указан
		if(filter_value != 0) {
			var hash = document.location.hash;

			hash = decodeURIComponent(hash);
			hash = hash.replace('#' + filter + '=', '');
			hash = hash.replace(filter_value, '');

			document.location.hash = hash;
		}

		var hash_page = other.hashParam('page');

		// Если страница указана
		if(hash_page != 0) {
			var hash = document.location.hash;

			hash = decodeURIComponent(hash);
			hash = hash.replace(hash_page, '1');

			document.location.hash = hash;
		}

		this.itemsCountSelect();
		this.itemsSelect();
		this.hideFilters();
		this.paginatorSet();

		button.parents().find('.filters_list_variable').removeClass('filters_list_active_variable')
	}



	// Сбросить все фильтры (#10)
	resetFilters() {
		var category = other.getParam('category');
		category = decodeURIComponent(category);
		document.location.hash = '';

		this.itemsCountSelect();
		this.itemsSelect();
		this.paginatorSet();

		$('.sorts_variable_btn').removeClass('sorts_variable_active_btn');
		$('#sorts_first_btn').addClass('sorts_variable_active_btn');
		$('.filters_list_variable').removeClass('filters_list_active_variable');
		$('#filter_min_price_field').val(this.min_price);
		$('#filter_max_price_field').val(this.max_price);
	}



	// Изменить сортировку (#11)
	sortChange(button) {
		$('.sorts_variable_btn').removeClass('sorts_variable_active_btn');

		button.addClass('sorts_variable_active_btn');

		var button_sort = button.attr('data-sort');
		var sort = other.hashParam('sort');
		sort = decodeURIComponent(sort);

		// Если сортировка не указана
		if(sort == 0) {
			document.location.hash += '#sort=' + button_sort;
		}

		// Если сортировка указана
		if(sort != 0) {
			var hash = document.location.hash;

			hash = decodeURIComponent(hash);
			hash = hash.replace(sort, button_sort);

			document.location.hash = hash;
		}

		this.itemsCountSelect();
		this.itemsSelect();
	}



	// Загрузить пагинатор (#12)
	paginatorSet() {
		var rows = $('#katalog_all_items_count').text();
		var page = other.hashParam('page');

		// Если страница не указана
		if(page == 0)
			page = 1;

		// Ajax-запрос на загрузку пагинатора
		$.ajax({
			async: false,
			url: '/ajax/katalog.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'paginator_set',
				rows: rows,
				page: page
			}
		})
		.done(function(data) {
			$('#paginator').html(data);
        })
        .always(function() {
		    setTimeout(function() {
		    	$('#paginator').show();
				$('#paginator').animate({opacity: '100%'}, 300);
		    }, 300);
		});
	}



	// Кнопка "Предыдущая страница" (#13)
	pagePrev() {
		var hash_page = other.hashParam('page');
		var page_prev = parseInt(hash_page) - 1;
		var hash = document.location.hash;
		hash = decodeURIComponent(hash);
		hash = hash.replace(hash_page, page_prev);

		document.location.hash = hash;

		$('body, html').animate({scrollTop: 0}, 500);

		this.itemsCountSelect();
		this.itemsSelect();
		this.paginatorSet();
	}



	// Кнопка "Следующая страница" (#14)
	pageNext() {
		var hash_page = other.hashParam('page');
		var page_next = parseInt(hash_page) + 1;
		var hash = document.location.hash;
		hash = decodeURIComponent(hash);
		hash = hash.replace(hash_page, page_next);

		document.location.hash = hash;

		$('body, html').animate({scrollTop: 0}, 500);

		this.itemsCountSelect();
		this.itemsSelect();
		this.paginatorSet();
	}



	// Кнопка "Выбранная страница" (#15)
	pageSet(button) {
		var page = button.text();
		var hash_page = other.hashParam('page');

		// Если страница не указана
		if(hash_page == 0) {
			document.location.hash += '#page=' + page;
		}

		// Если страница указана
		if(hash_page != 0) {
			var hash = document.location.hash;

			hash = decodeURIComponent(hash);
			hash = hash.replace(hash_page, page);

			document.location.hash = hash;
		}

		$('body, html').animate({scrollTop: 0}, 500);

		this.itemsCountSelect();
		this.itemsSelect();
		this.paginatorSet();
	}


	
}



// Создание нового экземпляра класса
var katalog = new Katalog();

$('#katalog_form, #paginator_form').submit(function(e) {
	e.preventDefault();
});