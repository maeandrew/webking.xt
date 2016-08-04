/** оформление заказа, заполнение формы */

function regionSelect(value){
	if(value != '' && value != 'Выберите область')
	$.ajax({
		url: URL_base+'ajaxorder',
		type: "POST",
		data:({
			"region": value,
			"action":'regionSelect'
		}),
	}).done(function(data){
		$('#id_city option, #id_delivery option, #id_delivery_service option, #id_delivery_department option').remove();
		$('#id_city').append(data);
		$('#delivery_service, #insurance, #delivery_department').slideUp();
		citySelect();
	});
}

function citySelect(){
	var value = $('#id_city').val();
	if(value!='')
	$.ajax({
		url: URL_base+'ajaxorder',
		type: "POST",
		data:({
			"city": value,
			"action":'citySelect'
		}),
	}).done(function(data){
		$('#id_delivery option, #id_delivery_service option, #id_delivery_department option').remove();
		$('#id_delivery').append(data);
		$('#delivery_service, #insurance, #delivery_department').slideUp();
		deliverySelect();
	});
}


function deliverySelect(){
	var value = $('#id_delivery').val();
	var city = $('#id_city').val();
	if(value == "3"){
		$.ajax({
			url: URL_base+'ajaxorder',
			type: "POST",
			data:({
				"city": city,
				"action":'deliverySelect'
			}),
		}).done(function(data){
			$('#id_delivery_service, #id_delivery_department').prop('required',true);
			$('#id_delivery_service option').remove();
			$('#delivery_service, #insurance, #delivery_department').slideDown();
			$('#id_delivery_service').append(data);
			$('.content-insurance').slideDown();
			deliveryServiceSelect($('#id_delivery_service').val());
		});
	}else if(value == "2"){
		$.ajax({
			url: URL_base+'ajaxorder',
			type: "POST",
			data:({
				"city": city,
				"action":'getCityId'
			}),
		}).done(function(data){
			$('#delivery_service, #insurance, #delivery_department').slideUp();
			$('#id_delivery_department option').remove();
			$('#id_delivery_department').append(data);
			$('.content-insurance').slideUp();
		});
	}else if(value == "1"){
		$.ajax({
			url: URL_base+'ajaxorder',
			type: "POST",
			data:({
				"city": city,
				"action":'getCityId'
			}),
		}).done(function(data){
			$('#delivery_service, #insurance, #delivery_department').slideUp();
			$('#id_delivery_department option').remove();
			$('#id_delivery_department').append(data);
			$('.content-insurance').slideUp();
		});
	}
}

function deliveryServiceSelect(value){
	var city = $('#id_city').val();
	$.ajax({
		url: URL_base+'ajaxorder',
		type: "POST",
		data:({
			"city": city,
			"shipping_comp": value,
			"action":'deliveryServiceSelect'
		}),
	}).done(function(data){
		$('#id_delivery_department option').remove();
		$('#id_delivery_department').append(data);
	});
}
/**Конец формы корзины */

function setOrderNote(id_order){
	var note = $('#order_note_'+id_order).val();
	$.ajax({
		url: URL_base+'ajax_contragent_note',
		type: "POST",
		data:({
			"id_order":id_order,
			"note":note
		}),
	}).done(function(){
		$('#order_note_'+id_order).animate({ backgroundColor : "#afa",}, 0).delay(500).animate({ backgroundColor : "#fff",}, 3000, "swing" );
	});
}

function setOrderKlient(id_order){
	var note_diler = $('#order_klient_'+id_order).val();
	$.ajax({
		url: URL_base+'ajax_diler_note_klient',
		type: "POST",
		data: ({
			"id_order":id_order,
			"note_diler":note_diler
		}),
	});
}

function setOrderNote_zamena(id_order){
	var note2 = $('#order_note2_'+id_order).val();
	$.ajax({
		url: URL_base+'ajax_contragent_note2',
		type: "POST",
		data:({
			"id_order":id_order,
			"note2":note2
		}),
	}).done(function(){
		$('#order_note2_'+id_order).animate({ backgroundColor : "#afa",}, 0).delay(500).animate({ backgroundColor : "#fff",}, 3000, "swing" );
	});
}

