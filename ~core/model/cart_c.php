<?php
class Cart {
	public $db;
	//public $fields;
	//private $usual_fields;
	//public $list;
	/** Конструктор
	 * @return
	 */
	public function __construct (){
		$this->db =& $GLOBALS['db'];
	}

	// добавление товара в корзину или изменение его количества
	public function UpdateCartQty($data){
		$products = new Products();
		$products->SetFieldsById($data['id_product'], 1);
		$product = $products->fields;
		$quantity = $data['quantity'];
		$note = isset($data['note_opt']) && !empty($data['note_opt'])?$data['note_opt']:(isset($data['note_mopt']) && !empty($data['note_mopt'])?$data['note_mopt']:'');
		if(isset($data['button']) && $data['button']){
			if($data['direction'] == 1){
				if($product['qty_control'] == 1 && fmod($quantity, $product['min_mopt_qty']) != 0){
					$quantity = $product['min_mopt_qty']*ceil($quantity/$product['min_mopt_qty']);
				}
				if($quantity < $product['min_mopt_qty']){
					$quantity = $product['min_mopt_qty'];
				}
			}else{
				if($product['qty_control'] == 1 && fmod($quantity, $product['min_mopt_qty']) != 0){
					$quantity = $product['min_mopt_qty']*floor($quantity/$product['min_mopt_qty']);
				}
				if($quantity < $product['min_mopt_qty']){
					$quantity = 0;
				}
			}
		}else{
			if($quantity > 0){
				if($product['qty_control'] == 1 && fmod($quantity, $product['min_mopt_qty']) != 0){
					$quantity = $product['min_mopt_qty']*round($quantity/$product['min_mopt_qty']);
				}
				if($quantity < $product['min_mopt_qty']){
					$quantity = $product['min_mopt_qty'];
				}
			}
		}
		if($quantity < $product['inbox_qty']){
			$mode = 'mopt';
			$other_mode = 'opt';
		}else{
			$mode = 'opt';
			$other_mode = 'mopt';
		}
		$base_price = $product['price_'.$mode];
		// Заполнение массива основных цен и суммы товара
		foreach($correction_set = explode(';', $GLOBALS['CONFIG']['correction_set_'.$product[$mode.'_correction_set']]) AS $cs){
			$summary[] = round(round($cs*$base_price, 2)*$quantity, 2);
			$actual_prices[] = round($cs*$base_price, 2);
		}
		// Заполнение массива дополнительных цен
		foreach(explode(';', $GLOBALS['CONFIG']['correction_set_'.$product[$other_mode.'_correction_set']]) AS $cs){
			$other_prices[] = round($cs*$product['price_'.$other_mode], 2);
		}
		if($quantity > 0){
			$_SESSION['cart']['products'][$product['id_product']]['quantity'] = $product['quantity'] = $quantity;
			$_SESSION['cart']['products'][$product['id_product']]['mode'] = $mode;
			$_SESSION['cart']['products'][$product['id_product']]['summary'] = $summary;
			$_SESSION['cart']['products'][$product['id_product']]['base_price'] = $base_price;
			$_SESSION['cart']['products'][$product['id_product']]['actual_prices'] = $product['actual_prices'] = $actual_prices;
			$_SESSION['cart']['products'][$product['id_product']]['other_prices'] = $product['other_prices'] = $other_prices;
			$_SESSION['cart']['products'][$product['id_product']]['correction_set'] = $correction_set;
			$_SESSION['cart']['products'][$product['id_product']]['note'] = $note;
			if(isset($data['id_cart_product'])){
				$_SESSION['cart']['products'][$product['id_product']]['id_cart_product'] = $data['id_cart_product'];
			}
		}else{
			if(isset($_SESSION['cart']['products'][$product['id_product']]['id_cart_product'])){
				$this->db->StartTrans();
				$this->db->DeleteRowFrom(_DB_PREFIX_."cart_product", "id_cart_product", $_SESSION['cart']['products'][$product['id_product']]['id_cart_product']);
				$this->db->CompleteTrans();
			}
			unset($_SESSION['cart']['products'][$product['id_product']]);
			$product['quantity'] = $quantity;
			$product['actual_prices'] = $actual_prices;
			$product['other_prices'] = $other_prices;
		}
		if($quantity > $product['product_limit']){
			$_SESSION['cart']['products'][$product['id_product']]['error_limit'] = true;
		}
		$this->RecalcCart();
		return array('cart'=>$_SESSION['cart'], 'product'=>$product);
	}
	/**
	 * удаляет товар из корзины
	 * @param integer $id_product [description]
	 * @param boolean $id_cart    [description]
	 */
	//	public function RemoveFromCart($id_product, $id_cart = false){
		// unset($_SESSION['cart']['products'][$id_product]);
		// if($id_cart){
		// 	$sql = "DELETE FROM "._DB_PREFIX_."cart_product
		// 		WHERE id_cart = ". $id_cart ."
		// 		AND id_product = ".$id_product;
		// 	$this->db->StartTrans();
		// 	if(!$this->db->Query($sql)){
		// 		$this->db->FailTrans();
		// 		return false;
		// 	}
		// 	$this->db->CompleteTrans();
		// }
		// $this->RecalcCart();
		// return $_SESSION['cart'];
	//	}

