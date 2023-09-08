// Класс "Авторизация аккаунта" (#class)
class AccountEnter {



	site_url = ''; // Адрес сайта
	login 	 = ''; // Логин
	email 	 = ''; // Email
	password = ''; // Пароль
	


	// Конструктор класса (#1)
	constructor() {
		var site_url = '';

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

        this.site_url = site_url;

        var content_box = $('#account_enter_form');

        // Ajax-запрос на загрузку первого шага
		$.ajax({
			async: false,
			url: '/ajax/accountEnter.php',
			type: 'POST',
			dataType: 'html',
			data: {action: 'start'}
		})
		.done(function(data) {
			content_box.append(data);
        })
        .always(function() {
			$('#account_enter_step_1').show();
			$('#account_enter_step_1').animate({opacity: '100%'}, 300);
			$('#account_field_1').focus();
		});
	}



	// Вывод шага №2 (пользователь забыл логин / пароль) (#2)
	goToStep2() {
		var response_result = false;

		// Ajax-запрос на проверку капчи
		$.ajax({
			async: false,
			url: '/ajax/accountEnter.php',
			type: 'POST',
			dataType: 'html',
			data: "action=captcha_check&response=" + grecaptcha.getResponse()
		})
		.done(function(result) {
			if(result == 'true') {
				response_result = true;
			}
        });

		// Если капча не пройдена
        if(response_result == false) {
        	var text = 'Вы не прошли проверку не робота.';

        	// Если тег не содержит класс
        	if(!$('#account_recaptcha').hasClass('account_recaptcha_error')) {
        		$('#account_recaptcha').addClass('account_recaptcha_error');
        		$('#account_recaptcha').parent().append('<em class="fa fa-times account_field_times"></em><span class="account_field_error_note">' + text + '</span>');
        	}

        	other.myAlertShow('error', text, false, 0);

			grecaptcha.reset();

			return;
        }

		$('#account_enter_step_1').hide();
		$('#account_enter_step_1').css({opacity: '0'});

		// Если шаг №2 регистрации уже был загружен
		if($('#account_enter_step_2').get(0)) {
			$('#account_enter_step_2').show();
			$('#account_enter_step_2').animate({opacity: '100%'}, 300);
			$('#account_field_3').val('');
			$('#account_field_3').focus();

			this.email = '';

			// Если тег содержит класс
			if($('#account_field_3').hasClass('account_field_error')) {
				$('#account_field_3').removeClass('account_field_error');
				$('#account_field_3').parent().find('.account_field_times, .account_field_error_note').remove();
			}

			// Если тег содержит класс
			else if($('#account_field_3').hasClass('account_field_allow')) {
				$('#account_field_3').removeClass('account_field_allow');
			}

			return;
		}

		var content_box = $('#account_enter_form');

		// Ajax-запрос на загрузку второго шага
		$.ajax({
			async: false,
			url: '/ajax/accountEnter.php',
			type: 'POST',
			dataType: 'html',
			data: {action: 'step_2'}
		})
		.done(function(data) {
			content_box.append(data);
        })
        .always(function() {
        	$('#account_enter_step_2').show();
			$('#account_enter_step_2').animate({opacity: '100%'}, 300);

        	if($('#account_recaptcha').hasClass('account_recaptcha_error')) {
				$('#account_recaptcha').removeClass('account_recaptcha_error');
				$('#account_recaptcha').parent().find('.account_field_times, .account_field_error_note').remove();
			}
		});
	}



