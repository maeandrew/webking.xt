<?php
ini_set('memory_limit', '512M');
if(!_acl::isAllow('seotext')){
	die("Access denied");
}
$Seo = new Seo();
unset($parsed_res);
$tpl->Assign('h1', 'Seo-текст');
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Seo-текст";

/*Pagination*/
if(isset($_GET['limit']) && is_numeric($_GET['limit'])){
	$GLOBALS['Limit_db'] = $_GET['limit'];
}
if((isset($_GET['limit']) && $_GET['limit'] != 'all')||(!isset($_GET['limit']))){
	if(isset($_POST['page_nbr']) && is_numeric($_POST['page_nbr'])){
		$_GET['page_id'] = $_POST['page_nbr'];
	}
	$Seo->SeoTextList();
	$cnt = count($Seo->list);
	$tpl->Assign('cnt', $cnt);
	$GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
	$limit = ' LIMIT '.$GLOBALS['Start'].','.$GLOBALS['Limit_db'];
}else{
	$GLOBALS['Limit_db'] = 0;
	$limit = '';
}
if($Seo->SeoTextList($limit)){
	foreach	($Seo->list as &$value){
		$value['text'] = cropStr($value['text'], 130)." ...";
	}
	$tpl->Assign('list', $Seo->list);

}

$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_seotext.tpl');

ini_set('memory_limit', '128M');
function cropStr($str, $size){
	return mb_substr($str,0,mb_strrpos(mb_substr($str,0,$size,'utf-8'),' ',utf-8),'utf-8');
}