	// пересчет корзины
	public function RecalcCart(){
		$products_sum = array(0, 0, 0, 0);
		$cart_column = 0;
		if(!empty($_SESSION['cart']['products'])){
			foreach($_SESSION['cart']['products'] AS &$p){
				if(!isset($p['note'])){
					$p['note'] = '';
				}
				if(!empty($p['summary'])){ 
					foreach($p['summary'] AS $k=>$s){
						$products_sum[$k] += $s;
					}
				}
			}

			// определение колонки цен по сумме заказа
			$retail_margin = $GLOBALS['CONFIG']['retail_order_margin']; // 500
			$wholesale_margin = $GLOBALS['CONFIG']['wholesale_order_margin']; // 3000
			$full_wholesale_margin = $GLOBALS['CONFIG']['full_wholesale_order_margin']; // 10000
			if($products_sum[3] >= $full_wholesale_margin){
				$cart_column = 0;
			}elseif($products_sum[3] >= $wholesale_margin){
				$cart_column = 1;
			}elseif($products_sum[3] >= $retail_margin){
				$cart_column = 2;
			}elseif($products_sum[3] < $retail_margin){
				$cart_column = 3;
			}

		}else{
			$_SESSION['cart']['products'] = array();
		}
		$_SESSION['cart']['products_sum'] = $products_sum;
		$_SESSION['cart']['cart_column'] = $cart_column;
		$_SESSION['cart']['cart_sum'] = $products_sum[$cart_column];
		return true;
	}

	// Очищает корзину
	public function ClearCart($id_cart = null){
		$_SESSION['cart']['products'] = array();
		$_SESSION['cart']['unavailable_products'] = array();
		if(isset($_SESSION['cart']['id_order'])){
			unset($_SESSION['cart']['id_order']);
		}
		if(isset($_SESSION['cart']['id'])){
			//Временное решение. Удалить после определения ошибки
			$sql = "UPDATE "._DB_PREFIX_."cart
					SET `status` = 1 WHERE id_cart = ".$_SESSION['cart']['id'];
			$this->db->StartTrans();
			if(!$this->db->Query($sql)) {
				$this->db->FailTrans();
				return false;
			}
			$this->db->CompleteTrans();
		}
		unset($_SESSION['cart']['id']);
		//Закоментированно временно. Поиск ошибки.
		// if($id_cart){
		// 	$sql = "DELETE FROM "._DB_PREFIX_."cart_product
		// 			WHERE id_cart = ". $id_cart;
		// 	$this->db->StartTrans();
		// 	if(!$this->db->Query($sql)) {
		// 		$this->db->FailTrans();
		// 		return false;
		// 	}
		// 	$this->db->CompleteTrans();
		// }
		$this->RecalcCart();
		return true;
	}

	// Проверка на доступность товара
	public function IsAvailableProduct($id_product){
		global $db;
		$sql = "SELECT p.id_product
			FROM "._DB_PREFIX_."product p
			WHERE p.id_product = ".$id_product."
			AND p.visible = 1
			AND (p.price_mopt > 0 OR p.price_opt > 0)";
		// Добавить если нужно отсекать товары на которые нет поставщиков
		$res = $db->GetOneRowArray($sql);
		if(!$res){
			return false;
		}
		return true;
	}

