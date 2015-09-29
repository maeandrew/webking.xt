<?php
	$ObjName = "contragents";
	$$ObjName = new Contragents();
	unset($parsed_res);
	if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		$id = $GLOBALS['REQAR'][1];
	}else{
		header('Location: '.$GLOBALS['URL_base'].'404/');
		exit();
	}
	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Отправители";
	$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/remitters/';
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Редактирование отправителя";
	$remlist = $$ObjName->GetRemitterById($id, 1);
	if(!$remlist) die("Ошибка при извлечении полей");
	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);
	if(isset($_POST['smb'])){
    	if ($$ObjName->UpdateRemitter($_POST)){
			$tpl->Assign('msg', 'Обновление данных прошло успешно.');
			unset($_POST);
			$remlist = $$ObjName->GetRemitterById($id, 1);
			if(!$remlist) die('Ошибка при извлечении полей.');
			header('Location: ');
		}else{
			$tpl->Assign('msg', 'При обновлении возникли ошибки.');
			$tpl->Assign('errm', 1);
		}
	}
	if(!isset($_POST['smb'])){
		foreach($remlist as $k=>$v){
			$_POST[$k] = $v;
		}
	}
	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_remitters_ae.tpl'));
	if(TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}
?>