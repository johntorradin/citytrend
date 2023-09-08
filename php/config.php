<?php
	//Класс "Конфигурация" (#class)
	class Config {



		public $header_news 			= 'Цены пополам! Только до 10 апреля!'; // Текст новостей в Header
		public $site_url 				= ''; // Адрес сайта
		public $mysql_host 				= ''; // Хост mysql
		public $mysql_user 				= ''; // Пользователь mysql
		public $mysql_pass 				= ''; // Пароль mysql
		public $mysql_db 				= ''; // База данных mysql
		public $gr_sitekey 				= ''; // Ключ g-recaptcha для html
		public $gr_secret  				= ''; // Секретный ключ g-recaptcha
		public $salt_1 					= ''; // Код №1 для создания токена
		public $salt_2 					= ''; // Код №2 для создания токена
		public $telephone 				= ''; // Телефон сайта
		public $email 					= ''; // Email сайта
		public $forward_email 			= ''; // Email, с которого будут отправлятся письма пользователям
		public $forward_email_pass 		= ''; // Пароль !!!доступа приложений!!! от Email, с которого будут отправлятся письма пользователям
		public $yookassa_shop_id		= ''; // Идентификатор магазина ЮКасса
		public $yookassa_secret_key		= ''; // Секретный ключ ЮКасса
		public $ap_user					= 'admin'; // Логин для входа в панель администратора
		public $youtube_soc 			= 'https://www.youtube.com'; // YouTube
		public $instagram_soc 			= 'http://instagram.com'; // Instagram
		public $vkontakte_soc 			= 'https://vk.com'; // VKontakte
		public $telegram_soc 			= 'https://web.telegram.org'; // Telegram
		public $enter_limit_time 		= 10; // Лимит времени между попытками авторизации аккаунта (минут)
		public $reg_limit_time 			= 5; // Лимит времени для регистрации нового аккаунта (минут)
		public $edit_limit_time 		= 5; // Лимит времени для изменения данных аккаунта аккаунта (минут)
		public $reg_key_limit_time 		= 5; // Лимит времени создания нового кода восстановления акка (минут)
		public $repair_key_limit_time 	= 5; // Лимит времени создания нового кода для регистрации акка (минут)
		public $edit_key_limit_time 	= 5; // Лимит времени создания нового кода для изменения почты акка (минут)
		public $add_avatars_limit_time 	= 5; // Лимит времени на смену файла аватарки пользователя
		public $add_reviews_limit_time 	= 5; // Лимит времени на добавление нового отзыва
		public $allow_file_size 		= 1; // Максимальный размер файла аватарки пользователя в мегабайтах
		public $top_catalog_items_count = 8; // Кол-во карточек товара на главной (Топ каталога)
		public $discounted_items_count 	= 8; // Кол-во карточек товара на главной (Топовые скидки)
		public $new_items_count 		= 8; // Кол-во карточек товара на главной (Новинки каталога)
		public $other_items_count 		= 8; // Кол-во карточек товара на главной (Возможно Вам понравится)
		public $watched_items_count 	= 8; // Кол-во карточек товара на главной (Вы смотрели)
		public $similar_items_count		= 8; // Кол-во карточек товара (Похожие вещи)
		public $sort_items_count 		= 50; // Кол-во карточек товара на странице сортировок
		public $reviews_count 			= 5; // Кол-во отзывов на странице с товаром


		
	}
?>
