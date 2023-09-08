// Класс "Покупки в Header" (#class)
class PurchasesHeader {



	purchases_state = false; // Состояние подгрузки товаров

	

	// Вывести товары в доставках пользователя (#1)
	selectItems() {
		var purchases_state = this.purchases_state;

		var fingerprint = other.getUserFingerprint();

		// Если товары уже были загружены
		if(purchases_state == true) {
			$('#search_results').hide();
			$('#user_info_box').hide();

			$('#purchases_box').show();
			$('#purchases_box').css({opacity: '100%'});
			$('.purchases_box').animate({opacity: '100%'}, 300);

			$('html, body').css({
				overflow: 'hidden', 
				height: '100%'
			});

			return;
		}

		// Если товары еще не были загружены
		if(purchases_state == false) {
			// Ajax-запрос на выборку товаров
			$.ajax({
				async: false,
				url: '/ajax/purchasesHeader.php',
				type: 'POST',
				dataType: 'html',
				data: {action: 'selectItems', fp: fingerprint}
			})
			.done(function(data) {
				$('.purchases_box').append(data);
				purchases_state = true;
	        })
	        .always(function() {
			    setTimeout(function() {
			    	$('#search_results').hide();
					$('#user_info_box').hide();

					$('#purchases_box').show();
					$('#purchases_box').css({opacity: '100%'});
					$('.purchases_box').animate({opacity: '100%'}, 300);

					$('html, body').css({
						overflow: 'hidden', 
						height: '100%'
					});
			    }, 300);
			});	

			this.purchases_state = true;
		}
	}



	// Скрыть контейнер при клике (#2)
	hideBoxOnClick() {
		$('#user_info_box').show();

		$('.purchases_box').animate({opacity: '0'}, 300);
		$('#purchases_box').animate({opacity: '0'}, 300);

		$('html, body').css({
			overflow: 'auto', 
			height: 'auto'
		});

		setTimeout(function(){ 
			$('#purchases_box').hide(); 
		}, 300);
	}



	// Скрыть контейнер при нажатии Escape (#3)
	hideBoxOnEscape() {
		$('.purchases_box').animate({opacity: '0'}, 300);
		$('#purchases_box').animate({opacity: '0'}, 300);

		$('html, body').css({
			overflow: 'auto', 
			height: 'auto'
		});

		setTimeout(function(){ 
			$('#purchases_box').hide(); 
		}, 300);
	}



}



// Создание нового экземпляра класса
var purchases = new PurchasesHeader();