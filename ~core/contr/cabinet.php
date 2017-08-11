<?php
if(!G::IsLogged()){
	$_SESSION['from'] = $_SERVER['REQUEST_URI'];
	header('Location: '.Link::Custom('main', null, array('clear' => true)).'#auth');
	exit();
}
G::metaTags();
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
unset($parsed_res);
$self_edit = $Users->GetUserBySelfEdit($_SESSION['member']["id_user"]);

$tpl->Assign('self_edit', $self_edit['self_edit']);
// Блок навигации в кабинете
require($GLOBALS['PATH_block'].'sb_cabinet_navigation.php');
if(isset($parsed_res) && $parsed_res['issuccess'] == true){
	$tpl_center .= $parsed_res['html'];
}
switch($Users->fields['gid']){
	case _ACL_CUSTOMER_:
		$header = 'Кабинет клиента';
		if(isset($_SESSION['member']['promo_code']) && $_SESSION['member']['promo_code'] != ''){
			require($GLOBALS['PATH_block'].'cp_cab_promo_customer.php');
		}else{
			if(isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'orders'){
				$header = 'Мои заказы';
				$rewrite = $GLOBALS['Rewrite'];
			}elseif(isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'settings'){
				$header = 'Настройки';
				$rewrite = $GLOBALS['Rewrite'];
			}elseif(isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'feedback'){
				$header = 'Обратная связь';
				$rewrite = $GLOBALS['Rewrite'];
			}elseif(isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'bonus'){
				$header = 'Бонусная программа';
				$rewrite = $GLOBALS['Rewrite'];
			}elseif(isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'favorites'){
				$header = 'Избранные товары';
				$rewrite = $GLOBALS['Rewrite'];
			}elseif(isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'waitinglist'){
				$header = 'Лист ожидания';
				$rewrite = $GLOBALS['Rewrite'];
			}elseif(isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'cooperative'){
				$header = 'Совместные заказы';
				$rewrite = $GLOBALS['Rewrite'];
			}elseif(isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'agent'){
				$header = 'Уголок агента';
				$rewrite = $GLOBALS['Rewrite'];
			}else{
				$header = 'Личные данные';
				$rewrite = 'personal';
			}
			require($GLOBALS['PATH_block'].'cp_cab_'.$rewrite.'_customer.php');
		}
		break;
	case _ACL_SUPPLIER_:
		$header = 'Кабинет поставщика';
		require($GLOBALS['PATH_block'].'cp_cab_supplier.php');
		break;
	case _ACL_CONTRAGENT_:
		$header = 'Кабинет контрагента';
		if(isset($GLOBALS['REQAR'][1]) && $GLOBALS['REQAR'][1] == 'info'){
			require($GLOBALS['PATH_block'].'cp_cab_inf_contragent.php');
		}else{
			require($GLOBALS['PATH_block'].'cp_cab_contragent.php');
		}
		break;
	case _ACL_MANAGER_:
		$header = 'Кабинет менеджера';
		require($GLOBALS['PATH_block'].'cp_cab_manager.php');
		break;
	case _ACL_DILER_:
		$header = 'Кабинет дилера';
		if(isset($GLOBALS['REQAR'][1]) && $GLOBALS['REQAR'][1] == 'info'){
			require($GLOBALS['PATH_block'].'cp_cab_inf_diler.php');
		}else{
			require($GLOBALS['PATH_block'].'cp_cab_diler.php');
		}
		break;
    case _ACL_M_DILER_:
		$header = 'Кабинет';
		require($GLOBALS['PATH_block'].'cp_cab_m_diler.php');
		break;
	case _ACL_ANONYMOUS_:
		$header = 'История заказов анонимных клиентов';
		require($GLOBALS['PATH_block'].'cp_cab_anonim.php');
		break;
	case _ACL_TERMINAL_:
		$header = 'Кабинет терминального клиента';
		require($GLOBALS['PATH_block'].'cp_cab_terminal.php');
		break;
	case _ACL_SUPPLIER_MANAGER_:
		$header = 'Кабинет менеджера поставщиков';
		require($GLOBALS['PATH_block'].'cp_cab_supplier_manager.php');
		break;
	// case _ACL_DEPARTMENT_:
		// $header = 'Кабинет пункта выдачи';
		// require($GLOBALS['PATH_block'].'cp_cab_department.php');
		// break;
	default:
		header('Location: /adm/');
		exit(0);
		break;
}
if(isset($parsed_res) && $parsed_res['issuccess'] == true){
	$tpl_center .= $parsed_res['html'];
}
$tpl->Assign('header', $header);
G::metaTags(array('page_title' => $header));
