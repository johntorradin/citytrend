// Класс "Аккаунт в Header" (#class)
class AccountHeader {



	start_name 	  	 	= ''; // Начальное имя
	start_login   	 	= ''; // Начальный логин
	start_email   	 	= ''; // Начальный email
	start_address 	 	= ''; // Начальный адрес
	new_name 	 	 	= ''; // Новое имя
	new_login 	 	 	= ''; // Новый логин
	new_email 	 	 	= ''; // Новый email
	new_address  	 	= ''; // Новый адрес
	new_password 	 	= ''; // Новый пароль
	name_changed 	 	= false; // Было ли изменено значение имени
	login_changed 	 	= false; // Было ли изменено значение логина
	email_changed 	 	= false; // Было ли изменено значение почты
	address_changed  	= false; // Было ли изменено значение адреса
	password_changed 	= false; // Было ли изменено значение пароля
	real_password_state = false; // Состояние проверки настоящего пароля



	// Загрузить новое фото профиля (#1)
	addAvatar() {
		var formData = new FormData();

		formData.append('file', $("#account_avatar_input")[0].files[0]);

		// Ajax-запрос на загрузку аватарки
		$.ajax({
			type: "POST",
			url: '/ajax/accountHeader.php',
			cache: false,
			contentType: false,
			processData: false,
			dataType : 'html',
			data: formData
		})
		.done(function(result) {
			var my_alert_icon = '';
			var my_alert_msg = '';

			// Если вернулся указанный ответ
			if(result == 'файл отсутствует') 
				return;

			// Если вернулся указанный ответ
			else if( result.includes('Вы недавно устанавливали фото профиля') ) {
				my_alert_icon = 'error';
				my_alert_msg = result;
			}

			// Если вернулся указанный ответ
			else if(result == 'ошибка загрузки') {
				my_alert_icon = 'error';
				my_alert_msg = 'Ошибка загрузки файла.'
			}

			// Если вернулся указанный ответ
			else if(result == 'недопустимый тип файла') {
				my_alert_icon = 'error';
				my_alert_msg = 'Был загружен недопустимый файл. Разрешается использовать только файлы в формате JPG (JPEG).';
			}

			// Если вернулся указанный ответ
			else if(result == 'большой размер файла') {
				my_alert_icon = 'error';
				my_alert_msg = 'Файл имеет слишком большой размер. Максимальный вес файла - 1 МБ.';
			}

			// Если вернулся указанный ответ
			else if(result == 'файл успешно загружен') {
				my_alert_icon = 'success';
				my_alert_msg = 'Вы успешно загрузили новое фото профиля!';
			}

			other.myAlertShow(my_alert_icon, my_alert_msg, false, 0);

			// Если вернулся ответ success
			if(my_alert_icon == 'success') {
				var login = $('#user_login').html();
				var num = Math.random();
				var src = '../media/images/avatars/' + login + '.jpg?v=' + num;

				$('#account_data_avatar').animate({opacity: '0'}, 0);
				$('#account_avatar').attr('src', src);
				$('#account_data_avatar').animate({opacity: '100%'}, 200);
			}
        });
	}



