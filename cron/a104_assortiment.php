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
	// ob_implicit_flush();

	ini_set('display_errors','on');
	ini_set('error_reporting',E_ALL);
	
	// выбераем имеющиеся у нас артикул
	if(!$supcomments = $Products->GetSupComments($id_supplier)){
		echo "Массив загруженых товаров поставщика пуст<br />";
		continue;
	}
	$supcomments = array_unique($supcomments);
	echo 'У поставщика в кабенете товаров: ', count($supcomments), "<br />","<br />";

	//Посмотрим результаты обработки файла

 	 		 
		echo 'Сортируем на обнавление и добавление<br/>';
		$file = '/var/www/xt.ua/web/post_images/array104';	
	$homepage = file_get_contents($file);
	$array_value = array();
	$array = explode('&', $homepage);
	foreach ($array as $key => $value) {
		// echo $key, ' ', $value, '<br/>';
		$array_value[] = explode(';:', $value);
	}
		// $file_exsel = '/var/www/xt.ua/web/post_images/A104.xlsx';
		// if (!$array = $Parser->lod_exsel($file_exsel)) {
		// 	die('файл exsel не загружен');
		if (!$array_value) {
			die('файл не загружен');
		}else{
			$n_c = $n_jpg = 0;
			$not_cat= $not_cat_offer = $offer_on = $offer_add = array();
			foreach ($array_value as $key => $offer) {
				if (in_array(trim($offer['2']), $supcomments)) {
					// array_push($offer_on, $offer);
					// echo "обновить: ";
				}else{
					array_push($offer_add, $offer);
					echo "добавить: ";
					
				echo $key, ' -> ', $offer[1], ' -> ', $offer[2], ' -> ', $offer[3], ' -> ', $offer[4], '<br/>';
			}
				// print_r('<pre>');
				// print_r($offer);
				// print_r('</pre>');		
			}
		}
	echo  'в прайсе', count($array), 'есть в базе ', count($offer_on),  '<br/>';
	echo 'Товаров на обновление: ', count($offer_on), "<br/>"; 
	echo 'Товаров на добавление: ', count($offer_add), "<br/>"; 
	echo 'Нет категории: ', count($not_cat_offer), "<br/>"; 
die();
	echo 'СТАРТ добавления: <br/>';
	$i = $l = $d = $ldi = 0;			
	foreach ($offer_add as $offer) {
		// if(10 < $ldi++){
 	// 		echo "СТОП по КОЛИЧЕСТВУ <br/>";
 	// 	 	die();
  // 	}
	ini_set('max_execution_time', 3000);
	unset($to_resize);
	unset($images_arr);
	unset($article);
	unset($assort);
	unset($product);
	unset($skipped);	
	echo "***********************СТАРТ******************************<br />";
	if(!$product = $Parser->maestro($offer)){
			echo "Товар пропущен product пустой<br />";
			$i++;
			continue;
	}
	//Устанавливаем категорию
	$id_category = trim($offer[4]);
	//посмотрим продаукт
	$show_product = $Parser->show_product($product);
	// continue;
		// Добавляем новый товар в БД
		if($id_product = $Products->AddProduct($product)){
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
			echo "Проблема с добавлением продукта <br/><br/>";
			$l++;
		}
	}
	echo "Товаров нет картинки ", $n_jpg, "<br/>";
	echo "Добавлено товаров ", $d, ' из : ', count($offer_add), "<br/>";
	echo "Товар пропущен product пустой ", $i, "<br />";
	echo "Проблема с добавлением продукта ", $l, "<br />";
	echo "Товаров не добавлено нет категорий ", $n_c, "<br />";
	foreach ($not_cat as $key => $value) {
		echo 'id_category ', $value, "<br />";
	}
?>