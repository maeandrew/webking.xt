<?php
$Address = new Address();

$haeder = 'Транспортные компании';
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/regions/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = 'Добавление транспортной компании';
$tpl->Assign('h1', $header);

if(isset($_POST['smb'])){
	require_once($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = Shipping_companies_form_validate();
	if(!$err){
		if($id = $Address->AddShippingCompany($_POST)){
			$tpl->Assign('msg', 'Добавление прошло успешно.');
			unset($_POST);
		}else{
			$tpl->Assign('msg', 'При добавлении возникли ошибки.');
			$tpl->Assign('errm', 1);
		}
	}else{
		// показываем все заново но с сообщениями об ошибках
		$tpl->Assign('msg', 'При добавлении возникли ошибки!');
		$tpl->Assign('errm', $errm);
	}
}
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_shipping_companies_ae.tpl');
