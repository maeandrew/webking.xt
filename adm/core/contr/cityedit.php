<?php

	$ObjName = "City";	
	$$ObjName = new Citys();


	// ---- center ----
	unset($parsed_res);

	if (isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		$id = $GLOBALS['REQAR'][1];
	}else{
		header('Location: '.$GLOBALS['URL_base'].'404/');
		exit();
	}
	
	if (!$$ObjName->SetFieldsById($id)) die('Ошибка при выборе города.');

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Города";
	$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/city/';
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Редактирование города";
	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);

	if (isset($_POST['smb'])){

		require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы

		list($err, $errm) = City_form_validate();
        if (!$err){
        	if ($$ObjName->Update($_POST)){
				$tpl->Assign('msg', 'Обновление данных прошло успешно.');
				unset($_POST);
				if (!$$ObjName->SetFieldsById($id)) die('Ошибка при извлечении полей.');
			}else{
				$tpl->Assign('msg', 'При обновлении возникли ошибки.');
				$tpl->Assign('errm', 1);
			}
        }else{
        	// показываем все заново но с сообщениями об ошибках
        	$tpl->Assign('msg', 'При обновлении возникли ошибки!');
            $tpl->Assign('errm', $errm);
            //print_r($errm);
        }
	}

	if (!isset($_POST['smb'])){
		foreach ($$ObjName->fields as $k=>$v){
			$_POST[$k] = $v;
		}
	}

	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_city_ae.tpl'));


	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

?>