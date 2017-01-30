<?php
class Parser {
	public $db;
	public $url;
	public $fields;

	public function __construct(){
		$this->db =& $GLOBALS['db'];
	}
	public function SetFieldsById($id){
		$sql = "SELECT * FROM "._DB_PREFIX_."parser_sites AS ps
			WHERE id = ".$id;
		if(!$this->fields = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return true;
	}
	public function Add($data){
		if(isset($data['title'])){
			$f['title'] = $data['title'];
		}
		if(isset($data['active'])){
			$f['active'] = $data['active'];
		}
		if(isset($data['id_supplier'])){
			$f['id_supplier'] = $data['id_supplier'];
		}
		if(isset($data['id_category'])){
			$f['id_category'] = $data['id_category'];
		}
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_."parser_sites", $f)){
			$this->db->FailTrans();
			return false;
		}
		$id = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id;
	}
	public function Update($data){
		$id = $data['id'];
		if(isset($data['title'])){
			$f['title'] = $data['title'];
		}
		if(isset($data['active'])){
			$f['active'] = $data['active'];
		}
		if(isset($data['id_supplier'])){
			$f['id_supplier'] = $data['id_supplier'];
		}
		if(isset($data['id_category'])){
			$f['id_category'] = $data['id_category'];
		}
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."parser_sites", $f, 'id = '.$id)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	public function GetSitesList($all = true){
		$sql = "SELECT ps.* FROM "._DB_PREFIX_."parser_sites AS ps".(!$all?' WHERE ps.active = 1':null);
		if(!$result = $this->db->GetArray($sql)){
			return false;
		}
		return $result;
	}
	// public function GetSiteFormatFile($id){
	// 	$sql = "SELECT ps.format FROM "._DB_PREFIX_."parser_sites AS ps WHERE ps.id = ".$id;
	// 	if(!$result = $this->db->GetOneRowArray($sql)){
	// 		return false;
	// 	}
	// 	return $result;
	// }
	public function AddParserSite($data){
		$f['title'] = $data['title'];
		$f['active'] = $data['active'];
		$f['id_suppleir'] = $data['id_suppleir'];
		$f['id_category'] = $data['id_category'];
		$this->db->StartTrans();
		if(!$this->db->Insert()){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function parseUrl($url){
		$html = file_get_html($url);
		if(!$html){
			return false;
		}
		return $html;
	}

	public function epicenter($data){
		global $Products;
		global $Specification;
		global $Images;
		$base_url = 'https://27.ua';
		$url = sprintf($base_url.'/search/?q=%s', $data[0]);
		if($pre_parsed_html = $this->parseUrl($url)){
			$link = $pre_parsed_html->find('.productListConteiner .product-Wrap .name-product');
			$url = $base_url.$link[0]->attr['href'];
		}
		if($Products->SetFieldsByRewrite(G::StrToTrans($link[0]->plaintext))){
			return false;
		}
		unset($pre_parsed_html);
		if($parsed_html = $this->parseUrl($url)){
			// Получаем артикул товара
			$product['sup_comment'] = trim($data[0]);
			// Получаем название товара
			$product['name'] = $parsed_html->find('h1', 0)->plaintext;
			// Получаем описание товара
			// $product['descr'] = $parsed_html->find('[itemprop="description"]', 0)->plaintext;
			// Получаем цену товара
			$product['price_opt_otpusk'] = $product['price_mopt_otpusk'] = $parsed_html->find('.productCard .price .price-wrapper', 0)->innertext;
			// Получаем характеристики товара
			foreach($parsed_html->find('.fullDescriptionConteiner table .product__feature tr') as $element){
				$caption = str_replace(':', '', trim($element->children(0)->plaintext));
				if($caption !== '' && !in_array($caption, array('Доставка', 'Самовывоз', 'Гарантия'))){
					$value = trim($element->children(1)->plaintext);
					$spec = $Specification->SpecExistsByCaption($caption);
					$product['specs'][] = array(
						'id_spec' => $spec?$spec['id']:$Specification->Add(array('caption' => $caption)),
						'value' => $value
					);
				}
			}
			// Получаем изображения товара максимального размера
			foreach($parsed_html->find('.PurchaseBody .image-wrap img') as $element){
				$filename = $element->src;
				$img_info = array_merge(getimagesize($filename), pathinfo($filename));
				$path = $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/';
				$Images->checkStructure($path);
				copy($filename, $path.$img_info['basename']);
				$product['images'][] = str_replace($GLOBALS['PATH_global_root'], '/', $path.$img_info['basename']);
				$product['images_visible'][] = 1;
			}
		}
		return $product;
	}

	public function zampodarki($data){
		global $Products;
		global $Specification;
		global $Images;
		$data[0] = trim($data[0]);
		$data[1] = trim($data[1]);
		$base_url = 'http://zamorskiepodarki.com';
		$url = sprintf($base_url.'/shop/?searchPhrase=%s', $data[0]);
		if($pre_parsed_html = $this->parseUrl($url)){
			$link = $pre_parsed_html->find('.goodName');
			$url = $base_url.$link[0]->attr['href'];
		}
		if($Products->SetFieldsByRewrite(G::StrToTrans($data[1]))){
			if($Products->SetFieldsByRewrite(G::StrToTrans($data[1].' ('.$data[0].')'))){
				$data[1] = $data[1].' ('.$data[0].')';
				print_r('<pre>'.G::StrToTrans($data[1]).'</pre>');
				print_r('<pre>Translit issue</pre>');
				return false;
			}
		}
		unset($pre_parsed_html);
		if($parsed_html = $this->parseUrl($url)){
			// Получаем артикул товара
			$product['sup_comment'] = trim($data[0]);
			// Получаем название товара
			$product['name'] = trim($data[1]);
			// Получаем описание товара
			// $product['descr'] = $parsed_html->find('[itemprop="description"]', 0)->plaintext;
			// Получаем цену товара
			$product['price_opt_otpusk'] = $product['price_mopt_otpusk'] = trim($data[2]);
			// Получаем характеристики товара
			// foreach($parsed_html->find('.fullDescriptionConteiner table .product__feature tr') as $element){
			// 	$caption = str_replace(':', '', trim($element->children(0)->plaintext));
			// 	if($caption == 'Артикул'){
			// 		$sup_comment = trim($element->children(1)->plaintext);
			// 	}elseif($caption !== '' && !in_array($caption, array('Доставка', 'Самовывоз', 'Гарантия'))){
			// 		$value = trim($element->children(1)->plaintext);
			// 		$spec = $Specification->SpecExistsByCaption($caption);
			// 		$product['specs'][] = array(
			// 			'id_spec' => $spec?$spec['id']:$Specification->Add(array('caption' => $caption)),
			// 			'value' => $value
			// 		);
			// 	}
			// }
			// Получаем изображения товара максимального размера
			foreach($parsed_html->find('#bigLayout img') as $element){
				$filename = $base_url.$element->src;
				if(strpos($filename, '.jpg')){
					$img_info = array_merge(getimagesize($filename), pathinfo($filename));
					$path = $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/';
					$Images->checkStructure($path);
					copy($filename, $path.$img_info['basename']);
					$product['images'][] = str_replace($GLOBALS['PATH_global_root'], '/', $path.$img_info['basename']);
					$product['images_visible'][] = 1;
				}
			}
		}
		return $product;
	}

	public function supertorba($data){
		global $Products;
		global $Specification;
		global $Images;
		$Unit = new Unit();;
		$data[0] = trim($data[0]);
		$data[1] = trim($data[1]);
		if($Products->SetFieldsByRewrite(G::StrToTrans($data[1]))){
			if($Products->SetFieldsByRewrite(G::StrToTrans($data[1].' ('.$data[0].')'))){
				$data[1] = $data[1].' ('.$data[0].')';
				print_r('<pre>'.G::StrToTrans($data[1]).'</pre>');
				print_r('<pre>Translit issue</pre>');
				return false;
			}
		}
		// Получаем артикул товара
		$product['sup_comment'] = trim($data[0]);
		// Получаем название товара
		$product['name'] = trim($data[1]);
		// Получаем цену товара
		$product['price_opt_otpusk'] = $product['price_mopt_otpusk'] = trim($data[2]);
		// Получаем id еденицы измерения товара. Если такой нет в БД - создаем новую.
		if(!$id_unit = $Unit->GetUnitIDByName($data[3])){
			$id_unit = $Unit->Add(array('unit_xt' => $data[3], 'unit_prom' => $data[3]));
		}
		$product['id_unit'] = $id_unit;
		// Получаем изображение товара
		$filename = $GLOBALS['PATH_product_img'].'custom_upload'.DIRECTORY_SEPARATOR.$data[0].'.jpg';
		if(!@getimagesize($filename)){
			return false;
		}
		$img_info = array_merge(getimagesize($filename), pathinfo($filename));
		$path = $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/';
		$Images->checkStructure($path);
		copy($filename, $path.$img_info['basename']);
		$product['images'][] = str_replace($GLOBALS['PATH_global_root'], '/', $path.$img_info['basename']);
		$product['images_visible'][] = 1;
		return $product;
	}

	public function zona($data){
		global $Products;
		global $Specification;
		global $Images;
		$base_url = 'http://zona220.com';
		$id_category = 0;
		if($parsed_html = $Parser->parseUrl( $res['url'])){
			// Название товара
			$product['name'] = $parsed_html->find('[itemprop="name"]', 0)->plaintext;
			if(!$product['name']){
				return false;
			}
			if($Products->SetFieldsByRewrite(G::StrToTrans($product['name']))){
				return false;
			}
			// Описание товара
			$product['descr'] = $parsed_html->find('[itemprop="description"]', 0)->plaintext;
			// Указываем базовую активность товара
			$product['active'] = 1;
			// Получаем цену товара
			$product['price_opt_otpusk'] = $product['price_mopt_otpusk'] = $parsed_html->find('[itemprop="price"]', 0)->innertext;
			// Находим характеристики товара
			foreach($parsed_html->find('.stats tr') as $element){
				$caption = trim($element->find('.name span', 0)->innertext);
				if($caption == 'Артикул'){
					$product['sup_comment'] = trim($element->children(1)->plaintext);
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
			foreach($parsed_html->find('#photo #elementTableImg img') as $element){
				$filename = $base_url.str_replace('/500_500_1/', '/', str_replace('/resize_cache/', '/', $element->src));
				$img_info = array_merge(getimagesize($filename), pathinfo($filename));
				$path = $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/';
				$Images->checkStructure($path);
				copy($filename, $path.$img_info['basename']);
				$product['images'][] = str_replace($GLOBALS['PATH_global_root'], '/', $path.$img_info['basename']);
				$product['images_visible'][] = 1;
			}
		}
		return $product;
	}
}
