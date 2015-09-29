<?php
if (!G::IsLogged()){
	$_SESSION['from'] = 'contragent_order';
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
$GLOBALS['IERA_LINKS'][0]['title'] = "Заказ";
$GLOBALS['IERA_LINKS'][0]['url'] = _base_url.'/contragent_order/';
$User = new Users();
$User->SetUser($_SESSION['member']);
if($User->fields['gid'] == _ACL_CONTRAGENT_){
	$Order = new Orders();
	if(isset($_POST['smb'])){
		if($Order->ExecuteContragentOrder($_POST, $id_order)){
			$tpl->Assign('msg_type', 'success');
			$tpl->Assign('msg', 'Информация обновлена.');
			unset($_POST);
		}else{
			$tpl->Assign('msg_type', 'error');
			$tpl->Assign('msg', 'Информация не обновлена.');
		}
	}elseif(isset($_POST['smb_pretense'])){
		if($Order->ExecuteContragentPretense($id_order)){
			$tpl->Assign('msg_type', 'success');
			$tpl->Assign('msg', 'Информация обновлена.');
			unset($_POST);
		}else{
			$tpl->Assign('msg_type', 'error');
			$tpl->Assign('msg', 'Информация не обновлена.');
		}
	}elseif(isset($_POST['smb_cancel'])){
		if($Order->CancelContragentOrder($id_order)){
			$tpl->Assign('msg_type', 'success');
			$tpl->Assign('msg', 'Заказ отменен контрагентом.');
			unset($_POST);
		}else{
			$tpl->Assign('msg_type', 'error');
			$tpl->Assign('msg', 'Информация не обновлена.');
		}
	}elseif(isset($_POST['smb_run'])){
		if($Order->RunContragentOrder($id_order)){
			$tpl->Assign('msg_type', 'success');
			$tpl->Assign('msg', 'Заказ направлен к выполнению.');
			unset($_POST);
		}else{
			$tpl->Assign('msg_type', 'error');
			$tpl->Assign('msg', 'Информация не обновлена.');
		}
	}
	$Order->SetFieldsById($id_order);
	$ord = $Order->fields;
	$tpl->Assign("order", $ord);
	$arr = $Order->GetOrderForContragent(array( "o.id_order"=>$id_order));
	$tpl->Assign("data", $arr);
	if($arr[0]['id_pretense_status']!=0){
		$pretarr = $Order->GetPretenseAdditionalRows($id_order);
		$tpl->Assign("pretarr", $pretarr);
	}
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_contragent_order.tpl')
	);
}else{
	$tpl->Assign('msg_type', 'error');
	$tpl->Assign('msg', 'Страница не доступна.');
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl')
	);
}
if(true == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}?>