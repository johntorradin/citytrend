// Класс "Разное" (#class)
class Other {



	// Проверить отпечаток браузера пользователя (#1)
	fingerprintCheck() {
		var fingerprint = this.getUserFingerprint();

		// Ajax-запрос на проверку Fingerprint
		$.ajax({
			async: false,
			url: '/ajax/fingerprintCheck.php',
			type: 'POST',
			dataType: 'html',
			data: {fp: fingerprint}
		})
		.done(function(data) {
			// Если ответ равен указанному
			if(data == 'yes') 
				return;

			$('.container').append(data);
        })
        .always(function() {
		    $('#cookie_accept_box').show();
			$('#cookie_accept_box').css({opacity: '100%'});
		});	
	}



	// Скрыть контейнер согласия с куки (#2)
	cookieBoxHide() {
		// Ajax-запрос на согласие с куки
		$.ajax({
			async: false,
			url: '/ajax/cookieAccepted.php',
			type: 'POST',
			dataType: 'html',
			data: {cookie: 'hide'}
		})
		.done(function(data) {
			$('#cookie_accept_box').animate({opacity: '0'}, 300);

		    setTimeout(function(){ 
				$('#cookie_accept_box').hide(); 
			}, 300);
        });
	}



	// Перевод первой буквы в верхний регистр (#3)
	mb_ucfirst(string) {
	    return string.charAt(0).toUpperCase() + string.slice(1);
	}



	// Перенаправить на страницу (#4)
	goToPage(page) {
		$(location).attr('href', page);
	}



	// Получить параметр GET (#5)
	getParam(name) {
		var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
		
		// Если результат равен нулю
		if(results == null) 
			return 0;
		
		return results[1] || 0;
	}



	// Получить параметр HASH (#5)
	hashParam(name) {
		var results = new RegExp('[\?#]' + name + '=([^&#]*)').exec(window.location.href);
		
		// Если результат равен нулю
		if(results == null) 
			return 0;
		
		return results[1] || 0;
	}



	// Показать или Убрать кнопку "Наверх" (#6)
	toTopToggle() {
		// Если отступ окна сверху больше указанного
		if($(window).scrollTop() > 400) {
			$('#to_top').fadeIn();
		} 

		// Если отступ окна сверху меньше или равен указанному
		else {
			$('#to_top').fadeOut();
		}
	}



	// Перемещение при клике на кнопку "Наверх" к началу страницы (#7)
	toTopGo() {
		$('body, html').animate({
			scrollTop: 0
		}, 500);

		return false;
	}



	// Получить Fingerprint (#8)
	getUserFingerprint() {
		var client = new ClientJS();
        var browser = client.getBrowser();
		var OS = client.getOS();
		var CPU = client.getCPU();
		var canvasPrint = client.getCanvasPrint();

		var fingerprint = client.getCustomFingerprint(browser, OS, CPU, canvasPrint);

		return fingerprint;
	}



	// Перевод строк rgb в hex (#9)
	rgbToHex(rgb) {
	    var rgb = rgb.match(/^rgb?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);

	    return (rgb && rgb.length === 4) ? "#" +
        ("0" + parseInt(rgb[1], 10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[2], 10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[3], 10).toString(16)).slice(-2) : '';
	};



	// Отобразить окно my_alert (#10)
	myAlertShow(state, text, confirm, timer) {
		$('html, body').css({
			overflow: 'hidden', 
			height:   '100%'
		});

		// Если тег содержит класс
		if($('.my_alert_title').hasClass('my_alert_title_success'))
			$('.my_alert_title').removeClass('my_alert_title_success');

		// Если тег содержит класс
		else if($('.my_alert_title').hasClass('my_alert_title_error'))
			$('.my_alert_title').removeClass('my_alert_title_error');

		// Если состояние = ошибка
		if(state == 'error') {
			$('.my_alert').css({'box-shadow' : '0 0 20px rgb(245 81 35 / 100%)'});
			$('.my_alert_title').addClass('my_alert_title_error');
			$('.my_alert_title').text('Ошибка...');
		}

		// Если состояние = успех
		else if(state == 'success') {
			$('.my_alert').css({'box-shadow' : '0 0 20px rgb(53 142 53 / 100%)'});
			$('.my_alert_title').addClass('my_alert_title_success');
			$('.my_alert_title').text('Отлично!');
		}

		// Если в функцию передан парамет confirm
		if(confirm == true) {
			$('.my_alert_btn_row').html('<button onclick="other.myAlertHide()" class="my_alert_exit">Закрыть</button><button onclick="other.myAlertHide()" id="my_alert_confirm" class="my_alert_confirm">Подтвердить</button>');
			$('.my_alert_title').text('Удаление товара');
		}

		// Если в функцию не передан парамет confirm
		else 
			$('.my_alert_btn_row').html('<button onclick="other.myAlertHide()" class="my_alert_exit">Закрыть</button>');

		$('.my_alet_text').text(text);

		// Если окно уже было загружено
		if($('.my_alert').css('opacity') == '100%')
			return;

		$('.my_alert_popup, .my_alert').show();
		$('.my_alert_popup, .my_alert').animate({'opacity' : '100%'}, 200);

		// Если таймер не равен нулю
		if(timer != 0) {
			$('.my_alert_btn_row').html('');
			$('.my_alert_popup').attr('onclick', '');
			$('.my_alet_text').append(' Возвращение на главную страницу через: <span class="my_alert_timer">' + timer + '</span>');

			timer--;

			var interval = setInterval(function() {
				$('.my_alert_timer').text(timer);

				timer--;

				// Если таймер закончился
				if(timer == -1) {
					$('.my_alert_popup, .my_alert').animate({'opacity' : '0'}, 200);

					setTimeout(function() {
						$('.my_alert_popup, .my_alert').hide();
					}, 200);
				}
			}, 1000);
		}
	}



	// Закрыть окно my_alert (#11)
	myAlertHide() {
		$('.my_alert_popup, .my_alert').animate({'opacity' : '0'}, 200);

		setTimeout(function() {
			$('.my_alert_popup, .my_alert').hide();
		}, 200);

		$('html, body').css({
			overflow: 'auto', 
			height: 'auto'
		});
	}


	
}



// Создание нового экземпляра класса
var other = new Other();