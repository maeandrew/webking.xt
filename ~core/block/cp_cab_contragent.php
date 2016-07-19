<?php
$GLOBALS['IERA_LINKS'][] = array(
	'title' => "Кабинет контрагента",
	'url' => _base_url.'/cabinet/'
);
$Contragent = new Contragents();
$GET_limit = "";
if(isset($_GET['limit']))
	$GET_limit = "limit".$_GET['limit'].'/';
if(isset($_POST['id_order']) && !empty($_POST['id_order'])) $id_order = intval($_POST['id_order']);

$Order = new Orders();
if(isset($_POST['change_client'])){
	$Order->SetNote_diler($_POST['order'], $_POST['client']);
}
if(isset($_POST['change_status'])){
	$Order->UpdateStatus($_POST['order'], $_POST['status'], isset($_POST['target_date'])?$_POST['target_date']:null);
}
if(isset($_POST['target'])){
	$target = $_POST['target'];
}else{
	$target = 100;
}
$Customer = new Customers();
$Customer->SetFieldsById($User->fields['id_user']);
$tpl->Assign('current_customer', $Customer->fields);
$klients = $Customer->SetList($User->fields['email']);
$tpl->Assign('klient', $klients);
$Contragent->SetFieldsById($User->fields['id_user']);
$tpl->Assign("contragent", $Contragent->fields);
$contrdates = $Contragent->SetCurrentWeek();
$DaysOfWeek = array("Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб");
$ts = time();
for($ii=0; $ii<=($GLOBALS['CONFIG']['order_day_end']+7); $ii++){
	$ts_tmp = $ts+86400*$ii;
	$arr = getdate($ts_tmp);
	$dates[date("d.m.Y", $ts_tmp)] = array('d_word' => $DaysOfWeek[$arr['wday']], 'd' => date("Y_m_d", $ts_tmp));
	if($arr['wday'] == 0 || $arr['wday'] == 6){
		$dates[date("d.m.Y", $ts_tmp)]['red'] = true;
		}
	if(isset($contrdates[date("Y-m-d", $ts_tmp)])){
		$dates[date("d.m.Y", $ts_tmp)]['work_day'] = $contrdates[date("Y-m-d", $ts_tmp)]['work_day']!=0?1:0;
		$dates[date("d.m.Y", $ts_tmp)]['work_night'] = $contrdates[date("Y-m-d", $ts_tmp)]['work_night']!=0?1:0;
		$dates[date("d.m.Y", $ts_tmp)]['limit_sum_day'] = $contrdates[date("Y-m-d", $ts_tmp)]['limit_sum_day']!=0?$contrdates[date("Y-m-d", $ts_tmp)]['limit_sum_day']:'0';
		$dates[date("d.m.Y", $ts_tmp)]['limit_sum_night'] = $contrdates[date("Y-m-d", $ts_tmp)]['limit_sum_night']!=0?$contrdates[date("Y-m-d", $ts_tmp)]['limit_sum_night']:'0';
	}else{
		$dates[date("d.m.Y", $ts_tmp)]['work_day'] = 0;
		$dates[date("d.m.Y", $ts_tmp)]['work_night'] = 0;
		$dates[date("d.m.Y", $ts_tmp)]['limit_sum_day'] = 0;
		$dates[date("d.m.Y", $ts_tmp)]['limit_sum_night'] = 0;
	}
}
$tpl->Assign('dates', $dates);
$fields = array('creation_date', 'target_date', 'id_order', 'status',
	'pretense', 'pretense_status', 'return', 'return_status', 'note');
$f_assoc = array('creation_date'=>'o.creation_date', 'target_date'=>'o.target_date',
	'id_order'=>'o.id_order', 'status'=>'o.id_order_status', 'pretense'=>'o.id_pretense_status',
	'pretense_status'=>'o.id_pretense_status', 'return'=>'o.id_return_status',
	'return_status'=>'o.id_return_status', 'customer'=>'u.id_user');
