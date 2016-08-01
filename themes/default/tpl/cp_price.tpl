<h1><?=$header?></h1>
<?if(isset($_GET['savedprices']) == true){?>
	<a href="/price/" class="subheader">Сформировать свой прайс-лист</a>
<?}else{?>
	<a href="/price/?savedprices=true" class="subheader">Перейти к готовым прайс-листам</a>
<?}?>
<div class="price_list_page row">
	<div class="col-md-4 col-lg-3">
		<form id="dynamic-params" action="/pricelist/" target="_blank" method="GET" class="price_form">
			<div class="price-params">
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

					<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-more">
						<input type="checkbox" id="checkbox-more" class="mdl-checkbox__input" name="column[]" value="0">при заказе более <?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?>грн.
					</label>

					<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-on">
						<input type="checkbox" id="checkbox-on" class="mdl-checkbox__input" name="column[]" value="1">при заказе на <?=$GLOBALS['CONFIG']['wholesale_order_margin']?>-<?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?>грн.
					</label>

					<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-from-to">
						<input type="checkbox" id="checkbox-from-to" class="mdl-checkbox__input" name="column[]" value="2">при заказе на <?=$GLOBALS['CONFIG']['retail_order_margin']?>-<?=$GLOBALS['CONFIG']['wholesale_order_margin']?>грн.
					</label>

					<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-to">
						<input type="checkbox" id="checkbox-to" class="mdl-checkbox__input" checked name="column[]" value="3">при заказе до <?=$GLOBALS['CONFIG']['retail_order_margin']?>грн.
					</label>

					<div id="individualMargin" class="mdl-textfield mdl-js-textfield">
						<input class="mdl-textfield__input" type="text" pattern="(-?[0-9]*(\.[0-9]+)?|-?[0-9]*(,[0-9]+)?)" id="individual" id="margin" name="margin" >
						<label class="mdl-textfield__label" for="individual">индивидуальная наценка</label>
						<span class="mdl-textfield__error">ВВЕДИТЕ ЧИСЛО!</span>
					</div>

				</fieldset>
				<fieldset>
					<legend>Фотография
						<label class="info_key">?</label>
						<div class="info_description">
							<p>В зависимости от этого параметра, будет сформирован прайс-лист с изображениями товаров или без них.</p>
						</div>
					</legend>
					<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="without"><input type="radio" checked name="photo" class="mdl-radio__button" id="without" value="0">без фотографий</label>
					<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="with"><input type="radio" name="photo" class="mdl-radio__button" id="with" value="1">с фотографиями</label>
					<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="withbig"><input type="radio" name="photo" class="mdl-radio__button" id="withbig" value="2">с большими фотографиями</label>
				</fieldset>

				<button class="mdl-button mdl-js-button mdl-button--raised uncheck_all">Снять все выделения</button>

				<p class="info">Хотите открыть прайс в Excell?<br>Сохраните страницу прайса в браузере, затем откройте сохраненный файл в Excell.</p>
				<div class="price-counter">
					<?if(isset($_GET['savedprices']) == true){?>
						<input type="hidden" name="savedprices">
						<!--<style>.price-counter .variables {color: transparent;text-shadow: none;}</style>-->
					<?}?>
					<p class="variables">Выбрано<span class="selected-count value">0</span></p>
					<p class="variables">Лимит<span class="limit-count value">3000</span></p>
					<p class="variables">Осталось<span class="remain-count value">3000</span></p>
					<input type="hidden" required name="selected-array" class="selected-array">
					<!-- <input type="submit" class="confirm btn-m-orange" value="Прайс-лист"> -->
					<button class="mdl-button mdl-js-button mdl-button--raised confirm">Прайс-лист</button>
				</div>
			</div>
		</form>
	</div>
	<div class="categories_js col-md-8 col-lg-9 ajax_loading">
		<?if(isset($_GET['savedprices']) == true){?>
			<?foreach($prices as $price){
				if($price['visibility'] == 1){?>
					<section id="pricelist_item">
						<!-- <input type="radio"  name="pricelist_select" class="pricelist_select" id="order-<?=$price['order']?>" value="<?=$price['id']?>">
						<label for="order-<?=$price['order']?>"><?=$price['name']?></label> -->
						<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="order-<?=$price['order']?>">
							<input type="radio" name="pricelist_select" class="mdl-radio__button pricelist_select" id="order-<?=$price['order']?>" value="<?=$price['id']?>" value="<?=$price['id']?>"><?=$price['name']?>
						</label>
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
											<?if(isset($l2['subcats'])){?>
												<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="cat-<?=$l2['id_category']?>">
													<input type="checkbox" name="category_select" class="category-parent-select mdl-checkbox__input" id="cat-<?=$l2['id_category']?>" value="<?=$l2['products']?>">
													<span class="mdl-checkbox__label"><?=$l2['name']?> [<?=$l2['products']?>]</span>
												</label>

												<label class="expand " for="expand_<?=$l2['id_category']?>">Развернуть</label>
												<input type="checkbox" id="expand_<?=$l2['id_category']?>" class="expand_input hidden mdl-checkbox__input">

												<ul class="list_level2">
													<?foreach($l2['subcats'] as $l3){?>
														<li>
															<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="cat-<?=$l3['id_category']?>">
																  <input type="checkbox" name="category_select" id="cat-<?=$l3['id_category']?>" class="mdl-checkbox__input category-select pid-<?=$l3['pid']?>" value="<?=$l3['products']?>">
																  <span class="mdl-checkbox__label"><?=$l3['name']?> [<?=$l3['products']?>]</span>
															</label>

															<!-- <input type="checkbox" name="category_select" class="category-select pid-<?=$l3['pid']?>" id="cat-<?=$l3['id_category']?>" value="<?=$l3['products']?>">
															<label for="cat-<?=$l3['id_category']?>"><?=$l3['name']?> [<?=$l3['products']?>]</label> -->
														</li>
													<?}?>
												</ul>
											<?}else{?>
												<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="cat-<?=$l2['id_category']?>">
													<input type="checkbox" name="category_select" class="category-parent-select mdl-checkbox__input" id="cat-<?=$l2['id_category']?>" value="<?=$l2['products']?>">
													<span class="mdl-checkbox__label"><?=$l2['name']?> [<?=$l2['products']?>]</span>
												</label>
											<?}?>

										<!-- <input type="checkbox" name="category_select" class="category-parent-select" id="cat-<?=$l2['id_category']?>" value="<?=$l2['products']?>">
											<?if(isset($l2['subcats'])){?>
												<label for="cat-<?=$l2['id_category']?>"><?=$l2['name']?> [<?=$l2['products']?>]</label>
												<label class="expand " for="expand_<?=$l2['id_category']?>">Развернуть</label>
												<input type="checkbox" id="expand_<?=$l2['id_category']?>" class="expand_input hidden mdl-checkbox__input">
												<ul class="list_level2">
													<?foreach($l2['subcats'] as $l3){?>
														<li>
															<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="cat-<?=$l3['id_category']?>">
																  <input type="checkbox" name="category_select" id="cat-<?=$l3['id_category']?>" class="mdl-checkbox__input category-select pid-<?=$l3['pid']?>" value="<?=$l3['products']?>">
																  <span class="mdl-checkbox__label"><?=$l3['name']?> [<?=$l3['products']?>]</span>
															</label>
															<input type="checkbox" name="category_select" class="category-select pid-<?=$l3['pid']?>" id="cat-<?=$l3['id_category']?>" value="<?=$l3['products']?>">
															<label for="cat-<?=$l3['id_category']?>"><?=$l3['name']?> [<?=$l3['products']?>]</label>
														</li>
													<?}?>
												</ul>
											<?}else{?>
												<label for="cat-<?=$l2['id_category']?>"><?=$l2['name']?> [<?=$l2['products']?>]</label>
											<?}?> -->


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
</div> <!-- END class="price_list_page" -->
<script>
	$(function(){
		$(".categories_js").removeClass('ajax_loading');
	});
	/** Плавающий блок параметров на странице формирования прайс-листа */
	var params = $('#dynamic-params'),
		start = parseInt(params.css("top"));
		var contHeight = $(".page_content_js").height();
		var formHeight = $("#dynamic-params").height();
		var endScroll = (contHeight - formHeight);
		
		if(contHeight < formHeight){
			endScroll = 50;
		}

	$(window).scroll(function(){
		var over_scroll = $('body').hasClass('banner_hide')?true:false;
		if($(this).scrollTop() > endScroll){
			params.css('top', endScroll);
			params.css('z-index', 0);
		}else if($(this).scrollTop() >= start){
			if(over_scroll === true){
				params.css("top", $(this).scrollTop());
			}
		}else{
			params.css("top", start);
		}
	});

	$(window).on("load", function() {
		var window_width = $(document).width(),
			start = 300,
			second_start = 600,
			diff = 0;
		if(window_width > 1600){
			diff = (window_width - 1600)/2;
		}
		$('.price_form').css('right', diff);

		if (contHeight < formHeight){
			$('#dynamic-params').css('top', 50);
			$(".price_list_page").css('height', formHeight);
		}
	});

	/** Выбор категорий для прайс-листа */
	/* Справка по заголовку в прайсе */
	$('#header-info-key').click(function(){
		$('.header-info').stop(true,true).zIndex(101).animate({
			"right": "-3px",
			"opacity": "1"
		});
	});
	$('#header-info-key').blur(function(){
		$('.header-info').stop(true,true).zIndex(0).animate({
			"right": "100px",
			"opacity": "0"
		});
	});

	/* Справка по выбору колонки в прайсе */
	$('#column-info-key').click(function(){
		$('.column-info').stop(true,true).zIndex(101).animate({
			"right": "-3px",
			"opacity": "1"
		});
	});
	$('#column-info-key').blur(function(){
		$('.column-info').stop(true,true).zIndex(0).animate({
			"right": "100px",
			"opacity": "0"
		});
	});

	/* Справка по выбору фото в прайсе */
	$('#photo-info-key').focus(function(){
		$('.photo-info').stop(true,true).zIndex(101).animate({
			"right": "-3px",
			"opacity": "1"
		});
	});
	$('#photo-info-key').blur(function(){
		$('.photo-info').stop(true,true).zIndex(0).animate({
			"right": "100px",
			"opacity": "0"
		});
	});

	/* Первоначальное выключение категорий, превышающих лимит */
	$('.category-select, .category-parent-select').each(function(){
		var limit = Number($('span.limit-count').text().replace(/\D+/g,""));
		if($(this).val() !== 0 && $(this).val() > limit){
			$(this).prop('disabled',true).closest('label').addClass('is-disabled');
		}else{
			$(this).prop('disabled',false).closest('label').removeClass('is-disabled');
		}
	});

	/* Проверка input индивидуальной наценки */
	$('#individual').keyup(function(){
		var value = $(this).val().replace(/[^0-9.,]/gi,"");
		if(value.length > 0 && value.length <= 6){
			$('input[name="column[]"]').prop('disabled',true).closest('label').addClass('is-disabled').css('color', 'gray');
			$(this).val(value);
		}else{
			$('input[name="column[]"]').prop('disabled',false).closest('label').removeClass('is-disabled').css('color', '');
			$(this).val('');
		}
	});

	/* Снять все выделения */
	$('.uncheck_all').click(function(e){
		e.preventDefault();
		$('.category-select:checked, .category-parent-select:checked, .category-parent-select:indeterminate').each(function(){
			var id = Number($(this).attr('id').replace(/\D+/g,""));
			var pid = Number($(this).attr('class').replace(/\D+/g,""));
			var products = Number($(this).val().replace(/\D+/g,""));
			var limit = Number($('span.limit-count').text().replace(/\D+/g,""));
			var summary = Number($('span.selected-count').text().replace(/\D+/g,""));
			var massive = $('.selected-array').val();
			if(pid == 0){
				if($('.pid-'+id).length == 0){
					summary -= products;
					massive = massive.replace((Number($(this).attr('id').replace(/\D+/g,""))+';'),'');
				}
			}else{
				summary -= products;
				massive = massive.replace((Number($(this).attr('id').replace(/\D+/g,""))+';'),'');
			}
			$(this).prop('checked', false).prop('indeterminate', false).closest('label').removeClass('is-semi-checked').removeClass('is-checked');
			$('.selected-array').val(massive);
			$('.selected-count').text(summary);
			var remain = limit-summary;
			$('span.remain-count').text(remain);
			$('.category-select, .category-parent-select').each(function(){
				var pid = Number($(this).attr('class').replace(/\D+/g,""));
				var id = Number($(this).attr('id').replace(/\D+/g,""));
				if(pid == 0){
					var remain_cat = 0;
					$('.pid-'+id+':checked').each(function(){
						remain_cat += Number($(this).val().replace(/\D+/g,""));
					});
					remain_cat = Number($(this).val().replace(/\D+/g,"")) - remain_cat;
				}else{
					var remain_cat = Number($(this).val().replace(/\D+/g,""));
				}
				if($(this).prop('checked') !== true && remain_cat > remain){
					$(this).prop('disabled',true).closest('label').addClass('is-disabled');
				}else{
					$(this).prop('disabled',false).closest('label').removeClass('is-disabled');
				}
			});
		});
	});

	/* Выбор категорий второго уровня */
	$('.pricelist_select').change(function(){
		var order = $(this).val();
		$('.selected-array').val(order);
	});

	/* Выбор категорий второго уровня */
	$('.category-select, .category-parent-select').change(function(){
		console.log("hello");
		var id = Number($(this).attr('id').replace(/\D+/g,""));
		var pid = Number($(this).attr('class').replace(/\D+/g,""));
		var products = Number($(this).val().replace(/\D+/g,""));
		var limit = Number($('span.limit-count').text().replace(/\D+/g,""));
		var summary = Number($('span.selected-count').text().replace(/\D+/g,""));
		var array = 0; var massive = $('.selected-array').val();
		$(this).closest('label').removeClass('is-semi-checked');
		if(pid == 0){
			if($('.pid-'+id).length > 0){
				if($(this).prop('checked')==true){
					$('.pid-'+id+':checked').each(function(){
						products = products - Number($(this).val());
					});
					$('.pid-'+id).each(function(){
						massive = massive.replace((Number($(this).attr('id').replace(/\D+/g,""))+';'),'');
						massive += Number($(this).attr('id').replace(/\D+/g,""))+';';
					});
					$('.pid-'+id).prop('checked',true).closest('label').addClass('is-checked');
					summary += products;
				}else{
					$('.pid-'+id).prop('checked',false).closest('label').removeClass('is-checked');
					summary -= products;
					$('.pid-'+id).each(function(){
						massive = massive.replace((Number($(this).attr('id').replace(/\D+/g,""))+';'),'');
					});
				}
			}else{
				if($(this).prop('checked')==true){
					summary += products;
					massive += Number($(this).attr('id').replace(/\D+/g,""))+';';
				}else{
					summary -= products;
					massive = massive.replace((Number($(this).attr('id').replace(/\D+/g,""))+';'),'');
				}
			}
		}else{
			if($(this).prop('checked')==true){
				summary += products;
				massive += Number($(this).attr('id').replace(/\D+/g,""))+';';
			}else{
				summary -= products;
				massive = massive.replace((Number($(this).attr('id').replace(/\D+/g,""))+';'),'');
			}
			if($('.pid-'+pid).length > 0 && $('.pid-'+pid+':checked').length > 0){
				if($('.pid-'+pid+':checked').length !== $('.pid-'+pid).length){
					$('#cat-'+pid).prop('checked',false).prop('indeterminate', true).closest('label').addClass('is-semi-checked');
				}else{
					$('#cat-'+pid).prop('checked',true).prop('indeterminate', false).closest('label').removeClass('is-semi-checked').addClass('is-checked');
				}
			}else{
				$('#cat-'+pid).prop('checked',false).prop('indeterminate', false).closest('label').removeClass('is-semi-checked').removeClass('is-checked');
			}
		}
		$('.selected-array').val(massive);
		$('span.selected-count').text(summary);
		var remain = limit-summary;
		$('span.remain-count').text(remain);
		$('.category-select, .category-parent-select').each(function(){
			var pid = Number($(this).attr('class').replace(/\D+/g,""));
			var id = Number($(this).attr('id').replace(/\D+/g,""));
			if(pid == 0){
				var remain_cat = 0;
				$('.pid-'+id+':checked').each(function(){
					remain_cat += Number($(this).val().replace(/\D+/g,""));
				});
				remain_cat = Number($(this).val().replace(/\D+/g,"")) - remain_cat;
			}else{
				var remain_cat = Number($(this).val().replace(/\D+/g,""));
			}
			if($(this).prop('checked') !== true && remain_cat > remain){
				$(this).prop('disabled',true).closest('label').addClass('is-disabled');
			}else{
				$(this).prop('disabled',false).closest('label').removeClass('is-disabled');
			}
		});
	});

	$('.category-select:checked, .category-parent-select:checked').each(function(){
		var id = Number($(this).attr('id').replace(/\D+/g,""));
		var pid = Number($(this).attr('class').replace(/\D+/g,""));
		var products = Number($(this).val().replace(/\D+/g,""));
		var limit = Number($('span.limit-count').text().replace(/\D+/g,""));
		var summary = Number($('span.selected-count').text().replace(/\D+/g,""));
		var array = 0; var massive = $('.selected-array').val();
		if(pid == 0){
			if($('.pid-'+id).length > 0){
				if($(this).prop('checked')==true){
					$('.pid-'+id+':checked').each(function(){
						products = products - Number($(this).val());
					});
					$('.pid-'+id).each(function(){
						massive = massive.replace((Number($(this).attr('id').replace(/\D+/g,""))+';'),'');
						massive += Number($(this).attr('id').replace(/\D+/g,""))+';';
					});
					$('.pid-'+id).prop('checked',true).closest('label').addClass('is-checked');
					summary += products;
				}else{
					$('.pid-'+id).prop('checked',false).closest('label').removeClass('is-checked');
					summary -= products;
					$('.pid-'+id).each(function(){
						massive = massive.replace((Number($(this).attr('id').replace(/\D+/g,""))+';'),'');
					});
				}
			}else{
				if($(this).prop('checked')==true){
					summary += products;
					massive += Number($(this).attr('id').replace(/\D+/g,""))+';';
				}else{
					summary -= products;
					massive = massive.replace((Number($(this).attr('id').replace(/\D+/g,""))+';'),'');
				}
			}
		}else{
			if($(this).prop('checked')==true){
				summary += products;
				massive += Number($(this).attr('id').replace(/\D+/g,""))+';';
			}else{
				summary -= products;
				massive = massive.replace((Number($(this).attr('id').replace(/\D+/g,""))+';'),'');
			}
			if($('.pid-'+pid).length > 0 && $('.pid-'+pid+':checked').length > 0){
				if($('.pid-'+pid+':checked').length !== $('.pid-'+pid).length){
					$('#cat-'+pid).prop('checked',false).prop('indeterminate', true).closest('label').addClass('is-semi-checked');
				}else{
					$('#cat-'+pid).prop('checked',true).prop('indeterminate', false).closest('label').removeClass('is-semi-checked');
				}
			}else{
				$('#cat-'+pid).prop('checked',false).prop('indeterminate', false).closest('label').removeClass('is-semi-checked');
			}
		}
		$('.selected-array').val(massive);
		$('span.selected-count').text(summary);
		var remain = limit-summary;
		$('span.remain-count').text(remain);
		$('.category-select, .category-parent-select').each(function(){
			var pid = Number($(this).attr('class').replace(/\D+/g,""));
			var id = Number($(this).attr('id').replace(/\D+/g,""));
			if(pid == 0){
				var remain_cat = 0;
				$('.pid-'+id+':checked').each(function(){
					remain_cat += Number($(this).val().replace(/\D+/g,""));
				});
				remain_cat = Number($(this).val().replace(/\D+/g,"")) - remain_cat;
			}else{
				var remain_cat = Number($(this).val().replace(/\D+/g,""));
			}
			if($(this).prop('checked') !== true && remain_cat > remain){
				$(this).prop('disabled',true).closest('label').addClass('is-disabled');
			}else{
				$(this).prop('disabled',false).closest('label').removeClass('is-disabled');
			}
		});
	});
</script>