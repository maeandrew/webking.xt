<?php
class Profiles {
	public	$db;
	public	$fields;
	public	$list;
	private	$db_table;

	public function __construct(){
		$this->db =& $GLOBALS['db'];
		$this->db_table = strtolower(__CLASS__);
	}
	/**
	 * [SetList description]
	 */
	public function SetList(){
		$sql = 'SELECT * FROM '._DB_PREFIX_.$this->db_table;
		if(!$this->list = $this->db->GetArray($sql)){
			return false;
		}
		foreach($this->list as &$value){
			$value['permissions'] = $this->ParsePermissions($value['permissions']);
		}
		return $this->list;
	}
	/**
	 * [SetFieldsById description]
	 * @param [type] $id [description]
	 */
	public function SetFieldsById($id){
		$sql = 'SELECT *
			FROM '._DB_PREFIX_.$this->db_table.'
			WHERE id_profile = '.$id;
		if(!$this->fields = $this->db->GetOneRowArray($sql)){
			return false;
		}
		$this->fields['permissions'] = $this->ParsePermissions($this->fields['permissions']);
		return true;
	}
	/**
	 * [GetUsersByProfileId description]
	 * @param [type] $id [description]
	 */
	public function GetUsersByProfileId($id){
		$sql = 'SELECT *
			FROM '._DB_PREFIX_.'user
			WHERE gid = '.$id;
		if(!$this->list = $this->db->GetArray($sql)){
			return false;
		}
		return $this->list;
	}
	/**
	 * [Update description]
	 * @param [type] $data [description]
	 */
	public function Update($data){
		$f['name'] = trim($data['name']);
		$f['caption'] = trim($data['caption']);
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_.$this->db_table, $f, 'id_profile = '.$data['id_profile'])){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	/**
	 * [Add description]
	 * @param [type] $data [description]
	 */
	public function Add($data){
		$f['name'] = trim($data['name']);
		$f['caption'] = trim($data['caption']);
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.$this->db_table, $f)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	/**
	 * [ParsePermissions description]
	 * @param [type] $arr [description]
	 */
	private function ParsePermissions($perms){
		switch ($perms) {
			case '0':
				$result = 0;
				break;
			case '1':
				$result = 1;
				break;
			default:
				$arr = explode(';', $perms);
				foreach($arr as &$value){
					preg_match('/(^.*)=(1|0),(1|0),(1|0),(1|0)$/', $value, $matches);
					list($a, $res['name'], $res['view'], $res['add'], $res['edit'], $res['del']) = $matches;
					$result[$res['name']] = $res;
				}
				break;
		}
		return $result;
	}
}
