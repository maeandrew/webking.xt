<?php
if(!isset($GLOBALS['Rewrite'])){
	header('Location: '.Link::Custom('404'));
	exit();
}
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
unset($parsed_res);
$User = new Users();
if(isset($_SESSION['member'])){
	$User->SetUser($_SESSION['member']);
}
$tpl->Assign('User', $User->fields['name']);
if(!$Products->SetFieldsByRewrite($GLOBALS['Rewrite'], 1)){
	header('Location: '.Link::Custom('404'));
	exit();
}
$product = $Products->fields;
G::metaTags($product);
$id_product = $product['id_product'];
$product['specifications'] = $Products->GetSpecificationList($id_product);
$product['images'] = $Products->GetPhotoById($id_product);
$product['videos'] = $Products->GetVideoById($id_product);
$GLOBALS['prod_title'] = $product['name'];
$GLOBALS['product_canonical'] = Link::Product($product['translit']);
/* product comments ======================================== */
$res = $Products->GetComentByProductId($id_product);
$tpl->Assign('comment', $res);
/* product comments ======================================== */

/* product rating ========================================== */
// $rating = $Products->GetProductRating($id_product);
// $tpl->Assign('rating', $rating);
/* product rating ========================================== */
$tpl->Assign('data', $Page->fields);
$tpl->Assign('indexation', $product['indexation']);
$tpl->Assign('item', $product);
$tpl->Assign('header', $product['name']);
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
// если в ссылке не была указана категория, то выбирается первая из соответствий категория-продукт
//if(!isset($id_category)) $id_category = $product['id_category'];
$id_category = $Products->GetCatBreadCrumbs($id_product);
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
	$Products->SubmitProductComment($text, $author, $author_name, $authors_email, $id_product, $rating);
	header('Location: '.Link::Product($GLOBALS['Rewrite']));
	exit();
}
// Обновление счетчика просмотренных товаров
$Products->UpdateViewsProducts($product['count_views'], $id_product);
// Запись в базу просмотренных товаров
if(isset($_SESSION['member']['id_user'])){
	$Products->AddViewProduct($id_product, $_SESSION['member']['id_user']);
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
if(!$Products->SetFieldsByRewrite($GLOBALS['Rewrite'], 1)){
	// header('Location: '._base_url.'/404/');
	exit();
}
if (isset($cat)) {
	$id_category = $cat['id_category'];
	$limit = 15;
	//$similar_products = $Products->GetRelatedProducts($id_product, $id_category);
	$popular_products = $Products->GetPopularsOfCategory($id_category, $id_product, false, $limit);
	$random_products = $Products->GetPopularsOfCategory($id_category, $id_product, true, $limit);
	$tpl->Assign('title', 'Популярные товары');
	$tpl->Assign('popular_products', $popular_products);
	$tpl->Assign('random_products', $random_products);
	// Вывод новинок категории
	$tpl->Assign('new_prods', $Products->getNewProducts($cat['id_category'], $id_product));
}

// Вывод 50 товаров для ссылок
$tpl->Assign('link_prods', $Products->getLinkProducts($id_product));

// Вывод сопутствующих товаров на страницу
$tpl->Assign('related_prods', $Products->GetArrayRelatedProducts($id_product));

$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_product.tpl')
);
if(true == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}
