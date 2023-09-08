// Класс "Слайдер" (#class)
class Slider {



	slides_box_id 		 = ''; // ID бокса со слайдами
	slides_count 		 = 0; // Кол-во слайдов
	slide_width 		 = 0; // Ширина одного слайда
	slides_box_width 	 = 0; // Ширина бокса со слайдами
	visible_slides_count = 0; // Кол-во одновременно "видимых" слайдов
	moving_count 		 = 1; // Кол-во прокруток слайдера
	max_moving_count 	 = 0; // Максимальное кол-во прокруток слайдера
	pos 				 = 0; // Текущая позиция слайдера
	coord_x_start 		 = 0; // Начальная позиция x
	coord_x_end 		 = 0; // Конечная позиция x



	// Конструктор класса (#1)
	constructor(slides_box_id, slides_count, slide_width, slides_box_width) {
	    this.slides_box_id = '#' + slides_box_id;
	    this.slides_count = parseFloat(slides_count);
	    this.slide_width = parseFloat(slide_width);
	    this.slides_box_width = parseFloat(slides_box_width);

	    // Высчитываем кол-во одновременно "видимых" слайдов = изначальная ширина бокса со слайдами / ширину одного слайда
	    this.visible_slides_count = Math.round(this.slides_box_width / this.slide_width);

	    // Пересчитываем ширину бокса со слайдами в зависимости от кол-ва слайдов = ширина одного слайда * кол-во слайдов
	    this.slides_box_width = Math.ceil(this.slide_width * this.slides_count);
	    
	    // Высчитываем максимально разрешенное кол-во прокруток слайдера = ширина бокса со слайдами / ширину одного слайда - кол-во "видимых" слайдов (общее кол-во слайдов должно быть больше, чем кол-во "видимых" слайдов как минимум в 2 раза!)
			this.max_moving_count = Math.ceil(this.slides_box_width / this.slide_width - this.visible_slides_count);
	}



	// Проверка, нужно ли активировать слайдер (#2)
	slidesCountCheck() {
		// Если кол-во слайдов больше кол-ва видимых слайдов
		if(this.slides_count > this.visible_slides_count) 
			return true;

		// Если слайдов недостаточно
		else 
			return false;
	}



	// Установить новую ширину бокса со слайдами (#3)
	setWidth() {
	    $(this.slides_box_id).css({'width' : this.slides_box_width});

	    // Установить ширину слайда фиксированной, вместо резиновой
	    $(this.slides_box_id).children('.slide').css({'width' : this.slide_width});
	}



	// Установить кол-во активных индикаторов (#4)
	setDots() {
		for(var i = 1; i <= this.visible_slides_count; i++ ) 
		{
			var active_dot = $(this.slides_box_id).parents('.slider').find('.slider_dot[data-num="' + i + '"]');

			active_dot.addClass('slider_active_dot');
		}
	}



	// Прокрутить слайдер вперед (#5)
	sliderNext() {
		// Если счетчик прокруток меньше максимального счетчика прокруток
		if(this.moving_count < this.max_moving_count) {
			this.pos = -(this.slide_width * this.moving_count);
		    $(this.slides_box_id).animate({'margin-left': this.pos + 'px'}, 400);

		    this.moving_count++;

		    $(this.slides_box_id).parents('.slider').find('.slider_dot').removeClass('slider_active_dot');

		    for(var i = this.moving_count; i <= this.moving_count + this.visible_slides_count - 1; i++ ) 
			{
				var active_dot = $(this.slides_box_id).parents('.slider').find('.slider_dot[data-num="' + i + '"]');

				active_dot.addClass('slider_active_dot');
			}

		    return;
		}

		// Если счетчик прокруток равен максимальному счетчику прокруток
		if(this.moving_count == this.max_moving_count) {
			this.pos = 0;

		    $(this.slides_box_id).animate({'margin-left': this.pos + 'px'}, 200);

		    this.moving_count = 1;

		    $(this.slides_box_id).parents('.slider').find('.slider_dot').removeClass('slider_active_dot');

		    for(var i = this.moving_count; i <= this.moving_count + this.visible_slides_count - 1; i++ ) 
			{
				var active_dot = $(this.slides_box_id).parents('.slider').find('.slider_dot[data-num="' + i + '"]');

				active_dot.addClass('slider_active_dot');
			}
		}
	}



	// Прокрутить слайдер назад (#6)
	sliderPrev() {
		// Если счетчик прокруток больше единицы
		if(this.moving_count > 1) {
			this.pos += this.slide_width;

		    $(this.slides_box_id).animate({'margin-left': this.pos + 'px'}, 400);

		    this.moving_count--;

		    $(this.slides_box_id).parents('.slider').find('.slider_dot').removeClass('slider_active_dot');

		    for(var i = this.moving_count; i <= this.moving_count + this.visible_slides_count - 1; i++ ) 
			{
				var active_dot = $(this.slides_box_id).parents('.slider').find('.slider_dot[data-num="' + i + '"]');

				active_dot.addClass('slider_active_dot');
			}
		    return;
		}

		// Если счетчик прокруток равен единице
		if(this.moving_count == 1) {
			this.pos = -(this.max_moving_count - 1) * this.slide_width;

		    $(this.slides_box_id).animate({'margin-left': this.pos + 'px'}, 400);

		    this.moving_count = this.max_moving_count;

		    $(this.slides_box_id).parents('.slider').find('.slider_dot').removeClass('slider_active_dot');

		    for(var i = this.moving_count; i <= this.moving_count + this.visible_slides_count - 1; i++ ) 
			{
				var active_dot = $(this.slides_box_id).parents('.slider').find('.slider_dot[data-num="' + i + '"]');

				active_dot.addClass('slider_active_dot');
			}
		}
	}


	
}