<div class="product" itemscope itemtype="http://schema.org/Product">
	<?// Проверяем доступнось розницы
	$mopt_available = ($item['price_mopt'] > 0 && $item['min_mopt_qty'] > 0)?true:false;
	// Проверяем доступнось опта
	$opt_available = ($item['price_mopt'] > 0 && $item['min_mopt_qty'] > 0)?true:false;
	$product_mark = '';
	$interval = date_diff(date_create(date("Y-m-d", strtotime($item['create_date']))), date_create(date("Y-m-d")));
	if(in_array($item['opt_correction_set'], $GLOBALS['CONFIG']['promo_correction_set']) || in_array($item['mopt_correction_set'], $GLOBALS['CONFIG']['promo_correction_set'])) {
		$product_mark = 'action';
	}elseif ($item['prod_status'] == 3 && $interval->format('%a') < 30){
		$product_mark = 'new';
	}?>
	<div class="mdl-grid">
		<div id="caruselCont" class="mdl-cell mdl-cell--3-col">
			<div class="product_main_img btn_js mdl-cell--hide-tablet mdl-cell--hide-phone" data-name="big_photos_carousel">
				<?if(!empty($item['images'])){?>
					<img class="main_img_js" itemprop="image" alt="<?=G::CropString($item['id_product'])?>" src="<?=G::GetImageUrl($item['images'][0]['src'])?>"/>
				<?}else if(!empty($item['img_1'])){?>
					<img class="main_img_js" itemprop="image" alt="<?=G::CropString($item['id_product'])?>" src="<?=G::GetImageUrl($item['img_1'])?>"/>
				<?}else{?>
					<img class="main_img_js" itemprop="image" alt="<?=G::CropString($item['id_product'])?>" src="<?=G::GetImageUrl('/images/nofoto.png')?>"/>
				<?}?>
				<div id="mainVideoBlock" class="hidden">
					<iframe width="100%" height="100%" src="" frameborder="0" allowfullscreen></iframe>
				</div>
				<?if(isset($product_mark) && $product_mark !== '' && $item['active'] != 0){?>
					<div class="market_action">
						<img src="<?=G::GetImageUrl('/images/'.$product_mark.'.png')?>" alt="<?=$product_mark === 'action'?'акционный товар':'новый товар'?>">
					</div>
				<?}?>
			</div>
			<?if(G::isMobile()){?>
				<div id="owl-product_mobile_img_js" class="mobile_carousel">
					<?if(!empty($item['images'])){
						foreach($item['images'] as $i => $image){?>
							<img src="<?=G::GetImageUrl($image['src'], 'medium')?>" alt="<?=htmlspecialchars($item['name'])?>">
						<?}
					}else{
						for($i=1; $i < 4; $i++){
							if(!empty($item['img_'.$i])){?>
								<img src="<?=G::GetImageUrl($item['img_'.$i], 'medium')?>" alt="<?=htmlspecialchars($item['name'])?>">
							<?}
						}
					}?>
					<?if(!empty($item['videos'])){
						foreach($item['videos'] as $i => $video){?>
							<div class="item-video"><a class="owl-video" href="<?=$video?>"></a></div>
						<?}
					}?>
				</div>
				<script>
					//Инициализация owl carousel
					$('#owl-product_mobile_img_js').owlCarousel({
						center:			true,
						dots:			true,
						items:			1,
						lazyLoad:		true,
						/*loop:			true,*/
						margin:			20,
						nav:			true,
						video:			true,
						videoHeight:	345,
						videoWidth:		345,
						navText: [
							'<svg class="arrow_left"><use xlink:href="images/slider_arrows.svg#arrow_left_tidy"></use></svg>',
							'<svg class="arrow_right"><use xlink:href="images/slider_arrows.svg#arrow_right_tidy"></use></svg>'
						]
					});
				</script>
			<?}else{?>
				<div id="owl-product_mini_img_js">
					<?if(!empty($item['images'])){
						foreach($item['images'] as $i => $image){?>
							<img src="<?=G::GetImageUrl($image['src'], 'thumb')?>" alt="<?=htmlspecialchars($item['name'])?>"<?=$i==0?'class="act_img"':'class=""';?>>
						<?}
					}else{
						for($i=1; $i < 4; $i++){
							if(!empty($item['img_'.$i])){?>
								<img src="<?=G::GetImageUrl($item['img_'.$i], 'thumb')?>" alt="<?=htmlspecialchars($item['name'])?>"<?=$i==1?' class="act_img"':'class=""';?>>
							<?}
						}
					}?>
					<!-- Код добавления видео начало-->
					<?if(!empty($item['videos'])){
						foreach($item['videos'] as $i => $video){?>
							<div class="videoBlock">
								<div class="videoBlockShield"></div>
								<iframe width="120" height="90" src="<?=str_replace('watch?v=', 'embed/', $video)?>" frameborder="0" allowfullscreen alt="<?=htmlspecialchars($item['name'])?>">
								</iframe>
							</div>
						<?}
					}?>
					<!-- Код добавления видео конец-->
				</div>
				<div id="big_photos_carousel" data-type="modal">
					<div class="modal_container">
						<div id="big_photos_carousel_js" class="carousel big_photos_carousel">
							<?if(!empty($item['images'])){
								foreach($item['images'] as $i => $image){?>
									<img src="<?=G::GetImageUrl($image['src'])?>" alt="<?=htmlspecialchars($item['name'])?>">
								<?}
							}else{
								for($i=1; $i < 4; $i++){
									if(!empty($item['img_'.$i])){?>
										<img src="<?=G::GetImageUrl($item['img_'.$i])?>" alt="<?=htmlspecialchars($item['name'])?>">
									<?}
								}
							}?>
							<?if(!empty($item['videos'])){
								foreach($item['videos'] as $i => $video){?>
									<div class="item-video"><a class="owl-video" href="<?=$video?>"></a></div>
								<?}
							}?>
						</div>
					</div>
				</div>
				<script>
					//Инициализация owl carousel
					$('#owl-product_mobile_img_js, #big_photos_carousel_js').owlCarousel({
						center:			true,
						dots:			true,
						items:			1,
						lazyLoad:		true,
						/*loop:			true,*/
						margin:			20,
						nav:			true,
						video:			true,
						videoHeight:	500,
						videoWidth:		$(document).outerWidth() > 1300?700:500,
						navText: [
							'<svg class="arrow_left"><use xlink:href="images/slider_arrows.svg#arrow_left_tidy"></use></svg>',
							'<svg class="arrow_right"><use xlink:href="images/slider_arrows.svg#arrow_right_tidy"></use></svg>'
						]
					});
					//Инициализация owl carousel
					$("#owl-product_mini_img_js").owlCarousel({
						dots:	false,
						items:	4,
						margin:	10,
						nav:	true,
						responsive: {
							320:	{items: 1},
							727:	{items: 2},
							950:	{items: 3},
							1250:	{items: 3},
							1600:	{items: 4}
						},
						navText: [
							'<svg class="arrow_left"><use xlink:href="images/slider_arrows.svg#arrow_left_tidy"></use></svg>',
							'<svg class="arrow_right"><use xlink:href="images/slider_arrows.svg#arrow_right_tidy"></use></svg>'
						]
					});
				</script>
			<?}?>
		</div>
		<!-- Класс-метка no_active_product_block ставится в зависимости от того, активен товар или нет и задает соответствующие стили -->
		<div id="specCont" class="specCont_js mdl-cell mdl-cell--9-col <?= $item['active'] != 1?'no_active_product_block':null;?>">
			<div class="product_name">
				<h1 itemprop="name"><?=$item['name']?></h1>
			</div>
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--7-col">
					<div>
						<input type="hidden" class="path_root_js" value="<?=$GLOBALS['PATH_root']?>">
						<input type="hidden" class="path_product_img_js" value="<?=$GLOBALS['PATH_product_img']?>">
					</div>
					
					<div class="pc_flex_wrap">
						<div class="product_content_wrap">
							<div class="content_header">
								<?=$cart_info;?>
							</div>
							<div class="products_details">
								<div class="art_avail_stars">
									<p class="product_article">Артикул: <?=$item['art']?></p>
									<?if(isset($_SESSION['member']) && in_array($_SESSION['member']['gid'], array(1, 2, 9, 14))){?>
										<!-- Ссылка на редактирование товара для администратором -->
										<a href="<?=Link::Custom('adm', 'productedit');?>/<?=$item['id_product']?>" target="_blank">Редактировать товар</a>
									<?}?>
									<div><?=isset($item['active']) && $item['active'] == 1?'В наличии':'Нет в наличии';?></div>
									<div class="rating_block" id="rating_block" <?=$item['c_mark'] > 0?'itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"':null;?>>
										<?if($item['c_mark'] > 0){?>
											<meta itemprop="worstRating" content="1">
											<meta itemprop="bestRating" content="5">
											<span class="hidden" itemprop="ratingValue"><?=$item['c_rating']?></span>
											<span class="hidden" itemprop="reviewCount"><?=$item['c_mark']?></span>
										<?}?>
										<?if($item['c_rating'] > 0){?>
											<span>Оценок товара: </span>
											<ul class="rating_stars">
												<?for($i = 1; $i <= 5; $i++){
													$star = 'star';
													if($i > floor($item['c_rating'])){
														if($i == ceil($item['c_rating'])){
															if(number_format($item['c_rating'], 1)[2] >= 5){
																$star .= '_half';
															}elseif(number_format($item['c_rating'], 1)[2] < 5){
																$star .= '_border';
															}
														}else{
															$star .= '_border';
														}
													}?>
													<li><i class="material-icons"><?=$star?></i></li>
												<?}?>
											</ul>
											<!-- <span class="stars_qty"><?=number_format($item['c_rating'], 1)[2] >= 5? number_format($item['c_rating'], 1):number_format($item['c_rating'], 1)[0]?> / 5</span> -->
											<span class="qty_ratings">(<?=$item['c_mark']?>)</span>
										<?}?>
									</div>
									<div class="mdl-tooltip" for="rating_block">Рейтинг товара</div>
								</div>
								<div class="pb_wrapper">
									<?$in_cart = !empty($_SESSION['cart']['products'][$item['id_product']])?true:false;
									$a = explode(';', $GLOBALS['CONFIG']['correction_set_'.$item['opt_correction_set']]);?>
									<div class="product_buy" data-idproduct="<?=$item['id_product']?>">
										<div class="buy_block" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
											<meta itemprop="priceCurrency" content="UAH">
											<link itemprop="availability" href="http://schema.org/<?=$opt_available?'InStock':'Out of stock'?>" />
											<div class="price_wrap">
												
												<div class="price <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>" itemprop="price" content="<?=$in_cart?number_format($_SESSION['cart']['products'][$item['id_product']]['actual_prices'][$_COOKIE['sum_range']], 2, ",", ""):number_format($item['price_opt']*$a[$_COOKIE['sum_range']], 2, ".", "");?>">
													<?=$in_cart?number_format($_SESSION['cart']['products'][$item['id_product']]['actual_prices'][$_COOKIE['sum_range']], 2, ",", ""):number_format($item['price_opt']*$a[$_COOKIE['sum_range']], 2, ",", "");?>
													<span class="bold_text"> грн.</span><span> / </span><span class="bold_text"><?=$item['units']?></span>
												</div>

												<div class="base_price <?=isset($product_mark) && $product_mark === 'action'?null:'hidden'?> <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>">
													<?if (!isset($_SESSION['cart']['products'][$item['id_product']]['quantity']) || ($_SESSION['cart']['products'][$item['id_product']]['quantity'] >= $item['inbox_qty'])){?>
														<?=number_format($item['base_prices_opt'][$_COOKIE['sum_range']], 2, ",", "")?>
													<?}else{?>
														<?=number_format($item['base_prices_mopt'][$_COOKIE['sum_range']], 2, ",", "")?>
													<?}?>
													<span class="bold_text"> грн.</span><span> / </span><span class="bold_text"><?=$item['units']?></span>
												</div>

												<!-- Цена поставщика -->
												<div class="price card_item <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?null:'hidden'?>">
													<?if($item['price_opt_otpusk'] != 0){
														echo number_format($item['price_opt_otpusk'], 2, ",", "");
													}else{
														echo number_format($item['price_mopt_otpusk'], 2, ",", "");
													}?>
												</div>
												<!-- <span> грн.</span> -->
											</div>

											<div class="prodBasePrices hidden">
												<?for($i = 0; $i < 4; $i++){?>
													<input class="basePriceOpt<?=$i?>" value="<?=number_format($item['base_prices_opt'][$i], 2, ",", "")?>">
													<input class="basePriceMopt<?=$i?>" value="<?=number_format($item['base_prices_mopt'][$i], 2, ",", "")?>">
												<?}?>
											</div>
											<div class="prodPrices hidden">
												<div class="itemProdQty"><?=$item['min_mopt_qty']?></div>
												<?for($i = 0; $i < 4; $i++){?>
													<input class="priceOpt<?=$i?>" value="<?=$item['prices_opt'][$i]?>">
													<input class="priceMopt<?=$i?>" value="<?=$item['prices_mopt'][$i]?>">
												<?}?>
											</div>
											<div class="qty_buy">
												<div class="quantity <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>">
													<button id="btn_add<?=$item['id_product']?>" class="material-icons btn_add btn_qty_js out_card_js" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1); return false;">add</button>
													<div class="mdl-tooltip mdl-tooltip--top tooltipForBtnAdd_js hidden" for="btn_add<?=$item['id_product']?>">Больше</div>
													<label for="qty">Кол-во: </label>
													<input type="text" class="minQty hidden" value="<?=$item['inbox_qty']?>">
													<input type="text" name="qty" class="qty_js out_card_js" value="<?=isset($_SESSION['cart']['products'][$item['id_product']]['quantity'])?$_SESSION['cart']['products'][$item['id_product']]['quantity']:$item['inbox_qty']?>" onchange="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null);return false;">

													<button id="btn_remove<?=$item['id_product']?>" class="material-icons btn_remove btn_qty_js out_card_js" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 0);return false;">remove</button>
													<div class="mdl-tooltip tooltipForBtnRemove_js hidden" for="btn_remove<?=$item['id_product']?>">Меньше</div>

													<div class="units"><?=$item['units'];?></div>
												</div>
												<div class="btn_buy <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>">
													<div id="in_cart_<?=$item['id_product'];?>" class="btn_js in_cart_js <?=isset($_SESSION['cart']['products'][$item['id_product']])?null:'hidden';?>" data-name="cart"><i class="material-icons">shopping_cart</i><!-- В корзине --></div>
													<div class="mdl-tooltip" for="in_cart_<?=$item['id_product'];?>">Товар в корзине</div>
													<button class="mdl-button mdl-js-button buy_btn_js out_card_js <?=isset($_SESSION['cart']['products'][$item['id_product']])?'hidden':null;?>" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null); return false;">Купить</button>
												</div>
											</div>
											<!-- Блок для поставщика -->
											<div class="supplier_block <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?null:'hidden'?>">
												<div class="count_cell">
													<span class="suplierPriceBlockLabel">Минимальное кол-во:</span>
													<p id="min_mopt_qty_<?=$item['id_product']?>"><?=$item['min_mopt_qty'].' '.$item['units']?><?=$item['qty_control']?" *":null?></p>
												</div>
												<div class="count_cell">
													<span class="suplierPriceBlockLabel">Количество в ящике:</span>
													<p id="inbox_qty_<?=$item['id_product']?>"><?=$item['inbox_qty'].' '.$item['units']?></p>
												</div>
												<div class="product_check <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?null:'hidden'?>">
													<span class="suplierPriceBlockLabel">Добавить:</span>
													<label  class="mdl-checkbox mdl-js-checkbox" for="checkbox_mopt_<?=$item['id_product']?>">
														<input type="checkbox" class="check mdl-checkbox__input" id="checkbox_mopt_<?=$item['id_product']?>" <?=isset($_SESSION['Assort']['products'][$item['id_product']])?'checked=checked':null?> onchange="AddDelProductAssortiment(this,<?=$item['id_product']?>)"/>
													</label>
												</div>
											</div>
										</div>
										<div class="priceMoptInf<?=($in_cart && $_SESSION['cart']['products'][$item['id_product']]['quantity'] < $item['inbox_qty'])?'':' hidden'?>">Малый опт</div>
									</div>
								</div>
								<div class="note <?=$item['note_control'] != 0?'note_control':null?> <?=isset($_SESSION['cart']['products'][$item['id_product']])?null:'hidden';?> <?=isset($_SESSION['cart']['products'][$item['id_product']]['note']) && $_SESSION['cart']['products'][$item['id_product']]['note'] != '' ?null:'activeNoteArea'?>">
									<textarea class="note_field" placeholder="<?=$item['note_control'] != 0?'ПРИМЕЧАНИЕ ОБЯЗАТЕЛЬНО!!!':' Примечание:'?>" id="mopt_note_<?=$item['id_product']?>" data-id="<?=$item['id_product']?>"><?=isset($_SESSION['cart']['products'][$item['id_product']]['note'])?$_SESSION['cart']['products'][$item['id_product']]['note']:null?></textarea>
									<label class="info_key">?</label>
									<div class="info_description">
										<p>Поле для ввода примечания к товару.</p>
									</div>
								</div>
								<?if($item['active'] == 0 || $item['visible'] == 0){?>
									<div class="sold_produxt_info">
										<p>На данный момент текущий товар не доступен для приобретения. Вы можете добавить его в "Лист ожидания" и будете проинформированы когда товар вновь появится в продаже. Чтобы добавить товар в список, нажмите кнопку ниже <strong>"Следить за ценой"</strong>.</p>
										<!-- <div class="icon"><div class="material-icons">trending_down</div></div> -->
										<ul>
											<li id="fortrending_info" class="fortrending <?=isset($_SESSION['member']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>" data-id-product="<?=$item['id_product'];?>" <?=isset($_SESSION['member'])?'data-id-user="'.$_SESSION['member']['id_user'].'" data-email="'.$_SESSION['member']['email'].'"':'';?>>
												<div class="waiting_list icon material-icons <?=isset($_SESSION['member']['waiting_list']) && in_array($item['id_product'], $_SESSION['member']['waiting_list'])? 'arrow' : null;?>">trending_down</div>
											</li>
										</ul>
										<div class="mdl-tooltip fortrending_info_tooltip" for="fortrending_info">
											<?=isset($_SESSION['member']['waiting_list']) && in_array($item['id_product'], $_SESSION['member']['waiting_list'])?'Товар уже <br> в листе ожидания' : 'Следить за ценой';?>
										</div>
									</div>
								<?}?>
								<div class="notificationProdNote <?=isset($item['note_control']) && $item['note_control'] == 0 ? 'hidden' : ''?>">
									<span>Данный товар имеет дополнительные конфигурации (цвет, материал и тд.). Укажите свои пожелания к товару в поле "Примечание" при оформлении заказа в корзине.</span>
								</div>
							</div>
							<div class="apps_panel mdl-cell--hide-phone">
								<ul>
									<li class="favorite<?=isset($_SESSION['member']['favorites']) && in_array($item['id_product'], $_SESSION['member']['favorites'])?' added':null;?> <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>" data-id-product="<?=$item['id_product'];?>">
										<?if(isset($_SESSION['member']['favorites']) && in_array($item['id_product'], $_SESSION['member']['favorites'])){?>
											В избранных
											<i id="forfavorite" class="isfavorite material-icons">favorite</i>
											<span class="mdl-tooltip" for="forfavorite">Товар уже в избранном</span></li>
										<?}else{?>
											В избранное
											<i id="forfavorite" class="notfavorite material-icons">favorite_border</i>
											<!-- <span class="mdl-tooltip" for="forfavorite">Добавить товар в избранное</span> --></li>
										<?}?>
									<li id="fortrending" class="fortrending <?=isset($_SESSION['member']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>" data-id-product="<?=$item['id_product'];?>" <?=isset($_SESSION['member'])?'data-id-user="'.$_SESSION['member']['id_user'].'" data-email="'.$_SESSION['member']['email'].'"':'';?>>
										Следить за ценой
										<div class="waiting_list icon material-icons <?=isset($_SESSION['member']['waiting_list']) && in_array($item['id_product'], $_SESSION['member']['waiting_list'])? 'arrow' : null;?>">trending_down</div></li>
									<!-- <div class="mdl-tooltip fortrending_info_tooltip" for="fortrending"><?=isset($_SESSION['member']['waiting_list']) && in_array($item['id_product'], $_SESSION['member']['waiting_list'])? 'Товар уже <br> в списке ожидания' : 'Следить за ценой';?></div> -->
									<li>Поделиться <i id="shareButton" class="material-icons">share</i>
									<!-- <span class="mdl-tooltip" for="shareButton">Поделиться</span></li> -->
								</ul>
								<div id="socialShare" class="mdl-menu mdl-menu--bottom-right mdl-js-menu social" for="shareButton">
									<ul class="social">
										<li>
											<a href="http://vk.com/share.php?url=<?=Link::Product($GLOBALS['Rewrite']);?>&title=<?=htmlspecialchars($item['name'])?>&description=<?=strip_tags($item['descr'])?>&image=<?=G::GetImageUrl($item['img_1'])?>&noparse=true" target="_blank" class="vk" title="Вконтакте" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
												<img src="<?=$GLOBALS['URL_img_theme']?>vk.svg" alt="Вконтакте">
											</a>
										</li>
										<li>
											<a href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=<?=Link::Product($GLOBALS['Rewrite']);?>&st.comments=<?=htmlspecialchars($item['name'])?>" target="_blank" class="ok" title="Однокласники" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
												<img src="<?=$GLOBALS['URL_img_theme']?>odnoklassniki.svg" alt="Одноклаcсники">
											</a>
										</li>
										<li>
											<a href="https://plus.google.com/share?url=<?=Link::Product($GLOBALS['Rewrite']);?>" target="_blank" class="g_pl" title="google+" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
												<img src="<?=$GLOBALS['URL_img_theme']?>google-plus.svg" alt="google+">
											</a>
										</li>
										<li>
											<a href="http://www.facebook.com/sharer.php?u=<?=Link::Product($GLOBALS['Rewrite']);?>&title='<?=htmlspecialchars($item['name'])?>'&description=<?=strip_tags($item['descr'])?>&picture=<?=G::GetImageUrl($item['img_1'])?>" target="_blank" class="f" title="Facebook" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
												<img src="<?=$GLOBALS['URL_img_theme']?>facebook.svg" alt="Facebook">
											</a>
										</li>
										<li>
											<a href="https://twitter.com/share?url=<?=Link::Product($GLOBALS['Rewrite']);?>&text=<?=htmlspecialchars($item['name'])?>" target="_blank" class="tw" title="Twitter" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
												<img src="<?=$GLOBALS['URL_img_theme']?>twitter.svg" alt="Twitter">
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--5-col">
					<div class="similar_products_mini">
						<?if(isset($item['active']) && $item['active'] == 0){
							if(isset($random_products) && !empty($random_products)){?>
								<h4>Похожие товары</h4>
								<?$iter = 0?>
								<?foreach($random_products as $p){?>
									<?if($iter != 2){?>
										<div class="item">
											<a href="<?=Link::Product($p['translit']);?>">
												<div class="img_cont">
													<?if(!empty($p['images'][0])){?>
														<img alt="<?=htmlspecialchars($p['name'])?>" src="<?=G::GetImageUrl($p['images'][0]['src'], 'medium');?>">
													<?}else	if(!empty($p['img_1'])){?>
														<img alt="<?=htmlspecialchars($p['name'])?>" src="<?=G::GetImageUrl($p['img_1'], 'medium');?>"/>
													<?}else{?>
														<img alt="" src="<?=G::GetImageUrl('/images/nofoto.png')?>">
													<?}?>
												</div>
												<div class="item_info">
													<span class="item_name"><?=$p['name']?></span>
													<span class="ca-more price_num">
														<?if($p['price_mopt'] > 100){
															print_r(ceil($p['price_mopt']*$GLOBALS['CONFIG']['full_wholesale_discount']));
														}else{
															print_r(number_format($p['price_mopt']*$GLOBALS['CONFIG']['full_wholesale_discount'], 2, ',', ''));
														}?>
													</span>
													<span>грн.</span><span><?=isset($p['units'])?'/'.$p['units']:null;?></span>
													<div class="product_buy" data-idproduct="<?=$p['id_product']?>">
														<?if(isset($p['active']) && $p['active'] == 0){?>
															<p class="out_of_stock">Нет в наличии</p>
														<?}else{?>
															<div class="buy_block" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
																<div class="btn_buy <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>">
																	<div id="in_cart_<?=$p['id_product'];?>" class="btn_js in_cart_js <?=isset($_SESSION['cart']['products'][$p['id_product']])?null:'hidden';?>" data-name="cart"><i class="material-icons">shopping_cart</i><!-- В корзине --></div>
																	<div class="mdl-tooltip" for="in_cart_<?=$p['id_product'];?>">Товар в корзине</div>
																	<button class="mdl-button mdl-js-button buy_btn_js out_card_js <?=isset($_SESSION['cart']['products'][$p['id_product']])?'hidden':null;?>" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null); return false;">Купить</button>
																</div>
																<input class="qty_js" type="hidden" value="<?=isset($p['min_mopt_qty'])?$p['min_mopt_qty']:1;?>">
															</div>
														<?}?>
													</div>
												</div>
											</a>
										</div>
									<? $iter++;
									}?>
								<?}?>
								<div class="more_items_link">
									<a class="anchor_link_js" href="#similar_products">Посмотреть все похожие предложения</a>
								</div>
							<?}
						}else{?>
							<div class="extra_info_block">
								Бесплатная доставка и бонусы
							</div>
						<?}?>
					</div>
				</div>
			</div>
			<?if(isset($pops) && !empty($pops)){?>
				<div class="slider_products">
					<h4>С этой категории (рандом)</h4>
					<div id="owl-top" class="owl-carousel">
						<?foreach($pops as $p){?>
							<div class="item">
								<a href="<?=Link::Product($p['translit']);?>">
									<?if(!empty($p['images'])){?>
										<img alt="<?=htmlspecialchars($p['name'])?>" src="<?=G::GetImageUrl($p['images'][0]['src'], 'medium')?>">
									<?}else	if(!empty($p['img_1'])){?>
										<img alt="<?=htmlspecialchars($p['name'])?>" src="<?=G::GetImageUrl($p['img_1'], 'medium')?>"/>
									<?}else{?>
										<img alt="" src="<?=G::GetImageUrl('/images/nofoto.png')?>">
									<?}?>
									<span><?=$p['name']?></span>
									<?if($p['price_mopt'] > 100){?>
										<div class="ca-more">от <?=ceil($p['prices_opt'][0])?> грн.</div>
									<?}else{?>
										<div class="ca-more">от <?=number_format($p['prices_opt'][0], 2, ',', '')?> грн.</div>
									<?}?>
								</a>
							</div>
						<?}?>
					</div>
				</div>
			<?}?>
		</div>
	</div>
	<div class="mdl-tabs mdl-js-tabs product_tabs">
		<div class="fortabs">
			<div class="tabs mdl-tabs__tab-bar mdl-color--grey-100">
				<a href="#description" class="mdl-tabs__tab fortabs_tab is-active">Описание</a>
				<a href="#specifications" class="mdl-tabs__tab fortabs_tab">Характеристики</a>
				<a href="#comments" class="mdl-tabs__tab fortabs_tab">Отзывы и вопросы</a>
				<a href="#seasonality" class="mdl-tabs__tab fortabs_tab seasonality_js">График спроса</a>
			</div>
		</div>
		<div class="tab-content">
			<div id="description" class="mdl-tabs__panel is-active">
				<?if(!empty($item['descr_xt_full'])){?>
					<p itemprop="description"><?=$item['descr_xt_full']?></p>
				<?}else if(!empty($item['descr'])){?>
					<p itemprop="description"><?=$item['descr']?></p>
				<?}else{?>
					<p>К сожалению описание товара временно отсутствует.</p>
				<?}?>
			</div>
			<div id="specifications" class="mdl-tabs__panel">
				<?if(isset($item['specifications']) && !empty($item['specifications'])){?>
					<?foreach($item['specifications'] as $s){?>
						<div class="mdl-grid">
							<div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-tablet mdl-cell--2-col-phone"><?=$s['caption']?>:</div>
							<div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-tablet mdl-cell--2-col-phone"><?=$s['value'].(isset($s['units'])?' '.$s['units']:null)?></div>
						</div>
					<?}?>
				<?}else{?>
					<p>К сожалению характеристики товара временно отсутствует.</p>
				<?}?>
			</div>
			<div id="comments" class="mdl-tabs__panel">
				<?if(!G::isLogged()){?>
					<div class="for_anonim">Хотите оставить отзыв о товаре? <a href="#" class="btn_js" data-name="auth">Ввойдите в свой аккаунт</a>.</div>
				<?}else{?>
					<div class="feedback_form">
						<h4>Оставить отзыв о товаре</h4>
						<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" onsubmit="onCommentSubmit()">
							<div class="feedback_stars">
								<label class="label_for_stars">Оценка:</label>
								<label>
									<input type="radio" name="rating" class="set_rating hidden" value="1">
									<i class="star material-icons">star_border</i>
								</label>
								<label>
									<input type="radio" name="rating" class="set_rating hidden" value="2">
									<i class="star material-icons">star_border</i>
								</label>
								<label>
									<input type="radio" name="rating" class="set_rating hidden" value="3">
									<i class="star material-icons">star_border</i>
								</label>
								<label>
									<input type="radio" name="rating" class="set_rating hidden" value="4">
									<i class="star material-icons">star_border</i>
								</label>
								<label>
									<input type="radio" name="rating" class="set_rating hidden" value="5">
									<i class="star material-icons">star_border</i>
								</label>
							</div>
							<label for="feedback_text">Отзыв:</label>
							<textarea name="feedback_text" id="feedback_text" cols="30" required></textarea>
							<div class="user_data <?=(!isset($_SESSION['member']['id_user']) || $_SESSION['member']['id_user'] == 4028)?null:'hidden';?>">
								<div class="fild_wrapp">
									<label for="feedback_author">Ваше имя:</label>
									<input type="text" name="feedback_author" id="feedback_author" required value="<?=isset($_SESSION['member']) && $_SESSION['member']['id_user'] != 4028?$_SESSION['member']['name']:null;?>">
								</div>
								<div class="fild_wrapp">
									<label for="feedback_authors_email">Эл.почта:</label>
									<input type="email" name="feedback_authors_email" id="feedback_authors_email" value="<?=isset($_SESSION['member']) && $_SESSION['member']['id_user'] != 4028?$_SESSION['member']['email']:null;?>">
								</div>
							</div>
							<button type="submit" name="sub_com" class="mdl-button mdl-js-button">Отправить отзыв</button>
						</form>
					</div>
				<?}?>
				<div class="feedback_container">
					<?if(empty($comment)){?>
						<p class="feedback_comment">Ваш отзыв может быть первым!</p>
					<?}else{?>
						<h4>Отзывы клиентов</h4>
						<?foreach($comment as $i){
							if(_acl::isAdmin() || $i['visible'] == 1 || ($i['visible'] == 0 && isset($_SESSION['member']) && $_SESSION['member']['id_user'] == $i['id_author'])){?>
								<div class="feedback_item feedback_item_js" itemprop="review" itemscope itemtype="http://schema.org/Review">
									<?=$i['visible'] == 0?'<span class="feedback_hidden">'.(_acl::isAdmin()?'Скрытый':'На модерации').'</span>':null;?>
									<span class="feedback_author" itemprop="author"><?=isset($i['name'])?$i['name']:'Аноним'?></span>
									<span id="isBought_<?=$i['Id_coment']?>" class="isBought <?=$i['purchase'] == 0?'hidden':null;?>"><i class="material-icons shopping_cart">shopping_cart</i> <i class="material-icons check_circle">check_circle</i></span>
									<div class="mdl-tooltip" for="isBought_<?=$i['Id_coment']?>">Клиент купил<br>данный товар</div>
								<!-- 	<span class="isAdmin <?=$i['adm'] == 0?'hidden':null;?>"><i id="is_admin_<?=$i['Id_coment']?>" class="material-icons">vpn_key</i></span>
									<div class="mdl-tooltip" for="is_admin_<?=$i['Id_coment']?>">Администратор</div> -->

									<span class="feedback_date"><i class="material-icons">query_builder</i>
										<meta itemprop="datePublished" content="<?=date("d.m.Y", strtotime($i['date_comment']))?>">
										<?if(date("d") == date("d", strtotime($i['date_comment']))){?>
											Сегодня
										<?}elseif(date("d")-1 == date("d", strtotime($i['date_comment']))){?>
											Вчера
										<?}else{
											echo date("d.m.Y", strtotime($i['date_comment']));
										}?>
									</span>
									<?if($i['rating'] > 0){?>
										<div class="feedback_rating" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
											<meta itemprop="worstRating" content="1">
											<meta itemprop="bestRating" content="5">
											<span class="hidden" itemprop="ratingValue"><?=$i['rating']?></span>
											Оценка товара:
											<ul class="rating_stars" title="<?=$item['c_rating'] != ''?'Оценок: '.$item['c_mark']:'Нет оценок'?>">
												<?for($j = 1; $j <= 5; $j++){
													$star = 'star';
													if($j > floor($i['rating'])){
														if($j == ceil($i['rating'])){
															$star .= '_half';
														}else{
															$star .= '_border';
														}
													}?>
													<li><i class="material-icons"><?=$star?></i></li>
												<?}?>
											</ul>
										</div>
									<?}?>
									<p class="feedback_comment" itemprop="description"><?=$i['text_coment'];?></p>
									<a href="#" class="feedback_comment_reply feedback_comment_reply_js" data-lvl-reply="1" data-isauthorized="<?=G::isLogged()?'true':'false';?>" data-action="<?=$_SERVER['REQUEST_URI']?>" data-idComment="<?=$i['Id_coment']?>"><i class="material-icons">reply</i><span>Ответить</span></a>
									<a href="#" class="comment_reply_cancel_js hidden"><span>Отмена</span></a>

									<?if(isset($i['answer']) && is_array($i['answer']) && !empty($i['answer'])){?>
										<?foreach($i['answer'] as $a){?>
											<div class="feedback_item feedback_reply feedback_item_js<?=(_acl::isAdmin() || $a['visible'] == 1 || ($a['visible'] == 0 && isset($_SESSION['member']) && $_SESSION['member']['id_user'] == $a['id_author']))?null:' hidden';?>" itemprop="review" itemscope itemtype="http://schema.org/Review">
												<?=$a['visible'] == 0?'<span class="feedback_hidden">'.(_acl::isAdmin()?'Скрытый':'На модерации').'</span>':null;?>
												<span class="feedback_author" itemprop="author"><?=isset($a['name'])?$a['name']:'Аноним'?></span>
												<span id="isBought_<?=$a['Id_coment']?>" class="isBought <?=$a['purchase'] == 0?'hidden':null;?>"><i class="material-icons shopping_cart">shopping_cart</i> <i class="material-icons check_circle">check_circle</i></span>
												<div class="mdl-tooltip" for="isBought_<?=$a['Id_coment']?>">Клиент купил<br>данный товар</div>
												<!-- 	<span class="isAdmin <?=$a['adm'] == 0?'hidden':null;?>"><i id="is_admin_<?=$a['Id_coment']?>" class="material-icons">vpn_key</i></span>
												<div class="mdl-tooltip" for="is_admin_<?=$a['Id_coment']?>">Администратор</div> -->
												<span class="feedback_date"><i class="material-icons">query_builder</i>
													<meta itemprop="datePublished" content="<?=date("d.m.Y", strtotime($a['date_comment']))?>">
													<?if(date("d") == date("d", strtotime($a['date_comment']))){?>
														Сегодня
													<?}elseif(date("d")-1 == date("d", strtotime($a['date_comment']))){?>
														Вчера
													<?}else{
														echo date("d.m.Y", strtotime($a['date_comment']));
													}?>
												</span>
												<p class="feedback_comment" itemprop="description"><?=$a['text_coment'];?></p>
											</div>
										<?}?>
									<?}?>
								</div>
							<?}
						}
					}?>
				</div>
			</div>
			<div id="seasonality" class="mdl-tabs__panel seasonality">
				<!-- <a href="<?=_base_url.$_SERVER['REQUEST_URI']?>" target="demand_graph">Обновить</a> -->
				<!-- <script type="text/javascript" src="//www.google.com.ua/trends/embed.js?hl=ru&q=[intertool,intex]&geo=UA&date=today+30-d&cmpt=q&tz=Etc/GMT-2&tz=Etc/GMT-2&content=1&cid=TIMESERIES_GRAPH_0&export=5&w=653&h=600"></script> -->
				<input type="hidden" name="par_lvl" value="<?=end($GLOBALS['IERA_LINKS'])['title']?>">
			</div>
		</div>
	</div>
