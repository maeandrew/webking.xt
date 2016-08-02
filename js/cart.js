/**
 * [SendToAjax description]
 * @param {[type]} id        [description]
 * @param {[type]} qty       [description]
 * @param {[type]} button    [description]
 * @param {[type]} direction [description]
 * @param {[type]} note      [description]
 */
function SendToAjax(id, qty, button, direction, note){
	var data = {id_product: id, quantity: qty, button: button, direction: direction, note: note};
	ajax('cart', 'updateCartQty', data).done(function(data){
		$('header .cart_item a.cart i').attr('data-badge', countOfObject(data.cart.products));
		$('.clear_cart').removeClass('hidden');

		completeCartProductAdd(data.cart);

		qty = data.product.quantity;
		var mode_text = 'от';
		if(qty === 0){
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
					$('div[data-idproduct="'+id+'"]').find('.price').text(data.cart.products[id].actual_prices[data.cart.cart_column].toFixed(2).toString().replace('.',','));
				});
			}else{
				if ($('.btn_remove').find('.info_description').not('hidden')) {
					$('.btn_remove').find('.info_description').addClass('hidden');
				}
			}
			$('div[data-idproduct="'+id+'"]').find('.in_cart_js').removeClass('hidden');
			$('div[data-idproduct="'+id+'"]').find('.buy_btn_js').addClass('hidden');
			if(data.cart.products[id].mode == 'opt'){
				mode_text = 'до';
			}
			if($('form.note[data-note="'+id+'"]').hasClass('note_control') && $('form.note[data-note="'+id+'"]').is(':not(.informed)') && $('form.note[data-note="'+id+'"] textarea').val() === ''){
				alert('Примечание данного товара является обязательным для заполнения!');
				$('form.note[data-note="'+id+'"]').addClass('informed').css('border-color', '#f00');
			}
		}
		if($('#cart').hasClass('opened')){
			// $('div[data-idproduct="'+id+'"]').find('.price').text(data.product.actual_prices[data.cart.cart_column].toFixed(2));
			$('.cart_order_sum').text(data.cart.cart_sum);
			$.each(data.cart.products, function(key, value){
				$('#cart div[data-idproduct="'+key+'"]').find('.price').text(value.actual_prices[data.cart.cart_column].toFixed(2).toString().replace('.',','));
				$('.order_mopt_sum_'+key).text(value.summary[data.cart.cart_column].toFixed(2).toString().replace('.',','));
			});
		}else{
			$('#cart div[data-idproduct="'+id+'"]').find('.price').text(data.product.actual_prices[$.cookie('sum_range')].toFixed(2).toString().replace('.',','));
			$('div[data-idproduct="'+id+'"]').find('.other_price .price_js').text(data.product.other_prices[$.cookie('sum_range')].toFixed(2).toString().replace('.',','));
			$('div[data-idproduct="'+id+'"]').find('.other_price .mode_js').text(mode_text);
		}
		removeLoadAnimation('div[data-idproduct="'+id+'"]');

		var sum = 0;
		// Автоматический пересчет скидки
		$('.currentCartSum').html(data.cart.products_sum[3]);
		ChangePriceRange(data.cart.cart_column, 0);		
		$('#cart .product_buy[data-idproduct="'+id+'"]').find('.price').html(data.cart.products[id].actual_prices[data.cart.cart_column].toFixed(2).toString().replace('.',',')); // устанавливает актуальную цену товара в корзине.
	});
}
/**
 * Определение количества товаров в корзине
 * @param  {[type]} obj [description]
 * @return {[type]}     [description]
 */
function countOfObject(obj) {
	var i = 0;
	if (typeof(obj)!="object" || obj === null) return 0;
	for(var x in obj) i++;
	if(i >= 1){
		$('header .cart_item a.cart i').addClass('mdl-badge');
	}
	return i;
}
/**
 * Удаление в корзине товара при нажатии на иконку
 * @param  {[type]} id [description]
 * @return {[type]}    [description]
 */
