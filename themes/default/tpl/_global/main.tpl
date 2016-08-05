<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title><?=$__page_title?$__page_title:null;?></title>
	<?=!empty($__page_description)?'<meta name="description" content="'.$__page_description.'"/>':null;?>
	<?=!empty($__page_keywords)?'<meta name="keywords" content="'.$__page_keywords.'"/>':null;?>
	<?if(in_array($GLOBALS['CurrentController'], array('product', 'products', 'news', 'post', 'page'))){
		if(!isset($indexation) || $indexation == 0){?>
			<meta name="robots" content="noindex, follow"/>
		<?}
	}else{?>
		<!-- <meta name="robots" content="noindex, follow"/> -->
	<?}?>
	<!-- setting canonical pages -->
	<?if($GLOBALS['CurrentController'] == 'main'){?>
		<link rel="canonical" href="<?=_base_url?>/"/>
	<?}elseif($GLOBALS['CurrentController'] == 'products'){
		if(strpos($_SERVER['REQUEST_URI'], 'limitall')){?>
			<link rel="canonical" href="<?=_base_url.str_replace('/limitall', '', $_SERVER['REQUEST_URI']);?>"/>
		<?}else{
			if(isset($GLOBALS['meta_canonical'])){?>
				<link rel="canonical" href="<?=$GLOBALS['meta_canonical'];?>"/>
			<?}
		}
		if(isset($GLOBALS['meta_next'])){?>
			<link rel="next" href="<?=$GLOBALS['meta_next'];?>"/>
		<?}
		if(isset($GLOBALS['meta_prev'])){?>
			<link rel="prev" href="<?=$GLOBALS['meta_prev'];?>"/>
		<?}
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
	<?php
	echo '<script type="text/javascript">
		var URL_base = "'._base_url.'/",
			current_controller = "'.$GLOBALS['CurrentController'].'",
			ajax_proceed = false,			
			columnLimits = {0: 10000, 1: 3000, 2: 500, 3: 0},	
			current_id_category = '.(isset($GLOBALS['CURRENT_ID_CATEGORY'])?$GLOBALS['CURRENT_ID_CATEGORY']:'null').',
			IsLogged = '.(G::IsLogged()?'true':'false').',
			IsMobile = '.(G::isMobile()?'true':'false').';
	</script>';
	?>
	<!-- END define JS global variables -->

	<!-- CSS load -->
	<?if(isset($css_arr)){
		$tmpstr = '<link href="'.$GLOBALS['URL_css'].'%s" rel="stylesheet" type="text/css"/>'."\n";
		foreach($css_arr as $css){
			if(substr($css, -9) == "style.css" || substr($css, -13) == "style.min.css"){
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
	<?if(!G::IsLogged() || !in_array($_SESSION['member']['gid'], array(_ACL_SUPPLIER_MANAGER_, _ACL_SUPPLIER_, _ACL_DILER_, _ACL_MODERATOR_, _ACL_MANAGER_, _ACL_SEO_))){?>
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
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCK1pgVfW7PcvNFyKyEj8_md7h2l2vTV9U&language=ru"></script>
</head>
<body class="<?=in_array($GLOBALS['CurrentController'], $GLOBALS['LeftSideBar'])?'sidebar':'no-sidebar'?> c_<?=isset($_SERVER['HTTP_REFERER']) && (strpos($_SERVER['HTTP_REFERER'], _base_url) === false) ? 'main':($GLOBALS['CurrentController'] === 'main'?$GLOBALS['CurrentController']:$GLOBALS['CurrentController'].' banner_hide')?>">
	
	<!-- Google Tag Manager -->
	<?if(SETT != 0){?>
		<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-K9CXG3"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-K9CXG3');</script>
	<?}?>
	<!-- End Google Tag Manager -->
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
	<?if( $GLOBALS['CurrentController'] === 'main' || (isset($_SERVER['HTTP_REFERER']) && (strpos($_SERVER['HTTP_REFERER'], _base_url) === false ))){?>
		<section class="banner">
			<div class="cont">
				<a href="<?=Link::Custom('page', 'Snabzhenie_predpriyatij');?>" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>>
					<span class="text_block">
						<img class="item_svg" src="<?=$GLOBALS['URL_img_theme']?>banner/factory.gif">
						<h3>Снабжение<br> предприятий</h3>
					</span>
				</a>
				<a href="<?=Link::Custom('page', 'Postavki_magazinam');?>" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>>
					<span class="text_block">
						<img class="item_svg" src="<?=$GLOBALS['URL_img_theme']?>banner/shop.gif">
						<h3>Поставки<br> магазинам</h3>
					</span>
				</a>
				<a href="<?=Link::Custom('page', 'Obespechenie_byta');?>" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>>
					<span class="text_block">
						<img class="item_svg" src="<?=$GLOBALS['URL_img_theme']?>banner/home.gif">
						<h3>Обеспечение<br> быта</h3>
					</span>
				</a>
			</div>
		</section>
	<?}?>	
	<section class="main<?=$GLOBALS['CurrentController'] == 'product'?' product_page':null?>">
		<section class="center">
			<style>
				#last_orders_count {
					width: 100%;
					height: 300px;
				}
			</style>
			<?=isset($__graph)?$__graph:null;?>
			<div class="page_content page_content_js">
				<?if($GLOBALS['CurrentController'] !== 'main'){?>
					<?=$__breadcrumbs?>
					<?=$__center?>
				<?}else{?>
					<div class="content_header clearfix">
						<?if(isset($available_sorting_values)){?>
							<div class="sort imit_select">
								<span>Сортировать:</span>
								<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label">
									<select id="sorting" name="sorting" class="mdl-selectfield__select sorting_js" onChange="SortProductsList($(this));">
										<?foreach($available_sorting_values as $key => $alias){ ?>
											<option <?=isset($GLOBALS['Sort']) && $GLOBALS['Sort'] == $key?'selected':null;?> value="<?=!isset($GLOBALS['Rewrite'])?Link::Custom($GLOBALS['CurrentController'], null, array('sort' => $key)):Link::Category($GLOBALS['Rewrite'], array('sort' => $key));?>"><?=$alias?></option>
										<?}?>
									</select>
								</div>

								<!-- <a href="#" class="graph_up hidden" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>><i class="material-icons">timeline</i></a>
								<?if(isset($_SESSION['member']) && $_SESSION['member']['gid'] == 0){?>
									<a href="#" class="show_demand_chart_js one" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>><i class="material-icons">timeline</i></a>
								<?}elseif(isset($_SESSION['member']) && $_SESSION['member']['gid'] == 1){?>
									<a href="#" class="show_demand_chart_js two" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>><i class="material-icons">timeline</i></a>
								<?}?>
								-->
							</div>
						<?}?>
						<div class="catalog_btn btn_js mdl-cell--hide-desktop" data-name="catalog">Каталог</div>
						<div class="cart_info mdl-cell--hide-phone clearfix <?=$GLOBALS['CurrentController'] == 'main'?'hidden':null;?>">
							<div class="your_discount">Ваша скидка</div>
							<div class="price_nav"></div>
						</div>
						<div class="productsListView">
							<i id="changeToList" class="material-icons changeView_js <?=isset($_COOKIE['product_view']) && $_COOKIE['product_view'] == 'list' ? 'activeView' : NULL?>" data-view="list">view_list</i>
							<span class="mdl-tooltip" for="changeToList">Вид списком</span>
							<i id="changeToBlock" class="material-icons changeView_js <?=!isset($_COOKIE['product_view']) || $_COOKIE['product_view'] == 'block' ? 'activeView' : NULL?>" data-view="block">view_module</i>
							<span class="mdl-tooltip" for="changeToBlock">Вид блоками</span>
							<i id="changeToColumn" class="material-icons changeView_js hidden <?=isset($_COOKIE['product_view']) && $_COOKIE['product_view'] == 'column' ? 'activeView' : NULL?>" data-view="column">view_column</i>
							<span class="mdl-tooltip" for="changeToColumn">Вид колонками</span>
						</div>
					</div>
					<div id="view_block_js" class="<?=isset($_COOKIE['product_view'])?$_COOKIE['product_view'].'_view':'block_view'?> col-md-12 ajax_loading">
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
			<!-- Блок последних новостей -->
			<?if(isset($news) && $GLOBALS['CurrentController'] !== 'cabinet'){?>
				<div class="last_news"> 				
					<div class="last_news_title">
						<h4>Последние новости</h4>
						<a href="<?=Link::Custom('news');?>" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?> class="min news_more mdl-button mdl-js-button">Все новости</a>
					</div>
					<div class="xt_news">
						<?foreach($news as $item){?>
							<div class="news_item">
								<div class="news_image">
									<?if(isset($item['thumbnail'])){?>
										<img alt="<?=G::CropString($item['title'])?>" class="lazy" data-original="<?=$item['thumbnail'];?>"/>
										<noscript>
											<img alt="<?=G::CropString($item['title'])?>" src="<?=$item['thumbnail'];?>"/>
										</noscript>
									<?}?>
								</div>
								<a class="news_title" href="<?=Link::Custom('news', $item['translit']);?>" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>>
									<h6 class="min news_title"><?=$item['title']?></h6>
								</a>
								<div class="min news_description"><?=$item['descr_short']?></div>
								<div class="read_more">
									<div class="min news_date">
										<p>
										<?if(date('d-m-Y') == date("d-m-Y", $item['date'])){?>
											Опубликовано Сегодня
										<?}elseif(date('d-m-Y', strtotime(date('d-m-Y').' -1 day')) == date('d-m-Y', $item['date'])){?>
											Опубликовано Вчера
										<?}else{?>
											Опубликовано
										<?  echo date("d.m.Y", $item['date']);
										}?>
										</p>
									</div>
									<a href="<?=Link::Custom('news', $item['translit']);?>" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?> class="mdl-button mdl-js-button">Читать далее</a>
								</div>
							</div>
						<?}?>	
					</div>
				</div>
			<?}?>
			<?if(isset($seotext)){?>
				<div class="mdl-grid">
					<div id="seoTextBlock" class="mdl-grid mdl-cell--12-col">
						<?=$seotext?>
					</div>
				</div>
			<?}elseif (isset($GLOBALS['descr_for_seo'])) {?>
				<div class="mdl-grid">
					<div id="seoTextBlock" class="mdl-grid mdl-cell--12-col">
						<?foreach($GLOBALS['descr_for_seo'] as $item){
							if(!empty($item['descr'])){?>
								<h2>Описание товара: <?=$item['name']?></h2>
								<p><?=$item['descr']?></p>
							<?}
						}?>
					</div>
				</div>
			<?}?>

			
		</section>
		<div id="canvas_mark_wrapper">
			<canvas id="err_canvas" width="10" height="10"></canvas>
		</div>
		<aside id="catalog" <?=(!in_array($GLOBALS['CurrentController'], $GLOBALS['LeftSideBar']) || G::isMobile())?'data-type="panel" data-position="left"':null?>>
			<div class="panel_container panel_container_js">
				<?=$__sidebar_l?>
			</div>
			<div class="catalog_close btn_js" data-name="catalog">
				<i class="material-icons" title="Закрыть каталог">close</i>
			</div>
		</aside>
	</section>
	<div class="phone_err_msg_js phone_err_msg err_msg_as_knob_js">
		<div class="err_msg_descr_wrap">
			<div class="err_msg_descr">Если у Вас возникли проблемы при работе с нашим сайтом</div>
			<div class="err_msg_btn">cообщите нам об ошибке</div>			
		</div>
	</div>
	<!-- message about error -->
	<div class="err_msg_as_wrap err_msg_as_wrap_js">
		<div class="err_msg_as err_msg_as_js">
			<div class="err_msg_as_title err_msg_as_knob_js">
				<p>Сообщите нам об ошибке</p>
				<i class="material-icons">keyboard_arrow_up</i>
			</div>
			<div class="err_msg_as_form err_msg_as_form_js">
				<form action="#">
					<div class="mdl-textfield mdl-js-textfield is-focused">
						<textarea name="errcomment" class="mdl-textfield__input" type="text" rows="3" id="sample5" autofocus></textarea>
						<label class="mdl-textfield__label" for="sample5">Опишите ошибку...</label>
					</div>
					<label class="screen_btn_js screen_btn mdl-checkbox mdl-js-checkbox" for="screenShotBox">
						<input type="checkbox" id="screenShotBox" class="mdl-checkbox__input" checked>
						<span class="mdl-checkbox__label">Добавить снимок экрана</span>
					</label>
					<div class="copyContainerWrap">
						<div id="savedCopyContainer">
							<img id="savedImageCopy" src="">
						</div>
						<div class="tools_wrapp_js tools_wrapp mdl-cell--hide-tablet mdl-cell--hide-phone">
							<i id="go_to_canvas_toolbar" class="material-icons go_to_canvas_toolbar_js">format_shapes</i>
							<div class="mdl-tooltip" for="go_to_canvas_toolbar">Выделить или затушевать нужную информацию</div>
							<i id="img_zoom" class="material-icons img_zoom_js">zoom_in</i>
							<div class="mdl-tooltip" for="img_zoom">Увеличить изображение</div>
						</div>
					</div>
					<div class="err_msg_as_send err_msg_as_send_js mdl-button mdl-js-button mdl-button--raised mdl-button--accent">Отправить</div>
				</form>
			</div>
		</div>
	</div>
	<div class="canvas_toolbar">
		<div id="problem_area" class="problem_area problem_area_js"></div>
		<div class="mdl-tooltip" for="problem_area">Выделить проблему</div>
		<div id="confidential" class="confidential confidential_js"></div>
		<div class="mdl-tooltip" for="confidential">Заштриховать конфиденциальную информацию</div>
		<div id="pencil_for_canvas" class="pencil_for_canvas pencil_for_canvas_js"></div>
		<div class="mdl-tooltip" for="pencil_for_canvas">Карандаш</div>
		<!-- Доработать функционал ластика 
		<div id="eraser_for_canvas" class="eraser_for_canvas eraser_for_canvas_js"></div>
		<div class="mdl-tooltip" for="eraser_for_canvas">Ластик</div> -->
		<button class="canvasReady canvasReady_js mdl-button mdl-js-button">Готово</button>
		<button class="canvasClear canvasClear_js mdl-button mdl-js-button">Очистить</button>
		<i class="close_canvas_toolbar_js close_canvas_toolbar material-icons">clear</i>
	</div>
	<div class="waiting_block_for_img_canvas_js waiting_block_for_img_canvas">
		Подождите, формируется скриншот страницы...
	</div>
	<footer class="mdl-mega-footer">
		<div class="footer_wrap">
			<div class="mdl-mega-footer__left-section">
				<div class="questions">
					<h5>Навигация</h5>
					<ul>
						<li><a href="<?=Link::Custom('main', null)?>" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>>Главная</a></li>
						<?foreach($list_menu as $menu){?>
							<li><a href="<?=Link::Custom('page', $menu['translit']);?>" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>><?=$menu['title']?></a></li>
						<?}?>
						<li><a href="<?=Link::Custom('price');?>" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>>Прайс-лист</a></li>
					</ul>
				</div>
				<div class="contacts">
					<div>
						<h5>Контакты</h5>
						<ul class="phone_nav_contacts">
							<?if(isset($GLOBALS['CONFIG']['footer_phone']) && $GLOBALS['CONFIG']['footer_phone'] != ''){?>
								<li><span><div class="material-icons">phone</div><?=$GLOBALS['CONFIG']['footer_phone'];?></span></li>
							<?}?>
							<!-- <li><span>(099) 228-69-38</span></li>
							<li><span>(093) 322-91-83</span></li> -->
							<?if(isset($GLOBALS['CONFIG']['footer_email']) && $GLOBALS['CONFIG']['footer_email'] != ''){?>
								<li><span><div class="material-icons">mail</div><?=$GLOBALS['CONFIG']['footer_email'];?></span></li>
							<?}?>
							<?if(isset($GLOBALS['CONFIG']['footer_address']) && $GLOBALS['CONFIG']['footer_address'] != ''){?>
								<li><span><div class="material-icons">location_on</div><?=$GLOBALS['CONFIG']['footer_address'];?></span></li>
							<?}?>
						</ul>
					</div>
					<div class="social hidden">
						<ul>
							<li><a href="https://vk.com/xt_ua" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?> target="_blank" class="vk" title="Вконтакте"><img src="<?=$GLOBALS['URL_img_theme']?>vk.svg" alt="Вконтакте"></a></li>
							<li><a href="http://ok.ru/group/54897683202077" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?> target="_blank" class="ok" title="Однокласники"><img src="<?=$GLOBALS['URL_img_theme']?>odnoklassniki.svg" alt="Однокласники"></a></li>
							<li><a href="https://plus.google.com/+X-torg/" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?> target="_blank" class="g_pl" title="google+"><img src="<?=$GLOBALS['URL_img_theme']?>google-plus.svg" alt="google+"></a></li>
							<li><a href="https://www.facebook.com/KharkovTorg" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?> target="_blank" class="f" title="Facebook"><img src="<?=$GLOBALS['URL_img_theme']?>facebook.svg" alt="Facebook"></a></li>
							<li><a href="https://twitter.com/we_xt_ua" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?> target="_blank" class="tw" title="Twitter"><img src="<?=$GLOBALS['URL_img_theme']?>twitter.svg" alt="Twitter"></a></li>
							<li><a href="https://www.youtube.com/channel/UCUSXO-seq23KfMwbn4q9VVw" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?> target="_blank" class="y_t" title="Yuotube"><img src="<?=$GLOBALS['URL_img_theme']?>youtube.svg" alt="Yuotube"></a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="ad_sense mdl-color--grey-200">
				<?if($GLOBALS['CurrentController'] == 'products'){?>
					<?if($GLOBALS['CURRENT_ID_CATEGORY'] == 478){?>
						<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
						<!-- Категории -->
						<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-2337139989896773" data-ad-slot="8269932848" data-ad-format="auto"></ins>
						<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
					<?}elseif($GLOBALS['CURRENT_ID_CATEGORY'] == 479){?>
						<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
						<!-- test -->
						<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-2337139989896773" data-ad-slot="9873030842" data-ad-format="auto"></ins>
						<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
					<?}elseif($GLOBALS['GLOBAL_CURRENT_ID_CATEGORY'] == 480){?>
						<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
						<!-- Категории2 -->
						<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-2337139989896773" data-ad-slot="7119113645" data-ad-format="auto"></ins>
						<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
					<?}?>
				<?}else{?>
					<!-- <img src="//lh3.ggpht.com/H8LE7fE6SRPpyBIs3CpNLn_4LBxZjmHbCos9CCeyDmUEGGI05vBM1QoQLcvDMp8sp70EI5Pk=w250" height="250" width="300"> -->
				<?}?>
			</div>
		</div>
		<div class="copyright">
			<div class="copyright_wrap">
				<p>&copy; Отдел снабжения XT.ua <?=date("Y")?></p>
				<!-- <p class="created">Разработано в <a href="http://webking.link/" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>>WebKingStudio</a></p> -->
			</div>
		</div>
	</footer>
	<div class="modals">
		<div id="quiz" data-type="modal"></div>
		<!-- Загрузка сметы -->
		<div id="estimateLoad" class="estimate_modal" data-type="modal">
			<div class="modal_container">
				<h3>Вы можете загрузить свою смету</h3>
				<div class="estimate_info estimate_info_js"></div>
				<form action="" id="estimate">
					<div class="mdl-grid">
						<?if(!G::IsLogged()){?>
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--12-col">
								<input class="mdl-textfield__input" name ="name" type="text" id="estimate_name" <?=isset($_SESSION['member']['name'])?'disableds':null?> value="<?=(isset($_SESSION['member']['name']))?$_SESSION['member']['name']:null?>">
								<label class="mdl-textfield__label" for="estimate_name">Имя</label>
								<span class="mdl-textfield__error">Ошибка ввода Имени!</span>
							</div>
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--12-col">
								<input class="mdl-textfield__input" name ="phone" type="text" id="estimate_phone" <?=(isset($_SESSION['member']['phone']))?'disableds':null?> value="<?=(isset($_SESSION['member']['phone']))?$_SESSION['member']['phone']:null?>">
								<label class="mdl-textfield__label" for="estimate_phone">Телефон</label>
								<span class="mdl-textfield__error">Ошибка ввода телефона!</span>
							</div>
						<?}?>
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--12-col">
							<textarea class="mdl-textfield__input" name="comment" type="text" rows= "3" id="estimate_comment" ></textarea>
							<label class="mdl-textfield__label" for="estimate_comment">Комментарий</label>
						</div>
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--12-col">
							<input class="mdl-textfield__input" name="file" type="file" id="estimate_file">
							<label class="mdl-textfield__label" for="estimate_file"></label>
						</div>
						<div class="mdl-cell mdl-cell--12-col">
							<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored estimate_js">Загрузить смету</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- Authentication -->
		<div id="auth" data-type="modal">
			<div id="sign_in" class="modal_container">
				<h4>Вход</h4>
				<span>Вы можете войти в личный кабинет как по email, так и по номеру вашего телефона.</span>
				<form action="#">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input class="mdl-textfield__input" type="text" id="email"> <!-- pattern="(^([\w\.]+)@([\w]+)\.([\w]+)$)|(^$)" -->
						<label class="mdl-textfield__label" for="email">Email или телефон</label>
						<span class="mdl-textfield__error"></span>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input class="mdl-textfield__input" type="password" id="passwd">
						<label class="mdl-textfield__label" for="passwd">Пароль</label>
						<span class="mdl-textfield__error"></span>
					</div>
					<div class="error"></div>
					<a href="#" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?> class="access_recovery btn_js" data-name="access_recovery">Забыли пароль?</a>
					<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored sign_in">Войти</button>
					<button class="mdl-button mdl-js-button switch" data-name="sign_up">Регистрация</button>
				</form>
			</div>
			<div id="sign_up" class="hidden modal_container">
				<h4>Регистрация</h4>
				<span></span>
				<form action="#" class="forPassStrengthContainer_js">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input class="mdl-textfield__input" type="text" id="name" name="name">
						<label class="mdl-textfield__label" for="name">Имя</label>
						<span class="mdl-textfield__error">Ошибка ввода имени!</span>
					</div>

					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input class="mdl-textfield__input" type="text" id="phone" name="phone">
						<label class="mdl-textfield__label" for="phone">Телефон</label>
						<span class="mdl-textfield__error">Ошибка ввода телефона!</span>
					</div>

					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input class="mdl-textfield__input" type="text" id="email" name="email" pattern="(^([\w\.]+)@([\w]+)\.([\w]+)$)|(^$)">
						<label class="mdl-textfield__label" for="email">Email</label>
						<span class="mdl-textfield__error">Ошибка ввода email!</span>
					</div>

					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="password" class="mdl-textfield__input" id="passwd"	name="passwd">
						<label class="mdl-textfield__label" for="passwd">Пароль</label>
						<span class="mdl-textfield__error">Ошибка ввода пароля!</span>
						<div id="password_error"></div>
						<div class="error_description"></div>
					</div>

					<div class="passStrengthContainer_js">
						<p class="ps_title">надежность пароля</p>
						<div class="ps">
							<div class="ps_lvl ps_lvl_js"></div>
						</div>
					</div>

					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="password" class="mdl-textfield__input" id="passwdconfirm" name="passwdconfirm">
						<label class="mdl-textfield__label" for="passwdconfirm">Подтверждение пароля</label>
						<span class="mdl-textfield__error">Ошибка ввода пароля!</span>
						<div id="password_error"></div>
						<div class="error_description"></div>
					</div>
					<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored sign_up">Продолжить</button>
					<button class="mdl-button mdl-js-button switch" data-name="sign_in">Вход</button>
				</form>
			</div>
		</div>
		<div id="access_recovery" data-type="modal">
			<div class="password_recovery_container">
				<h4>Восстановление доступа</h4>
				<form action="#">
					<div><label class="mdl-radio mdl-js-radio" for="chosen_mail">
						<input type="radio" id="chosen_mail" class="mdl-radio__button" name="recovery_method" data-value="email" checked>
						<span class="mdl-radio__label">через Email</span>
					</label></div>
					<div><label class="mdl-radio mdl-js-radio" for="chosen_sms">
						<input type="radio" id="chosen_sms" class="mdl-radio__button" name="recovery_method" data-value="sms">
						<span class="mdl-radio__label">по номеру телефона</span>
					</label></div>
					<div class="input_container">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input class="mdl-textfield__input" type="email" name="value" id="recovery_email">
							<label class="mdl-textfield__label" for="recovery_email">Email</label>
							<span class="mdl-textfield__error"></span>
						</div>
					</div>
					<button id="continue" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent">Продолжить</button>
				</form>
			</div>
		</div>
		<div id="registerComplete" data-type="modal">
			<div class="modal_container">
				<div class="auth_ok">
					<i class="material-icons">check_circle</i>
				</div>
				<p class="info_text">Спасибо за регистрацию!<br>Для настройки своего профиля перейдите в личный кабинет.</p>
				<a class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" href="<?=Link::Custom('cabinet')?>" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>>Мой кабинет</a>
			</div>
		</div>
		<!-- Cart -->
		<div id="cart" data-type="modal">
			<h4 class="title_cart">Корзина</h4>
			<div class="clear_cart ">
				<a onClick="removeFromCart();return false;" href="#" <?=($GLOBALS['CurrentController'] == 'product' || $GLOBALS['CurrentController'] == 'products')?'rel="nofollow"':null;?>><span class="icon-font color-red"></span>Очистить корзину</a>
			</div>
			<ul class="order_head mdl-cell--hide-phone">
				<li class="photo">Фото</li>
				<li class="name">Название</li>
				<li class="price">Цена, Количество</li>
				<li class="sum_li">Сумма</li>
			</ul>
			<div id="removingProd" class="cartInfBlock hidden">
				Подождите идет удаление...
			</div>
			<div id="fillNote" class="cartInfBlock hidden">
				Заполните обязательные примечания товаров!
			</div>
			<div id="clearCart" class="cartInfBlock hidden">
				Подождите идет очистка корзины...
			</div>
			<div class="modal_container"></div>
		</div>
		<div id="demand_chart" data-type="modal" data-target="<?=isset($GLOBALS['CURRENT_ID_CATEGORY'])?$GLOBALS['CURRENT_ID_CATEGORY']:0;?>">
			<div class="modal_container"></div>
		</div>
		<div id="demand_chart_msg" data-type="modal" data-target="<?=isset($GLOBALS['CURRENT_ID_CATEGORY'])?$GLOBALS['CURRENT_ID_CATEGORY']:0;?>">
			<div class="modal_container"></div>
		</div>
		<!-- Модалка контрагент корзина поиск данных о клиенета -->
		<div id="cart_customer_search" data-type="modal">
			<p>Найти клиента</p>
			<div class="search_block">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<label for="user_number">Телефон</label>
					<input class="mdl-textfield__input phone" type="text" id="user_number"
					pattern="\+\d{2}\s\(\d{3}\)\s\d{3}\-\d{2}\-\d{2}\">
					<label class="mdl-textfield__label" for="user_number"></label>
				</div>
				<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored search_btn_js">Найти</button>
			</div>
			<p>Результаты поиска</p>
			<div class="search_results_block">
				<div class="customer_main_info">
					<p>ФИО: переменная</p>
					<p>email: переменная</p>
					<p>Баланс: переменная</p>
					<p>Последний заказ: переменная</p>
				</div>
				<div class="bonus_block">
					<p>Бонусная карта: №123456</p>
					<p>Бонусный баланс: 100500 грн.</p>
					<p>Бонусный процент: 5%</p>
				</div>
			</div>
			<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Добавить</button>
		</div>

		<!-- Аналог alert -->
		<div id="snackbar" class="mdl-js-snackbar mdl-snackbar">
			<div class="mdl-snackbar__text"></div>
			<button class="mdl-snackbar__action" type="button"></button>
		</div>
		<!-- Модалка Отзывы и вопросы -->
		<div id="comment_question" class="modal_hidden" data-type="modal">
			<h4>Отзывы и вопросы</h4>
			<hr>
			<p>У Вашего клиента возник вопрос?<br>Напишите его</p>
			<form action="" method="post">
				<input type="hidden" name="id_product">
				<input type="hidden" name="id_user">
				<textarea name="feedback_text" id="feedback_text" cols="30" rows="8" required></textarea>
				<button type="submit" name="com_qtn" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Отправить</button>
			</form>
		</div>	
		<!-- Модалки кабинета. Заказы -->
		<div id="cloneOrder" class="modalEditOrder" data-type="modal">
			<h5>Заменить товар в текущей корзине <br> или добавить в нее?</h5>
			<button id="replaceCartMod" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent applyBtn btn_js" data-name="cloneOrder">Заменить!</button>
			<button id="addtoCartMod" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored cancelBtn btn_js" data-name="cloneOrder">Добавить!</button>
		</div>
		<div id="confirmDelOrder" class="modalEditOrder" data-type="modal">
			<h5>Вы действительно хотите удалить заказ?</h5>
			<button id="delOrderBtnMod" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent applyBtn">Да, удалить!</button>
			<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored cancelBtn btn_js" data-name="confirmDelOrder">Нет, оставить!</button>
		</div>
		<div id="confirmCnclOrder" class="modalEditOrder" data-type="modal">
			<h5>Вы действительно хотите отменить заказ?</h5>
			<button id="cnclOrderBtnMod" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent applyBtn">Да, отменить!</button>
			<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored cancelBtn btn_js" data-name="confirmCnclOrder">Нет, оставить!</button>
		</div>
		<div id="confirmDelItem" class="modalEditOrder" data-type="modal">
			<h5>Вы действительно хотите удалить товар из списка?</h5>
			<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent deleteBtn_js applyBtn">Удалить</button>
			<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored cancelBtn_js">Отмена</button>
		</div>
		<!-- Модальное окно просмотра ориганального изображения -->
		<div id="big_photo" data-type="modal">
			<img src="" alt="">
		</div>
		<!-- Authentication -->
		<div id="verification" data-type="modal">
			<h4>Выберите удобный для Вас<br>способ подтверждения доступа</h4>
			<div><label class="mdl-radio mdl-js-radio" for="choise_current_pass">
				<input type="radio" id="choise_current_pass" class="mdl-radio__button" name="verification" data-value="current_pass" checked>
				<span class="mdl-radio__label">текущий пароль</span>
			</label></div>
			<div><label class="mdl-radio mdl-js-radio" for="choise_verification_code">
				<input type="radio" id="choise_verification_code" class="mdl-radio__button" name="verification" data-value="verification_code">
				<span class="mdl-radio__label">SMS на Ваш номер телефона</span>
			</label></div>			
			<div class="cur_passwd_container">
				<div class="cur_passwd mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<label class="mdl-textfield__label" for="cur_passwd">Введите текущий пароль:</label>
					<input class="mdl-textfield__input" type="password" name="cur_passwd" id="cur_passwd"/>
					<span class="mdl-textfield__error">Чтобы продолжить введите Ваш текущий пароль</span>
				</div>
			</div>
			<div class="verification_meth hidden">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<label>Номер телефона</label>
					<input class="mdl-textfield__input phone" name="value" type="text" id="recovery_phone" value="<?=isset($User['phone'])?$User['phone']:null?>" pattern="\+\d{2}\s\(\d{3}\)\s\d{3}\-\d{2}\-\d{2}\" disabled>
					<label class="mdl-textfield__label" for="recovery_phone"></label>
					<span class="mdl-textfield__error"></span>
				</div>
			</div>
			<div class="ver_info_js hidden">
				<p class="info_text">На Ваш номер телефона отправлено<br>SMS-сообщение c кодом для подтверждения доступа, который будет действителен в течение следующих <span class="bold_text">24 часов!</span></p>
			</div>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label for_verification_code_js hidden">
				<input class="mdl-textfield__input" type="number" id="verification_code" name="verification_code" pattern="^\d{4}$">
				<label class="mdl-textfield__label" for="verification_code">Введите код подтверждения</label>
				<span class="mdl-textfield__error">Чтобы продолжить введите код подтверждения</span>
			</div>
			<p class="error_msg_js error_msg"></p>
			<button class="mdl-button mdl-js-button mdl-button--raised send_code_js hidden">Выслать код подтверждения</button>
			<button class="mdl-button mdl-js-button mdl-button--raised confirm_pass_js">Подтвердить</button>
			<button class="mdl-button mdl-js-button mdl-button--raised confirm_code_js hidden">Подтвердить</button>
		</div>
		
		<!-- Предложения / Жалобы -->
		<div id="offers" class="content_modal_win" data-type="modal">
			<div class="modal_container blockForForm">
				<div class="mdl-card__supporting-text">
					<h3>Предложения и пожелания</h3>
					<p>Напишите Нам, как мы можем улучшить нашу с Вами работу</p>
					<form action="" class="offers_form">
						<input type="hidden" name="offers_user_id" value="<?=G::IsLogged() && isset($_SESSION['member'])?$_SESSION['member']['id_user']:null;?>">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label <?=G::IsLogged()?'hidden':null;?>">
							<input class="mdl-textfield__input" name="user_email" type="text" id="offers_user_email" value="<?=G::IsLogged() && isset($_SESSION['member'])?$_SESSION['member']['email']:'';?>" pattern="(^([\w\.]+)@([\w]+)\.([\w]+)$)|(^$)">
							<label class="mdl-textfield__label" for="offers_user_email">Email...</label>
							<span class="mdl-textfield__error"></span>
						</div><br>
						<div class="mdl-textfield mdl-js-textfield">
							<textarea class="mdl-textfield__input" type="text" rows= "3" id="user_offers"></textarea>
							<label class="mdl-textfield__label" for="user_offers">Ваши предложения и пожелания...</label>
							<span class="mdl-textfield__error">Поле обязательно для заполнения!</span>
						</div><br>
					</form>
				</div>
				<div class="mdl-card__actions mdl-card--border">
					<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored offers_js">Отправить</button>
				</div>
			</div>
		</div>
		<div id="issue" class="content_modal_win" data-type="modal">
			<div class="modal_container blockForForm">
				<div class="mdl-card__supporting-text">
					<h3>Замечания</h3>
					<p>Сообщите нам, если у Вас есть замечания по поводу работы нашей службы снабжения.</p>
					<p>Мы постараемся сделать нашу совместную работу максимально удобной для Вас!</p>
					<form action="" class="issue_form">
						<input type="hidden" name="issue_user_id" value="<?=G::IsLogged() && isset($_SESSION['member'])?$_SESSION['member']['id_user']:null;?>">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label <?=G::IsLogged()?'hidden':null;?>">
							<input class="mdl-textfield__input" name="user_email" type="text" id="issue_user_email" value="<?=G::IsLogged() && isset($_SESSION['member'])?$_SESSION['member']['email']:'';?>" pattern="(^([\w\.]+)@([\w]+)\.([\w]+)$)|(^$)">
							<label class="mdl-textfield__label" for="issue_user_email">Email...</label>
							<span class="mdl-textfield__error">Поле обязательно для заполнения!</span>
						</div><br>
						<div class="mdl-textfield mdl-js-textfield">
							<textarea class="mdl-textfield__input" type="text" rows= "3" id="user_issue"></textarea>
							<label class="mdl-textfield__label" for="user_issue">Введите текст...</label>
							<span class="mdl-textfield__error">Поле обязательно для заполнения!</span>
						</div><br>
					</form>
				</div>
				<div class="mdl-card__actions mdl-card--border">
					<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored issue_js">Отправить</button>
				</div>
			</div>
		</div>
		<div id="issue_result" class="issue_result_js issue_result" data-type="modal">
			<div class="modal_container"></div>
		</div>
	</div>

	<div class="panels"></div>
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

	<!-- Код тега ремаркетинга Google -->
	<!--------------------------------------------------
	С помощью тега ремаркетинга запрещается собирать информацию, по которой можно идентифицировать личность пользователя. Также запрещается размещать тег на страницах с контентом деликатного характера. Подробнее об этих требованиях и о настройке тега читайте на странице http://google.com/ads/remarketingsetup.
	------------------------------------------------- -->
	
	<!-- <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script> -->
	<!-- <noscript>
		<div style="display:inline;">
		<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/880553131/?value=0&amp;guid=ON&amp;script=0"/>
		</div>
	</noscript> -->

	<!-- message about cookie -->
	<div class="cookie_wrap<?=!empty($_COOKIE['useCookie'])?' hidden':null;?>">
		<div class="cookie_msg cookie_msg_js">
			<p>Для повышения удобства использования, а также хранения личных настроек на локальном компьютере и обеспечения корректной работы сайта, мы используем технологию cookie.</p>
			<p>Кликая на кнопку "ОК" или продолжая использовать данный сайт, Вы соглашаетесь на использование этой технологии Нашей компанией.</p>
			<div class="close cookie_msg_close mdl-button mdl-js-button mdl-button--raised mdl-button--accent">ОК</div>
		</div>
	</div>
	<div class="go_up go_up_js mdl-button mdl-js-button mdl-button--raised mdl-button--accent mdl-cell--hide-phone">Наверх</div>
	
	<?if(SETT == 2){
		echo $GLOBALS['CONFIG']['jivosite'];
	}?>
</body>
