<!DOCTYPE html>
<html lang="ru">
<head>
	<title><?=isset($GLOBALS['prod_title'])?$GLOBALS['prod_title'].' | ':null;?><?=(isset($GLOBALS['products_title']) && $GLOBALS['products_title'] != '')?$GLOBALS['products_title']:$__page_title;?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<?if(in_array($GLOBALS['CurrentController'], array('product', 'products', 'news', 'post', 'page'))){
		if(!isset($indexation) || $indexation == 0){?>
			<meta name="robots" content="noindex, nofollow"/>
		<?}
	}else{?>
		<meta name="robots" content="noindex, nofollow"/>
	<?}?>
	<!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> -->
	<?if($GLOBALS['CurrentController'] == 'product'){?>
		<meta name="description" content='<?=isset($GLOBALS['prod_title'])?$GLOBALS['prod_title'].' | ':null;?>
		<?=(isset($GLOBALS['products_description']) && $GLOBALS['products_description'] != '')?$GLOBALS['products_description']:$__page_description;?>'/>
		<meta name="keywords" content='<?=isset($GLOBALS['prod_title'])?$GLOBALS['prod_title'].' | ':null;?><?=(isset($GLOBALS['products_keywords']) && $GLOBALS['products_keywords'] != '')?$GLOBALS['products_keywords']:$__page_kw;?>'/>
	<?}else{?>
		<meta name="description" content='<?=isset($GLOBALS['prod_title'])?$GLOBALS['prod_title'].' | ':null;?><?=(isset($GLOBALS['products_description']) && $GLOBALS['products_description'] != '')?$GLOBALS['products_description']:$__page_description;?>'/>
		<meta name="keywords" content='<?=isset($GLOBALS['prod_title'])?$GLOBALS['prod_title'].' | ':null;?><?=(isset($GLOBALS['products_keywords']) && $GLOBALS['products_keywords'] != '')?$GLOBALS['products_keywords']:$__page_kw;?>'/>
	<?}?>
	<!-- setting canonical pages -->
	<?if($GLOBALS['CurrentController'] == 'main'){?>
		<link rel="canonical" href="<?=_base_url?>/"/>
	<?}elseif($GLOBALS['CurrentController'] == 'products'){
		// if($GLOBALS['GLOBAL_CURRENT_ID_CATEGORY'] == 482 && empty($GLOBALS['subcats'])){
			if(strpos($_SERVER['REQUEST_URI'], 'limitall')){?>
				<link rel="canonical" href="<?=_base_url.str_replace('/limitall', '', $_SERVER['REQUEST_URI']);?>"/>
			<?}else{?>
				<link rel="canonical" href="<?=$GLOBALS['meta_canonical'];?>"/>
			<?}
			if(isset($GLOBALS['meta_next'])){?>
				<link rel="next" href="<?=$GLOBALS['meta_next'];?>"/>
			<?}
			if(isset($GLOBALS['meta_prev'])){?>
				<link rel="prev" href="<?=$GLOBALS['meta_prev'];?>"/>
			<?}
		// }else{?>
			<!-- <link rel="canonical" href="<?=$GLOBALS['products_canonical'];?>"/> -->
		<?//}
	}elseif(isset($GLOBALS['product_canonical']) && $GLOBALS['product_canonical'] != ''){?>
		<link rel="canonical" href="<?=$GLOBALS['product_canonical'];?>"/>
	<?}?>

	<!-- favicon loading -->
	<link type="image/x-icon" href="/favicon.ico" rel="icon"/>
	<link type="image/x-icon" href="/favicon.ico" rel="shortcut icon"/>
	<!-- END favicon loading -->

	<!-- END setting canonical pages -->

	<!-- defining author for special pages -->
	<?if(isset($GLOBALS['__author']) == true){?>
		<link rel="author" href="<?=$GLOBALS['__author']?>"/>
	<?}?>
	<!-- END defining author for special pages -->

	<!-- define JS global variables -->
	<script type="text/javascript">
		var URL_base = "<?=_base_url?>/",
			current_controller = "<?=$GLOBALS['CurrentController']?>",
			ajax_proceed = false,
			isLogged = <?=G::isLogged()?'false':'true';?>;
	</script>
	<!-- END define JS global variables -->

	<!-- CSS load -->
	<?if(isset($css_arr)){
		$tmpstr = '<link href="'.$GLOBALS['URL_css'].'%s" rel="stylesheet" type="text/css"/>'."\n";
		foreach($css_arr as $css){
			if(substr($css, -9) == "style.css"){
				$css .= "?".date("v=dHi");
			}
			echo sprintf($tmpstr, $css);
		}
	}?>

	<!-- JS load -->
	<?if(isset($js_arr)){
		$tmpstr = '<script src="'.$GLOBALS['URL_js'].'%s" type="text/javascript"%s></script>'."\n";
		foreach($js_arr as $js){
			echo sprintf($tmpstr, $js['name'], $js['async']==true?' async':null);
		}
	}?>
	<!-- <script src="http://mbostock.github.com/d3/d3.v2.js"></script>
		<script src="http://underscorejs.org/underscore.js"></script> -->
	<!-- END JS load -->

	<!-- Google Material Icon -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

	<!-- END include specific js templates for controllers -->
	<?if(!isset($_SESSION['member']['gid']) || !in_array($_SESSION['member']['gid'], array(_ACL_SUPPLIER_MANAGER_, _ACL_SUPPLIER_, _ACL_DILER_, _ACL_MODERATOR_, _ACL_MANAGER_, _ACL_SEO_))){?>
		<!-- Google counter -->
		<?=isset($GLOBALS['CONFIG']['google_counter_xt'])?$GLOBALS['CONFIG']['google_counter_xt']:null;?>
		<!-- END Google counter -->

		<!-- Yandex.Metrika counter -->
		<?=isset($GLOBALS['CONFIG']['yandex_counter_xt'])?$GLOBALS['CONFIG']['yandex_counter_xt']:null?>
		<!-- END Yandex.Metrika counter -->
		<!--<script>ga('require', 'ecommerce');</script>-->
	<?}?>
	<!-- define search box in google sitelinks -->
	<?if($GLOBALS['CurrentController'] == 'main'){?>
		<script type="application/ld+json">
			{
				"@context": "http://schema.org",
				"@type": "WebSite",
				"url": URL_base,
				"potentialAction": {
					"@type": "SearchAction",
					"target": URL_base+"search/?category2search=0&query={q}",
					"query-input": "required name=q"
				}
			}
		</script>
	<?}?>
	<!-- END define search box in google sitelinks -->
	<noscript>
		<style>
			img.lazy {
				display: none !important;
			}
		</style>
	</noscript>
