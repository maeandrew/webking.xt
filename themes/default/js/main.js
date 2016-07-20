window.onbeforeunload = function(e){
	// window.onpopstate = function(e) {
	// if ( $(window).width() < 500 && $('div[data-type="modal"]').hasClass('opened')) {


	// 	console.log($(window).width());
	// 	console.log($('div[data-type="modal"].opened'));
	// 	console.log($('div[data-type="modal"]').hasClass('opened'));
	// 	var curUrl = window.location.href;
	// 	console.log(curUrl);

	// 	$('div[data-type="modal"]').removeClass('opened').addClass('hidden');
	// 	$('.background_panel').addClass('hidden');

	// 	location.replace(curUrl);
		// history.back(0);
		// $('div[data-type="modal"]').close();
	// };
	// return "You work will be lost.";
};
$(window).on("load", function(){
	$("html, body").trigger("scroll");
});
// window.addEventListener("popstate", function(e) {
//     swapPhoto(location.pathname);
// }, false)
$(function(){
	// $("html, body").trigger("scroll");
	// Определение местоположения устройства из которого был осуществлен вход на сайт
	GetLocation();

	if($(window.location.hash).length == 1 && $(window.location.hash).data('type') == 'modal'){
		openObject((window.location.hash).replace('#', ''));
	}

	setTimeout(function(){
		if ($.cookie('useCookie') != 'agree'){
			$('.cookie_msg_js').css('top', 'calc(100% - '+$('.cookie_msg_js').outerHeight()+'px)');
			
			$('body').on('click', '.cookie_msg_js .close', function(event) {
				event.preventDefault();
				$('.cookie_msg_js').css('top', '100%');
				$.cookie('useCookie', 'agree', {expires: 365});
				setTimeout(function() {
					$('.cookie_wrap').remove();
					$('.err_msg_as_title').css('opacity', '1');
				}, 3000);
			});
		}else{
			$('.err_msg_as_title').css('opacity', '1');
		}
	}, 2000);

	// Смена вида отображения списка товаров
	$('.changeView_js').on('click', function(){
		var view = $(this).data('view');
		$('.productsListView i').removeClass('activeView');
		$(this).addClass('activeView');
		if (view == 'list') {
			$('.cart_info .price_nav').removeClass('hidden');
		}else{
			$('.cart_info .price_nav').addClass('hidden');
		}
		ChangeView(view);
		resizeAsideScroll('click');
	});	
	
	// Показать еще 30 товаров
	$('.show_more_js').on('click', function(e){
		e.preventDefault();		
		var page = $(this).closest('.products_page'),
			id_category = current_id_category,
			start_page = parseInt(page.find('.paginator li.active').first().text()),
			current_page = parseInt(page.find('.paginator li.active').last().text()),
			next_page = current_page+1,
			shown_products = (page.find('.card').get()).length,
			skipped_products = 30*(start_page-1),
			count = $(this).data('cnt');
		/*console.log(page.find('.paginator li.active'));
		console.log('start_page '+start_page);
		console.log('shown_products '+shown_products);*/
		$('.show_more').append('<span class="load_more"></span>');
		var data = {
			action: 'getmoreproducts_desctop',
			id_category: id_category,
			shown_products: shown_products,
			skipped_products: skipped_products
		};
		addLoadAnimation('.show_more_js');
		ajax('products', 'getmoreproducts', data, 'html').done(function(data){
			removeLoadAnimation('.show_more_js');				
			var product_view = $.cookie('product_view'),
				show_count = parseInt((count-30)-parseInt(skipped_products+shown_products));
			page.find('.products').append(data);
			$("img.lazy").lazyload({
				effect : "fadeIn"
			});
			if(page.find('.paginator li.page'+next_page).length < 1){
				if(parseInt(count-parseInt(skipped_products+shown_products)+30) > 30){
					page.find('.paginator li.next_pages').addClass('active').find('a').attr('href','#');
				}else{
					page.find('.paginator li.last_page').addClass('active').find('a').attr('href','#');
				}
			}else{
				page.find('.paginator li.page'+next_page).addClass('active').find('a').attr('href','#');
			}

			if(show_count < 0){
				$('#show_more_products').hide();
			}

			ListenPhotoHover();//Инициализания Preview

			$('.load_more').remove();
			resizeAsideScroll('show_more');
		});
	});

	//Добавление товара в корзину
	$('body').on('change', '.qty_js', function(){
		var id = $(this).closest('.product_buy').attr('data-idproduct'),
			qty = $(this).val(),
			note = $(this).closest('.product_section').find('.note textarea').val();
		SendToAjax (id,qty,false,false,note);
	});
	$('body').on('click', '.buy_btn_js', function (){
		$(this).closest('.card').find('.note').removeClass('hidden');
		
		if ($(this).closest('.card').find('.note').hasClass('note_control')) {
			$(this).closest('.card').find('.note').addClass('activeNoteArea');
		}

		var id = $(this).closest('.product_buy').attr('data-idproduct'),
			qty = $(this).closest('.product_buy').find('.qty_js').val(),
			note = $(this).closest('.product_section').find('.note textarea').val();
		SendToAjax (id,qty,false,false,note);
	});
	$(".note_field").blur(function() {
		if ($(".note_field").val() !== ''){
			$(this).closest('.card').find('.note').removeClass('activeNoteArea');
		}
		var id_product = $(this).data('id'),
		 	note = $(this).val();
		ajax('cart', 'updateCartQty', {id_product: id_product, note: note});
	});

	// // Инициализация добавления товара в избранное
	// $('body').on('click', '.preview_favorites', function () {
	// 	id_product = $(this).attr('data-idfavorite');
	// 	AddFavorite(event,id_product);
	// });

	//Удаление избранного товара из списка
	$('body').on('click', '.remove_favor_js', function(e){
		e.preventDefault();
		var id_product = $(this).closest('.favorite_js').data('idproduct'),
			clicked = $(this);
		$('#confirmDelItem').data('delIdItem', id_product).data('list', "favor");
		clicked.addClass('clicked_js').closest('.tableRow').addClass('flag_js');
	});

	//Удаление товара из листа ожидания
	$('body').on('click', '.remove_waitinglist_js', function(e){
		e.preventDefault();
		var id_product = $(this).closest('.waiting_list_js').data('idproduct'),
			clicked = $(this);
		$('#confirmDelItem').data('delIdItem', id_product).data('list', "waiting");
		clicked.addClass('clicked_js').closest('.tableRow').addClass('flag_js');
	});

	//Подтверждение удаления из листа ожидания/списка избранных
	$('#confirmDelItem').on('click', '.deleteBtn_js', function(){
		var id_product = $('#confirmDelItem').data('delIdItem'),
			clicked = $('.clicked_js');
		closeObject('confirmDelItem');
		if ($('#confirmDelItem').data('list') == 'favor') {
			addLoadAnimation('.flag_js');
			ajax('product', 'del_favorite', {id_product: id_product}).done(function(data){
				if (data.fav_count > 0) {
					clicked.closest('.favorite_js').remove();
					$('.userChoiceFav').text('('+data.fav_count+')');
					var data = {message: 'Товар удален из списка избранных товаров'};
					var snackbarContainer = document.querySelector('#snackbar');
					snackbarContainer.MaterialSnackbar.showSnackbar(data);
				}else{
					$('#favorites').html('<h5>У Вас нет избранных товаров</h5>');
					$('.userChoiceFav').text('(0)');
				}				
			}).fail(function(data){
				console.log('Error!');
			});
		}else if ($('#confirmDelItem').data('list') == 'waiting') {
			addLoadAnimation('.flag_js');
			ajax('product', 'del_from_waitinglist', {id_product: id_product}).done(function(data){
				if (data.fav_count > 0) {
					clicked.closest('.waiting_list_js').remove();
					$('.userChoiceWait').text('('+data.fav_count+')');
					var data = {message: 'Товар удален из листа ожидания'};
					var snackbarContainer = document.querySelector('#snackbar');
					snackbarContainer.MaterialSnackbar.showSnackbar(data);
				}else{
					$('#waiting_list').html('<h5>Лист ожидания пуст</h5>');
					$('.userChoiceWait').text('(0)');
				}
			}).fail(function(data){
				console.log('Error!');
			});
		}
		clicked.removeClass('clicked_js');
		$('.flag_js').removeClass('flag_js');
	});
	
	$('#confirmDelItem').on('click', '.cancelBtn_js', function(){
		$('#confirmDelItem').removeData('delIdItem');
		$('.clicked_js').removeClass('clicked_js');
		$('.flag_js').removeClass('flag_js');
		closeObject('confirmDelItem');
	});


	// SEO-text (Скрывать, если его длина превышает 1к символов)
	var seoText = $('#seoTextBlock').text();
	if (seoText.length > 1000){
		$('#seoTextBlock').css('height', '175px').parent('.mdl-grid')
		.append('<button id="expand_btn" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">Развернуть</button><button id="rollUp_btn" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect hidden">Свернуть</button>');
	}
	$('#expand_btn').click(function() {
		$("#seoTextBlock").css({'height': '100%'});
		$(this).addClass('hidden');
		$('#rollUp_btn').removeClass('hidden');
		resizeAsideScroll('show_more');
	});
	$('#rollUp_btn').click(function() {
		$('#seoTextBlock').css({'height': '175px'});
		$(this).addClass('hidden');
		$('#expand_btn').removeClass('hidden');
	});
	//Скрытие фильтров в зависимости от выбранного уровня товара ---
	if(($('ul.second_nav.allSections > li.active > ul[data-lvl="2"] > li.active:has(ul)')).length === 0 || $('ul.second_nav.allSections ul[data-lvl="3"] > li').hasClass('active')) {
		$('.main_nav li[data-nav="filter"]').removeClass('hidden');
	}else{
		$('.main_nav li[data-nav="filter"]').addClass('hidden');
	}
	if(($('ul.second_nav.allSections li.active').find('li.active')).length === 0){
		$('.main_nav li[data-nav="filter"]').addClass('hidden');
	}
	if($('#segmentNavOrg, #segmentNavStore, #allCategotyCont').find('li.active')){
		if(($('ul.second_nav li.active').find('li.active')).length === 0){
			$('.main_nav li[data-nav="filter"]').addClass('hidden');
		}
	}
	$('.main_nav > li').click(function() {
		/*$('ul.second_nav li').removeClass('active');*/
		if ($('.main_nav > li').hasClass('active') && !$('ul.second_nav li').hasClass('active')) {
			$('.main_nav li[data-nav="filter"]').addClass('hidden');
		}
	});
	$('.second_nav > li[onclick^="segmentOpen"]').click(function() {
		$('.main_nav li[data-nav="filter"]').addClass('hidden');
	});
	//---
	//Отключение клика на ссылку с #
	$('body').on('click', 'a[href="#"]', function(e){
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

	var coeff = 0.9;
	//Максимальная высота корзины
	if(viewport_width > 712){
		coeff = 0.8;
	}
	$('#cart .order_wrapp').css('max-height', (viewport_height - header_outerheight)*coeff);

	//Отправка формы Search
	$('.mob_s_btn').on('click', function() {
		// alert('dfs');
		// $(this).closest('form').submit();
		$('#search').focus();
	});

	// Активация кнопки поиска при вводе
	$('#search').on('keyup', function() {
		if($(this).val() !== ''){
			if(!$('.search_btn').hasClass('is-disabled')){
				$('.search_btn').addClass('is-disabled');
			}
		}else{
			if($('.search_btn').hasClass('is-disabled')){
				$('.search_btn').removeClass('is-disabled');
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
		if(sort.current_controller !== undefined){
			sort.current_controller.value = ($(this).data('value'));
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
		over_scroll = $('body').hasClass('banner_hide')?true:false,
		banner_height = $('.banner').outerHeight();
	var viewPort = $(window).height(); // высота окна
	var mainWindow = $('.main').outerHeight(); // высота главного блока	
	window.addEventListener("orientationchange", function() {
	   viewPort = $(window).height();
	}, false);
	$.cookie('mainWindow', mainWindow, { path: '/'});

	$(window).scroll(function(){
		if(over_scroll === false){
			if($(this).scrollTop() > banner_height/2 - 52 && header.hasClass("default")){
				header.removeClass("default").addClass("filled");
			}else if($(this).scrollTop() <= banner_height/2 - 52 && header.hasClass("filled")){
				header.removeClass("filled").addClass("default");
			}
			$('aside').css('bottom', 'auto');
			//Скрытие баннера
			if($(this).scrollTop() > banner_height){
				over_scroll = true;
				$('.banner').height(0);
				$('body').addClass('banner_hide');
				$('html, body').scrollTop(0);
			}
			if (IsMobile === true) {
				$('aside').css({
					'position' : 'absolute',
					'bottom' : 'auto',
					'top' : 'auto'
				});
			}
		}else{
			var CurentMainWindow = $('.main').outerHeight();//$.cookie('mainWindow');
			var scroll = $(this).scrollTop(); // прокрутка 
			var pieceOfHeader = CurentMainWindow - (scroll + viewPort) + 52;
			var main_nav = $('.main_nav').outerHeight();
			if(IsMobile === false){
				$('aside').css('max-height', 'calc(100vh - 52px)');				
			}else{
				$('aside').css('top', '52px');
				$('aside').css('position', 'fixed');
			}
			if((scroll + viewPort) <= CurentMainWindow){
				// не доскролили до футера
				// $('aside').css('bottom', 0);
			}else{
				// Доскролили
				var pieceOfFooter = (scroll + viewPort) - CurentMainWindow - 52 + main_nav;				
				$('aside .catalog .second_nav').css('max-height', 'calc(100vh - 52px - '+(pieceOfFooter)+'px');				

				//Проверить моб версию

				// if(IsMobile === true){
				// 	$('aside').css('max-height', 'calc(100vh - 52px - '+(pieceOfFooter > 0?pieceOfFooter:0)+'px)');
				// }
				
			}
			changeFiltersBtnsPosition();
		}
	});
	// События для автосмены размера сайбара и его скролла 
	$(window).on("load", function(){
		if(over_scroll === true){
			resizeAsideScroll('load');
		}else if (IsMobile === true) {
			$('aside').css({
				'position' : 'absolute',
				'bottom' : 'auto',
				'top' : 'auto'	
			});
		}		
	});

	/*$('body').on('click', function(){
		if(over_scroll === true){
			resizeAsideScroll('click');
		}
	});*/
	$(window).resize(function(){
		if(over_scroll === true){
			resizeAsideScroll('show_more');
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
			$('aside').css('bottom', 'auto');
			if (IsMobile === true) {
				$('aside').css({
					'position' : 'absolute',
					'bottom' : 'auto',
					'top' : 'auto'
				});
			}
		}
	});

	$('.catalog_btn, #breadcrumbs .btn_js').on('click', function(){
		$('aside').css({
			'position' : 'fixed',
			'bottom' : '0',
			'top' : '52px'
		});
	});

	//Меню
	$('aside').on('click','.more_cat', function() {
		var lvl = $(this).closest('ul').data('lvl'),
			parent = $(this).closest('li'),
			parent_active = parent.hasClass('active');
		$(this).closest('ul').find('li').removeClass('active').find('ul').stop(true, true).slideUp();
			$(this).find('.material-icons').text('add');

		if(!parent_active){
			parent.addClass('active').find('> ul').stop(true, true).slideDown();
			$(this).find('.material-icons').text('remove');
		}

		$('.second_nav li:not(.active) .more_cat i').text('add');
	});

	//Кабинет
	//$('a.cabinet_btn').find('ul.mdl-js-ripple-effect').css('dispaly','block');
	$('mdl-menu__container').hover(
		function(){
			$(this).addClass('is-visible');
		},
		function(){
			$(this).removeClass('is-visible');
		}
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
		$('#filterButtons').removeClass('buttonsTop');
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
				$(this).removeClass('hidden');
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
		responsive: {
			320: {items: 1},
			727: {items: 3},
			950: {items: 5},
			1250: {items: 6},
			1600: {items: 8}
		},
		nav: true, // Show next and prev buttons
		navText: ['<svg class="arrow_left"><use xlink:href="images/slider_arrows.svg#arrow_left_tidy"></use></svg>',
						'<svg class="arrow_right"><use xlink:href="images/slider_arrows.svg#arrow_right_tidy"></use></svg>']
	});

	//Rating stars
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

	// Закрытие подложки и окон
	$('body').on('click', '.background_panel', function(){
		closeObject();
	});

	// Добавление кнопки Закрыть всем модальным окнам
	$('[data-type="modal"]').each(function(index, el){
		$(this).append('<a href="#" class="close_modal btn_js" data-name="'+$(this).attr('id')+'"><i class="material-icons mdl-cell--hide-phone mdl-cell--hide-tablet">close</i><i class="material-icons mdl-cell--hide-desktop">cancel</i></a>');
	});

	// Перемещение к выбраной картинке (Замена картинки для открытия в ориг размере) 
	$('.product_main_img').on('click', function(){
		/*var img_src = $(this).find('img').attr('src'),
			img_alt = $(this).find('img').attr('alt');
		$('#big_photo img').attr({
			src: img_src,
			alt: img_alt
		});
		$('#big_photo').css({
			// 'height': (viewport_height - header_outerheight)*0.9,
			'max-width': viewport_width*0.9
		});*/	

		images = [];

		$('#owl-product_mini_img_js .owl-item').each(function(){
			$(this).find('img');
			images.push($(this).find('img').attr('class'));
		});
		
		var current_image = 0;
		$.each(images, function(index, value){
			console.log("INDEX: " + index + " VALUE: " + value);
			if (value === 'act_img'){
				current_image = index;
			}
		});

		var carousel = $("#owl-product_mobile_img_js");
		carousel.owlCarousel();		
		carousel.trigger('to.owl.carousel', [current_image, 500]);
	});
	// Закрытие окна при клике на картинку
	$('#big_photo img').on('click', function(){
		closeObject();
	});

	// Открытие обьектов с подложкой
	$('body').on('click', '.btn_js', function(){
		var name = $(this).data('name');
		if(name !== undefined){
			openObject(name);
		}
	});
	// Закрытие модалок по клику на Esc
	$(document).keyup(function(e){
		if(e.keyCode == 27){
			closeObject();
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
		openObject('demand_chart');
	});

	// Открытие модального Графика
	/*$('#demand_chart').on('click', '.btn_js.save', function(){
		var parent =  $(this).closest('#demand_chart'),
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

	// Редактирование модального Графика
	/*$('a.update_exist').on('click', function(){
		var id_graphics = $(this).attr('id');
		ajax('product', 'SearchGraph', {'id_graphics': id_graphics}, 'html').done(function(data){
			console.log(data);

			if(data != null){
				$('#demand_chart .modal_container').html(data);
				componentHandler.upgradeDom();
				openObject('demand_chart');

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
		var moderation = 0;
		if($(this).hasClass('two')){
			moderation = 1;
		}
		var id_graphics = false;
		ModalGraph(id_graphics, moderation);
	});

	// Обработка примечания
	$('.note textarea').on('blur', function(){
		$(this).css({
			height: '30px'
		});
		// var id = $(this).closest('form.note').attr('data-note'),
		// 	note = $(this).val();
		// ajax('cart', "update_note",{"id_product": id, "note": note});
	});
	// Обработка примечания
	$('.add_cart_state input:radio').on('click', function(){
		var checked = false;
		if($(this.checked)){
			checked = true;
		}
		$(this).prop("checked", checked);
	});

	/* Обработчик данных из корзины */
	$('#quiz').on('click', '.to_step', function(e){
		e.preventDefault();
		var
			//target_step = $(this).data('step'),
			//current_step = $(this).closest('[class*="step_"]').data('step'),
			//summary = $('#quiz .summary_info'),
			//current = $('.step_'+current_step),
			//target = $('.step_'+target_step),
			//validate = false,
			i = 0,
			data = {
				validate: false,
				current_step: $(this).closest('[class*="step_"]').data('step'),
				target_step: $(this).data('step')
			},
			all = {
				summary: $('#quiz .summary_info'),
				current: $('.step_'+$(this).closest('[class*="step_"]').data('step')),
				target: $('.step_'+$(this).data('step'))
			};
		if(data.target_step == 1){
			// all.summary.removeClass('active');
			if(data.current_step == 2){
				// all.summary.find('.last_name').closest('.row').addClass('hidden');
				// all.summary.find('.first_name').closest('.row').addClass('hidden');
				// all.summary.find('.middle_name').closest('.row').addClass('hidden');
				// all.summary.removeClass('active');
				validateq(data);
			}
		}else if(data.target_step == 2){
			if(data.current_step == 1){
				var last_name = all.current.find('[name="last_name"]').val(),
					first_name = all.current.find('[name="first_name"]').val(),
					middle_name = all.current.find('[name="middle_name"]').val();
				if(last_name === ''){
					i++;
					$('#last_name').addClass('is-invalid');
				}
				if(first_name === ''){
					i++;
					$('#first_name').addClass('is-invalid');
				}
				if(middle_name === ''){
					i++;
					$('#middle_name').addClass('is-invalid');
				}
				if(i === 0){
					data.first_name = first_name;
					data.last_name = last_name;
					data.middle_name = middle_name;
					data.validate = true;
					validateq(data);
				}
			}else if(data.current_step == 3){
				// all.summary.find('.region').closest('.row').addClass('hidden');
				// all.summary.find('.city').closest('.row').addClass('hidden');
				validateq(data);
			}
		}else if(data.target_step == 3){
			if(data.current_step == 2){
				data.selected_region = all.current.find('#region').val();
				data.selected_city = all.current.find('#city').val();
					// all.target.find('span.client').text($('.first_name').text()+' '+$('.middle_name').text());

				// if(selected_region != 'Выбрать' && selected_city != 'Выбрать'){
				// 	all.summary.find('.region').text(selected_region).closest('.row').removeClass('hidden');
				// 	all.summary.find('.city').text(selected_city).closest('.row').removeClass('hidden');
				// 	$('.error_div').addClass('hidden');
				// }

				// if(selected_region == 'Выбрать'){
				// 	i++;
				// 	$('.error_div').removeClass('hidden').text("Выберите область");
				// } else if(selected_city == 'Выбрать'){
				// 	i++;
				// 	$('.error_div').removeClass('hidden').text("Выберите город");
				// }

				if(i === 0){
					

					// ajax('cart', 'update_info', data, 'html').done(function(response){
					// 	GetDeliveryService(selected_city+' ('+selected_region+')', $('input[name="service"]:checked').val());
					// 	Position($(this).closest('[data-type="modal"]'));
					// 	all.summary.find('.delivery_service').text(selected_region);
					// 	all.summary.find('.delivery_method').text(selected_city);
					// });
					data.validate = true;
					validateq(data);
				}
			}else if(data.current_step == 4){
				all.summary.find('.delivery_service').closest('.row').addClass('hidden');
				all.summary.find('.delivery_method').closest('.row').addClass('hidden');
				all.summary.find('.client_address').closest('.row').addClass('hidden');
				all.summary.find('.post_office_address').closest('.row').addClass('hidden');
				validateq(data);
			}
		}else if(data.target_step == 4){
			if(data.current_step == 3){
				data.id_delivery = all.current.find('#id_delivery').val();
				data.id_delivery_service = all.current.find('#id_delivery_service').val();
				data.delivery_department = all.current.find('#delivery_department').val();
				data.address = all.current.find('#address').val();
				console.log(data);

				if(typeof delivery_service !== 'undefined') {
					all.summary.find('.delivery_service').text(delivery_service).closest('.row').removeClass('hidden');
				}
				if(delivery_method != 'Выбрать'){
					all.summary.find('.delivery_method').text(delivery_method).closest('.row').removeClass('hidden');
				}


				if(delivery_method == 'Адресная доставка' && delivery_address !== '') {
					all.summary.find('.client_address').text(delivery_address).closest('.row').removeClass('hidden');
				}
				if(delivery_method == 'Забрать со склада' && selected_post_office != 'Выбрать отделение'){
					all.summary.find('.client_address').text(delivery_address).closest('.row').addClass('hidden');
					all.summary.find('.post_office_address').text(selected_post_office).closest('.row').removeClass('hidden');
				}
				if(delivery_method == 'Забрать со склада' && selected_post_office != 'Выбрать отделение' && delivery_address !== ''){
					$('#delivery_address').val('');
				}

				if(typeof delivery_service === 'undefined'){
					i++;
					$('.error_div').removeClass('hidden').text('Выберите службу доставки');
				}else if(delivery_method == 'Выбрать'){
					i++;
					$('.error_div').removeClass('hidden').text('Выберите способ доставки');
				}else if(delivery_method == 'Адресная доставка' && delivery_address === ''){
					i++;
					$('.error_div').addClass('hidden');
					$('#client_address').addClass('is-invalid');
				}else if(delivery_method == 'Забрать со склада' && selected_post_office == 'Выбрать отделение'){
					i++;
					$('.error_div').removeClass('hidden').text('Выберите отделение');
				}else {
					$('.error_div').addClass('hidden');
				}
				if(i === 0){
					data = {
						delivery_service: delivery_service,
						delivery_method: delivery_method,
						delivery_address: delivery_address,
						selected_post_office_id: selected_post_office_id
					};

					ajax('cart', 'update_info', data, 'html').done(function(response){
						all.summary.find('.delivery_service').text(delivery_service);
						all.summary.find('.delivery_method').text(delivery_method);
						data.validate = true;
						validateq(data);
					});
				}
			}
		}else if(data.target_step == 5){
			if(data.current_step == 4){

			}

			if(i === 0){
				data = {delivery_service: delivery_service, delivery_method: delivery_method};

				ajax('cart', 'update_info', data, 'text').done(function(response){
					data.validate = true;
					validateq(data);
				});
			}
		}
		function validateq(data){
			addLoadAnimation('#quiz');
			if(data.target_step > data.current_step && data.validate === true){
				ajax('quiz', 'complete_step', data).done(function(response){
					if(response == true){
						GetQuizAjax({reload: false, step: data.target_step});
					}
				});
			}else{
				GetQuizAjax({reload: false, step: data.target_step});
			}
		}
	});
	

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
		
	// $('#verification').on('click', 'label[for="choise_sms"]', function(){
	// 	console.log('chosen_sms');
	// 	$('#verification #recovery_email').closest('div').addClass('hidden');
	// 	$('#verification .verification_input_container').html('<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><label>Номер телефона</label><input class="mdl-textfield__input phone" name="value" type="text" id="recovery_phone" pattern="\+\d{2}\s\(\d{3}\)\s\d{3}\-\d{2}\-\d{2}\"><label class="mdl-textfield__label" for="recovery_phone"></label><span class="mdl-textfield__error"></span></div>');
	// 	$(".phone").mask("+38 (099) ?999-99-99");
	// 	componentHandler.upgradeDom();
	// });

	$('.verification_btn').attr('disabled', 'disabled');

	$('#verification').on('click', '[for="choise_current_pass"]', function(){
		$('.cur_passwd_container, .confirm_btn_js').removeClass('hidden');
		$('.verification_meth, .for_verification_code_js, .confirm_code_js, .send_code_js, .ver_info_js').addClass('hidden');
		$('.confirm_pass_js').removeClass('hidden');
		$('.error_msg_js').text('');
		componentHandler.upgradeDom();
	});
	$('#verification').on('click', '[for="choise_verification_code"]', function(){
		$('.verification_meth, .send_code_js').removeClass('hidden');
		$('.cur_passwd_container, .confirm_pass_js').addClass('hidden');
		$('.confirm_code_js').addClass('hidden');
		$('.error_msg_js').text('');
		componentHandler.upgradeDom();
	});
	$('[name="cur_passwd"]').change(function(event) {
		if($(this).val() == '') {
			$(this).closest('.mdl-textfield').addClass('is-invalid').find('.mdl-textfield__error').text('Чтобы продолжить введите Ваш текущий пароль');
		}else if($(this).val().length < 4) {
			$(this).closest('.mdl-textfield').addClass('is-invalid').find('.mdl-textfield__error').text('Введите корректный пароль');
		}
	});
	$('[name="verification_code"]').change(function(event) {
		if($(this).val() == '') {
			$(this).closest('.mdl-textfield').addClass('is-invalid').find('.mdl-textfield__error').text('Чтобы продолжить введите код подтверждения');
		}else if($(this).val().length != 4) {
			$(this).closest('.mdl-textfield').addClass('is-invalid').find('.mdl-textfield__error').text('Введите корректный код подтверждения');
		}
	});

	$('.send_code_js').click(function(event) {
		$('.for_verification_code_js').removeClass('hidden');
		$('.send_code_js').addClass('hidden');
		$('.confirm_code_js, .ver_info_js').removeClass('hidden');
		// $('.confirm_btn_js').removeClass('hidden').attr('disabled', 'disabled');
		var id_user = $('[name="id_user"]').val(),
			phone_num = $('.phone').val().replace(/[^\d]+/g, "");

			if(phone_num.length == 12){
				phone = phone_num;
			}else{
				console.log("Неверный формат номера телефона");
			}
		data = {id_user: id_user, phone: phone, method: 'sms'};
		console.log(data);
		// $('.confirm_btn_js').removeAttr('disabled');
		ajax('cabinet', 'AccessCode', data).done(function(response){
			$('.confirm_btn_js').removeAttr('disabled');			
		});
	});
	$('.confirm_pass_js').click(function(event) {
		var id_user = $('[name="id_user"]').val(),
			new_passwd = $('[name="new_passwd"]').val(),
			method = $('[name="verification"]:checked').data('value'),
			curr_pass = $('[name="cur_passwd"]').val();

		data = {id_user: id_user, new_passwd: new_passwd, curr_pass: curr_pass, method: method};
		if (!$('.cur_passwd').hasClass('is-invalid')) {
			console.log(data);
			ajax('cabinet', 'ChangePassword', data).done(function(resp){
				console.log(resp.success);
				if(!resp.success){
					$('.error_msg_js').text(resp.msg);
				}else{
					$('#verification').html('<div class="auth_ok tac"><i class="material-icons">check_circle</i></div><p class="info_text" style="min-width: 300px; text-align: center;">Пароль успешно изменен!</p><a href="#" class="close_modal btn_js" data-name="verification"><i class="material-icons mdl-cell--hide-phone mdl-cell--hide-tablet">close</i><i class="material-icons mdl-cell--hide-desktop">cancel</i></a>');					
				}
			});
		}
	});

	$('.confirm_code_js').click(function(event) {
		var id_user = $('[name="id_user"]').val(),
			new_passwd = $('[name="new_passwd"]').val(),
			method = $('[name="verification"]:checked').data('value'),
			code = $('[name="verification_code"]').val();
		data = {id_user: id_user, code: code, new_passwd: new_passwd, method: method};
		if (!$('.for_verification_code_js').hasClass('is-invalid')) {
			ajax('cabinet', 'ChangePassword', data).done(function(resp){
				console.log(resp);
				if(!resp.success){
					$('.error_msg_js').text(resp.msg);
				}else{
					$('#verification').html('<div class="auth_ok tac"><i class="material-icons">check_circle</i></div><p class="info_text" style="min-width: 300px; text-align: center;">Пароль успешно изменен!</p><a href="#" class="close_modal btn_js" data-name="verification"><i class="material-icons mdl-cell--hide-phone mdl-cell--hide-tablet">close</i><i class="material-icons mdl-cell--hide-desktop">cancel</i></a>');					
				}
			}).fail(function(response){
				alert('Ошибка!');
			});
		}
	});

	

	$(".phone").mask("+38 (099) ?999-99-99");

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
	});

	$('.delivery_type [data-value="2"]').on('click', function(){
		if($('.delivery_service input[name="service"]:checked')){
			$('.post_office').css('display', 'block');
			$('.delivery_address').css('display', 'none');

			GetDeliveryMethods($('.delivery_service input[name="service"]:checked').val(), $('#city_select .select_field').text());
		}
	});

	$('#quiz .mdl-button').on('click', function(e){
		e.preventDefault();
		return false;
	});

	$('#access_recovery').on('click', 'label[for="chosen_mail"]', function(){
		$('#access_recovery #recovery_email').closest('div').addClass('hidden');
		$('#access_recovery .input_container').html('<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><label>Email</label><input class="mdl-textfield__input" name="value" type="email" id="recovery_email"><label class="mdl-textfield__label" for="recovery_email"></label><span class="mdl-textfield__error"></span></div>');
		componentHandler.upgradeDom();
	});
	$('#access_recovery').on('click', 'label[for="chosen_sms"]', function(){
		$('#access_recovery #recovery_email').closest('div').addClass('hidden');
		$('#access_recovery .input_container').html('<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><label>Номер телефона</label><input class="mdl-textfield__input phone" name="value" type="text" id="recovery_phone" pattern="\+\d{2}\s\(\d{3}\)\s\d{3}\-\d{2}\-\d{2}\"><label class="mdl-textfield__label" for="recovery_phone"></label><span class="mdl-textfield__error"></span></div>');
		$(".phone").mask("+38 (099) ?999-99-99");
		componentHandler.upgradeDom();
	});
	$('#access_recovery').on('blur', 'input[type="email"]', function(){
		var email = $(this).val();
		if(email !== ''){
			// Поле email заполнено (здесь будем писать код валидации)
			var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
			if(pattern.test(email)){
				$(this).css({'color' : 'green'});
			} else {
				$(this).css({'color' : 'red'});
				$('.mdl-textfield__error').text('Введите Email правильно');
			}
		} else {
			// Поле email пустое, выводим предупреждающее сообщение
			$(this).css({'color' : 'red'});
			$('.mdl-textfield__error').text('Введите Email');
		}
	});
	$('#access_recovery').on('click', '#continue', function(e) {
		e.preventDefault();
		var parent = $(this).closest('[data-type="modal"]'),
			method = parent.find('[name="recovery_method"]:checked'),
			value;
		if(method.data('value') == "sms") {
			var phone = $('#access_recovery .phone').val().replace(/[^\d]+/g, "");
			if(phone.length == 12){
				value = phone;
			}else{
				console.log("error");
			}
		}
		if(method.data('value') == "email"){
			value = parent.find('[name="value"]').val();
		}

		data = {method: method.data('value'), value: value};
		addLoadAnimation('#access_recovery');
		ajax('auth', 'accessRecovery', data).done(function(response){
			removeLoadAnimation('#access_recovery');
			if (response.success) {
				parent.find('.password_recovery_container').html(response.content);
			}else{
				parent.find('.mdl-textfield').addClass('is-invalid').find('.mdl-textfield__error').text(response.msg);
			}
			componentHandler.upgradeDom();
		});
	});

	$('#access_recovery').on('keyup', '#passwd', function(event) {
		event.preventDefault();
		var passwd = $(this).val(),
			passconfirm = $('#access_recovery #passwdconfirm').val();
		ValidatePass(passwd, $(this));
		// $('.mdl-textfield #passwd').closest('#regs form .mdl-textfield').addClass('is-invalid');
		if(passconfirm !== ''){
			ValidatePassConfirm(passwd, passconfirm);
		}
	});

	$('#access_recovery').on('keyup', '#passwdconfirm', function(){
		var passwd = $('#access_recovery #passwd').val(),
			passconfirm = $(this).val();
		ValidatePassConfirm(passwd, passconfirm);
	});

	$('#access_recovery').on('click', '#restore', function(e){
		e.preventDefault();
		var parent = $(this).closest('[data-type="modal"]'),
			id_user = parent.find('[type="hidden"]').val(),
			code = parent.find('[name="code"]').val();			
		data = {id_user: id_user, code: code};
		addLoadAnimation('#access_recovery');
		ajax('auth', 'checkСode', data).done(function(response){
			removeLoadAnimation('#access_recovery');
			if (response.success) {
				parent.find('.password_recovery_container').html(response.content);
			}else{
				parent.find('[name="code"]').closest('.mdl-textfield').addClass('is-invalid').find('.mdl-textfield__error').text(response.msg);
			}
			componentHandler.upgradeDom();
		});
	});

	$('#access_recovery').on('click', '#confirm_btn', function(e) {
		e.preventDefault();
		$('#access_recovery .mdl-textfield__error').empty();
		// addLoadAnimation('#password_recovery');
		var parent = $(this).closest('[data-type="modal"]'),
			id_user = parent.find('[type="hidden"]').val(),
			passwd = parent.find('input[name="new_passwd"]'),
			confirm_passwd = parent.find('input[name="passwdconfirm"]').val();
		ValidatePass(passwd.val(), passwd);
		if(passwd.val().length >= 4 && confirm_passwd !== '' && !ValidatePassConfirm(passwd.val(), confirm_passwd)){
			data = {id_user: id_user, passwd: confirm_passwd};
			if(!parent.find('.mdl-textfield').hasClass('is-invalid')) {
				addLoadAnimation('#access_recovery');
				ajax('auth', 'accessConfirm', data).done(function(response){
					removeLoadAnimation('#access_recovery');
					console.log(response);
					if (response.success) {
						$('.cabinet_btn').removeClass('hidden');
						$('.login_btn').addClass('hidden');
						ajax('auth', 'GetUserProfile', false, 'html').done(function(data){							
							$('#user_profile').append('<img src="/images/noavatar.png"/>');
							$('.user_profile_js').html(data);
							$('.cabinet_btn').removeClass('hidden');
							$('.login_btn').addClass('hidden');
							// $('header .cart_item a.cart i').removeClass('mdl-badge');
							// $('.card .buy_block .btn_buy').find('.in_cart_js').addClass('hidden');
							// $('.card .buy_block .btn_buy').find('.buy_btn_js').removeClass('hidden');
						});
						parent.find('.password_recovery_container').html(response.content);
					}else{
						value.closest('.mdl-textfield').addClass('is-invalid').find('.mdl-textfield__error').text(response.msg);
					}
					componentHandler.upgradeDom();
				});
			}
		}
	});
	
//---
	$('#regpasswd').keyup(function(event) {
		event.preventDefault();
		var passwd = $(this).val(),
			passconfirm = $('#settings #passwdconfirm').val();
		ValidatePass(passwd, $(this));
		if(passconfirm !== ''){
			ValidatePassConfirm(passwd, passconfirm);
		}
	});
	$('#passwdconfirm').keyup(function(){
		var passwd = $('#settings #regpasswd').val(),
			passconfirm = $(this).val();
		ValidatePassConfirm(passwd, passconfirm);
	});
//---

	$('#passwd, #regpasswd, [name="passwdconfirm"]').focusout(function(e){
		e.preventDefault();
		$(this).closest('.mdl-textfield').find('.mdl-textfield__error').empty();
		// $('[name="passwdconfirm"]').closest('.mdl-textfield').find('.mdl-textfield__error').html('');
	});

	// Открыть Форму авторизации
	$('.login_btn').on('click', function(e){
		openObject('auth');		
		$('#auth #sign_in').show().removeClass('hidden');
		$('#auth #sign_up').hide().addClass('hidden');
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
	$('#auth').on('click', '.sign_in', function(e){
		e.preventDefault();
		addLoadAnimation('#sign_in');
		var form = $(this).closest('form'),
			email = form.find('input#email').val(),
			passwd = form.find('input#passwd').val();
		form.find('.error').fadeOut();
		e.preventDefault();
		
		// Проверка введенного телефона-логина
		var str = email.replace(/\D/g, "");
		var check_num = /^(38)?(\d{10})$/;
		if (check_num.test(str)) {
			if (str.length === 10){
				email = 38 + str;
			}else{
				email = str;
			}
		}

		ajax('auth', 'sign_in', {email: email, passwd: passwd}).done(function(data){
			var parent = $('.userContainer');
			removeLoadAnimation('#sign_in');			
			
			if(data.err != 1){
				if (over_scroll === true) {
					var page = $('.products_page'),
						id_category = current_id_category,
						start_page = parseInt(page.find('.paginator li.active').first().text()),
						current_page = parseInt(page.find('.paginator li.active').last().text()),
						next_page = current_page,
						shown_products = 0,
						skipped_products = 30*(start_page-1);
						// count = $(this).data('cnt');
					$('.show_more').append('<span class="load_more"></span>');
					addLoadAnimation('.products');
					var arr = {
						action: 'getmoreproducts_desctop',
						id_category: id_category,
						shown_products: shown_products,
						skipped_products: skipped_products
					};					
					if (current_controller === 'search' || current_controller === 'product'){
						location.reload();
					}else{
						UpdateProductsList(page, arr);
					}
				}else{
					/*page = $('.page_content_js');
					skipped_products = 0;
					id_category = 478;*/ // временно		
				}
				closeObject('auth');
				
				if (data.member.gid == 3) {
					$('#header_js .cart_item').addClass('hidden');
					removeFromCart();
				}

				ajax('auth', 'GetUserProfile', false, 'html').done(function(data){
					$('#user_profile').append('<img src="/images/noavatar.png"/>');
					$('.user_profile_js').html(data);

					$('.cabinet_btn').removeClass('hidden');
					$('.login_btn').addClass('hidden');

					$('#authorized').removeClass('hidden');
					$('.userContainer').removeClass('hidden');
					$('button[value="Неавторизован"]').addClass('hidden');
				});
				// parent.find('.user_name').text(data.member.name);
				// parent.find('.user_email').text(data.member.email);
				// parent.find('.user_contr').text(data.member.contragent.name_c);
				// parent.find('.user_contr_phones').text(data.member.contragent.phones);
				// parent.find('.user_promo').text(data.member.promo_code);
				// parent.find('.userChoiceFav').text('( '+data.member.favorites.length+' )');
				// parent.find('.userChoiceWait').text('( '+data.member.waiting_list.length+' )');parent.find('.user_name').text(data.member.name);
				if (current_controller === 'main'){
					location.reload();
				}
			}else{
				form.find('.error').text(data.msg).fadeIn();				
			}
		});
	});
	
	// Проверка надежности пароля
	$('#sign_up #passwd').keyup(function(){
		var passwd = $(this).val();
		var passconfirm = $('#sign_up #passwdconfirm').val();
		ValidatePass(passwd, $(this));
		/*$('.mdl-textfield #passwd').closest('#regs form .mdl-textfield').addClass('is-invalid');*/
		if(passconfirm !== ''){
			ValidatePassConfirm(passwd, passconfirm);
		}
	});
	
	/** Проверка подтверждения пароля на странице регистрации */
	$('#sign_up #passwdconfirm').keyup(function(){
		var passwd = $('#sign_up #passwd').val();
		var passconfirm = $(this).val();
		ValidatePassConfirm(passwd, passconfirm);
	});

	// Проверка формы регистрации
	$('#sign_up .sign_up').click(function(e){
		e.preventDefault();
		addLoadAnimation('#sign_up');
		var parent = $(this).closest('form'),
			fields = {};
		parent.find('.mdl-textfield__input').each(function(index, el) {
			fields[$(el).attr('name')] = $(el).val();
		});
		// var res = ValidateEmail(data, 1);
		ajax('auth', 'register', fields).done(function(data){
			if(data.err === 0){
				ajax('auth', 'GetUserProfile', false, 'html').done(function(data){
					$('#user_profile').append('<img src="/images/noavatar.png"/>');
					$('.user_profile_js').html(data);
					$('.cabinet_btn').removeClass('hidden');
					$('.login_btn').addClass('hidden');	
				});
				openObject('registerComplete');
			}else{
				$.each(data.errm, function(key, value) {
					// console.log(key);
					// $('[name="'+key+'"] + .mdl-textfield__error').append(value);
					$('[name="'+key+'"]').closest('.mdl-textfield').addClass('is-invalid').find('.mdl-textfield__error').html(value);
				});
			}
			removeLoadAnimation('#sign_up');
		});
	});

	// Отправка сообщения об ошибке
	$('.error_js').click(function(e){
		e.preventDefault();
		var parent = $(this).closest('form'),
			fields = {};
		parent.find('.mdl-textfield__input').each(function(index, el) {
			fields[$(el).attr('name')] = $(el).val();
		});
		console.log(fields);
		ajax('errors', 'error', fields).done(function(data){
			console.log(data);
		});
	});

	//Отправка данных (смета клиента)
	$('#estimate').on('click', function(){
		$('.estimate_info_js').html(''); // удаление предыдущего оповещения аякса
		$('#estimate div').each(function() { // удаление класса is-invalid со всех полей
			$('#estimate div').removeClass('is-invalid');
		});
	});

	$('.estimate_js').on('click', function(e){
		e.preventDefault();		
		var check = true;
		if ($('#estimate_phone').val() !== undefined) {
			// Проверка введенного телефона и имени
			var phone = $('#estimate_phone').val();
			var name = $('#estimate_name').val();
			var str = phone.replace(/\D/g, "");
			var check_num = /^(38)?(\d{10})$/;
			if (check_num.test(str)) {
				if (str.length === 10){
					phone = 38 + str;
				}else{
					phone = str;
				}
			}			
			if (name === '') {
				$('#estimate_name').closest('div').addClass('is-invalid');
				check = false;
			}else{
				if (phone.length !== 12 ) {
					$('#estimate_phone').closest('div').addClass('is-invalid');
					check = false;
				}else{
					$('#estimate_phone').val(phone);
					check = true;
				}
			}
		}
		if (check === true) {
			addLoadAnimation('#estimateLoad');
			ajax('product', 'AddEstimate', new FormData($(this).closest('form')[0]), 'json', true).done(function(data){
				$('.estimate_info_js').html(data.message);
				if (data.status === 1){
					$('.estimate_info_js').css('color', 'green');
					if ($('#estimate_phone').val() !== undefined) {
						ajax('auth', 'GetUserProfile', false, 'html').done(function(data){
							$('#user_profile').append('<img src="/images/noavatar.png"/>');
							$('.user_profile_js').html(data);
							$('.cabinet_btn').removeClass('hidden');
							$('.login_btn').addClass('hidden');
							$('#estimate_name, #estimate_phone').closest('div').remove();
							$('.estimate_info_js').append('<br>Пользователь создан автоматически при загрузке сметы');
						});
					}
				}else{
					$('.estimate_info_js').css('color', 'red');
				}
				removeLoadAnimation('#estimateLoad');
			});	
		}
	});

	if($('header .cart_item a.cart i').data('badge') === 0) {
		$('#cart .clear_cart').addClass('hidden');
	}

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

	$('.toBigPhoto').click(function(event) {
		$("#big_photo img").attr("src", $(this).data('original-photo'));//.css('height', $('#big_photo[data-type="modal"]').outerHeight() + "px");
	});

	/*Перенос модалок и панелей в main.tpl*/

	moveObjects();

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

	// Оповещение о прогнозируемой цене при наведение на кнопки смены количества товара
	$('body').on('mouseenter', 'button', function(){
		var currentQty = parseInt($(this).closest('.quantity').find('.qty_js').val());
		var minQty = $(this).closest('.quantity').find('.minQty').val();
		var currentDiscount = parseInt($.cookie('sum_range'));
		var constantPriceOpt = parseInt($(this).closest('.buy_block').find('.priceOpt3').val());
		var currentCartSum = parseInt($('.currentCartSum').html());
		var	itemProdQty =  parseInt($(this).closest('.buy_block').find('.itemProdQty').html());

		if ($(this).hasClass('btn_remove') === true) {
			if (currentQty == minQty) {
				var prevPrice = $(this).closest('.buy_block').find('.priceMopt' + currentDiscount).val();
				$('.tooltipForBtnRemove_js').removeClass('hidden').html("до " + currentQty + " шт. цена " + prevPrice + " грн.");
			}else{
				if ((currentDiscount === 0) && (currentCartSum - constantPriceOpt <= 10000)){
					$('.tooltipForBtnRemove_js').removeClass('hidden').html("до " + currentQty + " шт. изменит % скидки");
				}
				if ((currentDiscount === 1) && (currentCartSum - constantPriceOpt <= 3000)){
					$('.tooltipForBtnRemove_js').removeClass('hidden').html("до " + currentQty + " шт. изменит % скидки");
				}
			}
		}else{
			if ((currentQty + itemProdQty) == minQty) {
				var nextPrice = $(this).closest('.buy_block').find('.priceOpt' + currentDiscount).val();
				$('.tooltipForBtnAdd_js').removeClass('hidden').html("больше " + minQty + " шт. цена " + nextPrice + " грн.");
			}else{
				if ((currentDiscount === 1) && (currentCartSum + constantPriceOpt >= 10000)){
					$('.tooltipForBtnAdd_js').removeClass('hidden').html("больше " + currentQty + " шт. изменит % скидки");
				}
				if ((currentDiscount === 2) && (currentCartSum + constantPriceOpt >= 3000)){
					$('.tooltipForBtnAdd_js').removeClass('hidden').html("больше " + currentQty + " шт. изменит % скидки");
				}
				if ((currentDiscount === 3) && (currentCartSum + constantPriceOpt >= 500)){
					$('.tooltipForBtnAdd_js').removeClass('hidden').html("больше " + currentQty + " шт. изменит % скидки");
				}
			}
		}
	}).on('mouseleave', 'button', function(){
		$('.tooltipForBtnAdd_js').addClass('hidden');
		$('.tooltipForBtnRemove_js').addClass('hidden');
	});	

	// Переключение сегментов при переходе по кнопке из страниц "Снабжение предприятий" и тд.
	$(".to_org_catalog_btn_js").on('click', function(){
		$.cookie('Segmentation', 1, { path: '/'});
	});
	$(".to_magaz_catalog_btn_js").on('click', function(){
		$.cookie('Segmentation', 2, { path: '/'});
	});


	// Блок кода для выделения ошибок на канвасе
	var temp = false;
	$('.err_msg_as_knob_js').click(function(event){
		if ($('.err_msg_as').hasClass('shown')) {
			$('.err_msg_as_title i').css('transform', 'rotate(0deg)');
			if ($(document).outerWidth() < 450) {
				$('.err_msg_as').removeClass('shown').css('top', '100%');
			}else{
				$('.err_msg_as').removeClass('shown').css('top', 'calc(100% - 34px)');
			}
		}else{
			$('.err_msg_as_title i').css('transform', 'rotate(-180deg)');
			$('.err_msg_as_form').find('textarea').focus();
			$('.err_msg_as_js').css('border-color', '#FF865F');
			$('.err_msg_as').css('background-color', '#fff').addClass('shown').css('top', 'calc(100% - '+$('.err_msg_as').outerHeight()+'px)');
		}
		if(!temp){
			temp = true;
			event.preventDefault();
			$('#err_canvas').attr({
				'width': $(window).outerWidth(),
				'height': $('header').outerHeight() + $('section.main').outerHeight() + $('footer').outerHeight()				
			});

			$('.screen_btn_js').removeClass('screen_btn_js').addClass('clicked_js').addClass('is-checked');

			$('.err_msg_as_title i').css('transform', 'rotate(0deg)');
			
			if ($(document).outerWidth() < 450) {
				$('.err_msg_as').removeClass('shown').css('top', '100%');
				$('.err_msg_as_form .mdl-textfield').css('height', 'calc(100vh - 345px)');
			}else{
				$('.err_msg_as').removeClass('shown').css('top', 'calc(100% - 34px)');
			}
				

			var detachEl = $('.err_msg_as_js').detach();
			var detachSnack = $('#snackbar').detach();
			if ($(document).outerWidth() < 450){
				$('.waiting_block_for_img_canvas_js').css('top', '0');
				$('#header_js').css('top', '52px');
			}else{
				$('.waiting_block_for_img_canvas_js').css('top', '15px');
			}

			html2canvas(document.body, {
				onrendered: function(canvas){
					canvas.id = 'canvasImg';

					var url = canvas.toDataURL("image/jpeg");
					// window.location = canvas.toDataURL();

					$('.err_msg_as_wrap').css('display', 'none');
					$('.err_msg_as_wrap').append(detachEl);
					$('.modals').append(detachSnack);
					// Находим элемент <img>
					var imageCopy = document.getElementById("savedImageCopy");
				
					// Отображаем данные холста в элементе <img>
					imageCopy.src = canvas.toDataURL();
					
					// Показываем элемент <div>, делая изображение видимым
					var imageContainer = document.getElementById("savedCopyContainer");
					imageContainer.style.display = "block";

					$('.err_msg_as_wrap').css('display', 'block');
					if ($(document).outerWidth() < 450) {
						$('.waiting_block_for_img_canvas_js').css('top', '-52px');
						$('#header_js').css('top', '0');
					}else{
						$('.waiting_block_for_img_canvas_js').css('top', '-52px');
					}

					$('.err_msg_as_title i').css('transform', 'rotate(180deg)');
					$('.err_msg_as').css('background-color', '#fff').addClass('shown').css('top', 'calc(100% - '+$('.err_msg_as').outerHeight()+'px)');

					$('#err_canvas').attr({'width':'20','height':'20'});
				}
			});
		}
	});

	$('body').on('click', '.clicked_js', function(e){
		e.preventDefault();
		temp = true;
		closeObject('big_photo');
		$(this).addClass('screen_btn_js').removeClass('is-checked').removeClass('clicked_js');
		$('#savedCopyContainer').css('display', 'none');
		if ($(document).outerWidth() < 450){
			$('.err_msg_as_form .mdl-textfield').css('height', 'calc(100vh - 145px)');
		}
		$('.err_msg_as').css('background-color', '#fff').addClass('shown').css('top', 'calc(100% - '+$('.err_msg_as').outerHeight()+'px)');
		$('#savedImageCopy').attr('src', '');
		$('#err_canvas').attr({'width':'20','height':'20'});
	});

	$('body').on('click', '.screen_btn_js', function(event){
		event.preventDefault();
		temp = true;
				$('#err_canvas').attr({
			'width': $(window).outerWidth(),
			'height': $('header').outerHeight() + $('section.main').outerHeight() + $('footer').outerHeight()			
		});

		$(this).removeClass('screen_btn_js').addClass('clicked_js').addClass('is-checked');
		
		$('.err_msg_as').removeClass('shown').css('top', 'calc(100% - 34px)');

		var detachEl = $('.err_msg_as_js').detach();
		var detachSnack = $('#snackbar').detach();
		// $('.waiting_block_for_img_canvas_js').removeClass('hidden');
		if ($(document).outerWidth() < 450){
			$('.waiting_block_for_img_canvas_js').css('top', '0');
			$('#header_js').css('top', '52px');
		}else{
			$('.waiting_block_for_img_canvas_js').css('top', '15px');
		}
		
		html2canvas(document.body, {
			onrendered: function(canvas){
				canvas.id = 'canvasImg';

				var url = canvas.toDataURL("image/jpeg");
				// window.location = canvas.toDataURL();

				$('.err_msg_as_wrap').css('display', 'none');
				$('.err_msg_as_wrap').append(detachEl);
				$('.modals').append(detachSnack);
				// Находим элемент <img>
				var imageCopy = document.getElementById("savedImageCopy");
			
				// Отображаем данные холста в элементе <img>
				imageCopy.src = canvas.toDataURL();
				
				// Показываем элемент <div>, делая изображение видимым
				var imageContainer = document.getElementById("savedCopyContainer");
				imageContainer.style.display = "block";

				$('.err_msg_as_wrap').css('display', 'block');
				// $('.waiting_block_for_img_canvas_js').addClass('hidden');
				if ($(document).outerWidth() < 450){
					$('.waiting_block_for_img_canvas_js').css('top', '-52px');
					$('#header_js').css('top', '0');
					$('.err_msg_as_form .mdl-textfield').css('height', 'calc(100vh - 345px)');
				}else{
					$('.waiting_block_for_img_canvas_js').css('top', '-52px');
				}
				$('.err_msg_as_title i').css('transform', 'rotate(180deg)');
				$('.err_msg_as').css('background-color', '#fff').addClass('shown').css('top', 'calc(100% - '+$('.err_msg_as').outerHeight()+'px)');

				$('#err_canvas').attr({'width':'20','height':'20'});
			}
		});
	});

	$('.go_to_canvas_toolbar_js').click(function(event){
		closeObject('big_photo');
		$('.err_msg_as_title i').css('transform', 'rotate(0deg)');		
		$('.err_msg_as').removeClass('shown').css('top', 'calc(100% - 34px)');
		$('.canvas_toolbar').css('display', 'block');
		$('#err_canvas').attr({
			'width': $(window).outerWidth(),
			'height': $('header').outerHeight() + $('section.main').outerHeight() + $('footer').outerHeight()			
		});
	});

	$('body').on('click', '.problem_area_js', function(){
		var color = 'yellow',
			tool_type = 'rect';
		init(color, tool_type);
	});
	$('body').on('click', '.confidential_js', function(){
		var color = 'black',
			tool_type = 'fillrect';
		init(color, tool_type);
	});
	$('body').on('click', '.pencil_for_canvas_js', function(){
		var color = 'red',
			tool_type = 'pencil';
		init(color, tool_type);
	});
	$('body').on('click', '.eraser_for_canvas_js', function(){
		var color = '#fff',
			tool_type = 'eraser';
		init(color, tool_type);
	});
	$('body').on('click', '.canvasClear_js', function(event){
		clear_canvas();
	});

	$('body').on('click', '.close_canvas_toolbar_js', function(event){
		$('.canvas_toolbar').css('display', 'none');
		$('#err_canvas').attr({'width':'20','height':'20'});
		clear_canvas();
	});

	$('body').on('click', '.img_zoom_js', function(event){
		$('.err_msg_as_title i').css('transform', 'rotate(0deg)');
		$('.err_msg_as').removeClass('shown').css('top', 'calc(100% - 34px)');
		$('#err_canvas').attr({'width':'20','height':'20'});
		var src = $('#savedImageCopy').attr('src');
		$('#big_photo').css({
			'overflow': 'auto',
			'overflow-x': 'hidden',
			'padding': '2em'
		});
		$('#big_photo img').attr('src', src).css('width', '100%');
		openObject('big_photo');
	});

	$('body').on('click', '.canvasReady_js', function(event){
		$('.canvas_toolbar').css('display', 'none');
		var detachElement = $('.err_msg_as_js').detach();
		var detachSnack = $('#snackbar').detach();
		if ($(document).outerWidth() < 450){
			$('.waiting_block_for_img_canvas_js').css('top', '0');
			$('#header_js').css('top', '52px');
		}else{
			$('.waiting_block_for_img_canvas_js').css('top', '15px');
		}

		html2canvas(document.body, {
			onrendered: function(canvas){
				var url = canvas.toDataURL("image/jpeg");
				// window.location = canvas.toDataURL();

				$('.err_msg_as_wrap').css('display', 'none');
				$('.err_msg_as_wrap').append(detachElement);
				$('.modals').append(detachSnack);
				// Находим элемент <img>
				var imageCopy = document.getElementById("savedImageCopy");
			
				// Отображаем данные холста в элементе <img>
				imageCopy.src = canvas.toDataURL();
				
				// Показываем элемент <div>, делая изображение видимым
				var imageContainer = document.getElementById("savedCopyContainer");
				imageContainer.style.display = "block";
				$('#savedCopyContainer').css('border-color', '#FF865F');

				$('#err_canvas').attr({'width':'20','height':'20'});
				
				$('.err_msg_as_wrap').css('display', 'block');
				if ($(document).outerWidth() < 450) {
					$('.waiting_block_for_img_canvas_js').css('top', '-52px');
					$('#header_js').css('top', '0');
				}else{
					$('.waiting_block_for_img_canvas_js').css('top', '-52px');
				}
				$('.err_msg_as_title i').css('transform', 'rotate(180deg)');
				$('.err_msg_as').css('background-color', '#fff').addClass('shown').css('top', 'calc(100% - '+$('.err_msg_as').outerHeight()+'px)');

				clear_canvas();
			}
		});
	});

	$('.err_msg_as_send_js').click(function(event) {
		var err_msg = $('textarea[name="errcomment"]').val(),
			img_src = $('#savedImageCopy').attr('src');
		var data = {'err_msg': err_msg, 'img_src': img_src };

		ajax('errors', 'error', data).done(function(data){
			if (data.status != 3) {
				$('textarea[name="errcomment"] + label').css('color', 'rgba(0, 0, 0, .26)');
				$('textarea[name="errcomment"]').val('').closest('div').removeClass('is-dirty');
				$('#savedCopyContainer').css('display', 'none');
				$('.err_msg_as').css('background-color', '#fff').addClass('shown').css('top', 'calc(100% - '+$('.err_msg_as').outerHeight()+'px)');
				$('#savedImageCopy').attr('src', '');
				$('.err_msg_as').removeClass('shown').css('top', 'calc(100% - 34px)');
				$('.clicked_js').addClass('screen_btn_js').removeClass('clicked_js').removeClass('is-checked');
				componentHandler.upgradeDom();
			}else{
				$('textarea[name="errcomment"] + label').css('color', '#ff0000');
			}
			var text = {message: data.message};
			var snackbarContainer = document.querySelector('#snackbar');
			snackbarContainer.MaterialSnackbar.showSnackbar(text);
		}).fail(function(data){
			console.log('Сообщение об ошибке не отправлено');
		});
	});

	$(document).scroll(function(event) {
		if ($(document).scrollTop() >= $(window).outerHeight()) {
			$('.go_up_js').css('bottom', '2em');
		}else{
			$('.go_up_js').css('bottom', '-3em');
		}
	});

	$('.go_up_js').click(function(event) {
		$('html, body').animate({
			scrollTop: 0
		}, 1000, "easeInOutCubic");
	});
});