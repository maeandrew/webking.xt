<?php
	error_reporting(-1);	
	$Parser = new Parser();
	global $Specification;
	$Specification = new Specification();
	$Suppliers = new Suppliers();
	global $Images;
	$Images = new Images();
	$Products = new Products();
	$id_supplier = 3223;

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
	// ob_implicit_flush();

	ini_set('display_errors','on');
	ini_set('error_reporting',E_ALL);
	
	// выбераем имеющиеся у нас артикул
	if(!$supcomments = $Products->GetSupComments($id_supplier)){
		echo "Массив загруженых товаров поставщика пуст<br />";
		die();
	}
	$supcomments = array_unique($supcomments);
	echo 'У поставщика в кабегнете товаров ', count($supcomments), "<br />","<br />";
		$file_exsel = '/var/www/xt.ua/web/post_images/S55.xlsx';
		//Открываем файл Excel
		if(!empty($file_exsel)){
			$objPHPExcel = PHPExcel_IOFactory::load($file_exsel);
			$objPHPExcel->setActiveSheetIndex(0);
			$aSheet = $objPHPExcel->getActiveSheet();			
		}
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
		//Посмотрим результаты обработки файла
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				foreach ($value as $key => $value) {
					// echo $value, '<br/>';
				}
			}
			// echo  $value[0], '**************<br/>';
		}
		//получаем имена фото в указаной папке
	 	$PATH_product_images = '/var/www/xt.ua/web/post_images/s55/';	
		$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($PATH_product_images), RecursiveIteratorIterator::SELF_FIRST);
		//Формируем масив ключ (имя фото) и адрес
		$array_img = array();
		foreach($objects as $name => $object){	
			if(substr($name, -3) == 'jpg'){	
				$key = str_replace($PATH_product_images, '', str_replace('.jpg', '', $name));
				$array_img[$key] = $name;
				// echo $key, ' ', $name, " <br/>";
			}   		 
		}
		foreach ($array_img as $key => $value) {
			echo $key, '->', $value, " <br/>";
		}
		echo 'В прайсе: ', count($array), " <br/>";
		echo 'Фото: ', count($array_img), " <br/>";
		$i = 0;
		$offer_add = array();
		foreach ($array as $key => $value) {
			if (array_key_exists(strval ($value['0']), $array_img) && !in_array($value[0], $supcomments)) {
				$offer_add[] = $value;
				// echo $i++, ' -> ', $value['0'], " Добавить <br/>";
			}
			
		}
		
		// загружаем файл sitemap.xml
		//  $html = 'https://kvitu.in.ua/sitemap.xml';
		// if ($sim_url = simplexml_load_file($html)){
		// 	echo "Файл загружен <br />";
		// }else{
		// 	echo "Не удалось открыть файл<br />\n";
		// 	die();
		// }
		// foreach($sim_url as $url => $massiv){
		// 	foreach($massiv  as  $key => $value){
		// 		if($key == 'loc'){
		// 			echo $value, '<br />';
		// 				// if(!stristr($value, 'manufacturer'))
		// 				// 	array_push($array, $value);
		// 		}
		// 	}
		// }


	

	echo 'СТАРТ добавления: <br/>';
	$i = $l = $d = $ldi = 0;			
	foreach ($offer_add as $offer) {
		// if(1 < $ldi++){
 	// 		echo "СТОП по КОЛИЧЕСТВУ <br/>";
 	// 	 die();
  // 		}

	
	ini_set('max_execution_time', 3000);
	unset($to_resize);
	unset($images_arr);
	unset($article);
	unset($assort);
	unset($product);
	unset($skipped);
	
	echo "***********************СТАРТ******************************<br />";

	$skipped = false;
	if(!$product = $Parser->s55cvet($offer, $array_img)){
		continue;
	}
	
	//выбераем нашу категорию
		echo 'id_category -> ',$id_category = $offer[7], "<br />";			
		echo 'id_supplier -> ',$id_supplier, "<br />";
		echo 'id_category -> ',$id_category, "<br />";	
		echo 'sup_comment -> ', $product['sup_comment'], "<br />";
		echo 'name -> ', $product['name'], "<br />";
		echo 'price_mopt_otpusk -> ', $product['price_mopt_otpusk'], "<br />";
		echo 'price_opt_otpusk -> ', $product['price_opt_otpusk'], "<br />";
		echo 'inbox_qty -> ', $product['inbox_qty'], "<br />";
		echo 'min_mopt_qty -> ', $product['min_mopt_qty'], "<br />";
		echo 'note_control -> ', $product['note_control'], "<br />";
		echo 'descr -> ', $product['descr'], "<br />";
		echo 'active -> ', $product['active'], "<br />";
		echo "Количество характеристик ", count($product['specs']), "<br />";
			foreach ($product['specs'] as $key => $value) {
				foreach ($value as $key => $value) {
					echo $key," ", $value," ";
				}
				echo "<br />";
			}
		echo "Количество фото ", count($product['images']), "<br />";
			foreach ($product['images'] as $key => $value) {
				echo $key," ", $value," <br />";
			}
// continue;
	// die();
		// Добавляем новый товар в БД
		if(!$product || $skipped){
			echo "Товар пропущен product пустой<br />";
			$i++;
			continue;
		}elseif($id_product = $Products->AddProduct($product)){
			// array_push($supcomments, trim($offer->vendorCode));

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
				'product_limit' => 100000,
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
			$d++;
			print_r('<pre>OK. Товар добавлен</pre>');
		}else{
			echo "Проблема с добавлением продукта <br /><br />";
			$l++;
		}
	}
	echo "Товаров нет картинки ", $n_jpg, "<br/>";
	echo "Добавлено товаров ", $d, ' из : ', count($offer_add), "<br/>";
	echo "Товар пропущен product пустой ", $i, "<br />";
	echo "Проблема с добавлением продукта ", $l, "<br />";
	echo "Товаров не добавлено нет категорий ", $n_c, "<br />";
	
?>