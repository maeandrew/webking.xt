<?php
// Адреса
class Address {
	public $db;

	public function __construct (){
		$this->db =& $GLOBALS['db'];
	}
	public function GetListByUserId($id_user){
		$sql = "SELECT a.*, lr.title AS region, lc.title AS city,
			sc.title AS shipping_company, ld.title AS delivery
			FROM "._DB_PREFIX_."address AS a
			LEFT JOIN "._DB_PREFIX_."locations_delivery_type AS ld ON ld.id = a.id_delivery
			LEFT JOIN "._DB_PREFIX_."locations_cities AS lc ON lc.id = a.id_city
			LEFT JOIN "._DB_PREFIX_."locations_regions AS lr ON lr.id = a.id_region
			LEFT JOIN "._DB_PREFIX_."shipping_companies AS sc ON sc.id = a.id_delivery_service
			WHERE a.visible = 1 AND a.id_user = ".$id_user;
		if(!$res = $this->db->GetArray($sql)){
			return false;
		}
		return $res;
	}
	public function GetPrimaryAddress($id_user){
		$sql = "SELECT * FROM "._DB_PREFIX_."address
		WHERE primary = 1
		AND id_user = ".$id_user;
		if(!$res = $this->db->GetArray($sql)){
			return false;
		}
		return $res;
	}
	public function GetAddressById($id_address){
		$sql ="SELECT a.*, lr.title AS region_title, lc.title AS city_title,
			dt.title AS delivery_type_title, sc.title AS shipping_company_title
			FROM "._DB_PREFIX_."address AS a
			LEFT JOIN "._DB_PREFIX_."locations_cities AS lc
				ON lc.id = a.id_city
			LEFT JOIN "._DB_PREFIX_."locations_regions AS lr
				ON lr.id = a.id_region
			LEFT JOIN "._DB_PREFIX_."shipping_companies AS sc
				ON sc.id = a.id_delivery_service
			LEFT JOIN "._DB_PREFIX_."locations_delivery_type AS dt
				ON dt.id = a.id_delivery
			WHERE a.id = ".$id_address;
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res;
	}
	// Вывод адреса доставки в заказах
	public function getAddressOrder($id_order){
		$sql = "SELECT a.*, lr.title AS region, lc.title AS city, sc.title AS shipping_company, ld.title AS delivery
				FROM "._DB_PREFIX_."address a
				LEFT JOIN "._DB_PREFIX_."locations_delivery_type ld ON ld.id = a.id_delivery_service
				LEFT JOIN "._DB_PREFIX_."locations_cities lc ON lc.id = a.id_city
				LEFT JOIN "._DB_PREFIX_."locations_regions lr ON lr.id = a.id_region
				LEFT JOIN "._DB_PREFIX_."shipping_companies sc ON sc.id = a.id_delivery_service
				WHERE a.id = (SELECT id_address FROM "._DB_PREFIX_."order WHERE id_order = ".$id_order.")";
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res;
	}








