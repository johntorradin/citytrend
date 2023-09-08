// Класс "Доставки" (#class)
class Delivery {



	deliverys_state = false; // Состояние подгрузки товаров

	

	// Вывести товары в доставках пользователя (#1)
	selectItems() {
		var deliverys_state = this.deliverys_state;

		var fingerprint = other.getUserFingerprint();

		// Если товары уже были загружены
		if(deliverys_state == true) {
			$('#search_results').hide();
			$('#user_info_box').hide();

			$('#delivery_box').show();
			$('#delivery_box').css({opacity: '100%'});
			$('.delivery_box').animate({opacity: '100%'}, 300);

			$('html, body').css({
				overflow: 'hidden', 
				height: '100%'
			});

			return;
		}

		// Если товары еще не были загружены
		if(deliverys_state == false) {
			// Ajax-запрос на выборку товаров
			$.ajax({
				async: false,
				url: '/ajax/delivery.php',
				type: 'POST',
				dataType: 'html',
				data: {action: 'selectItems', fp: fingerprint}
			})
			.done(function(data) {
				$('.delivery_box').append(data);
				deliverys_state = true;
	        })
	        .always(function() {
			    setTimeout(function() {
			    	$('#search_results').hide();
					$('#user_info_box').hide();

					$('#delivery_box').show();
					$('#delivery_box').css({opacity: '100%'});
					$('.delivery_box').animate({opacity: '100%'}, 300);

					$('html, body').css({
						overflow: 'hidden', 
						height: '100%'
					});
			    }, 300);
			});	

			this.deliverys_state = true;
		}
	}



	// Скрыть контейнер при клике (#2)
	hideBoxOnClick() {
		$('#user_info_box').show();
			
		$('.delivery_box').animate({opacity: '0'}, 300);
		$('#delivery_box').animate({opacity: '0'}, 300);

		$('html, body').css({
			overflow: 'auto', 
			height: 'auto'
		});

		setTimeout(function(){ 
			$('#delivery_box').hide(); 
		}, 300);
	}



	// Скрыть контейнер при нажатии Escape (#3)
	hideBoxOnEscape() {
		$('.delivery_box').animate({opacity: '0'}, 300);
		$('#delivery_box').animate({opacity: '0'}, 300);

		$('html, body').css({
			overflow: 'auto', 
			height: 'auto'
		});

		setTimeout(function(){ 
			$('#delivery_box').hide(); 
		}, 300);
	}


	
}



// Создание нового экземпляра класса
var delivery = new Delivery();