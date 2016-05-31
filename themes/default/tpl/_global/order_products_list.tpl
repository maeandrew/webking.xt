<div id="products">
	<div class="ordersProdList">
		<div class="ordersProdListTitle">
		<?if(isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'orders'){?>
			<div class="prodListPhoto">Фото</div>
		<?}?>
			<div class="orderProdName">Наименование товара</div>
			<div class="prodListPrice">Цена</div>
			<div class="prodListPrice">Кол-во</div>
			<div class="prodListPrice">Cумма</div>
		</div>
		<?$user_cart_total = 0;?>
		<?foreach ($list as $item) {?>
			<div class="ordersProdListContent">				
				<?if(isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'orders'){?>
					<div class="avatar">
						<?if(!empty($item['images'])){?>
							<img alt="<?=G::CropString($item['id_product'])?>" src="http://xt.ua<?_base_url?><?=file_exists($GLOBALS['PATH_root'].str_replace('original', 'small', $item['images'][0]['src']))?str_replace('original', 'small', $item['images'][0]['src']):'/efiles/_thumb/nofoto.jpg'?>"/>
						<?}else{?>
							<img alt="<?=G::CropString($item['id_product'])?>" src="http://xt.ua<?_base_url?><?=$item['img_1']?htmlspecialchars(str_replace("/image/", "/image/250/", $item['img_1'])):"/images/nofoto.jpg"?>"/>
						<?}?>
					</div>
				<?}?>
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
			<?$user_cart_total += $item['price']*$item['quantity'];?>
		<?}?>
		<div class="total_wrap">Всего: <?=$user_cart_total?> грн.</div>
	</div>
</div>