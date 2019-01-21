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

//Устанавливаем настройки памяти
// echo "memory_limit ", ini_get('memory_limit'), "<br />";
ini_set('memory_limit', '1024M');	
// echo "memory_limit ", ini_get('memory_limit'), "<br />";
//Устанавливаем настройки времени
// echo "max_execution_time ", ini_get('max_execution_time'), "<br />";
ini_set('max_execution_time', 3000);
// echo "max_execution_time ", ini_get('max_execution_time'), "<br />";

ini_set('display_errors','on');
ini_set('error_reporting',E_ALL);
set_time_limit(0);

// phpinfo();
// die();
//Парсинги по сохраненым файлам XSL----------------------------------------------------------
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
						case 25:
							// $url="https://api.dclink.com.ua/api/GetPrice";
					    
							$supcomments = $Products->GetSupComments($id_supplier);
							if(is_array($supcomments)){
								$supcomments = array_unique($supcomments);
							}
							if(!empty($supcomments) && in_array(trim($row[0]), $supcomments)){
								// print_r('<pre>Supplier comment issue</pre>');
								$skipped = true;
								continue;
							}else{
								if(!$product = $Parser->DCLing($row[0])){
									continue;
								}
							}
							break;
						default:
							# code...
							break;
					}
				// echo "Код постащика ", $id_supplier, "<br />";
				// echo "Код категории ",$id_category, "<br />";
				// echo "Арт поставщика ",$product['sup_comment'], "<br />";
				// echo "Название товара ",$product['name'], "<br />";
				// echo "Цена мелкий опт ",$product['price_mopt_otpusk'], "<br />";
				// echo "Ценна опт ",$product['price_opt_otpusk'], "<br />";
				// echo "Описание ",$product['descr'], "<br />";
				// echo "Активность ",$product['active'], "<br />";
				// echo "Количество характеристик ", count($product['specs'] , COUNT_RECURSIVE), "<br />","<br />";
				// echo "Количество картинок ", count($product['images'], COUNT_RECURSIVE), "<br />";
				// foreach ($product['images'] as $value) {
				// 	echo "<pre>";
				// 	print_r($value);
				// 	echo "</pre>";
				// }
// die();

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
	$_POST['num'] = 1*$_POST['num'];
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
			// phpinfo();
	// die();
			//Устанавливаем настройки памяти
			echo "memory_limit ", ini_get('memory_limit'), "<br />";
			ini_set('memory_limit', '4096M');	
			echo "memory_limit ", ini_get('memory_limit'), "<br />";
			//Устанавливаем настройки времени
			echo "max_execution_time ", ini_get('max_execution_time'), "<br />";
			ini_set('max_execution_time', 6000);
			echo "max_execution_time ", ini_get('max_execution_time'), "<br />";

			// echo "upload_max_filesize ", ini_get('upload_max_filesize'), "<br />";
			// ini_set("upload_max_filesize","100M");
			// echo "upload_max_filesize ", ini_get('upload_max_filesize'), "<br />";

			// echo "post_max_size ", ini_get('post_max_size'), "<br />";
			// echo "set_time_limit ", ini_get('set_time_limit'), "<br />";
			
			// set_time_limit(600);
			ini_set('display_errors','on');
			ini_set('error_reporting',E_ALL);


			//Открываем файл удалено
		// 	if (!$sim_url = simplexml_load_file("https://www.nl.ua/export_files/Kharkov.xml")){
		// 		echo "Не удалось открыть файл<br <br />";
		// 		die();
		// 	}
			// if (!$xml = file_get_contents("https://www.nl.ua/export_files/Kharkov.xml")){
			// 	echo "Не удалось открыть файл<br <br />";
			// 	die();
			// }
			// $sim_url = simplexml_load_file($xml);
			// echo "Файл загружен <br />";
		

		 
			
			//********************************
			//загружаем файл
			// $url='https://www.nl.ua/export_files/Kharkov.xml'; 
			// if(!copy($url, $GLOBALS['PATH_product_img'].'Kharkov.xml')){
			// 	echo "не удалось скопировать ...\n";
			// }else{
			// 	echo "Файл скопирован ...\n";
			// }
			//Открываем локальный файл
			$html = $GLOBALS['PATH_product_img'].'Kharkov.xml';
			if (!$sim_url = simplexml_load_file($html)){
				echo "Не удалось открыть файл<br />\n";
				die();
			}
			echo "Файл обработан simplexml_load_file  <br/>";
			// ob_end_clean();
			// ob_implicit_flush(1);

