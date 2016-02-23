<?php

	$ObjName = "DeliveryService";	
	$$ObjName = new DeliveryService();
	
	// ---- center ----
	unset($parsed_res);

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Службы доставки";
	$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/delivservs/';
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Добавление службы доставки";

	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);

	if (isset($_POST['smb'])){

		require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы

		list($err, $errm) = DeliveryService_form_validate();
        if (!$err){
        	if ($id = $$ObjName->Add($_POST)){
				$tpl->Assign('msg', 'Добавление прошло успешно.');
				unset($_POST);
			}else{
				$tpl->Assign('msg', 'При добавлении возникли ошибки.');
				$tpl->Assign('errm', 1);
			}
        }else{
        	// показываем все заново но с сообщениями об ошибках
        	$tpl->Assign('msg', 'При добавлении возникли ошибки!');
            $tpl->Assign('errm', $errm);
        }
	}

	if (!isset($_POST['smb'])){
		$_POST['id_delivery_service'] = 0;
	}


	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_delivserv_ae.tpl'));


	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

?>