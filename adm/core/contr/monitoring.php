<?php
if (!_acl::isAllow('monitoring')){
	die("Access denied");
}
unset($parsed_res);

$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Мониторинг";
$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);

if(isset($GLOBALS['REQAR'][1])){
	switch ($GLOBALS['REQAR'][1]){
		case 'specifications':
			$ii = count($GLOBALS['IERA_LINKS']);
			$GLOBALS['IERA_LINKS'][$ii]['title'] = "Мониторинг характеристик";
			$product = new Products();
			$specification = new Specification();
			$specification->GetMonitoringList();
			foreach($specification->list as $value){
				$product->SetFieldsForMonitoringSpecifications(array('id_category'));
			}
			$tpl->Assign('list', $specification->list);
			break;
		case 'products':
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
if ($parsed_res['issuccess'] == true) {
	$tpl_center .= $parsed_res['html'];
}
?>