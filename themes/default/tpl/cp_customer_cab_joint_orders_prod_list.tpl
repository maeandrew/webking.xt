<div id="products">
	<div class="ordersProdList">
		<div class="ordersProdListTitle">
			<div class="prodListPhoto">Фото</div>
			<div class="orderProdName">Наименование товара</div>
			<div class="prodListPrice">Цена</div>
			<div class="prodListPrice">Кол-во</div>
			<div class="prodListPrice">Cумма</div>
		</div>	
		<?foreach ($list as $item) {?>
	<!-- 	if($item['opt_qty'] > 0){
			$mode = 'opt';
		}else{
			$mode = 'mopt';
		}?>		 -->
			<div class="ordersProdListContent">
				<div class="avatar">
					<?if(!empty($item['img'])){?>						<!-- http://xt.ua -->
						<img alt="<?=G::CropString($item['id_product'])?>" src="<?_base_url?><?=file_exists($GLOBALS['PATH_root'].str_replace('original', 'small', $item['images'][0]['src']))?str_replace('original', 'small', $item['images'][0]['src']):'/efiles/_thumb/nofoto.jpg'?>"/>
					<?}else{?>
						<img alt="<?=G::CropString($item['id_product'])?>" src="<?_base_url?><?=$item['img_1']?htmlspecialchars(str_replace("/image/", "/image/250/", $item['img_1'])):"/images/nofoto.jpg"?>"/>
					<?}?>            	
				</div>
				<div class="orderProdName"><?=$item['name'];?></div>
				<div class="cent">
					<span class="priceTitle">Цена:</span>
					<span class="priceItem"><?=$item['base_price']?> грн.</span>
				</div>
				<div class="cent">
					<span class="priceTitle">Кол-во:</span>
					<span class="priceItem"><?=$item['quantity'];?> шт.</span>
				</div>
				<div class="cent">
					<span class="priceTitle">Сумма:</span>
					<span class="priceItem"><?=$item['base_price'];?> грн.</span>
				</div>
			</div>
		<?}?>
	</div>
</div>