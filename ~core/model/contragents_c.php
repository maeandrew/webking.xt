<?php
class Contragents extends Users{
	public $db;
	public $fields;
	public $list;
	private $usual_fields;
	private $db_table = _DB_PREFIX_.'contragent';
	private $db_fields;
	/** Конструктор
	 * @return
	 */
	public function __construct(){
		$this->db =& $GLOBALS['db'];
		parent::__construct();
		$this->usual_fields = [
			'c.id_user',
			'c.phones',
			'c.site',
			'c.name_c',
			'c.photo',
			'c.remote',
			'c.details'
		];
		$this->remitters_fields = [
			'id',
			'name',
			'egrpou',
			'mfo',
			'bank',
			'rs',
			'address'
		];
		$this->db_fields = [
			'id_user',
			'phones',
			'site',
			'name_c',
			'photo',
			'details',
			'remote',
		];
	}

	// Создание нового контрагента
	public function Create($data){
		if(!isset($data['id_user'])){
			if(!$id_user = parent::Create($data)){
				return false;
			}
			$data['id_user'] = $id_user;
		}
		$data['id_contragent'] = $data['id_user'];
		$Customers = new Customers();
		if(!$Customers->Read($data['id_user'])){
			if(!$Customers->Create($data)){
				return false;
			}
		}else{
			if(!$Customers->Update($data)){
				return false;
			}
		}
		foreach($this->db_fields as $field){
			switch ($field) {
				case 'remote':
					$f[$field] = isset($data[$field])?1:0;
					break;
				default:
					if(isset($data[$field]) && $data[$field]){
						$f[$field] = $data[$field];
					}
					break;
			}
		}
		$this->db->StartTrans();
		if(!$this->db->Insert($this->db_table, $f)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return $id_user;
	}

	// Получаем данные о контрагенте
	public function Read($id_user){
		$Customers = new Customers();
		if(!$res = $Customers->Read($id_user)){
			return false;
		}
		$sql = 'SELECT *
			FROM '.$this->db_table.'
			WHERE id_user = '.$id_user;
		return array_merge($res, (array) $this->db->GetOneRowArray($sql));
	}

	// Изменение данных контрагента
	public function Update($data){
		if(!parent::Update($data)){
			return false;
		}
		if(!$this->Read($data['id_user'])){
			if(!$this->Create($data)){
				return false;
			}
			return true;
		}
		$Customers = new Customers();
		if(!$Customers->Read($data['id_user'])){
			if(!$Customers->Create($data)){
				return false;
			}
		}else{
			if(!$Customers->Update($data)){
				return false;
			}
		}
		foreach($this->db_fields as $field){
			switch ($field) {
				case 'remote':
					$f[$field] = isset($data[$field])?1:0;
					break;
				default:
					if(isset($data[$field]) && $data[$field]){
						$f[$field] = $data[$field];
					}
					break;
			}
		}
		$this->db->StartTrans();
		if(!$this->db->Update($this->db_table, $f, "id_user = ".$f['id_user'])){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	// Удаление контрагента
	public function Delete($id_user){
		if(!parent::Delete($id_user)){
			return false;
		}
		/*
			Дополнительные процедуры очистки
		*/
		return true;
	}

	// Поля по id
	public function SetFieldsById($id, $all=0){
		// global $Users;
		if(!parent::SetFieldsById($id, $all)){
			return false;
		}
		$active = "AND active = 1";
		if($all == 1){}
		$active = '';
		$sql = "SELECT ".implode(", ",$this->usual_fields).",
			(SELECT COUNT(*) FROM "._DB_PREFIX_."rating AS r WHERE r.id_contragent = c.id_user) AS like_cnt
			FROM "._DB_PREFIX_."contragent AS c
			WHERE c.id_user = ".$id."
			".$active;
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}else{
			$this->fields = array_merge($arr[0], parent::GetFields());
			return true;
		}
	}

	// Добавление рейтинга Контраагента
	//
	public function GetRating($arr){
		$f['id_author'] = $_SESSION['member']['id_user'];
		$f['id_contragent'] = $arr['id_manager'];
		$f['mark'] = $arr['like'];
		$f['comment'] = $arr['comment'];
		$this->db->StartTrans();
		if($arr['voted'] == 1){
			$res = $this->db->Update(_DB_PREFIX_.'rating', $f, 'id_author = '.$f['id_author'].' AND id_contragent = '.$f['id_contragent']);
		}else{
			$res = $this->db->Insert(_DB_PREFIX_."rating", $f);
		}
		if(!$res){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function SetList(){
		$where = '';
		if(SETT !== 0){
			$date = date("Y-m-d", mktime(0, 0, 0, date("m") , date("d")+2, date("Y")));
			$where = (isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] != _ACL_CONTRAGENT_) || !isset($_SESSION['member']['gid'])?' WHERE cc.work_day = 1 AND cc.date = "'.$date.'" AND c.remote = 0 AND c.site NOT LIKE "%diler%"':'';
		}
		$sql = "SELECT DISTINCT c.id_user, c.name_c
		FROM "._DB_PREFIX_."contragent AS c
		LEFT JOIN "._DB_PREFIX_."calendar_contragent AS cc
			ON c.id_user = cc.id_contragent
		LEFT JOIN "._DB_PREFIX_."user AS u
			ON c.id_user = u.id_user".$where;
		if(!$this->list = $this->db->GetArray($sql)){
			return false;
		}
		return true;
	}

	// Сохраненные Поля по id
	public function GetSavedFields($id, $all=0){

		$id = $id;
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
				FROM "._DB_PREFIX_."contragent AS c
				WHERE c.id_user = \"$id\"";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}else{
			$this->fields = $arr[0];
			return $this->fields;
		}
	}

	public function GetSupplierArticlesByOrder($id_order, $id_product, $opt){

		if ($opt){
			$sql = "SELECT DISTINCT s.article, s.id_user
					FROM "._DB_PREFIX_."supplier s, "._DB_PREFIX_."osp osp
					WHERE osp.id_order = $id_order
					AND osp.id_product = $id_product
					AND (s.id_user = osp.id_supplier
					OR s.id_user = osp.id_supplier_altern)";
		}else{
			$sql = "SELECT DISTINCT s.article, s.id_user
					FROM "._DB_PREFIX_."supplier s, "._DB_PREFIX_."osp osp
					WHERE osp.id_order = $id_order
					AND osp.id_product = $id_product
					AND (s.id_user = osp.id_supplier_mopt
					OR s.id_user = osp.id_supplier_mopt_altern)";
		}
		$arr = $this->db->GetArray($sql);
		return $arr;
	}
	// Страница профиля менеджера по id
	public function GetManagerInfoById($id){
		$id = $id;
		$sql = "SELECT *
				FROM "._DB_PREFIX_."contragent
				WHERE id_user = \"$id\"";
		$arr = $this->db->GetOneRowArray($sql);
		if (!$arr)
			return false;
		else{
			return $arr;
		}
	}

	/* Добавление
	 *
	 */
	public function AddContragent($arr){
		global $Users;
		// user
		$arr['gid'] = _ACL_CONTRAGENT_;

		if(!$id_user = $Users->AddUser($arr)){
			return false;
		}
		unset($f);
		// user

		// Contragent
		$f['id_user'] = $id_user;
		$f['site'] = trim($arr['site']);
		$f['name_c'] = trim($arr['name_c']);
		if ($f['site']!=='' && (stripos($f['site'], "http://")===false)) $f['site'] = "http://".$f['site'];
		$f['phones'] = trim($arr['phones']);
		$f['remote'] = trim($arr['remote']);

		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'contragent', $f)){
			echo $this->db->ErrorMsg();
			$this->db->FailTrans();
			return false;
		}
		// contragent

		$this->db->CompleteTrans();

		return true;
	}


