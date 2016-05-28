<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
	<thead>
		<tr>
			<th class="mdl-data-table__cell--non-numeric"><div class="">
				<div class="avatar">
					<!-- <img alt="<?=G::CropString($product['name'])?>" src="<?=_base_url.str_replace('original', 'thumb', $product['img_1']);?>"/> -->
				</div>
			</th>
			<th class="mdl-data-table__cell--non-numeric">Наименование товара</th>
			<th>Цена</th>
			<th>Количество</th>
			<th>Cумма</th>
		</tr>
	</thead>
	<?foreach ($list as $item) {?>
		<!-- 	if($item['opt_qty'] > 0){
			$mode = 'opt';
		}else{
			$mode = 'mopt';
		}?>		-->
		<tbody>
			<tr>
				<td class="mdl-data-table__cell--non-numeric">
					<div class="avatar">
						<?if(!empty($item['img'])){?>						<!-- http://xt.ua -->
							<img alt="<?=G::CropString($item['id_product'])?>" src="<?_base_url?><?=file_exists($GLOBALS['PATH_root'].str_replace('original', 'small', $item['images'][0]['src']))?str_replace('original', 'small', $item['images'][0]['src']):'/efiles/_thumb/nofoto.jpg'?>"/>
						<?}else{ ?>
							<img alt="<?=G::CropString($item['id_product'])?>" src="<?_base_url?><?=$item['img_1']?htmlspecialchars(str_replace("/image/", "/image/250/", $item['img_1'])):"/images/nofoto.jpg"?>"/>
						<?}?>
						<!-- <img src="http://lorempixel.com/fashion/70/70/" alt="avatar" /> -->
					</div>

				</td>
				<td class="mdl-data-table__cell--non-numeric"><div><?=$item['name'];?></div></td>
				<!--  <td><div class="cent"><?=$item['site_price_'.$mode]?></div></td>
				<td><div class="cent"><?=$item[$mode.'_qty'];?></div></td>
				<td><div class="cent"><?=$item[$mode.'_sum'];?></div></td> -->
				<td><div class="cent"><?=$item['base_price']?></div></td>
				<td><div class="cent"><?=$item['quantity'];?></div></td>
				<td><div class="cent"><?=$item['cart_price'];?></div></td>
			</tr>
		</tbody>
	<?}?>
</table>