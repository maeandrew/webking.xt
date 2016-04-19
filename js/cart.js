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
	ajax('cart', 'update_cart_qty', data).done(function(data){

		$('header .cart_item a.cart').attr('data-badge', countOfOject(data.cart.products));

		completeCartProductAdd(data.cart);

		qty = data.product.quantity;
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
			// $('div[data-idproduct="'+id+'"]').find('.price').text(data.product.actual_prices[data.cart.cart_column].toFixed(2));
			$('.cart_order_sum').text(data.cart.cart_sum);
			$.each(data.cart.products, function(key, value){
				$('#cart div[data-idproduct="'+key+'"]').find('.price').text(value.actual_prices[data.cart.cart_column].toFixed(2));
				$('.order_mopt_sum_'+key).text(value.summary[data.cart.cart_column].toFixed(2));
			});
		}else{
			$('#cart div[data-idproduct="'+id+'"]').find('.price').text(data.product.actual_prices[$.cookie('sum_range')].toFixed(2));
			$('div[data-idproduct="'+id+'"]').find('.other_price .price_js').text(data.product.other_prices[$.cookie('sum_range')].toFixed(2));
			$('div[data-idproduct="'+id+'"]').find('.other_price .mode_js').text(mode_text);
		}
		removeLoadAnimation('div[data-idproduct="'+id+'"]');

		// Автоматический пересчет скидки
		if ($.cookie('manual') == 0){ // выполняется если скидка формируется автоматически (без ручного установления текущей скидки). значение берется из куков
			/**
			 * [Определение сумы скидки]
			 * @param  {[int]} data.cart.cart_column [колонка скидки корзины взята из массива корзины]
			 * @return {[func]}                      [вызывает вункцию смены цены (ChangePriceRange) и отображениии скидки. передает в нее id - текущая колонка корзины, sum - общую сумму корзины, val - значение всегда "0" - это "метка"/"флажок" которая обозначает что фукнция вызвана из данного аякса]
			 */
			switch(data.cart.cart_column) {
				case 0:
					ChangePriceRange(0, 0, 0);
					break;
				case 1:
					var sum = (10000 - data.cart.products_sum[3]).toFixed(2);
					ChangePriceRange(1, sum, 0);
					break;
				case 2:
					var sum = (3000 - data.cart.products_sum[3]).toFixed(2);
					ChangePriceRange(2, sum, 0);
					break;
				case 3:
					var sum = (500 - data.cart.products_sum[3]).toFixed(2);
					ChangePriceRange(3, sum, 0);
					break;
				default:
					console.log('не работает все');
				}
		}else{ // Выполняется при ручном выборе текущей скидки. Так же как и первое условие передает те же значения, за исключением суммы. Она постоянна.
			switch(data.cart.cart_column) {
				case 0:
					ChangePriceRange(0, 0, 0);
					break;
				case 1:
					var sum = (data.cart.products_sum[3]).toFixed(2);
					ChangePriceRange(1, sum, 0);
					break;
				case 2:
					var sum = (data.cart.products_sum[3]).toFixed(2);
					ChangePriceRange(2, sum, 0);
					break;
				case 3:
					var sum = (data.cart.products_sum[3]).toFixed(2);
					ChangePriceRange(3, sum, 0);
					break;
				default:
					console.log('не работает все');
			}
		}
		$('#cart .product_buy[data-idproduct="'+id+'"]').find('.price').html(data.cart.products[id].actual_prices[data.cart.cart_column].toFixed(2)); // устанавливает актуальную цену товара в корзине.

	});
}
/**
 * Определение количества товаров в корзине
 * @param  {[type]} obj [description]
 * @return {[type]}     [description]
 */
