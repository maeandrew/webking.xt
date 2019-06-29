<?php
	error_reporting(-1);	
	$Parser = new Parser();
	global $Specification;
	$Specification = new Specification();
	$Suppliers = new Suppliers();
	global $Images;
	$Images = new Images();
	$Products = new Products();
	$id_supplier = 4722;
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
	 $array_cat = array(47836759=>1133,24958750=>1133,24958742=>1133,24958733=>1133,24958715=>1133,25478084=>1133,24958690=>1133,25115838=>1133,25115134=>1133,25115133=>1133,25115130=>1133,25115360=>1133,25115358=>1133,20344356=>1133,20343952=>1133,20078055=>1133,29060733=>1138,29059056=>1709,21363012=>1316,20078049=>1709,20078048=>1133,20078046=>832,26851799=>1135,20078073=>1709,20669695=>1133,25115115=>1133,25115834=>1133,25115364=>1133,25115351=>1133,24958718=>1133,24958704=>1133,24958695=>1133,24773648=>1916,24771220=>1916,24769773=>1916,24609635=>1916,20081581=>1138,20078051=>1139,20165840=>1135,20165841=>1135,20165842=>1135,20669344=>1708,20078061=>1133,20674560=>1133,20688221=>1709,20686934=>1137,20686935=>1137,20686936=>1137,20724577=>1709,20310309=>1138,20078075=>832,20078056=>1133,20078057=>1133,20078058=>1133,20078059=>1133,20078060=>1133,20078069=>1709,20078074=>1709,20078076=>1709,20078077=>1138,20078071=>1137,20078063=>1137,20078062=>1708,20078053=>832,20078067=>832,20078068=>832,20078072=>832,20081622=>1708,20380395=>1133);

	// загружаем файл
	if ($sim_url = simplexml_load_file('https://glavtekstilopt.com.ua/yandex_market.xml?hash_tag=02f849c0046994cc42ebd864798f177b&sales_notes=&product_ids=&group_ids=&label_ids=&exclude_fields=&html_description=0&yandex_cpa=&process_presence_sure')){
		echo "Файл ПО СЫЛКЕ загружен <br />";
	}else{
		die("Не удалось открыть файл<br />");
	}
	//Посмотреть категории
	$Parser->show_categories($sim_url);
 // die('STOP');
	echo 'СТАРТ добавление и обновление:',' +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ <br/><br/>';
	$i = $l = $obn = $d = $n = 0;		
	foreach($sim_url->xpath('/yml_catalog/shop') as $element){
		foreach($element->xpath('offers/offer') as $offer){	

			if(20000 < $n++){
				break;
					die("СТОП по КОЛИЧЕСТВУ <br/>");
			}	
	
			// ОБНОВЛЯЕМ или Добавляем новый товар в БД
			echo $temp = strval($offer->name);
	// $id_product = $Products->GetIDByNema($offer->name);
	// die($id_product);
			// $id_product = $Products->GetIDByNema($offer->name)
		if (false) {

					// die('есть название');
		}elseif(!in_array($offer->vendorCode, $supcomments)){
					//заполняем продукт
					if($product = $Parser->glavteks_XML($offer)){
							//посмотрим продаукт
							$Parser->show_product($product);
							// die('Stop');			
						}else{
							echo "Товар пропущен product пустой<br />";
							$i++;
							continue;
						}
					if($id_product = $Products->AddProduct($product)){
						echo "Продукт добавлен <br /><br />";

									//выбераем нашу категорию
						foreach($array_cat as $k=>$value){
							if ($k == $offer->categoryId){
								$categoryId = $value;					
								break;
							}
						}
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
								'active' => 0,
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
		}else{
			echo "???<br/>";
		}		
	}
}


	// echo "Товаров нет фото ", $n_jpg, "<br/>";
	echo "Добавлено товаров ", $d, ' из : ', "<br/>";
	echo "Обновлено товаров ", $obn, ' из : ', "<br/>";
	echo "Товар пропущен product пустой ", $i, "<br />";
	echo "Проблема с добавлением продукта ", $l, "<br />";
	// echo "Товаров не добавлено нет категорий ", $n_c, "<br />";
	// foreach ($not_cat as $key => $value) {
	// 	echo 'id_category блузки ', $value, "<br />";
	// }
?>

