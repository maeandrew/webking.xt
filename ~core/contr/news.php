<?php
if(isset($GLOBALS['REQAR'][1])){
	$Page = new Page();
	$News = new News();
	$Page->PagesList();
	$tpl->Assign('list_menu', $Page->list);
}else{
	header('Location: '._base_url.'/404/');
	exit();
}
unset($parsed_res);
if(!$News->SetFieldsById($GLOBALS['REQAR'][1])){
	header('Location: '._base_url.'/404/');
	exit();
}
$news = $News->fields;
$header = $news['title'];
$tpl->Assign('header', $header);
$tpl->Assign('data', $news);
$GLOBALS['IERA_LINKS'][] = array(
	'title' => 'Новости оптового торгового центра xt.ua',
	'descr' => strip_tags($news['descr_short']),
	'url' => _base_url.'/newslist/'
);
$GLOBALS['IERA_LINKS'][] = array(
	'title' => $header,
	'url' => _base_url.'/news/'.$news['id_news'].'/'.$news['translit'].'/'
);
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_news.tpl')
);
if(true == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}?>