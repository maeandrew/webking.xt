// Получение корзины
function GetCartAjax(){
	ajax('cart', 'GetCart', false, 'html').done(function(data){
		//console.log(data);
		$('#cart > .modal_container').html(data);
		openObject('cart');
	});
	// if($('#cart').hasClass('opened')){
	// 	closeObject('cart');
	// }else{
	// 	$.ajax({
	// 		url: URL_base+'cart'
	// 	}).done(function(data){
	// 		var res = data.match(/<!-- CART -->([\s\S]*)\<!-- END CART -->/);
	// 		$('#cart > .modal_container').html(res[1]);
	// 		openObject('cart');
	// 	});
	// }
}

// Получение списка товаров в кабинете
function GetCabProdAjax(id_order){
	ajax('cabinet', 'GetProdList', {'id_order': id_order}, 'html').done(function(data){
		//console.log(data);
		$('.mdl-tabs__panel > #products').html(data);
	});
}

// Получение списка товаров по каждомк заказу в кабинете совместныйх покупок
function GetCabCoopProdAjax(id_cart){
	ajax('cabinet', 'GetProdListForCart', {'id_cart': id_cart}, 'html').done(function(data){
		//console.log(data);
		$('#products_cart').html(data);
	});
}
function ModalGraph(id_graphics){
	ajax('product', 'OpenModalGraph').done(function(data){
		$('#graph').html(data);
		componentHandler.upgradeDom();

		if(id_graphics){
			//console.log(id_graphics);
				//$('a').on('click', function(){
				//var id_graphics = $(this).attr('id');
				ajax('product', 'SearchGraph', {'id_graphics': id_graphics}, 'html').done(function(data){
					if(data != null){
						console.log(data);
						$('#graph').html(data);
						componentHandler.upgradeDom();
						openObject('graph');
						$('#graph #user_bt').find('a').addClass('update');
						$('#graph').on('click', '.update', function(){
							var parent =  $(this).closest('#graph'),
								id_category = parent.data('target'),
								opt = 0,
								name_user = parent.find('#name_user').val(),
								text = parent.find('textarea').val(),
								arr = parent.find('input[type="range"]'),
								values = {};
							if($('.select_go label').is(':checked')){
								opt = 1;
							}
							arr.each(function(index, val){
								values[index] = $(val).val();
							});
							ajax('product', 'UpdateGraph', {'values': values, 'id_category': id_category, 'id_graphics': id_graphics, 'name_user': name_user, 'text': text, 'opt': opt}).done(function(data){
								if(data === true){
									console.log('Your data has been saved successfully!');
									closeObject('graph');
									location.reload();
								}else{
									console.log('Something goes wrong!');
								}
							});
						});
					}else{
						console.log('Something goes wrong!');
					}
				});


		}else{
			openObject('graph');
			$('#graph').on('click', '.btn_js.save', function(){
				var parent =  $(this).closest('#graph'),
					id_category = parent.data('target'),
					opt = 0,
					name_user = parent.find('#name_user').val(),
					text = parent.find('textarea').val(),
					arr = parent.find('input[type="range"]'),
					values = {};
				if ($('.select_go label').is(':checked')) {
					opt = 1;
				}
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
			});
		};
	});
}

//function toArray(data){ return [].slice.call(data) }
/*function SaveGraph(){
	$('#graph').on('click', '.btn_js.save', function(){
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
	});
}*/

/*function UpdateGraph(id_graphics){
	if(val == 0){
		$('a.updat').on('click', function(){
			var id_graphics = $(this).attr('id');
			ajax('product', 'SearchGraph', {'id_graphics': id_graphics}, 'html').done(function(data){
				//console.log(data);

				if(data != null){
					$('#graph .modal_container').html(data);
					// var ev = 'a.update';
					// $.each(data, function(index, el){

					// 	if(index.indexOf('value_') >= 0){
					// 		$('#graph .'+index).val(el).trigger('change');
					// 	}else{
					// 		console.log('err');
					// 	};
					// });
					componentHandler.upgradeDom();
					openObject('graph');
					//ModalGraph(ev);

				}else{
					console.log('Something goes wrong!');
				}
			});
		});
	}else{
		console.log('else');
	};
}*/

/*function GetGraphAjax(data){
	ajax('products', 'GetGraphList', {'id_category': id_category}, 'html').done(function(data){
		console.log(data);
		$('#graph > .modal_container').html(data);
	});
}*/

function ajax(target, action, data, dataType){
	if(typeof(data) == 'object'){
		data['target'] = target;
		data['action'] = action;
	}else{
		data = {'target': target, 'action': action};
	}
	dataType = dataType || 'json';
	var ajax = $.ajax({
		url: URL_base+'ajax',
		type: "POST",
		dataType : dataType,
		data: data
	});
	return ajax;
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
}