	/* Обновление
	 *
	 */
	public function UpdateContragent($arr){
		global $Users;
		// user
		$arr['gid'] = $Users->fields['gid'];

		if (!$Users->UpdateUser($arr)){
			$this->db->errno = $Users->db->errno;
			$this->db->FailTrans();
			return false;
		}
		// user

		// contragent
		$f['id_user'] = trim($arr['id_user']);
		$f['site'] = trim($arr['site']);
		$f['details'] = trim($arr['details']);
		if(isset($arr['remote'])){
			$f['remote'] = 1;
		}else{
			$f['remote'] = 0;
		}
		$f['photo'] = trim($arr['photo']);
		$f['name_c'] = trim($arr['name_c']);
		if ($f['site']!=='' && (stripos($f['site'], "http://")===false)) $f['site'] = "http://".$f['site'];
		$f['phones'] = trim($arr['phones']);

		$this->db->StartTrans();
		if (!$this->db->Update(_DB_PREFIX_.'contragent', $f, "id_user = {$f['id_user']}")){
			echo $this->db->ErrorMsg();
			$this->db->FailTrans();
			return false;
		}
		// contragent
		$this->db->CompleteTrans();

		return true;
	}

	// Удаление
	public function DelContragent($id){

		$sql = "DELETE FROM "._DB_PREFIX_."contragent WHERE `id_user` =  $id";
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");

		$sql = "DELETE FROM "._DB_PREFIX_."user WHERE id_user=$id";
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");

		// User удалится триггером
		// связи с городами, стоянками и службами доставки удалятся триггерами

		return true;
	}