	// Проверка поля "Email" (#3)
	emailCheck(value) {
		var email = '';
		var input = $('#account_field_3');
		value = value.toLowerCase();
		input.val(value);

		// Если поле пустое
		if(value == '') {
			var text = 'Вы не указали email.';

			// Если тег содержит класс
			if(input.hasClass('account_field_allow')) {
	    		input.removeClass('account_field_allow');
	    	}

	    	// Если тег содержит класс
			if(input.hasClass('account_field_error')) {
				input.parent().children('.account_field_error_note').text(text);
				return;
			}

			input.addClass('account_field_error');
			input.parent().append('<em class="fa fa-times account_field_times"></em>');
			input.parent().append('<span class="account_field_error_note">' + text + '</span>');
			return;
		}

		// Regex Корректный email
		var regex = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
	    var valid = value.match(regex);

	    // Если в поле присутствуют ненужные символы
	    if(valid == null) {
	    	var text = 'Email введен некорректно.';

	    	// Если тег содержит класс
	    	if(input.hasClass('account_field_allow')) {
	    		input.removeClass('account_field_allow');
	    	}

	    	// Если тег содержит класс
	    	if(input.hasClass('account_field_error')) {
	    		input.parent().children('.account_field_error_note').text(text);
				return;
	    	}

	    	input.addClass('account_field_error');
			input.parent().append('<em class="fa fa-times account_field_times"></em>');
			input.parent().append('<span class="account_field_error_note">' + text + '</span>');
			return;
	    }

	    // Ajax-запрос на проверку email
	    $.ajax({
			async: false,
			url: '/ajax/accountEnter.php',
			type: 'POST',
			dataType: 'html',
			data: {action: 'check_email', email: value}
		})
		.done(function(result) {
			// Если вернулся ответ false
			if(result == 'false') {
				var text = 'Такой email не зарегистрирован.';

				// Если тег содержит класс
				if(input.hasClass('account_field_allow')) {
		    		input.removeClass('account_field_allow');
		    	}

		    	// Если тег содержит класс
		    	if(input.hasClass('account_field_error')) {
		    		input.parent().children('.account_field_error_note').text(text);
					return;
		    	}

		    	input.addClass('account_field_error');
				input.parent().append('<em class="fa fa-times account_field_times"></em>');
				input.parent().append('<span class="account_field_error_note">' + text + '</span>');
				return;
			}

			// Если поле заполнено корректно
		    if(input.hasClass('account_field_error')) {
		    	input.removeClass('account_field_error');
		    	input.parent().children('.account_field_times, .account_field_error_note').remove();
		    }

		    email = value;

		    input.addClass('account_field_allow');
        });

        this.email = email;
	}



	// Шаг №3 (ввод кода восстановления доступа) (#4)
	goToStep3() {
		var u_email = this.email;

		// Если email пустой
		if(u_email == '') {
			var text = 'Указан неверный email.';

			// Если тег содержит класс
        	if(!$('#account_filed_3').hasClass('account_recaptcha_error')) {
        		$('#account_filed_3').addClass('account_recaptcha_error');
        		$('#account_filed_3').parent().append('<em class="fa fa-times account_field_times"></em><span class="account_field_error_note">' + text + '</span>');
        	}

        	other.myAlertShow('error', text, false, 0);

			return;
		}

		// Если шаг №3 регистрации уже был загружен
		if($('#account_enter_step_3').get(0)) {
			$('#account_enter_step_3').show();
			$('#account_enter_step_3').animate({opacity: '100%'}, 300);

			$('#account_field_4').val('');
			$('#account_field_4').focus();

			// Если тег содержит класс
			if($('#account_field_4').hasClass('account_field_error')) {
				$('#account_field_4').removeClass('account_field_error');
				$('#account_field_4').parent().find('.account_field_times, .account_field_error_note').remove();
			}

			// Если тег содержит класс
			else if($('#account_field_4').hasClass('account_field_allow')) {
				$('#account_field_4').removeClass('account_field_allow');
			}

			return;
		}

		var content_box = $('#account_enter_form');

		// Ajax-запрос на загрузку третьего шага
		$.ajax({
			async: false,
			url: '/ajax/accountEnter.php',
			type: 'POST',
			dataType: 'html',
			data: {action: 'step_3', email: u_email}
		})
		.done(function(data) {
			content_box.append(data);

			$('#account_enter_step_2').hide();
			$('#account_enter_step_2').css({opacity: '0'});
			$('#account_enter_step_3').show();
			$('#account_enter_step_3').animate({opacity: '100%'}, 300);
			$('#account_field_4').focus();
        });
	}



