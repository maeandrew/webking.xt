<?php
$Address = new Address();
$Users = new Users();

$header = 'Пункты выдачи';
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$tpl->Assign('h1', $header);
// Список областей
$tpl->Assign('regions', $Address->GetRegionsList());
// Список городов
$tpl->Assign('cities', $Address->GetCitiesList());
// Список ТК
$tpl->Assign('shipping_companies', $Address->GetShippingCompaniesList());
// Список дилеров
$tpl->Assign('dealers', $Users->GetDealersList());

$where = false;

if(isset($_GET['smb'])){
	if($_GET['id_city'] != false){
		$where[] = 'id_city = '.$_GET['id_city'];
	}
	if($_GET['id_region'] != false){
	 	 $where[] = 'id_city IN (SELECT ls.id FROM '._DB_PREFIX_.'locations_cities AS ls WHERE ls.id_region = '.$_GET['id_region'].')';
	 }
	if($_GET['shipping_companies'] != false){
	 	$where[] = 'id_shipping_company = ' .$_GET['shipping_companies'];
	}

}else

if(isset($_GET['clear_filters'])){
	header ("Location: /adm/warehouses");
}

// Пагинация
if(isset($_GET['limit']) && is_numeric($_GET['limit'])){
	$GLOBALS['Limit_db'] = $_GET['limit'];
}
if((isset($_GET['limit']) && $_GET['limit'] != 'all') || !isset($_GET['limit'])){
	if(isset($_POST['page_nbr']) && is_numeric($_POST['page_nbr'])){
		$_GET['page_id'] = $_POST['page_nbr'];
	}
	$cnt = count($Address->GetWarehousesList($where));
	$GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
	$limit = ' '.$GLOBALS['Start'].', '.$GLOBALS['Limit_db'];
}else{
	$GLOBALS['Limit_db'] = 0;
	$limit = '';
}
// Список пунктов выдачи
$tpl->Assign('list', $Address->GetWarehousesList($where, $limit));

$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_warehouses.tpl');
