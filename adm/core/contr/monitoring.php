<?php
if (!_acl::isAllow('monitoring')){
	die("Access denied");
}
unset($parsed_res);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Мониторинг";
$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);

$specification->list[] = array('type_name'=>'Характеристики', 'alias'=>'specifications');
$specification->list[] = array('type_name'=>'Товары', 'alias'=>'products');
$tpl->Assign('list_types', $specification->list);

if(isset($GLOBALS['REQAR'][1])){
	switch ($GLOBALS['REQAR'][1]){
		case 'specifications':
			$ii = count($GLOBALS['IERA_LINKS']);
			$GLOBALS['IERA_LINKS'][$ii]['title'] = "Мониторинг характеристик";
			$product = new Products();
			$specification = new Specification();
			$specification->GetMonitoringList();
			if((isset($_GET['limit']) && $_GET['limit'] != 'all') || !isset($_GET['limit'])){
				if(isset($_POST['page_nbr']) && is_numeric($_POST['page_nbr'])){
					$_GET['page_id'] = $_POST['page_nbr'];
				}
				$cnt = count($specification->list);
				$GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
				$limit = ' '.$GLOBALS['Start'].', '.$GLOBALS['Limit_db'];
			}else{
				$GLOBALS['Limit_db'] = 0;
				$limit = false;
			}
			$specification->GetMonitoringList($limit);
			foreach($specification->list as $value){
				$product->SetFieldsForMonitoringSpecifications(array('id_category'));
			}
			$tpl->Assign('list', $specification->list);
			break;
		case 'products':
			$product = new Products();
			// $product->
			break;
		case 'characteristics':
			$product = new Products();
			// $product->
			break;
		default:
			break;
	}
	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);
	$parsed_res = array(
		'issuccess' => true,
		'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_monitoring_'.$GLOBALS['REQAR'][1].'.tpl')
	);
}else{
	$parsed_res = array(
		'issuccess' => true,
		'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_monitoring.tpl')
	);
}
if($parsed_res['issuccess'] == true){
	$tpl_center .= $parsed_res['html'];
}

?>