<div id="products">
	<div class="ordersProdList">
		<div class="ordersProdListContent ordersProdListTitle">
			<?if(isset($rewrite) && $rewrite == 'orders'){?>
				<div class="avatar">Фото</div>
			<?}?>
			<div class="orderProdName">Наименование товара</div>
			<div class="priceWrap">
				<div class="cent">Цена</div>
				<div class="cent">Кол-во</div>
				<div class="cent">Cумма</div>
			</div>
		</div>
		<?$user_cart_total = 0;?>
		<?if(isset($list) && $list != ''){
			foreach($list as $item){?>
				<div class="ordersProdListContent">
					<?if(isset($rewrite) && $rewrite == 'orders'){?>
						<div class="avatar">
							<?if(!empty($item['images'])){?>
								<img alt="<?=htmlspecialchars(G::CropString($item['id_product']))?>" src="<?_base_url?><?=G::GetImageUrl($item['images'][0]['src'], 'medium')?>"/>
							<?}else{?>
								<img alt="<?=htmlspecialchars(G::CropString($item['id_product']))?>" src="<?_base_url?><?=G::GetImageUrl($item['img_1'], 'medium')?>"/>
							<?}?>
						</div>
					<?}?>
					<div class="orderProdName"><?=$item['name'];?></div>
					<div class="priceWrap">
						<div class="cent">
							<span class="priceTitle">Цена:&nbsp;</span>
							<span class="priceItem"> <?=number_format($item['price'], 2, ',', '');?> грн.</span>
						</div>
						<div class="cent">
							<span class="priceTitle">Кол-во:&nbsp;</span>
							<span class="priceItem"> <?=$item['quantity'];?> шт.</span>
						</div>
						<div class="cent">
							<span class="priceTitle">Сумма:&nbsp;</span>
							<span class="priceItem"> <?=number_format($item['price']*$item['quantity'], 2, ',', '');?> грн.</span>
						</div>
					</div>
					<div class="note <?=empty($item['note'])?'hidden':null?>">
						<span class="priceTitle">Примечание:</span>
						<span class="priceItem"><?=$item['note']?></span>
					</div>
				</div>
				<?$user_cart_total += $item['price']*$item['quantity'];?>
			<?}
		}else{?>
			<div>В корзине нет товаров</div>
		<?}?>
	</div>
	<div class="over_sum">Итого: <?=number_format($user_cart_total, 2, ',', '')?> грн.</div>
</div>