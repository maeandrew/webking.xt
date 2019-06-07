<?php
	error_reporting(-1);	
	$Parser = new Parser();
	global $Specification;
	$Specification = new Specification();
	$Suppliers = new Suppliers();
	global $Images;
	$Images = new Images();
	$Products = new Products();
	$id_supplier = 35489;

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
	echo 'У поставщика в кабегнете товаров ', count($supcomments), "<br /><br />";
	//Cответстие категорий
	 $array_cat = array(40=>718,1204=>717,70=>710,1202=>1248,1211=>708,1216=>708,1217=>708,1218=>708,50=>710,1201=>1248,7=>1300,42=>1251,1215=>708,3=>718,1213=>716,1200=>1248,1212=>719,1541=>712,1538=>1305,43=>1305,1568=>712,29=>1221,1567=>712,2640=>719,1197=>709,47=>708,1566=>716,65=>1305,1199=>1305,2630=>1305,1195=>709,1569=>712,54=>1251,38=>718,3291=>1331,60=>1251,1209=>717,66=>710,58=>710,68=>718,3178=>718,59=>1354,45=>750,3104=>717,1198=>709,56=>710,64=>718,4851=>718,51=>695,1536=>718,1564=>1015,55=>1251,52=>1331,2245=>1331,57=>1331,63=>718,1565=>1331,1537=>710,1196=>709,1205=>717,1206=>717,1207=>717,69=>1331,39=>1221,1540=>1331,1542=>1331,48=>1331,37=>1221,4788=>1331,2327=>1331,49=>1331,2=>1221,5404=>1864,5725=>1221,30=>1221,31=>1221,32=>1221,33=>1221,34=>1221,5618=>1220,5624=>1220,28=>679);

	 $html = 'https://toysgroup.com.ua/export/toysgroup_products.yml';
	 
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
	echo " <br/><br/>**************************************** КАТЕГОРИИ ********************************* <br/>";
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
	// die();
	echo " <br/><br/>**************************************** ТОВАРЫ Сортируем на обнавление и добавление <br/>";   
  	$not_cat= $not_cat_offer = $offer_on = $offer_add = array();
	$currency_USD = 0; //урс долара
	foreach($sim_url->xpath('/yml_catalog/shop') as $element){			
		//получаем курс 
		// foreach($element->xpath('currencies/currency') as $currency){
		// 	if ($currency['id'] == 'USD') {
		// 		echo 'Курс USD -> ', $currency_USD = $currency['rate'], '<br/>';
		// 	}
		// }
		foreach($element->xpath('offers/offer') as $offer){
			if (in_array($offer['id'], $supcomments)) {//Товары на обновление
				// echo $offer['id'], "на обновление <br/>";
				array_push($offer_on, $offer);
			}else{//Товары на добавление	
				if (array_key_exists(strval($offer->categoryId), $array_cat)&& $offer->name != '') {
							//Получаем название товара
			// $name = $offer->name;
			// if (strstr($name, 'BRICK ')) {
			// 	// echo "string";
			// 	$name = str_replace('BRICK ','Конструктор BRICK ', $name);
			// }
			// if (strstr($name, 'JT ')) {
			// 	$name = str_replace('JT ','Игрушка JT ', $name);
			// }
			// if (strstr($name, 'гр "')) {
			// 	$name = str_replace('гр "','Набор "', $name);
			// }
			// if (strstr($name, 'гр ')) {
			// 	$name = str_replace('гр ','', $name);
			// }
			// if (strstr($name, 'Игра наст.')) {
			// 	$name = str_replace('Игра наст.','Игра настольная', $name);
			// }
			// if (strstr($name, 'наст. бол.')) {
			// 	$name = str_replace('наст. бол.','настольная болльшая', $name);
			// }
			// if (strstr($name, 'наст. мал.')) {
			// 	$name = str_replace('наст. мал.','настольная малая', $name);
			// }
			// if (strstr($name, 'Водовоз')) {
			// 	$name = str_replace('Водовоз','Машинка водовоз', $name);
			// }
			// if (strstr($name, 'Водопад')) {
			// 	$name = str_replace('Водопад','Машинка водопад', $name);
			// }
			// if (strstr($name, 'Гараж')) {
			// 	$name = str_replace('Гараж','Набор гараж', $name);
			// }
			// if (strstr($name, 'Внедорожник ')) {
			// 	$name = str_replace('Внедорожник ','Машинка внедорожник ', $name);
			// }
			echo $offer['id'],';', $offer->name,';',$offer->url, "на добавление <br/>";
			// continue;
					array_push($offer_add, $offer);
				}else{//Товары без категории и весь остаток
					// echo $offer['id'], "Нет категории <br/>";
					array_push($not_cat, $offer->categoryId);
					array_push($not_cat_offer, $offer);
				}
			}
		}
	}
	//Открываем файл
	$fail = $GLOBALS['PATH_post_img'].'NameX102.txt';
	if (!$result = fread(fopen($fail, "r"), filesize($fail))){
		echo "Не удалось открыть файл<br />\n";
		die();
	}
	$result = iconv("windows-1251", "utf-8", $result);
	$name = array_unique(explode(";;", $result));
	$arrayName[] = array();
	foreach ($name as $key => $value) {
		$val = explode("=>", $value);
		$arrayName[$val['0']] = $val['1'];		
	}
	// foreach ($arrayName as $key => $value) {
	// 	echo $key, ' ', $value, "<br/>";
	// }

	
	// die();
	echo 'Товаров на обновление: ', count($offer_on), "<br/>"; 
	echo 'Товаров на добавление: ', count($offer_add), "<br/>"; 
	echo 'Нет категории: ', count($not_cat_offer), "<br/>";
	// die();
	//Смотрим товары без категории
	foreach ($not_cat_offer as $key => $offer) {
		echo 'Категория: ', $offer->categoryId, ' товар: ',$offer->name, "<br/>";
	}
	// die();
	echo 'Формируем запросы на обновление категории, ЦЕННЫ И НАЛИЧИЯ<br/>';//Сответствие запросы на обновление категории и наличия
	$id_cat_not_sale = array(1220, 1864);//категории без скидки 10%
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
	        if (!in_array($id_cat, $id_cat_not_sale)) {
	        	$sql_arrey[] = "UPDATE "._DB_PREFIX_."assortiment SET product_limit = 100000, active = 1, no_xtorg = 1, price_opt_otpusk = '".round($offer->price*0.901, 2)."', price_mopt_otpusk = '".round($offer->price*0.901, 2)."', inusd = 0  WHERE id_supplier = ".$id_supplier." and id_product = ".$id_product;
	        }else{
	        	$sql_arrey[] = "UPDATE "._DB_PREFIX_."assortiment SET product_limit = 100000, active = 1, no_xtorg = 1, price_opt_otpusk = '".round($offer->price, 2)."', price_mopt_otpusk = '".round($offer->price, 2)."', inusd = 0  WHERE id_supplier = ".$id_supplier." and id_product = ".$id_product;
	        }
			
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
		// if(10 < $ldi++){
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

	foreach ($arrayName as $key => $value) {
		if ($key == $offer['id']) {
			$offer_name = $value;
		}
	}


	$skipped = false;
	if(!$product = $Parser->toysgroup_XML($offer, $offer_name)){
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
				$images_arr = $Images->parse_rename($product['images'], $article);
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
	echo "Товар пропущен product пустой ", $i, "<br />";
	echo "Проблема с добавлением продукта ", $l, "<br />";

	echo "Добавлено товаров ", $d, ' из : ', count($offer_add), "<br/>";
	echo "Товаров не добавлено нет категорий ", count($not_cat_offer), "<br />";
	
?>