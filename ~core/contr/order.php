<?php
if(!G::IsLogged()){
	$_SESSION['from'] = 'cart';
	header('Location: '. _base_url.'/login/');
	exit();
}
unset($parsed_res);
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
$GLOBALS['IERA_LINKS'] = array();
$GLOBALS['IERA_LINKS'][0]['title'] = "Заказ";
$GLOBALS['IERA_LINKS'][0]['url'] =  _base_url.'/order/';
$User = new Users();
$User->SetUser($_SESSION['member']);
if($User->fields['gid'] == _ACL_CUSTOMER_){
$Customer = new Customers();
$Customer->SetFieldsById($User->fields['id_user']);
$Cart = new Cart();
$Cart->SetDiscount($Customer->fields['discount']);
$Cart->SetSumDiscount();
$tpl->Assign('discount', $Customer->fields['discount']);
$tpl->Assign('sum_discount', $_SESSION['Cart']['sum_discount']);
if(isset($_SESSION['Cart']['products'])){
	$products = new Products();
	$arr = array();
	foreach($_SESSION['Cart']['products'] as $id=>$p){
		$arr[] = $id;
	}
	$products->SetProductsListFromArr($arr);
	$tpl->Assign('list', $products->list);
}else{
	$tpl->Assign('list', array());
}
$parsed_res = array('issuccess' => TRUE,
					'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_cart.tpl'));
}else{
	$tpl->Assign("msg", "Вы не можете оформлять заказы.");
	$parsed_res = array('issuccess' => TRUE,
						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl'));
}
if(TRUE == $parsed_res['issuccess']) {
	$tpl_center .= $parsed_res['html'];
}?>