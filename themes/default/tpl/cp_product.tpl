<div class="product mdl-grid">
	<?$Status = new Status();
	$st = $Status->GetStstusById($item['id_product']);
	// Проверяем доступнось розницы
	($item['price_mopt'] > 0 && $item['min_mopt_qty'] > 0)?$mopt_available = true:$mopt_available = false;
	// Проверяем доступнось опта
	($item['price_opt'] > 0 && $item['inbox_qty'] > 0)?$opt_available = true:$opt_available = false;?>
	<!-- SHOWCASE SLIDER -->

	<div class="mdl-cell mdl-cell--12-col">
		<h1><?=$item['name']?></h1>
	</div>
	<div class="mdl-cell mdl-cell--5-col mdl-cell--4-col-tablet mdl-cell--12-col-phone">
		<p class="product_article">Арт: <?=$item['art']?></p>
		<?if(isset($_SESSION['member']) && in_array($_SESSION['member']['gid'], array(1, 9))){?>
			<!-- Ссыдка на редактирование товара для администратором -->
			<a href="<?=Link::Custom('adm', 'productedit');?><?=$item['id_product']?>" target="_blank">Редактировать товар</a>
		<?}?>
		<div class="product_main_img btn_js mdl-cell--hide-phone" data-name="big_photo">


			<?if(!empty($item['images'])){?>
				<img alt="<?=G::CropString($item['id_product'])?>" src="<?=_base_url?><?=file_exists($GLOBALS['PATH_root'].$item['images'][0]['src'])?$item['images'][0]['src']:'/efiles/_thumb/nofoto.jpg'?>"/>
			<?}else{?>
				<img alt="<?=G::CropString($item['id_product'])?>" src="<?=_base_url?><?=$item['img_1']?htmlspecialchars($item['img_1']):"/images/nofoto.jpg"?>"/>
			<?}?>
			<div id="mainVideoBlock" class="hidden">
				<iframe width="100%" height="100%" src="" frameborder="0" allowfullscreen></iframe>
			</div>
		</div>
		<?if($_SESSION['client']['user_agent'] == 'mobile'){?>
			<style>
				@media (max-width: 727px){
					.product .mdl-cell {
						padding-right: 0;
					}
					.product_page h1 {
						margin: 0;
						padding: 0;
					}
					.breadcrumbs_wrapp {
						white-space: nowrap;
						overflow-x: overlay;
						overflow-y: hidden;
						padding-bottom: 10px;
					}
					.breadcrumbs_wrapp a {
						font-weight: 300;
					}
					.breadcrumbs_wrapp i {
						font-size: 18px;
						margin: 0;
					}
					.owl-pagination {
						padding: 5px 0;
					}
					.mobile_carousel .owl-item img {
						max-width: 100%;
					}
					.owl-page {
						width: 20px;
					}
					.owl-page span {
						display: block;
						width: 0;
						height: 0;
						background: #888;
						border-radius: 50%;
						margin: 0 auto;
						transition: all 0.4s ease-in-out;
						border: 3px solid #888;
					}
					.owl-page.active span {
						border: 7px solid #888;
					}
					.tabs .mdl-tabs__tab {
						width: 170px;
					}
					.fortabs {
						/*white-space: nowrap;
						overflow: scroll;
						overflow-x: hidden; */
						padding-bottom: 10px;
						overflow-x: overlay;
						overflow-y: hidden;
					}
				}
			</style>

			<div id="owl-product_mobile_img_js" class="mobile_carousel">
				<?if(!empty($item['images'])){
					foreach($item['images'] as $i => $image){?>
						<img src="<?=_base_url?><?=file_exists($GLOBALS['PATH_root'].str_replace('original', 'medium', $image['src']))?str_replace('original', 'medium', $image['src']):'/efiles/nofoto.jpg'?>" alt="<?=$item['name']?>">
					<?}
				}else{
					for($i=1; $i < 4; $i++){
						if(!empty($item['img_'.$i])){?>
							<img src="<?=_base_url?><?=$item['img_'.$i]?str_replace('/image/', '/image/500/', $item['img_'.$i]):'/efiles/nofoto.jpg'?>" alt="<?=$item['name']?>">
						<?}
					}
				}?>
			</div>
			<script>
				//Инициализация owl carousel
				$("#owl-product_mobile_img_js").owlCarousel({
					items: 6,
					itemsCustom: [[320, 1], [727, 2], [950, 3], [1250, 4], [1600, 5]],
					navigation: true, // Show next and prev buttons
					pagination: true,
					navigationText: ['<svg class="arrow_left"><use xlink:href="images/slider_arrows.svg#arrow_left_tidy"></use></svg>',
									'<svg class="arrow_right"><use xlink:href="images/slider_arrows.svg#arrow_right_tidy"></use></svg>']
				});
			</script>
		<?}else{?>
			<div id="owl-product_mini_img_js">
				<?if(!empty($item['images'])){
					foreach($item['images'] as $i => $image){?>
						<img src="<?=_base_url?><?=file_exists($GLOBALS['PATH_root'].str_replace('original', 'thumb', $image['src']))?str_replace('original', 'thumb', $image['src']):'/efiles/nofoto.jpg'?>" alt="<?=$item['name']?>"<?=$i==0?' class="act_img"':null;?>>
					<?}
				}else{
					for($i=1; $i < 4; $i++){
						if(!empty($item['img_'.$i])){?>
							<img src="<?=_base_url?><?=$item['img_'.$i]?str_replace('/efiles/', '/efiles/_thumb/', $item['img_'.$i]):'/efiles/nofoto.jpg'?>" alt="<?=$item['name']?>"<?=$i==1?' class="act_img"':null;?>>
						<?}
					}
				}?>
				<!-- Код добавления видео начало-->
				<?if(!empty($item['videos'])){
					foreach($item['videos'] as $i => $video){?>
					<div class="videoBlock">
						<div class="videoBlockShield"></div>
						<iframe width="120" height="120" src="<?=str_replace('watch?v=', 'embed/', $video)?><?=file_exists($GLOBALS['PATH_root'].str_replace('watch?v=', 'embed/', $video))?str_replace('watch?v=', 'embed/', $video):'/efiles/nofoto.jpg'?>" frameborder="0" allowfullscreen alt="<?=$item['name']?>">
						</iframe>
					</div>
					<?}
				}?>
				<!-- Код добавления видео конец-->
			</div>
			<script>
				//Инициализация owl carousel
				$("#owl-product_mini_img_js").owlCarousel({
					items: 4,
					itemsCustom: [[320, 1], [727, 2], [950, 3], [1250, 3], [1600, 4]],
					navigation: true, // Show next and prev buttons
					pagination: false,
					navigationText: ['<svg class="arrow_left"><use xlink:href="images/slider_arrows.svg#arrow_left_tidy"></use></svg>',
									'<svg class="arrow_right"><use xlink:href="images/slider_arrows.svg#arrow_right_tidy"></use></svg>']
				});
				$(function(){
					//Слайдер миниатюр картинок.
					$('#owl-product_mini_img_js .item').on('click', function(event) {
						var src = $(this).find('img').attr('src');
						var viewport_width = $(window).width();
						console.log(src);
						if(viewport_width > 711){
							$('#owl-product_slide_js').find('img').removeClass('act_img');
							$(this).find('img').addClass('act_img');
							// if(!(src.indexOf('nofoto') + 1)){
							//  src = src.replace('thumb', 'original');
							// }
							if(src.indexOf("<?=str_replace(DIRSEP, '/', str_replace($GLOBALS['PATH_root'], '', $GLOBALS['PATH_product_img']));?>") > -1){
								src = src.replace('thumb', 'original');
							}else{
								src = src.replace('_thumb/', '');
							}
							$('.product_main_img').find('img').attr('src', src);
							$('.product_main_img').hide().fadeIn('100');
						}else{
							event.preventDefault();
						}
					});
				});
			</script>
		<?}?>
	</div>
	<div class="mdl-cell mdl-cell--7-col mdl-cell--4-col-tablet">
		<div class="content_header mdl-cell--hide-phone clearfix">
			<?=$cart_info?>
		</div>
		<div class="pb_wrapper">
			<?$in_cart = false;
				if(!empty($_SESSION['cart']['products'][$item['id_product']])){
					$in_cart = true;
				}
				$a = explode(';', $GLOBALS['CONFIG']['correction_set_'.$item['opt_correction_set']]);
			?>
			<div class="product_buy clearfix" data-idproduct="<?=$item['id_product']?>">
				<div class="buy_block">
					<div class="price">
						<?=$in_cart?number_format($_SESSION['cart']['products'][$item['id_product']]['actual_prices'][$_COOKIE['sum_range']], 2, ".", ""):number_format($item['price_opt']*$a[$_COOKIE['sum_range']], 2, ".", "");?>
					</div>
					<div class="btn_buy">
						<div id="in_cart_<?=$item['id_product'];?>" class="btn_js in_cart_js <?=isset($_SESSION['cart']['products'][$item['id_product']])?null:'hidden';?>" data-name="cart"><i class="material-icons">shopping_cart</i><!-- В корзине --></div>
						<div class="mdl-tooltip" for="in_cart_<?=$item['id_product'];?>">Товар в корзине</div>
						<button class="mdl-button mdl-js-button buy_btn_js <?=isset($_SESSION['cart']['products'][$item['id_product']])?'hidden':null;?>" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null); return false;">Купить</button>
					</div>
					<div class="quantity">
						<button class="material-icons btn_add"	onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1); return false;">add</button>
						<input type="text" class="qty_js" value="<?=isset($_SESSION['cart']['products'][$item['id_product']]['quantity'])?$_SESSION['cart']['products'][$item['id_product']]['quantity']:$item['inbox_qty']?>" onchange="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null);return false;" min="0" step="<?=$item['min_mopt_qty'];?>">
						<button class="material-icons btn_remove" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 0);return false;">remove</button>
						<div class="units"><?=$item['units'];?></div>
					</div>
				</div>
			</div>
			<div class="apps_panel mdl-cell--hide-phone">
				<ul>
					<li><i class="material-icons" title="Добавить товар в избранное">favorite_border</i></li>
					<li><i class="material-icons" title="Следить за ценой">trending_down</i></li>
					<li><i class="material-icons" title="Поделиться">share</i></li>
				</ul>
			</div>
		</div>
		<div class="rating_block">
			<?if($item['c_rating'] > 0){?>
				<ul class="rating_stars" title="<?=$item['c_rating'] != ''?'Оценок: '.$item['c_mark']:'Нет оценок'?>">
					<?for($i = 1; $i <= 5; $i++){
						$star = 'star';
						if($i > floor($item['c_rating'])){
							if($i == ceil($item['c_rating'])){
								$star .= '_half';
							}else{
								$star .= '_border';
							}
						}?>
						<li><i class="material-icons"><?=$star?></i></li>
					<?}?>
				</ul>
			<?}?>
		</div>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			<div class="fortabs">
				<div class="tabs mdl-tabs__tab-bar mdl-color--grey-100">
					<a href="#description" class="mdl-tabs__tab is-active">Описание</a>
					<a href="#specifications" class="mdl-tabs__tab">Характеристики</a>
					<a href="#seasonality" class="mdl-tabs__tab">Сезонность</a>
					<a href="#comments" class="mdl-tabs__tab">Отзывы и вопросы</a>
				</div>
			</div>
			<div class="tab-content">
				<div id="description" class="mdl-tabs__panel is-active">
					<?if(!empty($item['descr_xt_full'])){?>
						<p><?=$item['descr_xt_full']?></p>
					<?}else{?>
						<p>К сожалению описание товара временно отсутствует.</p>
					<?}?>
				</div>
				<div id="specifications" class="mdl-tabs__panel">
					<?if(isset($item['specifications']) && !empty($item['specifications'])){?>
						<ul>
							<?foreach ($item['specifications'] as $s) {?>
								<li><span class="caption fleft"><?=$s['caption']?></span><span class="value fright"><?=$s['value'].' '.$s['units']?></span></li>
							<?}?>
						</ul>
					<?}else{?>
						<p>К сожалению характеристики товара временно отсутствует.</p>
					<?}?>
				</div>
				<div id="seasonality" class="mdl-tabs__panel">
					<?if(isset($id_product)){?>
						<div id="graph" data-type="modal" data-target="<?=$GLOBALS['CURRENT_ID_CATEGORY']?>">
							<div class="modal">
								<div class="modal_container">
									<p>График (своя версия)</p>
									<div class="select_go" style="margin-top: 15px;margin-left: 77px;">
										<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-2">
											<span class="mdl-switch__label" style="float: left;margin-left: -130px;">Розница<!--is-checked--></span>
											<input type="checkbox" id="switch-2" class="mdl-switch__input">
											<span class="mdl-switch__label">Опт<!--is-checked--></span>
										</label>
									</div>
									<div class="slider_wrap">
										<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="5" step="1" tabindex="0">
									</div>
									<div class="slider_wrap">
										<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="5" step="1" tabindex="0">
									</div>
									<div class="slider_wrap">
										<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="5" step="1" tabindex="0">
									</div>
									<div class="slider_wrap">
										<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="5" step="1" tabindex="0">
									</div>
									<div class="slider_wrap">
										<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="5" step="1" tabindex="0">
									</div>
									<div class="slider_wrap">
										<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="5" step="1" tabindex="0">
									</div>
									<div class="slider_wrap">
										<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="5" step="1" tabindex="0">
									</div>
									<div class="slider_wrap">
										<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="5" step="1" tabindex="0">
									</div>
									<div class="slider_wrap">
										<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="5" step="1" tabindex="0">
									</div>
									<div class="slider_wrap">
										<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="5" step="1" tabindex="0">
									</div>
									<div class="slider_wrap">
										<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="5" step="1" tabindex="0">
									</div>
									<div class="slider_wrap">
										<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="5" step="1" tabindex="0">
									</div>
									<div class="mdl-textfield">
										<label for="name" class="mdl-textfield__textarea">Примечания к графику:</label>
										<textarea required="required" type="text" name="text" id="text" style="width:80%;">
										</textarea>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="top: -10px;">
										<label for="name" class="mdl-textfield__label">Имя на графике:</label>
										<input class="mdl-textfield__input" type="text" id="name_user" value=""/>
									</div>
									<div id="user_bt" style="float:right;padding-right: 15px;margin-top: 40px;">
										<a href="#" class="save btn_js mdl-button" onclick="ModalGraph()">Сохранить</a>
									</div>
								</div>
							</div>
						</div>
					<?}else{?>
						<!-- <script type="text/javascript" src="//www.google.com.ua/trends/embed.js?hl=ru&q=[intertool,intex]&geo=UA&date=today+30-d&cmpt=q&tz=Etc/GMT-2&tz=Etc/GMT-2&content=1&cid=TIMESERIES_GRAPH_0&export=5&w=653&h=600"></script> -->
					<?}?>
				</div>
				<div id="comments" class="mdl-tabs__panel">
					<div class="feedback_form">
						<h4>Оставить отзыв о товаре</h4>
						<form action="" method="post" onsubmit="onCommentSubmit()">
							<div class="feedback_stars">
								<label class="label_for_stars">Оценка:</label>
								<label>
									<input type="radio" name="rating" class="set_rating hidden" value="1">
									<i class="star material-icons">star_border</i>
								</label>
								<label>
									<input type="radio" name="rating" class="set_rating hidden" value="2">
									<i class="star material-icons">star_border</i>
								</label>
								<label>
									<input type="radio" name="rating" class="set_rating hidden" value="3">
									<i class="star material-icons">star_border</i>
								</label>
								<label>
									<input type="radio" name="rating" class="set_rating hidden" value="4">
									<i class="star material-icons">star_border</i>
								</label>
								<label>
									<input type="radio" name="rating" class="set_rating hidden" value="5">
									<i class="star material-icons">star_border</i>
								</label>
							</div>
							<label for="feedback_text">Отзыв:</label>
							<textarea name="feedback_text" id="feedback_text" cols="30" required></textarea>
							<div class="user_data <?=(!isset($_SESSION['member']['id_user']) || $_SESSION['member']['id_user'] == 4028)?null:'hidden';?>">
								<div class="fild_wrapp">
									<label for="feedback_author">Ваше имя:</label>
									<input type="text" name="feedback_author" id="feedback_author" required value="<?=isset($_SESSION['member']) && $_SESSION['member']['id_user'] != 4028?$_SESSION['member']['name']:null;?>">
								</div>
								<div class="fild_wrapp">
									<label for="feedback_authors_email">Эл.почта:</label>
									<input type="email" name="feedback_authors_email" id="feedback_authors_email" required value="<?=isset($_SESSION['member']) && $_SESSION['member']['id_user'] != 4028?$_SESSION['member']['email']:null;?>">
								</div>
							</div>
							<button type="submit" name="sub_com" class="mdl-button mdl-js-button">Отправить отзыв</button>
						</form>
					</div>
					<div class="feedback_container">
						<?if(empty($coment)){?>
							<p class="feedback_comment">Ваш отзыв может быть первым!</p>
						<?}else{
							$counter = 0;
							foreach($coment as $i){
								if($i['visible'] == 1) {
									$counter++;
								}
							}
							if(!isset($_SESSION['member']) || $_SESSION['member']['gid'] != _ACL_ADMIN_){
								if($counter == 0) {?>
									<p class="feedback_comment">Ваш отзыв может быть первым!</p>
								<?}?>							
							<?}
							foreach($coment as $i){?>								
								<div class="feedback_sub_container <?=($i['visible']==0 && $_SESSION['member']['gid'] != _ACL_ADMIN_)?'hidden':null;?>">
									<span class="feedback_author"><?=isset($i['name'])?$i['name']:'Аноним'?></span>
									<span class="feedback_date"><i class="material-icons">query_builder</i>
										<?if(date("d") == date("d", strtotime($i['date_comment']))){?>
											Сегодня
										<?}elseif(date("d")-1 == date("d", strtotime($i['date_comment']))){?>
											Вчера
										<?}else{
											echo date("d.m.Y", strtotime($i['date_comment']));
										}?>
									</span>
									<?if ($i['rating'] > 0) {?>
										<div class="feedback_rating">
											Оценка товара:
											<ul class="rating_stars" title="<?=$item['c_rating'] != ''?'Оценок: '.$item['c_mark']:'Нет оценок'?>">
												<?for($j = 1; $j <= 5; $j++){
													$star = 'star';
													if($j > floor($i['rating'])){
														if($j == ceil($i['rating'])){
															$star .= '_half';
														}else{
															$star .= '_border';
														}
													}?>
													<li><i class="material-icons"><?=$star?></i></li>
												<?}?>
											</ul>
										</div>
									<?}?>
									<span style="color: red;" class="infoForAdmin <?=($i['visible']==1)?'hidden':null;?>">
									Скрыто</span>
									<p class="feedback_comment"><?=$i['text_coment'];?></p>
								</div>
							<?}?>
						<?}?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<section class="sliders">
	<div class="slider_products hidden">
		<h4>Сопутствующие товары</h4>
		<div id="owl-accompanying" class="owl-carousel">
			<div class="item">
				<a href="#">
					<img src="<?=$GLOBALS['URL_img_theme']?>46842.jpg">
					<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span>
					<div class="ca-more">65 грн.</div>
				</a>
			</div>
		</div>
	</div>
	<div class="slider_products">
		<h4>Популярные товары</h4>
		<div id="owl-popular" class="owl-carousel">
			<?foreach($pops as $p){?>
				<div class="item">
					<a href="<?=Link::Product($p['translit']);?>">
						<?if(!empty($p['images'])){?>
							<img alt="<?=$p['name']?>" src="<?=_base_url?><?=file_exists($GLOBALS['PATH_root'].str_replace('original', 'medium', $p['images'][0]['src']))?str_replace('original', 'medium', $p['images'][0]['src']):'/efiles/nofoto.jpg'?>">
						<?}else{
							if(!empty($p['img_1'])){?>
								<img alt="<?=str_replace('"', '', $p['name'])?>" src="<?=_base_url?><?=$p['img_1']?htmlspecialchars(str_replace("/efiles/image/", "/efiles/image/500/", $p['img_1'])):'/images/nofoto.jpg'?>"/>
							<?}
						}?>
						<span><?=$p['name']?></span>
						<div class="ca-more"><?=number_format($p['price_mopt']*$GLOBALS['CONFIG']['full_wholesale_discount'],2,",","")?> грн.</div>
					</a>
				</div>
			<?}?>
		</div>
	</div>
	<div class="slider_products">
		<h4>Просмотренные товары</h4>
		<div id="owl-last-viewed" class="owl-carousel">
			<?foreach($view_products_list as $p){?>
				<div class="item">
					<a href="<?=Link::Product($p['translit']);?>">
						<?if(!empty($p['images'])){?>
							<img alt="<?=$p['name']?>" src="<?=_base_url?><?=file_exists($GLOBALS['PATH_root'].str_replace('original', 'medium', $p['images'][0]['src']))?str_replace('original', 'medium', $p['images'][0]['src']):'/efiles/nofoto.jpg'?>">
						<?}else{
							if(!empty($p['img_1'])){?>
								<img alt="<?=str_replace('"', '', $p['name'])?>" src="<?=_base_url?><?=$p['img_1']?htmlspecialchars(str_replace("/efiles/image/", "/efiles/image/500/", $p['img_1'])):'/images/nofoto.jpg'?>"/>
							<?}
						}?>
						<span><?=$p['name']?></span>
						<div class="ca-more"><?=number_format($p['price_mopt']*$GLOBALS['CONFIG']['full_wholesale_discount'],2,",","")?> грн.</div>
					</a>
				</div>
			<?}?>
		</div>
	</div>