	public function AddRegion($data){
		$f['title'] = $data['title'];
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'locations_regions', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id;
	}
	public function UpdateRegion($data){
		$f['title'] = $data['title'];
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_.'locations_regions', $f, 'id = '.$data['id'])){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	public function DeleteRegion($id){
		$sql = "DELETE FROM "._DB_PREFIX_."locations_regions WHERE id = ".$id;
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}
	public function GetRegionsList(){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."locations_regions AS lr";

		if(!$res = $this->db->GetArray($sql, 'id')){
			return false;

		}
		return $res;
	}
	public function GetRegionByTitle($title){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."locations_regions AS lr
			WHERE lr.title = ".$this->db->Quote($title);
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res;
	}
	/**
	 * [GetRegionById description]
	 * @param [type] $id [description]
	 */
	public function GetRegionById($id){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."locations_regions AS lr
			WHERE lr.id = ".$id;
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res;
	}





	public function AddCity($data){
		$f['title'] = $data['title'];
		$f['id_region'] = $data['id_region'];
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'locations_cities', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id;
	}
	public function UpdateCity($data){
		$f['title'] = $data['title'];
		$f['id_region'] = $data['id_region'];
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_.'locations_cities', $f, 'id = '.$data['id'])){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	public function DeleteCity($id){
		$sql = "DELETE FROM "._DB_PREFIX_."locations_cities WHERE id = ".$id;
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}
	public function GetCitiesList($region = false, $limit = false){
		$sql = "SELECT lc.*
			FROM "._DB_PREFIX_."locations_cities AS lc";
			if($region !== false){
			if(is_integer($region)){
				$sql .= " WHERE lc.id_region = ".$region;
			}else{
				$sql .= " LEFT JOIN "._DB_PREFIX_."locations_regions AS lr ON lr.id = lc.id_region
				WHERE lr.title = ".$this->db->Quote($region);
			}
		}
		if($limit){
			$sql .= ' LIMIT '.$limit;
		}
		if(!$res = $this->db->GetArray($sql, 'id')){
			return false;
		}
		return $res;
	}
	public function GetCityByTitle($title, $id_region = false){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."locations_cities AS lc
			WHERE lc.title = ".$this->db->Quote($title);
			if($id_region){
				$sql .= " AND lc.id_region = ".$id_region;
			}
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res;
	}
	public function GetCityById($id){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."locations_cities AS lc
			WHERE lc.id = ".$id;
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res;
	}







	public function AddWarehouse($data){
		$f['warehouse'] = $data['warehouse'];
		$f['id_city'] = $data['id_city'];
		$f['id_dealer'] = $data['id_dealer'];
		$f['id_shipping_company'] = $data['id_shipping_company'];
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'locations_warehouses', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id;
	}
	public function UpdateWarehouse($data){
		$f['warehouse'] = $data['warehouse'];
		$f['id_city'] = $data['id_city'];
		$f['id_dealer'] = $data['id_dealer'];
		$f['id_shipping_company'] = $data['id_shipping_company'];
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_.'locations_warehouses', $f, 'id = '.$data['id'])){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	public function DeleteWarehouse($id){
		$sql = "DELETE FROM "._DB_PREFIX_."locations_warehouses WHERE id = ".$id;
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}
	public function GetWarehouseById($id){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."locations_warehouses AS lw
			WHERE lw.id = ".$id;
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res;
	}
	public function GetWarehousesList($where = false, $limit = false){
		$sql = "SELECT lw.*
			FROM "._DB_PREFIX_."locations_warehouses AS lw";
		if(!empty($where)){
			$sql .= ' WHERE '.implode(' AND ', $where);
		}
		if($limit){
			$sql .= ' LIMIT '.$limit;
		}
		if(!$res = $this->db->GetArray($sql, 'id')){
			return false;
		}
		return $res;
	}






	public function AddShippingCompany($data){
		$f['title'] = $data['title'];
		$f['courier'] = $data['courier'];
		$f['has_api'] = $data['has_api'];
		$f['api_key'] = $data['api_key'];
		$f['api_prefix'] = $data['api_prefix'];
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'shipping_companies', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id;
	}
	public function UpdateShippingCompany($data){
		$f['title'] = $data['title'];
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_.'shipping_companies', $f, 'id = '.$data['id'])){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	public function DeleteShippingCompany($id){
		$sql = "DELETE FROM "._DB_PREFIX_."shipping_companies WHERE id = ".$id;
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}
	public function GetShippingCompanyById($id){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."shipping_companies AS sc
			WHERE sc.id = ".$id;
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res;
	}
	public function GetShippingCompaniesList($where = false, $limit = false){
		$sql = "SELECT sc.*
			FROM "._DB_PREFIX_."shipping_companies AS sc";
		if(!empty($where)){
			$sql .= ' WHERE '.implode(' AND ', $where);
		}
		if($limit){
			$sql .= ' LIMIT '.$limit;
		}
		if(!$res = $this->db->GetArray($sql, 'id')){
			return false;
		}
		return $res;
	}







	public function AddAddress($data){
		$f['title'] = $data['title'];
		$f['id_user'] = isset($data['id_user'])?$data['id_user']:$_SESSION['member']['id_user'];
		$f['id_region'] = $data['id_region'];
		$f['id_city'] = $data['id_city'];
		$f['id_delivery'] = $data['id_delivery'];
		$f['id_delivery_service'] = $data['id_delivery_service'];
		if(!empty($data['delivery_department'])){
			$f['delivery_department'] = $data['delivery_department'];
		}
		if(!empty($data['address'])){
			$f['address'] = $data['address'];
		}
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'address', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id_address = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id_address;
	}
	public function DeleteAddress($id){
		$sql = "SELECT COUNT(*) AS count FROM "._DB_PREFIX_."order
				WHERE id_address = ".$id." AND id_customer = ".$_SESSION['member']['id_user'];
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		if($res['count'] == 0){
			$sql = "DELETE FROM "._DB_PREFIX_."address WHERE id = ".$id;
		}else{
			$sql = "UPDATE "._DB_PREFIX_."address SET visible = 0 WHERE id = ".$id;
		}
		$this->db->StartTrans();
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		$this->db->CompleteTrans();
		return true;
	}

	public function GetShippingCompanies($courier = false){
		$sql = "SELECT * FROM "._DB_PREFIX_."shipping_companies
			".($courier?'WHERE courier = 1':null);
		if(!$res = $this->db->GetArray($sql)){
			return false;
		}
		return $res;
	}
	public function getCity($company, $data){
		$warehouses = $this->getWarehouses($company, $data);
		if(empty($warehouses)){
			return false;
		}
		return $warehouses[0];
	}
	public function getWarehouses($company, $data){
		$sql = "SELECT id, id_city, warehouse AS name FROM "._DB_PREFIX_."locations_warehouses
			WHERE id_shipping_company = ".$company['id']."
			AND id_city = (SELECT lc.id FROM "._DB_PREFIX_."locations_cities AS lc WHERE lc.title = '".$data['city']."' AND lc.id_region = (SELECT lr.id FROM "._DB_PREFIX_."locations_regions AS lr WHERE lr.title = '".$data['region']."'))";
		if(!$res = $this->db->GetArray($sql)){
			return false;
		}
		return $res;
	}
	public function NonAPI($company, $function, $data = false){
		return $this->$function($company, $data);
	}
	public function UseAPI($company, $function, $data = false){
		$function = $company['api_prefix'].$function;
		return $this->$function($company, $data);
	}

	private function npgetCity($company, $data){
		$api = new NovaPoshtaApi2($company['api_key']);
		$city = $api->getCity($data['city'], $data['region']);
		if(!empty($city['data'][0])){
			return $city['data'][0];
		}
		return false;
	}
	private function npgetWarehouses($company, $data){
		$api = new NovaPoshtaApi2($company['api_key']);
		$warehouses = $api->getWarehouses($_POST['ref']);
		if(!empty($warehouses['data'][0])){
			foreach($warehouses['data'] as &$warehouse){
				$warehouse = array('id' => $warehouse['Ref'], 'name' => $warehouse['DescriptionRu']);
			}
			return $warehouses['data'];
		}
		return false;
	}

	private function itgetCity($company, $data){
		$key = explode(';', $company['api_key']);
		$api = new IntimeApi2($key[0], $key[1]);
		$city = $api->getSettlementCode($data['city'], $data['region']);
		if(!empty($city)){
			return array('Ref' => $city);
		}
		return false;
	}
	private function itgetWarehouses($company, $data){
		$key = explode(';', $company['api_key']);
		$api = new IntimeApi2($key[0], $key[1]);
		$warehouses = $api->getDepartmentsList($data['city'], $data['region']);
		if(!empty($warehouses)){
			foreach($warehouses as &$warehouse){
				$warehouse = array('id' => $warehouse['Code'], 'name' => '№'.$warehouse['AppendField'][10]['AppendFieldValue'].': '.$warehouse['AppendField'][0]['AppendFieldValue']);
			}
			asort($warehouses);
			return $warehouses;
		}
		return false;
	}

	private function delgetCity($company, $data){
		$key = explode(';', $company['api_key']);
		$api = new IntimeApi2($key[0], $key[1]);
		$city = $api->getSettlementCode($data['city'], $data['region']);
		if(!empty($city)){
			return array('Ref' => $city);
		}
		return false;
	}
	private function delgetWarehouses($company, $data){
		$key = explode(';', $company['api_key']);
		$api = new IntimeApi2($key[0], $key[1]);
		$warehouses = $api->getDepartmentsList($data['city']);
		if(!empty($warehouses)){
			foreach($warehouses as &$warehouse){
				$warehouse = array('id' => $warehouse['Code'], 'name' => '№'.$warehouse['AppendField'][10]['AppendFieldValue'].': '.$warehouse['AppendField'][0]['AppendFieldValue']);
			}
			asort($warehouses);
			return $warehouses;
		}
		return false;
	}

}

