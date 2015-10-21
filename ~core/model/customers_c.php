<?php
class Customers extends Users {
	private $usual_fields;
	public function __construct(){
		parent::__construct();
		$this->usual_fields = array("id_user", "cont_person", "phones", "discount", "id_contragent", "id_city",
									"id_delivery", "bonus_card", "bonus_balance", "bonus_discount", "balance");
	}
	// Покупатель по id
	public function SetFieldsById($id, $all = 0){
		global $User;
		$User->SetFieldsById($id, $all);
		$id = mysql_real_escape_string($id);
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM  "._DB_PREFIX_."customer
			WHERE id_user = '".$id."'";
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}else{
			return $this->fields;
		}
	}

	public function SetList($email_klient){
		$sql = "SELECT u.name, u.id_user, cu.cont_person, cu.phones
			FROM "._DB_PREFIX_."user u, "._DB_PREFIX_."customer cu
			WHERE email  LIKE \"%$email_klient%\"
			AND cu.id_user = u.id_user
			ORDER BY name";
		$kl=$this->db->GetArray($sql);
		return $kl;
	}

	//Получение списка избранных товаров
	public function GetListFavorites($id_user){
		$sql = "SELECT f.id_product, p.art, p.name,p.translit , p.img_1,
			p.price_opt, p.price_mopt
			FROM "._DB_PREFIX_."favorites AS f
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON f.id_product = p.id_product
			WHERE f.id_user = '".$id_user."'
			ORDER BY id_favorite";
		$arr = $this->db->GetArray($sql);
		return $arr;
	}

	//Добавление Избранного товара
	public function AddFavorite($id_user, $id_product){
		$f['id_user'] = $id_user;
		$f['id_product'] = $id_product;
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'favorites', $f)){
			$this->db->FailTrans();
			G::DieLoger("SQL error - $sql");
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	//Удаление Избранного товара
	public function DelFavorite($id_user, $id_product){
		$sql = "DELETE FROM "._DB_PREFIX_."favorites
			WHERE id_user = '".$id_user."'
			AND id_product = '".$id_product."'";
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			G::DieLoger("SQL error - $sql");
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	//Получение списка ожидания
	public function GetWaitingList($id_user){
		$sql = "SELECT wl.id_product, p.art, p.name, p.translit , p.img_1,
			p.price_opt, p.price_mopt, p.old_price_opt
			FROM "._DB_PREFIX_."waiting_list AS wl
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON wl.id_product = p.id_product
			WHERE wl.id_user = '".$id_user."'
			ORDER BY id_followprice";
		$arr = $this->db->GetArray($sql);
		return $arr;
	}

	//Добавление в список ожидания
	public function AddInWaitingList($id_user, $id_product){
		$f['id_user'] = $id_user;
		$f['id_product'] = $id_product;
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'waiting_list', $f)){
			$this->db->FailTrans();
			G::DieLoger("SQL error - $sql");
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	//Удаление из списка ожидания
	public function DelFromWaitingList($id_user, $id_product){
		$sql = "DELETE FROM "._DB_PREFIX_."waiting_list
			WHERE id_user = '".$id_user."'
			AND id_product = '".$id_product."'";
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			G::DieLoger("SQL error - $sql");
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function GetCustomersByContragent($id_contragent){
		$sql = "SELECT u.name, u.id_user, cu.cont_person, cu.phones
			FROM "._DB_PREFIX_."user u, "._DB_PREFIX_."customer cu
			WHERE cu.id_contragent = \"$id_contragent\"
			AND cu.id_user = u.id_user
			ORDER BY cont_person";
		$clients=$this->db->GetArray($sql);
		return $clients;
	}

	public function Klient($id_klient){
		$sql = "SELECT name
			FROM "._DB_PREFIX_."user
			WHERE id_user= \"$id_klient\"
			ORDER BY name";
		$kl1=$this->db->GetArray($sql);
		return $kl1;
	}

	public function updateContPerson($cont_person){
		if(!empty($cont_person)){
			$f['cont_person'] = mysql_real_escape_string(trim($cont_person));
			$User = new Users();
			$User->SetUser($_SESSION['member']);
			$user_id = $User->fields['id_user'];
			$f['id_user'] = mysql_real_escape_string(trim($user_id));
			if(!$this->db->Update(_DB_PREFIX_.'customer', $f, "id_user = {$f['id_user']}")){
				echo $this->db->ErrorMsg();
				$this->db->FailTrans();
				return false; //Если не удалось записать в базу
			}
			$this->db->CompleteTrans();
			return true;//Если все ок
		}else{
			return false; //Если имя пустое
		}
	}

	public function updatePhones($phones){
		if(!empty($phones)){
			$f['phones'] = mysql_real_escape_string(trim($phones));
			$User = new Users();
			$User->SetUser($_SESSION['member']);
			$user_id = $User->fields['id_user'];
			$f['id_user'] = mysql_real_escape_string(trim($user_id));
			if(!$this->db->Update(_DB_PREFIX_.'customer', $f, "id_user = {$f['id_user']}")){
				echo $this->db->ErrorMsg();
				$this->db->FailTrans();
				return false; //Если не удалось записать в базу
			}
			$this->db->CompleteTrans();
			return true;//Если все ок
		}else{
			return false; //Если телефон пустой
		}
	}

	public function updateContragentOnRegistration($contragent, $id_customer){
		if(!empty($contragent) && !empty($id_customer)){
			$f['id_contragent'] = mysql_real_escape_string(trim($contragent));
			$f['id_user'] = mysql_real_escape_string(trim($id_customer));
			if(!$this->db->Update(_DB_PREFIX_.'customer', $f, "id_user = {$f['id_user']}")){
				echo $this->db->ErrorMsg();
				$this->db->FailTrans();
				return false; //Если не удалось записать в базу
			}
			$this->db->CompleteTrans();
			return true;//Если все ок
		}else{
			return false; //Если имя пустое
		}
	}

	public function updateContragent($contragent){
		if(!empty($contragent)){
			$f['id_contragent'] = mysql_real_escape_string(trim($contragent));
			$User = new Users();
			$User->SetUser($_SESSION['member']);
			$user_id = $User->fields['id_user'];
			$f['id_user'] = mysql_real_escape_string(trim($user_id));
			if(!$this->db->Update(_DB_PREFIX_.'customer', $f, "id_user = {$f['id_user']}")){
				echo $this->db->ErrorMsg();
				$this->db->FailTrans();
				return false; //Если не удалось записать в базу
			}
			$this->db->CompleteTrans();
			return true;//Если все ок
		}else{
			return false; //Если имя пустое
		}
	}

	public function registerBonus($card, $sex, $learned_from, $birthday, $buy_volume){
		if(!empty($card) && !empty($sex) && !empty($learned_from)){
			$f['bonus_card'] = mysql_real_escape_string(trim($card));
			$f['bonus_balance'] = 20;
			$f['bonus_discount'] = 1;
			$f['sex'] = mysql_real_escape_string(trim($sex));
			$f['learned_from'] = mysql_real_escape_string(trim($learned_from));
			$f['birthday'] = mysql_real_escape_string(trim($birthday));
			$f['buy_volume'] = mysql_real_escape_string(trim($buy_volume));
			$User = new Users();
			$User->SetUser($_SESSION['member']);
			$user_id = $User->fields['id_user'];
			$f['id_user'] = mysql_real_escape_string(trim($user_id));
			if(!$this->db->Update(_DB_PREFIX_.'customer', $f, "id_user = {$f['id_user']}")){
				echo $this->db->ErrorMsg();
				$this->db->FailTrans();
				return false; //Если не удалось записать в базу
			}
			$this->db->CompleteTrans();
			return true;//Если все ок
		}else{
			return false; //Если имя пустое
		}
	}

	public function updateBonus($card){
		if(!empty($card)){
			$f['bonus_card'] = mysql_real_escape_string(trim($card));
			$User = new Users();
			$User->SetUser($_SESSION['member']);
			$user_id = $User->fields['id_user'];
			$f['id_user'] = mysql_real_escape_string(trim($user_id));
			if(!$this->db->Update(_DB_PREFIX_.'customer', $f, "id_user = {$f['id_user']}")){
				echo $this->db->ErrorMsg();
				$this->db->FailTrans();
				return false; //Если не удалось записать в базу
			}
			$this->db->CompleteTrans();
			return true;//Если все ок
		}else{
			return false; //Если имя пустое
		}
	}

	public function updateCity($city){
		if(!empty($city)){
			$f['id_city'] = mysql_real_escape_string(trim($city));
			$User = new Users();
			$User->SetUser($_SESSION['member']);
			$user_id = $User->fields['id_user'];
			$f['id_user'] = mysql_real_escape_string(trim($user_id));
			if(!$this->db->Update(_DB_PREFIX_.'customer', $f, "id_user = {$f['id_user']}")){
				echo $this->db->ErrorMsg();
				$this->db->FailTrans();
				return false; //Если не удалось записать в базу
			}
			$this->db->CompleteTrans();
			return true;//Если все ок
		}else{
			return false; //Если имя пустое
		}
	}

	public function updateDelivery($delivery){
		if(!empty($delivery)){
			$f['id_delivery'] = mysql_real_escape_string(trim($delivery));
			$User = new Users();
			$User->SetUser($_SESSION['member']);
			$user_id = $User->fields['id_user'];
			$f['id_user'] = mysql_real_escape_string(trim($user_id));
			if(!$this->db->Update(_DB_PREFIX_.'customer', $f, "id_user = {$f['id_user']}")){
				echo $this->db->ErrorMsg();
				$this->db->FailTrans();
				return false; //Если не удалось записать в базу
			}
			$this->db->CompleteTrans();
			return true;//Если все ок
		}else{
			return false; //Если имя пустое
		}
	}
	/* Регистрация пользователя
	 *
	 */
	public function RegisterCustomer($arr){
		return $this->AddCustomer($arr);
	}
	/* Добавление
	 *
	 */
	public function AddCustomer($arr){
		$User = new Users();
		$arr['gid'] = _ACL_CUSTOMER_;
		$this->db->StartTrans();
		if(!$id_user = $User->AddUser($arr)){
			$this->db->FailTrans();
			return false;
		}
		$arr['cont_person'] = $arr['phones'] = "";
		$arr['id_contragent'] = $arr['id_city'] = $arr['id_delivery'] = 0;
		$f['id_user'] = $id_user;
		if(isset($arr['discount'])){
			$f['cont_person'] = mysql_real_escape_string(trim($arr['cont_person']));
			$f['phones'] = mysql_real_escape_string(trim($arr['phones']));
			$f['id_contragent'] = mysql_real_escape_string(trim($arr['id_contragent']));
			$f['id_city'] = mysql_real_escape_string(trim($arr['id_city']));
			$f['id_delivery'] = mysql_real_escape_string(trim($arr['id_delivery']));
		}
		if(isset($arr['discount'])){
			$f['discount'] = mysql_real_escape_string(trim($arr['discount']));
		}
		if(!$this->db->Insert(_DB_PREFIX_.'customer', $f)){
			echo $this->db->ErrorMsg();
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function AddContragentCustomer($arr){
		$and['email'] = $arr['email'];
		$User = new Users();
		$User->UsersList(1,$and);
		$id_user = $User->list[0]['id_user'];
		$arr['cont_person'] = $arr['phones'] = "";
		$arr['id_contragent'] = $arr['id_city'] = $arr['id_delivery'] = 0;
		$f['id_user'] = $id_user;
		if(isset($arr['discount']))
			$f['cont_person'] = mysql_real_escape_string(trim($arr['cont_person']));
			$f['phones'] = mysql_real_escape_string(trim($arr['phones']));
			$f['id_contragent'] = mysql_real_escape_string(trim($arr['id_contragent']));
			$f['id_city'] = mysql_real_escape_string(trim($arr['id_city']));
			$f['id_delivery'] = mysql_real_escape_string(trim($arr['id_delivery']));

		if(isset($arr['discount'])){
			$f['discount'] = mysql_real_escape_string(trim($arr['discount']));
		}
		if(!$this->db->Insert(_DB_PREFIX_.'customer', $f)){
			echo $this->db->ErrorMsg();
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	/* Обновление пользователя
	 *
	 */
	public function UpdateCustomer($arr){
		global $User;
		$arr['gid'] = $User->fields['gid'];
		if(!$User->UpdateUser($arr)){
			$this->db->FailTrans();
			return false;
		}
		$id_user = $this->db->GetInsId();
		unset($f);
		$f['id_user'] = mysql_real_escape_string(trim($arr['id_user']));
		$f['address_ur'] = mysql_real_escape_string($arr['address_ur']);
		if(isset($arr['discount'])){
			$discount = str_replace(",",".",mysql_real_escape_string(trim($arr['discount'])));
			$f['discount'] = (1-$discount)*100;
		}
		if(!$this->db->Update(_DB_PREFIX_.'customer', $f, "id_user = {$f['id_user']}")){
			echo $this->db->ErrorMsg();
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	// Удаление
	public function DelCustomer($id){
		$sql = "DELETE FROM "._DB_PREFIX_."customer WHERE `id_user` =  $id";
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		$sql = "DELETE FROM "._DB_PREFIX_."user WHERE id_user=$id";
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}

	public function GetOrders($order_by = 'o.target_date desc'){
		$id_customer = $this->fields['id_user'];
		/*$sql = "SELECT o.target_date, o.id_order, o.skey, o.id_order_status, SUM(osp.opt_sum+osp.mopt_sum) AS sum,
				o.id_pretense_status, o.id_return_status, o.sum_discount, o.discount
				FROM "._DB_PREFIX_."order o, "._DB_PREFIX_."osp osp
				WHERE o.id_order = osp.id_order
				AND o.id_customer=$id_customer
				AND (o.id_order_status = 1 OR o.id_order_status = 3)
				GROUP BY id_order
				ORDER BY $order_by";*/
		$sql = "SELECT o.creation_date,o.target_date, o.id_order,
			o.id_order_status, o.note_customer, o.skey,
			SUM(osp.opt_sum+osp.mopt_sum) AS sum, o.id_pretense_status,
			o.id_return_status, o.note, o.sum_discount, o.discount,
			c.name_c as contragent, c.site as contragent_site
			FROM "._DB_PREFIX_."order AS o
			LEFT JOIN "._DB_PREFIX_."osp AS osp
			ON o.id_order = osp.id_order
			LEFT JOIN "._DB_PREFIX_."user AS u
			ON o.id_customer = u.id_user
			LEFT JOIN "._DB_PREFIX_."contragent AS c
			ON o.id_contragent = c.id_user
			WHERE o.id_customer = '".$id_customer."'
			AND o.visibility = 1
			GROUP BY o.id_order
			ORDER BY ".$order_by;
		$arr = $this->db->GetArray($sql);
		//$date = time()+3600*24;
		//$date2 = time()-3600*24*60;//echo time()-3600*24*10;
		//$sql = "SELECT o.target_date, o.id_order, o.id_order_status, SUM(osp.opt_sum+osp.mopt_sum) AS sum,
		//	o.id_pretense_status, o.id_return_status, o.sum_discount, o.discount
		//	FROM "._DB_PREFIX_."order o, "._DB_PREFIX_."osp osp
		//	WHERE o.id_order = osp.id_order
		//	AND o.id_customer=$id_customer
		//	AND o.target_date>\"$date2\"
		//	/*AND o.target_date<\"$date\"*/
		//	AND o.id_order_status = 2
		//	GROUP BY id_order
		//	ORDER BY $order_by";
		/*$sql = "SELECT o.creation_date,o.target_date, o.id_order, o.id_order_status, o.skey, SUM(osp.opt_sum+osp.mopt_sum) AS sum,
			o.id_pretense_status, o.id_return_status, o.note,   o.sum_discount, o.discount, c.name_c as contragent, c.site as contragent_site
			FROM "._DB_PREFIX_."order o, "._DB_PREFIX_."osp osp, "._DB_PREFIX_."user u, "._DB_PREFIX_."contragent c
			WHERE o.id_order = osp.id_order
			AND o.target_date>\"$date2\"
			AND o.target_date<\"$date\"
			AND o.id_customer=$id_customer
			AND c.id_user = o.id_contragent
			AND o.id_order_status IN (2)
			AND o.id_customer = u.id_user
			GROUP BY id_order
			ORDER BY $order_by";*/
		//$arr2 = $this->db->GetArray($sql);
		//if ($order_by == "o.id_order_status asc")
		//	$arr = array_merge($arr2, $arr);
		//else
		//	$arr = array_merge($arr, $arr2);
		return $arr;
	}

	public function GetPromoOrders(){
		$id_customer = $this->fields['id_user'];
		$sql = "SELECT o.creation_date, o.target_date, o.id_order,
			o.id_order_status, o.note_customer, o.skey,
			SUM(osp.opt_sum+osp.mopt_sum) AS sum, COUNT(osp.id_product) AS qty, o.id_pretense_status,
			o.id_return_status, o.note, o.sum_discount, o.discount, o.descr
			FROM "._DB_PREFIX_."order AS o, "._DB_PREFIX_."osp AS osp, "._DB_PREFIX_."user u
			WHERE o.id_order = osp.id_order
			AND o.id_customer = $id_customer
			AND o.id_customer = u.id_user
			AND o.visibility = 1
			GROUP BY o.id_order
			ORDER BY o.creation_date DESC";
		$arr = $this->db->GetArray($sql);
		return $arr;
	}

	public function GetOrders_diler($order_by='o.creation_date desc'){
		$id_customer = $_SESSION['member']['id_user'];
		$sql = "SELECT o.creation_date, o.target_date, o.id_klient,
			o.id_order, o.id_order_status, o.skey, o.sum_discount,
			SUM(osp.opt_sum+osp.mopt_sum) AS sum, o.discount,
			o.id_return_status, o.note, o.note2, o.id_pretense_status,
			c.name_c as contragent, c.site as contragent_site,
			(SELECT name
			FROM "._DB_PREFIX_."user u, "._DB_PREFIX_."order o
			WHERE o.id_klient = u.id_user
			AND osp.id_order = o.id_order) AS name_klient
			FROM "._DB_PREFIX_."order o, "._DB_PREFIX_."osp osp, "._DB_PREFIX_."user u, "._DB_PREFIX_."contragent c
			WHERE o.id_order = osp.id_order
			AND o.id_customer = $id_customer
			AND c.id_user = o.id_contragent
			AND o.id_order_status <> 7
			AND o.id_customer = u.id_user
			GROUP BY id_order
			ORDER BY $order_by";
		$arr = $this->db->GetArray($sql);
		return $arr;
	}

	public function GetOrders_m_diler($order_by='o.target_date desc'){
		$date2 = time()-3600*24*60;
		$sql = "SELECT  o.target_date, o.id_klient,  o.id_order,
			o.id_order_status,  SUM(osp.opt_sum+osp.mopt_sum) AS sum,
			o.note, o.note2,  o.sum_discount, o.discount,
			(SELECT name
			FROM "._DB_PREFIX_."user u, "._DB_PREFIX_."order o
			WHERE u.id_user = o.id_klient
			AND osp.id_order = o.id_order ) AS name_klient,
			(SELECT email
			FROM "._DB_PREFIX_."user u, "._DB_PREFIX_."order o
			WHERE u.id_user = o.id_klient
			AND osp.id_order = o.id_order ) AS email_klient
			FROM "._DB_PREFIX_."order o, "._DB_PREFIX_."osp osp
			WHERE o.id_order = osp.id_order
			AND o.id_delivery= 2
			AND o.target_date>\"$date2\"
			AND o.id_order_status <> 3
			AND o.id_order_status <> 4
			AND o.id_order_status <> 5
			AND o.id_order_status <> 7
			GROUP BY id_order
			ORDER BY id_order desc";
		$arr = $this->db->GetArray($sql);
		return $arr;
	}

	public function GetOrdersTerminal($order_by = 'o.creation_date desc'){
		$id_customer = $_SESSION['member']['id_user'];
		// $id_customer = $GLOBALS['CONFIG']['demo_user'];
		$date = time()-3600*24*15;
		$sql = "SELECT o.creation_date, o.target_date,
			o.id_order, o.skey, o.id_order_status,
			SUM(osp.opt_sum+osp.mopt_sum) AS sum,
			o.sum_discount, c.name_c as contragent,
			o.discount, c.site as contragent_site,
			o.phones, o.descr, p.art
			FROM "._DB_PREFIX_."order AS o
			LEFT JOIN "._DB_PREFIX_."osp AS osp
				ON osp.id_order = o.id_order
			LEFT JOIN "._DB_PREFIX_."user AS u
				ON u.id_user = o.id_customer
			LEFT JOIN "._DB_PREFIX_."contragent AS c
				ON c.id_user = o.id_contragent
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON p.id_product = osp.id_product
			WHERE o.id_customer = $id_customer
			AND o.creation_date > '".$date."'
			AND o.id_order_status IN (1,6)
			GROUP BY id_order
			ORDER BY $order_by";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		return $arr;
	}
	public function GetOrders_demo($order_by = 'o.creation_date desc'){
		$id_customer = $GLOBALS['CONFIG']['demo_user'];
		$date = time()+3600*24;
		$date2 = time()-3600*24*30;
		$sql = "SELECT o.creation_date, o.target_date, o.id_order,
			o.id_order_status, o.skey, c.site as contragent_site,
			o.sum_discount, o.discount, c.name_c as contragent,
			SUM(osp.opt_sum+osp.mopt_sum) AS sum
			FROM "._DB_PREFIX_."order AS o
			LEFT JOIN "._DB_PREFIX_."osp AS osp
				ON o.id_order = osp.id_order
			LEFT JOIN "._DB_PREFIX_."user AS u
				ON o.id_customer = u.id_user
			LEFT JOIN "._DB_PREFIX_."contragent AS c
				ON c.id_user = o.id_contragent
			WHERE o.creation_date > '".$date2."'
			AND o.id_order_status IN (1, 2, 4, 5, 6)
			GROUP BY o.id_order
			ORDER BY ".$order_by;
		$arr = $this->db->GetArray($sql);
		return $arr;
	}

	public function GetOrders_export($order_by){
		$date = mysql_real_escape_string($_POST['date3']);
		list($d,$m,$y) = explode(".", trim($date));
		$date = mktime(0, 0, 0, $m , $d, $y);
		$date = $date+3600*24*2;
		$sql = "SELECT o.target_date, o.creation_date, o.id_order, o.id_klient,
			o.id_order_status, o.skey, SUM(osp.opt_sum+osp.mopt_sum) AS sum,
			o.sum_discount, o.discount, c.name_c as contragent, c.site as contragent_site,
			o.phones, o.cont_person, o.id_delivery,  o.id_parking, o.id_city,
			o.id_delivery_service, o.descr, o.id_customer, o.note, o.otpusk_prices_sum,
				(SELECT email
				FROM "._DB_PREFIX_."user u, "._DB_PREFIX_."customer cu
				WHERE cu.id_user = u.id_user
				AND cu.id_user = o.id_customer) AS customer_email,
				(SELECT name
				FROM "._DB_PREFIX_."delivery del
				WHERE del.id_delivery = o.id_delivery ) AS customer_delivery,
				(SELECT name
				FROM "._DB_PREFIX_."delivery_service de
				WHERE de.id_delivery_service = o.id_delivery_service ) AS delivery
			FROM "._DB_PREFIX_."order o, "._DB_PREFIX_."osp osp, "._DB_PREFIX_."user u, "._DB_PREFIX_."contragent c
			WHERE o.id_order = osp.id_order
			AND o.target_date>=\"$date\"
			AND c.id_user = o.id_contragent
			AND o.id_order_status IN (1,2,6)
			AND o.id_customer = u.id_user
			GROUP BY id_order LIMIT 1000";
		$arr = $this->db->GetArray($sql);
		return $arr;
	}

	public function GetCustomer_export($date4){
		$date = mysql_real_escape_string($_POST['date4']);
		list($d,$m,$y) = explode(".", trim($date));
		$date = mktime(0, 0, 0, $m , $d, $y);
		$sql = "SELECT u.id_user, u.name, u.email, u.date_add,
			cu.cont_person, cu.phones
			FROM "._DB_PREFIX_."user u, "._DB_PREFIX_."customer cu
			WHERE u.id_user=cu.id_user
			AND u.date_add>=\"$date\"
			LIMIT 1000";
		$arr = $this->db->GetArray($sql);
		return $arr;
	}

	public function GetTovar_export($order2){
		$order = mysql_real_escape_string($_POST['order2']);
		$sql = "SELECT os.id_order, os.id_zapis, p.art, os.opt_qty, p.price_opt,
			p.price_mopt, os.mopt_qty, os.id_supplier, os.id_supplier_mopt,
			os.site_price_opt, os.site_price_mopt, os.price_opt_otpusk, os.price_mopt_otpusk,
			os.contragent_qty, os.contragent_mqty, o.discount
			FROM "._DB_PREFIX_."osp os, "._DB_PREFIX_."product p,  "._DB_PREFIX_."order o
			WHERE os.id_product=p.id_product
			AND os.id_order>=\"$order\"
			AND  os.id_order=o.id_order
			AND  o.id_order_status!=3
			AND  o.id_order_status!=7
			LIMIT 10000";
		$arr = $this->db->GetArray($sql);
		return $arr;
	}

	public function GetKatalog_export($order3){
		$order = mysql_real_escape_string($_POST['order3']);
		$sql = "SELECT p.id_product, p.art as art_tovar, p.name as name_tovar,
			p.descr, p.price_opt, p.price_mopt, p.inbox_qty, p.min_mopt_qty,
			p.qty_control, p.units, ca.name as name_katalog, ca.art as art_katalog
			FROM "._DB_PREFIX_."product p, "._DB_PREFIX_."category ca, "._DB_PREFIX_."cat_prod cat
			WHERE p.id_product = cat.id_product
			AND ca.id_category = cat.id_category
			AND p.art > $order
			GROUP BY p.art
			ORDER BY p.art ASC
			LIMIT 3000";
		$arr = $this->db->GetArray($sql);
		return $arr;
	}

	public function GetSupplier_export($date5){
		$date = mysql_real_escape_string($_POST['date5']);
		list($d,$m,$y) = explode(".", trim($date));
		$date = mktime(0, 0, 0, $m , $d, $y);
		$sql = "SELECT su.id_user, su.article, su.phones,
			su.place, u.name, u.email, u.date_add
			FROM "._DB_PREFIX_."supplier su, "._DB_PREFIX_."user u
			WHERE su.id_user = u.id_user
			AND u.date_add>=\"$date\"
			LIMIT 1000";
		$arr = $this->db->GetArray($sql);
		return $arr;
	}

	public function SaveInterviewResults($arr){
		$f['email'] = mysql_real_escape_string(trim($arr['email']));
		$f['name'] = mysql_real_escape_string(trim($arr['name']));
		$f['phone'] = mysql_real_escape_string(trim($arr['phone']));
		$f['city'] = mysql_real_escape_string(trim($arr['city']));
		$f['sex'] = mysql_real_escape_string(trim($arr['sex']));
		$f['operator_quality'] = mysql_real_escape_string(trim($arr['operator_quality']));
		$f['site_quality'] = mysql_real_escape_string(trim($arr['site_quality']));
		$f['owned_shop_type'] = mysql_real_escape_string(trim($arr['owned_shop_type']));
		$f['owned_shop_type'] = mysql_real_escape_string(trim($arr['owned_shop_type']));
		$f['buy_reason'] = mysql_real_escape_string(trim($arr['buy_reason']));
		$f['buy_frequency'] = mysql_real_escape_string(trim($arr['buy_frequency']));
		$f['interested_in'] = mysql_real_escape_string(trim($arr['interested_in']));
		$f['categories'] = mysql_real_escape_string(trim($arr['categories']));
		$f['recomendations'] = mysql_real_escape_string(trim($arr['recomendations']));
		if(!$this->db->Insert(_DB_PREFIX_.'interview_results', $f)){
			echo $this->db->ErrorMsg();
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

}?>