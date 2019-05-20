<?php
class Orders {
	public $db;
	public $fields;
	private $usual_fields;
	private $usual_fields2;
	public $list;

	public function __construct(){
		$this->db =& $GLOBALS['db'];
		$this->usual_fields = array("o.id_order", "o.id_order_status", "o.phones",
			"o.id_delivery", "o.id_parking", "o.id_city", "o.id_delivery_service",
			"o.id_contragent", "o.id_customer", "o.cont_person", "o.need_sertificate",
			"o.descr", "o.creation_date", "o.target_date", "o.return_date", "o.id_address",
			"o.pretense_date", "o.sum_opt", "o.sum_mopt", "o.sum", "o.discount",
			"o.sum_discount", "o.id_pretense_status", "o.id_return_status", "o.skey",
			"o.otpusk_prices_sum", "o.sum_nac", "o.note", "o.note2", "o.strachovka",
			"o.order_discount", "o.freight", "o.bonus_card", "o.id_remitter", "o.category"
		);
		$this->usual_fields2 = array("o.id_order", "o.id_order_status", "o.id_contragent",
			"o.id_customer", "o.cont_person", "o.need_sertificate", "o.descr",
			"o.creation_date", "o.target_date", "o.return_date", "o.pretense_date",
			"o.sum_opt", "o.sum_mopt", "o.sum", "o.discount", "o.sum_discount",
			"o.id_pretense_status", "o.id_return_status", "o.skey", "o.otpusk_prices_sum",
			"o.sum_nac", "o.order_discount", "o.freight", "o.id_remitter"
		);
	}