function countOfOject(obj) {
	var i=0;
	if (typeof(obj)!="object" || obj==null) return 0;
	for (x in obj) i++;
		if (i>=1) { $('header .phone_menu a.cart').addClass('mdl-badge') }
		else { $('header .phone_menu a.cart').removeClass('mdl-badge') };
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
			$('#removingProd, #clearCart').addClass('hidden');
			$('#cart .no_items').removeClass('hidden');
			$('#cart .order_wrapp, #cart .cart_footer, #cart .action_block').addClass('hidden');
			$('.products .in_cart_js').addClass('hidden');
			$('.products .buy_btn_js').removeClass('hidden');
			$.cookie('manual', 0);

			$('.quantity').each(function(){
				var minQty = $(this).find('.minQty').val();
				console.log(minQty);
				$(this).find('.qty_js').val(minQty);
			});
			ChangePriceRange(0, 0, 0);
			// switch(parseInt($.cookie('sum_range'))) {
			// 	case 0:
			// 		$('.product_buy').each(function(){
			// 			var priceOpt = $(this).find('.priceOpt0').val();
			// 			$(this).find('.price').html(priceOpt);
			// 			$(this).find('.priceMoptInf').addClass('hidden');
			// 		});
			// 		break;
			// 	case 1:
			// 		$('.product_buy').each(function(){
			// 			var priceOpt = $(this).find('.priceOpt1').val();
			// 			$(this).find('.price').html(priceOpt);
			// 			$(this).find('.priceMoptInf').addClass('hidden');
			// 		});
			// 		break;
			// 	case 2:
			// 		$('.product_buy').each(function(){
			// 			var priceOpt = $(this).find('.priceOpt2').val();
			// 			$(this).find('.price').html(priceOpt);
			// 			$(this).find('.priceMoptInf').addClass('hidden');
			// 		});
			// 		break;
			// 	case 3:
			// 		$('.product_buy').each(function(){
			// 			var priceOpt = $(this).find('.priceOpt3').val();
			// 			$(this).find('.price').html(priceOpt);
			// 			$(this).find('.priceMoptInf').addClass('hidden');
			// 		});
			// 		break;
			// 	default:
			// 		console.log('не работает');
			// }
			// $('.cart').addClass('hidden');
		});
	}else {
		ajax('cart', 'remove_from_cart', {id: id}).done(function (data) {
			$('#removingProd, #clearCart').addClass('hidden');
			var minQty = $('.products #in_cart_' + id).closest('.buy_block').find('.minQty').val();
			completeCartProductAdd(data);
			$('#cart_item_' + id).hide(200).remove();
			$('.products #in_cart_' + id).addClass('hidden');
			$('.products #in_cart_' + id).closest('.btn_buy').find('.buy_btn_js').removeClass('hidden');
			$('.products #in_cart_' + id).closest('.buy_block').find('.qty_js').val(minQty);
			$('.products #in_cart_' + id).closest('.product_buy').find('.priceMoptInf').addClass('hidden');

			switch(parseInt($.cookie('sum_range'))) {
				case 0:
					var priceOpt = $('.products #in_cart_' + id).closest('.product_buy').find('.priceOpt0').val();
					$('.products #in_cart_' + id).closest('.product_buy').find('.price').html(priceOpt);
					break;
				case 1:
					var priceOpt = $('.products #in_cart_' + id).closest('.product_buy').find('.priceOpt1').val();
					$('.products #in_cart_' + id).closest('.product_buy').find('.price').html(priceOpt);
					break;
				case 2:
					var priceOpt = $('.products #in_cart_' + id).closest('.product_buy').find('.priceOpt2').val();
					$('.products #in_cart_' + id).closest('.product_buy').find('.price').html(priceOpt);
					break;
				case 3:
					var priceOpt = $('.products #in_cart_' + id).closest('.product_buy').find('.priceOpt3').val();
					$('.products #in_cart_' + id).closest('.product_buy').find('.price').html(priceOpt);
					break;
				default:
					console.log('не работает');
			}

			if(data.products.length == 0){
				$('#cart .no_items').removeClass('hidden');
				$('#cart .order_wrapp, #cart .cart_footer, #cart .action_block').addClass('hidden');
				$.cookie('manual', 0);
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
	$('.no_items').addClass('hidden');
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
/**
 * [completeCartProductAdd description]
 * @param  {[type]} data [description]
 * @return {[type]}      [description]
 */
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