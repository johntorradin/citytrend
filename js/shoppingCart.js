// Класс "Корзина" (#class)
class ShoppingCart {



	// Вывести товары в корзине пользователя (#1)
	selectItems() {
		var fingerprint = other.getUserFingerprint();

		// Ajax-запрос на выборку товаров
		$.ajax({
			async: false,
			url: '/ajax/shoppingCart.php',
			type: 'POST',
			dataType: 'html',
			data: {action: 'selectItems', fp: fingerprint}
		})
		.done(function(data) {
			$('#shopping_cart_form').html('<button onclick="shopcart.hideBoxOnClick()" id="shopping_cart_box_close" class="box_close"><em class="fa fa-times"></em></button>' + data);

			var items_count = parseInt( $('.shopping_cart_item_box_allow').length );
			var sum = 0;

			for(var i = 0; i < items_count; i++) {
				sum += 
				parseInt( $('.shopping_cart_item_box_allow:eq(' + i + ')').find('.cart_item_price').text() ) * 
				parseInt( $('.shopping_cart_item_box_allow:eq(' + i + ')').find('#shopcart_item_count').text());
			}

			$('#cart_price_sum').html(sum + ' <em class="fa fa-rub"></em>');
        })
        .always(function() {
		    setTimeout(function() {
		    	$('#search_results').hide();

				$('#shopping_cart_box').show();
				$('#shopping_cart_box').css({opacity: '100%'});
				$('.shopping_cart_box').animate({opacity: '100%'}, 300);

				$('html, body').css({
					overflow: 'hidden', 
					height: '100%'
				});
		    }, 300);
		});
	}



	// Вывести кол-во вещей в корзине (#2)
	selectCount() {
		var fingerprint = other.getUserFingerprint();

		// Ajax-запрос на получение кол-ва вещей
		$.ajax({
			async: false,
			url: '/ajax/shoppingCart.php',
			type: 'POST',
			dataType: 'html',
			data: {action: 'selectCount', fp: fingerprint}
		})
		.done(function(data) {
			$('#shopping_cart_open_btn').children().html('<div class="row no-gutters align-items-center"><em class="fa fa-shopping-cart header_right_nav_icon"></em>Корзина' + data + '</div>');
        });
	}



	// Скрыть корзину при клике (#3)
	hideBoxOnClick() {
		$('.shopping_cart_box').animate({opacity: '0'}, 300);
		$('#shopping_cart_box').animate({opacity: '0'}, 300);

		$('html, body').css({
			overflow: 'auto', 
			height: 'auto'
		});

		setTimeout(function(){ 
			$('#shopping_cart_box').hide(); 
		}, 300);
	}



	// Скрыть корзину при нажатии Escape (#4)
	hideBoxOnEscape() {
		$('.shopping_cart_box').animate({opacity: '0'}, 300);
		$('#shopping_cart_box').animate({opacity: '0'}, 300);

		$('html, body').css({
			overflow: 'auto', 
			height: 'auto'
		});

		setTimeout(function(){ 
			$('#shopping_cart_box').hide(); 
		}, 300);
	}



	// Клик по кнопке-чекбоксу на товаре (#5)
	checkItem(btn) {
		// Если кнопка уже имеет класс "активно"
		if(btn.hasClass('item_check_checked')) {
			btn.removeClass('item_check_checked');
			btn.html('');
		}

		// Если кнопка не имеет класса "активно"
		else {
			btn.addClass('item_check_checked');
			btn.html('<em class="fa fa-check"></em>');
		}

		var count = $('.item_check_checked').length;
		$('#shopcart_checked_count').text(count);
	}



