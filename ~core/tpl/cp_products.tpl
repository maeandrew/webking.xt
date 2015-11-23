<?if(!empty($list) && empty($subcats)){?>
	<div class="sorting">
		<!--Сортировка по названию !-->
		<?if(!isset($_GET['search_in_cat'])){?>
			<form action="" method="POST">
				<?if(in_array('sorting', $list_controls)){?>
					<label for="sort_prod">Сортировка</label>
					<select id="sort_prod" name="value" data-role="none" onchange="$(this).closest('form').submit();">
						<?foreach($available_sorting_values as $key => $alias){
							print_r($sorting['value']);?>
							<option value="<?=$key?>" <?=isset($sorting['value']) && $sorting['value'] == $key?'selected="selected"':null;?>><?=$alias?></option>
						<?}?>
					</select>
					<select name="direction" data-role="none" class="hidden" onchange="$(this).closest('form').submit();">
						<option value="asc" <?=isset($sorting['direction']) && $sorting['direction'] == 'asc'?'selected="selected"':null;?>>по возрастанию</option>
						<option value="desc" <?=isset($sorting['direction']) && $sorting['direction'] == 'desc'?'selected="selected"':null;?>>по убыванию</option>
					</select>
				<?}?>
			</form>
		<?}?>
		<!--сортировка по названию!-->
		<div class="prod_structure">
			<span class="icon-font list">view_list</span>
			<span class="icon-font module disabled">view_module</span>
		</div>
	</div>
<?}?>
<div class="products">
	<?if(isset($subcats) && !empty($subcats)){?>
		<ul class="subcats row">
			<?foreach($subcats as $sub){
				$url = _base_url.'/products/'.$sub['id_category'].'/'.$sub['translit'].'/';
				if($sub['subcats'] !== 0){
					$url .= 'limitall/';
				}?>
				<li class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<a href="<?=$url;?>" class="animate">
						<div class="subcats_block">
							<div>
								<img class="lazy" data-original="<?=$sub['category_img']?>" alt="<?=$sub['name']?>"/>
								<noscript>
									<img src="<?=$sub['category_img']?>" alt="<?=$sub['name']?>"/>
								</noscript>
							</div>
							<div>
								<span class="color-grey"><?=$sub['name']?></span>
							</div>
						</div>
					</a>
				</li>
			<?}?>
		</ul>
		<?if(isset($curcat['content_xt']) && $curcat['content_xt'] != ''){?>
			<div class="content_wrapp">
				<input type="checkbox" id="read_more" class="hidden">
				<section class="content_text animate">
					<?=$curcat['content_xt']?>
				</section>
				<?if(strlen($curcat['content_xt']) >= 500){?>
					<label for="read_more">Читать полностью</label>
				<?}?>
			</div>
		<?}?>
	<?}else{?>
		<div class="row">
			<?if(isset($_SESSION['member']) && $_SESSION['member']['gid'] == _ACL_TERMINAL_){?>
				<form action="" method="post" class="price_mode_container">
					<?if(isset($_COOKIE['available_today']) && $_COOKIE['available_today'] == 1){?>
						<button type="submit" name="available_today" value="0" class="false">Показать все доступные товары</button>
					<?}else{?>
						<button type="submit" name="available_today" value="1" class="true">Отобрать товары с моментальной доставкой</button>
					<?}?>
				</form>
			<?}?>
			<!-- <form id="cart_discount_and_margin_parameters">
				<input type="hidden" id="cart_full_wholesale_order_margin" value="<?$GLOBALS['CONFIG']['full_wholesale_order_margin']?>"/>
				<input type="hidden" id="cart_full_wholesale_discount" value="<?$GLOBALS['CONFIG']['full_wholesale_discount']?>"/>
				<input type="hidden" id="cart_wholesale_order_margin" value="<?$GLOBALS['CONFIG']['wholesale_order_margin']?>"/>
				<input type="hidden" id="cart_wholesale_discount" value="<?$GLOBALS['CONFIG']['wholesale_discount']?>"/>
				<input type="hidden" id="cart_retail_order_margin" value="<?$GLOBALS['CONFIG']['retail_order_margin']?>"/>
				<input type="hidden" id="cart_retail_multiplyer" value="<?$GLOBALS['CONFIG']['retail_multiplyer']?>"/>
				<input type="hidden" id="cart_personal_discount" value="<?=isset($_SESSION['cart']['personal_discount'])?$_SESSION['cart']['personal_discount']:'1';?>"/>
				<input type="hidden" id="cart_price_mode" value="<?$_SESSION['price_mode']?>"/>
			</form> -->
			<?if(!empty($list)){?>
				<div class="col-md-12">
					<div class="tabs_container">
						<div class="row">
							<div class="tabs_block col-md-3  col-xs-12">
								<button onclick="ChangePriceRange(0);" class="sum_range sum_range_0 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 0)?'user_active':null;?>">
									<span class="tabs_block_descr">При сумме заказа более <?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?><!--noindex-->грн.<!--/noindex--></span>
									<label class="info_key">?</label>
									<div class="info_description">
										<p>В каталоге будут отображены цены товаров при общей сумме заказа более <?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?><!--noindex-->грн.<!--/noindex--></p>
									</div>
								</button>
							</div>
							<div class="tabs_block col-md-3  col-xs-12">
								<button onclick="ChangePriceRange(1);" class="sum_range sum_range_1 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 1)?'user_active':null;?>">
									<span class="tabs_block_descr">При сумме заказа <?=$GLOBALS['CONFIG']['wholesale_order_margin']?>-<?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?><!--noindex-->грн.<!--/noindex--></span>
									<label class="info_key">?</label>
									<div class="info_description">
										<p>В каталоге будут отображены цены товаров при общей сумме заказа от <?=$GLOBALS['CONFIG']['wholesale_order_margin']?> до <?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?><!--noindex-->грн.<!--/noindex--></p>
									</div>
								</button>
							</div>
							<div class="tabs_block col-md-3  col-xs-12">
								<button onclick="ChangePriceRange(2);" class="sum_range sum_range_2 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 2)?'user_active':null;?>">
									<span class="tabs_block_descr">При сумме заказа <?=$GLOBALS['CONFIG']['retail_order_margin']?>-<?=$GLOBALS['CONFIG']['wholesale_order_margin']?><!--noindex-->грн.<!--/noindex--></span>
									<label class="info_key">?</label>
									<div class="info_description">
										<p>В каталоге будут отображены цены товаров при общей сумме заказа от <?=$GLOBALS['CONFIG']['retail_order_margin']?> до <?=$GLOBALS['CONFIG']['wholesale_order_margin']?><!--noindex-->грн.<!--/noindex--></p>
									</div>
								</button>
							</div>
							<div class="tabs_block col-md-3 col-xs-12">
								<button onclick="ChangePriceRange(3);" class="sum_range sum_range_3 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 3)?'user_active':null;?>">
									<span class="tabs_block_descr">При сумме заказа до <?=$GLOBALS['CONFIG']['retail_order_margin']?><!--noindex-->грн.<!--/noindex--></span>
									<label class="info_key">?</label>
									<div class="info_description">
										<p>В каталоге будут отображены цены товаров при общей сумме заказа до <?=$GLOBALS['CONFIG']['retail_order_margin']?><!--noindex-->грн.<!--/noindex--></p>
									</div>
								</button>
							</div>
						</div>
					</div>
				</div>
				<div id="view_block_js" class="list_view col-md-12 ajax_loading">
					<div class="row">
						<?foreach($list as $item){
							$Status = new Status();
							$st = $Status->GetStstusById($item['id_product']);
							// Проверяем доступнось розницы
							($item['price_mopt'] > 0 && $item['min_mopt_qty'] > 0)?$mopt_available = true:$mopt_available = false;
							// Проверяем доступнось опта
							($item['price_opt'] > 0 && $item['inbox_qty'] > 0)?$opt_available = true:$opt_available = false;?>
							<div class="col-md-12 clearfix">
								<div class="product_section clearfix" id="product_<?=$item['id_product']?>">
									<div class="product_block">
										<div class="product_photo">
											<a href="<?=_base_url?>/product/<?=$item['id_product'].'/'.$item['translit']?>/">
												<div class="<?=$st['class']?>"></div>
												<?if(!empty($item['images'])){?>
													<img alt="<?=G::CropString($item['name'])?>" class="lazy" data-original="<?=_base_url.str_replace('original', 'thumb', $item['images'][0]['src']);?>"/>
													<noscript>
														<img alt="<?=G::CropString($item['name'])?>" src="<?=_base_url.str_replace('original', 'thumb', $item['images'][0]['src']);?>"/>
													</noscript>
												<?}else{?>
													<img alt="<?=G::CropString($item['name'])?>" class="lazy" data-original="<?=_base_url.($item['img_1'])?htmlspecialchars(str_replace("/image/", "/image/250/", $item['img_1'])):"/images/nofoto.jpg"?>"/>
													<noscript>
														<img alt="<?=G::CropString($item['name'])?>" src="<?=_base_url.($item['img_1'])?htmlspecialchars(str_replace("/image/", "/image/250/", $item['img_1'])):"/images/nofoto.jpg"?>"/>
													</noscript>
												<?}?>
											</a>
										</div>
										<div class="product_name p<?=$item['id_product']?>">
											<a href="<?=_base_url?>/product/<?=$item['id_product'].'/'.$item['translit']?>/" class="cat_<?=$item['id_product']?>"><?=G::CropString($item['name'])?></a>
										</div>
										<p class="product_article"><!--noindex-->арт. <!--/noindex--><?=$item['art']?></p>
									</div>
									<?$in_cart = false;
									if(isset($_SESSION['cart']['products'][$item['id_product']])){
										$in_cart = true;
									}
									$a = explode(';', $GLOBALS['CONFIG']['correction_set_'.$item['mopt_correction_set']]);
									?>
									<div class="product_buy" data-idproduct="<?=$item['id_product']?>">
										<div class="buy_block">
											<div class="active_price">
												<?if($item['price_opt'] == 0 && $item['price_mopt'] == 0){?>
													<span><b><!--noindex-->---<!--/noindex--></b></span>
													<input class="opt_cor_set_js" type="hidden" value="<?=$GLOBALS['CONFIG']['correction_set_'.$item['opt_correction_set']]?>">
													<input class="price_opt_js" type="hidden" value="<?=$item['price_opt']?>">
												<?}else{?>
													<input class="opt_cor_set_js" type="hidden" value="<?=$GLOBALS['CONFIG']['correction_set_'.$item['opt_correction_set']]?>">
													<input class="price_opt_js" type="hidden" value="<?=$item['price_opt']?>">
													<span class="price_js"><?=$in_cart?number_format($_SESSION['cart']['products'][$item['id_product']]['actual_prices'][$_COOKIE['sum_range']], 2, ".", ""):number_format($item['price_opt']*$a[$_COOKIE['sum_range']], 2, ".", "");?></span>
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
												<span class="price_js"><?=$in_cart?number_format($_SESSION['cart']['products'][$item['id_product']]['other_prices'][$_COOKIE['sum_range']], 2, ".", ""):number_format($item['price_mopt']*$a[$_COOKIE['sum_range']], 2, ".", "");?></span>
												<!--noindex--> грн.<!--/noindex-->
												<span class="mode_js"><?=$in_cart && $_SESSION['cart']['products'][$item['id_product']]['mode'] == 'mopt'?'от':'до';?></span>
												<?=($item['inbox_qty'].' '.$item['units']);?>
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
										<form action="" class="note <?=$item['note_control'] != 0?'note_control':null?>" data-note="<?=$item['id_product']?>">
											<textarea cols="30" rows="3" placeholder="Примечание к заказу"><?=isset($_SESSION['cart']['products'][$item['id_product']]['note'])?$_SESSION['cart']['products'][$item['id_product']]['note']:null?></textarea>
											<label class="info_key">?</label>
											<div class="info_description">
												<p>Поле для ввода примечания к товару.<br>
													<?if($item['note_control'] != 0){?>
														<b>Обязательное</b> для заполнения!
													<?}?>
												</p>
											</div>
										</form>
									</div>
									<!-- <div class="specifications">
										<ul>
											<li><span class="spec">Lorem ipsum dolor sit amet.</span><span class="unit">amet</span></li>
											<li><span class="spec">Lorem ipsum dolor sit amet.</span><span class="unit">amet</span></li>
											<li><span class="spec">Lorem ipsum dolor sit amet.</span><span class="unit">amet</span></li>
											<li><span class="spec">Lorem ipsum dolor sit amet.</span><span class="unit">amet</span></li>
											<li><span class="spec">Lorem ipsum dolor sit amet.</span><span class="unit">amet</span></li>
										</ul>
									</div> -->
								</div>
							</div>
						<?}?>
						<div class="preview ajax_loading">
							<div class="preview_content">
								<div class="col-md-6">
									<div id="owl-product_slide_js"></div>
									<div id="owl-product_slideDown_js"></div>
								</div>
								<div class="preview_info col-md-6">
									<h4></h4>
									<p class="product_article"><!--noindex-->aрт. <!--/<noindex--><span></span></p>
									<p class="product_description"></p>
									<div class="product_buy">
										<div class="buy_block">
											<div class="active_price">
												<span class="price_js"></span>
												<!--noindex--> грн.<!--/noindex-->
											</div>
											<div class="buy_buttons">
												<!--удаление товара оптом из корзины-->
												<a href="#" class="icon-font" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 0);return false;">remove</a>
												<input type="text" class="qty_js" value="0">
												<a href="#"	class="icon-font" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1);return false;">add</a>
												<!--количество заказываемых товаров-->
											</div>
											<div class="buy_btn_block">
												<button class="btn-m-orange buy_btn_js" type="button">Купить</button>
												<a href="<?=_base_url?>/cart/" class="in_cart_js hidden<?=G::IsLogged()?null:' open_modal" data-target="login_form';?>" title="Перейти в корзину">В корзине</a>
												<span class="not_available">Товара нет в наличии</span>
											</div>
										</div>
										<div class="other_price">
											<span class="price_js"></span>
											<!--noindex--> грн.<!--/noindex-->
											<span class="mode_js"></span>
											<span class="units_js"></span>
											<p class="qty_descr"></p>
										</div>
									</div>
									<div class="row">
										<div class="specifications col-md-6 hidden">
											<ul>
												<li><span class="spec"></span><span class="unit"></span></li>
												<li><span class="spec"></span><span class="unit"></span></li>
												<li><span class="spec"></span><span class="unit"></span></li>
												<li><span class="spec"></span><span class="unit"></span></li>
												<li><span class="spec"></span><span class="unit"></span></li>
											</ul>
											<a href="#" class="all_specifications">Все характеристики</a>
										</div>
										<div class="product_info col-md-6">
											<div class="preview_favorites">
												<span class="icon-font favorite"></span>
												<a href="#">В избранное</a>
											</div>
											<div class="preview_follprice">
												<p><span class="icon-font">Line</span><a href="#">Следить за ценой</a></p>
												<input type="hidden" name="reg" value="<?=isset($_SESSION['member']) && $_SESSION['member']['id_user'] != 4028?$_SESSION['member']['id_user']:null;?>">
												<div class="enter_mail">
													<form>
														<input name="user_email" type="email" placeholder="Введите email" autofocus required>
														<a href="#" id="cancel_follow_js" class="fright">Отмена</a>
														<button id="follow_price" type="submit" class="btn-s-green fleft">Подписаться</button>
													</form>
												</div>
											</div>
											<a href="#" class="rating">
												<ul class="rating_stars"></ul>
												<span class="comments"></span>
											</a>
											<div class="preview_socials">
												<a rel="nofollow" href="#" class="vk animate" title="Вконтакте" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
													<span class="icon-font">vk</span>
												</a>
												<a rel="nofollow" href="#" class="ok animate" title="Одноклассники" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
													<span class="icon-font">odnoklassniki</span>
												</a>
												<a rel="nofollow" href="#" class="ggl animate" title="Google+" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
													<span class="icon-font">g+</span>
												</a>
												<a rel="nofollow" href="#" class="fb animate" title="Facebook" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
													<span class="icon-font">facebook</span>
												</a>
												<a rel="nofollow" href="#" class="tw animate" title="Twitter" target="external" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
													<span class="icon-font">twitter</span>
												</a>
											</div>
										</div>
									</div>
									<!-- <form action="" class="note">
										<textarea cols="30" rows="3" placeholder="Примечание к заказу:"><?=isset($_SESSION['cart']['products'][$item['id_product']]['note_opt'])?$_SESSION['cart']['products'][$item['id_product']]['note_opt']:null?></textarea>
										<label class="info_key">?</label>
										<div class="info_description">
											<p>Поле для ввода примечания к товару</p>
										</div>
									</form> -->
									<a href="#" class="info_delivery">Информация о доставке</a>
								</div>
							</div>
							<div class="triangle"></div>
						</div>
						<?if(isset($cnt) && $cnt >= 30){?>
							<div class="sort_page sort_page_bottom">
								<?if($GLOBALS['CurrentController'] == 'search'){?>
									<a href="<?=_base_url?>/search/limitall/" <?=(isset($_GET['limit'])&&$_GET['limit']=='all')?'class="active"':null?>>Показать все</a>
								<?}else{?>
									<a href="<?=_base_url?>/products/<?=$curcat['id_category']?>/<?=$curcat['translit']?>/limitall/" <?=(isset($_GET['limit']) && $_GET['limit']=='all')?'class="active"':null?>>Показать все</a>
								<?}?>
							</div><!--class="sort_page"-->
							<?if($_GET['page_id'] != $pages_cnt && $GLOBALS['CurrentController'] !== 'search'){?>
								<p class="show_more"><a href="#" id="show_more_products">Показать еще 30 товаров</a></p>
							<?}?>
						<?}?>
					</div>
				</div>
				<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>
			<?}else{?>
				<div class="col-md-12">
					<!-- Конец строк товаров!-->
					<?if(isset($_SESSION['member']) && $_SESSION['member']['gid'] == _ACL_TERMINAL_){?>
						<h5>Товары из этого раздела доступны только по предварительному заказу.</h5>
					<?}else{?>
						<h5>Товаров нет</h5>
					<?}?>
				</div>
			<?}?>
		</div>
	<?}?>
