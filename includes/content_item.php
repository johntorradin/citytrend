<div class="content_item">
	<img class="content_item_back" src="../media/images/static/white_back.jpg">

	<!-- Увеличенное фото товара -->
	<div class="row no-gutters align-items-center big_item_photo_box">
		<div onclick="item.bigImgBoxCloseOnClick()" id="big_item_popup" class="big_item_popup"></div>
		<div class="big_item_image_container">
			<div class="bit_item_image_box">
				<img id="big_item_image" src="" class="big_item_image">
			</div>
			<button onclick="item.bigImgBoxCloseOnClick()" id="big_item_image_exit" class="big_item_image_exit"><em class="fa fa-times"></em></button>
		</div>
	</div>

	<!-- Главный контейнер -->
	<div class="row no-gutters item_content_main">
		<!-- Content -->
		<div class="col-12 col-xl-9 item_content_wrapper">
			<div id="start_item_info">
				<!-- Данные выводятся через ajax -->
			</div>
			<!-- Карточка товара -->
			<div class="row no-gutters item_card">
				<div class="col-12 col-lg-4">
					<!-- Слайдер "Изображения товара" -->
					<div id="item_images_slider" class="row no-gutters slider item_images_slider">
						<!-- Данные выводятся через ajax -->
					</div>
				</div>
				<!-- Материал, цвет, доп. инфа, описание -->
				<div class="col-12 col-lg-4">
					<div id="color_and_sizes" class="item_characters_box">
						<div class="item_characters_colors">
							<div id="item_colors" class="row no-gutters align-items-center item_color">
								<span class="item_color_title">Цвет:</span> 
								<!-- Данные выводятся через ajax -->
							</div>
						</div>
						<!-- Размеры -->
						<div class="item_characters_sizes">
							<!-- Начальная html-разметка -->
							<span class="item_size_title">Размер:</span>
							<span class="item_size_start_text">Для выбора размера укажите цвет.</span>
							<div id="item_characters_sizes">
								
							</div>
						</div>
						<div id="characters_and_description">
							<!-- Данные выводятся через ajax -->
						</div>
					</div>
				</div>
				<!-- Цена -->
				<div class="col-12 col-lg-4">
					<div id="item_price_box" class="item_price_box">
						<!-- Данные выводятся через ajax -->
					</div>
				</div>
			</div>
			<!-- Контейнер с отзывами -->
			<div id="item_reviews" class="row no-gutters item_reviews">
				<div class="col-12">
					<div class="row no-gutters item_reviews_title">
						<h1 class="item_reviews_title_h1">Отзывы о товаре</h1>
					</div>
					<form action="#" id="item_reviews_sort_form">
						<!-- Данные выводятся через ajax -->
					</form>
				</div>
				<!-- Данные выводятся через ajax -->
			</div>
			<!-- Слайдер "Вы смотрели" -->
			<div id="watched_items_slider" class="row no-gutters slider page_item_watched_items_slider">
				<!-- Данные выводятся через ajax -->
			</div>
		</div>
		<!-- Right Sidebar -->
		<div class="col-12 col-xl-3 item_content_right_sidebar">
			<!-- Блок "Похожие вещи" -->
			<div class="row no-gutters item_content_similar_items_box">
				<!-- Данные выводятся через ajax -->
			</div>
		</div>
	</div>
</div>
</div>