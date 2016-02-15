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
		$products->SetFieldsById($data['id_product']);
		$product = $products->fields;
		$quantity = $data['quantity'];
		if(isset($data['button'])){
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
			if(isset($data['id_cart_product'])){
				$_SESSION['cart']['products'][$product['id_product']]['id_cart_product'] = $data['id_cart_product'];
			}
		}else{
			$this->db->StartTrans();
			$this->db->DeleteRowFrom(_DB_PREFIX_."cart_product","id_cart_product",$_SESSION['cart']['products'][$product['id_product']]['id_cart_product']);
			$this->db->CompleteTrans();
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

	// удаляет товар из корзины
	public function RemoveFromCart($id_product, $id_cart){
		unset($_SESSION['cart']['products'][$id_product]);


		$sql = "DELETE FROM xt_cart_product
				WHERE id_cart = ". $id_cart ." AND id_product = ".$id_product;
		$this->db->StartTrans();
		if(!$this->db->Query($sql)) {
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();

		$this->RecalcCart();
		return $_SESSION['cart'];
	}

	// пересчет корзины
	public function RecalcCart(){
		$products_sum = array(0, 0, 0, 0);
		$cart_column = 0;
		if(!empty($_SESSION['cart']['products'])){
			foreach($_SESSION['cart']['products'] AS &$p){
				if(!isset($p['note'])){
					$p['note'] = '';
				}
				foreach($p['summary'] AS $k=>$s){
					$products_sum[$k] += $s;
				}
			}

			// определение колонки цен по сумме заказа
			$retail_margin = $GLOBALS['CONFIG']['retail_order_margin']; // 500
			$wholesale_margin = $GLOBALS['CONFIG']['wholesale_order_margin']; // 3000
			$full_wholesale_margin = $GLOBALS['CONFIG']['full_wholesale_order_margin']; // 10000
			if($products_sum[3] >= $full_wholesale_margin){
				$cart_column = 0;
			}elseif($products_sum[3] >= $wholesale_margin && $products_sum[1] < $full_wholesale_margin){
				$cart_column = 1;
			}elseif($products_sum[3] >= $retail_margin && $products_sum[2] < $wholesale_margin){
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
	public function ClearCart($id_cart){
		$_SESSION['cart']['products'] = array();
		$_SESSION['cart']['unavailable_products'] = array();
		if(isset($_SESSION['cart']['id_order'])){
			unset($_SESSION['cart']['id_order']);
		}
		unset($_SESSION['cart']['id']);

		$sql = "DELETE FROM xt_cart_product
				WHERE id_cart = ". $id_cart;
		$this->db->StartTrans();
		if(!$this->db->Query($sql)) {
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();

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
		$Products = new Products();
		$products = $Order->GetOrderForCart(array('o.id_order'=>$id_order));
		$personal_discount = 0;
		if(isset($_SESSION['cart']['personal_discount'])){
			$personal_discount = $_SESSION['cart']['personal_discount'];
		}
		if($add == null){
			$this->ClearCart();
		}
		if($_SESSION['member']['gid'] == _ACL_CONTRAGENT_){
			$_SESSION['cart']['base_order'] = $id_order;
		}
		foreach($products as $p){
			$p['quantity'] = $p['opt_qty']+$p['mopt_qty'];
			if($this->IsAvailableProduct($p['id_product'])){
				$this->UpdateCartQty($p);
				// $this->IsActualPrice($p);
			}else{
				$_SESSION['cart']['unavailable_products'][] = $p;
			}
			// if(isset($_SESSION['price_mode']) && $_SESSION['price_mode'] == 1){
			// 	if($this->IsAvailableProduct($p['id_product'])){

			// 		$this->UpdateProduct($p['id_product'], 1, $p['box_qty'], $p['opt_qty'], round($p['opt_sum'] * $personal_discount, 2), $p['note_opt'], $p['note_mopt'], round($p['default_sum_opt'] * $personal_discount, 2), explode(';', $GLOBALS['CONFIG']['correction_set_'.$product['opt_correction_set']]), $product['price_opt']);
			// 	}else{
			// 		$_SESSION['cart']['unavailable_products'][] = $p;
			// 	}
			// }else{
			// 	if($_SESSION['client']['user_agent'] == 'desktop'){
			// 		if($p['opt_qty'] > 0){
			// 			if($this->IsAvailableProduct($p['id_product'])){
			// 				$this->UpdateProduct($p['id_product'], 1, $p['box_qty'], $p['opt_qty'], $p['opt_sum'], $p['note_opt'], $p['note_mopt'], $p['default_sum_opt'], explode(';', $GLOBALS['CONFIG']['correction_set_'.$product['opt_correction_set']]), $product['price_opt']);
			// 			}else{
			// 				$_SESSION['Cart']['unavailable_products'][] = $p;
			// 			}
			// 		}
			// 	}
			// 	if($p['mopt_qty'] > 0){
			// 		if($this->IsAvailableProduct($p['id_product'])){
			// 			$this->UpdateProduct($p['id_product'], 0, null, $p['mopt_qty'], $p['mopt_sum'], $p['note_opt'], $p['note_mopt'], $p['default_sum_mopt'], explode(';', $GLOBALS['CONFIG']['correction_set_'.$product['mopt_correction_set']]), $product['price_mopt']);
			// 		}else{
			// 			$_SESSION['Cart']['unavailable_products'][] = $p;
			// 		}
			// 	}
			// }
		}
		// print_r($_SESSION['cart']);
		// die();
	}

	// Проверка актуальности цен
	public function IsActualPrice($product){


		print_r($product);die();


		return $res;
	}






	// Добавление и проверка корзины в БД
	public function InsertMyCart(){
		if(isset($_SESSION['cart']['id'])){
			# обновить корзину в БД по id
			foreach($_SESSION['cart']['products'] as $key => &$product){
				$f['quantity'] = $product['quantity'];
				$f['price'] = $product['base_price'];
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
			return $product['id_cart_product'];
		}else{
			// добавить корзину в БД и записать ее id в $_SESSION['cart']['id']
			if(isset($_SESSION['member'])){
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

	//
	public function LastClientCart(){
		$id = $_SESSION['member']['id_user'];
		$sql = "SELECT * FROM "._DB_PREFIX_."cart WHERE status = 0 AND id_user = ".$id." ORDER BY creation_date DESC LIMIT 1";
		$res = $this->db->GetOneRowArray($sql);
		if(!empty($res)){
			$_SESSION['cart']['id'] = $res['id_cart'];
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
	// 	$_SESSION['Cart']['products'][$id_product]['order_box_qty'] = 0;
	// 	$_SESSION['Cart']['products'][$id_product]['order_opt_qty'] = 0;
	// 	$_SESSION['Cart']['products'][$id_product]['order_mopt_qty'] = 0;
	// 	$_SESSION['Cart']['products'][$id_product]['order_opt_sum'] = 0;
	// 	$_SESSION['Cart']['products'][$id_product]['order_mopt_sum'] = 0;
	// 	$_SESSION['Cart']['products'][$id_product]['order_opt_sum_default'] = 0;
	// 	$_SESSION['Cart']['products'][$id_product]['order_mopt_sum_default'] = 0;
	// 	$_SESSION['Cart']['products'][$id_product]['note_opt'] = "";
	// 	$_SESSION['Cart']['products'][$id_product]['note_mopt'] = "";
	// 	$_SESSION['Cart']['products'][$id_product]['opt_correction_set'] = array();
	// 	$_SESSION['Cart']['products'][$id_product]['mopt_correction_set'] = array();
	// 	$_SESSION['Cart']['products'][$id_product]['opt_sum_default'] = array();
	// 	$_SESSION['Cart']['products'][$id_product]['mopt_sum_default'] = array();
	// 	$_SESSION['Cart']['products'][$id_product]['basic_opt_price'] = 0;
	// 	$_SESSION['Cart']['products'][$id_product]['basic_mopt_price'] = 0;
	// }
	// public function SetTotalQty() {
	// 	$_SESSION['Cart']['prod_qty'] = isset($_SESSION['Cart']['products'])?count($_SESSION['Cart']['products']):0;
	// }

	public function IsActualPrices(&$err, &$warn, &$errors, &$warnings){
		if(!empty($_SESSION['Cart']['products'])){
			global $db;
			$order_opt_sum = $order_mopt_sum = 0;
			foreach($_SESSION['Cart']['products'] as $id_product=>$arr){
				$sql = "SELECT p.id_product, p.price_opt, p.price_mopt,
					p.inbox_qty, p.mopt_correction_set, p.opt_correction_set,
					SUM(a.product_limit) AS product_limit
					FROM "._DB_PREFIX_."product AS p
					LEFT JOIN "._DB_PREFIX_."assortiment AS a
						ON a.id_product = p.id_product
					WHERE p.id_product = ".$id_product."
					AND a.active = 1
					GROUP BY a.id_product";
				$v = $db->GetOneRowArray($sql);
				if(!empty($v)){
					$mopt_correction = 1;
					if(isset($v['mopt_correction_set'])){
						if(isset($GLOBALS['CONFIG']['correction_set_'.$v['mopt_correction_set']]) && $GLOBALS['CONFIG']['correction_set_'.$v['mopt_correction_set']] != ''){
							$correction = explode(';', $GLOBALS['CONFIG']['correction_set_'.$v['mopt_correction_set']]);
							$mopt_correction = $correction[$_SESSION['price_column']];
						}
					}
					$opt_correction = 1;
					if(isset($v['opt_correction_set'])){
						if(isset($GLOBALS['CONFIG']['correction_set_'.$v['opt_correction_set']]) && $GLOBALS['CONFIG']['correction_set_'.$v['opt_correction_set']] != ''){
							$correction = explode(';', $GLOBALS['CONFIG']['correction_set_'.$v['opt_correction_set']]);
							$opt_correction = $correction[$_SESSION['price_column']];
						}
					}
					if(isset($_SESSION['price_mode']) && $_SESSION['price_mode'] == 1){
						$v['price_opt'] = round($v['price_opt']*$_SESSION['Cart']['personal_discount'],2);
						$v['price_mopt'] = round($v['price_mopt']*$_SESSION['Cart']['personal_discount'],2);
					}else{
						$v['price_opt'] = round($v['price_opt']*$opt_correction, 2);
						$v['price_mopt'] = round($v['price_mopt']*$mopt_correction, 2);
					}
					$new_mopt_price = round($v['price_mopt']*$arr['order_mopt_qty'], 2);
					$new_opt_price = round($v['price_opt']*$arr['order_opt_qty'], 2);
					$_SESSION['Cart']['products'][$id_product]['site_price_opt'] = $v['price_opt'];
					$_SESSION['Cart']['products'][$id_product]['site_price_mopt'] = $v['price_mopt'];
					if($new_mopt_price != $arr['order_mopt_sum_default']){
						$warnings['products'][$id_product]['price'] = "С момента добавления товара в корзину, его цена изменилась.";
						$arr['order_mopt_sum'] = (float)($v['price_mopt']*$arr['order_mopt_qty']);
						$arr['order_mopt_sum_default'] = $arr['order_mopt_sum'];
						$warn = 1;
					}
					if($new_opt_price != $arr['order_opt_sum_default'] && !isset($warnings['products'][$id_product]['price'])){
						$warnings['products'][$id_product]['price'] = "С момента добавления товара в корзину, его цена изменилась.";
						$arr['order_opt_sum'] = (float)($v['price_opt']*$arr['order_opt_qty']);
						$arr['order_opt_sum_default'] = $arr['order_opt_sum'];
						$warn = 1;
					}
					if(round($v['inbox_qty']*$arr['order_box_qty']) != $arr['order_opt_qty']){
						// $arr['order_opt_qty'] = round($v['inbox_qty']*$arr['order_box_qty']);
						$err = 1;
						$errors['products'][$id_product]['order_opt_qty'] = "Изменилось количество в ящике";
						$_SESSION['errm']['limit'] = "Необходимо уменьшить количество некоторых товаров";
					}
					if($arr['order_mopt_qty'] + $arr['order_opt_qty'] > $v['product_limit']){
						$err = 1;
						$errors['products'][$id_product]['order_qty'] = "Доступное количество: ".$v['product_limit'];
						$_SESSION['errm']['limit'] = "К сожалению некоторые товары недоступны в выбранном количестве. Измените или удалите выделенные товары.";
					}
					$order_opt_sum += (float)($v['price_opt']*$arr['order_opt_qty']);
					$order_mopt_sum += (float)($v['price_mopt']*$arr['order_mopt_qty']);
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
			$sql = "SELECT  c.id_cart, c.creation_date, c.id_user, c.status, cs.title_stat, u.name, u.email, u.last_login_date, cus.phones,	u.promo_code,
 							cus.discount , cus.id_contragent, cp.quantity, ROUND(SUM(cp.price * cp.quantity), 2) AS sum_cart
			FROM "._DB_PREFIX_."cart AS c
			LEFT JOIN "._DB_PREFIX_."user AS u
			ON c.id_user = u.id_user
			LEFT JOIN "._DB_PREFIX_."customer AS cus
			ON cus.id_user = u.id_user
			LEFT JOIN "._DB_PREFIX_."cart_product AS cp
			ON cp.id_cart = c.id_cart
			LEFT JOIN "._DB_PREFIX_."cart_status AS cs
			ON c.status = cs.id_status
			WHERE promo = '".$promo."'
			GROUP BY c.id_cart
			ORDER BY c.status ASC";
//		print_r($sql);
		$res = $db->GetArray($sql);
		if(!$res){
			return false;
		}
		return $res;
	}

	// Выборка всех товаров из корзин связанных промо-кодом
	public function GetCartForPromo($promo){
			global $db;
			$sql = "SELECT  p.id_product, p.art, p.name, p.images, p.price_opt, cp.price,
							cp.quantity, ROUND(SUM(cp.price * cp.quantity), 2) AS sum_prod
			FROM "._DB_PREFIX_."cart_product as cp
			LEFT JOIN "._DB_PREFIX_."cart as c
			ON c.id_cart = cp.id_cart
			LEFT JOIN "._DB_PREFIX_."product as p
			ON cp.id_product = p.id_product
			WHERE c.promo = '".$promo."'
			group by p.id_product;";
		$res = $db->GetArray($sql);
		if(!$res){
			return false;
		}
		return $res;
	}

	// Выборка всех товаров по id_cart
	public function GetProductsForCart($id_cart){
		global $db;
		$sql = "SELECT p.id_product, cp.quantity, cp.price as cart_price,
		(CASE WHEN cp.quantity >= p.inbox_qty THEN p.price_opt ELSE p.price_mopt END) as base_price,
		p.id_product, p.name,
		(CASE WHEN i.src IS NOT NULL THEN i.src ELSE p.img_1 END) as img
		FROM xt_cart_product as cp
		LEFT JOIN  xt_cart as c
		ON cp.id_cart = c.id_cart
		LEFT JOIN xt_product as p
		ON cp.id_product = p.id_product
		LEFT JOIN xt_image as i
		ON cp.id_product = i.id_product AND i.ord = 0
		WHERE c.id_cart = '".$id_cart."';";
		$res = $db->GetArray($sql);
		if(!$res){
			return false;
		}
		return $res;
	}

	//Добавить статус для заказа (корзины)
	public function SetStatusCart(){
		$cart_id = $this->InsertMyCart();

		// Символы, которые будут использоваться в пароле.
		$chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
		$max = 4;	// Количество символов в пароле.
		$size = StrLen($chars)-1;	// Определяем количество символов в $chars
		$promo = null;	// Определяем пустую переменную, в которую и будем записывать символы.
		while($max--)	$promo.=$chars[rand(0,$size)]; // Создаём пароль.

		$stat = 10;

		global $db;
		$sql = "UPDATE "._DB_PREFIX_."cart
		SET promo = '". $promo ."', status = '". $stat ."'
		WHERE id_cart = '". isset($_SESSION['cart']['id']) ? $_SESSION['cart']['id'] : $cart_id ."'";
		$res = $db->GetArray($sql);
		print_r($sql);
		if(!$res){
			return false;
		}
		return $res;
	}
}?>

