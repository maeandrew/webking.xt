<?php
if(!G::IsLogged()){
	$_SESSION['from'] = 'cabinet';
	header('Location: '._base_url.'/login/');
	exit();
}
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
unset($parsed_res);
$User = new Users();
$User->SetUser($_SESSION['member']);
switch($User->fields['gid']){
	case _ACL_CUSTOMER_:
		$header = 'Кабинет клиента';
		if(isset($_SESSION['member']['promo_code']) && $_SESSION['member']['promo_code'] != ''){
			require($GLOBALS['PATH_block'].'cp_cab_promo_customer.php');
		}else{
			if(isset($GLOBALS['REQAR'][1]) && $GLOBALS['REQAR'][1] == "personal"){
				$header = 'Личные данные';
				require($GLOBALS['PATH_block'].'cp_cab_personal_customer.php');
			}elseif(isset($GLOBALS['REQAR'][1]) && $GLOBALS['REQAR'][1] == "settings"){
				$header = 'Настройки';
				require($GLOBALS['PATH_block'].'cp_cab_settings_customer.php');
			}elseif(isset($GLOBALS['REQAR'][1]) && $GLOBALS['REQAR'][1] == "feedback"){
				$header = 'Обратная связь';
				require($GLOBALS['PATH_block'].'cp_cab_feedback_customer.php');
			}elseif(isset($GLOBALS['REQAR'][1]) && $GLOBALS['REQAR'][1] == "bonus"){
				$header = 'Бонусная программа';
				require($GLOBALS['PATH_block'].'cp_cab_bonus_customer.php');
			}elseif(isset($GLOBALS['REQAR'][1]) && $GLOBALS['REQAR'][1] == "favorites"){
				$header = 'Избранные товары';
				require($GLOBALS['PATH_block'].'cp_cab_favorites_customer.php');
			}elseif(isset($GLOBALS['REQAR'][1]) && $GLOBALS['REQAR'][1] == "watinglist"){
				$header = 'Лист ожидания';
				require($GLOBALS['PATH_block'].'cp_cab_watinglist_customer.php');
			}else{
				$header = 'Мои заказы';
				require($GLOBALS['PATH_block'].'cp_cab_orders_customer.php');
			}
		}
		if(true == $parsed_res['issuccess']){
			$tpl_center .= $parsed_res['html'];
		}
	;
	break;
	case _ACL_SUPPLIER_:
		$header = 'Кабинет поставщика';
		require($GLOBALS['PATH_block'].'cp_cab_supplier.php');
		if(true == $parsed_res['issuccess']){
			$tpl_center .= $parsed_res['html'];
		}
	;
	break;
	case _ACL_CONTRAGENT_:
		$header = 'Кабинет контрагента';
		if(isset($GLOBALS['REQAR'][1]) && $GLOBALS['REQAR'][1] == "info"){
			require($GLOBALS['PATH_block'].'cp_cab_inf_contragent.php');
		}else{
			require($GLOBALS['PATH_block'].'cp_cab_contragent.php');
		}
		if(true == $parsed_res['issuccess']){
			$tpl_center .= $parsed_res['html'];
		}
	;
	break;
	case _ACL_MANAGER_:
		$header = 'Кабинет менеджера';
		require($GLOBALS['PATH_block'].'cp_cab_manager.php');
		if(true == $parsed_res['issuccess']){
			$tpl_center .= $parsed_res['html'];
		}
	;
	break;
	case _ACL_DILER_:
		$header = 'Кабинет дилера';
		if(isset($GLOBALS['REQAR'][1]) && $GLOBALS['REQAR'][1] == "info"){
			require($GLOBALS['PATH_block'].'cp_cab_inf_diler.php');
		}else{
			require($GLOBALS['PATH_block'].'cp_cab_diler.php');
		}
		if(true == $parsed_res['issuccess']){
			$tpl_center .= $parsed_res['html'];
		}
	;
	break;
    case _ACL_M_DILER_:
		$header = 'Кабинет';
		require($GLOBALS['PATH_block'].'cp_cab_m_diler.php');
		if(true == $parsed_res['issuccess']){
			$tpl_center .= $parsed_res['html'];
		}
	;
	break;
	case _ACL_ANONIM_:
		$header = 'История заказов анонимных клиентов';
		require($GLOBALS['PATH_block'].'cp_cab_anonim.php');
		if(true == $parsed_res['issuccess']){
			$tpl_center .= $parsed_res['html'];
		}
	;
	break;
	case _ACL_TERMINAL_:
		$header = 'Кабинет терминального клиента';
		require($GLOBALS['PATH_block'].'cp_cab_terminal.php');
		if(true == $parsed_res['issuccess']){
			$tpl_center .= $parsed_res['html'];
		}
	;
	break;
	case _ACL_SUPPLIER_MANAGER_:
		$header = 'Кабинет менеджера поставщиков';
		require($GLOBALS['PATH_block'].'cp_cab_supplier_manager.php');
		if(true == $parsed_res['issuccess']){
			$tpl_center .= $parsed_res['html'];
		}
	;
	break;
	default:
		header('Location: /adm/');
	;
	break;
}
$tpl->Assign('header', $header);
?>