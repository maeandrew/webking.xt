<?php
if(!_acl::isAllow('seotextformats')){
	die("Access denied");
}
$Seo = new Seo();
unset($parsed_res);
$tpl->Assign('h1', 'Форматы сеотекста');
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Форматы сеотекста";

if(isset($_POST['clear_filters'])){
	$_POST['filter_type'] = null;
}else{
	if(isset($_POST['filter_type'])){
		$where = ' WHERE type = '.$_POST['filter_type'];
	}
}
/*Pagination*/
if(isset($_GET['limit']) && is_numeric($_GET['limit'])){
	$GLOBALS['Limit_db'] = $_GET['limit'];
}
if((isset($_GET['limit']) && $_GET['limit'] != 'all')||(!isset($_GET['limit']))){
	if(isset($_POST['page_nbr']) && is_numeric($_POST['page_nbr'])){
		$_GET['page_id'] = $_POST['page_nbr'];
	}
	$cnt = count($Seo->getSeotextFormats($where?$where:null));
	$tpl->Assign('cnt', $cnt);
	$GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
	$limit = ' LIMIT '.$GLOBALS['Start'].','.$GLOBALS['Limit_db'];
}else{
	$GLOBALS['Limit_db'] = 0;
	$limit = '';
}

//Вывод форматов сеотекста на страницу
$tpl->Assign('seotext_formats', $Seo->getSeotextFormats($where?$where:null, $limit));

$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_seotextformats.tpl');