	// Заполняет корзину товарами, такими как в заказе $id_order
	public function FillByOrderId($id_order, $add = null){
		$Order = new Orders();
		$Customer = new Customers();
		$Order->SetFieldsById($id_order);
		$order = $Order->fields;
		if($_SESSION['member']['gid'] == _ACL_CONTRAGENT_){
			$_SESSION['price_mode'] = 0;
			if($order['discount'] > 0 && $_SESSION['member']['id_user'] == $order['id_customer']){
				$_SESSION['price_mode'] = 1;
				$this->SetPersonalDiscount($order['discount']);
				$Customer->UpdateCustomer(array(
						'id_user' => $_SESSION['member']['id_user'],
						'email' => $_SESSION['member']['email'],
						'discount' => $order['discount']
					)
				);
			}
		}
		$products = $Order->GetOrderForCart(array('o.id_order'=>$id_order));
		if($add == null && isset($_SESSION['cart']['id'])){
			$this->ClearCart($_SESSION['cart']['id']);
		}elseif($_SESSION['member']['gid'] == _ACL_CONTRAGENT_ && $add == null && !isset($_SESSION['cart']['id'])){
			$_SESSION['cart'] = null;
		}
		if($_SESSION['member']['gid'] == _ACL_CONTRAGENT_){
			$_SESSION['cart']['base_order'] = $id_order;
			$_SESSION['cart']['id_customer'] = $order['id_customer'];
			$Customer->SetSessionCustomerBonusCart($order['id_customer'], 'cart');
		}
		foreach($products as $p){
			$p['quantity'] = $p['opt_qty']+$p['mopt_qty'];
			if($this->IsAvailableProduct($p['id_product'])){
				$this->UpdateCartQty($p);
				// $this->IsActualPrice($p);
			}else{
				$_SESSION['cart']['unavailable_products'][] = $p;
			}
		}
		// print_r($_SESSION['cart']);
		// die();
	}

	// Проверка актуальности цен
	public function IsActualPrice($product){
		//print_r($product);die();
		return true;
	}

	// Добавление и проверка корзины в БД
	public function DBCart(){
		//Удаляет товар из корзины
		if(isset($_POST['id_prod_for_remove'])){
			unset($_SESSION['cart']['products'][$_POST['id_prod_for_remove']]);
			if(G::IsLogged() && !_acl::isAdmin()){
				$this->db->StartTrans();
				if(!$this->db->DeleteRowsFrom(_DB_PREFIX_."cart_product",  array("id_cart = ".$_SESSION['cart']['id'], "id_product = ".$_POST['id_prod_for_remove']))){
					$this->db->FailTrans();
					return false;
				}
				$this->db->CompleteTrans();
				$this->RecalcCart();
			}
			return $_SESSION['cart'];
		}
		if(isset($_SESSION['cart']['id'])){
			//Меняем готовность заказа (ready=0) при изменении количества товаров в корзине
			if(isset($_SESSION['cart']['promo']) && $_SESSION['cart']['promo'] != '' && $_SESSION['cart']['adm'] == 0){
				$f['ready'] = 0;
				$this->db->Update(_DB_PREFIX_."cart", $f, "id_cart = ".$_SESSION['cart']['id']);
				unset($f);
			}
			// Обновить корзину в БД по id
			foreach($_SESSION['cart']['products'] as $key => &$product){
				$f['quantity'] = $product['quantity'];
				$f['price'] = $product['base_price'];
				$f['note'] = $product['note'];
				$this->db->StartTrans();
				if(isset($product['id_cart_product'])){
					if(!$this->db->Update(_DB_PREFIX_."cart_product", $f, "id_cart_product = ".$product['id_cart_product'])){
						$this->db->FailTrans();
						return false;
					}
				}else{
					$f['id_product'] = $key;
					$f['id_cart'] = $_SESSION['cart']['id'];
					if(!$this->db->Insert(_DB_PREFIX_."cart_product", $f)){
						$this->db->FailTrans();
						return false;
					}
					$product['id_cart_product'] = $this->db->GetLastId();
				}
				$this->db->CompleteTrans();
			}
			if(isset($product))	return $product['id_cart_product'];
		}else{
			// добавить корзину в БД и записать ее id в $_SESSION['cart']['id']
			if(G::IsLogged() && !_acl::isAdmin()){
				$f['id_user'] = $_SESSION['member']['id_user'];
				$this->db->StartTrans();
				if(!$this->db->Insert(_DB_PREFIX_.'cart', $f)){
					$this->db->FailTrans();
					return false; //Если не удалось записать в базу
				}
				unset($f);
				$_SESSION['cart']['id'] = $this->db->GetLastId();
				$this->db->CompleteTrans();
				foreach($_SESSION['cart']['products'] as $key => &$product){
					$f['id_product'] = $key;
					$f['quantity'] = $product['quantity'];
					$f['price'] = $product['base_price'];
					$f['id_cart'] = $_SESSION['cart']['id'];
					$this->db->StartTrans();
					if(!$this->db->Insert(_DB_PREFIX_."cart_product", $f)){
						$this->db->FailTrans();
						return false;
					}
					$product['id_cart_product'] = $this->db->GetLastId();
					$this->db->CompleteTrans();
					unset($f);
				}
				return $product['id_cart_product'];
			}
			return false;
		}
	}

