<?php
//setlocale(LC_ALL, 'ru_RU');
// ---- center ----
unset($parsed_res);
//$Page = new Page();
//$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
$products = new Products();
$plist = $products->SetProductsList4SuppliersCSV($_GET['orders'], $_GET['supplier']);
foreach ($plist as $key => $row) {
	$id_order[$key]  = $row['id_order'];
	$art[$key] = $row['art'];
}
array_multisort($id_order, SORT_ASC, $art, SORT_ASC, $plist);

//$handle = fopen('php://output', 'w');
$handle = $GLOBALS['CONFIG']['csv_path'].$_GET['supplier_article'].".csv";
//header("Content-type: application/csv; charset=Windows-1251");
//header("Content-Disposition: attachment; filename=".$_GET['supplier_article'].".csv");
//header("Pragma: no-cache");
//header("Expires: 0");

file_put_contents($handle, array(
	mb_convert_encoding('№ заказа', "windows-1251", "utf-8"),';',
	mb_convert_encoding('арт. сайт', "windows-1251", "utf-8"),';',
	mb_convert_encoding('арт. поставщика', "windows-1251", "utf-8"),';',
	mb_convert_encoding('Цена', "windows-1251", "utf-8"),';',
	mb_convert_encoding('Количество', "windows-1251", "utf-8"),';',
	mb_convert_encoding('Ед. измерения', "windows-1251", "utf-8"),';',
	mb_convert_encoding('Название', "windows-1251", "utf-8"),';',
	mb_convert_encoding('Примечание', "windows-1251", "utf-8"),
	"\r\n"
	));
foreach($plist AS $p){
	$art = explode('арт.', $p['name']);
	if($p['id_supplier'] == $_GET['supplier']){
		file_put_contents($handle, array(
				mb_convert_encoding($p['id_order'], "windows-1251", "utf-8"),';',
				mb_convert_encoding($p['art'], "windows-1251", "utf-8"),';',
				mb_convert_encoding(isset($art[1])?$art[1]:null, "windows-1251", "utf-8"),';',
				mb_convert_encoding($p['price_opt_otpusk'], "windows-1251", "utf-8"),';',
				mb_convert_encoding($p['opt_qty'], "windows-1251", "utf-8"),';',
				mb_convert_encoding($p['units'], "windows-1251", "utf-8"),';',
				mb_convert_encoding($p['name'], "windows-1251", "utf-8"),';',
				mb_convert_encoding($p['note_opt'], "windows-1251", "utf-8"),
				"\r\n"
			), FILE_APPEND );
	}
	if($p['id_supplier_mopt'] == $_GET['supplier']){
		file_put_contents($handle, array(
				mb_convert_encoding($p['id_order'], "windows-1251", "utf-8"),';',
				mb_convert_encoding($p['art'], "windows-1251", "utf-8"),';',
				mb_convert_encoding(isset($art[1])?$art[1]:null, "windows-1251", "utf-8"),';',
				mb_convert_encoding($p['price_mopt_otpusk'], "windows-1251", "utf-8"),';',
				mb_convert_encoding($p['mopt_qty'], "windows-1251", "utf-8"),';',
				mb_convert_encoding($p['units'], "windows-1251", "utf-8"),';',
				mb_convert_encoding($p['name'], "windows-1251", "utf-8"),';',
				mb_convert_encoding($p['note_mopt'], "windows-1251", "utf-8"),
				"\r\n"
			), FILE_APPEND );
	}
}
//fclose($handle);
exit;
?>