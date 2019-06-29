<?php
	error_reporting(-1);	
	$Parser = new Parser();
	global $Specification;
	$Specification = new Specification();
	$Suppliers = new Suppliers();
	global $Images;
	$Images = new Images();
	$Products = new Products();
	$id_supplier = 13315;
//Устанавливаем настройки памяти
	// echo "memory_limit ", ini_get('memory_limit'), "<br />";
	ini_set('memory_limit', '3072M');	
	// echo "memory_limit ", ini_get('memory_limit'), "<br />";

	//Устанавливаем настройки времени
	// echo "max_execution_time ", ini_get('max_execution_time'), "<br />";
	ini_set('max_execution_time', 6000);
	// set_time_limit(6000);
	// echo "max_execution_time ", ini_get('max_execution_time'), "<br />";

	// echo "post_max_size ", ini_get('post_max_size'), "<br />";
	// echo "set_time_limit ", ini_get('set_time_limit'), "<br />";
	// ob_end_flush();
	// ob_end_clean();
	ob_implicit_flush(1);	

	ini_set('display_errors','on');
	ini_set('error_reporting',E_ALL);
	echo "Загружаем файл: http://bluzka.ua/ru/yml/ <br/>";

	// выбераем имеющиеся у нас артикул
	if(!$supcomments = $Products->GetSupComments($id_supplier)){
		echo "Массив загруженых товаров поставщика пуст<br />";
		continue;
	}
	$supcomments = array_unique($supcomments);
	echo 'У поставщика в кабегнете товаров ', count($supcomments), "<br />","<br />";
	//сответстие категорий
	 $array_cat = array(61=>1905,62=>1906,63=>1868,64=>1906,65=>1908,66=>1908,67=>1906,68=>1910,69=>1910,71=>1108,72=>1910,74=>1186,75=>1867,76=>1867,77=>1455,78=>1209,79=>1550,80=>1867,81=>1550,82=>1098,83=>1633,84=>1867,85=>1095,86=>1095,87=>1095,88=>1095,89=>1095,90=>1359,91=>1098,92=>1550,100=>1096,101=>1096,102=>1096,103=>1096,104=>1096,105=>1096,106=>1096,108=>1098,109=>1098,111=>1911,112=>1912,113=>1913,114=>1913,115=>1913,116=>1573,117=>1914,118=>1914,120=>1359,121=>1356,122=>1101,123=>1357,128=>1205,130=>1213,132=>1641,133=>1205,134=>1205,135=>1208,136=>1211,137=>1472,138=>1617,139=>1573,140=>1624,141=>1663,142=>1624,144=>1663,145=>1209,146=>1204,147=>1573,148=>1203,149=>1707,150=>1207,151=>1200,152=>1204,153=>1707,154=>1203,155=>1203,156=>1203,157=>1204,158=>1204,159=>1101,164=>1063,166=>1211,168=>1622,169=>1211,170=>1622,172=>1585,173=>1203,174=>1325,175=>1197,176=>1577,177=>1581,178=>1566,179=>1198,180=>1566,189=>1192,190=>1196,191=>1196,192=>1196,193=>1196,194=>1629,199=>1557,200=>1212,201=>1915,202=>1749,203=>941,204=>635,207=>933,208=>677,209=>677,210=>677,211=>1205,212=>1697,213=>1804,214=>632,215=>1801,216=>922,217=>1205,218=>923,219=>921,220=>923,221=>923,222=>923,223=>920,224=>923,225=>933,226=>935,227=>938,228=>1196,229=>930,232=>934,233=>663,234=>940,235=>1210,236=>1210,237=>1210,238=>1210,244=>1612,245=>1210,246=>928,247=>940,248=>940,249=>940,250=>940,251=>940,266=>940,267=>940,268=>1856,269=>1218,270=>1574,271=>1856,272=>1218,273=>1218,274=>1218,275=>1218,276=>1659);

	// загружаем файл
	if ($sim_url = simplexml_load_file('https://bigs-shop.com.ua/index.php?route=extension/feed/yandex_yml&token=55don55')){
		echo "Файл загружен <br />";
	}else{
		die("Не удалось открыть файл<br />");
	}
	//смотрим категории
	$Parser->show_categories($sim_url);
	 // die('STOP');	
	
	//Загрузка файла и обновление цен
	if(isset($_POST["parse"]) && is_uploaded_file($_FILES['file']['tmp_name']) ){
			$objPHPExcel = PHPExcel_IOFactory::load($_FILES['file']['tmp_name']);
			$objPHPExcel->setActiveSheetIndex(0);
			$aSheet = $objPHPExcel->getActiveSheet();
			//этот массив будет содержать массивы содержащие в себе значения ячеек каждой строки
			$array_f = array();
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
				array_push($array_f, $item);
			}
			echo 'Содержимое файла***************************<br/>';
			// $Parser->show_file($array_f);		
	}else{
		die("STOP NO ФАЙЛА<br/>");
	}
	
	//выбераем номера нужных столбцов
	$key_price = $key_sup1  = FALSE;
	foreach ($array_f[0] as $key => $value) {
				if ($value == 'Цена: Цена барабашово') {
					$key_price = $key;
					echo $value, " key_price ", $key_price, '<br/>';
				}
				if ($value == 'Характеристика') {
					$key_sup1 = $key;
					echo $value, " key_sup1 ", $key_sup1, '<br/>';
				}
	}
	if ($key_price === FALSE || $key_sup1 === FALSE) {
		die('STOP файла неправельный');
	}
	asort($array_f['4']);