	// Получение данных по рабочим дням и ночам
	public function SetCurrentWeek(){

		$d = date("Y-m-d", time());
		$sql = "SELECT date, work_day, work_night, limit_sum_day, limit_sum_night
				FROM "._DB_PREFIX_."calendar_contragent
				WHERE id_contragent=".$this->fields['id_user']."
				AND date>=\"$d\"";

		$arr = $this->db->GetArray($sql,'date');
		return $arr;
	}


	public function UpdateCalendar($arr){
		//print_r($_POST);die();
		$ts = time();
		for ($ii=0; $ii<7; $ii++){
			$ts_tmp = $ts+86400*$ii;
			$d = date("Y_m_d", $ts_tmp);
			if(isset($f)) unset($f);
			$fl_day = 0;
			$fl_night = 0;

			if (isset($arr['work_day_'.$d]) && is_numeric($arr['work_day_'.$d])){
				$f['work_day'] = $arr['work_day_'.$d];
				$fl_day++;
			}else{
				$f['work_day'] = 0;
			}

			if (isset($arr['limit_sum_day_'.$d]) && is_numeric($arr['limit_sum_day_'.$d])){
				$f['limit_sum_day'] = $arr['limit_sum_day_'.$d];
				$fl_day++;
			}else{
				$f['limit_sum_day'] = 0;
			}


			if (isset($arr['work_night_'.$d]) && is_numeric($arr['work_night_'.$d])){
				$f['work_night'] = $arr['work_night_'.$d];
				$fl_night++;
			}else{
				$f['work_night'] = 0;
			}

			if (isset($arr['limit_sum_night_'.$d]) && is_numeric($arr['limit_sum_night_'.$d])){
				$f['limit_sum_night'] = $arr['limit_sum_night_'.$d];
				$fl_night++;
			}else{
				$f['limit_sum_night'] = 0;
			}

			$id_contragent = $this->fields['id_user'];
			$date = date("Y-m-d", $ts_tmp);

			if ($fl_day == 2 || $fl_night == 2){

				$sql = "SELECT date FROM "._DB_PREFIX_."calendar_contragent
						WHERE id_contragent=$id_contragent
						AND date=\"$date\"";
				$tarr = $this->db->GetArray($sql);
				$this->db->StartTrans();

				if ($tarr){
					if (!$this->db->Update(_DB_PREFIX_.'calendar_contragent', $f, "id_contragent = $id_contragent AND date=\"$date\"")){
						//echo $this->db->ErrorMsg();
						$this->db->FailTrans();
						return false;
					}else{
						$this->db->CompleteTrans();
					}
				}else{
					$f['date'] = $date;
					$f['id_contragent'] = $id_contragent;
					if(!$this->db->Insert(_DB_PREFIX_.'calendar_contragent', $f)){
						$this->db->FailTrans();
						return false;
					}else{
						$this->db->CompleteTrans();
					}
				}
			}else{
				$sql = "DELETE FROM "._DB_PREFIX_."calendar_contragent WHERE id_contragent=$id_contragent AND date=\"$date\"";
				$this->db->StartTrans();
				$this->db->Query($sql) or G::DieLoger("SQL error - $sql");
				$this->db->CompleteTrans();
			}
		}

	}

