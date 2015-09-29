function SendToAjax(id, qty, button, direction, note){
	// $('.product_buy[data-idproduct="'+id+'"]').addClass('ajax_loading');
	$.ajax({
		url: URL_base+'ajaxcart',
		type: "POST",
		cache: false,
		dataType : "json",
		data: {
			"action": "update_cart_qty",
			"id_product": id,
			"quantity": qty,
			"button": button,
			"direction": direction,
			"note": note
		}
	}).done(function(data){
		completeCartProductAdd(data.cart.products);
		qty = data.product.quantity;
		var mode_text = 'от';
		if(qty == 0){
			$('div[data-idproduct="'+id+'"]').find('.qty_js').val(0);
			$('div[data-idproduct="'+id+'"]').find('.buy_btn_js').removeClass('hidden');
			$('div[data-idproduct="'+id+'"]').find('.in_cart_js').addClass('hidden');
		}else{
			$('div[data-idproduct="'+id+'"]').find('.qty_js').val(qty);
			$('div[data-idproduct="'+id+'"]').find('.in_cart_js').removeClass('hidden');
			$('div[data-idproduct="'+id+'"]').find('.buy_btn_js').addClass('hidden');
			if(data.cart.products[id].mode == 'opt'){
				mode_text = 'до';
			}
			if($('form.note[data-note="'+id+'"]').hasClass('note_control') && $('form.note[data-note="'+id+'"]').is(':not(.informed)') && $('form.note[data-note="'+id+'"] textarea').val() == ''){
				alert('Примечание данного товара является обязательным для заполнения!');
				$('form.note[data-note="'+id+'"]').addClass('informed').css('border-color', '#f00');
			};
		}
		if(current_controller == 'cart'){
			$('div[data-idproduct="'+id+'"]').find('.active_price .price_js').text(data.product.actual_prices[data.cart.cart_column].toFixed(2));
			$('.cart_order_sum').text(data.cart.cart_sum);
			$.each(data.cart.products, function(key, value){
				$('div[data-idproduct="'+key+'"]').find('.active_price .price_js').text(value.actual_prices[data.cart.cart_column].toFixed(2));
				$('.order_mopt_sum_'+key).text(value.summary[data.cart.cart_column].toFixed(2));
			});
		}else{
			$('div[data-idproduct="'+id+'"]').find('.active_price .price_js').text(data.product.actual_prices[$.cookie('sum_range')].toFixed(2));
			$('div[data-idproduct="'+id+'"]').find('.other_price .price_js').text(data.product.other_prices[$.cookie('sum_range')].toFixed(2));
			$('div[data-idproduct="'+id+'"]').find('.other_price .mode_js').text(mode_text);
		}
		// console.log(mode_text);
		// $('.product_buy[data-idproduct="'+id+'"]').removeClass('ajax_loading');
	});
}

function ChangeCartQty(id, direction){
	/* direction: 0 - minus, 1 - plus; */
	var qty = parseInt($('.product_buy[data-idproduct="'+id+'"]').find('.qty_js').val());
	if(current_controller == 'cart'){
		var note = $('#cart_item_'+id).find('.note textarea').val();
	}else{
		var note = $('#product_'+id).find('.note textarea').val();
	}
	if(direction == 1){
		SendToAjax(id, qty+1, true, direction,note);
	}else{
		SendToAjax(id, qty-1, true, direction,note);
	}
}

