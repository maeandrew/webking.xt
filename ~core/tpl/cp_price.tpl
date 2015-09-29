<?if(isset($_GET['savedprices']) == true){?>
	<a href="/price/" class="subheader">Сформировать свой прайс-лист</a>
<?}else{?>
	<a href="/price/?savedprices=true" class="subheader">Перейти к готовым прайс-листам</a>
<?}?>
<div class="price_list_page row">
	<div class="categories_js col-md-8 col-lg-9 ajax_loading">
		<?if(isset($_GET['savedprices']) == true){?>
			<?foreach($prices as $price){
				if($price['visibility'] == 1){?>
					<section id="pricelist_item">
						<input type="radio" name="pricelist_select" class="pricelist_select" id="order-<?=$price['order']?>" value="<?=$price['id']?>">
						<label for="order-<?=$price['order']?>"><?=$price['name']?></label>
					</section>
				<?}
			}?>
		<?}else{?>
			<ul>
				<?foreach($list as $k=>$l1){
					if($l1['category_level'] == 1 && empty($l1['subcats']) == false){?>
						<li>
							<p class="header2"><?=$l1['name'];?></p>
							<?if(isset($l1['subcats'])){?>
								<ul class="list_level1">
									<?foreach($l1['subcats'] as $l2){?>
										<li>
											<input type="checkbox" name="category_select" class="category-parent-select" id="cat-<?=$l2['id_category']?>" value="<?=$l2['products']?>">
											<?if(isset($l2['subcats'])){?>
												<label for="cat-<?=$l2['id_category']?>"><?=$l2['name']?> [<?=$l2['products']?>]</label>
												<label class="expand" for="expand_<?=$l2['id_category']?>">Развернуть</label>
												<input type="checkbox" id="expand_<?=$l2['id_category']?>" class="expand_input hidden">
												<ul class="list_level2">
													<?foreach($l2['subcats'] as $l3){?>
														<li>
															<input type="checkbox" name="category_select" class="category-select pid-<?=$l3['pid']?>" id="cat-<?=$l3['id_category']?>" value="<?=$l3['products']?>">
															<label for="cat-<?=$l3['id_category']?>"><?=$l3['name']?> [<?=$l3['products']?>]</label>
														</li>
													<?}?>
												</ul>
											<?}else{?>
												<label for="cat-<?=$l2['id_category']?>"><?=$l2['name']?> [<?=$l2['products']?>]</label>
											<?}?>
										</li>
									<?}?>
								</ul>
							<?}?>
						</li>
					<?}
				}?>
			</ul>
		<?}?>
	</div>
	<div class="col-md-4 col-lg-3">
		<form action="/pricelist/" target="_blank" method="GET" id="dynamic-params" class="price_form">
			<fieldset>
				<legend>Заголовок прайса
					<label class="info_key">?</label>
					<div class="info_description">
						<p>Введенная здесь информация заменит стандартный заголовок прайс-листа.</p>
					</div>
				</legend>
				<textarea rows="1" name="header"></textarea>
			</fieldset>
			<fieldset>
				<legend>Цена
					<label class="info_key">?</label>
					<div class="info_description">
						<p>При изменении этого параметра, в прайс-листе будут указаны цены из колонок "Более <?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?>грн.",
						"<?=$GLOBALS['CONFIG']['wholesale_order_margin']?>-<?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?>грн.", "<?=$GLOBALS['CONFIG']['retail_order_margin']?>-<?=$GLOBALS['CONFIG']['wholesale_order_margin']?>грн.", "До <?=$GLOBALS['CONFIG']['retail_order_margin']?>." каталога товаров соответственно.<br>
						Для изменения цен товаров в прайс-листе с учетом своей наценки, в поле "индивидуальная наценка" введите коэфициент, на который они будут умножены, при этом переключение колонок станет недоступным.<br>
						Например:<br>
							введенный коэфициент - <b>1,5</b>;<br>
							розничная цена товара - <b>13,58</b>;<br>
							цена товара с наценкой -<br>
							<b>13,58 x 1,5 = 20,37</b>.<br>
						</p>
					</div>
					<!-- <input type="text" id="column-info-key"> -->
					<!-- <label for="column-info-key" class="info-key">?</label> -->
					<!-- <div class="column-info info">
						<p>При изменении этого параметра, в прайс-листе будут указаны цены из колонок "Более <?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?>грн.",
						"<?=$GLOBALS['CONFIG']['wholesale_order_margin']?>-<?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?>грн.", "<?=$GLOBALS['CONFIG']['retail_order_margin']?>-<?=$GLOBALS['CONFIG']['wholesale_order_margin']?>грн.", "До <?=$GLOBALS['CONFIG']['retail_order_margin']?>." каталога товаров соответственно.<br>
						Для изменения цен товаров в прайс-листе с учетом своей наценки, в поле "индивидуальная наценка" введите коэфициент, на который они будут умножены, при этом переключение колонок станет недоступным.<br>
						Например:<br>
							введенный коэфициент - <b>1,5</b>;<br>
							розничная цена товара - <b>13,58</b>;<br>
							цена товара с наценкой -<br>
							<b>13,58 x 1,5 = 20,37</b>.<br>
						</p>
					</div> -->
				</legend>
				<label><input type="checkbox" name="column[]" value="0">при заказе более <?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?>грн.</label>
				<label><input type="checkbox" name="column[]" value="1">при заказе на <?=$GLOBALS['CONFIG']['wholesale_order_margin']?>-<?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?>грн.</label>
				<label><input type="checkbox" name="column[]" value="2">при заказе на <?=$GLOBALS['CONFIG']['retail_order_margin']?>-<?=$GLOBALS['CONFIG']['wholesale_order_margin']?>грн.</label>
				<label><input type="checkbox" checked name="column[]" value="3">при заказе до <?=$GLOBALS['CONFIG']['retail_order_margin']?>грн.</label>
				<label><input type="text" name="margin" id="margin" value="">индивидуальная наценка</label>
			</fieldset>
			<fieldset>
				<legend>Фотография
					<label class="info_key">?</label>
					<div class="info_description">
						<p>В зависимости от этого параметра, будет сформирован прайс-лист с изображениями товаров или без них.</p>
					</div>
				</legend>
				<label><input type="radio" checked name="photo" id="without" value="0">без фотографий</label>
				<label><input type="radio" name="photo" id="with" value="1">с фотографиями</label>
				<label><input type="radio" name="photo" id="with" value="2">с большими фотографиями</label>
			</fieldset>
			<p class="ps">Хотите открыть прайс в Excell?<br>Сохраните страницу прайса в браузере, затем откройте сохраненный файл в Excell.</p>
			<div class="price-counter">
				<?if(isset($_GET['savedprices']) == true){?>
					<input type="hidden" name="savedprices">
					<!--<style>.price-counter .variables {color: transparent;text-shadow: none;}</style>-->
				<?}?>
				<p class="variables">Выбрано<span class="selected-count value">0</span></p>
				<p class="variables">Лимит<span class="limit-count value">3000</span></p>
				<p class="variables">Осталось<span class="remain-count value">3000</span></p>
				<input type="hidden" required name="selected-array" class="selected-array">
				<input type="submit" class="btn-m-orange" value="Прайс-лист">
				<a href="#" class="uncheck_all">Снять все выделения</a>
			</div>
		</form>
	</div>
</div> <!-- END class="price_list_page" -->
<script>
	$(function(){
		$(".categories_js").removeClass('ajax_loading');
	});
	/** Плавающий блок параметров на странице формирования прайс-листа */
	$(window).scroll(function(){
		var params = $('#dynamic-params');
		var start = 140;
		if($(this).scrollTop() >= start){
			params.css("top", $(this).scrollTop()-start);
		}else{
			params.css("top", '0');
		}
	});
</script>