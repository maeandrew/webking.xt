<?php
if(!isset($GLOBALS['Rewrite'])){
	header('Location: /404/');
	exit(0);
}
$Products = new Products();
$Products->SetFieldsByRewrite($GLOBALS['Rewrite'], 1);
$product = $Products->fields;
$product['images'] = $Products->GetPhotoById($product['id_product']);

$tpl->Assign('product', $product);
echo $tpl->Parse($GLOBALS['PATH_tpl'].'cp_product_label.tpl');
exit(0);
