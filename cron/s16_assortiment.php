<?php
// $Specification = new Specification();
// $Suppliers = new Suppliers();
// $Images = new Images();
// $Parser = new Parser();
// $Products = new Products();

// $update_images = false;

// $id_supplier = 94;
// $xml = simplexml_load_file('https://unison-line.com/yandex_market.xml?html_description=1&hash_tag=430898b3e30b1648f714e38504ffd7cc&yandex_cpa=&group_ids=&exclude_fields=&sales_notes=&product_ids=');
// $xml_array = json_decode(json_encode($xml), TRUE);

// // Фенкуия обработки фото товаров
// function proceedImages($filename){
// 	$Images = new Images();
// 	$img_info = array_merge(getimagesize($filename), pathinfo($filename));
// 	$path = $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/';
// 	$Images->checkStructure($path);
// 	copy($filename, $path.$img_info['basename']);
// 	return array(str_replace($GLOBALS['PATH_global_root'], '/', $path.$img_info['basename']), 1);
// }

// // Получаем список артикулов товаров поставщика
// $Products->GetSupComments($id_supplier);
// $supcomments = $Products->GetSupComments($id_supplier);
// if(is_array($supcomments)){
// 	$supcomments = array_unique($supcomments);
// }

// if(!$update_images){
// 	/**
// 	 * 1. Обновить курс доллара поставщика
// 	 * 2. Добавить новые товары
// 	 * 3. Обновить цены существующих товаров
// 	 */

// 	foreach($xml_array['shop']['currencies']['currency'] as $currency){
// 		$currencies[$currency['@attributes']['id']] = $currency['@attributes']['rate'];
// 	}

// 	/* // Обновление курса доллара поставщика
// 	$Suppliers->RecalcSupplierCurrency(array('id_supplier' => $id_supplier, 'currency_rate' => $currencies['USD']));
// 	*/

