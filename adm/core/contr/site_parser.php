<?php

// error_reporting(-1);
// header('Content-Type: text/html; charset=utf-8');


if(!_acl::isAllow('parser')){
	die('Access denied');
}
unset($parsed_res);
$header = 'Парсер';
$tpl->Assign('h1', $header);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$Products = new Products();
$Specification = new Specification();
$Images = new Images();
$Parser = new Parser();
$tpl->Assign('sites', $Parser->GetSitesList(false));

//Устанавливаем настройки памяти
echo "memory_limit ", ini_get('memory_limit'), "<br />";
ini_set('memory_limit', '1024M');	
echo "memory_limit ", ini_get('memory_limit'), "<br />";
//Устанавливаем настройки времени
echo "max_execution_time ", ini_get('max_execution_time'), "<br />";
ini_set('max_execution_time', 3000);
echo "max_execution_time ", ini_get('max_execution_time'), "<br />";

ini_set('display_errors','on');
ini_set('error_reporting',E_ALL);
set_time_limit(0);

// phpinfo();
// die();
//Парсинги по сохраненым файлам XML----------------------------------------------------------
//-------------------------------------------------------------------------------------------
if(isset($_POST['parse'])){
	print_r('<pre>');
	print_r($_POST);
	print_r('</pre>');

	$Parser->SetFieldsById($_POST['site']);
	$site = $Parser->fields;
	if($site['id_supplier'] == NULL){
		echo "Не выбран поставщик для товара";
		die();
	}
	if($site['id_category'] == NULL){
		echo "Не выбрана категория для товара";
		die();
	}
	$id_supplier = $site['id_supplier'];
	$id_category = $site['id_category'];
	// $format_example = $Parser->GetSiteFormatFile($_POST['site']);
	// $format_example['format'] = '/parser_formats_examples/articles_only.xlsx';
	// if($format_example['format']){
		// $objPHPExcel = PHPExcel_IOFactory::load($GLOBALS['PATH_global_root'].$format_example['format']);
		// $objPHPExcel->setActiveSheetIndex(0);
		// $aSheet = $objPHPExcel->getActiveSheet();
		// foreach($aSheet->getRowIterator() as $k => $row){
		// 	//получим итератор ячеек текущей строки
		// 	$cellIterator = $row->getCellIterator();
		// 	$cellIterator->setIterateOnlyExistingCells(false); // Включить пустые ячейки
		// 	//пройдемся циклом по ячейкам строки
		// 	$item = array();
		// 	foreach($cellIterator as $cell){
		// 		//заносим значения ячеек одной строки в отдельный массив
		// 		array_push($item, $cell->getCalculatedValue());
		// 	}
		// 	//заносим массив со значениями ячеек отдельной строки в "общий массив строк"
		// 	if($k == 1){
		// 		$heading_format = $item;
		// 		break;
		// 	}
		// }

		if(!empty($_FILES) && is_uploaded_file($_FILES['file']['tmp_name'])){
			$objPHPExcel = PHPExcel_IOFactory::load($_FILES['file']['tmp_name']);
			$objPHPExcel->setActiveSheetIndex(0);
			$aSheet = $objPHPExcel->getActiveSheet();
			//этот массив будет содержать массивы содержащие в себе значения ячеек каждой строки
			$array = array();
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
					$headings = $item;
				}
			}
			// проход по первой строке
			// $format_error = 0;
			// foreach($heading_format as $k => $i){
			// 	if($i != $headings[$k]){
			// 		$format_error++;
			// 	}
			// 	$keys[] = $i;
			// }
			// if(count($heading_format) !== count($headings)){
			// 	$format_error++;
			// }
			// if($format_error > 0){
			// 	$_SESSION['errm'][] = 'Неверный формат файла';
			// 	die('Неверный формат файла');
			// 	return array(0, 0);
			// }
			// ini_set('memory_limit', '728M');


			$d = $l = $i = 0;
			foreach($array as $key => &$row){
				$res = array_combine($headings, $row);
				$product = array();
				$skipped = false;
				 if($key < $_POST['num']){
					switch ($_POST['site']){
						case 5:
							if(!$product = $Parser->zona($row)){
								continue;
							}
							break;
						case 6:
							if(!$product = $Parser->epicenter($row)){
								continue;
							}
							break;
						case 7:
							if(!$product = $Parser->epicenter($row)){
								continue;
							}
							break;
						case 8:
							if(!$product = $Parser->epicenter($row)){
								continue;
							}
							break;
						case 9:
							if(!$product = $Parser->epicenter($row)){
								continue;
							}
							break;
						case 10:
							if(!$product = $Parser->epicenter($row)){
								continue;
							}
							break;
						case 11:
							if(!$product = $Parser->epicenter($row)){
								continue;
							}
							break;
						case 12:
							if(!$product = $Parser->epicenter($row)){
								continue;
							}
							break;
						case 13:
							$supcomments = $Products->GetSupComments($id_supplier);
							if(!empty($supcomments) && in_array(trim($row[0]), $supcomments)){
								// print_r('<pre>Supplier comment issue</pre>');
								$skipped = true;
								continue;
							}else{
								if(!$product = $Parser->zampodarki($row)){
									continue;
								}
							}
							break;
						case 14:
							$supcomments = $Products->GetSupComments($id_supplier);
							if(!empty($supcomments) && in_array(trim($row[0]), $supcomments)){
								// print_r('<pre>Supplier comment issue</pre>');
								$skipped = true;
								continue;
							}else{
								if(!$product = $Parser->elfa($row)){
									continue;
								}
							}
							break;
						case 15:
							$supcomments = $Products->GetSupComments($id_supplier);
							if(!empty($supcomments) && in_array(trim($row[0]), $supcomments)){
								// print_r('<pre>Supplier comment issue</pre>');
								$skipped = true;
								continue;
							}else{
								if(!$product = $Parser->supertorba($row)){
									continue;
								}
							}
							break;
						case 16: // Mastertool
							$supcomments = $Products->GetSupComments($id_supplier);
							if(!empty($supcomments) && in_array(trim($row[0]), $supcomments)){
								// print_r('<pre>Supplier comment issue</pre>');
								$skipped = true;
								continue;
							}else{
								if(!$product = $Parser->mastertool($row)){
									continue;
								}
							}
							break;
						case 17:
							$supcomments = $Products->GetSupComments($id_supplier);
							if(is_array($supcomments)){
								$supcomments = array_unique($supcomments);
							}
							if(!empty($supcomments) && in_array(trim($row[0]), $supcomments)){
								// print_r('<pre>Supplier comment issue</pre>');
								$skipped = true;
								continue;
							}else{
								if(!$product = $Parser->trislona($row)){
									continue;
								}
							}
							break;
						case 20:
							$supcomments = $Products->GetSupComments($id_supplier);
							if(is_array($supcomments)){
								$supcomments = array_unique($supcomments);
							}
							if(!empty($supcomments) && in_array(trim($row[0]), $supcomments)){
								// print_r('<pre>Supplier comment issue</pre>');
								$skipped = true;
								continue;
							}else{
								if(!$product = $Parser->nl($row)){
									continue;
								}
							}
							break;
						case 21:
							$supcomments = $Products->GetSupComments($id_supplier);
							if(is_array($supcomments)){
								$supcomments = array_unique($supcomments);
							}
							if(!empty($supcomments) && in_array(trim($row[0]), $supcomments)){
								// print_r('<pre>Supplier comment issue</pre>');
								$skipped = true;
								continue;
							}else{
								if(!$product = $Parser->nl($row)){
									continue;
								}
							}
							break;
						default:
							# code...
							break;
					}
					// Добавляем новый товар в БД
					if(!$product || $skipped){
						$i++;
					}elseif($id_product = $Products->AddProduct($product)){
						// print_r('<pre>OK, product added</pre>');
						$k++;
						// Добавляем характеристики новому товару
						if(!empty($product['specs'])){
							foreach($product['specs'] as $specification){
								$Specification->AddSpecToProd($specification, $id_product);
							}
						}
						// Формируем массив записи ассортимента
						$assort = array(
							'id_assortiment' => false,
							'id_supplier' => $id_supplier,
							'id_product' => $id_product,
							'price_opt_otpusk' => $product['price_opt_otpusk'],
							'price_mopt_otpusk' => $product['price_mopt_otpusk'],
							'active' => 1,
							'inusd' => 0,
							'sup_comment' => $product['sup_comment']
						);
						// Добавляем зпись в ассортимент
						$Products->AddToAssortWithAdm($assort);
						// Получаем артикул нового товара
						$article = $Products->GetArtByID($id_product);
						// Переименовываем фото товара
						$to_resize = $images_arr = array();
						if(isset($product['images']) && !empty($product['images'])){
							foreach($product['images'] as $key=>$image){
								$to_resize[] = $newname = $article['art'].($key == 0?'':'-'.$key).'.jpg';
								$file = pathinfo(str_replace('/'.str_replace($GLOBALS['PATH_global_root'], '', $GLOBALS['PATH_product_img']), '', $image));
								$path = $GLOBALS['PATH_product_img'].trim($file['dirname']).'/';
								$images_arr[] = str_replace($file['basename'], $newname, $image);
								rename($path.$file['basename'], $path.$newname);
							}
							//Проверяем ширину и высоту загруженных изображений, и если какой-либо из показателей выше 1000px, уменяьшаем размер
							foreach($images_arr as $filename){
								$file = $GLOBALS['PATH_product_img'].str_replace('/'.str_replace($GLOBALS['PATH_global_root'], '', $GLOBALS['PATH_product_img']), '', $filename);
								$size = getimagesize($file);
								// $size = getimagesize($path.$filename); //Получаем ширину, высоту, тип картинки
								$width = $size[0];
								$height = $size[1];
								if($size[0] > 1000 || $size[1] > 1000){
									$ratio = $size[0]/$size[1]; //коэфициент соотношения сторон
									//Определяем размеры нового изображения
									if(max($size[0], $size[1]) == $size[0]){
										$width = 1000;
										$height = 1000 / $ratio;
									}elseif(max($size[0], $size[1]) == $size[1]){
										$width = 1000*$ratio;
										$height = 1000;
									}
								}
								$res = imagecreatetruecolor($width, $height);
								imagefill($res, 0, 0, imagecolorallocate($res, 255, 255, 255));
								$src = $size['mime'] == 'image/jpeg'?imagecreatefromjpeg($file):imagecreatefrompng($file);
								// Добавляем логотип в нижний правый угол
								imagecopyresampled($res, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
									$stamp = imagecreatefrompng($GLOBALS['PATH_global_root'].'images/watermark_colored.png');
									$k = imagesy($stamp)/imagesx($stamp);
									$widthstamp = imagesx($res)*0.3;
									$heightstamp = $widthstamp*$k;
									imagecopyresampled($res, $stamp, imagesx($res) - $widthstamp, imagesy($res) - $heightstamp, 0, 0, $widthstamp, $heightstamp, imagesx($stamp), imagesy($stamp));
								imagejpeg($res, $file);
							}
							$Images->resize(false, $to_resize);
							// Привязываем новые фото к товару в БД
							$Products->UpdatePhoto($id_product, $images_arr, $product['images_visible']);
						}
						// Добавляем товар в категорию
						$Products->UpdateProductCategories($id_product, array($id_category), $arr['main_category']);
					}else{
						print_r('<pre>Product add issue</pre>');
						$l++;
					}
				 }
			}
			print_r('<pre>товарів додано: '.$d.'</pre>');
			print_r('<pre>товарів не вдалося додати: '.$l.'</pre>');
			print_r('<pre>товарів пропущено: '.$i.'</pre>');
			ini_set('memory_limit', '192M');
			ini_set('max_execution_time', 30);
		}
	// }else{
	// 	print_r('continue without format!');
	// }
}

