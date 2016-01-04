function GetCartAjax(){
	if($('#cart').hasClass('opened')){
		closeObject('cart');
	}else{
		$.ajax({
			url: URL_base+'cart'
		}).done(function(data){
			var res = data.match(/<!-- CART -->([\s\S]*)\<!-- END CART -->/);
			$('#cart > .modal_container').html(res[1]);
			openObject('cart');
		});
	}
}

// Change product view
function ChangeView(view){
	if(view == 'list'){
		$('.prod_structure span.list').removeClass('disabled');
		$('#view_block_js').removeClass('module_view').addClass('list_view');
		$('#view_block_js .col-md-4').removeClass().addClass('col-md-12 clearfix');
		$('.prod_structure span.module').addClass('disabled');
	}else if(view == 'module'){
		$('.prod_structure span.module').removeClass('disabled');
		$('#view_block_js').removeClass('list_view').addClass('module_view');
		$('#view_block_js .col-md-12').removeClass().addClass('col-lg-3 col-md-4 col-sm-6 col-xs-12 clearfix');
		$('.prod_structure span.list').addClass('disabled');
	}
	ListenPhotoHover();
	document.cookie="product_view="+view+"; path=/";
}

// Previw Sliders
function ListenPhotoHover(){
	preview = $('.list_view .preview');
	previewOwl = preview.find('#owl-product_slide_js');
	previewDownOwl = preview.find('#owl-product_slideDown_js');
	$('.product_photo').on('mouseover', function(){
		if($('#view_block_js').hasClass('list_view')){
			if($(this).hasClass('hovered')){
			}else{
				showPreview(1);
				// console.log('enter');
				$(this).addClass('hovered');
				// console.log('hover');
				rebuildPreview($(this));
			}
		}
	}).on('mouseleave', function(e){
		if($('#view_block_js').hasClass('list_view')){
			var mp = mousePos(e),
				obj = $(this),
				obj2 = $('.product_photo.hovered');
			// console.log(mp.x+'x'+mp.y);
			// console.log(preview.offset().left+'x'+preview.offset().top);
			// console.log(parseFloat(preview.offset().left+preview.width())+'x'+parseFloat(preview.offset().top+preview.height()));
			if((mp.x >= preview.offset().left && mp.x <= preview.offset().left+preview.width() && mp.y >= preview.offset().top && mp.y <= preview.offset().top+preview.height())
				|| (obj.hasClass('hovered') && mp.x >= obj.offset().left && mp.x <= obj.offset().left+obj.width() && mp.y >= obj.offset().top && mp.y <= obj.offset().top+obj.height())){
				// console.log('hover2');
			}else{
				// console.log('hide');
				hidePreview();
				obj.removeClass('hovered');
			}
		}
		return;
	});
	preview.on('mouseleave', function(e){
		if($('#view_block_js').hasClass('list_view')){
			mp = mousePos(e);
			obj = $('.product_photo.hovered');
			if(obj.hasClass('hovered') && mp.x >= obj.offset().left && mp.x <= obj.offset().left+obj.width() && mp.y >= obj.offset().top && mp.y <= obj.offset().top+obj.height()){
				// console.log('hovered_back');
			}else{
				// console.log('hide2');
				hidePreview();
				obj.removeClass('hovered');
			}
		}
	});
}

function hidePreview(){
	preview.hide().addClass('ajax_loading');
	if(previewOwl.data('owlCarousel')){
		previewOwl.data('owlCarousel').destroy();
	}
	if(previewDownOwl.data('owlCarousel')){
		previewDownOwl.data('owlCarousel').destroy();
	}
}

