<?foreach($list as $p){?>
	<div class="card clearfix">
		<div class="product_photo">
			<a href="#">
				<?if(!empty($p['images'])){?>
					<img alt="<?=G::CropString($p['id_product'])?>" class="lazy" data-original="<?=_base_url.str_replace('original', 'thumb', $p['images'][0]['src']);?>"/>
					<noscript>
						<img alt="<?=G::CropString($p['id_product'])?>" src="<?=_base_url.str_replace('original', 'thumb', $p['images'][0]['src']);?>"/>
					</noscript>
				<?}else{?>
					<img alt="<?=G::CropString($p['id_product'])?>" class="lazy" data-original="<?=_base_url.($p['img_1'])?htmlspecialchars(str_replace("/image/", "/image/250/", $p['img_1'])):"/images/nofoto.jpg"?>"/>
					<noscript>
						<img alt="<?=G::CropString($p['id_product'])?>" src="<?=_base_url.($p['img_1'])?htmlspecialchars(str_replace("/image/", "/image/250/", $p['img_1'])):"/images/nofoto.jpg"?>"/>
					</noscript>
				<?}?>
			</a>
		</div>
		<p class="product_name"><a href="<?=Link::Product($p['translit']);?>"><?=G::CropString($p['name'])?></a> <span class="product_article">Арт: <?=$p['art'];?></span></p>
		<div class="product_buy" data-idproduct="<?=$p['id_product']?>">
			<div class="buy_block">
				<p class="price"><?=number_format($p['price_opt'], 2, ',', '')?></p>
				<?if($GLOBALS['CurrentController'] != 'main'){?>
					<div class="btn_remove">
						<button class="mdl-button mdl-js-button material-icons" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 0);return false;">remove</button>
					</div>
					<input hidden type="text" class="qty_js_old" value="<?=isset($_SESSION['cart']['products'][$p['id_product']]['quantity'])?$_SESSION['cart']['products'][$p['id_product']]['quantity']:$p['inbox_qty']?>">
					<input type="number" class="qty_js" value="<?=isset($_SESSION['cart']['products'][$p['id_product']]['quantity'])?$_SESSION['cart']['products'][$p['id_product']]['quantity']:$p['inbox_qty']?>" onchange="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null);return false;" min="0" step="<?=$p['min_mopt_qty'];?>">
					<div class="btn_buy">
						<?if(isset($_SESSION['cart']['products'][$p['id_product']])){?>
							<button class="mdl-button mdl-js-button material-icons in_cart_js" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1); return false;">add</button>
							<button class="mdl-button mdl-js-button buy_btn_js hidden" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null); return false;">Купить</button>
						<?}else{?>
							<button class="mdl-button mdl-js-button material-icons in_cart_js hidden" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1); return false;">add</button>
							<button class="mdl-button mdl-js-button buy_btn_js" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null); return false;">Купить</button>
						<?}?>
					</div>
				<?}?>
			</div>
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