// Класс "Совершение покупки" (#class)
class PurchaseReg {



	address_check = false; // Переменная проверки поля "адрес"
	step_2_state = false; // Состояние загрузки шага №2
	step_3_state = false; // Состояние загрузки шага №3
	sum = 0; // Общая сумма покупки
	address = ''; // Адрес доставки



	// Загрузка шага №1 (#1)
	step_1() {
		var sum = 0;

		// Ajax-запрос на загрузку шага №1
		$.ajax({
			async: false,
			url: '/ajax/purchaseReg.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'step_1'
			}
		})
		.done(function(data) {
			$('#purchase_step_1').append(data);

			var items_count = parseInt( $('#items_count').text() );

			for(var i = 0; i < items_count; i++) {
				sum += 
				parseInt( $('.item_price:eq(' + i + ')').text() ) * 
				parseInt( $('.item_price:eq(' + i + ')').parents('.purchase_item').find('.purchase_item_count').text());
			}

			$('#all_sum').html(sum + ' <em class="fa fa-rub"></em>');
        });

        this.sum = sum;
	}



	// Загрузка шага №2 (#2)
	step_2() {
		$('#purchase_step_1').hide();
		$('#purchase_step_1').css({opacity: '0'});

		// Если шаг №2 уже был загружен
		if(this.step_2_state == true) {
			$('#purchase_step_2').show();
			$('#purchase_step_2').animate({opacity: '100%'}, 100);

			return;
		}

		// Ajax-запрос на загрузку шага №2
		$.ajax({
			async: false,
			url: '/ajax/purchaseReg.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'step_2'
			}
		})
		.done(function(data) {
			$('#purchase_step_2').append(data);
        })
        .always(function() {
		    setTimeout(function(){
		    	$('#purchase_step_2').show();
				$('#purchase_step_2').animate({opacity: '100%'}, 100);
		    }, 100);
		});

		var address = $('#purchase_field_1').val();

		this.addressCheck(address);
		this.step_2_state = true;
	}



	// Проверка поля "адрес" (#3)
	addressCheck(value) {
		var input = $('#purchase_field_1');
		var em = $('.purchase_field_times');
		var span = $('.purchase_field_error_note');
		// Regex Корректный адрес
		var regex = /\d{6}[\,\s]*[г\.]*\s*[А-Яа-я\-]{2,}[\,\s]*[ул|пер|пр|б-р]*[\.\s]*[А-Яа-я\-]{2,}[\,\s]*[д\.]*\s*\d{1,3}[\\\d{1,3}]*[\,\s\-]*[кв\.]*\s*\d{1,3}\s*/gmi;
	    var valid = value.match(regex);

	    // Если значение пустое
		if(value == '') {
			// Если тег содержит класс
			if(input.hasClass('purchase_field_allow')) {
	    		input.removeClass('purchase_field_allow');
	    	}

	    	// Если тег не содержит класс
	    	if(!input.hasClass('purchase_field_error')) {
				input.addClass('purchase_field_error');
			}

			em.show();
			span.text('Вы не ввели адрес доставки.');

			this.address_check = false;

			return;
		}

		// Если поле заполнено некорректно
	    if(valid == null) {
	    	// Если тег содержит класс
			if(input.hasClass('purchase_field_allow')) {
	    		input.removeClass('purchase_field_allow');
	    	}

	    	// Если тег не содержит класс
	    	if(!input.hasClass('purchase_field_error')) {
				input.addClass('purchase_field_error');
			}

			em.show();
			span.html('Адрес введен некорректно. Шаблон верного заполнения: <br> 101000, г. Москва, ул. Пушкина, д. X, кв. X <br> Где первые 6 символов - почтовый индекс, а "X" - номер дома/квартиры. <br> (Если квартиры нет, указывается только номер дома).');

			this.address_check = false;

			return;
	    }

	    // Если поле заполнено корректно
	    else {
	    	// Если тег содержит класс
			if(input.hasClass('purchase_field_error')) {
	    		input.removeClass('purchase_field_error');
	    	}

	    	// Если тег не содержит класс
	    	if(!input.hasClass('purchase_field_allow')) {
				input.addClass('purchase_field_allow');
			}

			em.hide();
			span.text('');

			this.address_check = true;
			this.address = value;
	    }
	}



	// Клик по кнопке "Очистить" (#4)
	addressClear() {
		$('#purchase_field_1').val('');

		this.addressCheck('');

		$('#purchase_field_1').focus();
	}



	// Загрузка шага №3 (#5)
	step_3() {
		// Если адрес не прошел проверку
		if(this.address_check == false) {
			other.myAlertShow('error', 'Адрес введен некорректно.', false, 0);

			return;
		}

		$('#purchase_step_2').hide();
		$('#purchase_step_2').css({opacity: '0'});

		// Если шаг №3 уже был загружен
		if(this.step_3_state == true) {
			$('#purchase_step_3').show();
			$('#purchase_step_3').animate({opacity: '100%'}, 100);

			return;
		}

		// Ajax-запрос на загрузку шага №3
		$.ajax({
			async: false,
			url: '/ajax/purchaseReg.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'step_3'
			}
		})
		.done(function(data) {
			$('#purchase_step_3').append(data);
        })
        .always(function() {
		    setTimeout(function(){
		    	$('#purchase_step_3').show();
				$('#purchase_step_3').animate({opacity: '100%'}, 100);
		    }, 100);
		});

		this.step_3_state = true;
	}



	// Покупка - возврат к шагу №2 (#6)
	backToStep2() {
		$('#purchase_step_3').hide();
		$('#purchase_step_3').css({opacity: '0'});

		$('#purchase_step_2').show();
		$('#purchase_step_2').animate({opacity: '100%'}, 100);
	}



	// Покупка - возврат к шагу №1 (#7)
	backToStep1() {
		$('#purchase_step_2').hide();
		$('#purchase_step_2').css({opacity: '0'});

		$('#purchase_step_1').show();
		$('#purchase_step_1').animate({opacity: '100%'}, 100);
	}



	// Занесение в сессию данных для ЮКасса (#8)
	finish() {
		var sum = this.sum;
		var address = this.address;
		var fingerprint = other.getUserFingerprint();

		// Ajax-запрос на занесение в сессию данных для ЮКасса
		$.ajax({
			async: false,
			url: '/ajax/purchaseReg.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'finish',
				sum : sum,
				address : address,
				fp : fingerprint
			}
		})
		.done(function(data) {
			window.location.reload();
        });
	}


	
}



// Создание нового экземпляра класса
var purchase = new PurchaseReg();

$('#purchase_box_form').on('submit', function(e) {
	e.preventDefault();
});