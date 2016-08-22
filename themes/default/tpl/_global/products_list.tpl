<?if($GLOBALS['CurrentController'] !== 'products'){?>
	<link href="<?=$GLOBALS['URL_css_theme'];?>page_styles/products.css" rel="stylesheet" type="text/css">
<?}?>
<?
$GLOBALS['descr_for_seo'] = [];
switch(isset($_SESSION['member']['gid']) ? $_SESSION['member']['gid'] : null){
	case _ACL_CONTRAGENT_:
	    foreach($list as $item){
			$Status = new Status();
			$action = false;
			array_push($GLOBALS['descr_for_seo'], array('name' => $item['name'], 'descr' => $item['descr']));
			$st = $Status->GetStstusById($item['id_product']);
			$a = explode(';', $GLOBALS['CONFIG']['correction_set_'.$item['opt_correction_set']]);
			// Проверяем доступнось розницы
			($item['price_mopt'] > 0 && $item['min_mopt_qty'] > 0)?$mopt_available = true:$mopt_available = false;
			// Проверяем доступнось опта
			($item['price_opt'] > 0 && $item['inbox_qty'] > 0)?$opt_available = true:$opt_available = false;?>
			<div class="card" data-idproduct="<?=$item['id_product']?>">
				<?if (in_array($item['opt_correction_set'], $GLOBALS['CONFIG']['promo_correction_set']) || in_array($item['mopt_correction_set'], $GLOBALS['CONFIG']['promo_correction_set'])) {
					$action = true;
				}?>
				<div class="market_action <?=isset($action) && $action === true?null:'hidden'?>">
					<img src="<?=_base_url?>/images/action2.png" alt="акционный товар">
				</div>
				<div class="product_section" id="product_<?=$item['id_product']?>">
					<!-- <div class="product_block"> -->
						<div class="product_photo">
							<a href="<?=_base_url?>/product/<?=$item['id_product'].'/'.$item['translit']?>/">
								<div class="<?=$st['class']?>"></div>
								<?if(!empty($item['images'])){?>
									<img alt="<?=htmlspecialchars(G::CropString($item['name']))?>" class="lazy" src="/images/nofoto.png" data-original="<?=_base_url?><?=G::GetImageUrl($item['images'][0]['src'], 'medium')?>"/>
									<noscript>
										<img alt="<?=htmlspecialchars(G::CropString($item['name']))?>" src="<?=_base_url?><?=G::GetImageUrl($item['images'][0]['src'], 'medium')?>"/>
									</noscript>
								<?}else{?>
									<img alt="<?=htmlspecialchars(G::CropString($item['name']))?>" class="lazy" src="/images/nofoto.png" data-original="<?=_base_url.G::GetImageUrl($item['img_1'], 'medium')?>"/>
									<noscript>
										<img alt="<?=htmlspecialchars(G::CropString($item['name']))?>" src="<?=_base_url.G::GetImageUrl($item['img_1'], 'medium')?>"/>
									</noscript>
								<?}?>
							</a>
						</div>
						<div class="product_name p<?=$item['id_product']?>">
							<a href="<?=_base_url?>/product/<?=$item['id_product'].'/'.$item['translit']?>/" class="cat_<?=$item['id_product']?>"><?=G::CropString($item['name'])?></a>
							<span class="product_article"><!--noindex-->арт. <!--/noindex--><?=$item['art']?></span>
							<div class="note <?=$item['note_control'] != 0?'note_control':null?> <?=isset($_SESSION['cart']['products'][$item['id_product']])?null:'hidden';?> <?=isset($_SESSION['cart']['products'][$item['id_product']]['note']) && $_SESSION['cart']['products'][$item['id_product']]['note'] != '' ?null:'activeNoteArea'?>">
								<textarea class="note_field" placeholder="<?=$item['note_control'] != 0?'ПРИМЕЧАНИЕ ОБЯЗАТЕЛЬНО!!!':' Примечание:'?>" id="mopt_note_<?=$item['id_product']?>" data-id="<?=$item['id_product']?>"><?=isset($_SESSION['cart']['products'][$item['id_product']]['note'])?$_SESSION['cart']['products'][$item['id_product']]['note']:null?></textarea>
								<label class="info_key">?</label>
								<div class="info_description">
									<p>Поле для ввода примечания к товару.</p>
								</div>
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
					<!-- </div> -->
					<?$in_cart = false;
					if(isset($_SESSION['cart']['products'][$item['id_product']])){
						$in_cart = true;
					}?>
					<?if((isset($item['active']) && ($item['active'] == 0 || $item['active'] == '')) || ($item['price_opt'] == 0 && $item['price_mopt'] == 0)){?>
						<div class="notAval">Нет в наличии</div>
					<?}else{?>
						<div class="product_buy" data-idproduct="<?=$item['id_product']?>">
							<div class="buy_block">
								<div class="base_price <?=isset($action) && $action === true?null:'hidden'?> <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>">
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
						<div class="fright service_block">
							<!-- <p class="comment_question open_modal" data-target="comment_question">Отзывы и вопросы</p> -->
							<button class="mdl-button mdl-js-button comment_question_btn btn_js" data-name="comment_question">Отзывы и вопросы</button>

							<?if($item['available_today'] == 1){?>
								<span class="material-icons icon-font timerIcon">timer</span>
								<p class="available_today">
									Отгрузка за 2 часа
								</p>
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
				<div class="clear_card"></div>
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
			<div class="clear_card"></div>
		</div><?
		foreach($list as $item){
			$action = false;
			array_push($GLOBALS['descr_for_seo'], array('name' => $item['name'], 'descr' => $item['descr']));?>
			<div class="card" data-idproduct="<?=$item['id_product']?>">
				<?if (in_array($item['opt_correction_set'], $GLOBALS['CONFIG']['promo_correction_set']) || in_array($item['mopt_correction_set'], $GLOBALS['CONFIG']['promo_correction_set'])) {
					$action = true;
				}?>
				<div class="market_action <?=isset($action) && $action === true?null:'hidden'?>">
					<img src="<?=_base_url?>/images/action2.png" alt="акционный товар">
				</div>
				<div class="product_photo card_item">
					<a href="<?=Link::Product($item['translit']);?>">
						<?if(!empty($item['images'])){?>
							<img alt="<?=htmlspecialchars(G::CropString($item['name']))?>" class="lazy" src="/images/nofoto.png" data-original="<?=_base_url.G::GetImageUrl($item['images'][0]['src'], 'thumb')?>"/>
							<noscript>
								<img alt="<?=htmlspecialchars(G::CropString($item['name']))?>" src="<?=_base_url.G::GetImageUrl($item['images'][0]['src'], 'thumb')?>"/>
							</noscript>
						<?}else{?>
							<img alt="<?=htmlspecialchars(G::CropString($item['name']))?>" class="lazy" src="/images/nofoto.png" data-original="<?=_base_url.G::GetImageUrl($item['img_1'], 'medium')?>"/>
							<noscript>
								<img alt="<?=htmlspecialchars(G::CropString($item['name']))?>" src="<?=_base_url.G::GetImageUrl($item['img_1'], 'medium')?>"/>
							</noscript>
						<?}?>
					</a>
				</div>
				<p class="product_name card_item"><a href="<?=Link::Product($item['translit']);?>"><?=G::CropString($item['name'])?></a><span class="product_article">Арт: <?=$item['art'];?></span></p>
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
				<div class="clear_card"></div>
			</div>
		<?}
    	break;
	default:
    	foreach($list as $item){
			$in_cart = false;
			$action = false;
			array_push($GLOBALS['descr_for_seo'], array('name' => $item['name'], 'descr' => $item['descr']));
			if(isset($_SESSION['cart']['products'][$item['id_product']])){
				$in_cart = true;
			}
			$a = explode(';', $GLOBALS['CONFIG']['correction_set_'.$item['opt_correction_set']]);?>
			<div class="card" data-idproduct="<?=$item['id_product']?>">
				<?if (in_array($item['opt_correction_set'], $GLOBALS['CONFIG']['promo_correction_set']) || in_array($item['mopt_correction_set'], $GLOBALS['CONFIG']['promo_correction_set'])) {
					$action = true;
				}?>
				<div class="market_action <?=isset($action) && $action === true?null:'hidden'?>">
					<img src="<?=_base_url?>/images/action2.png" alt="акционный товар">
				</div>
				<div class="product_photo">
					<a href="<?=Link::Product($item['translit']);?>">
						<?if(!empty($item['images'])){?>
							<img alt="<?=htmlspecialchars(G::CropString($item['id_product']))?>" class="lazy" src="/images/nofoto.png" data-original="<?=_base_url?><?=G::GetImageUrl($item['images'][0]['src'], 'medium')?>"/>
							<noscript><img alt="<?=htmlspecialchars(G::CropString($item['id_product']))?>" src="<?=_base_url?><?=G::GetImageUrl($item['images'][0]['src'], 'medium')?>"/></noscript>
						<?}else{?>
							<img alt="<?=htmlspecialchars(G::CropString($item['id_product']))?>" class="lazy" src="/images/nofoto.png" data-original="<?=_base_url?><?=G::GetImageUrl($item['img_1'], 'medium')?>"/>
							<noscript><img alt="<?=htmlspecialchars(G::CropString($item['id_product']))?>" src="<?=_base_url?><?=G::GetImageUrl($item['img_1'], 'medium')?>"/></noscript>
						<?}?>
					</a>
					<div class="add_to_fav_trend_block mdl-cell--hide-phone">
						<div class="favorite<?=isset($_SESSION['member']['favorites']) && in_array($item['id_product'], $_SESSION['member']['favorites'])?' added':null;?> <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>" data-id-product="<?=$item['id_product'];?>">
							<?if(isset($_SESSION['member']['favorites']) && in_array($item['id_product'], $_SESSION['member']['favorites'])) {?>
								<i id="forfavorite_<?=$item['id_product']?>" class="isfavorite favorite_icon material-icons">favorite</i>
								<span class="mdl-tooltip" for="forfavorite_<?=$item['id_product']?>">Товар уже <br> в избранном</span></div>
							<?}else{?>
								<i id="forfavorite_<?=$item['id_product']?>" class="notfavorite favorite_icon material-icons">favorite_border</i>
								<span class="mdl-tooltip" for="forfavorite_<?=$item['id_product']?>">Добавить товар <br> в избранное</span></div>
							<?}?>
						<div id="fortrending_<?=$item['id_product']?>" class="fortrending <?=isset($_SESSION['member']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>" data-id-product="<?=$item['id_product'];?>" <?=isset($_SESSION['member'])?'data-id-user="'.$_SESSION['member']['id_user'].'" data-email="'.$_SESSION['member']['email'].'"':'';?>>
							<div class="waiting_list icon material-icons <?=isset($_SESSION['member']['waiting_list']) && in_array($item['id_product'], $_SESSION['member']['waiting_list'])? 'arrow' : null;?>">trending_down</div></div>
						<div class="mdl-tooltip" for="fortrending_<?=$item['id_product']?>"><?=isset($_SESSION['member']['waiting_list']) && in_array($item['id_product'], $_SESSION['member']['waiting_list'])? 'Товар уже <br> в списке ожидания' : 'Следить за ценой';?></div>
						<div class="preview_icon_block"><div class="material-icons preview_icon">zoom_in</div></div>
					</div>
				</div>
				<div class="product_name">
					<a href="<?=Link::Product($item['translit']);?>"><?=G::CropString($item['name'])?></a>
					<span class="product_article">арт: <?=$item['art'];?></span>

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
				<?if((isset($item['active']) && ($item['active'] == 0 || $item['active'] == '')) || ($item['price_opt'] == 0 && $item['price_mopt'] == 0)){?>
					<div class="notAval">Нет в наличии</div>
				<?}else{?>
					<div class="product_buy" data-idproduct="<?=$item['id_product']?>">
						<div class="buy_block">
							<div class="base_price <?=isset($action) && $action === true?null:'hidden'?> <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>">
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
				<div class="clear_card"></div>
			</div>
		<?}
}?>



<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar snackbar">
	<div class="mdl-snackbar__text"></div>
	<button class="mdl-snackbar__action" type="button"></button>
</div>

<script>
	$(function(){
		//Инициализация добавления товара в избранное
		$('.favorite i').click(function(e) {
			e.preventDefault();
			if ($(this).closest('.favorite').hasClass('added')) {
				$(this).closest('.favorite').removeClass('added');
				RemoveFavorite($(this).closest('.favorite').data('id-product'), $(this));
			}else{
				$(this).closest('.favorite').addClass('added');
				AddFavorite($(this).closest('.favorite').data('id-product'), $(this));
			}
		});

		//Инициализация добавления товара в список ожидания
		$('.waiting_list').click(function(e) {
			e.preventDefault();
			if ($(this).hasClass('arrow')) {
				$(this).removeClass('arrow');
				RemoveFromWaitingList($(this).closest('.fortrending').data('id-product'), $(this).closest('.fortrending').data('id-user'), $(this).closest('.fortrending').data('email'), $(this));
			}else{
				$(this).addClass('arrow');
				AddInWaitingList($(this).closest('.fortrending').data('id-product'), $(this).closest('.fortrending').data('id-user'), $(this).closest('.fortrending').data('email'), $(this));
			}
		});

		$('.product_main_img').click(function(event) {
			$('#big_photo img').css('height', $('#big_photo[data-type="modal"]').outerHeight() + "px");
		});
	});
</script>