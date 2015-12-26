
<div class="products">
	<div class="row">
		<?if(!empty($list)){?>
			<div class="content_header mdl-cell--hide-phone clearfix">
				<div class="sort imit_select">
					<button id="sort-lower-left" class="mdl-button mdl-js-button">
						<i class="material-icons fleft">keyboard_arrow_down</i><span class="selected_sort select_fild"><?= $available_sorting_values[$sorting['value']]?></span>
					</button>

					<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="sort-lower-left">
								<?foreach($available_sorting_values as $key => $alias){?>

							<li class="mdl-menu__item sort <?=isset($sorting['value']) && $sorting['value'] == $key ? 'active' : NULL ?>" data-value="<?=$key?>" ><?=$alias?></li>
						<?}?>
					</ul>
				</div>
				<?=$cart_info;?>
			</div>

			<div id="view_block_js" class="list_view col-md-12 ajax_loading">
				<div class="row">
					<?=$products_list;?>
					<div class="preview ajax_loading">
						<div class="preview_content">
							<div class="col-md-6">
								<div id="owl-product_slide_js"></div>
								<div id="owl-product_slideDown_js"></div>
							</div>
							<div class="preview_info col-md-6">
								<h4></h4>
								<p class="product_article"><!--noindex-->aрт. <!--/<noindex--><span></span></p>
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
											<input type="hidden" name="reg" value="<?=isset($_SESSION['member']) && $_SESSION['member']['id_user'] != 4028?$_SESSION['member']['id_user']:null;?>">
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
								<!-- <form action="" class="note">
									<textarea cols="30" rows="3" placeholder="Примечание к заказу:"><?=isset($_SESSION['cart']['products'][$item['id_product']]['note_opt'])?$_SESSION['cart']['products'][$item['id_product']]['note_opt']:null?></textarea>
									<label class="info_key">?</label>
									<div class="info_description">
										<p>Поле для ввода примечания к товару</p>
									</div>
								</form> -->
								<a href="#" class="info_delivery">Информация о доставке</a>
							</div>
						</div>
						<div class="triangle"></div>
					</div>
					<?if(isset($cnt) && $cnt >= 30){?>
						<div class="sort_page sort_page_bottom">
							<?if($GLOBALS['CurrentController'] == 'search'){?>
								<a href="<?=_base_url?>/search/limitall/" <?=(isset($_GET['limit'])&&$_GET['limit']=='all')?'class="active"':null?>>Показать все</a>
							<?}else{?>
								<a href="<?=_base_url?>/products/<?=$curcat['id_category']?>/<?=$curcat['translit']?>/limitall/" <?=(isset($_GET['limit']) && $_GET['limit']=='all')?'class="active"':null?>>Показать все</a>
							<?}?>
						</div><!--class="sort_page"-->
						<?if($_GET['page_id'] != $pages_cnt && $GLOBALS['CurrentController'] !== 'search'){?>
							<p class="show_more"><a href="<?=_base_url?>/products/<?=$_GET['page_id']?>" id="show_more_products">Показать еще 30 товаров</a></p>
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
	$(window).load(function(){
		$("html,body").trigger("scroll");
	});
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
		$('#show_more_products').on('click', function(e){
			e.preventDefault();
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
				type: "GET",
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

		   		if(show_count < 0){
		   			$('#show_more_products').hide();
		   		}

		   		if(product_view != 'list'){ //Инициализания модульного просмотра
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

				$('.load_more').remove();
		   });
		});

	});

</script>