<div id="products">
	<div class="ordersProdList">
		<div class="ordersProdListTitle">
			<div class="prodListPhoto <?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite']=='cooperative'?null:'hidden';?>">Фото</div>
			<div class="orderProdName">Наименование товара</div>
			<div class="prodListPrice">Цена</div>
			<div class="prodListPrice">Кол-во</div>
			<div class="prodListPrice">Cумма</div>
		</div>
		<?foreach ($list as $item) {?>
			<div class="ordersProdListContent">
				<div class="avatar <?=isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite']=='cooperative'?null:'hidden';?>">
					<?if(!empty($item['img'])){?>
						<img alt="<?=htmlspecialchars(G::CropString($item['id_product']))?>" src="<?_base_url?><?=file_exists($GLOBALS['PATH_root'].str_replace('original', 'small', $item['images'][0]['src']))?str_replace('original', 'small', $item['images'][0]['src']):'/images/nofoto.png'?>"/>
					<?}else{?>
						<img alt="<?=htmlspecialchars(G::CropString($item['id_product']))?>" src="<?_base_url?><?=$item['img_1']?htmlspecialchars(str_replace("/image/", "/image/250/", $item['img_1'])):"/images/nofoto.png"?>"/>
					<?}?>
				</div>
				<div class="orderProdName"><?=$item['name'];?></div>
				<div class="cent">
					<span class="priceTitle">Цена:</span>
					<span class="priceItem"><?=$item['price']?> грн.</span>
				</div>
				<div class="cent">
					<span class="priceTitle">Кол-во:</span>
					<span class="priceItem"><?=$item['quantity'];?> шт.</span>
				</div>
				<div class="cent">
					<span class="priceTitle">Сумма:</span>
					<span class="priceItem"><?=$item['price']*$item['quantity'];?> грн.</span>
				</div>
			</div>
		<?}?>
	</div>
</div>