<div class="products_page">
	<div class="row">
		<?if(!empty($list)){ ?>
			<div class="content_header clearfix">
				<div class="sort imit_select">
					<button id="sort-lower-left" class="mdl-button mdl-js-button">
						<i class="material-icons fleft">keyboard_arrow_down</i><span class="selected_sort select_fild"><?= $available_sorting_values[$sorting['value']]?></span>
					</button>

					<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="sort-lower-left">
						<?foreach($available_sorting_values as $key => $alias){ ?>
							<a href="<?=Link::Category($GLOBALS['Rewrite'], array('sort' => $key))?>">
								<li class="mdl-menu__item sort <?=isset($sorting['value']) && $sorting['value'] == $key ? 'active' : NULL ?>" data-value="<?=$key?>" >
									<?=$alias?>
								</li>
							</a>
						<?}?>
					</ul>

					<!-- <a href="#" class="graph_up hidden"><i class="material-icons">timeline</i></a> -->
					<?if(isset($_SESSION['member']) && $_SESSION['member']['gid'] == 0){?>
						<a href="#" class="xgraph_up one"><i class="material-icons">timeline</i></a>
					<?}elseif(isset($_SESSION['member']) && $_SESSION['member']['gid'] == 1){?>
						<a href="#" class="xgraph_up two"><i class="material-icons">timeline</i></a>
					<?}?>

				</div>
				<?=$cart_info;?>
			</div>

			<div id="view_block_js" class="list_view col-md-12 ajax_loading">
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
							<p class="show_more"><a href="#" id="show_more_products">Показать еще 30 товаров</a></p>
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
	$(function(){
		<?if(isset($_COOKIE['product_view'])){?>
			// ChangeView('<?=$_COOKIE['product_view']?>');
		<?}?>
		$("#view_block_js").removeClass('ajax_loading');

		// var preview = $('.list_view .preview'),
		// 	previewOwl = preview.find('#owl-product_slide_js');

		ListenPhotoHover();//Инициализания Preview

		//Показать еще 30 товаров
		$('#show_more_products').on('click', function(e){
			e.preventDefault();
			var page = $(this).closest('.products_page'),
				id_category = <?=isset($GLOBALS['CURRENT_ID_CATEGORY'])?$GLOBALS['CURRENT_ID_CATEGORY']:'null';?>,
				start_page = parseInt(page.find('.paginator li.active').first().text()),
				current_page = parseInt(page.find('.paginator li.active').last().text()),
				next_page = current_page+1,
				shown_products = (page.find('.card').get()).length,
				skipped_products = 30*(start_page-1),
				count = <?=isset($cnt)?$cnt:0;?>;
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

		   		if(product_view != 'list'){ //Инициализания модульного просмотра
		   			ChangeView('module');
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
		});

	});

</script>