<h1><?=$header?></h1>
<div class="products_page">
	<?if ($avg_chart) {?>
		<div class="demand_chart_wrap">
			<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
				<div class="mdl-tabs__tab-bar">
						<a href="#retail" class="mdl-tabs__tab is-active">Розница</a>
						<a href="#opt" class="mdl-tabs__tab">Опт</a>
				</div>
				<div class="mdl-tabs__panel is-active" id="retail">
					<div class="mdl-cell--hide-phone clearfix toggle one range_wrap">
						<?if(!empty($values)){?>
							<input type="hidden" name="roz_id_chart" value="<?=$values[0]['id_chart']?>">
							<?foreach($values[0] as $key => $value){
								// var_dump(strpos($key, 'value_'));
								if(strpos($key, 'value_') !== false){?>
									<div class="slider_wrap">
										<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$value?>" step="1" tabindex="0">
									</div>
								<?}
							}
						}else{?>
							<div class="slider_wrap">
								<input id="inr_1" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_1']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>январь</span>
							</div>
							<div class="slider_wrap">
								<input id="inr_2" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_2']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>февраль</span>
							</div>
							<div class="slider_wrap">
								<input id="inr_3" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_3']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>март</span>
							</div>
							<div class="slider_wrap">
								<input id="inr_4" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_4']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>апрель</span>
							</div>
							<div class="slider_wrap">
								<input id="inr_5" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_5']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>май</span>
							</div>
							<div class="slider_wrap">
								<input id="inr_6" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_6']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>июнь</span>
							</div>
							<div class="slider_wrap">
								<input id="inr_7" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_7']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>июль</span>
							</div>
							<div class="slider_wrap">
								<input id="inr_8" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_8']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>август</span>
							</div>
							<div class="slider_wrap">
								<input id="inr_9" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_9']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>сентябрь</span>
							</div>
							<div class="slider_wrap">
								<input id="inr_10" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_10']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>октябрь</span>
							</div>
							<div class="slider_wrap">
								<input id="inr_11" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_11']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>ноябрь</span>
							</div>
							<div class="slider_wrap">
								<input id="inr_12" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_12']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>декабрь</span>
							</div>
						<?}?>
					</div>
				</div>
				<div class="mdl-tabs__panel" id="opt">
					<div class="mdl-cell--hide-phone clearfix toggle two range_wrap">
						<?if(!empty($values)){?>
							<input type="hidden" name="opt_id_chart" value="<?=$values[1]['id_chart']?>">
							<?foreach($values[1] as $key => $value){
								if(strpos($key, 'value_') !== false){?>
									<div class="slider_wrap">
										<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$value?>" step="1" tabindex="0">
									</div>
								<?}
							}
						}else{?>
							<div class="slider_wrap">
								<input id="ino_1" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_1']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>январь</span>
							</div>
							<div class="slider_wrap">
								<input id="ino_2" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_2']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>февраль</span>
							</div>
							<div class="slider_wrap">
								<input id="ino_3" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_3']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>март</span>
							</div>
							<div class="slider_wrap">
								<input id="ino_4" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_4']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>апрель</span>
							</div>
							<div class="slider_wrap">
								<input id="ino_5" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_5']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>май</span>
							</div>
							<div class="slider_wrap">
								<input id="ino_6" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_6']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>июнь</span>
							</div>
							<div class="slider_wrap">
								<input id="ino_7" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_7']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>июль</span>
							</div>
							<div class="slider_wrap">
								<input id="ino_8" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_8']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>август</span>
							</div>
							<div class="slider_wrap">
								<input id="ino_9" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_9']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>сентябрь</span>
							</div>
							<div class="slider_wrap">
								<input id="ino_10" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_10']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>октябрь</span>
							</div>
							<div class="slider_wrap">
								<input id="ino_11" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_11']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>ноябрь</span>
							</div>
							<div class="slider_wrap">
								<input id="ino_12" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_12']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num">5</div>
								<span>декабрь</span>
							</div>
						<?}?>
					</div>
				</div>
			</div>
		</div>
	<?}?>

	<!-- Отображение подкатегорий в топе списка продуктов -->
	<?if (!empty($category['subcats'])) {?>
		<div id="owl-subcategories_slide_js" class="mobile_carousel mdl-cell--hide-desktop mdl-cell--hide-tablet">
			<?php foreach ($category['subcats'] as $value) {?>
				<a class="subCategory" href="<?=Link::Category($value['translit'])?>">
					<img src="<?=_base_url?><?=file_exists($category['category_img'])?$category['category_img']:'/images/nofoto.png'?>">	
					<span class="subCategoryTitle"><?=$value['name']?></span>
				</a>
			<?}?>
		</div>
	<?}?>

	<?if (!empty($category['subcats'])) {?>
		<div class="subCategories mobile_carousel mdl-cell--hide-phone hidden">
			<?php foreach ($category['subcats'] as $value) {?>
				<!--<a href="<?=Link::Category($value['translit'])?>"><?=$value['name']?></a><span class="separator">•</span>-->
				<a class="subCategory" href="<?=Link::Category($value['translit'], array('clear' => true))?>">
					<img class="hidden" src="<?=_base_url?><?=file_exists($category['category_img'])?$category['category_img']:'/images/nofoto.png'?>">
					<span class="subCategoryTitle"><?=$value['name']?></span>
				</a>
			<?}?>
		</div>
	<?}?>
	<div class="row">
		<?if(!empty($list)){?>
			<div class="content_header clearfix">
				<div class="sort imit_select">
					<span>Сортировать:</span>
					<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label">
						<select id="sorting" name="sorting" class="mdl-selectfield__select sorting_js" onChange="SortProductsList($(this));">
							<?foreach($available_sorting_values as $key => $alias){ ?>
								<option <?=isset($GLOBALS['Sort']) && $GLOBALS['Sort'] == $key?'selected':null;?> value="<?=!isset($GLOBALS['Rewrite'])?Link::Custom($GLOBALS['CurrentController'], null, array('sort' => $key)):Link::Category($GLOBALS['Rewrite'], array('sort' => $key));?>"><?=$alias?></option>
							<?}?>
						</select>
					</div>

					<!--<a href="#" class="graph_up hidden"><i class="material-icons">timeline</i></a>
				 	<?if(isset($_SESSION['member']) && $_SESSION['member']['gid'] == 0){?>
						<a href="#" class="show_demand_chart_js one"><i class="material-icons">timeline</i></a>
					<?}elseif(isset($_SESSION['member']) && $_SESSION['member']['gid'] == 1){?>
						<a href="#" class="show_demand_chart_js two"><i class="material-icons">timeline</i></a>
					<?}?> -->					
				</div>
				<?if(isset($_SESSION['member']) && $_SESSION['member']['gid'] == 1){?>
					<a href="#" class="show_demand_chart_js two mdl-cell--hide-phone" data-idcategory="<?=isset($GLOBALS['CURRENT_ID_CATEGORY'])?$GLOBALS['CURRENT_ID_CATEGORY']:0;?>"><i class="material-icons">timeline</i></a>
				<?}?>
				<div class="productsListView">
					<i id="changeToList" class="material-icons changeView_js <?=isset($_COOKIE['product_view']) && $_COOKIE['product_view'] == 'list' ? 'activeView' : NULL?>" data-view="list">view_list</i>
					<span class="mdl-tooltip" for="changeToList">Вид списком</span>
					<i id="changeToBlock" class="material-icons changeView_js <?=!isset($_COOKIE['product_view']) || $_COOKIE['product_view'] == 'block' ? 'activeView' : NULL?>" data-view="block">view_module</i>
					<span class="mdl-tooltip" for="changeToBlock">Вид блоками</span>
					<i id="changeToColumn" class="material-icons changeView_js hidden <?=isset($_COOKIE['product_view']) && $_COOKIE['product_view'] == 'column' ? 'activeView' : NULL?>" data-view="column">view_column</i>
					<span class="mdl-tooltip" for="changeToColumn">Вид колонками</span>
				</div>
				<div class="catalog_btn btn_js mdl-cell--hide-desktop" data-name="catalog">Каталог</div>
				<?=$cart_info;?>
			</div>
			<div id="view_block_js" class="<?=isset($_COOKIE['product_view'])?$_COOKIE['product_view'].'_view':'block_view'?> col-md-12 ajax_loading">
				<div class="row">
					<div class="products">
						<?=$products_list;?>
					</div>
					<div class="preview ajax_loading mdl-shadow--4dp">
						<div class="preview_content">
							<div class="mdl-grid" style="overflow: hidden;">
								<div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-tablet">
									<div id="owl-product_slide_js"></div>
								</div>
							</div>
						</div>
						<div class="triangle"></div>
						<div id="p2" class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
					</div>
					<?if(isset($cnt) && $cnt >= 30){?>
						<!-- <div class="sort_page sort_page_bottom">
							<?if($GLOBALS['CurrentController'] == 'search'){?>
								<a href="<?=_base_url?>/search/limitall/" <?=(isset($_GET['limit'])&&$_GET['limit']=='all')?'class="active"':null?>>Показать все</a>
							<?}else{?>
								<a href="<?=_base_url?>/products/<?=$curcat['id_category']?>/<?=$curcat['translit']?>/limitall/" <?=(isset($_GET['limit']) && $_GET['limit']=='all')?'class="active"':null?>>Показать все</a>
							<?}?>
						</div> -->
						<?if($GLOBALS['Page_id'] != $pages_cnt && $GLOBALS['CurrentController'] !== 'search'){?>
							<p class="show_more show_more_js"><a href="#" data-cnt="<?=$cnt;?>">Показать еще 30 товаров</a></p>
						<?}?>
					<?}?>
				</div>
			</div>
			<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>
		<?}else{?>
			<div class="col-md-12">
				<!-- Конец строк товаров!-->
				<?if(isset($_SESSION['member']) && $_SESSION['member']['gid'] == _ACL_TERMINAL_){?>
					<h5>Товары из этого раздела доступны только по предварительному заказу.</h5>
				<?}else{?>
					<h5>Товаров нет</h5>
				<?}?>
			</div>
		<?}?>
	</div>
