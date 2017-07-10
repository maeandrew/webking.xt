<?php
$tpl_header = '';
$tpl_center = '';
$tpl_breadcrumbs = '';
$tpl_sidebar_l  = '';
/*
 * Загрузка контроллера
 */
// Cквозные блоки
unset($parsed_res);

// Навигация, определение активной категории
require($GLOBALS['PATH_block'].'navigation.php');

// print_r(G::getmicrotime() - $s_time);die();

$tpl->Assign('cart_info', $tpl->Parse($GLOBALS['PATH_tpl_global'].'cart_info.tpl'));

// Центральный блок
require($GLOBALS['PATH_contr'].$GLOBALS['CurrentController'].'.php');

// Шапка сайта
$tpl_header .= $tpl->Parse($GLOBALS['PATH_tpl_global'].'top_main.tpl');

// Хлебные крошки
unset($parsed_res);
require($GLOBALS['PATH_block'].'breadcrumbs.php');
if(true == @$parsed_res['issuccess']){
	$tpl_breadcrumbs .= $parsed_res['html'];
}

// Блок навигации по каталогам
require($GLOBALS['PATH_block'].'sb_nav.php');

// Блок фильтров
if(in_array($GLOBALS['CurrentController'], $GLOBALS['WithFilters'])){
	require($GLOBALS['PATH_block'].'sb_search_filters.php');
}

// ------------------------ Сквозные блоки ------------------------
$GLOBALS['__header'] = $tpl_header;
$GLOBALS['__center'] = $tpl_center;
$GLOBALS['__breadcrumbs'] = $tpl_breadcrumbs;
$GLOBALS['__sidebar_l'] = $tpl_sidebar_l;

unset($tpl_header, $tpl_center, $tpl_breadcrumbs, $tpl_sidebar_l);
