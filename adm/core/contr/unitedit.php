<?php
	$Unit = new Unit();
	// ---- center ----
	unset($parsed_res);
	if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		$id = $GLOBALS['REQAR'][1];
	}else{
		header('Location: '.$GLOBALS['URL_base'].'404/');
		exit();
	}
	if(!$Unit->SetFieldsById($id)) die('Ошибка при выборе единицы измерения.');
	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Единицы измерения";
	$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/units/';
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Редактирование единицы измерения";
	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);
	if(isset($_POST['smb'])){
		require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
		list($err, $errm) = Unit_form_validate();
        if(!$err){
        	if($Unit->Update($_POST)){
				$tpl->Assign('msg', 'Обновление данных прошло успешно.');
				unset($_POST);
				if (!$Unit->SetFieldsById($id)) die('Ошибка при извлечении полей.');
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
		foreach ($Unit->fields as $k=>$v){
			$_POST[$k] = $v;
		}
	}
	$parsed_res = array(
		'issuccess'	=> TRUE,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_unit_ae.tpl')
	);
	if(TRUE == $parsed_res['issuccess']){
		$tpl_center .= $parsed_res['html'];
	}
	// ---- right ----
?>