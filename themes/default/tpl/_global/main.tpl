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
<body class="<?=in_array($GLOBALS['CurrentController'], $GLOBALS['LeftSideBar'])?'sidebar':'no-sidebar'?> c_<?=$GLOBALS['CurrentController']?> <?=$GLOBALS['CurrentController'] == "main"?'':'banner_hidden'?>">
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
			<li><a href="#">Скидки</a></li>
			<li><a href="#">Каталог</a></li>
			<li><a href="#">Фильтры</a></li>
			<li><a href="#">Снабжение организаций</a></li>
			<li><a href="#">Поставки магазинам</a></li>
			<li><a href="#">Новости</a></li>
			<li><a href="#">Часто задаваемые вопросы</a></li>
			<li><a href="#">Книга жалоб и предложений</a></li>
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
		<div id="owl-main_slider" class="owl-carousel">
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
						<img class="item_svg" src="<?=$GLOBALS['URL_img_theme']?>banner/factory.svg">
						<h3>Снабжение<br> предриятий</h3>

					</span>
				</a>
				<a href="#">
					<span class="text_block">
						<img  class="item_svg" src="<?=$GLOBALS['URL_img_theme']?>banner/shop.svg">
						<h3>Поставки<br> магазинам</h3>

					</span>
				</a>
				<a href="#">
					<span class="text_block">
						<img  class="item_svg" src="<?=$GLOBALS['URL_img_theme']?>banner/home.svg">
						<h3>Обеспечение<br> быта</h3>

					</span>
				</a>
			</div>
			<!-- 	<a class="item" href="#">
				<img class="lazyOwl" data-src="<?=$GLOBALS['URL_img_theme']?>banner/скачанные-файлы-(1).jpg">
			</a>
			<a class="item" href="#">
				<img class="lazyOwl" data-src="<?=$GLOBALS['URL_img_theme']?>banner/скачанные-файлы-(2).jpg">
			</a>
			<a class="item" href="#">
				<img class="lazyOwl" data-src="<?=$GLOBALS['URL_img_theme']?>banner/скачанные-файлы-(3).jpg">
			</a> -->
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
					<h1 class="page_header"><?=$GLOBALS['CurrentController'] == 'products'?$curcat['name']:$header;?></h1>
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
						<div class="cart_info">
							<div class="your_discount">Ваша скидка</div>
							<div class="tabs_container">
								<ul>
									<li class="in_cart_block">
										<a href="#" class="btn_js" data-name="cart">20 товаров <span class="material-icons">shopping_cart</span></a>
									</li>
									<li>0%</li>
									<li>10%</li>
									<li>16%</li>
									<li class="active">21%</li>
								</ul>
							</div>
							<div class="order_balance">Еще заказать на <span class="summ">10000</span> грн.</div>
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
	<?if($GLOBALS['CurrentController'] == 'product'){?>
		<div id="big_photo" data-type="modal">
			<img src="" alt="">
		</div>
	<?}?>
	<div id="cart" data-type="modal">
		<div></div>
	</div>
</body>
</html>