<?php
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
$supplier = $Supplier->fields;
$arr = $Supplier->GetDataForAct();
$tpl->Assign('products', $arr);
foreach ($arr as $key => $i){
	if($i['inusd'] == 1){
		$supplier['usd_products']++;
	}
}
$tpl->Assign("Supplier", $supplier);
echo $tpl->Parse($GLOBALS['PATH_tpl'].'act_supplier'.($_GET['type']?'_'.$_GET['type']:null).'.tpl');
$e_time = G::getmicrotime();

echo "<!--".date("d.m.Y H:i:s", time())."  ".$_SERVER['REMOTE_ADDR']." gentime = ".($e_time - $s_time)." -->";
exit(0);
?>