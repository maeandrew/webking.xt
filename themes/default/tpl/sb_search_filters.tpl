<div class="cabinet" id="cart">
	<!-- CART -->
	<!-- Скрытая форма со значениями параметров дл яскидок и надбавок, которые можно изменить в панели администратора.
	Инициализация переменных, исходя из этих значений происходит в скрипте func.js !-->
	<form id="cart_discount_and_margin_parameters">
		<input type="hidden" id="cart_full_wholesale_order_margin" value="<?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?>"/>
		<input type="hidden" id="cart_full_wholesale_discount" value="<?=$GLOBALS['CONFIG']['full_wholesale_discount']?>"/>
		<input type="hidden" id="cart_wholesale_order_margin" value="<?=$GLOBALS['CONFIG']['wholesale_order_margin']?>"/>
		<input type="hidden" id="cart_wholesale_discount" value="<?=$GLOBALS['CONFIG']['wholesale_discount']?>"/>
		<input type="hidden" id="cart_retail_order_margin" value="<?=$GLOBALS['CONFIG']['retail_order_margin']?>"/>
		<input type="hidden" id="cart_retail_multiplyer" value="<?=$GLOBALS['CONFIG']['retail_multiplyer']?>"/>
		<input type="hidden" id="cart_personal_discount" value="<?=$personal_discount ?>"/>
		<input type="hidden" id="cart_price_mode" value="<?=$_SESSION['price_mode']?>"/>
	</form>
	<!-- Скрытая форма !-->
	<script>
		var randomManager;
		qtycontrol = new Array();
		notecontrol = new Array();
	</script>
	<?if(empty($list)){
		if(isset($cart['id_order'])){?>
			<?if($_GET['type'] == 'order'){?>
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
			<!--<?if($p['order_opt_qty'] > 0){?>
					<script>
						ga('ecommerce:addItem', {
							'id': '<?=$cart['id_order']?>',								// Transaction ID. Required.
							'name': '<?=str_replace("'", '"', $p['name'])?>',			// Product name. Required.
							'sku': '<?=$p['art']?>',									// SKU/code.
							'category': '<?=$p['id_category']?>',						// Category or variation.
							'price': '<?=$p['site_price_opt']?>',						// Unit price.
							'quantity': '<?=$p['order_opt_qty']?>'						// Quantity.
						});
					</script>
				<?}
				if($p['order_mopt_qty'] > 0){?>
					<script>
						ga('ecommerce:addItem', {
							'id': '<?=$cart['id_order']?>',								// Transaction ID. Required.
							'name': '<?=str_replace("'", '"', $p['name'])?>',			// Product name. Required.
							'sku': '<?=$p['art']?>',									// SKU/code.
							'category': '<?=$p['id_category']?>',						// Category or variation.
							'price': '<?=$p['site_price_mopt']?>',						// Unit price.
							'quantity': '<?=$p['order_mopt_qty']?>'						// Quantity.
						});
					</script>
				<?}?> -->
				<script>//ga('ecommerce:send');</script>
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
		<!-- <?if(isset($errm) && isset($msg)){?>
				<div class="msg-error paper_shadow_1">
					<span class="header">!</span>
					<p class="content"><?=$msg?></p>
				</div>
			<?}?>
			<?=isset($errm['products'])?'<span class="errmsg">'.$errm['products'].'</span>':null;?> -->
		<!-- <?if(isset($_SESSION['errm'])){?>
				<?foreach($_SESSION['errm'] as $msg){
					if(!is_array($msg)){?>
						<div class="msg-<?=msg_type?>">
							<p><?=$msg?></p>
						</div>
					<?}?>
					<script type="text/javascript">
						$('html, body').animate({
							scrollTop: 0
						}, 500, "easeInOutCubic");
					</script>
				<?}
			}?> -->

		<!-- Недоступные товары -->
		<?if(!empty($_SESSION['cart']['unavailable_products'])){?>
			<div class="msg-warning">
				<p><?=$count = count($unlist)?>
				<?if($count == 1){?>
					товар сейчас недоступен.
				<?}elseif(substr($count, -1) == 1 && substr($count, -2, 1) != 1){?>
					товар сейчас недоступен.
				<?}elseif(substr($count, -1) == 2 || substr($count, -1) == 3 || substr($count, -1) == 4 && substr($count, -2, 1) != 1){?>
					товара сейчас недоступно.
				<?}else{?>
					товаров сейчас недоступно.
				<?}?></p>
			</div>
		<?}?>
		<?if($User['gid'] == _ACL_MANAGER_){?>
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
		<h5>Корзина</h5>
		<div class="order_wrapp clearfix">
			<div class="order_head mdl-cell--hide-phone">
				<ul>
					<li class="photo">Фото</li>
					<li class="name">Название</li>
					<li class="price">Цена / Количество</li>
				</ul>
			</div>



			<?
			$i = 0;
			$summ_prod = count($_SESSION['cart']['products']);
			$summ_many = $_SESSION['cart']['cart_sum'];
			print_r($_SESSION['cart']['products']);

			foreach($list as $item){
				$item['price_mopt'] > 0?$mopt_available = true:$mopt_available = false;
				$item['price_opt'] > 0?$opt_available = true:$opt_available = false;
			?>
				<div class="card clearfix" id="cart_item_<?=$item['id_product']?>">
					<i class="material-icons remove_prod mdl-cell--hide-phone" onClick="removeFromCart('<?=$item['id_product']?>')">highlight_off</i>
					<span class="remove_prod_mob">Удалить</span>
					<div class="product_photo">
						<a href="<?=Link::Product($item['translit']); ?>" onClick="removeFromCart(<?=$item['id_product']?>)">
							<!-- <img
									alt="<?=G::CropString($item['name'])?>"
									class="lazy"
									data-original="<?=_base_url?><?=($item['img_1'])?htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $item['img_1'])):"/efiles/_thumb/image/nofoto.jpg"?>" /> -->

							<img
									alt="<?=G::CropString($item['name'])?>"
									class="lazy"
									src="http://lorempixel.com/120/90/" />

							<noscript>
								<img alt="<?=G::CropString($item['name'])?>" src="<?=_base_url?><?=($item['img_1'])?htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $item['img_1'])):"/efiles/_thumb/image/nofoto.jpg"?>"/>
							</noscript>
						</a>
					</div>
					<p class="product_name">
						<a href="<?=Link::Product($item['translit']); ?>" class="description_<?=$item['id_product'];?>" style="color:rgb(58, 154, 17);">
										<?=G::CropString($item['name'])?>
						</a>
						<span class="product_article">Артикул: <?=$item['art']?></span>
					</p>
					<div class="product_buy" data-idproduct="<?=$item['id_product']?>">

					<input class="opt_cor_set_js" type="hidden" value="<?=$GLOBALS['CONFIG']['correction_set_'.$item['opt_correction_set']]?>">
					<input class="price_opt_js" type="hidden" value="<?=$item['price_opt']?>">


						<p class="price mdl-cell--hide-phone">
							<?=number_format($_SESSION['cart']['products'][$item['id_product']]['actual_prices'][$_SESSION['cart']['cart_column']], 2, ".", "")?>
						</p>
						<p class="summ">=
							<span class="order_mopt_sum_<?=$item['id_product']?>">
								<?=isset($_SESSION['cart']['products'][$item['id_product']]['summary'][$_SESSION['cart']['cart_column']])?number_format($_SESSION['cart']['products'][$item['id_product']]['summary'][$_SESSION['cart']['cart_column']],2,".",""):"0.00"?>
							</span>

						</p>
						<div class="buy_block">
							<div class="btn_remove">
								<button class="mdl-button material-icons">
								<a href="#" class="icon-font" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 0);return false;">
									remove</a>
								</button>

							</div>
							<input type="text" class="qty_js" value="<?=$_SESSION['cart']['products'][$item['id_product']]['quantity']?>">
							<div class="btn_buy">
								<button class="mdl-button mdl-js-button" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1);return false;"><i class="material-icons">add</i></button>
							</div>
						</div>
					</div>
					<div class="product_info clearfix">
						<div class="note in_cart clearfix">
							<textarea cols="30" rows="3" id="mopt_note_<?=$item['id_product']?>" form="edit" name="note" <?=$item['note_control'] != 0 ? 'required':null?>>
								<?=isset($_SESSION['cart']['products'][$item['id_product']]['note'])?$_SESSION['cart']['products'][$item['id_product']]['note']:null?>
							</textarea>
							<label class="info_key">?</label>
							<div class="info_description">
								<p>Поле для ввода примечания к товару.</p>
							</div>
						</div>
					</div>
				</div>
			<?}?>
			<div class="clear_cart fleft">
				<a href="<?=Link::Custom('cart', 'clear');?>"><span class="icon-font color-red"></span>Очистить корзину</a>
			</div>
			<div class="total">
				<div class="label">Итого</div>
				<div class="positions">количество товаров:

						<?if($opt_available){?>
								<div class="buy_buttons">
									<!--удаление товара оптом из корзины-->
									<span id="summ_prod"><?=count($_SESSION['cart']['products'])?></span>
									<!--количество заказываемых товаров-->
								</div>
							<?}else{?>
								<!--Если опт НЕ доступен-->
								<div class="sold-out">Нет</div>
							<?}?> <!--проверка доступности опта-->

				</div>
				<div class="total_summ">сумма: <span id="summ_many"><?=isset($_SESSION['cart']['cart_sum'])?number_format($_SESSION['cart']['cart_sum'],2,".",""):"0.00"?></span></div>
			</div>
			<div class="action_block">
				<div class="wrapp">
					<?=$cart_info?>
				</div>
				<div class="wrapp">
					<form action="">
						<div class="mdl-textfield mdl-js-textfield" >
							<span class="number_label">Номер телефона</span>
							<input class="mdl-textfield__input" type="text" id="user_number" pattern="[0-9]{5,19}" onChange="validate($(this))">
							<label class="mdl-textfield__label" for="user_number"></label>
							<span style='color:red' id='namef'></span><br />
						</div>
						<div class="tooltip_wrapp clearfix">
							<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect add_cart_state">
								<input type="radio" class="mdl-radio__button" name="options" value="1">
								<span class="mdl-radio__label">Групповая корзина</span>
							</label>
							<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
								<input type="checkbox" class="mdl-checkbox__input">
								<span class="mdl-checkbox__label"></span>
							</label>
							<div class="info_description">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa perspiciatis blanditiis, minima repellendus
							</div>
						</div>
						<div class="tooltip_wrapp clearfix">
							<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect add_cart_state">
								<input type="radio" class="mdl-radio__button" name="options" value="2">
								<span class="mdl-radio__label">Совместная покупка</span>
							</label>
							<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
								<input type="checkbox" class="mdl-checkbox__input">
								<span class="mdl-checkbox__label">Совместная покупка</span>
							</label>
							<div class="info_description">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa perspiciatis blanditiisima
							</div>
						</div>
						<button class="mdl-button mdl-js-button" type='submit' value="Отправить">Отправить форму</button>

					</form>

					<script type='text/javascript'>
						function validate(obj){
						   //Считаем значения из полей name в переменную x
						   var x = obj.val();

						   //Если поле name пустое выведем сообщение и предотвратим отправку формы
						   if (x.length == 0){
						   	console.log('*Вы не ввели телефон');
						      $('#namef').text('*Вы не ввели телефон');
						      return false;
						   }
						   return true;
						}
					</script>
				</div>
			</div>
		</div>
		<!-- END NEW Товары в корзине -->


		<script>pcart = 1; discount = <?=isset($discount)?$discount:'0';?>;</script>
		<div id="cart_order_total" class="hidden">
			<!--Подсказка-->
			<div id="cart_order_tip">
				<!--Если заказали меньше , чем скидочной сумма-->
				<div id="cart_order_tip_multiplyer" style="display:none">
					Заказ расчитан по розничным ценам.<br> Закажите товаров более, чем на <?=$GLOBALS['CONFIG']['retail_order_margin']?> гривен и получите дополнительную скидку от розничной цены товара.
				</div>
				<!--Если заказали больше, чем безначеночная сумма, но меньше скидочной суммы-->
				<div id="cart_order_tip_discount" style="display:none">
					Заказ расчитан по ценам мелкого опта.<br> Закажите товаров более, чем на <?=$GLOBALS['CONFIG']['wholesale_order_margin']?> гривен и получите дополнительную скидку от розничной цены товара
				</div>
				<!--Если заказали больше, чем безначеночная сумма, но меньше скидочной суммы-->
				<div id="cart_order_tip_wholesale" style="display:none">
					Заказ расчитан по ценам среднего опта.<br> Закажите товаров более, чем на <?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?> гривен и получите дополнительную скидку от розничной цены товара
				</div>
			</div>
			<!--Подсказка-->
			<?if($personal_discount > 0){?>
				<!--Личная скидка-->
				<table id="cart_personal_discount">
					<tr style="display: none;">
						<td>Ваша личная скидка:</td>
						<td>
							<div id="cart_order_personal_discount"><?=$_SESSION['cart']['personal_discount']?></div>
						</td>
					</tr>
				</table>
				<!--Личная скидка-->
			<?}?>
			<div class="sum_order fright">
				<div id="cart_order_sum_caption_base">Сумма к оплате:</div>
				<div id="cart_order_sum_caption">
					<div id="cart_order_sum"><?=isset($_SESSION['cart']['cart_sum'])?number_format($_SESSION['cart']['cart_sum'],2,".",""):"0.00"?></div><!--noindex--> грн.<!--/noindex-->
				</div>
				<br>
				<?if(isset($_SESSION['price_mode']) && $_SESSION['price_mode'] == 1){?>
					<div id="cart_order_sum_caption" style="text-align: right; width: 94%;">
						<form action="" method="post" class="fleft">
							<input class="btn-s btn-orange-inv" type="submit" value="Обновить сумму"/>
						</form>
						наценка = <?=$_SESSION['cart']['personal_discount'];?>
					</div>
				<?}?>
			</div>
			<div class="clear_cart fleft">
				<span class="color-red">&times;</span>
				<a href="<?=_base_url?>/cart/clear/">Очистить корзину</a>
			</div>
			<table class="cart_info_table">
				<tr style="display: none;">
					<td>
					<? for($i = 0; $i < 4; $i++){?>
						<div id="corrected_sum_<?=$i?>">
							<?=number_format($_SESSION['cart']['order_sum'][$i],2,",","")?>
						</div>
					<?}?>
					</td>
					<!--Сумма по опту-->
					<td>Сумма по опту:</td>
					<td>
						<div id="cart_order_opt_sum">
							<?=isset($_SESSION['cart']['order_opt_sum'])?number_format($_SESSION['cart']['order_opt_sum'],2,",",""):"0,00"?>
						</div>
					</td>
					<td>грн.</td>
					<!--Сумма по опту-->
				</tr>
				<tr style="display: none;">
					<!--Сумма по рознице-->
					<td>Сумма по мелкому опту:</td>
					<td>
						<div id="cart_order_mopt_sum">
							<?=isset($_SESSION['cart']['order_mopt_sum'])?number_format($_SESSION['cart']['order_mopt_sum'],2,",",""):"0,00"?>
						</div>
					</td>
					<td>грн.</td>
					<!--Сумма по рознице-->
				</tr>
			</table>
			<?$sum_total = isset($_SESSION['cart']['sum'])?round($_SESSION['cart']['sum'],2):0;?>
			<!--class="table_itogo"-->
			<?if(isset($filial_notificator) == true){?>
				<span class="filial_notificator"><img src="/images/odessa_filial.png" width="80" alt="В заказе имеются товары с одесского склада"><p>Отмеченные товары будут отгружены со склада в Одессе.</p></span>
			<?}?>
		</div>


	<? /*
	<!--////////////////////////////////////////////////////////-->

		<!-- NEW Форма оформления заказа-->
		<div id="order" class="order row">
			<div class="col-md-12 clearfix">
				<h2>Оформление заказа</h2>
			</div>
			<div class="col-md-12">
				<form id="edit" method="post" class="row">
					<input type="hidden" name="discount" value="<?=$personal_discount?>"/>
					<input type="hidden" name="target_date" value="<?=date('d.m.Y', strtotime('+2 day', time()))?>">
					<section class="col-md-6 col-xs-12">
						<fieldset>
							<legend>Контактная информация:</legend>
							<?if($User['gid'] == _ACL_CONTRAGENT_){?>
								<div class="row">
									<label for="cont_person" class="col-md-4 col-xs-12">Контактное лицо:</label>
									<div class="col-md-8 col-xs-12">
										<input required="required" type="text" name="cont_person" id="cont_person" <?if($User['gid'] == _ACL_TERMINAL_){?>autocomplete="off" <?}?>value="<?=$customer['cont_person']?>">
										<div id="name_error"></div>
									</div>
								</div>
							<?}else{?>
								<div class="row">
									<label for="last_name" class="col-md-4 col-xs-12">Фамилия:</label>
									<div class="col-md-8 col-xs-12">
										<input required="required" type="text" name="last_name" id="last_name" value="<?=$customer['last_name']?>">
										<div id="name_error"></div>
									</div>
								</div>
								<div class="row">
									<label for="first_name" class="col-md-4 col-xs-12">Имя:</label>
									<div class="col-md-8 col-xs-12">
										<input required="required" type="text" name="first_name" id="first_name" value="<?=$customer['first_name']?>">
										<div id="name_error"></div>
									</div>
								</div>
								<div class="row">
									<label for="middle_name" class="col-md-4 col-xs-12">Отчество:</label>
									<div class="col-md-8 col-xs-12">
										<input required="required" type="text" name="middle_name" id="middle_name" value="<?=$customer['middle_name']?>">
										<div id="name_error"></div>
									</div>
								</div>
							<?}?>
							<div class="row">
								<label for="phone" class="col-md-4 col-xs-12">Контактный телефон:</label>
								<div class="phones col-md-8 col-xs-12">
									<input required="required" type="tel" name="phones" id="phone" <?=$User['gid'] != _ACL_CONTRAGENT_?'class="phone"':null?> maxlength="15"<?if($User['gid'] == _ACL_TERMINAL_){?> autocomplete="off"<?}?> value="<?=$customer['phones']?>">
									<div id="phone_error"></div>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Дополнительная информация:</legend>
							<?if($User['gid'] != _ACL_TERMINAL_){?>
								<?if(!isset($contragent['remote']) || $contragent['remote'] != 1){?>
									<div id="bonus" class="row">
										<label for="bonus_card" class="col-md-4 col-xs-12">Бонусная карта:</label>
										<div class="col-md-8 col-xs-12">
											<?if($User['gid'] == _ACL_CONTRAGENT_){?>
												<input type="text" name="bonus_card" id="bonus_card" autocomplete="off" value="<?=isset($_SESSION['member']['bonus_card'])?$_SESSION['member']['bonus_card']:null?>">
											<?}else{?>
												<?if($customer['bonus_card']){?>
													<span class="saved_info">№ <?=$customer['bonus_card']?></span>
												<?}else{?>
													<?if($_SESSION['member']['email'] == 'anonymous'){?>
														<input type="text" name="bonus_card" id="bonus_card" autocomplete="off" placeholder="Введите бонусную карту">
													<?}else{?>
														<div class="msg-info">
															<p>Для активации бонусной карты перейдите на страницу <a href="<?=_base_url?>/cabinet/bonus/">личного кабинета</a>.<br>
																<a href="<?=_base_url?>/page/Skidki/">Детали бонусной программы</a></p>
														</div>
													<?}?>
												<?}?>
											<?}?>
										</div>
									</div>
								<?}?>
								<div id="contragent" class="row">
									<label for="id_manager" class="col-md-4 col-xs-12">Менеджер:</label>
									<div class="col-md-8 col-xs-12">
										<?if(isset($contragent['remote']) && $contragent['remote'] == 1){?>
											<span class="saved_info col-md-"><?=$contragent['name_c']?></span>
											<input type="hidden" name="id_manager" id="id_manager" value="<?=$contragent['id_user']?>"/>
										<?}else{?>
											<select required="required" name="id_manager" id="id_manager">
												<?if(!$saved['manager'] || !$managers_list){?>
													<option selected="selected" disabled="disabled" class="cntr_0" value="">Менеджер</option>
												<?}
												$ii = 1;
												shuffle($managers_list);
												foreach($managers_list as $manager){?>
													<option <?=$manager['id_user'] == $saved['manager']['id_user']?'selected="selected"':null;?> class="cntr_<?=$ii?>" value="<?=$manager['id_user']?>"><?=$manager['name_c']?></option>
													<?$ii++;
												}?>
											</select>
										<?}?>
									</div>
								</div>
							<?}else{?>
								<input type="hidden" name="id_manager" id="id_manager" value="<?=$saved['manager']['id_user']?>"/>
							<?}?>
								<div id="contragent" class="row">
									<label for="description" class="col-md-4 col-xs-12">Дополнительная информация:</label>
									<div class="col-md-8 col-xs-12">
										<textarea name="description" id="description"></textarea>
									</div>
								</div>
						</fieldset>
					</section>
					<section class="col-md-6 col-xs-12 fright">
						<fieldset>
							<legend>Доставка:</legend>
							<div class="row region">
								<label for="id_region" class="col-md-4 col-sx-12">Область:</label>
								<div class="select  col-md-8 col-sx-12">
									<select required="required" name="id_region" id="id_region" onChange="regionSelect(id_region.value);">
										<option selected="selected" disabled="disabled">Выберите область</option>
										<?foreach($regions_list as $region){?>
											<option <?=$region['region'] == $saved['city']['region']?'selected="selected"':null;?> value="<?=$region['region']?>"><?=$region['region']?></option>
										<?}?>
									</select>
								</div>
							</div>
							<div class="row city">
								<label for="id_city" class="col-md-4 col-sx-12">Город:</label>
								<div class="select col-md-8 col-sx-12">
									<select required="required" name="id_city" id="id_city" onChange="citySelect(id_city.value);" <?=!isset($saved['city'])?'disabled="disabled"':null?>>
										<option selected="selected" disabled="disabled">Выберите город</option>
										<?foreach($cities_list as $city){?>
											<option <?=$city['name'] == $saved['city']['name']?'selected="selected"':null;?> value="<?=$city['names_regions']?>"><?=$city['name']?></option>
										<?}?>
									</select>
								</div>
							</div>
							<div class="row id_delivery">
								<label for="id_delivery" class="col-md-4 col-sx-12">Способ доставки:</label>
								<div class="select col-md-8 col-sx-12">
									<select required="required" name="id_delivery" id="id_delivery" onChange="deliverySelect();">
										<?foreach($deliverymethods_list as $dm){?>
											<option <?=$dm['id_delivery'] == $customer['id_delivery']?'selected="selected"':null;?> value="<?=$dm['id_delivery']?>"><?=$dm['name']?></option>
										<?}?>
									</select>
								</div>
							</div>
							<div class="row delivery_service" id="delivery_service" <?=$saved['deliverymethod']['id_delivery'] != 3?'style="display: none;"':null;?>>
								<label for="id_delivery_service" class="col-md-4 col-sx-12">Служба доставки:</label>
								<div class="select col-md-8 col-sx-12">
									<select name="id_delivery_service" onChange="deliveryServiceSelect(id_delivery_service.value);" id="id_delivery_service">
										<?foreach($deliveryservices_list as $ds){?>
											<option <?=$ds['shipping_comp'] == $saved['city']['shipping_comp']?'selected="selected"':null;?> value="<?=$ds['shipping_comp']?>"><?=$ds['shipping_comp']?></option>
										<?}?>
									</select>
								</div>
							</div>
							<div class="row delivery_department" id="delivery_department" <?=$saved['deliverymethod']['id_delivery'] != 3?'style="display: none;"':null;?>>
								<label for="id_delivery_department" class="col-md-4 col-sx-12">Отделение:</label>
								<div class="select col-md-8 col-sx-12">
									<select name="id_delivery_department" id="id_delivery_department">
										<?foreach($deliverydepartments_list as $dd){?>
											<option <?=$dd['id_city'] == $saved['city']['id_city']?'selected="selected"':null;?> value="<?=$dd['id_city']?>"><?=$dd['address']?></option>
										<?}?>
									</select>
								</div>
							</div>
						</fieldset>
					</section>
					<section class="col-md-6 col-xs-12 fright content-insurance<?=$saved['deliverymethod']['id_delivery'] != 3?' hidden':null;?>">
						<fieldset>
							<legend>Страховка груза:</legend>
							<div class="row insurance">
								<div class="col-md-12 col-xs-12">
									<label for="minimum-insurance"><input type="radio" id="minimum-insurance" value="0" name="strachovka" <?=(!isset($_POST['strachovka']) || $_POST['strachovka'] == 0)?'checked="checked"':null;?>/>Минимальная</label>
								</div>
							</div>
							<div class="row insurance">
								<div class="col-md-12 col-xs-12">
									<label for="full-insurance"><input type="radio" id="full-insurance" value="1" name="strachovka" <?=(isset($_POST['strachovka']) && $_POST['strachovka'] == 1)?'checked="checked"':null;?>/>Полная</label>
								</div>
							</div>
							<div class="row insurance">
								<div class="col-md-12 col-xs-12">
									<a href="/page/Usloviya-straxovaniya-gruza-transportnymi-kompaniyami" target="_blank">Правила страхования груза</a>
								</div>
							</div>
						</fieldset>
					</section>
					<div class="col-md-12 col-xs-12">
						<div class="msg-warning">
							<p>Заказ доступен к оплате в течении 3 дней после оформления.</p>
						</div>
					</div>
					<?if($_SESSION['member']['gid'] == _ACL_CONTRAGENT_){?>
						<div class="change_price_column col-md-6 col-xs-12">
							<a href="#" class="manual_price_column_change btn-m-green-inv">Изменить колонку цен</a>
							<div class="price_columns row">
								<div class="col-md-3">
									<input class="fleft <?=isset($_SESSION['price_column']) && $_SESSION['price_column'] == 0?'default" checked="checked':null;?>" type="radio" name="price_column" id="price_column_0" value="0">
									<label class="fleft" for="price_column_0">более 8000</label>
								</div>
								<div class="col-md-3">
									<input class="fleft <?=isset($_SESSION['price_column']) && $_SESSION['price_column'] == 1?'default" checked="checked':null;?>" type="radio" name="price_column" id="price_column_1" value="1">
									<label class="fleft" for="price_column_1">от 2000 до 8000</label>
								</div>
								<div class="col-md-3">
									<input class="fleft <?=isset($_SESSION['price_column']) && $_SESSION['price_column'] == 2?'default" checked="checked':null;?>" type="radio" name="price_column" id="price_column_2" value="2">
									<label class="fleft" for="price_column_2">от 200 до 2000</label>
								</div>
								<div class="col-md-3">
									<input class="fleft <?=isset($_SESSION['price_column']) && $_SESSION['price_column'] == 3?'default" checked="checked':null;?>" type="radio" name="price_column" id="price_column_3" value="3">
									<label class="fleft" for="price_column_3">менее 200</label>
								</div>
								<div class="reason col-md-12">
									<p>Причина изменения колонки цен (обязательно):</p>
									<textarea name="reason" id="reason" class="input-l" placeholder="Обязательно к заполнению"></textarea>
								</div>
							</div>
						</div>
					<?}?>
					<div class="buttons col-md-12 col-xs-12">
						<button type="submit" name="order" class="send_order btn-l-orange">Оформить заказ</button>
						<?if($_SESSION['member']['email'] !== 'anonymous'){?>
							<a href="<?=_base_url?>/cart/?type=draft" class="save_order btn-l-blue-inv">Сохранить черновик</a>
						<?}?>
					</div>
				</form>
			</div>
		</div>
	*/?>
		<!-- END NEW Форма оформления заказа -->
	<?}?>
	<?unset($_SESSION['errm']);?>
	<script type="text/javascript">
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
		$("#name").blur(function(){
			var name = this.value;
			var nName = name.replace(/[^A-zА-я ]+/g, "");
			var count = nName.length;
			if(count < 3){
				$(this).removeClass().addClass("unsuccess");
			}else{
				$("#name").prop("value",nName);
				$(this).removeClass().addClass("success");
			}
		});
		$("#phone").blur(function(){
			var phone = this.value;
			var nPhone = phone.replace(/[^0-9]+/g, "");
			var count = nPhone.length;
				$("#phone").prop("value",nPhone);
			if(count == 10){
				$(this).removeClass().addClass("success");
			}else{
				$(this).removeClass().addClass("unsuccess");
			}
		});
		/** Set Random contragent */
		if(randomManager == 1){
			var arr = new Array();
			var n = 1;
			$("#id_manager option").each(function(){
				arr.push(n);
				n++;
			});
			var random = Math.ceil(Math.random() * arr.length);
			$("#id_manager .cntr_"+random).prop("selected","true");
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
	</script>
	<!-- END CART -->
</div>