<?php

	$GLOBALS['IERA_LINKS'][] = array(
		'title' => $header,
		'url' => _base_url.'/cabinet/watinglist/'
	);

	$Customer = new Customers();

	$success = false;

	$Customer->SetFieldsById($User->fields['id_user']);

	//Список ожидания
	$wating_list = $Customer->GetWatingList($User->fields['id_user']);
	foreach ($wating_list as $key => $value) {
		if($value['price_opt'] == 0 && $value['price_mopt'] == 0){
			$wating_list[$key]['availability'] = 'нет';
		}else{
			$wating_list[$key]['availability'] = 'есть';
		}
	}
	$User->SetUser($_SESSION['member']);

	$tpl->Assign('wating_list', $wating_list);
	$tpl->Assign('User', $User->fields);
	$tpl->Assign('Customer', $Customer->fields);

	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_cab_watinglist.tpl'));

?>