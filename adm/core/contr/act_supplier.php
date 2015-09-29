<?php
if(!_acl::isAllow('users'))
	die("Access denied");
if(!isset($GLOBALS['REQAR'][1]) && !is_numeric($GLOBALS['REQAR'][1])){
	header('Location: /404/');
	exit();
}
$id_supplier = $GLOBALS['REQAR'][1];
unset($parsed_res);
$User = new Users();
$User->SetFieldsById($id_supplier);
$Supplier = new Suppliers();
$Supplier->SetFieldsById($id_supplier, 1);
$arr = $Supplier->GetDataForAct();
$tpl->Assign('products', $arr);
$tpl->Assign("Supplier", $Supplier->fields);
echo $tpl->Parse($GLOBALS['PATH_tpl'].'act_supplier.tpl');
$e_time = G::getmicrotime();
echo "<!--".date("d.m.Y H:i:s", time())."  ".$_SERVER['REMOTE_ADDR']." gentime = ".($e_time - $s_time)." -->";
exit(0);
?>