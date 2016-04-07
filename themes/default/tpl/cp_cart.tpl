<!-- <h4 class="title_cart">Корзина</h4> -->
<script>
	var randomManager;
	qtycontrol = new Array();
	notecontrol = new Array();
</script>
<?if(empty($list)){
	if(isset($cart['id_order'])){
		if($_GET['type'] == 'order'){?>
			<script>
				ga('ecommerce:addTransaction', {
					'id': '<?=$cart['id_order']?>',									// Transaction ID. Required.
					'affiliation': '<?=$GLOBALS['CONFIG']['invoice_logo_text']?>',	// Affiliation or store name.
					'revenue': '<?=$cart['sum_discount']?>'							// Grand Total.
				});
			</script>
			<?foreach($cart['products'] as $p){?>
				<script>
					ga('ecommerce:addItem', {
						'id': '<?=$cart['id_order']?>',								// Transaction ID. Required.
						'name': '<?=str_replace("'", '"', $p['name'])?>',			// Product name. Required.
						'sku': '<?=$p['art']?>',									// SKU/code.
						'category': '<?=$p['id_category']?>',						// Category or variation.
						'price': '<?=$p['site_price_opt']?>',						// Unit price.
						'quantity': '<?=$p['order_opt_qty']+$p['order_mopt_qty']?>'	// Quantity.
					});
				</script>
			<?}?>
			<?if($p['order_opt_qty'] > 0){?>
				<!-- <script>
					ga('ecommerce:addItem', {
					'id': '<?=$cart['id_order']?>',								// Transaction ID. Required.
					'name': '<?=str_replace("'", '"', $p['name'])?>',			// Product name. Required.
					'sku': '<?=$p['art']?>',									// SKU/code.
					'category': '<?=$p['id_category']?>',						// Category or variation.
					'price': '<?=$p['site_price_opt']?>',						// Unit price.
					'quantity': '<?=$p['order_opt_qty']?>'						// Quantity.
					});
				</script>-->
			<?}
			if($p['order_mopt_qty'] > 0){?>
				<!-- <script>
					ga('ecommerce:addItem', {
					'id': '<?=$cart['id_order']?>',								// Transaction ID. Required.
					'name': '<?=str_replace("'", '"', $p['name'])?>',			// Product name. Required.
					'sku': '<?=$p['art']?>',									// SKU/code.
					'category': '<?=$p['id_category']?>',						// Category or variation.
					'price': '<?=$p['site_price_mopt']?>',						// Unit price.
					'quantity': '<?=$p['order_mopt_qty']?>'						// Quantity.
					});
				</script> -->
			<?}?>
			<!-- <script>ga('ecommerce:send');</script> -->
		<?}?>
		<div class="success_order">
			<?if($_GET['type'] == 'draft'){?>
				<h2>Черновик сохранен</h2>
				<img src="<?=file_exists($GLOBALS['PATH_root'].'/images/draft__saved.png')?_base_url.'/images/draft__saved.png':'/efiles/_thumb/nofoto.jpg'?>" alt="draft saved">
				<p>
					<a href="/customer_order/<?=$cart['id_order']?>" class="btn-m-green fleft">Посмотреть состав черновика</a>
					<a href="/cabinet/" class="btn-m-green fright">Перейти в личный кабинет</a>
				</p>
			<?}else{?>
				<h2>Спасибо за Ваш заказ</h2>
				<img src="<?=file_exists($GLOBALS['PATH_root'].'/images/operator.png')?_base_url.'/images/operator.png':'/efiles/_thumb/nofoto.jpg'?>" alt="draft saved">
				<div class="order_info">
					<p>Заказ <b>№<?=$cart['id_order']?></b> принят.</p>
					<p>В ближайшее время с Вами свяжется менеджер.</p>
				</div>
				<p>
					<a href="/customer_order/<?=$cart['id_order']?>" class="btn-m-green fleft">Посмотреть состав заказа</a>
					<a href="/cabinet/" class="btn-m-green fright">Перейти в личный кабинет</a>
				</p>
			<?}?>
		</div>
	<?}else{?>
		<div class="no_items">
			<h2 class="cat_no_items">Ваша корзина пуста!</h2>
			<img src="<?=file_exists($GLOBALS['PATH_root'].'/images/kharkov/empty-cart.jpg')?_base_url.'/images/kharkov/empty-cart.jpg':'/efiles/_thumb/nofoto.jpg'?>" alt="Ваша корзина пуста!">
			<p>Перейдите в <a href="/">каталог</a> для совершения покупок</p>
		</div>
	<?}?>
<?}else{?>
	<!-- Недоступные товары -->
	<?if(!empty($_SESSION['cart']['unavailable_products'])){?>
		<div class="msg-warning">
			<p>
				<?=$count = count($unlist);?>
				<?if($count == 1){?>
					товар сейчас недоступен.
				<?}elseif(substr($count, -1) == 1 && substr($count, -2, 1) != 1){?>
					товар сейчас недоступен.
				<?}elseif(substr($count, -1) == 2 || substr($count, -1) == 3 || substr($count, -1) == 4 && substr($count, -2, 1) != 1){?>
					товара сейчас недоступно.
				<?}else{?>
					товаров сейчас недоступно.
				<?}?>
			</p>
		</div>
	<?}?>
	<?if(G::isLogged() && $_SESSION['member']['gid'] == _ACL_MANAGER_){?>
		<?if(!empty($unlist)){?>
			<a href="#" class="show_btn" onclick="$(this).next().toggleClass('hidden'); return false;">Показать недоступные товары</a>
			<div class="unavailable_products hidden animate" id="unavailable_products">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table paper_shadow_1">
					<colgroup>
						<col width="20%">
						<col width="80%">
					</colgroup>
					<thead>
						<tr>
							<td class="left">Артикул</td>
							<td class="left">Название</td>
						</tr>
					</thead>
					<tbody>
						<?foreach($unlist as $ul){?>
							<tr>
								<td class="left"><?=$ul['art']?></td>
								<td class="left">
									<a href="/product/<?=$ul['id_product'].'/'.$ul['translit']?>/"><?=$ul['name']?></a>
								</td>
							</tr>
						<?}?>
					</tbody>
				</table>
			</div>
		<?}?>
	<?}?>
	<!-- END Недоступные товары -->
	<!-- NEW Товары в корзине -->
	<div class="order_wrapp clearfix">
		<!-- <ul class="order_head mdl-cell--hide-phone">
			<li class="photo">Фото</li>
			<li class="name">Название</li>
			<li class="price">Цена, Количество</li>
			<li class="sum_li">Сумма</li>
		</ul> -->
		<?$i = 0;
		$summ_prod = count($_SESSION['cart']['products']);
		$summ_many = $_SESSION['cart']['cart_sum'];
		foreach($list as $item){
			$item['price_mopt'] > 0 ? $mopt_available = true : $mopt_available = false;
			$item['price_opt'] > 0 ? $opt_available = true : $opt_available = false;?>
			<div class="card clearfix" id="cart_item_<?=$item['id_product']?>">
				<i class="material-icons remove_prod mdl-cell--hide-phone" onClick="removeFromCart('<?=$item['id_product']?>')">highlight_off</i>
				<span class="remove_prod_mob">Удалить</span>
				<div class="product_photo">
					<a href="<?=Link::Product($item['translit']);?>">
						<?if(!empty($item['images'])){?>
							<img alt="<?=G::CropString($item['name'])?>" src="http://xt.ua<?=str_replace('/original/', '/thumb/', $item['images'][0]['src']);?>"/>
						<?}else{?>
							<img alt="<?=G::CropString($item['name'])?>" src="http://xt.ua<?=($item['img_1'])?str_replace("image/", "_thumb/image/", $item['img_1']):"/images/nofoto.jpg"?>"/>
						<?}?>
					</a>
				</div>
				<div class="product_name">
					<a href="<?=Link::Product($item['translit']);?>" class="description_<?=$item['id_product'];?>">
						<?=G::CropString($item['name'])?>
					</a>
					<span class="product_article">Артикул: <?=$item['art']?></span>
					<div class="product_info clearfix">
						<div class="note in_cart clearfix">
							<textarea cols="30" rows="3" id="mopt_note_<?=$item['id_product']?>" form="edit"
									  name="note" <?=$item['note_control'] != 0 ? 'required':null?>>
							<?=isset($_SESSION['cart']['products'][$item['id_product']]['note'])?$_SESSION['cart']['products'][$item['id_product']]['note']:null?>
							</textarea>
							<label class="info_key">?</label>
							<div class="info_description">
								<p>Поле для ввода примечания к товару.</p>
							</div>
						</div>
					</div>
				</div>
				<div class="product_buy" data-idproduct="<?=$item['id_product']?>">
					<input class="opt_cor_set_js" type="hidden" value="<?=$GLOBALS['CONFIG']['correction_set_'.$item['opt_correction_set']]?>">
					<input class="price_opt_js" type="hidden" value="<?=$item['price_opt']?>">
					<div class="buy_block">
						<div class="price">
							<?=number_format($_SESSION['cart']['products'][$item['id_product']]['actual_prices'][$_COOKIE['sum_range']], 2, ".", "");?>
						</div>
						<div class="quantity">
							<button class="material-icons btn_add"	onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1); return false;">add</button>
							<input type="text" class="qty_js" value="<?=isset($_SESSION['cart']['products'][$item['id_product']]['quantity'])?$_SESSION['cart']['products'][$item['id_product']]['quantity']:$item['inbox_qty']?>" onchange="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null);return false;" min="0" step="<?=$item['min_mopt_qty'];?>">
							<button class="material-icons btn_remove" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 0);return false;">remove</button>
							<div class="units"><?=$item['units'];?></div>
						</div>
					</div>
					<div class="priceMoptInf<?=($_SESSION['cart']['products'][$item['id_product']]['quantity'] < $item['inbox_qty'])?'':' hidden'?>">Малый опт</div>
				</div>
				<div class="summ">
					<span class="order_mopt_sum_<?=$item['id_product']?>">
						<?=isset($_SESSION['cart']['products'][$item['id_product']]['summary'][$_SESSION['cart']['cart_column']])?number_format($_SESSION['cart']['products'][$item['id_product']]['summary'][$_SESSION['cart']['cart_column']],2,".",""):"0.00"?>
					</span>
				</div>
			</div>
		<?}
		$cart_sum = $_SESSION['cart']['products_sum']['3'];
		$percent_sum = $total = 0;
		if($cart_sum >= 0 && $cart_sum < $GLOBALS['CONFIG']['retail_order_margin']) {
			$percent = $percent_sum = 0;
			$total = $cart_sum;
		}elseif($cart_sum >= $GLOBALS['CONFIG']['retail_order_margin'] && $cart_sum < $GLOBALS['CONFIG']['wholesale_order_margin']) {
			$percent = 10;
			$percent_sum = $cart_sum * 0.10;
			$total = $cart_sum - $percent_sum;
		}elseif($cart_sum >= $GLOBALS['CONFIG']['wholesale_order_margin'] && $cart_sum < $GLOBALS['CONFIG']['full_wholesale_order_margin']) {
			$percent = 16;
			$percent_sum = $cart_sum * 0.16;
			$total = $cart_sum - $percent_sum;
		}elseif($cart_sum >= $GLOBALS['CONFIG']['full_wholesale_order_margin']){
			$percent = 21;
			$percent_sum = $cart_sum * 0.21;
			$total = $cart_sum - $percent_sum;
		};?>
	</div>
	<div id="cartFooterBorder"></div>
	<div class="cart">
		<div id="total" class="fright">
			<div class="total">
				<div class="label totaltext">Итого</div>
				<div class="total_summ totalnumb">
					<span id="summ_many" class="summ_many">
						<?=isset($cart_sum)? $cart_sum : "0.00"?>
					</span>  ГРН	</div>
			</div>
			<div class="total">
				<div class="label totaltext">Вы экономите</div>
				<div class="total_summ totalnumb">
					<span class="summ_many">
						<?=round($percent_sum, 2)?>
					</span>  ГРН	</div>
			</div>
			<div class="total">
				<div class="label" style="color: #000">К оплате</div>
				<div class="total_summ">
					<span class="summ_many" style='font-size: 1.2em'><?=number_format($total, 2, ",", "")?>
					</span>  ГРН	</div>
			</div>
		</div>
		<div class="cart_info fleft order_balance">
			<table id="percent">
				<tr <?=$percent == 0 ? '': "style='display:none'"?>>
					<td>Добавьте:</td>
					<td><?=round(500-$cart_sum,2)?>грн</td>
					<td>Получите скидку:</td>
					<td>50грн (10%)</td>
				</tr>
				<tr <?=($percent == 0 || $percent == 10) ? '': "style='display:none'"?>>
					<td><?=$percent == 10 ? 'Добавьте:' : ''?></td>
					<td <?=($percent == 0) ? "style=\"color: #9E9E9E\"" : ''?>><?=round(3000-$cart_sum,2)?>грн</td>
					<td><?=$percent == 10 ? 'Получите скидку' : ''?></td>
					<td <?=($percent == 0) ? "style=\"color: #9E9E9E\"" : ''?>>480грн (16%)</td>
				</tr>
				<tr <?=($percent == 0 || $percent == 10 || $percent == 16) ? '': "style='display:none'"?>>
					<td><?=$percent == 16 ? 'Добавьте' : ''?></td>
					<td <?=($percent == 10 || $percent == 0) ? "style=\"color: #9E9E9E\"" : ''?>><?=round(10000-$cart_sum,2)?>грн</td>
					<td><?=$percent == 16 ? 'Получите скидку' : ''?></td>
					<td <?=($percent == 10 || $percent == 0) ? "style=\"color: #9E9E9E\"" : ''?>>2100грн (21%)</td>
				</tr>
				<?=$percent == 21 ? 'Ваша скидка 21%' : ''?>
			</table>
			<div class="price_nav"></div>
		</div>
	</div>

	<div class="action_block">
		<div class="wrapp">
			<form action="">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<label style="color: #7F7F7F">*Телефон</label>
					<input class="mdl-textfield__input phone" type="text" id="user_number"
					pattern="\+\d{2}\s\(\d{3}\)\s\d{3}\-\d{2}\-\d{2}\" value="<?=isset($phone) ? $phone : null ?>">
					<label class="mdl-textfield__label" for="user_number" style="color: #FF5722;"></label>
					<span class="mdl-textfield__error err_tel orange">Поле обязательное для заполнения!</span>
				</div>
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label hidden" id="promo_input">
					<input class="mdl-textfield__input" type="text" id="sample7">
					<label class="mdl-textfield__label" for="sample7">Промокод</label>
				</div>
				<!-- <div class="tooltip_wrapp clearfix">
					<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect add_cart_state">
						<input type="radio" class="mdl-radio__button" name="options" value="1">
						<span class="mdl-radio__label">Групповая корзина</span>
							<label class="info_key" style="position: initial;">?</label>
							<div class="info_description">
								<p>Групповая корзина Групповая корзина Групповая корзина.</p>
							</div>
					</label>
					<div class="info_description">
						Добавит Вас к групповой корзине и перенапрвит на нее.
					</div>
				</div>

				<div class="tooltip_wrapp clearfix">
					<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect add_cart_state">
						<input type="radio" class="mdl-radio__button"  id="joint_cart" name="options" value="2">
						<span class="mdl-radio__label">Совместная покупка</span>
							<label class="info_key" style="position: initial;">?</label>
							<div class="info_description">
								<p>Перейти к оформлению совместной корзины</p>
							</div>
					</label>
					<div class="info_description">
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa perspiciatis blanditiisima
					</div>
				</div> -->
				<?if(!G::isLogged() || !_acl::isAdmin()){?>
					<div id="button-cart1">
						<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect" type='submit' value="Отправить">Оформить заказ</button>
					</div>
				<?}else{?>
					<p>Вы не можете использовать корзину</p>
				<?}?>
				<!-- <div id="button-cart2">
					<button class="mdl-button mdl-js-button btn_js" type='submit' data-href="<?=Link::custom('cabinet','cooperative?t=working')?>" value="Отправить">Отправить форму</button>
				</div>
				<div id="button-cart3">
					<button class="mdl-button mdl-js-button btn_js" type='submit' data-href="<?=Link::custom('cabinet','?t=working')?>" value="Отправить"></button>
				</div> -->
			</form>
			<script type='text/javascript'>
				//   radio button magic
				// componentHandler.upgradeDom();

				// var checked = false;
				// var old_text = $('.action_block .mdl-button').text();

				// $('#cart .tooltip_wrapp.clearfix:eq(0)').on('click', function () {
				// 	if (checked == false) {
				// 		$('.action_block .mdl-button').text('Продолжить');
				// 		$("#button-cart1").hide();
				// 		$("#button-cart1").show();
				// 		// $("#button-cart3").hide();
				// 	}
				// });

				// $('#cart .tooltip_wrapp.clearfix:eq(1)').on('click', function () {
				// 	if (checked == false) {
				// 		$('.action_block .mdl-button').text('Организовать');
				// 		$("#button-cart1").hide();
				// 		// $("#button-cart2").hide();
				// 		$("#button-cart1").show();
				// 	}
				// });
				// $('#cart .action_block .mdl-radio').on('mousedown', function (e) {
				// 	checked = $(this).find('input').prop('checked');
				// }).on('click', function () {
				// 	if (checked == true) {
				// 		$(this).removeClass('is-checked').find('input').attr('checked', false);
				// 		$('.action_block .mdl-button').text(old_text);
				// 	}
				// });
				//   radio button magic (end)
			</script>
		</div>
	</div>

	<!-- END NEW Товары в корзине -->
	<script type="text/javascript">
		$(function(){
			if(isLogged){
				// console.log('loggedin');
			}
			// Инициалзация маски для ввода телефонных номеров
			$(".phone").mask("+38 (099) ?999-99-99");
			// Создание заказа, нового пользователя только с телефоном (start)

			$('.remove_prod').on('click', function(e){
				$(this).closest('.card').addClass('hidden');
				$('#removingProd').removeClass('hidden');
			});

			$('.clear_cart').on('click', function(e){
				$('#clearCart').removeClass('hidden');
			});

			$('#cart').on('click', '#button-cart1 button', function(e){
				e.preventDefault();
				addLoadAnimation('#cart');
				var phone = $('.action_block input.phone').val().replace(/[^\d]+/g, "");
				if(phone.length == 12){
					ajax('cart', 'makeOrder', {phone: phone}).done(
						function(data){
						if(data.status == 200){
							closeObject('cart');
						}
					});
				}else{
					removeLoadAnimation('#cart');
					$('.err_tel').css('visibility', 'visible');
				}
			});
			if(!isLogged){
				$('input.send_order, input.save_order').click(function(e){
					var name = $('#edit #name').val().length;
					var phone = $('#edit #phone').val().length;
					var id_manager = $('#edit #id_manager').val();
					var id_city = $('#edit #id_delivery_department').val();
					if(name > 3){
						if(phone > 0){
							if(id_manager != null){
								if(id_city != null){
									$(this).submit();
								}else{
									e.preventDefault();
									alert("Город не выбран");
								}
							}else{
								e.preventDefault();
								alert("Менеджер не выбран");
							}
						}else{
							e.preventDefault();
							$("#phone").removeClass().addClass("unsuccess");
							alert("Телефон не указан");
						}
					}else{
						e.preventDefault();
						$("#name").removeClass().addClass("unsuccess");
						alert("Контактное лицо не заполнено");
					}
				});
			}
			$("#name").blur(function(){
				var name = this.value;
				var nName = name.replace(/[^A-zА-я ]+/g, "");
				var count = nName.length;
				if (count < 3) {
					$(this).removeClass().addClass("unsuccess");
				} else {
					$("#name").prop("value", nName);
					$(this).removeClass().addClass("success");
				}
			});
			$("#phone").blur(function(){
				var phone = this.value;
				var nPhone = phone.replace(/[^0-9]+/g, "");
				var count = nPhone.length;
				$("#phone").prop("value", nPhone);
				if (count == 10) {
					$(this).removeClass().addClass("success");
				} else {
					$(this).removeClass().addClass("unsuccess");
				}
			});
			// Set Random contragent
			if(randomManager == 1){
				var arr = new Array();
				var n = 1;
				$("#id_manager option").each(function(){
					arr.push(n);
					n++;
				});
				var random = Math.ceil(Math.random()*arr.length);
				$("#id_manager .cntr_"+random).prop("selected", "true");
			}
			function ResetForm(){
				$("#id_delivery").val(0);
				$("#id_city").val(0);
				$("#cityblock").fadeOut();
				$("#id_delivery_service").val(0);
				$("#delivery_serviceblock").fadeOut();
				$("#id_parking").val(0);
				$("#parkingblock").fadeOut();
				$("#id_contragent").val(0);
				$("#contragentblock").fadeOut();
				$("#addressdescr").val(0);
				$("#addressdescr").fadeOut();
				$("#contrlink").val(0);
				$("#contrlink").fadeOut();
			}
			//---------Проверка на ввод телефона
			$('#button-cart1').click(function(){
				if(!$('.phone').val()){
					$(this).click(function(){
						$(this).attr('disabled', 'disabled');
					});
					$('.err_tel').css('visibility', 'visible');
				}else{
					$(this).removeAttr("disabled");
					$('.err_tel').css('visibility', '')
				}
			});
		});
	</script>
<?}?>