</div>
<section class="sliders">
	<!-- <div class="slider_products hidden">
		<h4>Сопутствующие товары</h4>
		<div id="owl-accompanying" class="owl-carousel">
			<div class="item">
				<a href="#">
					<img src="<?=$GLOBALS['URL_img_theme']?>46842.jpg">
					<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span>
					<div class="ca-more">65 грн.</div>
				</a>
			</div>
		</div>
	</div> -->
	<?if(isset($related_prods) && !empty($related_prods)){?>
		<div class="slider_products">
			<h4>Сопутствующие товары</h4>
			<div id="owl-accompanying" class="owl-carousel">
				<?foreach($related_prods as $p){?>
					<div class="item">
						<a href="<?=Link::Product($p['translit']);?>">
							<?if(!empty($p['images'])){?>
								<img alt="<?=htmlspecialchars($p['name'])?>" src="<?=G::GetImageUrl($p['images'][0]['src'], 'medium');?>">
							<?}else	if(!empty($p['img_1'])){?>
								<img alt="<?=htmlspecialchars($p['name'])?>" src="<?=G::GetImageUrl($p['img_1'], 'medium');?>"/>
							<?}else{?>
								<img alt="" src="<?=G::GetImageUrl('/images/nofoto.png')?>">
							<?}?>
							<span><?=$p['name']?></span>
							<?if($p['price_mopt'] > 100){?>
								<div class="ca-more">от <?=ceil($p['prices_opt'][0])?> грн.</div>
							<?}else{?>
								<div class="ca-more">от <?=number_format($p['prices_opt'][0], 2, ',', '')?> грн.</div>
							<?}?>
							<div class="product_buy" data-idproduct="<?=$p['id_product']?>">
								<?if(isset($p['active']) && $p['active'] == 0){?>
									<span class="out_of_stock">Нет в наличии</span>
								<?}else{?>
									<div class="buy_block" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
										<div class="btn_buy <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>">
											<div id="in_cart_<?=$p['id_product'];?>" class="btn_js in_cart_js <?=isset($_SESSION['cart']['products'][$p['id_product']])?null:'hidden';?>" data-name="cart"><i class="material-icons">shopping_cart</i><!-- В корзине --></div>
											<div class="mdl-tooltip" for="in_cart_<?=$p['id_product'];?>">Товар в корзине</div>
											<button class="mdl-button mdl-js-button buy_btn_js out_card_js <?=isset($_SESSION['cart']['products'][$p['id_product']])?'hidden':null;?>" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null); return false;">Купить</button>
										</div>
										<input class="qty_js" type="hidden" value="<?=isset($p['min_mopt_qty'])?$p['min_mopt_qty']:1;?>">
									</div>
								<?}?>
							</div>
						</a>
					</div>
				<?}?>
			</div>
		</div>
	<?}?>
	<?if(isset($new_prods) && !empty($new_prods)){?>
		<div class="slider_products">
			<h4>Новинки в этой категории</h4>
			<div id="owl-new-products" class="owl-carousel">
				<?foreach($new_prods as $p){?>
					<div class="item">
						<a href="<?=Link::Product($p['translit']);?>">
							<?if(!empty($p['images'])){?>
								<img alt="<?=htmlspecialchars($p['name'])?>" src="<?=G::GetImageUrl($p['images'][0]['src'], 'medium');?>">
							<?}else	if(!empty($p['img_1'])){?>
								<img alt="<?=htmlspecialchars($p['name'])?>" src="<?=G::GetImageUrl($p['img_1'], 'medium');?>"/>
							<?}else{?>
								<img alt="" src="<?=G::GetImageUrl('/images/nofoto.png')?>">
							<?}?>
							<span><?=$p['name']?></span>
							<?if($p['price_mopt'] > 100){?>
								<div class="ca-more">от <?=ceil($p['prices_opt'][0])?> грн.</div>
							<?}else{?>
								<div class="ca-more">от <?=number_format($p['prices_opt'][0], 2, ',', '')?> грн.</div>
							<?}?>
							<div class="product_buy" data-idproduct="<?=$p['id_product']?>">
								<?if(isset($p['active']) && $p['active'] == 0){?>
									<span class="out_of_stock">Нет в наличии</span>
								<?}else{?>
									<div class="buy_block" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
										<div class="btn_buy <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>">
											<div id="in_cart_<?=$p['id_product'];?>" class="btn_js in_cart_js <?=isset($_SESSION['cart']['products'][$p['id_product']])?null:'hidden';?>" data-name="cart"><i class="material-icons">shopping_cart</i><!-- В корзине --></div>
											<div class="mdl-tooltip" for="in_cart_<?=$p['id_product'];?>">Товар в корзине</div>
											<button class="mdl-button mdl-js-button buy_btn_js out_card_js <?=isset($_SESSION['cart']['products'][$p['id_product']])?'hidden':null;?>" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null); return false;">Купить</button>
										</div>
										<input class="qty_js" type="hidden" value="<?=isset($p['min_mopt_qty'])?$p['min_mopt_qty']:1;?>">
									</div>
								<?}?>
							</div>
						</a>
					</div>
				<?}?>
			</div>
		</div>
	<?}?>
	<?if(isset($random_products) && !empty($random_products)){?>
		<div id="similar_products" class="slider_products">
			<h4>Похожие товары</h4>
			<div id="owl-other" class="owl-carousel">
				<?foreach($random_products as $p){?>
					<div class="item">
						<a href="<?=Link::Product($p['translit']);?>">
							<?if(!empty($p['images'][0])){?>
								<img alt="<?=htmlspecialchars($p['name'])?>" src="<?=G::GetImageUrl($p['images'][0]['src'], 'medium');?>">
							<?}else	if(!empty($p['img_1'])){?>
								<img alt="<?=htmlspecialchars($p['name'])?>" src="<?=G::GetImageUrl($p['img_1'], 'medium');?>"/>
							<?}else{?>
								<img alt="" src="<?=G::GetImageUrl('/images/nofoto.png')?>">
							<?}?>
							<span><?=$p['name']?></span>
							<?if($p['price_mopt'] > 100){?>
								<div class="ca-more">от <?=ceil($p['prices_opt'][0])?> грн.</div>
							<?}else{?>
								<div class="ca-more">от <?=number_format($p['prices_opt'][0], 2, ',', '')?> грн.</div>
							<?}?>
							<div class="product_buy" data-idproduct="<?=$p['id_product']?>">
								<?if(isset($p['active']) && $p['active'] == 0){?>
									<span class="out_of_stock">Нет в наличии</span>
								<?}else{?>
									<div class="buy_block" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
										<div class="btn_buy <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>">
											<div id="in_cart_<?=$p['id_product'];?>" class="btn_js in_cart_js <?=isset($_SESSION['cart']['products'][$p['id_product']])?null:'hidden';?>" data-name="cart"><i class="material-icons">shopping_cart</i><!-- В корзине --></div>
											<div class="mdl-tooltip" for="in_cart_<?=$p['id_product'];?>">Товар в корзине</div>
											<button class="mdl-button mdl-js-button buy_btn_js out_card_js <?=isset($_SESSION['cart']['products'][$p['id_product']])?'hidden':null;?>" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null); return false;">Купить</button>
										</div>
										<input class="qty_js" type="hidden" value="<?=isset($p['min_mopt_qty'])?$p['min_mopt_qty']:1;?>">
									</div>
								<?}?>
							</div>
						</a>
					</div>
				<?}?>
			</div>
		</div>
	<?}?>
	<?if(isset($popular_products) && !empty($popular_products)){?>
		<div class="slider_products">
			<h4>Топ продаж категории</h4>
			<div id="owl-popular" class="owl-carousel">
				<?foreach($popular_products as $p){?>
					<div class="item">
						<a href="<?=Link::Product($p['translit']);?>">
							<?if(!empty($p['images'][0])){?>
								<img alt="<?=htmlspecialchars($p['name'])?>" src="<?=G::GetImageUrl($p['images'][0]['src'], 'medium');?>">
							<?}else	if(!empty($p['img_1'])){?>
								<img alt="<?=htmlspecialchars($p['name'])?>" src="<?=G::GetImageUrl($p['img_1'], 'medium');?>"/>
							<?}else{?>
								<img alt="" src="<?=G::GetImageUrl('/images/nofoto.png')?>">
							<?}?>
							<span><?=$p['name']?></span>
							<?if($p['price_mopt'] > 100){?>
								<div class="ca-more">от <?=ceil($p['prices_opt'][0])?> грн.</div>
							<?}else{?>
								<div class="ca-more">от <?=number_format($p['prices_opt'][0], 2, ',', '')?> грн.</div>
							<?}?>
							<div class="product_buy" data-idproduct="<?=$p['id_product']?>">
								<?if(isset($p['active']) && $p['active'] == 0){?>
									<span class="out_of_stock">Нет в наличии</span>
								<?}else{?>
									<div class="buy_block" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
										<div class="btn_buy <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>">
											<div id="in_cart_<?=$p['id_product'];?>" class="btn_js in_cart_js <?=isset($_SESSION['cart']['products'][$p['id_product']])?null:'hidden';?>" data-name="cart"><i class="material-icons">shopping_cart</i><!-- В корзине --></div>
											<div class="mdl-tooltip" for="in_cart_<?=$p['id_product'];?>">Товар в корзине</div>
											<button class="mdl-button mdl-js-button buy_btn_js out_card_js <?=isset($_SESSION['cart']['products'][$p['id_product']])?'hidden':null;?>" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null); return false;">Купить</button>
										</div>
										<input class="qty_js" type="hidden" value="<?=isset($p['min_mopt_qty'])?$p['min_mopt_qty']:1;?>">
									</div>
								<?}?>
							</div>
						</a>
					</div>
				<?}?>
			</div>
		</div>
	<?}?>
	<?if(isset($view_products_list) && !empty($view_products_list)){?>
		<div class="slider_products">
			<h4>Просмотренные ранее</h4>
			<div id="owl-last-viewed" class="owl-carousel">
				<?foreach($view_products_list as $p){?>
					<div class="item">
						<a href="<?=Link::Product($p['translit']);?>">
							<?if(!empty($p['images'][0])){?>
								<img alt="<?=htmlspecialchars($p['name'])?>" src="<?=G::GetImageUrl($p['images'][0]['src'], 'medium');?>">
							<?}else	if(!empty($p['img_1'])){?>
								<img alt="<?=htmlspecialchars($p['name'])?>" src="<?=G::GetImageUrl($p['img_1'], 'medium');?>"/>
							<?}else{?>
								<img alt="" src="<?=G::GetImageUrl('/images/nofoto.png')?>">
							<?}?>
							<span><?=$p['name']?></span>
							<?if($p['price_mopt'] > 100){?>
								<div class="ca-more">от <?=ceil($p['prices_opt'][0])?> грн.</div>
							<?}else{?>
								<div class="ca-more">от <?=number_format($p['prices_opt'][0], 2, ',', '')?> грн.</div>
							<?}?>
							<div class="product_buy" data-idproduct="<?=$p['id_product']?>">
								<?if(isset($p['active']) && $p['active'] == 0){?>
									<span class="out_of_stock">Нет в наличии</span>
								<?}else{?>
									<div class="buy_block" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
										<div class="btn_buy <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>">
											<div id="in_cart_<?=$p['id_product'];?>" class="btn_js in_cart_js <?=isset($_SESSION['cart']['products'][$p['id_product']])?null:'hidden';?>" data-name="cart"><i class="material-icons">shopping_cart</i><!-- В корзине --></div>
											<div class="mdl-tooltip" for="in_cart_<?=$p['id_product'];?>">Товар в корзине</div>
											<button class="mdl-button mdl-js-button buy_btn_js out_card_js <?=isset($_SESSION['cart']['products'][$p['id_product']])?'hidden':null;?>" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null); return false;">Купить</button>
										</div>
										<input class="qty_js" type="hidden" value="<?=isset($p['min_mopt_qty'])?$p['min_mopt_qty']:1;?>">
									</div>
								<?}?>
							</div>
						</a>
					</div>
				<?}?>
			</div>
		</div>
	<?}?>
	<div class="products_links_block">
		<!-- Регулярка для вывода не более 3 слов названия товара в ссылке pattern="^[^\s]+\s[^\s]+\s[^\s]+\s" -->
		<!--  старый вариант регулярки которая работает "/^[^\s]+\s[^\s]+\s[^\s]+\s[^\s]+\s|^[^\s]+\s[^\s]+\s[^\s]+|^[^\s]+\s[^\s]+|[^\s]+/"
			новый вариант регулярки которая работает но не до конца /^.*?\s.*?\s.*?\s.*?\s|^.*?\s.*?\s.*?\s.*?$|^.*?\s.*?\s.*?\s|^.*?\s.*?\s.*?$|^.*?\s|^.*?$/" -->
		<p class="products_links_block_title">Другие товары</p>
		<?foreach ($link_prods as $item) {
			preg_match("/^[^\s]+\s[^\s]+\s[^\s]+\s|^[^\s]+\s[^\s]+\s[^\s]+|^[^\s]+\s[^\s]+\s|^[^\s]+\s[^\s]+|[^\s]+/", $item['name'], $name);?>
			<a href="<?=Link::Product($item['translit']);?>" class="product_link"><?=$name[0]?></a>
		<?}?>
	</div>
</section>