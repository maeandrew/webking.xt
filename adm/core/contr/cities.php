<?php
$Address = new Address();

$header = 'Города';
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$tpl->Assign('h1', $header);

$tpl->Assign('regions', $Address->GetRegionsList());
$region = false;
if(isset($_GET['smb'])){
	$region = (int) $_GET['id_region'];
}else

if(isset($_GET['clear_filters'])){
	header ("Location: /adm/cities");
}

if(isset($_GET['limit']) && is_numeric($_GET['limit'])){
	$GLOBALS['Limit_db'] = $_GET['limit'];
}
if((isset($_GET['limit']) && $_GET['limit'] != 'all') || !isset($_GET['limit'])){
	if(isset($_POST['page_nbr']) && is_numeric($_POST['page_nbr'])){
		$_GET['page_id'] = $_POST['page_nbr'];
	}
	$cnt = count($Address->GetCitiesList($region));
	$GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
	$limit = ' '.$GLOBALS['Start'].', '.$GLOBALS['Limit_db'];
}else{
	$GLOBALS['Limit_db'] = 0;
	$limit = '';
}
$tpl->Assign('list', $Address->GetCitiesList($region, $limit));

$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_cities.tpl');
