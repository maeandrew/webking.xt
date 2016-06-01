<?php
class Profiles {
	public $db;
	public $fields;
	public $list;
	private $table;

	public function __construct(){
		$this->db =& $GLOBALS['db'];
		$this->table = strtolower(__CLASS__);
	}

	public function SetList(){
		$sql = 'SELECT * FROM '._DB_PREFIX_.$this->table;
		if(!$this->list = $this->db->GetArray($sql)){
			return false;
		}
		return $this->list;
	}

	public function SetFieldsByID($id){
		$sql = 'SELECT * FROM '._DB_PREFIX_.$this->table.'
			WHERE id_profile = '.$id;
		if(!$this->fields = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return true;
	}
	public function Update($data){
		$f['name'] = trim($data['name']);
		$f['caption'] = trim($data['caption']);
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_.$this->table, $f, 'id_profile = '.$data['id_profile'])){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
}
