<?//print_r($i['products']);?>
	<!-- <img alt="<?=G::CropString($p['name'])?>" class="lazy" data-original="<?=_base_url.str_replace('original', 'thumb', $p['images'][0]['src']);?>"/> -->
	<noscript>
		<img alt="<?=G::CropString($p['name'])?>" src="<?=_base_url.str_replace('original', 'thumb', $p['images'][0]['src']);?>"/>
	</noscript>
<?foreach ($i['products'] as $key => $product) {
	if($product['opt_qty'] > 0){
		$mode = 'opt';
	}else{
		$mode = 'mopt';
	}?>
	<img alt="<?=G::CropString($p['name'])?>" class="lazy" data-original="http://lorempixel.com/120/90/"/>
	<div>Наименование товара :<?=$product['name'];?></div>
	<div>Оптовая сумма :<?=$product[$mode.'_sum'];?></div>
	<div>Количество :<?=$product[$mode.'_qty'];?></div>
	<div>Цена :<?=$product['site_price_'.$mode]?></div>
<?}?>