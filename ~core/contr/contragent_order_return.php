<?php
if(!G::IsLogged()){
	$_SESSION['from'] = 'contragent_order_return';
	header('Location: '._base_url.'/login/');
	exit();
}
if(!isset($GLOBALS['REQAR'][1]) && !is_numeric($GLOBALS['REQAR'][1])){
	header('Location: '._base_url.'/404/');
	exit();
}
$id_order = $GLOBALS['REQAR'][1];
// ---- center ----
unset($parsed_res);
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
$GLOBALS['IERA_LINKS'] = array();
$GLOBALS['IERA_LINKS'][0]['title'] = "Возврат";
$GLOBALS['IERA_LINKS'][0]['url'] = _base_url.'/contragent_order_return/';
$User = new Users();
$User->SetUser($_SESSION['member']);
if($User->fields['gid'] == _ACL_CONTRAGENT_){
	$Order = new Orders();
	if(isset($_POST['smb_return'])){
		if ($Order->ExecuteContragentReturn($id_order)){
			$tpl->Assign('msg_type', 'success');
			$tpl->Assign('msg', 'Информация обновлена.');
			unset($_POST);
		}else{
			$tpl->Assign('msg_type', 'error');
			$tpl->Assign('msg', 'Информация не обновлена.');
		}
	}
	$Order->SetFieldsById($id_order);
	$ord = $Order->fields;
	$tpl->Assign("order", $ord);
	$arr = $Order->GetOrderForContragent(array("o.id_contragent"=>$User->fields['id_user'], "o.id_order"=>$id_order));
	$tpl->Assign("data", $arr);

	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_contragent_order_return.tpl')
	);
}else{
	$tpl->Assign('msg_type', 'error');
	$tpl->Assign('msg', 'Вы не можете управлять возвратами.');
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl')
	);
}
if(true == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}?>