<?php
if(!_acl::isAllow('users')){
	die("Access denied");
}
$User = new Users();
$Contragent = new Contragents();
$Customers = new Customers();
unset($parsed_res);
$tpl->Assign('h1', 'Добавление контрагента');
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Пользователи";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/users/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Добавление контрагента";
if($Contragent->SetRemittersList()){
	$tpl->Assign("remitters", $Contragent->list);
}
if(isset($_POST['smb'])){
	$_POST['details'] = '';
	foreach($Contragent->list as $detail){
		if(isset($_POST['details'.$detail['id']])){
			if($_POST['details'] != ''){
				$_POST['details'] .= ';';
			}
			$_POST['details'] .= $_POST['details'.$detail['id']];
		}
	}
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = Contragent_form_validate();
	if(!$err){
		if($id = $Contragent->AddContragent($_POST)){
			$Customers->AddContragentCustomer($_POST);
			$tpl->Assign('msg', 'Контрагент добавлен.');
			unset($_POST);
		}else{
			$tpl->Assign('msg', 'Контрагент не добавлен.');
			if($Contragent->db->errno == 1062){
				$errm['email'] = "Такой email уже есть в базе."; 
				$tpl->Assign('errm', $errm);
			}
		}
	}else{
		// показываем все заново но с сообщениями об ошибках
		$tpl->Assign('msg', 'Контрагент не добавлен!');
		$tpl->Assign('errm', $errm);
	}
}
$Parking = new Parkings();
if($Parking->SetList()){
	$tpl->Assign('parkings', $Parking->list);
}
$City = new Citys();
if($City->SetList()){
	$tpl->Assign('citys', $City->list);
}
$DeliveryService = new DeliveryService();
if($DeliveryService->SetList()){
	$tpl->Assign('delivery_services', $DeliveryService->list);
}
if(!isset($_POST['smb'])){
	$_POST['id_user'] = 0;
	$_POST['parkings_ids'][] = 0;
	$_POST['citys_ids'][] = 0;
	$_POST['delivery_services_ids'][] = 0;
}
$parsed_res = array(
	'issuccess' => TRUE,
	'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_contragent_ae.tpl')
);
if(TRUE == $parsed_res['issuccess']) {
	$tpl_center .= $parsed_res['html'];
}
?>