// 	$skipped_by_name = $skipped_by_article = 0;
// 	foreach($xml_array['shop']['offers']['offer'] as $k => $offer){
// 		$product = [];
// 		$assort = array(
// 			'id_assortiment' => false,
// 			'id_supplier' => $id_supplier,
// 			'active' => 1,
// 			'sup_comment' => $offer['vendorCode']
// 		);
// 		// Цена товара
// 		if($offer['currencyId'] == 'USD'){
// 			$assort['price_opt_otpusk_usd'] = $assort['price_mopt_otpusk_usd'] = $offer['price'];
// 			$assort['inusd'] = 1;
// 		}else{
// 			$assort['price_opt_otpusk'] = $assort['price_mopt_otpusk'] = $offer['price'];
// 			$assort['inusd'] = 0;
// 		}
// 		if(!empty($supcomments) && in_array($assort['sup_comment'], $supcomments)){
// 			$skipped_by_article++;
// 			$assort['id_assortiment'] = array_search($assort['sup_comment'], $supcomments);
// 			// $Products->UpdateAssortWithAdm($assort);
// 			continue;
// 		}
// 		// Название товара
// 		$product['name'] = $offer['name'];
// 		if($Products->SetFieldsByRewrite(G::StrToTrans($product['name']))){
// 			// product is already in database. trying to update price
// 			// $product['name'] = $offer['name'].' ('.$offer['vendorCode'].')';
// 			$skipped_by_name++;
// 			continue;
// 		}
// 		// Фото товара
// 		if(isset($offer['picture'])){
// 			if(is_array($offer['picture'])){
// 				foreach($offer['picture'] as $picture){
// 					list($product['images'][], $product['images_visible'][]) = proceedImages($picture);
// 				}
// 			}else{
// 				list($product['images'][], $product['images_visible'][]) = proceedImages($offer['picture']);
// 			}
// 		}
// 		// Характеристики товара
// 		if($parsed_html = $Parser->parseUrl($offer['url'])){
// 			foreach($parsed_html->find('[data-qaid="product_description"] table tr') as $element){
// 				$caption = str_replace(':', '', trim($element->children(0)->plaintext));
// 				if($caption !== '' && !in_array($caption, array('Доставка', 'Самовывоз', 'Гарантия'))){
// 					$value = trim($element->children(1)->plaintext);
// 					$spec = $Specification->SpecExistsByCaption($caption);
// 					$product['specs'][] = array(
// 						'id_spec' => $spec?$spec['id']:$Specification->Add(array('caption' => $caption)),
// 						'value' => $value
// 					);
// 				}
// 			}
// 		}
// 		// Добавление товара
// 		if($id_product = $Products->AddProduct($product)){
// 			// Добавляем характеристики новому товару
// 			if(!empty($product['specs'])){
// 				foreach($product['specs'] as $specification){
// 					$Specification->AddSpecToProd($specification, $id_product);
// 				}
// 			}
// 			$assort['id_product'] = $id_product;
// 			// Добавляем зпись в ассортимент
// 			$Products->AddToAssortWithAdm($assort);
// 			// Получаем артикул нового товара
// 			$article = $Products->GetArtByID($id_product);
// 			if(isset($product['images']) && !empty($product['images'])){
// 				$images_arr = [];
// 				foreach($product['images'] as $key=>$image){
// 					$to_resize[] = $newname = $article['art'].($key == 0?'':'-'.$key).'.jpg';
// 					$file = pathinfo(str_replace('/'.str_replace($GLOBALS['PATH_global_root'], '', $GLOBALS['PATH_product_img']), '', $image));
// 					$path = $GLOBALS['PATH_product_img'].trim($file['dirname']).'/';
// 					$images_arr[] = str_replace($file['basename'], $newname, $image);
// 					rename($path.$file['basename'], $path.$newname);
// 				}
// 				//Проверяем ширину и высоту загруженных изображений, и если какой-либо из показателей выше 1000px, уменяьшаем размер
// 				foreach($images_arr as $filename){
// 					$file = $GLOBALS['PATH_product_img'].str_replace('/'.str_replace($GLOBALS['PATH_global_root'], '', $GLOBALS['PATH_product_img']), '', $filename);
// 					$size = getimagesize($file);
// 					// $size = getimagesize($path.$filename); //Получаем ширину, высоту, тип картинки
// 					$width = $size[0];
// 					$height = $size[1];
// 					if($size[0] > 1000 || $size[1] > 1000){
// 						$ratio = $size[0]/$size[1]; //коэфициент соотношения сторон
// 						//Определяем размеры нового изображения
// 						if(max($size[0], $size[1]) == $size[0]){
// 							$width = 1000;
// 							$height = 1000 / $ratio;
// 						}elseif(max($size[0], $size[1]) == $size[1]){
// 							$width = 1000*$ratio;
// 							$height = 1000;
// 						}
// 					}
// 					$res = imagecreatetruecolor($width, $height);
// 					imagefill($res, 0, 0, imagecolorallocate($res, 255, 255, 255));
// 					$src = $size['mime'] == 'image/jpeg'?imagecreatefromjpeg($file):imagecreatefrompng($file);
// 					// Добавляем логотип в нижний правый угол
// 					imagecopyresampled($res, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
// 						$stamp = imagecreatefrompng($GLOBALS['PATH_global_root'].'images/watermark_colored.png');
// 						$k = imagesy($stamp)/imagesx($stamp);
// 						$widthstamp = imagesx($res)*0.3;
// 						$heightstamp = $widthstamp*$k;
// 						imagecopyresampled($res, $stamp, imagesx($res) - $widthstamp, imagesy($res) - $heightstamp, 0, 0, $widthstamp, $heightstamp, imagesx($stamp), imagesy($stamp));
// 					imagejpeg($res, $file);
// 				}
// 				$Images->resize(false, $to_resize);
// 				// Привязываем новые фото к товару в БД
// 				$Products->UpdatePhoto($id_product, $images_arr, $product['images_visible']);
// 			}
// 		}
// 	}
// }else{
// 	foreach($xml_array['shop']['offers']['offer'] as $k => $offer){
// 		$images = $images_visible = [];
// 		if($Products->SetFieldsBySupComment($offer['vendorCode'], $id_supplier)){
// 			$id_product = $Products->fields['id_product'];
// 			$art = $Products->fields['art'];
// 			// Фото товара
// 			if(empty(glob($GLOBALS['PATH_product_img'].'original/*/*/*/'.$art.'.jpg')) && isset($offer['picture'])){
// 				if(is_array($offer['picture'])){
// 					foreach($offer['picture'] as $picture){
// 						list($images[], $images_visible[]) = proceedImages($picture);
// 					}
// 				}else{
// 					list($images[], $images_visible[]) = proceedImages($offer['picture']);
// 				}
// 				if(!empty($images)){
// 					$images_arr = [];
// 					foreach($images as $key=>$image){
// 						$to_resize[] = $newname = $art.($key == 0?'':'-'.$key).'.jpg';
// 						$file = pathinfo(str_replace('/'.str_replace($GLOBALS['PATH_global_root'], '', $GLOBALS['PATH_product_img']), '', $image));
// 						$path = $GLOBALS['PATH_product_img'].trim($file['dirname']).'/';
// 						$images_arr[] = str_replace($file['basename'], $newname, $image);
// 						rename($path.$file['basename'], $path.$newname);
// 					}
// 					//Проверяем ширину и высоту загруженных изображений, и если какой-либо из показателей выше 1000px, уменяьшаем размер
// 					foreach($images_arr as $filename){
// 						$file = $GLOBALS['PATH_product_img'].str_replace('/'.str_replace($GLOBALS['PATH_global_root'], '', $GLOBALS['PATH_product_img']), '', $filename);
// 						$size = getimagesize($file);
// 						// $size = getimagesize($path.$filename); //Получаем ширину, высоту, тип картинки
// 						$width = $size[0];
// 						$height = $size[1];
// 						if($size[0] > 1000 || $size[1] > 1000){
// 							$ratio = $size[0]/$size[1]; //коэфициент соотношения сторон
// 							//Определяем размеры нового изображения
// 							if(max($size[0], $size[1]) == $size[0]){
// 								$width = 1000;
// 								$height = 1000 / $ratio;
// 							}elseif(max($size[0], $size[1]) == $size[1]){
// 								$width = 1000*$ratio;
// 								$height = 1000;
// 							}
// 						}
// 						$res = imagecreatetruecolor($width, $height);
// 						imagefill($res, 0, 0, imagecolorallocate($res, 255, 255, 255));
// 						$src = $size['mime'] == 'image/jpeg'?imagecreatefromjpeg($file):imagecreatefrompng($file);
// 						// Добавляем логотип в нижний правый угол
// 						imagecopyresampled($res, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
// 							$stamp = imagecreatefrompng($GLOBALS['PATH_global_root'].'images/watermark_colored.png');
// 							$k = imagesy($stamp)/imagesx($stamp);
// 							$widthstamp = imagesx($res)*0.3;
// 							$heightstamp = $widthstamp*$k;
// 							imagecopyresampled($res, $stamp, imagesx($res) - $widthstamp, imagesy($res) - $heightstamp, 0, 0, $widthstamp, $heightstamp, imagesx($stamp), imagesy($stamp));
// 						imagejpeg($res, $file);
// 					}
// 					$Images->resize(false, $to_resize);
// 					// Привязываем новые фото к товару в БД
// 					$Products->UpdatePhoto($id_product, $images_arr, $images_visible);
// 				}
// 			}
// 		}else{
// 			continue;
// 		}
// 	}
// }