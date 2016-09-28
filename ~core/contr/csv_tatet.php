<?php
unset($parsed_res);
$Products = new Products();
ini_set('memory_limit', '400M');
$plist = $Products->SetProductsList4csvTatet();
header("Content-type: application/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=tatet_ua.csv");
header("Pragma: no-cache");
header("Expires: 0");
$handle = fopen('php://output', 'w');
fputcsv($handle, array(
	'Категория',
	'Артикул',
	'Название',
	'Цена',
	'Единица измерения',
	'Статус',
	'Описание',
	'Изображение'
	));
foreach($plist AS $p){
	$opt_coeff_arr = explode(';', $GLOBALS['CONFIG']['correction_set_'.$p['opt_correction_set']]);
	$mopt_coeff_arr = explode(';', $GLOBALS['CONFIG']['correction_set_'.$p['mopt_correction_set']]);
	$opt_coeff = $opt_coeff_arr[2];
	$mopt_coeff = $mopt_coeff_arr[2];
	fputcsv($handle, array(
		$p['catname'],
		$p['art'],
		$p['name'],
		round($p['price_mopt']*$mopt_coeff,2),
		$p['units'],
		'1',
		$p['descr'],
		_base_url.$p['img_1']
	));
}
ini_set('memory_limit', '192M');
fclose($handle);
exit;
?>