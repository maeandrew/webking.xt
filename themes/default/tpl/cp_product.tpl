<div class="product mdl-grid">
	<?$Status = new Status();
	$st = $Status->GetStstusById($item['id_product']);
	// Проверяем доступнось розницы
	($item['price_mopt'] > 0 && $item['min_mopt_qty'] > 0)?$mopt_available = true:$mopt_available = false;
	// Проверяем доступнось опта
	($item['price_opt'] > 0 && $item['inbox_qty'] > 0)?$opt_available = true:$opt_available = false;?>
	<!-- SHOWCASE SLIDER -->
	<div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-tablet">
		<p class="product_article">Арт: <?=$item['art']?></p>
		<div class="product_main_img btn_js mdl-cell--hide-phone" data-name="big_photo">
			<?if(!empty($item['images'])){?>
				<img src="<?=_base_url?><?=$item['images'][0]['src']?>" alt="<?=$item['name']?>">
			<?}else{?>
				<img src="<?=file_exists($GLOBALS['PATH_root'].$item['img_1'])?_base_url.$item['img_1']:'/efiles/_thumb/nofoto.jpg'?>" alt="<?=$item['name']?>">
			<?}?>
		</div>
		<div id="owl-product_mini_img_js">
			<?if(!empty($item['images'])){
				foreach($item['images'] as $i => $image){?>
					<div class="item">
						<img src="<?=file_exists($GLOBALS['PATH_root'].str_replace('original', 'thumb', $image['src']))?_base_url.str_replace('original', 'thumb', $image['src']):'/efiles/nofoto.jpg'?>" alt="<?=$item['name']?>"<?=$i==0?' class="act_img"':null;?>>
					</div>
				<?}
			}else{
				for($i=1; $i < 4; $i++){
					if(!empty($item['img_'.$i])){?>
						<div class="item">
							<img src="<?=file_exists($GLOBALS['PATH_root'].$item['img_'.$i])?_base_url.str_replace('/efiles/', '/efiles/_thumb/', $item['img_'.$i]):'/efiles/nofoto.jpg'?>" alt="<?=$item['name']?>"<?=$i==1?' class="active_img"':null;?>>
						</div>
					<?}
				}
			}?>
		</div>
	</div>
	<div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-tablet">
		<div class="content_header mdl-cell--hide-phone clearfix">
			<div class="cart_info clearfix">
				<div class="your_discount">Ваша скидка</div>
				<div class="tabs_container">
					<ul>
						<li class="in_cart_block hidden">
							<a href="#">20 товаров <span class="material-icons">shopping_cart</span></a>
						</li>
						<li onclick="ChangePriceRange(0);" class="sum_range sum_range_0 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 0)?'user_active':null;?>">0%</li>
						<li onclick="ChangePriceRange(1);" class="sum_range sum_range_1 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 1)?'user_active':null;?>">10%</li>
						<li onclick="ChangePriceRange(2);" class="sum_range sum_range_2 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 2)?'user_active':null;?>">16%</li>
						<li onclick="ChangePriceRange(3);" class="active sum_range sum_range_3 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 3)?'user_active':null;?>">21%</li>
					</ul>
				</div>
				<div class="order_balance">Еще заказать на <span class="summ">10000</span> грн.</div>
				<div class="price_nav"></div>
			</div>
		</div>
		<div class="pb_wrapper">
			<?$in_cart = false;
				if(!empty($_SESSION['cart']['products'][$item['id_product']])){
					$in_cart = true;
				}
				$a = explode(';', $GLOBALS['CONFIG']['correction_set_'.$item['opt_correction_set']]);
			?>
			<div class="product_buy clearfix" data-idproduct="<?=$item['id_product']?>">
				<p class="price"><?=$in_cart?number_format($_SESSION['cart']['products'][$item['id_product']]['actual_prices'][$_COOKIE['sum_range']], 2, ".", ""):number_format($item['price_opt']*$a[$_COOKIE['sum_range']], 2, ".", "");?></p>
				<div class="buy_block">
					<div class="btn_remove">
						<button class="mdl-button material-icons" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 0);return false;">remove</button>
					</div>
					<input type="text" class="qty_js" value="<?=!$in_cart?$item['inbox_qty']:$_SESSION['cart']['products'][$item['id_product']]['quantity'];?>">
					<?if(!$in_cart){?>
						<div class="btn_buy">
							<button class="mdl-button mdl-js-button buy_btn_js" type="button">Купить</button>
						</div>
					<?}else{?>
						<div class="btn_buy">
							<button class="mdl-button mdl-js-button buy_btn_js" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1);return false;"><i class="material-icons">add</i></button>
						</div>
					<?}?>
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
			<div class="tabs mdl-tabs__tab-bar mdl-color--grey-100">
				<a href="#description" class="mdl-tabs__tab is-active">Описание</a>
				<a href="#specifications" class="mdl-tabs__tab">Характеристики</a>
				<a href="#seasonality" class="mdl-tabs__tab">Сезонность</a>
				<a href="#comments" class="mdl-tabs__tab">Отзывы и вопросы</a>
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
					График
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
							foreach($coment as $i){?>
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
								<p class="feedback_comment"><?=$i['text_coment'];?></p>
							<?}
						}?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<section class="sliders">
	<div class="slider_products">
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
							<img src="<?=_base_url?><?=str_replace('original', 'medium', $p['images'][0]['src'])?>" alt="<?=$p['name']?>">
						<?}else{
							if(!empty($p['img_1'])){?>
								<img alt="<?=str_replace('"', '', $p['name'])?>" src="<?=file_exists($GLOBALS['PATH_root'].$p['img_1'])?htmlspecialchars(str_replace("/efiles/image/", "/efiles/image/250/", $p['img_1'])):'/images/nofoto.jpg'?>"/>
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
							<img src="<?=_base_url?><?=str_replace('original', 'small', $p['images'][0]['src'])?>" alt="<?=$p['name']?>">
						<?}else{
							if(!empty($p['img_1'])){?>
								<img alt="<?=str_replace('"', '', $p['name'])?>" src="<?=file_exists($GLOBALS['PATH_root'].$p['img_1'])?htmlspecialchars(str_replace("/efiles/image/", "/efiles/image/250/", $p['img_1'])):'/images/nofoto.jpg'?>"/>
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
		//Слайдер миниатюр картинок
		$('#owl-product_mini_img_js .item').on('click', function(event) {
			var src = $(this).find('img').attr('src');
			var viewport_width = $(window).width();
			if(viewport_width > 711){
				$('#owl-product_mini_img_js').find('img').removeClass('act_img');
				$(this).find('img').addClass('act_img');
				// if(!(src.indexOf('nofoto') + 1)){
				// 	src = src.replace('thumb', 'original');
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