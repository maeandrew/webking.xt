<?php
	if (!_acl::isAllow('users'))
		die("Access denied");
	$User = new Users();
	$Supplier = new Suppliers();
	// ---- center ----
	unset($parsed_res);

	$tpl->Assign('h1', 'Добавление поставщика склада');
	if (isset($_POST['smb'])){
		if ($Supplier->AddWarehouse($_POST)){
			$tpl->Assign('msg', 'Поставщик добавлен.');
			$success = true;
			$tpl->Assign('success', $success);
			unset($_POST);
		}else{
			$tpl->Assign('msg', 'Поставщик не добавлен.');
			if ($Supplier->db->errno == 1062){
				$errm['email'] = "Такой email уже есть в базе."; 
				$tpl->Assign('errm', $errm);
			}
		}
	}
	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Пользователи";
	$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/warehouse/';
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Добавление поставщика склада";
	$nonWarehouses = $Supplier->GetNonWarehouses();
	$tpl->Assign('nonWarehouses', $nonWarehouses);
	$parsed_res = array('issuccess' => TRUE,
						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_warehouse_add.tpl'));
	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}
?>