<?php
class Cron {

	public $db;
	public $fields;
	public $list;

	public function __construct(){
		$this->db =& $GLOBALS['db'];
	}

	public function SetFieldsById($id){
		$sql = 'SELECT * FROM '._DB_PREFIX_.'crontab AS c
		WHERE c.id = '.$this->db->Quote($id);
		if(!$this->fields = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return true;
	}

	public function Add($data){
		$f['title'] = $data['title'];
		$f['description'] = $data['description'];
		$f['alias'] = $data['alias'];
		$f['active'] = $data['active'];
		$f['year'] = $data['year'];
		$f['mon'] = $data['mon'];
		$f['mday'] = $data['mday'];
		$f['hours'] = $data['hours'];
		$f['minutes'] = $data['minutes'];
		$f['author'] = $_SESSION['member']['id_user'];
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'crontab', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id;
	}

	public function Update($data){
		if(isset($data['title'])){
			$f['title'] = trim($data['title']);
		}
		if(isset($data['description'])){
			$f['description'] = trim($data['description']);
		}
		if(isset($data['alias'])){
			$f['alias'] = trim($data['alias']);
		}
		if(isset($data['active'])){
			$f['active'] = trim($data['active']);
		}
		if(isset($data['year'])){
			$f['year'] = trim($data['year']);
		}
		if(isset($data['mon'])){
			$f['mon'] = trim($data['mon']);
		}
		if(isset($data['mday'])){
			$f['mday'] = trim($data['mday']);
		}
		if(isset($data['hours'])){
			$f['hours'] = trim($data['hours']);
		}
		if(isset($data['minutes'])){
			$f['minutes'] = trim($data['minutes']);
		}
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_.'crontab', $f, 'id = '.$data['id'])){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function Delete($id){
		$f[] = 'id = '.$id;
		if(!$this->db->DeleteRowsFrom(_DB_PREFIX_.'crontab', $f)){
			return false;
		}
		return true;
	}

	public function Run($task){
		include(_root.'cron'.DIRSEP.$task['alias'].'.php');
		$this->RegisterLastRun($task['id']);
		return true;
	}

	public function CheckTiming($task){
		$timing = [
			'year' => $task['year'],
			'mon' => $task['mon'],
			'mday' => $task['mday'],
			'hours' => $task['hours'],
			'minutes' => $task['minutes']
		];
		$current_date = getdate();
		$run = true;
		foreach($timing as $key => $value){
			// var_dump($value);
			if(strpos($value, '-')){
				preg_match_all('/(\d+)-(\d+)/', $value, $matches);
				foreach($matches[0] as $k => $v){
					$n_string = '';
					for($i = $matches[1][$k]; $i <= $matches[2][$k]; $i++) {
						$n_string .= $i;
						if($i < $matches[2][$k]){
							$n_string .= ',';
						}
					}
					$value = str_replace($v, $n_string, $value);
				}
			}
			if(strpos($value, ',')){
				$$key = explode(',', $value);
				if(!in_array($current_date[$key], $$key)){
					$run = false;
				}
			}else{
				if($value !== '*' && (int) $value !== $current_date[$key]){
					$run = false;
				}
			}
		}
		if(!$run){
			return false;
		}
		if(!$this->Run($task)){
			return false;
		}
		return true;
	}

	public function CheckAliasUniqueness($alias){
		$sql = 'SELECT * FROM '._DB_PREFIX_.'crontab AS c
			WHERE c.alias = '.$this->db->Quote($alias);
		if($this->db->GetArray($sql)){
			return false;
		}
		return true;
	}

	public function SetList(){
		$sql = 'SELECT *
			FROM '._DB_PREFIX_.'crontab';
		if(!$this->list = $this->db->GetArray($sql)){
			return false;
		}
		return true;
	}

	public function RegisterLastRun($id){
		$f['last_run'] = date('Y-m-d H:i:s');
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_.'crontab', $f, 'id = '.$id)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
}