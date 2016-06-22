<?php
// Адреса
class Address {
	public $db;
	
	public function __construct (){
		$this->db =& $GLOBALS['db'];
	}
	/**
	 * [GetRegionsList description]
	 */
	public function GetRegionsList(){
		$sql = "SELECT DISTINCT c.region
			FROM "._DB_PREFIX_."city AS c
			WHERE c.region <> ''";
			// print_r($sql);die();
		if(!$res = $this->db->GetArray($sql)){
			return false;
		}
		return $res;
	}
	/**
	 * [GetRegionById description]
	 * @param [type] $id [description]
	 */
	public function GetRegionById($id){
		$sql = "SELECT c.region
			FROM "._DB_PREFIX_."city AS c
			WHERE c.id_city = ".$id;
		if(!$res = $this->db->GetArray($sql)){
			return false;
		}
		return $res;
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
		$sql = "DELETE FROM "._DB_PREFIX_."region WHERE id_region =  ".$id;
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
	public function SetFieldsByInput($string, $city){
		$string = $this->db->Quote($string);
		$city = $this->db->Quote($city);
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."city
			WHERE names_regions LIKE ".$city."
			AND shipping_comp LIKE ".$string."
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
	public function SetFieldsByInput($string){
		$string = $this->db->Quote($string);
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."city
			WHERE names_regions LIKE ".$string."
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
