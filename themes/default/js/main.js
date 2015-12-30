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

$(function(){

	var viewport_width = $(window).width(),
		viewport_height = $(window).height(),
		center_section_height = $('section .center').height(),
		header_outerheight = $('header').outerHeight();
	openObject('quiz');
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
	// $('.mob_s_btn').on('click', function() {
	// 	alert('dfs');
	// 	$(this).closest('form').submit();
	// 	$('#search').focus();
	// });

	// Фокусировка Search
	// $('#search').on('focus', function() {
	// 	$('html').css('overflow-y', 'scroll');
	// 	$('body').addClass('active_search');
	// });
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

	//Емитация Select
	$('.imit_select .mdl-menu__item').on('click', function() {
		var value = $(this).text();
		var sort = JSON.parse($.cookie('sorting'));
		sort[current_controller]['value'] = ($(this).data('value'));
		var sorting = JSON.stringify(sort);
		console.log(sorting);
		$.cookie('sorting', sorting, {
			expires: 2,
			path: '/'
		});
		location.reload();
		//$('.imit_select .mdl-menu__item').removeClass('active');
		//$(this).addClass('active');
		//$(this).closest('.imit_select').find('.select_fild').text(value);

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
	$('.second_nav li.active > ul').show();
	//Переключение вкладок главного меню
	$('.catalog').on('click', '.main_nav li', function() {
		var section = $(this).data('nav');

		if(section == 'filter'){
			var name = $(this).find('i').text();
			if(name == 'filter_list'){
				$(this).find('i').text('highlight_off');
				$(this).find('span.title').text('Скрыть');
				$('.second_nav, .news ').slideUp();
				$('.included_filters').hide();
				$('.filters').fadeIn();
				$(this).addClass('active');
			}else{
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
		price_pos = Math.round(price_el.offset().left + (price_el.width()/2) - (price_nav_el.width()/2));
	price_nav_el.offset({left:price_pos });
	//console.log(price_el.offset());

	//Высота блока главной картики продукта
	$('.product_main_img').css('height', $('.product_main_img').outerWidth());

	//Инициализация owl carousel
	$("#owl-product_mini_img_js").owlCarousel({
		items: 6,
		itemsCustom: [[320, 1], [727, 2], [950, 3], [1250, 4], [1600, 5]],
		navigation: true, // Show next and prev buttons
		pagination: false,
		navigationText: ['<svg class="arrow_left"><use xlink:href="images/slider_arrows.svg#arrow_left_tidy"></use></svg>',
						'<svg class="arrow_right"><use xlink:href="images/slider_arrows.svg#arrow_right_tidy"></use></svg>']
	});
	$("#owl-popular, #owl-last-viewed, #owl-accompanying").owlCarousel({
		autoPlay: false,
		stopOnHover: true,
		slideSpeed: 300,
		paginationSpeed: 400,
		itemsScaleUp: true,
		items: 5,
		navigation: true, // Show next and prev buttons
		navigationText: ['<svg class="arrow_left"><use xlink:href="images/slider_arrows.svg#arrow_left_tidy"></use></svg>',
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

	//Закрытие подложки и окон
	$('body').on('click', '.background_panel', function(){
		closeObject();
	});

	// Добавление кнопки Закрыть всем модальным окнам
	$('[data-type="modal"]').each(function(index, el) {
		$(this).append('<a href="#" class="material-icons close_modal btn_js" data-name="'+$(this).attr('id')+'">close</a>');
	});

	//Замена картинки для открытия в ориг размере
	$('.product_main_img').on('click', function() {
		var img_src = $(this).find('img').attr('src'),
			img_alt = $(this).find('img').attr('alt');
		$('#big_photo img').attr({
			src: img_src,
			alt: img_alt
		}).css({
			'max-height': (viewport_height - header_outerheight)*0.9,
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
	//Открытие модального окна login///////


/*$('.enter_btn').on('click', function(e){
		e.preventDefault();
		$(this).closest('[class^="wr_modal"]').addClass('hidden');
		$('.wr_modal_'+$(this).data('next-step')).removeClass('hidden');
	});*/

	/*$('button').on('click', '.enter_btn', function(){
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
		// $.ajax({
		// 	url: URL_base+'ajaxcart',
		// 	type: "POST",
		// 	cache: false,
		// 	dataType : "json",
		// 	data: {
		// 		"action": "update_note",
		// 		"id_product": id,
		// 		"note": note
		// 	}
		// });
	});
	//Обработка примечания
	$('.add_cart_state input:radio').on('click', function(){
		var checked = false;
		if($(this.checked)){
			checked = true;
		}
		$(this).prop("checked", checked);
		console.log('sdf');
	});

	/* Обработчик данных из корзины */
	$('submit').on('click', function(e){
		console.log('er');
		e.preventDefault();


		$.ajax({

			url: URL_base+'ajaxorder',
			type: "POST",
			cache: false,
			dataType : "json",
			data: {
				"action": 'add'

			}
		}).done(function(){
			if(data != false){
				openObject('opened');
			}else{
				error(function() {
					console.log('error');
				});
			}
		});
	});
	// dalee
	$('.to_step').on('click', function(e){
		e.preventDefault();
		$(this).closest('[class*="step_"]').removeClass('active');
		$('.step_'+$(this).data('step')).addClass('active');
		Position($(this).closest('[data-type="modal"]'));
		/*$('.opened').removeClass('wr_modal');
		openObject('modal');
		$('.opened').removeClass('wr_modal_2');*/

	});

	$('.login').on('click', function(e){
		openObject('regs_log');
		e.preventDefault();
	});
	$('#logs .enter_btn').on('click', function(){
		$(this).closest('#logs').addClass('hidden');
		$('#regs').removeClass('hidden');
	});
	$('#regs .enter_btn').on('click', function(){
		$(this).closest('#regs').addClass('hidden');
		$('#logs').removeClass('hidden');
	});
	$('#logs .logist').on('click', function(e){
		var email = $(this).closest('form').find('[name="email"]').val();
		var passwd = $(this).closest('form').find('[name="passwd"]').val();
		e.preventDefault();
		$.ajax({
			url: URL_base+'ajaxlogin',
			type: "GET",
			cache: false,
			dataType : "json",
			data: {
				"action": 'login',
				"email": email,
				"passwd": passwd
			}
		}).done(function(data){
			if(data.errm != 1){
				closeObject('regs_log');
				$('.login').closest('li').find('.enter_btn').removeClass('hidden');
				$('.login').addClass('hidden');
			}else{
				console.log(data.msg);
			}
		});
	});
	$('#logs .regist').on('click', function(e){
		var email = $(this).closest('form').find('[name="email"]').val();
		var passwd = $(this).closest('form').find('[name="passwd"]').val();
		e.preventDefault();
		$.ajax({
			url: URL_base+'ajaxlogin',
			type: "GET",
			cache: false,
			dataType : "json",
			data: {
				"action": 'login',
				"email": email,
				"passwd": passwd
			}
		}).done(function(data){
			if(data.errm != 1){
				closeObject('regs_log');
				$('.login').closest('li').find('.enter_btn').removeClass('hidden');
				$('.login').addClass('hidden');
			}else{
				console.log(data.msg);
			}
		});
	});

	$("#login_email").blur(function(){
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
});