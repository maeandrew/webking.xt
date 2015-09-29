<?php
	if (!_acl::isAllow('orders'))
		die("Access denied");

	$Order = new Orders();

	// ---- center ----
	unset($parsed_res);

	$tpl->Assign('h1', 'Заказы по поставщикам');

// 	$ii = count($GLOBALS['IERA_LINKS']);
// 	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Заказы по поставщикам";

// 	if (in_array("export", $GLOBALS['REQAR'])){$_POST = $_SESSION['_POST_'];}
	
// 	$arr = false;
// 	if (isset($_POST['smb'])){
// 		if ($_POST['filter_target_date_start']!==''){
// 			$arr['target_date_start'] = mysql_real_escape_string($_POST['filter_target_date_start']);
// 			list($d,$m,$y) = explode(".", trim($arr['target_date_start']));
// 			$arr['target_date_start'] = mktime(0, 0, 0, $m , $d, $y);
// 		}
// 		if ($_POST['filter_target_date_end']!==''){
// 			$arr['target_date_end'] = mysql_real_escape_string($_POST['filter_target_date_end']);
// 			list($d,$m,$y) = explode(".", trim($arr['target_date_end']));
// 			$arr['target_date_end'] = mktime(0, 0, 0, $m , $d, $y);
// 		}
		
// 		if ($_POST['filter_id_order']!=='')
// 			$arr['id_order'] = mysql_real_escape_string($_POST['filter_id_order']);
// 		if ($_POST['id_order_status']!=='0')
// 			$arr['id_order_status'] = mysql_real_escape_string($_POST['id_order_status']);
// 		if ($_POST['filter_contragent_name']!=='')
// 			$arr['contragent_name'] = mysql_real_escape_string($_POST['filter_contragent_name']);
// 		if ($_POST['filter_customer_name']!=='')
// 			$arr['customer_name'] = mysql_real_escape_string($_POST['filter_customer_name']);
// 	}else{
// 		$_POST['id_order_status'] = 0;
// 	}
	
// 	$fields = array('target_date', 'id_order');
// 	$orderby = "target_date desc";
// 	$sort_links = array();
	
// 	foreach ($fields as $f){
// 		$sort_links[$f] = $GLOBALS['URL_base']."adm/orders_sup/ord/$f/asc";
// 		if (in_array("ord", $GLOBALS['REQAR']) && in_array($f,$GLOBALS['REQAR'])){
// 			if (in_array("asc",$GLOBALS['REQAR'])){
// 				$sort_links[$f] = $GLOBALS['URL_base']."adm/orders_sup/ord/$f/desc";
// 				$orderby = "$f asc";
// 			}else{
// 				$orderby = "$f desc";
// 			}
// 		}
// 	}
	
// 	$tpl->Assign('sort_links', $sort_links);

// 	if ($Order->SetList_sup(1, $arr, $orderby))
// 	$tpl->Assign('list', $Order->list);
	
// 	$r = array();
	
// if (count($Order->list)){
	
// 	foreach ($Order->list as $i){
// 		$contragents[] = $i['id_contragent'];
// 		$customers[] = $i['id_customer'];
// 		if (isset($i['id_supplier']))
// 			$suppliers[] = $i['id_supplier'];
// 		if (isset($i['id_supplier_mopt']))
// 			$suppliers[] = $i['id_supplier_mopt'];
// 	}
// 	$contragents = $Order->ContragentsList(array_unique($contragents));
// 	$customers = $Order->CustomersList(array_unique($customers));

// 	if (isset($suppliers))
// 		$suppliers = $Order->SuppliersList(array_unique($suppliers));
	
// 	$order_statuses = $Order->GetStatuses();
// 	$tpl->Assign('order_statuses', $order_statuses);

// 	// Формирование массива строк для таблицы
// 	$r = array();
// 	$rE = array();
// 	$ii = 0;
// 	foreach ($Order->list as $i){
		
// 		$rE[$ii]['target_date'] = $r[$ii]['target_date'] = date("d.m.Y",$i['target_date']);
// 		$rE[$ii]['status_name'] = $r[$ii]['status_name'] = $order_statuses[$i['id_order_status']]['name'];