function setOrderNote_customer(id_order){
	var note_customer = $('#order_note_customer_'+id_order).val();
	$.ajax({
		url: URL_base+'ajax_contragent_note_customer',
		type: "POST",
		data:({
			"id_order":id_order,
			"note_customer":note_customer
		}),
	});
}

function setOrderNote_klient(id_order){
	var note_klient = $('#id_klient_'+id_order).val();
	$.ajax({
		url: URL_base+'ajax_contragent_note_klient',
		type: "POST",
		data:({
			"id_order":id_order,
			"note_klient":note_klient
		}),
	});
}

function setOrderNoteSuccess(id_order){
	$('#edit_box_'+id_order).fadeToggle();
	if($('#order_note_'+id_order).val()!=""){
		$('#'+id_order).removeClass('error');
		$('#'+id_order).addClass('done');
	}else{
		$('#'+id_order).removeClass('done');
		$('#'+id_order).addClass('error');
	}
}

//function RecalcSupplierCurrency(){
//	$("#popup_msg").fadeIn();
//	cur = parseFloat($("#currency_rate").val());
//	cur_old = parseFloat($("#currency_rate_old").val());
//	$.ajax({
//		url: URL_base+'ajaxsupdate',
//		type: "POST",
//		cache: false,
//		dataType: "json",
//		data: {
//			"cur": cur,
//			"cur_old": cur_old
//		}
//	}).done(function(){
//		setTimeout(function(){
//			$("#popup_msg").fadeOut();
//			location.reload();
//		},1000);
//	});
//}


function SwitchSupplierDate(date){
	$.ajax({
		url: URL_base+'ajaxsupdate',
		type: "POST",
		cache: false,
		dataType: "json",
		data: {
			"date": date
		},
		success: onSwitchSupSuccess
	});
}

/*Выполнение действий после апдейта дат поставщика*/
function onSwitchSupSuccess(obj){
	//alert("switch "+obj.date+" "+obj.dn+" "+" to "+obj.switcher);
	date = obj.date.replace(/\./g,"_");
	if (obj.switcher == 1)
		$('#'+obj.dn+date).css('background-color','#cccccc');
	else
		$('#'+obj.dn+date).css('background-color','');
	$('#next_update_date').text(obj.next_update_date);
}

// /*Добавить/Удалить товар а ассортименте у конкретного поставщика*/
// function AddDelProductAssortiment(obj, id){
// 	if (obj.checked){
// 		action = "add_product";
// 	}else{
// 		action = "del_product";
// 	}
// 	$.ajax({
// 		url: URL_base+'ajaxassort',
// 		type: "POST",
// 		cache: false,
// 		dataType: "json",
// 		data: {
// 			"action":action,
// 			"id_product":id
// 		},
// 		success: onAddDelSuccess
// 	});
// }

function onAddDelSuccess(obj){
	if (obj.action == "add"){
		$("#tr_opt_"+obj.id_product).css("background-color", "#F1FFF1");
		$("#tr_mopt_"+obj.id_product).css("background-color", "#F1FFF1");
	}else{
		$("#tr_opt_"+obj.id_product).css("background-color", "");
		$("#tr_mopt_"+obj.id_product).css("background-color", "");
	}
}

function DelFromAssort(id){
	a = 0;
	$("#price_opt_otpusk_"+id).val(a);
	b = 0;
	$("#price_opt_recommend_"+id).val(b);
	$.ajax({
		url: URL_base+'ajaxassort',
		type: "POST",
		cache: false,
		dataType: "json",
		data: {
			"action":"del_product",
			"id_product":id
		},
		success: onDelSuccess
	});
}

function onDelSuccess(obj){
	$("#tr_opt_"+obj.id_product).remove();
	$("#tr_mopt_"+obj.id_product).remove();
}

function SetSaleStatus(id){
	var s = $('input.salestatus'+id).val();
	$.ajax({
		url: URL_base+'ajaxassort',
		type: "POST",
		cache: false,
		dataType: "json",
		data: {
			"action": "sale_status",
			"id_product": id,
			"status": s
		},
		success: onSaleSuccess
	});
}

