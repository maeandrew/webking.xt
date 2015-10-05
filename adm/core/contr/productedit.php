<?php
if(!_acl::isAllow('product')){
	die("Access denied");
}
unset($parsed_res);
if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$id_product = $GLOBALS['REQAR'][1];
}else{
	header('Location: '.$GLOBALS['URL_base'].'404/');
	exit();
}
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
$Unit = new Unit();
$products = new Products();
$News = new News();
if($News->GetCommentListById($id_product)){
	$tpl->Assign('list_comment', $News->list);
}
$pops1 = $News->GetComent();
$tpl->Assign('pops1', $pops1);
$tpl->Assign('suppliers_info', $products->GetSuppliersInfoForProduct($id_product));
$tpl->Assign('related_prods_list', $products->GetArrayRelatedProducts($id_product));
$specification = new Specification();
$specification->SetListByProdId($id_product);
$tpl->Assign('product_specs', $specification->list);
$specification->SetList();
$tpl->Assign('specs', $specification->list);
$tpl->Assign('unitslist', $Unit->GetUnitsList());
if(isset($_GET['action']) && $_GET['action'] == "update_spec"){
	if($_GET['id_spec_prod'] == ''){
		$specification->AddSpecToProd($_GET, $id_product);
	}else {
		$specification->UpdateSpecsInProducts($_GET);
	}
	header('Location: '.$GLOBALS['URL_base'].'adm/productedit/'.$id_product);
}
elseif(isset($_GET['action']) && $_GET['action'] == "delete_spec"){
	$specification->DelSpecFromProd($_GET['id_spec_prod']);
	$products->UpdateProduct(array('id_product'=>$id_product));
	header('Location: '.$GLOBALS['URL_base'].'adm/productedit/'.$id_product);
}
if(isset($_POST['smb']) || isset($_POST['smb_new'])){
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	if(isset($_POST['price']) && $_POST['price'] == ""){
		$_POST['price'] = 0;
	}
	list($err, $errm) = Product_form_validate();
	if(!$err){
		if($id = $products->UpdateProduct($_POST)){
			$products->UpdateVideo($id_product, $_POST['video']);
			$tpl->Assign('msg', 'Товар обновлен.');
			if(isset($_POST['smb_new'])){
				header('Location: '.$GLOBALS['URL_base'].'adm/productadd/');
			}
			unset($_POST);
		}else{
			$tpl->Assign('msg', 'Товар не обновлен.');
			$tpl->Assign('errm', $errm);
		}
	}else{
		// показываем все заново но с сообщениями об ошибках
		$tpl->Assign('msg', 'Товар не обновлен2.');
		$tpl->Assign('errm', $errm);
		//print_r($errm);
	}
}
if(!$products->SetFieldsById($id_product, 1)) die('Ошибка при выборе товара.');
// Формирование списка категорий для выпадающего списка
$list = $dbtree->Full(array('id_category', 'category_level', 'name'));
// Определение категории к которой принадлежит товар
if(isset($item['id_category']) && $item['id_category'] == $products->fields['id_category']){
	$category['name'] = $item['name'];
	$category['id_category'] = $item['id_category'];
}
$tpl->Assign('list', $list);
$tpl->Assign('mlist', $products->GetManufacturers());

// get last article
$sql = "SELECT art AS cnt
	FROM "._DB_PREFIX_."product
	WHERE (SELECT MAX(id_product) FROM "._DB_PREFIX_."product) = id_product";
$res = $db->GetOneRowArray($sql);
$max_cnt = $res['cnt'];
//Дубликат товара
if(isset($_POST['smb_duplicate'])){
	$_POST['art'] = $max_cnt+1;
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	if(isset($_POST['price']) && $_POST['price'] == ""){
		$_POST['price'] = 0;
	}
	list($err, $errm) = Product_form_validate();
	if(!$err){
		if($id = $products->AddProduct($_POST)){
			$products->UpdateVideo($id, $_POST['video']);
			header('Location: '.$GLOBALS['URL_base'].'adm/productedit/'.$id);
			$tpl->Assign('msg', 'Товар добавлен.');
			unset($_POST);
		}else{
			$tpl->Assign('msg', 'Товар не добавлен.');
			$tpl->Assign('errm', $errm);
		}
	}else{
		// показываем все заново но с сообщениями об ошибках
		$tpl->Assign('msg', 'Товар не добавлен.');
		$tpl->Assign('errm', $errm);
	}
}
//Заполнение массива POST
if(!isset($_POST['smb'])){
	$video = $products->GetIdByVideo($id_product);
	$_POST['id_product'] = 0;
	$prod_fields = $products->fields;
	$prod_fields['video'] = $video;
	foreach($prod_fields as $k=>$v){
		$_POST[$k] = $v;
	}
}
$tpl->Assign('h1', $_POST['name']);
$parsed_res = array(
	'issuccess' => true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_product_ae.tpl')
);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Каталог";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/cat/';
if(isset($category['id_category'])){
	$dbtree->Parents($category['id_category'], array('id_category', 'name', 'category_level'));
	if(!empty($dbtree->ERRORS_MES)) {
	    print_r($dbtree->ERRORS_MES);die();
	}
	while($cat = $dbtree->NextRow()){
		if(0 <> $cat['category_level']){
			$GLOBALS['IERA_LINKS'][$ii]['title'] = $cat['name'];
			$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/products/'.$cat['id_category'];
		}
	}
}
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Редактирование товара";
if(true == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}
?>