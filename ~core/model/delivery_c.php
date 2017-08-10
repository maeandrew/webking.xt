<?php
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
