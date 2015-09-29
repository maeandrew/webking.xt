<?php
	if (!_acl::isAllow('users'))
		die("Access denied");

	$User = new Users();
	$Customer = new Customers();

	// ---- center ----
	unset($parsed_res);

	if (isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		$id_user = $GLOBALS['REQAR'][1];
	}else{
		header('Location: '.$GLOBALS['URL_base'].'404/');
		exit();
	}
	
	$tpl->Assign('h1', 'Добавление покупателя');

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Пользователи";
	$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/users/';
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Редактирование покупателя";

	if (!$Customer->SetFieldsById($id_user, 1)) die('Ошибка при выборе пользователя.');

	$tpl->Assign('h1', 'Редактирование покупателя');

	if (isset($_POST['smb'])){

		require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы

		list($err, $errm) = Customer_form_validate(array('passwd'));
        if (!$err){
        	if ($id = $Customer->UpdateCustomer($_POST)){
				$tpl->Assign('msg', 'Информация обновлена.');
				unset($_POST);
				if (!$Customer->SetFieldsById($id_user, 1)) die('Ошибка при выборе покупателя.');
			}else{
				$tpl->Assign('msg', 'Информация не обновлена.');
				if ($Customer->db->errno == 1062){
					$errm['email'] = "Такой email уже есть в базе.";
					$tpl->Assign('errm', $errm);
				}
			}
        }else{
        	// показываем все заново но с сообщениями об ошибках
        	$tpl->Assign('msg', 'Информация не обновлена.');
            $tpl->Assign('errm', $errm);
        }
	}


	if (!isset($_POST['smb'])){
		foreach ($Customer->fields as $k=>$v){
			$_POST[$k] = $v;
		}
	}
	

	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_ae.tpl'));

	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

?>