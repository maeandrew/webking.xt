<?php
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
