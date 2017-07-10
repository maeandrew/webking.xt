<?php
$Specification = new Specification();
unset($parsed_res);
if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$id = $GLOBALS['REQAR'][1];
}else{
	header('Location: '.$GLOBALS['URL_base'].'404/');
	exit();
}
if(!$Specification->SetFieldsById($id)) die('Ошибка при выборе характеристики.');
$ii = count($GLOBALS['IERA_LINKS']);
$header = 'Характеристики';
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/specifications/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Редактирование характеристики";
$tpl->Assign('h1', $header);
if(isset($_POST['smb'])){
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = Specification_form_validate();
	if(!$err){
		if($Specification->Update($_POST)){
			$tpl->Assign('msg', 'Обновление данных прошло успешно.');
			unset($_POST);
			if (!$Specification->SetFieldsById($id)) die('Ошибка при извлечении полей.');
		}else{
			$tpl->Assign('msg', 'При обновлении возникли ошибки.');
			$tpl->Assign('errm', 1);
		}
	}else{
		// показываем все заново но с сообщениями об ошибках
		$tpl->Assign('msg', 'При обновлении возникли ошибки!');
		$tpl->Assign('errm', $errm);
	}
}
if(!isset($_POST['smb'])){
	foreach ($Specification->fields as $k=>$v){
		$_POST[$k] = $v;
	}
}
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_specification_ae.tpl');