function completeCartProductAdd(data){
	var products_count = 0;
	for(var i in data){
		if(data.hasOwnProperty(i)){
			products_count++;
		}
	}
	$('.order_cart').text(products_count);
}
function removeFromCart(id){
	$.ajax({
		url: URL_base+'ajaxcart',
		type: "POST",
		cache: false,
		dataType : "json",
		data: {
			"action": "remove_from_cart",
			"id_product": id
		}
	}).done(function(data){
		$('#cart_item_'+id).hide(200);
	});

}
// function toCart(id, opt){
// 	var filial = parseFloat($(".filial_icon").attr("class"));
// 	var discount = parseFloat($("#cart_personal_discount").val());
// 	var opt_correction = $("#correction_set_price_opt_"+id).text().replace(/\s/g,"").split(';');
// 	var mopt_correction = $("#correction_set_price_mopt_"+id).text().replace(/\s/g,"").split(';');
// 	var opt_note = $("#opt_note_"+id).val();
// 	var mopt_note = $("#mopt_note_"+id).val();
// 	if(opt_note != ""){
// 		$("#ico_opt_"+id).attr("class", "done");
// 	}else{
// 		$("#ico_opt_"+id).attr("class", "error");
// 	}
// 	if(mopt_note != ""){
// 		$("#ico_mopt_"+id).attr("class", "done");
// 	}else{
// 		$("#ico_mopt_"+id).attr("class", "error");
// 	}
// 	if(opt == 1){
// 		var price, b, c, d, e, f, g, q, order_opt_qty, order_opt_sum;
// 		price = parseFloat($("#price_opt_"+id+"_basic").text().replace(",",".")).toFixed(2);
// 		b = parseFloat($("#inbox_qty_"+id).text());
// 		f = parseFloat($("#multiplicity_"+id).text());
// 		g = parseFloat($("#order_mopt_qty_"+id).val());
// 		q = 1;
// 		if(f == 1){
// 			q = 0;
// 		}
// 		if(price > 0 && b > 0){
// 			//Подбор ближайшего кратного ящику
// 			var entered = parseFloat($("#order_box_qty_surrogate_"+id).val());
// 			if(g > 0){
// 				$("#order_mopt_qty_"+id).val(0);
// 				toCart(id, 0);
// 				if(g > entered){
// 					entered = g;
// 				}
// 			}
// 			//Если не кратно и введено больше, чем в одном ящике
// 			if((entered%b) > 0 && entered > b && q == 1){
// 				entered2 = entered-b;
// 				var decide = (entered2%f) / f;
// 				//Если ближе к дополнительному ящику
// 				if(decide > 0.5){
// 					entered2 -= entered2%f;
// 					entered2 += f;
// 				}else{
// 				//Если ближе к -1 ящику
// 					entered2 -= entered2%f;
// 				}
// 				entered = entered2+b;
// 			}
// 			//Если больше нуля, но меньше, чем в ящике - ставим как в одном ящике
// 			else if((entered < b && entered > 0) || entered == b){
// 				entered = b;
// 			}
// 			$("#order_box_qty_surrogate_"+id).val(entered);
// 			//**
// 			c = entered/b;
// 			d = c*b;
// 			e = (d*price).toFixed(2);
// 			opt_basic_price = price;
// 			order_box_qty = c;
// 			order_opt_qty = d;
// 			order_opt_sum = e;
// 			//******************************************************
// 			$("#order_opt_qty_"+id).text(order_opt_qty+" шт.");
// 			$.ajax({
// 				url: URL_base+'ajaxcart',
// 				type: "POST",
// 				cache: false,
// 				dataType : "json",
// 				data: {
// 					"action": "update_qty",
// 					"opt": opt,
// 					"id_product": id,
// 					"order_box_qty": order_box_qty,
// 					"order_opt_qty": order_opt_qty,
// 					"order_opt_sum": order_opt_sum,
// 					"mopt_note": mopt_note,
// 					"opt_note": opt_note,
// 					"opt_correction": opt_correction,
// 					"opt_basic_price": opt_basic_price
// 				}
// 			}).done(function(obj){
// 				onCartSuccess(obj);
// 			});
// 		}else{
// 			$.ajax({
// 				url: URL_base+'ajaxcart',
// 				type: "POST",
// 				cache: false,
// 				dataType : "json",
// 				data: {
// 					"action": "update_qty",
// 					"opt": opt,
// 					"id_product": id,
// 					"order_box_qty": 0,
// 					"order_opt_qty": 0,
// 					"order_opt_sum": 0,
// 					"mopt_note": "",
// 					"opt_note": "",
// 					"opt_correction": null,
// 					"opt_basic_price": 0
// 				}
// 			}).done(function(obj){
// 				alert('Позиция не доступна по крупному опту.');
// 				onCartSuccess(obj);
// 			});
// 			$("#order_box_qty_"+id).val(0);
// 			$("#order_box_qty_surrogate_"+id).val(0);
// 		}
// 	}else{ // mopt
// 		var price, b, c, d, order_mopt_qty, order_mopt_sum;
// 		price = parseFloat($("#price_mopt_"+id+"_basic").text().replace(",",".")).toFixed(2);
// 		if(price > 0){
// 			b = parseFloat($("#min_mopt_qty_"+id).text());
// 			c = parseFloat($("#order_mopt_qty_"+id).val());
// 			i = parseFloat($("#inbox_qty_"+id).text());
// 			ra = checkqty(id, b, c, opt);
// 			if(!ra['success']){
// 				c = ra['num'];
// 				$("#order_mopt_qty_"+id).val(c);
// 				if(c!=0){
// 					alert("Требуется кратность минимальному количеству. Количество изменено на "+ra['num']+".");
// 				}
// 			}else{
// 				checkminqty(id, b, c, 'plus');
// 				c = parseFloat($("#order_mopt_qty_"+id).val());
// 			}
// 			d = (c*price).toFixed(2);
// 			ibq = parseFloat($("#inbox_qty_"+id).text());
// 			//if ((i-c)<0 && ibq>0){alert("Такое количество товара вы можете заказать по крупному опту.");}
// 			mopt_basic_price = price;
// 			order_mopt_qty = c;
// 			order_mopt_sum = d;
// 			//Number(e).toFixed(2).toString().replace(/\./g, ",");
// 			//alert(order_opt_sum);
// 			$.ajax({
// 				url: URL_base+'ajaxcart',
// 				type: "POST",
// 				cache: false,
// 				dataType : "json",
// 				data: {
// 					"action": "update_qty",
// 					"opt": opt,
// 					"id_product": id,
// 					"order_mopt_qty": order_mopt_qty,
// 					"order_mopt_sum": order_mopt_sum,
// 					"mopt_note": mopt_note,
// 					"opt_note": opt_note,
// 					"mopt_correction": mopt_correction,
// 					"mopt_basic_price": mopt_basic_price
// 				}
// 			}).done(function(obj){
// 				onCartSuccess(obj);
// 			});
// 		}else{
// 			$.ajax({
// 				url: URL_base+'ajaxcart',
// 				type: "POST",
// 				cache: false,
// 				dataType : "json",
// 				data: {
// 					"action": "update_qty",
// 					"opt": opt,
// 					"id_product": id,
// 					"order_mopt_qty": 0,
// 					"order_mopt_sum": 0,
// 					"mopt_note": "",
// 					"opt_note": "",
// 					"mopt_correction": null,
// 					"mopt_basic_price": 0
// 				}
// 			}).done(function(obj){
// 				$("#order_mopt_qty_"+id).val(0);
// 				alert('Позиция не доступна по мелкому опту.');
// 				onCartSuccess(obj);
// 			});
// 		}
// 	}
// }
// function toCart2(id, opt){
// 	var filial = parseFloat($(".filial_icon").attr("class"));
// 	var discount = parseFloat($("#cart_personal_discount").val());
// 	var opt_correction = $("#correction_set_price_opt_"+id).text().replace(/\s/g,"").split(';');
// 	var mopt_correction = $("#correction_set_price_mopt_"+id).text().replace(/\s/g,"").split(';');
// 	var opt_note = $("#opt_note_"+id).val();
// 	var mopt_note = $("#mopt_note_"+id).val();
// 	if(opt_note != ""){
// 		$("#ico_opt_"+id).attr("class", "done");
// 	}else{
// 		$("#ico_opt_"+id).attr("class", "error");
// 	}
// 	if(mopt_note != ""){
// 		$("#ico_mopt_"+id).attr("class", "done");
// 	}else{
// 		$("#ico_mopt_"+id).attr("class", "error");
// 	}
// 	if(opt == 1){
// 		var a, b, c, d, e, order_opt_qty, order_opt_sum;
// 		a = parseFloat($("#price_opt_"+id+"_basic").text().replace(",",".")).toFixed(2);
// 		b = parseFloat($("#inbox_qty_"+id).text());
// 		if(a > 0 && b > 0){
// 			//Подбор ближайшего кратного ящику
// 			var entered = parseFloat($("#order_box_qty_surrogate_"+id).val());
// 			//Если не кратно и введено больше, чем в одном ящике
// 			if(entered%b >0 && entered > b){
// 				var decide = (entered%b) / b;
// 				//Если ближе к дополнительному ящику
// 				if(decide > 0.5){
// 					entered -= entered%b;
// 					entered += b;
// 				}else{
// 				//Если ближе к -1 ящику
// 					entered -= entered%b;
// 				}
// 				$("#order_box_qty_surrogate_"+id).val(entered);
// 			}
// 			//Если больше нуля, но меньше, чем в ящике - ставим как в одном ящике
// 			else if(entered < b && entered >0){
// 				entered = b;
// 				$("#order_box_qty_surrogate_"+id).val(entered);
// 			}
// 			//**
// 			c = entered/b;
// 			d = c*b;
// 			e = (d*a).toFixed(2);
// 			opt_basic_price = a;
// 			order_box_qty = c;
// 			order_opt_qty = d;
// 			order_opt_sum = e;
// 			//******************************************************
// 			$("#order_opt_qty_"+id).text(order_opt_qty+" шт.");
// 			$.ajax({
// 				url: URL_base+'ajaxcart',
// 				type: "POST",
// 				cache: false,
// 				dataType : "json",
// 				data: {
// 					"action": "update_qty",
// 					"opt": opt,
// 					"id_product": id,
// 					"order_box_qty": order_box_qty,
// 					"order_opt_qty": order_opt_qty,
// 					"order_opt_sum": order_opt_sum,
// 					"mopt_note": mopt_note,
// 					"opt_note": opt_note,
// 					"opt_correction": opt_correction,
// 					"opt_basic_price": opt_basic_price
// 				},
// 				success: onCartSuccess
// 			});
// 		}else{
// 			$.ajax({
// 				url: URL_base+'ajaxcart',
// 				type: "POST",
// 				cache: false,
// 				dataType : "json",
// 				data: {
// 					"action": "update_qty",
// 					"opt": opt,
// 					"id_product": id,
// 					"order_box_qty": 0,
// 					"order_opt_qty": 0,
// 					"order_opt_sum": 0,
// 					"mopt_note": "",
// 					"opt_note": "",
// 					"opt_correction": null,
// 					"opt_basic_price": 0
// 				},
// 				success: onCartSuccess
// 			});
// 			$("#order_box_qty_"+id).val(0);
// 			$("#order_box_qty_surrogate_"+id).val(0);
// 			alert('Позиция не доступна по крупному опту.');
// 		}
// 	}else{ // mopt
// 		var a,b,c,d, order_mopt_qty, order_mopt_sum;
// 		a = parseFloat($("#price_mopt_"+id+"_basic").text().replace(",",".")).toFixed(2);
// 		if (a > 0){
// 			b = parseFloat($("#min_mopt_qty_"+id).text());
// 			c = parseFloat($("#order_mopt_qty_"+id).val());
// 			i = parseFloat($("#inbox_qty_"+id).text());
// 			ra = checkqty( id, b, c, opt );
// 			if(!ra['success']){
// 				c = ra['num'];
// 				$("#order_mopt_qty_"+id).val(c);
// 				if(c!=0){
// 					alert("Требуется кратность минимальному количеству. Количество изменено на "+ra['num']+".");
// 				}
// 			}else{
// 				checkminqty(id,b,c,'plus');
// 				c = parseFloat($("#order_mopt_qty_"+id).val());
// 			}
// 			d = (c*a).toFixed(2);
// 			ibq = parseFloat($("#inbox_qty_"+id).text());
// 			//if ((i-c)<0 && ibq>0){alert("Такое количество товара вы можете заказать по крупному опту.");}
// 			mopt_basic_price = a;
// 			order_mopt_qty = c;
// 			order_mopt_sum = d;
// 			//Number(e).toFixed(2).toString().replace(/\./g, ",");
// 			//alert(order_opt_sum);
// 			$.ajax({
// 				url: URL_base+'ajaxcart',
// 				type: "POST",
// 				cache: false,
// 				dataType : "json",
// 				data: {
// 					"action": "update_qty",
// 					"opt": opt,
// 					"id_product": id,
// 					"order_mopt_qty": order_mopt_qty,
// 					"order_mopt_sum": order_mopt_sum,
// 					"mopt_note": mopt_note,
// 					"opt_note": opt_note,
// 					"mopt_correction": mopt_correction,
// 					"mopt_basic_price": mopt_basic_price
// 				},
// 				success: onCartSuccess
// 			});
// 		}else{
// 			$.ajax({
// 				url: URL_base+'ajaxcart',
// 				type: "POST",
// 				cache: false,
// 				dataType : "json",
// 				data: {
// 					"action": "update_qty",
// 					"opt": opt,
// 					"id_product": id,
// 					"order_mopt_qty": 0,
// 					"order_mopt_sum": 0,
// 					"mopt_note": "",
// 					"opt_note": "",
// 					"mopt_correction": null,
// 					"mopt_basic_price": 0
// 				},
// 				success: onCartSuccess
// 			});
// 			$("#order_mopt_qty_"+id).val(0);
// 			alert('Позиция не доступна по мелкому опту.');
// 		}
// 	}
// }
// function onCartSuccess(obj){
// 	if(!obj.error){
// 		$(".order_cat").text(obj['total_quantity']);
// 		if(parseFloat(obj.string) > 0){
// 			$(".cart").addClass("full").removeClass("empty");
// 		}else{
// 			$(".cart").addClass("empty").removeClass("full");
// 		}
// 	}
// 	if($("#order_box_qty_"+obj.id_product).val() > 0 || $("#order_mopt_qty_"+obj.id_product).val() > 0){
// 		$(".p"+obj.id_product).css("background-color", "");
// 	}else{
// 		$(".p"+obj.id_product).css("background-color", "");
// 	}
// /*
// 	if ($("#order_box_qty_"+obj.id_product).val() == 1 || $("#order_mopt_qty_"+obj.id_product).val() == $('#min_mopt_qty_'+obj.id_product).text().replace(/\D+/g,"")) {
// 		$('#cat_table .price').stop(true, true).css({
// 			"background": "#F2930C",
// 			"z-index": "50"
// 		}).animate({
// 			"top": "30px"
// 		},{
// 			easing: 'easeOutCirc'
// 		}).animate({
// 			"top": "0px"
// 		},{
// 			duration: 1000,
// 			easing: 'easeOutElastic'
// 		});
// 		$('.price').animate({
// 			"background-color": "transparent"
// 		},{
// 			duration: 500
// 		}).animate({
// 			"background-color": "#F2930C"
// 		},{
// 			duration: 500
// 		}).animate({
// 			"background-color": "transparent"
// 		},{
// 			duration: 500
// 		});
// 	}*/
// 	if($("#order_box_qty_"+obj.id_product).val() > 0){
// 		$("#product_"+obj.id_product+" button").css("display", "none");
// 		$("#product_"+obj.id_product+" p.in_cart_js").css("display", "block");
// 	}else {
// 		$("#product_"+obj.id_product+" button").css("display", "block");
// 		$("#product_"+obj.id_product+" p.in_cart_js").css("display", "none");
// 	}
// 	if (window.pcart !== undefined){
// 		hookAfterCart(obj);
// 	}
// 	/*if (obj.sum > max_sum_order)
// 		alert("Внимание. Граничная Суммма наличного расчета одного предпринимателя с другим предпринимателем на протяжении одного дня по одному или нескольким платежным документам согласно постановления Правления Нацбанка Украины от 15.12.2004 №637 составляет 10000 гривен.");

