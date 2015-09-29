<?php
if(!_acl::isAllow('news')){
	die("Access denied");
}
$News = new News();
unset($parsed_res);
$tpl->Assign('h1', 'Новости');
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Новости";
if(isset($_POST['smb']) && isset($_POST['ord'])){
	$News->Reorder($_POST);
	$tpl->Assign('msg', 'Сортировка выполнена успешно.');
}
if($News->NewsList(1)){// die('Ошибка при формировании списка новостей.');
	$tpl->Assign('list', $News->list);
}
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_news.tpl')
);
if($parsed_res['issuccess'] == true){
	$tpl_center .= $parsed_res['html'];
}
?>