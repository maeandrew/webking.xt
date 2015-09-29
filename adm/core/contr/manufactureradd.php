<?php

	$Manufacturers = new Manufacturers();

	// ---- center ----
	unset($parsed_res);

	$tpl->Assign('h1', 'Добавление производителя');

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Производители";
	$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/manufacturers/';
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Добавление производителя";

	if (isset($_POST['smb'])){

		require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы

		list($err, $errm) = Manufacturer_form_validate();
        if (!$err){
        	if ($id = $Manufacturers->AddManufacturer($_POST)){
				$tpl->Assign('msg', 'Производитель добавлен.');
				unset($_POST);
			}else{
				$tpl->Assign('msg', 'Производитель не добавлен.');
			}
        }else{
        	// показываем все заново но с сообщениями об ошибках
        	$tpl->Assign('msg', 'Производитель не добавлен.');
            $tpl->Assign('errm', $errm);
        }
	}

	if (!$Manufacturers->ManufacturersList(1)) die('Ошибка при добавлении производителя.');
	$tpl->Assign('list', $Manufacturers->list);


	if (!isset($_POST['smb'])){
		$_POST['manufacturer_id'] = 0;
	}


	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_manufacturer_ae.tpl'));


	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

?>