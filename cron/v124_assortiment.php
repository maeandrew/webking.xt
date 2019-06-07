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
	echo "Загружаем файл: http://bluzka.ua/ru/yml/ <br/>";

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
		echo "Файл загружен <br />";
	}else{
		die("Не удалось открыть файл<br />");
	}
	echo " <br/><br/>КАТЕГОРИИ ********************************* <br/>";
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
	//проходим по файлу и сортируем на обнавление и добавление
	echo " <br/><br/>Сортируем на обнавление и добавление ************************<br/>";
	$n_c = $n_jpg = 0;
	$not_cat = $offer_on = $offer_add = array();
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
			if (!isset($prod['categoryId'])) {
				array_push($not_cat, $offer->categoryId);
				$n_c++;
				break;
			}
			$prod['pric'] = round($offer->price/1.67, 0);
			$prod['picture'] = $offer->picture;
			//проверяем наличие картинки
			if(substr($prod['picture'], -3) != 'jpg'){
				$n_jpg++;
				continue;
			}
			$prod['descr'] = str_replace(array('<h1>', '</h1>'), array('<h2>', '</h2>'), $offer->description);
			if($offer->param[1] == 'б/р'){					
				$key = trim($offer->vendorCode).trim($offer->param[0]);
				// echo $key, ' ', $name, "<br/>";
				$prod['name'] = $name." ".trim($offer->vendorCode)." (размер: б/р, цвет: ".trim($offer->param[0]).")";
				$prod['spec']['Производитель'] = $offer->country_of_origin;
				$prod['spec']['Цвет'] = trim($offer->param[0]);
				$prod['spec']['Размер одеж'] = 'б/р';
				$prod['sup_comment'] = $key;
				array_push($offer_on, $prod);
				if (!in_array($key, $supcomments)){
					array_push($offer_add, $prod);
					echo "на добавление <br/>";
					continue;
				}							
			}else{
				$raz = explode(",", $offer->param[1]);
				foreach ($raz as $value) {
					$key = trim($offer->vendorCode).trim($offer->param[0]).trim($value);
					// echo $key, ' ', $name, "<br/>";					
					$prod['name'] = $name." ".trim($offer->vendorCode)." (размер: ".trim($value).", цвет: ".trim($offer->param[0]).")";
					$prod['spec']['Производитель'] = $offer->country_of_origin;
					$prod['spec']['Цвет'] = trim($offer->param[0]);
					$prod['spec']['Размер одеж'] = $value;
					$prod['sup_comment'] = $key;
					array_push($offer_on, $prod);
					if (!in_array($key, $supcomments)){
					array_push($offer_add, $prod);
					echo "на добавление <br/>";
					continue;
					}	
				}
			}
		}
	}
	//Формируем запросы на обновление категории и наличия
	echo 'Формируем запросы на обновление категории, наличия и цен***************************<br/>';
	$sql_arrey = array();
	$sql_arrey[] = "UPDATE xt_assortiment SET no_xtorg = 0 WHERE id_supplier = ".$id_supplier;
	foreach ($offer_on as $prod) {
	   	$key = $prod['sup_comment'];
	    if (in_array($key, $supcomments)) { 
	        $id_product = $Products->GetIdBysup_comment($id_supplier, $key);//получаем id_product по sup_comment
	        // echo $id_product, '<br/>';	        
	        $sql_arrey[] = "delete from "._DB_PREFIX_."cat_prod WHERE id_product = ".$id_product;
	        $sql_arrey[] = "INSERT IGNORE INTO "._DB_PREFIX_."cat_prod(id_category, id_product, main, test) VALUES(".$prod['categoryId'].", ".$id_product.", ".'1'.", '')";
			$sql_arrey[] = "UPDATE "._DB_PREFIX_."assortiment SET product_limit = 100000, active = 1, no_xtorg = 1, price_opt_otpusk = '".$prod['pric']."', price_mopt_otpusk = '".$prod['pric']."', inusd = 0  WHERE id_supplier = ".$id_supplier." and id_product = ".$id_product;
	    }      
	} 
	//выключаем не обновленые позиции
    $sql_arrey[] = "UPDATE xt_assortiment SET product_limit = 0, active = 0 WHERE id_supplier = ".$id_supplier." and no_xtorg = 0";

	//можем посмотреть спысок запросов  
	echo 'Товаров на обновление: ', count($offer_on), "<br/>"; 
	// foreach ($sql_arrey as $key => $value) {
	// 		echo $value, '<br/>';
	// 		if(!stristr($value, 'UPDATE') === FALSE) {
 	// 	 	echo '<br/>';
 	// 		}
	// }
	//Обновляем расположение по категриям
	if($Products->ProcessAssortimentXML($sql_arrey)){
	 echo "ОБНОВЛЕНЫ категрии и наличие  <br />";
	}	

	//смотрим товары на добавление
	echo '++++++++++++++++++++++++++++++++++++++++Товаров на добавление: ', count($offer_add), "<br/>";
	foreach ($offer_add as $key => $value) {
		echo $key, "-------------------------------------<br/>";
		foreach ($value as $key => $value) {
			if ($key == 'spec') {
				foreach ($value as $key => $value) {
					echo "  ", $key, $value, "<br/>";
				}
			}else{
			echo $key, ' - ', $value, "<br/>";
			}
		}
		echo "<br/><br/>";
	}

 // die('STOP');
	echo '+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++СТАРТ добавление:', count($offer_add),' <br/>';
	$i = $l = $d = $ldi = 0;			
	foreach ($offer_add as $prod) {
		// if(10 < $ldi++){
 		//	die("СТОП по КОЛИЧЕСТВУ <br/>");
  		// }	
		if(!$product = $Parser->bluzka($prod, $Images)){
			echo "Товар пропущен product пустой<br />";
			$i++;
			continue;
		}
		echo $product['name'], "<br />";
		$id_category = $product['categoryId'];					
		echo $id_supplier, "<br />";
		echo $id_category, "<br />";
		echo $product['sup_comment'], "<br />";
		echo $product['price_mopt_otpusk'], "<br />";
		echo $product['price_opt_otpusk'], "<br />";
		echo $product['descr'], "<br />";
		echo $product['active'], "<br />";
		echo count($product['specs']), "<br />","<br />";
			foreach ($product['specs'] as $key => $value) {
				foreach ($value as $key => $value) {
					echo $key," ", $value," ";
				}
				echo "<br />";
			}
		echo count($product['images']), "<br />";
			foreach ($product['images'] as $value) {
				echo "<pre>";
				print_r($value);
				echo "</pre>";
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
			$Products->UpdateProductCategories($id_product, array($product['categoryId']));
			$d++;
			echo "***********OK. Товар добавлен *************<br /><br />";
		}else{
			echo "Проблема с добавлением продукта <br /><br />";
			$l++;
		}
	}
	echo "Товаров нет фото ", $n_jpg, "<br/>";
	echo "Добавлено товаров ", $d, ' из : ', count($offer_add), "<br/>";
	echo "Товар пропущен product пустой ", $i, "<br />";
	echo "Проблема с добавлением продукта ", $l, "<br />";
	echo "Товаров не добавлено нет категорий ", $n_c, "<br />";
	foreach ($not_cat as $key => $value) {
		echo 'id_category блузки ', $value, "<br />";
	}
?>

