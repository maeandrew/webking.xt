	<table class="mdl-data-table mdl-js-data-table  mdl-shadow--2dp">
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
<?foreach ($products as $product) {
	if($product['opt_qty'] > 0){
		$mode = 'opt';
	}else{
		$mode = 'mopt';
	}?>
		<tbody>
		    <tr>
		        <td class="mdl-data-table__cell--non-numeric">
		            <div class="avatar">
		            	<!-- <img alt="<?=G::CropString($product['name'])?>" src="<?=_base_url.str_replace('original', 'thumb', $product['img_1']);?>"/> -->
		            	<img src="http://lorempixel.com/fashion/70/70/" alt="avatar" />
		            </div>
		        </td>
		        <td class="mdl-data-table__cell--non-numeric"><div><?=$product['name'];?></div></td>
		        <td><div class="cent"><?=$product['site_price_'.$mode]?></div></td>
		        <td><div class="cent"><?=$product[$mode.'_qty'];?></div></td>
		        <td><div class="cent"><?=$product[$mode.'_sum'];?></div></td>
		    </tr>
		</tbody>
<?}?>
	</table>