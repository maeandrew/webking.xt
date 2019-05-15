<?php
	error_reporting(-1);	
	$Parser = new Parser();
	global $Specification;
	$Specification = new Specification();
	$Suppliers = new Suppliers();
	global $Images;
	$Images = new Images();
	$Products = new Products();
	$id_supplier = 220;

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

	//сответстие категорий
	 $array_cat = array(79=>1288, 80=>1288, 81=>1288, 82=>1288, 83=>1288, 84=>1288, 85=>1288, 86=>1288, 87=>1288, 88=>1288, 89=>1288, 90=>1288, 91=>1259, 92=>1259, 93=>1259, 94=>1259, 95=>1259, 96=>1259, 97=>1259, 98=>1259, 99=>1714, 100=>1714, 101=>1714, 102=>1713, 103=>1714, 104=>1714, 105=>891, 106=>1714, 107=>1714, 108=>1714, 109=>1714, 112=>1055, 113=>1055, 114=>1716, 115=>1054, 117=>1321, 119=>592, 120=>771, 121=>775, 122=>760, 123=>796, 124=>763, 125=>762, 126=>1334, 127=>804, 128=>811, 130=>759, 131=>782, 132=>812, 133=>1288, 134=>1288, 135=>1470, 136=>1470, 137=>1470, 138=>1470, 139=>1470, 141=>1093, 142=>1288, 143=>1550, 144=>1470, 145=>1093, 146=>1288, 147=>1288, 148=>1288, 149=>1288, 150=>1288, 151=>1288, 152=>1288, 153=>1288, 154=>1288, 155=>1792, 156=>1288, 158=>1288, 159=>1093, 160=>1093, 161=>1093, 163=>1093, 164=>1093, 165=>1093, 166=>1093, 167=>1093, 169=>1093, 171=>1093, 172=>1093, 173=>1093, 174=>1093, 175=>1093, 176=>1093, 177=>1093, 178=>1093, 179=>1093, 180=>1093, 181=>1093, 182=>1093, 183=>1093, 184=>1093, 185=>1093, 186=>1093, 187=>1093, 188=>1093, 189=>1093, 190=>1093, 191=>1093, 192=>1093, 193=>1093, 194=>1093, 195=>1093, 196=>1093, 197=>1093, 198=>1093, 199=>1093, 200=>1093, 201=>1093, 202=>1093, 203=>1093, 204=>1093, 205=>1093, 206=>1093, 207=>1093, 208=>1093, 209=>1093, 211=>1093, 212=>1093, 213=>1093, 214=>1362, 215=>1362, 216=>1362, 217=>1362, 219=>1084, 220=>1259, 221=>1259, 222=>1259, 223=>1259, 224=>1259, 225=>1259, 226=>1259, 227=>1259, 228=>1259, 229=>1259, 230=>1259, 231=>1259, 232=>1259, 233=>1259, 234=>1259, 235=>1134, 236=>1344, 238=>1259, 239=>1259, 240=>1323, 241=>1323, 242=>1323, 243=>1323, 244=>1288, 246=>1288, 247=>1288, 248=>1288, 249=>1322, 250=>1288, 251=>1288, 252=>1362, 253=>1365, 254=>657, 255=>784);

	 $html = 'https://supertorba.com.ua/index.php?route=feed/yandex_yml';
	 
	// загружаем файл
	if ($sim_url = simplexml_load_file($html)){
		echo "Файл загружен <br />";
	}else{
		echo "Не удалось открыть файл<br/>";
		die();
	}

	// $html = $GLOBALS['PATH_post_img'].'A100.xml';
	// if (!$sim_url = simplexml_load_file($html)){
	// 	echo "Не удалось открыть файл<br />\n";
	// 	die();
	// }
	echo "Файл обработан simplexml_load_file  <br/><br/>";

	//Выборка кодов категори
	echo '*********************************************************';
	$show_product = $Parser->categories($sim_url);
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
	
	echo "<br/><br/><br/>";
	echo 'Всего товаров в файле: ', count($n_offer), "<br/>";
	echo 'Товаров на обновление: ', count($offer_on), "<br/>"; 
	echo 'Товаров на добавление: ', count($offer_add), "<br/>"; 
	echo 'Товаров нет категории: ', count($not_cat_offer), "<br/>";
	echo 'Нет категорий: ', count($not_cat), "<br/>"; 
	echo "<br/><br/><br/>";


 	// foreach ($offer_add as $key => $value) {
		// 	if ($id_product = $Products->GetIDByNema($f)) {
		// 		array_push($array_dublt_id, $id_product);
		// 	}
		// }
	 
	//Смотрим нет категории
	// 	foreach ($not_cat as $key => $value) {
	// 	echo  'Категория:', $value, "<br/>";
	// }

	//Смотрим товары без категории
	// foreach ($not_cat_offer as $key => $value) {
	// 	echo 'Категория: ', $offer->categoryId, ' товар: ',$offer->name, "<br/>";
	// }
	 
	// die();
	echo 'Формируем запросы на обновление категории, ЦЕННЫ И НАЛИЧИЯ<br/>';//Сответствие запросы на обновление категории и наличия
	$array_id_supcomments = array();
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
        $id_product2 = $Products->GetIDByNema($offer->name);//получаем id_product по sup_comment
        
        $array_id_supcomments[] = array($offer->vendorCode, $id_product, $id_product2);
        // echo $id_product, '<br/>';	        
        $sql_arrey[] = "delete from "._DB_PREFIX_."cat_prod WHERE id_product = ".$id_product;
        // $sql_arrey[] = "INSERT IGNORE INTO "._DB_PREFIX_."cat_prod(id_category, id_product, main, test) VALUES(".$id_cat.", ".$id_product.", ".'1'.", '')";
		$sql_arrey[] = "UPDATE "._DB_PREFIX_."assortiment SET product_limit = 100000, active = 1, no_xtorg = 1, price_opt_otpusk = '".round(strval($offer->price), 2)."', price_mopt_otpusk = '".round(strval($offer->price), 2)."', inusd = 0  WHERE id_supplier = ".$id_supplier." and id_product = ".$id_product;
    }      
	} 
	//выключаем не обновленые позиции
    $sql_arrey[] = "UPDATE "._DB_PREFIX_."assortiment SET product_limit = 0, active = 0 WHERE id_supplier = ".$id_supplier." and no_xtorg = 0";

	//можем посмотреть спысок запросов  
	echo 'Товаров на обновление: ', count($offer_on), "<br/>"; 
	foreach ($sql_arrey as $key => $value) {
	echo $value, '<br/>';
		if(!stristr($value, 'UPDATE') === FALSE) {
  		  echo '<br/>';
 		}
	}
	//смотрим масив id и код поставщика
	foreach ($array_id_supcomments as $key => $value) {
		echo $value[0], ' => ', $value[1], ' = ',$value[2],  $value[1] == $value[2]? 'ок':'ОШИБКА','<br/>' ;
	}
	 die('ГОТОВО STOP');

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
 	// 		die();
 	// 	}
	
	echo "*******СТАРТ********<br />";
	if(!$product = $Parser->supertorba_xml($offer)){
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