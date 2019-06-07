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
	 $array_cat = array(100=>1889,101=>1877,102=>1877,103=>1877,104=>1742,105=>1742,106=>1742,107=>1878,108=>1876,109=>1880,110=>1884,111=>1883,112=>1880,113=>1880,115=>1883,116=>1879,117=>1879,118=>1879,119=>1883,123=>1870,124=>1876,125=>1885,126=>1739,127=>1885,128=>1739,129=>1885,130=>1885,131=>1739,132=>1739,133=>1886,140=>1871,141=>1887,142=>1890,143=>1872,144=>1874,145=>1874,146=>1741,147=>1875,148=>1875,149=>1875,150=>1865,151=>1865,152=>1877,154=>1877,155=>1881,156=>1889,157=>1889,158=>1888,159=>1888,160=>1888,161=>1888,177=>1887,178=>1887,179=>1887,180=>1887,181=>1890,182=>1890,183=>1886,184=>1886,185=>1878,186=>1878,188=>1876,189=>1881,190=>1881,191=>1744,192=>1744,193=>1744,194=>1870,195=>1870,196=>1870,197=>1870,198=>1890,199=>1873,200=>1873,201=>1873,202=>1745,203=>1890,204=>1874,59=>1739,60=>1739,61=>1885,62=>1886,63=>1871,64=>1745,65=>1875,66=>1876,67=>1741,69=>1865,71=>1879,75=>1742,77=>1877,82=>1872,83=>1745,84=>1872,85=>1876,86=>1876,87=>1876,88=>1874,89=>1744,90=>1741,91=>1741,92=>1741,94=>1871,95=>1745,99=>1888);

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
	echo "Товаров нет картинки ", $n_jpg, "<br/>";
	echo "Добавлено товаров ", $d, ' из : ', count($offer_add), "<br/>";
	echo "Товар пропущен product пустой ", $i, "<br />";
	echo "Проблема с добавлением продукта ", $l, "<br />";
	echo "Товаров не добавлено нет категорий ", $n_c, "<br />";
	foreach ($not_cat as $key => $value) {
		echo 'id_category ', $value, "<br />";
	}
?>