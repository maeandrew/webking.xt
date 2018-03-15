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
		$arrContextOptions=array(
			"ssl"=>array(
				"verify_peer"=>false,
				"verify_peer_name"=>false,
			),
		); 
		$html = file_get_html($url, false, stream_context_create($arrContextOptions));
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
			$data[1] = $data[1].' ('.$data[0].')';
			if($Products->SetFieldsByRewrite(G::StrToTrans($data[1]))){
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

	public function trislona($data){
		global $Products;
		global $Specification;
		global $Images;
		$data[0] = trim($data[0]);
		$data[1] = trim($data[1]);
		if($Products->SetFieldsByRewrite(G::StrToTrans($data[1]))){
			$data[1] = $data[1].' ('.$data[0].')';
			if($Products->SetFieldsByRewrite(G::StrToTrans($data[1]))){
				print_r('expression2');
				print_r('<pre>'.G::StrToTrans($data[1]).'</pre>');
				print_r('<pre>Translit issue</pre>');
				return false;
			}
		}
		// Получаем артикул товара
		$product['sup_comment'] = trim($data[0]);
		// Получаем название товара
		$product['name'] = trim($data[1]);
		// Получаем описание товара
		$product['descr'] = str_replace('&nbsp;', ' ', strip_tags(trim($data[4])));
		// Получаем цену товара
		$product['price_mopt_otpusk'] = trim($data[5]);
		$product['price_opt_otpusk'] = trim($data[6]);
		$product['inbox_qty'] = trim($data[7]);
		// Получаем изображения товара максимального размера
		foreach(explode(',', $data[2]) as $filename){
			if(strpos($filename, '.jpg')){
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

	public function supertorba($data){
		global $Products;
		global $Specification;
		global $Images;
		$Unit = new Unit();
		$data[0] = trim($data[0]);
		$data[1] = trim($data[1]);
		if($Products->SetFieldsByRewrite(G::StrToTrans($data[1]))){
			$data[1] = $data[1].' ('.$data[0].')';
			if($Products->SetFieldsByRewrite(G::StrToTrans($data[1]))){
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
		// Получаем
		$product['inbox_qty'] = $data[4];
		$product['min_mopt_qty'] = $data[5];
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

	public function elfa($data){
		global $Products;
		global $Specification;
		global $Images;
		function get_web_page($url) {
		    $options = array(
		        CURLOPT_RETURNTRANSFER => true,   // return web page
		        CURLOPT_HEADER         => true,   // don't return headers
		        CURLOPT_FOLLOWLOCATION => true,   // follow redirects
		        CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
		        CURLOPT_ENCODING       => "",     // handle compressed
		        CURLOPT_USERAGENT      => "test", // name of client
		        CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
		        CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
		        CURLOPT_TIMEOUT        => 120,    // time-out on response
		        CURLOPT_RETURNTRANSFER => true,
		        CURLOPT_SSL_VERIFYPEER => false,  // Blindly accept the certificate
		    );

		    $ch = curl_init($url);
		    curl_setopt_array($ch, $options);
		    $content = curl_exec($ch);
			$curlinfo_effective_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
		    curl_close($ch);

		    return $curlinfo_effective_url;
		}
		$base_url = 'https://repka.ua';
		$url = sprintf($base_url.'/search/?q=%s', $data[0]);
		$url = get_web_page($url);
		if($pre_parsed_html = $this->parseUrl('http://repka.ua/sredstva-dlya-epilyatsii-i-depilyatsii/camomile-depilation-75ml-4823015936586-328508/')){
			$name = $pre_parsed_html->find('[itemprop="name"]', 0)->plaintext;
		}
		die();
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

	public function mastertool($data){
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
		// Получаем количество товара
		$product['inbox_qty'] = $data[2];
		$product['min_mopt_qty'] = $data[3];
		// Получаем цену товара
		$product['price_mopt_otpusk'] = trim($data[4]);
		$product['price_opt_otpusk'] = trim($data[5]);
		// Получаем id еденицы измерения товара. Если такой нет в БД - создаем новую.
		if(!$id_unit = $Unit->GetUnitIDByName($data[6])) {
			$id_unit = $Unit->Add(array('unit_xt' => $data[6], 'unit_prom' => $data[6]));
		}
		$id_product['id_unit'] = $id_unit;


		// Получаем изображение товара
		$images = glob($GLOBALS['PATH_product_img'].'custom_upload/mastertool'.DIRECTORY_SEPARATOR.$data[0].'.jpg');
		$images2 = glob($GLOBALS['PATH_product_img'].'custom_upload/mastertool'.DIRECTORY_SEPARATOR.$data[0].'_u.jpg');
		$images = array_merge($images, $images2);

		if(empty($images)){
			return false;
		}
		foreach ($images as $img) {
			if(!@getimagesize($img)){
				continue;
			}
			$img_info = array_merge(getimagesize($img), pathinfo($img));
			$path = $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/';
			$Images->checkStructure($path);
			copy($img, $path.$img_info['basename']);
			$product['images'][] = str_replace($GLOBALS['PATH_global_root'], '/', $path.$img_info['basename']);
			$product['images_visible'][] = 1;
		}
		if(!isset($product['images'])){
			return false;
		}
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

	public function nl($data){
		global $Products;
		global $Specification;
		global $Images;
		$base_url = 'https://nl.ua';
		$url = sprintf($base_url.'/ru/find/?q=%s', $data[0]);
		if($pre_parsed_html = $this->parseUrl($url)){
			$link = $pre_parsed_html->find('.items-wrapper .item-good .title a');
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
			$product['name'] = $parsed_html->find('main h1', 0)->plaintext;
			// Получаем описание товара
			$product['descr'] = $parsed_html->find('.detail_text .text_content', 0)->plaintext;
			// Получаем цену товара
			preg_match_all('/^\d+.\d+/', trim($parsed_html->find('.item_current_price', 0)->innertext), $price);
			$product['price_opt_otpusk'] = $product['price_mopt_otpusk'] = floatval($price[0][0]);
			// Получаем характеристики товара
			foreach($parsed_html->find('.item_properties dl') as $element){
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
			foreach($parsed_html->find('.thumbs-wrapper .thumbs img') as $element){
				$filename = str_replace('/71_70_1/', '/', str_replace('/resize_cache/', '/', $base_url.$element->src));
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
	public function presto($data){

		echo  "function presto -> ОК<br />";
		echo  $data, "<br />";

		global $Products;
		global $Specification;
		global $Images;
		$xml = simplexml_load_file($_FILES['file']['tmp_name']);
		//print_r($xml);
		foreach ($xml->xpath('/yml_catalog/shop') as $element) {
			foreach ($element->xpath('offers/offer') as $offer) {
				
				if(trim($offer->vendorCode) == trim($data)){
					echo  $data, "  ==  ", $offer->vendorCode,"  ДА+++++++++++++++++++ <br />";
					$start = microtime(true);
				 	// Получаем артикул товара
					$product['sup_comment'] = $offer->vendorCode;
					// Получаем название товара
					$product['name'] = $offer->name;
					// Получаем количество товара
					$product['inbox_qty'] = '5';
					$product['min_mopt_qty'] = '1';
					// Получаем цену товара
					$product['price_mopt_otpusk'] = $product['price_opt_otpusk'] = $offer->price;
					// Описание товара
					$product['descr'] = $offer->description;
					// Указываем базовую активность товара
					$product['active'] = '1';
					
					// Находим характеристики товара
					foreach ($offer->param as $param) {
						$caption = $param [name];

						if($caption !== '' && !in_array($caption, array('Доставка', 'Самовывоз', 'Гарантия'))){
							$value = $param;
							$spec = $Specification->SpecExistsByCaption($caption);
							$product['specs'][] = array('id_spec' => $spec?$spec['id']:$Specification->
							Add(array('caption' => $caption)), 'value' => $value);
						}
					}
					//Выбираем изображения максимального размера
					$j=0; // для пропуска 2 изображения
					foreach ($offer->picture as $picture) {
					 	if ($j==1){
							//echo $picture, "Отмена <br />";
							$j++;
							continue;
						}
						else{
					    	$img_info = array_merge(array(getimagesize($picture)), pathinfo($picture));
							$path = $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/';
							$Images->checkStructure($path);
							copy($picture, $path.$img_info['basename']);
							sleep(2);
							$product['images'][] = str_replace($GLOBALS['PATH_global_root'], '/', $path.$img_info['basename']);
							$product['images_visible'][] = 1;
							$j++;
						}
					}
					break;
				}
				else{
					echo  $data, "  ==  ", $offer->vendorCode,"  НЕТ <br />";
					continue;
				}
			}
		}
 		return $product;
 	}
	public function bluzka($offer){
		echo  "function bluzka -> ОК<br />";

		global $Products;
		global $Specification;
		global $Images;
						
					$start = microtime(true);
				 	// Получаем артикул товара
					$product['sup_comment'] = $offer->vendorCode;
										
					//Получаем название товара
					$product['name'] = strip_tags(stristr($offer->description, 'Состав', true));
					$product['name'] = str_replace("&nbsp;",'', $product['name']);
					$product['name'] = trim($product['name']);
					$product['name'] .= " (";
					$product['name'] .= $offer->param;
					$product['name'] .= ")";

					//Получаем количество товара
					$product['inbox_qty'] = '2';
					$product['min_mopt_qty'] = '1';
					
					// Описание товара
					$search  = array('<h1>', '</h1>');
					$replace = array('<h2>', '</h2>');
					$product['descr'] = str_replace($search, $replace, $offer->description);

					// Указываем базовую активность товара
					$product['active'] = '1';

					//Указиваем обезательное примечание
					$product['note_control'] = '1';
					
					// Получаем изображения товара максимального размера из $offer
					$filename = $offer->picture;
					$img_info = array_merge(getimagesize($filename), pathinfo($filename));
					
					$path = $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/';
					$Images->checkStructure($path);
					// Получаем изображения товара максимального размера из $offer
					copy($filename, $path.$img_info['basename']);
					sleep(2);
					$product['images'][] = str_replace($GLOBALS['PATH_global_root'], '/', $path.$img_info['basename']);
					$product['images_visible'][] = 1;
					
					// Находим характеристики товара
					$caption = $offer->param[1]['name'];
					foreach (explode(", ", $offer->param[1])as $razmer){
						$caption = $offer->param[1]['name'];
					// echo $razmer,"<br />";
								$spec = $Specification->SpecExistsByCaption($caption);
								$product['specs'][] = array('id_spec' => $spec? $spec['id']: $Specification->Add(array('caption' => $caption)), 'value' => $razmer);
					}
					// Получаем оптовую цену товара
					if($html = $this->parseUrl($offer->url)){
					echo "Зашли на карточку товара <br />";
						$product['price_mopt_otpusk'] = $product['price_opt_otpusk'] = trim($html->find('.js_price_ws', 0)->innertext);
					}

 		return $product;
 	}



}
