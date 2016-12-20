<h1><?=$header?></h1>
<div class="products_page">
	<!-- Отображение подкатегорий в топе списка продуктов -->
	<?if(!empty($category['subcats'])){?>
		<div id="owl-subcategories_slide_js" class="mobile_carousel mdl-cell--hide-desktop mdl-cell--hide-tablet">
			<?php foreach ($category['subcats'] as $value) {?>
				<a class="subCategory" href="<?=Link::Category($value['translit'])?>">
					<span class="subCategoryImageWrap">
						<img src="<?=_base_url?><?=file_exists($category['category_img'])?$category['category_img']:'/images/nofoto.png'?>" alt="<?=htmlspecialchars($value['name']);?>">
					</span>
					<span class="subCategoryTitleWrap">
						<span class="subCategoryTitle"><?=$value['name']?></span>
					</span>
				</a>
			<?}?>
		</div>
	<?}?>
	<?if(!empty($category['subcats'])){?>
		<div class="subCategories mdl-cell--hide-phone">
			<?php foreach ($category['subcats'] as $value) {?>
				<a class="subCategory" href="<?=Link::Category($value['translit'], array('clear' => true))?>">
					<span class="subCategoryImageWrap">
						<img src="<?=_base_url?><?=!empty($value['category_img'])?$value['category_img']:'/images/nofoto.png'?>" alt="<?=htmlspecialchars($value['name']);?>">
					</span>
					<span class="subCategoryTitleWrap">
						<span class="subCategoryTitle"><?=$value['name']?></span>
					</span>
				</a>
			<?}?>
		</div>
	<?}?>
	<?if((isset($chart_html) && !empty($chart_html)) && $GLOBALS['CurrentController'] != 'search'){?>
		<div class="avg_chart_wrap mdl-cell--hide-tablet mdl-cell--hide-phone">
			<div class="avg_chart_det_wrap">
				<div class="chart_title">График спроса категории</div>
				<div class="line_det">
					<span class="legenda roz"><i></i> - Розничный</span>
					<span class="legenda opt"><i></i> - Оптовый</span>
				</div>
			</div>
			<?=$chart_html;?>
			<div class="avg_chart_det_wrap">
				<div id="details_btn" data-idcategory="<?=isset($GLOBALS['CURRENT_ID_CATEGORY'])?$GLOBALS['CURRENT_ID_CATEGORY']:0;?>" class="avg_chart_det_btn avg_chart_det_btn_js mdl-button mdl-js-button <?=$chart_details?'hidden':null?>">Детали<i class="material-icons">&#xE315;</i></div>
			</div>
			<div class="charts_container">
				<div class="charts_title hidden">Графики, на основании которых построен график средних значений</div>
				<div class="charts_wrap mdl-grid"></div>
			</div>
		</div>
	<?}?>
	<div class="row">
		<?if(!empty($list)){?>
			<div class="content_header">
				<?=$cart_info;?>
				<div class="list_settings">
					<div class="sort">
						<label class="mdl-cell--hide-tablet mdl-cell--hide-desktop"><i class="material-icons">sort</i></label>
						<label class="mdl-cell--hide-phone">Сортировать:</label>
						<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label">
							<label for="sorting" class="hidden">Сортировка</label>
							<select id="sorting" name="sorting" class="mdl-selectfield__select sorting_js" onChange="SortProductsList($(this));">
								<?foreach($available_sorting_values as $key => $alias){ ?>
									<option <?=isset($GLOBALS['Sort']) && $GLOBALS['Sort'] == $key?'selected':null;?> value="<?=!isset($GLOBALS['Rewrite'])?Link::Custom($GLOBALS['CurrentController'], null, array('sort' => $key)):Link::Category($GLOBALS['Rewrite'], array('sort' => $key));?>"><?=$alias?></option>
								<?}?>
							</select>
						</div>
					</div>
					<div class="productsListView">
						<label class="mdl-cell--hide-phone">Вид:</label>
						<i id="changeToList" class="material-icons changeView_js <?=isset($_COOKIE['product_view']) && $_COOKIE['product_view'] == 'list' ? 'activeView' : NULL?>" data-view="list">view_list</i>
						<span class="mdl-tooltip" for="changeToList">Списком</span>
						<i id="changeToBlock" class="material-icons changeView_js <?=!isset($_COOKIE['product_view']) || $_COOKIE['product_view'] == 'block' ? 'activeView' : NULL?>" data-view="block">view_module</i>
						<span class="mdl-tooltip" for="changeToBlock">Блоками</span>
						<i id="changeToColumn" class="material-icons changeView_js hidden <?=isset($_COOKIE['product_view']) && $_COOKIE['product_view'] == 'column' ? 'activeView' : NULL?>" data-view="column">view_column</i>
						<span class="mdl-tooltip" for="changeToColumn">Колонками</span>
					</div>
					<?if(isset($_SESSION['member']) && in_array($_SESSION['member']['gid'], array(1, 2, 9))){?>
						<a href="#" class="show_demand_chart_js two mdl-cell--hide-phone mdl-cell--hide-tablet" data-idcategory="<?=isset($GLOBALS['CURRENT_ID_CATEGORY'])?$GLOBALS['CURRENT_ID_CATEGORY']:0;?>"><i class="material-icons">timeline</i></a>
					<?}?>
				</div>
			</div>
			<?/*if(isset($list_categories)){?>
				<?foreach($list_categories as &$v){?>
					<a href="<?=_base_url?>/<?=$v['translit']?>/?query=<?=$_SESSION['search']['query']?>&search_subcategory=<?=$v['id_category']?>"><input type="button" value="<?=$v['name']. ' ('. $v['count'].')'?>"></a>&nbsp;&nbsp;
				<?}?>
			<?}*/?>
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
	// $('#owl-subcategories_slide_js').owlCarousel({
	// 		center:			true,
	// 		dots:			true,
	// 		items:			1,
	// 		lazyLoad:		true,
	// 		margin:			20,
	// 		nav:			true,
	// 		navText: [
	// 			'<svg class="arrow_left"><use xlink:href="images/slider_arrows.svg#arrow_left_tidy"></use></svg>',
	// 			'<svg class="arrow_right"><use xlink:href="images/slider_arrows.svg#arrow_right_tidy"></use></svg>'
	// 		]
	// });
	$(function(){
		<?if(isset($_COOKIE['product_view'])){?>
			// ChangeView('<?=$_COOKIE['product_view']?>');
		<?}?>
		$("#view_block_js").removeClass('ajax_loading');

		// var preview = $('.list_view .preview'),
		// 	previewOwl = preview.find('#owl-product_slide_js');

		/* Открытие фильтров моб.вид */
		$('.filters_mob_btn_js').on('click', function(){
			if($('.activeFilters_js').hasClass('active') === false) {
				var name = $('.activeFilters_js').find('i').text();
				if (name == 'filter_list') {
					$('.activeFilters_js').find('i').text('highlight_off');
					$('.activeFilters_js').find('span.title').text('Скрыть');
					$('.second_nav, .news ').slideUp();
					$('.included_filters').hide();
					$('.filters').fadeIn();
					$('.activeFilters_js').addClass('active');
				}
			}
		});
	});

</script>