// die();
			//Проверка товаров в наличии и не вналичии
			// $offer_on = $offer_off = array();
			//  	foreach ($sim_url->xpath('/yml_catalog/shop') as $element) {
			// 		foreach ($element->xpath('offers/offer') as $offer) {
			// 			if ($offer['available']) {
			// 				array_push($offer_on, $offer);
			// 			}else{
			// 				array_push($offer_off, $offer);
			// 			}
			// 		}
			// 	}

			// echo 'В в наличии ', count($offer_on), "<br />";
			// echo 'НЕТ в наличии ', count($offer_off), "<br />";
			// echo 'Всего в файле ', count($offer_on) + count($offer_off), "<br /> ГОТОВО ";

			// выбераем имеющиеся у нас артикул
			$supcomments = $Products->GetSupComments($id_supplier);
			if(is_array($supcomments)){
				$supcomments = array_unique($supcomments);
			}
			if(!$supcomments){
				echo "Массив загруженых товаров поставщика пуст<br />";
				continue;
			}
			echo 'У поставщика в кабегнете товаров ', count($supcomments), "<br />","<br />";
			//создаем масивы соотметствия категорий
			$array_cat = array(5819=>675,5834=>675,5840=>1067,5977=>1009,5995=>1790,5997=>1790,5999=>1006,6001=>1790,6002=>1790,6004=>1790,6005=>1790,6007=>1790,6009=>1790,6011=>1790,6013=>1790,6014=>1790,6015=>1790,6016=>1006,6017=>1790,6018=>1790,6020=>1006,6021=>1192,6022=>1405,6023=>1006,6024=>1006,6028=>632,6032=>948,6033=>945,6034=>1343,6036=>1697,6039=>1737,6040=>1439,6041=>951,6042=>1749,6044=>921,6045=>957,6047=>1411,6048=>949,6050=>1457,6051=>1458,6052=>1323,6053=>920,6054=>1714,6055=>1419,6056=>940,6057=>1749,6058=>922,6059=>1697,6060=>939,6061=>950,6062=>1011,6063=>1749,6064=>935,6066=>1465,6067=>1012,6068=>1199,6069=>1697,6070=>941,6071=>1463,6072=>632,6073=>923,6075=>940,6076=>939,6078=>1564,6080=>1442,6081=>1697,6082=>1434,6083=>937,6084=>635,6085=>1210,6086=>931,6088=>934,6089=>1395,6090=>1211,6091=>1438,6092=>938,6093=>1419,6094=>635,6095=>1419,6096=>1419,6097=>635,6098=>1677,6099=>1439,6100=>1438,6101=>1419,6102=>946,6103=>679,6104=>953,6105=>1445,6106=>940,6107=>1445,6108=>635,6109=>1463,6110=>1419,6111=>924,6112=>1411,6113=>918,6114=>635,6115=>1410,6116=>632,6117=>933,6118=>1419,6119=>930,6120=>1205,6121=>632,6122=>831,6123=>1749,6124=>1564,6125=>940,6126=>632,6127=>1403,6128=>1395,6130=>1463,6131=>1697,6132=>1460,6133=>941,6134=>1435,6135=>946,6136=>946,6137=>1697,6138=>1178,6139=>1012,6140=>1419,6143=>941,6144=>1697,6145=>1448,6146=>1419,6147=>1436,6148=>1564,6149=>1697,6150=>1456,6151=>1697,6152=>940,6153=>946,6154=>1697,6155=>1175,6156=>945,6157=>1459,6158=>952,6159=>1697,6160=>1474,6161=>954,6162=>946,6163=>781,6164=>935,6165=>679,6166=>940,6167=>1697,6168=>1697,6169=>1418,6170=>946,6171=>935,6172=>677,6173=>1412,6174=>1419,6175=>915,6176=>634,6177=>677,6178=>950,6179=>1564,6180=>632,6181=>940,6182=>940,6183=>743,6184=>1347,6185=>940,6186=>928,6187=>1474,6189=>941,6190=>1465,6191=>1221,6192=>1447,6193=>1697,6194=>1440,6195=>1474,6196=>1697,6197=>1448,6198=>1463,6199=>1419,6200=>1697,6201=>940,6202=>1419,6203=>947,6204=>1389,6206=>601,6207=>978,6209=>1419,6213=>944,6217=>961,6220=>944,6224=>903,6231=>961,6234=>901,6235=>900,6236=>1796,6237=>903,6238=>902,6240=>1794,6243=>634,6244=>1795,6245=>1797,6246=>1797,6247=>1794,6248=>908,6249=>910,6251=>961,6254=>1503,6256=>909,6260=>1382,6262=>1794,6263=>1794,6265=>957,6267=>639,6268=>1796,6269=>1796,6270=>1796,6271=>1796,6272=>1796,6273=>1796,6274=>944,6275=>944,6276=>944,6285=>961,6286=>961,6290=>1382,6293=>634,6294=>568,6295=>903,6296=>955,6297=>1004,6298=>953,6303=>1786,6305=>919,6307=>1006,6309=>1787,6311=>917,6312=>917,6313=>917,6315=>912,6316=>912,6317=>914,6318=>1787,6319=>912,6321=>918,6322=>912,6323=>1340,6324=>1344,6325=>912,6326=>917,6327=>917,6328=>1726,6329=>912,6330=>1344,6331=>1787,6332=>1787,6334=>964,6335=>912,6336=>912,6337=>914,6338=>964,6339=>1726,6340=>912,6341=>796,6342=>1787,6343=>912,6344=>915,6345=>917,6346=>1726,6347=>1726,6348=>919,6349=>1344,6351=>1726,6352=>1344,6354=>1785,6355=>917,6357=>912,6358=>1785,6360=>1785,6361=>1344,6362=>1785,6363=>1344,6364=>1787,6365=>1787,6366=>917,6368=>1786,6369=>1786,6370=>1786,6371=>1785,6372=>1726,6373=>1344,6374=>912,6375=>1787,6376=>917,6378=>1113,6379=>1113,6380=>912,6386=>1209,6388=>896,6389=>1684,6390=>1201,6391=>1208,6392=>1204,6393=>1325,6395=>1557,6396=>1199,6398=>1666,6399=>1205,6401=>1629,6403=>1325,6405=>1217,6407=>1591,6408=>1201,6409=>1200,6410=>1623,6411=>1325,6412=>1578,6414=>1198,6415=>1624,6417=>1325,6418=>1622,6420=>1532,6421=>1211,6422=>1602,6425=>1197,6426=>1325,6427=>1616,6429=>1581,6430=>1611,6431=>1618,6432=>1572,6433=>1566,6434=>1325,6435=>1202,6436=>1599,6438=>1201,6439=>1203,6442=>1593,6443=>1707,6444=>1575,6445=>1207,6446=>1204,6450=>1654,6451=>1593,6452=>1620,6453=>1626,6455=>1623,6456=>1063,6457=>1214,6460=>1568,6463=>1619,6465=>1565,6469=>1209,6473=>1201,6474=>1641,6478=>1648,6480=>1692,6482=>1325,6483=>1192,6484=>1325,6485=>1196,6486=>1325,6495=>1594,6499=>772,6500=>1647,6501=>1559,6502=>1682,6506=>990,6507=>1006,6509=>1476,6510=>1783,6511=>980,6512=>1782,6513=>980,6514=>967,6515=>1476,6517=>1782,6518=>1385,6519=>1422,6520=>970,6521=>1422,6522=>1782,6523=>1476,6524=>1782,6525=>1782,6526=>1476,6527=>975,6528=>975,6529=>975,6530=>975,6531=>1215,6532=>1112,6536=>997,6538=>1000,6540=>998,6541=>997,6542=>998,6543=>997,6544=>1000,6546=>1001,6547=>997,6550=>995,6552=>995,6553=>1000,6554=>1193,6555=>995,6556=>1075,6557=>1075,6558=>1003,6561=>995,6562=>1403,6563=>998,6564=>998,6565=>1598,6566=>1001,6567=>995,6571=>994,6572=>995,6574=>995,6575=>1075,6581=>1192,6582=>998,6583=>1000,6584=>999,6586=>995,6588=>999,6589=>1192,6590=>1194,6592=>997,6593=>1383,6594=>1192,6595=>997,6596=>1553,6599=>997,6600=>1001,6601=>1001,6602=>1193,6604=>1001,6606=>1001,6607=>1749,6611=>1784,6612=>1784,6614=>1071,6616=>1082,6617=>1071,6618=>1172,6619=>1784,6620=>1076,6625=>1075,6627=>1070,6630=>1070,6631=>1784,6632=>1662,6633=>1784,6635=>1074,6636=>1662,6637=>1076,6638=>1784,6640=>1784,6641=>1784,6642=>1784,6644=>1130,6645=>728,6646=>1076,6647=>967,6648=>1212,6649=>970,6651=>1073,6652=>1073,6653=>1142,6654=>1662,6656=>1070,6657=>1070,6658=>1076,6659=>1076,6666=>1081,6670=>1793,6672=>1287,6674=>1171,6676=>1791,6677=>1178,6678=>1425,6679=>1793,6680=>640,6682=>1792,6683=>629,6684=>1472,6685=>1426,6686=>1793,6687=>1171,6688=>1792,6689=>1428,6690=>1179,6691=>1184,6692=>1792,6694=>1187,6695=>1186,6696=>1185,6701=>1088,6704=>1227,6706=>1139,6708=>1141,6712=>1057,6713=>1088,6715=>759,6720=>1057,6722=>1088,6723=>1712,6726=>816,6727=>1446,6730=>1102,6731=>1137,6732=>1125,6733=>1089,6734=>1057,6737=>1133,6738=>1125,6740=>1066,6742=>1138,6743=>1550,6744=>1057,6746=>1005,6749=>1057,6750=>1709,6752=>1095,6753=>1139,6754=>1008,6755=>1125,6756=>1098,6757=>1646,6758=>1057,6759=>1057,6760=>1131,6761=>1111,6762=>1230,6763=>1305,6764=>1105,6765=>1120,6769=>1426,6771=>1381,6772=>771,6774=>1415,6775=>1415,6776=>1415,6777=>1415,6778=>1415,6779=>1415,6783=>1246,6784=>1555,6785=>1555,6786=>1555,6787=>1732,6788=>1243,6789=>1245,6790=>1555,6791=>1555,6793=>1244,6794=>1241,6795=>1243,6797=>1101,6800=>1288,6805=>1058,6806=>1057,6807=>1054,6808=>1055,6809=>722,6810=>1053,6811=>1057,6812=>1057,6813=>1057,6814=>891,6815=>1429,6816=>679,6817=>1429,6828=>1133,6829=>873,6830=>1135,6831=>1134,6832=>1007,6833=>1135,6834=>1125,6835=>1125,6840=>990,6842=>987,6843=>987,6844=>987,6845=>991,6846=>987,6848=>987,6849=>990,6850=>990,6851=>987,6852=>990,6853=>990,6854=>987,6855=>987,6856=>987,6857=>990,6858=>987,6859=>991,6860=>987,6861=>987,6862=>990,6863=>987,6864=>1104,6865=>989,6866=>991,6867=>987,6868=>991,6869=>987,6870=>987,6872=>990,6873=>990,6874=>987,6875=>987,6876=>990,7990=>1788,7992=>1009,7996=>1789,7997=>1788,8001=>1789,8002=>1789,8007=>1788,8017=>1789,8019=>1789,8021=>1788,8022=>1788,8023=>1789,8027=>1789,8028=>1788,8029=>1789,8030=>1788,8031=>1788,8032=>1009,8034=>1788,8035=>1789,8044=>1789,8045=>1789,8056=>1789,8060=>1789,8062=>1789,8063=>1789,8069=>1789,8070=>1789,8074=>1789,8075=>1788,8076=>1788,8083=>1788,8088=>1788,8089=>1788,8102=>1788,8103=>1788,8107=>1789,8111=>1788,8112=>1788,8113=>1788,8114=>1788,8130=>1788,8134=>1788,8135=>1788,8145=>1788,8147=>1788,8148=>1788,8161=>1788,8163=>1788,8179=>1788,8183=>1788,8191=>1788,8193=>1788,8203=>1789,8205=>1789,8206=>1789,8210=>1789,8212=>1789,8215=>1009,8216=>1009,8218=>1009,8219=>1009,8220=>1009,9166=>1790,9178=>1006,9192=>990,9197=>988,9330=>1195,9589=>1403,10043=>1796,10048=>679,10049=>1192,10098=>903,10302=>679,10338=>1182,10350=>1190,10352=>1189,10357=>1792,10358=>1171,10359=>1325,10360=>1792,10362=>1793,10367=>1427,10368=>1183,10370=>1179,10371=>1792,10372=>638,10373=>638,10375=>1180,10376=>1183,10378=>1186,10379=>1186,10380=>1792,10384=>1426,10388=>1426,10395=>1784,10411=>1103,10416=>1075,10427=>1426,10431=>961,10432=>633,10596=>925,10597=>1205,10608=>1485,10670=>1676,11024=>1782,11592=>679,11601=>679,11602=>679,11617=>1216,11618=>679,11619=>1565,11652=>1568,11660=>679,11664=>679,11665=>1593,11666=>679,11749=>679,11755=>1009,11815=>1786,11816=>1456,11817=>1697,11818=>995,11819=>988,12164=>941,12166=>634,12167=>1677,12171=>1114,12187=>1082,12194=>1662,12228=>1075,12271=>1761,12397=>1415,12398=>1230,12399=>1125,12400=>1429,12480=>1788,12481=>1788,12498=>1789,12520=>1789,12534=>1789,12539=>1788,12712=>1788,12714=>1788,12718=>1789,12987=>1788,12990=>1788,13063=>997,13659=>1789,13666=>1788,13671=>1788,13672=>1788,13680=>1789,13682=>1789,13683=>1788,13692=>1788,13694=>1788,13697=>1788,13699=>1788,13704=>1788,13707=>1789,13710=>1788,13712=>1003,13713=>1003,13723=>1125,13730=>1788,13733=>1788,13735=>1788,13738=>1789,13749=>1481,13750=>1785,13752=>1788,13756=>917,13758=>1426,13762=>1789,13765=>1009,13768=>629,13770=>1788,13772=>1789,13773=>1789,13778=>1788,13780=>1788,13784=>1788,13786=>1788,13788=>1788,13793=>1788,13796=>1344,13799=>1114,13800=>1171,13803=>952,13805=>1736,13806=>1023,13809=>1789,13813=>1697,13816=>1789,13821=>945,13823=>917,13825=>1697,13827=>1697,13829=>1004,13830=>1697,13832=>1697,13835=>1108,13845=>990,13847=>1357,13849=>1381,13855=>1788,13857=>1788,13858=>1788,13863=>1788,13865=>1788,13866=>1788,13869=>1789,13872=>1788,13874=>1789,13876=>1788,13878=>1788,13880=>1789,13891=>1789,13892=>1789,13896=>1789,13898=>1789,13900=>1789,13902=>1789,13904=>1788,13913=>1789,13914=>1789,13923=>1788,13924=>1789,13927=>1073,13928=>1789,13930=>1789,13932=>1789,13934=>1788,13936=>1789,13939=>1787,13941=>978,13956=>1081,13958=>1789,13960=>1789,13964=>970,13965=>1788,13968=>1077,13969=>970,13971=>1788,13974=>970,13977=>1789,13979=>1788,13985=>1789,13989=>1788,13991=>1788,13995=>1789,14002=>1068,14008=>1313,14010=>1131,14015=>1788,14017=>1789,14019=>1788,14023=>1788,14027=>1788,14029=>1788,14037=>1789,14041=>1789,14070=>1380,14071=>1380,14072=>1380,14073=>1380,14074=>1380,14075=>1380,14077=>1380,14078=>560,14079=>1380,14080=>1380,14081=>1380,14082=>1380,14084=>1380,14085=>1380,14086=>1380,14087=>1380,14089=>1380,14090=>1380,14091=>679,14094=>679,14096=>1380,14097=>1788,14099=>1788,14101=>1789,14104=>607,14105=>1789,14113=>1789,14115=>1325,14118=>1111,14126=>603,14127=>1788,14132=>1325,14134=>1112,14136=>1253,14137=>1057,14140=>1074,14142=>832,14144=>1446,14145=>1789,14151=>1789,14153=>1789,14155=>1789,14157=>1788,14161=>1788,14163=>1788,14165=>1789,14167=>1789,14169=>1789,14171=>1472,14172=>1716,14173=>1713,14174=>1714,14175=>1714,14176=>1714,14177=>1714,14178=>1713,14179=>1714,14180=>1713,14181=>1714,14182=>1714,14183=>1713,14184=>1713,14185=>1714,14186=>1713,14187=>1789,14189=>1788,14191=>1789,14193=>891,14194=>1789,14200=>1789,14202=>1788,14204=>1789,14209=>1788,14210=>1789,14212=>1788,14215=>1788,14217=>1789,14219=>1789,14221=>1789,14223=>1788,14225=>1788,14227=>1788,14229=>1788,14233=>1788,14235=>1788,14237=>1789,14241=>1788,14243=>1789,14249=>1788,14252=>1054,14255=>1054,14258=>1788,14260=>1788,14262=>1789,14264=>1789,14268=>1788,14270=>1489,14272=>1788,14275=>1081,14290=>1788,14292=>1788,14294=>1788,14310=>1788,14320=>1789,14322=>1788,14332=>1789,14338=>1789,14346=>1789,14348=>1788,14356=>1070,14364=>1076,14366=>1074,14369=>1125,14371=>1125,14373=>1125,14374=>1782,14377=>1125,14378=>1788,14380=>1788,14382=>1788,14384=>1789,14386=>1788,14390=>1788,14396=>1788,14398=>1788,14400=>1788,14402=>1789,14415=>1788,14419=>1789);
				//можем просмотреть
				// foreach ($array_cat as $key => $value) {
				// 	echo $key, " =>  ", $value, ",";
				//  }
				// die();
			//vendorCode c ошибками
			$error_vendorCode = array(90511154,90601164,90601155,31035202,31034348,31043393,31035285,31034456,31034457,31034783,31010710,31030315,31034727,31035744,31030241,31034960,31035656,31035657,31033112,31033141,31034408,31033163,31010917,31009331,31009182,31009610,31009956,31009747,31009719,31253016,31012419,31012859,31005556,31012547,31012920,31047006,70837168,30110072,30101867,30138035,31021463,31021885,31044046,31044047,31003432,31227591,31227595,31227597,31241252,31227594,31227745,31227746,31246183,31222310,40617387,80335841,10843549,10922639,10920157,10927034,10906804,10922620,10924541,10922687,10922685,10924557,10901515,10704282,10704284,10704288,10704286,10704280,10704277,10704279,10704293,51333094,51333205,51333044,51333092,51333095,51333206,51333118,51333119,51333120,80132359,80213729,60306687,60306688,60306689,60611545,60611548,60611549,60611550,60611551,60611555,60611556,60611558,60611559,60611560,60611562,60611563,60611564,60611565,60611569,80128191,0128153,60802989,60809689,60814219,60814626,10316609,20535278);
			//обеденяем позииции которые не нужно добавлять
			$supcomments_error = array_merge($supcomments, $error_vendorCode);
	// die();	
			//Выборка цен для обновления************************
			// echo "UPDATE xt_assortiment SET no_xtorg = 0 WHERE id_supplier = 30939;", "<br />";
			// 	foreach ($sim_url->xpath('/yml_catalog/shop') as $element) {
			// 		foreach ($element->xpath('offers/offer') as $offer) {
			// 			// ob_end_clean();
			// 			ob_implicit_flush(1);
			// 			echo "UPDATE xt_assortiment SET  product_limit = 100000, active = 1, no_xtorg = 1, price_opt_otpusk = ", $offer->price, ", price_mopt_otpusk = ", $offer->price, " WHERE id_supplier = ", 30939, " and sup_comment = '", $offer->vendorCode, "';<br />";
			// 			}
			// 	}
			// echo "UPDATE xt_assortiment SET product_limit = 0, active = 0 WHERE id_supplier = 30939 and no_xtorg = 0;", "<br />";
			//Выборка цен для обновления************************
			//авто обновление
			
			$all = 0; //количество товаров в файле
			$array_add = array(); //количество товаров на добавление
			$sql_arrey = array(); //количество товаров обновляется
			//проставляем метку обновления no_xtorg = 0
			$sql = "UPDATE xt_assortiment SET no_xtorg = 0 WHERE id_supplier = 30939";
			$sql_arrey[] = $sql;
			foreach ($sim_url->xpath('/yml_catalog/shop') as $element) {
				foreach ($element->xpath('offers/offer') as $offer) {
					if (in_array($offer->vendorCode, $supcomments)) {
						$ldi++;
						if($ldi> $_POST['num']){
							echo "СТОП по КОЛИЧЕСТВУ <br/>";
							break 2;
						}
						$id_product = $Products->GetIdBysup_comment($id_supplier, $offer->vendorCode);
						$sql = "UPDATE "._DB_PREFIX_."assortiment SET  product_limit = 100000, active = 1, no_xtorg = 1, price_opt_otpusk = ". $offer->price. ", price_mopt_otpusk = ". $offer->price. " WHERE id_supplier = 30939 and id_product = ".$id_product;
						array_push($sql_arrey, $sql);
						echo $offer->vendorCode, " обновляем <br/>";
					}else{
						if(array_key_exists(strval($offer->categoryId), $array_cat) && !in_array($offer->vendorCode, $supcomments_error)){
							array_push($array_add, $offer);
							echo $offer->vendorCode, " на добавление <br/>";
						}else{
							echo $offer->vendorCode, " пропускаем <br/>";
						}	
					}
					$all++;
				}
			}
			//выключаем не обновленые позиции
			$sql = "UPDATE xt_assortiment SET product_limit = 0, active = 0 WHERE id_supplier = 30939 and no_xtorg = 0";
			$sql_arrey[] = $sql;
			
			//посмотрим масив sql запросов
			echo "Количество товаров в файле ", $all, "<br />";
			echo "Количество товаров на добавление ", count($array_add), "<br />";
			echo 'в масиве $sql_arrey ', count($sql_arrey), '<br/>';
			foreach ($sql_arrey as $key => $value) {
				echo $key, " ", $value, '<br/>';
			}	
			if($Products->ProcessAssortimentXML($sql_arrey)){
			echo "ГОТОВО <br />";
			}
			
			// die();	
			// $Suppliers = new Suppliers();
			// $sop = $Suppliers->Read($id_supplier);
			// foreach ($sop as $key => $value) {
			// 	echo $key, " ", $value, '<br/>';
			// }
		
