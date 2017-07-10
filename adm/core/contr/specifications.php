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
if($$ObjName->SetList()){
	$tpl->Assign('list', $$ObjName->list);
}
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_specification.tpl');