// 	if (obj.sum > 100){
// 		$("#nac_1").fadeOut();
// 		$("#nac_2").fadeOut();
// 	}else{
// 		sum_total = parseFloat(Number(obj.sum_discount).toFixed(2));
// 		pr = parseFloat(sum_total/100*proc_rozn);
// 		sum_nac = parseFloat(sum_total + pr);

// 		$("#sum_nac").text(Number(sum_nac).toFixed(2));
// 		$("#nac_1").fadeIn();
// 		$("#nac_2").fadeIn();
// 	}*/
// 	cartUpdateInfo();
// }

// function onCartComent(){
// 	alert("Коментарий о позиции будет отображен на сайте после премодерации.");
// }
// function checkqty( id, need, req, is_opt ){
// 	if(is_numeric(req)){
// 		if(req!=0 && is_opt == 1){
// 			x = req/need;
// 			x = Number(x).toFixed(0);
// 			num = x*need;
// 			x = req%need;
// 			if(x!=0){
// 				return {success:false, num:num};
// 			}else{
// 				return {success:true};
// 			}
// 		}else{
// 			if(qtycontrol[id] == 1){
// 				x = req/need;
// 				x = Number(x).toFixed(0);
// 				num = x*need;
// 				x = req%need;
// 				if(x!=0){
// 					return {success:false, num:num};
// 				}else{
// 					return {success:true};
// 				}
// 			}else{
// 				return {success:true};
// 			}
// 		}
// 	}else{
// 		return {success:false, num:0};
// 	}
// }
// function checkminqty(id, need, req, direction){
// 	if(is_numeric(req)){
// 		if(req != 0 && req < need){
// 			if(direction=='minus')
// 				need = 0;
// 			$("#order_mopt_qty_"+id).val(need);
// 			/*if(need != 0){
// 				alert("Установлено минимальное количество. Количество изменено на "+need+".");
// 			}*/
// 		}
// 	}
// }
// function ch_qty(opt, direction, id){
// 	var discount = parseFloat($("#cart_personal_discount").val());
// 	var opt_correction = $("#correction_set_price_opt_"+id).text().replace(/\s/g,"").split(';');
// 	var mopt_correction = $("#correction_set_price_mopt_"+id).text().replace(/\s/g,"").split(';');
// 	if(opt == 1){
// 		//alert(direction);
// 		price = (parseFloat($("#price_opt_"+id+"_basic").text().replace(",",".")) * opt_correction[3]).toFixed(2);
// 		c = parseFloat($("#order_box_qty_"+id).val());
// 		z = parseFloat($("#inbox_qty_"+id).text());
// 		x = parseFloat($("#multiplicity_"+id).text());
// 		g = parseFloat($("#order_mopt_qty_"+id).val());
// 		if(g > z && g > $("#order_box_qty_surrogate_"+id).val()){
// 			c = g/z;
// 		}
// 		if(direction == 'plus' && price > 0){
// 			if(c == 0){
// 				c += 1;
// 				total_qty = c*z;
// 			}else if(c == 1){
// 				total_qty = z+x;
// 				c = total_qty/z;
// 			}else{
// 				total_qty = parseFloat((c*z).toFixed())+x;
// 				c = total_qty/z;
// 			}
// 			$("#order_box_qty_"+id).val(c);
// 			$("#order_box_qty_surrogate_"+id).val(total_qty);
// 		}else if(direction == 'minus' && price > 0){
// 			if(c != 0){
// 				if(c <= 1){
// 					c = 0;
// 					total_qty = parseFloat((c*z).toFixed());
// 				}else{
// 					total_qty = parseFloat((c*z).toFixed())-x;
// 					c = total_qty/z;
// 				}
// 				$("#order_box_qty_"+id).val(c);
// 				$("#order_box_qty_surrogate_"+id).val(total_qty);
// 			}
// 		}
// 	}else if(opt == 0){
// 		b = 1;
// 		if(qtycontrol[id] == 1){
// 			b = parseFloat($("#min_mopt_qty_"+id).text());
// 		}
// 		price = (parseFloat($("#price_mopt_"+id+"_basic").text().replace(",",".")) * mopt_correction[3]).toFixed(2);
// 		c = parseFloat($("#order_mopt_qty_"+id).val());
// 		e = parseFloat($("#order_box_qty_"+id).val());
// 		if(e > 0 && c == b-1){
// 			alert('Вы уже заказали этот товар по оптовой цене.');
// 		}
// 		if(direction == 'plus' && price > 0){
// 			c += b;
// 			$("#order_mopt_qty_"+id).val(c);
// 		}else if(direction == 'minus' && price > 0){
// 			if(c != 0){
// 				c -= b;
// 				$("#order_mopt_qty_"+id).val(c);
// 			}
// 		}
// 	}
// 	if(price > 0){
// 		b = parseFloat($("#min_mopt_qty_"+id).text());
// 		c = parseFloat($("#order_mopt_qty_"+id).val());
// 		checkminqty(id, b, c, direction);
// 		toCart(id, opt);
// 	}else{
// 		if(opt == 1){
// 			$.ajax({
// 				url: URL_base+'ajaxcart',
// 				type: "POST",
// 				cache: false,
// 				dataType : "json",
// 				data: {
// 					"action":"update_qty",
// 					"opt":opt,
// 					"id_product":id,
// 					"order_box_qty":0,
// 					"order_opt_qty":0,
// 					"order_opt_sum":0,
// 					"mopt_note":"",
// 					"opt_note":"",
// 					"opt_correction": null,
// 					"opt_basic_price":0
// 				},
// 				success: onCartSuccess
// 			});
// 			$("#order_box_qty_"+id).val(0);
// 			$("#order_box_qty_surrogate_"+id).val(0);
// 		}else{
// 			$.ajax({
// 				url: URL_base+'ajaxcart',
// 				type: "POST",
// 				cache: false,
// 				dataType : "json",
// 				data: {
// 					"action":"update_qty",
// 					"opt":opt,
// 					"id_product":id,
// 					"order_mopt_qty":0,
// 					"order_mopt_sum":0,
// 					"mopt_note":"",
// 					"opt_note":"",
// 					"mopt_correction": null,
// 					"mopt_basic_price":0
// 				},
// 				success: onCartSuccess
// 			});
// 			$("#order_mopt_qty_"+id).val(0);
// 		}
// 		alert("Позиция не доступна.");
// 	}
// }
// function ch_qty2( opt, direction, id ){
// 	var discount = parseFloat($("#cart_personal_discount").val());
// 	var opt_correction = $("#correction_set_price_opt_"+id).text().replace(/\s/g,"").split(';');
// 	var mopt_correction = $("#correction_set_price_mopt_"+id).text().replace(/\s/g,"").split(';');
// 	if(opt == 1){
// 		//alert(direction);
// 		p = (parseFloat($("#price_opt_"+id+"_basic").text().replace(",",".")) * opt_correction[3]).toFixed(2);
// 		c = parseFloat($("#order_box_qty_"+id).val());
// 		z = parseFloat($("#inbox_qty_"+id).text());
// 		if(direction == 'plus' && p > 0){
// 			c += 1;
// 			total_qty=c*z;
// 			$("#order_box_qty_"+id).val(c);
// 			$("#order_box_qty_surrogate_"+id).val(total_qty);
// 		}else if(direction == 'minus' && p > 0){
// 			if(c != 0){
// 				c -= 1;
// 				total_qty=c*z;
// 				$("#order_box_qty_"+id).val(c);
// 				$("#order_box_qty_surrogate_"+id).val(total_qty);
// 			}
// 		}

