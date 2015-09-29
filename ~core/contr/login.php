<?php
if(isset($_COOKIE['PHPSESSID'])){
	$header = 'Авторизация';
	$GLOBALS['IERA_LINKS'][] = array(
		'title' => $header,
		'url' => _base_url.'/login/'
	);
	$tpl->Assign('header', $header);
	$to = "cabinet/";
	if(isset($_SESSION['from']) && $_SESSION['from'] != 'login'){
		$to = "{$_SESSION['from']}/";
	}
	if(G::IsLogged() && ($_SESSION['member']['gid'] != _ACL_SUPPLIER_MANAGER_ && !isset($_COOKIE['sm_login']))){
		header('Location: '._base_url.'/'.$to);
		exit();
	}
	$Page = new Page();
	$Page->PagesList();
	$tpl->Assign('list_menu', $Page->list);
	$Customers = new Customers();
	unset($parsed_res);
	if(isset($_SESSION['SLGN']['email']) && $_SESSION['SLGN']['passwd']){
		$_POST['email'] = $_SESSION['SLGN']['email'];
		$_POST['passwd'] = $_SESSION['SLGN']['passwd'];
		$_POST['contr'] = $_SESSION['SLGN']['contr'];
		unset($_SESSION['SLGN']);
	}
	if(isset($_POST['email']) && isset($_POST['passwd'])){
		$User = new Users();
		if($User->CheckUser($_POST)){
			if(isset($_POST['contr'])){
				$Customers->updateContragentOnRegistration($_POST['contr'], $User->fields['id_user']);
			}
			$User->LastLoginRemember($User->fields['id_user']);
			G::Login($User->fields);
			if($_SESSION['member']['gid'] == _ACL_TERMINAL_){
				header('Location: https://'.$_SERVER['HTTP_HOST'].'/'.$to);
				exit();
			}
			header('Location: '._base_url.'/'.$to);
			exit();
		}else{
			$tpl->Assign('msg_type', 'error');
			$tpl->Assign('msg', 'Ошибка! Неверный email или пароль.');
			$tpl->Assign('errm', 1);
		}
		unset($_POST);
	}
	if(isset($_GET['email']) && isset($_GET['passwd'])){
		$User = new Users();
		if($_SESSION['member']['gid'] == _ACL_SUPPLIER_MANAGER_ || isset($_COOKIE['sm_login'])){
			if($User->CheckUserNoPass($_GET)){
				if(isset($_COOKIE['sm_login'])){
					setcookie('sm_login', '', time() - 30, "/");
				}else{
					setcookie('sm_login', true, time() + (86400 * 30), "/");
				}
				$User->LastLoginRemember($User->fields['id_user']);
				G::Login($User->fields);
				header('Location: '._base_url.'/'.$to);
				exit();
			}else{
				$tpl->Assign('msg_type', 'error');
				$tpl->Assign('msg', 'Неверный email или пароль.');
				$tpl->Assign('errm', 1);
			}
			unset($_GET);
		}else{
			if($User->CheckUser($_GET)){
				if(1){
					$User->LastLoginRemember($User->fields['id_user']);
					G::Login($User->fields);
					header('Location: '._base_url.'/'.$to);
					exit();
				}
			}else{
				$tpl->Assign('msg_type', 'error');
				$tpl->Assign('msg', 'Неверный email или пароль.');
				$tpl->Assign('errm', 1);
			}
		}
		unset($_GET);
	}
	$parsed_res = array(
		'issuccess'	=> true,
	 	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_login.tpl')
	 );
	if(true == $parsed_res['issuccess']){
		$tpl_center .= $parsed_res['html'];
	}
}else{
	$tpl->Assign('msg_type', 'warning');
	$tpl->Assign('msg', 'В Вашем браузере отключены cookie или их прием заблокирован антивирусом. Без настройки этой функции авторизация на сайте невозможна.');
	$tpl->Assign('errm', 1);
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl')
	);
	if(true == $parsed_res['issuccess']){
		$tpl_center .= $parsed_res['html'];
	}
}?>