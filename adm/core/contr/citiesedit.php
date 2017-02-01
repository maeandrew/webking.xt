<?php
$Address = new Address();

// ---- center ----
unset($parsed_res);

if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$id = $GLOBALS['REQAR'][1];
}else{
	header('Location: '.$GLOBALS['URL_base'].'404/');
	exit();
}
$header = 'Города';
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/cities/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = 'Редактирование города';
$tpl->Assign('h1', $header);
if(!$city = $Address->GetCityById($id)) die("Ошибка при извлечении полей");
if(isset($_POST['smb'])){
	require_once($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = City_form_validate();
	if(!$err){
		if($Address->UpdateCity($_POST)){
			$tpl->Assign('msg', 'Обновление данных прошло успешно.');
			unset($_POST);
			if (!$city = $Address->GetCityById($id)) die('Ошибка при извлечении полей.');
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
	foreach($city as $k=>$v){
		$_POST[$k] = $v;
	}
}
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_cities_ae.tpl');
