<div class="products">
	<?foreach($list as $p){
		print_r('<!--');
		print_r($p);
		print_r('-->');
		?>
		<div class="card clearfix">
			<div class="product_photo">
				<a href="#">
					<?if(!empty($p['images'])){?>
						<!-- <img alt="<?=G::CropString($p['name'])?>" class="lazy" data-original="http://lorempixel.com/500/500/"/> -->
						<img alt="<?=G::CropString($p['name'])?>" class="lazy" data-original="<?=_base_url.str_replace('original', 'thumb', $p['images'][0]['src']);?>"/>
						<noscript>
							<img alt="<?=G::CropString($p['name'])?>" src="<?=_base_url.str_replace('original', 'thumb', $p['images'][0]['src']);?>"/>
						</noscript>
					<?}else{?>
						<!-- <?=_base_url.htmlspecialchars(str_replace("/image/", "/image/250/", $p['img_1']));?> -->
						<!-- <img alt="<?=G::CropString($p['name'])?>" class="lazy" data-original="http://lorempixel.com/500/500/"/> -->
						<img alt="<?=G::CropString($p['name'])?>" class="lazy" data-original="<?=_base_url.($p['img_1'])?htmlspecialchars(str_replace("/image/", "/image/250/", $p['img_1'])):"/images/nofoto.jpg"?>"/>
						<noscript>
							<img alt="<?=G::CropString($p['name'])?>" src="<?=_base_url.($p['img_1'])?htmlspecialchars(str_replace("/image/", "/image/250/", $p['img_1'])):"/images/nofoto.jpg"?>"/>
						</noscript>
					<?}?>
				</a>
			</div>
			<p class="product_name"><a href="<?=Link::Product($p['translit']);?>"><?=G::CropString($p['name'])?></a> <span class="product_article">Арт: <?=$p['art'];?></span></p>
			<div class="product_buy" data-idproduct="<?=$p['id_product']?>">
				<p class="price"><?=number_format($p['price_opt'], 2, ',', '')?></p>
				<?if($GLOBALS['CurrentController'] != 'main'){?>
					<div class="buy_block">
						<div class="btn_remove">
							<div id="t_<?=$p['name']?>" class="icon material-icons">

							<!-- <label class="info_key hidden" style="top: 6px;opacity: 0; border-radius: 0;width: 38px;height: 22px;"></label> -->
							<label>
								<button class="mdl-button material-icons icon-font" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 0);return false;">remove</button>
							</label>
							<div class="info_description hidden" style="width: 292px;left: -252px;top: 40px;">
								<p>При нажатии базовая стоимость уменьшится</p>
							</div>
							</div>
							<div class="mdl-tooltip hidden" for="t_<?=$p['name']?>">Do not user! Stoped
							</div>
						</div>
						<input hidden type="text" class="qty_js_old" value="<?=isset($_SESSION['cart']['products'][$p['id_product']]['quantity'])?$_SESSION['cart']['products'][$p['id_product']]['quantity']:$p['inbox_qty']?>">


						<input type="text" class="qty_js" value="<?=isset($_SESSION['cart']['products'][$p['id_product']]['quantity'])?$_SESSION['cart']['products'][$p['id_product']]['quantity']:$p['inbox_qty']?>" onchange="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null);return false;">
						<div class="btn_buy">
							<label id="p_<?=$p['name']?>">
								<button class="mdl-button mdl-js-button buy_btn_js" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1);return false;">
									<?=isset($_SESSION['cart']['products'][$p['id_product']])?'+':'Купить'?>
								</button>
							</label>
							<div class="info_description hidden" style="width: 292px;left: -252px;top: 40px;">
								<p>При нажатии базовая стоимость увеличится</p>
							</div>
							<div class="mdl-tooltip hidden" for="p_<?=$p['name']?>">Es es do not Stoped!
							</div>
						</div>

						<!-- <input type="text" class="qty_js" value="<?=$_SESSION['cart']['products'][$item['id_product']]['quantity']?>">
						<div class="btn_buy">
							<button class="mdl-button mdl-js-button" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1);return false;"><i class="material-icons">add</i></button>
							</div> -->
					</div>
				<?}?>
			</div>
			<div class="product_info clearfix">
				<div class="note clearfix">
					<textarea placeholder="Примечание: "></textarea>
					<label class="info_key">?</label>
					<div class="info_description">
						<p>Поле для ввода примечания к товару.</p>
					</div>
				</div>
			</div>
		</div>
	<?}?>
</div>