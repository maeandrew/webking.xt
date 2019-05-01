<?php
	error_reporting(-1);	
	$Parser = new Parser();
	global $Specification;
	$Specification = new Specification();
	$Suppliers = new Suppliers();
	global $Images;
	$Images = new Images();
	$Products = new Products();
	$id_supplier = 21763;

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
	}else{
		$supcomments = array_unique($supcomments);
		echo 'У поставщика в кабегнете товаров ', count($supcomments), "<br />","<br />";
	}

	//ответстие категорий
	 $array_cat = array(123=>1746,136=>1747,139=>1748,58=>1736,59=>1735,60=>1737,61=>1738,62=>1739,64=>1740,70=>1741,75=>1742,81=>1743,89=>1744,93=>1749,95=>1745,77=>1741, 129=>1749, 66=>1736, 151=>1865, 150=>1865, 63=>1737, 94=>1736, 147=>1741, 149=>1737, 148=>1749, 91=>1741, 67=>1741, 83=>1741, 116=>1749, 155=>.1749, 113=>1749, 108=>1865, 88=>1865, 105=>1748, 106=>1748, 104=>1749, 154=>1741, 102=>1741, 101=>1741, 119=>1749, 115=>1749, 112=>1749, 133=>1737, 126=>1737, 132=>1735, 117=>1749, 146=>1741, 65=>1736, 145=>1865, 144=>1865, 85=>1865, 84=>1741, 143=>1749, 82=>1749, 100=>1438, 107=>990, 103=>1741, 152=>1741, 111=>1749, 118=>1749, 128=>1737, 127=>1737, 202=>1745, 130=>1737);

	 $html = 'https://presto-ps.ua/index.php?route=extension/feed/x_torg';
	 
	// загружаем файл
	if ($sim_url = simplexml_load_file($html)){
		echo "Файл загружен <br />";
	}else{
		echo "Не удалось открыть файл<br />\n";
		die();
	}

	// $html = $GLOBALS['PATH_post_img'].'A100.xml';
	// if (!$sim_url = simplexml_load_file($html)){
	// 	echo "Не удалось открыть файл<br />\n";
	// 	die();
	// }
	echo "Файл обработан simplexml_load_file  <br/>";

	//Выборка кодов категори
	foreach ($sim_url->xpath('/yml_catalog/shop') as $element) {
		foreach ($element->xpath('categories/category ') as $category ) {
			$n = 0;					
			foreach ($element->xpath('offers/offer') as $offer) {
				// echo $category['id'], ' - ', $offer->categoryId,  "<br />";
				if (trim($category['id']) == trim($offer->categoryId)) {
					$n++;
				}
			}
			echo  $category['parentId']?$category['parentId']:0, '; ', $category, '; ', $category['id'], '; ', $n,  "<br />";	
		}
	}
	echo "ГОТОВО <br />";
  
  	echo 'Сортируем на обнавление и добавление<br/>';//проходим по файлу и сортируем на обнавление и добавление
	$n_c = $n_jpg = 0; //нет категории  количество фото
	$not_cat= $not_cat_offer = $offer_on = $offer_add = $n_offer = array();
	$currency_USD = 0; //урс долара
	foreach($sim_url->xpath('/yml_catalog/shop') as $element){
		//получаем курс 
		foreach($element->xpath('currencies/currency') as $currency){
			if ($currency['id'] == 'USD') {
				echo 'Курс USD -> ', $currency_USD = $currency['rate'], '<br/>';
			}
		}
		foreach($element->xpath('offers/offer') as $offer){	
			array_push($n_offer, $offer);
			if (in_array(strval($offer->vendorCode), $supcomments)) {//Товары на обновление
				// echo $offer['id'], "на обновление <br/>";
				array_push($offer_on, $offer);
			}else{//Товары на добавление	
				if (array_key_exists(strval($offer->categoryId), $array_cat)) {
				// echo $offer['id'], "на добавление <br/>";
				array_push($offer_add, $offer);
				}else{//Товары без категории
				// echo $offer['id'], "Нет категории <br/>";
				array_push($not_cat, $offer->categoryId);
				array_push($not_cat_offer, $offer);
				}
			}
		}
	}
	$not_cat = array_unique($not_cat);
	
		// foreach ($offer_add as $key => $value) {
		// 	if ($id_product = $Products->GetIDByNema($f)) {
		// 		array_push($array_dublt_id, $id_product);
		// 	}
		// }
	echo "<br/><br/><br/>";
	echo 'Всего товаров в файле: ', count($n_offer), "<br/>";
	echo 'Товаров на обновление: ', count($offer_on), "<br/>"; 
	echo 'Товаров на добавление: ', count($offer_add), "<br/>"; 
	echo 'Товаров нет категории: ', count($not_cat_offer), "<br/>";
	echo 'Нет категорий: ', count($not_cat), "<br/>"; 
	echo "<br/><br/><br/>";

	 
	//Смотрим нет категории

		foreach ($not_cat as $key => $value) {
		echo  'Категория:', $value, "<br/>";
	}
	//Смотрим товары без категории
	// foreach ($not_cat_offer as $key => $value) {
	// 	echo 'Категория: ', $offer->categoryId, ' товар: ',$offer->name, "<br/>";
	// }
	 
	// die();
	echo 'Формируем запросы на обновление категории, ЦЕННЫ И НАЛИЧИЯ<br/>';//Сответствие запросы на обновление категории и наличия
	$sql_arrey = array();
	$sql_arrey[] = "UPDATE "._DB_PREFIX_."assortiment SET no_xtorg = 0 WHERE id_supplier = ".$id_supplier;
	foreach ($offer_on as $offer) {
		//выбераем нашу категорию
	foreach($array_cat as $k=>$value){
		if ($k == $offer->categoryId){
			$id_cat = $value;
			break;
		}
	}
	   	$key = $offer->vendorCode;
	    if (in_array($key, $supcomments)) { 
	        $id_product = $Products->GetIdBysup_comment($id_supplier, $key);//получаем id_product по sup_comment
	        // echo $id_product, '<br/>';	        
	        $sql_arrey[] = "delete from "._DB_PREFIX_."cat_prod WHERE id_product = ".$id_product;
	        $sql_arrey[] = "INSERT IGNORE INTO "._DB_PREFIX_."cat_prod(id_category, id_product, main, test) VALUES(".$id_cat.", ".$id_product.", ".'1'.", '')";
			$sql_arrey[] = "UPDATE "._DB_PREFIX_."assortiment SET product_limit = 100000, active = 1, no_xtorg = 1, price_opt_otpusk = '".round(strval($offer->priceOPT), 2)."', price_mopt_otpusk = '".round(strval($offer->priceOPT), 2)."', inusd = 0  WHERE id_supplier = ".$id_supplier." and id_product = ".$id_product;
	    }      
	} 
	//выключаем не обновленые позиции
    $sql_arrey[] = "UPDATE "._DB_PREFIX_."assortiment SET product_limit = 0, active = 0 WHERE id_supplier = ".$id_supplier." and no_xtorg = 0";

	//можем посмотреть спысок запросов  
	echo '++++++++++++++++++++++++++++++++++++++++Товаров на обновление: ', count($offer_on), "<br/>"; 
	foreach ($sql_arrey as $key => $value) {
	echo $value, '<br/>';
		if(!stristr($value, 'UPDATE') === FALSE) {
  		  echo '<br/>';
 		}
	}
	
	//Обновляем расположение по категриям ЦЕНЫ И НАЛИЧИЕ
	if($Products->ProcessAssortimentXML($sql_arrey)){
	 echo "ОБНОВЛЕНЫ категрии и наличие  <br />";
	}	

	
// die(); 
	echo 'СТАРТ добавления: <br/>';
	$i = $l = $d = $ldi = 0;			
	foreach ($offer_add as $offer) {
		// if(0 < $ldi++){
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
	if(!$product = $Parser->presto($offer, $currency_USD)){
			echo "Товар пропущен product пустой<br />";
			$i++;
			continue;
	}
	//выбераем нашу категорию
	foreach($array_cat as $k=>$value){
		if ($k == $offer->categoryId){
			$id_category = $value;
			break;
		}
	}				
//посмотрим продаукт
	$show_product = $Parser->show_product($product);
// die('STOP');
		// Добавляем новый товар в БД
		if($id_product = $Products->AddProduct($product)){
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
	foreach ($not_cat as $key => $value) {
		echo 'id_category ', $value, "<br />";
	}
?>