//Парсинги по сохраненым файлам XML----------------------------------------------------------
//-------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------

if(isset($_POST['parse_XML'])){
	print_r('<pre>');
	print_r($_POST);
	print_r('</pre>');


	$Parser->SetFieldsById($_POST['site']);
	$site = $Parser->fields;
	if($site['id_supplier'] == NULL){
		echo "Не выбран поставщик для товара";
		die();
	}
	if($site['id_category'] == NULL){
		echo "Не выбрана категория для товара";
		die();
	}
	$id_supplier = $site['id_supplier'];
	$id_category = $site['id_category'];

	

	print_r('<pre>');
	print_r($_POST);
	print_r('</pre>');


		
	if(!empty($_FILES) && is_uploaded_file($_FILES['file']['tmp_name'])){
		$xml = simplexml_load_file($html);
		print_r('<pre>');
		print_r($_POST);
		print_r('</pre>');
	//die();
		//получим  масив id 
		$array = array();
		//пройдемся циклом по  и вберем ключи
		switch ($_POST['site']){
			case 22:
				echo "case 22 ----- ОК <br />";
				$item = array();
					foreach ($xml->xpath('/yml_catalog/shop') as $element) {
						foreach ($element->xpath('offers/offer') as $offer) {
								array_push($array, $offer->vendorCode);
						}
					}
					echo "Размер масива ", count($array, COUNT_RECURSIVE), "<br />";
					
					foreach ($array as $key => $value) {
	    			echo "Ключ: $key; Значение: $value<br />\n";
					 }
				break;

			default:
				# code...
			break;
		}
	} else {
		echo "Не удалось открыть файл<br />\n";
    }
		
	// die();

	ini_set('max_execution_time', 3000);
	$d = $k = $l = $i = 0;
	foreach($array as $key => &$row){
		//$res = array_combine($headings, $row);
		$product = array();
		$skipped = false;

		if($d < $_POST['num']){
			switch ($_POST['site']){
				case 22:
					$supcomments = $Products->GetSupComments($id_supplier);
					if(is_array($supcomments)){
						$supcomments = array_unique($supcomments);
					}
					if(!empty($supcomments) && in_array(trim($row), $supcomments)){
						echo $row, " - Есть у поставщика ";
						$skipped = true;
						$i++;
						continue;
						break;
					}else{
						//Определяем категорию
						switch ($offer->categoryId) {
						    case 139:
						        $id_category = '1748';
						        break;
						    case 136:
						        $id_category = '1747';
						        break;
						    case 123:
						        $id_category = '1746';
						        break;
						    case 95:
						        $id_category = '1745';
						        break;
						    case 93:
						        $id_category = '1749';
						        break;
						    case 89:
						        $id_category = '1744';
						        break;
						    case 81:
						        $id_category = '1743';
						        break;
						    case 75:
						        $id_category = '1742';
						        break;
						    case 70:
						        $id_category = '1741';
						        break;
						    case 64:
						        $id_category = '1740';
						        break;
						    case 62:
						        $id_category = '1739';
						        break;
						    case 61:
						        $id_category = '1738';
						        break;
						    case 60:
						        $id_category = '1737';
						        break;
						    case 59:
						        $id_category = '1735';
						        break;
						    case 58:
						        $id_category = '1736';
						        break;
						    default:
								$id_category = $site['id_category'];
							break;
						}
						echo $row, " - Значение для парсинга <br />";
						if(!$product = $Parser->presto($row)){
							continue;
						}
					}
					break;
			
				default:
					# code...
					break;
			}
				
				// echo $id_supplier, "<br />";
				// echo $id_category, "<br />";
				// echo $product['sup_comment'], "<br />";
				// echo $product['name'], "<br />";
				// echo $product['price_mopt_otpusk'], "<br />";
				// echo $product['price_opt_otpusk'], "<br />";
				// echo $product['descr'], "<br />";
				// echo $product['active'], "<br />";
				// echo count($product['specs'] , COUNT_RECURSIVE), "<br />","<br />";
				// echo count($product['images'], COUNT_RECURSIVE), "<br />";
				// foreach ($product['images'] as $value) {
				// 	echo "<pre>";
				// 	print_r($value);
				// 	echo "</pre>";
				// }
					// if(!$product || $skipped){
					// 	print_r('<pre>НЕТ. Товар пропущен</pre>');
					// 	$i++;
					// 	continue;
					// }else{
					// 	print_r('<pre>OK. Товар добавлен</pre>');
					// 	$d++;
					// }
			
					// echo $row, "<br />";
			 //die();

			// Добавляем новый товар в БД
			if(!$product || $skipped){
				echo $row, "Добавляем новый товар в БД     -      Товар пропущен <br />";
				$i++;
				continue;
			}elseif($id_product = $Products->AddProduct($product)){
				// Добавляем характеристики новому товару
				if(!empty($product['specs'])){
					foreach($product['specs'] as $specification){
						$Specification->AddSpecToProd($specification, $id_product);
					}
				}
				// Формируем массив записи ассортимента
				$assort = array(
					'id_assortiment' => false,
					'id_supplier' => $id_supplier,
					'id_product' => $id_product,
					'price_opt_otpusk' => $product['price_opt_otpusk'],
					'price_mopt_otpusk' => $product['price_mopt_otpusk'],
					'active' => 1,
					'inusd' => 0,
					'sup_comment' => $product['sup_comment']
				);
				// Добавляем зпись в ассортимент
				$Products->AddToAssortWithAdm($assort);
				// Получаем артикул нового товара
				$article = $Products->GetArtByID($id_product);
				// Переименовываем фото товара
				$to_resize = $images_arr = array();
				if(isset($product['images']) && !empty($product['images'])){
					foreach($product['images'] as $key=>$image){
						$to_resize[] = $newname = $article['art'].($key == 0?'':'-'.$key).'.jpg';
						$file = pathinfo(str_replace('/'.str_replace($GLOBALS['PATH_global_root'], '', $GLOBALS['PATH_product_img']), '', $image));
						$path = $GLOBALS['PATH_product_img'].trim($file['dirname']).'/';
						$images_arr[] = str_replace($file['basename'], $newname, $image);
						rename($path.$file['basename'], $path.$newname);
					}
					//Проверяем ширину и высоту загруженных изображений, и если какой-либо из показателей выше 1000px, уменяьшаем размер
					foreach($images_arr as $filename){
						$file = $GLOBALS['PATH_product_img'].str_replace('/'.str_replace($GLOBALS['PATH_global_root'], '', $GLOBALS['PATH_product_img']), '', $filename);
						$size = getimagesize($file);
						// $size = getimagesize($path.$filename); //Получаем ширину, высоту, тип картинки
						$width = $size[0];
						$height = $size[1];
						if($size[0] > 1000 || $size[1] > 1000){
							$ratio = $size[0]/$size[1]; //коэфициент соотношения сторон
							//Определяем размеры нового изображения
							if(max($size[0], $size[1]) == $size[0]){
								$width = 1000;
								$height = 1000 / $ratio;
							}elseif(max($size[0], $size[1]) == $size[1]){
								$width = 1000*$ratio;
								$height = 1000;
							}
						}
						$res = imagecreatetruecolor($width, $height);
						imagefill($res, 0, 0, imagecolorallocate($res, 255, 255, 255));
						$src = $size['mime'] == 'image/jpeg'?imagecreatefromjpeg($file):imagecreatefrompng($file);
						// Добавляем логотип в нижний правый угол
						imagecopyresampled($res, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
							$stamp = imagecreatefrompng($GLOBALS['PATH_global_root'].'images/watermark_colored.png');
							$k = imagesy($stamp)/imagesx($stamp);
							$widthstamp = imagesx($res)*0.3;
							$heightstamp = $widthstamp*$k;
							imagecopyresampled($res, $stamp, imagesx($res) - $widthstamp, imagesy($res) - $heightstamp, 0, 0, $widthstamp, $heightstamp, imagesx($stamp), imagesy($stamp));
						imagejpeg($res, $file);
					}
					$Images->resize(false, $to_resize);
					// Привязываем новые фото к товару в БД
					$Products->UpdatePhoto($id_product, $images_arr, $product['images_visible']);
				}
				// Добавляем товар в категорию
				$Products->UpdateProductCategories($id_product, array($id_category), $arr['main_category']);

				$skipped = false;
				$d++;
			}else{
				echo "Проблема с добавлением продукта <br />";
				$d++;
			}
				
		}
		else{//Тестовое условие
			die();
		}
		
	}
	print_r('<pre>товарів додано: '.$d.'</pre>');
	print_r('<pre>товарів не вдалося додати: '.$l.'</pre>');
	print_r('<pre>товарів пропущено: '.$i.'</pre>');
	ini_set('memory_limit', '192M');
	ini_set('max_execution_time', 30);
}

//Парсинги по xml URL----------------------------------------------------------
//-------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------


if(isset($_POST['parse_URL'])){
	echo "Зашли в parse_URL";
	print_r('<pre>');
	print_r($_POST);
	print_r('</pre>');
	$l = $d = $i = $ldi = $ldiK = 0;

	$Parser->SetFieldsById($_POST['site']);
	$site = $Parser->fields;
	if($site['id_supplier'] == NULL){
		echo "Не выбран поставщик для товара";
		die();
	}
	$id_supplier = $site['id_supplier'];
	if($site['id_category'] == NULL){
		echo "Не выбрана категория для товара";
		die();
	}
	$id_category = $site['id_category'];

	//захолдим в индивидуальные настройки 
	switch ($_POST['site']){
		case 21:
			echo "зашли в case 21 (NewLine_XML) <br />";
//Устанавливаем настройки памяти
echo "memory_limit ", ini_get('memory_limit'), "<br />";
ini_set('memory_limit', '3024M');	
echo "memory_limit ", ini_get('memory_limit'), "<br />";
//Устанавливаем настройки времени
echo "max_execution_time ", ini_get('max_execution_time'), "<br />";
ini_set('max_execution_time', 6000);
echo "max_execution_time ", ini_get('max_execution_time'), "<br />";

ini_set('display_errors','on');
ini_set('error_reporting',E_ALL);
set_time_limit(0);
			//Открываем файл
			// if (!$sim_url = simplexml_load_file("https://www.nl.ua/export_files/Kharkov.xml")){
			// 	echo "Не удалось открыть файл<br />\n";
			// 	die();
			// }
			// echo "Файл загружен <br />";



// function start_element($parser, $element_name, $element_attrs) {
//   switch ($element_name) {
//     case 'KEYWORDS':
//        echo '<h1>Keywords</h1><ul>';
//        break;
//     case 'KEYWORD':
//        echo '<li>';
//        break;
//   }
// }
 
// function end_element($parser, $element_name) {
//   switch ($element_name) {
//     case 'KEYWORDS':
//        echo '</ul>';
//        break;
//     case 'KEYWORD':
//        echo '</li>';
//        break;
//   }
// }
 
 
// function character_data($parser, $data) {
//   echo htmlentities($data);
// }
 
// $parser = xml_parser_create();
// xml_set_element_handler($parser, 'start_element', 'end_element');
// xml_set_character_data_handler($parser, 'character_data');
 
// $fp = fopen('https://www.nl.ua/export_files/Kharkov.xml', 'r') or die ("Не удалось открыть файл!");
     
     
// while ($data = fread($fp, 4096)) {
//   xml_parse($parser, $data, feof($fp)) or
//     die(sprintf('XML ERROR: %s at line %d',
//         xml_error_string(xml_get_error_code($parser)),
//         xml_get_current_line_number($parser)));
// }
 
 
// xml_parser_free($parser); 		



	// print_r('<pre>');
	// print_r($GLOBALS);
	// print_r('</pre>');



//Открываем локальный файл 

			echo $GLOBALS['PATH_product_img'].'Kharkov.xml',"<br />";
			$html = $GLOBALS['PATH_product_img'].'Kharkov.xml';

			ini_set("max_execution_time", "6000");
			if (!$sim_url = simplexml_load_file($html)){
				echo "Не удалось открыть файл<br />\n";
				die();
			}
			echo "Файл загружен <br/>";
					ob_end_clean();
					ob_implicit_flush(1);

// die();	
			// выбераем имеющиеся у нас артикул
			$supcomments = $Products->GetSupComments($id_supplier);
			if(is_array($supcomments)){
				$supcomments = array_unique($supcomments);
			}
			echo 'Загрузили в масив асортимент ', count($supcomments, COUNT_RECURSIVE), "<br />","<br />";
			ob_end_clean();
			ob_implicit_flush(1);
			
			if(!$supcomments){
				echo "Массив загруженых товаров поставщика пуст<br />";
				continue;
			}
			echo "ОК <br/>";
			ob_end_clean();
			ob_implicit_flush(1);

// die();
			//создаем масивы соотметствия категорий
			$keys_NL = array(5819, 5834, 5840, 5977, 5995, 5997, 5999, 6001, 6002, 6004, 6005, 6007, 6009, 6011, 6013, 6014, 6015, 6016, 6017, 6018, 6020, 6021, 6022, 6023, 6024, 6028, 6032, 6033, 6034, 6036, 6039, 6040, 6041, 6042, 6044, 6045, 6047, 6048, 6050, 6051, 6052, 6053, 6054, 6055, 6056, 6057, 6058, 6059, 6060, 6061, 6062, 6063, 6064, 6066, 6067, 6068, 6069, 6070, 6071, 6072, 6073, 6075, 6076, 6078, 6080, 6081, 6082, 6083, 6084, 6085, 6086, 6088, 6089, 6090, 6091, 6092, 6093, 6094, 6095, 6096, 6097, 6098, 6099, 6100, 6101, 6102, 6103, 6104, 6105, 6106, 6107, 6108, 6109, 6110, 6111, 6112, 6113, 6114, 6115, 6116, 6117, 6118, 6119, 6120, 6121, 6122, 6123, 6124, 6125, 6126, 6127, 6128, 6130, 6131, 6132, 6133, 6134, 6135, 6136, 6137, 6138, 6139, 6140, 6143, 6144, 6145, 6146, 6147, 6148, 6149, 6150, 6151, 6152, 6153, 6154, 6155, 6156, 6157, 6158, 6159, 6160, 6161, 6162, 6163, 6164, 6165, 6166, 6167, 6168, 6169, 6170, 6171, 6172, 6173, 6174, 6175, 6176, 6177, 6178, 6179, 6180, 6181, 6182, 6183, 6184, 6185, 6186, 6187, 6189, 6190, 6191, 6192, 6193, 6194, 6195, 6196, 6197, 6198, 6199, 6200, 6201, 6202, 6203, 6204, 6206, 6207, 6209, 6213, 6217, 6220, 6224, 6231, 6234, 6235, 6236, 6237, 6238, 6240, 6243, 6244, 6245, 6246, 6247, 6248, 6249, 6251, 6254, 6256, 6260, 6262, 6263, 6265, 6267, 6268, 6269, 6270, 6271, 6272, 6273, 6274, 6275, 6276, 6285, 6286, 6290, 6293, 6294, 6295, 6296, 6297, 6298, 6303, 6305, 6307, 6309, 6311, 6312, 6313, 6315, 6316, 6317, 6318, 6319, 6321, 6322, 6323, 6324, 6325, 6326, 6327, 6328, 6329, 6330, 6331, 6332, 6334, 6335, 6336, 6337, 6338, 6339, 6340, 6341, 6342, 6343, 6344, 6345, 6346, 6347, 6348, 6349, 6351, 6352, 6354, 6355, 6357, 6358, 6360, 6361, 6362, 6363, 6364, 6365, 6366, 6368, 6369, 6370, 6371, 6372, 6373, 6374, 6375, 6376, 6378, 6379, 6380, 6386, 6388, 6389, 6390, 6391, 6392, 6393, 6395, 6396, 6398, 6399, 6401, 6403, 6405, 6407, 6408, 6409, 6410, 6411, 6412, 6414, 6415, 6417, 6418, 6420, 6421, 6422, 6425, 6426, 6427, 6429, 6430, 6431, 6432, 6433, 6434, 6435, 6436, 6438, 6439, 6442, 6443, 6444, 6445, 6446, 6450, 6451, 6452, 6453, 6455, 6456, 6457, 6460, 6463, 6465, 6469, 6473, 6474, 6478, 6480, 6482, 6483, 6484, 6485, 6486, 6495, 6499, 6500, 6501, 6502, 6506, 6507, 6509, 6510, 6511, 6512, 6513, 6514, 6515, 6517, 6518, 6519, 6520, 6521, 6522, 6523, 6524, 6525, 6526, 6527, 6528, 6529, 6530, 6531, 6532, 6536, 6538, 6540, 6541, 6542, 6543, 6544, 6546, 6547, 6550, 6552, 6553, 6554, 6555, 6556, 6557, 6558, 6561, 6562, 6563, 6564, 6565, 6566, 6567, 6571, 6572, 6574, 6575, 6581, 6582, 6583, 6584, 6586, 6588, 6589, 6590, 6592, 6593, 6594, 6595, 6596, 6599, 6600, 6601, 6602, 6604, 6606, 6607, 6611, 6612, 6614, 6616, 6617, 6618, 6619, 6620, 6625, 6627, 6630, 6631, 6632, 6633, 6635, 6636, 6637, 6638, 6640, 6641, 6642, 6644, 6645, 6646, 6647, 6648, 6649, 6651, 6652, 6653, 6654, 6656, 6657, 6658, 6659, 6666, 6670, 6672, 6674, 6676, 6677, 6678, 6679, 6680, 6682, 6683, 6684, 6685, 6686, 6687, 6688, 6689, 6690, 6691, 6692, 6694, 6695, 6696, 6701, 6704, 6706, 6708, 6712, 6713, 6715, 6720, 6722, 6723, 6726, 6727, 6730, 6731, 6732, 6733, 6734, 6737, 6738, 6740, 6742, 6743, 6744, 6746, 6749, 6750, 6752, 6753, 6754, 6755, 6756, 6757, 6758, 6759, 6760, 6761, 6762, 6763, 6764, 6765, 6769, 6771, 6772, 6774, 6775, 6776, 6777, 6778, 6779, 6783, 6784, 6785, 6786, 6787, 6788, 6789, 6790, 6791, 6793, 6794, 6795, 6797, 6800, 6805, 6806, 6807, 6808, 6809, 6810, 6811, 6812, 6813, 6814, 6815, 6816, 6817, 6828, 6829, 6830, 6831, 6832, 6833, 6834, 6835, 6840, 6842, 6843, 6844, 6845, 6846, 6848, 6849, 6850, 6851, 6852, 6853, 6854, 6855, 6856, 6857, 6858, 6859, 6860, 6861, 6862, 6863, 6864, 6865, 6866, 6867, 6868, 6869, 6870, 6872, 6873, 6874, 6875, 6876, 7990, 7992, 7996, 7997, 8001, 8002, 8007, 8017, 8019, 8021, 8022, 8023, 8027, 8028, 8029, 8030, 8031, 8032, 8034, 8035, 8044, 8045, 8056, 8060, 8062, 8063, 8069, 8070, 8074, 8075, 8076, 8083, 8088, 8089, 8102, 8103, 8107, 8111, 8112, 8113, 8114, 8130, 8134, 8135, 8145, 8147, 8148, 8161, 8163, 8179, 8183, 8191, 8193, 8203, 8205, 8206, 8210, 8212, 8215, 8216, 8218, 8219, 8220, 9166, 9178, 9192, 9197, 9330, 9589, 10043, 10048, 10049, 10098, 10302, 10338, 10350, 10352, 10357, 10358, 10359, 10360, 10362, 10367, 10368, 10370, 10371, 10372, 10373, 10375, 10376, 10378, 10379, 10380, 10384, 10388, 10395, 10411, 10416, 10427, 10431, 10432, 10596, 10597, 10608, 10670, 11024, 11592, 11601, 11602, 11617, 11618, 11619, 11652, 11660, 11664, 11665, 11666, 11749, 11755, 11815, 11816, 11817, 11818, 11819, 12164, 12166, 12167, 12171, 12187, 12194, 12228, 12271, 12397, 12398, 12399, 12400, 12480, 12481, 12498, 12520, 12534, 12539, 12712, 12714, 12718, 12987, 12990, 13063, 13659, 13666, 13671, 13672, 13680, 13682, 13683, 13692, 13694, 13697, 13699, 13704, 13707, 13710, 13712, 13713, 13723, 13730, 13733, 13735, 13738, 13749, 13750, 13752, 13756, 13758, 13762, 13765, 13768, 13770, 13772, 13773, 13778, 13780, 13784, 13786, 13788, 13793, 13796, 13799, 13800, 13803, 13805, 13806, 13809, 13813, 13816, 13821, 13823, 13825, 13827, 13829, 13830, 13832, 13835, 13845, 13847, 13849, 13855, 13857, 13858, 13863, 13865, 13866, 13869, 13872, 13874, 13876, 13878, 13880, 13891, 13892, 13896, 13898, 13900, 13902, 13904, 13913, 13914, 13923, 13924, 13927, 13928, 13930, 13932, 13934, 13936, 13939, 13941, 13956, 13958, 13960, 13964, 13965, 13968, 13969, 13971, 13974, 13977, 13979, 13985, 13989, 13991, 13995, 14002, 14008, 14010, 14015, 14017, 14019, 14023, 14027, 14029, 14037, 14041, 14070, 14071, 14072, 14073, 14074, 14075, 14077, 14078, 14079, 14080, 14081, 14082, 14084, 14085, 14086, 14087, 14089, 14090, 14091, 14094, 14096, 14097, 14099, 14101, 14104, 14105, 14113, 14115, 14118, 14126, 14127, 14132, 14134, 14136, 14137, 14140, 14142, 14144, 14145, 14151, 14153, 14155, 14157, 14161, 14163, 14165, 14167, 14169, 14171, 14172, 14173, 14174, 14175, 14176, 14177, 14178, 14179, 14180, 14181, 14182, 14183, 14184, 14185, 14186, 14187, 14189, 14191, 14193, 14194, 14200, 14202, 14204, 14209, 14210, 14212, 14215, 14217, 14219, 14221, 14223, 14225, 14227, 14229, 14233, 14235, 14237, 14241, 14243, 14249, 14252, 14255, 14258, 14260, 14262, 14264, 14268, 14270, 14272, 14275, 14290, 14292, 14294, 14310, 14320, 14322, 14332, 14338, 14346, 14348, 14356, 14364, 14366, 14369, 14371, 14373, 14374, 14377, 14378, 14380, 14382, 14384, 14386, 14390, 14396, 14398, 14400, 14402, 14415, 14419);
			$values_XT = array(675, 675, 1067, 1009, 1790, 1790, 1006, 1790, 1790, 1790, 1790, 1790, 1790, 1790, 1790, 1790, 1790, 1006, 1790, 1790, 1006, 1192, 1405, 1006, 1006, 632, 948, 945, 1343, 1697, 1737, 1439, 951, 1749, 921, 957, 1411, 949, 1457, 1458, 1323, 920, 1714, 1419, 940, 1749, 922, 1697, 939, 950, 1011, 1749, 935, 1465, 1012, 1199, 1697, 941, 1463, 632, 923, 940, 939, 1564, 1442, 1697, 1434, 937, 635, 1210, 931, 934, 1395, 1211, 1438, 938, 1419, 635, 1419, 1419, 635, 1677, 1439, 1438, 1419, 946, 679, 953, 1445, 940, 1445, 635, 1463, 1419, 924, 1411, 918, 635, 1410, 632, 933, 1419, 930, 1205, 632, 831, 1749, 1564, 940, 632, 1403, 1395, 1463, 1697, 1460, 941, 1435, 946, 946, 1697, 1178, 1012, 1419, 941, 1697, 1448, 1419, 1436, 1564, 1697, 1456, 1697, 940, 946, 1697, 1175, 945, 1459, 952, 1697, 1474, 954, 946, 781, 935, 679, 940, 1697, 1697, 1418, 946, 935, 677, 1412, 1419, 915, 634, 677, 950, 1564, 632, 940, 940, 743, 1347, 940, 928, 1474, 941, 1465, 1221, 1447, 1697, 1440, 1474, 1697, 1448, 1463, 1419, 1697, 940, 1419, 947, 1389, 601, 978, 1419, 944, 961, 944, 903, 961, 901, 900, 1796, 903, 902, 1794, 634, 1795, 1797, 1797, 1794, 908, 910, 961, 1503, 909, 1382, 1794, 1794, 957, 639, 1796, 1796, 1796, 1796, 1796, 1796, 944, 944, 944, 961, 961, 1382, 634, 568, 903, 955, 1004, 953, 1786, 919, 1006, 1787, 917, 917, 917, 912, 912, 914, 1787, 912, 918, 912, 1340, 1344, 912, 917, 917, 1726, 912, 1344, 1787, 1787, 964, 912, 912, 914, 964, 1726, 912, 796, 1787, 912, 915, 917, 1726, 1726, 919, 1344, 1726, 1344, 1785, 917, 912, 1785, 1785, 1344, 1785, 1344, 1787, 1787, 917, 1786, 1786, 1786, 1785, 1726, 1344, 912, 1787, 917, 1113, 1113, 912, 1209, 896, 1684, 1201, 1208, 1204, 1325, 1557, 1199, 1666, 1205, 1629, 1325, 1217, 1591, 1201, 1200, 1623, 1325, 1578, 1198, 1624, 1325, 1622, 1532, 1211, 1602, 1197, 1325, 1616, 1581, 1611, 1618, 1572, 1566, 1325, 1202, 1599, 1201, 1203, 1593, 1707, 1575, 1207, 1204, 1654, 1593, 1620, 1626, 1623, 1063, 1214, 1568, 1619, 1565, 1209, 1201, 1641, 1648, 1692, 1325, 1192, 1325, 1196, 1325, 1594, 772, 1647, 1559, 1682, 990, 1006, 1476, 1783, 980, 1782, 980, 967, 1476, 1782, 1385, 1422, 970, 1422, 1782, 1476, 1782, 1782, 1476, 975, 975, 975, 975, 1215, 1112, 997, 1000, 998, 997, 998, 997, 1000, 1001, 997, 995, 995, 1000, 1193, 995, 1075, 1075, 1003, 995, 1403, 998, 998, 1598, 1001, 995, 994, 995, 995, 1075, 1192, 998, 1000, 999, 995, 999, 1192, 1194, 997, 1383, 1192, 997, 1553, 997, 1001, 1001, 1193, 1001, 1001, 1749, 1784, 1784, 1071, 1082, 1071, 1172, 1784, 1076, 1075, 1070, 1070, 1784, 1662, 1784, 1074, 1662, 1076, 1784, 1784, 1784, 1784, 1130, 728, 1076, 967, 1212, 970, 1073, 1073, 1142, 1662, 1070, 1070, 1076, 1076, 1081, 1793, 1287, 1171, 1791, 1178, 1425, 1793, 640, 1792, 629, 1472, 1426, 1793, 1171, 1792, 1428, 1179, 1184, 1792, 1187, 1186, 1185, 1088, 1227, 1139, 1141, 1057, 1088, 759, 1057, 1088, 1712, 816, 1446, 1102, 1137, 1125, 1089, 1057, 1133, 1125, 1066, 1138, 1550, 1057, 1005, 1057, 1709, 1095, 1139, 1008, 1125, 1098, 1646, 1057, 1057, 1131, 1111, 1230, 1305, 1105, 1120, 1426, 1381, 771, 1415, 1415, 1415, 1415, 1415, 1415, 1246, 1555, 1555, 1555, 1732, 1243, 1245, 1555, 1555, 1244, 1241, 1243, 1101, 1288, 1058, 1057, 1054, 1055, 722, 1053, 1057, 1057, 1057, 891, 1429, 679, 1429, 1133, 873, 1135, 1134, 1007, 1135, 1125, 1125, 990, 987, 987, 987, 991, 987, 987, 990, 990, 987, 990, 990, 987, 987, 987, 990, 987, 991, 987, 987, 990, 987, 1104, 989, 991, 987, 991, 987, 987, 990, 990, 987, 987, 990, 1788, 1009, 1789, 1788, 1789, 1789, 1788, 1789, 1789, 1788, 1788, 1789, 1789, 1788, 1789, 1788, 1788, 1009, 1788, 1789, 1789, 1789, 1789, 1789, 1789, 1789, 1789, 1789, 1789, 1788, 1788, 1788, 1788, 1788, 1788, 1788, 1789, 1788, 1788, 1788, 1788, 1788, 1788, 1788, 1788, 1788, 1788, 1788, 1788, 1788, 1788, 1788, 1788, 1789, 1789, 1789, 1789, 1789, 1009, 1009, 1009, 1009, 1009, 1790, 1006, 990, 988, 1195, 1403, 1796, 679, 1192, 903, 679, 1182, 1190, 1189, 1792, 1171, 1325, 1792, 1793, 1427, 1183, 1179, 1792, 638, 638, 1180, 1183, 1186, 1186, 1792, 1426, 1426, 1784, 1103, 1075, 1426, 961, 633, 925, 1205, 1485, 1676, 1782, 679, 679, 679, 1216, 679, 1565, 1568, 679, 679, 1593, 679, 679, 1009, 1786, 1456, 1697, 995, 988, 941, 634, 1677, 1114, 1082, 1662, 1075, 1761, 1415, 1230, 1125, 1429, 1788, 1788, 1789, 1789, 1789, 1788, 1788, 1788, 1789, 1788, 1788, 997, 1789, 1788, 1788, 1788, 1789, 1789, 1788, 1788, 1788, 1788, 1788, 1788, 1789, 1788, 1003, 1003, 1125, 1788, 1788, 1788, 1789, 1481, 1785, 1788, 917, 1426, 1789, 1009, 629, 1788, 1789, 1789, 1788, 1788, 1788, 1788, 1788, 1788, 1344, 1114, 1171, 952, 1736, 1023, 1789, 1697, 1789, 945, 917, 1697, 1697, 1004, 1697, 1697, 1108, 990, 1357, 1381, 1788, 1788, 1788, 1788, 1788, 1788, 1789, 1788, 1789, 1788, 1788, 1789, 1789, 1789, 1789, 1789, 1789, 1789, 1788, 1789, 1789, 1788, 1789, 1073, 1789, 1789, 1789, 1788, 1789, 1787, 978, 1081, 1789, 1789, 970, 1788, 1077, 970, 1788, 970, 1789, 1788, 1789, 1788, 1788, 1789, 1068, 1313, 1131, 1788, 1789, 1788, 1788, 1788, 1788, 1789, 1789, 1380, 1380, 1380, 1380, 1380, 1380, 1380, 560, 1380, 1380, 1380, 1380, 1380, 1380, 1380, 1380, 1380, 1380, 679, 679, 1380, 1788, 1788, 1789, 607, 1789, 1789, 1325, 1111, 603, 1788, 1325, 1112, 1253, 1057, 1074, 832, 1446, 1789, 1789, 1789, 1789, 1788, 1788, 1788, 1789, 1789, 1789, 1472, 1716, 1713, 1714, 1714, 1714, 1714, 1713, 1714, 1713, 1714, 1714, 1713, 1713, 1714, 1713, 1789, 1788, 1789, 891, 1789, 1789, 1788, 1789, 1788, 1789, 1788, 1788, 1789, 1789, 1789, 1788, 1788, 1788, 1788, 1788, 1788, 1789, 1788, 1789, 1788, 1054, 1054, 1788, 1788, 1789, 1789, 1788, 1489, 1788, 1081, 1788, 1788, 1788, 1788, 1789, 1788, 1789, 1789, 1789, 1788, 1070, 1076, 1074, 1125, 1125, 1125, 1782, 1125, 1788, 1788, 1788, 1789, 1788, 1788, 1788, 1788, 1788, 1789, 1788, 1789);
			  $array_cat = array_combine($keys_NL, $values_XT);
				foreach ($array_cat as $key => $value) {
					ob_end_clean();
					ob_implicit_flush(1);
					echo $key, "   ->  ", $value, "<br />";
				 }

				// die();

			  	//vendorCode c ошибками
			// $error_vendorCode = array(90511154,90601164,90601155,31035202,31034348,31043393,31035285,31034456,31034457,31034783,31010710,31030315,31034727,31035744,31030241,31034960,31035656,31035657,31033112,31033141,31034408,31033163,31010917,31009331,31009182,31009610,31009956,31009747,31009719,31253016,31012419,31012859,31005556,31012547,31012920,31047006,70837168,30110072,30101867,30138035,31021463,31021885,31044046,31044047,31003432,31227591,31227595,31227597,31241252,31227594,31227745,31227746,31246183,31222310,40617387,80335841,10843549,10922639,10920157,10927034,10906804,10922620,10924541,10922687,10922685,10924557,10901515,10704282,10704284,10704288,10704286,10704280,10704277,10704279,10704293,51333094,51333205,51333044,51333092,51333095,51333206,51333118,51333119,51333120,80132359,80213729,60306687,60306688,60306689,60611545,60611548,60611549,60611550,60611551,60611555,60611556,60611558,60611559,60611560,60611562,60611563,60611564,60611565,60611569,80128191,0128153,60802989,60809689,60814219,60814626,10316609,20535278);


			// $supcomments = array_merge ($supcomments, $error_vendorCode);

				//можем просмотреть список  кодов товара и цен
			 	  $array_offer  =  array();
				foreach ($sim_url->xpath('/yml_catalog/shop') as $element) {
					foreach ($element->xpath('offers/offer') as $offer) {
					ob_end_clean();
					ob_implicit_flush(1);
						// echo $offer->vendorCode, " : ", $offer->price, "<br />";
						if(in_array($offer->categoryId, $keys_NL) && !in_array($offer->vendorCode, $supcomments) && $ldiK < $_POST['num']){
							echo $offer->vendorCode, "<br />";
							array_push($array_offer, $offer);
							$ldiK++;
							}
					}
				}
				echo "Количество товаров в файле ", count($array_offer, COUNT_RECURSIVE), "<br />";
			

				
					// die();
				// sleep(5);

			foreach ($array_offer as $offer) {
					ob_end_clean();
					ob_implicit_flush(1);
					//Определяем категорию карточки товара на xt.ua
				foreach($array_cat as $k=>$value){
					if ($k == $offer->categoryId){
						$id_category = $value;
					 	break;
					}
					  
				}
				// echo $offer->categoryId, ' -> ', $id_category,  "<br />";
				// echo 'поставщик ', $id_supplier, "<br />";


				if(!$product = $Parser->NewLine_XML($offer)){
					continue;
				}
				
				// Добавляем новый товар в БД
						if(!$product){
							echo "Товар пропущен product пустой<br />";
							$i++;
							continue;
						}elseif($id_product = $Products->AddProduct($product)){
							// array_push($supcomments, trim($offer->vendorCode));
							print_r('<pre>OK, product added</pre>');
							
							// Добавляем характеристики новому товару
							if(!empty($product['specs'])){
								foreach($product['specs'] as $specification){
									$Specification->AddSpecToProd($specification, $id_product);
								}
							}
							// Формируем массив записи ассортимента
							$assort = array(
								'id_assortiment' => false,
								'id_supplier' => $id_supplier,
								'id_product' => $id_product,
								'price_opt_otpusk' => $product['price_opt_otpusk'],
								'price_mopt_otpusk' => $product['price_mopt_otpusk'],
								'active' => 1,
								'inusd' => 0,
								'sup_comment' => $product['sup_comment']
							);
							// Добавляем зпись в ассортимент
							$Products->AddToAssortWithAdm($assort);
							// Получаем артикул нового товара
							$article = $Products->GetArtByID($id_product);
							// Переименовываем фото товара
							$to_resize = $images_arr = array();
							if(isset($product['images']) && !empty($product['images'])){
								foreach($product['images'] as $key=>$image){
									$to_resize[] = $newname = $article['art'].($key == 0?'':'-'.$key).'.jpg';
									$file = pathinfo(str_replace('/'.str_replace($GLOBALS['PATH_global_root'], '', $GLOBALS['PATH_product_img']), '', $image));
									$path = $GLOBALS['PATH_product_img'].trim($file['dirname']).'/';
									$images_arr[] = str_replace($file['basename'], $newname, $image);
									rename($path.$file['basename'], $path.$newname);
								}
								//Проверяем ширину и высоту загруженных изображений, и если какой-либо из показателей выше 1000px, уменяьшаем размер
								foreach($images_arr as $filename){
									$file = $GLOBALS['PATH_product_img'].str_replace('/'.str_replace($GLOBALS['PATH_global_root'], '', $GLOBALS['PATH_product_img']), '', $filename);
									$size = getimagesize($file);
									// $size = getimagesize($path.$filename); //Получаем ширину, высоту, тип картинки
									$width = $size[0];
									$height = $size[1];
									if($size[0] > 1000 || $size[1] > 1000){
										$ratio = $size[0]/$size[1]; //коэфициент соотношения сторон
										//Определяем размеры нового изображения
										if(max($size[0], $size[1]) == $size[0]){
											$width = 1000;
											$height = 1000 / $ratio;
										}elseif(max($size[0], $size[1]) == $size[1]){
											$width = 1000*$ratio;
											$height = 1000;
										}
									}
									$res = imagecreatetruecolor($width, $height);
									imagefill($res, 0, 0, imagecolorallocate($res, 255, 255, 255));
									$src = $size['mime'] == 'image/jpeg'?imagecreatefromjpeg($file):imagecreatefrompng($file);
									// Добавляем логотип в нижний правый угол
									imagecopyresampled($res, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
										$stamp = imagecreatefrompng($GLOBALS['PATH_global_root'].'images/watermark_colored.png');
										$k = imagesy($stamp)/imagesx($stamp);
										$widthstamp = imagesx($res)*0.3;
										$heightstamp = $widthstamp*$k;
										imagecopyresampled($res, $stamp, imagesx($res) - $widthstamp, imagesy($res) - $heightstamp, 0, 0, $widthstamp, $heightstamp, imagesx($stamp), imagesy($stamp));
									imagejpeg($res, $file);
									 // sleep(2);
								}
								$Images->resize(false, $to_resize);
								// Привязываем новые фото к товару в БД
								$Products->UpdatePhoto($id_product, $images_arr, $product['images_visible']);
							}
							// Добавляем товар в категорию
							$Products->UpdateProductCategories($id_product, array($id_category));//, $arr['main_category']

						}else{
							echo "Проблема с добавлением продукта <br /><br />";
							$l++;
						}
			}
		break;
		case 23:
			echo "зашли в case 23 <br />";
			// Проверка_URL
			
			if ($sim_url = simplexml_load_file('http://bluzka.ua/ru/yml/')){
				echo "Файл загружен <br />";

				//Устанавливаем настройки времени
				// $asd = array();
				foreach ($sim_url->xpath('/yml_catalog/shop') as $element) {
					foreach ($element->xpath('offers/offer') as $offer) {
						ini_set('max_execution_time', 3000);
						unset($to_resize);
						unset($images_arr);
						unset($article);
						unset($assort);
						unset($product);
						unset($skipped);
					
					// foreach($offer->vendorCode as $value){
					// 	echo $value, "<br />";
					// 	array_push($asd, trim($value));	
					// }
					// echo 'итого ', count($asd , COUNT_RECURSIVE), "<br />";
					// break;

						$skipped = false;

						// if(!empty($supcomments) && in_array(trim($offer->vendorCode), $supcomments)){
						// 	$skipped = true;
						// 	continue;
						// }else{	
							//проверяем наличие картинки
							// if(file_exists($offer->picture)){
							// 	continue;
							// }
							//парсим товар 
							// $product = array();
							if(!$product = $Parser->bluzka($offer)){
								continue;
							}
											
				echo $id_supplier, "<br />";
				echo $id_category, "<br />";
				echo $product['sup_comment'], "<br />";
				echo $product['name'], "<br />";
				echo $product['price_mopt_otpusk'], "<br />";
				echo $product['price_opt_otpusk'], "<br />";
				echo $product['descr'], "<br />";
				echo $product['active'], "<br />";
				echo count($product['specs'] , COUNT_RECURSIVE), "<br />","<br />";
				echo count($product['images'], COUNT_RECURSIVE), "<br />";
				foreach ($product['images'] as $value) {
					echo "<pre>";
					print_r($value);
					echo "</pre>";
				}
					if(!$product || $skipped){
						print_r('<pre>НЕТ. Товар пропущен</pre>');
						$i++;
						continue;
					}else{
						print_r('<pre>OK. Товар добавлен</pre>');
						$d++;
					}
		
			 
							//Определяем категорию
							switch ($offer->categoryId) {
							    case 395:
							        $id_category = '1751';
							        break;
							    case 293:
							        $id_category = '1752';
							        break;
							    case 299:
							        $id_category = '1753';
							        break;
							    case 381:
							        $id_category = '1754';
							        break;
							    case 301:
							        $id_category = '1755';
							        break;
							    case 300:
							        $id_category = '1756';
							        break;
							    case 463:
							        $id_category = '1757';
							        break;
							    case 396:
							        $id_category = '1758';
							        break;
							    case 351:
							        $id_category = '1759';
							        break;
							    case 338:
							        $id_category = '1760';
							        break;
							    case 404:
							        $id_category = '1761';
							        break;
							    case 380:
							        $id_category = '1762';
							        break;
							    case 288:
							        $id_category = '1763';
							        break;
							    case 289:
							        $id_category = '1764';
							        break;
							    case 290:
							        $id_category = '1765';
							        break;
							    case 291:
							        $id_category = '1766';
							        break;
							    case 382:
							        $id_category = '1767';
							        break;
							    case 328:
							        $id_category = '1767';
							        break;
							    case 304:
							        $id_category = '1767';
							        break;
							   case 303:
							        $id_category = '1768';
							        break;
							    case 302:
							        $id_category = '1769';
							        break;
							    case 448:
							        $id_category = '1770';
							        break;
							    case 329:
							        $id_category = '1771';
							        break;
							    case 296:
							        $id_category = '1772';
							        break;
							    case 295:
							        $id_category = '1773';
							        break;
							    case 294:
							        $id_category = '1774';
							        break;
							    case 292:
							        $id_category = '1775';
							        break;
							    case 297:
							        $id_category = '1776';
							        break;
							    case 298:
							        $id_category = '1777';
							        break;
							    case 287:
							        $id_category = '1778';
							        break;
							    case 285:
							        $id_category = '1779';
							        break;
							    case 286:
							        $id_category = '1780';
							        break;
							    default:
									$id_category = $site['id_category'];
								break;
							}
					echo 'категория ', $id_category, "<br />";
							$d++;
						// }
							// die();
						// Добавляем новый товар в БД
						if(!$product || $skipped){
							echo "Товар пропущен product пустой<br />";
							$i++;
							continue;
						}elseif($id_product = $Products->AddProduct($product)){
							// array_push($supcomments, trim($offer->vendorCode));
							print_r('<pre>OK, product added</pre>');
							
							// Добавляем характеристики новому товару
							if(!empty($product['specs'])){
								foreach($product['specs'] as $specification){
									$Specification->AddSpecToProd($specification, $id_product);
								}
							}
							// Формируем массив записи ассортимента
							$assort = array(
								'id_assortiment' => false,
								'id_supplier' => $id_supplier,
								'id_product' => $id_product,
								'price_opt_otpusk' => $product['price_opt_otpusk'],
								'price_mopt_otpusk' => $product['price_mopt_otpusk'],
								'active' => 1,
								'inusd' => 0,
								'sup_comment' => $product['sup_comment']
							);
							// Добавляем зпись в ассортимент
							$Products->AddToAssortWithAdm($assort);
							// Получаем артикул нового товара
							$article = $Products->GetArtByID($id_product);
							// Переименовываем фото товара
							$to_resize = $images_arr = array();
							if(isset($product['images']) && !empty($product['images'])){
								foreach($product['images'] as $key=>$image){
									$to_resize[] = $newname = $article['art'].($key == 0?'':'-'.$key).'.jpg';
									$file = pathinfo(str_replace('/'.str_replace($GLOBALS['PATH_global_root'], '', $GLOBALS['PATH_product_img']), '', $image));
									$path = $GLOBALS['PATH_product_img'].trim($file['dirname']).'/';
									$images_arr[] = str_replace($file['basename'], $newname, $image);
									rename($path.$file['basename'], $path.$newname);
								}
								//Проверяем ширину и высоту загруженных изображений, и если какой-либо из показателей выше 1000px, уменяьшаем размер
								foreach($images_arr as $filename){
									$file = $GLOBALS['PATH_product_img'].str_replace('/'.str_replace($GLOBALS['PATH_global_root'], '', $GLOBALS['PATH_product_img']), '', $filename);
									$size = getimagesize($file);
									// $size = getimagesize($path.$filename); //Получаем ширину, высоту, тип картинки
									$width = $size[0];
									$height = $size[1];
									if($size[0] > 1000 || $size[1] > 1000){
										$ratio = $size[0]/$size[1]; //коэфициент соотношения сторон
										//Определяем размеры нового изображения
										if(max($size[0], $size[1]) == $size[0]){
											$width = 1000;
											$height = 1000 / $ratio;
										}elseif(max($size[0], $size[1]) == $size[1]){
											$width = 1000*$ratio;
											$height = 1000;
										}
									}
									$res = imagecreatetruecolor($width, $height);
									imagefill($res, 0, 0, imagecolorallocate($res, 255, 255, 255));
									$src = $size['mime'] == 'image/jpeg'?imagecreatefromjpeg($file):imagecreatefrompng($file);
									// Добавляем логотип в нижний правый угол
									imagecopyresampled($res, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
										$stamp = imagecreatefrompng($GLOBALS['PATH_global_root'].'images/watermark_colored.png');
										$k = imagesy($stamp)/imagesx($stamp);
										$widthstamp = imagesx($res)*0.3;
										$heightstamp = $widthstamp*$k;
										imagecopyresampled($res, $stamp, imagesx($res) - $widthstamp, imagesy($res) - $heightstamp, 0, 0, $widthstamp, $heightstamp, imagesx($stamp), imagesy($stamp));
									imagejpeg($res, $file);
									 // sleep(2);
								}
								$Images->resize(false, $to_resize);
								// Привязываем новые фото к товару в БД
								$Products->UpdatePhoto($id_product, $images_arr, $product['images_visible']);
							}
							// Добавляем товар в категорию
							$Products->UpdateProductCategories($id_product, array($id_category), $arr['main_category']);

						}else{
							echo "Проблема с добавлением продукта <br /><br />";
							$l++;
						}

					// if($d >= $_POST['num']){	
					// 	break;
					// }
					}
				// if($d >= $_POST['num']){	
				// 	break;
				// }
				}
			} else {
			echo "Не удалось открыть файл<br />\n";
			}
		break;
		case 24:
			echo "зашли в case 24 <br />";
			//Открываем файл
			if (!$sim_url = simplexml_load_file('https://zona220.com/export1-xml/Rozetka_UA.xml')){
			echo "Не удалось открыть файл<br />\n";
			die();
			}
			echo "Файл загружен <br />";

			// выбераем имеющиеся у нас артикул
			$supcomments = $Products->GetSupComments($id_supplier);
			if(is_array($supcomments)){
				$supcomments = array_unique($supcomments);
			}
			 echo 'В кабенете поставшика ', count($supcomments, COUNT_RECURSIVE), "<br />","<br />";
			
			// //можем просмотреть список катигорий и список кодов товара
			// 	$array_sup = array();
			// 	foreach ($supcomments as $value) {
			// 			if(!strpos($value, '$')){
			// 				array_push($array_sup, $value);
			// 			}
			// 	}
			// echo 'Загрузили шин ', count($array_sup, COUNT_RECURSIVE), "<br />","<br />";

			// //можем просмотреть список катигорий и список кодов товара
			// $array = array();
			// $array_cat = array();
			// foreach ($sim_url->xpath('/yml_catalog/shop') as $element) {
			// 	foreach ($element->xpath('offers/offer') as $offer) {
			// 		if($offer->categoryId == '554'){
			// 			array_push($array, $offer['id']);
			// 		}
			// 	}
			// }
			// echo "Количество товаров в файле ", count($array, COUNT_RECURSIVE), "<br />";


			// die();


			foreach ($sim_url->xpath('/yml_catalog/shop') as $element) {
				foreach ($element->xpath('offers/offer') as $offer) {
					if($ldi> $_POST['num']){
						die();
					}
					// echo 'Карточка ', $ldi++, "<br />";
					//Устанавливаем настройки времени		
					ini_set('max_execution_time', 120);
					// чистим переменые
					unset($to_resize);
					unset($images_arr);
					unset($article);
					unset($assort);
					unset($product);
					unset($skipped);
					// sleep('5');
					if(!$supcomments){
						echo $offer['id'], ' Массив товаров поставщика пуст', "<br />";
						continue;
						}
					if(in_array(trim($offer['id']), $supcomments)){
						echo $offer['id'], ' Товар есть в базе', "<br />";
						continue;
						}
					if($offer->categoryId != '554'){
						echo $offer['id'], ' Товар не отвечает условиям для загрузки', "<br />";
						continue;
						}

					// die();
					if(!$product = $Parser->zona_XML($offer)){
						continue;
					}
					echo 'id ->', $offer['id'], "<br />";					
					// echo $id_supplier, "<br />";
					// echo $id_category, "<br /><br />";

					// echo $product['sup_comment'], "<br />";
					// echo $product['name'], "<br />";
					// echo $product['price_mopt_otpusk'], "<br />";
					// echo $product['price_opt_otpusk'], "<br />";
					// echo $product['descr'], "<br />";
					// echo $product['active'], "<br />";
					// echo count($product['specs'] , COUNT_RECURSIVE), "<br />","<br />";
					// foreach($product['specs'] as $specification){
					// 	echo "<pre>";
					// 	print_r($Specification);
					// 	echo "</pre>";
					// }
					// echo count($product['images'], COUNT_RECURSIVE), "<br />";
					// foreach ($product['images'] as $value) {
					// 	echo "<pre>";
					// 	print_r($value);
					// 	echo "</pre>";
					// }

			
					// continue;

					// Добавляем новый товар в БД
					if(!$product){
						$i++;	
						echo "product пустой -> Товар пропущен<br />";
						continue;
					}
					if($id_product = $Products->AddProduct($product)){
						$d++;
						print_r('<pre>OK, добавляем товар</pre>');
							// Добавляем характеристики новому товару
							if(!empty($product['specs'])){
								foreach($product['specs'] as $specification){
									$Specification->AddSpecToProd($specification, $id_product);
								}
							}
							// Формируем массив записи ассортимента
							$assort = array(
								'id_assortiment' => false,
								'id_supplier' => $id_supplier,
								'id_product' => $id_product,
								'price_opt_otpusk' => $product['price_opt_otpusk'],
								'price_mopt_otpusk' => $product['price_mopt_otpusk'],
								'active' => 1,
								'inusd' => 0,
								'sup_comment' => $product['sup_comment']
							);
							// Добавляем зпись в ассортимент
							$Products->AddToAssortWithAdm($assort);
							// Получаем артикул нового товара
							$article = $Products->GetArtByID($id_product);
							// Переименовываем фото товара
							$to_resize = $images_arr = array();
							if(isset($product['images']) && !empty($product['images'])){
								foreach($product['images'] as $key=>$image){
									$to_resize[] = $newname = $article['art'].($key == 0?'':'-'.$key).'.jpg';
									$file = pathinfo(str_replace('/'.str_replace($GLOBALS['PATH_global_root'], '', $GLOBALS['PATH_product_img']), '', $image));
									$path = $GLOBALS['PATH_product_img'].trim($file['dirname']).'/';
									$images_arr[] = str_replace($file['basename'], $newname, $image);
									rename($path.$file['basename'], $path.$newname);
								}
								//Проверяем ширину и высоту загруженных изображений, и если какой-либо из показателей выше 1000px, уменяьшаем размер
								foreach($images_arr as $filename){
									$file = $GLOBALS['PATH_product_img'].str_replace('/'.str_replace($GLOBALS['PATH_global_root'], '', $GLOBALS['PATH_product_img']), '', $filename);
									$size = getimagesize($file);
									// $size = getimagesize($path.$filename); //Получаем ширину, высоту, тип картинки
									$width = $size[0];
									$height = $size[1];
									if($size[0] > 1000 || $size[1] > 1000){
										$ratio = $size[0]/$size[1]; //коэфициент соотношения сторон
										//Определяем размеры нового изображения
										if(max($size[0], $size[1]) == $size[0]){
											$width = 1000;
											$height = 1000 / $ratio;
										}elseif(max($size[0], $size[1]) == $size[1]){
											$width = 1000*$ratio;
											$height = 1000;
										}
									}
									$res = imagecreatetruecolor($width, $height);
									imagefill($res, 0, 0, imagecolorallocate($res, 255, 255, 255));
									$src = $size['mime'] == 'image/jpeg'?imagecreatefromjpeg($file):imagecreatefrompng($file);
									// Добавляем логотип в нижний правый угол
									imagecopyresampled($res, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
										$stamp = imagecreatefrompng($GLOBALS['PATH_global_root'].'images/watermark_colored.png');
										$k = imagesy($stamp)/imagesx($stamp);
										$widthstamp = imagesx($res)*0.3;
										$heightstamp = $widthstamp*$k;
										imagecopyresampled($res, $stamp, imagesx($res) - $widthstamp, imagesy($res) - $heightstamp, 0, 0, $widthstamp, $heightstamp, imagesx($stamp), imagesy($stamp));
									imagejpeg($res, $file);
								}
									$Images->resize(false, $to_resize);
								// Привязываем новые фото к товару в БД
								$Products->UpdatePhoto($id_product, $images_arr, $product['images_visible']);
							}
							// Добавляем товар в категорию
							$Products->UpdateProductCategories($id_product, array($id_category), $arr['main_category']);
							array_push($supcomments, trim($offer['id']));
					
							echo 'товар добавлен  ', "<br />";							
							// die();
					}else{
						echo "Проблема с добавлением продукта <br /><br />";
						$l++;
					}
				}
			}

		break;
		default:
			// die();
		break;
	}
	print_r('<pre>Итого обработано: '.$ldi.'</pre>');
	print_r('<pre>товарів додано: '.$d.'</pre>');
	print_r('<pre>товарів не вдалося додати: '.$l.'</pre>');
	print_r('<pre>товарів пропущено: '.$i.'</pre>');
	ini_set('memory_limit', '192M');
	ini_set('max_execution_time', 30);
}


//-----------------------------------------------------------------------
//--------------------------------Парсинги TEST--------------------------
//-----------------------------------------------------------------------

if(isset($_POST['test'])){
	echo "Зашли в test";
	print_r('<pre>');
	print_r($_POST);
	print_r('</pre>');
	// phpinfo();
	//Открываем файл
			// if (!$sim_url = simplexml_load_file("https://www.nl.ua/export_files/Kharkov.xml")){
			// echo "Не удалось открыть файл<br />\n";
			// die();
			// }
			// echo "Файл загружен <br />";


			// 	$array_cat_CT = array();
			// 	$array_prod_CT = array();
			// foreach ($sim_url->xpath('/yml_catalog/shop') as $element) {
			// 	foreach ($element->xpath('offers/offer') as $offer) {
			// 	array_push($array_cat_CT, strval($offer->categoryId));

			// 	// array_push($array_prod_CT, $offer->vendorCode);
				
			// 	}
			// }
			// print_r('<pre>');
			// print_r(array_count_values($array_cat_CT));
			// print_r('</pre>');



			// $array_cat_prod = array_combine($array_cat_CT, $array_prod_CT);
		// foreach ($array_cat_prod ->$key as $value) {
		// 		echo $key, ' -> ', $value "<br/>";
		// }

		// 	$array_cat_CT = array_count_values ($array_cat_CT);

		
			

echo "<br/><br/><br/><br/><br/><br/><br/><br/><br/>";


				while (ob_end_clean()){}; // на всякий случай
					ob_implicit_flush(1);
					echo str_repeat(chr(0), 4096); // IE
					// погнали
					$n = 5;
					while ($n > 0) {
					echo 'text<br />';
					sleep(1);
	 				$n--;
				}


			// die();	 




	// if($html = $Parser->parseUrl('http://bluzka.ua/ru/item/bluzka-1247-1247/')){
	// echo "Зашли на карточку товара <br />";

		// echo '--------------------------------------------<br />';

		// echo  'Ценна: ', $html->find('.js_price_ws', 0)->innertext, "<br />";

		// echo  'Название: ', $html->find('h1', 0)->innertext, "<br />";
		
		// echo '0--------------------------------------------<br />';

		// echo  $html->find('.good-color_size', 0)->children(1), "<br />";

		// echo '1--------------------------------------------<br />';

		// echo  $html->find('.hidden_colors', 0)->plaintext, "<br />";

		// echo '1--------------------------------------------<br />';
		// foreach($html->find('label, input') as $img) {

		// 	if($img->type ==='radio' and $img->name ==='buy[color]'){
		// 	$img = $img->value;
		// 	echo $img ,'<br />';
		// 	}
		// }
		// foreach($html->find('label, span') as $img) {

		// 	$img = $img->plaintext;
		// 	echo $img ,'<br />';
			
		// }
			
		// 	if ($img === 'radio') {
		// 		continue;
		// 	} else {
		// 		echo $img->value ,'<br />';
		// 	}

		

		// echo '2--------------------------------------------<br />';
		// foreach($html->find('span') as $img) {
		// 	echo $img->plaintext  ,'<br />';
		// }

		// echo '3--------------------------------------------<br />';
		// 	foreach($html->find('img') as $img) {
		// 		echo $img->parent(),'<br />';
				
		// 	}
		// echo '4--------------------------------------------<br />';
		// 	foreach($html->find('div[class="slider_vertical"], div[class="item"] ') as $img) {
  					
		// 		echo  $img['data-color'],'<br />';
		// 	}
		// 		echo '4--------------------------------------------<br />';
		// foreach($html->find('div[class="slider_vertical"]') as $img) {

			// foreach($img->find('div') as $col){
			// 		echo $col['data-color'],'<br />';
				
			// 		$img = $img->find('img');
			// 		$img = $img->src;
			// 		$pos = strpos($img, '/assets/images/items/');
			// 		if ($pos === false) {
			// 			continue;
			// 		} else {
			// 			$img_url = 'bluzka.ua';
			// 			$img_url .= $img;
			// 			echo  $img_url,'<br />';
			// 		}
			// }

		// 		foreach($img->find('img') as $img){
		// 			$img = $img->src;
		// 			$pos = strpos($img, '/assets/images/items/');
		// 			if ($pos === false) {
		// 				continue;
		// 			} else {
		// 				$img_url = 'bluzka.ua';
		// 				$img_url .= $img;
		// 				echo  $img_url,'<br />';
		// 			}
		// 		}
			
		// }
		// echo '4--------------------------------------------<br />';
		// echo '4--------------------------------------------<br />';
			// foreach($html->find('div[class="slider_vertical"], img ') as $img) {
			// 	$img = $img->src;
			// 	$pos = strpos($img, '/assets/images/items/');
			// 	if ($pos === false) {
			// 		continue;
			// 	} else {
			// 		$img_url = 'bluzka.ua';
			// 		$img_url .= $img;
			// 		echo  $img_url,'<br />';
			// 	}
			// }
		
		
	// }
}

//подключение интерфейса
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_site_parser.tpl');
