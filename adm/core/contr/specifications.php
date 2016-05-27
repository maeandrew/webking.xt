<?php
if(!_acl::isAllow('specifications')){
	die("Access denied");
}
$ObjName = "Specification";	
$$ObjName = new Specification();
// ---- center ----
unset($parsed_res);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Характеристики";
$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);
if(isset($_POST['smb']) && isset($_POST['ord'])){
	$$ObjName->Reorder($_POST);
	$tpl->Assign('msg', 'Сортировка выполнена успешно.');
}
if($$ObjName->SetList()){
	$tpl->Assign('list', $$ObjName->list);
}
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_specification.tpl')
);
if(true == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}
