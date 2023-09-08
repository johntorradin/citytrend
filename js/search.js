// Класс "Поиск" (#class)
class Search {



	// Выборка товаров из БД (#1)
	itemsSelect(text) {
		var content = $('#search_results_content');

		// Если запрос пустой
		if(text == '') 
		{
			content.css({opacity: '0'});

			content.html('<div class="search_results_is_null"><div class="row no-gutters align-items-center search_results_is_start">Введите запрос и здесь отобразятся результаты поиска...</div></div>');

			content.animate({opacity: '100%'}, 300);
			return;
		}
	
		// Если запрос не пустой
		if(text != '') 
		{	
			content.css({opacity: '0'});
			
			// Ajax-запрос на выборку товаров
			$.ajax({
				async: false,
				url: '/ajax/search.php',
				method: 'get',
				dataType: 'html',
				data: {text: text}
			})
			.done(function(data) {
	        	content.html(data);
	        })
	        .always(function() {
			    setTimeout(function(){
					content.animate({opacity: '100%'}, 300);
			    }, 300);
			});
		}
	}


 
	// Показать контейнер при клике (#2)
	showBoxOnClick() {
		$('.search_results, #search_close_icon').show();

		$('.search_field').animate({
			'border-top-left-radius' : '30px',
			'border-top-right-radius' : '30px',
			'border-bottom-right-radius' : '0',
			'border-bottom-left-radius' : '0'
		}, 100);

		$('.search_results, em#search_close_icon').animate({opacity: '100%'}, 200);

		$('#search_field').focus();
	}



	// Показать контейнер при фокусе (#3)
	showBoxOnFocus() {
		$('.search_results, #search_close_icon').show();

		$('.search_field').animate({
			'border-top-left-radius' : '30px',
			'border-top-right-radius' : '30px',
			'border-bottom-right-radius' : '0',
			'border-bottom-left-radius' : '0'
		}, 100);

		$('.search_results, #search_close_icon').animate({opacity: '100%'}, 200);
	}



	// Скрыть контейнер при клике по всему документу (#4)
	hideBoxOnClick() {
		$('.search_results, #search_close_icon').animate({opacity: '0'}, 300);

		$('.search_field').animate({
			'border-top-left-radius' : '30px',
			'border-top-right-radius' : '30px',
			'border-bottom-right-radius' : '30px',
			'border-bottom-left-radius' : '30px'
		}, 100);

		$('#search_field').blur();

		setTimeout(function(){ 
			$('.search_results, #search_close_icon').hide(); 
		}, 300);
	}



	// Скрыть контейнер при нажатии Escape (#5)
	hideBoxOnEscape() {
		$('.search_results, #search_close_icon').animate({opacity: '0'}, 300);

		$('.search_field').animate({
			'border-top-left-radius' : '30px',
			'border-top-right-radius' : '30px',
			'border-bottom-right-radius' : '30px',
			'border-bottom-left-radius' : '30px'
		}, 100);

		$('#search_field').blur();

		setTimeout(function(){ 
			$('.search_results, #search_close_icon').hide(); 
		}, 300);
	}



	// Очистить поле дял ввода при клике по кнопке с крестиком (#6)
	inputClear() {
		$('#search_results_content').html('<div class="search_results_is_null"><div class="row no-gutters align-items-center search_results_is_start">Введите запрос и здесь отобразятся результаты поиска...</div></div>');

		$('#search_field').val('').focus();
	}



}



// Создание нового экземпляра класса
var search = new Search();

// Обработка событий
$('#search').submit(function(e) { 
	e.preventDefault(); 
});
$('#search_icon').on('click', function() { 
	search.showBoxOnClick(); 
});
$('#search_field').on('click', function() { 
	search.showBoxOnClick(); 
});
$('#search_field').on('focus', function() { 
	search.showBoxOnFocus(); 
});
$('#search_close_icon').on('click', function() { 
	search.inputClear(); 
});