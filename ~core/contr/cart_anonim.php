<?php
$header = 'Корзина';
$GLOBALS['IERA_LINKS'][] = array(
	'title' => $header,
	'url' => _base_url.'/cart/'
);
$tpl->Assign('header', $header);
if(isset($_COOKIE['PHPSESSID'])){
	if(isset($GLOBALS['REQAR'][1]) && $GLOBALS['REQAR'][1] == 'clear'){
		unset($_SESSION['Cart']);
	}
	if(!G::IsLogged()){
		$Users->CheckUser(array('email'=>'anonymous', 'passwd'=>'1234567'));
		die();
		$sql = "UPDATE "._DB_PREFIX_."customer
			SET cont_person = NULL,
				phones = NULL
			WHERE id_user = 1381";
		$query = $GLOBALS['db']->Query($sql);
		G::Login($Users->fields);
		header('Location: '._base_url.'/cart/');
	}else{
		$Users->SetUser($_SESSION['member']);
	}
}else{
	$tpl->Assign('msg_type', 'error');
	$tpl->Assign('msg', 'В Вашем браузере отключены cookie или их прием заблокирован антивирусом. Без настройки этой функции авторизация на сайте невозможна.');
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl')
	);
	if(true == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}
}
// ---- center ----
unset($parsed_res);
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
?>