$orderby = "o.creation_date desc, o.id_order desc";
$sort_links = array();
$ii = count($GLOBALS['IERA_LINKS'])-1;
if(isset($_POST['change_margin'])){
	$_POST['discount'] = str_replace(",",".",$_POST['discount']);
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	$nocheck[] = 'keystring';
	if(!$err){
		if($id = $Customer->UpdateCustomer($_POST)){
			$tpl->Assign('msg', 'Информация обновлена.');
			$success = true;
			unset($_POST);
			header("Location: /cabinet");
			exit();
		}else{
			$tpl->Assign('msg', 'Информация не обновлена.');
			if(mysql_errno() == 1062){
				$errm['email'] = "Такой email уже есть в базе.";
				ini_set('display_errors',1);
				error_reporting(E_ALL);
				$tpl->Assign('errm', $errm);
			}
		}
	}else{
		// показываем все заново но с сообщениями об ошибках
		$tpl->Assign('msg', 'Информация не обновлена.');
		$tpl->Assign('errm', $errm);
	}
}
foreach($fields as $f){
	$sort_links[$f] = $GLOBALS['IERA_LINKS'][$ii]['url']."{$GET_limit}ord/$f/desc";
	if(in_array("ord", $GLOBALS['REQAR']) && in_array($f, $GLOBALS['REQAR'])){
		if(in_array("asc", $GLOBALS['REQAR'])){
			$sort_links[$f] = $GLOBALS['IERA_LINKS'][$ii]['url']."{$GET_limit}ord/$f/desc";
			$orderby = "{$f_assoc[$f]} asc";
		}else{
			$sort_links[$f] = $GLOBALS['IERA_LINKS'][$ii]['url']."{$GET_limit}ord/$f/asc";
			$orderby = "{$f_assoc[$f]} desc";
		}
	}
}
$tpl->Assign('sort_links', $sort_links);


if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$orders = $Contragent->GetContragentOrdersByClient($orderby, $target, $User->fields['id_user'], $GLOBALS['REQAR'][1]);	
}else{
	$orders = $Contragent->GetContragentOrders($orderby, $target, $User->fields['id_user']);
}

// Пагинатор ===============================================
if(isset($_GET['limit']) && is_numeric($_GET['limit'])){
	$GLOBALS['Limit_db'] = $_GET['limit'];
}
if((isset($_GET['limit']) && $_GET['limit'] != 'all' && !is_array($mass)) || !isset($_GET['limit'])){
	if(isset($GLOBALS['Page_id']) && is_numeric($GLOBALS['Page_id'])){
		$_GET['page_id'] = $GLOBALS['Page_id'];
	}
	$cnt = count($orders);
	$tpl->Assign('cnt', $cnt);
	$tpl->Assign('pages_cnt', ceil($cnt/$GLOBALS['Limit_db']));
	
	$GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
	unset($cnt);
	$limit = ' LIMIT '.$GLOBALS['Start'].', '.$GLOBALS['Limit_db'];
}else{
	$GLOBALS['Limit_db'] = 0;
	$limit = '';
}
// =========================================================
// Список заказов
if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$orders = $Contragent->GetContragentOrdersByClient($orderby, $target, $User->fields['id_user'], $GLOBALS['REQAR'][1], $limit);
	$tpl->Assign('filtered_client', $GLOBALS['REQAR'][1]);
}else{
	$orders = $Contragent->GetContragentOrders($orderby, $target, $User->fields['id_user'], $limit);
}
$Contragent->SetFieldsById($User->fields['id_user']);
$tpl->Assign('contragent', $Contragent->fields);
$tpl->Assign('orders', $orders);
$tpl->Assign('current', $User->fields);
$customers = $Customer->GetCustomersByContragent($User->fields['id_user']);
$tpl->Assign('customers', $customers);
$order_statuses = $Order->GetStatuses();
$tpl->Assign('order_statuses', $order_statuses);
$id = explode(';', $Contragent->fields['details']);
if(empty($id[0]) || strlen($Contragent->fields['details']) == 0){
	$id = 0;
}
$remitters = $Contragent->GetRemitterById($id);
$tpl->Assign('remitters', $remitters);
$parsed_res = array(
	'issuccess' => true,
	'html' => $tpl->Parse($GLOBALS['PATH_tpl'].'cp_contragent_cab.tpl')
);