// Города
class Citys {
	public $db;
	public $fields;
	private $usual_fields;
	public $list;

	/** Конструктор
	 *  @return
	 */

	public function __construct (){
		$this->db =& $GLOBALS['db'];
		$this->usual_fields = array("id_city", "names_regions", "name" ,"region");
		$this->all_fields = array("id_city", "names_regions", "name" ,"region", "shipping_comp", "address", "phones");
	}

	// по id
	public function SetFieldsById($id){
		$sql = "SELECT ".implode(", ",$this->all_fields)."
			FROM "._DB_PREFIX_."city
			WHERE id_city = ".$id."
			AND closed = 0";
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		return $this->fields;
	}

	// сохраненные по id
	public function GetSavedFields($id){
		$sql = "SELECT ".implode(", ",$this->all_fields)."
			FROM "._DB_PREFIX_."city
			WHERE id_city = ".$id;
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		return $this->fields;
	}

	// по строке
	public function SetFieldsByInput($string){
		$sql = "SELECT ".implode(", ", $this->usual_fields)."
			FROM "._DB_PREFIX_."city
			WHERE region LIKE ".$this->db->Quote($string)."
			AND closed = 0
			AND address <> ''
			GROUP BY name";
		$res = $this->db->GetArray($sql);
		return $res;
	}

