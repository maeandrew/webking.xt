<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	$Products = new Products();
	$where_arr = array('cp.id_category'=>(isset($_POST['id_category'])?$_POST['id_category']:null));
	$params = array(
		'group_by' => 'a.id_product',
		'ajax' => true,
		'rel_search' => null
	);
	if(isset($_COOKIE['sorting'])) {
		$sort = json_decode($_COOKIE['sorting'], true);
		$sorting = $sort['products'];
		$params['order_by'] = $sorting['value'];
	}

	if(isset($_POST['action'])){
		switch($_POST['action']){
			case "getFilterLink":
				echo json_encode(Link::Category($_POST['rewrite'], $_POST['params']));
				break;
			case "getmoreproducts":
				$Products->SetProductsList($where_arr, ' LIMIT '.($_POST['skipped_products']+$_POST['shown_products']).', 30', 0, $params);
				if($Products->list){
					foreach($Products->list as &$p){
						$p['images'] = $Products->GetPhotoById($p['id_product']);
					}
				}
				$tpl->Assign('list', $Products->list);
				$i = $_POST['shown_products']+1;
				$products_list = $tpl->Parse($GLOBALS['PATH_tpl_global'].'products_list.tpl');
				echo $products_list;
				break;
			case "getmoreproducts_desktop":
				$Products->SetProductsList($where_arr, ' LIMIT '.($_POST['skipped_products']+$_POST['shown_products']).', 30', 0, $params);
				$list = $Products->list;
				$i = $_POST['shown_products']+1;
				foreach($list AS $item){
					$item['images'] = $Products->GetPhotoById($item['id_product']);?>
					<div class="col-md-12 clearfix">
						<div class="product_section clearfix" id="product_<?=$item['id_product']?>">
							<div class="product_block">
								<div class="product_photo">
									<a href="<?=_base_url?>/product/<?=$item['id_product'].'/'.$item['translit']?>/">
										<div class="<?=$st['class']?>"></div>
										<?if(!empty($item['images'])){?>
											<img alt="<?=G::CropString($item['name'])?>" src="<?=file_exists($GLOBALS['PATH_root'].str_replace('original', 'thumb', $item['images'][0]['src']))?_base_url.str_replace('original', 'thumb', $item['images'][0]['src']):'/efiles/_thumb/nofoto.jpg'?>"/>
											<noscript>
												<img alt="<?=G::CropString($item['name'])?>" src="<?=file_exists($GLOBALS['PATH_root'].str_replace('original', 'thumb', $item['images'][0]['src']))?_base_url.str_replace('original', 'thumb', $item['images'][0]['src']):'/efiles/_thumb/nofoto.jpg'?>"/>
											</noscript>
										<?}else{?>
											<img alt="<?=G::CropString($item['name'])?>" src="<?=file_exists($GLOBALS['PATH_root'].$item['img_1'])?_base_url.htmlspecialchars(str_replace("/image/", "/image/250/", $item['img_1'])):'/efiles/_thumb/nofoto.jpg'?>"/>
											<noscript>
												<img alt="<?=G::CropString($item['name'])?>" src="<?=file_exists($GLOBALS['PATH_root'].$item['img_1'])?_base_url.htmlspecialchars(str_replace("/image/", "/image/250/", $item['img_1'])):'/efiles/_thumb/nofoto.jpg'?>"/>
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
								<form action="" class="note">
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
				break;
			case "getproductscount":
				$cnt = $Products->GetProductsCnt($where_arr, 0, $params);
				echo $cnt;
				break;
			default:
				break;
		}
		exit();
	}
}
?>