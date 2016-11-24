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

if(isset($_POST['id_gift'])){
	$Products->SetFIeldsById($_POST['id_gift']);
	$gift = $Products->fields;
	$gift['images'] = $Products->GetPhotoById($gift['id_product']);
	$tpl->Assign('gift', $gift);
}
echo $tpl->Parse($GLOBALS['PATH_tpl'].'cp_product_label.tpl');
exit(0);