	// Восстановление в корзину незавершенных покупок из предыдущей сессии
	public function LastClientCart(){
		$id = $_SESSION['member']['id_user'];
		$sql = "SELECT * FROM "._DB_PREFIX_."cart WHERE status LIKE '%0' AND id_user = ".$id." ORDER BY status DESC, creation_date DESC LIMIT 1";
		$res = $this->db->GetOneRowArray($sql);
		if(!empty($res)){
			$sql = "SELECT * FROM "._DB_PREFIX_."cart_product WHERE id_cart = ".$res['id_cart'];
			$res1 = $this->db->GetArray($sql);
			foreach($res1 as $value){
				if(isset($_SESSION['cart']['products'][$value['id_product']])){
					$this->db->StartTrans();
					$this->db->DeleteRowFrom(_DB_PREFIX_."cart_product", "id_product", $value['id_product']);
					$this->db->CompleteTrans();
				}
			}
			$_SESSION['cart']['id'] = $res['id_cart'];
			$_SESSION['cart']['promo'] = $res['promo'];
			$_SESSION['cart']['adm'] = $res['adm'];
			$_SESSION['cart']['ready'] = $res['ready'];
			$_SESSION['cart']['ready'] = isset($res['note'])?$res['note']:'';
			$this->DBCart();
			$sql = "SELECT * FROM "._DB_PREFIX_."cart_product WHERE id_cart = ".$res['id_cart'];
			$res = $this->db->GetArray($sql);
			foreach($res as $value){
				$this->UpdateCartQty($value);
			}
			return true;
		}
		return false;
	}

	public function UpdatePromoProduct($id_product=null, $opt, $box_qty, $qty, $sum, $note_opt="",$note_mopt="", $sum_default = null, $correction = null, $basic_price = null){
		$sum = round($sum, 2);
		if(!isset($_SESSION['Cart']['products'][$id_product])){
			$this->InitProduct($id_product);
		}
		$sum = round($basic_price*$qty, 2);
		$_SESSION['price_column'] = 3;
		$_SESSION['Cart']['products'][$id_product]['order_mopt_qty'] = $qty;
		$_SESSION['Cart']['products'][$id_product]['basic_mopt_price'] = $basic_price;
		$_SESSION['Cart']['products'][$id_product]['order_mopt_sum'] = $sum;
		$_SESSION['Cart']['products'][$id_product]['order_mopt_sum_default'] = $sum;
		$_SESSION['Cart']['products'][$id_product]['mopt_correction_set'] = array('1', '1', '1', '1');
		for($ii = 0; $ii < 4; $ii++){
			$_SESSION['Cart']['products'][$id_product]['mopt_sum_default'][$ii] = $sum;
		}
		if(null !== $sum_default){
			$_SESSION['Cart']['products'][$id_product]['order_mopt_sum'] = $sum_default;
			$_SESSION['Cart']['products'][$id_product]['order_mopt_sum_default'] = $sum_default;
		}
		$_SESSION['Cart']['products'][$id_product]['note_opt'] = $note_opt;
		$_SESSION['Cart']['products'][$id_product]['note_mopt'] = $note_mopt;

		if($_SESSION['Cart']['products'][$id_product]['order_mopt_qty'] == 0
		&& $_SESSION['Cart']['products'][$id_product]['order_box_qty'] == 0){
			unset($_SESSION['Cart']['products'][$id_product]);
		}
		$this -> SetSumDiscount();
	}
	// public function InitProduct($id_product){
		//	$_SESSION['Cart']['products'][$id_product]['order_box_qty'] = 0;
		//	$_SESSION['Cart']['products'][$id_product]['order_opt_qty'] = 0;
		//	$_SESSION['Cart']['products'][$id_product]['order_mopt_qty'] = 0;
		//	$_SESSION['Cart']['products'][$id_product]['order_opt_sum'] = 0;
		//	$_SESSION['Cart']['products'][$id_product]['order_mopt_sum'] = 0;
		//	$_SESSION['Cart']['products'][$id_product]['order_opt_sum_default'] = 0;
		//	$_SESSION['Cart']['products'][$id_product]['order_mopt_sum_default'] = 0;
		//	$_SESSION['Cart']['products'][$id_product]['note_opt'] = "";
		//	$_SESSION['Cart']['products'][$id_product]['note_mopt'] = "";
		//	$_SESSION['Cart']['products'][$id_product]['opt_correction_set'] = array();
		//	$_SESSION['Cart']['products'][$id_product]['mopt_correction_set'] = array();
		//	$_SESSION['Cart']['products'][$id_product]['opt_sum_default'] = array();
		//	$_SESSION['Cart']['products'][$id_product]['mopt_sum_default'] = array();
		//	$_SESSION['Cart']['products'][$id_product]['basic_opt_price'] = 0;
		//	$_SESSION['Cart']['products'][$id_product]['basic_mopt_price'] = 0;
	//}
	// public function SetTotalQty() {
		// 	$_SESSION['Cart']['prod_qty'] = isset($_SESSION['Cart']['products'])?count($_SESSION['Cart']['products']):0;
	// }

