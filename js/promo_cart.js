function toCart(id){
	var opt_note = $("#opt_note_"+id).val();
	var mopt_note = $("#mopt_note_"+id).val();
	if(opt_note != ""){
		$("#ico_opt_"+id).attr("class", "done");
	}else{
		$("#ico_opt_"+id).attr("class", "error");
	}
	if(mopt_note != ""){
		$("#ico_mopt_"+id).attr("class", "done");
	}else{
		$("#ico_mopt_"+id).attr("class", "error");
	}

	var a,b,c,d, order_mopt_qty, order_mopt_sum;
	a = parseFloat($(".price"+id).text().replace(",",".")).toFixed(2);
	if(a > 0){
		b = parseFloat($("#min_mopt_qty_"+id).text());
		c = parseFloat($("#order_mopt_qty_"+id).val());
		i = parseFloat($("#inbox_qty_"+id).text());

		ra = checkqty(id, b, c);
		if(!ra['success']){
			c = ra['num'];
			$("#order_mopt_qty_"+id).val(c);
			if(c!=0){
				alert("Требуется кратность минимальному количеству. Количество изменено на "+ra['num']+".");
			}
		}else{
			checkminqty(id,b,c,'plus');
			c = parseFloat($("#order_mopt_qty_"+id).val());
		}
		d = (c*a).toFixed(2);
		ibq = parseFloat($("#inbox_qty_"+id).text());
		mopt_basic_price = a;
		order_mopt_qty = c;
		order_mopt_sum = d;
		var data = {opt: 0, id_product: id, order_mopt_qty: order_mopt_qty, order_mopt_sum: order_mopt_sum,
			opt_note: mopt_note, opt_note: opt_note, mopt_correction: null, mopt_basic_price: mopt_basic_price};
		ajax('cart', 'update_qty', data).done(onCartSuccess());
	}else{
		var data = {opt: 0, id_product: id, order_mopt_qty: 0, order_mopt_sum: 0, mopt_note: "",
			opt_note: "", mopt_correction: null, mopt_basic_price: 0};
		ajax('cart', 'update_qty', data).done(onCartSuccess());

		$("#order_mopt_qty_"+id).val(0);
		alert('Позиция не доступна по мелкому опту.');
	}
}
function onCartSuccess(obj){
	if(!obj.error){
		$("#acart").text(obj.string);
		if(parseFloat(obj.string)>0){
			$(".cart").addClass("full").removeClass("empty");
			$("#acart").css("display", "inline");
			$("#cart_text").text('В корзине ');
		}else{
			$(".cart").addClass("empty").removeClass("full");
			$("#acart").css("display", "none");
			$("#cart_text").text('Корзина пуста ');
		}
	}
	if($("#order_box_qty_"+obj.id_product).val() > 0 || $("#order_mopt_qty_"+obj.id_product).val() > 0){
		$(".p"+obj.id_product).css("background-color", "");
	}else{
		$(".p"+obj.id_product).css("background-color", "");
	}
/*
	if ($("#order_box_qty_"+obj.id_product).val() == 1 || $("#order_mopt_qty_"+obj.id_product).val() == $('#min_mopt_qty_'+obj.id_product).text().replace(/\D+/g,"")) {
		$('#cat_table .price').stop(true, true).css({
			"background": "#F2930C",
			"z-index": "50"
		}).animate({
			"top": "30px"
		},{
			easing: 'easeOutCirc'
		}).animate({
			"top": "0px"
		},{
			duration: 1000,
			easing: 'easeOutElastic'
		});
		$('.price').animate({
			"background-color": "transparent"
		},{
			duration: 500
		}).animate({
			"background-color": "#F2930C"
		},{
			duration: 500
		}).animate({
			"background-color": "transparent"
		},{
			duration: 500
		});
	}*/
	if($("#order_box_qty_"+obj.id_product).val() > 0){
		$("#opt_buy_button_"+obj.id_product).css("display", "none");
		$("#opt_buy_buttons_"+obj.id_product).css("display", "block");
	}else{
		$("#opt_buy_button_"+obj.id_product).css("display", "block");
		$("#opt_buy_buttons_"+obj.id_product).css("display", "none");
	}

	if($("#order_mopt_qty_"+obj.id_product).val() > 0){
		$("#mopt_buy_button_"+obj.id_product).css("display", "none");
		$("#mopt_buy_buttons_"+obj.id_product).css("display", "block");
	}else{
		$("#mopt_buy_button_"+obj.id_product).css("display", "block");
		$("#mopt_buy_buttons_"+obj.id_product).css("display", "none");
	}
	if(window.pcart !== undefined){
		hookAfterCart(obj);
	}
	/*if (obj.sum > max_sum_order)
		alert("Внимание. Граничная Суммма наличного расчета одного предпринимателя с другим предпринимателем на протяжении одного дня по одному или нескольким платежным документам согласно постановления Правления Нацбанка Украины от 15.12.2004 №637 составляет 10000 гривен.");

	if (obj.sum > 100){
		$("#nac_1").fadeOut();
		$("#nac_2").fadeOut();
	}else{
		sum_total = parseFloat(Number(obj.sum_discount).toFixed(2));
		pr = parseFloat(sum_total/100*proc_rozn);
		sum_nac = parseFloat(sum_total + pr);

		$("#sum_nac").text(Number(sum_nac).toFixed(2));
		$("#nac_1").fadeIn();
		$("#nac_2").fadeIn();
	}*/
	cartUpdateInfo();
}