	// Финиш восстановления пароля (#5)
	repairSuccess() {
		var u_email = this.email;
		var site_url = this.site_url;

		var input = $('#account_field_4');
		var mail_key = input.val();

		// Если значение не равно 6 символам
		if(mail_key.length != 6) {
			var text = 'Код состоит из 6 цифр.';

			// Если тег не содержит класс
			if(!input.hasClass('account_field_error')) {
		    	input.addClass('account_field_error');
				input.parent().append('<em class="fa fa-times account_field_times"></em>');
				input.parent().append('<span class="account_field_error_note">' + text + '</span>');
		    }

		    return;
		}

		var fingerprint = other.getUserFingerprint();

		// Ajax-запрос на завершение восстановления
		$.ajax({
			async: false,
			url: '/ajax/accountEnter.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'key_check',
				fp: fingerprint,
				key: mail_key,
				email: u_email
			}
		})
		.done(function(result) {
			// Если ответ содержит указанный текст
			if(result.includes('Вы заходите в аккаунт слишком часто')) {
				other.myAlertShow('error', result, false, 0);

				return;
			}

			// Если вернулся ответ success
			if(result == 'success') {
				let timerInterval

				var text = 'Пароль успешно восстановлен!';

				other.myAlertShow('success', text, false, 5);

				setTimeout(function() {
					other.goToPage(site_url);
				}, 5000);
			}

			// Если вернулся ответ error
			else {
				var text = 'Вы ввели неверный код.';

				// Если тег не содержит класс
				if(!input.hasClass('account_field_error')) {
			    	input.addClass('account_field_error');
					input.parent().append('<em class="fa fa-times account_field_times"></em>');
					input.parent().append('<span class="account_field_error_note">' + text + '</span>');
					return;
			    }

			    // Если тег содержит класс
			    if(input.hasClass('account_field_error')) {
			    	input.parent().children('.account_field_error_note').text(text);
			    }
			}
        });
	}



	// Возврат к шагу №2 из шага №3 (#6)
	backToStep2() {
		$('#account_enter_step_3').hide();
		$('#account_enter_step_3').css({opacity: '0'});

		$('#account_enter_step_2').show();
		$('#account_enter_step_2').animate({opacity: '100%'}, 300);

		$('#account_field_3').val('');
		$('#account_field_3').focus();

		this.email = '';

		// Если тег содержит класс
		if($('#account_field_3').hasClass('account_field_error')) {
			$('#account_field_3').removeClass('account_field_error');
			$('#account_field_3').parent().find('.account_field_times, .account_field_error_note').remove();
		}

		// Если тег содержит класс
		else if($('#account_field_3').hasClass('account_field_allow')) {
			$('#account_field_3').removeClass('account_field_allow');
		}
	}



	// Возврат к шагу №1 из шага №2 (#7)
	backToStep1() {
		$('#account_enter_step_2').hide();
		$('#account_enter_step_2').css({opacity: '0'});

		$('#account_enter_step_1').show();
		$('#account_enter_step_1').animate({opacity: '100%'}, 300);

		$('#account_field_1').focus();
	}



	// Очистка полей на шаге №1 (#8)
	step_1_clear() {
		$('#account_field_1, #account_field_2').val('');
		$('#account_field_1').focus();
		grecaptcha.reset();

		this.login = '';
		this.password = '';

		// Если тег содержит класс
		if($('.account_field').hasClass('account_field_error')) {
			$('.account_field').removeClass('account_field_error');
			$('.account_field').parent().find('.account_field_times, .account_field_error_note').remove();
		}

		// Если тег содержит класс
		else if($('.account_field').hasClass('account_field_allow')) {
			$('.account_field').removeClass('account_field_allow');
		}
	}



	// Очистка полей на шаге №2 (#9)
	step_2_clear() {
		$('#account_field_3').val('');
		$('#account_field_3').focus();

		this.email = '';

		// Если тег содержит класс
		if($('#account_field_3').hasClass('account_field_error')) {
			$('#account_field_3').removeClass('account_field_error');
			$('#account_field_3').parent().find('.account_field_times, .account_field_error_note').remove();
		}

		// Если тег содержит класс
		else if($('#account_field_3').hasClass('account_field_allow')) {
			$('#account_field_3').removeClass('account_field_allow');
		}
	}



	// Очистка полей на шаге №3 (#10)
	step_3_clear() {
		$('#account_field_4').val('');
		$('#account_field_4').focus();

		// Если тег содержит класс
		if($('#account_field_4').hasClass('account_field_error')) {
			$('#account_field_4').removeClass('account_field_error');
			$('#account_field_4').parent().find('.account_field_times, .account_field_error_note').remove();
		}

		// Если тег содержит класс
		else if($('#account_field_4').hasClass('account_field_allow')) {
			$('#account_field_4').removeClass('account_field_allow');
		}
	}



	// Проверка поля "Логин" (#11)
	loginCheck(value) {
		var login = '';
		var input = $('#account_field_1');
		value = value.toLowerCase();
		input.val(value);

		// Если поле пустое
		if(value == '') {
			var text = 'Вы не указали логин.';

			// Если тег содержит класс
			if(input.hasClass('account_field_allow')) {
	    		input.removeClass('account_field_allow');
	    	}

	    	// Если тег содержит класс
			if(input.hasClass('account_field_error')) {
				input.parent().children('.account_field_error_note').text(text);
				return;
			}

			input.addClass('account_field_error');
			input.parent().append('<em class="fa fa-times account_field_times"></em>');
			input.parent().append('<span class="account_field_error_note">' + text + '</span>');
			return;
		}

		// Regex Английские буквы, цифры и знаки подчеркивания
		var regex = /^[a-zA-Z0-9\_]{3,30}$/;
	    var valid = value.match(regex);

	    // Если в поле присутствуют ненужные символы
	    if(valid == null) {
	    	var text = 'Логин введен некорректно. Минимальная длина логина - 3 символа.';

	    	// Если тег содержит класс
	    	if(input.hasClass('account_field_allow')) {
	    		input.removeClass('account_field_allow');
	    	}

	    	// Если тег содержит класс
	    	if(input.hasClass('account_field_error')) {
	    		input.parent().children('.account_field_error_note').text(text);
				return;
	    	}

	    	input.addClass('account_field_error');
			input.parent().append('<em class="fa fa-times account_field_times"></em>');
			input.parent().append('<span class="account_field_error_note">' + text + '</span>');
			return;
	    }

	    // Ajax-запрос на проверку логина
	    $.ajax({
			async: false,
			url: '/ajax/accountEnter.php',
			type: 'POST',
			dataType: 'html',
			data: {action: 'check_login', login: value}
		})
		.done(function(result) {
			// Если вернулся ответ false
			if(result == 'false') {
				var text = 'Такой логин не зарегистрирован.';

				// Если тег содержит класс
				if(input.hasClass('account_field_allow')) {
		    		input.removeClass('account_field_allow');
		    	}

		    	// Если тег содержит класс
		    	if(input.hasClass('account_field_error')) {
		    		input.parent().children('.account_field_error_note').text(text);
					return;
		    	}

		    	input.addClass('account_field_error');
				input.parent().append('<em class="fa fa-times account_field_times"></em>');
				input.parent().append('<span class="account_field_error_note">' + text + '</span>');
				return;
			}

			// Если поле заполнено корректно
		    if(input.hasClass('account_field_error')) {
		    	input.removeClass('account_field_error');
		    	input.parent().children('.account_field_times, .account_field_error_note').remove();
		    }

		    login = value;

		    input.addClass('account_field_allow');
        });

        this.login = login;
	}



	// Проверка поля "Логин" (#12)
	passwordCheck(value) {
		var input = $('#account_field_2');

		// Если поле пустое
		if(value == '') {
			var text = 'Вы не ввели пароль.';

			// Если тег содержит класс
			if(input.hasClass('account_field_allow')) {
	    		input.removeClass('account_field_allow');
	    	}

	    	// Если тег содержит класс
			if(input.hasClass('account_field_error')) {
				input.parent().children('.account_field_error_note').text(text);
				return;
			}

			input.addClass('account_field_error');
			input.parent().append('<em class="fa fa-times account_field_times"></em>');
			input.parent().append('<span class="account_field_error_note">' + text + '</span>');
			return;
		}

		// Regex Английские буквы, цифры и указанные символы
		var regex = /^[a-zA-Z0-9!@#$%^&*_]{6,30}$/;
	    var valid = value.match(regex);

	    // Если в поле присутствуют ненужные символы
	    if(valid == null) {
	    	var text = 'Пароль не должен содержать пробелы. Длина пароля от 6 до 30 символов.';

	    	// Если тег содержит класс
	    	if(input.hasClass('account_field_allow')) {
	    		input.removeClass('account_field_allow');
	    	}

	    	// Если тег содержит класс
	    	if(input.hasClass('account_field_error')) {
	    		input.parent().children('.account_field_error_note').text(text);
				return;
	    	}

	    	input.addClass('account_field_error');
			input.parent().append('<em class="fa fa-times account_field_times"></em>');
			input.parent().append('<span class="account_field_error_note">' + text + '</span>');
			return;
	    }

	    // Если поле заполнено корректно
	    if(input.hasClass('account_field_error')) {
	    	input.removeClass('account_field_error');
	    	input.parent().children('.account_field_times, .account_field_error_note').remove();
	    }

	    input.addClass('account_field_allow');
	    this.password = value;
	}



	// Финиш (#13)
	finish() {
		var u_login = this.login;
		var u_password = this.password;

		var response_result = false;
		var site_url = this.site_url;

		// Если поле НЕ имеет класс allow (значит не прошло проверку)
		if(
			!$('#account_field_1').hasClass('account_field_allow') || 
			!$('#account_field_2').hasClass('account_field_allow')
		) 
		{
			var text = 'Не все поля были корректно заполнены.';

			other.myAlertShow('error', text, false, 0);

			return;
		}

		// Ajax-запрос на проверку капчи
		$.ajax({
			async: false,
			url: '/ajax/accountEnter.php',
			type: 'POST',
			dataType: 'html',
			data: "action=captcha_check&response=" + grecaptcha.getResponse()
		})
		.done(function(result) {
			// Если вернулся ответ true
			if(result == 'true') {
				response_result = true;
			}
        });

		// Если капча не прошла проверку
        if(response_result == false) {
        	var text = 'Вы не прошли проверку не робота.';

        	// Если тег не содержит класс
        	if(!$('#account_recaptcha').hasClass('account_recaptcha_error')) {
        		$('#account_recaptcha').addClass('account_recaptcha_error');
        		$('#account_recaptcha').parent().append('<em class="fa fa-times account_field_times"></em><span class="account_field_error_note">' + text + '</span>');
        	}

        	other.myAlertShow('error', text, false, 0);

			grecaptcha.reset();

			return;
        }

        var fingerprint = other.getUserFingerprint();

        // Ajax-запрос на завершение входа
		$.ajax({
			async: false,
			url: '/ajax/accountEnter.php',
			type: 'POST',
			dataType: 'html',
			data: {action: 'finish', fp: fingerprint, login: u_login, password: u_password}
		})
		.done(function(result) {
			// Если ответ содержит указанный текст
			if(result.includes('Вы заходите в аккаунт слишком часто')) {
				other.myAlertShow('error', result, false, 0);

				return;
			}

			// Если вернулся ответ false
			if(result == 'false') {
				other.myAlertShow('error', 'Пароль указан неверно. Повторите попытку.', false, 0);
			}

			// Если вернулся ответ true
			else {
				let timerInterval

				var text = 'Вы успешно вошли в аккаунт!';

				other.myAlertShow('success', text, false, 5);

				setTimeout(function() {
					other.goToPage(site_url);
				}, 5000);
			}
        });
	}



}



// Создание нового экземпляра класса
var account = new AccountEnter();

// Обработка событий
$('#account_enter_form').on('submit', function(e) { 
	e.preventDefault(); 
});