	public function IsActualPrices(&$err, &$warn, &$errors, &$warnings){
		if(isset($_SESSION['cart']['products']) && !empty($_SESSION['cart']['products'])){
			global $db;
			$order_opt_sum = $order_mopt_sum = 0;
			foreach($_SESSION['cart']['products'] as $id_product=>$arr){
				$sql = "SELECT p.id_product, p.price_opt, p.price_mopt,
					p.inbox_qty, p.mopt_correction_set, p.opt_correction_set
					FROM "._DB_PREFIX_."product AS p
						LEFT JOIN "._DB_PREFIX_."assortiment AS a ON a.id_product = p.id_product
					WHERE p.id_product = ".$id_product."
					AND a.active = 1
					GROUP BY a.id_product";
				$res = $db->GetOneRowArray($sql);
				if(!empty($res)){
					$mopt_correction = 1;
					if(isset($res['mopt_correction_set'])){
						if(isset($GLOBALS['CONFIG']['correction_set_'.$res['mopt_correction_set']]) && $GLOBALS['CONFIG']['correction_set_'.$res['mopt_correction_set']] != ''){
							$correction = explode(';', $GLOBALS['CONFIG']['correction_set_'.$res['mopt_correction_set']]);
							$mopt_correction = $correction[$_SESSION['price_column']];
						}
					}
					$opt_correction = 1;
					if(isset($res['opt_correction_set'])){
						if(isset($GLOBALS['CONFIG']['correction_set_'.$res['opt_correction_set']]) && $GLOBALS['CONFIG']['correction_set_'.$res['opt_correction_set']] != ''){
							$correction = explode(';', $GLOBALS['CONFIG']['correction_set_'.$res['opt_correction_set']]);
							$opt_correction = $correction[$_SESSION['price_column']];
						}
					}
					if(isset($_SESSION['price_mode']) && $_SESSION['price_mode'] == 1){
						$res['price_opt'] = round($res['price_opt']*$_SESSION['cart']['personal_discount'],2);
						$res['price_mopt'] = round($res['price_mopt']*$_SESSION['cart']['personal_discount'],2);
					}else{
						$res['price_opt'] = round($res['price_opt']*$opt_correction, 2);
						$res['price_mopt'] = round($res['price_mopt']*$mopt_correction, 2);
					}
					$new_mopt_price = round($res['price_mopt']*$arr['order_mopt_qty'], 2);
					$new_opt_price = round($res['price_opt']*$arr['order_opt_qty'], 2);
					$_SESSION['cart']['products'][$id_product]['site_price_opt'] = $res['price_opt'];
					$_SESSION['cart']['products'][$id_product]['site_price_mopt'] = $res['price_mopt'];
					if($new_mopt_price != $arr['order_mopt_sum_default']){
						$warnings['products'][$id_product]['price'] = "С момента добавления товара в корзину, его цена изменилась.";
						$arr['order_mopt_sum'] = (float)($res['price_mopt']*$arr['order_mopt_qty']);
						$arr['order_mopt_sum_default'] = $arr['order_mopt_sum'];
						$warn = 1;
					}
					if($new_opt_price != $arr['order_opt_sum_default'] && !isset($warnings['products'][$id_product]['price'])){
						$warnings['products'][$id_product]['price'] = "С момента добавления товара в корзину, его цена изменилась.";
						$arr['order_opt_sum'] = (float)($res['price_opt']*$arr['order_opt_qty']);
						$arr['order_opt_sum_default'] = $arr['order_opt_sum'];
						$warn = 1;
					}
					if(round($res['inbox_qty']*$arr['order_box_qty']) != $arr['order_opt_qty']){
						// $arr['order_opt_qty'] = round($res['inbox_qty']*$arr['order_box_qty']);
						$err = 1;
						$errors['products'][$id_product]['order_opt_qty'] = "Изменилось количество в ящике";
						$_SESSION['errm']['limit'] = "Необходимо уменьшить количество некоторых товаров";
					}
					if($arr['order_mopt_qty'] + $arr['order_opt_qty'] > $res['product_limit']){
						$err = 1;
						$errors['products'][$id_product]['order_qty'] = "Доступное количество: ".$res['product_limit'];
						$_SESSION['errm']['limit'] = "К сожалению некоторые товары недоступны в выбранном количестве. Измените или удалите выделенные товары.";
					}
					$order_opt_sum += (float)($res['price_opt']*$arr['order_opt_qty']);
					$order_mopt_sum += (float)($res['price_mopt']*$arr['order_mopt_qty']);
				}else{
					$err = 1;
					$_SESSION['errm'][] = "Некоторые товары сейчас не доступны.";
				}
			}
		}
	}

