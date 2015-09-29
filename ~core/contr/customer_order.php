<?php
if(!G::IsLogged()){
	if(!isset($GLOBALS['REQAR'][1]) && !is_numeric($GLOBALS['REQAR'][1])){
		$_SESSION['from'] = 'customer_order/'.$GLOBALS['REQAR'][1];
	}
	header('Location: /login/');
	exit();
}
if(!isset($GLOBALS['REQAR'][1]) || !is_numeric($GLOBALS['REQAR'][1])){
	header('Location: /404/');
	exit();
}
$id_order = $GLOBALS['REQAR'][1];
if(isset($GLOBALS['REQAR'][2]) && $GLOBALS['REQAR'][2]=="pret"){
	$tpl->Assign('show_pretense', true);
}else{
	$tpl->Assign('show_pretense', false);
}
unset($parsed_res);
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
$header = 'Просмотр заказа';
$GLOBALS['IERA_LINKS'][] = array(
	'title' => "Личный кабинет",
	'url' => _base_url.'/cabinet/'
);
$GLOBALS['IERA_LINKS'][] = array(
	'title' => $header,
	'url' => _base_url.'/customer_order/'.$id_order
);
$User = new Users();
$User->SetUser($_SESSION['member']);
if($User->fields['gid'] == _ACL_CUSTOMER_ OR $User->fields['gid'] == _ACL_DILER_ OR $User->fields['gid'] == _ACL_CONTRAGENT_){
	$tpl->Assign("gid", $User->fields['gid']);
	$Order = new Orders();
	$Order->SetFieldsById($id_order);
	$tpl->Assign("order", $Order->fields);
	$header .= ' № '.$Order->fields['id_order'].' <p class="subtext"> от '.date('d.m.Y', $Order->fields['creation_date']);
	if($User->fields['gid'] == _ACL_CONTRAGENT_ && $Order->fields['target_date'] != NULL){
		$header .= ' на '.date('d.m.Y', $Order->fields['target_date']);
	}
	$header .='</p>';
	if(isset($_POST['smb_pretense'])){
		if($Order->CreatePretense($_POST, $id_order)){
			$tpl->Assign('msg_type', 'success');
			$tpl->Assign('msg', 'Информация обновлена.');
			$Mailer = new Mailer();
			$Mailer->SendOrderPretInvoicesToContragent($id_order);
			unset($_POST);
		}else{
			$tpl->Assign('msg_type', 'error');
			$tpl->Assign('msg', 'Информация не обновлена.');
		}
	}
	if(isset($_POST['smb_cancel'])){
		if($Order->CancelCustomerOrder($id_order)){
			$tpl->Assign('msg_type', 'success');
			$tpl->Assign('msg', 'Заказ отменен.');
			unset($_POST);
			header('Location: '.$_SERVER['REQUEST_URI']);
		}else{
			$tpl->Assign('msg_type', 'error');
			$tpl->Assign('msg', 'Информация не обновлена.');
		}
	}
	$Customer = new Customers();
	$Customer->SetFieldsById($User->fields['id_user']);
	$tpl->Assign("Customer", $Customer->fields);
	if($User->fields['gid'] == _ACL_CONTRAGENT_){
		$arr = $Order->GetOrderForCustomer(array("o.id_order" => $id_order));
	}else{
		$arr = $Order->GetOrderForCustomer(array("o.id_customer" => $User->fields['id_user'], "o.id_order" => $id_order));
	}
	$tpl->Assign("data", $arr);
	if($arr[0]['id_pretense_status'] != 0){
		$pretarr = $Order->GetPretenseAdditionalRows($id_order);
		$tpl->Assign("pretarr", $pretarr);
	}
	$active_pretense_btn = false;
	$active_return_btn = false;
	if($arr[0]['target_date'] > (time()-3600*24*$GLOBALS['CONFIG']['pretense_enable_days'])){
		$active_pretense_btn = true;
	}
	if($arr[0]['target_date'] > (time()-3600*24*$GLOBALS['CONFIG']['return_enable_days'])){
		$active_return_btn = true;
	}
	$tpl->Assign("active_pretense_btn", $active_pretense_btn);
	$tpl->Assign("active_return_btn", $active_return_btn);
	if(!isset($_SESSION['member']['promo_code']) || $_SESSION['member']['promo_code'] == ''){
		$parsed_res = array(
			'issuccess'	=> true,
			'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_order.tpl')
		);
	}else{
		$parsed_res = array(
			'issuccess'	=> true,
			'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_promo_order.tpl')
		);
	}
}else{
	$tpl->Assign('msg_type', 'warning');
	$tpl->Assign('msg', 'Вы не можете просматривать заказы.');
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl')
	);
}
$tpl->Assign('header', $header);
if(true == $parsed_res['issuccess']) {
	$tpl_center .= $parsed_res['html'];
}?>