<?php
unset($parsed_res);
$products = new Products();
ini_set('memory_limit', '400M');
$plist = $products->SetProductsList4csvProm();
header("Content-type: application/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=prom_ua.csv");
header("Pragma: no-cache");
header("Expires: 0");
$handle = fopen('php://output', 'w');
fputcsv($handle, array(
	'Артикул',
	'Название',
	'Цена опт',
	'Цена розница'
	));
foreach($plist AS $p){
	$opt_coeff_arr = explode(';', $GLOBALS['CONFIG']['correction_set_'.$p['opt_correction_set']]);
	$mopt_coeff_arr = explode(';', $GLOBALS['CONFIG']['correction_set_'.$p['mopt_correction_set']]);
	$opt_coeff = $opt_coeff_arr[2];
	$mopt_coeff = $mopt_coeff_arr[2];
	fputcsv($handle, array(
		$p['art'],
		$p['name'],
		round($p['price_opt']*$p['min_mopt_qty']*$opt_coeff,2),
		round($p['price_mopt']*$p['min_mopt_qty']*$mopt_coeff,2)
	));
}
ini_set('memory_limit', '192M');
fclose($handle);
exit;
?>