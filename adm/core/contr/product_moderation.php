<?php
if(!_acl::isAllow('product_moderation')){
	die("Access denied");
}
unset($parsed_res);
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
$category = $dbtree->Full(array('id_category', 'category_level', 'name'));
$products = new Products();
$suppliers = new Suppliers();
$tpl->Assign('h1', 'Товары на модерации');
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Товары на модерации";
$prods = $products->GetProductsOnModeration();
$list = $suppl = array();
foreach($prods as $prod){
	if($prod['moderation_status'] != 2){
		$suppliers->SetFieldsById($prod['id_supplier']);
		$suppl[$prod['id_supplier']] = $suppliers->fields;
		$list[$prod['id_supplier']][] = $prod;
	}
}
$tpl->Assign('category', $category);
$tpl->Assign('list', $list);
$tpl->Assign('suppliers', $suppl);
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_moderation.tpl')
);
if(true == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}?>