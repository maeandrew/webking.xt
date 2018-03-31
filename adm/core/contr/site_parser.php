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
	$l = $d = $i = $ldi = 0;

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

	//Устанавливаем настройки памяти
	ini_set('memory_limit', '3048M');
	ini_set('max_execution_time', 6000);	

	//захолдим в индивидуальные настройки 
	switch ($_POST['site']){
		case 21:
			echo "зашли в case 21 (NewLine_XML) <br />";
			//Открываем файл
			if (!$sim_url = simplexml_load_file("https://www.nl.ua/export_files/Kharkov.xml")){
			echo "Не удалось открыть файл<br />\n";
			die();
			}
			echo "Файл загружен <br />";
			
			// выбераем имеющиеся у нас артикул
			$supcomments = $Products->GetSupComments($id_supplier);
			if(is_array($supcomments)){
				$supcomments = array_unique($supcomments);
			}
			echo 'Загрузили в масив асортимент ', count($supcomments, COUNT_RECURSIVE), "<br />","<br />";
			
			// if(!$supcomments){
			// 	echo "Массив загруженых товаров поставщика пуст<br />";
			// 	continue;
			// }

			//создаем масивы соотметствия категорий
			$keys_NL = array(6442, 6683, 10372, 6267, 6715, 6772, 6726, 6814, 6388, 6380, 6317, 6344, 10431, 6217, 6231, 6251, 6514, 6520, 6527, 6528, 6529, 6530, 6513, 6584, 8220, 6062, 6067, 6139, 6456, 6657, 6614, 6652, 14366, 12228, 6620, 6637, 6658, 6659, 13968, 14275, 6616, 6722, 14134, 13799, 12171, 6765, 12399, 10049, 6590, 9330, 6485, 6425, 6414, 6068, 6396, 6409, 6390, 6408, 6438, 6473, 6439, 6392, 6446, 6120, 6399, 6445, 6391, 6386, 6469, 6085, 6090, 6421, 6531, 11617, 6405, 6794, 6788, 6795, 6793, 6789, 6783, 6763, 6417, 6426, 6403, 6434, 6393, 6411, 6184, 13849, 6771, 6518, 6173, 6774, 6775, 6776, 6777, 6778, 6779, 12397, 6519, 6521, 6678, 6685, 6769, 10367, 6689, 12400, 6509, 6420, 6786, 6790, 6791, 6395, 6501, 11619, 6433, 11652, 6444, 6412, 6429, 6407, 6451, 11665, 6436, 6422, 6427, 6431, 6452, 6418, 6410, 6455, 6415, 6453, 6401, 6474, 6478, 6450, 6398, 6098, 6502, 6389, 6480, 6443, 6723);
			$values_XT = array(1593, 629, 638, 639, 759, 771, 816, 891, 896, 912, 914, 915, 961, 961, 961, 961, 967, 970, 975, 975, 975, 975, 980, 999, 1009, 1011, 1012, 1012, 1063, 1070, 1071, 1073, 1074, 1075, 1076, 1076, 1076, 1076, 1077, 1081, 1082, 1088, 1112, 1114, 1114, 1120, 1125, 1192, 1194, 1195, 1196, 1197, 1198, 1199, 1199, 1200, 1201, 1201, 1201, 1201, 1203, 1204, 1204, 1205, 1205, 1207, 1208, 1209, 1209, 1210, 1211, 1211, 1215, 1216, 1217, 1241, 1243, 1243, 1244, 1245, 1246, 1305, 1325, 1325, 1325, 1325, 1325, 1325, 1347, 1381, 1381, 1385, 1412, 1415, 1415, 1415, 1415, 1415, 1415, 1415, 1422, 1422, 1425, 1426, 1426, 1427, 1428, 1429, 1476, 1532, 1555, 1555, 1555, 1557, 1559, 1565, 1566, 1568, 1575, 1578, 1581, 1591, 1593, 1593, 1599, 1602, 1616, 1618, 1620, 1622, 1623, 1623, 1624, 1626, 1629, 1641, 1648, 1654, 1666, 1677, 1682, 1684, 1692, 1707, 1712);
			  $array_cat = array_combine($keys_NL, $values_XT);
				// foreach ($array_cat as $key => $value) {
				// 	echo $key, "   ->  ", $value, "<br />";
				//  }

				//можем просмотреть список  кодов товара и цен
			 	  $array_offer  =  array();
				foreach ($sim_url->xpath('/yml_catalog/shop') as $element) {
					foreach ($element->xpath('offers/offer') as $offer) {
						// echo $offer->vendorCode, " : ", $offer->price, "<br />";
						if(in_array($offer->categoryId, $keys_NL) && !in_array(trim($offer->vendorCode), $supcomments)){
							// echo $offer->vendorCode, "<br />";
							array_push($array_offer, $offer);
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