function SetInUSD(id, nacenmopt, nacenopt, comment){
	var currency_rate = $('#currency_rate').val();
	$('.inusd'+id).prop('disabled', true);
	var s = $('.inusd'+id).prop('checked');
	$.ajax({
		url: URL_base+'ajaxassort',
		type: "POST",
		cache: false,
		dataType: "json",
		data: {
			"action": "inusd",
			"id_product": id,
			"inusd": s
		}
	}).done(function(obj){
		if(obj.inusd == 'true'){
			var price_mopt_otpusk = parseFloat($('#price_mopt_otpusk_'+id).val().replace(",","."))/currency_rate;
			var price_opt_otpusk = parseFloat($('#price_opt_otpusk_'+id).val().replace(",","."))/currency_rate;
			$('#price_mopt_otpusk_'+id).val(price_mopt_otpusk.toFixed(3)).removeClass('uah_price').addClass('usd_price');
			$('#price_opt_otpusk_'+id).val(price_opt_otpusk.toFixed(3)).removeClass('uah_price').addClass('usd_price');
			$('.inusd'+obj.id_product).prop('checked', true);
		}else{
			var price_mopt_otpusk = parseFloat($('#price_mopt_otpusk_'+id).val().replace(",","."))*currency_rate;
			var price_opt_otpusk = parseFloat($('#price_opt_otpusk_'+id).val().replace(",","."))*currency_rate;
			$('#price_mopt_otpusk_'+id).val(price_mopt_otpusk.toFixed(2)).removeClass('usd_price').addClass('uah_price');
			$('#price_opt_otpusk_'+id).val(price_opt_otpusk.toFixed(2)).removeClass('usd_price').addClass('uah_price');
			$('.inusd'+obj.id_product).prop('checked', false);
		}
		toAssort(id, 0, nacenmopt, comment);
		toAssort(id, 1, nacenopt, comment);
		$('.inusd'+obj.id_product).prop('disabled', false);
	});
}

function onSaleSuccess(obj){
	if(obj.id_status == 1){
		$('input.salestatus'+obj.id_product).val(4);
		$('input.salestatus'+obj.id_product).prop('checked', false);
	}else{
		$('input.salestatus'+obj.id_product).val(1);
		$('input.salestatus'+obj.id_product).prop('checked', true);
	}
	$('input.salestatus'+obj.id_product).prop('disabled', false);
}