</div><!--class="products"-->
<script>
	$('#owl-subcategories_slide_js').owlCarousel({
			center:			true,
			dots:			true,
			items:			1,
			lazyLoad:		true,
			/*loop:			true,*/
			margin:			20,
			nav:			true,
			/*video:			true,
			videoHeight:	345,
			videoWidth:		345,*/
			navText: [
				'<svg class="arrow_left"><use xlink:href="images/slider_arrows.svg#arrow_left_tidy"></use></svg>',
				'<svg class="arrow_right"><use xlink:href="images/slider_arrows.svg#arrow_right_tidy"></use></svg>'
			]
	});
	$(function(){
		<?if(isset($_COOKIE['product_view'])){?>
			// ChangeView('<?=$_COOKIE['product_view']?>');
		<?}?>
		$("#view_block_js").removeClass('ajax_loading');

		// var preview = $('.list_view .preview'),
		// 	previewOwl = preview.find('#owl-product_slide_js');

		ListenPhotoHover();//Инициализания Preview

		//Показать еще 30 товаров
		/*$('.show_more_js').on('click', function(e){
			e.preventDefault();
			var page = $(this).closest('.products_page'),
				id_category = current_id_category,
				start_page = parseInt(page.find('.paginator li.active').first().text()),
				current_page = parseInt(page.find('.paginator li.active').last().text()),
				next_page = current_page+1,
				shown_products = (page.find('.card').get()).length,
				skipped_products = 30*(start_page-1),
				count = $(this).data('cnt');
			console.log(page.find('.paginator li.active'));
			console.log('start_page '+start_page);
			console.log('shown_products '+shown_products);
			$('.show_more').append('<span class="load_more"></span>');
			var data = {
				action: 'getmoreproducts_desctop',
				id_category: id_category,
				shown_products: shown_products,
				skipped_products: skipped_products
			};
			ajax('products', 'getmoreproducts', data, 'html').done(function(data){
		   		var product_view = $.cookie('product_view'),
		   			show_count = parseInt((count-30)-parseInt(skipped_products+shown_products));
				page.find('.products').append(data);
				$("img.lazy").lazyload({
					effect : "fadeIn"
				});
		   		if(page.find('.paginator li.page'+next_page).length < 1){
					if(parseInt(count-parseInt(skipped_products+shown_products)+30) > 30){
						page.find('.paginator li.next_pages').addClass('active').find('a').attr('href','#');
					}else{
						page.find('.paginator li.last_page').addClass('active').find('a').attr('href','#');
					}
				}else{
					page.find('.paginator li.page'+next_page).addClass('active').find('a').attr('href','#');
				}

				if(show_count < 0){
					$('#show_more_products').hide();
				}

				//Инициализация добавления товара в избранное
				$('.preview_favorites').click(function(event) {
					id_product = $(this).attr('data-idfavorite');
					AddFavorite(event,id_product);
				});
				ListenPhotoHover();//Инициализания Preview

				//Добавление товара в корзину
				$('.qty_js').on('change', function(){
					var id =  $(this).closest('.product_buy').attr('data-idproduct'),
						qty  = $(this).val(),
						note = $(this).closest('.product_section').find('.note textarea').val();
					SendToAjax (id,qty,false,false,note);
				});
				$('.buy_btn_js').on('click', function (){
					var id =  $(this).closest('.product_buy').attr('data-idproduct'),
						qty = $(this).closest('.product_buy').find('.qty_js').val(),
						note = $(this).closest('.product_section').find('.note textarea').val();
					SendToAjax (id,qty,false,false,note);
				});

				$('.load_more').remove();
		   });
		});*/

	});

</script>