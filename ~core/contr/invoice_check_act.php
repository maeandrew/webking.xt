<?php
if(!isset($_GET['key'])){
	header('Location: '. _base_url.'/404/');
	exit();
}
unset($parsed_res);

$key = $_GET['key'];
$Invoice = new Invoice();
$Order = new Orders();
$Customer = new Customers();
$Contragent = new Contragents();

$data = $Invoice->GetSoldProductsListByKey($key);
if($data){
	foreach($data as &$p){
		$p['images'] = $products->GetPhotoById($p['id_product']);
	}
}
$tpl->Assign('products', $data);
echo $tpl->Parse($GLOBALS['PATH_tpl'].'invoice_check_act.tpl');
exit(0);