<?php
if(!isset($GLOBALS['Rewrite'])){
	header('Location: '.Link::Custom('404'));
	exit();
}
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
$products = new Products();
unset($parsed_res);
$User = new Users();
if(isset($_SESSION['member'])){
	$User->SetUser($_SESSION['member']);
}
$tpl->Assign('User', $User->fields['name']);
if(!$products->SetFieldsByRewrite($GLOBALS['Rewrite'], 1)){
	header('Location: '.Link::Custom('404'));
	exit();
}
$product = $products->fields;
G::metaTags($product);
$id_product = $product['id_product'];
$product['specifications'] = $products->GetSpecificationList($id_product);
$product['images'] = $products->GetPhotoById($id_product);
$product['videos'] = $products->GetVideoById($id_product);
$GLOBALS['prod_title'] = $product['name'];
$GLOBALS['product_canonical'] = Link::Product($product['translit']);
/* product comments ======================================== */
$res = $products->GetComentByProductId($id_product);
$tpl->Assign('comment', $res);
/* product comments ======================================== */

/* product rating ========================================== */
// $rating = $products->GetProductRating($id_product);
// $tpl->Assign('rating', $rating);
/* product rating ========================================== */
$tpl->Assign('data', $Page->fields);
$tpl->Assign('indexation', $product['indexation']);
$tpl->Assign('item', $product);
$tpl->Assign('header', $product['name']);
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
// если в ссылке не была указана категория, то выбирается первая из соответствий категория-продукт
if(!isset($id_category)) $id_category = $product['id_category'];
$res = $dbtree->Parents($id_category, array('id_category', 'name', 'category_level', 'translit'));
foreach($res as $cat){
	if($cat['category_level'] > 0){
		$GLOBALS['IERA_LINKS'][] = array(
			'title' => $cat['name'],
			'url' => Link::Category($cat['translit'])
		);
	}
}
// если отправили комментарий
if(isset($_POST['sub_com'])){
	$text = nl2br($_POST['feedback_text'], false);
	$text = stripslashes($text);
	$rating = isset($_POST['rating'])?$_POST['rating']:0;

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
	$products->SubmitProductComment($text, $author, $author_name, $authors_email, $id_product, $rating);
	header('Location: '.Link::Product($GLOBALS['Rewrite']));
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
if(!$products->SetFieldsByRewrite($GLOBALS['Rewrite'], 1)){
	// header('Location: '._base_url.'/404/');
	exit();
}
$id_category = $product['id_category'];
$similar_products = $products->GetRelatedProducts($id_product, $id_category);
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