function rebuildPreview(obj){
	var position = obj.offset(),
		positionProd = $('#view_block_js').offset(),
		id_product = obj.closest('.product_section').find('.product_buy').attr('data-idproduct');

	// Calculating position of preview window
	var viewportWidth = $(window).width(),
		viewportHeight = $(window).height(),
		pos = getScrollWindow(),
		correctionBottom = 0,
		correctionTop = 0,
		marginBottom = 15,
		marginTop = 15;
	if(pos > 50){
		marginTop += $('header').height();
	}
	if(pos + viewportHeight < position.top + preview.height()/2 + obj.height()/2 + marginBottom){
		// console.log('overflow Bottom');
		correctionBottom = position.top + preview.height()/2 + obj.height()/2 - (pos+viewportHeight) + marginBottom;
	}else if(pos > position.top - preview.height()/2 + obj.height()/2 - marginTop){
		// console.log('overflow Top');
		correctionTop =  position.top - preview.height()/2 + obj.height()/2 - pos - marginTop;
	}
	preview.css({
		top: position.top - positionProd.top - preview.height()/2 + obj.height()/2 - correctionBottom - correctionTop,
		left: 100
	});
	if(position.top - preview.offset().top + obj.height()/2 + preview.find('.triangle').height() > preview.height() ){
		preview.css('border-radius', '5px 5px 5px 0').find('.triangle').css({
			top: '50%',
			left: 20
		});
	}else if(preview.offset().top > position.top + obj.height()/2 - preview.find('.triangle').height()){
		preview.css('border-radius', '0 5px 5px 5px').find('.triangle').css({
			top: '50%',
			left: 20
		});
	}else{
		preview.css('border-radius', '5px').find('.triangle').css({
			top: position.top - preview.offset().top + obj.height()/2,
			left: -7
		});
	}
	// Sending ajax for collectiong data about hovered product
	if(obj.hasClass('hovered')){
		$.ajax({
			url: URL_base+'ajaxproduct',
			type: "POST",
			cache: false,
			dataType : "json",
			data: {
				"action": 'get_array_product',
				"id_product": id_product
			}
		}).done(function(data){
			previewOwl.empty();
			previewDownOwl.empty();
			if(data.images != false){
				$.each(data.images, function(index, el) {
					var img_medium = el.src.replace("/original/", "/medium/");
						img_thumb = el.src.replace("/original/", "/thumb/");
					previewOwl.append('<div class="item"><img src="'+img_medium+'" alt="'+data.name+'"></div>');
					previewDownOwl.append('<div class="item"><img src="'+img_thumb+'" alt="'+data.name+'"></div>');
				});
			}else{
				for(var i = 1; i <= 3; i++){
					var img = eval('data.img_'+i).replace("/image/", "/image/500/");
					if(img != ''){
						previewOwl.append('<div class="item"><img src="'+img+'" alt="'+data.name+'"></div>');
						previewDownOwl.append('<div class="item"><img src="'+img+'" alt="'+data.name+'"></div>');
					}
				};
			}
			showPreview(0);
			previewDownOwl.find('.owl-item').click(function(){
				var position = $(this).index();
				previewOwl.data('owlCarousel').goTo(position);
			});
			//Заполнение Preview
			preview.find('.preview_info h4').html('<a href="/product/'+data.id_product+'/'+data.translit+'/">'+data.name+'</a>');
			preview.find('.product_article span').html(data.art);
			preview.find('.product_description').html(data.descr.replace(/<[^>]+>/g,''));
			preview.find('.all_specifications').attr('href', '/product/'+data.id_product+'/'+data.translit+'/#tabs-1');
			preview.find('.preview_favorites').attr('data-idfavorite', data.id_product);
			preview.find('.favorite').html(data.favorite);
			preview.find('.preview_favorites a').html(data.favorite_descr);
			if(data.favorite == 'favorites'){
				preview.find('.preview_favorites').attr('title', 'Товар находится в избранных');
				preview.find('.preview_favorites a').attr('href', '/cabinet/favorites/');
			}else{
				preview.find('.preview_favorites').attr('title', 'Добавить товар в избранное');
				preview.find('.preview_favorites a').attr('href', '#');
			}
			preview.find('.preview_follprice p a').html(data.waiting_list_descr);
			if(data.waiting_list == 'in_list'){
				preview.find('.preview_follprice p').removeClass('add_waitinglist').attr('title', 'Товар находится в списке ожидания');
				preview.find('.preview_follprice p a').attr('href', '/cabinet/waitinglist/');
			}else{
				preview.find('.preview_follprice p').addClass('add_waitinglist').attr('title', 'Добавить товар в список ожидания');
				preview.find('.preview_follprice p a').attr('href', '#');
			}
			preview.find('.rating').attr({
				href: '/product/'+data.id_product+'/'+data.translit+'/#tabs-2',
				title: data.rating_title
			});
			preview.find('.rating_stars').html(data.rating_stars);
			preview.find('.comments').html(data.comments_count);
			$('.preview_follprice').attr('data-follprice', data.id_product);
			preview.find('.vk').attr('href', 'http://vk.com/share.php?url=/product/'+data.id_product+'/'+data.translit);
			preview.find('.ok').attr('href', 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=/product/'+data.id_product+'/'+data.translit);
			preview.find('.ggl').attr('href', 'https://plus.google.com/share?url=/product/'+data.id_product+'/'+data.translit);
			preview.find('.fb').attr('href', 'http://www.facebook.com/sharer.php?u=/product/'+data.id_product+'/'+data.translit+'&t='+data.name);
			preview.find('.tw').attr('href', 'http://twitter.com/home?status='+data.name+'+-+/product/'+data.id_product+'/'+data.translit);
			preview.find('.product_buy').attr('data-idproduct', data.id_product);
			if(data.cart_control == 1){
				preview.find('.buy_btn_js').addClass('hidden');
				preview.find('.in_cart_js').removeClass('hidden');
			}else{
				preview.find('.buy_btn_js').removeClass('hidden');
				preview.find('.in_cart_js').addClass('hidden');
			}
			preview.find('.qty_js').val(data.qty_value);
			if(data.actual_price == 0 && data.other_price == 0 && data.visible != 0){
				if (data.actual_price == 0 && data.other_price == 0) {
					preview.find('.active_price').hide();
					preview.find('.other_price').hide();
					preview.find('.buy_buttons').hide();
					preview.find('.buy_btn_block button,.buy_btn_block a').hide();
					preview.find('.buy_btn_block .not_available').show();
				}else{
					preview.find('.buy_buttons').hide();
					preview.find('.buy_btn_block button,.buy_btn_block a').hide();
					preview.find('.buy_btn_block .not_available').show();
				}
			}else{
				preview.find('.active_price').show();
				preview.find('.other_price').show();
				preview.find('.buy_buttons').show();
				preview.find('.buy_btn_block button,.buy_btn_block a').show();
				preview.find('.buy_btn_block .not_available').hide();
			};
			preview.find('.active_price .price_js').html(data.actual_price);
			preview.find('.other_price .price_js').html(data.other_price);
			preview.find('.other_price .mode_js').html('до');
			preview.find('.other_price .units_js').text(data.other_price_descr);
			preview.find('.qty_descr').text(data.qty_descr);
			preview.find('.info_delivery').attr('href', '/product/'+data.id_product+'/'+data.translit+'/#tabs-4');
			$('.enter_mail').hide();
			// console.log(data);
		});
	}else{
		preview.hide();
	}
}
/** Определение расстояния прокрутки страницы */
function getScrollWindow() {
	var html = document.documentElement;
	var body = document.body;
	var top = html.scrollTop || body && body.scrollTop || 0;
	top -= html.clientTop;
	return top;
}
function changeToTop(pos){
	var totop = $('#toTop');
	if(pos > $('html').height()/8){
		if(totop.hasClass('visible') == false){
			totop.addClass('visible');
		}
	}else{
		if(totop.hasClass('visible')){
			totop.removeClass('visible');
		}
	}
}

function showPreview(ajax){
	if(ajax == 0){
		previewOwl.owlCarousel({
			singleItem: true,
			lazyLoad: true,
			lazyFollow: false
		});
		previewDownOwl.owlCarousel({
			items: 4,
			itemsDesktop: [1199,3],
			itemsDesktopSmall: [979,3],
			navigation: true, // Show next and prev buttons
			navigationText: ['<span class="icon-nav">arrow_left</span>', '<span class="icon-nav">arrow_right</span>']
		});
		setTimeout(function(){
			preview.removeClass('ajax_loading');
		}, 200);
	}else{
		preview.show();
	}
}

// get mouse position
function mousePos(e){
	var X = e.pageX; // положения по оси X
	var Y = e.pageY; // положения по оси Y
	return {"x":X, "y":Y}
}

/* Смена отображаемой цены */
function ChangePriceRange(id, sum){
	document.cookie="sum_range="+id+"; path=/";
	document.cookie="manual=1; path=/";
	$('li.sum_range').removeClass('active');
	$('li.sum_range_'+id).addClass('active');
	sum = 'Еще заказать на '+sum;
	$('.order_balance').text(sum);

	//console.log(sum);

	// setTimeout(function(){
	//  $('.product_buy .active_price').stop(true,true).css({
	//      "background-color": "#97FF99"
	//      //"color": "black"
	//  }).delay(1000).animate({
	//      "background-color": "transparent"
	//      //"color": "red"
	//  }, 3000);

	// },300);
}

function openObject(id){
	var object = $('#'+id),
		type = object.data('type');
	if($('body').hasClass('active_bg')){
		$('.opened:not([id="'+object.attr('id')+'"])').each(function(index, el) {
			closeObject($(this).attr('id'));
		});
	}
	if(object.hasClass('opened') && type != "search"){
		closeObject(object.attr('id'));
		DeactivateBG();
	}else{
		if(type == 'modal'){
			object.find('.modal_container').css({
				'max-height': $(window)*0.8
			});
			Position(object.addClass('opened'));
		}else{
			object.addClass('opened');
		}
		ActivateBG();
	}
}

function closeObject(id){
	if(id == undefined){
		$('.opened').each(function(index, el) {
			closeObject($(this).attr('id'));
		});
	}else{
		$('#'+id).removeClass('opened');
		if(id == 'phone_menu'){
			$('[data-name="phone_menu"]').html('menu');
		};
	}
	DeactivateBG();
}
function Position(object){
	object.css({
		'top': ($(window).height() + 52 - object.height())/2,
		'right': ($(window).width() - object.width())/2
	});
}

//Активация подложки
function ActivateBG(){
	$('body').addClass('active_bg');
}
//Деактивация подложки
function DeactivateBG(){
	$('body').removeClass('active_bg');
}

//Закрытие Панели мобильного меню
function closePanel(){
	$('.menu').html('menu');
	$('.panel').slideUp();
}

// /*MODAL WINDOW*/

// // Вызов модального окна
// function openModal(target){
// 	$('body').addClass('active_modal');
// 	$('#'+target+'.modal_hidden').removeClass('modal_hidden').addClass('modal_opened');
// }
// // Закрытие модального окна
// function closeModal(){
// 	$('.modal_opened').removeClass('modal_opened').addClass('modal_hidden');
// 	$('body').removeClass('active_modal');
// }

//Установка выбранного рейтинга
function changestars(rating){
	$('.set_rating').each(function(){
		var star = $(this).next('i');
		if(parseInt($(this).val()) <= parseInt(rating)){
			star.text('star');
		}else{
			star.text('star_border');
		}
	});
// Выбор области (региона)
function GetRegions(){
	// console.log('23124123');
	// $.post(URL_base+'ajax', { name: "John", time: "2pm" } );
	$.ajax({
		type: "post",
		url: URL_base+'ajax',
		cache: false,
		dataType: "json",
		processData: true,
		data: ({
			target: 'regions',
			action: 'GetRegionsList'
		}),
	}).done(function(data){
		var str = data.map(function(elem){
			return '<li class="mdl-menu__item" data-value="'+elem.id_city+'">'+elem.region+'</li>';
		}).join('');
		$('[for="region_select"]').html(str);
	});
}