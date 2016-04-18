<?if(!empty($list)){?>
	<div class="sorting">
		<!--Сортировка по названию !-->
		<?if(!isset($_GET['search_in_cat'])){?>
			<form action="" method="POST">
				<?if(in_array('sorting', $list_controls)){?>
					<label for="sort_prod">Сортировка</label>
					<select id="sort_prod" name="value" data-role="none" onchange="$(this).closest('form').submit();">
						<?foreach($available_sorting_values as $key => $alias){?>
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
	</div>
<?}?>
<div class="separateBlocks"></div>
<div class="products">
	<div class="card card_wrapper clearfix">
		<div class="product_photo card_item">Фото товара</div>
		<p class="product_name card_item">Наименование товара</p>
		<div class="suplierPriceBlock headerPriceBlock">
			<div class="price card_item">Цена<br>за еденицу товара</div>
			<div class="count_cell card_item">Минимальное<br>количество</div>
			<div class="count_cell card_item">Кол-во<br>в ящике</div>
			<div class="product_check card_item">Добавить в<br>ассортимент</div>
		</div>
	</div>
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
			<?if($_SESSION['member']['gid'] != _ACL_SUPPLIER_){?>
				<div class="product_buy" data-idproduct="<?=$p['id_product']?>">
					<p class="price"><?=number_format($p['price_mopt'], 2, ',', '')?></p>
					<div class="buy_block">
						<div class="btn_remove">
							<button class="mdl-button material-icons icon-font" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 0);return false;">
								remove
							</button>
						</div>
						<input type="text" class="qty_js" value="0" onchange="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null);return false;">
						<div class="btn_buy">
							<button class="mdl-button mdl-js-button buy_btn_js" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1);return false;">
								<?=isset($_SESSION['cart']['products'][$p['id_product']])?'+':'Купить'?>
							</button>
						</div>

						<!-- <input type="text" class="qty_js" value="<?=$_SESSION['cart']['products'][$p['id_product']]['quantity']?>">
						<div class="btn_buy">
							<button class="mdl-button mdl-js-button" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1);return false;"><i class="material-icons">add</i></button>
						</div> -->
					</div>
				</div>
			<?} else {?>
			<div class="suplierPriceBlock">
				<div class="price card_item"><p id="price_mopt_<?=$p['id_product']?>">
					<?if($p['price_opt_otpusk'] != 0){
						echo number_format($p['price_opt_otpusk'], 2, ".", "").' грн.';
					}else{
						echo number_format($p['price_mopt_otpusk'], 2, ".", "").' грн.';
					}?>
				</p></div>
				<div class="count_cell card_item">
					<p id="min_mopt_qty_<?=$p['id_product']?>"><?=$p['min_mopt_qty'].' '.$p['units']?><?=$p['qty_control']?" *":null?></p>
				</div>
				<div class="count_cell card_item">
					<p id="inbox_qty_<?=$p['id_product']?>"><?=$p['inbox_qty'].' '.$p['units']?></p>
				</div>

				<div class="product_check card_item">
					<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox_mopt_<?=$p['id_product']?>">
						<!-- <input type="checkbox" id="checkbox-2" class="mdl-checkbox__input"> -->
						<input type="checkbox" class="check mdl-checkbox__input" id="checkbox_mopt_<?=$p['id_product']?>" <?=isset($_SESSION['Assort']['products'][$p['id_product']])?'checked=checked':null?> onchange="AddDelProductAssortiment(this,<?=$p['id_product']?>)"/>
					</label>
				</div>
			</div>
			<?}?>
		</div>
	<?}?>
</div>