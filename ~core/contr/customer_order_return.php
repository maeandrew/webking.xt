<?php
if(!G::IsLogged()){
	$_SESSION['from'] = 'customer_order_return';
	header('Location: '. _base_url.'/login/');
	exit();
}
if(!isset($GLOBALS['REQAR'][1]) && !is_numeric($GLOBALS['REQAR'][1])){
	header('Location: '. _base_url.'/404/');
	exit();
}
$id_order = $GLOBALS['REQAR'][1];
unset($parsed_res);
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
$GLOBALS['IERA_LINKS'] = array();
$GLOBALS['IERA_LINKS'][0]['title'] = "Возврат";
$GLOBALS['IERA_LINKS'][0]['url'] =  _base_url.'/customer_order_return/';
$Users->SetUser($_SESSION['member']);
if($Users->fields['gid'] == _ACL_CUSTOMER_){
	$Order = new Orders();
	if(isset($_POST['smb_return'])){
		if($Order->CreateReturn($_POST, $id_order)){
			$tpl->Assign('msg_type', 'success');
			$tpl->Assign('msg', 'Информация обновлена.');
			$Mailer = new Mailer();
			$Mailer->SendOrderRetInvoicesToContragent($id_order);
			unset($_POST);
		}else{
			$tpl->Assign('msg_type', 'error');
			$tpl->Assign('msg', 'Информация не обновлена.');
		}
	}
	$Customer = new Customers();
	$Customer->SetFieldsById($Users->fields['id_user']);
	$tpl->Assign("Customer", $Customer->fields);
	$arr = $Order->GetOrderForCustomer(array("o.id_customer"=>$Users->fields['id_user'], "o.id_order"=>$id_order));
	$tpl->Assign("data", $arr);
	if(isset($_POST['smb_return']) && !($arr[0]['target_date'] > (time()-3600*24*$GLOBALS['CONFIG']['return_enable_days']))){
		$tpl->Assign('msg_type', 'error');
		$tpl->Assign('msg', 'Время возможности создать возврат прошло.');
		$parsed_res = array(
			'issuccess'	=> true,
			'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl')
		);
	}else{
		$parsed_res = array(
			'issuccess'	=> true,
			'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_order_return.tpl')
		);
	}
}else{
	$tpl->Assign('msg_type', 'error');
	$tpl->Assign('msg', 'Вы не можете создавать возвраты.');
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl'));
}
if(TRUE == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}?>