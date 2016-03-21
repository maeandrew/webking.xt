<?php
$header = 'Ассортимент поставщика';
$tpl->Assign('h1', $header);
$GLOBALS['IERA_LINKS'][] = array(
	'title' => $header,
	'url' => _base_url.'/cabinet/assortment/'
);
if(!isset($GLOBALS['REQAR'][1]) || !is_numeric($GLOBALS['REQAR'][1])){
	header('Location: '._base_url.'/404/');
	exit();
}
$id_supplier = $GLOBALS['REQAR'][1];
$tpl->Assign('id_supplier', $id_supplier);

$Products = new Products();
$Supplier = new Suppliers();
$Supplier->SetFieldsById($id_supplier);
$tpl->Assign('supplier', $Supplier->fields);
$Products->SetProductsList1($id_supplier);
$products = $Products->list;
if($products){
	foreach($products as &$p){
		$p['images'] = $Products->GetPhotoById($p['id_product']);
	}
}
$tpl->Assign('list', $products);
$parsed_res = array(
	'issuccess' => true,
	'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_assortment.tpl')
);
if($parsed_res['issuccess'] === true){
	$tpl_center .= $parsed_res['html'];
}
?>