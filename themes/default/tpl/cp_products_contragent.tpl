<?if(!empty($list) && empty($subcats)){?>
	<div class="sorting">
		<!--Сортировка по названию !-->
		<!--<?if(!isset($_GET['search_in_cat'])){?>
			<form action="" method="POST">
				<?if(in_array('sorting', $list_controls)){?>
					<label for="sort_prod">Сортировка</label>
					<select id="sort_prod" name="value" data-role="none" onchange="$(this).closest('form').submit();">
						<?foreach($available_sorting_values as $key => $alias){?>
							<option value="<?=$key?>" <?=isset($sorting['value']) && $sorting['value'] == $key?'selected="selected"':null;?>><?=$alias?></option>
						<?}?>
					</select>
					<select name="direction" data-role="none" class="hidden" onchange="$(this).closest('form').submit();">
						<option value="asc" <?=isset($sorting['direction']) && $sorting['direction'] == 'asc'?'selected="selected"':null;?>>по возрастанию</option>
						<option value="desc" <?=isset($sorting['direction']) && $sorting['direction'] == 'desc'?'selected="selected"':null;?>>по убыванию</option>
					</select>
				<?}?>
			</form>
		<?}?>-->
		<!--сортировка по названию!-->
		<!--<div class="prod_structure">
			<span class="icon-font list">view_list</span>
			<span class="icon-font module disabled">view_module</span>
		</div>-->
	</div>
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
		<div class="productsListView">
			<i id="changeToList" class="material-icons changeView_js <?=isset($_COOKIE['product_view']) && $_COOKIE['product_view'] == 'list' ? 'activeView' : NULL?>" data-view="list">view_list</i>
			<span class="mdl-tooltip" for="changeToList">Вид списком</span>
			<i id="changeToBlock" class="material-icons changeView_js <?=isset($_COOKIE['product_view']) && $_COOKIE['product_view'] == 'block' ? 'activeView' : NULL?>" data-view="block">view_module</i>
			<span class="mdl-tooltip" for="changeToBlock">Вид блоками</span>
			<i id="changeToColumn" class="material-icons changeView_js hidden <?=isset($_COOKIE['product_view']) && $_COOKIE['product_view'] == 'column' ? 'activeView' : NULL?>" data-view="column">view_column</i>
			<span class="mdl-tooltip" for="changeToColumn">Вид колонками</span>
		</div>
		<div class="catalog_btn btn_js mdl-cell--hide-desktop" data-name="catalog">Каталог</div>
	</div>
<?}?>
<div class="products">
	<!-- SHOWCASE SLIDER -->
	<div id="showcase_bg" class="showcase_bg"></div>
	<div id="showcase" class="showcase paper_shadow_1"></div>
	<?if(isset($subcats) && !empty($subcats)){?>
		<ul class="subcats row">
			<?foreach($subcats as $sub){
				$url = _base_url.'/products/'.$sub['id_category'].'/'.$sub['translit'].'/';
				if($sub['subcats'] !== 0){
					$url .= 'limitall/';
				}?>
				<li class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<a href="<?=$url;?>" class="animate">
						<div class="subcats_block">
							<div>
								<img class="lazy" data-original="<?=_base_url?>/efiles/katalog/<?=$sub['translit']?>.jpg" alt="<?=$sub['name']?>"/>
								<noscript>
									<img src="<?=_base_url?>/efiles/katalog/<?=$sub['translit']?>.jpg" alt="<?=$sub['name']?>"/>
								</noscript>
							</div>
							<div>
								<span class="color-grey"><?=$sub['name']?></span>
							</div>
						</div>
					</a>
				</li>
			<?}?>
		</ul>
		<?if (isset($curcat['content']) && $curcat['content'] != '') {?>
			<div class="content_wrapp">
				<input type="checkbox" id="read_more" class="hidden">
				<section class="content_text animate">
					<?=$curcat['content']?>
				</section>
				<?if (strlen($curcat['content']) >= 500) {?>
					<label for="read_more">Читать полностью</label>
				<?}?>
			</div>
		<?}?>
	<?}else{?>
		<div class="row">
			<form action="<?=$GLOBALS['URL_request']?>" method="POST" class="price_mode_container">
				<?if($_SESSION['price_mode'] == 0){?>
					<button name="price_mode" value="1" class="btn-m-blue">Переключить на дилерские цены</button>
				<?}elseif($_SESSION['price_mode'] == 1){?>
					<button name="price_mode" value="0" class="btn-m-green">Переключить на общие цены</button>
				<?}?>
			</form>
			<?if(!empty($list)){?>
				<!-- <form id="cart_discount_and_margin_parameters">
					<input type="hidden" id="cart_full_wholesale_order_margin" value="<?$GLOBALS['CONFIG']['full_wholesale_order_margin']?>"/>
					<input type="hidden" id="cart_full_wholesale_discount" value="<?$GLOBALS['CONFIG']['full_wholesale_discount']?>"/>
					<input type="hidden" id="cart_wholesale_order_margin" value="<?$GLOBALS['CONFIG']['wholesale_order_margin']?>"/>
					<input type="hidden" id="cart_wholesale_discount" value="<?$GLOBALS['CONFIG']['wholesale_discount']?>"/>
					<input type="hidden" id="cart_retail_order_margin" value="<?$GLOBALS['CONFIG']['retail_order_margin']?>"/>
					<input type="hidden" id="cart_retail_multiplyer" value="<?$GLOBALS['CONFIG']['retail_multiplyer']?>"/>
					<input type="hidden" id="cart_personal_discount" value="<?=isset($_SESSION['cart']['personal_discount'])?$_SESSION['cart']['personal_discount']:'1';?>"/>
					<input type="hidden" id="cart_price_mode" value="<?$_SESSION['price_mode']?>"/>
				</form> -->
				<form action="<?=$_SERVER['REQUEST_URI']?>/" method="POST">
					<button name="sort_name" id="sort_name" style="display: none;"></button>
					<button name="sort_price" id="sort_price_asc" value="asc" style="display: none;"></button>
					<button name="sort_price" id="sort_price_desc" value="desc" style="display: none;"></button>
				</form>
				<?if($_SESSION['price_mode'] == 0){?>
				<div class="col-md-12">
					<div class="tabs_container">
						<div class="row">
							<div class="tabs_block col-md-3  col-xs-12">
								<button onclick="ChangePriceRange(0);" class="sum_range sum_range_0 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 0)?'user_active':null;?>">
									<span class="tabs_block_descr">При сумме заказа более <?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?><!--noindex-->грн.<!--/noindex--></span>
									<label class="info_key">?</label>
									<div class="info_description">
										<p>В каталоге будут отображены цены товаров при общей сумме заказа более <?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?><!--noindex-->грн.<!--/noindex--></p>
									</div>
								</button>
							</div>
							<div class="tabs_block col-md-3  col-xs-12">
								<button onclick="ChangePriceRange(1);" class="sum_range sum_range_1 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 1)?'user_active':null;?>">
									<span class="tabs_block_descr">При сумме заказа <?=$GLOBALS['CONFIG']['wholesale_order_margin']?>-<?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?><!--noindex-->грн.<!--/noindex--></span>
									<label class="info_key">?</label>
									<div class="info_description">
										<p>В каталоге будут отображены цены товаров при общей сумме заказа от <?=$GLOBALS['CONFIG']['wholesale_order_margin']?> до <?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?><!--noindex-->грн.<!--/noindex--></p>
									</div>
								</button>
							</div>
							<div class="tabs_block col-md-3  col-xs-12">
								<button onclick="ChangePriceRange(2);" class="sum_range sum_range_2 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 2)?'user_active':null;?>">
									<span class="tabs_block_descr">При сумме заказа <?=$GLOBALS['CONFIG']['retail_order_margin']?>-<?=$GLOBALS['CONFIG']['wholesale_order_margin']?><!--noindex-->грн.<!--/noindex--></span>
									<label class="info_key">?</label>
									<div class="info_description">
										<p>В каталоге будут отображены цены товаров при общей сумме заказа от <?=$GLOBALS['CONFIG']['retail_order_margin']?> до <?=$GLOBALS['CONFIG']['wholesale_order_margin']?><!--noindex-->грн.<!--/noindex--></p>
									</div>
								</button>
							</div>
							<div class="tabs_block col-md-3 col-xs-12">
								<button onclick="ChangePriceRange(3);" class="sum_range sum_range_3 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 3)?'user_active':null;?>">
									<span class="tabs_block_descr">При сумме заказа до <?=$GLOBALS['CONFIG']['retail_order_margin']?><!--noindex-->грн.<!--/noindex--></span>
									<label class="info_key">?</label>
									<div class="info_description">
										<p>В каталоге будут отображены цены товаров при общей сумме заказа до <?=$GLOBALS['CONFIG']['retail_order_margin']?><!--noindex-->грн.<!--/noindex--></p>
									</div>
								</button>
							</div>
						</div>
					</div>
				</div>
				<?}?>
				<div id="view_block_js" class="list_view col-md-12 ajax_loading">
					<div class="row">
						<div class="products">
							<?=$products_list;?>
						</div>
						<div class="preview ajax_loading">
							<div class="preview_content">
								<div class="col-md-6">
									<div id="owl-product_slide_js">
										<div class="item"><img src="<?=_base_url?><?=$item['img_1']?>" alt="<?=$item['name']?>"></div>
										<div class="item"><img src="<?=_base_url?><?=$item['img_1']?>" alt="<?=$item['name']?>"></div>
										<div class="item"><img src="<?=_base_url?><?=$item['img_1']?>" alt="<?=$item['name']?>"></div>
									</div>
									<div id="owl-product_slideDown_js">
										<div class="item"><img src="<?=_base_url?><?=$item['img_1']?>" alt="<?=$item['name']?>"></div>
										<div class="item"><img src="<?=_base_url?><?=$item['img_1']?>" alt="<?=$item['name']?>"></div>
										<div class="item"><img src="<?=_base_url?><?=$item['img_1']?>" alt="<?=$item['name']?>"></div>
										<div class="item"><img src="<?=_base_url?><?=$item['img_1']?>" alt="<?=$item['name']?>"></div>
									</div>
								</div>
								<div class="preview_info col-md-6">
									<h4></h4>
									<p class="product_article"><!--noindex-->арт. <!--/<noindex--><span></span></p>
									<p class="product_description"></p>
									<div class="product_buy">
										<div class="buy_block">
											<div class="active_price">
												<span class="price_js"></span>
												<!--noindex--> грн.<!--/noindex-->
											</div>
											<div class="buy_buttons">
												<!--удаление товара оптом из корзины-->
												<a href="#" class="icon-font" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 0);return false;">remove</a>
												<input type="text" class="qty_js" value="0">
												<a href="#"	class="icon-font" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1);return false;">add</a>
												<!--количество заказываемых товаров-->
											</div>
											<div class="buy_btn_block">
												<button class="btn-m-orange buy_btn_js" type="button">Купить</button>
												<a href="<?=_base_url?>/cart/" class="in_cart_js hidden<?=G::IsLogged()?null:' open_modal" data-target="login_form';?>" title="Перейти в корзину">В корзине</a>
												<span class="not_available">Товара нет в наличии</span>
											</div>
										</div>
										<div class="other_price">
											<span class="price_js"></span>
											<!--noindex--> грн.<!--/noindex-->
											<span class="mode_js"></span>
											<span class="units_js"></span>
											<p class="qty_descr"></p>
										</div>
									</div>
									<div class="row">
										<div class="specifications col-md-6 hidden">
											<ul>
												<li><span class="spec"></span><span class="unit"></span></li>
												<li><span class="spec"></span><span class="unit"></span></li>
												<li><span class="spec"></span><span class="unit"></span></li>
												<li><span class="spec"></span><span class="unit"></span></li>
												<li><span class="spec"></span><span class="unit"></span></li>
											</ul>
											<a href="#" class="all_specifications">Все характеристики</a>
										</div>
										<div class="product_info col-md-6">
											<div class="preview_favorites">
												<span class="icon-font favorite"></span>
												<a href="#">В избранное</a>
											</div>
											<div class="preview_follprice">
												<p><span class="icon-font">Line</span><a href="#">Следить за ценой</a></p>
												<input type="hidden" name="reg" value="<?=isset($_SESSION['member']) && $_SESSION['member']['id_user'] != 4028?$_SESSION['member']['email']:null;?>">
												<div class="enter_mail">
													<form>
														<input name="user_email" type="email" placeholder="Введите email" autofocus required>
														<a href="#" id="cancel_follow_js" class="fright">Отмена</a>
														<button id="follow_price" type="submit" class="btn-s-green fleft">Подписаться</button>
													</form>
												</div>
											</div>
											<a href="#" class="rating">
												<ul class="rating_stars"></ul>
												<span class="comments"></span>
											</a>
											<div class="preview_socials">
												<a rel="nofollow" href="#" class="vk animate" title="Вконтакте" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
													<span class="icon-font">vk</span>
												</a>
												<a rel="nofollow" href="#" class="ok animate" title="Одноклассники" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
													<span class="icon-font">odnoklassniki</span>
												</a>
												<a rel="nofollow" href="#" class="ggl animate" title="Google+" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
													<span class="icon-font">g+</span>
												</a>
												<a rel="nofollow" href="#" class="fb animate" title="Facebook" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
													<span class="icon-font">facebook</span>
												</a>
												<a rel="nofollow" href="#" class="tw animate" title="Twitter" target="external" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false">
													<span class="icon-font">twitter</span>
												</a>
											</div>
										</div>
									</div>
									<a href="#" class="info_delivery">Информация о доставке</a>
								</div>
							</div>
							<div class="triangle"></div>
						</div>
						<?if(isset($cnt) && $cnt >= 30){?>
							<div class="sort_page sort_page_bottom">
								<?if ($GLOBALS['CurrentController'] == 'search') {?>
									<a href="<?=_base_url?>/search/limitall/" <?=(isset($_GET['limit'])&&$_GET['limit']=='all')?'class="active"':null?>>Показать все</a>
								<?}else{?>
									<a href="<?=_base_url?>/products/<?=$curcat['id_category']?>/<?=$curcat['translit']?>/limitall/" <?=(isset($_GET['limit']) && $_GET['limit']=='all')?'class="active"':null?>>Показать все</a>
								<?}?>
							</div><!--class="sort_page"-->
							<?if ($_GET['page_id'] != $pages_cnt && $GLOBALS['CurrentController'] !== 'search') {?>
								<p class="show_more"><a href="#" id="show_more_products">Показать еще 30 товаров</a></p>
							<?}?>
						<?}?>
					</div>
				</div>
				<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>
				<!-- <style>
					@import url("//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css");
				</style>
				<div class="dialog_duplicate hidden" title="Отметка дубля">
					<input type="hidden" name="id">
					<p>Отметить товар <span></span> как дубль.</p>
					<input type="text" name="duplicate_comment" placeholder="Артикул основного товара">
					<button class="btn-m-green" onclick="">Отправить</button>
				</div> -->
				<!-- <div id="comment_question" class="modal_hidden">
					<h4>Отзывы и вопросы</h4>
					<hr>
					<p>У Вашего клиента возник вопрос?<br>Напишите его</p>
					<form action="" method="post">
						<input type="hidden" name="id_product">
						<textarea name="feedback_text" id="feedback_text" cols="30" rows="8" required></textarea>
						<button type="submit" name="com_qtn" class="btn-m-green">Отправить</button>
					</form>
				</div> -->
			<?}else{?>
				<!-- Конец строк товаров!-->
				<h5 class="col-md-12">Товаров нет</h5>
			<?}?>
		</div>
	<?}?>
