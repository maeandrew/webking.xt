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

	//Индивидуальные настройки сайтов-----------------------------------------------------------

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

	public function DCLing($data){
		global $Products;
		global $Specification;
		global $Images;

		$base_url = 'https://opt.dclink.com.ua/item.htm?id=';
		$url = $base_url.$data;
		echo  $url,"<br />";
		
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, array (
	        'login' => 'ХозТорг(Харьков)',
	        'password' => 'm2kyCSZv',
	        'showprice' => '1'    )); //параметры запроса
	    curl_setopt($ch, CURLOPT_URL, $url);
    
		if($parsed_html = $this->parseUrl($url)){
		echo  $parsed_html,"<br />";


			// Название товара
			$product['name'] = $parsed_html->find('h1')->plaintext;
			$product['name'] = $parsed_html->find('h1')->innertext;
			die();
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
		curl_close($ch);
		return $product;
	}

	public function DCLing_API($Product_Code, $Product_Name, $Product_Price, $sim_url_imag){
		global $Products;
		global $Specification;
		global $Images;

		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, array (
		    'login' => 'ХозТорг(Харьков)',
		    'password' => 'm2kyCSZv',
		    'id' => $Product_Code
		));
				
		// Название товара
		$product['name'] = $Product_Name;
		if(!$product['name']){
			return false;
		}
		if($Products->SetFieldsByRewrite(G::StrToTrans($product['name']))){
			return false;
		}

		// Описание товара
		$url="https://api.dclink.com.ua/api/GetItemDescription";
 		curl_setopt($ch, CURLOPT_URL, $url);
		$description = json_decode(curl_exec($ch), true);
			foreach ($description as $key => $value) {
				foreach ($value as $key => $value) {
				$product['descr'] = $value;	
				}
			}
		// Указываем базовую активность товара
		$product['active'] = 1;

		// Получаем цену товара
		$product['price_opt_otpusk'] = $product['price_mopt_otpusk'] = $Product_Price * 26;

		// Находим характеристики товара
		$url="https://api.dclink.com.ua/api/GetItemProperties";
 		curl_setopt($ch, CURLOPT_URL, $url);
 		$response = json_decode(curl_exec($ch), true);
 		$properties_arr = array();
 		$values_arr = array();
 		$items_arr = array();

		foreach ($response as $key => $value) {
			if($key == 'properties')
					$properties_arr = $value;
			if($key == 'values')
					$values_arr = $value;
			if($key == 'items')
					$items_arr = $value;
		}

		foreach ($items_arr as $key => $value) {
			foreach ($value as $key1 => $value1) {
				$temp = $temp2 = '';
				foreach ($properties_arr as $key => $value_pro) {
					if($value_pro[0] == $value1[0]) {
						$temp = $value_pro[1];
					}
				}
				foreach ($values_arr as $key => $value_val) {
					if($value_val[0] == $value1[1]) {
						$temp2 = $value_val[1];
					}
				}
				$caption = $temp;
				if($caption !== '' && !in_array($caption, array('Доставка', 'Самовывоз', 'Гарантия'))){
					$value = $temp2;
					$spec = $Specification->SpecExistsByCaption($caption);
					$product['specs'][] = array(
					'id_spec' => $spec?$spec['id']:$Specification->Add(array('caption' => $caption)),
					'value' => $value
					);
				}
			}
		}


		//назначаем артикул поставщика
		$product['sup_comment'] = $Product_Code;	
		//фото
		foreach ($sim_url_imag->Product as $Product_imag) {
			if((int)$Product_imag->Code == (int)$Product_Code){
				echo $Product_imag->URL, "<br />";
				$filename = $Product_imag->URL;
				$img_info = array_merge(getimagesize($filename), pathinfo($filename));
				$path = $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/';
				$Images->checkStructure($path);
				copy($filename, $path.$img_info['basename']);
				$product['images'][] = str_replace($GLOBALS['PATH_global_root'], '/', $path.$img_info['basename']);
				$product['images_visible'][] = 1;
			}
		}
			curl_close($ch);
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
 	public function zona_XML($offer){
		echo "Ок парсим товар<br />";
		global $Products;
		global $Specification;
		global $Images;

	 	// Получаем артикул товара
		$product['sup_comment'] = $offer['id'];
							
		//Получаем название товара
		$product['name'] = $offer->name;
		
		//Получаем количество товара
		$product['inbox_qty'] = '2';
		$product['min_mopt_qty'] = '1';
		
		//Указываем базовую активность товара
		$product['active'] = '1';

		//Указиваем обезательное примечание
		$product['note_control'] = '0';

		// Получаем оптовую цену товара
		$product['price_mopt_otpusk'] = $product['price_opt_otpusk'] = $offer->price;
		
			// Получаем характеристики товара
			$product['specs'][] = array('id_spec' => 22, 'value' => $offer->vendor);
				
			foreach ($offer->param as $param) {
				$caption = $param ['name'];
				if($caption !== '' && !in_array($caption, array('Доставка', 'Самовывоз', 'Гарантия', 'Оплата\Доставка', 'Доступное количество', 'Тип оплаты'))){
					$value = $param;
					$spec = $Specification->SpecExistsByCaption($caption);
					$product['specs'][] = array('id_spec' => $spec?$spec['id']:$Specification->Add(array('caption' => $caption)), 'value' => $value);
				}
			}

			// Получаем изображения товара максимального размера
			foreach ($offer->picture as $picture) {
			    	$img_info = array_merge(array(getimagesize($picture)), pathinfo($picture));
					$path = $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/';
					$Images->checkStructure($path);
					copy($picture, $path.$img_info['basename']);
					$product['images'][] = str_replace($GLOBALS['PATH_global_root'], '/', $path.$img_info['basename']);
					$product['images_visible'][] = 1;
			}

			// Получаем описание товара
			$product['descr'] =  'Описание временно отсутствует';
	
		// sleep(1);
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

	public function bluzka_0($data, $sim_url){
		// echo  "function bluzka -> ОК<br />";
		// echo  $data, "<br />";
		global $Products;
		global $Specification;
		global $Images;
		// $sim_url = simplexml_load_file($_POST['url']);
		foreach ($sim_url->xpath('/yml_catalog/shop') as $element) {
			foreach ($element->xpath('offers/offer') as $offer) {
					$Code_color = $offer->vendorCode;
					$Code_color .= $offer->param;
				if(trim($Code_color) == trim($data)){
					echo  $data, "  ==  ", $Code_color,"  ДА+++++++++++++++++++ <br />";
					
					$start = microtime(true);
				 	// Получаем артикул товара
					$product['sup_comment'] = $offer->vendorCode;
					//Получаем название товара
					$product['name'] = $str_name = strip_tags(stristr($offer->description, 'Состав', true));
					$product['name'] .= " (";
					$product['name'] .= $offer->param;
					$product['name'] .= ")";
					//Получаем количество товара
					$product['inbox_qty'] = '2';
					$product['min_mopt_qty'] = '1';
					
					// Описание товара
					$product['descr'] = str_replace("<h1>", "<h2>", $offer->description);
					// Указываем базовую активность товара
					$product['active'] = '1';
					//Указиваем обезательное примечание
					$product['note_control'] = '1';
					
					// Получаем изображения товара максимального размера
					
					$filename = $offer->picture;
					$img_info = array_merge(getimagesize($filename), pathinfo($filename));
					$path = $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/';
					$Images->checkStructure($path);
					copy($filename, $path.$img_info['basename']);
					$product['images'][] = str_replace($GLOBALS['PATH_global_root'], '/', $path.$img_info['basename']);
					$product['images_visible'][] = 1;
					// Находим характеристики товара
					$caption = $offer->param[1]['name'];
					// echo $caption,"<br />";
					foreach (explode(", ", $offer->param[1])as $razmer){
						$caption = $offer->param[1]['name'];
						// echo $razmer,"<br />";
								$spec = $Specification->SpecExistsByCaption($caption);
								$product['specs'][] = array('id_spec' => $spec?$spec['id']:$Specification->
									Add(array('caption' => $caption)), 'value' => $razmer);
					}
					if($html = $this->parseUrl($offer->url)){
						// Получаем оптовую цену товара
					$product['price_mopt_otpusk'] = $product['price_opt_otpusk'] = trim($html->find('.js_price_ws', 0)->innertext);
					
					}
					break;
				}
				else{
					echo  $data, "  ==  ", $Code_color,"  НЕТ <br />";
					// die();
					continue;
				}
			}
		}
 		return $product;
 	}
	public function bluzka($offer){
		// echo  "function bluzka -> ОК<br />";

		global $Products;
		global $Specification;
		global $Images;

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
		// sleep(3);
		$product['images'][] = str_replace($GLOBALS['PATH_global_root'], '/', $path.$img_info['basename']);
		$product['images_visible'][] = 1;
		
		// Находим характеристики товара
		$caption = $offer->param[1]['name'];
		foreach (explode(", ", $offer->param[1])as $razmer){
			$caption = $offer->param[1]['name'];
			$spec = $Specification->SpecExistsByCaption($caption);
			$product['specs'][] = array('id_spec' => $spec? $spec['id']: $Specification->Add(array('caption' => $caption)), 'value' => $razmer);
		}
		// Получаем оптовую цену товара
		if($html = $this->parseUrl($offer->url)){
		// echo "Зашли на карточку товара <br />";
			$product['price_mopt_otpusk'] = $product['price_opt_otpusk'] = trim($html->find('.js_price_ws', 0)->innertext);
		}else{
			$product['price_mopt_otpusk'] = $product['price_opt_otpusk'] = 0;
		}
 		return $product;
 	}
 	public function bluzka_pras($offer){
		// echo  "function bluzka -> ОК<br />";

		global $Products;
		global $Specification;
		global $Images;

	 	
							
		// Получаем оптовую цену товара
		if($html = $this->parseUrl($offer->url)){
		// echo "Зашли на карточку товара <br />";
			echo trim($html->find('.js_price_ws', 0)->innertext), '<br />';
			
		}else{
			echo 0, '<br />';
			
		}
 		return 0;
 	}

	public function nl($data){
		// echo  "function nl -> ОК<br />";
		global $Products;
		global $Specification;
		global $Images;
		$base_url = 'https://nl.ua';
		$url = sprintf($base_url.'/ru/find/?q=%s', $data[0]);
		echo  $url,"<br />";
		if($pre_parsed_html = $this->parseUrl($url)){
			$link = $pre_parsed_html->find('.items-wrapper .item-good .title a');
			$url = $base_url.$link[0]->attr['href'];
		}
		if($Products->SetFieldsByRewrite(G::StrToTrans($link[0]->plaintext))){
			return false;
		}
		unset($pre_parsed_html);
		echo  $url,"<br />";
		if($parsed_html = $this->parseUrl($url)){
			// Получаем артикул товара
			$product['sup_comment'] = trim($data[0]);
			// Получаем название товара
			$product['name'] = $parsed_html->find('main h1', 0)->plaintext;
			// Получаем описание товара
			$product['descr'] =  $parsed_html->find('.text_content', 0)->innertext;;
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
 	public function NewLine_XML($offer){
		// echo "Ок парсим товар<br />";
		global $Products;
		global $Specification;
		global $Images;

	 	// Получаем артикул товара
		$product['sup_comment'] = $offer->vendorCode;
							
		//Получаем название товара
		$product['name'] = $offer->name;
		
		//Получаем количество товара
		$product['inbox_qty'] = '2';
		$product['min_mopt_qty'] = '1';
		
		//Указываем базовую активность товара
		$product['active'] = '1';

		//Указиваем обезательное примечание
		$product['note_control'] = '0';
		
		// Получаем оптовую цену товара
		$product['price_mopt_otpusk'] = $product['price_opt_otpusk'] = $offer->price;
		

		if($parsed_html = $this->parseUrl($offer->url)){
			// sleep(5);
			// echo "Заходим на url<br />";

			// Получаем описание товара
			$product['descr'] =  $parsed_html->find('.text_content', 0)->innertext;
			
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
			$base_url = 'https://nl.ua';
			foreach($parsed_html->find('.thumbs-wrapper .thumbs img') as $element){
				$filename = str_replace('/71_70_1/', '/', str_replace('/resize_cache/', '/', $base_url.$element->src));
				$img_info = array_merge(getimagesize($filename), pathinfo($filename));
				$path = $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/';
				$Images->checkStructure($path);
				copy($filename, $path.$img_info['basename']);
				$product['images'][] = str_replace($GLOBALS['PATH_global_root'], '/', $path.$img_info['basename']);
				$product['images_visible'][] = 1;
			}

			// foreach($parsed_html->find('.thumbs-wrapper .thumbs img') as $element){
			// 	$filename = str_replace('/71_70_1/', '/', str_replace('/resize_cache/', '/', $base_url.$element->src));
			// 	$img_info = array_merge(getimagesize($filename), pathinfo($filename));
			// 	$path = $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/';
			// 	$Images->checkStructure($path);
			// 	$newname = $offer->vendorCode.($key == 0?'new':'new-'.$key).'.jpg';;
			// 	copy($filename, $path.$newname);
			// 	$product['images'][] = str_replace($GLOBALS['PATH_global_root'], '/', $newname);
			// 	$product['images_visible'][] = 1;
			// }
		}

			echo 'sup_comment -> ', $product['sup_comment'], "<br />";
			echo 'name -> ', $product['name'], "<br />";
			echo 'price_mopt_otpusk -> ', $product['price_mopt_otpusk'], "<br />";
			echo 'price_opt_otpusk -> ', $product['price_opt_otpusk'], "<br />";
			echo 'inbox_qty -> ', $product['inbox_qty'], "<br />";
			echo 'min_mopt_qty -> ', $product['min_mopt_qty'], "<br />";
			echo 'note_control -> ', $product['note_control'], "<br />";
			echo 'descr -> ', $product['descr'], "<br />";
			echo 'active -> ', $product['active'], "<br />";
			echo "Количество характеристик ", count($product['specs']), "<br />";
				foreach ($product['specs'] as $key => $value) {
					foreach ($value as $key => $value) {
						echo $key," ", $value," ";
					}
					echo "<br />";
				}
			echo "Количество фото ", count($product['images']), "<br />";
				foreach ($product['images'] as $key => $value) {
					echo $key," ", $value," <br />";
				}

 		return $product;
 	}
 	public function S100($data){
		global $Products;
		global $Specification;
		global $Images;
			echo "парсим ->", $data, '<br/>';
		
		unset($pre_parsed_html);
		if($parsed_html = $this->parseUrl($data)){
			// Получаем название товара
			$product['name'] = $parsed_html->find('h1', 1)->plaintext;
			// echo $product['name'];			
			// Получаем артикул товара
			$product['sup_comment'] = $product['name'];	
			// Получаем описание товара
			$product['descr'] = $parsed_html->find('#tab-description', 0)->plaintext;
			// echo  $product['descr'], '<br/>';
			// Получаем цену товара
			$product['price_opt_otpusk'] = $product['price_mopt_otpusk'] = 1;
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
			foreach($parsed_html->find('.thumbnails .thumbnail img') as $element){
				$filename = $element->src;
				// echo $filename;
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
	public function Intertool_XML($offer){
		// echo "Ок парсим товар<br />";
		global $Products;
		global $Specification;
		global $Images;

	 	// Получаем артикул товара
		$product['sup_comment'] = $offer->vendorCode;
							
		//Получаем название товара
		$product['name'] = $offer->name;
		
		//Получаем количество товара в упаковке
		$product['inbox_qty'] = empty($offer->multiplicity) ? 2 : $offer->multiplicity;
		$product['min_mopt_qty'] = '1';

		//Указываем базовую активность товара
		$product['active'] = '1';

		//Указиваем обезательное примечание
		$product['note_control'] = '0';
		
		// Получаем оптовую цену товара
		$product['price_mopt_otpusk'] = $product['price_opt_otpusk'] = $offer->price;

		// Получаем описание товара
		$product['descr'] =  $offer->description;

		foreach($offer->param as $param){
			$caption = str_replace(':', '', trim($param['name']));
			if($caption !== '' && !in_array($caption, array('Доставка', 'Самовывоз', 'Гарантия'))){
				$value = $param;
				$spec = $Specification->SpecExistsByCaption($caption);
				$product['specs'][] = array(
					'id_spec' => $spec ? $spec['id']:$Specification->Add(array('caption' => $caption)),
					'value' => $value
				);
			}
		}
			
		// Получаем изображения товара максимального размера		
		foreach($offer->picture as $element){
			$img_info = array_merge(getimagesize($element), pathinfo($element));
			$path = $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/';
			$Images->checkStructure($path);
			copy($element, $path.$img_info['basename']);
			sleep(1);
			$product['images'][] = str_replace($GLOBALS['PATH_global_root'],'/', $path.$img_info['basename']);
			$product['images_visible'][] = 1;
		}

			
			echo 'sup_comment -> ', $product['sup_comment'], "<br />";
			echo 'name -> ', $product['name'], "<br />";
			echo 'price_mopt_otpusk -> ', $product['price_mopt_otpusk'], "<br />";
			echo 'price_opt_otpusk -> ', $product['price_opt_otpusk'], "<br />";
			echo 'inbox_qty -> ', $product['inbox_qty'], "<br />";
			echo 'min_mopt_qty -> ', $product['min_mopt_qty'], "<br />";
			echo 'note_control -> ', $product['note_control'], "<br />";
			echo 'descr -> ', $product['descr'], "<br />";
			echo 'active -> ', $product['active'], "<br />";
			echo "Количество характеристик ", count($product['specs']), "<br />";
				foreach ($product['specs'] as $key => $value) {
					foreach ($value as $key => $value) {
						echo $key," ", $value," ";
					}
					echo "<br />";
				}
			echo "Количество фото ", count($product['images']), "<br />";
				foreach ($product['images'] as $key => $value) {
					echo $key," ", $value," <br />";
				}
		// 	die();
 		return $product;
 	}
 	public function Sport_Baza($data){
		global $Products;
		global $Specification;
		global $Images;
		echo "парсим ->", $data, '<br/>';		
		if($parsed_html = $this->parseUrl($data)){
			print_r('<pre>');
			print_r($parsed_html);
			print_r('</pre>');
			// Получаем название товара
			$product['name'] = $parsed_html->find('breadcrumbs-1WtpdcnpBj')->plaintext;
			echo $product['name'];
			$product['name'] = $parsed_html->find('ul.breadcrumbs-1WtpdcnpBj li')->plaintext;
			echo $product['name'];
			$product['name'] = $parsed_html->find('ul.breadcrumbs-1WtpdcnpBj li')->plaintext;
			echo $product['name'];
			$product['name'] = $parsed_html->find('ul.breadcrumbs-1WtpdcnpBj li')->plaintext;
			echo $product['name'];
			$product['name'] = $parsed_html->find('ul.breadcrumbs-1WtpdcnpBj li')->plaintext;
			echo $product['name'];
			$product['name'] = $parsed_html->find('ul.breadcrumbs-1WtpdcnpBj li')->plaintext;
			echo $product['name'];
			die();
			// Получаем артикул товара
			$product['sup_comment'] = $product['name'];	
			// Получаем описание товара
			$product['descr'] = $parsed_html->find('#tab-description', 0)->plaintext;
			// echo  $product['descr'], '<br/>';
			// Получаем цену товара
			$product['price_opt_otpusk'] = $product['price_mopt_otpusk'] = 1;
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
			foreach($parsed_html->find('.thumbnails .thumbnail img') as $element){
				$filename = $element->src;
				// echo $filename;
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
	public function pnsemena_cat($data){
		echo "парсим ->", $data, '<br/>';		
		if($parsed_html = $this->parseUrl($data)){
			//выбераем категорию и товары
			$cat = array();
			foreach($parsed_html->find('#gallery a') as $a){
	    		// echo 'http://pnsemena.com.ua'. $a->href,' --------------- ', $a->plaintext,'------------------', 'http://pnsemena.com.ua', $a->find('img',0)->src, '</br>';
	    		// echo $a->plaintext, '</br>';
	    		// $art = 'http://pnsemena.com.ua'. $a->href;
	    		// echo substr($art, -3), ;
	    		array_push($cat, 'http://pnsemena.com.ua'.$a->href);
	    		// array_push($cat, $arrayName = array($a->plaintext, 'http://pnsemena.com.ua'. $a->href, 'http://pnsemena.com.ua'. $a->find('img',0)->src));
 			}
 		}
		return $cat;
	}
	public function pnsemena_prod($data){
		$url = $data;
		$prod = array();
		$pages = 1; //минимум одна страница должна быть
		for ($i=1; $i <= $pages; $i++) { 
			$url = $data[1].'&gpg='.$i;
			// echo "<br/><br/>парсим ->", $url, '   *********************************************************************<br/>';
			if($parsed_html = $this->parseUrl($url)){
				//выбераем количество страниц
				if ($i==1) {	
					$pages = $parsed_html->find('.dis', 1)->title;
					echo 'Страниц - ',$pages, '</br>';
				}					
				foreach($parsed_html->find('#gallery') as $gal){
					foreach ($gal->find('table ') as $table) {
						$arrayprod = array();
						//id категори
						array_push($arrayprod, $data[0]);
						//Название
						foreach ($table->find('h3') as $h3) {
							echo $data[2].' '. $h3->plaintext, '</br>';
							array_push($arrayprod, $data[2].' '. $h3->plaintext);
						}
						//Описание
						$dis='Описание';
						foreach ($table->find('p') as $p) {
							echo 'p--> ', $p->plaintext, '</br>';
							$dis = $dis . '</br>' . $p->plaintext;
						}
						array_push($arrayprod, $dis);
						//Сылка на фото
						foreach ($table->find('a') as $a) {
							echo 'jmg--> ', 'http://pnsemena.com.ua'.$a->href, '</br>';
						array_push($arrayprod, 'http://pnsemena.com.ua'.$a->href);
						}
						array_push($prod, $arrayprod);
						unset($arrayprod);
						echo '===================</br>';
					}
		 		}
			}
 		}
		return $prod;
	}
		public function pnsemena($offer){
		// echo "Ок парсим товар<br />";
		global $Products;
		global $Specification;
		global $Images;

	 	// Получаем артикул товара
		$product['sup_comment'] = '';
							
		//Получаем название товара
		$product['name'] = $offer[1];
		
		//Получаем количество товара в упаковке
		$product['inbox_qty'] = 20;
		$product['min_mopt_qty'] = 1;

		//Указываем базовую активность товара
		$product['active'] = '1';

		//Указиваем обезательное примечание
		$product['note_control'] = '0';
		
		// Получаем оптовую цену товара
		$product['price_mopt_otpusk'] = $product['price_opt_otpusk'] = 1;

		// Получаем описание товара
		$product['descr'] =  $offer[2];

		// foreach($offer->param as $param){
		// 	$caption = str_replace(':', '', trim($param['name']));
		// 	if($caption !== '' && !in_array($caption, array('Доставка', 'Самовывоз', 'Гарантия'))){
		// 		$value = $param;
		// 		$spec = $Specification->SpecExistsByCaption($caption);
		// 		$product['specs'][] = array(
		// 			'id_spec' => $spec ? $spec['id']:$Specification->Add(array('caption' => $caption)),
		// 			'value' => $value
		// 		);
		// 	}
		// }
			
		// Получаем изображения товара максимального размера
		$arrayName = array($offer[3]);

		foreach($arrayName as $element){
			$img_info = array_merge(getimagesize($element), pathinfo($element));
			$path = $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/';
			$Images->checkStructure($path);
			copy($element, $path.$img_info['basename']);
			$product['images'][] = str_replace($GLOBALS['PATH_global_root'], '/', $path.$img_info['basename']);
			$product['images_visible'][] = 1;
		}
		sleep(1);

		// echo "Заходим на url<br />";
		
		// if($parsed_html = $this->parseUrl($offer->url)){
		// 	// sleep(5);					
		// }

					echo 'sup_comment -> ', $product['sup_comment'], "<br />";
					echo 'name -> ', $product['name'], "<br />";
					echo 'price_mopt_otpusk -> ', $product['price_mopt_otpusk'], "<br />";
					echo 'price_opt_otpusk -> ', $product['price_opt_otpusk'], "<br />";
					echo 'inbox_qty -> ', $product['inbox_qty'], "<br />";
					echo 'min_mopt_qty -> ', $product['min_mopt_qty'], "<br />";
					echo 'note_control -> ', $product['note_control'], "<br />";
					echo 'descr -> ', $product['descr'], "<br />";
					echo 'active -> ', $product['active'], "<br />";
					// echo "Количество характеристик ", count($product['specs']), "<br />";
					// 	foreach ($product['specs'] as $key => $value) {
					// 		foreach ($value as $key => $value) {
					// 			echo $key," ", $value," ";
					// 		}
					// 		echo "<br />";
					// 	}
					echo "Количество фото ", count($product['images']), "<br />";
						foreach ($product['images'] as $key => $value) {
							echo $key," ", $value," <br />";
						}
		// 	die();
 		return $product;
 	}
}