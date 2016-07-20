<?php
if (!_acl::isAllow('product'))
	die("Access denied");

	// ---- center ----
	unset($parsed_res);

	if (isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		$id_product = $GLOBALS['REQAR'][1];
	}else{
		header('Location: '.$GLOBALS['URL_base'].'404/');
		exit();
	}

	$products = new Products();

	$tpl->Assign('h1', 'Удаление товара');

	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Каталог";
	$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/cat/';
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Удаление товара";

	if(!$res = $products->DelProduct($id_product)){
		die('Ошибка при удалении товара.');
	}

	$tpl->Assign('msg', 'Товар удален.');

	$parsed_res = array(
		'issuccess' => true,
	 	'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl')
	 );


	if($parsed_res['issuccess'] == true){
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

?>