<?php
class Users {
	public $db;
	public $fields;
	private $usual_fields;
	private $db_table = _DB_PREFIX_.'user';
	private $db_fields;
	public $list;
	/** Конструктор
	 * @return
	 */
	public function __construct (){
		$this->db =& $GLOBALS['db'];
		$this->usual_fields = [
			'id_user',
			'name',
			'passwd',
			'email',
			'phone',
			'phones',
			'descr',
			'gid',
			'active',
			'date_add',
			'last_login_date',
			'pwdchkey',
			'news',
			'promo_code',
			'promo_mail',
			'agent',
			'agent_acception_date',
			'dealer'
		];
		$this->db_fields = [
			'name',
			'passwd',
			'email',
			'phone',
			'descr',
			'gid',
			'active',
			'date_add',
			'last_login_date',
			'pwdchkey',
			'news',
			'promo_code',
			'promo_mail',
			'agent',
			'agent_acception_date',
			'dealer',
		];
	}

	// Создание нового пользователя
	public function Create($data){
		foreach($this->db_fields as $field){
			switch ($field) {
				case 'passwd':
					$f[$field] = md5($data[$field]);
					break;
				default:
					if(isset($data[$field]) && $data[$field]){
						$f[$field] = $data[$field];
					}
					break;
			}
		}
		$this->db->StartTrans();
		if(!$this->db->Insert_user($this->db_table, $f)){
			$this->db->FailTrans();
			return false;
		}
		$id_user = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id_user;
	}

	// Получаем данные о пользователе
	public function Read($id_user){
		$sql = 'SELECT *
			FROM '.$this->db_table.'
			WHERE id_user = '.$id_user;
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res;
	}

