<?php
class Parser {
	public $db;
	public $url;

	public function __constructor(){
		$this->db =& $GLOBALS['db'];
	}

	public function parseUrl($url){
		$Products = new Products();
		$Specification = new Specification();
		$Images = new Images();
		$product = array();
		$html = file_get_html($url);
		// Название товара
		$product['name'] = $html->find('[itemprop="name"]', 0)->plaintext;
		if($Products->SetFieldsByRewrite(G::StrToTrans($product['name']))){
			return false;
		}
		// Описание товара
		$product['descr'] = $html->find('[itemprop="description"]', 0)->plaintext;
		// Указываем базовую активность товара
		$product['active'] = 1;
		// Получаем цену товара
		$product['price_opt_otpusk'] = $product['price_mopt_otpusk'] = $html->find('[itemprop="price"]', 0)->innertext;
		// Находим характеристики товара
		foreach($html->find('.stats tr') as $element){
			$caption = trim($element->find('.name span', 0)->innertext);
			if($caption == 'Артикул'){
				$sup_comment = trim($element->children(1)->plaintext);
			}elseif($caption !== '' && !in_array($caption, array('Доставка', 'Самовывоз', 'Гарантия'))){
				$value = trim($element->children(1)->plaintext);
				$spec = $Specification->SpecExistsByCaption($caption);
				$product['specs'][] = array(
					'id_spec' => $spec?$spec['id']:$Specification->Add(array('caption' => $caption)),
					'value' => $value
				);
			}
		}
		// Выбираем изображения максимального размера
		foreach($html->find('#photo #elementTableImg img') as $element){
			$filename = 'http://zona220.com'.str_replace('/500_500_1/', '/', str_replace('/resize_cache/', '/', $element->src));
			$img_info = array_merge(getimagesize($filename), pathinfo($filename));
			$path = $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/';
			$Images->checkStructure($path);
			copy($filename, $path.$img_info['basename']);
			$product['images'][] = str_replace($GLOBALS['PATH_global_root'], '/', $path.$img_info['basename']);
			$product['images_visible'][] = 1;
		}
		$html->clear();
		unset($html);
		// Добавляем новый товар в БД
		if($id_product = $Products->AddProduct($product)){
			// Добавляем характеристики новому товару
			if(!empty($product['specs'])){
				foreach($product['specs'] as $specification){
					$Specification->AddSpecToProd($specification, $id_product);
				}
			}
			// Формирем массив записи ассортимента
			$assort = array('id_assortiment' => false, 'id_supplier' => 25392, 'id_product' => $id_product, 'price_opt_otpusk' => $product['price_opt_otpusk'], 'price_mopt_otpusk' => $product['price_mopt_otpusk'], 'active' => 0, 'inusd' => 0, 'sup_comment' => $sup_comment);
			// $assort = array('id_assortiment' => false, 'id_supplier' => 23029, 'id_product' => $id_product, 'price_opt_otpusk' => $product['price_opt_otpusk'], 'price_mopt_otpusk' => $product['price_mopt_otpusk'], 'active' => 0, 'inusd' => 0);
			// Добавляем зпись в ассортимент
			$Products->AddToAssortWithAdm($assort);
			// Получаем артикул нового товара
			$article = $Products->GetArtByID($id_product);
			// Переименовываем фото товара
			$to_resize = $images_arr = array();
			if(isset($product['images'])){
				foreach($product['images'] as $k=>$image){
					$to_resize[] = $newname = $article['art'].($k == 0?'':'-'.$k).'.jpg';
					$file = pathinfo(str_replace('/'.str_replace($GLOBALS['PATH_global_root'], '', $GLOBALS['PATH_product_img']), '', $image));
					$path = $GLOBALS['PATH_product_img'].trim($file['dirname']).'/';
					$images_arr[] = str_replace($file['basename'], $newname, $image);
					rename($path.$file['basename'], $path.$newname);
				}
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
				imagecopyresampled($res, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
				$stamp = imagecreatefrompng($GLOBALS['PATH_global_root'].'images/watermark.png');
				imagecopyresampled($res, $stamp, 10, 10, 0, 0, imagesx($stamp), imagesy($stamp), imagesx($stamp), imagesy($stamp));
				imagejpeg($res, $file);
			}
			$Images->resize(false, $to_resize);
			// Привязываем новые фото к товару в БД
			$Products->UpdatePhoto($id_product, $images_arr, $product['images_visible']);
		}
		return $id_product;
	}
}