echo "Товаров в файле", count($array_f), "<br/>";

 // die('STOP');
	echo '+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++СТАРТ добавление:', count($array_f),' <br/>';
	$i = $l = $d = $ldi = 0;	
	$sql_arrey = $arrey_no_offer = array();//для обновления		
	$sql_arrey[] = "UPDATE xt_assortiment SET no_xtorg = 0 WHERE id_supplier = ".$id_supplier;
	//Прорабатывае файл
	foreach ($array_f as $key => $value) {
		echo $ldi, ' ---------------------> ', $value[$key_sup1], ' -> ', $value[$key_price], '<br/>';
		if(10000 < $ldi++){
			break;
 			die("СТОП по КОЛИЧЕСТВУ или о <br/>");
  	}	

  	$offer_add = '';
  	//выбераем нужные даные с масива $offer
  	if (isset($value[$key_sup1]) && !empty($value[$key_sup1])) {
	  	foreach($sim_url->xpath('/yml_catalog/shop') as $element){
				foreach($element->xpath('offers/offer') as $offer){		
					if (stristr(strval($offer->name), strval($value[$key_sup1]))){
						$offer->vendorCode = strval($value[$key_sup1]);
						$offer->priceXT = strval($value[$key_price]);
						foreach($array_cat as $k=>$cat){
							if ($k == $offer->categoryId){
								$categoryId = $cat;
								break;
							}							
						}
						$offer_add = $offer;
						break 2;
					}
				}
			}
  	}
		if (!property_exists($offer_add, 'vendorCode')) {
			echo "<br/>код ", strval($value[$key_sup1]), "соответствия НЕТ<br/>";
			array_push($arrey_no_offer, $value);
			continue;
		}else{
			echo $offer_add->vendorCode,' ОК', "<br/>";
			// $Parser->show_product($offer);	
		}
		// ОБНОВЛЯЕМ или Добавляем новый товар в БД
		if ($offer_add->id_product = $id_product = $Products->GetIDByNema($offer_add->name)) {
			//ОБНОВЛЯЕМ
			//ОБНОВЛЯЕМ
			//ОБНОВЛЯЕМ
			//ОБНОВЛЯЕМ
		}elseif(!in_array($value[$key_sup1], $supcomments)){
			if (!in_array(strval($offer_add->vendorCode), $supcomments)) {	
					//заполняем продукт
					if($product = $Parser->maestro_XML($offer_add)){
							//посмотрим продаукт
							$Parser->show_product($product);			
						}else{
							echo "Товар пропущен product пустой<br />";
							$i++;
							continue;
						}
					if($id_product = $Products->AddProduct($product)){
						echo "Продукт добавлен <br /><br />";
						// Добавляем характеристики новому товару
							if(!empty($product['specs'])){
								foreach($product['specs'] as $specification){
									echo "specs <br />";
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
							$Products->DelFromAssort($id_product, $id_supplier);
							$Products->AddToAssortWithAdm($assort);
							array_push($supcomments, $product['sup_comment']);
							// Получаем артикул нового товара
							$article = $Products->GetArtByID($id_product);
							// Переименовываем фото товара
							$to_resize = $images_arr = array();
							if(isset($product['images']) && !empty($product['images'])){
								$images_arr = $Images->parse_rename($product['images'], $article);
								// Привязываем новые фото к товару в БД
								$Products->UpdatePhoto($id_product, $images_arr, $product['images_visible']);
							}
							// Добавляем товар в категорию
							$Products->UpdateProductCategories($id_product, array($categoryId));
							$d++;
							echo "***********OK. Товар добавлен *************<br /><br />";

				}else{
						echo "Проблема с добавлением продукта <br /><br />";
						$l++;
						continue;
				}
			}
		}
	
		//формируем запрос для обновления цен
		
		if ($key != 0 && in_array($value[$key_sup1], $supcomments)) {
				$id_prod = $Products->GetIdBysup_comment($id_supplier, $value[$key_sup1]);//получаем id_product по sup_comment
	      $sql_arrey[] = "delete from "._DB_PREFIX_."cat_prod WHERE id_product = ".$id_prod;
	      $sql_arrey[] = "INSERT IGNORE INTO "._DB_PREFIX_."cat_prod(id_category, id_product, main, test) VALUES(".$categoryId.", ".$id_prod.", ".'1'.", '')";
				$sql_arrey[] = "UPDATE "._DB_PREFIX_."assortiment SET product_limit = 100000, active = 1, no_xtorg = 1, price_opt_otpusk = '".$value[$key_price]."', price_mopt_otpusk = '".$value[$key_price]."', inusd = 0  WHERE id_supplier = ".$id_supplier." and id_product = ".$id_prod;
		}else{
				
		}	
	}
	// echo "Товаров нет фото ", $n_jpg, "<br/>";
	echo "Товар пропущен product пустой ", $i, "<br />";
	echo "Проблема с добавлением продукта ", $l, "<br />";

 
	//выключаем не обновленые позиции
  $sql_arrey[] = "UPDATE xt_assortiment SET product_limit = 0, active = 0 WHERE id_supplier = ".$id_supplier." and no_xtorg = 0";
	echo 'Товаров на обновление: ',  count($sql_arrey)/3, " из ", count($array_f), "<br/>"; 
	//смотрим запросы
foreach ($sql_arrey as $key => $value) {
			echo $value, '<br/>';
			if(!stristr($value, 'UPDATE') === FALSE) {
 		 	echo '<br/>';
 			}
	}
//Обновляем 
	if($Products->ProcessAssortimentXML($sql_arrey)){
	 echo "ОБНОВЛЕНО наличие  <br />";
	}	
	echo "немогу сопоставить", count($arrey_no_offer), "<br/>";
	// foreach ($arrey_no_offer as $key => $value) {
	// 		echo $value[4], ' -----> ', $value[3], '<br/>';			
	// }

?>