	// Список
	public function SetList($param = 0, $limit = ""){
		if($limit != ""){
			$limit = " limit ".$limit;
		}
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."city
			GROUP BY name".
			$limit;
		$this->list = $this->db->GetArray($sql);
		//print_r($this->list);die();
		if(!$this->list){
			return false;
		}
		return true;
	}

	// Добавление
	public function Add($arr){
		//$f['id_city'] = mysql_real_escape_string(trim($arr['id_city']));
		$f['id_city'] = $arr['id_city'];
		$f['name'] = $this->db->Quote($arr['name']);
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'city', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id;
	}

	// Обновление
	public function Update($arr){
		$f['id_city'] = $arr['id_city'];
		$f['name'] = $this->db->Quote($arr['name']);
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."city", $f, "id_city = {$f['id_city']}")){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	// Удаление
	public function Del($id_city){
		$sql = "DELETE FROM "._DB_PREFIX_."city WHERE id_city = ".$id_city;
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}
}

// Области
class Regions {
	public $db;
	public $fields;
	private $usual_fields;
	public $list;

	/** Конструктор
	 * @return
	 */

	public function __construct(){
		$this->db =& $GLOBALS['db'];
		$this->usual_fields = array("id_city", "region");
	}

	// по id
	public function SetFieldsById($id){
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."city
			WHERE id_region = ".$id;
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		return true;
	}

	// по строке
	public function SetFieldsByInput($string){
		$string = $this->db->Quote($string);
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."city
			WHERE region LIKE ".$this->db->Quote($string)."
			AND closed = 0
			GROUP BY region";
		$res = $this->db->GetArray($sql);
		return $res;
	}