	// Выборка всех корзин связанных промо-кодом
	public function GetInfoForPromo($promo){
		global $db;
		$sql = "SELECT c.id_cart, c.id_user, c.status, c.adm, c.ready, u.name,
			u.phone, c.promo, u.email
			FROM "._DB_PREFIX_."cart AS c
			LEFT JOIN "._DB_PREFIX_."user AS u ON c.id_user = u.id_user
			LEFT JOIN "._DB_PREFIX_."cart_product AS cp ON cp.id_cart = c.id_cart
			LEFT JOIN "._DB_PREFIX_."cart_status AS cs ON c.status = cs.id_status
			WHERE promo = '".$promo."'
			GROUP BY c.id_user
			ORDER BY c.adm DESC, c.ready DESC";
		$res = $db->GetArray($sql);
		if(!$res){
			return false;
		}
		return $res;
	}


	// Выборка всех товаров из корзин связанных промо-кодом  по каждой корзине отдельно
	public function  GetProductsForPromo($promo){
		global $db;
		$sql = "SELECT c.id_cart, c.id_user, p.id_product, p.art, p.name, p.images,
				cp.quantity AS quantity, cp.note
				FROM "._DB_PREFIX_."cart_product as cp
				LEFT JOIN "._DB_PREFIX_."cart as c ON c.id_cart = cp.id_cart
				LEFT JOIN "._DB_PREFIX_."product as p ON cp.id_product = p.id_product
				WHERE c.promo = '".$promo."'
				ORDER BY c.id_cart";
		$res = $db->GetArray($sql);
		if(!$res){
			return false;
		}
		$general_result = $this->GetCartForPromo($promo);
		foreach ($general_result['products'] as $k => $v) {
			$general_res[$v['id_product']] = $v;
		}
		unset($general_result);
		foreach($res as $k=>&$v){
			$v['price'] = $general_res[$v['id_product']]['price'];
			$v['sum_prod'] = ROUND($v['price'] * $v['quantity'], 2);
			if(isset($res2[$v['id_user']])){
				$res2[$v['id_user']]['total_sum'] += $v['sum_prod'];
			}else{
				$res2[$v['id_user']]['total_sum'] = $v['sum_prod'];
			}
			$res2[$v['id_user']][] = $v;
		}
		return $res2;
	}

	// Выборка всех товаров из корзин связанных промо-кодом
	public function GetCartForPromo($promo){
		global $db;
		$sql = "SELECT p.id_product, p.art, p.name, p.images,
					(CASE WHEN SUM(cp.quantity)>=p.inbox_qty THEN p.price_opt ELSE p.price_mopt END) as price,
					SUM(cp.quantity) AS quantity, p.mopt_correction_set, p.opt_correction_set,
					p.inbox_qty,
					(CASE WHEN SUM(cp.quantity)>=p.inbox_qty THEN 'opt' ELSE 'mopt' END) AS `mode`,
					(SELECT GROUP_CONCAT(cp2.note SEPARATOR ', ') FROM "._DB_PREFIX_."cart_product cp2 LEFT JOIN "._DB_PREFIX_."cart as c2
					ON c2.id_cart = cp2.id_cart WHERE cp2.id_product = cp.id_product AND c2.promo = '".$promo."') AS note
					FROM "._DB_PREFIX_."cart_product as cp
					LEFT JOIN "._DB_PREFIX_."cart as c ON c.id_cart = cp.id_cart
					LEFT JOIN "._DB_PREFIX_."product as p ON cp.id_product = p.id_product
					WHERE c.promo = '".$promo."'
					GROUP BY p.id_product;";
		$res['products'] = $db->GetArray($sql);
		$res['total_sum'] = 0;
		foreach ($res['products'] as &$v) {
			$v['sum_prod'] = ROUND($v['price'] * $v['quantity'], 2);
			$res['total_sum'] += $v['sum_prod'];
			$coef_price_opt =  explode(';', $GLOBALS['CONFIG']['correction_set_'.$v['opt_correction_set']]);
			$coef_price_mopt =  explode(';', $GLOBALS['CONFIG']['correction_set_'.$v['mopt_correction_set']]);
			for($i=0; $i<=3; $i++){
				$v['prices_opt'][$i] = round($v['price']* $coef_price_opt[$i], 2);
				$v['prices_mopt'][$i] = round($v['price']* $coef_price_mopt[$i], 2);
			}
		}
		$retail_margin = $GLOBALS['CONFIG']['retail_order_margin']; // 500
		$wholesale_margin = $GLOBALS['CONFIG']['wholesale_order_margin']; // 3000
		$full_wholesale_margin = $GLOBALS['CONFIG']['full_wholesale_order_margin']; // 10000
		if($res['total_sum'] >= $full_wholesale_margin){
			$cart_column = 0;
			$discount = 21;
		}elseif($res['total_sum'] >= $wholesale_margin){
			$cart_column = 1;
			$discount = 16;
		}elseif($res['total_sum'] >= $retail_margin){
			$cart_column = 2;
			$discount = 10;
		}elseif($res['total_sum'] < $retail_margin){
			$cart_column = 3;
			$discount = 0;
		}
		$res['total_sum'] = 0;
		$res['discount'] = $discount;
		foreach ($res['products'] as &$v) {
			$v['price'] = ($v['mode'] == 'mopt')? $v['prices_mopt'][$cart_column]:$v['prices_opt'][$cart_column];
			$v['sum_prod'] = ROUND($v['price'] * $v['quantity'], 2);
			$res['total_sum'] += $v['sum_prod'];
			$res['cart_column'] = $cart_column;
		}
		if(!$res){
			return false;
		}
		return $res;
	}

