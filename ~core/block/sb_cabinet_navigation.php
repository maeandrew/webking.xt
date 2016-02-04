<?php
	if(isset($GLOBALS['Rewrite'])){
		$tpl->Assign('cabinet_page', $GLOBALS['Rewrite']);
	}
	foreach($GLOBALS['profiles'] as $value){
		if($value['id_profile'] == $_SESSION['member']['gid']){
			$profile = $value['name'];
		}
	}
	$classname = $profile.'s';
	if(class_exists($classname)){
		$class = new $classname();
		$class->SetFieldsById($_SESSION['member']['id_user']);
		$data = $class->fields;
		if($profile == 'supplier'){
			$data['active_products_cnt'] = $products->GetProductsCntSupCab(
				array('a.id_supplier' => $class->fields['id_user'], 'a.active' => 1, 'p.visible' => 1),
				' AND a.product_limit > 0 AND (a.price_mopt_otpusk > 0 OR a.price_opt_otpusk > 0)'
			);
			$data['all_products_cnt'] = $products->GetProductsCntSupCab(array('a.id_supplier'=>$class->fields['id_user'], 'p.visible' => 1));
			$data['moderation_products_cnt'] = count($products->GetProductsOnModeration($class->fields['id_user']));
		}
		$tpl->Assign($profile, $data);
		$parsed_res = array(
			'issuccess'	=> true,
			'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'sb_'.$profile.'_cabinet_navigation.tpl')
		);
	}
?>