<?php
//setlocale(LC_ALL, 'ru_RU');
// ---- center ----
unset($parsed_res);
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);

$Products = new Products();

ini_set('memory_limit', '1024M');	
ini_set('max_execution_time', 3000);
$plist = $Products->SetProductsList4csvProm();

header('Content-Encoding: UTF-8');
header("Content-type: application/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=prom_ua.csv");
header("Pragma: no-cache");
header("Expires: 0");

$handle = fopen('php://output', 'w');

fputcsv($handle, array(
	'Код_товара',
	'Название_позиции',
	'Ключевые_слова',
	'Описание',
	'Тип_товара',
	'Цена',
	'Валюта',
	'Единица_измерения',
	'Минимальный_объем_заказа',
	'Оптовая_цена',
	'Минимальный_заказ_опт',
	'Ссылка_изображения',
	'Наличие',
	'Производитель',
	'Страна_производитель',
	'Номер_группы',
	'Адрес_подраздела',
	'Возможность_поставки',
	'Срок_поставки',
	'Способ_упаковки',
	'Идентификатор_товара',
	'Уникальный_идентификатор',
	'Идентификатор_подраздела',
	'Идентификатор_группы'));
foreach($plist AS $p){
	$opt_coeff_arr = explode(';', $GLOBALS['CONFIG']['correction_set_'.$p['opt_correction_set']]);
	$mopt_coeff_arr = explode(';', $GLOBALS['CONFIG']['correction_set_'.$p['mopt_correction_set']]);
	$opt_coeff = $opt_coeff_arr[0];
	$mopt_coeff = $mopt_coeff_arr[3];
	if($p['name_index'] == ''){
		$p['name_index'] = strtoupper($p['name']);
	}
	fputcsv($handle, array(
		$p['art'],
		$p['name'],
		str_replace(' ', ',', $p['name_index']), '.'.
		'<a href="'.$GLOBALS['URL_base'].'/'.$p['translit'].'.html"><img src="'.$GLOBALS['URL_base'].'/images/buy.png" /></a>'.$p['descr'],
		$p['price_mopt'] > 0?'u':'w',
		round($p['price_mopt']*$mopt_coeff, 1),
		'UAH',
		$p['units'],
		$p['min_mopt_qty'],
		round($p['price_opt']*$opt_coeff, 3),
		$p['inbox_qty'],
		_base_url.$p['img_1'],
		'+',
		'',
		'',
		$p['prom_id'],
		'',
		'',
		'',
		'',
		$p['art'],

	));
}
ini_set('memory_limit', '192M');
ini_set('max_execution_time', 30);
fclose($handle);
exit;