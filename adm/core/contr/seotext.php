<?php
if(!_acl::isAllow('seotext')){
	die("Access denied");
}
$Seo = new SEO();
unset($parsed_res);
$tpl->Assign('h1', 'Seo-текст');
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Seo-текст";

if($Seo->SeoTextList()){// die('Ошибка при формировании списка новостей.');
	foreach	($Seo->list as &$value){
		$value['text'] = cropStr($value['text'], 130)." ...";
	}
	$tpl->Assign('list', $Seo->list);

}
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_seotext.tpl')
);
if($parsed_res['issuccess'] == true){
	$tpl_center .= $parsed_res['html'];
}

function cropStr($str, $size){
	return mb_substr($str,0,mb_strrpos(mb_substr($str,0,$size,'utf-8'),' ',utf-8),'utf-8');
}
?>