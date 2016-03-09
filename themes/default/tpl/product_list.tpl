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
<div class="products">
	<?foreach($list as $p){?>
		<div class="card clearfix">
			<div class="product_photo">
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
			<p class="product_name"><a href="<?=Link::Product($p['translit']);?>"><?=G::CropString($p['name'])?></a> <span class="product_article">Арт: <?=$p['art'];?></span></p>
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

						<!-- <input type="text" class="qty_js" value="<?=$_SESSION['cart']['products'][$item['id_product']]['quantity']?>">
						<div class="btn_buy">
							<button class="mdl-button mdl-js-button" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1);return false;"><i class="material-icons">add</i></button>
						</div> -->

					</div>
				</div>
			<?}?>
			<?if($_SESSION['member']['gid'] == _ACL_SUPPLIER_){?>
				<div class="product_check" style="float: right;">
					<input type="checkbox" name="product_ch">
					<label for="product_ch">добавить в ассортимент</label>
				</div>
			<?}?>
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
<script>

</script>