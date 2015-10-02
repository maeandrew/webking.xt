<?php
if(!_acl::isAllow('news')){
	die("Access denied");
}
$News = new News();
// ---- center ----
unset($parsed_res);
$h1 = 'Вопросы по товару';
$tpl->Assign('h1', $h1);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = $h1;
// die('Ошибка при формировании списка новостей.');
if($News->NewsList1()){
	$tpl->Assign('list', $News->list);
}
//$tpl->Assign('id_category', $id_category);
$pops1 = $News->GetComent();
$tpl->Assign('pops1', $pops1);
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_coment.tpl')
);
if(TRUE == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}
// ---- right ----
?>