	public function GetOrders($order_by='o.target_date desc', $target){
		$id_contragent = $this->fields['id_user'];
		// *****************************************************************В работе
		$date = time()-3600*24;
		$date2 = time()-3600*24*45;//echo time()-3600*24*10;
		if($target == 100){
			$sql = "SELECT o.cont_person, o.phones, o.target_date, o.creation_date, o.id_order, o.id_order_status, o.skey, SUM(osp.opt_sum+osp.mopt_sum) AS sum,
					o.id_pretense_status, o.id_return_status, o.note, o.note2, o.note_customer, u.name as name_customer, o.sum_discount, o.discount, c.name_c as contragent, o.id_customer
					FROM "._DB_PREFIX_."order o, "._DB_PREFIX_."osp osp, "._DB_PREFIX_."user u, "._DB_PREFIX_."contragent c
					WHERE o.id_order = osp.id_order


									AND c.id_user = o.id_contragent

					AND (o.id_return_status IN (1) OR o.id_pretense_status IN (1))
					AND o.id_customer = u.id_user
					GROUP BY id_order
					ORDER BY $order_by";

			$arr1 = $this->db->GetArray($sql);

			$sql = "SELECT o.cont_person, o.phones, o.target_date, o.creation_date, o.id_order, o.id_order_status, o.skey, SUM(osp.opt_sum+osp.mopt_sum) AS sum,
					o.id_pretense_status, o.id_return_status, o.note, o.note2, o.note_customer, u.name as name_customer, o.sum_discount, o.discount, c.name_c as contragent, o.id_customer
					FROM "._DB_PREFIX_."order o, "._DB_PREFIX_."osp osp, "._DB_PREFIX_."user u, "._DB_PREFIX_."contragent c
					WHERE o.id_order = osp.id_order
					AND o.target_date>\"$date2\"

									AND c.id_user = o.id_contragent

					AND o.id_order_status IN (1,6)
					AND o.id_customer = u.id_user
					GROUP BY id_order
					ORDER BY $order_by";

			$arr2 = $this->db->GetArray($sql);

			if ($order_by == "o.id_order_status asc")
				$arr = array_merge($arr2, $arr1);
			else
				$arr = array_merge($arr1, $arr2);
		}elseif($target == 200){
			// Выполненные за месяц
			$sql = "SELECT o.cont_person, o.phones, o.target_date, o.creation_date, o.id_order, o.note_customer, o.id_order_status, o.skey, SUM(osp.opt_sum+osp.mopt_sum) AS sum,
					 o.note, o.note2,  o.sum_discount, o.discount, o.id_customer
					FROM "._DB_PREFIX_."order o, "._DB_PREFIX_."osp osp, "._DB_PREFIX_."user u
					WHERE o.id_order = osp.id_order

					AND o.target_date>\"$date2\"

					AND o.id_order_status IN (2)
					AND o.id_customer = u.id_user
					GROUP BY id_order
					ORDER BY $order_by";

			$arr = $this->db->GetArray($sql);
		}

		return $arr;
	}

    public function GetContragentOrders($order_by='o.creation_date desc', $target, $id_contragent, $limit = false, $order_number = false){
        // *****************************************************************В работе
        $date = time()-3600*24;
        $date2 = time()-3600*24*30;//echo time()-3600*24*10;
        $sql = "SELECT o.cont_person, o.phones, o.target_date,
				o.creation_date, o.id_order, o.id_customer,
				u.name AS name_customer,o.id_klient,
				(SELECT name
				FROM "._DB_PREFIX_."user AS u
				LEFT JOIN "._DB_PREFIX_."order AS o
					ON o.id_klient = u.id_user
				WHERE osp.id_order = o.id_order) AS name_klient,
				(SELECT cu.cont_person
				FROM "._DB_PREFIX_."customer AS cu
				LEFT JOIN "._DB_PREFIX_."order AS o
					ON cu.id_user = o.id_klient
				WHERE osp.id_order = o.id_order) AS cont_person_klient,
				c.name_c AS contragent, o.id_order_status, o.skey,
				SUM(osp.opt_sum+osp.mopt_sum) AS sum, o.id_pretense_status,
				o.id_return_status, o.note, o.note2, o.note_customer,
				o.sum_discount, o.discount
			FROM "._DB_PREFIX_."order AS o
			LEFT JOIN "._DB_PREFIX_."osp AS osp
				ON o.id_order = osp.id_order
			LEFT JOIN "._DB_PREFIX_."user AS u
				ON o.id_customer = u.id_user
			LEFT JOIN "._DB_PREFIX_."contragent AS c
				ON c.id_user = o.id_contragent
			WHERE o.id_order_status <> 7
			
			AND o.creation_date > '".$date2."'".($order_number?$order_number:null)."
			GROUP BY id_order
			ORDER BY ".$order_by.
			// AND (o.id_contragent = '".$id_contragent."' OR o.id_customer = '".$id_contragent."')
			($limit?$limit:null);
        $arr = $this->db->GetArray($sql);
        return $arr;
    }

