function SendToAjax(id, qty, button, direction, note){
	$.ajax({
		url: URL_base+'ajaxcart',
		type: "GET",
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
			/*$('div[data-idproduct="'+id+'"]').find('.buy_btn_js').addClass('hidden');*/
			/*$('div[data-idproduct="'+id+'"]').find('.buy_btn_js').addClass('one_plus');*/
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

function ChangeCartQty(id, direction){
	/* direction: 0 - minus, 1 - plus; */

	var qty = parseInt($('.product_buy[data-idproduct="'+id+'"]').find('.qty_js').val());
	/*console.log(qty);*/
	if(current_controller == 'cart'){
		var note = $('#cart_item_'+id).find('.note textarea').val();
	}else{
		var note = $('#product_'+id).find('.note textarea').val();
	}
	if(direction == 1){
		SendToAjax(id, qty+1, true, direction,note);
	}else if(direction == 0){
		SendToAjax(id, qty-1, true, direction,note);
	}else{
		SendToAjax(id, qty, true, direction,note);
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
		type: "GET",
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