</div><!--class="products"-->
<script>
	$(window).load(function(){
		$("html,body").trigger("scroll");
	});
	$(function(){
		<?if(isset($_COOKIE['product_view'])){?>
			ChangeView('<?=$_COOKIE['product_view']?>');
		<?}?>
		$("#view_block_js").removeClass('ajax_loading');

		var preview = $('.list_view .preview'),
			previewOwl = preview.find('#owl-product_slide_js'),
			previewDownOwl = preview.find('#owl-product_slideDown_js');

		ListenPhotoHover();//Инициализания Preview

		//Показать еще 30 товаров
		$('#show_more_products').on('click', function(){
			var page = $(this).closest('.products'),
				id_category = <?=isset($GLOBALS['CURRENT_ID_CATEGORY'])?$GLOBALS['CURRENT_ID_CATEGORY']:'null';?>,
				start_page = parseInt(page.find('.paginator li.active').first().text()),
				current_page = parseInt(page.find('.paginator li.active').last().text()),
				next_page = current_page+1,
				shown_products = (page.find('.product_section').get()).length,
				skipped_products = 30*(start_page-1),
				count = <?=isset($cnt)?$cnt:0;?>;
			$('.show_more').append('<span class="load_more"></span>');
			$.ajax({
				url: URL_base+"ajaxcat",
				type: "POST",
				data: ({
				 'action': 'getmoreproducts_desctop',
				 'id_category': id_category,
				 'shown_products': shown_products,
				 'skipped_products': skipped_products
				}),
		   	}).done(function(data){
		   		var product_view = $.cookie('product_view'),
		   			show_count = parseInt((count-30)-parseInt(skipped_products+shown_products));
		   			page.find('#view_block_js .preview').before(data);
		   		if(page.find('.paginator li.page'+next_page).length < 1){
					if(parseInt(count-parseInt(skipped_products+shown_products)+30) > 30){
						page.find('.paginator li.next_pages').addClass('active').find('a').attr('href','#');
					}else{
						page.find('.paginator li.last_page').addClass('active').find('a').attr('href','#');
					}
				}else{
					page.find('.paginator li.page'+next_page).addClass('active').find('a').attr('href','#');
				}

		   		if(show_count < 0){
		   			$('#show_more_products').hide();
		   		}

		   		if(product_view != 'list'){ //Инициализания модульного просмотра
		   			ChangeView('module');
		   		}

				ListenPhotoHover(); //Инициализания Preview

				//Инициализация добавления товара в избранное
				$('.preview_favorites').click(function(event) {
					id_product = $(this).attr('data-idfavorite');
					AddFavorite(event,id_product);
				});

				//Добавление товара в корзину
				$('.qty_js').on('change', function(){
					var id =  $(this).closest('.product_buy').attr('data-idproduct'),
						qty  = $(this).val(),
						note = $(this).closest('.product_section').find('.note textarea').val();
					SendToAjax (id,qty,false,false,note);
				});
				$('.buy_btn_js').on('click', function (){
					var id =  $(this).closest('.product_buy').attr('data-idproduct'),
						qty = $(this).closest('.product_buy').find('.qty_js').val(),
						note = $(this).closest('.product_section').find('.note textarea').val();
					SendToAjax (id,qty,false,false,note);
				});

				$('.load_more').remove();
		   });
		});

	});

</script>