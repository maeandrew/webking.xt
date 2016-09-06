<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"><span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"><span class="strong">Сделано!</span><?=$msg?></div><?}?>
<div class="move_product_wrap">
	<div class="move_to" data-isempty="<?=empty($product_list)?'true':'false';?>">
		<p>Перенести в категорию</p>
		<select name="category" class="input-m" required>
			<option disabled selected value="">Выберите категорию</option>
			<?foreach($categories as $category){?>
				<option <?=(next($categories)['pid'] == $category['id_category'])?'disabled':null?> <?=($category['id_category'] == $i['category'])?'selected':null?> value="<?=$category['id_category']?>"><?=str_repeat("&nbsp;&nbsp;&nbsp;", $category['category_level'])?><?=$category['name']?></option>
			<?}?>
		</select>
		<div><label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="move_product_<?=$item['id_product']?>">
			<input type="checkbox" name="move_product" data-idproduct="<?=$item['id_product']?>" id="move_product_<?=$item['id_product']?>" class="move_product_<?=$item['id_product']?>_js mdl-checkbox__input">
			<span class="mdl-checkbox__label title_move_product">Дополнительная категория</span>
		</label></div>
		<button name="submit" type="submit" title="Перенести товары из заказа в выбранную категорию" class="btn-m-green btn_move_to_js" value="Вперед">Вперед</button>
	</div>
	<div class="checked_products_wrap">
		<div class="no_checked_products_js no_checked_products<?=!empty($product_list)?' hidden':null;?>"><a href="<?=$GLOBALS['URL_base']?>">Выберите товары</a> для переноса в нужную категорию.</div>
		<?if(!empty($product_list)){?>
			<div class="checked_products">
				<?foreach($product_list as $item){?>
					<div class="checked_product" data-idproduct="<?=$item['id_product']?>">
						<div class="item_photo">
							<a href="<?=Link::Product($item['translit']);?>">
								<?if(!empty($item['images'])){?>
									<img alt="<?=htmlspecialchars(G::CropString($item['id_product']))?>" class="lazy" src="/images/nofoto.png" data-original="<?=G::GetImageUrl($item['images'][0]['src'], 'medium')?>"/>
									<noscript><img alt="<?=htmlspecialchars(G::CropString($item['id_product']))?>" src="<?=G::GetImageUrl($item['images'][0]['src'], 'medium')?>"/></noscript>
								<?}else{?>
									<img alt="<?=htmlspecialchars(G::CropString($item['id_product']))?>" class="lazy" src="/images/nofoto.png" data-original="<?=G::GetImageUrl($item['img_1'], 'medium')?>"/>
									<noscript><img alt="<?=htmlspecialchars(G::CropString($item['id_product']))?>" src="<?=G::GetImageUrl($item['img_1'], 'medium')?>"/></noscript>
								<?}?>
							</a>
						</div>
						<div class="product_item">
							<div><a href="<?=Link::Product($item['translit']);?>"><?=G::CropString($item['name'])?></a></div>
							<div class="product_article">арт: <?=$item['art'];?></div>
							<div class="product_descr"><?=$item['descr_xt_full'];?></div>
						</div>
						<div class="btn_wrap">
							<div><button class="btn-m-red-inv del_checked_product_js" data-idproduct="<?=$item['id_product']?>">Удалить</button></div>
							<div><a class="icon-font btn-m-blue psevdo_btn" title="Посмотреть товар на сайте" href="/product/<?=$item['translit']?>" target="_blank">v</a></div>
						</div>
					</div>
				<?}?>
			</div>
		<?}?>
	</div>
</div>
<script>
var restore = 0;
$('[name="restore"]').click(function(){
	var restore = 1;
	var id_order = $(this).val();
	ajax('order', 'restoreDeleted', {id_order: id_order, restore: restore}).done(function(){
		$(this).fadeOut(300);
	});
});
</script>