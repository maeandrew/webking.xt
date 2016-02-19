<?php
if(!_acl::isAllow('posts')){
	die("Access denied");
}
$Post = new Post();
unset($parsed_res);
$header = 'Статьи';
$tpl->Assign('h1', $header);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
if(isset($_POST['smb']) && isset($_POST['ord'])){
	$Post->Reorder($_POST);
	$tpl->Assign('msg', 'Сортировка выполнена успешно.');
}
if($Post->SetList(1)){// die('Ошибка при формировании списка новостей.');
	$tpl->Assign('list', $Post->list);
}
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_posts.tpl')
);
if($parsed_res['issuccess'] == true){
	$tpl_center .= $parsed_res['html'];
}
?>