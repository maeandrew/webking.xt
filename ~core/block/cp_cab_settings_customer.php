<?php
	$GLOBALS['IERA_LINKS'][] = array(
		'title' => $header,
		'url' => _base_url.'/cabinet/settings/'
	);
	$customers = new Customers();
	$contragents = new Contragents();
	$success = false;
	$customers->SetFieldsById($User->fields['id_user']);
	$customer = $customers->fields;
	$contragents->SetList(false, false);
	$availablemanagers = $contragents->list;
	if($customer['id_contragent'] > 0){
		$contragents->GetSavedFields($customer['id_contragent']);
		$savedmanager = $contragents->fields;
	}
	$User->SetUser($_SESSION['member']);
	$tpl->Assign('User', $User->fields);
	$tpl->Assign('Customer', $customer);
	$tpl->Assign('availablemanagers', $availablemanagers);
	$tpl->Assign('savedmanager', $savedmanager);
	if(isset($_POST['save_settings'])){
		if($User->updateUser($_POST) &&	$customers->updateContragent($_POST['id_manager'])){
			header("Location: /cabinet/settings/?t=basic&success");
		}else{
			header("Location: /cabinet/settings/?t=basic&unsuccess");
		}
	}elseif(isset($_POST['save_password'])){ echo'1'; print_r($_POST); die();
		$_POST['passwd'] = $_POST['new_passwd'];
		if(isset($_POST['passwd']) && $_POST['passwd'] != '' && $_POST['passwd'] == $_POST['passwdconfirm']){
			// print_r($_POST);die();
			if($User->updateUser($_POST)){
				header("Location: /cabinet/settings/?t=password&success");
			}else{
				header("Location: /cabinet/settings/?t=password&unsuccess");
			}
		}else{
			header("Location: /cabinet/settings/?t=password&unsuccess");
		}
	}

	// if(isset($_POST['apply'])){
	// 	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	// 	$nocheck[] = 'keystring';
	// 	// if(isset($_POST['passwd']) && $_POST['passwd'] == ''){
	// 	// 	$nocheck[] = 'passwdconfirm';
	// 	// 	$nocheck[] = 'passwd';
	// 	// }
	// 	list($err, $errm) = Register_form_validate($nocheck);
	// 	if(!$err){
	// 		$tpl->Assign('msg', 'Информация обновлена.');
	// 		$User->updateUser($_POST);
	// 		$customers->updateCustomer($_POST);
	// 		$customers->updateContPerson($_POST['cont_person']);
	// 		$customers->updatePhones($_POST['phones']);
	// 		$customers->updateContragent($_POST['id_manager']);
	// 		$customers->updateCity($_POST['id_delivery_department']);
	// 		$customers->updateDelivery($_POST['id_delivery']);
	// 		if(!$customer['bonus_card']){
	// 			$customers->registerBonus($_POST['bonus_card'], $_POST['sex'], $_POST['learned_from'], date("Y-m-d",strtotime($_POST['bday'].'.'.$_POST['bmonth'].'.'.$_POST['byear'])), $_POST['buy_volume']);
	// 		}else{
	// 			$customers->updateBonus($_POST['bonus_card']);
	// 		}
	// 		header("Location: /cabinet");
	// 	}else{
	// 		// показываем все заново но с сообщениями об ошибках
	// 		$tpl->Assign('msg', 'Информация не обновлена.');
	// 		$tpl->Assign('errm', $errm);
	// 	}
	// }
	// if(isset($_POST['cancel'])){
	// 	header("Location: /cabinet/");
	// }
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_cab_settings.tpl')
	);
?>