	public function SetNote($id_order, $note){
		$sql = "UPDATE "._DB_PREFIX_."order SET note='$note' WHERE id_order=$id_order";
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			G::DieLoger("SQL error - $sql");
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function SetNote2($id_order, $note2){
		$sql = "UPDATE "._DB_PREFIX_."order SET note2='$note2' WHERE id_order=$id_order";
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			G::DieLoger("SQL error - $sql");
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function SetNote_diler($id_order, $note_diler){
		$sql = "UPDATE "._DB_PREFIX_."order SET id_klient='$note_diler' WHERE id_order=$id_order";
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			G::DieLoger("SQL error - $sql");
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function SetNote_customer($id_order, $note_customer){
		$sql = "UPDATE "._DB_PREFIX_."order SET note_customer='$note_customer' WHERE id_order=$id_order";
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			G::DieLoger("SQL error - $sql");
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function SetNote_klient($id_order, $note_klient){
		$sql = "SELECT cu.phones, cu.cont_person
			FROM "._DB_PREFIX_."customer cu
			WHERE id_user = ".$note_klient;
		$arr = $this->db->GetOneRowArray($sql);
		foreach($arr as $ord){
			$a=$arr['cont_person'];
			$b=$arr['phones'];
		}
		$this->db->StartTrans();
		$sql = "UPDATE "._DB_PREFIX_."order SET id_klient='$note_klient', cont_person='$a' ,  phones='$b' WHERE id_order=$id_order";
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			G::DieLoger("SQL error - $sql");
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	/**
	 * Получить данные о заказе по его id
	 * @param integer $id_order id заказа
	 */
	public function SetFieldsById($id_order){
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."order AS o
			WHERE o.id_order = ".$id_order;
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		return true;
	}

	public function Suplir_prov($arr = false){
		$date2 = date("Y-m-d", (time()+3600*24*2));
		$sql = "SELECT u.name, u.id_user, c.work_day, s.koef_nazen_mopt, s.koef_nazen_opt,  COUNT(DISTINCT a.id_assortiment) AS cnt, s.currency_rate
				FROM  "._DB_PREFIX_."assortiment a, "._DB_PREFIX_."user u, "._DB_PREFIX_."calendar_supplier c, "._DB_PREFIX_."supplier s
				WHERE a.active = 1
				AND u.id_user = s.id_user
				AND u.id_user = c.id_supplier
				AND  c.date = \"$date2\"
				AND u.id_user = a.id_supplier
				group by a.id_supplier";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		return $arr;
	}

	// Список
	public function SetList($param = 0, $and = false, $orderby = "", $limit = ""){
		if($limit != ""){
			$limit = " limit $limit";
		}
		$add_table_users = "";
		//contragent_name
		//customer_name
		$like = "";
		// if(isset($and['contragent_name']) && isset($and['customer_name'])){
		// 	$add_table_users = " LEFT JOIN "._DB_PREFIX_."user AS u ON (o.id_customer = u.id_user OR o.id_contragent = u.id_user)";
		// 	$like = count($and) > 2?" AND ":" WHERE ";
		// 	$like .= "(u.name LIKE '%".$and['contragent_name']."%' AND u.gid = 4)";
		// 	$like .= " OR (u.name LIKE '%".$and['customer_name']."%' AND u.gid = 5)";
		// 	unset($and['contragent_name']);
		// 	unset($and['customer_name']);
		// }elseif(isset($and['contragent_name'])){
		// 	$add_table_users = " LEFT JOIN "._DB_PREFIX_."user AS u ON o.id_contragent = u.id_user";
		// 	$like = count($and) > 1?" AND ":" WHERE ";
		// 	$like .= "u.name LIKE '%".$and['contragent_name']."%'";
		// 	unset($and['contragent_name']);
		// }elseif(isset($and['customer_name'])){
		// 	$add_table_users = " LEFT JOIN "._DB_PREFIX_."user AS u ON o.id_customer = u.id_user";
		// 	$like = count($and) > 1?" AND ":" WHERE ";
		// 	$like .= "u.name LIKE '%".$and['customer_name']."%'";
		// 	unset($and['customer_name']);
		// }
		$sql = "SELECT ".implode(", ",$this->usual_fields).",
			ca.name_c AS contragent_name,
			u.name AS customer_name,
			u.email AS customer_email
			FROM "._DB_PREFIX_."order AS o ".$add_table_users."
			LEFT JOIN "._DB_PREFIX_."user AS u
				ON u.id_user = o.id_customer
			LEFT JOIN "._DB_PREFIX_."contragent AS ca
				ON ca.id_user = o.id_contragent".
			$this->db->GetWhere($and).
			$like.
			" ORDER BY ".$orderby.", id_order desc".
			$limit;
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}

	// Список по поставщикам
	public function SetList_sup($param = 0, $and = false, $orderby = "", $limit = ""){
		if($limit != ""){
			$limit = " limit $limit";
		}
		$dates = false;
		$date_where = array();
		if(isset($and['target_date_start'])){
			$date_where[] = "target_date>".$and['target_date_start'];
			unset($and['target_date_start']);
			$dates = true;
		}
		if(isset($and['target_date_end'])){
			$date_where[] = "target_date<".$and['target_date_end'];
			unset($and['target_date_end']);
			$dates = true;
		}
		$add_table_users = "";
		//contragent_name
		//customer_name
		$like = "";
		if(isset($and['contragent_name']) && isset($and['customer_name'])){
			$add_table_users = " LEFT JOIN "._DB_PREFIX_."user u ON (o.id_customer=u.id_user OR o.id_contragent=u.id_user)";
			$like = count($and)>2?" AND ":" WHERE ";
			$like .= "(u.name LIKE \"%".$and['contragent_name']."%\" AND u.gid=4)";
			$like .= " OR (u.name LIKE \"%".$and['customer_name']."%\" AND u.gid=5)";
			unset($and['contragent_name']);
			unset($and['customer_name']);
		}elseif(isset($and['contragent_name'])){
			$add_table_users = " LEFT JOIN "._DB_PREFIX_."user u ON o.id_contragent=u.id_user";
			$like = count($and)>1?" AND ":" WHERE ";
			$like .= "u.name LIKE \"%".$and['contragent_name']."%\"";
			unset($and['contragent_name']);
		}elseif(isset($and['customer_name'])){
			$add_table_users = " LEFT JOIN "._DB_PREFIX_."user u ON o.id_customer=u.id_user";
			$like = count($and)>1?" AND ":" WHERE ";
			$like .= "u.name LIKE \"%".$and['customer_name']."%\"";
			unset($and['customer_name']);
		}
		$dw = "";
		if($dates)
		if(count($and)){
			$dw = " AND ".implode(" AND ", $date_where);
		}else{
			$dw = " WHERE ".implode(" AND ", $date_where);
		}
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."order o $add_table_users
			".$this->db->GetWhere($and)."
			$like
			$dw
			order by $orderby, id_order desc
			$limit";
		$arr = $this->db->GetArray($sql);
		$rows = array();
		$ii = 0;
		foreach($arr as $ord){
			if($ord['id_order_status'] != 3){
				$sql = "SELECT *
					FROM "._DB_PREFIX_."osp osp
					WHERE osp.id_order = {$ord['id_order']}";
				$arr2 = $this->db->GetArray($sql);
				$supp_sums = array();
				$supp_otpusk_sums = array();
				foreach($arr2 as $a2){
					if($a2['id_supplier']!=0){
						if(isset($supp_sums[$a2['id_supplier']])){
							$supp_sums[$a2['id_supplier']] = round($supp_sums[$a2['id_supplier']] + $a2['opt_sum'], 2);
							$supp_otpusk_sums[$a2['id_supplier']] = round($supp_otpusk_sums[$a2['id_supplier']] + ($a2['opt_qty']*$a2['price_opt_otpusk']) , 2);
						}else{
							$supp_sums[$a2['id_supplier']] = $a2['opt_sum'];
							$supp_otpusk_sums[$a2['id_supplier']] = round($a2['opt_qty']*$a2['price_opt_otpusk'] , 2);
						}
					}
					if($a2['id_supplier_mopt']!=0){
						if(isset($supp_sums[$a2['id_supplier_mopt']])){
							$supp_sums[$a2['id_supplier_mopt']] = round($supp_sums[$a2['id_supplier_mopt']] + $a2['mopt_sum'], 2);
							$supp_otpusk_sums[$a2['id_supplier_mopt']] = round($supp_otpusk_sums[$a2['id_supplier_mopt']] + ($a2['mopt_qty']*$a2['price_mopt_otpusk']) , 2);
						}else{
							$supp_sums[$a2['id_supplier_mopt']] = $a2['mopt_sum'];
							$supp_otpusk_sums[$a2['id_supplier_mopt']] = round($a2['mopt_qty']*$a2['price_mopt_otpusk'] , 2);
						}
					}
				}
				$suppliers = array();
				foreach($arr2 as $a2){
					if($a2['id_supplier'] != 0 && !in_array($a2['id_supplier'], $suppliers)){
						$a2['id_supplier_t'] = $a2['id_supplier'];
						$a2['sup_sum_t'] = $supp_sums[$a2['id_supplier']];
						$a2['sup_otpusk_sum_t'] = $supp_otpusk_sums[$a2['id_supplier']];
						$rows[$ii++] = array_merge($ord,$a2);
						$suppliers[] = $a2['id_supplier'];
					}
					if($a2['id_supplier_mopt'] != 0 && !in_array($a2['id_supplier_mopt'], $suppliers)){
						$a2['id_supplier_t'] = $a2['id_supplier_mopt'];
						$a2['sup_sum_t'] = $supp_sums[$a2['id_supplier_mopt']];
						$a2['sup_otpusk_sum_t'] = $supp_otpusk_sums[$a2['id_supplier_mopt']];
						$rows[$ii++] = array_merge($ord,$a2);
						$suppliers[] = $a2['id_supplier_mopt'];
					}
				}
			}else{
				$rows[$ii++] = $ord;
			}
		}
		$this->list = $rows;
		if(!$this->list){
			return false;
		}else{
			return true;
		}
	}

	public function ContragentsList($arr){
		$sql = "SELECT u.id_user, u.name
			FROM "._DB_PREFIX_."user AS u
			WHERE u.id_user IN (".implode(",", $arr).")";
		return $this->db->GetArray($sql, 'id_user');
	}

	public function CustomersList($arr){
		$sql = "SELECT u.id_user, u.name
			FROM "._DB_PREFIX_."user u
			WHERE u.id_user IN (".implode(",", $arr).")";
		return $this->db->GetArray($sql, 'id_user');
	}

	public function SuppliersList($arr){
		$sql = "SELECT u.id_user, u.name, s.article, s.is_partner
			FROM "._DB_PREFIX_."user AS u
			LEFT JOIN "._DB_PREFIX_."supplier AS s
				ON s.id_user = u.id_user
			WHERE u.id_user IN (".implode(",", $arr).")";
		return $this->db->GetArray($sql, 'id_user');
	}

	public function GetSuppliers($id_order){
		$id_supplier = '';
		$sql = "SELECT DISTINCT s.id_user AS id_supplier, u.name, s.article,
			s.phones, s.place, s.is_partner, s.make_csv, s.send_mail_order,
			s.real_email, s.real_phone, s.icq, s.balance, s.personal_message,
			s.example_sum, s.pickers, s.area, s.currency_rate,
			(SELECT CASE WHEN COUNT(*) > 0 THEN 1 ELSE 0 END
				FROM "._DB_PREFIX_."assortiment AS a
				WHERE s.id_user = a.id_supplier
				AND a.inusd = 1) AS inusd
			FROM "._DB_PREFIX_."osp AS osp
			LEFT JOIN "._DB_PREFIX_."supplier AS s
				ON (osp.id_supplier = s.id_user OR osp.id_supplier_mopt = s.id_user)
			LEFT JOIN "._DB_PREFIX_."user AS u
				ON u.id_user = s.id_user
			WHERE osp.id_order = ".$id_order."
			AND s.id_user IS NOT NULL";
		if($id_supplier){
			$sql .= " AND s.id_user = ".$id_supplier;
		}
		$sql .= " ORDER BY s.article";
		$this->list = $this->db->GetArray($sql, 'id_supplier');
		if(!$this->list){
			return false;
		}
		return true;
	}

	public function GetSuppliersAltern($id_order){
		$sql = "SELECT DISTINCT s.id_user AS id_supplier, u.name, s.article, s.phones, s.place, s.is_partner
			FROM "._DB_PREFIX_."osp osp, "._DB_PREFIX_."supplier s
			LEFT JOIN "._DB_PREFIX_."user u ON u.id_user = s.id_user
			WHERE osp.id_order = $id_order
			AND (osp.id_supplier_altern = s.id_user
				OR osp.id_supplier_mopt_altern = s.id_user)";
		$this->list = $this->db->GetArray($sql,'id_supplier');
		if(!$this->list){
			return false;
		}else{
			return true;
		}
	}

	public function GetSupplier($id_supplier){
		$sql = "SELECT u.id_user as id_supplier, u.name
			FROM "._DB_PREFIX_."user u
			WHERE u.id_user = $id_supplier
			";
		$this->list = $this->db->GetOneRowArray($sql);
		if(!$this->list){
			return false;
		}else{
			return true;
		}
	}

	public function SetListBySupplier($id_supplier = false, $id_order, $pretense = false, $type = false, $filial = false){
		if($type){
			$where = "((osp.id_supplier = ".$id_supplier." AND osp.opt_qty > 0)
				OR (osp.id_supplier_mopt = ".$id_supplier." AND osp.mopt_qty > 0))";
		}else{
			$where = "((osp.id_supplier = ".$id_supplier."
					AND osp.opt_qty > 0
					AND osp.contragent_qty <= 0
					AND osp.note_opt NOT LIKE '%Отмена#%')
				OR (osp.id_supplier_mopt = ".$id_supplier."
					AND osp.mopt_qty > 0
					AND osp.contragent_mqty <= 0
					AND osp.note_mopt NOT LIKE '%Отмена#%'))";
		}
		$sql = "SELECT o.id_order, o.id_order_status, osp.id_product, p.name,
			p.img_1,
			(SELECT src FROM "._DB_PREFIX_."image AS i WHERE p.id_product = i.id_product AND ord = 0 AND i.visible = 1) AS image,
			osp.site_price_opt, osp.site_price_mopt, p.inbox_qty,
			osp.box_qty, osp.opt_qty, osp.mopt_qty,
			osp.supplier_quantity_opt, osp.supplier_quantity_mopt,
			osp.opt_sum, osp.mopt_sum, s.article,  p.art,
			(SELECT "._DB_PREFIX_."supplier.article FROM "._DB_PREFIX_."supplier WHERE "._DB_PREFIX_."supplier.id_user = osp.id_supplier_mopt) AS article_mopt,
			osp.id_supplier, osp.id_supplier_mopt, o.target_date, o.return_date, o.pretense_date, o.creation_date,
			osp.contragent_qty, osp.contragent_mqty, osp.contragent_sum, osp.contragent_msum,
			osp.fact_qty, osp.fact_sum, osp.fact_mqty, osp.fact_msum,
			osp.return_qty, osp.return_sum, osp.return_mqty, osp.return_msum,
			o.id_pretense_status, o.id_return_status, osp.price_opt_otpusk, osp.price_mopt_otpusk,
			osp.id_supplier_altern, osp.id_supplier_mopt_altern,
			(SELECT "._DB_PREFIX_."supplier.article FROM "._DB_PREFIX_."supplier WHERE "._DB_PREFIX_."supplier.id_user=osp.id_supplier_altern) AS article_altern,
			(SELECT "._DB_PREFIX_."supplier.article FROM "._DB_PREFIX_."supplier WHERE "._DB_PREFIX_."supplier.id_user=osp.id_supplier_mopt_altern) AS article_mopt_altern,
			p.weight, p.volume, osp.note_opt, osp.note_mopt, p.sertificate, p.checked, osp.warehouse_quantity,
			a.sup_comment
			FROM "._DB_PREFIX_."osp AS osp
			LEFT JOIN "._DB_PREFIX_."order AS o
				ON osp.id_order = o.id_order
			LEFT JOIN "._DB_PREFIX_."supplier AS s
				ON osp.id_supplier = s.id_user
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON osp.id_product = p.id_product
			LEFT JOIN "._DB_PREFIX_."assortiment AS a
				ON (osp.id_product = a.id_product AND a.id_supplier = ".$id_supplier.")
			WHERE ".$where."
			AND osp.id_order = ".$id_order."
			ORDER BY p.name";
		if($pretense){
			$sql .= " AND (osp.opt_qty != osp.fact_qty OR osp.mopt_qty != osp.fact_mqty)";
		}
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}else{
			return true;
		}
	}

	// Создание заказа
	public function Add($arr = null){
		global $Cart;
		global $Products;
		global $Users;
		if(isset($arr)) {
			$GetCartForPromo = $Cart->GetCartForPromo($arr);
			$OrderCart = array();
			foreach ($GetCartForPromo['products'] as $k => $v) {
				$OrderCart[$v['id_product']] = $v;
			}
			//unset($GetCartForPromo);
			$jo_order = 1;
		}
		$OrderCart = ($arr === null)?$_SESSION['cart']['products']:$OrderCart;
		// Если список товаров в корзине пуст
		if(empty($OrderCart)){
			// Завершаем работу скрипта
			print_r('products error');
			return false;
		}
		//получаем количество заказов клиента
		if(G::IsLogged()){
			$count_orders = $this->db->GetOneRowArray("SELECT COUNT(*) AS cnt FROM "._DB_PREFIX_."order WHERE id_customer = ".$_SESSION['member']['id_user']);
		}
		// Если введен промо-код в корзине и его ключевое слово - AG
		if($count_orders['cnt'] == 0 && isset($_SESSION['cart']['promo']) && substr($_SESSION['cart']['promo'], 0, 2) == 'AG'){
			// Подписываем покупателя на агента и если подписать не удалось
			if(!$Users->SubscribeAgentUser($_SESSION['member']['id_user'], substr($_SESSION['cart']['promo'], 2))){
				// Завершаем работу скрипта
				// print_r('agent subscription error');
				// return false;
			}
		}
		// Если есть даные агента партнера  ключевое слово - AG
		if($count_orders['cnt'] == 0 && !isset($_SESSION['cart']['promo']) && isset($_COOKIE['utm_campaign']) && substr($_COOKIE['utm_campaign'], 0, 2) == 'ag'){
			// Подписываем покупателя на агента и если подписать не удалось
					if(!$Users->SubscribeAgentUser($_SESSION['member']['id_user'], substr($_COOKIE['utm_campaign'], 2))){

			}
		}

		// $discount = 0;
		// if(isset($_SESSION['cart']['discount'])){
		// 	if(isset($_SESSION['price_mode']) && $_SESSION['price_mode'] == 1){
		// 		$discount = 1;
		// 	}else{
		// 		$discount = $_SESSION['cart']['discount'];
		// 	}
		// }
		// $this->UpdateSuppliersTurn();

		// Пересмотреть проверку актуальности цен
		// $Cart->IsActualPrices($err, $warn, $errm, $warnings);
		// if($err){
		// 	if(isset($_SESSION['errm'])){
		// 		$_SESSION['errm'] = array_merge($_SESSION['errm'], $errm);
		// 	}else{
		// 		$_SESSION['errm'] = $errm;
		// 		header('Location: '._base_url.'/cart/');
		// 		exit();
		// 	}
		// }
		// isset($_SESSION['member']['id_user']) ? $_SESSION['member']['id_user'] : $_SESSION['member']['id_user'] = $_POST['id_user'];
		// isset($arr['discount']) ? $arr['discount']  : $arr['discount'] = 0;

		// Определяем статус будущего заказа, по-умолчанию установив 1 - обычный заказ
		$order_status = 1;
		// Если у клиента есть промо-код
		if(isset($_SESSION['cart']['promo_code']) && $_SESSION['cart']['promo_code'] != ''){
			/** Написать проверку промо-кода */
			$order_status = 11; // Промо-заказ
		}
		$f['id_order_status'] = $order_status;
		// Сохраняем номер заказа, на основании которого был создан текущщий
		if(isset($_SESSION['cart']['base_order'])){
			$f['base_order'] = $_SESSION['cart']['base_order'];
		}
		// Вычисляем ориентировочную дату отгрузки
		$f['target_date'] = strtotime('+2 day', time());
		// Фиксируем дату создания заказа
		$f['creation_date'] = time();
		// Определяем покупателя для заказа. В случае когда менеджер оформляет заказ на клиента, получаем id покупателя из $_SESSION['cart']['id_customer'] во всех остальных случаях - из $_SESSION['member']['id_user']
		$f['id_customer'] = isset($_SESSION['cart']['id_customer'])?$_SESSION['cart']['id_customer']:$_SESSION['member']['id_user'];

		// Получаем дополнительную информацию о покупателе
		$Customers = new Customers();
		$Customers->SetFieldsById($f['id_customer']);
		$customer = $Customers->fields;
		// Определяем адрес по-умолчанию
		$Address = new Address();
		if($customer_address = $Address->GetPrimaryAddress($f['id_customer'])){
			$_SESSION['member']['id_address'] = $f['id_addrress'] = $customer_address['id'];
		}
		// Обновляем контрагента у покупателя
		if(isset($_SESSION['cart']['id_contragent'])){
			$array['id_contragent'] = $_SESSION['cart']['id_contragent'];
			if($_SESSION['member']['gid'] == _ACL_CUSTOMER_){
				$_SESSION['member']['contragent']['id_user'] = $_SESSION['cart']['id_contragent'];
				$array['id_user'] = $_SESSION['member']['id_user'];
			}elseif($_SESSION['member']['gid'] == _ACL_CONTRAGENT_ && !empty($_SESSION['cart']['id_customer'])){
				$array['id_user'] = $_SESSION['cart']['id_customer'];
			}
		}elseif($_SESSION['member']['gid'] == _ACL_CONTRAGENT_ && !empty($_SESSION['cart']['id_customer'])){
			$array['id_contragent'] = $_SESSION['member']['id_user'];
			$array['id_user'] = $_SESSION['cart']['id_customer'];
		}
		if(isset($array['id_user'])){
			$Customers->updateCustomer($array);
		}
		// Определяем контрагента
		if(isset($_SESSION['cart']['id_contragent'])){
			$id_contragent = $_SESSION['cart']['id_contragent'];
		}else{
			if($_SESSION['member']['gid'] == _ACL_CONTRAGENT_){
				$id_contragent = $_SESSION['member']['id_user'];
			}else{
				//Определяем выходной или рабочий день у контрагента
				$date = date("Y-m-d", mktime(0, 0, 0, date("m") , date("d")+2, date("Y")));
				$sql = "SELECT work_day FROM "._DB_PREFIX_."calendar_contragent
					WHERE id_contragent = ".$customer['id_contragent']." AND date = '".$date."'";
				$res = $this->db->GetOneRowArray($sql);
				if($res['work_day'] != 1){
					//рандомный выбор контрагента
					$Contragents = new Contragents();
					$Contragents->SetList();
					$id_contragent = $Contragents->list[array_rand($Contragents->list)]['id_user'];
				}else{
					$id_contragent = $customer['id_contragent'];
				}
			}
		}
		$f['id_contragent'] = $id_contragent;
		// Фиксируем в заказе примененный промо-код
		if(isset($_SESSION['cart']['promo']) && $_SESSION['cart']['promo'] != ''){
			$f['promo_code'] = $_SESSION['cart']['promo'];
		}
		// Фиксируем в заказе бонусную карту покупателя, если у него она есть
		if(isset($customer['bonus_card']) && $customer['bonus_card'] != ''){
			$f['bonus_card'] = $customer['bonus_card'];
		}
		// Определяем колонку цен корзины
		// Если колонка изменена менеджером вручную ($_SESSION['cart']['manual_price_change']) - берем ее, иначе берем $_SESSION['cart']['cart_column']
		$cart_column = isset($_SESSION['cart']['manual_price_change'])?$_SESSION['cart']['manual_price_change']:$_SESSION['cart']['cart_column'];
		// Если заказ не совместный берем сумму из $_SESSION['cart']['products_sum'] по колонке
		$f['sum_opt'] = $f['sum_mopt'] = $f['sum'] = $f['sum_discount'] = !isset($jo_order)?$_SESSION['cart']['products_sum'][$cart_column]:$GetCartForPromo['total_sum'];
		// Фиксируем в заказе номер телефона покупателя
		$f['phones'] = $customer['phones'];
		// Фиксируем в заказе ФИО покупателя
		$f['cont_person'] = isset($arr['cont_person'])?trim($arr['cont_person']):$customer['cont_person'];
		// Записываем уникальный ключ доступа к заказу
		$f['skey'] = md5(time().'jWfUsd');
		$f['sid'] = 1;
		// Фиксируем в заказе примечание клиента
		$f['note'] = isset($_SESSION['cart']['note'])?$_SESSION['cart']['note']:'';
		// Фиксируем в закзае факт ручного изменения колонки менеджером с указанием комментария
		if(isset($_SESSION['cart']['manual_price_change']) && isset($_SESSION['cart']['manual_price_change_note'])){
			$f['manual_price_change'] = $_SESSION['cart']['manual_price_change'].' - '.$_SESSION['cart']['manual_price_change_note'];
		}
		// Записываем информацию о заказе в таблицу xt_order
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'order', $f)){
			$this->db->FailTrans();
			print_r('order insert error');
			return false;
		}
		// Получаем id нового заказа
		$id_order = $this->db->GetLastId();
		if(isset($jo_order)){
			$GetCartForPromo['id_order'] =  $id_order;
		}else{
			// Фиксируем в сессии номер нового заказа (нужно для заполнения красной формы)
			$_SESSION['cart']['id_order'] = $id_order;
		}
		// Записываем номер нового заказа в соответствующую строку в таблицу xt_cart для перевода корзины в статус закрытой
		if(isset($_SESSION['cart']['id'])){
			$sql = "UPDATE "._DB_PREFIX_."cart
				SET id_order = ".$id_order."
				WHERE id_cart = ".$_SESSION['cart']['id'];
			if(!$this->db->Query($sql)){
				$this->db->FailTrans();
				return false;
			}
		}
		// Очищаем массив заказа
		unset($f);
		// Заполнение связки заказ-товары
		$Suppliers = new Suppliers();
		/**
		 * $order_otpusk_prices_sum - общая сумма заказа по отпускным ценам
		 * $ii - счетчик товаров
		 * $sup_nb - счетчик товаров, имеющих поставщика
		 */
		$order_otpusk_prices_sum = $ii = $sup_nb = 0;
		// Перебираем каждый товар в корзине
		foreach($OrderCart as $id_product=>$item){
			// Определяем поставщика для товара
			if($id_supplier = $this->GetSupplierForProduct($id_product, $item['mode'])){
				// Если поставщик есть - начинаем наполнять массив товара
				$p[$ii]['id_order'] = $id_order;
				$p[$ii]['id_product'] = $id_product;
				$p[$ii]['price_'.$item['mode'].'_otpusk'] = $Suppliers->GetPriceOtpusk($id_supplier, $id_product, $item['mode']);
				$order_otpusk_prices_sum += round($p[$ii]['price_'.$item['mode'].'_otpusk']*$item['quantity'], 2);
				$sup_nb++;
				$Products->SetFieldsById($id_product);
				$product = $Products->fields;
				$p[$ii]['box_qty'] = $item['quantity']/$product['inbox_qty'];
				$p[$ii][$item['mode'].'_qty'] = $item['quantity'];
				$p[$ii]['note'] = $item['note'];
				$p[$ii]['default_sum_'.$item['mode']] = !isset($jo_order)?$item['summary'][$cart_column]:$item['sum_prod'];
				$percents = explode(';', $GLOBALS['CONFIG']['agent_bonus_percent']);
				if ($GLOBALS['CONFIG']['retail_order_margin']<$product['prices_mopt'][3]) {
						$percents[3]=$percents[2];
					}
				if ($GLOBALS['CONFIG']['wholesale_order_margin']<$product['prices_mopt'][3]) {
						$percents[3]=$percents[2]=$percents[1];
					}
				if ($GLOBALS['CONFIG']['full_wholesale_order_margin']<$product['prices_mopt'][3]) {
						$percents[3]=$percents[2]=$percents[1]=$percents[0];
					}
				$p[$ii][$item['mode'].'_sum'] = !isset($jo_order)?$item['summary'][$cart_column]:$item['sum_prod'];
				$p[$ii]['site_price_'.$item['mode']] = !isset($jo_order)?$item['actual_prices'][$cart_column]:$item['price'];
				if($item['mode'] == 'opt'){
					$p[$ii]['id_supplier'] = $id_supplier;
					$p[$ii]['mopt_sum'] = 0;
					$p[$ii]['site_price_mopt'] = 0;
					$p[$ii]['mopt_qty'] = 0;
					$p[$ii]['note_mopt'] = '';
					$p[$ii]['default_sum_mopt'] = 0;
					$p[$ii]['id_supplier_mopt'] = 0;
					$p[$ii]['price_mopt_otpusk'] = 0;					
				}else{
					$p[$ii]['id_supplier_'.$item['mode']] = $id_supplier;
					$p[$ii]['opt_sum'] = 0;
					$p[$ii]['site_price_opt'] = 0;
					$p[$ii]['opt_qty'] = 0;
					$p[$ii]['note_opt'] = '';
					$p[$ii]['default_sum_opt'] = 0;
					$p[$ii]['id_supplier'] = 0;
					$p[$ii]['price_opt_otpusk'] = 0;
				}
				for($i=0; $i<=3; $i++){
					$agent_profits[$i] = round($product['prices_opt_margin'][$i]*$percents[$i], 2);
					$agent_profits[$i+4] = round($product['prices_mopt_margin'][$i]*$percents[$i], 2);
				}
				ksort($agent_profits);
				$p[$ii]['agent_profits'] = implode(';', $agent_profits);		
				$p[$ii]['dealer_price'] = $item['actual_prices'][1];
				$p[$ii]['partner_price'] = $item['actual_prices'][0];
				// Если товар имеет акционный корректировочный сет, ставим отметку об этом в поле promo в таблице xt_osp
				if(in_array($product['opt_correction_set'], $GLOBALS['CONFIG']['promo_correction_set']) || in_array($product['mopt_correction_set'], $GLOBALS['CONFIG']['promo_correction_set'])){
					$p[$ii]['promo'] = 1;
				}else{
					$p[$ii]['promo'] = 0;
				}
				

				$p[$ii]['gift'] = 0;
			}
			$ii++;
		}
		// Если в корзине есть подарки, ищем для них поставщиков и добавляем их в массив товаров с указанием цены 0.01грн
		if(isset($_SESSION['cart']['id_gift']) && $id_supplier = $this->GetSupplierForProduct($_SESSION['cart']['id_gift'], 'mopt')){
			$p[$ii]['id_order'] = $id_order;
			$p[$ii]['id_product'] = $_SESSION['cart']['id_gift'];
			$p[$ii]['id_supplier_mopt'] = $id_supplier;
			$p[$ii]['price_mopt_otpusk'] = $Suppliers->GetPriceOtpusk($id_supplier, $_SESSION['cart']['id_gift'], 'mopt');
			$order_otpusk_prices_sum += 0.01;
			$sup_nb++;
			$Products->SetFieldsById($_SESSION['cart']['id_gift']);
			$product = $Products->fields;
			$p[$ii]['box_qty'] = 1/$product['inbox_qty'];
			$p[$ii]['mopt_qty'] = 1;
			$p[$ii]['note'] = 'Подарок!';
			$p[$ii]['default_sum_mopt'] = '0.01';
			$p[$ii]['opt_qty'] = 0;
			$p[$ii]['note_opt'] = '';
			$p[$ii]['default_sum_opt'] = 0;
			$p[$ii]['id_supplier'] = 0;
			$p[$ii]['price_opt_otpusk'] = 0;
			$p[$ii]['mopt_sum'] = '0.01';
			$p[$ii]['site_price_mopt'] = '0.01';
			$p[$ii]['opt_sum'] = 0;
			$p[$ii]['dealer_price'] = 0;
			$p[$ii]['partner_price'] = 0;
			$p[$ii]['site_price_opt'] = 0;
			$p[$ii]['promo'] = 0;
			$p[$ii]['agent_profits'] = null;
			$p[$ii]['gift'] = 1;
		}
		// Если ни у одного товара нет поставщика
		if($sup_nb === 0){
			$_SESSION['errm']['limit'] = "Невозможно сформировать заказ. Недостаточное количество одного или нескольких товаров на складе. Остаток недостающего товара отображен в поле названия товара.";
			print_r('sup_nb error');
			return false;
		}
		// Если в результате массив товаров не пустой, записываем информацию в таблицу xt_osp
		if(empty($p) || !$this->db->InsertArr(_DB_PREFIX_.'osp', $p)){
			$this->db->FailTrans();
			print_r('osp insert error');
			return false;
		}
		// Сохраняем сумму заказа по отпускным ценам
		$sql = "UPDATE "._DB_PREFIX_."order
			SET otpusk_prices_sum = ".round($order_otpusk_prices_sum, 2)."
			WHERE id_order = ".$id_order;
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			print_r('order update error');
			return false;
		}
		$this->db->CompleteTrans();
		// Очищаем массив товаров
		unset($p);
		// Если статус заказа - обычный и его оформил сам покупатель
		if($order_status == 1 && $_SESSION['member']['gid'] == _ACL_CUSTOMER_){
			// Отправляем на его эл. почту письмо с уведомлением об успешном оформлении заказа
			$Mailer = new Mailer();
			$Mailer->SendOrderInvoicesToCustomers($id_order);
			// Отправляем на его телефон SMS с уведомлением об успешном оформлении заказа
			// $Users->SetFieldsById($_SESSION['member']['id_user']);
			// $Gateway = new APISMS($GLOBALS['CONFIG']['sms_key_private'], $GLOBALS['CONFIG']['sms_key_public'], 'http://atompark.com/api/sms/', false);
			// $Contragents = new Contragents();
			// $string = $Contragents->GetSavedFields($id_contragent);
			// $manager2send = $string['name_c'].' '.preg_replace("/[,]/i",", ",preg_replace("/[a-z\\(\\)\\-\\040]/i","",$string['phones']));
			// if($Users->fields['phone'] != '' ){
				// $Gateway->execCommad(
				// 	'sendSMS',
				// 	array(
				// 		'sender' => $GLOBALS['CONFIG']['invoice_logo_sms'],
				// 		'text' => 'Заказ № '.$id_order.' принят. Ваш менеджер '.$manager2send,
				// 		'phone' => $Users->fields['phone'],
				// 		'datetime' => null,
				// 		'sms_lifetime' => 0
				// 	)
				// );
			// }
		}
		if(isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] == _ACL_CONTRAGENT_){
			unset($_SESSION['cart']['base_order'], $_SESSION['cart']['id_customer'], $_SESSION['member']['bonus']);
		}
		if(isset($_SESSION['cart']['promo'])){
			unset($_SESSION['cart']['promo']);
		}
		if(isset($_SESSION['cart']['id_gift'])){
			unset($_SESSION['cart']['id_gift']);
		}
		if(isset($_SESSION['cart']['note'])){
			unset($_SESSION['cart']['note']);
		}
		if(isset($_SESSION['cart']['id_contragent'])){
			unset($_SESSION['cart']['id_contragent']);
		}
		if(isset($_SESSION['cart']['manual_price_change'])){
			unset($_SESSION['cart']['manual_price_change']);
		}
		if(isset($_SESSION['cart']['manual_price_change_note'])){
			unset($_SESSION['cart']['manual_price_change_note']);
		}
		return $id_order;
	}

	// Обновление
	public function GetStatuses(){
		$sql = "SELECT id_order_status, name
				FROM "._DB_PREFIX_."order_status
				order by id_order_status";
		$arr = $this->db->GetArray($sql);
		foreach($arr as $i){
			$a[$i['id_order_status']] = $i;
		}
		return $a;
	}

	/**
	 * Возвращает id вычисленного поставщика для товара
	 * @param [type] $id_product [description]
	 * @param [type] $mode       [description]
	 */
	public function GetSupplierForProduct($id_product, $mode){
		// если продукт имеет эксклюзивного поставщика
		if($supplier = $this->HasExclusiveSupplier($id_product, $mode)){
			return $supplier['id_supplier'];
		}
		// определение списка доступных поставщиков
		$sql = "SELECT a.id_product, a.id_supplier,
			a.price_opt_otpusk, a.price_mopt_otpusk
			FROM "._DB_PREFIX_."assortiment AS a
			WHERE a.id_product = ".$id_product."
			AND a.active = 1
			AND (a.price_".$mode."_otpusk > 0 AND a.price_".$mode."_recommend > 0)
			ORDER BY a.price_".$mode."_otpusk DESC";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		foreach($arr as $s){
			if($this->CheckRentabPrice($id_product, $s['id_supplier'], $mode)){
				$id_supplier = $s['id_supplier'];
			}
		}
		return $id_supplier;
	}

	/**
	 * Проверка на эксклюзивного поставщика
	 * @param integer	$id_product id товара
	 * @param string	$mode       режим opt/mopt
	 */
	public function HasExclusiveSupplier($id_product, $mode){
		$sql = "SELECT p.exclusive_supplier AS id_supplier
			FROM "._DB_PREFIX_."product AS p
			RIGHT JOIN "._DB_PREFIX_."supplier AS s ON p.exclusive_supplier = s.id_user
			WHERE p.id_product = ".$id_product;
		if($arr = $this->db->GetOneRowArray($sql)){
			// Если поставщик доступен по дате и у него достаточное количество товара
			if($this->CheckRentabPrice($id_product, $arr['id_supplier'], $mode)){
				return $arr;
			}
		}
		return false;
	}

	/**
	 * Проверка на рентабельность цен поставщика
	 * @param integer $id_product  [description]
	 * @param integer $id_supplier [description]
	 * @param string $mode        [description]
	 */
	public function CheckRentabPrice($id_product, $id_supplier, $mode){
		$sql = "SELECT p.price_".$mode." AS site_price, a.price_".$mode."_otpusk AS price_otpusk
			FROM "._DB_PREFIX_."product AS p
				LEFT JOIN "._DB_PREFIX_."assortiment AS a ON p.id_product = a.id_product
			WHERE p.id_product = ".$id_product."
			AND a.id_supplier = ".$id_supplier;
		$arr = $this->db->GetOneRowArray($sql);
		$delta = round(($arr['site_price']*$GLOBALS['CONFIG']['proc_supplier']/100), 2);
		if($arr['site_price']-$arr['price_otpusk'] < $delta || $arr['price_otpusk'] <= 0){
			return false;
		}
		return true;
	}

	// Проверка на доступность поставщика в этот день */*
	public function IsAvailableSupplierInDate($id_supplier, $target_date){
		$target_date = date("Y-m-d",$target_date);
		$sql = "SELECT date
				FROM "._DB_PREFIX_."calendar_supplier
				WHERE id_supplier=$id_supplier
				AND date=\"$target_date\"
				AND work_day = 1";
		$arr = $this->db->GetOneRowArray($sql);
		if($arr){
			return true;
		}else{
			return false;
		}
	}

	// Проверить доступное количество товара
	public function CheckProductLimit($id_product, $id_exclusive_supplier, $target_date, $product_limit){
		$sql = "SELECT a.product_limit
				FROM "._DB_PREFIX_."assortiment a
				WHERE id_supplier=$id_exclusive_supplier
				AND a.id_product=$id_product";
		$arr = $this->db->GetOneRowArray($sql);
		if($arr['product_limit'] >= $product_limit){
			return true;
		}else{
			//$_SESSION['errm'][] = "Превышено доступное количество товара.";
			//$_SESSION['Supplier']['limit_err'][$id_product] = "Количество, доступное для заказа: ".$arr['product_limit'];
			return false;
		}
	}

	public function CorrectProductLimit($id_product, $id_supplier, $limit){
		$sql = "UPDATE "._DB_PREFIX_."assortiment SET product_limit=product_limit-$limit
				WHERE id_product=$id_product
				AND id_supplier=$id_supplier";
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			return false;
		}
		return true;
	}

	public function SupplierWasOrder($id_supplier){
		$sql = "UPDATE "._DB_PREFIX_."supplier SET was_order=1
				WHERE id_user=$id_supplier";
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			return false;
		}
		return true;
	}
	// Проверка контрагента на доступность по дате и сумме
	public function IsAvailableContragentInDateSum($id_contragent, $target_date, $sum){
		$target_date = date("Y-m-d",$target_date);
		$sql = "SELECT date
				FROM "._DB_PREFIX_."calendar_contragent
				WHERE id_contragent = ".$id_contragent."
				AND date = '".$target_date."'
				AND (work_day != 0 || work_night != 0)
				AND (limit_sum_day > $sum || limit_sum_night != $sum)";
		$arr = $this->db->GetOneRowArray($sql);
		if($arr){
			return true;
		}else{
			return false;
		}
	}

	public function CorrectContragentLimitSum($id_contragent, $limit_sum, $target_date){
		$sql = "SELECT limit_sum_day, limit_sum_night
			FROM "._DB_PREFIX_."calendar_contragent
			WHERE id_contragent = ".$id_contragent."
			AND date='".date("Y-m-d",$target_date)."'";
		$arr = $this->db->GetOneRowArray($sql);

		if($arr['limit_sum_day'] > $limit_sum){
			$dn = 'day';
		}elseif($arr['limit_sum_night'] > $limit_sum){
			$dn = 'night';
		}else{
			$this->db->FailTrans();
			return false;
		}
		$sql = "UPDATE "._DB_PREFIX_."calendar_contragent
			SET limit_sum_".$dn." = limit_sum_".$dn-$limit_sum."
			WHERE id_contragent = ".$id_contragent."
			AND date='".date("Y-m-d",$target_date)."'";
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			return false;
		}
		return true;
	}

	public function GetOrderForContragent($and){
		$sql = "SELECT o.id_order, o.id_order_status, o.sum_discount,
				o.note, osp.id_product, p.name, p.img_1, p.art, p.inbox_qty,
				osp.site_price_opt, osp.site_price_mopt, osp.box_qty,
				osp.mopt_qty, osp.opt_sum, osp.mopt_sum, s.article, osp.opt_qty,
				osp.id_supplier, osp.id_supplier_mopt, o.target_date,
				osp.contragent_qty, osp.contragent_mqty, osp.contragent_sum,
				osp.contragent_msum, osp.fact_qty, osp.fact_sum, osp.fact_mqty,
				osp.fact_msum, osp.return_qty, osp.return_sum, osp.return_mqty,
				osp.return_msum, o.id_pretense_status, o.id_return_status,
				osp.id_supplier_altern, osp.id_supplier_mopt_altern,
				(SELECT "._DB_PREFIX_."supplier.article
					FROM "._DB_PREFIX_."supplier
					WHERE "._DB_PREFIX_."supplier.id_user = osp.id_supplier_mopt
				) AS article_mopt,
				(SELECT "._DB_PREFIX_."supplier.article
					FROM "._DB_PREFIX_."supplier
					WHERE "._DB_PREFIX_."supplier.id_user = osp.id_supplier_altern
				) AS article_altern,
				(SELECT "._DB_PREFIX_."supplier.article
					FROM "._DB_PREFIX_."supplier
					WHERE "._DB_PREFIX_."supplier.id_user = osp.id_supplier_mopt_altern
				) AS article_mopt_altern
			FROM "._DB_PREFIX_."osp AS osp
			LEFT JOIN "._DB_PREFIX_."order AS o
				ON osp.id_order = o.id_order
			LEFT JOIN "._DB_PREFIX_."supplier AS s
				ON osp.id_supplier = s.id_user
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON osp.id_product = p.id_product
			".$this->db->GetWhere($and)."
			GROUP BY osp.id_order, osp.id_product
			ORDER BY article, article_mopt, p.name
			";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}else{
			return $arr;
		}
	}

	public function GetOrderForMdiler($and){
		$sql = "SELECT o.id_order, o.id_order_status, o.sum_discount,
				osp.id_product, p.name, p.art, p.img_1, osp.site_price_opt,
				osp.site_price_mopt, osp.opt_qty, osp.mopt_qty, osp.opt_sum,
				osp.mopt_sum, s.article, osp.id_supplier, osp.id_supplier_mopt,
				o.target_date, osp.contragent_qty, osp.contragent_mqty,
				osp.contragent_sum, osp.contragent_msum, osp.price_opt_otpusk,
				osp.price_mopt_otpusk, osp.id_supplier_altern, osp.id_supplier_mopt_altern,
				(SELECT "._DB_PREFIX_."supplier.article
					FROM "._DB_PREFIX_."supplier
					WHERE "._DB_PREFIX_."supplier.id_user = osp.id_supplier_mopt
				) AS article_mopt,
				(SELECT "._DB_PREFIX_."supplier.article
					FROM "._DB_PREFIX_."supplier
					WHERE "._DB_PREFIX_."supplier.id_user = osp.id_supplier_altern
				) AS article_altern,
				(SELECT "._DB_PREFIX_."supplier.article
					FROM "._DB_PREFIX_."supplier
					WHERE "._DB_PREFIX_."supplier.id_user = osp.id_supplier_mopt_altern
				) AS article_mopt_altern
			FROM "._DB_PREFIX_."osp AS osp
			LEFT JOIN "._DB_PREFIX_."order AS o
				ON osp.id_order = o.id_order
			LEFT JOIN "._DB_PREFIX_."supplier AS s
				ON osp.id_supplier = s.id_user
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON osp.id_product = p.id_product
			".$this->db->GetWhere($and)."
			GROUP BY osp.id_order, osp.id_product
			ORDER BY p.name";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		return $arr;
	}

	public function ExecuteContragentOrder($arr, $id_order){
		$Supplier = new Suppliers();
		$sql = "SELECT id_product, site_price_opt, site_price_mopt
			FROM "._DB_PREFIX_."osp
			WHERE id_order = ".$id_order;
		$prices = $this->db->GetArray($sql, "id_product");
		if(isset($arr['contr_qty'])){
			foreach($arr['contr_qty'] as $id_product=>$contr_qty){
				$sql = "UPDATE "._DB_PREFIX_."osp
					SET contragent_qty = ".$contr_qty.",
						contragent_sum = ".round($arr['contr_qty'][$id_product]*$prices[$id_product]['site_price_opt'],2).",
						id_supplier = {$Supplier->GetSupplierIdByArt($arr['article'][$id_product])}
					WHERE id_order = ".$id_order."
					AND id_product = ".$id_product;
				$this->db->StartTrans();
				if(!$this->db->Query($sql)){
					$this->db->FailTrans();
					G::DieLoger("SQL error - $sql");
					return false;
				}
				$this->db->CompleteTrans();
			}
		}
		if(isset($arr['contr_mqty'])){
			foreach($arr['contr_mqty'] as $id_product=>$contr_mqty){
				$sql = "UPDATE "._DB_PREFIX_."osp
					SET contragent_mqty = ".$contr_mqty.",
						contragent_msum = ".round($arr['contr_mqty'][$id_product]*$prices[$id_product]['site_price_mopt'],2).",
						id_supplier_mopt = {$Supplier->GetSupplierIdByArt($arr['article_mopt'][$id_product])}
					WHERE id_order = ".$id_order."
					AND id_product = ".$id_product;
				$this->db->StartTrans();
				if(!$this->db->Query($sql)){
					$this->db->FailTrans();
					G::DieLoger("SQL error - $sql");
					return false;
				}
				$this->db->CompleteTrans();
			}
		}
		$sql = "UPDATE "._DB_PREFIX_."order
			SET id_order_status = 2
			WHERE id_order = ".$id_order;
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			G::DieLoger("SQL error - $sql");
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function CancelContragentOrder($id_order){
		$sql = "UPDATE "._DB_PREFIX_."order
			SET id_order_status = 4
			WHERE id_order = ".$id_order;
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			G::DieLoger("SQL error - $sql");
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function RunContragentOrder($id_order){
		$sql = "UPDATE "._DB_PREFIX_."order
			SET id_order_status = 6
			WHERE id_order = ".$id_order;
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			G::DieLoger("SQL error - $sql");
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function OffUserOrder($id_order){
		$sql = "UPDATE "._DB_PREFIX_."order
			SET id_order_status = 5,
				visibility = 0
			WHERE id_order = ".$id_order;
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			G::DieLoger("SQL error - $sql");
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function CancelCustomerOrder($id_order){
		$sql = "UPDATE "._DB_PREFIX_."order
			SET id_order_status = 5
			WHERE id_order = ".$id_order;
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			G::DieLoger("SQL error - $sql");
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function ExecuteContragentPretense($id_order){
		$sql = "UPDATE "._DB_PREFIX_."order
			SET id_pretense_status = 2
			WHERE id_order = ".$id_order;
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			G::DieLoger("SQL error - $sql");
			return false;
		}
		return true;
	}

	public function UpdateStatus($id_order, $status, $date = false){
		if($date !== false){
			$sql = "UPDATE "._DB_PREFIX_."order
				SET id_order_status = ".$status.",
					target_date = UNIX_TIMESTAMP('".$date."')
				WHERE id_order = ".$id_order;
		}else{
			$sql = "UPDATE "._DB_PREFIX_."order
				SET id_order_status = ".$status."
				WHERE id_order = ".$id_order;
		}
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			G::DieLoger("SQL error - $sql");
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function GetOrderForCustomer($and){
		$sql = "SELECT o.id_order, o.id_order_status, o.sum_discount, osp.id_product,
				osp.id_supplier_altern,
				(CASE WHEN osp.opt_qty >0 THEN osp.site_price_opt ELSE osp.site_price_mopt END) AS price,
				p.inbox_qty, osp.box_qty,
				(CASE WHEN osp.opt_qty >0 THEN osp.opt_qty ELSE osp.mopt_qty END) AS quantity,
				osp.opt_qty, osp.mopt_qty, osp.opt_sum, osp.mopt_sum, s.article, osp.id_supplier, p.name, p.art,
				osp.site_price_mopt, osp.site_price_opt,
				(CASE WHEN osp.note_opt <>'' THEN osp.note_opt ELSE osp.note_mopt END) AS note,
				o.target_date, osp.contragent_qty, osp.contragent_mqty, osp.contragent_sum,
				osp.contragent_msum, osp.fact_qty, osp.fact_sum,
				osp.fact_mqty, osp.fact_msum, p.img_1,
				osp.return_qty, osp.return_sum,
				osp.return_mqty, osp.return_msum,
				osp.dealer_price, osp.partner_price, osp.promo,
				p.units, o.id_pretense_status, o.id_return_status,
				p.translit, osp.id_supplier_mopt_altern, osp.id_supplier_mopt, osp.agent_profits, i.src AS images,
				(SELECT "._DB_PREFIX_."supplier.article
					FROM "._DB_PREFIX_."supplier
					WHERE "._DB_PREFIX_."supplier.id_user = osp.id_supplier_mopt
				) AS article_mopt,
				(SELECT "._DB_PREFIX_."supplier.article
					FROM "._DB_PREFIX_."supplier
					WHERE "._DB_PREFIX_."supplier.id_user = osp.id_supplier_altern
				) AS article_altern,
				(SELECT "._DB_PREFIX_."supplier.article
					FROM "._DB_PREFIX_."supplier
					WHERE "._DB_PREFIX_."supplier.id_user = osp.id_supplier_mopt_altern
				) AS article_mopt_altern
				FROM "._DB_PREFIX_."osp AS osp
				LEFT JOIN "._DB_PREFIX_."order AS o
					ON osp.id_order = o.id_order
				LEFT JOIN "._DB_PREFIX_."supplier AS s
					ON osp.id_supplier = s.id_user
				LEFT JOIN "._DB_PREFIX_."product AS p
					ON osp.id_product = p.id_product
				LEFT JOIN "._DB_PREFIX_."image AS i
					ON osp.id_product = i.id_product
						AND i.ord = 0 AND i.visible = 1
				".$this->db->GetWhere($and)."
				GROUP BY osp.id_order, osp.id_product
				ORDER BY p.name";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}else{
			return $arr;
		}
	}

	public function GetCartForCustomer($and){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."osp AS osp
			LEFT JOIN "._DB_PREFIX_."order AS o
				ON osp.id_order = o.id_order
			LEFT JOIN "._DB_PREFIX_."supplier AS s
				ON osp.id_supplier = s.id_user
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON osp.id_product = p.id_product
			LEFT JOIN "._DB_PREFIX_."image AS i
				ON osp.id_product = i.id_product
					AND i.ord = 0 AND i.visible = 1
			".$this->db->GetWhere($and)."
			GROUP BY osp.id_order, osp.id_product
			ORDER BY p.name";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}else{
			return $arr;
		}
	}

	public function GetOrderForPricelist($and){
		$sql = "SELECT DISTINCT cp.id_category, c.name
			FROM "._DB_PREFIX_."osp AS osp
			LEFT JOIN "._DB_PREFIX_."order AS o
				ON osp.id_order = o.id_order
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON osp.id_product = p.id_product
			LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
				ON osp.id_product = cp.id_product
			LEFT JOIN "._DB_PREFIX_."category AS c
				ON cp.id_category = c.id_category
			".$this->db->GetWhere($and)."
			GROUP BY osp.id_product
			ORDER BY p.name";
		$arr['cats'] = $this->db->GetArray($sql);
		$ii = 0;
		$sql = "SELECT o.id_order, o.id_order_status, cp.id_category,
				o.sum_discount, osp.id_product, p.name, p.art, p.img_1,
				osp.site_price_opt, osp.site_price_mopt, p.inbox_qty,
				osp.opt_qty, osp.mopt_qty, osp.opt_sum, osp.mopt_sum,
				osp.id_supplier, osp.id_supplier_mopt, o.target_date,
				osp.contragent_qty, osp.contragent_mqty, osp.contragent_sum,
				osp.fact_qty, osp.fact_sum, osp.fact_mqty, osp.fact_msum,
				osp.return_qty, osp.return_sum, osp.return_mqty, osp.return_msum,
				p.min_mopt_qty, p.units, osp.box_qty, o.id_pretense_status,
				o.id_return_status, osp.contragent_msum, i.src AS image
			FROM "._DB_PREFIX_."osp AS osp
			LEFT JOIN "._DB_PREFIX_."order AS o
				ON osp.id_order = o.id_order
			LEFT JOIN "._DB_PREFIX_."supplier AS s
				ON osp.id_supplier = s.id_user
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON osp.id_product = p.id_product
			LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
				ON osp.id_product = cp.id_product
			LEFT JOIN "._DB_PREFIX_."image AS i
				ON osp.id_product = i.id_product
					AND i.ord = 0 AND i.visible = 1
			".$this->db->GetWhere($and)."
			GROUP BY osp.id_order, osp.id_product
			ORDER BY p.name";
		$arr['products'] = $this->db->GetArray($sql);
		foreach($arr['cats'] as $k=>$c){
			foreach($arr['products'] as $p){
				if($p['id_category'] == $c['id_category']){
					$arr['cats'][$k]['products'][] = $p;
				}
			}
		}
		if(!$arr){
			return false;
		}else{
			return $arr;
		}
	}

	public function GetOrderForAdmin($and){
		$sql = "SELECT o.id_order, o.id_order_status, osp.id_product,
				p.name, p.img_1, osp.site_price_opt, osp.site_price_mopt,
				p.inbox_qty, osp.box_qty, osp.opt_qty, osp.mopt_qty,
				osp.opt_sum, osp.mopt_sum, s.article, osp.id_supplier,
				osp.id_supplier_mopt, o.target_date, osp.contragent_qty,
				osp.contragent_mqty, osp.contragent_sum, osp.contragent_msum,
				osp.fact_qty, osp.fact_sum, osp.fact_mqty, osp.fact_msum,
				osp.return_qty, osp.return_sum, osp.return_mqty, osp.return_msum,
				o.id_pretense_status, o.id_return_status, osp.id_supplier_altern,
				osp.id_supplier_mopt_altern,
				(SELECT "._DB_PREFIX_."supplier.article
					FROM "._DB_PREFIX_."supplier
					WHERE "._DB_PREFIX_."supplier.id_user = osp.id_supplier_mopt
				) AS article_mopt,
				(SELECT "._DB_PREFIX_."supplier.article
					FROM "._DB_PREFIX_."supplier
					WHERE "._DB_PREFIX_."supplier.id_user = osp.id_supplier_altern
				) AS article_altern,
				(SELECT "._DB_PREFIX_."supplier.article
					FROM "._DB_PREFIX_."supplier
					WHERE "._DB_PREFIX_."supplier.id_user = osp.id_supplier_mopt_altern
				) AS article_mopt_altern
			FROM "._DB_PREFIX_."osp AS osp
			LEFT JOIN "._DB_PREFIX_."order AS o
				ON osp.id_order = o.id_order
			LEFT JOIN "._DB_PREFIX_."supplier AS s
				ON osp.id_supplier = s.id_user
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON osp.id_product = p.id_product
			".$this->db->GetWhere($and)."
			GROUP BY osp.id_order, osp.id_product";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		return $arr;
	}

	// Создание претензии
	public function CreatePretense($arr, $id_order){
		$sql = "SELECT id_product, site_price_opt, site_price_mopt
			FROM "._DB_PREFIX_."osp
			WHERE id_order = ".$id_order;
		$prices = $this->db->GetArray($sql, "id_product");
		$this->db->StartTrans();
		// Заполнение факт кол-ва существующих позиций
		if(isset($arr['fact_qty'])){
			foreach($arr['fact_qty'] as $id_product=>$fact_qty){
				$sql = "UPDATE "._DB_PREFIX_."osp
					SET fact_qty = ".$fact_qty.",
						fact_sum = ".round($arr['fact_qty'][$id_product]*$prices[$id_product]['site_price_opt'],2)."
					WHERE id_order = ".$id_order."
					AND id_product = ".$id_product;
				if(!$this->db->Query($sql)){
					$this->db->FailTrans();
					G::DieLoger("SQL error - $sql");
					return false;
				}
			}
		}
		if(isset($arr['fact_mqty'])){
			foreach($arr['fact_mqty'] as $id_product=>$fact_mqty){
				$sql = "UPDATE "._DB_PREFIX_."osp
					SET fact_mqty = ".$fact_mqty.",
						fact_msum = ".round($arr['fact_mqty'][$id_product]*$prices[$id_product]['site_price_mopt'],2)."
					WHERE id_order = ".$id_order."
					AND id_product = ".$id_product;
				if(!$this->db->Query($sql)){
					$this->db->FailTrans();
					G::DieLoger("SQL error - $sql");
					return false;
				}
			}
		}
		// Заполнение новых (добавленных юзером) позиций
		$this->db->DeleteRowFrom(_DB_PREFIX_."pretense", "id_order", $id_order);
		if(isset($arr['pretense_article'])){
			foreach($arr['pretense_article'] as $ii=>$pretense_article){
				$f['id_order'] = $id_order;
				$f['article'] = $pretense_article;
				$f['name'] = $arr['pretense_name'][$ii];
				$f['price'] = $arr['pretense_price'][$ii];
				$f['qty'] = $arr['pretense_qty'][$ii];
				if(!$this->db->Insert(_DB_PREFIX_.'pretense', $f)){
					$this->db->FailTrans();
					return false;
				}
			}
		}
		// Установка статуса "В работе" претензии заказа
		$sql = "UPDATE "._DB_PREFIX_."order
			SET id_pretense_status = 1,
				pretense_date = '".time()."'
			WHERE id_order = ".$id_order;
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			G::DieLoger("SQL error - $sql");
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function GetPretenseAdditionalRows($id_order){
		$sql = "SELECT article, name, price, qty
			FROM "._DB_PREFIX_."pretense
			WHERE id_order = ".$id_order;
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}else{
			return $arr;
		}
	}

	public function CreateReturn($arr,$id_order) {
		$sql = "SELECT id_product, site_price_opt, site_price_mopt
			FROM "._DB_PREFIX_."osp
			WHERE id_order = ".$id_order;
		$prices = $this->db->GetArray($sql, "id_product");
		$this->db->StartTrans();
		// обработка строк по крупному опту
		if(isset($arr['return_qty'])){
			foreach($arr['return_qty'] as $id_product=>$return_qty){
				$sql = "UPDATE "._DB_PREFIX_."osp
					SET return_qty = ".$return_qty.",
						return_sum = ".round($arr['return_qty'][$id_product]*$prices[$id_product]['site_price_opt'], 2)."
					WHERE id_order = ".$id_order."
					AND id_product = ".$id_product;
				if(!$this->db->Query($sql)){
					$this->db->FailTrans();
					G::DieLoger("SQL error - $sql");
					return false;
				}
			}
		}
		// обработка строк по мелкому опту
		if(isset($arr['return_mqty'])){
			foreach($arr['return_mqty'] as $id_product=>$return_mqty){
				$sql = "UPDATE "._DB_PREFIX_."osp
					SET return_mqty = ".$return_mqty.",
						return_msum = ".round($arr['return_mqty'][$id_product]*$prices[$id_product]['site_price_mopt'], 2)."
					WHERE id_order = ".$id_order."
					AND id_product = ".$id_product;
				if(!$this->db->Query($sql)){
					$this->db->FailTrans();
					G::DieLoger("SQL error - $sql");
					return false;
				}
			}
		}
		// Установка статуса "В работе" возврата заказа
		$sql = "UPDATE "._DB_PREFIX_."order
			SET id_return_status = 1,
				return_date = '".time()."'
			WHERE id_order = ".$id_order;
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			G::DieLoger("SQL error - $sql");
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	// Перевод заказа в статус "Выполнен"
	public function ExecuteContragentReturn($id_order){
		$sql = "UPDATE "._DB_PREFIX_."order
			SET id_return_status = 2
			WHERE id_order = ".$id_order;
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			G::DieLoger("SQL error - $sql");
			return false;
		}
		return true;
	}

	// Проверка и обновление даты обнуления очереди пооставщиков
	public function UpdateSuppliersTurn(){
		// Проверка даты очистки очереди
		$date = date("Y-m-d", time());
		if($date > $GLOBALS['CONFIG']['turn_date']){
			// если дата устарела - устанавливаем новую
			$new_date = date("Y-m-d", (time()+3600*24*$GLOBALS['CONFIG']['turn_days']));
			$f['value'] = $new_date;
			$this->db->StartTrans();
			$this->db->Update(_DB_PREFIX_."config", $f, "name = 'turn_date'");
			$f = array('was_order'=>0);
			$this->db->Update(_DB_PREFIX_."supplier", $f, "1");
			$this->db->CompleteTrans();
		}
	}

	public function GetOrderForCart($and){
		$sql = 'SELECT o.id_order, osp.id_product,
			osp.box_qty, osp.opt_qty, osp.mopt_qty,
			osp.default_sum_opt, osp.default_sum_mopt,
			osp.note_opt, osp.note_mopt, osp.note,
			osp.opt_sum, osp.mopt_sum
			FROM '._DB_PREFIX_.'osp AS osp
			LEFT JOIN '._DB_PREFIX_.'order AS o
				ON osp.id_order = o.id_order
			'.$this->db->GetWhere($and);
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}else{
			return $arr;
		}
	}

	// Объявление полей для экспорта "Заказы по поставщикам"
	public function GetExcelOrdersSupColumnsArray(){
		$ii = 0;
		$ca[$ii++] = array('h'=>'Дата', 						'n' => 'target_date',			'w'=>'14');
		$ca[$ii++] = array('h'=>'Статус', 						'n' => 'status_name', 			'w'=>'20');
		$ca[$ii++] = array('h'=>'Заказ',						'n' => 'id_order',		 		'w'=>'16');
		$ca[$ii++] = array('h'=>'Код части заказа', 			'n' => 'id_order_supart', 		'w'=>'20');
		$ca[$ii++] = array('h'=>'Покупатель', 					'n' => 'customer_name',		 	'w'=>'62');
		$ca[$ii++] = array('h'=>'Контрагент', 					'n' => 'contragent_name',		'w'=>'34');
		$ca[$ii++] = array('h'=>'Поставщик', 					'n' => 'supplier_name', 		'w'=>'34');
		$ca[$ii++] = array('h'=>'Группа',						'n' => 'partner', 				'w'=>'16');
		$ca[$ii++] = array('h'=>'Сумма по заказу, грн',			'n' => 'order_sum', 			'w'=>'20');
		$ca[$ii++] = array('h'=>'Сумма по отпуск ценам, грн',	'n' => 'otpusk_prices_sum',		'w'=>'20');
		$ca[$ii++] = array('h'=>'Претензия',					'n' => 'pretense', 				'w'=>'20');
		$ca[$ii++] = array('h'=>'Статус',						'n' => 'pretense_status',		'w'=>'20');
		$ca[$ii++] = array('h'=>'Возврат',						'n' => 'return', 				'w'=>'20');
		$ca[$ii++] = array('h'=>'Статус',						'n' => 'return_status',			'w'=>'20');
		return $ca;
	}

	// Генерация и выдача для скачивания файла excel "Заказы по поставщикам"
	public function GenExcelOrdersSupFile($rows){
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Generator xtorg")
			->setLastModifiedBy("Generator xtorg")
			 ->setTitle("Products")
			 ->setSubject("Generator xtorg: products")
			 ->setDescription("Generator xtorg.")
			 ->setKeywords("office 2007 openxml php")
			 ->setCategory("result file");
		$objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Arial');
		$objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(15);
		$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);
		$ca = $this->GetExcelOrdersSupColumnsArray();
		$ii=1;
		foreach($ca as $i){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr($ii+64).'1', $i['h']);
			$objPHPExcel->getActiveSheet()->getStyle(chr($ii+64).'1')->getFont()->setBold(true);
			$ii++;
		}
		$charcnt = 0;
		foreach($ca as $i){
			$objPHPExcel->getActiveSheet()->getColumnDimension(chr((++$charcnt)+64))->setWidth($i['w']);
		}
		$ii=2;
		foreach($rows as $r){
			$charcnt = 0;
			foreach ($ca as $i){
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r[$i['n']]);
			}
			$ii++;
		}
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Заказы по поставщикам.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}

	public function ClearDB($date){
		list($d,$m,$y) = explode(".", trim($date));
		$date = mktime(0, 0, 0, $m , $d, $y);
		$sql = "SELECT id_order
			FROM "._DB_PREFIX_."order
			WHERE creation_date < '".$date."'";
		$arr = $this->db->GetArray($sql);
		if(count($arr)){
			$a = array();
			foreach($arr as $id){
				$a[] = $id['id_order'];
			}
			$ids = implode(",", $a);
			$this->db->StartTrans();
			$sql = "DELETE FROM "._DB_PREFIX_."order WHERE id_order IN($ids)";
			if(!$this->db->Query($sql)){
				$this->db->FailTrans();
				G::DieLoger("SQL error - $sql");
				return false;
			}
			$sql = "DELETE FROM "._DB_PREFIX_."osp WHERE id_order IN($ids)";
			if(!$this->db->Query($sql)){
				$this->db->FailTrans();
				G::DieLoger("SQL error - $sql");
				return false;
			}
			$sql = "DELETE FROM "._DB_PREFIX_."pretense WHERE id_order IN($ids)";
			if(!$this->db->Query($sql)){
				$this->db->FailTrans();
				G::DieLoger("SQL error - $sql");
				return false;
			}
			$this->db->CompleteTrans();
		}
		return true;
	}

	public function RestoreDeleted($id_order){
		$sql = "UPDATE "._DB_PREFIX_."order
			SET id_order_status = 6
			WHERE id_order = ".$id_order;
		$this->db->StartTrans();
		if(!$this->db->Query($sql)) {
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	// Добавляем адрес к заказу клиента
	public function addAddress($id_order, $id_address){
		$sql = "UPDATE "._DB_PREFIX_."order
			SET id_address = ".$id_address."
			WHERE id_order = ".$id_order;
		$this->db->StartTrans();
		if(!$this->db->Query($sql)) {
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function GetOrdersByDate($from_i, $to_i){
		$from_date = time()-3600*24*30*$from_i;
		$to_date = time()-3600*24*30*$to_i;
		$sql = "SELECT ".implode(", ",$this->usual_fields2).",
				(SELECT name
					FROM "._DB_PREFIX_."user AS u
					LEFT JOIN "._DB_PREFIX_."contragent AS ca
						ON ca.id_user = u.id_user
					WHERE ca.id_user = o.id_contragent
				) AS contragent_name,
				(SELECT name
					FROM "._DB_PREFIX_."user AS u
					LEFT JOIN "._DB_PREFIX_."customer AS cu
						ON cu.id_user = u.id_user
					WHERE cu.id_user = o.id_customer
				) AS customer_name,
				(SELECT email
					FROM "._DB_PREFIX_."user AS u
					LEFT JOIN "._DB_PREFIX_."customer AS cu
						ON cu.id_user = u.id_user
					WHERE cu.id_user = o.id_customer
				) AS customer_email
			FROM "._DB_PREFIX_."order AS o
			WHERE creation_date >= '".$to_date."'
			AND creation_date <= '".$from_date."'
			ORDER BY creation_date DESC";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		return $arr;
	}

	public function GetOrdersByPromoSupplier($id_supplier){
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."order AS o
			LEFT JOIN "._DB_PREFIX_."user AS u
				ON u.id_user = o.id_customer
			LEFT JOIN "._DB_PREFIX_."promo_code AS pc
				ON pc.code = u.promo_code
			WHERE o.id_order_status IN (11, 5)
			AND pc.id_supplier = ".$id_supplier."
			ORDER BY o.creation_date DESC";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		return $arr;
	}

	public function GetOrdersCountListByDate($date){
		$sql = "SELECT '".$date."' AS date, IFNULL((SELECT COUNT(o.id_order)
			FROM "._DB_PREFIX_."order AS o
			WHERE DATE_FORMAT(from_unixtime(o.creation_date),'%d-%m-%Y') = '".$date."'
			GROUP BY DATE_FORMAT(from_unixtime(o.creation_date),'%d-%m-%Y')), 0) AS count";
		if(!$arr = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $arr;
	}

	//Выборка заказов сделанных на протяжении недели
	public function GetOrdersCountListByWeek($date_start, $date_end){
		$sql = "SELECT '".$date_start."' AS date_start,
			'".$date_end."' AS date_end,
			IFNULL((SELECT COUNT(o.id_order)
			FROM "._DB_PREFIX_."order AS o
			WHERE o.creation_date > ".strtotime($date_start)."
			AND o.creation_date <= ".strtotime($date_end)."), 0) AS count";
		if(!$arr = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $arr;
	}

	public function GetContragentByLastOrder(){
		$sql = "SELECT c.name_c
				FROM "._DB_PREFIX_."order o
				LEFT JOIN "._DB_PREFIX_."contragent c
				ON o.id_contragent = c.id_user
				WHERE o.id_customer = ".$_SESSION['member']['id_user']."
				ORDER BY o.id_order DESC LIMIT 1";
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res['name_c'];
	}

	public function SetOrderAddress($id_order, $id_address){
		$f['id_address'] = $id_address;
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_.'order', $f, 'id_order = '.$id_order)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function GetLastOrder($id_user){
		$sql = "SELECT FROM_UNIXTIME(creation_date, \"%Y-%m-%d\") AS last_order
				FROM "._DB_PREFIX_."order WHERE id_customer = ".$id_user."
				AND id_order_status = 2 ORDER BY id_order DESC LIMIT 1";
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res['last_order'];
	}
}