// 	}else if(opt==0){
// 		b = 1;
// 		if(qtycontrol[id] == 1){
// 			b = parseFloat($("#min_mopt_qty_"+id).text());
// 		}
// 		p = (parseFloat($("#price_mopt_"+id+"_basic").text().replace(",",".")) * mopt_correction[3]).toFixed(2);
// 		c = parseFloat($("#order_mopt_qty_"+id).val());
// 		if(direction == 'plus' && p > 0){
// 			c = c+b;
// 			$("#order_mopt_qty_"+id).val(c);

// 		}else if(direction == 'minus' && p > 0){
// 			if(c != 0){
// 				c = c-b;
// 				$("#order_mopt_qty_"+id).val(c);
// 			}
// 		}
// 	}
// 	if(p > 0){
// 		b = parseFloat($("#min_mopt_qty_"+id).text());
// 		c = parseFloat($("#order_mopt_qty_"+id).val());
// 		checkminqty(id, b, c, direction);
// 		toCart(id, opt);
// 	}else{
// 		if(opt == 1){
// 			$.ajax({
// 				url: URL_base+'ajaxcart',
// 				type: "POST",
// 				cache: false,
// 				dataType : "json",
// 				data: {
// 					"action":"update_qty",
// 					"opt":opt,
// 					"id_product":id,
// 					"order_box_qty":0,
// 					"order_opt_qty":0,
// 					"order_opt_sum":0,
// 					"mopt_note":"",
// 					"opt_note":"",
// 					"opt_correction": null,
// 					"opt_basic_price":0
// 				},
// 				success: onCartSuccess
// 			});

