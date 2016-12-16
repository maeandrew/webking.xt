<div class="gifts_wrap">
	<?if(isset($gifts)){
		foreach ($gifts as $product) {?>
			<div class="gift_product gift_product_js">
				<input type="hidden" value="<?=$product["id_product"]?>" class="id_gift_product_js">
				<?if(!empty($product['images'])){?>
					<img itemprop="image" src="<?=G::GetImageUrl($product['images'][0]['src'], 'medium')?>"/>
				<?}else if(!empty($product['img_1'])){?>
					<img itemprop="image" src="<?=G::GetImageUrl($product['img_1'], 'medium')?>"/>
				<?}else{?>
					<img itemprop="image" src="<?=G::GetImageUrl('/images/nofoto.png')?>"/>
				<?}?>
				<p class="gift_product_title"><?=$product["name"]?></p>
				<p class="gift_product_art">Артикул: <?=$product["art"]?></p>
			</div>
		<?}
	}?>
</div>
