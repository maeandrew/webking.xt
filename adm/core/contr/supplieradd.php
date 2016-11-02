<?php
if(!_acl::isAllow('users')){
	die('Access denied');
}
$User = new Users();
$Supplier = new Suppliers();
unset($parsed_res);
$tpl->Assign('h1', 'Добавление поставщика');
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Пользователи";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/users/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Добавление поставщика";
if(isset($_POST['smb'])){
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = Supplier_form_validate();
    if(!$err){
    	if($id = $Supplier->AddSupplier($_POST)){
			$tpl->Assign('msg', 'Поставщик добавлен.');
			unset($_POST);
		}else{
			$tpl->Assign('msg', 'Поставщик не добавлен.');
			if($Supplier->db->errno == 1062){
				$errm['email'] = "Такой email уже есть в базе.";
				$tpl->Assign('errm', $errm);
			}
		}
    }else{
    	// показываем все заново но с сообщениями об ошибках
    	$tpl->Assign('msg', 'Поставщик не добавлен!');
        $tpl->Assign('errm', $errm);
    }
}
if(!isset($_POST['smb'])){
	$_POST['id_user'] = 0;
}
$tpl->Assign('filials', $Supplier->GetFilialList());
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_supplier_ae.tpl');
