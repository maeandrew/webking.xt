<?php
$GLOBALS['IERA_LINKS'][] = array(
	'title' => $header,
	'url' => _base_url.'/cabinet/settings/'
);
$customers = new Customers();
$contragents = new Contragents();
$Newsletter = new Newsletter();
$success = false;
$customers->SetFieldsById($Users->fields['id_user']);
$customer = $customers->fields;
$contragents->SetList();
$availablemanagers = $contragents->list;
$newsletters = $Newsletter->getNewsletterByIdUser($Users->fields['id_user']);
$tpl->Assign('newsletters', $newsletters);
if($customer['id_contragent'] > 0){
	$contragents->GetSavedFields($customer['id_contragent']);
	$savedmanager = $contragents->fields;
}
$Users->SetUser($_SESSION['member']);
$tpl->Assign('User', $Users->fields);
$tpl->Assign('Customer', $customer);
$tpl->Assign('availablemanagers', $availablemanagers);
$tpl->Assign('savedmanager', $savedmanager);
$tpl->Assign('msg', array('type' => 'info', 'text' => 'Что бы настроить уведомления и получать рассылку введите свой email в <a href="'.Link::Custom('cabinet', null, array('clear' => true)).'">личных данных</a>.'));
if(isset($_POST['save_settings'])){
	if($Users->updateUser($_POST) &&	$customers->updateContragent($_POST['id_manager'])){
		header("Location: /cabinet/settings/?t=basic&success");
	}else{
		header("Location: /cabinet/settings/?t=basic&unsuccess");
	}
}elseif(isset($_POST['save_password'])){
	$_POST['passwd'] = $_POST['new_passwd'];
	if(isset($_POST['passwd']) && $_POST['passwd'] != '' && $_POST['passwd'] == $_POST['passwdconfirm']){
		if($Users->updateUser($_POST)){
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