</head>
<body class="<?=in_array($GLOBALS['CurrentController'], $GLOBALS['LeftSideBar'])?'sidebar':'no-sidebar'?> c_<?=$GLOBALS['CurrentController']?> <?=$GLOBALS['CurrentController'] == "main"?'':'banner_hide'?>">
	<!-- Yandex.Metrika counter -->
	<?isset($GLOBALS['CONFIG']['yandex_counter_noscript'])?$GLOBALS['CONFIG']['yandex_counter_noscript']:null?>
	<!-- END Yandex.Metrika counter -->
	<!--[if lt IE 9]>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script type="text/javascript">
			$(function(){
				$('body').find('.container-fluid').remove();
				$('.old_browser_bg').show();
			});
		</script>
	<![endif]-->
	<div class="background_panel"></div>
	<header id="header_js" class="default" data-type="search">
		<?=$__header?>
	</header>
	<div id="phone_menu" class="panel" data-type="panel">
		<ul class="phone_nav">
			<?foreach($list_menu as $menu){?>
				<li><a href="<?=Link::Custom('page', $menu['translit']);?>"><?=$menu['title']?></a></li>
			<?}?>
		</ul>
		<ul class="phone_nav_contacts clearfix">
			<li class="parent_nav"><div class="material-icons">phone</div><span>(063) 225-91-83</span></li>
			<li><span>(099) 228-69-38</span></li>
			<li><span>(093) 322-91-83</span></li>
			<li class="parent_nav"><div class="material-icons">mail</div><span>administration@x-torg.com</span></li>
			<li class="parent_nav"><div class="material-icons">location_on</div><span>г. Харьков, ТЦ Барабашово, Площадка Свояк, Торговое Место 130</span></li>
		</ul>
	</div>
	<section class="banner">
		<div class="cont">
			<a href="#">
				<span class="text_block">
					<img class="item_svg" src="<?=$GLOBALS['URL_img_theme']?>banner/factory.gif">
					<h3>Снабжение<br> предриятий</h3>

				</span>
			</a>
			<a href="#">
				<span class="text_block">
					<img class="item_svg" src="<?=$GLOBALS['URL_img_theme']?>banner/shop.gif">
					<h3>Поставки<br> магазинам</h3>

				</span>
			</a>
			<a href="#">
				<span class="text_block">
					<img class="item_svg" src="<?=$GLOBALS['URL_img_theme']?>banner/home.gif">
					<h3>Обеспечение<br> быта</h3>

				</span>
			</a>
		</div>
	</section>
	<?if(isset($navigation) && !in_array($GLOBALS['CurrentController'], $GLOBALS['LeftSideBar'])){?>
		<aside id="catalog" class="mdl-color--grey-100 mdl-cell--hide-phone" data-type="panel">
			<div class="wrapper">
				<?=$__sidebar_l?>
				<?if($news != false){?>
					<div class="xt_news">
						<a href="<?=Link::Custom('news', $news['translit']);?>">
							<h6 class="min news_title"><?=$news['title']?></h6>
							<div class="min news_description"><?=$news['descr_short']?></div>
							<div class="min news_date">
								<?if(date('d-m-Y') == date("d-m-Y", $news['date'])){?>
									Опубликовано Сегодня
								<?}elseif(date('d-m-Y', strtotime(date('d-m-Y').' -1 day')) == date('d-m-Y', $news['date'])){?>
									Опубликовано Вчера
								<?}else{?>
									Опубликовано
								<?  echo date("d.m.Y", $news['date']);
								}?>
							</div>
						</a>
						<div class="min news_more">
							<a href="<?=Link::Custom('news');?>">Все новости >>></a>
						</div>
					</div>
				<?}?>
				<?if($post != false){?>
					<div class="xt_news" style="margin-bottom:50px;">
						<a href="<?=Link::Custom('news', $news['translit']);?>">
							<h6 class="min news_title"><?=$post['title']?></h6>
							<img style="margin-top:15px;">
							<div class="min news_description"><?=$post['content_preview']?></div>
							<div class="min news_date">
								<?if(date('d-m-Y') == $post['date']){?>
									Опубликовано Сегодня
								<?}elseif($post['date']){?>
									Опубликовано Вчера
								<?}else{?>
									Опубликовано
								<?echo $post['date'];
								}?>
							</div>
						</a>
						<div class="min news_more">
							<a href="<?=Link::Custom('post');?>">Все статьи >>></a>
						</div>
					</div>
				<?}?>
			</div>
			<div class="catalog_close btn_js" data-name="catalog">
				<i class="material-icons" title="Закрыть каталог">close</i>
			</div>
		</aside>
	<?}?>
	<div id="newheader_wrapp"></div>
	<section class="main <?=$GLOBALS['CurrentController'] == 'product'?'product_page':null?>">
		<?if(in_array($GLOBALS['CurrentController'], $GLOBALS['LeftSideBar'])){?>
			<aside class="mdl-color--grey-100 mdl-cell--hide-phone">
				<div class="wrapper">
					<?=$__sidebar_l?>
						<?if($news != false){?>
							<div class="xt_news">
								<a href="<?=Link::Custom('news', $news['translit']);?>">
									<h6 class="min news_title"><?=$news['title']?></h6>
									<div class="min news_description"><?=$news['descr_short']?></div>
									<div class="min news_date">
										<?if(date('d-m-Y') == date("d-m-Y", $news['date'])){?>
											Опубликовано Сегодня
										<?}elseif(date('d-m-Y', strtotime(date('d-m-Y').' -1 day')) == date('d-m-Y', $news['date'])){?>
											Опубликовано Вчера
										<?}else{?>
											Опубликовано
										<?  echo date("d.m.Y", $news['date']);
										}?>
									</div>
								</a>
								<div class="min news_more">
									<a href="<?=Link::Custom('news');?>">Все новости >>></a>
								</div>
							</div>
						<?}?>
				</div>
			</aside>
		<?}?>
		<section class="center">
			<style>
				#last_orders_count {
					width: 100%;
					height: 300px;
				}
			</style>
			<?php if(isset($__graph)){
				echo $__graph;
			}?>
			<div class="content">
				<?if($GLOBALS['CurrentController'] != 'main'){?>
					<?=$__breadcrumbs?>
					<!-- <h1 class="page_header"><?=$GLOBALS['CurrentController'] == 'products'?$curcat['name']:$header;?></h1> -->
					<?=$__center?>
				<?}else{?>
					<div class="content_header clearfix">
						<div class="sort imit_select">
							<button id="sort-lower-left" class="mdl-button mdl-js-button">
								<i class="material-icons fleft">keyboard_arrow_down</i><span class="selected_sort select_fild">По рейтингу</span>
							</button>
							<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="sort-lower-left">
								<li class="mdl-menu__item active">По рейтингу</li>
								<li class="mdl-menu__item">Новинки</li>
								<li class="mdl-menu__item">Популярные</li>
								<li class="mdl-menu__item">От дешевых к дорогим</li>
							</ul>

							<?if(isset($_SESSION['member']) && $_SESSION['member']['gid'] == 0){?>
								<a href="#" class="xgraph_up one"><i class="material-icons">timeline</i></a>
							<?}elseif(isset($_SESSION['member']) && $_SESSION['member']['gid'] == 1){?>
								<a href="#" class="xgraph_up two"><i class="material-icons">timeline</i></a>
							<?}?>
						</div>
						<div class="cart_info mdl-cell--hide-phone clearfix">
							<div class="your_discount">Ваша скидка</div>
							<div class="tabs_container">
								<ul>
									<!-- <li class="in_cart_block">
										<a href="#" class="btn_js" data-name="cart">
										<?php
											$str = count($_SESSION['cart']['products']). ' товар';
											$count = count($_SESSION['cart']['products']);
											if(substr($count,-1) == 1 && substr($count,-2) != 1)
												$str .= '';
											else if(substr($count,-1) >= 2 && substr($count,-1) <= 4)
												$str .= 'а';
											else
												$str .= 'ов';
										?>
										<div class="order_cart"><?=$str?></div>
										<span class="material-icons">shopping_cart</span></a>
									</li> -->
									<li onclick="ChangePriceRange(3, 0)" class="sum_range sum_range_3 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 3)?'active':null;?>">0%</li>
									<li onclick="ChangePriceRange(2,<?=$sum = 500 - $_SESSION['cart']['cart_sum'];?>);" class="sum_range sum_range_2 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 2)?'active':null;?>">10%</li>
									<li onclick="ChangePriceRange(1,<?=$sum = 3000 - $_SESSION['cart']['cart_sum'];?>);" class="sum_range sum_range_1 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 1)?'active':null;?>">16%</li>
									<li onclick="ChangePriceRange(0,<?=$sum = 10000 - $_SESSION['cart']['cart_sum'];?>);" class="sum_range sum_range_0 <?=(isset($_COOKIE['sum_range']) && $_COOKIE['sum_range'] == 0)?'active':null;?>">21%</li>
								</ul>
							</div>
							<div class="order_balance">
								<?if($_COOKIE['sum_range'] == 3) {;?>
									Готово!
								<?}elseif($_COOKIE['sum_range'] == 2){
									$sum = 500 - $_SESSION['cart']['cart_sum'];?>
									Еще заказать на <span class="summ"><?=number_format($sum, 2, ',', ' ');?></span> грн.
								<?}elseif($_COOKIE['sum_range'] == 1){
									$sum = 3000 - $_SESSION['cart']['cart_sum'];?>
									Еще заказать на <span class="summ"><?=number_format($sum, 2, ',', ' ')?></span> грн.
								<?}elseif($_COOKIE['sum_range'] == 0){
									$sum = 10000 - $_SESSION['cart']['cart_sum'];?>
									Еще заказать на <span class="summ"><?=number_format($sum, 2, ',', ' ')?></span> грн.
								<?}?>
							</div>
							<div class="price_nav"></div>
						</div>
					</div>
					<div id="view_block_js" class="list_view col-md-12 ajax_loading">
						<div class="row">
							<div class="products">
								<?=$products_list;?>
							</div>
							<?if($GLOBALS['CurrentController'] != 'main'){?>
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
							<?}?>
						</div>
					</div>
					<script>
						ListenPhotoHover(); //Инициализания Preview
					</script>
					<!-- <div class="show_more mdl-cell--hide-phone"><a href="#">Показать еще 30 товаров</a></div> -->
				<?}?>
			</div>
			<?if(isset($seotext)){?>
				<div class="mdl-grid">
					<div id="seoTextBlock" class="mdl-grid mdl-cell--12-col">
						<?=$seotext?>
					</div>
				</div>
			<?}?>
			<footer class="mdl-mega-footer mdl-color--grey-100 clearfix">
				<div class="mdl-mega-footer__left-section clearfix">
					<div class="questions mdl-cell--hide-tablet mdl-cell--hide-phone">
						<h5>Навигация</h5>
						<ul>
							<li><a href="<?=Link::Custom('main')?>">Главная</a></li>
							<?foreach($list_menu as $menu){?>
								<li><a href="<?=Link::Custom('page', $menu['translit']);?>"><?=$menu['title']?></a></li>
							<?}?>
							<li><a href="#">Форум</a></li>
						</ul>
					</div>
					<div class="contacts">
						<div class="mdl-cell--hide-phone">
							<h5>Контакты</h5>
							<ul class="phone_nav_contacts clearfix">
								<?if(isset($GLOBALS['CONFIG']['footer_phone']) && $GLOBALS['CONFIG']['footer_phone'] != ''){?>
									<li class="parent_nav"><div class="material-icons">phone</div><span><?=$GLOBALS['CONFIG']['footer_phone'];?></span></li>
								<?}?>
								<!-- <li><span>(099) 228-69-38</span></li>
								<li><span>(093) 322-91-83</span></li> -->
								<?if(isset($GLOBALS['CONFIG']['footer_email']) && $GLOBALS['CONFIG']['footer_email'] != ''){?>
									<li class="parent_nav"><div class="material-icons">mail</div><span><?=$GLOBALS['CONFIG']['footer_email'];?></span></li>
								<?}?>
								<?if(isset($GLOBALS['CONFIG']['footer_address']) && $GLOBALS['CONFIG']['footer_address'] != ''){?>
									<li class="parent_nav"><div class="material-icons">location_on</div><span><?=$GLOBALS['CONFIG']['footer_address'];?></span></li>
								<?}?>
							</ul>
						</div>
						<div class="social">
							<ul>
								<li><a href="https://vk.com/xt_ua" target="_blank" class="vk" title="Вконтакте"><img src="<?=$GLOBALS['URL_img_theme']?>vk.svg" alt="Вконтакте"></a></li>
								<li><a href="http://ok.ru/group/54897683202077" target="_blank" class="ok" title="Однокласники"><img src="<?=$GLOBALS['URL_img_theme']?>odnoklassniki.svg" alt="Однокласники"></a></li>
								<li><a href="https://plus.google.com/+X-torg/" target="_blank" class="g_pl" title="google+"><img src="<?=$GLOBALS['URL_img_theme']?>google-plus.svg" alt="google+"></a></li>
								<li><a href="https://www.facebook.com/KharkovTorg" target="_blank" class="f" title="Facebook"><img src="<?=$GLOBALS['URL_img_theme']?>facebook.svg" alt="Facebook"></a></li>
								<li><a href="https://twitter.com/we_xt_ua" target="_blank" class="tw" title="Twitter"><img src="<?=$GLOBALS['URL_img_theme']?>twitter.svg" alt="Twitter"></a></li>
								<li><a href="https://www.youtube.com/channel/UCUSXO-seq23KfMwbn4q9VVw" target="_blank" class="y_t" title="Yuotube"><img src="<?=$GLOBALS['URL_img_theme']?>youtube.svg" alt="Yuotube"></a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="ad_sense">
					<?if($GLOBALS['CurrentController'] == 'products'){?>
						<?if($GLOBALS['CURRENT_ID_CATEGORY'] == 478){?>
							<!-- <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
							<!-- Категории -->
							<!-- <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-2337139989896773" data-ad-slot="8269932848" data-ad-format="auto"></ins> -->
							<!-- <script>(adsbygoogle = window.adsbygoogle || []).push({});</script> -->
						<?}elseif($GLOBALS['CURRENT_ID_CATEGORY'] == 479){?>
							<!-- <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
							<!-- test -->
							<!-- <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-2337139989896773" data-ad-slot="9873030842" data-ad-format="auto"></ins> -->
							<!-- <script>(adsbygoogle = window.adsbygoogle || []).push({});</script> -->
						<?}elseif($GLOBALS['GLOBAL_CURRENT_ID_CATEGORY'] == 480){?>
							<!-- <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
							<!-- Категории2 -->
							<!-- <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-2337139989896773" data-ad-slot="7119113645" data-ad-format="auto"></ins> -->
							<!-- <script>(adsbygoogle = window.adsbygoogle || []).push({});</script> -->
						<?}?>
					<?}else{?>
						<img src="//lh3.ggpht.com/H8LE7fE6SRPpyBIs3CpNLn_4LBxZjmHbCos9CCeyDmUEGGI05vBM1QoQLcvDMp8sp70EI5Pk=w250" height="250" width="300">
					<?}?>
				</div>
				<div class="copyright">
					<p>&copy; Отдел снабжения XT.ua 2015</p>
					<p class="created">Разработано в <a href="http://webking.link/">WebKingStudio</a></p>
				</div>
			</footer>
		</section>
	</section>
	<div class="modals">
		<div id="quiz" data-type="modal">
			<div class="modal_container summary_info">
				<div class="row hidden">
					<span class="span_title">Фамилия: </span>
					<span class="lastname"></span>
				</div>
				<div class="row hidden">
					<span class="span_title">Имя:</span>
					<span class="firstname"></span></div>
				<div class="row hidden">
					<span class="span_title">Отчество:</span>
					<span class="middlename"></span></div>
				<div class="row hidden">
					<span class="span_title">Область:</span>
					<span class="region"></span>
				</div>
				<div class="row hidden">
					<span class="span_title">Город:</span>
					<span class="city"></span>
				</div>
				<div class="row hidden">
					<span class="span_title">Служба доставки:</span>
					<span class="delivery_service"></span>
				</div>
				<div class="row hidden">
					<span class="span_title">Способ доставки:</span>
					<span class="delivery_method"></span>
				</div>


				<div class="row hidden">
					<span class="span_title">Адрес клиента:</span>
					<span class="client_address"></span>
				</div>
				<div class="row hidden">
					<span class="span_title">Адрес склада:</span>
					<span class="post_office_address"></span>
				</div>
			</div>
			<div class="modal_container step_1 active" data-step="1">
				<div class="head_top">
					<h5>Здравствуйте! Меня зовут Алёна и я сопровождаю Ваш заказ.</h5>
					<span>Сейчас я вижу Вас как "Клиент 2345623", скажите, как Вас зовут?</span>
				</div>
				<div class="row">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="lastname">
						<input class="mdl-textfield__input" type="text" name="lastname" value="">
						<label class="mdl-textfield__label" for="lastname">Фамилия</label>
						<span class="mdl-textfield__error">Введите фамилию</span>
					</div>
				</div>
				<div class="row">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="firstname">
						<input class="mdl-textfield__input" type="text" name="firstname" value="">
						<!-- value="Александр"> -->
						<label class="mdl-textfield__label" for="firstname">Имя</label>
						<span class="mdl-textfield__error">Введите имя</span>
					</div>
				</div>
				<div class="row">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="middlename">
						<input class="mdl-textfield__input" type="text" name="middlename" value="">
						<label class="mdl-textfield__label" for="middlename">Отчество</label>
						<span class="mdl-textfield__error">Введите отчество</span>
					</div>
				</div>
				<div class="row">
					<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="2">Далее</button>
				</div>
			</div>
			<div class="modal_container step_2 " data-step="2">
				<div class="head_top">
					<h6><span class="client">Пользователь</span>, приятно познакомиться!</h6>
					<span>Мы доставляем в 460 городов, а откуда Вы?</span>
				</div>
				<div class="row">
					<span class="number_label">Область</span>
					<div class="region imit_select">
						<button id="region_select" class="mdl-button mdl-js-button">
							<span class="select_field">Харьковская область<!-- Выбрать --></span>
							<i class="material-icons">keyboard_arrow_down</i>
						</button>
						<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="region_select"></ul>
					</div>

				</div>
				<div class="row">
					<span class="number_label">Город</span>
					<div class="city imit_select">
						<button id="city_select" class="mdl-button mdl-js-button">
							<span class="select_field">Харьков<!-- Выбрать --></span>
							<i class="material-icons">keyboard_arrow_down</i>
						</button>
						<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="city_select"></ul>
					</div>
				</div>

				<div class="row">
					<div class="error_div hidden">

					</div>
					<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="1">Назад</button>
					<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="3">Далее</button>
				</div>
			</div>
			<div class="modal_container step_3 " data-step="3">
				<div class="head_top">
					<h6><span class="client">Пользователь</span>, доставка в <span class="city">Город</span> возможна!</h6>
				</div>
				<div class="row delivery_service">
				</div>

				<div class="row">
					<span>Вам удобнее забрать заказ со склада, или принять по адресу?</span>
					<div class="imit_select delivery_type">
						<button id="select_delivery_type" class="mdl-button mdl-js-button">
							<span class="select_field">Выбрать</span>
							<i class="material-icons fright">keyboard_arrow_down</i>
						</button>
						<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="select_delivery_type">
							<li class="mdl-menu__item" data-value="1" >Адресная доставка</li>
							<li class="mdl-menu__item" data-value="2" >Забрать со склада</li>
						</ul>
					</div>


					<div class="row post_office imit_select">
						<button id="post_office_select" class=" mdl-button mdl-js-button">
							<span class="select_field">Выбрать отделение<!-- Выбрать --></span>
							<i class="material-icons">keyboard_arrow_down</i>
						</button>
						<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect list_post_office" for="post_office_select"></ul>
					</div>
				</div>
				<div id="client_address" class="row delivery_address mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input id="delivery_address" class="mdl-textfield__input" type="text" name="clientaddress" value="" id="sample3">
					<label class="mdl-textfield__label" for="sample3">Доставить по адресу...</label>
					<span class="mdl-textfield__error">Введите адрес</span>
				</div>

				<div class="row">
					<div class="error_div hidden">

					</div>
					<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="2">Назад</button>
					<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="4">Далее</button>
				</div>
			</div>
			<div class="modal_container step_4 " data-step="4">
				<div class="head_top">
					<h6>Виталий Петрович, у меня есть необходимые данные для отправки заказа.</h6>
					<span>Вы готовы внести предоплату?</span>
				</div>
				<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-6">
					<input type="radio" id="option-6" class="mdl-radio__button" name="options" value="6" checked>
					<span class="mdl-radio__label">Нет, мне необходима телефонная консультация.</span>
				</label>
				<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-7">
					<input type="radio" id="option-7" class="mdl-radio__button" name="options" value="7">
					<span class="mdl-radio__label">Да, предоставьте реквизиты!</span>
				</label>
				<div class="company_details">
					<h4>Реквизиты компании</h4>
				</div>
				<div class="row">
					<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="3">Назад</button>
					<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="5">Отправить</button>
				</div>
			</div>
			<div class="modal_container step_5 " data-step="5">
				<div class="head_top">
					<h6>Готово!</h6>
					<p class="msg_for_client">Я свяжусь с Вами в ближайшее время.</p>
				</div>
			</div>
			<div class="progress">
				<div class="line">
					<div class="line_active"></div>
				</div>
				<span class="go">Заполнено: </span>
			</div>
		</div>
		<!-- Authentication -->
		<div id="auth" data-type="modal">
			<div id="login" class="modal_container">
				<h4>Вход</h4>
				<span>Сопроводительный текст к форме входа.</span>
				<form action="#">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input class="mdl-textfield__input" type="text" id="email">
						<label class="mdl-textfield__label" for="email">Email или телефон</label>
						<span class="mdl-textfield__error"></span>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input class="mdl-textfield__input" type="password" id="passwd">
						<label class="mdl-textfield__label" for="passwd">Пароль</label>
						<span class="mdl-textfield__error"></span>
					</div>
					<div class="error"></div>
					<button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--raised mdl-button--colored sign-in">Вход</button>
					<button class="mdl-button mdl-js-button mdl-js-ripple-effect switch" data-name="registration">Регистрация</button>
				</form>
			</div>
			<div id="registration" class="hidden modal_container">
				<h4>Регистрация</h4>
				<span>Сопроводительный текст к форме регистрации.</span>
				<form action="#">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input class="mdl-textfield__input" type="text" id="name" name="name">
						<label class="mdl-textfield__label" for="name">Имя</label>
						<span class="mdl-textfield__error">Ошибка ввода имени!</span>
					</div>

					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input class="mdl-textfield__input" type="text" id="email" name="email">
						<label class="mdl-textfield__label" for="email">Email (логин)</label>
						<span class="mdl-textfield__error">Ошибка ввода email!</span>
					</div>

					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="password" class="mdl-textfield__input" id="passwd"	name="passwd">
						<label class="mdl-textfield__label" for="passwd">Пароль</label>
						<span class="mdl-textfield__error">Ошибка ввода пароля!</span>
						<!-- <div id="passstrength">
								<div id="passstrengthlevel"></div>
							</div>
							<div id="password_error"></div>
							<div class="error_description"></div> -->
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="password" class="mdl-textfield__input" id="passwdconfirm" name="passwdconfirm">
						<label class="mdl-textfield__label" for="passwdconfirm">Подтверждение пароля</label>
						<span class="mdl-textfield__error">Ошибка ввода пароля!</span>
						<div id="password_error"></div>
						<div class="error_description"></div>
					</div>
					<button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--raised mdl-button--colored sign-up">Регистрация</button>
					<button class="mdl-button mdl-js-button mdl-js-ripple-effect switch" data-name="login">Вход</button>
				</form>
			</div>
		</div>
		<div id="cart" data-type="modal">
			<h4 class="title_cart">Корзина</h4>
			<div class="clear_cart fleft">
					<a onClick="removeFromCart();return false;" href="#"><span class="icon-font color-red"></span>Очистить корзину</a>
			</div>
			<ul class="order_head mdl-cell--hide-phone">
				<li class="photo">Фото</li>
				<li class="name">Название</li>
				<li class="price">Цена, Количество</li>
				<li class="sum_li">Сумма</li>
			</ul>
			<div class="modal_container"></div>
			<?$cart_sum = $_SESSION['cart']['products_sum']['3'];
			$percent_sum = $total = 0;
			if($cart_sum >= 0 && $cart_sum < $GLOBALS['CONFIG']['retail_order_margin']) {
				$percent = $percent_sum = 0;
				$total = $cart_sum;
			}elseif($cart_sum >= $GLOBALS['CONFIG']['retail_order_margin'] && $cart_sum < $GLOBALS['CONFIG']['wholesale_order_margin']) {
				$percent = 10;
				$percent_sum = $cart_sum * 0.10;
				$total = $cart_sum - $percent_sum;
			}elseif($cart_sum >= $GLOBALS['CONFIG']['wholesale_order_margin'] && $cart_sum < $GLOBALS['CONFIG']['full_wholesale_order_margin']) {
				$percent = 16;
				$percent_sum = $cart_sum * 0.16;
				$total = $cart_sum - $percent_sum;
			}elseif($cart_sum >= $GLOBALS['CONFIG']['full_wholesale_order_margin']){
				$percent = 21;
				$percent_sum = $cart_sum * 0.21;
				$total = $cart_sum - $percent_sum;
			};?>
			<div id="cartFooterBorder"></div>
			<div class="cart">

				<div id="total" class="fright">
					<div class="total">
						<div class="label totaltext">Итого</div>
						<div class="total_summ totalnumb">
							<span id="summ_many" class="summ_many">
								<?=isset($cart_sum)? $cart_sum : "0.00"?>
							</span>  ГРН	</div>
					</div>
					<div class="total">
						<div class="label totaltext">Вы экономите</div>
						<div class="total_summ totalnumb">
							<span class="summ_many">
								<?=round($percent_sum, 2)?>
							</span>  ГРН	</div>
					</div>
					<div class="total">
						<div class="label" style="color: #000">К оплате</div>
						<div class="total_summ">
							<span class="summ_many" style='font-size: 1.2em'><?=number_format($total, 2, ",", "")?>
							</span>  ГРН	</div>
					</div>
				</div>
				<div class="cart_info fleft order_balance">
					<table id="percent">
						<tr <?=$percent == 0 ? '': "style='display:none'"?>>
							<td>Добавьте:</td>
							<td><?=round(500-$cart_sum,2)?>грн</td>
							<td>Получите скидку:</td>
							<td>50грн (10%)</td>
						</tr>
						<tr <?=($percent == 0 || $percent == 10) ? '': "style='display:none'"?>>
							<td><?=$percent == 10 ? 'Добавьте:' : ''?></td>
							<td <?=($percent == 0) ? "style=\"color: #9E9E9E\"" : ''?>><?=round(3000-$cart_sum,2)?>грн</td>
							<td><?=$percent == 10 ? 'Получите скидку' : ''?></td>
							<td <?=($percent == 0) ? "style=\"color: #9E9E9E\"" : ''?>>480грн (16%)</td>
						</tr>
						<tr <?=($percent == 0 || $percent == 10 || $percent == 16) ? '': "style='display:none'"?>>
							<td><?=$percent == 16 ? 'Добавьте' : ''?></td>
							<td <?=($percent == 10 || $percent == 0) ? "style=\"color: #9E9E9E\"" : ''?>><?=round(10000-$cart_sum,2)?>грн</td>
							<td><?=$percent == 16 ? 'Получите скидку' : ''?></td>
							<td <?=($percent == 10 || $percent == 0) ? "style=\"color: #9E9E9E\"" : ''?>>2100грн (21%)</td>
						</tr>
						<?=$percent == 21 ? 'Ваша скидка 21%' : ''?>
					</table>
					<div class="price_nav"></div>
				</div>
			</div>
			<div class="action_block">
				<div id="removingProd" class="hidden">
					Подождите идет удаление...
				</div>
				<div class="wrapp">
					<form action="">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<label style="color: #7F7F7F">*Телефон</label>
							<input class="mdl-textfield__input phone" type="text" id="user_number" pattern="/[^\d]+/">
							<label class="mdl-textfield__label" for="user_number" style="color: #FF5722;"></label>
							<span class="mdl-textfield__error err_tel orange">Поле обязательное для заполнения!</span>
						</div>
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label hidden" id="promo_input">
							<input class="mdl-textfield__input" type="text" id="sample7">
							<label class="mdl-textfield__label" for="sample7">Промокод</label>
						</div>
						<?if(!G::isLogged() || !_acl::isAdmin()){?>
							<div id="button-cart1">
								<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect" type='submit' value="Отправить">Оформить заказ</button>
							</div>
						<?}else{?>
							<p>Вы не можете использовать корзину</p>
						<?}?>
					</form>
					<script type='text/javascript'>
						$(function(){
							$(".phone").mask("+38 (099) ?999-99-99");
							$('#cart').on('click', '#button-cart1 button', function(e){
								e.preventDefault();
								addLoadAnimation('#cart');
								var phone = $('.action_block input.phone').val().replace(/[^\d]+/g, "");
								if(phone.length == 12){
									ajax('cart', 'makeOrder', {phone: phone}).done(
										function(data){
										if(data.status == 200){
											closeObject('cart');
											openObject('quiz');
											/*location.reload();*/
										}
									});
								}else{
									removeLoadAnimation('#cart');
								}
							});
						});
					</script>
				</div>
			</div>
		</div>
		<div id="graph" data-type="modal" data-target="<?=(isset($GLOBALS['CURRENT_ID_CATEGORY']))?$GLOBALS['CURRENT_ID_CATEGORY']:0;?>">
			<div class="modal_container"></div>
		</div>
		<!-- Модалки кабинета. Заказы -->
		<div id="cloneOrder" class="modalEditOrder" data-type="modal">
			<h5>Очистить текущую корзину или оставить?</h5>
			<button id="clearCatBtn" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect applyBtn">Да, очистить!</button>
			<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect cancelBtn btn_js" data-name="cloneOrder">Нет, оставить!</button>
		</div>
		<div id="confirmDelOrder" class="modalEditOrder" data-type="modal">
			<h5>Вы действительно хотите удалить заказ?</h5>
			<button id="delOrderBtnMod" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect applyBtn">Да, удалить!</button>
			<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect cancelBtn btn_js" data-name="confirmDelOrder">Нет, оставить!</button>
		</div>
		<div id="confirmCnclOrder" class="modalEditOrder" data-type="modal">
			<h5>Вы действительно хотите отменить заказ?</h5>
			<button id="cnclOrderBtnMod" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect applyBtn">Да, отменить!</button>
			<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect cancelBtn btn_js" data-name="confirmCnclOrder">Нет, оставить!</button>
		</div>

	</div>
	<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
		<symbol id="XLS" viewBox="-467 269 24 24" style="enable-background:new -467 269 24 24;" xml:space="preserve">
			<style type="text/css">
				.st2{font-family:'Arial-BoldMT';}
				.st3{font-size:12px;}
			</style>
			<path class="st0" d="M-467,269h24v24h-24V269z"/>
			<path class="st1" d="M-449.2,290.5h-11.7c-0.9,0-1.7-0.8-1.7-1.7v-15.6c0-0.9,0.8-1.7,1.7-1.7h7.6l5.8,5.6v11.7
				C-447.4,289.7-448.2,290.5-449.2,290.5z"/>
			<path class="st1" d="M-453.9,271.8l0,4c0,0.7,0.6,1.3,1.3,1.3h5.2"/>
			<text transform="matrix(1 0 0 1 -458.8125 287.5)" class="st2 st3">X</text>
		</symbol>

		<symbol id="txt" x="0px" y="0px" viewBox="-467 269 24 24" style="enable-background:new -467 269 24 24;" xml:space="preserve">
			<path class="st0" d="M-467,269h24v24h-24V269z"/>
			<path class="st1" d="M-449.2,290.5h-11.7c-0.9,0-1.7-0.8-1.7-1.7v-15.6c0-0.9,0.8-1.7,1.7-1.7h7.6l5.8,5.6v11.7
				C-447.4,289.7-448.2,290.5-449.2,290.5z"/>
			<path class="st1" d="M-453.9,271.8v4c0,0.7,0.6,1.3,1.3,1.3h5.2"/>
			<path d="M-461,287.5h12.1v-1.7H-461V287.5z M-461,284.1h12.1v-1.7H-461V284.1z M-461,278.9v1.7h12.1v-1.7H-461z"/>
		</symbol>

		<symbol id="img" x="0px" y="0px" viewBox="-467 269 24 24" style="enable-background:new -467 269 24 24;" xml:space="preserve">
			<path class="st0" d="M-467,269h24v24h-24V269z"/>
			<path class="st1" d="M-449.2,290.5h-11.7c-0.9,0-1.7-0.8-1.7-1.7v-15.6c0-0.9,0.8-1.7,1.7-1.7h7.6l5.8,5.6v11.7
				C-447.4,289.7-448.2,290.5-449.2,290.5z"/>
			<path class="st1" d="M-453.9,271.8l0,4c0,0.7,0.6,1.3,1.3,1.3h5.2"/>
			<path d="M-452.8,281.8l-3,4.3l-2.2-2.8l-3,4.3h12.1L-452.8,281.8z"/>
			<ellipse cx="-458.2" cy="280.5" rx="1.4" ry="1.5"/>
		</symbol>

		<symbol id="paper" x="0px" y="0px" viewBox="-467 269 24 24" style="enable-background:new -467 269 24 24;" xml:space="preserve">
			<style type="text/css">
				.st0{fill:none;}
				.st1{fill:none;stroke:#000;stroke-miterlimit:10;}
			</style>
			<path class="st0" d="M-467,269h24v24h-24V269z"/>
			<path class="st1" d="M-449.2,290.5h-11.7c-0.9,0-1.7-0.8-1.7-1.7v-15.6c0-0.9,0.8-1.7,1.7-1.7h7.6l5.8,5.6v11.7
				C-447.4,289.7-448.2,290.5-449.2,290.5z"/>
			<path class="st1" d="M-453.9,271.8l0,4c0,0.7,0.6,1.3,1.3,1.3h5.2"/>
		</symbol>

		<symbol id="date" viewBox="0 0 24 24" height="24"  width="24">
			<path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/>
			<path d="M0 0h24v24H0z" fill="none"/>
		</symbol>

		<symbol id="shipping" viewBox="0 0 24 24" height="24"  width="24">
			<path d="M0 0h24v24H0z" fill="none"/>
			<path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
		</symbol>

		<symbol id="money" viewBox="0 0 24 24" height="24"  width="24">
			<path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
			<path d="M0 0h24v24H0z" fill="none"/>
		</symbol>

		<symbol id="shuffle" viewBox="0 0 24 24" height="24"  width="24">
			<path d="M0 0h24v24H0z" fill="none"/>
			<path d="M10.59 9.17L5.41 4 4 5.41l5.17 5.17 1.42-1.41zM14.5 4l2.04 2.04L4 18.59 5.41 20 17.96 7.46 20 9.5V4h-5.5zm.33 9.41l-1.41 1.41 3.13 3.13L14.5 20H20v-5.5l-2.04 2.04-3.13-3.13z"/>
		</symbol>


		<symbol id="like" viewBox="0 0 24 24" height="24"  width="24">
			<path d="M0 0h24v24H0z" fill="none"/>
		<path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-1.91l-.01-.01L23 10z"/>
		</symbol>
		<symbol id="dislike" viewBox="0 0 24 24" height="24"  width="24">
			<path d="M0 0h24v24H0z" fill="none"/>
			<path d="M15 3H6c-.83 0-1.54.5-1.84 1.22l-3.02 7.05c-.09.23-.14.47-.14.73v1.91l.01.01L1 14c0 1.1.9 2 2 2h6.31l-.95 4.57-.03.32c0 .41.17.79.44 1.06L9.83 23l6.59-6.59c.36-.36.58-.86.58-1.41V5c0-1.1-.9-2-2-2zm4 0v12h4V3h-4z"/>
		</symbol>
	</svg>
</body>
</html>