	// Вывести "инфо пользователя" (#2)
	selectUserInfo() {
		var fingerprint = other.getUserFingerprint();
		
		// Ajax-запрос на получение данных аккаунта
		$.ajax({
			async: false,
			url: '/ajax/accountHeader.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'selectUserInfo', 
				fp:     fingerprint
			}
		})
		.done(function(data) {
			$('#user_info_form').append(data);
        });
	}
	


	// Показать контейнер "инфо пользователя" (#3)
	showBox() {
		$('#search_results').hide();

		$('#user_info_box').show();
		$('#user_info_box').css({opacity: '100%'});
		$('.user_info_box').animate({opacity: '100%'}, 300);

		$('html, body').css({
			overflow: 'hidden', 
			height:   '100%'
		});
	}



	// Скрыть контейнер "инфо пользователя" при клике (#4)
	hideBoxOnClick() {
		$('.user_info_box').animate({opacity: '0'}, 300);
		$('#user_info_box').animate({opacity: '0'}, 300);

		$('html, body').css({
			overflow: 'auto', 
			height:   'auto'
		});

		setTimeout(function(){ 
			$('#user_info_box').hide(); 
		}, 300);
	}



	// Показать контейнер "редактирование инфо пользователя" (#5)
	showEditBox() {
		var content_box = $('#user_info_edit_form');

		// Ajax-запрос на получение формы редактирования
		$.ajax({
			async: false,
			url: '/ajax/accountHeader.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'edit_box_show'
			}
		})
		.done(function(data) {
			content_box.append(data);
        })
        .always(function() {
			$('#search_results').hide();
			$('#user_info_box').hide();

			$('#user_info_edit').show();
			$('#user_info_edit').css({opacity: '100%'});
			$('.user_info_edit').animate({opacity: '100%'}, 300);
			$('#account_edit_field_1').focus();

			$('html, body').css({
				overflow: 'hidden', 
				height:   '100%'
			});
		});

		this.start_name = $('#account_edit_field_1').val();
		this.start_login = $('#account_edit_field_2').val();
		this.start_email = $('#account_edit_field_3').val();
		this.start_address = this.new_address = $('#account_edit_field_4').val();
	}



	// Скрыть контейнер "редактирование инфо пользователя" (#6)
	hideEditBox() {
		this.new_name = '';
		this.new_login = '';
		this.new_email = '';
		this.new_address = '';
		this.new_password = '';
		this.name_changed = false;
		this.login_changed = false;
		this.email_changed = false;
		this.address_changed = false;
		this.real_password_state = false;

		$('#user_info_box').show();

		$('.user_info_edit').animate({opacity: '0'}, 300);
		$('#user_info_edit').animate({opacity: '0'}, 300);

		$('html, body').css({
			overflow: 'auto', 
			height:   'auto'
		});

		setTimeout(function(){ 
			$('#user_info_edit').hide();
			$('#user_info_edit_form').html('<button onclick="account.hideEditBox()" id="user_info_edit_close" class="box_close"><em class="fa fa-times"></em></button>');
		}, 300);
	}



	// Скрыть контейнеры "инфо пользователя" и "редактирование инфо пользователя" при нажатии Escape (#7)
	hideBoxesOnEscape() {
		this.new_name = '';
		this.new_login = '';
		this.new_email = '';
		this.new_address = '';
		this.new_password = '';
		this.name_changed = false;
		this.login_changed = false;
		this.email_changed = false;
		this.address_changed = false;
		this.real_password_state = false;

		$('.user_info_box').animate({opacity: '0'}, 300);
		$('#user_info_box').animate({opacity: '0'}, 300);
		$('.user_info_edit').animate({opacity: '0'}, 300);
		$('#user_info_edit').animate({opacity: '0'}, 300);

		$('html, body').css({
			overflow: 'auto', 
			height:   'auto'
		});

		setTimeout(function(){ 
			$('#user_info_box').hide();
			$('#user_info_edit').hide(); 
			$('#user_info_edit_form').html('<button onclick="account.hideEditBox()" id="user_info_edit_close" class="box_close"><em class="fa fa-times"></em></button>'); 
		}, 300);
	}



	// Проверка поля "Имя" (#8)
	nameCheck(value) {
		var input = $('#account_edit_field_1');
		var start_name = this.start_name;
		value = other.mb_ucfirst(value);

		input.val(value);

		// Regex Русские буквы
		var regex = /^[а-яА-Я]+$/;
	    var valid = value.match(regex);

		// Если поле пустое
		if(value == '') {
			this.new_name = 'error';
			this.name_changed = false;
			var text = 'Вы не указали имя.';

			// Если тег содержит класс
			if(input.hasClass('account_edit_field_allow')) {
	    		input.removeClass('account_edit_field_allow');
	    	}

	    	// Если тег содержит класс
			if(input.hasClass('account_edit_field_error')) {
				input.parent().children('.account_edit_error_note').text(text);

				return;
			}

			input.addClass('account_edit_field_error');
			input.parent().append('<em class="fa fa-times account_edit_field_times"></em>');
			input.parent().append('<span class="account_edit_error_note">' + text + '</span>');

			return;
		}

		// Если значение меньше 2 символов
		if(value.length < 2) {
			this.new_name = 'error';
			this.name_changed = false;
			var text = 'Минимальное значение - 2 символа.';

			// Если тег содержит класс
			if(input.hasClass('account_edit_field_allow')) {
	    		input.removeClass('account_edit_field_allow');
	    	}

	    	// Если тег содержит класс
			if(input.hasClass('account_edit_field_error')) {
				input.parent().children('.account_edit_error_note').text(text);

				return;
			}

			input.addClass('account_edit_field_error');
			input.parent().append('<em class="fa fa-times account_edit_field_times"></em>');
			input.parent().append('<span class="account_edit_error_note">' + text + '</span>');

			return;
		}

		// Если значение совпадает с тем, которое было у пользователя перед редактированием
		if(value == start_name) {
			this.new_name = '';
			this.name_changed = false;

			// Если тег содержит класс
			if(input.hasClass('account_edit_field_allow')) {
	    		input.removeClass('account_edit_field_allow');
	    	}

	    	// Если тег содержит класс
	    	if(input.hasClass('account_edit_field_error')) {
				input.removeClass('account_edit_field_error');
				input.parent().children('.account_edit_field_times, .account_edit_error_note').remove();
			}

			return;
		}

	    // Если в поле присутствуют ненужные символы
	    if(valid == null) {
	    	this.new_name = 'error';
	    	this.name_changed = false;
	    	var text = 'Имя введено некорректно. Используйте только русские буквы.';

	    	// Если тег содержит класс
	    	if(input.hasClass('account_edit_field_allow')) {
	    		input.removeClass('account_edit_field_allow');
	    	}

	    	// Если тег содержит класс
	    	if(input.hasClass('account_edit_field_error')) {
	    		input.parent().children('.account_edit_error_note').text(text);

				return;
	    	}

	    	input.addClass('account_edit_field_error');
			input.parent().append('<em class="fa fa-times account_edit_field_times"></em>');
			input.parent().append('<span class="account_edit_error_note">' + text + '</span>');

			return;
	    }

	    // Если поле заполнено корректно
	    else {
	    	this.new_name = value;
	    	this.name_changed = true;

	    	// Если тег содержит класс
		    if(input.hasClass('account_edit_field_error')) {
		    	input.removeClass('account_edit_field_error');
		    	input.parent().children('.account_edit_field_times, .account_edit_error_note').remove();
		    }

		    input.addClass('account_edit_field_allow');
	    }
	}



	// Проверка поля "Логин" (#9)
	loginCheck(value) {
		var input = $('#account_edit_field_2');
		var start_login = this.start_login;
		var new_login = this.new_login;
		var login_changed = this.login_changed;
		value = value.toLowerCase();

		input.val(value);

		// Regex Английские буквы, цифры и знаки подчеркивания
		var regex = /^[a-zA-Z0-9\_]{3,30}$/;
	    var valid = value.match(regex);

		// Если поле пустое
		if(value == '') {
			new_login = 'error';
			login_changed = false;
			var text = 'Вы не указали логин.';

			// Если тег содержит класс
			if(input.hasClass('account_edit_field_allow')) {
	    		input.removeClass('account_edit_field_allow');
	    	}

	    	// Если тег содержит класс
			if(input.hasClass('account_edit_field_error')) {
				input.parent().children('.account_edit_error_note').text(text);

				return;
			}

			input.addClass('account_edit_field_error');
			input.parent().append('<em class="fa fa-times account_edit_field_times"></em>');
			input.parent().append('<span class="account_edit_error_note">' + text + '</span>');

			this.new_login = new_login;
			this.login_changed = login_changed;

			return;
		}

		// Если значение меньше 3 символов
		if(value.length < 3) {
			new_login = 'error';
			login_changed = false;
			var text = 'Минимальное значение - 3 символа.';

			// Если тег содержит класс
			if(input.hasClass('account_edit_field_allow')) {
	    		input.removeClass('account_edit_field_allow');
	    	}

	    	// Если тег содержит класс
			if(input.hasClass('account_edit_field_error')) {
				input.parent().children('.account_edit_error_note').text(text);

				return;
			}

			input.addClass('account_edit_field_error');
			input.parent().append('<em class="fa fa-times account_edit_field_times"></em>');
			input.parent().append('<span class="account_edit_error_note">' + text + '</span>');

			this.new_login = new_login;
			this.login_changed = login_changed;

			return;
		}

		// Если значение совпадает с тем, которое было у пользователя перед редактированием
		if(value == start_login) {
			new_login = '';
			login_changed = false;

			// Если тег содержит класс
			if(input.hasClass('account_edit_field_allow')) {
	    		input.removeClass('account_edit_field_allow');
	    	}

	    	// Если тег содержит класс
	    	if(input.hasClass('account_edit_field_error')) {
				input.removeClass('account_edit_field_error');
				input.parent().children('.account_edit_field_times, .account_edit_error_note').remove();
			}

			this.new_login = new_login;
			this.login_changed = login_changed;

			return;
		}

		// Если в поле присутствуют ненужные символы
	    if(valid == null) {
	    	new_login = 'error';
	    	login_changed = false;
	    	var text = 'Логин введен некорректно. Используйте только английские буквы, цифры и знаки подчеркивания. Разрешенная длина логина от 3 до 30 символов';

	    	// Если тег содержит класс
	    	if(input.hasClass('account_edit_field_allow')) {
	    		input.removeClass('account_edit_field_allow');
	    	}

	    	// Если тег содержит класс
	    	if(input.hasClass('account_edit_field_error')) {
	    		input.parent().children('.account_edit_error_note').text(text);

				return;
	    	}

	    	input.addClass('account_edit_field_error');
			input.parent().append('<em class="fa fa-times account_edit_field_times"></em>');
			input.parent().append('<span class="account_edit_error_note">' + text + '</span>');

			this.new_login = new_login;
			this.login_changed = login_changed;

			return;
	    }

	    // Ajax-запрос на проверку логина
	    $.ajax({
			async: false,
			url: '/ajax/accountHeader.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'check_login', 
				login: value
			}
		})
		.done(function(result) {
			// Если вернулся ответ false
			if(result == 'false') {
				new_login = 'error';
				login_changed = false;
				var text = 'Логин уже занят.';

				// Если тег содержит класс
				if(input.hasClass('account_edit_field_allow')) {
		    		input.removeClass('account_edit_field_allow');
		    	}

		    	// Если тег содержит класс
		    	if(input.hasClass('account_edit_field_error')) {
		    		input.parent().children('.account_edit_error_note').text(text);

					return;
		    	}

		    	input.addClass('account_edit_field_error');
				input.parent().append('<em class="fa fa-times account_edit_field_times"></em>');
				input.parent().append('<span class="account_edit_error_note">' + text + '</span>');

				return;
			}

			// Если поле заполнено корректно
			else {
				new_login = value;
				login_changed = true;

				// Если тег содержит класс
			    if(input.hasClass('account_edit_field_error')) {
			    	input.removeClass('account_edit_field_error');
			    	input.parent().children('.account_edit_field_times, .account_edit_error_note').remove();
			    }

			    input.addClass('account_edit_field_allow');
			}
        });

        this.new_login = new_login;
        this.login_changed = login_changed;
	}



	// Проверка поля "Email" (#10)
	emailCheck(value) {
		var input = $('#account_edit_field_3');
		var start_email = this.start_email;
		var new_email = this.new_email;
		var email_changed = this.email_changed;
		value = value.toLowerCase();

		input.val(value);

		// Regex Корректный email
		var regex = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
	    var valid = value.match(regex);

		// Если поле пустое
		if(value == '') {
			new_email = 'error';
			email_changed = false;
			var text = 'Вы не указали email.';

			// Если тег содержит класс
			if(input.hasClass('account_edit_field_allow')) {
	    		input.removeClass('account_edit_field_allow');
	    	}

	    	// Если тег содержит класс
			if(input.hasClass('account_edit_field_error')) {
				input.parent().children('.account_edit_error_note').text(text);

				return;
			}

			input.addClass('account_edit_field_error');
			input.parent().append('<em class="fa fa-times account_edit_field_times"></em>');
			input.parent().append('<span class="account_edit_error_note">' + text + '</span>');

			this.new_email = new_email;
			this.email_changed = email_changed;

			return;
		}

		// Если значение совпадает с тем, которое было у пользователя перед редактированием
		if(value == start_email) {
			new_email = '';
			email_changed = false;

			// Если тег содержит класс
			if(input.hasClass('account_edit_field_allow')) {
	    		input.removeClass('account_edit_field_allow');
	    	}

	    	// Если тег содержит класс
	    	if(input.hasClass('account_edit_field_error')) {
				input.removeClass('account_edit_field_error');
				input.parent().children('.account_edit_field_times, .account_edit_error_note').remove();
			}

			this.new_email = new_email;
			this.email_changed = email_changed;

			return;
		}

		// Если поле заполнено некорректно
	    if(valid == null) {
	    	new_email = 'error';
	    	email_changed = false;
	    	var text = 'Email введен некорректно.';

	    	// Если тег содержит класс
	    	if(input.hasClass('account_edit_field_allow')) {
	    		input.removeClass('account_edit_field_allow');
	    	}

	    	// Если тег содержит класс
	    	if(input.hasClass('account_edit_field_error')) {
	    		input.parent().children('.account_edit_error_note').text(text);

				return;
	    	}

	    	input.addClass('account_edit_field_error');
			input.parent().append('<em class="fa fa-times account_edit_field_times"></em>');
			input.parent().append('<span class="account_edit_error_note">' + text + '</span>');

			this.new_email = new_email;
			this.email_changed = email_changed;

			return;
	    }

	    // Ajax-запрос на проверку email
	    $.ajax({
			async: false,
			url: '/ajax/accountHeader.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'check_email', 
				email: value
			}
		})
		.done(function(result) {
			// Если вернулся ответ false
			if(result == 'false') {
				new_email = 'error';
				email_changed = false;
				var text = 'Email уже занят.';

				// Если тег содержит класс
				if(input.hasClass('account_edit_field_allow')) {
		    		input.removeClass('account_edit_field_allow');
		    	}

		    	// Если тег содержит класс
		    	if(input.hasClass('account_edit_field_error')) {
		    		input.parent().children('.account_edit_error_note').text(text);
					
					return;
		    	}

		    	input.addClass('account_edit_field_error');
				input.parent().append('<em class="fa fa-times account_edit_field_times"></em>');
				input.parent().append('<span class="account_edit_error_note">' + text + '</span>');

				return;
			}

			// Если поле заполнено корректно
			else {
				new_email = value;
				email_changed = true;

				// Если тег содержит класс
			    if(input.hasClass('account_edit_field_error')) {
			    	input.removeClass('account_edit_field_error');
			    	input.parent().children('.account_edit_field_times, .account_edit_error_note').remove();
			    }

			    input.addClass('account_edit_field_allow');
			}
        });

        this.new_email = new_email;
        this.email_changed = email_changed;
	}



	// Проверка поля "Адрес" (#11)
	addressCheck(value) {
		var input = $('#account_edit_field_4');
		var start_address = this.start_address;
		var new_address = this.new_address;
		var address_changed = this.address_changed;
		// Regex Корректный адрес
		var regex = /\d{6}[\,\s]*[г\.]*\s*[А-Яа-я\-]{2,}[\,\s]*[ул|пер|пр|б-р]*[\.\s]*[А-Яа-я\-]{2,}[\,\s]*[д\.]*\s*\d{1,3}[\\\d{1,3}]*[\,\s\-]*[кв\.]*\s*\d{1,3}\s*/gmi;
	    var valid = value.match(regex);

		// Если значение совпадает с тем, которое было у пользователя перед редактированием
		if(value == start_address) {
			new_address = value;
			address_changed = false;

			// Если тег содержит класс
			if(input.hasClass('account_edit_field_allow')) {
	    		input.removeClass('account_edit_field_allow');
	    	}

	    	// Если тег содержит класс
	    	if(input.hasClass('account_edit_field_error')) {
				input.removeClass('account_edit_field_error');
				input.parent().children('.account_edit_field_times, .account_edit_error_note').remove();
			}

			this.new_address = new_address;
			this.address_changed = address_changed;

			return;
		}

		// Если значение пустое
		if(value == '') {
			new_address = '';
			address_changed = true;

			// Если тег содержит класс
			if(input.hasClass('account_edit_field_allow')) {
	    		input.removeClass('account_edit_field_allow');
	    	}

	    	// Если тег содержит класс
	    	if(input.hasClass('account_edit_field_error')) {
				input.removeClass('account_edit_field_error');
				input.parent().children('.account_edit_field_times, .account_edit_error_note').remove();
			}

			this.new_address = new_address;
			this.address_changed = address_changed;

			return;
		}

		// Если поле заполнено некорректно
	    if(valid == null) {
	    	new_address = 'error';
	    	address_changed = false;
	    	var text = 'Адрес введен некорректно. Шаблон верного заполнения: <br> 101000, г. Москва, ул. Пушкина, д. X, кв. X <br> Где первые 6 символов - почтовый индекс, а "X" - номер дома/квартиры. <br> (Если квартиры нет, указывается только номер дома).';

	    	// Если тег содержит класс
	    	if(input.hasClass('account_edit_field_allow')) {
	    		input.removeClass('account_edit_field_allow');
	    	}

	    	// Если тег содержит класс
	    	if(input.hasClass('account_edit_field_error')) {
	    		input.parent().children('.account_edit_error_note').text(text);

				return;
	    	}

	    	input.addClass('account_edit_field_error');
			input.parent().append('<em class="fa fa-times account_edit_field_times"></em>');
			input.parent().append('<span class="account_edit_error_note">' + text + '</span>');

			this.new_address = new_address;
			this.address_changed = address_changed;

			return;
	    }

	    // Если поле заполнено корректно
	    else {
	    	new_address = value;
	    	address_changed = true;

	    	// Если тег содержит класс
		    if(input.hasClass('account_edit_field_error')) {
		    	input.removeClass('account_edit_field_error');
		    	input.parent().children('.account_edit_field_times, .account_edit_error_note').remove();
		    }

		    input.addClass('account_edit_field_allow');

		    this.address_changed = address_changed;
		    this.new_address = new_address;
	    }
	}



	// Проверка поля "Пароль" (#12)
	passwordCheck(value) {
		var input = $('#account_edit_field_5');
		var new_password = this.new_password;
		var password_changed = this.password_changed;
		// Regex Английские буквы, цифры и указанные символы
		var regex = /^[a-zA-Z0-9!@#$%^&*_]{6,30}$/;
	    var valid = value.match(regex);

		// Если поле пустое
		if(value == '') {
			new_password = '';
			password_changed = false;

			// Если тег содержит класс
			if(input.hasClass('account_edit_field_allow')) {
	    		input.removeClass('account_edit_field_allow');
	    	}

	    	// Если тег содержит класс
	    	if(input.hasClass('account_edit_field_error')) {
				input.removeClass('account_edit_field_error');
				input.parent().children('.account_edit_field_times, .account_edit_error_note').remove();
			}

			this.new_password = new_password;
			this.password_changed = password_changed;

			return;
		}

		// Если поле заполнено некорректно
	    if(valid == null) {
	    	new_password = 'error';
	    	password_changed = false;
	    	var text = 'Пароль не должен содержать пробелы. Разрешенная длина пароля от 6 до 30 символов.';

	    	// Если тег содержит класс
	    	if(input.hasClass('account_edit_field_allow')) {
	    		input.removeClass('account_edit_field_allow');
	    	}

	    	// Если тег содержит класс
	    	if(input.hasClass('account_edit_field_error')) {
	    		input.parent().children('.account_edit_error_note').text(text);
				return;
	    	}

	    	input.addClass('account_edit_field_error');
			input.parent().append('<em class="fa fa-times account_edit_field_times"></em>');
			input.parent().append('<span class="account_edit_error_note">' + text + '</span>');

			this.new_password = new_password;
			this.password_changed = password_changed;

			return;
	    }

	    // Если поле заполнено корректно
	    else {
	    	new_password = value;
	    	password_changed = true;

	    	// Если тег содержит класс
		    if(input.hasClass('account_edit_field_error')) {
		    	input.removeClass('account_edit_field_error');
		    	input.parent().children('.account_edit_field_times, .account_edit_error_note').remove();
		    }

		    input.addClass('account_edit_field_allow');

		    this.new_password = new_password;
		    this.password_changed = password_changed;
	    }
	}



	// Проверка поля "Ваш текущий пароль" (#13)
	realPasswordCheck(value) {
		var input = $('#account_edit_field_6');
		var real_password_state = false;
		// Regex Английские буквы, цифры и указанные символы
		var regex = /^[a-zA-Z0-9!@#$%^&*_]{6,30}$/;
	    var valid = value.match(regex);

	    // Если поле пустое
		if(value == '') {
			// Если тег содержит класс
			if(input.hasClass('account_edit_field_allow')) {
	    		input.removeClass('account_edit_field_allow');
	    	}

			// Если тег содержит класс
	    	if(input.hasClass('account_edit_field_error')) {
				input.removeClass('account_edit_field_error');
				input.parent().children('.account_edit_field_times, .account_edit_error_note').remove();
			}

			this.real_password_state = real_password_state;

			return;
		}

		// Если поле заполнено некорректно
	    if(valid == null) {
	    	var text = 'Пароль введен некорректно.';

	    	// Если тег содержит класс
	    	if(input.hasClass('account_edit_field_allow')) {
	    		input.removeClass('account_edit_field_allow');
	    	}

	    	// Если тег содержит класс
	    	if(input.hasClass('account_edit_field_error')) {
	    		input.parent().children('.account_edit_error_note').text(text);

				return;
	    	}

	    	input.addClass('account_edit_field_error');
			input.parent().append('<em class="fa fa-times account_edit_field_times"></em>');
			input.parent().append('<span class="account_edit_error_note">' + text + '</span>');

			this.real_password_state = real_password_state;

			return;
	    }

	    // Ajax-запрос на проверку пароля пользователя
	    $.ajax({
			async: false,
			url: '/ajax/accountHeader.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'check_real_password', 
				password: value
			}
		})
		.done(function(result) {
			// Если вернулся ответ false
			if(result == 'false') {
				var text = 'Введенный пароль не совпадает с паролем от аккаунта.';

				// Если тег содержит класс
				if(input.hasClass('account_edit_field_allow')) {
		    		input.removeClass('account_edit_field_allow');
		    	}

		    	// Если тег содержит класс
		    	if(input.hasClass('account_edit_field_error')) {
		    		input.parent().children('.account_edit_error_note').text(text);

					return;
		    	}

		    	input.addClass('account_edit_field_error');
				input.parent().append('<em class="fa fa-times account_edit_field_times"></em>');
				input.parent().append('<span class="account_edit_error_note">' + text + '</span>');

				return;
			}

			// Если поле заполнено корректно
			else {
				real_password_state = true;

				// Если тег содержит класс
			    if(input.hasClass('account_edit_field_error')) {
			    	input.removeClass('account_edit_field_error');
			    	input.parent().children('.account_edit_field_times, .account_edit_error_note').remove();
			    }

			    input.addClass('account_edit_field_allow');
			}
        });

        this.real_password_state = real_password_state;
	}



	// Подтверждение изменения данных (#14)
	editConfirm() {
		var new_name = this.new_name;
		var new_login = this.new_login;
		var new_email = this.new_email;
		var new_address = this.new_address;
		var new_password = this.new_password;
		var name_changed = this.name_changed;
		var login_changed = this.login_changed;
		var email_changed = this.email_changed;
		var address_changed = this.address_changed;
		var password_changed = this.password_changed;
		var real_password_state = this.real_password_state;
		var input = $('#account_edit_field_6');

		// Если имеются ошибки
		if(new_name == 'error' || new_login == 'error' || 
			new_email == 'error' || new_address == 'error' || 
			new_password == 'error') 
		{
			return;
		}

		// Если поля не были изменены
		if(name_changed == false && login_changed == false &&
			email_changed == false && address_changed == false &&
			password_changed == false)
		{
			this.hideEditBox();

			return;
		}

		// Если пользователь не ввел текущий пароль
		if(real_password_state == false) {
			var text = 'Необходимо ввести текущий пароль от аккаунта.';

			// Если тег содержит класс
			if(input.hasClass('account_edit_field_allow')) {
	    		input.removeClass('account_edit_field_allow');
	    	}

	    	// Если тег содержит класс
	    	if(input.hasClass('account_edit_field_error')) {
	    		input.parent().children('.account_edit_error_note').text(text);

				return;
	    	}

	    	input.addClass('account_edit_field_error');
			input.parent().append('<em class="fa fa-times account_edit_field_times"></em>');
			input.parent().append('<span class="account_edit_error_note">' + text + '</span>');

			return;
		}

		// Ajax-запрос на загрузку разметки подтверждения изменения данных
		$.ajax({
			async: false,
			url: '/ajax/accountHeader.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'edit_confirm',
				email: new_email
			}
		})
		.done(function(data) {
			// Если ответ содержит указанный текст
			if( data.includes('Вы недавно редактировали профиль') ) {
				other.myAlertShow('error', data, false, 0);

				return;
			}

			$('#user_info_edit_form').html(data);
			$('#account_edit_field_7').focus();
        });
	}



	// Финиш редактирования данных (#15)
	editFinish() {
		var new_name = this.new_name;
		var new_login = this.new_login;
		var new_email = this.new_email;
		var new_address = this.new_address;
		var new_password = this.new_password;
		var value = '';
		var result = '';

		// Если поле для ввода кода было отображено
		if($('#account_edit_field_7').length) {
			var input = $('#account_edit_field_7');
		    value = input.val();

		    // Если поле пустое
			if(value == '') {
				var text = 'Вы не указали код подтверждения.';

				// Если тег содержит класс
				if(input.hasClass('account_edit_field_allow')) {
		    		input.removeClass('account_edit_field_allow');
		    	}

		    	// Если тег содержит класс
				if(input.hasClass('account_edit_field_error')) {
					input.parent().children('.account_edit_error_note').text(text);

					return;
				}

				input.addClass('account_edit_field_error');
				input.parent().append('<em class="fa fa-times account_edit_field_times"></em>');
				input.parent().append('<span class="account_edit_error_note">' + text + '</span>');

				return;
			}

			// Если введенное значение меньше 6 символов
			if(value.length != 6) {
				var text = 'Код подтверждения состоит из 6 символов.';

				// Если тег содержит класс
				if(input.hasClass('account_edit_field_allow')) {
		    		input.removeClass('account_edit_field_allow');
		    	}

		    	// Если тег содержит класс
				if(input.hasClass('account_edit_field_error')) {
					input.parent().children('.account_edit_error_note').text(text);

					return;
				}

				input.addClass('account_edit_field_error');
				input.parent().append('<em class="fa fa-times account_edit_field_times"></em>');
				input.parent().append('<span class="account_edit_error_note">' + text + '</span>');

				return;
			}
		}

		// Ajax-запрос на завершение редактирования
		$.ajax({
			async: false,
			url: '/ajax/accountHeader.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'edit_finish',
				key: value,
				name: new_name,
				login: new_login,
				email: new_email,
				address: new_address,
				password: new_password
			}
		})
		.done(function(data) {
			// Если вернулся ответ error
			if(data == 'error') {
				var text = 'Неверный код подтверждения.';

				// Если тег содержит класс
				if(input.hasClass('account_edit_field_allow')) {
		    		input.removeClass('account_edit_field_allow');
		    	}

		    	// Если тег содержит класс
				if(input.hasClass('account_edit_field_error')) {
					input.parent().children('.account_edit_error_note').text(text);

					return;
				}

				input.addClass('account_edit_field_error');
				input.parent().append('<em class="fa fa-times account_edit_field_times"></em>');
				input.parent().append('<span class="account_edit_error_note">' + text + '</span>');

				return;
			}

			// Если вернулся ответ success
			else 
				result = 'success';
        });

		// Если результат success
        if(result == 'success') {
			// Если новое имя не пустое        	
        	if(new_name != '') 
        		$('#user_name').text(new_name);

			// Если новый логин не пустой
			if(new_login != '') 
				$('#user_login').text(new_login);

			// Если новый email не пустой
			if(new_email != '') 
				$('#user_email').text(new_email);

			$('#user_address').text(new_address);

			this.hideEditBox();

			other.myAlertShow('success', 'Данные аккаунта были обновлены!', false, 0);
        }
	}



	// Очистка полей в окне редактирования (#16)
	editFieldsClear() {
		// Если тег содержит класс
		if( $('.account_edit_field').hasClass('account_edit_field_error') ) {
			$('.account_edit_field').removeClass('account_edit_field_error');
		    $('.account_edit_field').parent().children('.account_edit_field_times, .account_edit_error_note').remove();
		}

		// Если тег содержит класс
		if( $('.account_edit_field').hasClass('account_edit_field_allow') ) {
	    	$('.account_edit_field').removeClass('account_edit_field_allow');
	    }

		$('#account_edit_field_1').val(this.start_name);
		$('#account_edit_field_2').val(this.start_login);
		$('#account_edit_field_3').val(this.start_email);
		$('#account_edit_field_4').val(this.start_address);
		$('#account_edit_field_5').val('');
		$('#account_edit_field_6').val('');

		this.new_name = '';
		this.new_login = '';
		this.new_email = '';
		this.new_address = '';
		this.new_password = '';
		this.name_changed = false;
		this.login_changed = false;
		this.email_changed = false;
		this.address_changed = false;
		this.real_password_state = false;

		$('#account_edit_field_1').focus();
	}



	// Событие при наведении на аватар пользователя в окне данных об аккаунте (#17)
	userAvatarMouseDown() {
		$('#account_avatar_edit_icon').css({opacity : '100%', backgroundColor: 'rgba(0,0,0,0.5)'});
	}



	// Событие при уходе мыши с аватара пользователя в окне данных об аккаунте (#18)
	userAvatarMouseOut() {
		$('#account_avatar_edit_icon').css({opacity : '0', backgroundColor: 'rgba(0,0,0,0)'});
	}


	
}



// Создание нового экземпляра класса
var account = new AccountHeader();

// Обработка событий
$('#user_info_edit_form').on('submit', function(e) {
	e.preventDefault();
});