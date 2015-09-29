<?php
	
	if (!_acl::isAllow('orders'))
		die("Access denied");

	if (isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		$id_order = $GLOBALS['REQAR'][1];
	}else{
		header('Location: '.$GLOBALS['URL_base'].'404/');exit(0);
	}
	
	if (isset($GLOBALS['REQAR'][2])){
		$type = $GLOBALS['REQAR'][2];
	}else{
		header('Location: '.$GLOBALS['URL_base'].'404/');exit(0);
	}
	
	
	$Mailer = new Mailer();
	
	$Mailer->echo = true;
	
	if ($type == 'order_contragent'){
		$Mailer->SendOrderInvoicesToContragent($id_order);
	}
	
	if ($type == 'order_suppliers'){
		$Mailer->SendOrderInvoicesToAllSuppliers($id_order);
	}
	
	if ($type == 'order_pret_contragent'){
		$Mailer->SendOrderPretInvoicesToContragent($id_order);
	}
	
	if ($type == 'order_ret_contragent'){
		$Mailer->SendOrderRetInvoicesToContragent($id_order);
	}
	
	
	exit(0);

?>