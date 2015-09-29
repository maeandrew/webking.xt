<?php
	$ObjName = "Config";
	$$ObjName = new Config();
	// ---- center ----
	unset($parsed_res);
	if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		$id = $GLOBALS['REQAR'][1];
	}else{
		header('Location: '.$GLOBALS['URL_base'].'404/');
		exit();
	}
	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Настройки";
	$GLOBALS['IERA_LINKS'][$ii++]['url'] = '/adm/configs/';
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Редактирование настройки";
	if(!$$ObjName->SetFieldsById($id)) die("Ошибка при извлечении полей");
	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);
	if(isset($_POST['smb'])){
		require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
		list($err, $errm) = Config_form_validate();
        if(!$err){
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
            print_r($errm);
        }
	}
	if(!isset($_POST['smb'])){
		foreach ($$ObjName->fields as $k=>$v){
			$_POST[$k] = $v;
		}
	}
	if($id==0){
		$parsed_res = array(
			'issuccess'	=> true,
			'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_config_instr_ae.tpl')
		);
	}else{
		$parsed_res = array(
			'issuccess'	=> true,
			'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_config_ae.tpl')
		);
	}
	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}
	// ---- right ----
?>