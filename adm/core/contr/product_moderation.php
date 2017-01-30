<?php
if(!_acl::isAllow('product_moderation')){
	die("Access denied");
}
unset($parsed_res);
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
$Products = new Products();
$suppliers = new Suppliers();
$tpl->Assign('h1', 'Товары на модерации');
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Товары на модерации";
$prods = $Products->GetProductsOnModeration();
$list = $suppl = array();
foreach($prods as $prod){
	if($prod['moderation_status'] != 2){
		$suppliers->SetFieldsById($prod['id_supplier']);
		$suppl[$prod['id_supplier']] = $suppliers->fields;
		$list[$prod['id_supplier']][] = $prod;
	}
}
unset($prods);
// Формирование списка категорий для выпадающего списка
$category = $Products->generateCategory();
$tpl->Assign('category', $category);
$tpl->Assign('list', $list);
$tpl->Assign('suppliers', $suppl);
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_moderation.tpl');
