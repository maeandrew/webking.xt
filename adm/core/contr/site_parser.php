<?php

error_reporting(-1);
header('Content-Type: text/html; charset=utf-8');


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




// //Устанавливаем настройки памяти
// echo "memory_limit ", ini_get('memory_limit'), "<br />";
// ini_set('memory_limit', '1024M');	
// echo "memory_limit ", ini_get('memory_limit'), "<br />";
// //Устанавливаем настройки времени
// echo "max_execution_time ", ini_get('max_execution_time'), "<br />";
// ini_set('max_execution_time', 3000);
// echo "max_execution_time ", ini_get('max_execution_time'), "<br />";

ini_set('display_errors','on');
ini_set('error_reporting',E_ALL);


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



// echo 'display_errors = ' . ini_get('display_errors') . "<br />";
// echo 'upload_max_size = ' . ini_get('upload_max_size') ."<br />";
// echo 'post_max_size = ' . ini_get('post_max_size') . "<br />";

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
// 		die();
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
			case 2300000:
				echo "case 23 bluzka -> ОК <br />";
				
					foreach ($xml->xpath('/yml_catalog/shop') as $element) {
							foreach ($element->xpath('offers/offer') as $offer) {
								$vendorCode_color = $offer->vendorCode;
								$vendorCode_color .= $offer->param;
								array_push($array, $vendorCode_color);
							}
						}
					// $array = array_unique($array);
					echo "Размер масива ", count($array, COUNT_RECURSIVE), "<br />";
					foreach ($array as $key => $value) {
						echo "Ключ: $key; Значение: $value<br />\n";
					 }
				//  die();
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
//-------------------------------------------------------------------------------------------

