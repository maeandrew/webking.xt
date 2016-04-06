function SendToAjax(id, qty, button, direction, note){
	var data = {id_product: id, quantity: qty, button: button, direction: direction, note: note};
	ajax('cart', 'update_cart_qty', data).done(function(data){
		completeCartProductAdd(data.cart);
		qty = data.product.quantity;
		//console.log(data.cart.cart_column);
		var mode_text = 'от';
		if(qty == 0){
			$('div[data-idproduct="'+id+'"]').find('.qty_js').val(0);
			$('div[data-idproduct="'+id+'"]').find('.in_cart_js').addClass('hidden');
			$('div[data-idproduct="'+id+'"]').find('.buy_btn_js').removeClass('hidden');
		}else{
			var qty_old = parseInt($('.product_buy[data-idproduct="'+id+'"]').find('.qty_js_old').val());
			$('div[data-idproduct="'+id+'"]').find('.qty_js').val(qty);
			if(qty_old == qty){
				$('.btn_remove').find('.info_description').removeClass('hidden');
				//var id_prod_name = $('.btn_remove div').attr('id');

				$('.btn_remove button').on('click', function() {
					$('div[data-idproduct="'+id+'"]').find('.price').text(data.cart.products[id].actual_prices[data.cart.cart_column]);
				});
			}else{
				if ($('.btn_remove').find('.info_description').not('hidden')) {
					$('.btn_remove').find('.info_description').addClass('hidden');
				};
			};
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
		if($('#cart').hasClass('opened')){
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
		removeLoadAnimation('div[data-idproduct="'+id+'"]');
	});
}

// Удаление в корзине товара при нажатии на иконку
function removeFromCart(id){
	if(!id) {
		ajax('cart', 'clearCart').done(function (data) {
			$('#removingProd').addClass('hidden');
			$('.modal_container').find('.card').addClass('hidden');
			$('.products').find('.in_cart_js').addClass('hidden');
			$('.products').find('.buy_btn_js').removeClass('hidden');

			$('.quantity').each(function(){
			    var minQty = $(this).find('.minQty').val();
			    console.log(minQty);
			    $(this).find('.qty_js').val(minQty);
			});

			/*$('.card').each(function(){

				console.log($(this).find('.quantity input[type="text"]').val())
			});*/


			/*location.reload();*/
		});
	}else {
		ajax('cart', 'remove_from_cart', {id: id}).done(function (data) {
			$('#removingProd').addClass('hidden');
			var minQty = $('.products #in_cart_' + id).closest('.buy_block').find('.minQty').val();
			/*console.log(minQty);*/
			/*Position('cart');*/
			completeCartProductAdd(data);
			$('#cart_item_' + id).hide(200).remove();
			$('.products #in_cart_' + id).addClass('hidden');
			$('.products #in_cart_' + id).closest('.btn_buy').find('.buy_btn_js').removeClass('hidden');
			$('.products #in_cart_' + id).closest('.buy_block').find('.qty_js').val(minQty);
		});
	}
}

function ChangeCartQty(id, direction){
	/* direction: 0 - minus, 1 - plus; */
	var qty = parseInt($('.product_buy[data-idproduct="'+id+'"]').find('.qty_js').val());
	addLoadAnimation('.product_buy[data-idproduct="'+id+'"]');
	if(current_controller == 'cart'){
		var note = $('#cart_item_'+id).find('.note textarea').val();
	}else{
		var note = $('#product_'+id).find('.note textarea').val();
	}
	if(direction == 1){
		SendToAjax(id, qty+1, true, direction, note);
	}else if(direction == 0){
		SendToAjax(id, qty-1, true, direction, note);
	}else{
		SendToAjax(id, qty, false, false, note);
	}

}

function completeCartProductAdd(data){
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
	$('#summ_prod').text(products_count);
	if(products_count > 0){
		$('.checkout').removeClass('hidden');
	}else{
		$('.checkout').addClass('hidden');
	}
	var sum_sale = (data.products_sum[3] - data.products_sum[data.cart_column]).toFixed(2);
	$('.summ_many:eq(1)').text(sum_sale);
	$('.summ_many:eq(2)').text((data.products_sum[3]- sum_sale).toFixed(2));

	// обновление облока скидок (start)
	if(data.products_sum[3] >= 500){
		$('#percent tr:eq(0)').hide();
		$('#percent tr:eq(1)').css('color', '#000');
		$('#percent td:eq(5)').text((3000-data.cart_sum).toFixed(2)+'грн');
		$('#perc_cont .your_discount').text('Ваша скидка '+ (data.cart_sum * 0.1).toFixed(2) +' грн (10%)');
		$('#percent td:eq(4)').text('Добавьте:');
		$('#percent td:eq(6)').text('Получите скидку:');
		$('#percent td:eq(9)').css('color','#9E9E9E');
		$('#percent td:eq(11)').css('color','#9E9E9E');
		$('#percent td:eq(5)').css('color','');
		$('#percent td:eq(7)').css('color','');
		$('#percent td:eq(10)').css('color','');
		$('#percent td:eq(12)').css('color','');
	}
	if(data.products_sum[3] < 500){
		$('#percent tr:eq(0)').show();
		$('#percent td:eq(1)').text((500-data.cart_sum).toFixed(2)+'грн');
		$('#percent td:eq(5)').text((3000-data.cart_sum).toFixed(2)+'грн');
		$('#percent td:eq(9)').text((10000-data.cart_sum).toFixed(2)+'грн');
		$('#perc_cont .your_discount').text('Ваша скидка 00.00 грн (0%)');
		$('#percent td:eq(0)').text('Добавьте:');
		$('#percent td:eq(2)').text('Получите скидку:');
		$('#percent td:eq(4)').text('');
		$('#percent td:eq(6)').text('');
		$('#percent td:eq(8)').text('');
		$('#percent td:eq(10)').text('');
		$('#percent td:eq(9)').css('color','#9E9E9E');
		$('#percent td:eq(11)').css('color','#9E9E9E');
		$('#percent td:eq(7)').css('color','#9E9E9E');
		$('#percent td:eq(5)').css('color','#9E9E9E');
	}
	if(data.products_sum[3] >= 3000){
		$('#percent tr:eq(1)').hide();
		$('#percent tr:eq(2)').css('color', '#000');
		$('#percent td:eq(5)').text((10000-data.cart_sum).toFixed(2)+'грн');
		$('#perc_cont .your_discount').text('Ваша скидка '+ (data.cart_sum * 0.16).toFixed(2) +' грн (16%)');
		$('#percent td:eq(8)').text('Добавьте:');
		$('#percent td:eq(10)').text('Получите скидку:');
		$('#percent td:eq(9)').css('color','');
		$('#percent td:eq(11)').css('color','');
	}
	if(data.products_sum[3] < 3000 && data.products_sum[3] >= 500){
		$('#percent tr:eq(1)').show();
		$('#percent td:eq(5)').text((3000-data.cart_sum).toFixed(2)+'грн');
		$('#percent td:eq(9)').text((10000-data.cart_sum).toFixed(2)+'грн');
		$('#perc_cont .your_discount').text('Ваша скидка '+ (data.cart_sum * 0.1).toFixed(2) +' грн (10%)');
		$('#percent td:eq(4)').text('Добавьте:');
		$('#percent td:eq(6)').text('Получите скидку:');
		$('#percent td:eq(8)').text('');
		$('#percent td:eq(10)').text('');
		$('#percent td:eq(9)').css('color','#9E9E9E');
		$('#percent td:eq(11)').css('color','#9E9E9E');
	}
	if(data.products_sum[3] >= 10000){
		$('#percent tr:eq(2)').hide();
		$('#perc_cont .your_discount').text('Ваша скидка '+ (data.cart_sum * 0.21).toFixed(2) +' грн (21%)');
	}

}