	// Выборка совместных заказов для личного кабинета клиента
	public function GetInfoJO($condition){
		switch ($condition){
			case 'joactive':
				$status = " AND c.`status` = 10 ";
				break;
			case 'jocompleted':
				$status = " AND c.`status` = 11 ";
				break;
			case 'joinwork':
				$status = " AND c.`status` = 12 ";
				break;
		}
		global $db;
		$sql = "SELECT c.*, u.name, u.phone, u.email, COUNT(cp2.id_cart) AS count_carts,
				cp.id_user AS adm_id, us.name AS adm_name, us.phone AS adm_phones, us.email AS adm_email
				FROM xt_cart AS c
				LEFT JOIN "._DB_PREFIX_."user AS u ON c.id_user = u.id_user
				LEFT JOIN "._DB_PREFIX_."cart AS cp ON c.promo = cp.promo  AND cp.adm = 1
				LEFT JOIN "._DB_PREFIX_."cart AS cp2 ON c.promo = cp2.promo
				LEFT JOIN "._DB_PREFIX_."user AS us ON cp.id_user = us.id_user
				WHERE c.id_user = '".$_SESSION['member']['id_user']."'
				".$status."
				GROUP BY c.promo
				HAVING count_carts > 0
				ORDER BY creation_date DESC";
		$res = $db->GetOneRowArray($sql);

		if(!$res){
			return false;
		}
		//Добавляем список всех товаров со всех корзин, связанных промокодом
		$a = $this->GetCartForPromo($res['promo']);
		$res['products'] = $a['products'];
		$res['total_sum'] = $a['total_sum'];
		$res['discount'] = $a['discount'];
		//Добавляем информацию об участниках совместного заказа
		$res['infoCarts'] = $this->GetInfoForPromo($res['promo']);
		$b = $this->GetProductsForPromo($res['promo']);
		foreach($res['infoCarts'] as &$val){
			$val['sum_cart'] = $b[$val['id_user']]['total_sum'];
		}
		unset($a, $b);
		return $res;
	}


	//	public function GetInfoJO($condition){
		// switch ($condition){
		// 	case 'joactive':
		// 		$status = " AND c.`status` = 10 ";
		// 		break;
		// 	case 'jocompleted':
		// 		$status = " AND c.`status` = 11 ";
		// 		break;
		// 	case 'joinwork':
		// 		$status = " AND c.`status` = 12 ";
		// 		break;
		// }
		// global $db;
		// $sql = "SELECT c.*, u.name, u.phone, u.email, COUNT(cp2.id_cart) AS count_carts,
		// 		cp.id_user AS adm_id, us.name AS adm_name, us.phone AS adm_phones, us.email AS adm_email
		// 		FROM xt_cart AS c
		// 		LEFT JOIN "._DB_PREFIX_."user AS u ON c.id_user = u.id_user
		// 		LEFT JOIN "._DB_PREFIX_."cart AS cp ON c.promo = cp.promo  AND cp.adm = 1
		// 		LEFT JOIN "._DB_PREFIX_."cart AS cp2 ON c.promo = cp2.promo
		// 		LEFT JOIN "._DB_PREFIX_."user AS us ON cp.id_user = us.id_user
		// 		WHERE c.id_user = '".$_SESSION['member']['id_user']."'
		// 		".$status."
		// 		GROUP BY c.promo
		// 		HAVING count_carts > 0
		// 		ORDER BY creation_date DESC";
		// $res = $db->GetArray($sql);