// 		$r[$ii]['id_order'] = '<a href="'.$GLOBALS['URL_base'].'adm/order/'.$i['id_order'].'">'.$i['id_order'].'</a>';
// 		$rE[$ii]['id_order'] = $i['id_order'];
		
// 		if($i['id_order_status']!=3){
// 			$r[$ii]['id_order_supart'] = "<a href=\"{$GLOBALS['URL_base']}adm/order_sup/{$i['id_order']}/{$i['id_supplier_t']}\">{$i['id_order']}-{$suppliers[$i['id_supplier_t']]['article']}</a>";
// 			$rE[$ii]['id_order_supart'] = "{$i['id_order']}-{$suppliers[$i['id_supplier_t']]['article']}";
// 		}else{
// 			$r[$ii]['id_order_supart'] = '';
// 			$rE[$ii]['id_order_supart'] = "";
// 		}
		  
// 		$rE[$ii]['customer_name'] = $r[$ii]['customer_name'] = isset($customers[$i['id_customer']])?htmlspecialchars($customers[$i['id_customer']]['name']):"[удален]";
// 		$rE[$ii]['contragent_name'] = $r[$ii]['contragent_name'] = isset($contragents[$i['id_contragent']])?htmlspecialchars($contragents[$i['id_contragent']]['name']):"[удален]";
// 		$rE[$ii]['supplier_name'] = $r[$ii]['supplier_name'] = ($i['id_order_status']!=3)?htmlspecialchars($suppliers[$i['id_supplier_t']]['name']):'';
// 		$rE[$ii]['partner'] = $r[$ii]['partner'] = ($i['id_order_status']!=3 && $suppliers[$i['id_supplier_t']]['is_partner']==1)?'партнер':'';
		
// 		if (!isset($i['sup_sum_t'])) $i['sup_sum_t'] = 0;
// 		if (!isset($i['sup_otpusk_sum_t'])) $i['sup_otpusk_sum_t'] = 0;
		
// 		$rE[$ii]['order_sum'] = $r[$ii]['order_sum'] = $i['sup_sum_t'];
// 		$rE[$ii]['otpusk_prices_sum'] = $r[$ii]['otpusk_prices_sum'] = round($i['sup_otpusk_sum_t'],2);
		
// 		if($i['id_pretense_status']==0){$rE[$ii]['pretense'] = $r[$ii]['pretense'] = '-';}else{
// 			$r[$ii]['pretense'] = "<a href=\"{$GLOBALS['URL_base']}adm/order/{$i['id_order']}\">{$i['id_order']}</a>-прет";
// 			$rE[$ii]['pretense'] = "{$i['id_order']}-прет";
// 		}
// 		if($i['id_pretense_status']==0){$rE[$ii]['pretense_status'] = $r[$ii]['pretense_status'] = '-';}else{
// 			$rE[$ii]['pretense_status'] = $r[$ii]['pretense_status'] = $order_statuses[$i['id_pretense_status']]['name'];
// 		}

// 		if($i['id_return_status']==0){$rE[$ii]['return'] = $r[$ii]['return'] = '-';}else{
// 			$r[$ii]['return'] = "<a href=\"{$GLOBALS['URL_base']}adm/order_return/{$i['id_order']}\">{$i['id_order']}</a>-возв";
// 			$rE[$ii]['return'] = "{$i['id_order']}-возв";
// 		}
// 		if($i['id_return_status']==0){$rE[$ii]['return_status'] = $r[$ii]['return_status'] = '-';}else{
// 			$rE[$ii]['return_status'] = $r[$ii]['return_status'] = $order_statuses[$i['id_return_status']]['name'];
// 		}
// 		$ii++;
// 	}
	
	
// }else{
// 	$order_statuses = $Order->GetStatuses();
// 	$tpl->Assign('order_statuses', $order_statuses);
// }
	
// if (in_array("export", $GLOBALS['REQAR'])){
	// $Order->GenExcelOrdersSupFile($rE);
	// exit(0);
// }else{
	if(isset($_SESSION['_POST_'])) unset($_SESSION['_POST_']);
	$_SESSION['_POST_'] = $_POST;
	
	// $tpl->Assign('rows', $r);

	$parsed_res = array(
		'issuccess' => TRUE,
		'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_orders_sup.tpl')
	);
	if(TRUE == $parsed_res['issuccess']){
		$tpl_center .= $parsed_res['html'];
	}
// }
?>