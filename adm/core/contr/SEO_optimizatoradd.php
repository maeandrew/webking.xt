<?php
	if (!_acl::isAllow('users'))
		die("Access denied");

	$User = new Users();

	// ---- center ----
	unset($parsed_res);

	$tpl->Assign('h1', 'Добавление СЕО-оптимизатора');

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Пользователи";
	$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/users/';
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Добавление СЕО-оптимизатора";

	if (isset($_POST['smb'])){

		require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы

		list($err, $errm) = User_form_validate();
        if (!$err){
        	if ($id = $User->AddUser($_POST)){
				$tpl->Assign('msg', 'Пользователь добавлен.');
				unset($_POST);
			}else{
				$tpl->Assign('msg', 'Пользователь не добавлен.');
				if (mysql_errno() == 1062){
					$errm['email'] = "Такой email уже есть в базе.";
					$tpl->Assign('errm', $errm);
				}
			}
        }else{
        	// показываем все заново но с сообщениями об ошибках
        	$tpl->Assign('msg', 'Ошибка! Пользователь не добавлен.');
            $tpl->Assign('errm', $errm);
        }
	}

	if (!$User->UsersList(1)) die('Ошибка при добавлении СЕО-оптимизатора.');
	$tpl->Assign('list', $User->list);
//print_r($User->GetGroups());die();
	$tpl->Assign('groups', $User->GetGroups());

	if (!isset($_POST['smb'])){
		$_POST['id_user'] = 0;
	}


	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_seo_ae.tpl'));


	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

?>