		// if(!$res){
		// 	return false;
		// }
		// foreach ($res as &$v){
		// 	//Добавляем список всех товаров со всех корзин, связанных промокодом
		// 	$a = $this->GetCartForPromo($v['promo']);
		// 	$v['products'] = $a['products'];
		// 	$v['total_sum'] = $a['total_sum'];
		// 	$v['discount'] = $a['discount'];
		// 	//Добавляем информацию об участниках совместного заказа
		// 	$v['infoCarts'] = $this->GetInfoForPromo($v['promo']);
		// 	$b = $this->GetProductsForPromo($v['promo']);
		// 	foreach($v['infoCarts'] as &$val){
		// 		$val['sum_cart'] = $b[$val['id_user']]['total_sum'];
		// 	}
		// }
		// unset($a, $b);
		// return $res;
	//	}

	// Выборка всех товаров по id_cart
	public function GetProductsForCart($id_cart){
		global $db;
		$sql = "SELECT p.id_product, p.art, p.name, cp.quantity, cp.price,
		(CASE WHEN i.src IS NOT NULL THEN i.src ELSE p.img_1 END) as images
		FROM "._DB_PREFIX_."cart_product as cp
		LEFT JOIN  "._DB_PREFIX_."cart as c
		ON cp.id_cart = c.id_cart
		LEFT JOIN "._DB_PREFIX_."product as p
		ON cp.id_product = p.id_product
		LEFT JOIN "._DB_PREFIX_."image as i
		ON cp.id_product = i.id_product AND i.ord = 0 AND i.visible = 1
		WHERE c.id_cart = '".$id_cart."';";
		$res = $db->GetArray($sql);
		if(!$res){
			return false;
		}
		return $res;
	}

	//Формирование промокода
	public function CreatePromo($prefix){
		$promo = $prefix.G::GenerateVerificationCode();
		if(!$this->UpdateCart($promo, 10, 1, 1)){
			return false;
		}
		return $promo;
	}

	//Добавить/удалить статус и промокод для заказа (корзины)
	public function UpdateCart($promo = false, $status = false, $adm = false, $ready = false, $id_cart = false){
		$cart_id = $this->DBCart();
		$id_cart = $id_cart?$id_cart:(isset($_SESSION['cart']['id'])?$_SESSION['cart']['id']:$cart_id);
		$sql = "UPDATE "._DB_PREFIX_."cart	SET "
			.($promo !== false?"promo = ".($promo === null?'NULL':"'".$promo."'").", ":null)
			.($status !== false?"status = ".$status.", ":null)
			.($adm !== false?"adm = ".$adm.", ":null)
			.($ready !== false?"ready = ".$ready.", ":null);
		$sql = substr($sql, 0, -2);
		$sql .= " WHERE id_cart = ". $id_cart;
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	//Добавить/удалить статус и промокод для заказа (корзины)
	public function UpdateCartNote($note){
		$_SESSION['cart']['note'] = $note;
		if (isset($_SESSION['cart']['id'])) {
			$sql = "UPDATE "._DB_PREFIX_."cart
				SET note = ".$this->db->Quote($note)."
				WHERE id_cart = ".$_SESSION['cart']['id'];
			print_r($_SESSION['cart']);
			$this->db->StartTrans();
			if(!$this->db->Query($sql)){
				$this->db->FailTrans();
				return false;
			}
			$this->db->CompleteTrans();			
		}
		return true;
	}

	//Проверка промокода
	public function CheckPromo($promo){
		switch (substr($promo, 0, 2)){
			case 'JO':
				if(!$res = $this->db->GetOneRowArray("SELECT * FROM "._DB_PREFIX_."cart WHERE promo = '".$promo."' AND adm = 1 AND `status` = '10'")){
					return false;
				} else{
					if(!$this->UpdateCart($promo, 10, 0, 0)){
						return false;
					}
					return $promo;
				}
				break;
		}
	}

	//Проверка готовности корзины
	public function CheckCartReady($promo){
		$sql = "SELECT COUNT(ready) AS count FROM "._DB_PREFIX_."cart
		 		WHERE ready = 0 AND promo = '".$promo."'";
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res['count'];
	}

	//Обновление статуса корзины по промокоду
	public  function UpdateStatusCart($promo, $status){
		$sql = "UPDATE "._DB_PREFIX_."cart	SET status = '".$status."'
				WHERE promo = '".$promo."'";
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
}
