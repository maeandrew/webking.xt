<?php
	if (!_acl::isAllow('users'))
		die("Access denied");

	$User = new Users();
	//$User->SetUser($_SESSION['member']) or exit('Ошибка пользователя.');

	// ---- center ----
	unset($parsed_res);

	if (isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		$id_user = $GLOBALS['REQAR'][1];
	}else{
		header('Location: '.$GLOBALS['URL_base'].'404/');
		exit();
	}

	if (!$User->SetFieldsById($id_user, 1)) die('Ошибка при выборе пользователя.');

	$tpl->Assign('h1', 'Редактирование пользователя');

	if (isset($_POST['smb'])){

		require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы

		list($err, $errm) = User_form_validate(array('passwd'));
        if (!$err){
        	if ($id = $User->UpdateUser($_POST)){
				$tpl->Assign('msg', 'Информация обновлена.');
				unset($_POST);
				if (!$User->SetFieldsById($id_user, 1)) die('Ошибка при выборе пользователя.');
			}else{
				$tpl->Assign('msg', 'Ошибка! Информация не обновлена.');
				if (mysql_errno() == 1062){
					$errm['email'] = "Такой email уже есть в базе.";
					$tpl->Assign('errm', $errm);
				}
			}
        }else{
        	// показываем все заново но с сообщениями об ошибках
        	$tpl->Assign('msg', 'Ошибка! Информация не обновлена.');
            $tpl->Assign('errm', $errm);
        }
	}

	if (!$User->UsersList(1)) die('Ошибка при обновлении пользователя.');
	$tpl->Assign('list', $User->list);

	$tpl->Assign('groups', $User->GetGroups());


	if (!isset($_POST['smb'])){
		foreach ($User->fields as $k=>$v){
			$_POST[$k] = $v;
		}
	}

	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_seo_ae.tpl'));


	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Страницы";
	$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/pages/';
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Редактирование страницы";

	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

?>