	// Изменение данных пользователя
	public function Update($data){
		foreach($this->db_fields as $field){
			switch ($field) {
				case 'passwd':
					if($data[$field]){
						$f[$field] = md5($data[$field]);
					}
					break;
				default:
					if(isset($data[$field]) && $data[$field]){
						$f[$field] = $data[$field];
					}
					break;
			}
		}
		$this->db->StartTrans();
		if(!$this->db->Update($this->db_table, $f, "id_user = ".$data['id_user'])){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	// Удаление пользователя
	public function Delete($id_user){
		$this->db->StartTrans();
		if(!$this->db->DeleteRowFrom($this->db_table, 'id_user', $id_user)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	// Добавить пользователя
	public function AddUser($arr){
		if(isset($arr['name'])){
			$f['name'] = trim($arr['name']);
		}
		if(isset($arr['email'])){
			$f['email'] = trim($arr['email']);
		}
		if(isset($arr['passwd'])){
			$f['passwd'] = md5(trim($arr['passwd']));
		}
		if(isset($arr['gid'])){
			$f['gid'] = trim($arr['gid']);
		}
		if(isset($arr['descr'])){
			$f['descr'] = trim($arr['descr']);
		}
		if(isset($arr['phone'])){
			$f['phone'] = trim($arr['phone']);
		}
		// Функционал промо-кода поставщика для ограничения вывода товаров для клиента (клиент поставщика)
		//  if(isset($arr['promo_code']) && $arr['promo_code'] != ''){
		// 	$arr['promo_code'] = trim($arr['promo_code']);
		// 	$Suppliers = new Suppliers();
		// 	if($Suppliers->CheckCodeUniqueness($arr['promo_code']) === false){
		// 		$f['promo_code'] = $arr['promo_code'];
		// 	}
		// }
        if(isset($arr['news'])){
        	$f['news'] = trim($arr['news']);
        }
		$f['active'] = 1;
		if(isset($arr['active']) && $arr['active'] == "on"){
			$f['active'] = 0;
		}
		$this->db->StartTrans();
		if(!$this->db->Insert_user(_DB_PREFIX_.'user', $f)){
			$this->db->errno = $this->db->ErrorMsg('Не удалось создать нового пользователя в таб. user.');
			$this->db->FailTrans();
			return false;
		}
		$id_user = $this->db->GetLastId();
		$this->db->CompleteTrans();
		if($f['gid'] == _ACL_CUSTOMER_){
			if(isset($arr['email'])){
				$mailer = new Mailer();
				$mailer->SendRegisterToCustomers(array('email' => trim($arr['email']), 'name' => trim($arr['name']), 'passwd' => trim($arr['passwd'])));
			}elseif($arr['phone'] && $arr['email'] = null){
				$Gateway = new APISMS($GLOBALS['CONFIG']['sms_key_private'], $GLOBALS['CONFIG']['sms_key_public'], 'http://atompark.com/api/sms/', false);
				$res = $Gateway->execCommad(
					'sendSMS',
					array(
						'sender' => $GLOBALS['CONFIG']['invoice_logo_text'],
						'text' => trim($_GET['text']),
						'phone' => $_GET['reciever'],
						'datetime' => null,
						'sms_lifetime' => 0
					)
				);
			}
		}
		return $id_user;
	}
	// public function CheckUser($arr){
	// 	$f['email'] = trim($arr['email']);
	// 	$f['passwd'] = trim($arr['passwd']);
	// 	$sql = "SELECT id_user, email, gid, promo_code, name
	// 		FROM "._DB_PREFIX_."user
	// 		WHERE (email = '".$f['email']."'
	// 		OR email = '".$f['email']."@x-torg.com')
	// 		AND passwd = '".md5($f['passwd'])."'
	// 		AND active = 1";
	// 	if($this->fields = $this->db->GetOneRowArray($sql)){
	// 		return true;
	// 	}else{
	// 		return false;
	// 	}
	// }

	public function CheckUser($arr){
		$f['passwd'] = trim($arr['passwd']);
		if(isset($arr['id_user'])){
			$where = " id_user = ".$arr['id_user'];
		}else{
			$f['email'] = trim($arr['email']);
			$where = "(email = '".$f['email']."'
			OR email = '".$f['email']."@x-torg.com'
			OR phone = '".$f['email']."')";
		}
		$sql = "SELECT id_user, email, gid, promo_code, name, phone, agent
			FROM "._DB_PREFIX_."user
			WHERE ".$where."
			AND passwd = '".md5($f['passwd'])."'
			AND active = 1";
		if(!$this->fields = $this->db->GetOneRowArray($sql)){
			return false;
		}
		$this->SetUserAdditionalInfo($this->fields['id_user']);
		return true;
	}

	public function CheckUserNoPass($data){
		$data = trim($data);
		$sql = "SELECT u.id_user, u.email, u.gid, u.promo_code, u.active
			FROM "._DB_PREFIX_."user AS u
			WHERE (u.email = '".$data."' OR u.phone = '".$data."')
			AND u.active = 1";
		if(!$this->fields = $this->db->GetOneRowArray($sql)){
			return false;
		}
		$this->SetUserAdditionalInfo($this->fields['id_user']);
		return $this->fields;
	}
	public function SetUserAdditionalInfo($id_user){
		$sql = "SELECT id_user, email, gid, promo_code, name, phone, agent
			FROM "._DB_PREFIX_."user
			WHERE id_user = $id_user";
		$this->fields = $this->db->GetOneRowArray($sql);
		// получаем список избранных товаров
		$sql = "SELECT f.id_product
			FROM "._DB_PREFIX_."favorites AS f
			WHERE f.id_user = ".$id_user;
		$this->fields['favorites'] = $this->db->GetArray($sql);
		foreach($this->fields['favorites'] as $key => $value){
			$this->fields['favorites'][$key] = $value['id_product'];
		}
		// получаем лист ожидания
		$sql = "SELECT wl.id_product
			FROM "._DB_PREFIX_."waiting_list AS wl
			WHERE wl.id_user = ".$id_user;
		$this->fields['waiting_list'] = $this->db->GetArray($sql);
		foreach($this->fields['waiting_list'] as $key => $value){
			$this->fields['waiting_list'][$key] = $value['id_product'];
		}
		// получаем данные о личном менеджере
		if($this->fields['gid'] == 4){
			$sql = "SELECT ct.*
				FROM "._DB_PREFIX_."contragent AS ct
				WHERE ct.id_user = ".$id_user;
		}else{
			$sql = "SELECT ct.*
				FROM "._DB_PREFIX_."contragent AS ct
				LEFT JOIN "._DB_PREFIX_."customer AS c
					ON c.id_contragent = ct.id_user
				WHERE c.id_user = ".$id_user;
		}
		$this->fields['contragent'] = $this->db->GetOneRowArray($sql);
		$this->fields['avatar'] = G::GetUserAvatarUrl($id_user);
		// получаем список товаров, которые уже были в заказе
		$sql = "SELECT DISTINCT osp.id_product, osp.opt_qty+osp.mopt_qty AS count
			FROM "._DB_PREFIX_."order AS o
			LEFT JOIN "._DB_PREFIX_."osp AS osp
				ON osp.id_order = o.id_order
			WHERE o.id_customer = ".$id_user."
			HAVING (count > 0)";
		$this->fields['ordered_prod'] = $this->db->GetArray($sql);
		foreach($this->fields['ordered_prod'] as $key => $value){
			$this->fields['ordered_prod'][$key] = $value['id_product'];
		}
		$md = md5($this->fields['id_user']);
		$this->fields['personal_color'] = substr($md, strlen($md)-6);
		if($this->fields['gid'] == _ACL_CUSTOMER_){
			$sql = "SELECT * FROM "._DB_PREFIX_."customer AS c
				WHERE c.id_user = $id_user";
				$res = $this->db->GetOneRowArray($sql);
			$this->fields['first_name'] = $res['first_name'];
			$this->fields['middle_name'] = $res['middle_name'];
			$this->fields['last_name'] = $res['last_name'];
		}
		if($this->fields['gid'] !== _ACL_CONTRAGENT_){
			if(!empty($this->fields['last_name']) && !empty($this->fields['first_name']) && !empty($this->fields['middle_name'])){
				$this->fields['name'] = $this->fields['last_name'].' '.$this->fields['first_name'].' '.$this->fields['middle_name'];
			}elseif(!isset($this->fields['name'])){
				$this->fields['name'] = isset($this->fields['email']) && !empty($this->fields['email'])?substr($this->fields['email'], 0, strpos($this->fields['email'], "@")):'';
			}
		}
		return true;
	}

	public function GetFields(){
		return $this->fields;
	}

	public function SetUser($arr){
		if(empty($arr)){
			return false;
		}
		return $this->SetFieldsById($arr['id_user'], 1);
	}

	// Пользователь по id
	public function SetFieldsById($id, $all=0){
		$active = " AND active = 1";
		if($all == 1){
			$active = '';
		}
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."user
			WHERE id_user = ".$id.
			$active;
		if(!$this->fields = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return true;
	}

	// Дополнительная информация по поставщику
//	public function GetMoreInfoSupplier($id, $search_field){
//		global $db;
//		$sql = "SELECT ".$search_field."
//			FROM "._DB_PREFIX_."supplier
//			WHERE id_user = ".$id;
//		$res = $db->GetOneRowArray($sql);
//		if(!$res){
//			return false;
//		}
//		return $res[$search_field];
//	}

	// Список пользователей (0 - только видимые. 1 - все, и видимые и невидимые)
	public function UsersList($param=0, $and=false, $limit = ""){
		if($limit != ""){
			$limit = " limit $limit";
		}
		if($param == 0){
			$and['active'] = "1";
		}
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."user
			".$this->db->GetWhere($and)."
			ORDER BY gid, name, id_user DESC
			$limit";
		$this->list = $this->db->GetArray($sql);
//		foreach($this->list as &$v) {
//			if($v['gid'] == 3){
//				$v['usd'] = $this->GetMoreInfoSupplier($v['id_user'], 'currency_rate');
//				$v['next_update_date'] = $this->GetMoreInfoSupplier($v['id_user'], 'next_update_date');
//			}
//		}
		if(!$this->list){
			return false;
		}
		return true;
	}

	public function GetGroups(){
		foreach($GLOBALS['ACL_PERMS']['groups'] as $i=>$g){
			$groups[$i]['gid'] = $i;
			$groups[$i]['name'] = $g['name'];
			$groups[$i]['caption'] = $g['caption'];
		}
		return $groups;
	}

	// Обновление пользователя
	public function UpdateUser($arr){
		$f['id_user'] = trim($arr['id_user']);
		if(isset($arr['name']) && $arr['name'] != ''){
			$f['name'] = trim($arr['name']);
		}
		if(isset($arr['email']) ){
			$f['email'] = ($arr['email'] !='')?trim($arr['email']): NULL;
		}
		if(isset($arr['phone']) && $arr['phone'] != '') {
			//Проверяем, существует ли такой телефон в таблице User
			if($this->CheckPhoneUniqueness($arr['phone'], $arr['id_user'])){
				$f['phone'] = trim($arr['phone']);
			}
		}
		if(isset($arr['passwd']) && $arr['passwd'] != ''){
			$f['passwd'] = md5(trim($arr['passwd']));
		}
		if(isset($arr['gid']) && isset($arr['passwd']) && $arr['passwd'] != ''){
			$f['gid'] = trim($arr['gid']);
		}
		if(isset($arr['descr'])){
			$f['descr'] = trim($arr['descr']);
		}
		if(isset($arr['news'])){
			$f['news'] = $arr['news'];
		}else{
			$f['news'] = 0;
		}
		if(isset($arr['active'])){
			$f['active'] = $arr['active'];
		}
		if(isset($arr['agent'])){
			$f['agent'] = $arr['agent'];
		}
		$this->db->StartTrans();
		if(isset($arr['promo_code']) && $arr['promo_code'] != ''){
			$arr['promo_code'] = trim($arr['promo_code']);
			$supplier = new Suppliers();
			if($supplier->CheckCodeUniqueness($arr['promo_code']) === false){
				$f['promo_code'] = $arr['promo_code'];
			}
		}
		if(!$this->db->Update(_DB_PREFIX_."user", $f, "id_user = ".$f['id_user'])){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		$this->SetUserAdditionalInfo($f['id_user']);
		G::Login($this->fields);
		return true;
	}

	public function IsUserEmail($email){
		$sql = "SELECT email, passwd
				FROM "._DB_PREFIX_."user
				WHERE email = \"$email\"";
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}else{
			return true;
		}
	}

	public function SetPwdChangeKey($email){
		$pwdchkey = substr(md5(time()), 0, 8);
		$sql = "UPDATE "._DB_PREFIX_."user
			SET pwdchkey = '".$pwdchkey."'
			WHERE email = '".$email."'";
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return $pwdchkey;
	}

	public function CheckPwdChangeKey($key){
		$key = trim($key);
		$sql = "SELECT email
			FROM "._DB_PREFIX_."user
			WHERE pwdchkey = \"$key\"";
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		$email = $this->fields['email'];
		$sql = "UPDATE "._DB_PREFIX_."user
			SET pwdchkey = NULL
			WHERE email = \"$email\"";
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return $email;
	}

	public function CheckPwdChangeKey1($key){
		$key = trim($key);
        $keu_reg = 0;
		$sql = "SELECT id_user
			FROM "._DB_PREFIX_."user
			WHERE md5(id_user) = \"$key\"";
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		$id_user1 = $this->fields['id_user'];
		$sql = "UPDATE "._DB_PREFIX_."user
			SET news = '".$keu_reg."'
			WHERE id_user = '".$id_user1."'";
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return $id_user1;
	}

	public function LastLoginRemember($id_user){
		$sql = "UPDATE "._DB_PREFIX_."user
			SET last_login_date = CURRENT_DATE()
			WHERE id_user = ".$id_user;
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
	}

	public function ChangePwd($email){
		$newpwd = substr(md5(time()), 0, 8);
		$sql = "UPDATE "._DB_PREFIX_."user
				SET passwd = \"".md5($newpwd)."\"
				WHERE email=\"$email\"";
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return $newpwd;
	}

	// Удаление
	public function DelUser($id){
		$sql = "DELETE FROM "._DB_PREFIX_."user WHERE `id_user` =  $id";
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function GetUsersByPromoSupplier($id_supplier){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."promo_code AS pc
			WHERE pc.id_supplier = ".$id_supplier;
		$res = $this->db->GetArray($sql);
		foreach($res as &$r){
			$sql = "SELECT u.id_user, u.name, u.email, u.promo_code, c.cont_person, c.phone
				FROM "._DB_PREFIX_."user AS u
				LEFT JOIN "._DB_PREFIX_."customer AS c
					ON c.id_user = u.id_user
				LEFT JOIN "._DB_PREFIX_."promo_code AS pc
					ON pc.code = u.promo_code
				WHERE pc.id = ".$r['id']."
				ORDER BY c.cont_person";
			$arr = $this->db->GetArray($sql);
			if(!empty($arr)){
				$r['users'] = $arr;
			}
		}
		if(!$res){
			return false;
		}
		return $res;
	}

	public function GetRegisteredUsersListByDate($date){
		$sql = "SELECT '".$date."' AS date, IFNULL((SELECT COUNT(c.id_user)
			FROM "._DB_PREFIX_."customer AS c
			LEFT JOIN "._DB_PREFIX_."user AS u
				ON c.id_user = u.id_user
			WHERE DATE_FORMAT(from_unixtime(date_add),'%d-%m-%Y') = '".$date."'
			GROUP BY DATE_FORMAT(from_unixtime(date_add),'%d-%m-%Y')), 0) AS count";
		if(!$arr = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $arr;
	}

	//Выборка зарегестрированных пользователей на протяжении недели
	public function GetRegisteredUsersListByWeek($date_start, $date_end){
		$sql = "SELECT '".$date_start."' AS date_start,
			'".$date_end."' AS date_end,
			IFNULL((SELECT COUNT(c.id_user)
			FROM "._DB_PREFIX_."customer AS c
			LEFT JOIN "._DB_PREFIX_."user AS u
				ON c.id_user = u.id_user
			WHERE u.date_add > ".strtotime($date_start)."
			AND u.date_add <= ".strtotime($date_end)."), 0) AS count";
		if(!$arr = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $arr;
	}
	/**
	 * Проверка уникальности email
	 * Если введенного email нет в базе данных, возвращает true, иначе false
	 * @param string $email номер телефона
	 */
	public function CheckEmailUniqueness($email, $id_user = false){
		$sql = "SELECT id_user, COUNT(*) AS count
			FROM "._DB_PREFIX_."user
			WHERE email = '".$email."'";
		if($id_user !== false) $sql .= " AND id_user <> ".$id_user;
		$res = $this->db->GetOneRowArray($sql);
		if($res['count'] > 0){
			return false;
		}
		return true;
	}
	/**
	 * Проверка уникальности номера телефона
	 * Если введенного номера телефона нет в базе данных, возвращает true, иначе false
	 * @param string $phone номер телефона
	 */
	public function CheckPhoneUniqueness($phone, $id_user = false){
		$sql = "SELECT id_user, COUNT(*) AS count
			FROM "._DB_PREFIX_."user
			WHERE phone = '".$phone."'";
		if($id_user !== false) $sql .= " AND id_user <> ".$id_user;
		$res = $this->db->GetOneRowArray($sql);
		if($res['count'] > 0){
			return false;
		}
		return true;
	}

	public function SetVerificationCode($id_user, $method, $address){
		$f['token'] = $id_user;
		$f['verification_code'] = G::GenerateVerificationCode();
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'verification_code', $f)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();

		if($method == 'email'){
			// Функция отправки сообщения на email
			$Mailer = new Mailer();
			$Mailer->SendCustomEmail($address, 'Код подтверждения. '.$_SERVER['SERVER_NAME'], 'Код подтверждения - '.$f['verification_code'].'. Код действителен в течении 24 часов.');
		}elseif($method == 'sms'){
			$Gateway = new APISMS($GLOBALS['CONFIG']['sms_key_private'], $GLOBALS['CONFIG']['sms_key_public'], 'http://atompark.com/api/sms/', false);
			if($address != ''){
				$data = array(
					'sender' => $GLOBALS['CONFIG']['invoice_logo_text'],
					'text' => 'Код подтверждения - '.$f['verification_code'],
					'phone' => $address, //'38'.
					'datetime' => null,
					'sms_lifetime' => 0
				);
				$res = $Gateway->execCommad('sendSMS', $data);
			}
		}
		return true;
	}

	public function GetVerificationCode($id_user, $verification_code){
		$f[] = 'token = '.$id_user;
		$f[] = 'verification_code = '.$verification_code;
		$sql = "SELECT COUNT(*) AS count
 				FROM "._DB_PREFIX_."verification_code
 				WHERE token = ".$id_user."
 				AND verification_code = ".$verification_code."
 				AND end_date >= CURTIME()";
		$res = $this->db->GetOneRowArray($sql);
		if($res['count'] > 0){
			$this->db->StartTrans();
			if(!$this->db->DeleteRowsFrom(_DB_PREFIX_.'verification_code', $f)){
				$this->db->FailTrans();
				return false;
			}
			$this->db->CompleteTrans();
			return true;
		}
		return false;
	}

	//Отправка смс с паролем при оформлении заказа по номеру телефона
	public function SendPassword($passwd, $phone){
		$Gateway = new APISMS($GLOBALS['CONFIG']['sms_key_private'], $GLOBALS['CONFIG']['sms_key_public'], 'http://atompark.com/api/sms/', false);
		if($phone != ''){
			$data = array(
				'sender' => $GLOBALS['CONFIG']['invoice_logo_text'],
				'text' => "xt.ua \nВаш временный пароль - ".$passwd,
				'phone' => $phone, //'38'.
				'datetime' => null,
				'sms_lifetime' => 0
			);
			$Gateway->execCommad('sendSMS', $data);
		}
	}

	public function CheckCurrentPasswd($passwd, $id_user){
		$sql = "SELECT count(*) AS count
				FROM "._DB_PREFIX_."user
				WHERE id_user = ".$id_user."
				AND passwd = '".md5(trim($passwd))."'";
		$res = $this->db->GetOneRowArray($sql);
		if($res['count']<>1){
			return false;
		}
		return true;
	}

	// Удаляем телефоны у юзеров
	public function delDoublePhone($phone){
		$sql = "UPDATE "._DB_PREFIX_."user SET phone = NULL
				WHERE phone = '".$phone."'";
		if(!$this->db->Query($sql)){
			return false;
		}
		return true;
	}
	// Подтверждение условия соглашения и начало деятельности как агента
	public function ConfirmAgent(){
		$sql = "UPDATE "._DB_PREFIX_."user
			SET agent = 1,
			agent_acception_date = CURRENT_TIMESTAMP
			WHERE id_user = ".$_SESSION['member']['id_user'];
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			return false;
		}
		$f['name'] = 'Промо-код агента';
		$f['code'] = 'AG'.$_SESSION['member']['id_user'];
		if(!$this->db->Insert(_DB_PREFIX_.'promo_code', $f)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		$_SESSION['member']['agent'] = 1;
		return true;
	}
	public function SubscribeAgentUser($id_user, $id_agent){
		$f['id_user'] = $id_user;
		$f['id_agent'] = $id_agent;
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'user_agent', $f)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function GetAgentInfo($id_agent){
		$sql = "SELECT o.*, c.*, u.*
			FROM "._DB_PREFIX_."order AS o
			LEFT JOIN "._DB_PREFIX_."user_agent AS ua
				ON ua.id_user = o.id_customer
			LEFT JOIN "._DB_PREFIX_."customer AS c
				ON c.id_user = o.id_customer
			LEFT JOIN "._DB_PREFIX_."user AS u
				ON u.id_user = o.id_customer
			WHERE ua.id_agent = ".$id_agent."
			AND ua.active = 1
			AND from_unixtime(o.target_date) > ua.activation_date";
		if(!$res = $this->db->GetArray($sql)){
			return false;
		}
		return $res;
	}

	public function GetAgentWithdrawals($id_agent){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."agent_withdrawal AS aw
			WHERE aw.id_agent = ".$id_agent;
		if(!$res = $this->db->GetArray($sql)){
			return false;
		}
		return $res;
	}

	public function GetUsersByAgent($id_agent){
		$sql = "SELECT u.*, c.*, ua.*
			FROM "._DB_PREFIX_."user_agent AS ua
			LEFT JOIN "._DB_PREFIX_."user AS u
				ON u.id_user = ua.id_user
			LEFT JOIN "._DB_PREFIX_."customer AS c
				ON c.id_user = u.id_user
			WHERE ua.id_agent = ".$id_agent."
			AND ua.active = 1";
		if(!$res = $this->db->GetArray($sql)){
			return false;
		}
		return $res;
	}

	public function DisableAgentClient($id){
		$f['countable'] = 0;
		if(!$this->db->Update(_DB_PREFIX_.'user_agent', $f, 'id = '.$id)){
			return false;
		}
		return true;
	}

	public function GetActiveAgentsList(){
		$sql = 'SELECT ua.*
			FROM '._DB_PREFIX_.'user_agent AS ua
			GROUP BY ua.id_agent
			HAVING MAX(ua.activation_date)';
		if(!$res = $this->db->GetArray($sql)){
			return false;
		}
		return $res;
	}

	public function GetDealersList($limit = false){
		$sql = "SELECT u.*, c.*
			FROM "._DB_PREFIX_."user AS u
			LEFT JOIN "._DB_PREFIX_."customer AS c
				ON c.id_user = u.id_user
			WHERE u.dealer = 1";
		if($limit){
			$sql .= ' LIMIT '.$limit;
		}
		if(!$res = $this->db->GetArray($sql, 'id_user')){
			return false;
		}
		return $res;
	}

	public function GetUserBySelfEdit($id_user){
		$sql = "SELECT self_edit FROM "._DB_PREFIX_."supplier AS s
			WHERE s.id_user = ".$id_user."
			AND s.self_edit = '1'";
		if(!$res = $this->db->GetOneRowArray($sql)){
			return $res;
		}
		return $res;
	}

	public function GetUserIDByPhone($phone){
		$sql = "SELECT id_user
			FROM "._DB_PREFIX_."user
			WHERE phone = '$phone'";
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res['id_user'];
	}
	public function GetUserIDByEmail($email){
		$sql = "SELECT id_user
			FROM "._DB_PREFIX_."user
			WHERE email = '$email'";
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res['id_user'];
	}
}
