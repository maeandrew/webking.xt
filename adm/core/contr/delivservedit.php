<?php

	$ObjName = "DeliveryService";	
	$$ObjName = new DeliveryService();	

	// ---- center ----
	unset($parsed_res);

	if (isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		$id = $GLOBALS['REQAR'][1];
	}else{
		header('Location: '.$GLOBALS['URL_base'].'404/');
		exit();
	}

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Службы доставки";
	$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/delivservs/';
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Редактирование службы доставки";
	
	if (!$$ObjName->SetFieldsById($id)) die("Ошибка при извлечении полей");

	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);
	

	if (isset($_POST['smb'])){

		require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы

		list($err, $errm) = DeliveryService_form_validate();
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
        }
	}

	if (!isset($_POST['smb'])){
		foreach ($$ObjName->fields as $k=>$v){
			$_POST[$k] = $v;
		}
	}

	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_delivserv_ae.tpl'));


	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

?>