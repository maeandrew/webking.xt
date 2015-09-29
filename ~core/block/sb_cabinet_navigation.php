<?php
	$Customer = new Customers();
	if(isset($GLOBALS['REQAR'][1])){
		$tpl->Assign('cabinet_page', $GLOBALS['REQAR'][1]);
	}
	if($User->fields['gid'] == _ACL_CUSTOMER_){
		$tpl->Assign('customer', $Customer->fields);
		$parsed_res = array(
			'issuccess'	=> true,
	 		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'sb_customer_cabinet_navigation.tpl')
	 	);
	}elseif($User->fields['gid'] == _ACL_SUPPLIER_){
		$supplier = $Supplier->fields;
		$supplier['active_products_cnt'] = $products->GetProductsCntSupCab(
			array('a.id_supplier'=>$Supplier->fields['id_user'], 'a.active' => 1, 'p.visible' => 1),
			' AND a.product_limit > 0 AND (a.price_mopt_otpusk > 0 OR a.price_opt_otpusk > 0)'
		);
		$supplier['all_products_cnt'] = $products->GetProductsCntSupCab(array('a.id_supplier'=>$Supplier->fields['id_user'], 'p.visible' => 1));
		$supplier['moderation_products_cnt'] = count($products->GetProductsOnModeration($Supplier->fields['id_user']));
		$tpl->Assign('supplier', $supplier);
		$parsed_res = array(
			'issuccess'	=> true,
	 		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'sb_supplier_cabinet_navigation.tpl')
	 	);
	}
?>