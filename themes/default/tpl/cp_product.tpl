<div id="product">
	<?$Status = new Status();
	$st = $Status->GetStstusById($item['id_product']);
	// Проверяем доступнось розницы
	($item['price_mopt'] > 0 && $item['min_mopt_qty'] > 0)?$mopt_available = true:$mopt_available = false;
	// Проверяем доступнось опта
	($item['price_opt'] > 0 && $item['inbox_qty'] > 0)?$opt_available = true:$opt_available = false;?>
	<!-- SHOWCASE SLIDER -->
	<div id="showcase_bg" class="showcase_bg"></div>
	<div id="showcase" class="showcase paper_shadow_1"></div>
	<script type="text/javascript">
		var qtycontrol = new Array();
		var notecontrol = new Array();
	</script>
	<div class="product">
		<div class="row">
			<div class="col-md-6 clearfix">
				<div id="product_miniatures_img" <?=count($item['images'])<5?'class="no_slide"':null?>>
					<a href="#" class="arrow_Up"><span class="icon-font">arrow_up</span></a>
					<a href="#" class="arrow_Down"><span class="icon-font">arrow_down</span></a>
					<div class="carrossel_wrapper">
						<div class="carrossel-items">
							<?if(!empty($item['images'])){
								foreach($item['images'] as $i => $image){?>
									<div class="item">
										<img src="<?=file_exists($GLOBALS['PATH_root'].str_replace('original', 'thumb', $image['src']))?_base_url.str_replace('original', 'thumb', $image['src']):'/efiles/_thumb/nofoto.jpg'?>" alt="<?=$item['name']?>"<?=$i==0?' class="active_img"':null;?>>
									</div>
								<?}
							}else{
								for($i=1; $i < 4; $i++){
									if(!empty($item['img_'.$i])){?>
										<div class="item">
											<img src="<?=file_exists($GLOBALS['PATH_root'].$item['img_'.$i])?_base_url.str_replace('/efiles/', '/efiles/_thumb/', $item['img_'.$i]):'/efiles/_thumb/nofoto.jpg'?>" alt="<?=$item['name']?>"<?=$i==1?' class="active_img"':null;?>>
										</div>
									<?}
								}
							}?>
						</div>
					</div>
				</div>
				<div id="product_main_img">
					<?if(!empty($item['images'])){?>
							<div class="item">
								<img src="<?=_base_url?><?=$item['images'][0]['src']?>" alt="<?=$item['name']?>">
							</div>
					<?}else{?>
						<div class="item"><img src="<?=file_exists($GLOBALS['PATH_root'].$item['img_1'])?_base_url.$item['img_1']:'/efiles/_thumb/nofoto.jpg'?>" alt="<?=$item['name']?>"></div>
					<?}?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="product_description">
					<div class="tabs_container">
						<div class="row">
							<div class="tabs_block col-md-3 col-sm-3 col-xs-3">
								<button onclick="ChangePriceRange(0);" class="sum_range sum_range_0 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 0)?'user_active':null;?>"><span class="tabs_block_descr">Более <?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?><!--noindex-->грн.<!--/noindex--></span>
										<label class="info_key">?</label>
										<div class="info_description">
											<p>В каталоге будут отображены цены товаров при общей сумме заказа более <?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?><!--noindex-->грн.<!--/noindex--></p>
										</div>
								</button>
							</div>
							<div class="tabs_block col-md-3 col-sm-3 col-xs-3">
								<button onclick="ChangePriceRange(1);" class="sum_range sum_range_1 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 1)?'user_active':null;?>"><span class="tabs_block_descr">от <?=$GLOBALS['CONFIG']['wholesale_order_margin']?> до <?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?><!--noindex-->грн.<!--/noindex--></span>
										<label class="info_key">?</label>
										<div class="info_description">
											<p>В каталоге будут отображены цены товаров при общей сумме заказа от <?=$GLOBALS['CONFIG']['wholesale_order_margin']?> до <?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?><!--noindex-->грн.<!--/noindex--></p>
										</div>
								</button>
							</div>
							<div class="tabs_block col-md-3 col-sm-3 col-xs-3">
								<button onclick="ChangePriceRange(2);" class="sum_range sum_range_2 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 2)?'user_active':null;?>"><span class="tabs_block_descr">от <?=$GLOBALS['CONFIG']['retail_order_margin']?> до <?=$GLOBALS['CONFIG']['wholesale_order_margin']?><!--noindex-->грн.<!--/noindex--></span>
										<label class="info_key">?</label>
										<div class="info_description">
											<p>В каталоге будут отображены цены товаров при общей сумме заказа от <?=$GLOBALS['CONFIG']['retail_order_margin']?> до <?=$GLOBALS['CONFIG']['wholesale_order_margin']?><!--noindex-->грн.<!--/noindex--></p>
										</div>
								</button>
							</div>
							<div class="tabs_block col-md-3 col-sm-3 col-xs-3">
								<button onclick="ChangePriceRange(3);" class="sum_range sum_range_3 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 3)?'user_active':null;?>"><span class="tabs_block_descr">Менее <?=$GLOBALS['CONFIG']['retail_order_margin']?><!--noindex-->грн.<!--/noindex--></span>
										<label class="info_key">?</label>
										<div class="info_description">
											<p>В каталоге будут отображены цены товаров при общей сумме заказа до <?=$GLOBALS['CONFIG']['retail_order_margin']?><!--noindex-->грн.<!--/noindex--></p>
										</div>
								</button>
							</div>
						</div>
					</div>
					<div class="product_section clearfix">
						<?$in_cart = false;
						if(!empty($_SESSION['cart']['products'][$item['id_product']])){
							$in_cart = true;
						}
						$a = explode(';', $GLOBALS['CONFIG']['correction_set_'.$item['opt_correction_set']]);
						?>
						<div class="product_buy" data-idproduct="<?=$item['id_product']?>">
							<div class="buy_block">
								<div class="active_price">
									<?if($item['price_opt'] == 0 && $item['price_mopt'] == 0){?>
										<span><b><!--noindex-->----<!--/noindex--></b></span>
										<input class="opt_cor_set_js" type="hidden" value="<?=$GLOBALS['CONFIG']['correction_set_'.$item['opt_correction_set']]?>">
										<input class="price_opt_js" type="hidden" value="<?=$item['price_opt']?>">
									<?}else{?>
										<input class="opt_cor_set_js" type="hidden" value="<?=$GLOBALS['CONFIG']['correction_set_'.$item['opt_correction_set']]?>">
										<input class="price_opt_js" type="hidden" value="<?=$item['price_opt']?>">
										<span class="price_js"><?=$in_cart?number_format($_SESSION['cart']['products'][$item['id_product']]['actual_prices'][$_COOKIE['sum_range']], 2, ".", ""):number_format($item['price_opt']*$a[$_COOKIE['sum_range']], 2, ".", "");?></span>
										<!--noindex--> грн.<!--/noindex-->
									<?}?>
								</div>
								<?if(($item['price_opt'] > 0 || $item['price_mopt'] > 0) && $item['visible'] != 0){?>
									<div class="buy_buttons">
										<!--удаление товара оптом из корзины-->
										<a href="#" class="icon-font" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 0);return false;">remove</a>
										<input type="text" class="qty_js" value="<?=!$in_cart?$item['inbox_qty']:$_SESSION['cart']['products'][$item['id_product']]['quantity'];?>">
										<a href="#"	class="icon-font" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1);return false;">add</a>
										<!--количество заказываемых товаров-->
									</div>
									<?if(!$in_cart){?>
										<div class="buy_btn_block">
											<button class="btn-m-orange buy_btn_js" type="button">Купить</button>
											<a href="<?=_base_url?>/cart/" class="in_cart_js hidden<?=G::IsLogged()?null:' open_modal" data-target="login_form';?>" title="Перейти в корзину">В корзине</a>
										</div>
									<?}else{?>
										<div class="buy_btn_block">
											<button class="btn-m-orange buy_btn_js hidden" type="button">Купить</button>
											<a href="<?=_base_url?>/cart/" class="in_cart_js <?=G::IsLogged()?null:' open_modal" data-target="login_form';?>" title="Перейти в корзину">В корзине</a>
										</div>
									<?}?>
								<?}else{?>
									<!--Если опт НЕ доступен-->
									<div class="not_available">Товара нет в наличии</div>
								<?}?> <!--проверка доступности опта-->
							</div>
							<div class="other_price <?=$item['price_opt'] == 0 && $item['price_mopt'] == 0?'hidden':null?>">
								<input class="mopt_cor_set_js" type="hidden" value="<?=$GLOBALS['CONFIG']['correction_set_'.$item['mopt_correction_set']]?>">
								<input class="price_mopt_js" type="hidden" value="<?=$item['price_mopt']?>">
								<p>
									<span class="price_js"><?=$in_cart?number_format($_SESSION['cart']['products'][$item['id_product']]['other_prices'][$_COOKIE['sum_range']], 2, ".", ""):number_format($item['price_mopt']*$a[$_COOKIE['sum_range']], 2, ".", "");?></span>
									<!--noindex--> грн.<!--/noindex-->
									<span class="mode_js"><?=$in_cart && $_SESSION['cart']['products'][$item['id_product']]['mode'] == 'mopt'?'от':'до';?></span>
									<?=$item['inbox_qty'].' '.$item['units']?>
									<?if(isset($item['qty_control']) && !empty($item['qty_control'])){?>
										<p class="qty_descr">мин. <?=$item['min_mopt_qty'].' '.$item['units']?> (кратно)</p>
									<?}?>
								</p>
							</div>
						</div>
						<div class="product_info_actions">
							<?if(!isset($_SESSION['member']) || $_SESSION['member']['gid'] != _ACL_SUPPLIER_ ){?>
								<div class="preview_favorites <?=G::IsLogged()?null:' open_modal" data-target="login_form';?>" data-idfavorite="<?=$item['id_product']?>" title="<?=(!isset($_SESSION['member']) || !in_array($item['id_product'], $_SESSION['member']['favorites']))?'Добавить товар в избранное':'Товар находится в избранных'?>">
									<span class="icon-font favorite">favorites<?=(!isset($_SESSION['member']) || !in_array($item['id_product'], $_SESSION['member']['favorites']))?'-o':null?></span>
									<!-- Тег <a> не менять без необходимость с синтаксисом все ок(Sublime не правнльно подсвечивает)-->
									<a <?=(!isset($_SESSION['member']) || !in_array($item['id_product'], $_SESSION['member']['favorites']))?'href="#">В избранное':'href="/cabinet/favorites/">В избранном'?></a>
								</div>
								<div class="preview_follprice" data-follprice="<?=$item['id_product']?>">
									<?if(!isset($_SESSION['member']) || !in_array($item['id_product'], $_SESSION['member']['waiting_list'])){?>
										<p class="add_waitinglist">
											<span class="icon-font line">Line</span>
											<a href="#">Следить за ценой</a>
										</p>
									<?}else{?>
										<p>
											<span class="icon-font line">Line</span>
											<a href="/cabinet/waitinglist/">В листе ожидания</a>
										</p>
									<?}?>
									<input type="hidden" name="reg" value="<?=isset($_SESSION['member']) && $_SESSION['member']['id_user'] != 4028?$_SESSION['member']['id_user']:null;?>">
									<div class="enter_mail">
										<form>
											<input name="user_email" type="email" placeholder="Введите email" autofocus required>
											<a href="#" id="cancel_follow_js" class="fright">Отмена</a>
											<button id="follow_price" type="submit" class="btn-s-green fleft">Подписаться</button>
										</form>
									</div>
								</div>
							<?}?>
							<div class="rating_block">
								<a href="<?=_base_url?>/product/<?=$item['id_product'].'/'.$item['translit']?>/#tabs-2" class="rating">
									<ul class="rating_stars" title="<?=$item['c_rating'] != ''?'Оценок: '.$item['c_mark']:'Нет оценок'?>">
										<?
										for($i = 1; $i <= 5; $i++){
											$star = 'star';
											if($i > floor($item['c_rating'])){
												if($i == ceil($item['c_rating'])){
													$star .= '_half';
												}else{
													$star .= '_outline';
												}
											}?>
											<li><span class="icon-font star_outline"><?=$star?></span></li>
										<?}?>
									</ul>
									<span class="comments"><?=$item['c_count']?>
										<?if($item['c_count'] == 1){?>
											отзыв
										<?}elseif(substr($item['c_count'], -1) == 1 && substr($item['c_count'], -2, 1) != 1){?>
											отзыв
										<?}elseif(substr($item['c_count'], -1) == 2 || substr($item['c_count'], -1) == 3 || substr($item['c_count'], -1) == 4 && substr($item['c_count'], -2, 1) != 1){?>
											отзыва
										<?}else{?>
											отзывов
										<?}?>
									</span>
								</a>
							</div>
						</div>
					</div>
					<div class="product_info">
						<?if(isset($item['specifications']) && !empty($item['specifications'])){?>
							<div class="specifications">
								<h4>Характеристики:</h4>
								<table class="table">
									<col width="50%">
									<col width="50%">
									<tbody>
										<?foreach ($item['specifications'] as $k => $s) {?>
											<?if($k <= 3){?>
												<tr>
													<td class="caption"><?=$s['caption']?></td>
													<td class="value"><?=$s['value'].' '.$s['units']?></td>
												</tr>
											<?}?>
										<?}?>
									</tbody>
								</table>
							</div>
						<?}?>
						<div class="product_spec_body">
							<h4>Описание</h4>
							<? if(!empty($item['descr_xt_short'])){?>
								<p><?=$item['descr_xt_short']?></p>
							<?}else{?>
								<p>К сожалению описание товара временно отсутствует.</p>
							<?}?>
						</div>
						<div class="preview_socials">
							<span class="social_text">Поделиться:</span>
							<a rel="nofollow" href="http://vk.com/share.php?url=/product/<?=$item['id_product'].'/'.$item['translit']?>" class="vk animate" title="Вконтакте" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
								<span class="icon-font">vk</span>
							</a>
							<a rel="nofollow" href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=/product/<?=$item['id_product'].'/'.$item['translit']?>" class="ok animate" title="Одноклассники" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
								<span class="icon-font">odnoklassniki</span>
							</a>
							<a rel="nofollow" href="https://plus.google.com/share?url=/product/<?=$item['id_product'].'/'.$item['translit']?>" class="ggl animate" title="Google+" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
								<span class="icon-font">g+</span>
							</a>
							<a rel="nofollow" href="http://www.facebook.com/sharer.php?u=/product/<?=$item['id_product'].'/'.$item['translit'].'&t='.$item['name']?>" class="fb animate" title="Facebook" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
								<span class="icon-font">facebook</span>
							</a>
							<a rel="nofollow" href="http://twitter.com/home?status=<?=$item['name'].'+-+/product/'.$item['id_product'].'/'.$item['translit']?>" class="tw animate" title="Twitter" target="external" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
								<span class="icon-font">twitter</span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--Описание-->
	</div><!-- product! -->

	<div class="row">
		<div class="col-md-12">
			<div id="tabs">
				<ul class="tabs">
					<li><a href="#tabs-1" class="tab">Описание</a></li>
					<li><a href="#tabs-2" class="tab">Характеристики</a></li>
					<li><a href="#tabs-3" class="tab">Оплата</a></li>
					<li><a href="#tabs-4" class="tab">Доставка</a></li>
					<li><a href="#tabs-5" class="tab">Фото</a></li>
					<li><a href="#tabs-6" class="tab">Отзывы и вопросы</a></li>
					<li><a href="#tabs-7" class="tab">Обзоры и видео</a></li>
				</ul>
				<div class="tab-content">
					<div id="tabs-1" class="tab_item">
						<div class="row">
							<div class="product_spec_body col-lg-8 col-md-8 col-sm-12 col-xs-12">
								<? if(!empty($item['descr_xt_full'])){?>
									<p><?=$item['descr_xt_full']?></p>
								<?}else{?>
									<p>К сожалению описание товара временно отсутствует.</p>
								<?}?>
							</div>
						</div>
					</div>
					<div id="tabs-2" class="tab_item">
						<div class="row">
							<div class="specifications col-lg-8 col-md-8 col-sm-12 col-xs-12">
								<?if(isset($item['specifications']) && !empty($item['specifications'])){?>
									<table class="table">
										<col width="50%">
										<col width="50%">
										<tbody>
											<?foreach ($item['specifications'] as $s) {?>
												<tr>
													<td class="caption"><?=$s['caption']?></td>
													<td class="value"><?=$s['value'].' '.$s['units']?></td>
												</tr>
											<?}?>
										</tbody>
									</table>
								<?}else{?>
									<p>К сожалению характеристики товара временно отсутствует.</p>
								<?}?>
							</div>
						</div>
					</div>
					<div id="tabs-3" class="tab_item">
						<div class="tab_item_wrapper">
							<span class="tab_item_header">Способы оплаты:</span>
							<div class="row">
								<div class="col-md-6 payment_border">
									<span class="tab_item_label">Для физических лиц:</span>
									<div class="payment_item">
										<div class="row">
											<div class="col-md-12">
												<img src="<?=file_exists($GLOBALS['PATH_root'].'/images/payments/card.jpg')?_base_url.'/images/payments/card.jpg':'/efiles/_thumb/nofoto.jpg'?>" alt="Пополнение карточного счёта через терминал приема платежей ПриватБанка">
												<div class="payment_item_descr">
													<a href="#" class="open_modal" data-target="modal1">Пополнение карточного счёта через терминал приема платежей ПриватБанка</a>
													<div id="modal1" class="modal_hidden">
														<h4>Пополнение карточного счёта через терминал приема платежей ПриватБанка</h4>
														<ol class="payment_ol">
															<li>Зайти в любое отделение ПриватБанка;</li>
															<li>В меню терминала выбрать банковские операции с логотипом ПриватБанк;</li>
															<li>Ввести номер карточки получателя;</li>
															<li>Терминал будет обрабатывать данные и отобразит ФИО получателя;</li>
															<li>Скормить терминал купюрами (без сдачи);</li>
															<li>Подтвердить сумму оплаты;</li>
															<li>Распечатать квитанцию. (храните квитанцию до поступления суммы на ваш баланс);</li>
															<li>Сообщить сумму оплаты и номер заказа своему менеджеру.</li>
														</ol>
														<span class="requisites">Реквизиты можно получить у своего менеджера</span>
													</div>
													<table width="100%">
													<colgroup>
														<col width="20%">
														<col width="80%">
													</colgroup>
														<tr>
															<td>Комиссия:</td>
															<td><span class="color-red">0</span></td>
														</tr>
														<tr>
															<td>Зачисление:</td>
															<td>моментально</td>
														</tr>
													</table>
												</div>
											</div>
										</div>
									</div>
									<div class="payment_item">
										<div class="row">
											<div class="col-md-12">
												<img src="<?=file_exists($GLOBALS['PATH_root'].'/images/payments/privat.jpg')?_base_url.'/images/payments/privat.jpg':'/efiles/_thumb/nofoto.jpg'?>" alt="Пополнение карточного счёта в отделении ПриватБанка">
												<div class="payment_item_descr">
													<a href="#" class="open_modal" data-target="modal2">Пополнение карточного счёта в отделении ПриватБанка</a>
													<div id="modal2" class="modal_hidden">
														<h4>Пополнение карточного счёта в отделении ПриватБанка</h4>
														<ol class="payment_ol">
															<li>Зайти в любое отделение ПриватБанка;</li>
															<li>Предоставить кассиру номер карты* для перевода средств;</li>
															<li>Оплатить;</li>
															<li>Забрать квитанцию. (храните квитанцию до поступления суммы на ваш баланс);</li>
															<li>Сообщить сумму оплаты и номер заказа своему менеджеру.</li>
														</ol>
														<span class="requisites">Реквизиты можно получить у своего менеджера</span>
													</div>
													<table width="100%">
													<colgroup>
														<col width="20%">
														<col width="80%">
													</colgroup>
														<tr>
															<td>Комиссия:</td>
															<td><span class="color-red">0</span></td>
														</tr>
														<tr>
															<td>Зачисление:</td>
															<td>моментально</td>
														</tr>
													</table>
												</div>
											</div>
										</div>
									</div>
									<div class="payment_item">
										<div class="row">
											<div class="col-md-12">
												<img src="<?=file_exists($GLOBALS['PATH_root'].'/images/payments/bank.jpg')?_base_url.'/images/payments/bank.jpg':'/efiles/_thumb/nofoto.jpg'?>" alt="Банковским переводом с другого банка">
												<div class="payment_item_descr">
													<a href="#" class="open_modal" data-target="modal3">Банковским переводом с другого банка</a>
													<div id="modal3" class="modal_hidden">
														<h4>Банковским переводом с другого банка</h4>
														<ol class="payment_ol">
															<li>Зайти отделение банка;</li>
															<li>Предоставить кассиру реквизиты;</li>
															<li>Оплатить;</li>
															<li>Забрать квитанцию (храните квитанцию до поступления суммы на ваш баланс);</li>
															<li>Сообщить название банка. сумму оплаты и номер заказа своему менеджеру.</li>
														</ol>
														<span class="requisites">Реквизиты можно получить у своего менеджера</span>
													</div>
													<table width="100%">
													<colgroup>
														<col width="20%">
														<col width="80%">
													</colgroup>
														<tr>
															<td>Комиссия:</td>
															<td><span class="color-red">согласно тарифам банка</span></td>
														</tr>
														<tr>
															<td>Зачисление:</td>
															<td>от 1 до 3 суток</td>
														</tr>
													</table>
												</div>
											</div>
										</div>
									</div>
									<div class="payment_item">
										<div class="row">
											<div class="col-md-12">
												<img src="<?=file_exists($GLOBALS['PATH_root'].'/images/payments/terminals.jpg')?_base_url.'/images/payments/terminals.jpg':'/efiles/_thumb/nofoto.jpg'?>" alt="Через терминал приема платежей другого банка">
												<div class="payment_item_descr">
													<a href="#" class="open_modal" data-target="modal4">Через терминал приема платежей другого банка</a>
													<div id="modal4" class="modal_hidden">
														<h4>Через терминал приема платежей другого банка</h4>
														<ol class="payment_ol">
															<li>В меню терминала выбрать пополнение карточного счёта;</li>
															<li>Терминал будет обрабатывать данные и отобразит ФИО получателя;</li>
															<li>Скормить терминал купюрами (без сдачи);</li>
															<li>Подтвердить сумму оплаты;</li>
															<li>Распечатать квитанцию. (храните квитанцию до поступления суммы на ваш баланс);</li>
															<li>Сообщить сумму оплаты и номер заказа своему менеджеру.</li>
														</ol>
														<span class="requisites">Реквизиты можно получить у своего менеджера</span>
													</div>
													<table width="100%">
													<colgroup>
														<col width="20%">
														<col width="80%">
													</colgroup>
														<tr>
															<td>Комиссия:</td>
															<td><span class="color-red">согласно тарифам терминала</span></td>
														</tr>
														<tr>
															<td>Зачисление:</td>
															<td>от 1 до 3 суток</td>
														</tr>
													</table>
												</div>
											</div>
										</div>
									</div>
									<div class="payment_item">
										<div class="row">
											<div class="col-md-12">
												<img src="<?=file_exists($GLOBALS['PATH_root'].'/images/payments/privat24.jpg')?_base_url.'/images/payments/privat24.jpg':'/efiles/_thumb/nofoto.jpg'?>" alt="Приват24">
												<div class="payment_item_descr">
													<a href="#" class="open_modal" data-target="modal5">Приват24</a>
													<div id="modal5" class="modal_hidden">
														<div class="msg-info">
															<p>Для дополнительной информации свяжитесь с нашими менеджерами.</p>
														</div>
													</div>
													<table width="100%">
													<colgroup>
														<col width="20%">
														<col width="80%">
													</colgroup>
														<tr>
															<td>Комиссия:</td>
															<td><span class="color-red">0</span></td>
														</tr>
														<tr>
															<td>Зачисление:</td>
															<td>моментально</td>
														</tr>
													</table>
												</div>
											</div>
										</div>
									</div>
									<div class="payment_item">
										<div class="row">
											<div class="col-md-12">
												<img src="<?=file_exists($GLOBALS['PATH_root'].'/images/payments/nalog.jpg')?_base_url.'/images/payments/nalog.jpg':'/efiles/_thumb/nofoto.jpg'?>" alt="Наложенный платеж">
												<div class="payment_item_descr">
													<a href="#" class="open_modal" data-target="modal6">Наложенный платеж</a>
													<div id="modal6" class="modal_hidden">
														<h4>Наложенный платеж</h4>
														<ul class="payment_ul">
															<li>При выборе данного способа оплаты, покупка отправляется на указанный адрес курьерской службой «НОВАЯ ПОЧТА» или «ИНТАЙМ».</li>
															<li>При общей сумме заказа более 1000 грн. Обязательна предоплата в размере ~10% от суммы заказа.</li>
															<li>Перевозчику при получении товара оплачивается необходимый остаток суммы + 3 % комиссии, а также услуги оформления наложенного платежа у транспортной компании (обычно ~2%).</li>
															<li>При первом заказе до 1000 грн. комиссия в 3% не взымается.</li>
														</ul>
													</div>
													<table width="100%">
													<colgroup>
														<col width="20%">
														<col width="80%">
													</colgroup>
														<tr>
															<td>Комиссия:</td>
															<td><span class="color-red">от 2 до 6%*</span></td>
														</tr>
														<tr>
															<td>Зачисление:</td>
															<td>расчет при получении товара</td>
														</tr>
													</table>
												</div>
											</div>
										</div>
									</div>
									<div class="payment_item">
										<div class="row">
											<div class="col-md-12">
												<img src="<?=file_exists($GLOBALS['PATH_root'].'/images/payments/cash.jpg')?_base_url.'/images/payments/cash.jpg':'/efiles/_thumb/nofoto.jpg'?>" alt="Наличный расчет">
												<div class="payment_item_descr">
													<a href="#" class="open_modal" data-target="modal7">Наличный расчет</a>
													<div id="modal7" class="modal_hidden">
														<h4>Наличный расчет на территории ТЦ «Барабашово»</h4>
														<ul class="payment_ul">
															<li>Оплата производится при получении (самовывоз) на территории ТЦ «Барабашово»</li>
															<li>В некоторых случаях требуется авансовый платеж.</li>
															<li>Наличный расчет с курьером в момент передачи товара (г. Харьков).</li>
															<li>Данный способ оплаты распространяется только на покупателей г. Одесса и района.</li>
															<li>Оплата доставки по Харькову договорная, зависит от объема и веса заказа.</li>
														</ul>
													</div>
													<table width="100%">
													<colgroup>
														<col width="20%">
														<col width="80%">
													</colgroup>
														<tr>
															<td>Комиссия:</td>
															<td><span class="color-red">0</span></td>
														</tr>
														<tr>
															<td>Зачисление:</td>
															<td>расчет при получении товара</td>
														</tr>
													</table>
												</div>
											</div>
										</div>
									</div>
									<div class="payment_item">
										<div class="row">
											<div class="col-md-12">
												<img src="<?=file_exists($GLOBALS['PATH_root'].'/images/payments/webmoney.jpg')?_base_url.'/images/payments/webmoney.jpg':'/efiles/_thumb/nofoto.jpg'?>" alt="WebMoney">
												<div class="payment_item_descr">
													<a href="#" class="open_modal" data-target="modal8">WebMoney</a>
													<div id="modal8" class="modal_hidden">
														<h4>WebMoney</h4>
														<ul class="payment_ul">
														Кошельки для перевода денег:
															<li>UAH</li>
															<li>USD</li>
															<li>RUB</li>
															<li>BYR</li>
														</ul>
														<span class="requisites">Номер кошелька можно получить у своего менеджера</span>
													</div>
													<table width="100%">
													<colgroup>
														<col width="20%">
														<col width="80%">
													</colgroup>
														<tr>
															<td>Комиссия:</td>
															<td><span class="color-red">0</span></td>
														</tr>
														<tr>
															<td>Зачисление:</td>
															<td>моментально</td>
														</tr>
													</table>
												</div>
											</div>
										</div>
									</div>
									<div class="payment_item">
										<div class="row">
											<div class="col-md-12">
												<img src="<?=file_exists($GLOBALS['PATH_root'].'/images/payments/yandex-money.jpg')?_base_url.'/images/payments/yandex-money.jpg':'/efiles/_thumb/nofoto.jpg'?>" alt="Яндекс.Деньги">
												<div class="payment_item_descr">
													<a href="#" class="open_modal" data-target="modal9">Яндекс.Деньги</a>
													<div id="modal9" class="modal_hidden">
														<div class="msg-info">
															<p>Для дополнительной информации свяжитесь с нашими менеджерами.</p>
														</div>
													</div>
													<table width="100%">
													<colgroup>
														<col width="20%">
														<col width="80%">
													</colgroup>
														<tr>
															<td>Комиссия:</td>
															<td><span class="color-red">0</span></td>
														</tr>
														<tr>
															<td>Зачисление:</td>
															<td>моментально</td>
														</tr>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<span class="tab_item_label">Для юридических лиц:</span>
									<div class="payment_item">
										<div class="row">
											<div class="col-md-12">
												<img src="<?=file_exists($GLOBALS['PATH_root'].'/images/payments/cashless.jpg')?_base_url.'/images/payments/cashless.jpg':'/efiles/_thumb/nofoto.jpg'?>" alt="Безналичный расчёт, без НДС">
												<div class="payment_item_descr">
													<a href="#" class="open_modal" data-target="modal10">Безналичный расчёт, без НДС</a>
													<div id="modal10" class="modal_hidden">
														<h4>Безналичный расчёт, без НДС</h4>
														<ul class="payment_ul">
														Для того чтобы получить счет фактуру для оплаты:
															<li>сделайте заказ</li>
															<li>выберите способ оплаты безналичный расчет</li>
															<li>войдите в биллинг, выберите нужный счет и нажмите оплатить</li>
															<li>вам будет сформирован счет-фактура для оплаты по безналичному расчету</li>
														</ul>
													</div>
													<table width="100%">
													<colgroup>
														<col width="20%">
														<col width="80%">
													</colgroup>
														<tr>
															<td>Комиссия:</td>
															<td><span class="color-red">2%</span></td>
														</tr>
														<tr>
															<td>Зачисление:</td>
															<td>от моментально до 3 суток</td>
														</tr>
													</table>
												</div>
											</div>
										</div>
									</div>
									<div class="payment_item">
										<div class="row">
											<div class="col-md-12">
												<img src="<?=file_exists($GLOBALS['PATH_root'].'/images/payments/cashlessNDS.jpg')?_base_url.'/images/payments/cashlessNDS.jpg':'/efiles/_thumb/nofoto.jpg'?>" alt="Безналичный расчёт с НДС (налоговая накладная)">
												<div class="payment_item_descr">
													<a href="#" class="open_modal" data-target="modal11">Безналичный расчёт с НДС (налоговая накладная)</a>
													<div id="modal11" class="modal_hidden">
														<h4>Безналичный расчёт с НДС (налоговая накладная)</h4>
														<ul class="payment_ul">
														Для этого способа оплаты необходимо:
															<li>заключить договор</li>
															<li>сделайте заказ</li>
															<li>войдите в биллинг, выберите нужный счет и нажмите оплатить</li>
															<li>выберите способ оплаты безналичный расчет</li>
															<li>вам будет сформирован счет-фактура для оплаты по безналичному расчету</li>
															<li>при получении товара получите оригиналы документов</li>
														</ul>
													</div>
													<table width="100%">
													<colgroup>
														<col width="20%">
														<col width="80%">
													</colgroup>
														<tr>
															<td>Комиссия:</td>
															<td><span class="color-red">15%</span></td>
														</tr>
														<tr>
															<td>Зачисление:</td>
															<td>от моментально до 3 суток</td>
														</tr>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="tabs-4" class="tab_item">
						<div class="tab_item_wrapper">
							<div class="delivery_wrapper">
								<span class="tab_item_header">Способы доставки:</span>
								<span class="tab_item_label">Самовывоз</span>
								<p>Самовывоз производится с парковочных стоянок ТЦ Барабашово. До парковочных стоянок ТЦ Барабашово доставка товара бесплатная.</p>
								<span class="tab_item_label">Доставка транспортом Харьковторг</span>
								<p>Доставка осуществляется грузовым автотранспортом Харьковторг. В нашем распоряжении имеется тентированный автомобиль Газель и тентированный пикап	Богдан 2312 с обьемом кузова 2,5 м3. Возможен наем транспорта для перевозки Ваших грузов.
								По осуществлению грузоперевозок обращаться по телефонам - (067) 539-22-01 и (050) 304-27-76</p>
								<span class="tab_item_label">Транспортные компании</span>
								<p>Отправка заказаного товара производится транспортными компаниями. После отправки товара Вам перезвонят и сообщат номер декларации. Расходы транспортной компании на доставку груза оплачивает клиент при получении товара.
								В воскресенье и понедельник отправки производятся по согласованию с менеджером.</p><br>
								<p>Во избежание недоразумений и конфликтных ситуаций просим Вас при получении товара на отделении транспортной компании внимательно проверять целостность упаковки, соответствие количества товара и комплектности с указанным в сопроводительной накладной, внешний вид товара на отсутствие сколов, царапин, трещин, вмятин, боя и других дефектов.</p>
								<p>При обнаружении повреждений, недовеса, кражи и т.п. требуйте составления коммерческого акта от перевозчика с описанием повреждений упаковки груза и материального ущерба по накладной. В ином случае, дальнейшие претензии к перевозчику приняты не будут!
								По умолчанию груз отправляется через выбранного Вами перевозчика без страхования. Данную услугу предоставляет любая транспортная компания и по Вашему желанию стоимость страхования будет добавлена к стоимости товара при выставлении счета.
								На данный момент Мы работаем со следующими транспортными компаниями:</p>
								<div class="row delivery_items_wrapper">
									<div class="delivery_item">
										<div class="img_block">
											<img src="<?=file_exists($GLOBALS['PATH_root'].'/images/delivery/nova_poshta.png')?_base_url.'/images/payments/cashlessNDS.jpg':'/efiles/_thumb/nofoto.jpg'?>" tabs alt="Новая почта" width="100">
										</div>
										<span>Выходной - Понедельник</span>
										<a href="http://novaposhta.ua/frontend/calculator/ua">Калькулятор стоимости</a>
									</div>
									<div class="delivery_item">
										<div class="img_block">
											<img src="<?=file_exists($GLOBALS['PATH_root'].'/images/delivery/delivery.png')?_base_url.'/images/delivery/delivery.png':'/efiles/_thumb/nofoto.jpg'?>" alt="Деливери" width="100">
										</div>
										<span>Выходной - Воскресенье, Понедельник</span>
										<a href="http://www.delivery-auto.com/ru-RU/Calculator">Калькулятор стоимости</a>
									</div>
									<div class="delivery_item">
										<div class="img_block">
											<img src="<?=file_exists($GLOBALS['PATH_root'].'/images/delivery/ny_logo.png')?_base_url.'/images/delivery/ny_logo.png':'/efiles/_thumb/nofoto.jpg'?>" alt="Интайм" width="100">
										</div>
										<span>Выходной - Понедельник</span>
										<a href="http://www.intime.ua/calc/">Калькулятор стоимости</a>
									</div>
									<div class="delivery_item">
										<div class="img_block">
											<img src="<?=file_exists($GLOBALS['PATH_root'].'/images/delivery/gunsel.jpg')?_base_url.'/images/delivery/gunsel.jpg':'/efiles/_thumb/nofoto.jpg'?>" alt="GNS Cargo" width="100">
										</div>
										<span>Выходной - Понедельник</span>
										<a href="http://gnscargo.ua/">Калькулятор стоимости</a>
									</div>
									<div class="delivery_item">
										<div class="img_block">
											<img src="<?=file_exists($GLOBALS['PATH_root'].'/images/delivery/x-torg.png')?_base_url.'/images/delivery/x-torg.png':'/efiles/_thumb/nofoto.jpg'?>" alt="XT" width="100">
										</div>
										<span>Наша доставка</span>
									</div>
								</div>
								<p>Уважаемые клиенты!</p>
								<p>Обращаем Ваше внимание, что груз на отделении транспортной компании принимается по количеству мест, указанных в товарно-транспортной накладной.
								При получении заказа просим Вас осуществлять полную проверку исправности внешнего вида тары, которая использовалась при транспортировке; целостности фирменного скотча; внутреннего содержимого посылки на предмет отсутствия повреждений товара, наличия количества согласно товарной накладной, которую Вы сможете найти под этикеткой X-torg на внешней стороне упаковочной коробки.</p>
								<p>В случае несоответствий в посылке, Вы с представителем транспортной компании составляете акт досмотра , в котором указывается расхождения содержимого груза и имеющейся накладной, и о данной претензии в обязательном порядке сообщаете своему менеджеру. Претензии о недостаче товара за пределами транспортной компании не принимаются.</p>
								<p>Транспортная компания-перевозчик, согласно оплаченной Вами страховой суммы при оформлении заказа, обязуется компенсировать стоимость поврежденного или отсутствующего груза в полном или частичном объеме в зависимости от выбранного варианта страхования.</p>
								<p>На изображении, приведенном ниже, Вы можете увидеть отличительные черты упаковки Вашего заказа. Обязательно обратите внимание на то, что счет-накладная находится под стикером, на котором отображена короткая информация о заказе. Убедитесь в целостности упаковки. Ее гарантирует фирменная пломба – контрольная лента зеленого цвета. С целью защиты Ваших покупок от воздействия влаги, упаковка обернута стрейч-пленкой.</p>
								<span class="color-red">Внимание! В связи с не стабильной ситуацией в стране, цены могут меняться. Мы делаем все что от нас зависит для того, что бы цены были актуальными.</span>
							</div>
							<div class="bottom_box">
								<img src="<?=file_exists($GLOBALS['PATH_root'].'/efiles/katalog/korobka.jpg')?_base_url.'/efiles/katalog/korobka.jpg':'/efiles/_thumb/nofoto.jpg'?>" alt="Фирменная упаковка">
							</div>
						</div>
					</div>
					<div id="tabs-5" class="tab_item">
						<div class="tab_item_wrapper">
							<span class="photo_tab_title">Фотографии <span class="item_name"><?=$item['name']?></span></span>
							<div class="photo_tab_wrapper">
								<?if(!empty($item['images'])){
									foreach($item['images'] as $image){?>
										<div class="item">
											<img src="<?=_base_url?><?=$image['src']?>" alt="<?=$item['name']?>">
										</div>
									<?}
								}else{
									for($i=1; $i < 4; $i++){
										if(!empty($item['img_'.$i])){?>
											<div class="item">
												<img src="<?=file_exists($GLOBALS['PATH_root'].$item['img_'.$i])?_base_url.$item['img_'.$i]:'/efiles/_thumb/nofoto.jpg'?>" alt="<?=$item['name']?>">
											</div>
										<?}
									}
								}?>
							</div>
						</div>
					</div>
					<div id="tabs-6" class="tab_item">
						<div class="row">
							<div class="col-md-7 col-sm-6">
							<?if(empty($coment)){?>
								<div class="feedback_container">
									<p class="feedback_comment">Ваш отзыв может быть первым!</p>
								</div>
							<?}else{
								foreach($coment as $i){?>
									<div class="feedback_container">
										<span class="feedback_author"><?if(isset($i['name'])){echo $i['name'];}else{echo "Аноним";}?></span>
										<span class="feedback_date"><span class="icon-font">clock </span><?if(date("d") == date("d", strtotime($i['date_comment']))){?>
												Сегодня
											<?}elseif(date("d")-1 == date("d", strtotime($i['date_comment']))){?>
												Вчера
											<?}else{
												echo date("d.m.Y", strtotime($i['date_comment']));
											}?>
										</span>
										<?if ($i['rating'] > 0) {?>
											<span class="feedback_rating">
												Оценка товара:
												<?
												for($j = 1; $j <= 5; $j++){
													$star = 'star';
													if($j > floor($i['rating'])){
														if($j == ceil($i['rating'])){
															$star .= '_half';
														}else{
															$star .= '_outline';
														}
													}?>
													<span class="icon-font"><?=$star?></span>
												<?}?>
											</span>
										<?}?>
										<p class="feedback_comment"><?=$i['text_coment'];?></p>
										<!-- Конец строки розницы!-->
									</div>
								<?}
							}?>
							</div>
							<div class="col-md-5 col-sm-6">
								<div class="feedback_form">
									<h4>Оставить отзыв о товаре</h4>
									<form action="" method="post" onsubmit="onCommentSubmit()">
										<div class="feedback_stars">
											<label class="label_for_stars">Оценка:</label>
											<label>
												<input type="radio" name="rating" class="set_rating hidden" value="1">
												<span class="star icon-font">star_outline</span>
											</label>
											<label>
												<input type="radio" name="rating" class="set_rating hidden" value="2">
												<span class="star icon-font">star_outline</span>
											</label>
											<label>
												<input type="radio" name="rating" class="set_rating hidden" value="3">
												<span class="star icon-font">star_outline</span>
											</label>
											<label>
												<input type="radio" name="rating" class="set_rating hidden" value="4">
												<span class="star icon-font">star_outline</span>
											</label>
											<label>
												<input type="radio" name="rating" class="set_rating hidden" value="5">
												<span class="star icon-font">star_outline</span>
											</label>
										</div>
										<label for="feedback_text">Отзыв:</label>
										<textarea name="feedback_text" id="feedback_text" cols="30" rows="10" required></textarea>
										<div <?=(!isset($_SESSION['member']['id_user']) || $_SESSION['member']['id_user'] == 4028)?null:'class="hidden"';?>>
												<label for="feedback_author">Ваше имя:</label>
												<input type="text" name="feedback_author" id="feedback_author" required value="<?=isset($_SESSION['member']) && $_SESSION['member']['id_user'] != 4028?$_SESSION['member']['name']:null;?>">

											<label for="feedback_authors_email">Эл.почта:</label>
											<input type="email" name="feedback_authors_email" id="feedback_authors_email" required value="<?=isset($_SESSION['member']) && $_SESSION['member']['id_user'] != 4028?$_SESSION['member']['email']:null;?>">
										</div>
										<button type="submit" name="sub_com" class="btn-m-green">Отправить отзыв</button>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div id="tabs-7" class="tab_item">
						<div class="tab_item_wrapper">
							<span class="video_tab_title">Обзоры и видео <span class="item_name"><?=$item['name']?></span></span>
							<div class="video_tab_wrapper">
								<?if(!empty($item['videos'])){
									foreach($item['videos'] as $video){?>
										<object width="800" height="480" data="<?=str_replace('watch?v=', 'embed/', $video)?>"></object>
									<?}
								}?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">var max_sum_order = <?=$GLOBALS['CONFIG']['max_sum_order']?>;</script>
	<?if(!empty($related)){?>
		<div class="clear"></div>
		<h5>Также в разделе Вы найдете:</h5>
		<div id="ca-container" class="ca-container">
			<div class="ca-wrapper">
			<?$n=1;
			foreach($related AS $p){?>
				<div class="ca-item ca-item-<?=$n?>">
					<div class="ca-item-main">
						<a href="<? echo _base_url."/product/".$p['id_product']."/".$p['translit'] ?>">
							<img alt="<?=$p['name']?>" src="<?=file_exists($GLOBALS['PATH_root'].$p['img_1'])?htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $p['img_1'])):'/efiles/_thumb/nofoto.jpg'?>"/>
							<h6><?=$p['name']?></h6>
						</a>
						<a href="<? echo _base_url."/product/".$p['id_product']."/".$p['translit'] ?>" class="ca-more">Подробнее ...</a>
					</div>
				</div>
			<?$n++;}?>
			</div>
		</div>
		<script type="text/javascript">
			$('#ca-container').contentcarousel();
		</script>
	<?}?>
	<div class="clear"></div>
	<section class="content_text hidden">
		<?if(count($view_products_list) > 1){?>
			<div class="last_viewed">
				<h2>Последние просмотренные товары</h2>
				<div id="owl-demo" class="owl-carousel owl-theme">
					<?foreach ($view_products_list as $i){
						if($item['id_product'] != $i['id_product']){?>
							<div class="item">
								<a href="<?=_base_url."/product/".$i['id_product']."/".$i['translit']."/";?>">
									<img src="<?file_exists($GLOBALS['PATH_root'].$i['img_1'])?htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $i['img_1'])):'/efiles/_thumb/nofoto.jpg'?>" alt="<?=str_replace('"', '', $i['name'])?>" height="180"/>
									<span><?=$i['name']?></span>
									<div class="ca-more"><?=number_format($i['price_mopt']*$GLOBALS['CONFIG']['full_wholesale_discount'],2,",","")?> грн.</div>
								</a>
							</div>
						<?}
					}?>
				</div>
			</div>
		<?}?>
		<div class="clear"></div>
		<?=(isset($sdescr))?$sdescr:null;?>
	</section>
	<div style="margin-top: 100px;" class="hidden">
		<h3>Цена товара <?=$item['name']?> зависит от общей суммы заказа</h3>
		<?if(SETT != 0){
			require_once $GLOBALS['PATH_root'].'/koldunschik4/init.php';
			echo $k_link->showLinks(0); // раскомментировать для UTF-8
		}?>
	</div>
	<script>
		$(function(){

			//Слайдер миниатюр
			$('.arrow_Up').on('click', function() {   //Обработка клика на стрелку Вверх
				var carusel = $(this).parents('#product_miniatures_img');
				up_carusel(carusel);
				return false;
			});
			$('.arrow_Down').on('click', function() {   //Обработка клика на стрелку Вниз
				var carusel = $(this).parents('#product_miniatures_img');
				down_carusel(carusel);
				return false;
			});

			//Product photo block
			$('body').on('click', '#product_miniatures_img .item', function(){
				$('#product_miniatures_img').find('img').removeClass('active_img');
				$(this).find('img').addClass('active_img');
				var imgsrc = $(this).find('img').attr('src');
				if(imgsrc.indexOf("<?=str_replace(DIRSEP, '/', str_replace($GLOBALS['PATH_root'], '', $GLOBALS['PATH_product_img']));?>") > -1){
					imgsrc = imgsrc.replace('thumb', 'original');
				}else{
					imgsrc = imgsrc.replace('_thumb/', '');
				}
				$('#product_main_img').find('.item img').attr('src', imgsrc);
				$('#product_main_img').hide().fadeIn('100');
			});
			//Raiting stars
			$('.set_rating').on('change', function(){
				var rating = $(this).val();
				changestars(rating);
			});
			$('.star').hover(function(){
				var rating = $(this).closest('label').find('input').val();
				changestars(rating);
				$('.feedback_stars').on('mouseleave', function(){
					rating = $(this).find('input:checked').val();
					if(!rating){
						rating = 0;
					}
					changestars(rating);
				});
			});
			$('.star').on('click', function(e){
				var input = $(this).closest('label').find('input');
				if(input.is(":checked")){
					e.preventDefault();
					input.removeAttr('checked');
					changestars(0);
				}
			});
		});

		function changestars(rating){
			$('.set_rating').each(function(){
				var star = $(this).next('span');
				if(parseInt($(this).val()) <= parseInt(rating)){
					star.text('star');
				}else{
					star.text('star_outline');
				}
			});
		}
		//tabs-container
		$("#tabs").tabs();
	</script>
</div><!-- cabinet! -->