function removeFromCart(id){
	if(!id) {
		ajax('cart', 'clearCart').done(function(data){
			$('header .cart_item a.cart i').removeClass('mdl-badge');
			$('#removingProd, #clearCart, #cart .clear_cart').addClass('hidden');
			$('header .cart_item a.cart i').attr('data-badge', 0);
			$('#cart .no_items').removeClass('hidden');
			$('#cart .order_wrapp, #cart .cart_footer, #cart .orderNote, #cart .action_block, #cart .msg-info, #cart .buy_more').addClass('hidden');
			$('.in_cart_js').addClass('hidden');
			$('.buy_btn_js').removeClass('hidden');

			$.cookie('manual', 0, { path: '/'});

			$('.quantity').each(function(){
				var minQty = $(this).find('.minQty').val();
				$(this).find('.qty_js').val(minQty);
				$('#specCont').find('.qty_js').val(minQty);
				$(this).closest('.card').find('.note_field').val('');
				$(this).closest('.card').find('.note').addClass('hidden');
			});
			ChangePriceRange(3, 0);
		});
	}else{
		ajax('cart', 'remove_from_cart', {id_prod_for_remove: id}).done(function(data){
			ChangePriceRange(data.cart_column, 0);
			$('header .cart_item a.cart i').attr('data-badge', countOfObject(data.products));
			$('#removingProd, #clearCart').addClass('hidden');
			var minQty = $('#in_cart_' + id).closest('.buy_block').find('.minQty').val();
			completeCartProductAdd(data);
			$('#cart_item_' + id).hide(200).remove();
			$('#in_cart_' + id).addClass('hidden');
			$('#in_cart_' + id).closest('.btn_buy').find('.buy_btn_js').removeClass('hidden');
			$('#in_cart_' + id).closest('.buy_block').find('.qty_js').val(minQty);
			$('#in_cart_' + id).closest('.product_buy').find('.priceMoptInf').addClass('hidden');
			$('#in_cart_' + id).closest('.card').find('.note_field').val('');
			$('#in_cart_' + id).closest('.card').find('.note').addClass('hidden');

			var priceOpt = $('#in_cart_' + id).closest('.product_buy').find('.priceOpt' + $.cookie('sum_range')).val();
			var basePriceOpt = $('#in_cart_' + id).closest('.product_buy').find('.basePriceOpt' + $.cookie('sum_range')).val();
			$('#in_cart_' + id).closest('.product_buy').find('.price').html(priceOpt);
			$('#in_cart_' + id).closest('.product_buy').find('.base_price').html(basePriceOpt);

			$('.cart_order_sum').text(data.cart_sum);
			$.each(data.products, function(key, value){
				$('#cart div[data-idproduct="'+key+'"]').find('.price').text(value.actual_prices[data.cart_column].toFixed(2));
				$('.order_mopt_sum_'+key).text(value.summary[data.cart_column].toFixed(2));
			});

			if(data.products.length === 0){
				ChangePriceRange(3, 0);
				$('header .cart_item a.cart i').removeClass('mdl-badge');
				$('#cart .no_items').removeClass('hidden');
				$('#cart .order_wrapp, #cart .cart_footer, #cart .action_block, #cart .orderNote, #cart .clear_cart, #cart .msg-info, #cart .buy_more').addClass('hidden');
				$.cookie('manual', 0, { path: '/'});
			}
		});
	}
}
/**
 * [ChangeCartQty description]
 * @param {[type]} id        [description]
 * @param {[type]} direction [description]
 */
