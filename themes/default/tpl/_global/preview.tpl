<div class="mdl-grid" style="overflow: hidden;">
	<?$Status = new Status();
	$st = $Status->GetStstusById($product['id_product']);
	// Проверяем доступнось розницы
	($product['price_mopt'] > 0 && $product['min_mopt_qty'] > 0)?$mopt_available = true:$mopt_available = false;
	// Проверяем доступнось опта
	($product['price_opt'] > 0 && $product['inbox_qty'] > 0)?$opt_available = true:$opt_available = false;?>

	<div class="mdl-cell mdl-cell--12-col product_name">
		<a href="<?=Link::Product($product['translit']);?>"><?=G::CropString($product['name'])?></a>
	</div>
	<style>
		#caruselCont {
			width: 95%;
		}
		#specCont {
			width: 95%;
		} 
		.product_main_img{
			display: none;
		}
		.owl-video-wrapper {
			margin: 0 auto;
		}
		.product .mdl-cell {
			padding-right: 0;
		}
		.product_page h1 {
			margin: 0;
			padding: 0;
		}
		.breadcrumbs_wrapp {
			white-space: nowrap;
			overflow-x: overlay;
			overflow-y: hidden;
			padding-bottom: 10px;
		}
		.breadcrumbs_wrapp a {
			font-weight: 300;
		}
		.breadcrumbs_wrapp i {
			font-size: 18px;
			margin: 0;
		}
		.owl-pagination {
			padding: 5px 0;
		}		
		.mobile_carousel .owl-item img {
			max-width: 100%;
			margin: 0px auto;
			display: block;
		}
		.owl-dot {
			width: 20px;
		}
		.owl-dot span {
			display: block;
			width: 0;
			height: 0;
			background: #888;
			border-radius: 50%;
			margin: 0 auto;
			transition: all 0.4s ease-in-out;
			border: 3px solid #888;
		}
		.owl-dot.active span {
			border: 7px solid #888;
		}

		.mdl-tabs__tab-bar {
			min-width: none;
		}
		.tabs .mdl-tabs__tab {
			width: 50%;
			border-bottom: 1px solid #e0e0e0;
		}
		.mdl-grid .mdl-tabs__tab {
			margin-top: 0;
		}
		.fortabs {
			padding-bottom: 10px;
			overflow-x: overlay;
			overflow-y: hidden;
		}
		#owl-product_mobile_img_js {
			clear: both;
		}
		 #owl-product_mobile_img_js .owl-stage-outer {
			height: 325px;
		} 


		@media (min-width: 700px){
			.product .mdl-tabs__tab-bar {
				min-width: 680px;
			}
			.tabs .mdl-tabs__tab {
			width: 25%;
			}
		}
	</style>
	<script>
		$('#owl-product_mobile_img_js').owlCarousel({
			center:			true,
			dots:			true,
			items:			1,
			lazyLoad:		true,
			loop:			true,
			margin:			20,
			nav:			true,
			video:			true,			
			videoHeight:	300,
			videoWidth:		300,
			navText: [
				'<svg class="arrow_left"><use xlink:href="images/slider_arrows.svg#arrow_left_tidy"></use></svg>',
				'<svg class="arrow_right"><use xlink:href="images/slider_arrows.svg#arrow_right_tidy"></use></svg>'
			]
		});	
	</script>
	<div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-tablet">
		<!-- <p class="product_article">Арт: <?=$product['art']?></p> -->
		<div id="owl-product_mobile_img_js">
			<?if(!empty($product['images'])){
				foreach($product['images'] as $i => $image){?>
					<img src="<?=_base_url?><?=file_exists($GLOBALS['PATH_root'].str_replace('original', 'medium', $image['src']))?str_replace('original', 'medium', $image['src']):'/images/nofoto.png'?>" alt="<?=$product['name']?>">
				<?}
			}else{
				for($i=1; $i < 4; $i++){
					if(!empty($product['img_'.$i])){?>
						<img src="<?=_base_url?><?=$product['img_'.$i]?str_replace("/image/", "/image/500/", $product['img_'.$i]):'/images/nofoto.png'?>" alt="<?=$product['name']?>">
					<?}
				}
			}?>
		</div>
	</div>
	<div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-tablet">
		<div class="pb_wrapper">
			<?$in_cart = false;
			if(!empty($_SESSION['cart']['products'][$product['id_product']])){
				$in_cart = true;
			}
			$a = explode(';', $GLOBALS['CONFIG']['correction_set_'.$product['opt_correction_set']]);?>
			<div class="product_buy" data-idproduct="<?=$product['id_product']?>">
				<div class="buy_block">
					<div class="price">
						<?=$in_cart?number_format($_SESSION['cart']['products'][$product['id_product']]['actual_prices'][$_COOKIE['sum_range']], 2, ".", ""):number_format($product['price_opt']*$a[$_COOKIE['sum_range']], 2, ".", "");?>
					</div>
					<div class="btn_buy">
						<div id="in_cart_<?=$product['id_product'];?>" class="btn_js in_cart_js <?=isset($_SESSION['cart']['products'][$product['id_product']])?null:'hidden';?>" data-name="cart"><i class="material-icons">shopping_cart</i><!-- В корзине --></div>
						<div class="mdl-tooltip" for="in_cart_<?=$product['id_product'];?>">Товар в корзине</div>
						<button class="mdl-button mdl-js-button buy_btn_js <?=isset($_SESSION['cart']['products'][$product['id_product']])?'hidden':null;?>" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null); return false;">Купить</button>
					</div>
					<div class="quantity">
						<button class="material-icons btn_add"	onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1); return false;">add</button>
						<input type="text" class="qty_js" value="<?=isset($_SESSION['cart']['products'][$product['id_product']]['quantity'])?$_SESSION['cart']['products'][$product['id_product']]['quantity']:$product['inbox_qty']?>" onchange="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null);return false;" min="0" step="<?=$product['min_mopt_qty'];?>">
						<button class="material-icons btn_remove" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 0);return false;">remove</button>
						<div class="units"><?=$product['units'];?></div>
					</div>
				</div>
			</div>
			<!-- <div class="apps_panel mdl-cell--hide-phone">
				<ul>
					<li><i class="material-icons" title="Добавить товар в избранное"></i></li>
					<li><i class="material-icons" title="Следить за ценой"></i></li>
					<li><i class="material-icons" title="Поделиться"></i></li>
				</ul>
			</div> -->
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

		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			<div class="tabs mdl-tabs__tab-bar mdl-color--grey-100">
				<a href="#specifications" class="mdl-tabs__tab is-active">Характеристики</a>
				<a href="#description" class="mdl-tabs__tab">Описание</a>
			</div>
			<div class="tab-content">
				<div id="specifications" class="mdl-tabs__panel is-active">
					<?if(isset($product['specifications']) && !empty($product['specifications'])){?>
						<ul>
							<?foreach($product['specifications'] as $s){?>
								<li><span class="caption fleft"><?=$s['caption']?></span><span class="value fright"><?=$s['value'].' '.$s['units']?></span></li>
							<?}?>
						</ul>
					<?}else{?>
						<p>К сожалению характеристики товара временно отсутствует.</p>
					<?}?>

					<button id="btn1" class="mdl-button hidden" type="button">Подробнее</button>
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
	$(function(){
		//Слайдер миниатюр картинок
		$('#owl-product_mini_img_js .item').on('click', function(event) {
			var src = $(this).find('img').attr('src');
			var viewport_width = $(window).width();
			if(viewport_width > 711){
				$('#owl-product_mini_img_js').find('img').removeClass('act_img');
				$(this).find('img').addClass('act_img');
				if(src.indexOf("<?=str_replace(DIRSEP, '/', str_replace($GLOBALS['PATH_root'], '', $GLOBALS['PATH_product_img']));?>") > -1){
					src = src.replace('thumb', 'original');
				}else{
					src = src.replace('_thumb/', '');
				}
				$('.product_main_img').find('img').attr('src', src);
				$('.product_main_img').hide().fadeIn('100');
			}else{
				event.preventDefault();
			}
		});
	});
	$(".tab-content .mdl-button").click(function(event){
		$(this).addClass('hidden').parent().css("height","auto");
	});
	$(".mdl-tabs__panel").each(function(index, el){
		if ($(el).height() > 150 ) {
			$(el).css({
				'height': '150',
				'overflow': 'hidden'
			});
			$(el).find('.mdl-button').removeClass('hidden');
		}
	});
</script>