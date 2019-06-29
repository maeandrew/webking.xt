<?php
	error_reporting(-1);	
	$Parser = new Parser();
	global $Specification;
	$Specification = new Specification();
	$Suppliers = new Suppliers();
	global $Images;
	$Images = new Images();
	$Products = new Products();
	$id_supplier = 18514;
	//Устанавливаем настройки памяти
	// echo "memory_limit ", ini_get('memory_limit'), "<br />";
	ini_set('memory_limit', '3072M');	
	// echo "memory_limit ", ini_get('memory_limit'), "<br />";

	//Устанавливаем настройки времени
	// echo "max_execution_time ", ini_get('max_execution_time'), "<br />";
	ini_set('max_execution_time',0);
	set_time_limit(0);
	// echo "max_execution_time ", ini_get('max_execution_time'), "<br />";

	// echo "post_max_size ", ini_get('post_max_size'), "<br />";
	// echo "set_time_limit ", ini_get('set_time_limit'), "<br />";

	// ob_start();
	// ob_end_flush();
	// ob_end_clean();
	// ob_implicit_flush();
	session_write_close();
	
	
	

	ini_set('display_errors','on');
	ini_set('error_reporting',E_ALL);

	echo "bluzka<br/>";

	// выбераем имеющиеся у нас артикул
	if(!$supcomments = $Products->GetSupComments($id_supplier)){
		echo "Массив загруженых товаров поставщика пуст<br />";
		continue;
	}
	$supcomments = array_unique($supcomments);
	echo 'У поставщика в кабегнете товаров ', count($supcomments), "<br />","<br />";
	//сответстие категорий
	 $array_cat = array(321=>837,322=>837,312=>840,313=>840,314=>840,316=>840,318=>840,319=>840,337=>840,363=>840,364=>840,368=>840,353=>869,323=>1313,324=>1313,378=>1313,395=>1751,293=>1752,299=>1753,381=>1754,301=>1755,300=>1756,463=>1757,396=>1758,351=>1759,338=>1760,404=>1761,380=>1762,288=>1763,289=>1764,290=>1765,291=>1766,304=>1767,328=>1767,382=>1767,303=>1768,302=>1769,448=>1770,329=>1771,296=>1772,295=>1773,294=>1774,292=>1775,297=>1776,298=>1777,287=>1778,286=>1780,365=>1859,383=>1860,376=>1861,394=>1862, 285=>1779);

	// загружаем файл
	if ($sim_url = simplexml_load_file('http://bluzka.ua/ru/yml/')){
		echo "Файл ПО СЫЛКЕ загружен <br />";
	}else{
		die("Не удалось открыть файл<br />");
	}
	//Посмотреть категории
	$Parser->show_categories($sim_url);

	//проходим по файлу и сортируем на обнавление и добавление
	echo " <br/><br/>Формируем названия с сортируем на обнавление и добавление ************************<br/><br/>";
	$n_c = $n_jpg = 0;
	$not_cat = $offer_on_prod = $offer_add = array();
	foreach($sim_url->xpath('/yml_catalog/shop') as $element){
		foreach($element->xpath('offers/offer') as $offer){
			$prod = array();
			$name = strip_tags(stristr($offer->description, '</h1>', true));
			$name = str_replace(array('&nbsp;', '<h1>'),'', $name);
			$name = trim($name);
			$prod['url'] = $offer->url;
			//выбераем нашу категорию
			foreach($array_cat as $k=>$value){
				if ($k == $offer->categoryId){
					$prod['categoryId'] = $value;					
					break;
				}
			}
			//если нет категории
			if (!isset($prod['categoryId'])) {
				array_push($not_cat, $offer->categoryId);
				$n_c++;
				break;
			}
			$prod['pric'] = round($offer->price, 0);
			$prod['picture'] = $offer->picture;
			//проверяем наличие картинки
			if(substr($prod['picture'], -3) != 'jpg'){
				$n_jpg++;
				continue;
			}
			//фрмеруем описание
			$prod['descr'] = str_replace(array('<h1>', '</h1>'), array('<h2>', '</h2>'), $offer->description);
			//формеруем название и характеристики
			if($offer->param[1] == 'б/р'){					
				$key = trim($offer->vendorCode).trim($offer->param[0]);				
				$prod['name'] = $name." ".trim($offer->vendorCode)." (размер: б/р, цвет: ".trim($offer->param[0]).")";
				$prod['spec']['Производитель'] = strval($offer->country_of_origin);
				$prod['spec']['Цвет'] = trim($offer->param[0]);
				$prod['spec']['Размер одеж'] = 'б/р';
				$prod['sup_comment'] = $key;
				if (!in_array($key, $supcomments)){
					array_push($offer_add, $prod);
					echo $prod['name'], " на добавление-> <br/>";
					continue;
				}else{
					// if ($prod['id_product']= $Products->GetIDByNema($prod['name'])) {
					// 	echo "на обновление карточки", " <br/>";
					// 	array_push($offer_add, $prod);
					// }
				}
			}else{
				$raz = explode(",", $offer->param[1]);
				foreach ($raz as $value) {
					$key = trim($offer->vendorCode).trim($offer->param[0]).trim($value);									
					$prod['name'] = $name." ".trim($offer->vendorCode)." (размер: ".trim($value).", цвет: ".trim($offer->param[0]).")";
					$prod['spec']['Производитель'] = strval($offer->country_of_origin);
					$prod['spec']['Цвет'] = trim($offer->param[0]);
					$prod['spec']['Размер одеж'] = $value;
					$prod['sup_comment'] = $key;					
					if (!in_array($key, $supcomments)){
						array_push($offer_add, $prod);
						echo $prod['name'], " на добавление-> <br/>";
						continue;
					}else{
						// if ($prod['id_product']= $Products->GetIDByNema($prod['name'])) {
						// 	echo "на обновление карточки", " <br/>";
						// 	array_push($offer_add, $prod);
						// }
					}
				}
			}
		}
	}
	echo "Товаров на обновление", count($offer_on_prod), "<br/>";
	echo "Товаров на добавление", count($offer_add), "<br/>";
	//смотрим товары на добавление
	// $Parser->show_product($offer_add);
 // die('STOP');
	echo 'СТАРТ добавление и обновление:', count($offer_add),' +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ <br/><br/>';
	$i = $l = $obn = $d = $n = 0;			
	foreach ($offer_add as $prod) {
	//	if(0 < $n++){
	// 		break;
		// 		die("СТОП по КОЛИЧЕСТВУ <br/>");
	//	}	
	//выбераем id_product поназванию
	if ($id_product = $prod['id_product']= $Products->GetIDByNema($prod['name'])) {
		# code...
	}

	if(!$product = $Parser->bluzka($prod)){
		echo "Товар пропущен product пустой<br />";
		$i++;
		continue;
	}
	//посмотрим продаукт
	$Parser->show_product($product);
	// die();

	// обновляем картосу товара или добавляем новую
	if (isset($product['id_product']) && !empty($product['id_product'])) {	

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
			$Products->UpdateProductCategories($id_product, array($product['categoryId']));
			$obn++;
			echo "OK. Товар ОБНОВЛЕН: ", $product['name'], "<br />";
        //обновляем категори товаров
        // $sql_arrey[] = "delete from "._DB_PREFIX_."cat_prod WHERE id_product = ".$id_product;
        // $sql_arrey[] = "INSERT IGNORE INTO "._DB_PREFIX_."cat_prod(id_category, id_product, main, test) VALUES(".$prod['categoryId'].", ".$id_product.", ".'1'.", '')";

		// 	if($Products->UpdateProduct($product);){
		// 		echo "Продукт обновлен <br /><br />";
		// 	}else{
		// 		echo "Проблема с обновлением продукта <br /><br />";
		// 	continue;
		// }
	}else{
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
			$Products->UpdateProductCategories($id_product, array($product['categoryId']));
			$d++;
			echo "OK. Товар добавлен: ", $product['name'], "<br />";

		}else{
				array_push($offer_on_prod, $offer->categoryId);
			echo "Проблема с добавлением продукта <br /><br />";
			$l++;
			continue;
		}			

	}
}

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
		//содержимое файла
		// $Parser->show_file($array_f);

		//Формируем запросы на обновление категории и наличия
	echo 'Формируем запросы на обновление категории, наличия и цен***************************<br/>';
	$sql_arrey = array();
	$sql_arrey[] = "UPDATE xt_assortiment SET no_xtorg = 0 WHERE id_supplier = ".$id_supplier;
	$key_price = $key_sup1 = $key_sup2 = $key_sup3 = FALSE;
	foreach ($array_f as $key => $strok) {
		if ($key == 0) {
			foreach ($strok as $key => $value) {
				if ($value == 'Цена,опт.грн.') {
					$key_price = $key;
					// echo $value, " key_price ", $key_price, '<br/>';
				}
				if ($value == 'Код') {
					$key_sup1 = $key;
					// echo $value, " key_sup1 ", $key_sup1, '<br/>';
				}
				if ($value == 'Цвет') {
					$key_sup2 = $key;
					// echo $value, " key_sup2 ", $key_sup2, '<br/>';
				}
				if ($value == 'Размер') {
					$key_sup3 = $key;
					// echo $value, " key_sup3 ", $key_sup3, '<br/>';
				}
			}
			continue;
		}
		if ($key_price === FALSE || $key_sup1 === FALSE || $key_sup2 === FALSE || $key_sup3 === FALSE) {
			die('STOP файла неправельный');
			}
   	$sup = $strok[$key_sup1].$strok[$key_sup2].$strok[$key_sup3];




    if (in_array($sup, $supcomments) && isset($sup) && !empty($sup)) { 
        $id_product = $Products->GetIdBysup_comment($id_supplier, $sup);//получаем id_product по sup_comment
 
		$sql_arrey[] = "UPDATE "._DB_PREFIX_."assortiment SET product_limit = 100000, active = 1, no_xtorg = 1, price_opt_otpusk = '".$strok[$key_price]."', price_mopt_otpusk = '".$strok[$key_price]."', inusd = 0  WHERE id_supplier = ".$id_supplier." and id_product = ".$id_product;
    }      
	} 
	//выключаем не обновленые позиции
    $sql_arrey[] = "UPDATE xt_assortiment SET product_limit = 0, active = 0 WHERE id_supplier = ".$id_supplier." and no_xtorg = 0";

	//можем посмотреть спысок запросов  
	echo ' ГОТОВО Товаров на обновление: ',  count($sql_arrey), " из ", count($array_f), " в файле<br/><br/>"; 
	// foreach ($sql_arrey as $key => $value) {
	// 		echo $value, '<br/>';
	// 		if(!stristr($value, 'UPDATE') === FALSE) {
 // 		 	echo '<br/>';
 // 			}
	// }
	
//Обновляем 
if($Products->ProcessAssortimentXML($sql_arrey)){
	echo "ОБНОВЛЕНО наличие  <br />";
	}	
}else{
	echo " В ТОВАРАХ НЕ ОБНОВЛЕНЫ ЦЕНЫ нет ФАЙЛА<br/>";
}

	echo "Товаров нет фото ", $n_jpg, "<br/>";
	echo "Добавлено товаров ", $d, ' из : ', count($offer_add), "<br/>";
	echo "Обновлено товаров ", $obn, ' из : ', count($offer_add), "<br/>";
	echo "Товар пропущен product пустой ", $i, "<br />";
	echo "Проблема с добавлением продукта ", $l, "<br />";
	echo "Товаров не добавлено нет категорий ", $n_c, "<br />";
	foreach ($not_cat as $key => $value) {
		echo 'id_category блузки ', $value, "<br />";
	}
?>

