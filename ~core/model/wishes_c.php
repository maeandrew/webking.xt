<?php
class Wishes {
	public $db;
	public $fields;
	private $usual_fields;
	public $list;
	public function __construct (){
		$this->db =& $GLOBALS['db'];
		$this->usual_fields = array("id_wishes", "id_reply", "author", "author_name", "author_email", "text_wishes", "date_wishes", "visible");
	}

	//Получение Списка предложений
	public function GetWishesList($vis = false){
		$date = time()-3600*24*30;
		if ($vis) {
			$visible = '';
		}else{
			$visible = 'w.visible = 1 AND UNIX_TIMESTAMP(w.date_wishes) > '.$date.' AND ';
		}
		$sql = "SELECT w.id_wishes, w.id_reply, w.text_wishes,
			(CASE
				WHEN w.author = 4028 THEN w.author_name
				ELSE (SELECT name FROM "._DB_PREFIX_."user WHERE id_user = w.author)
			END) AS name,
			w.date_wishes, w.visible
			FROM "._DB_PREFIX_."wishes AS w
			WHERE ".$visible."
			w.id_reply IS NULL
			ORDER BY w.date_wishes DESC";
		$arr = $this->db->GetArray($sql);
		foreach ($arr as &$value) {
			$sql2 = "SELECT w.id_wishes, w.id_reply, w.text_wishes,
			(CASE
				WHEN w.author = 4028 THEN w.author_name
				ELSE (SELECT name FROM "._DB_PREFIX_."user WHERE id_user = w.author)
			END) AS name,
			w.date_wishes, w.visible
			FROM "._DB_PREFIX_."wishes AS w
			WHERE ".$visible."
			w.id_reply = ".$value['id_wishes']."
			ORDER BY w.date_wishes DESC";
			$value['reply'] = $this->db->GetArray($sql2);
		}
		if(!$arr){
			return false;
		}else{
			return $arr;
		}
	}

	//Добавление Пожелания или предложения
	public function AddWishes($arr){
		if(!empty($arr['text_wishes'])){
			if(isset($arr['id_reply'])){
				$f['id_reply'] = mysql_real_escape_string(trim($arr['id_reply']));
			}
			$f['author'] = mysql_real_escape_string(trim($arr['author']));
			$f['author_name'] = mysql_real_escape_string(trim($arr['author_name']));
			$f['author_email'] = mysql_real_escape_string(trim($arr['author_email']));
			$f['text_wishes'] = mysql_real_escape_string(trim($arr['text_wishes']));
			if(isset($arr['visible'])){
				$f['visible'] = mysql_real_escape_string(trim($arr['visible']));
			}
			unset($arr);
			if(!$this->db->Insert(_DB_PREFIX_.'wishes', $f)){
				$this->db->FailTrans();
				return false; //Если не удалось записать в базу
			}
			unset($f);
			$this->db->CompleteTrans();
			return true;//Если все ок
		}else{
			return false; //Если имя пустое
		}
	}

	//Переключение видимости
	public function SwitchVisibleWishes($id_wishes,$vis){
		if($vis == 'show'){
			$visible = 1;
		}else{
			$visible = 0;
		}
		$this->db->StartTrans();
		$sql = "UPDATE "._DB_PREFIX_."wishes SET visible = ".$visible." WHERE id_wishes = ".$id_wishes;
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			G::DieLoger("SQL error - $sql");
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	// Удаление пожелания
	public function DeleteWishes($id_wishes){
		$sql = "DELETE FROM "._DB_PREFIX_."wishes WHERE id_wishes =  ".$id_wishes;
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}

}
?>