// die();
			echo "ОК можно парсить <br/>";	
			foreach ($array_add as $offer) {
				// $ldi++;
				// if($ldi> $_POST['num']){
				// 	echo "СТОП по КОЛИЧЕСТВУ";
				// 	die();
				// }
				echo "CТАРТ ---------------------------------------------------------------------------------------------------------------";
					// ob_end_clean();
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
		case 25:
			echo "зашли в case 25 <br />";
			// выбераем имеющиеся у нас артикул
			$supcomments = $Products->GetSupComments($id_supplier);
			if(is_array($supcomments)){
				$supcomments = array_unique($supcomments);
			}
			echo 'В кабенете поставшика ', count($supcomments, COUNT_RECURSIVE), "<br />","<br />";
			//создаем масивы соотметствия категорий
			$keys_DC = array(152,711,875,778,80,608,680,563,211,566,218,410,282,456,502,480,693,324,207,59,487,488,657,577,579,580,592,593,594,584,169,712,774,854,865,722,713,787,869,779,762,857,861,870,872,866,920,860,879,715,720,856,864,862,721,867,863,855,873,897,894,891,906,601,612,519,520,530,454,909,907,509,500,490,508,461,506,513,446,463,514,515,516,518,525,527,470,533,535,741,503,462,499,932,325,765,459,467,489,742,465,521,482,458,483,485,704,283,491,87,139,656,664,665,931,933,695,644,645,646,647,674,659,58,648,649,21,751,753,586,746,314,754,323,750,752,755,170,376,922,453,220,729,221,411,939,658,391,401,242,918,444,280,378,379,839,791,807,808,251,834,835,836,842,196,204,205,206,245,246,248,790,792,793,811,794,795,277,279,731,789,276,179,181,184,884,318,319,934,321,322,447,315,320,469,471,223,287,389,399,732,687,895,799,188,796,396,209,215,935,286,197,208,210,292,293,203,224,222,90,683,42,110,261,581,19,619,26,31,43,50,878,905,727,728,730,307,308,333,363,348,183,814,815,801,802,803,804,817,818,797,816,822,823,824,825,826,827,809,810,813,831,819,820,832,786,193,200,202,291,876,877,880,881,882,890,899,900,901,902,903,911,912,913,914,915,916,919,923,924,925,926,927,929,908,838,840,380,655,671,694,896,495,452,212,843,226,381,494,529,534,285,135,445,504,505,507,510,511,512,758,460,871,479,501,893,522,523,524,531,532,214,281,528,859,883,886,133,526,887,885,917,928,830,30,160,780,697,260,35,68,158,159,13,53,624,627,628,22,557,290,387,397,400,91,243,781,784,12,258,138,186,405,5,395,317,289,388,398,27,275,288,390,394,9,622,623,760,441,442,481,329,194,20,641,99,668,146,670,54,767,85,618,29,597,598,599,600,602,609,614,615,616,25,48,103,149,195,404,620,770,100,576,201,56,180,190,225,33,309,192,47,555,316,191,219,96,229,92,104,328,301,538,733,650,651,272,554,255,259,263,44,682,189,125,69,187,375,182,736,64,771,45,185,24,772,198,86,150,700,701,851,852,78,105,231,773,847,849,850,134,672,673,575,199,756);
			$values_XT = array(559,560,563,579,584,587,592,596,600,604,613,620,626,630,631,632,633,635,652,655,659,662,666,670,670,670,670,670,670,670,673,679,695,707,707,708,708,708,708,709,710,710,710,710,710,711,711,712,712,713,713,714,714,716,717,718,718,719,719,721,722,724,764,772,773,781,781,782,796,811,812,921,922,926,928,928,930,931,934,935,935,935,935,935,935,935,938,939,939,940,940,940,941,942,943,944,945,946,947,948,949,949,950,951,951,953,954,955,957,988,989,990,990,990,990,990,990,992,992,992,992,992,992,992,992,992,992,995,995,996,996,996,998,999,1003,1003,1003,1021,1054,1055,1057,1063,1065,1067,1071,1072,1073,1073,1073,1079,1080,1086,1091,1091,1091,1092,1094,1095,1095,1096,1096,1096,1096,1096,1098,1098,1098,1098,1098,1098,1098,1098,1098,1098,1098,1101,1101,1102,1102,1103,1139,1141,1186,1186,1186,1189,1192,1192,1192,1194,1194,1194,1195,1195,1196,1196,1197,1198,1198,1198,1200,1200,1200,1201,1202,1202,1203,1205,1205,1205,1205,1207,1208,1208,1208,1208,1209,1210,1211,1212,1212,1215,1215,1216,1216,1217,1217,1218,1218,1218,1218,1221,1233,1252,1252,1252,1260,1260,1260,1260,1260,1277,1280,1280,1281,1281,1281,1281,1281,1281,1282,1282,1282,1282,1282,1282,1282,1282,1286,1286,1286,1286,1287,1287,1287,1305,1325,1325,1325,1325,1331,1331,1331,1331,1331,1331,1331,1331,1331,1331,1331,1331,1331,1331,1331,1331,1331,1331,1331,1331,1331,1331,1331,1331,1353,1356,1357,1378,1379,1385,1395,1400,1402,1406,1408,1408,1411,1411,1411,1411,1411,1418,1419,1419,1419,1419,1419,1419,1419,1419,1419,1419,1430,1445,1445,1452,1456,1457,1458,1459,1459,1472,1472,1474,1478,1480,1481,1484,1485,1488,1489,1509,1514,1550,1557,1557,1558,1558,1559,1561,1561,1561,1561,1562,1563,1563,1563,1563,1564,1564,1566,1566,1566,1566,1568,1568,1572,1572,1572,1572,1572,1573,1573,1574,1575,1577,1581,1581,1581,1582,1584,1584,1584,1585,1588,1588,1588,1590,1590,1590,1590,1590,1591,1593,1593,1594,1594,1594,1594,1595,1595,1597,1597,1598,1598,1598,1598,1598,1598,1598,1598,1598,1598,1599,1599,1599,1599,1602,1602,1603,1604,1606,1610,1611,1616,1617,1619,1622,1623,1623,1624,1626,1628,1629,1633,1641,1644,1646,1647,1647,1648,1648,1648,1652,1655,1655,1659,1659,1660,1660,1660,1661,1662,1663,1669,1669,1670,1671,1674,1677,1677,1677,1679,1680,1682,1683,1684,1697,1697,1697,1697,1697,1697,1697,1697,1697,1697,1697,1697,1697,1698,1698,1698,1698,1707,1749);
			$array_cat = array_combine($keys_DC, $values_XT);

			// header("Content-Type: text/html; charset=windows-1251");
			//Открываем файл

		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, array (
		        'login' => 'ХозТорг(Харьков)',
		        'password' => 'm2kyCSZv',
		        'showprice' => '1',
		        'altname' => '1'    )); //параметры запроса 
			//Получаем прайс
			$url="https://api.dclink.com.ua/api/GetPrice";
	 		curl_setopt($ch, CURLOPT_URL, $url);
			if (!$sim_url = simplexml_load_string(curl_exec($ch))){
				echo "Не удалось открыть файл<br />\n";
				die();
			}
			//Получаем сылки на фото
			$url_imag="https://api.dclink.com.ua/api/GetPicturesUrl";
			curl_setopt($ch, CURLOPT_URL, $url_imag);
			if (!$sim_url_imag = simplexml_load_string(curl_exec($ch))){
				echo "Не удалось открыть файл<br />\n";
				die();
			}
			curl_close($ch);
			//Прайс для обновления
			// $count=0;
			// echo "UPDATE xt_assortiment SET  product_limit = 0, active = 0 WHERE id_supplier = 32076;", "<br />";
			// foreach ($sim_url->Product as $Product) {
			// echo "UPDATE xt_assortiment SET  product_limit = 100000, active = 1, price_opt_otpusk = ", $Product->Price * 26.2, ", price_mopt_otpusk = ", $Product->Price * 26.2, " WHERE id_supplier = ", 32076, " and sup_comment = '", $Product->Code, "';<br />";
				
			// 	$count++;
			// }

			// echo $count, "----------------------", "ГОТОВО <br />";
			// die();

			echo "парсим ------------------------------------- <br />";

			foreach ( $sim_url->Product as $Product) {
				// ob_end_clean();
				ob_implicit_flush(1);
				echo "<br />", $Product->Code, " -> ", $Product->CategoryID, "----------------------<br />";
				//условие на количество
				if($ldi > $_POST['num']){
					die();
				}
				

				//условие на наличие в базе
				if(in_array(trim($Product->Code), $supcomments)){
					echo 'id ->', $Product->Code, "<br />";					
					echo $id_supplier, "<br />";
					echo $id_category, "<br />";					
					echo $Product->Code, ' Товар есть в базе', "<br />";
					continue;
				}

				//определяем категорию товара
				foreach($array_cat as $k => $value){
					if ($k == $Product->CategoryID){
						$id_category = $value;
					 	break;
					}					  
				}
				// if($id_category = 1731){
				// 	echo  " Товар без категории<br />";
				// 	continue;
				// }


				if(!$product = $Parser->DCLing_API($Product->Code, $Product->Name, $Product->Price, $sim_url_imag)){
					continue;
				}
				echo "<br />Посмотрим продакт-------------------------<br />";
				echo 'id ->', $Product->Code, "<br />";					
				echo $id_supplier, "<br />";
				echo $id_category, "<br />";
				echo $product['sup_comment'], "<br />";
				echo $product['name'], "<br />";
				echo $product['price_mopt_otpusk'], "<br />";
				echo $product['price_opt_otpusk'], "<br />";
				echo $product['descr'], "<br />";
				echo $product['active'], "<br />";
				echo "Характеристики-----------<br />";
				// foreach($product['specs'] as $specification){
				// 	echo $specification[0], " ", $specification[1], " ", $specification[2], "<br />";
				// }
				echo "Фото-----------<br />";
				echo count($product['images'], COUNT_RECURSIVE), "<br />";
				foreach ($product['images'] as $value) {
					echo $value, "<br />";
				}
	// 	die();
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
									 // sleep(2);
								}
								$Images->resize(false, $to_resize);
							// Привязываем новые фото к товару в БД
							$Products->UpdatePhoto($id_product, $images_arr, $product['images_visible']);
						}
						// Добавляем товар в категорию
						$Products->UpdateProductCategories($id_product, array($id_category));
						array_push($supcomments, trim($Product->Code));
						$ldi++;
						echo 'товар добавлен  ', "<br />";							
						// die();
				}else{
					echo "Проблема с добавлением продукта <br /><br />";
					$l++;
				}
			}
			
		break;
			case 26:
			echo "зашли в case 26 <br />";
			//Открываем файл
			if (!$sim_url = simplexml_load_file('http://opthoz.com.ua/sitemap.xml')){
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
			//Содержимое файла
			// print_r('<pre>');
			// print_r($sim_url);
			// print_r('</pre>');
			 //Выбераем  урлы в массив
				$array = array();
			 foreach($sim_url as $url => $massiv){
				foreach($massiv  as  $key => $value){
					if($key == 'loc'){
							if(!stristr($value, 'manufacturer'))
								array_push($array, $value);
					}
				}
			}
			//Можно просмотреть список
			// foreach ($array as $key => $value) {
			// 	echo "$key => $value <br />";
			// }

			// die();

				foreach ($array as $key => $value) {
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
					// die();
					if(!$product = $Parser->S100($value)){
						continue;
					}
					// echo 'url->', $value, "<br />";					
					// echo $id_supplier, "<br />";
					// echo $id_category, "<br /><br />";

					// echo $product['sup_comment'], "<br />";
					// echo $product['name'], "<br />";
					// echo $product['price_mopt_otpusk'], "<br />";
					// echo $product['price_opt_otpusk'], "<br />";
					// echo $product['descr'], "<br />";
					// echo $product['active'], "<br />";
					// // echo count($product['specs'] , COUNT_RECURSIVE), "<br />","<br />";
					// // foreach($product['specs'] as $specification){
					// // 	echo "<pre>";
					// // 	print_r($Specification);
					// // 	echo "</pre>";
					// // }
					// echo count($product['images'], COUNT_RECURSIVE), "<br />";
					// foreach ($product['images'] as $value) {
					// 	echo "<pre>";
					// 	print_r($value);
					// 	echo "</pre>";
					// }

			// die();
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
		break;
		case 27:
			echo "зашли в case 27 <br />";
			die();
			//Открываем файл
			if (!$sim_url = simplexml_load_file('http://opthoz.com.ua/sitemap.xml')){
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
			//Содержимое файла
			// print_r('<pre>');
			// print_r($sim_url);
			// print_r('</pre>');
			 //Выбераем  урлы в массив
				$array = array();
			 foreach($sim_url as $url => $massiv){
				foreach($massiv  as  $key => $value){
					if($key == 'loc'){
							if(!stristr($value, 'manufacturer'))
								array_push($array, $value);
					}
				}
			}
			//Можно просмотреть список
			// foreach ($array as $key => $value) {
			// 	echo "$key => $value <br />";
			// }

			// die();

				foreach ($array as $key => $value) {
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
					// die();
					if(!$product = $Parser->S100($value)){
						continue;
					}
					// echo 'url->', $value, "<br />";					
					// echo $id_supplier, "<br />";
					// echo $id_category, "<br /><br />";

					// echo $product['sup_comment'], "<br />";
					// echo $product['name'], "<br />";
					// echo $product['price_mopt_otpusk'], "<br />";
					// echo $product['price_opt_otpusk'], "<br />";
					// echo $product['descr'], "<br />";
					// echo $product['active'], "<br />";
					// // echo count($product['specs'] , COUNT_RECURSIVE), "<br />","<br />";
					// // foreach($product['specs'] as $specification){
					// // 	echo "<pre>";
					// // 	print_r($Specification);
					// // 	echo "</pre>";
					// // }
					// echo count($product['images'], COUNT_RECURSIVE), "<br />";
					// foreach ($product['images'] as $value) {
					// 	echo "<pre>";
					// 	print_r($value);
					// 	echo "</pre>";
					// }

			// die();
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
		break;
		// 
		case 28:
			echo "зашли в case X30 Интертул XML <br />";
			
			// //Устанавливаем настройки памяти
			// echo "memory_limit ", ini_get('memory_limit'), "<br />";
			// ini_set('memory_limit', '3024M');	
			// echo "memory_limit ", ini_get('memory_limit'), "<br />";
			// //Устанавливаем настройки времени
			// echo "max_execution_time ", ini_get('max_execution_time'), "<br />";
			// ini_set('max_execution_time', 6000);
			// echo "max_execution_time ", ini_get('max_execution_time'), "<br />";

			// ini_set('display_errors','on');
			// ini_set('error_reporting',E_ALL);
			// set_time_limit(0);
			//Открываем файл
			if (!$sim_url = simplexml_load_file("https://intertool.ua/xml_output/yandex_market.xml")){
				echo "Не удалось открыть файл<br />\n";
				die();
			}
			echo "Файл загружен <br />";
			//Выборка кодов категори
			// foreach ($sim_url->xpath('/yml_catalog/shop') as $element) {
			// 	foreach ($element->xpath('categories/category ') as $category ) {
			// 		echo  $category['parentId'], '; ', $category, '; ', $category['id'], "<br />";	
			// 	}
			// }
			// echo "ГОТОВО <br />";
			// выбераем имеющиеся у нас артикул
			$supcomments = $Products->GetSupComments($id_supplier);
			if(is_array($supcomments)){
				$supcomments = array_unique($supcomments);
			}
			echo 'Загрузили в масив асортимент поставщика', count($supcomments), "<br />","<br />";
			//список товаров на добавление
			$arrayName = array('NT-0128','NT-0130','PT-1807','PT-1809','PT-1808','KT-4702','KT-4701','AT-0141','AT-0142','PT-0022AP','TL-7001','WT-0831','SP-2017','SP-2023','SP-2027','SP-2021','SP-2025','SP-2029','SP-2024','SP-2028','SP-2022','SP-2026','SP-2030','DT-0315.00','AT-3049','HT-7054','NT-0161','HT-0391','HT-0392','HT-0393','HT-1228','FT-2095','RT-1052','RT-1053','RT-1054','RT-1055','RT-1049','RT-1050','RT-1051','RT-3118','RT-5008','RT-1056','RT-1057','RT-1058','RT-1059','RT-1041','RT-1042','RT-1043','RT-1044','HT-0528','HT-0527','RT-1045','RT-1046','RT-1047','RT-1048','RT-1037','RT-1038','RT-1039','RT-1040','RT-1027','RT-1028','RT-1031','RT-1032','RT-1029','RT-1035','RT-1033','RT-1034','BX-0503','PT-0023','CT-5111.0','CT-4012.0','CT-4020.0','NT-0150','DM-1921','DM-1941','DM-2521','DM-2541','DM-3021','DM-3041','DM-3821','DM-3841','DM-4821','DM-4841','DM-7221','DM-7241','AT-0131','FT-2023','FT-2090','FT-0010','AT-0133','VT-0101','PT-0500','HT-0213','AT-0110','ET-5126','HT-1251','HT-1253','SD-0330','SD-8040','SD-8040.00','HT-7015','FT-1127','HT-0571','HT-0476','RT-2008W','WT-0618','WT-0621','RT-0014','RT-1106','RT-1010','RT-1107','RT-1101','RT-1102','RT-1103','RT-1104','RT-1105','NT-0116','NT-0118','SP-2113','SP-2112','SP-2111','PT-1512','PT-1513','DT-0400','BX1-250','SD-0425','SD-0426','SD-5210','SD-5305','SD-5310','SD-5315','SD-5320','SD-5325','SD-5330','SD-5230','SD-5232','SD-5242','SD-5252','SD-5270','SD-5275','SD-5280','SD-5295','FT-1006','FT-1013','AT-0102','AT-0103','AT-0101','UT-6008','BX-9001','HT-0270','HT-0268','MT-1224','MT-1240','MT-1134','MT-1144','MT-1225','MT-1242','MT-1135','MT-1145','MT-1136','MT-1146','MT-1137','MT-1147','MT-1221','MT-1234','MT-1131','MT-1141','MT-1222','MT-1236','MT-1132','MT-1142','MT-1223','MT-1238','MT-1133','MT-1143','LB-0105','TC-1113','TC-1116','TC-1118','TC-1122','TC-1127','TC-1133','TC-1146','TC-1152','TC-1165','TC-1011','TC-1013','TC-1014','TC-1018','TC-1006','DT-2208.17','DT-2209.17','BX-9011','GE-4079','GE-4049','DT-1546','BT-0820','BT-082020','BT-0821','BT-082120','BT-0822','BT-0823','BT-0824','BT-0825','BT-082520','BT-0826','BT-0813','BT-0814','BT-081420','BT-0816','BT-081620','BT-0818','BT-081820','KT-2812','MT-3020','MT-3049','DT-0200','AT-0111','AT-0112','AT-0113','AT-0114','AT-0115','AT-0116','AT-0117','AT-0118','AT-0119','HT-7019','HT-7017','HT-7018','HT-7016','NT-0146','NT-0148','NT-0136','NT-0138','NT-0140');
			echo 'Загрузили в масив список товаров на добавление', count($supcomments), "<br />","<br />";
			
			ob_end_clean();
			ob_implicit_flush(1);
			
			if(!$supcomments){
				echo "Массив загруженых товаров поставщика пуст<br />";
				continue;
			}
			//Выбераем товар на добавление
		 	$array_offer  =  array();
		 	$array_offer_net  =  array();
			foreach ($sim_url->xpath('/yml_catalog/shop') as $element) {
				foreach ($element->xpath('offers/offer') as $offer) {
					if(!in_array($offer->vendorCode, $supcomments)){
						// echo $offer->vendorCode, "<br />";
						array_push($array_offer_net, $offer);
					}
					if(in_array($offer->vendorCode, $arrayName) && !in_array($offer->vendorCode, $supcomments) && isset($offer->picture)){
						// echo $offer->vendorCode, "<br />";
						array_push($array_offer, $offer);
					}
				}
			}
			echo "Товаров нет в нашей база ", count($array_offer_net), "<br /> МЫ хотим добавить товаров", count($array_offer), "<br />";

		// 	print_r('<pre>');
		// 	print_r($array_offer);
		// 	print_r('</pre>');

		
		// die();
			
		foreach ($array_offer as $offer) {
			$ldi++;
			if($ldi> $_POST['num']){
				echo "";
			die();
			}
			echo "CТАРТ ----------------------------------------------------------------------------------------------------------------------------";
			sleep(3);
			// ob_end_clean();
			ob_implicit_flush(1);
			//Устанавливаем настройки времени		
			ini_set('max_execution_time', 120);
			// чистим переменые
			unset($to_resize);
			unset($images_arr);
			unset($article);
			unset($assort);
			unset($product);
			unset($skipped);

			if(!$product = $Parser->Intertool_XML($offer)){
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
		case 29:
			echo "зашли в case 29 sport-baza.net <br />";
			//Открываем файл
			if (!$sim_url = simplexml_load_file('https://sport-baza.net/sitemap.xml')){
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
			//Содержимое файла
			// print_r('<pre>');
			// print_r($sim_url);
			// print_r('</pre>');
			 //Выбераем  урлы в массив
			$array_grup = array();
			$array_prod = array();
			foreach($sim_url as $url => $massiv){
				foreach($massiv  as  $key => $value){
					if($key == 'loc'){
						if(stristr($value, 'https://sport-baza.net/g'))
						array_push($array_grup, $value);
						if(stristr($value, 'https://sport-baza.net/p') && !stristr($value, 'product_list'))
						array_push($array_prod, $value);
					}
				}
			}
			// Можно просмотреть список
			// echo "Групп ", count($array_grup), "<br />";
			// foreach ($array_grup as $key => $value) {
			// 	echo "$key => $value <br />";
			// }
			// echo "Товаров", count($array_prod), "<br />";
			// foreach ($array_prod as $key => $value) {
			// 	echo "$key => $value <br />";
			// }

			// die();

				foreach ($array_prod as $key => $value) {
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
					// if(in_array(trim($offer['id']), $supcomments)){
					// 	echo $offer['id'], ' Товар есть в базе', "<br />";
					// 	continue;
					// 	}
					// die();
					if(!$product = $Parser->Sport_Baza($value)){
						continue;
					}
					// echo 'url->', $value, "<br />";					
					// echo $id_supplier, "<br />";
					// echo $id_category, "<br /><br />";

					// echo $product['sup_comment'], "<br />";
					// echo $product['name'], "<br />";
					// echo $product['price_mopt_otpusk'], "<br />";
					// echo $product['price_opt_otpusk'], "<br />";
					// echo $product['descr'], "<br />";
					// echo $product['active'], "<br />";
					// // echo count($product['specs'] , COUNT_RECURSIVE), "<br />","<br />";
					// // foreach($product['specs'] as $specification){
					// // 	echo "<pre>";
					// // 	print_r($Specification);
					// // 	echo "</pre>";
					// // }
					// echo count($product['images'], COUNT_RECURSIVE), "<br />";
					// foreach ($product['images'] as $value) {
					// 	echo "<pre>";
					// 	print_r($value);
					// 	echo "</pre>";
					// }

			die();
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
		break;
		case 30:
			echo "зашли в case 30 pnsemena.com.ua <br />";
			//Устанавливаем настройки времени		
				ini_set('max_execution_time', 120);
			//Открываем файл
			 $sim_url = 'http://pnsemena.com.ua/semena.html';
			 //список позиций без фото
			 $arrayName = array('284046' => 'Семена в банках АРБУЗ АРАШАН 0,5КГ ИТАЛИЯ',
				'284047' => 'Семена в банках АРБУЗ АСТРАХАНСКИЙ 0,5КГ РОССИЯ',
				'284048' => 'Семена в банках АРБУЗ АЮ ПРОДЮССЁР 0,5КГ БАНКА США',
				'284050' => 'Семена в банках АРБУЗ КЕНДИ 0,5КГ',
				'284056' => 'Семена в банках АРБУЗ ТАЛИСМАН 0,5КГ',
				'284062' => 'Семена в банках ГОРОХ АЛЬФА 0,5КГ',
				'284068' => 'Семена в банках ДЫНЯ КРЕДО 0,5КГ ИТАЛИЯ',
				'284069' => 'Семена в банках ДЫНЯ РАДУЖНАЯ 0,5КГ ТОРПЕДА',
				'284071' => 'Семена в банках ДЫНЯ ЭФИОПКА 0,5КГ РОССИЯ',
				'284079' => 'Семена в банках КУКУРУЗА БАГРАТИОН 0,5КГ БАНКА УКРАИНА',
				'284081' => 'Семена в банках ЛУК ГЛОБУС 0,5КГ МОЛДОВА',
				'284087' => 'Семена в банках МОРКОВЬ БОЛТЕКС 0,250 КГ БАНКА ИТАЛИЯ',
				'284089' => 'Семена в банках МОРКОВЬ МОСКОВСКАЯ ЗИМНЯЯ 0,5 КГ БАНКА РОССИЯ',
				'284090' => 'Семена в банках МОРКОВЬ ШАНТАНЕ РЕД КОР 0,5КГ РОССИЯ',
				'284092' => 'Семена в банках ОГУРЕЦ АЛЛАДИН F1 0,200 КГ БАНКА ПОЛЬША',
				'284093' => 'Семена в банках ОГУРЕЦ ВЕСЁЛЫЕ МОТЫЛЬКИ F1 0,200 КГ БАНКА КИТАЙ',
				'284095' => 'Семена в банках ОГУРЕЦ КИТАЙСКОЕ ЧУДО F1 0,200 КГ БАНКА КИТАЙ',
				'284097' => 'Семена в банках ОГУРЕЦ ПОЛЁТ БАБОЧКИ F1 0.200 КГ БАНКА КИТАЙ',
				'284103' => 'Семена в банках ПАТИССОН ЯНТАРЬ 0,25КГ ГЕРМАНИЯ',
				'284106' => 'Семена в банках ПЕРЕЦ ПОЛЁТ 0,2КГ МОЛДОВА',
				'284108' => 'Семена в банках ПЕТРУШКА ЛИСТОВАЯ БОГАТЫРЬ 0,5КГ',
				'284112' => 'Семена в банках РЕДИС КРАСНЫЙ ГИГАНТ 0,5 КГ БАНКА ИТАЛИЯ',
				'284119' => 'Семена в банках ТОМАТ БЫЧЬЕ СЕРДЦЕ 0,2КГ ИТАЛИЯ',
				'284121' => 'Семена в банках ТОМАТ ДАР ЗАВОЛЖЬЯ РОЗОВЫЙ 0,250Г',
				'284123' => 'Семена в банках ТОМАТ МАЛИНОВЫЙ ЗВОН 0,2КГ РОССИЯ',
				'284130' => 'Семена в банках ТЫКВА РУЖ ВИЧ ДЕ ТАМП 0,2КГ ИТАЛИЯ',
				'284131' => 'Семена в банках ТЫКВА ШТИРИЙСКАЯ 0,250Г',
				'284132' => 'Семена в банках УКРОП АЛЛИГАТОР 0,250 КГ БАНКА РОССИЯ',
				'284134' => 'Семена в банках УКРОП ТАТРАН 0,250 КГ БАНКА ЧЕХИЯ',
				'282676' => 'Семена гороха МАЙСКИЙ СКОРОСПЕЛЫЙ 40Г',
				'282677' => 'Семена гороха МЕДОВАЯ ЛОПАТКА 40Г',
				'282779' => 'Семена капусты Краснокачанная ТОПАЗ – 0,5 г',
				'282701' => 'Семена лекарственных растений ВАЛЕРИАНА кардиола – 0,1 г',
				'282713' => 'Семена лекарственных растений МЕЛИССА – 0,1 г',
				'282715' => 'Семена лекарственных растений ОГУРЕЧНАЯ ТРАВА БОРАГО -0,1ГР',
				'282720' => 'Семена лекарственных растений ТАБАК КУРИТЕЛЬНЫЙ «ВИРДЖИНИЯ ГОЛД» 0,1 г',
				'282721' => 'Семена лекарственных растений ТАБАК КУРИТЕЛЬНЫЙ «ДЮБЕК» 0,1 г',
				'282723' => 'Семена лекарственных растений ТИМЬЯН-0,1ГР',
				'282729' => 'Семена лекарственных растений ШАЛФЕЙ-0,1ГР',
				'282821' => 'Семена лука БАТУН – 700-900 семян',
				'282827' => 'Семена лука ЛУК НА ЗЕЛЕНЬ «БЕЛЫЙ ЛИСБОН» – 700-900 семян',
				'282830' => 'Семена лука РЕД БАРОН – более 500 семян',
				'282833' => 'Семена лука ЭТАЛОН ГОЛД 8Г',
				'282834' => 'Семена лука ЯЛТИНСКИЙ – 200-250 семян',
				'282847' => 'Семена моркови КАРОТЕЛЬ 10Г+ СКАРЛА 2Г СЕРИЯ ДУЭТ',
				'282848' => 'Семена моркови КОРОЛЕВА ОСЕНИ – 15 г',
				'282849' => 'Семена моркови КРАСНЫЙ ВЕЛИКАН – 15 г',
				'282856' => 'Семена моркови МОСКОВСКАЯ ЗИМНЯЯ – 15 г',
				'282857' => 'Семена моркови НАНТСКАЯ – 15 г',
				'282860' => 'Семена моркови СЛАСТЕНА – 15 г',
				'282861' => 'Семена моркови ТИП-ТОП – 15 г',
				'282863' => 'Семена моркови ШАНТЕНЭ 2461 – 15 г',
				'282865' => 'Семена моркови ШАНТЕНЭ КОРОЛЕВСКАЯ 10Г+ ВИТА ЛОНГА 2ГСЕРИЯ ДУЭТ',
				'282876' => 'Семена огурцов БЕЛЫЙ АНГЕЛ F1 10ШТ',
				'282906' => 'Семена огурцов ДРУЖНАЯ СЕМЕЙКА F1 25-30ШТ + КУРАЖ F1 25-30ШТ СЕРИЯ ДУЭТ',
				'282919' => 'Семена огурцов ЗЯТЁК F1 25-30ШТ + ТЁЩА F1 25-30ШТ СЕРИЯ ДУЭТ',
				'282946' => 'Семена огурцов МАШЕНЬКА F1 25-30ШТ + ВИНОГРАДНАЯ ГРОЗДЬ 25-30ШТ F1 СЕРИЯ ДУЭТ',
				'282958' => 'Семена огурцов ОБИЛЬНЫЙ F1 – 15-17 семян',
				'282973' => 'Семена огурцов САМО СОВЕРШЕНСТВО F1 50-70ШТ',
				'282982' => 'Семена огурцов СТЕПНОЙ F1 - 50-70 шт',
				'283010' => 'Семена переца ДЖЕК - 40-50 шт',
				'283040' => 'Семена редиса ЖАРА – 15 г',
				'283041' => 'Семена редиса ЗАРЯ – 15 г',
				'283044' => 'Семена редиса КРАСНЫЙ С БЕЛЫМ КОНЧИКОМ – 15 г',
				'283052' => 'Семена редиса ФРАНЦУЗСКИЙ ЗАВТРАК – 15 г',
				'283065' => 'Семена салата АЗАРТ 10Г',
				'283070' => 'Семена салата Индау (Руккола) С ОЛИВКОВЫМ ЛИСТОМ – 10 г',
				'283073' => 'Семена салата ЛАТУК 10Г',
				'283076' => 'Семена салата ОДЕССКИЙ КУЧЕРЯВЕЦ 8Г+МАЛИНОВЫЙ ШАР 2ГСЕРИЯ ДУЭТ',
				'283084' => 'Семена свеклы БОРДО 237 – 15 г',
				'283088' => 'Семена свеклы ЕГИПЕТСКАЯ ПЛОСКАЯ – 15 г',
				'283090' => 'Семена свеклы КОРМОВАЯ УРСУС ПОЛИ 0,2КГ',
				'283091' => 'Семена свеклы КОРМОВАЯ УРСУС ПОЛИ 1КГ',
				'283093' => 'Семена свеклы КОРМОВАЯ ЦЕНТАУР ПОЛИ 0,2КГ',
				'283094' => 'Семена свеклы КОРМОВАЯ ЦЕНТАУР ПОЛИ 1КГ',
				'283099' => 'Семена свеклы МАНГОЛЬД РАДУГА 1Г',
				'283101' => 'Семена свеклы НОСОВСКАЯ ПЛОСКАЯ – 15 г',
				'283104' => 'Семена свеклы ЦИЛИНДРА – 10 г',
				'283116' => 'Семена спаржевой фасоли БЛАУХИЛЬДЕ 10Г НОВИНКА',
				'283124' => 'Семена томата АГАТА – 400-450 семян',
				'283149' => 'Семена томата ГРУША ЧЁРНАЯ 0,1Г',
				'283162' => 'Семена томата ДЕВИЧЬЕ СЕРДЦЕ – 0,1 г',
				'283164' => 'Семена томата ДЖИНА 200-250ШТ',
				'283196' => 'Семена томата ЛЯНА – 1 г',
				'283203' => 'Семена томата МОБИЛ – 400-450 семян',
				'283214' => 'Семена томата ПРИНЦЕССА ТУРАНДОТ 0,1Г',
				'283215' => 'Семена томата ПУСТОТЕЛЫЙ БЕЛЫЙ -0.1 гр',
				'283818' => 'Семена томата РОЗОВЫЙ СЛОН 0,1Г',
				'283822' => 'Семена томата САНЬКА 400-450ШТ + АБАКАНСКИЙ РОЗОВЫЙ 0,1Г СЕРИЯ ДУЭТ',
				'283828' => 'Семена томата СКАЗКА 400-450ШТ+ ТОМАТ КРАСНЫЕ СВЕЧИ 0,1Г СЕРИЯ ДУЭТ',
				'283847' => 'Семена томата ЦИФОМАНДРА – 30 семян',
				'283871' => 'Семена тыквы ТИТАН 10Г',
				'283915' => 'Семена цветов БАРХАТЦЫ «ГЛАЗ ТИГРА» – 0,2 г',
				'284150' => 'Семена цветов гранулированные ПЕТУНИЯ КРУПНОЦВЕТКОВАЯ НИЗКОРОСЛАЯ РАДОСТЬ F1 10ШТ',
				'284154' => 'Семена цветов гранулированные ПЕТУНИЯ МНОГОЦВЕТКОВАЯ НИЗКОРОСЛАЯ АЛЕНКА F1 10ШТ',
				'284166' => 'Семена цветов гранулированные СУРФИНИЯ КРУПНОЦВЕТКОВАЯ ВЕЛВЕТ ПАРПЛ F1 10ШТ',
				'284170' => 'Семена цветов гранулированные СУРФИНИЯ КРУПНОЦВЕТКОВАЯ РОУЗ ВЕЙН ВЕЛВЕТ F1 10ШТ',
				'283986' => 'Семена цветов МАТТИОЛА – 5 г');
			//смотрим список позиций без фото
			foreach ($arrayName as $key => $value) {
				echo $key,'--- ', $value, '</br>';
			}
			echo  'В прайсе на добавление ', count($arrayName),'</br>';
			
			//получаем сылки категорий	
			$semena_cat= array();
			if(!$semena_cat = $Parser->pnsemena_cat($sim_url)){
				continue;
			}
			// //добавляем две категории с главного меню
			array_push($semena_cat, 'http://pnsemena.com.ua/semena_v_bankakh.html');
			array_push($semena_cat, 'http://pnsemena.com.ua/glavnaya/semena_petunii.html');
			//префикс перед названием каждого товара
			$pref_cat = array(
				'Семена арбуза',
				'Семена базилика',
				'Семена баклажана',
				'Семена гороха',
				'Семена дыни',
				'Семена лекарственных растений',
				'Семена кабачка',
				'Семена капусты',
				'Семена капусты цветной',
				'Семена кукурузы',
				'Семена лука',
				'Семена моркови',
				'Семена огурцов',
				'Семена патисонов',
				'Семена переца',
				'Семена петрушки',
				'Семена редиса',
				'Семена редьки',
				'Семена салата',
				'Семена свеклы',
				'Семена сельдеря',
				'Семена спаржевой фасоли',
				'Семена томата',
				'Семена тыквы',
				'Семена укропа',
				'Семена цветов',
				'Семена щавеля',
				'Семена в банках',
				'Семена цветов гранулированные');
			//Id категорий на нашем сайте
			$Id_cat = array(
				1819,
				1820,
				1821,
				1822,
				1823,
				1824,
				1825,
				1826,
				1827,
				1828,
				1829,
				1830,
				1831,
				1832,
				1833,
				1834,
				1835,
				1836,
				1837,
				1838,
				1839,
				1840,
				1841,
				1842,
				1843,
				1844,
				1845,
				1846,
				1847);
			//обеденяем информацию по одной категории
			$cat_id_pref_url=array();
			$i=0;
			foreach ($Id_cat as $key => $value) {
				// echo  $Id_cat[$i],' ----- ', $semena_cat[$i],' ----- ', $pref_cat[$i], '</br>';
				$x = array($Id_cat[$i], $semena_cat[$i], $pref_cat[$i]);
				// echo  $x[0],' ----- ', $x[1],' ----- ', $x[2], '</br>';
				array_push($cat_id_pref_url, $x);
				$i++;
				unset($x);
			}
			//смотрим результат обеденяем информацию по одной категории
			foreach ($cat_id_pref_url as $key => $value) {
				echo  $value[0],' - ', $value[1], ' - ', $value[2], '</br>';
			}

			//проходим по страницам категорий и выбераем информацию о товарах
			$semena_prod = array();
			foreach ($cat_id_pref_url as $value) {
				if(!$sem_prod = $Parser->pnsemena_prod($value)){
				continue;
				}
				$semena_prod = array_merge($semena_prod, $sem_prod);
			}
			echo  'В прайсе  ', count($semena_prod),'</br>';
			
			//Отбераем товары на добавление
			// $semena_prod_update = array();
				foreach ($semena_prod as $key => $value) {
					if (!in_array($value[1], $arrayName)) {
						unset($semena_prod[$key]);
						// array_push($semena_prod_update, $value);
					}
			}
			foreach ($semena_prod as $key => $value) {
				echo $key, "<br />", $value[0], "<br />", $value[1],"<br />", $value[2],"<br />", $value[3], "<br />";
			}

			echo  'В прайсе на добавление', count($semena_prod),'</br>';
die();
			
			die();
			// парсим новый товар
			foreach ($semena_prod as $key => $value) {
				if($ldi> $_POST['num']){
					die();
				}
				
				echo 'Карточка ', $ldi++, "<br />";
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
				$id_category = $value[0];
				// if(in_array(trim($offer['id']), $supcomments)){
				// 	echo $offer['id'], ' Товар есть в базе', "<br />";
				// 	continue;
				// 	}
				// die();
				if(!$product = $Parser->pnsemena($value)){
					continue;
				}
				// echo 'url->', $value, "<br />";					
				// echo $id_supplier, "<br />";
				// echo $id_category, "<br /><br />";

				// echo $product['sup_comment'], "<br />";
				// echo $product['name'], "<br />";
				// echo $product['price_mopt_otpusk'], "<br />";
				// echo $product['price_opt_otpusk'], "<br />";
				// echo $product['descr'], "<br />";
				// echo $product['active'], "<br />";
				// // echo count($product['specs'] , COUNT_RECURSIVE), "<br />","<br />";
				// // foreach($product['specs'] as $specification){
				// // 	echo "<pre>";
				// // 	print_r($Specification);
				// // 	echo "</pre>";
				// // }
				// echo count($product['images'], COUNT_RECURSIVE), "<br />";
				// foreach ($product['images'] as $value) {
				// 	echo "<pre>";
				// 	print_r($value);
				// 	echo "</pre>";
				// }

			// die();
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
		break;
		case 31:
			echo "зашли в case X67 positive-parfum.prom.ua XML <br />";
			
			// //Устанавливаем настройки памяти
			// echo "memory_limit ", ini_get('memory_limit'), "<br />";
			// ini_set('memory_limit', '3024M');	
			// echo "memory_limit ", ini_get('memory_limit'), "<br />";
			// //Устанавливаем настройки времени
			// echo "max_execution_time ", ini_get('max_execution_time'), "<br />";
			// ini_set('max_execution_time', 6000);
			// echo "max_execution_time ", ini_get('max_execution_time'), "<br />";

			// ini_set('display_errors','on');
			// ini_set('error_reporting',E_ALL);
			// set_time_limit(0);
			//Открываем файл
			if (!$sim_url = simplexml_load_file("https://positive-parfum.prom.ua/yandex_market.xml?hash_tag=d4108794b72e28bffb1a38e4f7fee387&sales_notes=&product_ids=&group_ids=&label_ids=&exclude_fields=&html_description=0&yandex_cpa=&process_presence_sure=")){
				echo "Не удалось открыть файл<br />\n";
				die();
			}
			echo "Файл загружен <br />";
			//Выборка кодов категори
			// foreach ($sim_url->xpath('/yml_catalog/shop') as $element) {
			// 	foreach ($element->xpath('categories/category ') as $category ) {
			// 		echo  $category['parentId'], '; ', $category, '; ', $category['id'], "<br />";	
			// 	}
			// }
			// echo "ГОТОВО <br />";
			//создаем масивы соотметствия категорий
			$array_cat = array(27578976 => 1050,27578977 => 1529,27578978 => 1530,27578979 => 1050);
				//можем просмотреть
				// foreach ($array_cat as $key => $value) {
				// 	echo $key, " =>  ", $value, ",";
				//  }

			// выбераем имеющиеся у нас артикул
			$supcomments = $Products->GetSupComments($id_supplier);
			if(is_array($supcomments)){
				$supcomments = array_unique($supcomments);
			}
			echo 'Загрузили в масив асортимент поставщика', count($supcomments), "<br />","<br />";
						
			ob_end_clean();
			ob_implicit_flush(1);
			
			if(!$supcomments){
				echo "Массив загруженых товаров поставщика пуст<br />";
				continue;
			}
			//Выбераем товар на добавление
		 	$array_offer  =  array();
		 	$array_offer_net  =  array();
			foreach ($sim_url->xpath('/yml_catalog/shop') as $element) {
				foreach ($element->xpath('offers/offer') as $offer) {
					if(!in_array($offer->vendorCode, $supcomments)){
						// echo $offer->vendorCode, "<br />";
						array_push($array_offer, $offer);
					}
				}
			}
			echo " МЫ хотим добавить товаров", count($array_offer), "<br />";

		// 	print_r('<pre>');
		// 	print_r($array_offer);
		// 	print_r('</pre>');

		
		// die();
			
		foreach ($array_offer as $offer) {
			$ldi++;
			if($ldi> $_POST['num']){
				echo "";
			die();
			}
			echo "CТАРТ ----------------------------------------------------------------------------------------------------------------------------";
			//Определяем категорию карточки товара на xt.ua
			foreach($array_cat as $k=>$value){
				if ($k == $offer->categoryId){
					$id_category = $value;
				 	break;
				}
			}
			
			sleep(3);
			// ob_end_clean();
			ob_implicit_flush(1);
			//Устанавливаем настройки времени		
			ini_set('max_execution_time', 120);
			// чистим переменые
			unset($to_resize);
			unset($images_arr);
			unset($article);
			unset($assort);
			unset($product);
			unset($skipped);

			if(!$product = $Parser->Intertool_XML($offer)){
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
		default:
			 die();
		break;
	}
	print_r('<pre>Итого обработано: '.$ldi.'</pre>');
	print_r('<pre>товарів додано: '.$d.'</pre>');
	print_r('<pre>товарів не вдалося додати: '.$l.'</pre>');
	print_r('<pre>товарів пропущено: '.$i.'</pre>');
	ini_set('memory_limit', '192M');
	ini_set('max_execution_time', 30);
}




//подключение интерфейса
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_site_parser.tpl');
