<?php
if(!_acl::isAllow('users')){
	die("Access denied");
}
$Contragents = new Contragents();
$Customers = new Customers();
unset($parsed_res);
$tpl->Assign('h1', 'Добавление контрагента');
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Пользователи";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/users/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Добавление контрагента";
if($Contragents->SetRemittersList()){
	$tpl->Assign("remitters", $Contragents->list);
}
if(isset($_POST['smb'])){
	$_POST['details'] = '';
	foreach($Contragents->list as $detail){
		if(isset($_POST['details'.$detail['id']])){
			if($_POST['details'] != ''){
				$_POST['details'] .= ';';
			}
			$_POST['details'] .= $_POST['details'.$detail['id']];
		}
	}
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = Contragents_form_validate();
	if(!$err){
		if($id = $Contragents->AddContragent($_POST)){
			$Customers->AddContragentCustomer($_POST);
			$tpl->Assign('msg', 'Контрагент добавлен.');
			unset($_POST);
		}else{
			$tpl->Assign('msg', 'Контрагент не добавлен.');
			if($Contragents->db->errno == 1062){
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
$Cities = new Cities();
if($Cities->SetList()){
	$tpl->Assign('cities', $Cities->list);
}
$DeliveryService = new DeliveryService();
if($DeliveryService->SetList()){
	$tpl->Assign('delivery_services', $DeliveryService->list);
}
if(!isset($_POST['smb'])){
	$_POST['id_user'] = 0;
	$_POST['parkings_ids'][] = 0;
	$_POST['cities_ids'][] = 0;
	$_POST['delivery_services_ids'][] = 0;
}
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_contragent_ae.tpl');