</div><!--class="products"-->
<script>
	$(function(){
		<?if(isset($_COOKIE['product_view'])){?>
			ChangeView('<?=$_COOKIE['product_view']?>');
		<?}?>
		$("#view_block_js").removeClass('ajax_loading');

		var preview = $('.list_view .preview'),
			previewOwl = preview.find('#owl-product_slide_js'),
			previewDownOwl = preview.find('#owl-product_slideDown_js');

		ListenPhotoHover();//Инициализания Preview

		//Показать еще 30 товаров
		$('#show_more_products').on('click', function(){
			var page = $(this).closest('.products'),
				id_category = <?=isset($GLOBALS['CURRENT_ID_CATEGORY'])?$GLOBALS['CURRENT_ID_CATEGORY']:'null';?>,
				start_page = parseInt(page.find('.paginator li.active').first().text()),
				current_page = parseInt(page.find('.paginator li.active').last().text()),
				next_page = current_page+1,
				shown_products = (page.find('.product_section').get()).length,
				skipped_products = 30*(start_page-1),
				count = <?=isset($cnt)?$cnt:0;?>;
			$('.show_more').append('<span class="load_more"></span>');
			$.ajax({
				url: URL_base+"ajaxcat",
				type: "POST",
				data: ({
				 'action': 'getmoreproducts_desctop',
				 'id_category': id_category,
				 'shown_products': shown_products,
				 'skipped_products': skipped_products
				}),
		   	}).done(function(data){
		   		var product_view = $.cookie('product_view'),
		   			show_count = parseInt((count-30)-parseInt(skipped_products+shown_products));
		   			page.find('#view_block_js .preview').before(data);
		   		if(page.find('.paginator li.page'+next_page).length < 1){
					if(parseInt(count-parseInt(skipped_products+shown_products)+30) > 30){
						page.find('.paginator li.next_pages').addClass('active').find('a').attr('href','#');
					}else{
						page.find('.paginator li.last_page').addClass('active').find('a').attr('href','#');
					}
				}else{
					page.find('.paginator li.page'+next_page).addClass('active').find('a').attr('href','#');
				}

		   		if (show_count < 0) {
		   			$('#show_more_products').hide();
		   		}

		   		if (product_view != 'list') { //Инициализания модульного просмотра
		   			ChangeView('module');
		   		}

				ListenPhotoHover(); //Инициализания Preview

				//Инициализация добавления товара в избранное
				$('.preview_favorites').click(function(event) {
					id_product = $(this).attr('data-idfavorite');
					AddFavorite(event,id_product);
				});

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

				//Дубликаты  товаров
				$('[class^="duplicate_check_"]').on('click', function(e){
					e.preventDefault();
					$('.dialog_duplicate').dialog('open');
					var id = $(this).prop('class').replace(/[^0-9\.]+/g, '');
					var art = $(this).next().val();
					$('.dialog_duplicate input[name="id"]').val(id);
					$('.dialog_duplicate p span').text(art);
					var onclick='ToggleDuplicate('+id+',<?=$_SESSION["member"]["id_user"]?>, $(\'.dialog_duplicate input[name="duplicate_comment"]\').val());$(\'.dialog_duplicate\').dialog(\'close\');$(\'.duplicate_check_'+id+'\').prop(\'checked\', true);$(\'.duplicate_check_'+id+'\').prop(\'disabled\', true);';
					$('.dialog_duplicate button').attr('onclick', onclick);
				});
				$('.load_more').remove();
		   });
		});

		$('.comment_question').on('click', function() {
			var id = $(this).closest('.product_section').find('.product_buy').data('idproduct');
			$('#comment_question [name="id_product"]').val(id);
		});
	});
</script>