<!DOCTYPE html>
<html lang="ru">
<head>
	<title><?=isset($GLOBALS['prod_title'])?$GLOBALS['prod_title'].' | ':null;?><?=(isset($GLOBALS['products_title']) && $GLOBALS['products_title'] != '')?$GLOBALS['products_title']:$__page_title;?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
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

	<!-- JS load -->
	<?if(isset($js_arr)){
		$tmpstr = '<script src="'.$GLOBALS['URL_js'].'%s" type="text/javascript"%s></script>'."\n";
		foreach($js_arr as $js){
			echo sprintf($tmpstr, $js['name'], $js['async']==true?' async':null);
		}
	}?>
	<!-- END JS load -->

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
	<!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
			<script type="text/javascript" src="<?=_base_url?>/plugins/tagcanvas/excanvas.js"></script>
        <![endif]-->
    <!-- Placed at the end of the document so the pages load faster -->
	<!-- END CSS load -->

	<!-- favicon loading -->
	<link type="image/x-icon" href="/favicon.ico" rel="icon"/>
	<link type="image/x-icon" href="/favicon.ico" rel="shortcut icon"/>
	<!-- END favicon loading -->

	<!-- enable call button for terminal client -->
	<?if(isset($_SESSION['member']) && $_SESSION['member']['gid'] == _ACL_TERMINAL_ && date("H")*60+date("i") < 1020+44){?>
		<script type='text/javascript' src='<?=$GLOBALS['URL_js']?>/c2c-api.js'></script>
		<script type='text/javascript'>
			c2c.from = 'YWRtaW5AeC10b3JnLmNvbQ==';
			c2c.text = '<span class="icon-phone" style="margin-right: 3px;">phone</span> Спросить у менеджера';
			c2c.cls = 'btn btn-large btn-success';
			c2c.config = {
				http_service_url: null,
				websocket_proxy_url: null,
				sip_outbound_proxy_url: null
			};
			c2c.init();
		</script>
	<?}?>
	<!-- END enable call button for terminal client

	<?if($GLOBALS['CurrentController'] == 'main'){?>
		<script type="text/javascript">
			$(window).bind("load", function() {
				$("#datepicker").datepicker({
					dayName: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
					dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
					monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
					monthNamesShort: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
					firstDay: 1,
					inline: true
				});
			});
		</script>
	<?}?>
	<!-- include specific js templates for controllers -->
	<?if(in_array($GLOBALS['CurrentController'],array('products', 'search'))){include_once 'products_js.tpl';}?>
	<?if(in_array($GLOBALS['CurrentController'],array('cabinet', 'cabinet_admin_supplier'))){include_once 'suppliercab_js.tpl';}?>
	<?if(in_array($GLOBALS['CurrentController'],array('cart'))){include_once 'cart_js.tpl';}?>
	<!-- END include specific js templates for controllers -->
	<?if(!isset($_SESSION['member']['gid']) || !in_array($_SESSION['member']['gid'], array(_ACL_CONTRAGENT_, _ACL_SUPPLIER_MANAGER_, _ACL_SUPPLIER_, _ACL_DILER_, _ACL_MODERATOR_, _ACL_MANAGER_, _ACL_SEO_))){?>
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
<body class="<?=in_array($GLOBALS['CurrentController'], $GLOBALS['LeftSideBar'])?'sidebar':'no-sidebar'?>">
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

	<div id="back_modal" class="hidden"></div>
	<div class="container-fluid">
		<!-- header section -->
		<header class="row default"><?=$__header?></header>
		<!-- END header section -->
		<!-- main section -->
		<div id="wrapper" class="row">
			<?if(in_array($GLOBALS['CurrentController'], $GLOBALS['LeftSideBar'])){?>
				<?if(!isset($_SESSION['member']['promo_code']) || $_SESSION['member']['promo_code'] == ''){?>
					<aside id="sb_left">
						<?=$__sidebar_l?>
						<div class="sb_block">
							<h4>Важное</h4>
							<div class="sb_container">
								<div class="sb_important">
									<?if($GLOBALS['CurrentController'] !== 'main'){?>
										<a href="<?=Link::Custom('news');?>">Новости</a>
										<a href="<?=Link::Custom('post');?>">Статьи</a>
									<?}?>
									<a href="<?=Link::Custom('price');?>">Прайс листы</a>
									<a href="<?=Link::Custom('page', 'Oplata');?>">Оплата</a>
									<a href="<?=Link::Custom('page', 'Dostavka');?>">Доставка</a>
									<a href="<?=Link::Custom('page', 'Stat_dilerom');?>">Как стать диллером</a>
									<a href="<?=_base_url?>/">Как стать партнером</a>
									<a href="<?=_base_url?>/wishes/" class="wishes">Пожелания и предложения</a>
								</div>
							</div>
						</div>
						<div class="sb_block">
							<script type="text/javascript" src="//vk.com/js/api/openapi.js?116"></script>
							<!-- VK Widget -->
							<div id="vk_groups"></div>
							<script type="text/javascript">
							VK.Widgets.Group("vk_groups", {mode: 0, width: "300", height: "400", color1: 'FFFFFF', color2: '2B587A', color3: '52cf55'}, 70996442);
							</script>
						</div>
					</aside>
				<?}?>
			<?}?>
			<section class="center_wrap">
				<?=$__breadcrumbs?>
				<?if($GLOBALS['CurrentController'] != 'main'){?>
					<h1 class="page_header"><?=$GLOBALS['CurrentController'] == 'products'?$curcat['name']:$header;?></h1>
				<?}else{
					if(!empty($main_slides)){?>
						<div id="owl-main_slider" class="owl-carousel">
							<?foreach($main_slides AS $k=>$s){?>
								<a class="item" href="<?=$s['content']?>">
									<img class="lazyOwl" data-src="<?=file_exists($GLOBALS['PATH_root'].'/images/slides/'.$s['image'])?_base_url.'/images/slides/'.$s['image']:'/efiles/_thumb/nofoto.jpg'?>">
								</a>
							<?}?>
						</div>
					<?}?>
					<div class="cloud_tag">
						<!-- <canvas width="700" height="450" id="myCanvas">
							<p>Anything in here will be replaced on browsers that support the canvas element</p>
							<ul>
							<?foreach($pops as $i){?>
								<li><a href="<?=_base_url."/product/".$i['id_product']."/".$i['translit']."/";?>" target="_blank" title="<?=$i['name']?>">
										<img height="50%" width="50%" alt="<?=str_replace('"', '', $i['name'])?>" src="<?=htmlspecialchars(str_replace("/efiles/image/", "//x-torg.com/efiles/image/250/", $i['img_1']))?>"/>
									</a>
								</li>
							<?}?>
								<li><a href="http://www.google.com" target="_blank">Google</a></li>
								<li><a href="/fish">Fish</a></li>
								<li><a href="/chips">Chips</a></li>
								<li><a href="/salt">Salt</a></li>
								<li><a href="/vinegar">Vinegar</a></li>
								<li><a href="/"><img height="40" width="100" src="<?=file_exists($GLOBALS['PATH_root'].'/images/Logo-SVG3.svg')?_base_url.'/images/Logo-SVG3.svg':'/efiles/_thumb/nofoto.jpg'?>" alt=""></a></li>
								<li><a href="/"><img height="50%" width="50%" src="/efiles/_thumb/nofoto.jpg" alt=""></a></li>
							</ul>
						</canvas> -->
						<!-- <embed type="application/x-shockwave-flash" src="http://freeviral.ru/tagcloud.swf?r=9" width="700" height="450" id="tagcloudflash" name="tagcloudflash" quality="high" wmode="transparent" allowscriptaccess="always" flashvars="tcolor=0x006633&amp;tspeed=100&amp;distr=true&amp;mode=tags&amp;tagcloud=<tags><a href='http://x-torg.com' style='font-size:18pt;'>ХАРЬКОВТОРГ</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com/' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com/' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com/' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com/' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com/' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com/' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com/' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com/' style='font-size:18pt;'>x-torg.com</a><a href='http://x-torg.com/' style='font-size:18pt;'>x-torg.com</a></tags>"> -->
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="sales_block">
								<div class="left_part">
									<h4><span class="sales_block_title">Акция!</span></h4>
									<p>Iphone 4s 32гб.4g. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos fugiat, excepturi deleniti cumque quo consequatur dolorem porro, animi voluptate, fuga laudantium natus totam, nostrum voluptas nemo eaque dolor eius eligendi.</p>
									<span class="original_price">5500 грн.</span>
									<span class="sale_price">4023 грн.</span>
									<a href="#" class="btn-m-orange">Успей купить</a>
								</div>
								<div class="right_part">
									<img src="http://it-max.com.ua/files/products/iphone5s-gallery1-2013_1.300x300.png?ec812bd8be71ab69d0cdc07edb2e0764" alt="phone">
									<div class="end_time">Осталось <br> <span>1:09:33</span></div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="sales_block">
								<div class="left_part">
									<h4><span class="sales_block_title">Акция!</span></h4>
									<p>Iphone 4s 32гб.4g. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos fugiat, excepturi deleniti cumque quo consequatur dolorem porro, animi voluptate, fuga laudantium natus totam, nostrum voluptas nemo eaque dolor eius eligendi.</p>
									<span class="original_price">5500 грн.</span>
									<span class="sale_price">4023 грн.</span>
									<a href="#" class="btn-m-orange">Успей купить</a>
								</div>
								<div class="right_part">
									<img src="http://it-max.com.ua/files/products/iphone5s-gallery1-2013_1.300x300.png?ec812bd8be71ab69d0cdc07edb2e0764" alt="phone">
									<div class="end_time">Осталось <br> <span>1:09:33</span></div>
								</div>
							</div>
						</div>
					</div>
				<?}?>
				<?if($GLOBALS['CurrentController'] != 'main'){?>
					<?=$__center?>
				<?}?>
			</section>
			<?if(in_array($GLOBALS['CurrentController'], $GLOBALS['RightSideBar'])){?>
				<aside id="sb_right">
					<?=$__sidebar_r?>
				</aside>
			<?}?>
		</div>
		<!-- END main section -->
		<section class="sliders">
			<?if($GLOBALS['CurrentController'] == 'main'){?>
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
			<?}?>
			<?if(in_array($GLOBALS['CurrentController'], array('main', 'product'))){?>
				<div class="slider_products">
					<?if(!empty($view_products_list)){?>
						<h4>Просмотренные товары</h4>
						<div id="owl-last-viewed" class="owl-carousel">
							<?foreach($view_products_list as $p){
								if($GLOBALS['CurrentController'] == 'main' || ($GLOBALS['CurrentController'] == 'product' && $item['id_product'] != $p['id_product'])){?>
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
								<?}
							}?>
						</div>
					<?}?>
				</div>
			<?}?>
			<?if($GLOBALS['CurrentController'] == 'main'){?>
				<?=$__center?>
			<?}?>
		</section>
		<!-- footer section -->
		<?if(!isset($_SESSION['member']['promo_code']) || $_SESSION['member']['promo_code'] == ''){?>
			<footer class="row">
				<section>
					<div class="row">
						<div class="col-md-2 col-xs-6 footer_navigation">
							<div class="column_header">
								<h5>Навигация</h5>
							</div>
							<ul>
								<li>
									<a href="<?=_base_url?>/">Главная</a>
								</li>
								<li>
									<a href="<?=_base_url?>/page/O-nas/">О нас</a>
								</li>
								<li>
									<a href="<?=_base_url?>/page/Spravka/">Справка</a>
								</li>
								<li>
									<a href="<?=_base_url?>/page/Oplata-i-dostavka/">Доставка</a>
								</li>
								<li>
									<a href="<?=_base_url?>/page/Kontakty/">Контакты</a>
								</li>
								<li>
									<a href="<?=_base_url?>/page/Stat-dilerom/">Стать дилером</a>
								</li>
								<li>
									<a href="<?=_base_url?>/page/Skidki/">Скидки</a>
								</li>
							</ul>
						</div>
						<div class="col-md-2 col-xs-6 footer_contacts">
							<div class="column_header">
								<h5>Контакты</h5>
							</div>
							<ul>
								<li><div class="icon-lcn">location</div><span>г. Харьков, ТЦ Барабашово, Площадка Свояк, Торговое Место 130</span>
								</li>
								<li>
									<div class="icon-ml">mail</div><span>administration@x-torg.com</span>
								</li>
								<li>
									<div class="icon-ph">phone</div><span><?=$GLOBALS['CONFIG']['phone1'];?></span>
								</li>
								<li>
									<span><?=$GLOBALS['CONFIG']['phone2'];?></span>
								</li>
								<li>
									<span><?=$GLOBALS['CONFIG']['phone3'];?></span>
								</li>
								<li>
									<span><?=$GLOBALS['CONFIG']['phone4'];?></span>
								</li>
							</ul>
						</div>
						<div class="col-md-5 col-sm-6 col-xs-12 footer_map">
							<div><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d641.1494048992278!2d36.298578000000006!3d50.00015300000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNTDCsDAwJzAwLjYiTiAzNsKwMTcnNTQuOSJF!5e0!3m2!1suk!2sua!4v1433875265809" width="100%" height="250" frameborder="0" style="border:0"></iframe></div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12 footer_adsense">
							<div><img src="//lh3.ggpht.com/H8LE7fE6SRPpyBIs3CpNLn_4LBxZjmHbCos9CCeyDmUEGGI05vBM1QoQLcvDMp8sp70EI5Pk=w250" height="auto"></div>
						</div>
					</div>
					<div class="row subfooter">
						<!-- <div class="col-md-3">Разработано в <a href="http://webking.link/">WebKingStudio</a></div> -->
						<div class="socials col-md-6 col-xs-12">
							<ul>
								<li>Мы в соцсетях:</li>
								<li>
									<a href="https://vk.com/xt_ua" target="_blank" class="icon-vkontakte animate">vk</a>
								</li>
								<li>
									<a href="http://ok.ru/group/54897683202077" target="_blank" class="icon-okru animate">odnoklassniki</a>
								</li>
								<li>
									<a href="https://plus.google.com/+X-torg/" target="_blank" class="icon-googleplus animate">g+</a>
								</li>
								<li>
									<a href="https://www.facebook.com/KharkovTorg" target="_blank" class="icon-fb animate">facebook</a>
								</li>
								<li>
									<a href="https://twitter.com/we_xt_ua" target="_blank" class="icon-tw animate">twitter</a>
								</li>
								<li>
									<a href="https://www.youtube.com/channel/UCUSXO-seq23KfMwbn4q9VVw" target="_blank" class="icon-yt animate">youtube</a>
								</li>
							</ul>
						</div>
						<div class="copyright col-md-6 col-xs-12">
							<p>&copy; Оптовый торговый центр &ldquo;<?=$GLOBALS['CONFIG']['shop_name'];?>&rdquo;, 2011 - <?=date('Y')?></p>
							<p>Разработано в <a href="http://webking.link/">WebKingStudio</a></p>
						</div>
					</div>
				</section>
			</footer>
		<?}?>
		<!-- END footer section -->
		<div id="toTop" class="icon-arrow-up animate" title="Прокрутить наверх">arrow_up</div>
	</div>
	<script>
		$(function(){
			/* lazy-load initialization */
			$("img.lazy").show().lazyload({
				effect : "fadeIn",
				threshold : 200,
				failure_limit : 10
			});

			/* styler initialization */
			$('select#category2search, select#sort_prod').styler();

			/* owl-carousel initialization */
			// $("#owl-main_slider").owlCarousel({
			// 	autoPlay: true,
			// 	stopOnHover: true,
			// 	slideSpeed: 300,
			// 	paginationSpeed: 400,
			// 	itemsScaleUp: true,
			// 	singleItem: true,
			// 	lazyLoad: true,
			// 	lazyFollow: false,
			// 	navigation: true, // Show next and prev buttons
			// 	navigationText: ['<span class="icon-nav">arrow_left</span>', '<span class="icon-nav">arrow_right</span>']
			// });
			$("#owl-popular, #owl-last-viewed").owlCarousel({
				autoPlay: false,
				stopOnHover: true,
				slideSpeed: 300,
				paginationSpeed: 400,
				itemsScaleUp: true,
				items: 5,
				navigation: true, // Show next and prev buttons
				navigationText: ['<span class="icon-nav">arrow_left</span>', '<span class="icon-nav">arrow_right</span>']
			});
			if( ! $('#myCanvas').tagcanvas({
				textColour : '#009e00',
				outlineColour:'#f36711',
				outlineThickness : 1,
				maxSpeed : 0.03,
				decel: 0.98,
				depth: 0.92,
				//freezeActive: true,
				initial: [0.2,0],
				shadow: '#f00',
				reverse: true,
				//stretchX: 2,	//ростягивает по горизонтали
				//shape: 'vcylinder', //форма облака
				tooltip: 'div',	//инициализация подсказки с представлением div
				tooltipClass: 'tooltip_description', //назначаем класс подсказки
				imageRadius: "50%",
				minTags: 200,
				weight: false
			})) {
				// TagCanvas failed to load
				$('.cloud_tag').hide();
			}
  			// your other jQuery stuff here..

			//Проверка на Adobe Flash Player
			//var hasFlash = false;
			// try {
			// 	hasFlash = Boolean(new ActiveXObject('ShockwaveFlash.ShockwaveFlash'));
			// }
			// catch(exception) {
			// 	hasFlash = ('undefined' != typeof navigator.mimeTypes['application/x-shockwave-flash']);
		 // 	}
		});
	</script>
	<?if(!isset($_SESSION['member']['gid']) || !in_array($_SESSION['member']['gid'], array(_ACL_CONTRAGENT_, _ACL_SUPPLIER_MANAGER_, _ACL_SUPPLIER_, _ACL_DILER_, _ACL_MODERATOR_, _ACL_MANAGER_, _ACL_SEO_))){?>
		<!-- BEGIN JIVOSITE CODE {literal} -->
		<script type='text/javascript'>
			// (function(){ var widget_id = 'wRwkJ4y3LA';
			// var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();
		</script>
		<!-- {/literal} END JIVOSITE CODE -->
	<?}?>
	<div class="old_browser_bg">
		<div class="old_browser paper_shadow_1">
			<h5>Вы используете устаревшую версию Internet Explorer!</h5>
			<p class="main">Это устаревшая версия программы, поэтому наш сайт временно не работает в этом браузере.<br>Мы рекомендуем Вам установить современную версию программы для использования всех функций сайта и правильного отображения страниц.</p>
			<ul class="analog">
				<li>
					<a href="http://windows.microsoft.com/ru-ru/internet-explorer/download-ie">
						<img alt="Internet Explorer" src="<?=file_exists($GLOBALS['PATH_root'].'/images/browsers/IE.png')?_base_url.'/images/browsers/IE.png':'/efiles/_thumb/nofoto.jpg'?>"/>
						<p>Internet Explorer</p>
					</a>
				</li>
				<li>
					<a href="http://www.opera.com/computer/windows">
						<img alt="Opera Browser" src="<?=file_exists($GLOBALS['PATH_root'].'/images/browsers/Opera.png')?_base_url.'/images/browsers/Opera.png':'/efiles/_thumb/nofoto.jpg'?>"/>
						<p>Opera</p>
					</a>
				</li>
				<li>
					<a href="https://www.google.com/intl/ru/chrome/browser/">
						<img alt="Google Chrome Browser" src="<?=file_exists($GLOBALS['PATH_root'].'/images/browsers/chrome.png')?_base_url.'/images/browsers/chrome.png':'/efiles/_thumb/nofoto.jpg'?>"/>
						<p>Google Chrome</p>
					</a>
				</li>
				<li>
					<a href="http://www.mozilla.org/ru/firefox/new/">
						<img alt="Mozilla Firefox Browser" src="<?=file_exists($GLOBALS['PATH_root'].'/images/browsers/firefox.png')?_base_url.'/images/browsers/firefox.png':'/efiles/_thumb/nofoto.jpg'?>"/>
						<p>Mozilla Firefox</p>
					</a>
				</li>
			</ul>
			<p class="sub">Вы можете скачать любую из предложенных выше программ бесплатно с официального сайта разработчиков просто кликнув по нужной иконке.</p>
		</div>
	</div>
</body>
</html>