<div class="mdl-grid" style="overflow: hidden;">
	<?$Status = new Status();
	$st = $Status->GetStstusById($product['id_product']);
	// Проверяем доступнось розницы
	($product['price_mopt'] > 0 && $product['min_mopt_qty'] > 0)?$mopt_available = true:$mopt_available = false;
	// Проверяем доступнось опта
	($product['price_opt'] > 0 && $product['inbox_qty'] > 0)?$opt_available = true:$opt_available = false;
	$product_mark = '';
	$interval = date_diff(date_create(date("Y-m-d", strtotime($product['create_date']))), date_create(date("Y-m-d")));
	if(in_array($product['opt_correction_set'], $GLOBALS['CONFIG']['promo_correction_set']) || in_array($product['mopt_correction_set'], $GLOBALS['CONFIG']['promo_correction_set'])) {
		$product_mark = 'action';
	}elseif ($product['prod_status'] == 3 && $interval->format('%a') < 30){
		$product_mark = 'new';
	}?>
	<!-- <div class="mdl-cell mdl-cell--12-col product_name">
		<a href="<?=Link::Product($product['translit']);?>"><?=G::CropString($product['name'])?></a>
	</div> -->
	<div class="mdl-cell mdl-cell--9-col mdl-cell--4-col-tablet">
		<!-- <p class="product_article">Арт: <?=$product['art']?></p> -->
		<!-- <div id="owl-product_slide_js">
			<?if(!empty($product['images'])){
				foreach($product['images'] as $i => $image){?>
					<img src="<?=G::GetImageUrl($image['src'], 'medium')?>" alt="<?=$product['name']?>"/>
				<?}
			}else{
				for($i=1; $i < 4; $i++){
					if(!empty($product['img_'.$i])){?>
						<img src="<?=G::GetImageUrl($product['img_'.$i], 'medium')?>"/>
					<?}
				}
			}?>
		</div> -->
		<div class="product_main_img mdl-cell--hide-tablet mdl-cell--hide-phone">
			<!-- <?if(!empty($product['images'])){?>
				<img class="main_img main_img_js" itemprop="image" alt="<?=G::CropString($product['id_product'])?>" src="<?=G::GetImageUrl($product['images'][0]['src'])?>"/>
			<?}else if(!empty($product['img_1'])){?>
				<img class="main_img main_img_js" itemprop="image" alt="<?=G::CropString($product['id_product'])?>" src="<?=G::GetImageUrl($product['img_1'])?>"/>
			<?}else{?>
				<img class="main_img main_img_js" itemprop="image" alt="<?=G::CropString($product['id_product'])?>" src="<?=G::GetImageUrl('/images/nofoto.png')?>"/>
			<?}?>
			<div id="mainVideoBlock" class="hidden">
				<iframe width="100%" height="100%" src="" frameborder="0" allowfullscreen></iframe>
			</div>
			<?if(isset($product_mark) && $product_mark !== '' && $product['active'] != 0){?>
				<div class="market_action">
					<img src="<?=G::GetImageUrl('/images/'.$product_mark.'.png')?>" alt="<?=$product_mark === 'action'?'акционный товар':'новый товар'?>">
				</div>
			<?}?> -->
			<!-- <div id="owl-product_mini_img_js">
				<?if(!empty($product['images'])){
					foreach($product['images'] as $i => $image){?>
						<img src="<?=G::GetImageUrl($image['src'], 'thumb')?>" alt="<?=htmlspecialchars($product['name'])?>"<?=$i==0?'class="act_img"':'class=""';?>>
					<?}
				}else{
					for($i=1; $i < 4; $i++){
						if(!empty($product['img_'.$i])){?>
							<img src="<?=G::GetImageUrl($product['img_'.$i], 'thumb')?>" alt="<?=htmlspecialchars($product['name'])?>"<?=$i==1?' class="act_img"':'class=""';?>>
						<?}
					}
				}?>
				<?if(!empty($product['videos'])){
					foreach($product['videos'] as $i => $video){?>
						<div class="videoBlock">
							<div class="videoBlockShield"></div>
							<iframe width="120" height="90" src="<?=str_replace('watch?v=', 'embed/', $video)?>" frameborder="0" allowfullscreen alt="<?=htmlspecialchars($product['name'])?>">
							</iframe>
						</div>
					<?}
				}?>
			</div> -->


			<div id="big_photos_carousel_js" class="carousel big_photos_carousel">
				<?if(!empty($product['images'])){
					foreach($product['images'] as $i => $image){?>
						<img src="<?=G::GetImageUrl($image['src'])?>" alt="<?=htmlspecialchars($product['name'])?>">
					<?}
				}else{
					for($i=1; $i < 4; $i++){
						if(!empty($product['img_'.$i])){?>
							<img src="<?=G::GetImageUrl($product['img_'.$i])?>" alt="<?=htmlspecialchars($product['name'])?>">
						<?}
					}
				}?>
				<?if(!empty($product['videos'])){
					foreach($product['videos'] as $i => $video){?>
						<div class="item-video"><a class="owl-video" href="<?=$video?>"></a></div>
					<?}
				}?>
			</div>
		</div>
	</div>
	<div>
		<input type="hidden" class="path_root_js" value="<?=$GLOBALS['PATH_root']?>">
		<input type="hidden" class="path_product_img_js" value="<?=$GLOBALS['PATH_product_img']?>">
	</div>
	<div class="mdl-cell mdl-cell--3-col mdl-cell--4-col-tablet">
		<div class="pb_wrapper">
			<?$in_cart = false;
			if(!empty($_SESSION['cart']['products'][$product['id_product']])){
				$in_cart = true;
			}
			$a = explode(';', $GLOBALS['CONFIG']['correction_set_'.$product['opt_correction_set']]);?>
			<?if($product['active'] == 0){?>
				<div class="notAval">Нет в наличии</div>
			<?}else{?>
				<a class="product_name" href="<?=Link::Product($product['translit']);?>"><?=G::CropString($product['name'])?></a>
				<div class="product_buy" data-idproduct="<?=$product['id_product']?>">
					<div class="buy_block">
						<div class="product_price">
							<div class="price <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>" itemprop="price" content="<?=$in_cart?number_format($_SESSION['cart']['products'][$product['id_product']]['actual_prices'][$_COOKIE['sum_range']], 2, ".", ""):number_format($product['price_opt']*$a[$_COOKIE['sum_range']], 2, ".", "");?>"><?=$in_cart?number_format($_SESSION['cart']['products'][$product['id_product']]['actual_prices'][$_COOKIE['sum_range']], 2, ",", ""):number_format($product['price_opt']*$a[$_COOKIE['sum_range']], 2, ",", "");?></div>
							<span class="<?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>">грн.</span>
						</div>
						<div class="prodPrices hidden">
							<div class="itemProdQty"><?=$product['min_mopt_qty']?></div>
							<?for($i = 0; $i < 4; $i++){?>
								<input class="priceOpt<?=$i?>" value="<?=$product['prices_opt'][$i]?>">
								<input class="priceMopt<?=$i?>" value="<?=$product['prices_mopt'][$i]?>">
							<?}?>
						</div>
						<div class="btn_buy <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>">
							<div id="in_cart_<?=$product['id_product'];?>" class="btn_js in_cart_js <?=isset($_SESSION['cart']['products'][$product['id_product']])?null:'hidden';?>" data-name="cart"><i class="material-icons">shopping_cart</i><!-- В корзине --></div>
							<div class="mdl-tooltip" for="in_cart_<?=$product['id_product'];?>">Товар в корзине</div>
							<button class="mdl-button mdl-js-button buy_btn_js <?=isset($_SESSION['cart']['products'][$product['id_product']])?'hidden':null;?>" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null); return false;">Купить</button>
						</div>
						<div class="quantity <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>">
							<!-- <button id="preview_btn_add<?=$product['id_product']?>" class="material-icons btn_add btn_qty_js"	onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1); return false;">add</button>
							<div class="mdl-tooltip mdl-tooltip--top tooltipForBtnAdd_js hidden" for="preview_btn_add<?=$product['id_product']?>">Больше</div>
							<input type="text" class="minQty hidden" value="<?=$product['inbox_qty']?>">
							<input type="text" class="qty_js" value="<?=isset($_SESSION['cart']['products'][$product['id_product']]['quantity'])?$_SESSION['cart']['products'][$product['id_product']]['quantity']:$product['inbox_qty']?>" onchange="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null);return false;">

							<button id="preview_btn_remove<?=$product['id_product']?>" class="material-icons btn_remove btn_qty_js" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 0);return false;">remove</button>
							<div class="mdl-tooltip tooltipForBtnRemove_js hidden" for="preview_btn_remove<?=$product['id_product']?>">Меньше</div>
							<div class="units"><?=$product['units'];?></div> -->
							<div class="quantityReverseBlock">
								<button id="btn_add<?=$product['id_product']?>" class="material-icons btn_add btn_qty_js"	onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1); return false;">add</button>
								<div class="mdl-tooltip mdl-tooltip--top tooltipForBtnAdd_js hidden" for="btn_add<?=$product['id_product']?>">Больше</div>

								<input type="text" class="minQty hidden" value="<?=$product['inbox_qty']?>">
								<input type="text" class="qty_js" value="<?=isset($_SESSION['cart']['products'][$product['id_product']]['quantity'])?$_SESSION['cart']['products'][$product['id_product']]['quantity']:$product['inbox_qty']?>">

								<button id="btn_remove<?=$product['id_product']?>" class="material-icons btn_remove btn_qty_js" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 0);return false;">remove</button>
								<div class="mdl-tooltip tooltipForBtnRemove_js hidden" for="btn_remove<?=$product['id_product']?>">Меньше</div>
							</div>
							<div class="units"><?=$product['units'];?></div>
						</div>
						<!-- Блок для поставщика -->
						<div class="supplier_block <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?null:'hidden'?>">
							<div class="price" itemprop="price" content="<?=$in_cart?number_format($_SESSION['cart']['products'][$product['id_product']]['actual_prices'][$_COOKIE['sum_range']], 2, ".", ""):number_format($product['price_opt']*$a[$_COOKIE['sum_range']], 2, ".", "");?>"><?=$in_cart?number_format($_SESSION['cart']['products'][$product['id_product']]['actual_prices'][$_COOKIE['sum_range']], 2, ",", ""):number_format($product['price_opt']*$a[$_COOKIE['sum_range']], 2, ",", "");?></div>
							<span>грн.</span>
							<div class="prodPrices hidden">
								<div class="itemProdQty"><?=$product['min_mopt_qty']?></div>
								<?for($i = 0; $i < 4; $i++){?>
									<input class="priceOpt<?=$i?>" value="<?=$product['prices_opt'][$i]?>">
									<input class="priceMopt<?=$i?>" value="<?=$product['prices_mopt'][$i]?>">
								<?}?>
							</div>
						</div>
					</div>
					<div class="priceMoptInf<?=($in_cart && $_SESSION['cart']['products'][$product['id_product']]['quantity'] < $product['inbox_qty'])?'':' hidden'?>">Малый опт</div>
				</div>
			<?}?>
		</div>
		<div class="add_to_fav_trend_block mdl-cell--hide-phone">
			<div class="favorite <?=isset($_SESSION['member']['favorites']) && in_array($product['id_product'], $_SESSION['member']['favorites'])?' added':null;?><?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?' hidden':null?>" data-id-product="<?=$product['id_product'];?>">
				<?if(isset($_SESSION['member']['favorites']) && in_array($product['id_product'], $_SESSION['member']['favorites'])) {?>
					<i id="preview_forfavorite_<?=$product['id_product']?>" class="isfavorite favorite_icon material-icons">favorite</i>
					<span class="mdl-tooltip" for="preview_forfavorite_<?=$product['id_product']?>">Товар уже <br> в избранном</span>
				<?}else{?>
					<i id="preview_forfavorite_<?=$product['id_product']?>" class="notfavorite favorite_icon material-icons">favorite_border</i>
					<span class="mdl-tooltip" for="preview_forfavorite_<?=$product['id_product']?>">Добавить товар <br> в избранное</span>
				<?}?>
			</div>
			<div class="fortrending <?=isset($_SESSION['member']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?' hidden':null?>" data-id-product="<?=$product['id_product'];?>" <?=isset($_SESSION['member'])?'data-id-user="'.$_SESSION['member']['id_user'].'" data-email="'.$_SESSION['member']['email'].'"':'';?>>
				<i id="preview_fortrending_<?=$product['id_product']?>" class="waiting_list icon material-icons <?=isset($_SESSION['member']['waiting_list']) && in_array($product['id_product'], $_SESSION['member']['waiting_list'])?'arrow':null;?>">trending_down</i>
				<span class="mdl-tooltip" for="preview_fortrending_<?=$product['id_product']?>"><?=isset($_SESSION['member']['waiting_list']) && in_array($product['id_product'], $_SESSION['member']['waiting_list'])?'Товар уже <br> в списке ожидания':'Следить за ценой';?></span>
			</div>
			<div class="share <?=isset($_SESSION['member']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?' hidden':null?>">
				<i id="shareButton" class="material-icons share_button" title="Поделиться">share</i>
				<span class="mdl-tooltip" for="shareButton">Поделиться</span>
			</div>
		<div id="socialShare" class="mdl-menu mdl-menu--bottom-right mdl-js-menu social" for="shareButton">
			<ul class="social">
				<li>
					<a href="http://vk.com/share.php?url=<?=Link::Product($product['translit']);?>&title=<?=htmlspecialchars($product['name'])?>&description=<?=strip_tags($product['descr'])?>&image=<?=G::GetImageUrl($product['img_1'])?>&noparse=true" target="_blank" class="vk" title="Вконтакте" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
						<img src="<?=$GLOBALS['URL_img_theme']?>vk.svg" alt="Вконтакте">
					</a>
				</li>
				<li>
					<a href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=<?=Link::Product($product['translit']);?>&st.comments=<?=htmlspecialchars($product['name'])?>" target="_blank" class="ok" title="Однокласники" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
						<img src="<?=$GLOBALS['URL_img_theme']?>odnoklassniki.svg" alt="Одноклаcсники">
					</a>
				</li>
				<li>
					<a href="https://plus.google.com/share?url=<?=Link::Product($product['translit']);?>" target="_blank" class="g_pl" title="google+" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
						<img src="<?=$GLOBALS['URL_img_theme']?>google-plus.svg" alt="google+">
					</a>
				</li>
				<li>
					<a href="http://www.facebook.com/sharer.php?u=<?=Link::Product($product['translit']);?>&title='<?=htmlspecialchars($product['name'])?>'&description=<?=strip_tags($product['descr'])?>&picture=<?=G::GetImageUrl($product['img_1'])?>" target="_blank" class="f" title="Facebook" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
						<img src="<?=$GLOBALS['URL_img_theme']?>facebook.svg" alt="Facebook">
					</a>
				</li>
				<li>
					<a href="https://twitter.com/share?url=<?=Link::Product($product['translit']);?>&text=<?=htmlspecialchars($product['name'])?>" target="_blank" class="tw" title="Twitter" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
						<img src="<?=$GLOBALS['URL_img_theme']?>twitter.svg" alt="Twitter">
					</a>
				</li>
			</ul>
		</div>
		</div>
		<!-- <div class="rating_block">
			<?if($product['c_rating'] > 0){?>
				<ul class="rating_stars" title="<?=$product['c_rating'] != ''?'Оценок: '.$product['c_mark']:'Нет оценок'?>">
					<?for($i = 1; $i <= 5; $i++){
						$star = 'star';
						if($i > floor($product['c_rating'])){
							if($i == ceil($product['c_rating'])){
								$star .= '_half';
							}else{
								$star .= '_border';
							}
						}?>
						<li><i class="material-icons"><?=$star?></i></li>
					<?}?>
				</ul>
			<?}?>
		</div> -->

		<div class="mdl-tabs mdl-js-tabs">
			<div class="tabs mdl-tabs__tab-bar mdl-color--grey-100">
				<a href="#specifications" class="mdl-tabs__tab is-active">Характеристики</a>
				<a href="#description" class="mdl-tabs__tab">Описание</a>
			</div>
			<div class="tab-content">
				<div id="specifications" class="mdl-tabs__panel is-active">
					<?if(isset($product['specifications']) && !empty($product['specifications'])){?>
						<!-- <ul>
							<?foreach($product['specifications'] as $s){?>
								<li><span class="caption fleft"><?=$s['caption']?></span><span class="value fright"><?=$s['value'].' '.$s['units']?></span></li>
							<?}?>
						</ul> -->
						<?foreach($product['specifications'] as $s){?>
							<div class="mdl-grid">
								<div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-tablet mdl-cell--2-col-phone"><?=$s['caption']?>:</div>
								<div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-tablet mdl-cell--2-col-phone"><?=$s['value'].(isset($s['units'])?' '.$s['units']:null)?></div>
							</div>
						<?}?>
					<?}else{?>
						<p>К сожалению характеристики товара временно отсутствует.</p>
					<?}?>

					<!-- <button id="btn1" class="mdl-button hidden" type="button">Подробнее</button> -->
				</div>
				<div id="description" class="mdl-tabs__panel">
					<?if(!empty($product['descr_xt_full'])){?>
						<p><?=$product['descr_xt_full']?></p>
					<?}else{?>
						<p>К сожалению описание товара временно отсутствует.</p>
					<?}?>
					<button id="btn2" class="mdl-button hidden" type="button">Подробнее</button>
				</div>
			</div>
		</div>
