<?php
$Address = new Address();

$header = 'Добавление пункта выдачи';
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = 'Пункты выдачи';
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/warehouses/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$tpl->Assign('h1', $header);

$tpl->Assign('regions', $Address->GetRegionsList());

$tpl->Assign('cities', $Address->GetCitiesList());

$tpl->Assign('shipping_companies', $Address->GetShippingCompaniesList());

$tpl->Assign('dealers', $Users->GetDealersList());

if(isset($_POST['smb'])){
	require_once($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = Warehouse_form_validate();
    if(!$err){
    	if($id = $Address->AddWarehouse($_POST)){
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

$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_warehouses_ae.tpl');