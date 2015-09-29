<?php

	$Manufacturers = new Manufacturers();

	// ---- center ----
	unset($parsed_res);

	if (isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		$manufacturer_id = $GLOBALS['REQAR'][1];
	}else{
		header('Location: '.$GLOBALS['URL_base'].'404/');
		exit();
	}

	if (!$Manufacturers->SetFieldsById($manufacturer_id, 1)) die('Ошибка при выборе производителя.');

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Производители";
	$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/manufacturers/';
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Редактирование производителя";
	
	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);

	if (isset($_POST['smb'])){

		require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы

		list($err, $errm) = Manufacturer_form_validate();
        if (!$err){
        	if ($id = $Manufacturers->UpdateManufacturer($_POST)){
				$tpl->Assign('msg', 'Производитель обновлен.');
				unset($_POST);
				if (!$Manufacturers->SetFieldsById($manufacturer_id, 1)) die('Ошибка при выборе производителя.');
			}else{
				$tpl->Assign('msg', 'Ошибка при обновлении производителя.');
			}
        }else{
        	// показываем все заново но с сообщениями об ошибках
        	$tpl->Assign('msg', 'Ошибка! Информация о производителе не обновлена.');
            $tpl->Assign('errm', $errm);
        }
	}

	if (!$Manufacturers->ManufacturersList(1)) die('Ошибка при добавлении производителя.');
	$tpl->Assign('list', $Manufacturers->list);


	if (!isset($_POST['smb'])){
		foreach ($Manufacturers->fields as $k=>$v){
			$_POST[$k] = $v;
		}
	}

	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_manufacturer_ae.tpl'));

	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

?>