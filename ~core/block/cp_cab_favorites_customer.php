<?php

	$GLOBALS['IERA_LINKS'][] = array(
		'title' => $header,
		'url' => _base_url.'/cabinet/favorites/'
	);


	$Customer = new Customers();


	$success = false;

	$Customer->SetFieldsById($User->fields['id_user']);

	//Список избранных товаров
	$favorites = $Customer->GetListFavorites($User->fields['id_user']);
	if ($favorites) {
		foreach ($favorites as $key => $value) {
			if($value['price_opt'] == 0 && $value['price_mopt'] == 0){
				$favorites[$key]['availability'] = 'нет';
			}else{
				$favorites[$key]['availability'] = 'есть';
			}
		}
	}
	
	$User->SetUser($_SESSION['member']);

	$tpl->Assign('favorites', $favorites);
	$tpl->Assign('User', $User->fields);
	$tpl->Assign('Customer', $Customer->fields);

	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_cab_favorites.tpl'));

?>