</div>

<script>
	//Инициализация owl carousel
	/*$('#owl-product_mobile_img_js').owlCarousel({
		center:			true,
		dots:			true,
		items:			1,
		lazyLoad:		true,
		loop:			true,
		margin:			20,
		nav:			true,
		video:			true,
		videoHeight:	345,
		videoWidth:		345,
		navText: [
			'<svg class="arrow_left"><use xlink:href="images/slider_arrows.svg#arrow_left_tidy"></use></svg>',
			'<svg class="arrow_right"><use xlink:href="images/slider_arrows.svg#arrow_right_tidy"></use></svg>'
		]
	});	*/
	// $("#owl-product_mini_img_js").owlCarousel({
	// 	dots:	false,
	// 	items:	5,
	// 	margin:	10,
	// 	nav:	true,
	// 	responsive: {
	// 		320:	{items: 1},
	// 		727:	{items: 2},
	// 		950:	{items: 3},
	// 		1250:	{items: 3},
	// 		1600:	{items: 5}
	// 	},
	// 	navText: [
	// 		'<svg class="arrow_left"><use xlink:href="images/slider_arrows.svg#arrow_left_tidy"></use></svg>',
	// 		'<svg class="arrow_right"><use xlink:href="images/slider_arrows.svg#arrow_right_tidy"></use></svg>'
	// 	]
	// });

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

	$(function(){
		//Слайдер миниатюр картинок
		// $('#owl-product_mini_img_js .item').on('click', function(event) {
		// 	var src = $(this).find('img').attr('src');
		// 	var viewport_width = $(window).width();
		// 	if(viewport_width > 711){
		// 		$('#owl-product_mini_img_js').find('img').removeClass('act_img');
		// 		$(this).find('img').addClass('act_img');
		// 		if(src.indexOf("<?=str_replace(DIRSEP, '/', str_replace($GLOBALS['PATH_root'], '', $GLOBALS['PATH_product_img']));?>") > -1){
		// 			src = src.replace('thumb', 'original');
		// 		}else{
		// 			src = src.replace('_thumb/', '');
		// 		}
		// 		$('.product_main_img').find('img').attr('src', src);
		// 		$('.product_main_img').hide().fadeIn('100');
		// 	}else{
		// 		event.preventDefault();
		// 	}
		// });
	});
	// $(".tab-content .mdl-button").click(function(event){
	// 	$(this).addClass('hidden').parent().css("height","auto");
	// });
	// $(".mdl-tabs__panel").each(function(index, el){
	// 	if ($(el).height() > 150 ) {
	// 		$(el).css({
	// 			'height': '175',
	// 			'overflow': 'hidden'
	// 		});
	// 		$(el).find('.mdl-button').removeClass('hidden');
	// 	}
	// });
</script>