	// Список
	public function SetList($param = 0, $limit = ""){
		if($limit != ""){
			$limit = " limit ".$limit;
		}
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."city
			WHERE closed = 0
			AND address <> ''
			GROUP BY region".
			$limit;
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}

	// Добавление
	public function Add($arr){
		$f['id_region'] = $arr['id_region'];
		$f['name'] = $this->db->Quote($arr['name']);
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'region', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id;
	}

	// Обновление
	public function Update($arr){
		$f['id_region'] = $arr['id_region'];
		$f['name'] = $this->db->Quote($arr['name']);
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."region", $f, "id_region = {$f['id_region']}")){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	// Удаление
	public function Del($id){
		$sql = "DELETE FROM "._DB_PREFIX_."region WHERE id_region = ".$id;
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}

	// Сортировка
	public function Reorder($arr){
		foreach($arr['ord'] as $id=>$ord){
			$sql = "UPDATE "._DB_PREFIX_."region
				SET ord = ".$ord."
				WHERE id_region = ".$id;
			$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		}
	}
}

// Способы доставки
class Delivery {

	public $db;
	public $fields;
	private $usual_fields;
	public $list;

	/** Конструктор
	 * @return
	 */

	public function __construct (){
		$this->db =& $GLOBALS['db'];
		$this->usual_fields = array("id_city", "name", "region", "shipping_comp", "address");
		$this->delivery_fields = array("id_delivery", "name");
	}

	// по id
	public function SetFieldsById($id){
		$sql = "SELECT ".implode(", ",$this->delivery_fields)."
			FROM "._DB_PREFIX_."delivery
			WHERE id_delivery = ".$id;
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		return true;
	}

	// сохраненные по id
	public function GetSavedFields($id){
		$sql = "SELECT ".implode(", ",$this->delivery_fields)."
			FROM "._DB_PREFIX_."delivery
			WHERE id_delivery = ".$id;
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		return true;
	}

	// Список Способов доставки
	public function SetDeliveryList($param = 0, $limit=""){
		if($limit != ""){
			$limit = " limit ".$limit;
		}
		$sql = "SELECT ".implode(", ",$this->delivery_fields)."
			FROM "._DB_PREFIX_."delivery
			ORDER BY id_delivery".
			$limit;
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}

	// по строке
	public function SetFieldsByInput($shipping_comp, $city, $region){
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."city
			WHERE name = ".$this->db->Quote($city)."
			AND region = ".$this->db->Quote($region)."
			AND shipping_comp = ".$this->db->Quote($shipping_comp)."
			AND closed = 0
			ORDER BY id_city";
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}

	// Список
	public function SetList($param = 0, $limit = ""){
		if($limit != ""){
			$limit = " limit ".$limit;
		}
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."city
			ORDER BY id_city".
			$limit;
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}

	// Добавление
	public function Add($arr){
		$f['id_delivery'] = $arr['id_delivery'];
		$f['name'] = $this->db->Quote($arr['name']);
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'delivery', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id;
	}

	// Обновление
	public function Update($arr){
		$f['id_delivery'] = $arr['id_delivery'];
		$f['name'] = $this->db->Quote($arr['name']);
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."delivery", $f, "id_delivery = {$f['id_delivery']}")){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	// Удаление
	public function Del($id){
		$sql = "DELETE FROM "._DB_PREFIX_."delivery WHERE id_delivery = ".$id;
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}

	// Сортировка
	public function Reorder($arr){
		foreach($arr['ord'] as $id=>$ord){
			$sql = "UPDATE "._DB_PREFIX_."delivery
				SET ord = ".$ord."
				WHERE id_delivery = ".$id;
			$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		}
	}
}

// Службы доставки
class DeliveryService {
	public $db;
	public $fields;
	private $usual_fields;
	public $list;

	/** Конструктор
	 * @return
	 */

	public function __construct(){
		$this->db =& $GLOBALS['db'];
		$this->usual_fields = array("id_city", "names_regions", "name", "region", "shipping_comp");
	}

	// по id
	public function SetFieldsById($id){
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."city
			WHERE shipping_comp = ".$id."
			AND closed = 0";
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		return true;
	}

