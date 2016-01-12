<!DOCTYPE html>
<html lang="ru">
<head>
	<title><?=isset($GLOBALS['prod_title'])?$GLOBALS['prod_title'].' | ':null;?><?=(isset($GLOBALS['products_title']) && $GLOBALS['products_title'] != '')?$GLOBALS['products_title']:$__page_title;?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?if($GLOBALS['CurrentController'] == 'product'){
		if($item['indexation'] == 0){?>
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
			current_controller = "<?=$GLOBALS['CurrentController']?>";
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
	<!-- END JS load -->

	<!-- Google Material Icon -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

	<!-- END include specific js templates for controllers -->
	<?if(!isset($_SESSION['member']['gid']) || !in_array($_SESSION['member']['gid'], array(_ACL_SUPPLIER_MANAGER_, _ACL_SUPPLIER_, _ACL_DILER_, _ACL_MODERATOR_, _ACL_MANAGER_, _ACL_SEO_))){?>
		<!-- Google counter -->
		<?isset($GLOBALS['CONFIG']['google_counter'])?$GLOBALS['CONFIG']['google_counter']:null;?>
		<!-- END Google counter -->

		<!-- Yandex.Metrika counter -->
		<?isset($GLOBALS['CONFIG']['yandex_counter'])?$GLOBALS['CONFIG']['yandex_counter']:null?>
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
			<!-- <div class="cont_top">
				<div><img src="<?=$GLOBALS['URL_img_theme']?>smeta_2.png" alt=""></div>
				<div>
					<span>Добро пожаловать!</span>
					<span>Быстро и качественно решаем задачи отдела снабжения каждой компании.</span>
				</div>
			</div> -->
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
			<?=$__sidebar_l?>
			<div class="catalog_close btn_js" data-name="catalog">
				<i class="material-icons" title="Закрыть каталог">close</i>
			</div>
		</aside>
	<?}?>
	<div id="newheader_wrapp"></div>
	<section class="main <?=$GLOBALS['CurrentController'] == 'product'?'product_page':null?>">
		<?if(in_array($GLOBALS['CurrentController'], $GLOBALS['LeftSideBar'])){?>
			<aside class="mdl-color--grey-100 mdl-cell--hide-phone">
				<?=$__sidebar_l?>
			</aside>
		<?}?>
		<section class="center">
			<?if($GLOBALS['CurrentController'] == 'main'){?>
				<div class="stat_year mdl-color--grey-100 mdl-cell--hide-phone clearfix">
					<div class="stat_info">
						<p>График опроса</p>
						<ul>
							<li>Горячий сезон</li>
							<li>Активный</li>
							<li>Межсезонные</li>
						</ul>
					</div>
					<div class="graph_block">
						<div class="stat_title">
							<p class="mopt_demand"><span></span>Розничный cпрос</p>
							<p class="opt_demand"><span></span>Оптовый спрос</p>
						</div>
						<div class="график"></div>
						<nav class="stat_month">
							<ul>
								<li>Январь</li>
								<li>Февраль</li>
								<li>Март</li>
								<li>Апрель</li>
								<li class="active">Май</li>
								<li>Июнь</li>
								<li>Июль</li>
								<li>Август</li>
								<li>Сентябрь</li>
								<li>Октябрь</li>
								<li>Ноябрь</li>
								<li>Декабрь</li>
							</ul>
						</nav>
					</div>
				</div>
			<?}?>
			<div class="content">
				<?if($GLOBALS['CurrentController'] != 'main'){?>
					<?=$__breadcrumbs?>
					<!-- <h1 class="page_header"><?=$GLOBALS['CurrentController'] == 'products'?$curcat['name']:$header;?></h1> -->
					<?=$__center?>
				<?}else{?>
					<div class="content_header mdl-cell--hide-phone clearfix">
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
						</div>
						<div class="cart_info clearfix">
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
					<div class="products">
						<div class="card clearfix">
							<div class="product_photo">
								<a href="#">
									<img src="<?=$GLOBALS['URL_img_theme']?>chair_mini1.jpg" alt="">
								</a>
							</div>
							<p class="product_name"><a href="/product.html">Игрушка детская «Веселый поезд»</a> <span class="product_article">Арт: 109742</span></p>
							<div class="product_buy">
								<p class="price">29000,34</p>
								<div class="buy_block">
									<div class="btn_remove">
										<button class="mdl-button material-icons">remove</button>
									</div>
									<input type="text" class="qty_js" value="0">
									<div class="btn_buy">
										<button class="mdl-button mdl-js-button buy_btn_js" type="button">Купить</button>
									</div>
								</div>
							</div>
							<div class="product_info clearfix">
								<div class="note clearfix">
									<textarea placeholder="Примечание: "></textarea>
									<label class="info_key">?</label>
									<div class="info_description">
										<p>Поле для ввода примечания к товару.</p>
									</div>
								</div>
							</div>
						</div>
						<div class="card clearfix">
							<div class="product_photo">
								<a href="#">
									<img src="<?=$GLOBALS['URL_img_theme']?>chair_mini1.jpg" alt="">
								</a>
							</div>
							<p class="product_name"><a href="#">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio iure, sint voluptatibus aliquam nobis pariatur voluptas vel ullam! Incidunt fugit provident temporibus, excepturi sint assumenda harum velit nesciunt veniam, quidem.</a> <span class="product_article">Арт: 109742</span></p>
							<div class="product_buy">
								<p class="price">29000,34</p>
								<div class="buy_block">
									<div class="btn_remove">
										<button class="mdl-button material-icons">remove</button>
									</div>
									<input type="text" class="qty_js" value="0">
									<div class="btn_buy">
										<button class="mdl-button mdl-js-button buy_btn_js" type="button"><i class="material-icons">add</i></button>
									</div>
								</div>
							</div>
							<div class="product_info clearfix">
								<div class="note in_cart clearfix">
									<textarea placeholder="Примечание: "></textarea>
									<label class="info_key">?</label>
									<div class="info_description">
										<p>Поле для ввода примечания к товару.</p>
									</div>
								</div>
							</div>
						</div>
						<div class="card clearfix">
							<div class="product_photo">
								<a href="#">
									<img src="<?=$GLOBALS['URL_img_theme']?>chair_mini1.jpg" alt="">
								</a>
							</div>
							<p class="product_name"><a href="#">Игрушка детская «Веселый поезд»</a> <span class="product_article">Арт: 109742</span></p>
							<div class="product_buy">
								<p class="price">29,34</p>
								<div class="buy_block">
									<div class="btn_remove">
										<button class="mdl-button material-icons">remove</button>
									</div>
									<input type="text" class="qty_js" value="0">
									<div class="btn_buy">
										<button class="mdl-button mdl-js-button buy_btn_js" type="button"><i class="material-icons">add</i></button>
									</div>
								</div>
							</div>
							<div class="product_info clearfix">
								<div class="note in_cart clearfix">
									<textarea class="required" placeholder="Примечание: обязательно"></textarea>
									<label class="info_key">?</label>
									<div class="info_description">
										<p>Поле для ввода примечания к товару.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="show_more mdl-cell--hide-phone"><a href="#">Показать еще 30 товаров</a></div>
					<div class="paginator">
						<ul>
							<li class="active"><a href="#">1</a></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
						</ul>
					</div>
				<?}?>
			</div>
			<footer class="mdl-mega-footer mdl-color--grey-100 clearfix">
				<div class="mdl-mega-footer__left-section clearfix">
					<div class="questions mdl-cell--hide-tablet mdl-cell--hide-phone">
						<h5>Вопросы</h5>
						<ul>
							<li><a href="#">Главная</a></li>
							<li><a href="#">О нас</a></li>
							<li><a href="#">Lorem ipsum dolor sit amet, consectetur adipisicing elit?</a></li>
							<li><a href="#">Справка</a></li>
							<li><a href="#">Доставка</a></li>
							<li><a href="#">Lorem ipsum dolor sit amet, consectetur adipisicing elit?</a></li>
							<li><a href="#">Контакты</a></li>
							<li><a href="#">Стать дилером</a></li>
							<li><a href="#">Скидки</a></li>
							<li><a href="#">Форум</a></li>
						</ul>
					</div>
					<div class="contacts">
						<div class="mdl-cell--hide-phone">
							<h5>Контакты</h5>
							<ul class="phone_nav_contacts clearfix">
								<li class="parent_nav"><div class="material-icons">phone</div><span>(063) 225-91-83</span></li>
								<li><span>(099) 228-69-38</span></li>
								<li><span>(093) 322-91-83</span></li>
								<li class="parent_nav"><div class="material-icons">mail</div><span>administration@x-torg.com</span></li>
								<li class="parent_nav"><div class="material-icons">location_on</div><span>г. Харьков, ТЦ Барабашово, Площадка Свояк, Торговое Место 130</span></li>
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
					<img src="//lh3.ggpht.com/H8LE7fE6SRPpyBIs3CpNLn_4LBxZjmHbCos9CCeyDmUEGGI05vBM1QoQLcvDMp8sp70EI5Pk=w250" height="250" width="300">
				</div>
				<div class="copyright">
					<p>&copy; Отдел снабжения XT.ua 2015</p>
					<p class="created">Разработано в <a href="http://webking.link/">WebKingStudio</a></p>
				</div>
			</footer>
		</section>
	</section>










	<div id="quiz" data-type="modal">
		<div class="modal_container summary_info">
			<div class="row hidden">Фамилия: <span class="lastname"></span></div>
			<div class="row hidden">Имя: <span class="firstname"></span></div>
			<div class="row hidden">Отчество: <span class="middlename"></span></div>
			<div class="row hidden">Область: <span class="region"></span></div>
			<div class="row hidden">Город: <span class="city"></span></div>
			<div class="row hidden">Служба доставки: <span class="delivery_service"></span></div>
			<div class="row hidden">Способ доставки: <span class="delivery_method"></span></div>
		</div>
		<div class="modal_container step_1 active" data-step="1">
			<div class="head_top">
				<h5>Здравствуйте! Меня зовут Алёна и я сопровождаю Ваш заказ.</h5>
				<span>Сейчас я вижу Вас как "Клиент 2345623", скажите, как Вас зовут?</span>
			</div>
			<div class="row">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="lastname">
					<input class="mdl-textfield__input" type="text" name="lastname" value="Пархоменко">
					<label class="mdl-textfield__label" for="lastname">Фамилия</label>
					<span class="mdl-textfield__error">Введите фамилию</span>
				</div>
			</div>
			<div class="row">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="firstname">
					<input class="mdl-textfield__input" type="text" name="firstname" value="Александр">
					<label class="mdl-textfield__label" for="firstname">Имя</label>
					<span class="mdl-textfield__error">Введите имя</span>
				</div>
			</div>
			<div class="row">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="middlename">
					<input class="mdl-textfield__input" type="text" name="middlename" value="Васильевич">
					<label class="mdl-textfield__label" for="middlename">Отчество</label>
					<span class="mdl-textfield__error">Введите отчество</span>
				</div>
			</div>
			<div class="row">
				<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="2">Далее</button>
			</div>
		</div>
		<div class="modal_container step_2" data-step="2">
			<div class="head_top">
				<h6><span class="client">Пользователь</span>, приятно познакомиться!</h6>
				<span>Мы доставляем в 460 городов, а откуда Вы?</span>
			</div>
			<div class="row">
				<span class="number_label">Область</span>
				<div class="region mdl-cell--hide-phone imit_select">
					<button id="region_select" class="mdl-button mdl-js-button">
						<span class="select_field">Харьковская область<!-- Выбрать --></span>
						<i class="material-icons">keyboard_arrow_down</i>
					</button>
					<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="region_select"></ul>
				</div>
			</div>
			<div class="row">
				<span class="number_label">Город</span>
				<div class="city mdl-cell--hide-phone imit_select">
					<button id="city_select" class="mdl-button mdl-js-button">
						<span class="select_field">Харьков<!-- Выбрать --></span>
						<i class="material-icons">keyboard_arrow_down</i>
					</button>
					<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="city_select"></ul>
				</div>
			</div>
			<div class="row">
				<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="1">Назад</button>
				<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="3">Далее</button>
			</div>
		</div>

		<div class="modal_container step_3" data-step="3">
			<div class="head_top">
				<h6><span class="client">Пользователь</span>, доставка в <span class="city">Город</span> возможна!</h6>
			</div>
			<label class="mdl-radio mdl-js-radio" for="option-1">
				<input type="radio" id="option-1" class="mdl-radio__button" name="options" value="1" checked>
				<span class="mdl-radio__label">Новая Почта</span>
			</label>
			<div class="row delivery_service">
			</div>
			<div class="row">
				<span>Вам удобнее забрать заказ со склада, или принять по адресу?</span>
				<div class="sort imit_select">
					<button id="sort-lower-left_3" class="mdl-button mdl-js-button">
						<i class="material-icons fright">keyboard_arrow_down</i><span class="selected_sort select_fild">Выбрать</span>
					</button>
					<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="sort-lower-left_3">
						<li class="mdl-menu__item sort" data-value="1" >Принять по адресу</li>
						<li class="mdl-menu__item sort" data-value="2" >Забрать со склада</li>
					</ul>
				</div>
			</div>
			<div class="row">
				<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="2">Назад</button>
				<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="4">Далее</button>
			</div>
		</div>

		<div class="modal_container step_4" data-step="4">
			<div class="head_top">
				<h5>Здравствуйте! Меня зовут Алёна и я сопровождаю Ваш заказ.</h5>
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
			<div class="row">
				<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="3">Назад</button>
				<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="5">Отправить</button>
			</div>
			<div class="line">
				<div class="line_active"></div>
			</div>
			<span class="go">Готово!</span>
		</div>

		<div class="progress">
			<div class="line">
				<div class="line_active"></div>
			</div>
			<span class="go">Заполнено: </span>
		</div>
		<div class="modal_container step_5" data-step="5">
			<div class="head_top">
				<h5>Здравствуйте! Меня зовут Алёна и я сопровождаю Ваш заказ.</h5>
				<span>Спасибо! Я свяжусь с Вами в течении часа.</span>
			</div>
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
					<label class="mdl-textfield__label" for="email">Логин</label>
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

					<!-- <div id="password_error"></div>
					<div class="error_description"></div> -->
				</div>
				<button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--raised mdl-button--colored sign-up">Регистрация</button>
				<button class="mdl-button mdl-js-button mdl-js-ripple-effect switch" data-name="login">Вход</button>
			</form>
		</div>
	</div>

	<?if($GLOBALS['CurrentController'] == 'product'){?>
		<div id="big_photo" data-type="modal">
			<img src="" alt="">
		</div>
	<?}?>
	<div id="cart" data-type="modal">
		<div class="modal_container"></div>
	</div>

</body>
</html>