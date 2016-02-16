<?php
$tpl_header = '';
$tpl_center = '';
$tpl_nav = '';
$tpl_aside = '';
$tpl_breadcrumbs = '';
$tpl_sidebar_l  = '';
$tpl_sidebar_r  = '';
$tpl_popular  = '';
$tpl_graph = '';
/*
 * Загрузка контроллера
 */
// Cквозные блоки
unset($parsed_res);
require($GLOBALS['PATH_block'].'main_navigation.php');
if(true == @$parsed_res['issuccess']){
	$tpl_nav .= $parsed_res['html'];
}

$tpl->Assign('cart_info', $tpl->Parse($GLOBALS['PATH_tpl_global'].'cart_info.tpl'));
$tpl_aside = $tpl->Parse($GLOBALS['PATH_tpl_global'].'aside.tpl');
// Центральный блок
require($GLOBALS['PATH_contr'].$GLOBALS['CurrentController'].'.php');

if(!in_array($GLOBALS['CurrentController'], $GLOBALS['NoTemplate'])){
	// Шапка сайта
	$navigation = $dbtree->GetCats(array('id_category', 'category_level', 'name', 'category_banner', 'banner_href', 'translit', 'pid'), 1);
	foreach($navigation as &$l1){
		$level2 = $dbtree->GetSubCats($l1['id_category'], 'all');
		foreach($level2 as &$l2){
			$level3 = $dbtree->GetSubCats($l2['id_category'], 'all');
			$l2['subcats'] = $level3;
		}
		$l1['subcats'] = $level2;
	}
	$tpl->Assign('navigation', $navigation);
	$tpl_header .= $tpl->Parse($GLOBALS['PATH_tpl_global'].'top_main.tpl');


	// GRAPH
	if($GLOBALS['CurrentController'] == 'main'){
		$data_graph = $products->GetGraphList(0);
	}elseif($GLOBALS['CurrentController'] == 'products'){
		$data_graph = $products->GetGraphList($GLOBALS['CURRENT_ID_CATEGORY']);
	}
	if(isset($data_graph)){
		$tpl->Assign('data_graph', $data_graph);
		$tpl_graph .= $tpl->Parse($GLOBALS['PATH_tpl_global'].'graph.tpl');
	}

	// Хлебные крошки
	if(!in_array($GLOBALS['CurrentController'], $GLOBALS['LeftSideBar']) && !in_array($GLOBALS['CurrentController'], $GLOBALS['NoBreadcrumbs'])){
		unset($parsed_res);
		require($GLOBALS['PATH_block'].'breadcrumbs.php');
		if(true == @$parsed_res['issuccess']){
			$tpl_breadcrumbs .= $parsed_res['html'];
		}
	}
	if($User->fields['gid'] != _ACL_MANAGER_ OR $User->fields['gid'] != _ACL_M_DILER_ OR $User->fields['gid'] != _ACL_CONTRAGENT_){
		$sb_count = 0;
		// Левый сайдбар
		// if(in_array($GLOBALS['CurrentController'], $GLOBALS['LeftSideBar'])){
			$sb_count++;

			// Блок навигации по каталогам
			unset($parsed_res);
			require($GLOBALS['PATH_block'].'sb_nav.php');
			if(true == @$parsed_res['issuccess']){
				$tpl_sidebar_l .= $parsed_res['html'];
			}
			// Блок фильтров
			if(in_array($GLOBALS['CurrentController'], $GLOBALS['WithFilters'])){
				unset($parsed_res);
				require($GLOBALS['PATH_block'].'sb_search_filters.php');
				if(true == @$parsed_res['issuccess']){
					$tpl_sidebar_l .= $parsed_res['html'];
				}
			}
		// }
		// Правый сайдбар
		if(in_array($GLOBALS['CurrentController'], $GLOBALS['RightSideBar'])){
			$sb_count++;
			// Блок новостей
			unset($parsed_res);
			require($GLOBALS['PATH_block'].'sb_news.php');
			if(true == @$parsed_res['issuccess']){
				$tpl_sidebar_r .= $parsed_res['html'];
			}
			// Блок статей
			unset($parsed_res);
			require($GLOBALS['PATH_block'].'sb_posts.php');
			if(true == @$parsed_res['issuccess']){
				$tpl_sidebar_r .= $parsed_res['html'];
			}
		}
		// connecting sidebar correction stylesheets
		// if($sb_count == 2){
		// 	G::AddCSS('twosidebars.css');
		// }elseif($sb_count == 0){
		// 	G::AddCSS('nosidebar.css');
		// }else{
		// 	G::AddCSS('onesidebar.css');
		// }
	}
		// ---- popular things ----
		// if(!in_array($GLOBALS['CurrentController'], $GLOBALS['NoRightBarControllers'])){
		// 	if(!in_array($GLOBALS['CurrentController'], $GLOBALS['EmptyTemplControllers'])){
		// 		unset($parsed_res);
		// 		require($GLOBALS['PATH_block'].'sb_popular.php');
		// 		if(true == @$parsed_res['issuccess']){
		// 			$tpl_sidebar_l .= $parsed_res['html'];
		// 		}
		// 	}
		// }
		// if(!in_array($GLOBALS['CurrentController'], $GLOBALS['EmptyTemplControllers'])){
		// 	unset($parsed_res);
		// 	require($GLOBALS['PATH_block'].'popular.php');
		// 	if(true == @$parsed_res['issuccess']){
		// 		$tpl_popular .= $parsed_res['html'];
		// 	}
		// }
	// }
}
// ------------------------ Сквозные блоки ------------------------
$GLOBALS['__center'] = $tpl_center;
$GLOBALS['__header'] = $tpl_header;
$GLOBALS['__nav'] = $tpl_nav;
$GLOBALS['__aside'] = $tpl_aside;
$GLOBALS['__breadcrumbs'] = $tpl_breadcrumbs;
$GLOBALS['__sidebar_l'] = $tpl_sidebar_l;
$GLOBALS['__sidebar_r'] = $tpl_sidebar_r;
$GLOBALS['__popular'] = $tpl_popular;
if($GLOBALS['CurrentController'] == 'main'){
	$GLOBALS['__graph'] = $tpl_graph;
	$GLOBALS['__page_title'] = 'Оптовый интернет-магазин xt.ua';
	$GLOBALS['__page_kw'] = '';
	$GLOBALS['__page_description'] = '';
	$GLOBALS['__page_h1'] = '';
}elseif($GLOBALS['CurrentController'] == 'products'){
	foreach($GLOBALS['IERA_LINKS'] as $k=>$i){
		// if($k != 0){
			$GLOBALS['__page_url'] = $i['url'];
			$GLOBALS['__page_title'][] = $i['title'];
			$GLOBALS['__page_kw'][] = $i['title'];
			$GLOBALS['__page_description'][] = $i['title'];
		// }
	}
	$GLOBALS['__graph'] = $tpl_graph;
	$GLOBALS['__page_title'] = implode(". ", $GLOBALS['__page_title']);
	$GLOBALS['__page_kw'] = implode(" ", $GLOBALS['__page_kw']);
	$GLOBALS['__page_description'] = "Оптовый интернет-магазин xt.ua | ".implode(" ", $GLOBALS['__page_description']);
}elseif($GLOBALS['CurrentController'] == 'news'){
	foreach($GLOBALS['IERA_LINKS'] as $k=>$i){
		if($k != 0){
			$GLOBALS['__page_url'] = $i['url'];
			$GLOBALS['__page_title'][] = $i['title'];
			$GLOBALS['__page_kw'][] = $i['title'];
			if(isset($i['descr'])){
				$GLOBALS['__page_description'][] = $i['descr'];
			}
		}
	}
	$GLOBALS['__page_title'] = implode(". ", $GLOBALS['__page_title'])." | Новости оптового интернет-магазина ".$GLOBALS['CONFIG']['shop_name'];
	$GLOBALS['__page_kw'] = implode(" ", $GLOBALS['__page_kw']);
	$GLOBALS['__page_description'] = "Оптовый интернет-магазин xt.ua | ".implode(" ", $GLOBALS['__page_description']);
}else{
	$GLOBALS['__page_title'] = array();
	$GLOBALS['__page_kw'] = array();
	$GLOBALS['__page_description'] = array();
	foreach($GLOBALS['IERA_LINKS'] as $k=>$i){
		if($k != 0){
			$GLOBALS['__page_title'][] = $i['title'];
			$GLOBALS['__page_kw'][] = $i['title'];
			$GLOBALS['__page_description'][] = $i['title'];
		}
	}
	$GLOBALS['__page_title'] = implode(". ", $GLOBALS['__page_title']);
	$GLOBALS['__page_kw'] = implode(" ", $GLOBALS['__page_kw']) . "| Киев, Харьков, Днепропетровск, Донецк, Запорожье, Луганск, Крым, Одесса, Львов, Полтава, Сумы, Чернигов, Ивано-Франковск, Закарпатье ";
	$GLOBALS['__page_description'] = "Оптовый интернет-магазин xt.ua | ".implode(". ", $GLOBALS['__page_description'])." | Дешевый интернет магазин недорогих товаров" ;
}?>