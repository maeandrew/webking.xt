function SendToAjax(id, qty, button, direction, note){

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
		//console.log(data);
		completeCartProductAdd(data.cart);
		qty = data.product.quantity;
		var mode_text = 'от';
		if(qty == 0){
			$('div[data-idproduct="'+id+'"]').find('.qty_js').val(0);
			// $('div[data-idproduct="'+id+'"]').find('.buy_btn_js').removeClass('hidden');
			$('div[data-idproduct="'+id+'"]').find('.buy_btn_js').text('Купить');
			$('div[data-idproduct="'+id+'"]').find('.in_cart_js').addClass('hidden');
		}else{
			$('div[data-idproduct="'+id+'"]').find('.qty_js').val(qty);
			$('div[data-idproduct="'+id+'"]').find('.in_cart_js').removeClass('hidden');
			/*$('div[data-idproduct="'+id+'"]').find('.buy_btn_js').addClass('hidden');*/
			$('div[data-idproduct="'+id+'"]').find('.buy_btn_js').text('+');
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
	});
}

// Удаление в корзине товара при нажатии на иконку
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
		completeCartProductAdd(data);
		$('#cart_item_'+id).hide(200).remove();

	});
}

function ChangeCartQty(id, direction){
	/* direction: 0 - minus, 1 - plus; */

	var qty = parseInt($('.product_buy[data-idproduct="'+id+'"]').find('.qty_js').val());
	/*console.log(qty);*/
	if(current_controller == 'cart'){
		var note = $('#cart_item_'+id).find('.note textarea').val();
	}else{
		var note = $('#product_'+id).find('.note textarea').val();
	}
	$('.order_mopt_sum_'+id).text();
	if(direction == 1){
		//console.log(qty);
		SendToAjax(id, qty+1, true, direction,note);
	}else if(direction == 0){
		SendToAjax(id, qty-1, true, direction,note);
	}else{
		SendToAjax(id, qty, true, direction,note);
	}

}

function completeCartProductAdd(data){
	//console.log(data['products_sum'][0]);
	var products_count = Object.keys(data.products).length.toString();
	var	str = products_count+' товар';
	if(products_count.substr(-1) <= 1)
		str += '';
	else if(products_count.substr(-1) >= 2 && products_count.substr(-1) <= 4)
		str += 'а';
	else
		str += 'ов';
	$('.order_cart').text(str);
	$('#summ_many').text(data.products_sum[3]);
	//$('#summ_many').text(data.cart_sum);
	$('#summ_prod').text(products_count);
	if(products_count > 0){
		$('.checkout').removeClass('hidden');
	}else{
		$('.checkout').addClass('hidden');
	}
	//$.each(data.cart.products, function(key, value){
	//	$('div[data-idproduct="'+key+'"]').find('.active_price .price_js').text(value.actual_prices[data.cart.cart_column].toFixed(2));
	//	$('.order_mopt_sum_'+key).text(value.summary[data.cart.cart_column].toFixed(2));
	//});
	var sum_sale = (data.products_sum[3] - data.products_sum[data.cart_column]).toFixed(2);
	//console.log(sum_sale);
	$('.summ_many:eq(1)').text(sum_sale);
	$('.summ_many:eq(2)').text((data.products_sum[3]- sum_sale).toFixed(2));

//----------------обновление облока скидок (start)---------------

	if(data.cart_sum >= 500){
		$('#percent tr:eq(0)').hide();
		$('#percent tr:eq(1)').css('color', '#000');
		$('#percent td:eq(5)').text((3000-data.cart_sum).toFixed(2)+'грн');
		$('#perc_cont .your_discount').text('Ваша скидка '+ (data.cart_sum * 0.1).toFixed(2) +' грн (10%)');
		$('#percent td:eq(4)').text('Добавь:');
		$('#percent td:eq(6)').text('Получи скидку:');
	}
	if(data.cart_sum < 500){
		$('#percent tr:eq(0)').show();
		$('#percent td:eq(1)').text((500-data.cart_sum).toFixed(2)+'грн');
		$('#percent td:eq(5)').text((3000-data.cart_sum).toFixed(2)+'грн');
		$('#percent td:eq(9)').text((10000-data.cart_sum).toFixed(2)+'грн');
		$('#perc_cont .your_discount').text('Ваша скидка 00.00 грн (0%)');
		$('#percent td:eq(0)').text('Добавь:');
		$('#percent td:eq(2)').text('Получи скидку:');
		$('#percent td:eq(4)').text('');
		$('#percent td:eq(6)').text('');
	}
	if(data.cart_sum >= 3000){
		$('#percent tr:eq(1)').hide();
		$('#percent tr:eq(2)').css('color', '#000');
		$('#percent td:eq(5)').text((10000-data.cart_sum).toFixed(2)+'грн');
		$('#perc_cont .your_discount').text('Ваша скидка '+ (data.cart_sum * 0.16).toFixed(2) +' грн (16%)');
		$('#percent td:eq(8)').text('Добавь:');
		$('#percent td:eq(10)').text('Получи скидку:');
	}
	if(data.cart_sum < 3000 && data.cart_sum >= 500){
		$('#percent tr:eq(1)').show();
		$('#percent td:eq(5)').text((3000-data.cart_sum).toFixed(2)+'грн');
		$('#percent td:eq(9)').text((10000-data.cart_sum).toFixed(2)+'грн');
		$('#perc_cont .your_discount').text('Ваша скидка '+ (data.cart_sum * 0.1).toFixed(2) +' грн (10%)');
		$('#percent td:eq(4)').text('Добавь:');
		$('#percent td:eq(6)').text('Получи скидку:');
		$('#percent td:eq(8)').text('');
		$('#percent td:eq(10)').text('');
		$('#percent td:eq(9)').css('color','grey');
		$('#percent td:eq(11)').css('color','grey');
	}
	if(data.cart_sum >= 10000){
		$('#percent tr:eq(2)').hide();
		$('#perc_cont .your_discount').text('Ваша скидка '+ (data.cart_sum * 0.21).toFixed(2) +' грн (21%)');
	}

	//if($('#percent tr:eq(0)').is(':visible')){
	//	$('#percent tr:eq(0)').css('color', '#000');
	//}
	//if($('#percent tr:eq(0)').is(':hidden')){
	//	$('#percent tr:eq(1)').css('color', '#000');
	//}
	//if($('#percent tr:eq(1)').is(':hidden')){
	//	$('#percent tr:eq(2)').css('color', '#000');
	//}
//----------------обновление облока скидок (end)---------------

}
