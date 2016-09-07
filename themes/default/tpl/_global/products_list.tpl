<?=G::AddCSS('../themes/'.$GLOBALS['Theme'].'/css/page_styles/products.css');?>
<?$GLOBALS['descr_for_seo'] = [];
switch(isset($_SESSION['member']['gid']) ? $_SESSION['member']['gid'] : null){
	case _ACL_CONTRAGENT_:
		foreach($list as $item){
			$Status = new Status();
			$product_mark = '';
			array_push($GLOBALS['descr_for_seo'], array('name' => $item['name'], 'descr' => $item['descr_xt_full']));
			$st = $Status->GetStstusById($item['id_product']);
			$a = explode(';', $GLOBALS['CONFIG']['correction_set_'.$item['opt_correction_set']]);
			// Проверяем доступнось розницы
			($item['price_mopt'] > 0 && $item['min_mopt_qty'] > 0)?$mopt_available = true:$mopt_available = false;
			// Проверяем доступнось опта
			($item['price_opt'] > 0 && $item['inbox_qty'] > 0)?$opt_available = true:$opt_available = false;?>
			<div class="card<?=$item['visible'] == 0?' unvisible':null?>" data-idproduct="<?=$item['id_product']?>">
				<?if(in_array($item['opt_correction_set'], $GLOBALS['CONFIG']['promo_correction_set']) || in_array($item['mopt_correction_set'], $GLOBALS['CONFIG']['promo_correction_set'])) {
					$product_mark = 'action';
				}elseif ($item['prod_status'] == 3){
					$product_mark = 'new';
				}?>
				<?if(isset($product_mark) && $product_mark !== ''){?>
					<div class="market_action">
						<img src="<?=_base_url?>/images/<?=$product_mark?>.png" alt="<?=$product_mark === 'action'?'акционный товар':'новый товар'?>">
					</div>
				<?}?>
				<div class="product_section" id="product_<?=$item['id_product']?>">
					<div class="product_photo">
						<a href="<?=Link::Product($item['translit']);?>">
							<div class="<?=$st['class']?>"></div>
							<?if(!empty($item['images'])){?>
								<img alt="<?=htmlspecialchars(G::CropString($item['name']))?>" class="lazy" src="/images/nofoto.png" data-original="<?=G::GetImageUrl($item['images'][0]['src'], 'medium')?>"/>
								<noscript>
									<img alt="<?=htmlspecialchars(G::CropString($item['name']))?>" src="<?=G::GetImageUrl($item['images'][0]['src'], 'medium')?>"/>
								</noscript>
							<?}else{?>
								<img alt="<?=htmlspecialchars(G::CropString($item['name']))?>" class="lazy" src="/images/nofoto.png" data-original="<?=G::GetImageUrl($item['img_1'], 'medium')?>"/>
								<noscript>
									<img alt="<?=htmlspecialchars(G::CropString($item['name']))?>" src="<?=G::GetImageUrl($item['img_1'], 'medium')?>"/>
								</noscript>
							<?}?>
						</a>
					</div>
					<div class="product_name p<?=$item['id_product']?>">
						<a href="<?=Link::Product($item['translit']);?>" class="cat_<?=$item['id_product']?>"><?=G::CropString($item['name'])?></a>
						<span class="product_article"><!--noindex-->арт. <!--/noindex--><?=$item['art']?></span>
						<div class="rating_block" id="rating_block" <?=isset($item['c_mark']) && $item['c_mark'] > 0?'itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"':null;?>>
							<?if(isset($item['c_mark']) && $item['c_mark'] > 0){?>
								<meta itemprop="worstRating" content="1">
								<meta itemprop="bestRating" content="5">
								<span class="hidden" itemprop="ratingValue"><?=$item['c_rating']?></span>
								<span class="hidden" itemprop="reviewCount"><?=$item['c_mark']?></span>
							<?}?>
							<?if(isset($item['c_rating']) && $item['c_rating'] > 0){?>
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
								<span class="stars_qty"><?=number_format($item['c_rating'], 1)[2] >= 5? number_format($item['c_rating'], 1):number_format($item['c_rating'], 1)[0]?> / 5</span>
								<span class="qty_ratings">(Оценок: <?=$item['c_mark']?>)</span>
							<?}?>
						</div>
						<div class="note <?=$item['note_control'] != 0?'note_control':null?> <?=isset($_SESSION['cart']['products'][$item['id_product']])?null:'hidden';?> <?=isset($_SESSION['cart']['products'][$item['id_product']]['note']) && $_SESSION['cart']['products'][$item['id_product']]['note'] != '' ?null:'activeNoteArea'?>">
							<textarea class="note_field" placeholder="<?=$item['note_control'] != 0?'ПРИМЕЧАНИЕ ОБЯЗАТЕЛЬНО!!!':' Примечание:'?>" id="mopt_note_<?=$item['id_product']?>" data-id="<?=$item['id_product']?>"><?=isset($_SESSION['cart']['products'][$item['id_product']]['note'])?$_SESSION['cart']['products'][$item['id_product']]['note']:null?></textarea>
							<label class="info_key">?</label>
							<div class="info_description">
								<p>Поле для ввода примечания к товару.</p>
							</div>
						</div>
					</div>
					<?$in_cart = false;
					if(isset($_SESSION['cart']['products'][$item['id_product']])){
						$in_cart = true;
					}?>
					<?if($item['active'] == 0){?>
						<div class="notAval">Нет в наличии</div>
					<?}else{?>
						<div class="product_buy" data-idproduct="<?=$item['id_product']?>">
							<div class="buy_block">
								<div class="base_price <?=isset($product_mark) && $product_mark === 'action'?null:'hidden'?> <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>">
									<?if (!isset($_SESSION['cart']['products'][$item['id_product']]['quantity']) || ($_SESSION['cart']['products'][$item['id_product']]['quantity'] >= $item['inbox_qty'])) {?>
										<?=number_format($item['base_prices_opt'][$_COOKIE['sum_range']], 2, ",", "")?>
									<?}else{?>
										<?=number_format($item['base_prices_mopt'][$_COOKIE['sum_range']], 2, ",", "")?>
									<?}?>
								</div>
								<div class="product_price">
									<div class="price"><?=$in_cart?number_format($_SESSION['cart']['products'][$item['id_product']]['actual_prices'][$_COOKIE['sum_range']], 2, ",", ""):number_format($item['price_opt']*$a[$_COOKIE['sum_range']], 2, ",", "");?></div><span>грн.</span>
								</div>
								<div class="prodBasePrices hidden">
									<?for($i = 0; $i < 4; $i++){?>
										<input class="basePriceOpt<?=$i?>" value="<?=number_format($item['base_prices_opt'][$i], 2, ",", "")?>">
										<input class="basePriceMopt<?=$i?>" value="<?=number_format($item['base_prices_mopt'][$i], 2, ",", "")?>">
									<?}?>
								</div>
								<div class="prodPrices hidden">
									<?for($i = 0; $i < 4; $i++){?>
										<input class="priceOpt<?=$i?>" value="<?=$item['prices_opt'][$i]?>">
										<input class="priceMopt<?=$i?>" value="<?=$item['prices_mopt'][$i]?>">
									<?}?>
								</div>
								<div class="btn_buy">
									<button class="mdl-button mdl-js-button buy_btn_js <?=isset($_SESSION['cart']['products'][$item['id_product']])?'hidden':null;?>" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null); return false;">Купить</button>
									<div id="in_cart_<?=$item['id_product'];?>" class="btn_js in_cart_js <?=isset($_SESSION['cart']['products'][$item['id_product']])?null:'hidden';?>" data-name="cart"><i class="material-icons">shopping_cart</i><!-- В корзине --></div>
									<div class="mdl-tooltip" for="in_cart_<?=$item['id_product'];?>">Товар в корзине</div>
								</div>
								<div class="quantity">
									<div class="quantityReverseBlock">
										<button id="btn_add<?=$item['id_product']?>" class="material-icons btn_add btn_qty_js"	onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1); return false;">add</button>
										<div class="mdl-tooltip mdl-tooltip--top tooltipForBtnAdd_js hidden" for="btn_add<?=$item['id_product']?>">Больше</div>

										<input type="text" class="minQty hidden" value="<?=$item['inbox_qty']?>">
										<input type="text" class="qty_js" value="<?=isset($_SESSION['cart']['products'][$item['id_product']]['quantity'])?$_SESSION['cart']['products'][$item['id_product']]['quantity']:$item['inbox_qty']?>" step="<?=$item['min_mopt_qty'];?>">

										<button id="btn_remove<?=$item['id_product']?>" class="material-icons btn_remove btn_qty_js" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 0);return false;">remove</button>
										<div class="mdl-tooltip tooltipForBtnRemove_js hidden" for="btn_remove<?=$item['id_product']?>">Меньше</div>
									</div>
									<div class="units"><?=$item['units'];?></div>
								</div>
							</div>
							<div class="priceMoptInf<?=($in_cart && $_SESSION['cart']['products'][$item['id_product']]['quantity'] < $item['inbox_qty'])?'':' hidden'?>">Малый опт</div>
						</div>
					<?}?>
					<div class="product_info">
						<div class="rating_block hidden">
							<div class="preview_favorites" data-idfavorite="<?=$item['id_product']?>" title="<?=(!isset($_SESSION['member']) || !in_array($item['id_product'], $_SESSION['member']['favorites']))?'Добавить товар в избранное':'Товар находится в избранных'?>">
								<span class="material-icons icon-font favorite">favorites<?=(!isset($_SESSION['member']) || !in_array($item['id_product'], $_SESSION['member']['favorites']))?'-o':null?></span>
							</div>
							<a href="<?=Link::Product($item['translit']);?>" class="rating">
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
										<li><span class="material-icons icon-font"><?=$star?></span></li>
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
						<div class="service_block">
							<button class="mdl-button mdl-js-button comment_question_btn btn_js" data-name="comment_question">Отзывы и вопросы</button>
							<?if($item['available_today'] == 1){?>
								<span class="material-icons timerIcon">timer</span>
								<p class="available_today">Отгрузка за 2 часа</p>
							<?}?>
						</div>
						<!-- <form action="<?=$_SERVER['REQUEST_URI']?>" class="note <?=$item['note_control'] != 0?'note_control':null?>" data-note="<?=$item['id_product']?>">
							<textarea cols="30" rows="3" placeholder="Примечание к заказу" ><?=isset($_SESSION['cart']['products'][$item['id_product']]['note_opt'])?$_SESSION['cart']['products'][$item['id_product']]['note_opt']:null?></textarea>
							<label class="info_key">?</label>
							<div class="info_description">
								<p>Поле для ввода примечания к товару.<br>
									<?if($item['note_control'] != 0){?>
										<b>Обязательное</b> для заполнения!
									<?}?>
								</p>
							</div>
						</form> -->
					</div>
					<div class="specifications">
						<ul>
							<li><span class="spec">Lorem ipsum dolor sit amet.</span><span class="unit">amet</span></li>
							<li><span class="spec">Lorem ipsum dolor sit amet.</span><span class="unit">amet</span></li>
							<li><span class="spec">Lorem ipsum dolor sit amet.</span><span class="unit">amet</span></li>
							<li><span class="spec">Lorem ipsum dolor sit amet.</span><span class="unit">amet</span></li>
							<li><span class="spec">Lorem ipsum dolor sit amet.</span><span class="unit">amet</span></li>
						</ul>
					</div>
				</div>
				<?if(isset($_SESSION['member']['ordered_prod']) && in_array($item['id_product'], $_SESSION['member']['ordered_prod'])){?>
					<div id="ordered-<?=$item['id_product'];?>" class="icon material-icons ordered">check_circle</div>
					<div class="mdl-tooltip" for="ordered-<?=$item['id_product'];?>">Вы уже заказывали<br>этот товар ранее</div>
				<?}?>
				<div class="clearBoth"></div>
			</div>
		<?}
		break;
	case _ACL_SUPPLIER_:
		?><div class="card card_tittle">
			<div class="product_photo card_item">Фото товара</div>
			<p class="product_name card_item">Наименование товара</p>
			<div class="suplierPriceBlock headerPriceBlock">
				<div class="price card_item">Цена за ед. товара</div>
				<div class="count_cell card_item">Минимальное<br>количество</div>
				<div class="count_cell card_item">Кол-во<br>в ящике</div>
				<div class="product_check card_item">Добавить в<br>ассортимент</div>
			</div>
			<div class="clearBoth"></div>
		</div><?
		foreach($list as $item){
			$product_mark = '';
			array_push($GLOBALS['descr_for_seo'], array('name' => $item['name'], 'descr' => $item['descr_xt_full']));?>
			<div class="card" data-idproduct="<?=$item['id_product']?>">
				<?if (in_array($item['opt_correction_set'], $GLOBALS['CONFIG']['promo_correction_set']) || in_array($item['mopt_correction_set'], $GLOBALS['CONFIG']['promo_correction_set'])) {
					$product_mark = 'action';
				}elseif ($item['prod_status'] == 3){
					$product_mark = 'new';
				}?>
				<?if(isset($product_mark) && $product_mark !== ''){?>
					<div class="market_action">
						<img src="<?=_base_url?>/images/<?=$product_mark?>.png" alt="<?=$product_mark === 'action'?'акционный товар':'новый товар'?>">
					</div>
				<?}?>
				<div class="product_photo card_item">
					<a href="<?=Link::Product($item['translit']);?>">
						<?if(!empty($item['images'])){?>
							<img alt="<?=htmlspecialchars(G::CropString($item['name']))?>" class="lazy" src="/images/nofoto.png" data-original="<?=G::GetImageUrl($item['images'][0]['src'], 'thumb')?>"/>
							<noscript>
								<img alt="<?=htmlspecialchars(G::CropString($item['name']))?>" src="<?=G::GetImageUrl($item['images'][0]['src'], 'thumb')?>"/>
							</noscript>
						<?}else{?>
							<img alt="<?=htmlspecialchars(G::CropString($item['name']))?>" class="lazy" src="/images/nofoto.png" data-original="<?=G::GetImageUrl($item['img_1'], 'medium')?>"/>
							<noscript>
								<img alt="<?=htmlspecialchars(G::CropString($item['name']))?>" src="<?=G::GetImageUrl($item['img_1'], 'medium')?>"/>
							</noscript>
						<?}?>
					</a>
				</div>
				<p class="product_name card_item"><a href="<?=Link::Product($item['translit']);?>"><?=G::CropString($item['name'])?></a><span class="product_article">Арт: <?=$item['art'];?></span></p>
				<div class="rating_block" id="rating_block" <?=isset($item['c_mark']) && $item['c_mark'] > 0?'itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"':null;?>>
					<?if(isset($item['c_mark']) && $item['c_mark'] > 0){?>
						<meta itemprop="worstRating" content="1">
						<meta itemprop="bestRating" content="5">
						<span class="hidden" itemprop="ratingValue"><?=$item['c_rating']?></span>
						<span class="hidden" itemprop="reviewCount"><?=$item['c_mark']?></span>
					<?}?>
					<?if(isset($item['c_rating']) && $item['c_rating'] > 0){?>
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
						<span class="stars_qty"><?=number_format($item['c_rating'], 1)[2] >= 5? number_format($item['c_rating'], 1):number_format($item['c_rating'], 1)[0]?> / 5</span>
						<span class="qty_ratings">(Оценок: <?=$item['c_mark']?>)</span>
					<?}?>
				</div>
				<div class="suplierPriceBlock">
					<div class="price card_item"><p id="price_mopt_<?=$item['id_product']?>">
						<?if($item['price_opt_otpusk'] != 0){
							echo number_format($item['price_opt_otpusk'], 2, ".", "").' грн.';
						}else{
							echo number_format($item['price_mopt_otpusk'], 2, ".", "").' грн.';
						}?>
					</p></div>
					<div class="count_cell card_item">
						<span class="suplierPriceBlockLabel">Минимальное кол-во:</span>
						<p id="min_mopt_qty_<?=$item['id_product']?>"><?=$item['min_mopt_qty'].' '.$item['units']?><?=$item['qty_control']?" *":null?></p>
					</div>
					<div class="count_cell card_item">
						<span class="suplierPriceBlockLabel">Количество в ящике:</span>
						<p id="inbox_qty_<?=$item['id_product']?>"><?=$item['inbox_qty'].' '.$item['units']?></p>
					</div>

					<div class="product_check card_item">
						<span class="suplierPriceBlockLabel">Добавить:</span>
						<label  class="mdl-checkbox mdl-js-checkbox">
							<!-- <input type="checkbox" id="checkbox-2" class="mdl-checkbox__input"> -->
							<input type="checkbox" class="check mdl-checkbox__input" <?=isset($_SESSION['Assort']['products'][$item['id_product']])?'checked=checked':null?> onchange="AddDelProductAssortiment(this, <?=$item['id_product']?>)"/>
						</label>
					</div>
				</div>
				<div class="clearBoth"></div>
			</div>
		<?}
		break;
	default:
		foreach($list as $item){
			$in_cart = false;
			$product_mark = '';
			array_push($GLOBALS['descr_for_seo'], array('name' => $item['name'], 'descr' => $item['descr_xt_full']));
			if(isset($_SESSION['cart']['products'][$item['id_product']])){
				$in_cart = true;
			}
			$a = explode(';', $GLOBALS['CONFIG']['correction_set_'.$item['opt_correction_set']]);?>
			<div class="card<?=$item['visible'] == 0?' unvisible':null?>" data-idproduct="<?=$item['id_product']?>">
				<?if (in_array($item['opt_correction_set'], $GLOBALS['CONFIG']['promo_correction_set']) || in_array($item['mopt_correction_set'], $GLOBALS['CONFIG']['promo_correction_set'])) {
					$product_mark = 'action';
				}elseif ($item['prod_status'] == 3){
					$product_mark = 'new';
				}?>
				<?if(isset($product_mark) && $product_mark !== ''){?>
					<div class="market_action">
						<img src="<?=_base_url?>/images/<?=$product_mark?>.png" alt="<?=$product_mark === 'action'?'акционный товар':'новый товар'?>">
					</div>
				<?}?>
				<div class="product_photo">
					<a href="<?=Link::Product($item['translit']);?>">
						<?if(!empty($item['images'])){?>
							<img alt="<?=htmlspecialchars(G::CropString($item['id_product']))?>" class="lazy" src="/images/nofoto.png" data-original="<?=G::GetImageUrl($item['images'][0]['src'], 'medium')?>"/>
							<noscript><img alt="<?=htmlspecialchars(G::CropString($item['id_product']))?>" src="<?=G::GetImageUrl($item['images'][0]['src'], 'medium')?>"/></noscript>
						<?}else{?>
							<img alt="<?=htmlspecialchars(G::CropString($item['id_product']))?>" class="lazy" src="/images/nofoto.png" data-original="<?=G::GetImageUrl($item['img_1'], 'medium')?>"/>
							<noscript><img alt="<?=htmlspecialchars(G::CropString($item['id_product']))?>" src="<?=G::GetImageUrl($item['img_1'], 'medium')?>"/></noscript>
						<?}?>
					</a>
					<div class="add_to_fav_trend_block mdl-cell--hide-phone">
						<div class="favorite<?=isset($_SESSION['member']['favorites']) && in_array($item['id_product'], $_SESSION['member']['favorites'])?' added':null;?> <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>" data-id-product="<?=$item['id_product'];?>">
							<?if(isset($_SESSION['member']['favorites']) && in_array($item['id_product'], $_SESSION['member']['favorites'])) {?>
								<i id="forfavorite_<?=$item['id_product']?>" class="isfavorite favorite_icon material-icons">favorite</i>
								<span class="mdl-tooltip" for="forfavorite_<?=$item['id_product']?>">Товар уже <br> в избранном</span>
							<?}else{?>
								<i id="forfavorite_<?=$item['id_product']?>" class="notfavorite favorite_icon material-icons">favorite_border</i>
								<span class="mdl-tooltip" for="forfavorite_<?=$item['id_product']?>">Добавить товар <br> в избранное</span>
							<?}?>
						</div>
						<div id="fortrending_<?=$item['id_product']?>" class="fortrending <?=isset($_SESSION['member']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>" data-id-product="<?=$item['id_product'];?>" <?=isset($_SESSION['member'])?'data-id-user="'.$_SESSION['member']['id_user'].'" data-email="'.$_SESSION['member']['email'].'"':'';?>>
							<div class="waiting_list icon material-icons <?=isset($_SESSION['member']['waiting_list']) && in_array($item['id_product'], $_SESSION['member']['waiting_list'])? 'arrow' : null;?>">trending_down</div></div>
						<div class="mdl-tooltip" for="fortrending_<?=$item['id_product']?>"><?=isset($_SESSION['member']['waiting_list']) && in_array($item['id_product'], $_SESSION['member']['waiting_list'])? 'Товар уже <br> в списке ожидания' : 'Следить за ценой';?></div>
						<div class="preview_icon_block"><div class="material-icons preview_icon">zoom_in</div></div>
					</div>
				</div>
				<div class="product_name">
					<a href="<?=Link::Product($item['translit']);?>"><?=G::CropString($item['name'])?></a>
					<span class="product_article">арт: <?=$item['art'];?></span>
					<?if(G::IsLogged() && in_array($_SESSION['member']['gid'], array(1, 2))){?>
						<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="move_product_<?=$item['id_product']?>">
							<input type="checkbox" name="move_product" data-idproduct="<?=$item['id_product']?>" id="move_product_<?=$item['id_product']?>" class="move_product_<?=$item['id_product']?>_js mdl-checkbox__input" <?=isset($_SESSION['fill_category']) && in_array($item['id_product'], $_SESSION['fill_category'])?'checked':null;?>>
							<span class="mdl-checkbox__label title_move_product">Перенести в категорию</span>
						</label>
					<?}?>

					<div class="rating_block" id="rating_block" <?=isset($item['c_mark']) && $item['c_mark'] > 0?'itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"':null;?>>
						<?if(isset($item['c_mark']) && $item['c_mark'] > 0){?>
							<meta itemprop="worstRating" content="1">
							<meta itemprop="bestRating" content="5">
							<span class="hidden" itemprop="ratingValue"><?=$item['c_rating']?></span>
							<span class="hidden" itemprop="reviewCount"><?=$item['c_mark']?></span>
						<?}?>
						<?if(isset($item['c_rating']) && $item['c_rating'] > 0){?>
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
							<span class="stars_qty"><?=number_format($item['c_rating'], 1)[2] >= 5? number_format($item['c_rating'], 1):number_format($item['c_rating'], 1)[0]?> / 5</span>
							<span class="qty_ratings">(Оценок: <?=$item['c_mark']?>)</span>
						<?}?>
					</div>

					<div class="product_info">
						<div class="note <?=$item['note_control'] != 0?'note_control':null?> <?=isset($_SESSION['cart']['products'][$item['id_product']])?null:'hidden';?> <?=isset($_SESSION['cart']['products'][$item['id_product']]['note']) && $_SESSION['cart']['products'][$item['id_product']]['note'] != '' ?null:'activeNoteArea'?>">
							<textarea class="note_field" placeholder="<?=$item['note_control'] != 0?'ПРИМЕЧАНИЕ ОБЯЗАТЕЛЬНО!!!':' Примечание:'?>" id="mopt_note_<?=$item['id_product']?>" data-id="<?=$item['id_product']?>"><?=isset($_SESSION['cart']['products'][$item['id_product']]['note'])?$_SESSION['cart']['products'][$item['id_product']]['note']:null?></textarea>
							<label class="info_key">?</label>
							<div class="info_description">
								<p>Поле для ввода примечания к товару.</p>
							</div>
						</div>
					</div>
				</div>
				<?if($item['active'] == 0){?>
					<div class="notAval">Нет в наличии</div>
				<?}else{?>
					<div class="product_buy" data-idproduct="<?=$item['id_product']?>">
						<div class="buy_block">
							<div class="base_price <?=isset($product_mark) && $product_mark === 'action'?null:'hidden'?> <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>">
								<?if (!isset($_SESSION['cart']['products'][$item['id_product']]['quantity']) || ($_SESSION['cart']['products'][$item['id_product']]['quantity'] >= $item['inbox_qty'])) {?>
									<?=number_format($item['base_prices_opt'][$_COOKIE['sum_range']], 2, ",", "")?>
								<?}else{?>
									<?=number_format($item['base_prices_mopt'][$_COOKIE['sum_range']], 2, ",", "")?>
								<?}?>
							</div>
							<div class="product_price">
								<div class="price"><?=$in_cart?number_format($_SESSION['cart']['products'][$item['id_product']]['actual_prices'][$_COOKIE['sum_range']], 2, ",", ""):number_format($item['price_opt']*$a[$_COOKIE['sum_range']], 2, ",", "");?></div><span>грн.</span>
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
							<div class="btn_buy">
								<button class="mdl-button mdl-js-button buy_btn_js <?=isset($_SESSION['cart']['products'][$item['id_product']])?'hidden':null;?>" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null); return false;">Купить</button>
								<div id="in_cart_<?=$item['id_product'];?>" class="btn_js in_cart_js <?=isset($_SESSION['cart']['products'][$item['id_product']])?null:'hidden';?>" data-name="cart"><i class="material-icons">shopping_cart</i><!-- В корзине --></div>
								<div class="mdl-tooltip" for="in_cart_<?=$item['id_product'];?>">Товар в корзине</div>
							</div>
							<div class="quantity">
								<div class="quantityReverseBlock">
									<button id="btn_add<?=$item['id_product']?>" class="material-icons btn_add btn_qty_js"	onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1); return false;">add</button>
									<div class="mdl-tooltip mdl-tooltip--top tooltipForBtnAdd_js hidden" for="btn_add<?=$item['id_product']?>">Больше</div>

									<input type="text" class="minQty hidden" value="<?=$item['inbox_qty']?>">
									<input type="text" class="qty_js" value="<?=isset($_SESSION['cart']['products'][$item['id_product']]['quantity'])?$_SESSION['cart']['products'][$item['id_product']]['quantity']:$item['inbox_qty']?>">

									<button id="btn_remove<?=$item['id_product']?>" class="material-icons btn_remove btn_qty_js" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 0);return false;">remove</button>
									<div class="mdl-tooltip tooltipForBtnRemove_js hidden" for="btn_remove<?=$item['id_product']?>">Меньше</div>
								</div>
								<div class="units"><?=$item['units'];?></div>
							</div>
						</div>
						<div class="priceMoptInf<?=($in_cart && $_SESSION['cart']['products'][$item['id_product']]['quantity'] < $item['inbox_qty'])?'':' hidden'?>">Малый опт</div>
					</div>
				<?}?>
				<?if(isset($_SESSION['member']['ordered_prod']) && in_array($item['id_product'], $_SESSION['member']['ordered_prod'])){?>
					<div id="ordered-<?=$item['id_product'];?>" class="icon material-icons ordered">check_circle</div>
					<div class="mdl-tooltip" for="ordered-<?=$item['id_product'];?>">Вы уже заказывали<br>этот товар ранее</div>
				<?}?>
				<div class="clearBoth"></div>
			</div>
		<?}
		break;
}?>