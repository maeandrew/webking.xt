<div class="mdl-grid" style="overflow: hidden;">
	<?$Status = new Status();
	$st = $Status->GetStstusById($product['id_product']);
	// Проверяем доступнось розницы
	($product['price_mopt'] > 0 && $product['min_mopt_qty'] > 0)?$mopt_available = true:$mopt_available = false;
	// Проверяем доступнось опта
	($product['price_opt'] > 0 && $product['inbox_qty'] > 0)?$opt_available = true:$opt_available = false;?>

	<div class="mdl-cell mdl-cell--12-col">
		<a href="<?=Link::Product($product['translit']);?>"><?=G::CropString($product['name'])?></a>
	</div>
	<div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-tablet">
		<!-- <p class="product_article">Арт: <?=$product['art']?></p> -->
		<div id="owl-product_slide_js">
			<?if(!empty($product['images'])){
				foreach($product['images'] as $i => $image){?>
					<div class="item">
						<img src="<?=file_exists($GLOBALS['PATH_root'].str_replace('original', 'thumb', $image['src']))?_base_url.str_replace('original', 'thumb', $image['src']):'/efiles/nofoto.jpg'?>" alt="<?=$product['name']?>"<?=$i==0?' class="act_img"':null;?>>
					</div>
				<?}
			}else{
				for($i=1; $i < 4; $i++){
					if(!empty($product['img_'.$i])){?>
						<div class="item">
							<img src="<?=file_exists($GLOBALS['PATH_root'].$product['img_'.$i])?_base_url.str_replace('/efiles/', '/efiles/_thumb/', $product['img_'.$i]):'/efiles/nofoto.jpg'?>" alt="<?=$product['name']?>"<?=$i==1?' class="active_img"':null;?>>
						</div>
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
				$a = explode(';', $GLOBALS['CONFIG']['correction_set_'.$product['opt_correction_set']]);
			?>
			<div class="product_buy clearfix" data-idproduct="<?=$product['id_product']?>"  style="overflow: hidden;">
				<p class="price"><?=$in_cart?number_format($_SESSION['cart']['products'][$product['id_product']]['actual_prices'][$_COOKIE['sum_range']], 2, ".", ""):number_format($product['price_opt']*$a[$_COOKIE['sum_range']], 2, ".", "");?></p>
				<div class="buy_block">
					<div class="btn_remove">
						<button class="mdl-button material-icons" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 0);return false;">remove</button>
					</div>
					<input type="text" class="qty_js" value="<?=!$in_cart?$product['inbox_qty']:$_SESSION['cart']['products'][$product['id_product']]['quantity'];?>">
					<?if(!$in_cart){?>
						<div class="btn_buy">
							<button class="mdl-button mdl-js-button buy_btn_js" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1);return false;">Купить</button>
						</div>
					<?}else{?>
						<div class="btn_buy">
							<button class="mdl-button mdl-js-button buy_btn_js" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1);return false;"><i class="material-icons">add</i></button>

						</div>
					<?}?>
				</div>
			</div>
			<div class="apps_panel mdl-cell--hide-phone">
				<ul>
					<li><i class="material-icons" title="Добавить товар в избранное"></i></li>
					<li><i class="material-icons" title="Следить за ценой"></i></li>
					<li><i class="material-icons" title="Поделиться"></i></li>
				</ul>
			</div>
		</div>
		<div class="rating_block">
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
		</div>

		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			<div class="tabs mdl-tabs__tab-bar mdl-color--grey-100">
				<a href="#specifications" class="mdl-tabs__tab is-active">Характеристики</a>
				<a href="#description" class="mdl-tabs__tab">Описание</a>
			</div>
			<div class="tab-content">
				<div id="specifications" class="mdl-tabs__panel is-active">
					<?if(isset($product['specifications']) && !empty($product['specifications'])){?>
						<table>
							<?foreach ($product['specifications'] as $s) {?>
								<!-- <td><span class="caption fleft"><?=$s['caption']?></span></td>
								<tr><span class="value fright"><?=$s['value'].'</tr><tr>'.$s['units']?></span></tr> -->
								<tr>
									<td width="62%"><span style="font-weight: bold;"><?=$s['caption']?></span></td>
									<td width="38%"><?=$s['value']?> <?=$s['units']?></td>
								</tr>
							<?}?>
						</table>
					<?}else{?>
						<p>К сожалению характеристики товара временно отсутствует.</p>
					<?}?>
				</div>
				<div id="description" class="mdl-tabs__panel">
					<?if(!empty($product['descr_xt_full'])){?>
						<p><?=$product['descr_xt_full']?></p>
					<?}else{?>
						<p>К сожалению описание товара временно отсутствует.</p>
					<?}?>
				</div>
			</div>
		</div>
</div>
<script>
	$(function(){
		//Слайдер миниатюр картинок
		$('#owl-product_mini_img_js .item').on('click', function(event) {
			var src = $(this).find('img').attr('src');
			var viewport_width = $(window).width();
			if(viewport_width > 711){
				$('#owl-product_mini_img_js').find('img').removeClass('act_img');
				$(this).find('img').addClass('act_img');
				// if(!(src.indexOf('nofoto') + 1)){
				//  src = src.replace('thumb', 'original');
				// }
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

</script>