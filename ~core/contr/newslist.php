<?php
unset($parsed_res);
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
$header = 'Новости оптового торгового центра xt.ua';
$tpl->Assign('header', $header);
$GLOBALS['IERA_LINKS'][] = array(
	'title' => $header,
	'url' => _base_url.'/newslist/'
);
$News = new News();
if($News->NewsList()){
	$tpl->Assign('list', $News->list);
}
$parsed_res = array(
	'issuccess' => true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_newslist.tpl')
);
if(TRUE == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}
?>