	// Клик по кнопке удаления товара (#6)
	deleteItem(btn) {
		var fingerprint = other.getUserFingerprint();
		var artikul = btn.parent('.shopping_cart_item_box').find('#shopcart_item_artikul').text();
		var size = btn.parent('.shopping_cart_item_box').find('#shopcart_item_size').text();
		var color = btn.parent('.shopping_cart_item_box').find('#shopcart_item_color').text();

		other.myAlertShow('error', 'Удалить товар из корзины?', true, 0);

		// Если пользователь нажал на кнопку подтверждения удаления
		$('#my_alert_confirm').click(function() {
			// Ajax-запрос на удаление товара из корзины
			$.ajax({
				async: false,
				url: '/ajax/shoppingCart.php',
				type: 'POST',
				dataType: 'html',
				data: {
					action: 'deleteItem', 
					fp: fingerprint,
					artikul: artikul,
					color: color,
					size: size
				}
			})
			.done(function(data) {
				btn.parent('.shopping_cart_item_box').remove();

				shopcart.selectCount();

				var count = $('.item_check').length;
				$('#cart_items_count').text(count);

				var active_count = $('.item_check_checked').length;
				$('#shopcart_checked_count').text(active_count);

				var items_count = parseInt( $('.shopping_cart_item_box_allow').length );
				var sum = 0;

				for(var i = 0; i < items_count; i++) {
					sum += 
					parseInt( $('.shopping_cart_item_box_allow:eq(' + i + ')').find('.cart_item_price').text() ) * 
					parseInt( $('.shopping_cart_item_box_allow:eq(' + i + ')').find('#shopcart_item_count').text());
				}

				$('#cart_price_sum').html(sum + ' <em class="fa fa-rub"></em>');

				// Если товаров не осталось после удаления
				if(items_count == 0) {
					shopcart.hideBoxOnClick();
				}
	        });
		});
	}