function toAssort(id, opt, nacen, comment){
	var inusd = $('.inusd'+id).prop('checked');
	var currency_rate = $('#currency_rate').val();
	if(opt == 1){
		optw = "opt";
	}else{
		optw = "mopt";
	}
	var a,b,c;
	a = parseFloat($("#price_"+optw+"_otpusk_"+id).val().replace(",","."));
	b = parseFloat($("#price_"+optw+"_otpusk_"+id).val().replace(",","."));
	if(inusd == true){
		a = a*currency_rate;
		b = b*currency_rate;
	}
	c = parseFloat($("#product_limit_mopt_"+id).val());
	$("#product_limit_mopt_"+id).val(c);
	active = 0;
	if(c > 0){
		if(opt){
			po = parseFloat($("#price_opt_"+id).val());
			pom = Number(po - po*parseFloat($("#price_delta_otpusk").val())*0.01).toFixed(2);
			if(po != 0 && a > pom){
				alert("Предлагаемая Вами крупнооптовая цена не позволяет продавать данный товар на сайте.");
			}
			pop = Number(po + po*parseFloat($("#price_delta_recom").val())*0.01).toFixed(2);
			pom = Number(po - po*parseFloat($("#price_delta_recom").val())*0.01).toFixed(2);
			if(po != 0 && (b > pop || b < pom)){
				alert("Предлагаемая Вами среднерыночная цена значительно отличается от цены сайта (более "+parseFloat($("#price_delta_recom").val())+"%).");
			}
		}else{
			pm = parseFloat($("#price_mopt_"+id).val());
			pmm = Number(pm - pm*parseFloat($("#price_delta_otpusk").val())*0.01).toFixed(2);
			if(pm != 0 && a > pmm){
				alert("Предлагаемая Вами мелкооптовая цена не позволяет продавать данный товар на сайте.");
			}
			pmp = Number(pm + pm*parseFloat($("#price_delta_recom").val())*0.01).toFixed(2);
			pmm = Number(pm - pm*parseFloat($("#price_delta_recom").val())*0.01).toFixed(2);
			if(pm != 0 && (b > pmp || b < pmm)){
				alert("Предлагаемая Вами среднерыночная цена значительно отличается от цены сайта (более "+parseFloat($("#price_delta_recom").val())+"%).");
			}
		}
		ao = parseFloat($("#price_opt_otpusk_"+id).val());
		bo = parseFloat($("#price_opt_otpusk_"+id).val());
		am = parseFloat($("#price_mopt_otpusk_"+id).val());
		bm = parseFloat($("#price_mopt_otpusk_"+id).val());
		active = 1;
		if((ao > 0 && bo == 0) || (ao == 0 && bo > 0)){
			active = 0;
			alert("Необходимо заполнить цены.");
		}else if((am > 0 && bm == 0) || (am == 0 && bm > 0)){
			active = 0;
			alert("Необходимо заполнить цены.");
		}
	}
	if(active == 1){
		$("#tr_opt_"+id).removeClass('notavailable notprice').addClass('available');
		$("#tr_mopt_"+id).removeClass('notavailable notprice').addClass('available');
	}else{
		$("#tr_opt_"+id).removeClass('available').addClass('notavailable');
		$("#tr_mopt_"+id).removeClass('available').addClass('notavailable');
		$("#product_limit_opt_"+id).val(0);
		$("#product_limit_mopt_"+id).val(0);
	}
	if(a <= 0 || b <= 0){
		//$("#checkbox_"+optw+"_"+id).attr('checked','');
		$("#tr_opt_"+id).removeClass('available').addClass('notavailable notprice');
		$("#tr_mopt_"+id).removeClass('available').addClass('notavailable notprice');
	}
	if(a < 0){
		a = 0;
		$("#price_opt_otpusk_"+id).val(a);
	}
	//if (b<0){ b=0;$("#price_opt_recommend_"+id).val(b);}
	$.ajax({
		url: URL_base+'ajaxassort',
		type: "POST",
		cache: false,
		dataType: "json",
		data:{
			"action": "update_assort",
			"opt": opt,
			"id_product": id,
			"price_otpusk": a,
			"price_recommend": b,
			"nacen": nacen,
			"product_limit": c,
			"active": active,
			"sup_comment": comment,
			"inusd": inusd,
			"currency_rate": currency_rate
		},
		success: onAssortSuccess
	});
}

function onAssortSuccess() {
	//alert ("Ok") ;
}

function CheckOtpRecPrices(id, opt){
	if(opt == 1){
		optw = "opt";
	}else{
		optw = "mopt";
	}
	var a,b;
	a = parseFloat($("#price_"+optw+"_otpusk_"+id).val());
	b = parseFloat($("#price_"+optw+"_recommend_"+id).val());
	if(b<a){
		alert("Ошибка! Отпускная цена не может быть выше среднерыночной.");
		return false;
	}else{
		return true;
	}
}

function refreshkcaptcha(){
	src = $("#kcaptcha").attr("src");
	$("#kcaptcha").attr("src", src+ Math.random());
	$("#kcaptcha").load();
}

function hide_unselected(){
	$(".returns_table .table_row").each(function(){
		var id = $(this).attr("id");
		if($("#chbox_"+id).attr("checked")!==true){
			$("#"+id).hide();
		}
	});
}

function show_unselected(){
	$(".returns_table .table_row").each(function(){
		var id = $(this).attr("id");
		if($("#chbox_"+id).attr("checked")!==true){
			$("#"+id).show();
		}
	});
}

