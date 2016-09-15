<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	$Products = new Products();
	$sort = unserialize($_COOKIE['sorting']);
	$sorting = $sort['products'];
	$where_arr = array('cp.id_category'=>$_GET['id_category']);
	$params = array(
		'group_by' => 'a.id_product',
		'order_by' => $sorting['value'],
		'ajax' => true,
		'rel_search' => null
	);

	if(isset($_GET['action'])){
		switch($_GET['action']){
			case "getmoreproducts":
				$Products->SetProductsList($where_arr, ' LIMIT '.($_GET['skipped_products']+$_GET['shown_products']).', 30', $params);
				$list = $Products->list;
				$i = $_GET['shown_products']+1;
				foreach($list AS $item){
					$item['images'] = $Products->GetPhotoById($item['id_product']);
					($item['price_mopt'] > 0 && $item['min_mopt_qty'] > 0)? $mopt_available = TRUE : $mopt_available = FALSE;?>
					<section class="product product_<?=$item['id_product']?> animate">
						<div class="content animate bg-white brdrds">
							<div class="thumbnail">
								<a href="/product/<?=$item['id_product']?>/<?=$item['translit']?>/">
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
							<div class="name">
								<a href="/product/<?=$item['id_product']?>/<?=$item['translit']?>/" class="color-green"><?=$item['name'];?></a>
								<div class="article color-sgrey">Артикул: <?=$item['art']?></div>
							</div>
							<div id="product_prices">
								<?$script = '<script type="text/javascript">';
								if($item['qty_control']){
									$script .= "qtycontrol[".$item['id_product']."] = 1;";
								}
								if($item['note_control']){
									$script .= "notecontrol[".$item['id_product']."] = 1;";
								}
								$script .= "</script>";
								if($item['qty_control'] || $item['note_control']){
									echo $script;
								}
								if($mopt_available){?>
									<div class="cat_item_even" id="cat_item_<?=$item['id_product']?> mopt">
										<!-- Начало строки розницы!-->
										<?if(isset($item['mopt_correction_set'])){
											if(isset($GLOBALS['CONFIG']['correction_set_'.$item['mopt_correction_set']]) && $GLOBALS['CONFIG']['correction_set_'.$item['mopt_correction_set']] != ''){
												$mopt_correction = explode(';', $GLOBALS['CONFIG']['correction_set_'.$item['mopt_correction_set']]);
											}else{
												$mopt_correction = explode(';', $GLOBALS['CONFIG']['correction_set_0']);
											}
										}
										$cat_wholesale_price = explode(',',number_format($item['price_mopt']*$mopt_correction[0],2,",",""));
										if($item['price_mopt']*$mopt_correction[1]*$item['min_mopt_qty'] > $GLOBALS['CONFIG']['full_wholesale_order_margin']){
											$cat_best_price = $cat_wholesale_price;
										}else{
											$cat_best_price = explode(',',number_format($item['price_mopt']*$mopt_correction[1],2,",",""));
										}
										if($item['price_mopt']*$mopt_correction[2]*$item['min_mopt_qty'] > $GLOBALS['CONFIG']['wholesale_order_margin']){
											$cat_worst_price = $cat_best_price;
										}else{
											$cat_worst_price = explode(',',number_format($item['price_mopt']*$mopt_correction[2],2,",",""));
										}
										if($item['price_mopt']*$mopt_correction[3]*$item['min_mopt_qty'] > $GLOBALS['CONFIG']['retail_order_margin']){
											$cat_base_price = $cat_worst_price;
										}else{
											$cat_base_price = explode(',',number_format($item['price_mopt']*$mopt_correction[3],2,",",""));
										}?>
										<div class="mopt_price">
											<span id="min_mopt_qty_<?=$item['id_product']?>" style="display: none;"><?=$item['min_mopt_qty']?></span>
											<span class="description fleft">Розничная цена (от <span id="min_mopt_qty_<?=$item['id_product']?>"><?=$item['min_mopt_qty']?></span><?=$item['units']?><?=$item['qty_control']?"*":null?>)</span>
											<div class="mopt_price_value fleft">
												<span class="integer fleft"><?=$cat_base_price[0]?></span>
												<span class="sup fright"><?=$cat_base_price[1]?></span>
												<span class="sub fright">грн</span>
											</div>
											<div class="buy_buttons_set fright">
												<a href="#" data-role="none" id="mopt_buy_button_<?=$item['id_product']?>" class="btn-l btn-orange buy_button <?=(isset($_SESSION['Cart']['products'][$item['id_product']]['order_mopt_qty']) && $_SESSION['Cart']['products'][$item['id_product']]['order_mopt_qty'] > 0)?'hidden':null;?>" onclick="ch_qty(0,'plus',<?=$item['id_product']?>);return false;">В корзину <svg class="icon"><use xlink:href="#icon-add-shopping-cart"></use></svg></a>
												<div id="mopt_buy_buttons_<?=$item['id_product']?>" class="buy_buttons <?=!isset($_SESSION['Cart']['products'][$item['id_product']]['order_mopt_qty']) || $_SESSION['Cart']['products'][$item['id_product']]['order_mopt_qty'] == 0?'hidden':null;?>">
													<a href="#" data-role="none" class="btn-l btn-orange fleft" onclick="ch_qty(0,'minus',<?=$item['id_product']?>);return false;">
														<svg class="icon"><use xlink:href="#icon-remove"></use></svg>
													</a>
													<input type="number" data-role="none" <?=$item['qty_control']?'step="'.$item['min_mopt_qty'].'"':null?> class="cat_mopt_order_qty btn-l fleft" id="order_mopt_qty_<?=$item['id_product']?>" value="<?=isset($_SESSION['Cart']['products'][$item['id_product']]['order_box_qty'])?$_SESSION['Cart']['products'][$item['id_product']]['order_mopt_qty']:"0"?>" onchange="toCart(<?=$item['id_product']?>, 0)">
													<a href="#" data-role="none" class="btn-l btn-orange fleft" onclick="ch_qty(0,'plus',<?=$item['id_product']?>);return false;">
														<svg class="icon"><use xlink:href="#icon-add"></use></svg>
													</a>
													<div class="clear"></div>
												</div>
											</div>
										</div>
									</div>
									<?if(isset($item['old_price_mopt']) && $item['old_price_mopt'] > 0 && $item['price_mopt'] > 0 && $item['old_price_mopt'] > $item['price_mopt']){?>
										<div class="cat_base_price sale_price mopt_item<?=$item['id_product']?> hidden">
											<div class="old_price">
												<span><?=number_format($item['old_price_mopt']*$mopt_correction[3],2,",","")?></span>
											</div>
											<div id="price_mopt_<?=$item['id_product']?>_basic" class="hidden">
												<?=number_format($item['price_mopt'],2,",","")?>
											</div>
											<div id="correction_set_price_mopt_<?=$item['id_product']?>" class="hidden">
												<?=$GLOBALS['CONFIG']['correction_set_'.$item['mopt_correction_set']]?>
											</div>
										</div>
									<?}else{?>
										<div class="cat_base_price sale_price mopt_item<?=$item['id_product']?> hidden" <?=(!isset($_COOKIE['sum_range']) || $_COOKIE['sum_range'] != 3)?'style="display: none;"':null?>><?=($cat_base_price[0] == 0 && $cat_base_price[1] == 0) ?'---':$cat_base_price[0].','.$cat_base_price[1];?>
											<div id="price_mopt_<?=$item['id_product']?>_basic" class="hidden">
												<?=number_format($item['price_mopt'],2,",","")?>
											</div>
											<div id="correction_set_price_mopt_<?=$item['id_product']?>" class="hidden">
												<?=$GLOBALS['CONFIG']['correction_set_'.$item['mopt_correction_set']]?>
											</div>
										</div>
									<?}?>
								<?}?>
								<div class="clear"></div>
							</div>
						</div>
					</section>
				<?$i++;
				}
			;
			break;
			case "getmoreproducts_desktop":
				$Products->SetProductsList($where_arr, ' LIMIT '.($_GET['skipped_products']+$_GET['shown_products']).', 30', $params);
				$list = $Products->list;
				$i = $_GET['shown_products']+1;
				foreach($list AS $item){
					$item['images'] = $Products->GetPhotoById($item['id_product']);?>
					<div class="col-md-12 clearfix">
						<div class="product_section clearfix" id="product_<?=$item['id_product']?>">
							<div class="product_block">
								<div class="product_photo">
									<a href="<?=_base_url?>/product/<?=$item['id_product'].'/'.$item['translit']?>/">
										<div class="<?=$st['class']?>"></div>
										<?if(!empty($item['images'])){?>
											<img alt="<?=htmlspecialchars(G::CropString($item['name']))?>" src="<?=_base_url.G::GetImageUrl($item['images'][0]['src'], 'thumb')?>"/>
											<noscript>
												<img alt="<?=htmlspecialchars(G::CropString($item['name']))?>" src="<?=_base_url.G::GetImageUrl($item['images'][0]['src'], 'thumb')?>"/>
											</noscript>
										<?}else{?>
											<img alt="<?=htmlspecialchars(G::CropString($item['name']))?>" src="<?=_base_url.G::GetImageUrl($item['img_1'], 'medium')?>"/>
											<noscript>
												<img alt="<?=htmlspecialchars(G::CropString($item['name']))?>" src="<?=_base_url.G::GetImageUrl($item['img_1'], 'medium')?>"/>
											</noscript>
										<?}?>
									</a>
								</div>
								<div class="product_name p<?=$item['id_product']?>">
									<a href="<?=_base_url?>/product/<?=$item['id_product'].'/'.$item['translit']?>/" class="cat_<?=$item['id_product']?>"><?=G::CropString($item['name'])?></a>
								</div>
								<p class="product_article"><!--noindex-->арт: <!--/noindex--><?=$item['art']?></p>
								<?if(isset($_SESSION['member']) && $_SESSION['member']['gid'] == _ACL_CONTRAGENT_){?>
									<div class="duplicate">
										<label form="duplicate">
											<input type="checkbox" name="duplicate" class="duplicate_check_<?=$item['id_product']?>" id="duplicate" <?=$item['duplicate']==1?'disabled checked="checked"':null;?>>Дубль
											<input type="hidden" value="<?=$item['art']?>" class="articul">
										</label>
									</div>
									<?if($item['available_today'] == 1){?>
										<p class="available_today"><span class="icon-font">clock</span>Отгрузка за 2 часа</p>
									<?}?>
								<?}?>
							</div>
							<?$in_cart = false;
							if(isset($_SESSION['cart']['products'][$item['id_product']])){
								$in_cart = true;
							}?>
							<?if($item['price_opt'] == 0 && $item['price_mopt'] == 0){?>
								<div class="notAval">Нет в наличии</div>
							<?}else{?>
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
												<span class="price_js"><?=$in_cart?number_format($_SESSION['cart']['products'][$item['id_product']]['actual_prices'][$_COOKIE['sum_range']], 2, ".", ""):number_format($item['price_opt']*explode(';', $GLOBALS['CONFIG']['correction_set_'.$item['opt_correction_set']])[$_COOKIE['sum_range']], 2, ".", "");?></span>
												<!--noindex--> грн.<!--/noindex-->
											<?}?>
										</div>
										<?if(($item['price_opt'] > 0 || $item['price_mopt'] > 0)  && $item['visible'] != 0){?>
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
											<span class="price_js"><?=$in_cart?number_format($_SESSION['cart']['products'][$item['id_product']]['other_prices'][$_COOKIE['sum_range']], 2, ".", ""):number_format($item['price_mopt']*explode(';', $GLOBALS['CONFIG']['correction_set_'.$item['mopt_correction_set']])[$_COOKIE['sum_range']], 2, ".", "");?></span>
											<!--noindex--> грн.<!--/noindex-->
											<span class="mode_js"><?=$in_cart && $_SESSION['cart']['products'][$item['id_product']]['mode'] == 'mopt'?'от':'до';?></span>
											<?=$item['inbox_qty'].' '.$item['units']?>
											<?if(isset($item['qty_control']) && !empty($item['qty_control'])){?>
												<p class="qty_descr">мин. <?=$item['min_mopt_qty'].' '.$item['units']?> (кратно)</p>
											<?}?>
										</p>
									</div>
								</div>
							<?}?>
							<div class="product_info">
								<div class="rating_block">
									<div class="preview_favorites" data-idfavorite="<?=$item['id_product']?>" title="<?=(!isset($_SESSION['member']) || !in_array($item['id_product'], $_SESSION['member']['favorites']))?'Добавить товар в избранное':'Товар находится в избранных'?>">
										<span class="icon-font favorite">favorites<?=(!isset($_SESSION['member']) || !in_array($item['id_product'], $_SESSION['member']['favorites']))?'-o':null?></span>
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
												<li><span class="icon-font"><?=$star?></span></li>
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
								<form action="<?=$_SERVER['REQUEST_URI']?>" class="note">
									<textarea cols="30" rows="3" placeholder="Примечание к заказу"><?=isset($_SESSION['cart']['products'][$item['id_product']]['note_opt'])?$_SESSION['cart']['products'][$item['id_product']]['note_opt']:null?></textarea>
									<label class="info_key">?</label>
									<div class="info_description">
										<p>Поле для ввода примечания к товару</p>
									</div>
								</form>
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
				<?$i++;
				}
			;
			break;
			case "getproductscount":
				$cnt = $Products->GetProductsCnt($where_arr, 0, $params);
				echo $cnt;
			;
			default:
			;
			break;
		}
		exit();
	}
}
?>