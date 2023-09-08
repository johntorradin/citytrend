// Класс "Регистрация аккаунта" (#class)
class AccountReg {



	site_url = ''; // Адрес сайта
	name 	 = ''; // Имя
	gender 	 = 'мужчина'; // Пол
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

        var fingerprint = other.getUserFingerprint();

        var content_box = $('#account_reg_form');

        // Ajax-запрос на загрузку первого шага
		$.ajax({
			async: false,
			url: '/ajax/accountReg.php',
			type: 'POST',
			dataType: 'html',
			data: {action: 'start', fp: fingerprint}
		})
		.done(function(data) {
			content_box.append(data);
        })
        .always(function() {
			$('#account_reg_step_1').show();
			$('#account_reg_step_1').animate({opacity: '100%'}, 300);
			$('#account_field_1').focus();
		});
	}



	// Проверка поля "Имя" (#2)
	nameCheck(value) {
		var input = $('#account_field_1');
		value = other.mb_ucfirst(value);
		input.val(value);

		// Если поле пустое
		if(value == '') {
			var text = 'Вы не указали своё имя.';

			// Если тег имеет класс
			if(input.hasClass('account_field_allow')) {
	    		input.removeClass('account_field_allow');
	    	}

	    	// Если тег имеет класс
			if(input.hasClass('account_field_error')) {
				input.parent().children('.account_field_error_note').text(text);
				return;
			}

			input.addClass('account_field_error');
			input.parent().append('<em class="fa fa-times account_field_times"></em>');
			input.parent().append('<span class="account_field_error_note">' + text + '</span>');
			return;
		}

		// Если значение меньше 2 знаков
		if(value.length < 2) {
			var text = 'Минимальное значение - 2 символа.';

			// Если тег имеет класс 
			if(input.hasClass('account_field_allow')) {
	    		input.removeClass('account_field_allow');
	    	}

	    	// Если тег имеет класс
			if(input.hasClass('account_field_error')) {
				input.parent().children('.account_field_error_note').text(text);
				return;
			}

			input.addClass('account_field_error');
			input.parent().append('<em class="fa fa-times account_field_times"></em>');
			input.parent().append('<span class="account_field_error_note">' + text + '</span>');
			return;
		}

		// Regex Русские буквы
		var regex = /^[а-яА-Я]+$/;
	    var valid = value.match(regex);

	    // Если в поле присутствуют ненужные символы
	    if(valid == null) {
	    	var text = 'Имя введено некорректно. Используйте только русские буквы.';

	    	// Если тег имеет класс
	    	if(input.hasClass('account_field_allow')) {
	    		input.removeClass('account_field_allow');
	    	}

	    	// Если тег имеет класс
	    	if(input.hasClass('account_field_error')) {
	    		input.parent().children('.account_field_error_note').text(text);
				return;
	    	}

	    	input.addClass('account_field_error');
			input.parent().append('<em class="fa fa-times account_field_times"></em>');
			input.parent().append('<span class="account_field_error_note">' + text + '</span>');
			return;
	    }

	    // Если тег имеет класс
	    if(input.hasClass('account_field_error')) {
	    	input.removeClass('account_field_error');
	    	input.parent().children('.account_field_times, .account_field_error_note').remove();
	    }

	    input.addClass('account_field_allow');
	    this.name = value;
	}



	// Выбор пола (м/ж) (#3)
	genderSet(gender) {
		// Если пол "мужчина"
		if(gender == 'мужчина') {
			$('#account_gender_female_checkbox').html('');
			$('#account_gender_male_checkbox').html('<em class="fa fa-check"></em>');
			this.gender = gender;
		}

		// Если пол "женщина"
		else if(gender == 'женщина') {
			$('#account_gender_male_checkbox').html('');
			$('#account_gender_female_checkbox').html('<em class="fa fa-check"></em>');
			this.gender = gender;
		}
	}



	// Проверка поля "Логин" (#4)
	loginCheck(value) {
		var login = '';
		var input = $('#account_field_2');
		value = value.toLowerCase();
		input.val(value);

		// Если поле пустое
		if(value == '') {
			var text = 'Вы не указали логин.';

			// Если тег имеет класс
			if(input.hasClass('account_field_allow')) {
	    		input.removeClass('account_field_allow');
	    	}

	    	// Если тег имеет класс
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
	    	var text = 'Логин введен некорректно. Используйте только английские буквы, цифры и знаки подчеркивания. Разрешенная длина логина от 3 до 30 символов';

	    	// Если тег имеет класс
	    	if(input.hasClass('account_field_allow')) {
	    		input.removeClass('account_field_allow');
	    	}

	    	// Если тег имеет класс
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
			url: '/ajax/accountReg.php',
			type: 'POST',
			dataType: 'html',
			data: {action: 'check_login', login: value}
		})
		.done(function(result) {
			// Если ответ вернул false
			if(result == 'false') {
				var text = 'Логин уже занят.';

				// Если тег имеет класс
				if(input.hasClass('account_field_allow')) {
		    		input.removeClass('account_field_allow');
		    	}

		    	// Если тег имеет класс
		    	if(input.hasClass('account_field_error')) {
		    		input.parent().children('.account_field_error_note').text(text);
					return;
		    	}

		    	input.addClass('account_field_error');
				input.parent().append('<em class="fa fa-times account_field_times"></em>');
				input.parent().append('<span class="account_field_error_note">' + text + '</span>');
				return;
			}

			// Если тег имеет класс
		    if(input.hasClass('account_field_error')) {
		    	input.removeClass('account_field_error');
		    	input.parent().children('.account_field_times, .account_field_error_note').remove();
		    }

		    login = value;

		    input.addClass('account_field_allow');
        });

        this.login = login;
	}



	// Проверка поля "Email" (#5)
	emailCheck(value) {
		var email = '';
		var input = $('#account_field_3');
		value = value.toLowerCase();
		input.val(value);

		// Если поле пустое
		if(value == '') {
			var text = 'Вы не указали email.';

			// Если тег имеет класс
			if(input.hasClass('account_field_allow')) {
	    		input.removeClass('account_field_allow');
	    	}

	    	// Если тег имеет класс
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

	    	// Если тег имеет класс
	    	if(input.hasClass('account_field_allow')) {
	    		input.removeClass('account_field_allow');
	    	}

	    	// Если тег имеет класс
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
			url: '/ajax/accountReg.php',
			type: 'POST',
			dataType: 'html',
			data: {action: 'check_email', email: value}
		})
		.done(function(result) {
			// Если вернулся ответ false
			if(result == 'false') {
				var text = 'Email уже занят.';

				// Если тег имеет класс
				if(input.hasClass('account_field_allow')) {
		    		input.removeClass('account_field_allow');
		    	}

		    	// Если тег имеет класс
		    	if(input.hasClass('account_field_error')) {
		    		input.parent().children('.account_field_error_note').text(text);
					return;
		    	}

		    	input.addClass('account_field_error');
				input.parent().append('<em class="fa fa-times account_field_times"></em>');
				input.parent().append('<span class="account_field_error_note">' + text + '</span>');
				return;
			}

			// Если тег имеет класс
		    if(input.hasClass('account_field_error')) {
		    	input.removeClass('account_field_error');
		    	input.parent().children('.account_field_times, .account_field_error_note').remove();
		    }

		    email = value;

		    input.addClass('account_field_allow');
        });

        this.email = email;
	}



	// Проверка поля "Пароль" (#6)
	passwordCheck(value) {
		var input = $('#account_field_4');

		// Если поле пустое
		if(value == '') {
			var text = 'Вы не ввели пароль.';

			// Если тег имеет класс
			if(input.hasClass('account_field_allow')) {
	    		input.removeClass('account_field_allow');
	    	}

	    	// Если тег имеет класс
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
	    	var text = 'Пароль не должен содержать пробелы. Разрешенная длина пароля от 6 до 30 символов.';

	    	// Если тег имеет класс
	    	if(input.hasClass('account_field_allow')) {
	    		input.removeClass('account_field_allow');
	    	}

	    	// Если тег имеет класс
	    	if(input.hasClass('account_field_error')) {
	    		input.parent().children('.account_field_error_note').text(text);
				return;
	    	}

	    	input.addClass('account_field_error');
			input.parent().append('<em class="fa fa-times account_field_times"></em>');
			input.parent().append('<span class="account_field_error_note">' + text + '</span>');
			return;
	    }

	    // Если тег имеет класс
	    if(input.hasClass('account_field_error')) {
	    	input.removeClass('account_field_error');
	    	input.parent().children('.account_field_times, .account_field_error_note').remove();
	    }

	    input.addClass('account_field_allow');
	    this.password = value;
	}



	// Проверка поля "Повторный пароль" (#7)
	repeatPasswordCheck(value) {
		var input = $('#account_field_5');
		var password = $('#account_field_4').val();

		// Если основное поле для ввода пароля не заполнено
		if(password == '')
			return;

		// Если поле пустое
		if(value == '') {
			var text = 'Вы не ввели повторный пароль.';

			// Если тег имеет класс
			if(input.hasClass('account_field_allow')) {
	    		input.removeClass('account_field_allow');
	    	}

	    	// Если тег имеет класс
			if(input.hasClass('account_field_error')) {
				input.parent().children('.account_field_error_note').text(text);
				return;
			}

			input.addClass('account_field_error');
			input.parent().append('<em class="fa fa-times account_field_times"></em>');
			input.parent().append('<span class="account_field_error_note">' + text + '</span>');
			return;
		}

		// Если поля не совпадают
		if(password != value) {
			var text = 'Пароли не совпадают.';

			// Если тег имеет класс
			if(input.hasClass('account_field_allow')) {
	    		input.removeClass('account_field_allow');
	    	}

	    	// Если тег имеет класс
			if(input.hasClass('account_field_error')) {
				input.parent().children('.account_field_error_note').text(text);
				return;
			}

			input.addClass('account_field_error');
			input.parent().append('<em class="fa fa-times account_field_times"></em>');
			input.parent().append('<span class="account_field_error_note">' + text + '</span>');
			return;
		}

	    // Если тег имеет класс
	    if(input.hasClass('account_field_error')) {
	    	input.removeClass('account_field_error');
	    	input.parent().children('.account_field_times, .account_field_error_note').remove();
	    }

	    input.addClass('account_field_allow');
	}



	// Переход к шагу №2 (#8)
	goToStep2() {

		// Если поле НЕ имеет класс allow (значит не прошло проверку)
		if(
			!$('#account_field_1').hasClass('account_field_allow') || 
			!$('#account_field_2').hasClass('account_field_allow') || 
			!$('#account_field_3').hasClass('account_field_allow') || 
			!$('#account_field_4').hasClass('account_field_allow') || 
			!$('#account_field_5').hasClass('account_field_allow')
		) 
		{
			other.myAlertShow('error', 'Не все поля были корректно заполнены.', false, 0);

			return;
		}

		$('#account_reg_step_1').hide();
		$('#account_reg_step_1').css({opacity: '0'});

		// Если шаг №2 регистрации уже был загружен
		if($('#account_reg_step_2').get(0)) {
			$('#account_reg_step_2').show();
			$('#account_reg_step_2').animate({opacity: '100%'}, 300);
			return;
		}

		var content_box = $('#account_reg_form');

		var sitekey = '';

		// Ajax-запрос на получение html-ключа grecaptcha из конфига
		$.ajax({
			async: false,
			url: '/ajax/loadConfig.php',
			type: 'POST',
			dataType: 'html',
			data: {variable: 'gr_sitekey'}
		})
		.done(function(key) {
			sitekey = key;
        });

		// Ajax-запрос на загрузку второго шага
		$.ajax({
			async: false,
			url: '/ajax/accountReg.php',
			type: 'POST',
			dataType: 'html',
			data: {action: 'reg_step_2'}
		})
		.done(function(data) {
			content_box.append(data);

			grecaptcha.render('grecaptcha', {
	        	'sitekey' : sitekey
	        });
        })
        .always(function() {
        	$('#account_data_mailkey_line').hide();
			$('#account_reg_step_2').show();
			$('#account_reg_step_2').animate({opacity: '100%'}, 300);
		});
	}



	// Согласие с правилами сайта (#9)
	rulesAccept() {
		// Если чекбокс не активирован
		if($('#account_rules_checkbox').html() == '') {
			$('#account_rules_checkbox').html('<em class="fa fa-check"></em>');
		}

		// Если чекбокс активирован
		else {
			$('#account_rules_checkbox').html('');
		}
	}



	// Отправка кода на email (#10)
	goToMailSend() {
		var response_result = false;
		var rules_accept = false;

		// Ajax-запрос на проверку капчи
		$.ajax({
			async: false,
			url: '/ajax/accountReg.php',
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

		// Если чекбокс активирован
        if($('#account_rules_checkbox').html() != '')
        	rules_accept = true;

        // Если капча не пройдена
        if(response_result == false) {
        	var text = 'Вы не прошли проверку не робота.';

        	// Если тег имеет класс
        	if(!$('#account_recaptcha').hasClass('account_recaptcha_error')) {
        		$('#account_recaptcha').addClass('account_recaptcha_error');
        		$('#account_recaptcha').parent().append('<em class="fa fa-times account_field_times"></em><span class="account_field_error_note">' + text + '</span>');
        	}

        	other.myAlertShow('error', 'Необходимо пройти проверку на робота.', false, 0);

			grecaptcha.reset();

			return;
        }

        // Если чекбокс не активирован
        if(rules_accept == false) {
        	var text = 'Для продолжения, необходимо ознакомиться с правилами сайта и принять их.';

        	// Если тег имеет класс
        	if(!$('#account_rules_title').hasClass('account_rules_error')) {
        		$('#account_rules_title').addClass('account_rules_error');
        		$('#account_rules_title').parent().append('<em class="fa fa-times account_field_times"></em><span class="account_field_error_note">' + text + '</span>');
        	}

        	other.myAlertShow('error', 'Необходимо ознакомится с правилами сайта и принять их!', false, 0);

			return;
        }

        // Если капча пройдена и правила сайта приняты
        if(response_result == true && rules_accept == true) {
        	// Если тег имеет класс
        	if($('#account_recaptcha').hasClass('account_recaptcha_error')) {
        		$('#account_recaptcha').removeClass('account_recaptcha_error');
				$('#account_recaptcha').parent().children('.account_field_times, .account_field_error_note').remove();
        	}

        	// Если тег имеет класс
        	if($('#account_rules_title').hasClass('account_rules_error')) {
        		$('#account_rules_title').removeClass('account_rules_error');
				$('#account_rules_title').parent().children('.account_field_times, .account_field_error_note').remove();
        	}

        	// Ajax-запрос на отправку письма
        	$.ajax({
				async: false,
				url: '/ajax/accountReg.php',
				type: 'POST',
				dataType: 'html',
				data: {action: 'mail_send', email: this.email}
			})
			.done(function(result) {
				// Если вернулся ответ true
				if(result == 'true') {
					$('#reg_step_2_line_note').text('На Вашу эл. почту было отправлено письмо с кодом подтверждения.');

					other.myAlertShow('success', 'На Вашу эл. почту было отправлено письмо с кодом подтверждения. Введите код в поле и нажмите на кнопку "Зарегистрироваться".', false, 0);

					$('#account_data_mailkey_line').show();
					$('#account_reg_mailsend').remove();
					$('#account_reg_finish').show();
					$('#account_field_6').focus();
				}
	        });
        }
	}



	// Возврат к шагу №1 (#11)
	backToStep1() {
		$('#account_reg_step_2').hide();
		$('#account_reg_step_2').css({opacity: '0'});

		$('#account_reg_step_1').show();
		$('#account_reg_step_1').animate({opacity: '100%'}, 300);

		$('#account_field_1').focus();
	}



	// Финиш (#12)
	finish() {
		var site_url = this.site_url;

		var input = $('#account_field_6');
		var mail_key = input.val();

		// Если значение не равно 6 символам
		if(mail_key.length != 6) {
			var text = 'Код состоит из 6 цифр.';

			// Если тег не имеет класс
			if(!input.hasClass('account_field_error')) {
		    	input.addClass('account_field_error');
				input.parent().append('<em class="fa fa-times account_field_times"></em>');
				input.parent().append('<span class="account_field_error_note">' + text + '</span>');
		    }

		    return;
		}

		var u_name = this.name;
		var u_gender = this.gender;
		var u_login = this.login;
		var u_email = this.email;
		var u_password = this.password; 

		// Ajax-запрос на завершение
		$.ajax({
			async: false,
			url: '/ajax/accountReg.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'key_check', 
				key: mail_key,
				name: u_name,
				gender: u_gender,
				login: u_login,
				email: u_email,
				password: u_password
			}
		})
		.done(function(result) {
			// Если вернулся ответ success
			if(result == 'success') {
				let timerInterval

				other.myAlertShow('success', 'Вы успешно зарегистрированы!', false, 5);

				setTimeout(function() {
					other.goToPage(site_url);
				}, 5000);
			}

			// Если вернулся ответ error
			else if(result == 'error') {
				var text = 'Вы ввели неверный код.';

				// Если тег не имеет класс
				if(!input.hasClass('account_field_error')) {
			    	input.addClass('account_field_error');
					input.parent().append('<em class="fa fa-times account_field_times"></em>');
					input.parent().append('<span class="account_field_error_note">' + text + '</span>');
					return;
			    }

			    // Если тег имеет класс
			    if(input.hasClass('account_field_error')) {
			    	input.parent().children('.account_field_error_note').text(text);
			    }
			}

			// Если вернулось число минут до конца блокировки
			else {
				other.myAlertShow('error', 'Вы недавно зарегистрировали другой аккаунт. Следующий аккаунт можно будет зарегистрировать через ' + result + ' мин.', false, 0);
			}
        });
	}



	// Очистка полей (#13)
	fieldsClear() {
		$('.account_field').val('');
		$('#account_field_1').focus();

		$('#account_gender_male_checkbox').html('<em class="fa fa-check"></em>');
		$('#account_gender_female_checkbox').html('');

		// Если тег имеет класс
		if($('.account_field').hasClass('account_field_error')) {
			$('.account_field').removeClass('account_field_error');
			$('.account_field').parent().find('.account_field_times, .account_field_error_note').remove();
		}

		// Если тег имеет класс
		else if($('.account_field').hasClass('account_field_allow')) {
			$('.account_field').removeClass('account_field_allow');
		}
	}


	
}



// Создание нового экземпляра класса
var account = new AccountReg();

// Обработка событий
$('#account_reg_form').on('submit', function(e) { 
	e.preventDefault(); 
});