/** SHOWCASE SLIDER INITIALIZATION */
// function showSlider(src1,src2,src3){
//  $('#showcase_bg, #showcase').fadeIn();
//  // $('#showcase_bg').css("bottom", 0);
//  // $('#showcase').css("top", '50%');
//  var slides = new Array(src1,src2,src3);
//  var thumbs = new Array(src1.replace("/efiles/", "/efiles/_thumb/"),src2.replace("/efiles/", "/efiles/_thumb/"),src3.replace("/efiles/", "/efiles/_thumb/"));
//  var i = 0;
//  jQuery.each(slides, function(){
//      if(slides[i]){
//          $('#showcase').append('<div class="close animate"></div><div class="showcase-slide"><div class="showcase-content"><img style="max-width: 800px; max-height: 550px;" src="'+slides[i]+'"/></div><div class="showcase-thumbnail"><img src="'+thumbs[i]+'"/></div></div>');
//          i++;
//      }
//  });
//  /** НАСТРОЙКИ SHOWCASE СЛАЙДЕРА */
//  $("#showcase").awShowcase({
//      content_width:          900,
//      content_height:         550,
//      fit_to_parent:          false,
//      auto:                   false,
//      interval:               3000,
//      continuous:             false,
//      loading:                false,
//      tooltip_width:          200,
//      tooltip_icon_width:     32,
//      tooltip_icon_height:    32,
//      tooltip_offsetx:        18,
//      tooltip_offsety:        0,
//      arrows:                 true,
//      buttons:                false,
//      btn_numbers:            false,
//      keybord_keys:           true,
//      mousetrace:             false,  Trace x and y coordinates for the mouse
//      pauseonover:            true,
//      stoponclick:            true,
//      transition:             'fade', /* hslide/vslide/fade */
//      transition_delay:       300,
//      transition_speed:       500,
//      show_caption:           'onhover', /* onload/onhover/show */
//      thumbnails:             true,
//      thumbnails_position:    'outside-last', /* outside-last/outside-first/inside-last/inside-first */
//      thumbnails_direction:   'horizontal', /* vertical/horizontal */
//      thumbnails_slidex:      0, /* 0 = auto / 1 = slide one thumbnail / 2 = slide two thumbnails / etc. */
//      dynamic_height:         false, /* For dynamic height to work in webkit you need to set the width and height of images in the source. Usually works to only set the dimension of the first slide in the showcase. */
//      speed_change:           true, /* Set to true to prevent users from swithing more then one slide at once. */
//      viewline:               false /* If set to true content_width, thumbnails, transition and dynamic_height will be disabled. As for dynamic height you need to set the width and height of images in the source. */
//  });
//  $('#showcase_bg, .showcase .close').click(function(){
//      $('#showcase_bg, #showcase').fadeOut().delay(600).children().remove();
//  });
// }

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

/* Валидация бонусной карты */
function ValidateBonusCard(card){
	if(card.length == 5 && /^\d+$/.test(card)){
		$('#bonus_card').removeClass().addClass("success");
		return false;
	}else{
		$('#bonus_card').removeClass().addClass("unsuccess");
		return 'Логин слишком короткий';
	}
}

/** Валидация имени **/
function ValidateName(name){
	if(name.length < 4){
		$('#name_error + .error_description').empty();
		$('#regname').removeClass().addClass("unsuccess");
		if(name.length == 0){
			$('#name_error + .error_description').append('Введите имя');
		}else{
			$('#name_error + .error_description').append('Имя слишком короткое');
		}
	}else{
		$('#name_error + .error_description').empty();
		$('#regname').removeClass().addClass("success");
		return false;
	}
}

