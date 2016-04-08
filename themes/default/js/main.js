// $(function() {
// 	var params = {
// 	"modelName": "Address",
// 	"calledMethod": "getCities",
// 	"methodProperties": {},
// 	"apiKey": "45a3b980c25318193c40f7b10f7d0663"
// 	};
// 	$.ajax({
// 		url: "http://testapi.novaposhta.ua/v2.0/address/getCities/{format}/&" + $.param(params),
// 		beforeSend: function(xhrObj){
// 			// Request headers
// 			xhrObj.setRequestHeader("Content-Type","application/json");
// 		},
// 		type: "POST",
// 	})
// 	.done(function(data) {
// 		alert("success");
// 	})
// 	.fail(function() {
// 		alert("error");
// 	});
// });
$(window).load(function(){
	$("html,body").trigger("scroll");
});

$(function(){
	//Отключение клика на ссылку с #
	$('a[href="#"]').on('click', function(e){
		e.preventDefault();
	});

	//function $_GET(key) {
	//	var s = window.location.search;
	//	s = s.match(new RegExp(key + '=([^&=]+)'));
	//	return s ? s[1] : false;
	//}
	//if($_GET('quiz')){
	//	openObject('quiz');
	//}
	// openObject('auth');

	var viewport_width = $(window).width(),
		viewport_height = $(window).height(),
		center_section_height = $('section .center').height(),
		header_outerheight = $('header').outerHeight();

	// Инициализация lazy load
	$("img.lazy").lazyload({
		effect : "fadeIn"
	});

	// if(viewport_width < 711) {

	// 	//Замена картинок баннера
	// 	// var banner_img = $('#owl-main_slider img');
	// 	// $('#owl-main_slider').css({
	// 	// 	'height': viewport_width,
	// 	// 	'max-height':  $(window).height()*0.8
	// 	// });
	// 	// $.each( banner_img ,function(index, obj) {
	// 	// 	var src = $(this).attr('data-src'),
	// 	// 		mobile_src = src.replace('banner', 'banner/mobile');
	// 	// 	$(this).attr('data-src' , mobile_src);
	// 	// });

	// 	//Замена картинок в слайдере миниатюр
	// 	var slider_img = $('#owl-product_mini_img_js img');
	// 	$.each( slider_img ,function(index, obj) {
	// 		var src = $(this).attr('src'),
	// 			mobile_src = src.replace('small', 'medium');
	// 		$(this).attr( 'src' , mobile_src);
	// 	});
	// 	//Удаление класса акт картинки на моб версии
	// 	$('#owl-product_mini_img_js').find('img').removeClass('act_img');
	// }

	// Высота сайдбара
	$('.sidebar_wrapp').css('max-height', (viewport_height - header_outerheight - 15));

	//Инициализаци слайдера
	// $("#owl-main_slider").owlCarousel({
	// 	autoPlay: true,
	// 	stopOnHover: true,
	// 	slideSpeed: 500,
	// 	paginationSpeed: 800,
	// 	itemsScaleUp: true,
	// 	singleItem: true,
	// 	lazyLoad: true,
	// 	lazyFollow: false,
	// 	// transitionStyle : "fade",
	// 	pagination: false,
	// 	navigation: true, // Show next and prev buttons
	// 	navigationText: ['<svg class="arrow_left"><use xlink:href="images/slider_arrows.svg#arrow_left"></use></svg>',
	// 					'<svg class="arrow_right"><use xlink:href="images/slider_arrows.svg#arrow_right"></use></svg>']
	// });

	//Строчный просмотр товаров
	$('.prod_structure span.list').on('click', function(){
		ChangeView('list');
	});
	//Модульный просмотр товаров
	$('.prod_structure span.module').on('click', function(){
		ChangeView('module');
	});

	//Максимальная высота корзины
	if(viewport_width > 712) {
		var coeff = 0.8;
	}else{
		var coeff = 0.9;
	}
	$('#cart .order_wrapp').css('max-height', (viewport_height - header_outerheight)*coeff);

	//Отправка формы Search
	$('.mob_s_btn').on('click', function() {
		// alert('dfs');
		// $(this).closest('form').submit();
		$('#search').focus();
	});

	// Фокусировка Search
	$('#search').on('focus', function() {
		$('html').css('overflow-y', 'scroll');
		// $('body').addClass('active_bg');
	});
	// Активация кнопки поиска при вводе
	$('#search').on('keyup', function() {
		var val = $(this).val();
		if(val != ''){
			if(!$('.search_btn').hasClass('color-grey-search')){
				$('.search_btn').addClass('color-grey-search');
			}
		}else{
			if($('.search_btn').hasClass('color-grey-search')){
				$('.search_btn').removeClass('color-grey-search');
			}
		}
	});
	//Отмена обработчика отпраки формы
	$('#category-lower-right').on('click', function(event) {
		event.preventDefault();
	});

	//Имитация Select
	$('.imit_select').on('click', '.mdl-menu__item', function(){
		var value = $(this).text(),
			id = $(this).data('value');
		console.log(value);
		console.log($(this).closest('.imit_select').find('.select_field').text());
		$(this).closest('.imit_select').find('.mdl-menu__item').removeClass('active');
		$(this).closest('.imit_select').find('.select_field').text(value);
		$(this).closest('.mdl-menu__container').removeClass('is-visible');
		$(this).addClass('active');
	});
	$('.region.imit_select').on('click', '.mdl-menu__item', function(){
		GetCities($('.region.imit_select').find('.select_field').text());
		$('.city.imit_select').find('.select_field').text('Выбрать');
	});
	$('.sort.imit_select .mdl-menu__item').on('click', function(){
		var sort = JSON.parse($.cookie('sorting'));
		if(sort[current_controller] != undefined){
			sort[current_controller]['value'] = ($(this).data('value'));
			var sorting = JSON.stringify(sort);
			$.cookie('sorting', sorting, {
				expires: 2,
				path: '/'
			});
			location.reload();
		}
	});

	// Активация меню mobile
	$('.menu').on('click', function() {
		var action = $(this).text(),
			indent = $("header").outerHeight(),
			panel_height = viewport_height - indent;
		if(action == 'menu'){
			$(this).html('close');
			// $('.panel[data-type="panel"]').css('display', 'block').height(panel_height);
			// $('body').addClass('active_panel');
		}else{
			$(this).html('menu');
			// $('.panel[data-type="panel"]').height(0);
			// $('body').removeClass('active_panel');
		}
	});

	//Закрытие search mobile
	$('.search_close').on('click', function(){
		closeObject();
	});

	//Scroll Magic
	var header = $("header"),
		over_scroll = $('body').hasClass('banner_hidden')?true:false,
		banner_height = $('.banner').height(),
		header_height = header.height();
	$(window).scroll(function(){
		if(over_scroll == false){
			if($(this).scrollTop() > banner_height/2 - header_height && header.hasClass("default")){
				header.removeClass("default").addClass("filled");
			}else if($(this).scrollTop() <= banner_height/2 - header_height && header.hasClass("filled")){
				header.removeClass("filled").addClass("default");
			}
			//Скрытия баннера
			if($(this).scrollTop() > banner_height){
				over_scroll = true;
				$('.banner').height(0);
				$('body').addClass('banner_hide');
				$('html, body').scrollTop(0);
			}
		}
	});

	//Возврат баннера если он скрыт
	$('.logo').on('click', function(event){
		if($('body').hasClass('c_main') && over_scroll === true){
			event.preventDefault();
			$('.banner').animate({
				height: banner_height
			}, 300);
			$('html, body').animate({
				scrollTop: 0
			}, 300);
			$('body').removeClass('banner_hide');
			header.removeClass("fixed_panel").addClass("default");
			setTimeout(function(){over_scroll = false;},305);
		}
	});

	//Меню
	$('.more_cat').on('click', function() {
		var lvl = $(this).closest('ul').data('lvl'),
			parent = $(this).closest('li'),
			parent_active = parent.hasClass('active');
		$(this).closest('ul').find('li').removeClass('active').find('ul').stop(true, true).slideUp();
		 // $(this).closest('ul').find('.material-icons').addClass('rotate');

		if(!parent_active){
			parent.addClass('active').find('> ul').stop(true, true).slideDown();
			// $(this).find('.material-icons').addClass('rotate');
		}
	});


	//Кабинет
	//$('a.cabinet_btn').find('ul.mdl-js-ripple-effect').css('dispaly','block');
	$('mdl-menu__container').hover(
       function(){ $(this).addClass('is-visible') },
       function(){ $(this).removeClass('is-visible') }
	);

	/*$('.elem').hover(function(){
		$(this).text('mouse on');
	},function(){
		$(this).text('mouse off');
	});*/


	$('.second_nav li.active > ul').show();
	//Переключение вкладок главного меню
	$('.catalog').on('click', '.main_nav li', function() {
		var section = $(this).data('nav');

		if(section == 'filter') {
			var name = $(this).find('i').text();
			if (name == 'filter_list') {
				$(this).find('i').text('highlight_off');
				$(this).find('span.title').text('Скрыть');
				$('.second_nav, .news ').slideUp();
				$('.included_filters').hide();
				$('.filters').fadeIn();
				$(this).addClass('active');
			} else {
				$(this).find('i').text('filter_list');
				$(this).find('span.title').text('Фильтры');
				$('.filters').fadeOut();
				$('.second_nav, .news').slideDown();
				$('.included_filters').show();
				$(this).removeClass('active');
			}
		}else{
			$('.catalog .main_nav li').removeClass('active');
			$(this).addClass('active');
		}
	});

	//Меню в кабинете
	$('.menus').on('click', function() {
		var children = $(this).closest('li').find('ul');
		if(children.hasClass('active')){
			children.removeClass('active').stop(true, true).slideUp();
		}else{
			children.addClass('active').stop(true, true).slideDown();
		}
	});

	/** Анимация прокручивания кнопки наверх */
	var pos = getScrollWindow();
	changeToTop(pos);
	$(window).scroll(function(){
		pos = getScrollWindow();
		changeToTop(pos);
	});
	$('#toTop').click(function () {
		$('html, body').animate({
			scrollTop: 0
		}, 1000, "easeInOutCubic");
	});

	//Стрелка указывающая на цену
	var price_el = $('.price'),
		price_nav_el = $('.price_nav');

	if(price_el.length > 0) {
		var price_pos = Math.round(price_el.offset().left + (price_el.width() / 2) - (price_nav_el.width() / 2));
		price_nav_el.offset({left: price_pos});
	}

	//Высота блока главной картики продукта
	$('.product_main_img').css('height', $('.product_main_img').outerWidth());

	//Инициализация owl carousel
	$("#owl-product_mini_img_js").owlCarousel({
		items: 6,
		itemsCustom: [[320, 1], [727, 2], [950, 3], [1250, 4], [1600, 5]],
		navigation: true, // Show next and prev buttons
		dots: false,
		navigationText: ['<svg class="arrow_left"><use xlink:href="images/slider_arrows.svg#arrow_left_tidy"></use></svg>',
						'<svg class="arrow_right"><use xlink:href="images/slider_arrows.svg#arrow_right_tidy"></use></svg>']
	});
	$("#owl-popular, #owl-last-viewed, #owl-accompanying").owlCarousel({
		autoPlay: false,
		dots: false,
		stopOnHover: true,
		slideSpeed: 300,
		paginationSpeed: 400,
		itemsScaleUp: true,
		items: 5,
		responsive: {
			320: {items: 1},
			727: {items: 2},
			950: {items: 3},
			1250: {items: 4},
			1600: {items: 5}
		},
		nav: true, // Show next and prev buttons
		navText: ['<svg class="arrow_left"><use xlink:href="images/slider_arrows.svg#arrow_left_tidy"></use></svg>',
						'<svg class="arrow_right"><use xlink:href="images/slider_arrows.svg#arrow_right_tidy"></use></svg>']
	});

	//Raiting stars
	$('.set_rating').on('change', function(){
		var rating = $(this).val();
		changestars(rating);
	});
	$('.star').hover(function(){
		var rating = $(this).closest('label').find('input').val();
		changestars(rating);
		$('.feedback_stars').on('mouseleave', function(){
			rating = $(this).find('input:checked').val();
			if(!rating){
				rating = 0;
			}
			changestars(rating);
		});
	});
	$('.star').on('click', function(e){
		var input = $(this).closest('label').find('input');
		if(input.is(":checked")){
			e.preventDefault();
			input.removeAttr('checked');
			changestars(0);
		}
	});

	$('input.mdl-checkbox__input').on('click', function(){
		// location.href = $(this).closest('a').attr('href');
	});

	//Закрытие подложки и окон
	$('body').on('click', '.background_panel', function(){
		closeObject();
	});

	// Добавление кнопки Закрыть всем модальным окнам
	$('[data-type="modal"]').each(function(index, el){
		$(this).append('<a href="#" class="material-icons close_modal btn_js" data-name="'+$(this).attr('id')+'">close</a>');
	});

	//Замена картинки для открытия в ориг размере
	$('.product_main_img').on('click', function(){
		var img_src = $(this).find('img').attr('src'),
			img_alt = $(this).find('img').attr('alt');
		$('#big_photo img').attr({
			src: img_src,
			alt: img_alt
		})
		$('#big_photo').css({
			// 'height': (viewport_height - header_outerheight)*0.9,
			'max-width': viewport_width*0.9
		});
	});
	//Закрытие окна при клике на картинку
	$('#big_photo img').on('click', function(){
		closeObject();
	});

	//Открытие обьектов с подложкой
	$('body').on('click', '.btn_js', function(){
		var name = $(this).data('name');
		if(name != undefined){
			if(name == 'cart'){
				GetCartAjax();
			}else{
				openObject(name);
			}
		}
	});

	/*$('.stat_year').hover(function(){
		$('#top_block_graph').css('opacity','block') },
       function(){ $('#top_block_graph').css('display','none').css('z-index','11')
   });*/
	$('.stat_years canvas').on('click', function(){
		var one = $(this).closest('.stat_years').find('input[type="range"]').eq(0).val();
		var two = $(this).closest('.stat_years').find('input[type="range"]').eq(1).val();
		$(this).closest('.stat_years').find('input[type="range"]').each(function(index, el) {
			console.log($(el).val());
		});
		// console.log(two);
		openObject('graph');
	});

	//Открытие модального Графика
	/*$('#graph').on('click', '.btn_js.save', function(){
		var parent =  $(this).closest('#graph'),
			id_category = parent.data('target'),
			opt = 0,
			name_user = parent.find('#name_user').val(),
			text = parent.find('textarea').val(),
			arr = parent.find('input[type="range"]'),
			values = {};
		if ($('.select_go label').is(':checked')) {
			var opt = 1;
		};
		arr.each(function(index, val){
			values[index] = $(val).val();
		});
		ajax('product', 'SaveGraph', {'values': values, 'id_category': id_category, 'name_user': name_user, 'text': text, 'opt': opt}).done(function(data){
			if(data === true){
				console.log('Your data has been saved successfully!');
				closeObject('graph');
				location.reload();
			}else{
				console.log('Something goes wrong!');
			}
		});
	});*/

	//Редактирование модального Графика
	/*$('a.update_exist').on('click', function(){
		var id_graphics = $(this).attr('id');
		ajax('product', 'SearchGraph', {'id_graphics': id_graphics}, 'html').done(function(data){
			console.log(data);

			if(data != null){
				$('#graph .modal_container').html(data);
				componentHandler.upgradeDom();
				openObject('graph');

			}else{
				console.log('Something goes wrong!');
			}
		});
	});*/

	$('#icon_graph').on('click', function(){
	    //$(document.body).click(function () {
	      if ($("div.stat_years").is(":hidden")) {
	        /*$("div.stat_years").slideDown("slow").removeClass('hidden');*/
	        $("div.stat_years").slideDown("slow");
	      } else {
	        $("div.stat_years").slideUp("slow");
	      }
	    //});
	  });

	$('.down_graph').on('click', function(){
		$("div.stat_year").slideUp("slow");
	    	$('.ones').css('opacity', '0');
			$(".graph_up").removeClass('hidden').animate({
				opacity: 0.6
			}, 1500 ).css({
				'transform': 'rotate(30deg)',

			});
	  });

	$(".graph_up").on('click', function(){
		$(this).addClass('hidden');
		$("div.stat_year").eq(0).slideDown("slow");
		//$('.ones').css('opacity', '1').setTimeout(function(){}, 2000);
		setTimeout(function(){
			$('.ones').css('opacity', '1');
		}, 600);
	});

	$('.xgraph_up').on('click', function() {
		if ($(this).hasClass('two')) {
			var moderation = 1;
		}else{
			var moderation = 0;
		}
		var id_graphics = false;
		ModalGraph(id_graphics, moderation);
	});



	//Открытие модального окна login///////
	/*$('.switch').on('click', function(e){
		e.preventDefault();
		$(this).closest('[class^="wr_modal"]').addClass('hidden');
		$('.wr_modal_'+$(this).data('next-step')).removeClass('hidden');
	});*/

	/*$('button').on('click', '.switch', function(){
		var name = $(this).data('name');
		if(name != undefined){
			if(name == 'login'){
				GetLoginAjax();
			}else{
				openObject(name);
			}
		}
	});*/
	//Обработка примечания
	$('.note textarea').on('blur', function(){
		$(this).css({
			height: '30px'
		});
		// var id = $(this).closest('form.note').attr('data-note'),
		// 	note = $(this).val();
		// ajax('cart', "update_note",{"id_product": id, "note": note});
	});
	//Обработка примечания
	$('.add_cart_state input:radio').on('click', function(){
		var checked = false;
		if($(this.checked)){
			checked = true;
		}
		$(this).prop("checked", checked);
	});

	/* Обработчик данных из корзины */
	$('#quiz .to_step').on('click', function(e){
		e.preventDefault();
		var
			//target_step = $(this).data('step'),
			//current_step = $(this).closest('[class*="step_"]').data('step'),
			//summary = $('#quiz .summary_info'),
			//current = $('.step_'+current_step),
			//target = $('.step_'+target_step),
			//validate = false,
			i = 0,
			data = null,
			all = {
			target_step: $(this).data('step'),
			current_step: $(this).closest('[class*="step_"]').data('step'),
			summary: $('#quiz .summary_info'),
			current: $('.step_'+$(this).closest('[class*="step_"]').data('step')),
			target: $('.step_'+$(this).data('step')),
			validate: false

		};
		if(all.target_step == 1){
			all.summary.removeClass('active');
			if(all.current_step == 2){
				all.summary.find('.lastname').closest('.row').addClass('hidden');
				all.summary.find('.firstname').closest('.row').addClass('hidden');
				all.summary.find('.middlename').closest('.row').addClass('hidden');
				all.summary.removeClass('active');
				validateq(all);
			}
		}else if(all.target_step == 2){
			if(all.current_step == 1){
				var lastname = all.current.find('[name="lastname"]').val(),
					firstname = all.current.find('[name="firstname"]').val(),
					middlename = all.current.find('[name="middlename"]').val();
				all.target.find('span.client').text(firstname+' '+middlename);
				all.summary.find('.lastname').text(lastname).closest('.row').removeClass('hidden');
				all.summary.find('.firstname').text(firstname).closest('.row').removeClass('hidden');
				all.summary.find('.middlename').text(middlename).closest('.row').removeClass('hidden');
				if(lastname == ''){
					i++;
					$('#lastname').addClass('is-invalid');
				}
				if(firstname == ''){
					i++;
					$('#firstname').addClass('is-invalid');
				}
				if(middlename == ''){
					i++;
					$('#middlename').addClass('is-invalid');
				}
				if(i == 0){
					data = {firstname: firstname, lastname: lastname, middlename:middlename};

					ajax('cart', 'update_info', data, 'text').done(function(response){
						GetRegions();
						all.summary.addClass('active');
						all.validate = true;
						validateq(all);
					});

				}
			}else if(all.current_step == 3){
				all.summary.find('.region').closest('.row').addClass('hidden');
				all.summary.find('.city').closest('.row').addClass('hidden');
				validateq(all);
			}
		}else if(all.target_step == 3){
			if(all.current_step == 2){
				var selected_region = all.current.find('#region_select .select_field').text(),
					selected_city = all.current.find('#city_select .select_field').text();
					all.target.find('span.client').text($('.firstname').text()+' '+$('.middlename').text());

				if(selected_region != 'Выбрать' && selected_city != 'Выбрать'){
					all.summary.find('.region').text(selected_region).closest('.row').removeClass('hidden');
					all.summary.find('.city').text(selected_city).closest('.row').removeClass('hidden');
					$('.error_div').addClass('hidden');
				}

				if(selected_region == 'Выбрать'){
					i++;
					$('.error_div').removeClass('hidden').text("Выберите область");
				} else if(selected_city == 'Выбрать'){
					i++;
					$('.error_div').removeClass('hidden').text("Выберите город");
				}

				if(i == 0){
					data = {selected_region: selected_region, selected_city: selected_city};

					ajax('cart', 'update_info', data, 'html').done(function(response){
						GetDeliveryService(selected_city+' ('+selected_region+')', $('input[name="service"]:checked').val());
						Position($(this).closest('[data-type="modal"]'));
						all.summary.find('.delivery_service').text(selected_region);
						all.summary.find('.delivery_method').text(selected_city);
						all.validate = true;
						validateq(all);
					});
				}
			}else if(all.current_step = 4){
				all.summary.find('.delivery_service').closest('.row').addClass('hidden');
				all.summary.find('.delivery_method').closest('.row').addClass('hidden');
				all.summary.find('.client_address').closest('.row').addClass('hidden');
				all.summary.find('.post_office_address').closest('.row').addClass('hidden');
				validateq(all);
			}
		}else if(all.target_step == 4){
			if(all.current_step == 3){
				var delivery_service = $('input[name="service"]:checked').val(),
					delivery_method = $('#select_delivery_type .select_field').text(),
					selected_post_office = all.current.find('#post_office_select .select_field').text(),
					selected_post_office_id = $('[for="post_office_select"] li.active').data('value'),
					delivery_address = all.current.find('#delivery_address').val();

				if(typeof delivery_service !== 'undefined') {
					all.summary.find('.delivery_service').text(delivery_service).closest('.row').removeClass('hidden');
				}
				if(delivery_method != "Выбрать"){
					all.summary.find('.delivery_method').text(delivery_method).closest('.row').removeClass('hidden');
				}


				if(delivery_method == "Адресная доставка" && delivery_address != "") {
					all.summary.find('.client_address').text(delivery_address).closest('.row').removeClass('hidden');
				}
				if(delivery_method == "Забрать со склада" && selected_post_office != "Выбрать отделение"){
					all.summary.find('.client_address').text(delivery_address).closest('.row').addClass('hidden');
					all.summary.find('.post_office_address').text(selected_post_office).closest('.row').removeClass('hidden');
				}
				if(delivery_method == "Забрать со склада"
				 && selected_post_office != "Выбрать отделение"
				 && delivery_address != "") {
					$('#delivery_address').val("");
				}

				if(typeof delivery_service === 'undefined'){
					i++;
					$('.error_div').removeClass('hidden').text("Выберите службу доставки");
				}else if(delivery_method == "Выбрать"){
					i++;
					$('.error_div').removeClass('hidden').text("Выберите способ доставки");
				}else if(delivery_method == "Адресная доставка" && delivery_address == ""){
					i++;
					$('.error_div').addClass('hidden');
					$('#client_address').addClass('is-invalid');
				}else if(delivery_method == "Забрать со склада" && selected_post_office == "Выбрать отделение"){
					i++;
					$('.error_div').removeClass('hidden').text("Выберите отделение");
				}else {
					$('.error_div').addClass('hidden');
				}
				if(i == 0){
					data = {
						delivery_service: delivery_service,
						delivery_method: delivery_method,
						delivery_address: delivery_address,
						selected_post_office_id: selected_post_office_id
					};

					ajax('cart', 'update_info', data, 'html').done(function(response){
						all.summary.find('.delivery_service').text(delivery_service);
						all.summary.find('.delivery_method').text(delivery_method);
						all.validate = true;
						validateq(all);
					});
				}
			}
		}else if(all.target_step == 5){
			if(all.current_step == 4){

			}

			if(i == 0){
				data = {delivery_service: delivery_service, delivery_method: delivery_method};

				ajax('cart', 'update_info', data, 'text').done(function(response){
					all.validate = true;
					validateq(all);
				});
			}
		}
		function validateq(all){

			if(all.validate == true || all.target_step < all.current_step){
				all.current.removeClass('active');
				all.target.addClass('active');
				Position($(this).closest('[data-type="modal"]'));
			}
		};
	});
	// $('submit').on('click', function(e){
	// 	e.preventDefault();


	// 	$.ajax({

	// 		url: URL_base+'ajaxorder',
	// 		type: "POST",
	// 		cache: false,
	// 		dataType : "json",
	// 		data: {
	// 			"action": 'add'

	// 		}
	// 	}).done(function(){
	// 		if(data != false){
	// 			openObject('opened');
	// 		}else{
	// 			error(function() {
	// 				console.log('error');
	// 			});
	// 		}
	// 	});
	// });
	// dalee

	/*  $('.select_go label').on('change', function() {
	    console.log('trues');
	    if($(this).is(':checked')){
	      console.log('trues');
	      console.log($(this));
	      var block_one = $('.mdl-color--grey-100').eq(0).not(':has(div.hidden)');
	      console.log(block_one);
	      block_one.addClass('hidden');
	      var block_two = $('.mdl-color--grey-100').eq(1).hasClass('hidden');
	      console.log(block_two);
	      block_two.removeClass('hidden');
	    }else{
	      var block_one = $('.mdl-color--grey-100').eq(1).not(':has(div.hidden)');
	      block_one.addClass('hidden');
	      var block_two = $('.mdl-color--grey-100').eq(0).hasClass('hidden');
	      block_two.removeClass('hidden');
	    }
	    //$('.mdl-color--grey-100').toggleClass('hidden');
	  });*/

	$('input[name="options"]').on('change', function() {
		$('#quiz .company_details').css('display', 'block');
	});

	$('#quiz .delivery_service').on('click', 'input[name="service"]', function(){
		if($('.delivery_service input[name="service"]:checked') && $('[data-value="2"]')){
			GetDeliveryMethods($(this).val(), $('#city_select .select_field').text());
			Position($(this).closest('[data-type="modal"]'));
		}
	});

	$('.delivery_type [data-value="1"]').on('click', function(){
		$('.delivery_address').css('display', 'block');
		$('.post_office').css('display', 'none');
	})

	$('.delivery_type [data-value="2"]').on('click', function(){
		if($('.delivery_service input[name="service"]:checked')){
			$('.post_office').css('display', 'block');
			$('.delivery_address').css('display', 'none');

			GetDeliveryMethods($('.delivery_service input[name="service"]:checked').val(), $('#city_select .select_field').text());
		}
	})

	$('#quiz .mdl-button').on('click', function(e){
		e.preventDefault();
		return false;
	});

	// Открыть Форму авторизации
	$('.login_btn').on('click', function(e){
		openObject('auth');
		/*removeLoadAnimation('#auth');*/
		$('#auth #login').show().removeClass('hidden');
		$('#auth #registration').hide().addClass('hidden');
		e.preventDefault();
	});

	// Переключение вход / регистрация
	$('#auth').on('click', '.switch', function(e){
		e.preventDefault();
		$(this).closest('.modal_container').fadeOut().addClass('hidden');
		$('#'+$(this).data('name')).hide().removeClass('hidden').fadeIn();
		Position($('#auth'));
	});

	// Проверка формы входа
	$('#auth').on('click', '.sign-in', function(e){
		e.preventDefault();
		addLoadAnimation('#auth');
		var form = $(this).closest('form'),
			email = form.find('input#email').val(),
			passwd = form.find('input#passwd').val();
		form.find('.error').fadeOut();
		e.preventDefault();
		ajax('auth', 'sign_in', {email: email, passwd: passwd}).done(function(data){
			var parent = $('.header_nav [for="demo-menu-lower-right"]');
			removeLoadAnimation('#auth');
			if(data.errm != 1){
				parent.find('.mdl-menu__item .user_name').text(data.member.name);
				parent.find('.mdl-menu__item .user_email').text(data.member.email);
				parent.find('.mdl-menu__item .user_contr').text(data.member.contragent.name_c);
				parent.find('.mdl-menu__item .user_contr_phones').text(data.member.contragent.phones);
				parent.find('.mdl-menu__item .user_promo').text(data.member.promo_code);
				closeObject('auth');
				$('.cabinet_btn').removeClass('hidden');
				$('.login_btn').addClass('hidden');
			}else{
				form.find('.error').text(data.msg).fadeIn();
			}
		});
	});

	// Проверка надежности пароля
	$('#registration #passwd').keyup(function(){
		var passwd = $(this).val();
		var passconfirm = $('#registration #passwdconfirm').val();
		ValidatePass(passwd);
		/*$('.mdl-textfield #passwd').closest('#regs form .mdl-textfield').addClass('is-invalid');*/
		if(passconfirm !== ''){
			ValidatePassConfirm(passwd, passconfirm);
		}
	});

	/** Проверка подтверждения пароля на странице регистрации */
	$('#registration #passwdconfirm').keyup(function(){
		var passwd = $('#registration #passwd').val();
		var passconfirm = $(this).val();
		ValidatePassConfirm(passwd, passconfirm);
	});

	// Проверка формы регистрации
	$('#registration .sign-up').click(function(e){
		e.preventDefault();
		addLoadAnimation('#registration');
		var parent = $(this).closest('form'),
			name = parent.find('input#name').val(),
			email = parent.find('input#email').val();
		ValidateEmail(email, 1);

	});


	/*$("#login_email").blur(function(){
		var name = this.value;
		var count = name.length;
		if(count < 5){
			$(this).removeClass().addClass("unsuccess");
		} else {
			$("#login_email").attr("value",name);
			$(this).removeClass().addClass("success");
		}
	});
	$("#login_passwd").blur(function(){
		var pswd = this.value;
		var count = pswd.length;
			$("#login_passwd").attr("value",pswd);
		if(count > 0){
			$(this).removeClass().addClass("success");
		} else {
			$(this).removeClass().addClass("unsuccess");
		}
	});
*/


	/*    Cabinet     */

	$('.order').on('click', '.number', function(){
		var parent = $(this).closest('.order');

		if(parent.hasClass('expanded')){
			$('.order').removeClass('expanded').find('.tabs').slideUp();
		}else{
			$('.order').removeClass('expanded').find('.tabs').slideUp();
			parent.addClass('expanded').find('.tabs').slideDown();
		}
	});
		$('.showall').on('click', function(){
		$('.order').addClass('expanded').find('.tabs').slideDown();
	});
		$('.hideall').on('click', function(){
		$('.order').removeClass('expanded').find('.tabs').slideUp();
	});

	$('#percent tr:first').css('color', '#000');


	/*Перенос модалок в main.tpl*/

	showModals();

	$('input[name="product_limit_checkbox"]').on('change', function(){
		var id = $(this).data('id-product'),
			product_limit = $('#product_limit_mopt_'+id);
		if(this.checked){
			limit = 10000000;
		}else{
			limit = 0;
		}
		product_limit.val(limit);
		toAssort($(this).data('id-product'), 0, $(this).data('koef'), $(this).data('supp'));
	});
});