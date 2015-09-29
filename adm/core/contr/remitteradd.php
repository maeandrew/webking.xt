<?php
	$ObjName = "Contragents";	
	$$ObjName = new Contragents();
	unset($parsed_res);
	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Отправители";
	$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/remitters/';
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Добавление отправителя";
	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);
	if(isset($_POST['smb'])){
		if($id = $$ObjName->AddRemitter($_POST)){
			$tpl->Assign('msg', 'Добавление прошло успешно.');
			unset($_POST);
		}else{
			$tpl->Assign('msg', 'При добавлении возникли ошибки.');
			$tpl->Assign('errm', 1);
		}
	}
	if(!isset($_POST['smb'])){
		$_POST['id_parking'] = 0;
	}
	$parsed_res = array('issuccess' => TRUE,
						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_remitters_ae.tpl'));
	if(TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

?>