// 			$("#order_box_qty_"+id).val(0);
// 			$("#order_box_qty_surrogate_"+id).val(0);
// 		}else{
// 			$.ajax({
// 				url: URL_base+'ajaxcart',
// 				type: "POST",
// 				cache: false,
// 				dataType : "json",
// 				data: {
// 					"action":"update_qty",
// 					"opt":opt,
// 					"id_product":id,
// 					"order_mopt_qty":0,
// 					"order_mopt_sum":0,
// 					"mopt_note":"",
// 					"opt_note":"",
// 					"mopt_correction": null,
// 					"mopt_basic_price":0
// 				},
// 				success: onCartSuccess
// 			});
// 			$("#order_mopt_qty_"+id).val(0);
// 		}
// 		alert("Позиция не доступна.");
// 	}
// }
// function CheckNotes(id,opt){
// 	opt_note = $("#opt_note_"+id).val();
// 	mopt_note = $("#mopt_note_"+id).val();
// 	if(opt == 1 && opt_note == ''){
// 		alert("Позиция требует заполнения примечания по крупному опту. Возможно необходимо указать выбранный Вами цвет, размер и т.п.");
// 		$("#order_box_qty_"+id).val(0);
// 		$("#order_box_qty_surrogate_"+id).val(5);
// 		//return false;
// 	}
// 	if(opt == 0 && mopt_note == ''){
// 		alert("Позиция требует заполнения примечания по мелкому опту. Возможно необходимо указать выбранный Вами цвет, размер и т.п.");
// 		$("#order_mopt_qty_"+id).val(0);
// 		//return false;
// 	}
// 	return true;
// }
// function is_numeric(mixed_var) {
// 	return (mixed_var == '') ? false : !isNaN(mixed_var);
// }
// function hookAfterCart(obj){
// 	//Скидка
// 	var wholesale_discount = parseFloat($("#cart_wholesale_discount").val());
// 	//Наценка
// 	var retail_multiplyer = parseFloat($("#cart_retail_multiplyer").val());
// 	$("#cart_order_mopt_sum").text(parseFloat(obj.order_mopt_sum).toFixed(2));
// 	$("#cart_order_opt_sum").text(parseFloat(obj.order_opt_sum).toFixed(2));
// 	$("#corrected_sum_0").text(parseFloat(obj.order_sum[0]).toFixed(2));
// 	$("#corrected_sum_1").text(parseFloat(obj.order_sum[1]).toFixed(2));
// 	$("#corrected_sum_2").text(parseFloat(obj.order_sum[2]).toFixed(2));
// 	$("#corrected_sum_3").text(parseFloat(obj.order_sum[3]).toFixed(2));
// 	$("#cart_order_sum").text(parseFloat(obj.sum_discount).toFixed(2));
// 	//*Получение количества товаров из полей
// 	var item_opt_qty = parseFloat($("#order_box_qty_surrogate_"+obj.id_product).val());
// 	var item_mopt_qty = parseFloat($("#order_mopt_qty_"+obj.id_product).val());

