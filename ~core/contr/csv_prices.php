<?php
//setlocale(LC_ALL, 'ru_RU');
	// ---- center ----
	unset($parsed_res);
	$Page = new Page();
	$Page->PagesList();
	$tpl->Assign('list_menu', $Page->list);

	$Products = new Products();

	$plist = $Products->SetProductsList4csv();

header("Content-type: application/csv; charset=Windows-1251");
header("Content-Disposition: attachment; filename=fishing.csv");
header("Pragma: no-cache");
header("Expires: 0");

$handle = fopen('php://output', 'w');

fputcsv($handle, array(
	mb_convert_encoding('Название', "windows-1251", "utf-8"),
	mb_convert_encoding('Цена при заказе от 2000 грн', "windows-1251", "utf-8"),
	mb_convert_encoding('Адрес страницы', "windows-1251", "utf-8"),
	));
foreach($plist AS $p){
	fputcsv($handle, array(
		mb_convert_encoding($p['name'], "windows-1251", "utf-8"),
		number_format($p['price_mopt']*$GLOBALS['CONFIG']['wholesale_discount'],2,".",""),
		'http://'.$GLOBALS['CONFIG']['invoice_logo_text'].'/product/'.$p['id_product'].'/'.$p['translit'].'/'
	));
}
fclose($handle);
exit;
?>