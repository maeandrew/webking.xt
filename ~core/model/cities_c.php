<?php
class Cities {
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