	// Клик по кнопке "Купить" (#7)
	buyItem(btn) {
		var id = btn.parent('.shopping_cart_item_box_allow').attr('data-id');
		var site_url = '';
		var size = btn.parent('.shopping_cart_item_box').find('#shopcart_item_size').text();
		var color = btn.parent('.shopping_cart_item_box').find('#shopcart_item_color').text();
		var count = btn.parent().find('#shopcart_item_count').text();
		var price = btn.parent().find('.cart_item_price').text();
		var rgb = btn.parent().find('.purchases_item_color').css('background-color');
		var hex = other.rgbToHex(rgb);
		var name = btn.parent().find('.shopping_cart_item_link').text();
		var artikul = btn.parent().find('#shopcart_item_artikul').text();

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

        var purchase = id + ',' + artikul + ',' + name + ',' + color + ',' + hex + ',' + size + ',' + count + ',' + price;

        // Ajax-запрос на создание строки покупки
		$.ajax({
			async: false,
			url: '/ajax/purchaseReg.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'set_purchase',
				purchase: purchase
			}
		})
		.done(function(data) {
			other.goToPage(site_url + 'purchase');
        });
	}



	// Клик по кнопке "Купить выбранное" (#8)
	buySelectedItems() {
		var count = $('#shopcart_checked_count').text();

		// Если товары не выбраны
		if(count == 0) {
			other.myAlertShow('error', 'Товары не выбраны.', false, 0);

			return;
		}

		var purchase = '';

		$('.item_check_checked').each(function(index, element) {
			var id = $(element).parent().attr('data-id');
			var size = $(element).parent().find('#shopcart_item_size').text();
			var color = $(element).parent().find('#shopcart_item_color').text();
			var count = $(element).parent().find('#shopcart_item_count').text();
			var price = $(element).parent().find('.cart_item_price').text();
			var rgb = $(element).parent().find('.purchases_item_color').css('background-color');
			var hex = other.rgbToHex(rgb);
			var name = $(element).parent().find('.shopping_cart_item_link').text();
			var artikul = $(element).parent().find('#shopcart_item_artikul').text();
			
			purchase += id + ',' + artikul + ',' + name + ',' + color + ',' + hex + ',' + size + ',' + count + ',' + price + ',|';
		});

		// Если строка содержит символ-разделитель
		if(purchase.includes('|')) {
			purchase = purchase.slice(0,-2);
		}

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

        // Ajax-запрос на создание строки покупки
		$.ajax({
			async: false,
			url: '/ajax/purchaseReg.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'set_purchase',
				purchase: purchase
			}
		})
		.done(function(data) {
			other.goToPage(site_url + 'purchase');
        });
	}



	// Клик по кнопке "Купить всё" (#9)
	buyAllItems() {
		var purchase = '';

		$('.item_check').each(function(index, element) {
			var id = $(element).parent().attr('data-id');
			var size = $(element).parent().find('#shopcart_item_size').text();
			var color = $(element).parent().find('#shopcart_item_color').text();
			var count = $(element).parent().find('#shopcart_item_count').text();
			var price = $(element).parent().find('.cart_item_price').text();
			var rgb = $(element).parent().find('.purchases_item_color').css('background-color');
			var hex = other.rgbToHex(rgb);
			var name = $(element).parent().find('.shopping_cart_item_link').text();
			var artikul = $(element).parent().find('#shopcart_item_artikul').text();
			
			purchase += id + ',' + artikul + ',' + name + ',' + color + ',' + hex + ',' + size + ',' + count + ',' + price + ',|';
		});

		// Если строка содержит символ-разделитель
		if(purchase.includes('|')) {
			purchase = purchase.slice(0,-2);
		}

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

        // Ajax-запрос на создание строки покупки
		$.ajax({
			async: false,
			url: '/ajax/purchaseReg.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'set_purchase',
				purchase: purchase
			}
		})
		.done(function(data) {
			other.goToPage(site_url + 'purchase');
        });
	}



	// Клик по кнопке уменьшения кол-ва товара (#10)
	itemCountMinus(btn) {
		var fingerprint = other.getUserFingerprint();
		var artikul = btn.parents('.shopping_cart_item_box').find('#shopcart_item_artikul').text();
		var size = btn.parents('.shopping_cart_item_box').find('#shopcart_item_size').text();
		var color = btn.parents('.shopping_cart_item_box').find('#shopcart_item_color').text();
		var count = btn.parents('.shopping_cart_item_box').find('#shopcart_item_count').text();
		
		// Если кол-во единиц товара меньше 2
		if(count < 2)
			return;

		// Ajax-запрос на уменьшение единиц товара
		$.ajax({
			async: false,
			url: '/ajax/shoppingCart.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'item_minus',
				fp: fingerprint,
				artikul: artikul,
				size: size,
				color: color
			}
		})
		.done(function(data) {
			count--;

			btn.parents('.shopping_cart_item_box').find('#shopcart_item_count').text(count);

			var items_count = parseInt( $('.shopping_cart_item_box_allow').length );
			var sum = 0;

			for(var i = 0; i < items_count; i++) {
				sum += 
				parseInt( $('.shopping_cart_item_box_allow:eq(' + i + ')').find('.cart_item_price').text() ) * 
				parseInt( $('.shopping_cart_item_box_allow:eq(' + i + ')').find('#shopcart_item_count').text());
			}

			$('#cart_price_sum').html(sum + ' <em class="fa fa-rub"></em>');
        });
	}



	// Клик по кнопке увеличения кол-ва товара (#11)
	itemCountPlus(btn) {
		var fingerprint = other.getUserFingerprint();
		var artikul = btn.parents('.shopping_cart_item_box').find('#shopcart_item_artikul').text();
		var size = btn.parents('.shopping_cart_item_box').find('#shopcart_item_size').text();
		var color = btn.parents('.shopping_cart_item_box').find('#shopcart_item_color').text();
		var count = btn.parents('.shopping_cart_item_box').find('#shopcart_item_count').text();

		// Ajax-запрос на увеличение единиц товара
		$.ajax({
			async: false,
			url: '/ajax/shoppingCart.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'item_plus',
				fp: fingerprint,
				artikul: artikul,
				size: size,
				color: color
			}
		})
		.done(function(data) {
			// Если вернулся успешный ответ
			if(data == 'Успех') {
				count++;

				btn.parents('.shopping_cart_item_box').find('#shopcart_item_count').text(count);

				var items_count = parseInt( $('.shopping_cart_item_box_allow').length );
				var sum = 0;

				for(var i = 0; i < items_count; i++) {
					sum += 
					parseInt( $('.shopping_cart_item_box_allow:eq(' + i + ')').find('.cart_item_price').text() ) * 
					parseInt( $('.shopping_cart_item_box_allow:eq(' + i + ')').find('#shopcart_item_count').text());
				}

				$('#cart_price_sum').html(sum + ' <em class="fa fa-rub"></em>');
			}

			// Если вернулась ошибка
			else {
				other.myAlertShow('error', data, false, 0);
			}
        });
	}



}



// Создание нового экземпляра класса
var shopcart = new ShoppingCart();

// Обработка событий
$('#shopping_cart_form').on('submit', function(e) {
	e.preventDefault();
});