    public function GetContragentOrdersByClient($order_by='o.creation_date desc', $target, $id_contragent, $id_client, $limit = false){
        $id_client = trim($id_client);
        if($id_client == $GLOBALS['CONFIG']['default_user']){
            $and = " AND o.id_customer = \"$id_contragent\" AND o.id_klient = \"$id_client\"";
        }else{
            $and = " AND (o.id_customer = \"$id_client\" OR o.id_klient = \"$id_client\") AND o.id_contragent = \"$id_contragent\"";
        }
        // *****************************************************************В работе
        $date = time()-3600*24;
        $date2 = time()-3600*24*30;//echo time()-3600*24*10;
        $sql = "
			SELECT
				o.cont_person,
				o.phones,
				o.target_date,
				o.creation_date,
				o.id_order,
				o.id_customer,
				u.name AS name_customer,
				o.id_klient,
				(
					SELECT
						name
					FROM
						"._DB_PREFIX_."user AS u,
						"._DB_PREFIX_."order AS o
					WHERE
						o.id_klient = u.id_user
						AND osp.id_order = o.id_order
				) AS name_klient,
				(
					SELECT
						cu.cont_person
					FROM
						"._DB_PREFIX_."customer AS cu,
						"._DB_PREFIX_."order AS o
					WHERE
						cu.id_user = o.id_klient
						AND osp.id_order = o.id_order
				) AS cont_person_klient,
				c.name_c AS contragent,
				o.id_order_status,
				o.skey,
				SUM(osp.opt_sum+osp.mopt_sum) AS sum,
				o.id_pretense_status,
				o.id_return_status,
				o.note,
				o.note2,
				o.note_customer,
				o.sum_discount,
				o.discount
			FROM
				"._DB_PREFIX_."order AS o,
				"._DB_PREFIX_."osp AS osp,
				"._DB_PREFIX_."user AS u,
				"._DB_PREFIX_."contragent AS c
			WHERE
				o.id_order = osp.id_order
				AND c.id_user = o.id_contragent
				AND o.id_customer = u.id_user
				$and
			GROUP BY id_order
			ORDER BY $order_by
			ORDER BY ".$order_by.
			($limit?$limit:null);
        $arr = $this->db->GetArray($sql);


		return $arr;
	}


	public function GetParkingById($id_parking){
		$sql = "SELECT name FROM "._DB_PREFIX_."parking WHERE id_parking=$id_parking";
		$arr = $this->db->GetOneRowArray($sql);
		return $arr['name'];
	}

	public function GetCityById($id_city){
		$sql = "SELECT name FROM "._DB_PREFIX_."city WHERE id_city=$id_city";
		$arr = $this->db->GetOneRowArray($sql);
		return $arr['name'];
	}

	public function GetDeliveryServiceById($id_ds){
		$sql = "SELECT name FROM "._DB_PREFIX_."delivery_service WHERE id_delivery_service=$id_ds";
		$arr = $this->db->GetOneRowArray($sql);
		return $arr['name'];
	}

	public function GetContragentServiceById($id_ds){
		$sql = "SELECT name_c FROM "._DB_PREFIX_."contragent WHERE id_user = $id_ds";
		$arr = $this->db->GetOneRowArray($sql);
		return $arr['name_c'];
	}

	// Заполнение или обновление календаря контрагента
	public function SwitchContragentDate($date, $dn, $limit_sum){
		global $Users;

		$limit_sum = $limit_sum;

		$tmp = explode("_", $date);
		$date = $tmp[0]."-".$tmp[1]."-".$tmp[2];

		$this->db->StartTrans();

		$id_contragent = $Users->fields['id_user'];
		$sql = "SELECT date, id_contragent, work_day,
				work_night, limit_sum_day, limit_sum_night
			FROM "._DB_PREFIX_."calendar_contragent
			WHERE id_contragent = ".$id_contragent."
			AND date = '".$date."'";
		$switcher = 0;
		$switcher2 = 0;
		$arr = $this->db->GetOneRowArray($sql);
		if ($arr){ // Если дата уже есть в базе
			if ($dn == "day"){
				$switcher = $arr['work_day']==1?0:1;
				$switcher2 = $arr['work_day']==1?0:1000000;
				$sql = "UPDATE "._DB_PREFIX_."calendar_contragent
					SET work_day = ".$switcher.",
						limit_sum_day = ".$switcher2."
					WHERE id_contragent = ".$id_contragent."
					AND date = '".$date."'";
			}/*elseif($dn == "night"){
				$switcher = $arr['work_night']==1?0:1;
				$sql = "UPDATE "._DB_PREFIX_."calendar_contragent SET work_night=$switcher, limit_sum_night=$limit_sum
						WHERE id_contragent=$id_contragent
						AND date=\"$date\"";
			}*/else{G::DieLoger("<b>Bad dn - </b>$dn");}

			$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");

		}else{ // Если даты еще нет
			$switcher = 1;
			if ($dn == "day"){
				$sql = "INSERT INTO "._DB_PREFIX_."calendar_contragent (date, id_contragent, work_day)
						VALUES ('".$date."', ".$id_contragent.", 1)";
			}/*elseif($dn == "night"){
				$sql = "INSERT INTO "._DB_PREFIX_."calendar_contragent (date, id_contragent, work_night, limit_sum_day)
						VALUES (\"$date\", $id_contragent, 1, $limit_sum)";
			}*/else{G::DieLoger("<b>Bad dn - </b>$dn");}

			$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		}

		$this->db->CompleteTrans();
		return true;
	}