function checkqty( id, need, req){
	if(is_numeric(req)){
		if(qtycontrol[id] == 1){
			x = req/need;
			x = Number(x).toFixed(0);
			num = x*need;
			x = req%need;
			if(x!=0){
				return {success:false, num:num};
			}else{
				return {success:true};
			}
		}else{
			return {success:true};
		}
	}else{
		return {success:false, num:0};
	}
}
function checkminqty( id, need, req, direction ){
	if(is_numeric(req)){
		if(req!=0 && req<need){
			if(direction=='minus')
				need=0;
				$("#order_mopt_qty_"+id).val(need);
			/*if (need!=0)
				alert("Установлено минимальное количество. Количество изменено на "+need+".");*/
		}
	}
}
function ch_qty(direction, id){
	b = 1;
	if(qtycontrol[id] == 1){
		b = parseFloat($("#min_mopt_qty_"+id).text());
	}
	p = parseFloat($(".price"+id).text().replace(",",".")).toFixed(2);
	c = parseFloat($("#order_mopt_qty_"+id).val());
	if(direction == 'plus' && p>0){
		c = c+b;
		$("#order_mopt_qty_"+id).val(c);

	}else if(direction == 'minus' && p>0){
		if(c != 0){
			c = c-b;
			$("#order_mopt_qty_"+id).val(c);
		}
	}
	if(p>0){
		b = parseFloat($("#min_mopt_qty_"+id).text());
		c = parseFloat($("#order_mopt_qty_"+id).val());
		checkminqty(id, b, c, direction);
		toCart(id);
	}else{
		var data = {opt: 0, id_product:id, order_mopt_qty:0, order_mopt_sum:0, mopt_note:"",
			opt_note:"", mopt_correction: null, mopt_basic_price:0};
		ajax('cart', 'update_qty', data).done(onCartSuccess());

		$("#order_mopt_qty_"+id).val(0);
		//alert("Позиция не доступна.");
	}
}
function CheckNotes(id,opt){
	opt_note = $("#opt_note_"+id).val();
	mopt_note = $("#mopt_note_"+id).val();
	if(opt==1 && opt_note == ''){
		alert("Позиция требует заполнения примечания по крупному опту. Возможно необходимо указать выбранный Вами цвет, размер и т.п.");
		$("#order_box_qty_"+id).val(0);
		$("#order_box_qty_surrogate_"+id).val(5);
		//return false;
	}
	if(opt==0 && mopt_note == ''){
		alert("Позиция требует заполнения примечания по мелкому опту. Возможно необходимо указать выбранный Вами цвет, размер и т.п.");
		$("#order_mopt_qty_"+id).val(0);
		//return false;
	}
	return true;
}
function is_numeric( mixed_var ) {
	return ( mixed_var == '' ) ? false : !isNaN( mixed_var );
}
function hookAfterCart(obj){
	//Скидка
	var wholesale_discount = parseFloat($("#cart_wholesale_discount").val());

	//Наценка
	var retail_multiplyer = parseFloat($("#cart_retail_multiplyer").val());
	$("#cart_order_mopt_sum").text(parseFloat(obj.order_mopt_sum).toFixed(2));
	$("#cart_order_opt_sum").text(parseFloat(obj.order_opt_sum).toFixed(2));
	$("#corrected_sum_0").text(parseFloat(obj.order_sum[0]).toFixed(2));
	$("#corrected_sum_1").text(parseFloat(obj.order_sum[1]).toFixed(2));
	$("#corrected_sum_2").text(parseFloat(obj.order_sum[2]).toFixed(2));
	$("#corrected_sum_3").text(parseFloat(obj.order_sum[3]).toFixed(2));
	$("#cart_order_sum").text(parseFloat(obj.sum_discount).toFixed(2));
	//*Получение количества товаров из полей
	var item_opt_qty = parseFloat($("#order_box_qty_surrogate_"+obj.id_product).val());
	var item_mopt_qty = parseFloat($("#order_mopt_qty_"+obj.id_product).val());

	if(!isNaN(item_opt_qty) && !isNaN(item_mopt_qty)){
		var item_total_qty = item_opt_qty + item_mopt_qty;
	}else if(!isNaN(item_opt_qty)){
		var item_total_qty = item_opt_qty
		var item_mopt_qty = 0;
	}else if(!isNaN(item_mopt_qty)){
		var item_total_qty = item_mopt_qty
		var item_opt_qty = 0;
	}
	var item_opt_price = parseFloat($("#price_opt_"+obj.id_product).text());
	var item_mopt_price = parseFloat($("#price_mopt_"+obj.id_product).text());
	//Сумма по оптам товара
	var item_opt_sum = item_opt_price * item_opt_qty; 
	var item_mopt_sum = item_mopt_price * item_mopt_qty;
	var item_total_qty = item_opt_qty + item_mopt_qty;
	//Обновляем столбцы Сумм
	//Для опта
	$("#order_opt_sum_"+obj.id_product).text(item_opt_sum.toFixed(2));
	//Для мопта
	$("#order_mopt_sum_"+obj.id_product).text(item_mopt_sum.toFixed(2));
	//Для общего количества
	$("#cart_item_total_qty_"+obj.id_product).text(item_total_qty + " шт.");
	//Обновляем примечания
	if(obj.note_opt !== undefined){
		$("#cart_note_opt_"+obj.id_product).text(obj.note_opt);
	}
	if(obj.note_mopt !== undefined){
		$("#cart_note_mopt_"+obj.id_product).text(obj.note_mopt);
	}

	cartUpdateInfo();
}
//*********************************************************************************************************
//Выводит подсказки в корзине, в зависимости от Суммы заказа
//Подсказки рекомендуют клиенту воспользоваться скидкой, приобретая товары на определенную Сумму
//Обновляет столбец цен, в зависимости от Суммы заказа
function cartUpdateInfo(){
	var discount = parseFloat($("#cart_personal_discount").val());
	var opt_sum =  parseFloat($("#cart_order_opt_sum").text().replace(",","."));
	var mopt_sum = parseFloat($("#cart_order_mopt_sum").text().replace(",","."));
	var order_sum = opt_sum + mopt_sum;
	//$("#sum_discount").text(Number(obj.sum_discount).toFixed(2)+" грн.");

	//wholesale_margin - Сумма, выше которой даем скидку
	//wholesale_discount - скидка
	//retail_margin - Сумма, ниже которой даем наценку
	//wholesale_multiplyer - наценка
	if($("#cart_discount_and_margin_parameters").length > 0){
		$(".cart_your_price").each(function(){
			var id = $(this).attr('id');
			var old_price = parseFloat($('#'+id+'_basic').text().replace(",","."));
			var new_price = old_price.toFixed(2);
			//Подсказка
			$("#cart_order_tip").slideDown();
			$("#cart_order_tip_multiplyer").slideDown();
			$("#cart_order_tip_discount").slideUp();
			$("#cart_order_tip_wholesale").slideUp();
			$(this).text(new_price.replace(".",",") + " грн.");
			var id_integer = $(this).attr('name');
			cartSetItemSum( id_integer );	
		});
	}	//Проверка на наличие формы с параметрами (величины наценок и границ для их применения)
}
//Удаление товара из корзины
function cartRemove(id){
	//Посылаем запросы на удаление товара по опту и рознице
	var data = {opt: 0, id_product: id, order_mopt_qty: 0, order_mopt_sum: 0, mopt_note: "", opt_note: ""};
	ajax('cart', 'update_qty', data).done(onCartSuccess());

	//Скрываем строку товара из таблицы
	$("#cat_item_"+id).fadeOut(700);
	cartUpdateInfo();
}
//********************
function cartSetItemSum( id ){
	var item_opt_qty = parseFloat($("#order_box_qty_surrogate_"+id).val());
	var item_mopt_qty = parseFloat($("#order_mopt_qty_"+id).val());

	if(isNaN(item_opt_qty)){
		var item_opt_qty = 0;
	}
	if(isNaN(item_mopt_qty)){
		var item_mopt_qty = 0;
	}
	var item_opt_price = parseFloat($("#price_opt_"+id).text().replace(",",".")).toFixed(2);
	var item_mopt_price = parseFloat($("#price_mopt_"+id).text().replace(",",".")).toFixed(2);

	var item_opt_sum = (item_opt_price * item_opt_qty).toFixed(2);
	var item_mopt_sum = (item_mopt_price * item_mopt_qty).toFixed(2);
	//Для опта
	$("#order_opt_sum_"+id).text(item_opt_sum.replace(".",","));

	//Для мопта
	$("#order_mopt_sum_"+id).text(item_mopt_sum.replace(".",","));	
}
