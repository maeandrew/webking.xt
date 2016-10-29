<?php
$urls = array(
	'http://zona220.com/catalog/elektronnaya_kniga_airbook_city_led.html',
	'http://zona220.com/catalog/akkumulyatornaya_batareya_powerplant_htc_desire_hd_a9191_dv00dv6053.html',
	'http://zona220.com/catalog/kofemolka_moulinex_ar_1108.html',
	'http://zona220.com/catalog/blok_pitaniya_fractal_design_650w_integra_m_fd_psu_in3b_650w_eu.html'
);
$Products = new Products();
$Images = new Images();
foreach($urlsa as $url){
	$product = array();
	$html = file_get_html($url);
	// Находим все изображения

	foreach($html->find('.stats tr[class!="cap"]') as $element){
		$caption = $element->find('.name span', 0)->innertext;
		if(!in_array($caption, array('Доставка', 'Самовывоз', 'Гарантия'))){
			$value = trim($element->children(1)->plaintext);
			$product['specs'][] = array(
				'caption' => $caption,
				'value' => $value
			);
		}elseif($caption == 'Артикул'){
			$product['assort']['sup_comment'] = trim($element->children(1)->plaintext);
		}
	}
	foreach($html->find('#photo #elementTableImg img') as $element){
		$filename = 'http://zona220.com'.str_replace('/500_500_1/', '/', str_replace('/resize_cache/', '/', $element->src));
		$img_info = array_merge(getimagesize($filename), pathinfo($filename));
		$path = $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/';
		$Images->checkStructure($path);
		copy($filename, $path.$img_info['basename']);
		$product['images'][] = str_replace($GLOBALS['PATH_global_root'], '/', $path.$img_info['basename']);
		$product['images_visible'][] = 1;
	}
	$product['create_user'] = 20793;
	$product['name'] = $html->find('[itemprop="name"]', 0)->plaintext;
	$product['descr'] = $html->find('[itemprop="description"]', 0)->plaintext;
	$product['price_opt_otpusk'] = $product['price_mopt_otpusk'] = $html->find('[itemprop="price"]', 0)->innertext;
	$html->clear();
	unset($html);
	if($id_product = $Products->AddProduct($product)){
		print_r('<pre>');
		print_r($id_product);
		print_r('</pre>');
		$article = $Products->GetArtByID($id_product);
		if(isset($product['images'])){
			foreach($product['images'] as $k=>$image){
				$to_resize[] = $newname = $article['art'].($k == 0?'':'-'.$k).'.jpg';
				$file = pathinfo(str_replace('/'.str_replace($GLOBALS['PATH_root'], '', $GLOBALS['PATH_product_img']), '', $image));
				$path = $GLOBALS['PATH_product_img'].trim($file['dirname']).'/';
				$images_arr[] = str_replace($file['basename'], $newname, $image);
				rename($path.$file['basename'], $path.$newname);
			}
		}else{
			$images_arr = array();
		}

		//Проверяем ширину и высоту загруженных изображений, и если какой-либо из показателей выше 1000px, уменяьшаем размер
		foreach($images_arr as $filename){
			$file = $GLOBALS['PATH_product_img'].str_replace('/'.str_replace($GLOBALS['PATH_root'], '', $GLOBALS['PATH_product_img']), '', $filename);
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
			imagecopyresampled($res, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
			imagejpeg($res, $file);
		}

		$Images->resize(false, $to_resize);
		$Products->UpdatePhoto($id_product, $images_arr, $product['images_visible']);

		//Формирем массив поставщика товара
		$assort = array(
			'id_assortiment' => false,
			'id_supplier' => 7,
			'id_product' => $id_product,
			'price_opt_otpusk' => $product['price_opt_otpusk'],
			'price_mopt_otpusk' => $product['price_mopt_otpusk'],
			'inusd' => 0
		);
		//Добавляем поставщика в ассортимент
		if(!$Products->AddToAssortWithAdm($assort)){
			// echo '<script>alert("Ошибка при добавлении поставщика!\nДанный товар уже имеется в ассортименте поставщика!");</script>';
		}
	}
}
