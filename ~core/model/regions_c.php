<?php
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