	//*******************************************************************************************

	public function CheckContragentDate($date, $dn, $limit_sum){
		global $Users;

		$limit_sum = $limit_sum;

		$tmp = explode("_", $date);
		$date = $tmp[0]."-".$tmp[1]."-".$tmp[2];

		$this->db->StartTrans();
		$id_contragent = $Users->fields['id_user'];
		$sql = "SELECT date, id_contragent, work_day,
				work_night, limit_sum_day, limit_sum_night
			FROM "._DB_PREFIX_."calendar_contragent
			WHERE id_contragent = ".$id_contragent."
			AND date = '".$date."'";

		$arr = $this->db->GetOneRowArray($sql);


		if ($dn == "day"){
			$sql = "INSERT INTO "._DB_PREFIX_."calendar_contragent (date, id_contragent, work_day, limit_sum_day)
						VALUES ('".$date."', ".$id_contragent.", 1, ".$limit_sum.")";
		}elseif($dn == "night"){
			$sql = "INSERT INTO "._DB_PREFIX_."calendar_contragent (date, id_contragent, work_night, limit_sum_day)
						VALUES ('".$date."', ".$id_contragent.", 1, ".$limit_sum.")";
		}else{G::DieLoger("<b>Bad dn - </b>$dn");}

		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");


		$this->db->CompleteTrans();
		return true;
	}

	//******************************************************************************************* Отправители - Р/с, МФО, ЕГРПОУ...

	public function AddRemitter($arr){
		$f['name'] = trim($arr['name']);
		$f['egrpou'] = trim($arr['egrpou']);
		$f['mfo'] = trim($arr['mfo']);
		$f['bank'] = trim($arr['bank']);
		$f['rs'] = trim($arr['rs']);
		$f['address'] = trim($arr['address']);

		if(!$this->db->Insert(_DB_PREFIX_.'remitter', $f)){
			echo $this->db->ErrorMsg();
			$this->db->FailTrans();
			return false;
		}
		return true;
	}
	public function UpdateRemitter($arr){
		$f['id'] = trim($arr['id']);
		$f['name'] = trim($arr['name']);
		$f['egrpou'] = trim($arr['egrpou']);
		$f['mfo'] = trim($arr['mfo']);
		$f['bank'] = trim($arr['bank']);
		$f['rs'] = trim($arr['rs']);
		$f['address'] = trim($arr['address']);

		if(!$this->db->Update(_DB_PREFIX_.'remitter', $f, "id = {$f['id']}")){
			echo $this->db->ErrorMsg();
			$this->db->FailTrans();
			return false;
		}
		return true;
	}
	public function DelRemitter($id){
		$sql = "DELETE FROM "._DB_PREFIX_."remitter WHERE id=$id";
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}
	public function SetRemittersList(){
		$sql = "SELECT ".implode(", ", $this->remitters_fields)."
		FROM "._DB_PREFIX_."remitter";
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}
	public function GetRemitterById($id, $only=null){
		if(is_array($id)){
			$id = array_unique($id);
			$sql = "SELECT *
					FROM "._DB_PREFIX_."remitter
					WHERE id IN (".implode(',', $id).")";
		}else{
			$id = $id;
			$sql = "SELECT *
					FROM "._DB_PREFIX_."remitter
					WHERE id = ".$id;
		}
		if($only){
			$arr = $this->db->GetOneRowArray($sql);
		}else{
			$arr = $this->db->GetArray($sql);
		}
		if(!$arr){
			return false;
		}else{
			return $arr;
		}
	}

}
?>