<?php
class Unit{
	public $db;
	public $fields;
	private $usual_fields;
	public $list;
	/** Конструктор
		 * @return
	 	 */
	 public function __construct (){
		$this->db =& $GLOBALS['db'];
		$this->usual_fields = array("id", "unit_xt", "unit_prom");
	}
			

	// по id
	public function SetFieldsById($id){
		$id = mysql_real_escape_string($id);		
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
				FROM "._DB_PREFIX_."units
				WHERE id = \"$id\"";
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}else{
			return true;
		}
	}	

	public function GetUnitsList(){
		$sql = "SELECT * FROM "._DB_PREFIX_."units";
		$res = $this->db->GetArray($sql);
		if(!$res){
			return false;
		}
		return $res;
	}

	// Список
	public function SetList($param=0, $limit=""){
		if($limit != ""){
			$limit = " limit $limit";
		}
		$sql = "SELECT *
			FROM "._DB_PREFIX_."units
			ORDER BY id
			$limit";
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}else{
			return true;
		}
	}

	// Добавление
	public function Add($arr){
		$f['id'] = mysql_real_escape_string(trim($arr['id']));
		$f['unit_xt'] = mysql_real_escape_string(trim($arr['unit_xt']));
		$f['unit_prom'] = mysql_real_escape_string(trim($arr['unit_prom']));
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'units', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id;
	}

	// Обновление
	public function Update($arr){
		$f['id'] = mysql_real_escape_string(trim($arr['id']));
		$f['unit_xt'] = mysql_real_escape_string(trim($arr['unit_xt']));
		$f['unit_prom'] = mysql_real_escape_string(trim($arr['unit_prom']));
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."units", $f, "id = {$f['id']}")){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
}
?>