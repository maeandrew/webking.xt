<link href="<?=$GLOBALS['URL_css_theme'];?>page_styles/products.css" rel="stylesheet" type="text/css">
<?switch(isset($_SESSION['member']['gid']) ? $_SESSION['member']['gid'] : null){
	case _ACL_CONTRAGENT_:
	    foreach($list as $item){
			$Status = new Status();
			$st = $Status->GetStstusById($item['id_product']);
			$a = explode(';', $GLOBALS['CONFIG']['correction_set_'.$item['opt_correction_set']]);
			// Проверяем доступнось розницы
			($item['price_mopt'] > 0 && $item['min_mopt_qty'] > 0)?$mopt_available = true:$mopt_available = false;
			// Проверяем доступнось опта
			($item['price_opt'] > 0 && $item['inbox_qty'] > 0)?$opt_available = true:$opt_available = false;?>
			<div class="card">
				<div class="product_section" id="product_<?=$item['id_product']?>">
					<!-- <div class="product_block"> -->
						<div class="product_photo">
							<a href="<?=_base_url?>/product/<?=$item['id_product'].'/'.$item['translit']?>/">
								<div class="<?=$st['class']?>"></div>
								<?if(!empty($item['images'])){?>
									<img alt="<?=G::CropString($item['name'])?>" class="lazy" data-original="<?=_base_url.str_replace('original', 'medium', $item['images'][0]['src']);?>"/>
									<noscript>
										<img alt="<?=G::CropString($item['name'])?>" src="<?=_base_url.str_replace('original', 'medium', $item['images'][0]['src']);?>"/>
									</noscript>
								<?}else{?>
									<img alt="<?=G::CropString($item['name'])?>" class="lazy" data-original="<?=_base_url.($item['img_1'])?htmlspecialchars(str_replace("/image/", "/image/500/", $item['img_1'])):"/images/nofoto.png"?>"/>
									<noscript>
										<img alt="<?=G::CropString($item['name'])?>" src="<?=_base_url.($item['img_1'])?htmlspecialchars(str_replace("/image/", "/image/500/", $item['img_1'])):"/images/nofoto.png"?>"/>
									</noscript>
								<?}?>
							</a>
						</div>
						<div class="product_name p<?=$item['id_product']?>">
							<a href="<?=_base_url?>/product/<?=$item['id_product'].'/'.$item['translit']?>/" class="cat_<?=$item['id_product']?>"><?=G::CropString($item['name'])?></a>
							<span class="product_article"><!--noindex-->арт. <!--/noindex--><?=$item['art']?></span>
							<?if(isset($_SESSION['member']['ordered_prod']) && in_array($item['id_product'], $_SESSION['member']['ordered_prod'])){?>
								<div id="ordered-<?=$item['id_product'];?>" class="icon material-icons ordered">check_circle</div>
								<div class="mdl-tooltip" for="ordered-<?=$item['id_product'];?>">Вы уже заказывали<br>этот товар ранее</div>
							<?}?>
							<div class="note <?=$item['note_control'] != 0?'note_control activeNoteArea':null?> <?=isset($_SESSION['cart']['products'][$item['id_product']])?null:'hidden';?>">
								<textarea class="note_field" placeholder="<?=$item['note_control'] != 0?'ПРИМЕЧАНИЕ ОБЯЗАТЕЛЬНО!!!':' Примечание:'?>" id="mopt_note_<?=$item['id_product']?>" data-id="<?=$item['id_product']?>"><?=isset($_SESSION['cart']['products'][$item['id_product']]['note_opt'])?$_SESSION['cart']['products'][$item['id_product']]['note_opt']:null?></textarea>
								<label class="info_key">?</label>
								<div class="info_description">
									<p>Поле для ввода примечания к товару.</p>
								</div>
							</div>
							<!-- <form action="" class="note <?=$item['note_control'] != 0?'note_control':null?>" data-note="<?=$item['id_product']?>">
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
					<div class="product_buy" data-idproduct="<?=$item['id_product']?>">
					<div class="buy_block">
						<div class="product_price">
							<div class="price"><?=$in_cart?number_format($_SESSION['cart']['products'][$item['id_product']]['actual_prices'][$_COOKIE['sum_range']], 2, ",", ""):number_format($item['price_opt']*$a[$_COOKIE['sum_range']], 2, ",", "");?></div><span>грн.</span>
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
								<input type="text" class="qty_js" value="<?=isset($_SESSION['cart']['products'][$item['id_product']]['quantity'])?$_SESSION['cart']['products'][$item['id_product']]['quantity']:$item['inbox_qty']?>" min="0" step="<?=$item['min_mopt_qty'];?>">
								
								<button id="btn_remove<?=$item['id_product']?>" class="material-icons btn_remove btn_qty_js" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 0);return false;">remove</button>
								<div class="mdl-tooltip tooltipForBtnRemove_js hidden" for="btn_remove<?=$item['id_product']?>">Меньше</div>
							</div>
							<div class="units"><?=$item['units'];?></div>
						</div>
					</div>
					<div class="priceMoptInf<?=($in_cart && $_SESSION['cart']['products'][$item['id_product']]['quantity'] < $item['inbox_qty'])?'':' hidden'?>">Малый опт</div>
				</div>
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
							<button class="mdl-button mdl-js-button mdl-js-ripple-effect comment_question_btn btn_js" data-name="comment_question">Отзывы и вопросы</button>

							<?if($item['available_today'] == 1){?>
								<span class="material-icons icon-font timerIcon">timer</span>
								<p class="available_today">
									Отгрузка за 2 часа
								</p>
							<?}?>
						</div>
						<!-- <form action="" class="note <?=$item['note_control'] != 0?'note_control':null?>" data-note="<?=$item['id_product']?>">
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
			</div>
		<?}	      
	    break;
	case _ACL_SUPPLIER_:	    	
    	?><div class="card card_wrapper clearfix">
			<div class="product_photo card_item">Фото товара</div>
			<p class="product_name card_item">Наименование товара</p>
			<div class="suplierPriceBlock headerPriceBlock">
				<div class="price card_item">Цена за ед. товара</div>
				<div class="count_cell card_item">Минимальное<br>количество</div>
				<div class="count_cell card_item">Кол-во<br>в ящике</div>
				<div class="product_check card_item">Добавить в<br>ассортимент</div>
			</div>
		</div><?
		foreach($list as $p){ ?>
			<div class="card clearfix">
				<div class="product_photo card_item">
					<a href="<?=Link::Product($p['translit']);?>">
						<?if(!empty($p['images'])){?>
							<img alt="<?=G::CropString($p['name'])?>" class="lazy" data-original="<?=_base_url.str_replace('original', 'thumb', $p['images'][0]['src']);?>"/>
							<noscript>
								<img alt="<?=G::CropString($p['name'])?>" src="<?=_base_url.str_replace('original', 'thumb', $p['images'][0]['src']);?>"/>
							</noscript>
						<?}else{?>
							<img alt="<?=G::CropString($p['name'])?>" class="lazy" data-original="<?=_base_url.($p['img_1'])?htmlspecialchars(str_replace("/image/", "/image/250/", $p['img_1'])):"/images/nofoto.png"?>"/>
							<noscript>
								<img alt="<?=G::CropString($p['name'])?>" src="<?=_base_url.($p['img_1'])?htmlspecialchars(str_replace("/image/", "/image/250/", $p['img_1'])):"/images/nofoto.png"?>"/>
							</noscript>
						<?}?>
					</a>
				</div>
				<p class="product_name card_item"><a href="<?=Link::Product($p['translit']);?>"><?=G::CropString($p['name'])?></a><span class="product_article">Арт: <?=$p['art'];?></span></p>
				<div class="suplierPriceBlock">
					<div class="price card_item"><p id="price_mopt_<?=$p['id_product']?>">
						<?if($p['price_opt_otpusk'] != 0){
							echo number_format($p['price_opt_otpusk'], 2, ".", "").' грн.';
						}else{
							echo number_format($p['price_mopt_otpusk'], 2, ".", "").' грн.';
						}?>
					</p></div>
					<div class="count_cell card_item">
						<span class="suplierPriceBlockLabel">Минимальное кол-во:</span>
						<p id="min_mopt_qty_<?=$p['id_product']?>"><?=$p['min_mopt_qty'].' '.$p['units']?><?=$p['qty_control']?" *":null?></p>			
					</div>
					<div class="count_cell card_item">
						<span class="suplierPriceBlockLabel">Количество в ящике:</span>
						<p id="inbox_qty_<?=$p['id_product']?>"><?=$p['inbox_qty'].' '.$p['units']?></p>
					</div>

					<div class="product_check card_item">
						<span class="suplierPriceBlockLabel">Добавить:</span>
						<label  class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox_mopt_<?=$p['id_product']?>">				
							<!-- <input type="checkbox" id="checkbox-2" class="mdl-checkbox__input"> -->
							<input type="checkbox" class="check mdl-checkbox__input" id="checkbox_mopt_<?=$p['id_product']?>" <?=isset($_SESSION['Assort']['products'][$p['id_product']])?'checked=checked':null?> onchange="AddDelProductAssortiment(this,<?=$p['id_product']?>)"/>
						</label>
					</div>
				</div>
			</div>
		<?}
    	break;		
	default:		 
    	foreach($list as $item){
			$in_cart = false;
			if(isset($_SESSION['cart']['products'][$item['id_product']])){
				$in_cart = true;
			}
			$a = explode(';', $GLOBALS['CONFIG']['correction_set_'.$item['opt_correction_set']]);?>
			<div class="card">
				<div class="product_photo">
					<a href="<?=Link::Product($item['translit']);?>">
						<?if(!empty($item['images'])){?>
							<img alt="<?=G::CropString($item['id_product'])?>" class="lazy" data-original="<?=_base_url?><?=file_exists($GLOBALS['PATH_root'].str_replace('original', 'medium', $item['images'][0]['src']))?str_replace('original', 'small', $item['images'][0]['src']):'/images/nofoto.png'?>"/>
							<noscript><img alt="<?=G::CropString($item['id_product'])?>" src="<?=_base_url?><?=file_exists($GLOBALS['PATH_root'].str_replace('original', 'small', $item['images'][0]['src']))?str_replace('original', 'small', $item['images'][0]['src']):'/images/nofoto.png'?>"/></noscript>
						<?}else{?>
							<img alt="<?=G::CropString($item['id_product'])?>" class="lazy" data-original="<?=_base_url?><?=$item['img_1']?htmlspecialchars(str_replace("/image/", "/image/250/", $item['img_1'])):"/images/nofoto.png"?>"/>
							<noscript><img alt="<?=G::CropString($item['id_product'])?>" src="<?=_base_url?><?=$item['img_1']?htmlspecialchars(str_replace("/image/", "/image/250/", $item['img_1'])):"/images/nofoto.png"?>"/></noscript>
						<?}?>
					</a>
				</div>
				<div class="product_name">
					<a href="<?=Link::Product($item['translit']);?>"><?=G::CropString($item['name'])?></a>
					<span class="product_article">арт: <?=$item['art'];?></span>
					<?if(isset($_SESSION['member']['ordered_prod']) && in_array($item['id_product'], $_SESSION['member']['ordered_prod'])){?>
						<div id="ordered-<?=$item['id_product'];?>" class="icon material-icons ordered">check_circle</div>
						<div class="mdl-tooltip" for="ordered-<?=$item['id_product'];?>">Вы уже заказывали<br>этот товар ранее</div>
					<?}?>
					<div class="product_info">
						<div class="note <?=$item['note_control'] != 0?'note_control activeNoteArea':null?> <?=isset($_SESSION['cart']['products'][$item['id_product']])?null:'hidden';?>">
							<textarea class="note_field" placeholder="<?=$item['note_control'] != 0?'ПРИМЕЧАНИЕ ОБЯЗАТЕЛЬНО!!!':' Примечание:'?>" id="mopt_note_<?=$item['id_product']?>" data-id="<?=$item['id_product']?>"><?=isset($_SESSION['cart']['products'][$item['id_product']]['note_opt'])?$_SESSION['cart']['products'][$item['id_product']]['note_opt']:null?></textarea>
							<label class="info_key">?</label>
							<div class="info_description">
								<p>Поле для ввода примечания к товару.</p>
							</div>
						</div>
					</div>
				</div>
				<div class="product_buy" data-idproduct="<?=$item['id_product']?>">
					<div class="buy_block">
						<div class="product_price">
							<div class="price"><?=$in_cart?number_format($_SESSION['cart']['products'][$item['id_product']]['actual_prices'][$_COOKIE['sum_range']], 2, ",", ""):number_format($item['price_opt']*$a[$_COOKIE['sum_range']], 2, ",", "");?></div><span>грн.</span>
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
								<input type="text" class="qty_js" value="<?=isset($_SESSION['cart']['products'][$item['id_product']]['quantity'])?$_SESSION['cart']['products'][$item['id_product']]['quantity']:$item['inbox_qty']?>" min="0" step="<?=$item['min_mopt_qty'];?>">
								
								<button id="btn_remove<?=$item['id_product']?>" class="material-icons btn_remove btn_qty_js" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 0);return false;">remove</button>
								<div class="mdl-tooltip tooltipForBtnRemove_js hidden" for="btn_remove<?=$item['id_product']?>">Меньше</div>
							</div>
							<div class="units"><?=$item['units'];?></div>
						</div>
					</div>
					<div class="priceMoptInf<?=($in_cart && $_SESSION['cart']['products'][$item['id_product']]['quantity'] < $item['inbox_qty'])?'':' hidden'?>">Малый опт</div>
				</div>
				<!-- <div class="product_info clearfix">
					<div class="note clearfix">
						<textarea placeholder="Примечание: "></textarea>
						<label class="info_key">?</label>
						<div class="info_description">
							<p>Поле для ввода примечания к товару.</p>
						</div>
					</div>
				</div> -->
			</div>
		<?}
}?>