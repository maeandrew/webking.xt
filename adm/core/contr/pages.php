<?php
if(!_acl::isAllow('pages')){
	die("Access denied");
}
$Page = new Page();
// ---- center ----
unset($parsed_res);
$tpl->Assign('h1', 'Страницы');
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Страницы";
if(isset($_POST['smb']) && isset($_POST['ord'])){
	$Page->Reorder($_POST);
	$tpl->Assign('msg', 'Сортировка выполнена успешно.');
}
if(!$Page->PagesList(1)) die('Ошибка при формировании списка страниц.');
$tpl->Assign('list', $Page->list);
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_pages.tpl')
);
if(true == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}
// ---- right ----
?>