function ChangeCartQty(id, direction){
	/* direction: 0 - minus, 1 - plus; */
	$('#cart .no_items').addClass('hidden');
	var qty = 0;
	if($('#cart').hasClass('opened')){
		qty = parseInt($('#cart .product_buy[data-idproduct="'+id+'"]').find('.qty_js').val());
	}else if($('.product_buy[data-idproduct="'+id+'"]').closest('.card').find('.product_photo').hasClass('hovered')){
		qty = parseInt($('.preview .product_buy[data-idproduct="'+id+'"]').find('.qty_js').val());
	}else{
		qty = parseInt($('.product_buy[data-idproduct="'+id+'"]').find('.qty_js').val());
	}

	addLoadAnimation('.product_buy[data-idproduct="'+id+'"]');
	var note = $('#product_'+id).find('.note textarea').val();
	if(direction === 1){
		SendToAjax(id, qty+1, true, direction, note);
	}else if(direction === 0){
		SendToAjax(id, qty-1, true, direction, note);
	}else{
		SendToAjax(id, qty, false, false, note);
	}
}
/**
 * [completeCartProductAdd description]
 * @param  {[type]} data [description]
 * @return {[type]}      [description]
 */
function completeCartProductAdd(data){

	var products_count = Object.keys(data.products).length.toString();
	var	str = products_count+' товар';
	if(products_count.substr(-1) <= 1){
		str += '';
	}else if(products_count.substr(-1) >= 2 && products_count.substr(-1) <= 4){
		str += 'а';
	}else{
		str += 'ов';
	}
	$('.order_cart').text(str);
	$('.summ_many').text(data.products_sum[3].toFixed(2).toString().replace('.',','));
	$('#summ_prod').text(products_count);
	if(products_count > 0){
		$('.checkout').removeClass('hidden');
	}else{
		$('.checkout').addClass('hidden');
	}
	var sum_sale = (data.products_sum[3] - data.products_sum[data.cart_column]).toFixed(2);
	$('.summ_many:eq(1)').text(sum_sale.toString().replace('.',','));
	$('.summ_many:eq(2)').text((data.products_sum[3] - sum_sale).toFixed(2).toString().replace('.',','));


	// ОБНОВЛЕНИЕ СКИДОК. НОВЫЙ БЛОК
	if(data.products_sum[3] < 500){
		$('.discountTableElem, #sumPer0, #sumPer10, #sumPer16, #dicsPer0, #dicsPer10, #dicsPer16').removeClass('hidden');
		$('#sumPer0').text((500-data.products_sum[3]).toFixed(2).toString().replace('.',',')+' грн');
		$('#sumPer10').text((3000-data.products_sum[3]).toFixed(2).toString().replace('.',',')+' грн');
		$('#sumPer16').text((10000-data.products_sum[3]).toFixed(2).toString().replace('.',',')+' грн');
		$('#currentDiscount').text('0%');
	}else if(data.products_sum[3] < 3000){
		$('.discountTableElem, #sumPer10, #sumPer16, #dicsPer10, #dicsPer16').removeClass('hidden');
		$('#sumPer0, #dicsPer0').addClass('hidden');
		$('#sumPer10').text((3000-data.products_sum[3]).toFixed(2).toString().replace('.',',')+' грн');
		$('#sumPer16').text((10000-data.products_sum[3]).toFixed(2).toString().replace('.',',')+' грн');
		$('#currentDiscount').text('10%');
	}else if(data.products_sum[3] < 10000){
		$('.discountTableElem, #sumPer16, #dicsPer16').removeClass('hidden');
		$('#sumPer0, #sumPer10, #dicsPer0, #dicsPer10').addClass('hidden');
		$('#sumPer16').text((10000-data.products_sum[3]).toFixed(2).toString().replace('.',',')+' грн');
		$('#currentDiscount').text('16%');
	}else if(data.products_sum[3] >= 10000){
		$('.discountTableElem, #sumPer0, #sumPer10, #sumPer16, #dicsPer0, #dicsPer10, #dicsPer16').addClass('hidden');
		$('#currentDiscount').text('21%');
	}
}

$(function(){
	$('body').on('change', '.qty_js', function(){
		ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null);
	});
});