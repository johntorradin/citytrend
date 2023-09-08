// Класс "Панель администратора" (#class)
class AdminPanel {
	


	// Вывести отзывы (#1)
	selectReviews() {
		// Ajax-запрос на загрузку отзывов
		$.ajax({
			async: false,
			url: '/ajax/adminPanel.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'select_reviews'
			}
		})
		.done(function(data) {
			$('.ap_textarea').html(data);
        });
	}



	// Вывести доставки (#2)
	selectDeliverys() {
		// Ajax-запрос на загрузку доставок
		$.ajax({
			async: false,
			url: '/ajax/adminPanel.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'select_deliverys'
			}
		})
		.done(function(data) {
			$('.ap_textarea').html(data);
        });
	}



	// Вывести покупки (#3)
	selectPurchases() {
		// Ajax-запрос на загрузку покупок
		$.ajax({
			async: false,
			url: '/ajax/adminPanel.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'select_purchases'
			}
		})
		.done(function(data) {
			$('.ap_textarea').html(data);
        });
	}



	// Разрешить отзыв (#4)
	allowReview() {
		var id = $('#review_id').val();

		// Ajax-запрос на разрешение отзыва
		$.ajax({
			async: false,
			url: '/ajax/adminPanel.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'allow_review',
				id : id
			}
		});

		this.selectReviews();
	}



	// Подтверждение получения товара (#5)
	setPurchase() {
		var id = $('#delivery_id').val();

		// Ajax-запрос на подтверждение получения товара
		$.ajax({
			async: false,
			url: '/ajax/adminPanel.php',
			type: 'POST',
			dataType: 'html',
			data: {
				action: 'set_purchase',
				id : id
			}
		});

		this.selectDeliverys();
	}



}



// Создание нового экземпляра класса
var panel = new AdminPanel();

$('#ap_form').on('submit', function(e) {
	e.preventDefault();
});