function rebuildPreview(obj){
	var position = obj.offset(),
		positionProd = $('#view_block_js').offset(),
		id_product = obj.closest('.card').find('.product_buy').data('idproduct');

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
		correctionTop = position.top - preview.height()/2 + obj.height()/2 - pos - marginTop;
	}
	preview.css({
		top: position.top - positionProd.top - preview.height()/2 + obj.height()/2 - correctionBottom - correctionTop,
		left: 100,
	});
	if(position.top - preview.offset().top + obj.height()/2 + preview.find('.triangle').height() > preview.height() ){
		preview.css('border-radius', '5px 5px 5px 0').find('.triangle').css({
			top: '50%',
			left: 20,
		});
	}else if(preview.offset().top > position.top + obj.height()/2 - preview.find('.triangle').height()){
		preview.css('border-radius', '0 5px 5px 5px').find('.triangle').css({
			top: '50%',
			left: 20,
		});
	}else{
		preview.css('border-radius', '5px').find('.triangle').css({
			top: position.top - preview.offset().top + obj.height()/2,
			left: -7,
		});
	}
	// Sending ajax for collectiong data about hovered product
	if(obj.hasClass('hovered')){
		ajax('product', 'get_array_product', {'id_product': id_product}, 'html').done(function(data){
			preview.find('.preview_content').html(data);
			componentHandler.upgradeDom();
			showPreview(0);
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
		preview.find('#owl-product_slide_js').owlCarousel({
			singleItem: true,
			lazyLoad: true,
			lazyFollow: false,
			nav: true,
			dots: true,
			navContainer: true
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
	return {"x":X, "y":Y};
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
	$(document).keyup(function(e){
		if(e.keyCode == 27){
			closeObject(object.attr('id'));
		}
	});
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
		'top': ($(window).height() + 52 - object.outerHeight())/2,
		'left': ($(window).width() - object.outerWidth())/2
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
}


// Выбор области (региона)
function GetRegions(){
	$.ajax({
		type: "post",
		url: URL_base+'ajax',
		dataType: "html",
		data: ({
			target: 'location',
			action: 'GetRegionsList'
		}),
	}).done(function(data){
		$('[for="region_select"]').html(data);
	});
}

// Выбор области (региона)
function GetCities(input){
	$.ajax({
		type: "post",
		url: URL_base+'ajax',
		dataType: "html",
		data: ({
			target: 'location',
			action: 'GetCitiesList',
			input: input
		}),
	}).done(function(data){
		$('[for="city_select"]').html(data);
	});
}

// Выбор службы доставки
function GetDeliveryService(input, service){
	$.ajax({
		type: "post",
		url: URL_base+'ajax',
		dataType: "html",
		data: ({
			target: 'location',
			action: 'GetDeliveryServicesList',
			input: input,
			service: service
		}),
	}).done(function(data){
		$('.delivery_service').html(data);
	});
}

// Выбор службы доставки
function GetDeliveryMethods(input){
	$.ajax({
		type: "post",
		url: URL_base+'ajax',
		dataType: "html",
		data: ({
			target: 'location',
			action: 'GetDeliveryMethodsList',
			input: input,
			service: service
		}),
	}).done(function(data){
		$('.delivery_service').html(data);
	});
}

/** Валидация пароля **/
function ValidatePass(passwd){
	var protect = 0;
	var result;
	var small = new RegExp("^(?=.*[a-zа-я]).*$", "g");
	if(small.test(passwd)) {
		protect++;
	}

	var big = new RegExp("^(?=.*[A-ZА-Я]).*$", "g");
	if(big.test(passwd)) {
		protect++;
	}

	var numb = new RegExp("^(?=.*[0-9]).*$", "g");
	if(numb.test(passwd)) {
		protect++;
	}

	var vv = new RegExp("^(?=.*[!,@,#,$,%,^,&,*,?,_,~,-,=]).*$", "g");
	if(vv.test(passwd)) {
		protect++;
	}

	if(protect == 1) {
		$('#passwd + .mdl-textfield__error').empty();
		$('.mdl-textfield__error').closest('.mdl-textfield #passwd').attr('class', 'bad');
		$('#passwd').removeClass().addClass("success");
		result = false;
	}
	if(protect == 2) {
		$('.mdl-textfield__error').closest('.mdl-textfield #passwd').attr('class', 'better');
		$('#passwd').removeClass().addClass("success");
		result = false;
	}
	if(protect == 3) {
		$('.mdl-textfield__error').closest('.mdl-textfield #passwd').attr('class', 'ok');
		$('#passwd').removeClass().addClass("success");
		result = false;
	}
	if(protect == 4) {
		$('.mdl-textfield__error').closest('.mdl-textfield #passwd').attr('class', 'best');
		$('#passwd').removeClass().addClass("success");
		result = false;
	}
	if(passwd.length == 0){
		$('#passwd + .mdl-textfield__error').empty();
		$('#passstrengthlevel').attr('class', 'small');
		$('#passwd').removeClass().addClass("unsuccess");
		result = 'Введите пароль';
		$('#passwd + .mdl-textfield__error').append(result);
	}else if(passwd.length < 4) {
		$('#passwd + .mdl-textfield__error').empty();
		$('#passstrengthlevel').attr('class', 'small');
		$('#passwd').removeClass().addClass("unsuccess");
		result = 'Пароль слишком короткий';
		$('#passwd + .mdl-textfield__error').append(result);
	}
	return result;
}

/** Валидация email **/
function ValidateEmail(email, type){
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	var name = $('#regs #name').val();
	var pass = $('#passwd').val();
	var passconfirm = $('#passwdconfirm').val();
	var error = '';
	/*var confirmps = $('#confirmps').prop('checked');*/
	var result;
	$.ajax({
		url: URL_base+'register',
		type: "GET",
		data:({
			"email": email,
			"action": "validate"
		}),
	}).done(function(data){
		console.log(data);
		if(email.length == 0){
			$('#email + #email_error').empty();
			$('#regs #email').removeClass().addClass("unsuccess");
			error = 'Введите email';
			$('#email + .mdl-textfield__error').append(error);
			$('#email').closest('.mdl-textfield ').addClass('is-invalid');
			result = false;
		}else if(!re.test(email)){
			$('#email + .mdl-textfield__error').empty();
			$('#regs #email').removeClass().addClass("unsuccess");
			error = 'Введен некорректный email';
			$('#email + .mdl-textfield__error').append(error);
			$('#email').closest('.mdl-textfield ').addClass('is-invalid');
			result = false;
		}else if(data == "true"){

			$('#email ~ .mdl-textfield__error').empty();
			$('#regs #email').removeClass().addClass("unsuccess");
			error = 'Пользователь с таким email уже зарегистрирован';
			$('#email ~ .mdl-textfield__error').append(error);
			$('#email').closest('.mdl-textfield ').addClass('is-invalid');
			result = false;
		}else if(data == "false"){
			$('#email ~ .mdl-textfield__error').empty();
			$('#regs #email').removeClass().addClass("success");
			error = '';
			result = true;
		}
		if(type == 1){

			if(CompleteValidation(name, error, pass, passconfirm)){
				result = true;
				if(passconfirm){
					/*console.log('TRUE');*/
					/*Regist();*/
				}else{
					/*$('#regs .regist').on('click', function() {
						$(this).closest('.mdl-textfield').find('#passwd').text('ERROR');
					});*/
					$('label[for="confirmps"]').stop(true,true).animate({
						"color": "#fff",
						"font-weight": "bold",
						"background-color": "#f00",
						"border-radius": "5px"
					},500)
					.delay(300)
					.animate({
						"color": "#000",
						"font-weight": "normal",
						"background-color": "#fff"
					},500);
				}
			}else{
				console.log('FALSE');
				result = false;
			}
		}
		return result;
	});
}
function Regist() {
	console.log('TRUE');
	$.ajax({
		url: URL_base+'register',
		type: "GET",
		cache: false,
		dataType : "json",
		data: {
			"action": 'register',
			"cont_person": name,
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
}
/** Валидация подтверждения пароля **/
function ValidatePassConfirm(passwd, passconfirm){
	if(passconfirm !== passwd || !passconfirm){
		/*console.log('Error');*/
		$('#passwdconfirm + .mdl-textfield__error').empty();
		$('#passwdconfirm').removeClass().addClass("unsuccess");
		$('#passwdconfirm').closest('.mdl-textfield ').addClass('is-invalid');
		$('#passwdconfirm + .mdl-textfield__error').append('Пароли не совпадают');
	}else{
		console.log('Пароли совпали');
		$('#passwdconfirm ~ .mdl-textfield__error').empty();
		$('#passwdconfirm').removeClass().addClass("success");
		return false;
	}
}

/** Валидация имени **/
function ValidateName(name){
	if(name.length < 3){
		$('#name ~ .mdl-textfield__error').empty();
		$('#regs #name').removeClass().addClass("unsuccess");
		$('#name').closest('.mdl-textfield ').addClass('is-invalid');
		if(name.length == 0){
			$('#name ~ .mdl-textfield__error').append('Введите имя');
		}else{
			$('#name ~ .mdl-textfield__error').append('Имя слишком короткое');
		}
	}else{
		$('#name ~ .mdl-textfield__error').empty();
		$('#regs #name').removeClass().addClass("success");
		return false;
	}
}

/** Завершить валидацию после проверки email */
function CompleteValidation(name, email, passwd, passconfirm){
	var fin = 0;
	if(ValidateName(name)){
		$('#regs .mdl-textfield__error').closest('#name .mdl-textfield').text(ValidateName(name));
		fin++;
	}
	if(email){
		$('#regs .mdl-textfield__error').closest('#email .mdl-textfield').text(email);
		fin++;
	}
	if(ValidatePass(passwd)){
		/*console.log(passwd);*/
		$('#regs .mdl-textfield__error').closest('#passwd .mdl-textfield').text(ValidatePass(passwd));
		fin++;
	}
	if(ValidatePassConfirm(passwd, passconfirm)){
		/*console.log(passconfirm);*/
		$('#regs .mdl-textfield__error').closest('#passwdconfirm .mdl-textfield').text(ValidatePassConfirm(passwd, passconfirm));
		fin++;
	}
	if(fin > 0){
		return false;
	}else{
		return true;
	}
}