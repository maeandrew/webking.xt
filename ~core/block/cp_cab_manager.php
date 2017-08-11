<?php
$GLOBALS['IERA_LINKS'] = array();
$GLOBALS['IERA_LINKS'][0]['title'] = "Кабинет";
$GLOBALS['IERA_LINKS'][0]['url'] =  _base_url.'/cabinet/';
if(isset($_POST['id_order']) && !empty($_POST['id_order'])) $id_order = intval($_POST['id_order']);
$Manager = new Managers();
$Manager->SetFieldsById($Users->fields['id_user']);
$tpl->Assign("manager", $Manager->fields);
//*********************************
if($Users->fields['gid'] == _ACL_MANAGER_){
	$Order = new Orders();
	if(isset($_POST['smb_cancel'])){
		if($Order->CancelContragentOrder($id_order)){
			$tpl->Assign('msg', 'Заказ отменен контрагентом.');
			unset($_POST);
		}else{
			$tpl->Assign('msg', 'Информация не обновлена.');
		}
	}elseif(isset($_POST['smb_run'])){
		if($Order->RunContragentOrder($id_order)){
			$tpl->Assign('msg', 'Заказ направлен к выполнению.');
			unset($_POST);
		}else{
			$tpl->Assign('msg', 'Информация не обновлена.');
		}
	}
}
//*********************************
//print_r($dates);
$fields = array('date', 'id_order', 'status', 'pretense', 'pretense_status', 'return', 'return_status', 'customer');
$f_assoc = array('date'=>'o.target_date', 'id_order'=>'o.id_order', 'status'=>'o.id_order_status',
	'pretense'=>'o.id_pretense_status', 'pretense_status'=>'o.id_pretense_status',
	'return'=>'o.id_return_status', 'return_status'=>'o.id_return_status', 'customer'=>'u.id_user');
$orderby = "o.id_order desc";
$sort_links = array();
$GET_limit = "";
if(isset($_GET['limit'])){
	$GET_limit = "limit".$_GET['limit'].'/';
}
$ii = count($GLOBALS['IERA_LINKS'])-1;
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
// Список заказов
$orders = $Manager->GetOrders($orderby);
$tpl->Assign('orders', $orders);
$Order = new Orders();
$order_statuses = $Order->GetStatuses();
$tpl->Assign('order_statuses', $order_statuses);
$parsed_res = array('issuccess' => TRUE,
					'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_manager_cab.tpl'));
?>