<div class="agents_gifts">
	<h2>Подарки</h2>
	<div class="gifts_wrap">
	<?if(isset($gifts)){
		foreach ($gifts as $product) {?>
			<div class="gift_product gift_product_js">
				<input type="hidden" value="<?=$product["id_product"]?>" class="id_gift_product_js">
				<?if(!empty($product['images'])){?>
					<img class="main_img_js" itemprop="image" src="<?=G::GetImageUrl($product['images'][0]['src'])?>"/>
				<?}else if(!empty($product['img_1'])){?>
					<img class="main_img_js" itemprop="image" src="<?=G::GetImageUrl($product['img_1'])?>"/>
				<?}else{?>
					<img class="main_img_js" itemprop="image" src="<?=G::GetImageUrl('/images/nofoto.png')?>"/>
				<?}?>
				<p class="gift_product_title"><?=$product["name"]?></p>
				<p class="gift_product_art">Артикул: <?=$product["art"]?></p>
			</div>
		<?}
	}?>
</div>