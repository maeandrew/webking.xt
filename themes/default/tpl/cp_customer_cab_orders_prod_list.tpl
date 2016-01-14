<?foreach ($products as $product) {
	if($product['opt_qty'] > 0){
		$mode = 'opt';
	}else{
		$mode = 'mopt';
	}?>
	<div class="prod_list">
		<img alt="<?=G::CropString($product['name'])?>" src="<?=_base_url.str_replace('original', 'thumb', $product['img_1']);?>"/>
		<div>Наименование товара :<?=$product['name'];?></div>
		<div>Оптовая сумма :<?=$product[$mode.'_sum'];?></div>
		<div>Количество :<?=$product[$mode.'_qty'];?></div>
		<div>Цена :<?=$product['site_price_'.$mode]?></div>
	</div>







<?}?>