/** Валидация email **/
function ValidateEmail(email, type){
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
		name = $('#regname').val(),
		pass = $('#regpasswd').val(),
		passconfirm = $('#passwdconfirm').val(),
		code = $('#promo_code').val(),
		confirmps = $('#confirmps').prop('checked'),
		result;
	ajax('users', 'check_email_uniqueness', {email: email}).done(function(response){
		if(email.length == 0){
			$('#email_error + .error_description').empty();
			$('#regemail').removeClass().addClass("unsuccess");
			error = 'Введите email';
			$('#email_error + .error_description').append(error);
			result = false;
		}else if(!re.test(email)){
			$('#email_error + .error_description').empty();
			$('#regemail').removeClass().addClass("unsuccess");
			error = 'Введен некорректный email';
			$('#email_error + .error_description').append(error);
			result = false;
		}else if(response == "true"){
			$('#email_error + .error_description').empty();
			$('#regemail').removeClass().addClass("unsuccess");
			error = 'Пользователь с таким email уже зарегистрирован';
			$('#email_error + .error_description').append(error);
			result = false;
		}else{
			$('#email_error + .error_description').empty();
			$('#regemail').removeClass().addClass("success");
			error = '';
			result = true;
		}
		if(type == 1){
			if(CompleteValidation(name, error, pass, passconfirm)){
				result = true;
				if(confirmps){
					$('#reg_form').submit();
					$('#reg_form #smb').submit();
				}else{
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
				result = false;
			}
		}
		return result;
	});
}

/** Валидация промо-кода **/
function ValidatePromoCode(code){
	var fin = 0,
		result;
	$.ajax({
		url: URL_base+'ajaxpromocodevalidate',
		type: "POST",
		data:({
			"code": code,
			"action": "validate"
		}),
	}).done(function(data){
		if(data == 'false'){
			$('#promo_code').removeClass().addClass("unsuccess");
			$('#promo_code').next().next().text('Промо-код недействительный.');
			fin++;
		}else{
			$('#promo_code').removeClass().addClass("success");
		}
		if(fin > 0){
			return false;
		}else{
			return true;
		}
	});
}

/** Валидация пароля **/
function ValidatePass(pass){
	var protect = 0;
	var result;
	var small = new RegExp("^(?=.*[a-zа-я]).*$", "g");
	if(small.test(pass)) {
		protect++;
	}

	var big = new RegExp("^(?=.*[A-ZА-Я]).*$", "g");
	if(big.test(pass)) {
		protect++;
	}

	var numb = new RegExp("^(?=.*[0-9]).*$", "g");
	if(numb.test(pass)) {
		protect++;
	}

	var vv = new RegExp("^(?=.*[!,@,#,$,%,^,&,*,?,_,~,-,=]).*$", "g");
	if(vv.test(pass)) {
		protect++;
	}

	if(protect == 1) {
		$('#password_error + .error_description').empty();
		$('#passstrengthlevel').attr('class', 'bad');
		$('#regpasswd').removeClass().addClass("success");
		result = false;
	}
	if(protect == 2) {
		$('#passstrengthlevel').attr('class', 'better');
		$('#regpasswd').removeClass().addClass("success");
		result = false;
	}
	if(protect == 3) {
		$('#passstrengthlevel').attr('class', 'ok');
		$('#regpasswd').removeClass().addClass("success");
		result = false;
	}
	if(protect == 4) {
		$('#passstrengthlevel').attr('class', 'best');
		$('#regpasswd').removeClass().addClass("success");
		result = false;
	}
	if(pass.length == 0){
		$('#password_error + .error_description').empty();
		$('#passstrengthlevel').attr('class', 'small');
		$('#regpasswd').removeClass().addClass("unsuccess");
		result = 'Введите пароль';
		$('#password_error + .error_description').append(result);
	}else if(pass.length < 4) {
		$('#password_error + .error_description').empty();
		$('#passstrengthlevel').attr('class', 'small');
		$('#regpasswd').removeClass().addClass("unsuccess");
		result = 'Пароль слишком короткий';
		$('#password_error + .error_description').append(result);
	}
	return result;
}

/** Валидация подтверждения пароля **/
function ValidatePassConfirm(pass, passconfirm){
	if(passconfirm !== pass || !passconfirm){
		$('#passwdconfirm_error + .error_description').empty();
		$('#passwdconfirm').removeClass().addClass("unsuccess");
		$('#passwdconfirm_error + .error_description').append('Пароли не совпадают');
	}else{
		$('#passwdconfirm_error + .error_description').empty();
		$('#passwdconfirm').removeClass().addClass("success");
		return false;
	}
}

/** Завершить валидацию после проверки email */
function CompleteValidation(name, email, pass, passconfirm, code){
	var fin = 0;
	if(ValidateName(name)){
		$('#regname').closest('.error_description').text(ValidateName(name));
		fin++;
	}
	if(email){
		$('#regemail').closest('.error_description').text(email);
		fin++;
	}
	if(ValidatePass(pass)){
		$('#regpasswd').closest('.error_description').text(ValidatePass(pass));
		fin++;
	}
	if(ValidatePassConfirm(pass, passconfirm)){
		$('#passwdconfirm').closest('.error_description').text(ValidatePassConfirm(pass, passconfirm));
		fin++;
	}
	if(fin > 0){
		return false;
	}else{
		return true;
	}
}

// function FixHeader(){
//  $(window).scroll(function(){
//      if($('.tabs').css('position') == 'relative' && getScrollWindow() >= 85){
//          newPosX = getScrollWindow() - 85;
//          $('.tabs').css({
//              "position": "fixed",
//              "top": "0",
//              "z-index": "10000",
//              "width": "1262"
//          });
//          $('header').css("height", "173px");
//          $('.under_tab').css({
//              "box-shadow": "0px 2px 3px -1px rgba(0, 0, 0, 0.4)"
//          });
//      }else if($('.tabs').css('position') == 'fixed' && getScrollWindow() < 85){
//          $('.tabs').css({
//              "position": "relative",
//              "top": "0",
//              "z-index": "100"
//          });
//          $('.under_tab').css({
//              "box-shadow": "none"
//          });
//      }
//  });
// }
function ToggleDuplicate(id, user, comment){
	$.ajax({
		url: URL_base+'ajaxassort',
		type: "POST",
		cache: false,
		dataType: "json",
		data: {
			"action": "toggle_duplicate",
			"id_product": id,
			"duplicate_user": user,
			"duplicate_comment": comment
		}
	});
}

//Подсчет кол-ва просмотров у товара
function countViewsProducts(count_views, id_product) {
	$.ajax({
		url: URL_base+'ajaxmain',
		type: "POST",
		cache: false,
		dataType : "json",
		data: {
			"action": 'count_views_products',
			"count_views": count_views,
			"id_product": id_product
		}
	});
}













function toggleSearchButton(action, value){
	if(action == 'show'){
		if($('.search_block').hasClass('focused') == false){
			$('.search_block').addClass('focused');
		}
		if(value.length > 0){
			$('.search_block').addClass('filled');
		}else{
			$('.search_block').removeClass('filled');
		}
	}else{
		$('.search_block').removeClass('focused').removeClass('filled');
	}
}

/*MODAL WINDOW*/

// Вызов модального окна
function openModal(target){
	$('#back_modal').removeClass('hidden');
	$('#'+target+'.modal_hidden').removeClass('modal_hidden').addClass('modal_opened');
}
// Закрытие модального окна
function closeModal(){
	$('.modal_opened').removeClass('modal_opened').addClass('modal_hidden');
	$('#back_modal').addClass('hidden');
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
				$(this).addClass('hovered');
				rebuildPreview($(this));
			}
		}
	}).on('mouseleave', function(e){
		if($('#view_block_js').hasClass('list_view')){
			var mp = mousePos(e),
				obj = $(this),
				obj2 = $('.product_photo.hovered');
			if((mp.x >= preview.offset().left && mp.x <= preview.offset().left+preview.width() && mp.y >= preview.offset().top && mp.y <= preview.offset().top+preview.height())
				|| (obj.hasClass('hovered') && mp.x >= obj.offset().left && mp.x <= obj.offset().left+obj.width() && mp.y >= obj.offset().top && mp.y <= obj.offset().top+obj.height())){
			}else{
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
			}else{
				hidePreview();
				obj.removeClass('hovered');
			}
		}
	});
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
		correctionBottom = position.top + preview.height()/2 + obj.height()/2 - (pos+viewportHeight) + marginBottom;
	}else if(pos > position.top - preview.height()/2 + obj.height()/2 - marginTop){
		correctionTop =  position.top - preview.height()/2 + obj.height()/2 - pos - marginTop;
	}
	preview.css({
		top: position.top - positionProd.top - preview.height()/2 + obj.height()/2 - correctionBottom - correctionTop,
		left: 80
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
		});
	}else{
		preview.hide();
	}
}

