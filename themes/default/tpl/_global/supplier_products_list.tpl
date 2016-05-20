<?foreach($list as $p){ ?>
	<div class="card clearfix">
		<div class="product_photo card_item">
			<a href="#">
				<?if(!empty($p['images'])){?>
					<img alt="<?=G::CropString($p['name'])?>" class="lazy" data-original="http://lorempixel.com/120/90/"/>
					<!-- <img alt="<?=G::CropString($p['name'])?>" class="lazy" data-original="<?=_base_url.str_replace('original', 'thumb', $p['images'][0]['src']);?>"/> -->
					<noscript>
						<img alt="<?=G::CropString($p['name'])?>" src="<?=_base_url.str_replace('original', 'thumb', $p['images'][0]['src']);?>"/>
					</noscript>
				<?}else{?>
					<img alt="<?=G::CropString($p['name'])?>" class="lazy" data-original="http://lorempixel.com/120/90/"/>
					<!-- <img alt="<?=G::CropString($p['name'])?>" class="lazy" data-original="<?=_base_url.($p['img_1'])?htmlspecialchars(str_replace("/image/", "/image/250/", $p['img_1'])):"/images/nofoto.jpg"?>"/> -->
					<noscript>
						<img alt="<?=G::CropString($p['name'])?>" src="<?=_base_url.($p['img_1'])?htmlspecialchars(str_replace("/image/", "/image/250/", $p['img_1'])):"/images/nofoto.jpg"?>"/>
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
				<span>Минимальное кол-во:</span>
				<p id="min_mopt_qty_<?=$p['id_product']?>"><?=$p['min_mopt_qty'].' '.$p['units']?><?=$p['qty_control']?" *":null?></p>			
			</div>
			<div class="count_cell card_item">
				<span>Количество в ящике:</span>
				<p id="inbox_qty_<?=$p['id_product']?>"><?=$p['inbox_qty'].' '.$p['units']?></p>
			</div>

			<div class="product_check card_item">
				<span>Добавить:</span>			
				<label  class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox_mopt_<?=$p['id_product']?>">				
					<!-- <input type="checkbox" id="checkbox-2" class="mdl-checkbox__input"> -->
					<input type="checkbox" class="check mdl-checkbox__input" id="checkbox_mopt_<?=$p['id_product']?>" <?=isset($_SESSION['Assort']['products'][$p['id_product']])?'checked=checked':null?> onchange="AddDelProductAssortiment(this,<?=$p['id_product']?>)"/>
				</label>				
			</div>

		</div>
	</div>
<?}?>