// 	if(!isNaN(item_opt_qty) && !isNaN(item_mopt_qty)){
// 		var item_total_qty = item_opt_qty + item_mopt_qty;
// 	}else if(!isNaN(item_opt_qty)){
// 		var item_total_qty = item_opt_qty
// 		var item_mopt_qty = 0;
// 	}else if(!isNaN(item_mopt_qty)){
// 		var item_total_qty = item_mopt_qty
// 		var item_opt_qty = 0;
// 	}
// 	var item_opt_price = parseFloat($("#price_opt_"+obj.id_product).text());
// 	var item_mopt_price = parseFloat($("#price_mopt_"+obj.id_product).text());
// 	//Сумма по оптам товара
// 	var item_opt_sum = item_opt_price * item_opt_qty;
// 	var item_mopt_sum = item_mopt_price * item_mopt_qty;
// 	var item_total_qty = item_opt_qty + item_mopt_qty;
// 	//Обновляем столбцы Сумм
// 	//Для опта
// 	$("#order_opt_sum_"+obj.id_product).text(item_opt_sum.toFixed(2));
// 	//Для мопта
// 	$("#order_mopt_sum_"+obj.id_product).text(item_mopt_sum.toFixed(2));
// 	//Для общего количества
// 	$("#cart_item_total_qty_"+obj.id_product).text(item_total_qty + " шт.");
// 	//Обновляем примечания
// 	if(obj.note_opt !== undefined){
// 		$("#cart_note_opt_"+obj.id_product).text(obj.note_opt);
// 	}
// 	if(obj.note_mopt !== undefined){
// 		$("#cart_note_mopt_"+obj.id_product).text(obj.note_mopt);
// 	}
// 	cartUpdateInfo();
// }
// //*********************************************************************************************************
// //Выводит подсказки в корзине, в зависимости от Суммы заказа
// //Подсказки рекомендуют клиенту воспользоваться скидкой, приобретая товары на определенную Сумму
// //Обновляет столбец цен, в зависимости от Суммы заказа
// function cartUpdateInfo(){
// 	var discount = parseFloat($("#cart_personal_discount").val());
// 	var mode = parseFloat($("#cart_price_mode").val());
// 	var opt_sum =  parseFloat($("#cart_order_opt_sum").text().replace(",","."));
// 	var mopt_sum = parseFloat($("#cart_order_mopt_sum").text().replace(",","."));
// 	var order_sum = opt_sum + mopt_sum;
// 	var corrected_sum = new Array();
// 	corrected_sum[0] = parseFloat($("#corrected_sum_0").text().replace(",","."));
// 	corrected_sum[1] = parseFloat($("#corrected_sum_1").text().replace(",","."));
// 	corrected_sum[2] = parseFloat($("#corrected_sum_2").text().replace(",","."));
// 	corrected_sum[3] = parseFloat($("#corrected_sum_3").text().replace(",","."));
// 	//$("#sum_discount").text(Number(obj.sum_discount).toFixed(2)+" грн.");
// 	//wholesale_margin - Сумма, выше которой даем скидку
// 	//wholesale_discount - скидка
// 	//retail_margin - Сумма, ниже которой даем наценку
// 	//wholesale_multiplyer - наценка
// 	if($("#cart_discount_and_margin_parameters").length > 0){
// 		// Сумма, с которой начисляем крупнооптовую скидку 								8000
// 		var full_wholesale_margin = parseFloat($("#cart_full_wholesale_order_margin").val());
// 		// Сумма, с которой начисляем оптовую скидку 									2000
// 		var wholesale_margin = parseFloat($("#cart_wholesale_order_margin").val());
// 		// Сумма, ДО котрой ничего не начисляем											500
// 		var retail_margin = parseFloat($("#cart_retail_order_margin").val());
// 		// Личная скидка
// 		var personal_discount = parseFloat($("#cart_personal_discount").val());
// 		if(mode == 1){
// 			$(".cart_your_price").each(function(){
// 				var id = $(this).attr('id');
// 				var opt_correction = $("#correction_set_"+id).text().replace(/\s/g,"").split(';');
// 				var mopt_correction = $("#correction_set_"+id).text().replace(/\s/g,"").split(';');
// 				if(opt_correction.length == 0){
// 					var correction = mopt_correction;
// 				}else{
// 					var correction = opt_correction;
// 				}
// 				var old_price = parseFloat($('#'+id+'_basic').text().replace(",","."));
// 				var new_price = (old_price * (correction[3] * personal_discount)).toFixed(2);
// 				$(this).text(new_price.replace(".",",") + " грн.");
// 				var id_integer = $(this).attr('name');
// 				cartSetItemSum( id_integer );
// 			});
// 			//Подсказка
// 			$("#cart_order_tip").hide();
// 			$("#cart_order_tip_multiplyer").hide();
// 			$("#cart_order_tip_discount").hide();
// 			$("#cart_order_tip_wholesale").hide();
// 		}else{
// 			$(".cart_your_price").each(function(){
// 				var id = $(this).attr('id');
// 				var opt_correction = $("#correction_set_"+id).text().replace(/\s/g,"").split(';');
// 				var mopt_correction = $("#correction_set_"+id).text().replace(/\s/g,"").split(';');
// 				var correction;
// 				if(opt_correction.length == 0){
// 					correction = mopt_correction;
// 				}else{
// 					correction = opt_correction;
// 				}
// 				var old_price = parseFloat($('#'+id+'_basic').text().replace(",","."));
// 				var new_price = 0;
// 				if(corrected_sum[3] >= retail_margin && corrected_sum[2] < wholesale_margin){	//Наценка
// 					new_price = (old_price * correction[2]).toFixed(2);
// 					//Подсказка
// 				}else if(corrected_sum[2] >= wholesale_margin && corrected_sum[1] < full_wholesale_margin){	//Скидка
// 					new_price = (old_price * correction[1]).toFixed(2);
// 					//Подсказка
// 					$("#cart_order_tip").slideDown();
// 					$("#cart_order_tip_multiplyer").slideUp();
// 					$("#cart_order_tip_discount").slideUp();
// 					$("#cart_order_tip_wholesale").slideDown();
// 				}else if(corrected_sum[1] >= full_wholesale_margin){	//Скидка
// 					new_price = (old_price * correction[0]).toFixed(2);
// 					//Подсказка
// 					$("#cart_order_tip").slideDown();
// 					$("#cart_order_tip_multiplyer").slideUp();
// 					$("#cart_order_tip_discount").slideUp();
// 					$("#cart_order_tip_wholesale").slideUp();
// 				}else{	//По умолчанию
// 					new_price = (old_price * correction[3]).toFixed(2);
// 					//Подсказка
// 					$("#cart_order_tip").slideDown();
// 					$("#cart_order_tip_multiplyer").slideDown();
// 					$("#cart_order_tip_discount").slideUp();
// 					$("#cart_order_tip_wholesale").slideUp();
// 				}
// 				$(this).text(new_price.replace(".",",") + " грн.");
// 				var id_integer = $(this).attr('name');
// 				cartSetItemSum( id_integer );
// 			});
// 		}
// 	}	//Проверка на наличие формы с параметрами (величины наценок и границ для их применения)
// }
// //********************************************************************************************************
// //Удаление товара из корзины
// function cartRemove( id ){
// 	//Посылаем запросы на удаление товара по опту и рознице
// 	$.ajax({
// 		url: URL_base+'ajaxcart',
// 		type: "POST",
// 		cache: false,
// 		dataType : "json",
// 		data: {
// 			"action":"update_qty",
// 			"opt":1,
// 			"id_product":id,
// 			"order_box_qty":0,
// 			"order_opt_qty":0,
// 			"order_opt_sum":0,
// 			"mopt_note":"",
// 			"opt_note":""
// 		},
// 		success: onCartSuccess
// 	});
// 	$.ajax({
// 		url: URL_base+'ajaxcart',
// 		type: "POST",
// 		cache: false,
// 		dataType : "json",
// 		data: {
// 			"action":"update_qty",
// 			"opt":0,
// 			"id_product":id,
// 			"order_mopt_qty":0,
// 			"order_mopt_sum":0,
// 			"mopt_note":"",
// 			"opt_note":""
// 		},
// 		success: onCartSuccess
// 	});
// 	//Скрываем строку товара из таблицы
// 	$("#cat_item_"+id+"_mopt").fadeOut(700);
// 	$("#cat_item_"+id+"_opt").fadeOut(700);
// 	cartUpdateInfo();
// }
// //********************
// function cartSetItemSum( id ){
// 	var item_opt_qty = parseFloat($("#order_box_qty_surrogate_"+id).val());
// 	var item_mopt_qty = parseFloat($("#order_mopt_qty_"+id).val());
// 	if(isNaN(item_opt_qty)){
// 		var item_opt_qty = 0;
// 	}
// 	if(isNaN(item_mopt_qty)){
// 		var item_mopt_qty = 0;
// 	}
// 	var item_opt_price = parseFloat($("#price_opt_"+id).text().replace(",",".")).toFixed(2);
// 	var item_mopt_price = parseFloat($("#price_mopt_"+id).text().replace(",",".")).toFixed(2);

// 	var item_opt_sum = (item_opt_price * item_opt_qty).toFixed(2);
// 	var item_mopt_sum = (item_mopt_price * item_mopt_qty).toFixed(2);
// 	//Для опта
// 	$("#order_opt_sum_"+id).text(item_opt_sum.replace(".",","));

// 	//Для мопта
// 	$("#order_mopt_sum_"+id).text(item_mopt_sum.replace(".",","));
// }


