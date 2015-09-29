<?php
	if(!_acl::isAllow('remitters')){
		die("Access denied");
	}
	$ObjName = 'contragents';
	$$ObjName = new Contragents();
	unset($parsed_res);
	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Отправители";
	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);
	if($$ObjName->SetRemittersList()){
		$tpl->Assign('list', $$ObjName->list);
	}
	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_remitters.tpl'));
	if(TRUE == $parsed_res['issuccess']){
		$tpl_center .= $parsed_res['html'];
	}
?>