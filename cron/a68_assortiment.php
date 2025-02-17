<?php
	error_reporting(-1);	
	$Parser = new Parser();
	global $Specification;
	$Specification = new Specification();
	$Suppliers = new Suppliers();
	global $Images;
	$Images = new Images();
	$Products = new Products();
	$id_supplier = 10;

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
	echo 'У поставщика в кабегнете товаров ', count($supcomments), "<br />","<br />";
	//ответстие категорий
	 $array_cat = array(53831059=>899,53831058=>899,53831057=>899,53831056=>899,53831055=>1016,53831054=>1606,53831053=>899,53831052=>1606,53831051=>1606,53831050=>1606,53831049=>899,53831048=>899,53831047=>899,53831046=>899,53831045=>899,53831044=>899,53831043=>899,17700076=>1102,29540874=>1102,17700114=>988,17700112=>988,17700111=>988,17700110=>988,17700109=>988,17700108=>988,17700107=>988,17700104=>988,17700103=>987,17700102=>987,17700101=>987,17700100=>988,17700099=>988,17700123=>1644,17700122=>1644,17700121=>1644,17700120=>1644,17700119=>1644,17700024=>1385,17700020=>1091,17700018=>993,17700013=>993,17700010=>1213,17700009=>1200,32753207=>989,24040178=>987,17700019=>1644,17700016=>1471,17700011=>592,17700014=>1644,17700048=>1644,24040218=>987,29540907=>987,20079416=>987,17700012=>987,17700032=>987,17700034=>987,17700036=>987,17700039=>987,17700037=>987,17700041=>987,17700043=>987,17700026=>1200,17700028=>656,17700031=>592,17700073=>1102,17700078=>1102,17700080=>1102,17700022=>989,17700044=>1814,17700047=>1814,17700050=>1814,17700055=>1215,17700057=>1215,17700059=>1644,17700061=>1644,17700063=>989,17700065=>989,17700068=>1644,17700070=>1644,17700115=>988,17700015=>1102,17700046=>1814,17700049=>1814,17700056=>1215,17700058=>1215,17700060=>1215,17700062=>1215,17700064=>1215,17700066=>1215,17700069=>1215,17700071=>990,17700033=>988,17700035=>988,17700038=>988,17700042=>988,17700025=>1200,17700027=>1641,17700030=>592,17700077=>1102,17700079=>1102,17700093=>989,17700092=>1638,17700116=>1814,17700117=>1814,17700118=>1814);

	 $html = 'https://x-balog.com/yandex_market.xml?hash_tag=9ace4d39e2c81d52ab040720c25d7cf8&sales_notes=&product_ids=&group_ids=&label_ids=&exclude_fields=&html_description=0&yandex_cpa=&process_presence_sure=';
	 
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
    // die();
    //получаем курс 
   
  	echo 'Сортируем на обнавление и добавление<br/>';//проходим по файлу и сортируем на обнавление и добавление
	$n_c = $n_jpg = 0; //нет категории  количество фото
	$not_cat= $not_cat_offer = $offer_on = $offer_add = array();
	$currency_USD = 0; //урс долара
	foreach($sim_url->xpath('/yml_catalog/shop') as $element){
		//получаем курс 
		foreach($element->xpath('currencies/currency') as $currency){
			if ($currency['id'] == 'USD') {
				echo 'Курс USD -> ', $currency_USD = $currency['rate'], '<br/>';
			}
		}
		foreach($element->xpath('offers/offer') as $offer){	
			if (in_array($offer['id'], $supcomments)) {//Товары на обновление
				echo $offer['id'], "на обновление <br/>";
				array_push($offer_on, $offer);
			}else{//Товары на добавление	
				if (array_key_exists(strval($offer->categoryId), $array_cat)) {
				echo $offer['id'], "на добавление <br/>";
				array_push($offer_add, $offer);
				}else{//Товары без категории
				echo $offer['id'], "Нет категории <br/>";
				array_push($not_cat, $offer->categoryId);
				array_push($not_cat_offer, $offer);
				}
			}
		}
	}
	echo 'Товаров на обновление: ', count($offer_on), "<br/>"; 
	echo 'Товаров на добавление: ', count($offer_add), "<br/>"; 
	echo 'Нет категории: ', count($not_cat_offer), "<br/>"; 
	//Смотрим товары без категории
	foreach ($not_cat_offer as $key => $value) {
		echo 'Категория: ', $offer->categoryId, ' товар: ',$offer->name, "<br/>";
	}
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
	   	$key = $offer['id'];
	    if (in_array($key, $supcomments)) { 
	        $id_product = $Products->GetIdBysup_comment($id_supplier, $key);//получаем id_product по sup_comment
	        // echo $id_product, '<br/>';	        
	        $sql_arrey[] = "delete from "._DB_PREFIX_."cat_prod WHERE id_product = ".$id_product;
	        $sql_arrey[] = "INSERT IGNORE INTO "._DB_PREFIX_."cat_prod(id_category, id_product, main, test) VALUES(".$id_cat.", ".$id_product.", ".'1'.", '')";
			$sql_arrey[] = "UPDATE "._DB_PREFIX_."assortiment SET product_limit = 100000, active = 1, no_xtorg = 1, price_opt_otpusk = '".round(strval($offer->price) * $currency_USD, 1)."', price_mopt_otpusk = '".round(strval($offer->price) * $currency_USD, 1)."', inusd = 0  WHERE id_supplier = ".$id_supplier." and id_product = ".$id_product;
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

	
die(); 
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
	if(!$product = $Parser->sunopt_XML($offer, $currency_USD)){
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