	// по строке
	public function SetFieldsByInput($city, $region){
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."city
			WHERE name = ".$this->db->Quote($city)."
			AND region = ".$this->db->Quote($region)."
			AND shipping_comp <> ''
			AND closed = 0
			GROUP BY shipping_comp DESC";
		$res = $this->db->GetArray($sql);
		return $res;
	}

	// по строке
	public function GetAnyCityId($string){
		$string = $this->db->Quote($string);
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."city
			WHERE names_regions LIKE ".$this->db->Quote($string)."
			GROUP BY shipping_comp";
		$res = $this->db->GetOneRowArray($sql);
		return $res;
	}

	// Список
	public function SetList($param=0, $limit=""){
		if($limit != ""){
			$limit = " limit ".$limit;
		}

		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."city
			WHERE shipping_comp <> ''
			GROUP BY shipping_comp".
			$limit;
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}

	// Список отделений в выбраном городе по службе доставки
	public function GetListDepartmentByCity($delivery_sevice, $city){
		$sql = "SELECT id_city, address
			FROM "._DB_PREFIX_."city
			WHERE name = '". $city ."'
			AND shipping_comp = '". $delivery_sevice ."'";
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return $this->list;
	}
	// Список по региону
	public function SetListByRegion($nameRegion){
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."city
			WHERE shipping_comp <> ''
			AND names_regions LIKE ".$this->db->Quote($nameRegion)."
			AND address <> ''
			GROUP BY shipping_comp";
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}

	// Добавление
	public function Add($arr){
		$f['id_delivery_service'] = $arr['id_delivery_service'];
		$f['name'] = $this->db->Quote($arr['name']);
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'delivery_service', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id;
	}

	// Обновление
	public function Update($arr){
		$f['id_delivery_service'] = $arr['id_delivery_service'];
		$f['name'] = $this->db->Quote($arr['name']);
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."delivery_service", $f, "id_delivery_service = {$f['id_delivery_service']}")){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	// Удаление
	public function Del($id){
		$sql = "DELETE FROM "._DB_PREFIX_."delivery_service WHERE id_delivery_service = ".$id;
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}

	// Сортировка
	public function Reorder($arr){
		foreach($arr['ord'] as $id=>$ord){
			$sql = "UPDATE "._DB_PREFIX_."delivery_service
				SET ord = ".$ord."
				WHERE id_delivery_service = ".$id;
			$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		}
	}
}

class Parkings {
	public $db;
	public $fields;
	private $usual_fields;
	public $list;

	/** Конструктор
	 * @return
	 */

	public function __construct (){
		$this->db =& $GLOBALS['db'];
		$this->usual_fields = array("id_parking", "name", "ord");
	}

	// по id
	public function SetFieldsById($id){
		//$id = mysql_real_escape_string($id);
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."parking
			WHERE id_parking = ".$id;
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		return true;
	}

	// Список
	public function SetList($param=0, $limit=""){
		if($limit != ""){
			$limit = " limit ".$limit;
		}
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."parking
			order by ord, name".
			$limit;
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}

	// Добавление
	public function Add($arr){
		//$f['id_parking'] = mysql_real_escape_string(trim($arr['id_parking']));
		$f['id_parking'] = $arr['id_parking'];
		$f['name'] = $this->db->Quote($arr['name']);
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'parking', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id;
	}

	// Обновление
	public function Update($arr){
		$f['id_parking'] = $arr['id_parking'];
		$f['name'] = $this->db->Quote($arr['name']);
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."parking", $f, "id_parking = {$f['id_parking']}")){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	// Удаление
	public function Del($id){
		$sql = "DELETE FROM "._DB_PREFIX_."parking WHERE id_parking = ".$id;
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}

	// Сортировка
	public function Reorder($arr){
		foreach($arr['ord'] as $id=>$ord){
			$sql = "UPDATE "._DB_PREFIX_."parking
				SET ord = ".$ord."
				WHERE id_parking = ".$id;
			$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		}
	}
}
