<?php
	if (!_acl::isAllow('users'))
		die("Access denied");
 
	$User = new Users();
	$Customer = new Customers();

	// ---- center ----
	unset($parsed_res);

	$tpl->Assign('h1', 'Добавление покупателя');

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Пользователи";
	$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/users/';
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Добавление покупателя";

	if (isset($_POST['smb'])){

		require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы

		list($err, $errm) = Customer_form_validate();
        if (!$err){
        	if ($id = $Customer->AddCustomer($_POST)){
				$tpl->Assign('msg', 'Покупатель добавлен.');
				unset($_POST);
			}else{
				$tpl->Assign('msg', 'Покупатель не добавлен.');
				if ($Customer->db->errno == 1062){
					$errm['email'] = "Такой email уже есть в базе."; 
					$tpl->Assign('errm', $errm);
				}
			}
        }else{
        	// показываем все заново но с сообщениями об ошибках
        	$tpl->Assign('msg', 'Покупатель не добавлен!');
            $tpl->Assign('errm', $errm);
        }
	}

	if (!isset($_POST['smb'])){
		$_POST['id_user'] = 0;
	}

	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_ae.tpl'));


	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

?>