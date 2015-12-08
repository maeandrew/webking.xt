<?php
class Users {
	public $db;
	public $fields;
	private $usual_fields;
	public $list;
	/** Конструктор
	 * @return
	 */
	public function __construct (){
		$this->db =& $GLOBALS['db'];
		$this->usual_fields = array("id_user", "name", "email", "descr", "gid", "active", "news", "promo_code");
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
		$f['email'] = trim($arr['email']);
		$f['passwd'] = trim($arr['passwd']);
		print_r($f['email']);
		$sql = "SELECT u.id_user, u.email, u.gid, u.promo_code, u.name
			FROM "._DB_PREFIX_."user AS u
			WHERE (u.email = ".$f['email']."
			OR u.email = ".$f['email']."@x-torg.com')
			AND u.passwd = ".md5($f['passwd'])."
			AND u.active = 1";
		if(!$this->fields = $this->db->GetOneRowArray($sql)){
			return false;
		}
		$sql2 = "SELECT f.id_product
			FROM "._DB_PREFIX_."favorites AS f
			WHERE f.id_user = ".$this->fields['id_user'];
		$this->fields['favorites'] = $this->db->GetArray($sql2);
		foreach($this->fields['favorites'] as $key => $value){
			$this->fields['favorites'][$key] = $value['id_product'];
		}
		$sql3 = "SELECT wl.id_product
			FROM "._DB_PREFIX_."waiting_list AS wl
			WHERE wl.id_user = ".$this->fields['id_user'];
		$this->fields['waiting_list'] = $this->db->GetArray($sql3);
		foreach($this->fields['waiting_list'] as $key => $value){
			$this->fields['waiting_list'][$key] = $value['id_product'];
		}
		return true;
	}

	public function CheckUserNoPass($arr){
		$f['email'] = trim($arr['email']);
		$sql = "SELECT u.id_user, u.email, u.gid, u.promo_code, u.active
			FROM "._DB_PREFIX_."user AS u
			WHERE u.email = '".$f['email']."'
			AND u.active = 1";
		if($this->fields = $this->db->GetOneRowArray($sql)){
			return true;
		}else{
			return false;
		}
	}

	public function GetFields(){
		return $this->fields;
	}

	public function SetUser($arr){
		if(!empty($arr)){
			return $this->SetFieldsById($arr['id_user']);
		}
		return false;
	}

	// Пользователь по id
	public function SetFieldsById($id, $all=0){
		$active = "AND active = 1";
		if($all == 1){
			$active = '';
		}
		$id = $id;
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."user
			WHERE id_user = \"$id\"
			$active";
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		return true;
	}

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
			order by gid,name, id_user desc
			$limit";
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}else{
			return true;
		}
	}

	public function GetGroups(){
		foreach($GLOBALS['ACL_PERMS']['groups'] as $i=>$g){
			$groups[$i]['gid'] = $i;
			$groups[$i]['name'] = $g['name'];
			$groups[$i]['caption'] = $g['caption'];
		}
		return $groups;
	}

	// Добавить пользователя
	public function AddUser($arr){
		$f['name'] = trim($arr['name']);
		$f['email'] = trim($arr['email']);
		$f['passwd'] = md5(trim($arr['passwd']));
		$f['gid'] = trim($arr['gid']);
		$f['descr'] = trim($arr['descr']);
		if($arr['promo_code'] != ''){
			$arr['promo_code'] = trim($arr['promo_code']);
			$supplier = new Suppliers();
			if($supplier->CheckCodeUniqueness($arr['promo_code']) === false){
				$f['promo_code'] = $arr['promo_code'];
			}
		}
        if(isset($arr['news'])){
        	$f['news'] = trim($arr['news']);
        }
		$f['active'] = 1;
		if(isset($arr['active']) && $arr['active'] == "on"){
			$f['active'] = 0;
		}
		$f['date_add'] = time();
		if(!$this->db->Insert_user(_DB_PREFIX_.'user', $f)){
			$this->db->errno = mysql_errno();
			$this->db->FailTrans();
			return false;
		}
		$id_user = $this->db->GetInsId();
		return $id_user;
	}

	// Обновление пользователя
	public function UpdateUser($arr){
		$f['id_user'] = trim($arr['id_user']);
		if(isset($arr['name']) && $arr['name'] != ''){
			$f['name'] = trim($arr['name']);
		}
		if(isset($arr['email']) && $arr['passwd'] != ''){
			$f['email'] = trim($arr['email']);
		}
		if(isset($arr['passwd']) && $arr['passwd'] != ''){
			$f['passwd'] = md5(trim($arr['passwd']));
		}
		if(isset($arr['gid']) && $arr['passwd'] != ''){
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
		$f['active'] = 1;
		if(isset($arr['active']) && $arr['active'] == "on"){
			$f['active'] = 0;
		}
		$this->db->StartTrans();
		if(isset($arr['promo_code']) && $arr['promo_code'] != ''){
			$arr['promo_code'] = trim($arr['promo_code']);
			$supplier = new Suppliers();
			if($supplier->CheckCodeUniqueness($arr['promo_code']) === false){
				$f['promo_code'] = $arr['promo_code'];
			}
		}
		if(!$this->db->Update(_DB_PREFIX_."user", $f, "id_user = {$f['id_user']}")){
			$this->db->errno = mysql_errno();
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
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
			SET `news` = '".$keu_reg."'
			WHERE `id_user`='".$id_user1."'";
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return $id_user1;
	}

	public function ValidateEmail($email){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."user
			WHERE email = \"$email\"";
		if(count($this->db->GetArray($sql)) == 0){
			return 'good';
		}else{
			return false;
		}
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
			$sql = "SELECT u.id_user, u.name, u.email, u.promo_code, c.cont_person, c.phones
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

}?>