// get mouse position
function mousePos(e){
	var X = e.pageX; // положения по оси X
	var Y = e.pageY; // положения по оси Y
	return {"x":X, "y":Y}
}

/* Функция отправки отзыва о продукте */
function onCommentSubmit(){
	alert("Коментарий о позиции будет отображен на сайте после премодерации.");
}
/* Вывод сообщения при отправке пожелания*/
function onWishesSubmit(){
	alert("Сообщение будет отображено на сайте после премодерации.");
}

/* Смена отображаемой цены */
function ChangePriceRange(id){
	document.cookie="sum_range="+id+"; path=/";
	document.cookie="manual=1; path=/";
	$('button.sum_range').removeClass('user_active');
	$('button.sum_range_'+id).addClass('user_active');
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
function formPrice(){
	var id,opt_cor_set,mopt_cor_set,price_opt,price_mopt,
		sum_range = $.cookie('sum_range');

	ajax('cart', 'get_cart', {action: 'get_cart'}).done(function(data){
		$('.product_section div[data-idproduct]').each(function(index, el) {
			id = $(this).attr('data-idproduct');
			price_opt = $(this).find('.price_opt_js').val();
			price_mopt = $(this).find('.price_mopt_js').val();
			opt_cor_set = $(this).find('.opt_cor_set_js').val().split(';');
			mopt_cor_set = $(this).find('.mopt_cor_set_js').val().split(';');
			if(data.products[id] != undefined){
				actual_price = data.products[id]['actual_prices'][sum_range];
				other_price = data.products[id]['other_prices'][sum_range];
			}else{
				actual_price = price_opt * opt_cor_set[sum_range];
				other_price = price_mopt * mopt_cor_set[sum_range];
			};
			$(this).find('.active_price span.price_js').html(actual_price.toFixed(2));
			$(this).find('.other_price span.price_js').html(other_price.toFixed(2));
			$('.product_buy .buy_block').stop(true,true).css({
				"background-color": "rgb(249, 240, 206)"
			}).delay(1000).animate({
				"background-color": "transparent"
			}, 3000);
		});
	});
}

//Добавление товара в избранное
function AddFavorite(event,id_product){
	$.ajax({
		url: URL_base+'ajaxproduct',
		type: "POST",
		cache: false,
		dataType: "json",
		data: {
			"action": 'add_favorite',
			"id_product": id_product
		}
	}).done(function(data){
		if(data.answer == 'login'){
			// alert('Войдите или зарегистрируйтесь.');
			event.preventDefault();

			var target = 'login_form';
			openModal(target);
		}else if(data.answer == 'already'){
			//alert('Товар уже находится в избранных.');
			event.preventDefault();
		}else{
			$('div[data-idfavorite="'+id_product+'"]').attr('title', 'Товар находится в избранных');
			$('div[data-idfavorite="'+id_product+'"]').find('span.favorite').html('favorites');
			$('div[data-idfavorite="'+id_product+'"] a').html('В избранном').attr('href', '/cabinet/favorites/');
			$('.fav_count_js').html(data.fav_count);
			//alert('ok');
		}
	});
}

//Добавление товара в список ожидания
function AddInWaitingList(id_product,id_user,email){
	$.ajax({
		url: URL_base+'ajaxproduct',
		type: "POST",
		cache: false,
		dataType: "json",
		data: {
			"action": 'add_in_waitinglist',
			"id_product": id_product,
			"id_user": id_user,
			"email": email
		},
		error: function(){
			alert('Товар уже добавлен в лист ожидания');
			location.reload();
		}
	}).done(function(data){
		if(data.answer_data == 'insert_ok'){
			location.reload();
		}
	});
	return false;
}

//Прокрутка слайдера вверх
function up_carusel(carusel){
	var block_height = $(carusel).find('.item').outerHeight();
	$(carusel).find(".carrossel-items .item").eq(-1).clone().prependTo($(carusel).find(".carrossel-items"));
	$(carusel).find(".carrossel-items").css({"top":"-"+block_height+"px"});
	$(carusel).find(".carrossel-items .item").eq(-1).remove();
	$(carusel).find(".carrossel-items").animate({top: "0px"}, 200);
};
//Прокрутка слайдера вниз
function down_carusel(carusel){
	var block_height = $(carusel).find('.item').outerHeight();
	$(carusel).find(".carrossel-items").css({"top":"auto"}).animate({bottom: block_height +"px"}, 200, function(){
		$(carusel).find(".carrossel-items .item").eq(0).clone().appendTo($(carusel).find(".carrossel-items"));
		$(carusel).find(".carrossel-items .item").eq(0).remove();
		$(carusel).find(".carrossel-items").css({"bottom":"0px"});
	});
};