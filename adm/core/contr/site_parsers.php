<?php
if(!_acl::isAllow('parser')){
	die('Access denied');
}
unset($parsed_res);
$header = 'Парсер сайтов';
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = 'Каталог';
$GLOBALS['IERA_LINKS'][$ii++]['url'] = '/adm/cat/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;

if(isset($_POST['parse'])){
	if(!empty($_FILES) && is_uploaded_file($_FILES['urls']['tmp_name'])){
		require($GLOBALS['PATH_sys'].'excel/Classes/PHPExcel/IOFactory.php');
		$objPHPExcel = PHPExcel_IOFactory::load($_FILES['urls']['tmp_name']);
		$objPHPExcel->setActiveSheetIndex(0);
		$aSheet = $objPHPExcel->getActiveSheet();
		//этот массив будет содержать массивы содержащие в себе значения ячеек каждой строки
		$array = array();
		$ca = array('id', 'url', 'name');
		//получим итератор строки и пройдемся по нему циклом
		foreach($aSheet->getRowIterator() as $k => $row){
			//получим итератор ячеек текущей строки
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); // Включить пустые ячейки
			//пройдемся циклом по ячейкам строки
			$item = array();
			foreach($cellIterator as $cell){
				//заносим значения ячеек одной строки в отдельный массив
				array_push($item, $cell->getCalculatedValue());
			}
			//заносим массив со значениями ячеек отдельной строки в "общий массив строк"
			if($k > 1){
				array_push($array, $item);
			}else{
				$heading = $item;
			}
		}
		// проход по первой строке
		foreach($ca as $k => $i){
			if($i != $heading[$k]){
				$_SESSION['errm'][] = 'Неверный формат файла';
				return array(0, 0);
			}
			$keys[] = $i;
		}
		$Parser = new Parser();
		// ini_set('memory_limit', '728M');
		ini_set('max_execution_time', 3000);
		foreach($array as $row){
			$res = array_combine($keys, $row);
			if(isset($res['url']) && $res['url'] !== ''){
				if($Parser->parseUrl($res['url'])){
					sleep(1);
				}
			}
		}
		// ini_set('memory_limit', '192M');
		ini_set('max_execution_time', 30);
	}
}

$tpl->Assign('h1', $header);
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_site_parsers.tpl');