</section>
<script>
	$(function(){
		//Слайдер миниатюр картинок. Перемещение выбраной картинки в окно просмотра
		$('#owl-product_mini_img_js .owl-item').on('click', function(event){
			$('.product_main_img').find('#mainVideoBlock').addClass('hidden');
			$('.product_main_img').find('iframe').attr('src', '');
			var src = $(this).find('img').attr('src'),
				viewport_width = $(window).width();
			/*console.log(src);*/
			if(viewport_width > 711){
				$('#owl-product_mini_img_js').find('img').removeClass('act_img');
				$('#owl-product_mini_img_js').find('iframe').removeClass('act_img'); // нов. добав. убирает фокус со всех миниатюр изображений кроме текущей активной
				$(this).find('img').addClass('act_img');
				if(src.indexOf("<?=str_replace(DIRSEP, '/', str_replace($GLOBALS['PATH_root'], '', $GLOBALS['PATH_product_img']));?>") > -1){
					src = src.replace('thumb', 'original');
				}else{
					src = src.replace('_thumb/', '');
				}
				$('.product_main_img').hide().fadeIn('100').find('img').attr('src', src);
			}else{
				event.preventDefault();
			}
		}).on('click','.videoBlock', function(e) { //выбор видео и его перемещение в главное окно
      		e.stopPropagation(); // предотвращает распостранение евента который висит на родителях
      		$('#owl-product_mini_img_js').find('iframe').removeClass('act_img'); //убирает фокус с видео
      		$('#owl-product_mini_img_js').find('img').removeClass('act_img'); //убирает фокус с изображений
      		$(this).find('iframe').addClass('act_img'); //добавляет выделение текущей активной миниатюре
      		var src = $(this).find('iframe').attr('src');
      		/*console.log(src);*/
			$('.product_main_img').find('iframe').attr('src', src);
      		$('.product_main_img').find('#mainVideoBlock').removeClass('hidden');
    	});
	});
</script>