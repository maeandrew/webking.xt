<?php
$GLOBALS['IERA_LINKS'][] = array(
	'title' => $header,
	'url' => _base_url.'/cabinet/settings/'
);
$customers = new Customers();
$contragents = new Contragents();
$Newsletter = new Newsletter();
$success = false;
$customers->SetFieldsById($User->fields['id_user']);
$customer = $customers->fields;
$contragents->SetList(false, false);
$availablemanagers = $contragents->list;
$newsletters = $Newsletter->getNewsletterByIdUser($User->fields['id_user']);
$tpl->Assign('newsletters', $newsletters);
if($customer['id_contragent'] > 0){
	$contragents->GetSavedFields($customer['id_contragent']);
	$savedmanager = $contragents->fields;
}
$User->SetUser($_SESSION['member']);
$tpl->Assign('User', $User->fields);
$tpl->Assign('Customer', $customer);
$tpl->Assign('availablemanagers', $availablemanagers);
$tpl->Assign('savedmanager', $savedmanager);
if(isset($_POST['save_settings'])){
	if($User->updateUser($_POST) &&	$customers->updateContragent($_POST['id_manager'])){
		header("Location: /cabinet/settings/?t=basic&success");
	}else{
		header("Location: /cabinet/settings/?t=basic&unsuccess");
	}
}elseif(isset($_POST['save_password'])){
	$_POST['passwd'] = $_POST['new_passwd'];
	if(isset($_POST['passwd']) && $_POST['passwd'] != '' && $_POST['passwd'] == $_POST['passwdconfirm']){
		if($User->updateUser($_POST)){
			header("Location: /cabinet/settings/?t=password&success");
		}else{
			header("Location: /cabinet/settings/?t=password&unsuccess");
		}
	}else{
		header("Location: /cabinet/settings/?t=password&unsuccess");
	}
}
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_cab_settings.tpl')
);
