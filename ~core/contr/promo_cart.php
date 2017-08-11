<?php
if(isset($GLOBALS['REQAR'][1]) && $GLOBALS['REQAR'][1]=='clear'){
	unset($_SESSION['Cart']);
}
if(!G::IsLogged()){
	$_SESSION['from'] = 'cart';
	header('Location: '. _base_url.'/login/');
	exit();
}else{
	$Users->SetUser($_SESSION['member']);
	$current_user = $Users->fields;
	$tpl->Assign('User', $Users->fields);
}
unset($parsed_res);
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
$GLOBALS['IERA_LINKS'] = array();
$GLOBALS['IERA_LINKS'][1]['title'] = "Корзина";
if($Users->fields['gid'] == _ACL_CUSTOMER_
	|| $Users->fields['gid'] == _ACL_ANONYMOUS_
	|| $Users->fields['gid'] == _ACL_DILER_
	|| $Users->fields['gid'] == _ACL_CONTRAGENT_){
	$Customer = new Customers();
	$Customer->SetFieldsById($Users->fields['id_user']);
	$SavedCity = new Cities();
	$SavedCity->GetSavedFields($Customer->fields['id_city']);
	$SavedContragent = new Contragents();
	$SavedContragent->GetSavedFields($Customer->fields['id_contragent']);
	$DeliveryMethod = new Delivery();
	$DeliveryMethod->SetDeliveryList();
	$SavedDeliveryMethod = new Delivery();
	$SavedDeliveryMethod->GetSavedFields($Customer->fields['id_delivery']);
	$Cart = new Cart();
	if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		if(isset($_POST['add_order'])){
			$Cart->FillByOrderId($GLOBALS['REQAR'][1], true);
		}else{
			$Cart->FillByOrderId($GLOBALS['REQAR'][1]);
		}
		header('Location: '. _base_url.'/cart/');
	}elseif(isset($GLOBALS['REQAR'][1]) && $GLOBALS['REQAR'][1]=='clear'){
		unset($_SESSION['Cart']);
	}
	$Cart->SetTotalQty();
	$Cart->SetAllSums();
	$Cart->SetPersonalDiscount($Customer->fields['discount']);
	$Cart->SetSumDiscount();
	$Cart->SetAllSums();
	$Contragent = new Contragents();
    $errm = $warnings = array();
	$err = $warn = 0;
	$cart->IsActualPrices($err, $warn, $errm, $warnings);
    if($err){
        if(isset($_SESSION['errm'])){
        	$_SESSION['errm'] = array_merge($_SESSION['errm'], $errm);
        }else{
        	$_SESSION['errm'] = $errm;
        }
    }
	unset($_SESSION['warnings']);
	if($warn){
		$_SESSION['warnings'] = $warnings;
	}
	$tpl->Assign('personal_discount', $_SESSION['Cart']['personal_discount']);
	$today = time();
	$target_date = strtotime('+2 day', $today );
	$target_date = date('d.m.Y',$target_date);
	$_POST['target_date'] = $target_date;
	$ccont_person = explode(' ', $Customer->fields['cont_person']);
	$Customer->fields['surname'] = $ccont_person[0];
	$Customer->fields['name'] = isset($ccont_person[1]) ? $ccont_person[1] : '';
	$Customer->fields['last_name'] = isset($ccont_person[2]) ? $ccont_person[2] : '';
	$tpl->Assign('discount', $_SESSION['Cart']['discount']);
	$tpl->Assign('sum_discount', $_SESSION['Cart']['sum_discount']);
	$tpl->Assign('Customer', $Customer->fields);
	$tpl->Assign('SavedCity', $SavedCity->fields);
	$tpl->Assign('SavedContragent', $SavedContragent->fields);
	$tpl->Assign('DeliveryMethod', $DeliveryMethod->list);
	$tpl->Assign('SavedDeliveryMethod', $SavedDeliveryMethod->fields);
	/* Сортировки */
	$fields = array('name', 'opt', 'inbox', 'mopt', 'moptqty');
	$f_assoc = array('name'=>'p.name', 'opt'=>'p.price_opt', 'inbox'=>'p.inbox_qty',
					 'mopt'=>'p.price_mopt', 'moptqty'=>'p.min_mopt_qty');
	$orderby = "p.name asc";
	$GET_limit = "";
	if(isset($_GET['limit'])){
		$GET_limit = "limit".$_GET['limit'].'/';
	}
	/* Сортировки */
	if(isset($_SESSION['Cart']['products']) && count($_SESSION['Cart']['products'])){
		$Products = new Products();
		$arr = array();
		foreach($_SESSION['Cart']['products'] as $id=>$p){
			$arr[] = $id;
		}
		$Products->SetPromoProductsListFromArr($arr, $_SESSION['member']['promo_code']);
		if(isset($sum_sort)){
			$arr = $Products->list;
			$tmp = array();
			foreach($arr as $k=>$i){
				if($orderbysum == 'summopt'){
					$tmp[$k] = isset($_SESSION['Cart']['products'][$i['id_product']]['order_mopt_sum'])?number_format($_SESSION['Cart']['products'][$i['id_product']]['order_mopt_sum'],2,'.', ''):"0.00";
				}elseif($orderbysum == 'sumopt'){
					$tmp[$k] = isset($_SESSION['Cart']['products'][$i['id_product']]['order_opt_sum'])?number_format($_SESSION['Cart']['products'][$i['id_product']]['order_opt_sum'],2,'.', ''):"0.00";
				}
			}
			if($orderbysum_asc){
				asort($tmp);
			}else{
				arsort($tmp);
			}
			$tmp2 = array();
			foreach($tmp as $k=>$v){
				foreach($arr as $k2=>$v2){
					if($k == $k2){
						$tmp2[] = $v2;
					}
				}
			}
			$Products->list = $tmp2;
		}
		$tpl->Assign('list', $Products->list);
	}else{
		$tpl->Assign('list', array());
	}
	$avaMan = $Contragent->GetContragentList();
	$allMan = $Contragent->GetAllContragentList();
	$CurrentCustomer = $Customer->SetFieldsById($current_user['id_user']);
	// Если нажата кнопка "Оформить заказ", "Сохранить черновик", "Редактировать информацию" или "Отменить редактирование"
	if(isset($_POST['p_order']) || isset($_POST['order']) || isset($_POST['apply']) || isset($_POST['cancel'])){
		$Order = new Orders();
		require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
		list($err, $errm) = Order_form_validate();
		if(!$err){
			if($id = $Order->Add($_POST)){
				$tpl->Assign('msg', 'Заказ сформирован.');
				$success = true;
				$Customer -> updateContPerson($_POST['cont_person']);
				$Customer -> updatePhones($_POST['phones']);
				unset($_POST);
			}
		}else{
			// показываем все заново но с сообщениями об ошибках
			$tpl->Assign('msg', 'Заказ не сформирован!');
			$tpl->Assign('errm', $errm);
		}
	}
	if(isset($success)){
		unset($_SESSION['Cart']);
		$tpl->Assign('msg', "Заказ успешно сформирован.");
		header('Location: '. _base_url.'/cabinet/');
		exit();
	}else{
		$parsed_res = array('issuccess' => TRUE,
 							'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_promo_cart.tpl'));
	}
	unset($_SESSION['erri']);
}else{
 	$tpl->Assign("msg", "Вы не можете использовать корзину.");
 	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl'));
}
if(TRUE == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}?>