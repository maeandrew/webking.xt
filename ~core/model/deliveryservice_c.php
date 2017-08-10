<?php
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