if(isset($_POST['parse_URL'])){
echo "Зашли в parse_URL";
print_r('<pre>');
print_r($_POST);
print_r('</pre>');
$l = $d = $i = 0;
//Включаем показ ошибок

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
	

//Устанавливаем настройки памяти

ini_set('memory_limit', '1024M');	

//Устанавливаем настройки времени

ini_set('max_execution_time', 3000);



// Проверил_URL
	if (get_headers('http://bluzka.ua/ru/yml/', 1)){
	echo " Проверил_URL <br />";
		$sim_url = simplexml_load_file('http://bluzka.ua/ru/yml/');
		echo "Файл загружен <br />";
	// вібераем имеющиеся у нас артикул
	// $supcomments = $Products->GetSupComments($id_supplier);
	// if(is_array($supcomments)){
	// 	$supcomments = array_unique($supcomments);
	// }
		//захолдим в индивидуальные настройки 
		switch ($_POST['site']){
			case 23:
			echo "зашли в case 23 <br />";
			//Устанавливаем настройки времени
				ini_set('max_execution_time', 3000);
				foreach ($sim_url->xpath('/yml_catalog/shop') as $element) {
					foreach ($element->xpath('offers/offer') as $offer) {
						$skipped = false;
						$start = microtime(true);
						// if(!empty($supcomments) && in_array(trim($offer->vendorCode), $supcomments)){
						// 	$skipped = true;
						// 	continue;
						// }else{	
							//проверяем наличие картинки
							if(file_exists($offer->picture)){
								continue;
							}
							//парсим товар 
							$product = array();
							if(!$product = $Parser->bluzka($offer)){
								continue;
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
					
							echo "---------------Просматреваем полученые даные о товаре-----------------------------<br />";
							echo $id_supplier, "<br />";
							echo "определяем категорию по categoryId " .$offer->categoryId. " -> категория", $id_category, "<br />";
							echo $product['sup_comment'], "<br />";
							echo $product['name'], "<br />";
							echo $product['price_mopt_otpusk'], "<br />";
							echo $product['price_opt_otpusk'], "<br />";
							echo $product['descr'], "<br />";
							echo $product['active'], "<br />";
							echo count($product['specs'] , COUNT_RECURSIVE), "<br />","<br />";
							echo count($product['images'], COUNT_RECURSIVE), "<br />";


							$d++;
						// }
							// die();
						// Добавляем новый товар в БД
						if(!$product || $skipped){
							echo $row, "Товар пропущен product пустой<br />";
							$i++;
							continue;
						}elseif($id_product = $Products->AddProduct($product)){
							array_push($supcomments, trim($offer->vendorCode));
							// print_r('<pre>OK, product added</pre>');
							
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
							echo 'OK. Товар добавлен Время выполнения скрипта: '.round(microtime(true) - $start, 4).' сек. <br /><br />';
							
							unset($to_resize);
							unset($images_arr);
							unset($article);
							unset($assort);
							unset($product);
							unset($skipped);
						}else{
							echo "Проблема с добавлением продукта <br /><br />";
							$l++;
						}

						if($d >= $_POST['num']){	
							break;
						}
					}
					if($d >= $_POST['num']){	
						break;
					}	
				}
			break;
			default:
				die();
			break;
		}

	} else {
		echo "Не удалось открыть файл<br />\n";
	}
	print_r('<pre>товарів додано: '.$d.'</pre>');
	print_r('<pre>товарів не вдалося додати: '.$l.'</pre>');
	print_r('<pre>товарів пропущено: '.$i.'</pre>');
	ini_set('memory_limit', '192M');
	ini_set('max_execution_time', 30);
}

//Парсинги по сохраненым файлам parse_NL_xml-------------------------------------------------
//-------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------

if(isset($_POST['parse_NL_xml'])){

	//Устанавливаем настройки памяти
echo "memory_limit ", ini_get('memory_limit'), "<br />";
ini_set('memory_limit', '1024M');	
echo "memory_limit ", ini_get('memory_limit'), "<br />";
//Устанавливаем настройки времени
echo "max_execution_time ", ini_get('max_execution_time'), "<br />";
ini_set('max_execution_time', 3000);
echo "max_execution_time ", ini_get('max_execution_time'), "<br />";
//показ ошибок
ini_set('display_errors','on');
ini_set('error_reporting',E_ALL);


	echo "Зашли в parse_NL_xml";
	print_r('<pre>');
	print_r($_POST);
	print_r('</pre>');
	$l = $d = $i = 0;

	$id_supplier = 30939;
	$id_category = 1733;

	// Проверил_URL
	// if (get_headers("https://www.nl.ua/export_files/Kharkov.xml", 1)){
	// 	echo " Проверил_URL <br />";
	// 	$sim_url = simplexml_load_file("https://www.nl.ua/export_files/Kharkov.xml");
	// 	echo "Файл загружен <br /><br />";
		if ($sim_url = simplexml_load_file("https://www.nl.ua/export_files/Kharkov.xml")){
		echo "Файл загружен <br /><br />";
	//можем просмотреть список катигорий и список кодов товара
		$array = array();
		$array_cat = array();
		foreach ($sim_url->xpath('/yml_catalog/shop') as $element) {
			foreach ($element->xpath('offers/offer') as $offer) {
				array_push($array, $offer->vendorCode);
				array_push($array, $offer->vendorCode);
			}
		}
			echo "Размер масива товаров ", count($array, COUNT_RECURSIVE), "<br />";
			foreach ($array as $key => $value) {
				echo "$value<br />\n";
			 }

		die();

		// выбераем имеющиеся у нас артикул
		$supcomments = $Products->GetSupComments($id_supplier);
		if(is_array($supcomments)){
			$supcomments = array_unique($supcomments);
		}

		//создаем масивы соотметствия категорий
		$keys_NL = array(1,2);
		$values_XT = array(5,4);
		$array_cat = array_combine($keys_NL, $values_XT);
			foreach ($array_cat as $key => $value) {
				echo $key, "->", $value, "<br />";
			 }

		echo "Ок ищем товар<br />";
		//захолдим в индивидуальные настройки 
		foreach ($sim_url->xpath('/yml_catalog/shop') as $element) {
			foreach ($element->xpath('offers/offer') as $offer) {
				$skipped = false;
				if(!empty($supcomments) && in_array(trim($offer->vendorCode), $supcomments)){
					$skipped = true;
						continue;
					}else{
					
						$start = microtime(true);
						 //определяем нашу категориию
						// foreach($array_cat as $key => $value){
						// 	if($offer->categoryId == $key){
						// 		$id_category = $value;
						// 	}
						// }
						//если категории нет пропустить товар
						// if(!$id_category){
						// 	continue;
						// }

						//парсим товар
						$product = array();
						if(!$product = $Parser->NewLine_XML($offer)){
							continue;
						}



						//парсим товар по URL
						// $product = array();
						// if(!$product = $Parser->nl($offer->url)){
						// 	continue;
						// }
								
							// echo "---------------Просматреваем полученые даные о товаре-----------------------------<br />";
							// echo "categoryId " .$offer->categoryId. " -> наша категория", $id_category, "<br />";	//Определяем категорию
							// echo $id_supplier, "<br />";
							// echo $product['sup_comment'], "<br />";
							// echo $product['name'], "<br />";
							// echo $product['price_mopt_otpusk'], "<br />";
							// echo $product['price_opt_otpusk'], "<br />";
							// echo $product['descr'], "<br />";
							// echo "active ", $product['active'], "<br />";
							// echo count($product['specs'] , COUNT_RECURSIVE), "<br />","<br />";
							// foreach ($product['specs'] as $key => $value) {
							// 	echo "<pre>";
							// 	print_r($value);
							// 	echo "</pre>";
							// }

							// echo count($product['images'], COUNT_RECURSIVE), "<br />";
							// foreach ($product['images'] as $key => $value) {
							// 	echo "<pre>";
							// 	print_r($value);
							// 	echo "</pre>";
							// }

					}
					// $d++;
					// continue;
					// die();


					// Добавляем новый товар в БД
					if(!$product || $skipped){
						echo $row, "Товар пропущен product пустой<br />";
						$i++;
						continue;
					}elseif($id_product = $Products->AddProduct($product)){
						// print_r('<pre>OK, product added</pre>');
						$d++;
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
						array_push($supcomments, trim($offer->vendorCode));
						// чистим переменые
						unset($to_resize);
						unset($images_arr);
						unset($article);
						unset($assort);
						unset($product);
						unset($skipped);
					}else{
						echo "Проблема с добавлением продукта <br /><br />";
						$l++;
					}
				echo 'OK. Товар добавлен Время выполнения скрипта: '.round(microtime(true) - $start, 4).' сек. <br /><br />';
				if($d > $_POST['num']){	
					break;
				}
			}
			if($d > $_POST['num']){	
				break;
			}	
		}
	} else {
		echo "Не удалось открыть файл<br />\n";
	}
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




	
	if($html = $Parser->parseUrl('http://bluzka.ua/ru/item/bluzka-1247-1247/')){
	echo "Зашли на карточку товара <br />";

		// echo '--------------------------------------------<br />';

		// echo  'Ценна: ', $html->find('.js_price_ws', 0)->innertext, "<br />";

		// echo  'Название: ', $html->find('h1', 0)->innertext, "<br />";
		
		// echo '0--------------------------------------------<br />';

		// echo  $html->find('.good-color_size', 0)->children(1), "<br />";

		// echo '1--------------------------------------------<br />';

		// echo  $html->find('.hidden_colors', 0)->plaintext, "<br />";

		echo '1--------------------------------------------<br />';
		foreach($html->find('label, input') as $img) {

			if($img->type ==='radio' and $img->name ==='buy[color]'){
			$img = $img->value;
			echo $img ,'<br />';
			}
		}
		foreach($html->find('label, span') as $img) {

			$img = $img->plaintext;
			echo $img ,'<br />';
			
		}
			
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
				echo '4--------------------------------------------<br />';
		foreach($html->find('div[class="slider_vertical"]') as $img) {

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

				foreach($img->find('img') as $img){
					$img = $img->src;
					$pos = strpos($img, '/assets/images/items/');
					if ($pos === false) {
						continue;
					} else {
						$img_url = 'bluzka.ua';
						$img_url .= $img;
						echo  $img_url,'<br />';
					}
				}
			
		}
		echo '4--------------------------------------------<br />';
		echo '4--------------------------------------------<br />';
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
		
		
	}
}

//подключение интерфейса
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_site_parser.tpl');
