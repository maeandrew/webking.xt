<?php
if(isset($GLOBALS['REQAR'][1])){
	$Page = new Page();
	$Page->PagesList();
	$tpl->Assign('list_menu', $Page->list);
	$products = new Products();
	// Категорией предком товара выбирается категория, по ссылке из которой, товар был выбран
	if(isset($GLOBALS['REQAR'][3])){
		$id_category = $GLOBALS['REQAR'][3];
		$GLOBALS['CURRENT_ID_CATEGORY'] = $id_category;
	}
}else{
	header('Location: '._base_url.'/404/');
	exit();
}
unset($parsed_res);
$User = new Users();
if(isset($_SESSION['member'])){
	$User->SetUser($_SESSION['member']);
}
$tpl->Assign('User', $User->fields['name']);
if(!$products->SetFieldsById($GLOBALS['REQAR'][1], 1)){
	header('Location: '._base_url.'/404/');
	exit();
}
$product = $products->fields;
$id_product = $product['id_product'];
$product['specifications'] = $products->GetSpecificationList($id_product);
$product['images'] = $products->GetPhotoById($id_product);
$product['videos'] = $products->GetVideoById($id_product);
$GLOBALS['prod_title'] = $product['name'];
$GLOBALS['product_canonical'] = '/product/'.$id_product.'/'.$product['translit'].'/';
/* product comments ======================================== */
$res = $products->GetComentByProductId($id_product);
$tpl->Assign('coment', $res);
/* product comments ======================================== */

/* product rating ========================================== */
// $rating = $products->GetProductRating($id_product);
// $tpl->Assign('rating', $rating);
/* product rating ========================================== */

$sdescr = new sdescr($product['name'], $id_product);
$yaml = new sfYamlParser;
$file_to_load = ($id_product)%1;
$linked_pages = $yaml->parse(file_get_contents($GLOBALS['PATH_root'].'repository/linked_pages.yml'));
$parts = $yaml->parse(file_get_contents($GLOBALS['PATH_root'].'repository/parts_'.$file_to_load.'.yml'));
$sdescr->setLinkedPages($linked_pages);
$sdescr->setParts($parts);
$tpl->Assign('sdescr', $sdescr->getDescr());
$tpl->Assign('data', $Page->fields);
$tpl->Assign('item', $product);
$tpl->Assign('header', $product['name'].'<p class="subtext color-sgrey">Артикул: '.$product['art'].'</p>');
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
// если в ссылке не была указана категория, то выбирается первая из соответствий категория-продукт
if(!isset($id_category)) $id_category = $product['id_category'];
$dbtree->Parents($id_category, array('id_category', 'name', 'category_level', 'translit'));
if(!empty($dbtree->ERRORS_MES)){
	die("Error parents");
}
// print_r($dbtree->NextRow());
while($cat = $dbtree->NextRow()){
	// print_r($cat);
	if(0 <> $cat['category_level']){
		$GLOBALS['IERA_LINKS'][] = array(
			'title' => $cat['name'],
			'url' => _base_url.'/products/'.$cat['id_category'].'/'.$cat['translit'].'/limitall/'
		);
	}
}
// end($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][key($GLOBALS['IERA_LINKS'])]['url'] = str_replace('/limitall', '', end($GLOBALS['IERA_LINKS'])['url']);
// если отправили комментарий
if(isset($_POST['sub_com'])){
	$put = $id_product;
	$text = nl2br($_POST['feedback_text'], false);
	$text = stripslashes($text);
	$rating = $_POST['rating'];

	if(isset($_SESSION['member']) && $_SESSION['member']['gid'] == _ACL_CONTRAGENT_ ){
		$author = 007;
		$author_name = $_SESSION['member']['id_user'];
	}elseif(isset($_SESSION['member']) && $_SESSION['member']['id_user'] != 4028){
		$author = $_SESSION['member']['id_user'];
		$author_name = $_SESSION['member']['name'];
	}else{
		$author = 4028;
		$author_name = $_POST['feedback_author'];
	}
	$authors_email = $_POST['feedback_authors_email'];
	$related33 = $products->GetComentProducts($text, $author, $author_name, $authors_email, $put, $rating);
	header('Location: '._base_url.'/product/'.$id_product);
	exit();
}
// Обновление счетчика просмотренных товаров
$products->UpdateViewsProducts($product['count_views'], $id_product);
// Запись в базу просмотренных товаров
if(isset($_SESSION['member']['id_user'])){
	$products->AddViewProduct($id_product, $_SESSION['member']['id_user']);
}
// Запись в куки просмотренных товаров
$residprod = $id_product;
$array = array();
if(isset($_COOKIE['view_products'])){
	$array = json_decode($_COOKIE['view_products']);
}
if(isset($residprod) && !in_array($residprod, $array)){
	array_push($array, $residprod);
	if(count($array) > 15){
		array_shift($array);
	}
	$json = json_encode($array);
	setcookie('view_products', $json, 0, "/");
}

// Выборка похожих товаров
if(!$products->SetFieldsById($GLOBALS['REQAR'][1], 1)){
	header('Location: '._base_url.'/404/');
	exit();
}
$id_category = $product['id_category'];
$similar_products = $products->GetRelatedProducts($GLOBALS['REQAR'][1], $id_category);
if(empty($similar_products)){
	$tpl->Assign('title', 'Популярные товары');
	$similar_products = $products->GetPopularsOfCategory($id_category, true);
}
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_product.tpl')
);
if(true == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}
?>