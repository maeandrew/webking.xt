<?php
if(G::IsLogged()){
	header('Location: '.$GLOBALS['URL_base']);
	exit();
}
$GLOBALS['__page_title'] = 'Вход';
$GLOBALS['MainTemplate'] = 'login.tpl';
$Page = new Page();
unset($parsed_res);
if(isset($_POST['email']) && isset($_POST['passwd']) && $_POST['email'] && $_POST['passwd']){
	$User = new Users();
	if($User->CheckUser($_POST)){
		_acl::load($User->fields['gid']);
		if(_acl::isAllow('admin_panel')){
			G::Login($User->fields);
			header('Location: '.$GLOBALS['URL_base'].'adm/');
			//$GLOBALS['URL_request']
			exit();
		}else{
			$tpl->Assign('msg', 'Доступ запрещен.');
        	$tpl->Assign('errm', 1);
		}
	}else{
		$tpl->Assign('msg', 'Неверный email или пароль.');
        $tpl->Assign('errm', 1);
	}
	unset($_POST);
}
$parsed_res = array('issuccess' => TRUE,
 					'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_login.tpl'));
if(TRUE == $parsed_res['issuccess']) {
	$tpl_center .= $parsed_res['html'];
}?>