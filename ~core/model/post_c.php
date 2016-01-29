<?php
class Post {
	public $db;
	public $fields;
	public $list;
	/** Конструктор
	 * @return
	 */
	public function __construct(){
		$this->db =& $GLOBALS['db'];
		$this->usual_fields = array('id', 'title', 'translit', 'content_preview', 'content', 'date', 'visible', 'ord', 'page_title', 'page_description', 'page_keywords');
	}

	// Статья по id
	public function SetFieldsById($id, $all=0){
		$visible = "AND visible = 1";
		if($all == 1){
			$visible = '';
		}
		$id = mysql_real_escape_string($id);
		$sql = "SELECT ".implode(', ', $this->usual_fields)."
			FROM "._DB_PREFIX_."post
			WHERE id = '".$id."'
			".$visible."
			ORDER BY ord";
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		return true;
	}

	// Статья по транслиту
	public function SetFieldsByRewrite($rewrite, $all = 0){
		$visible = "AND visible = 1";
		if($all == 1){
			$visible = '';
		}
		$sql = "SELECT ".implode(', ', $this->usual_fields)."
			FROM "._DB_PREFIX_."post
			WHERE translit = ".$this->db->Quote($rewrite)."
			".$visible."
			ORDER BY ord";
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		return true;
	}

	// Статья по id
	public function SetList($all = 0){
		$visible = "WHERE visible = 1";
		if($all == 1){
			$visible = '';
		}
		$sql = "SELECT ".implode(', ', $this->usual_fields)."
			FROM "._DB_PREFIX_."post
			".$visible."
			ORDER BY ord";
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}
	// Добавить статью
	public function AddPost($arr){
		$f['title'] = mysql_real_escape_string(trim($arr['title']));
		$f['content_preview'] = mysql_real_escape_string(trim($arr['content_preview']));
		$f['content'] = mysql_real_escape_string(trim($arr['content']));
		$f['page_title'] = mysql_real_escape_string(trim($arr['page_title']));
		$f['page_keywords'] = mysql_real_escape_string(trim($arr['page_keywords']));
		$f['page_description'] = mysql_real_escape_string(trim($arr['page_description']));
		$f['translit'] = G::StrToTrans($arr['title']);
		$f['visible'] = 1;
		if(isset($arr['visible']) && $arr['visible'] == "on"){
			$f['visible'] = 0;
		}
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'post', $f)){
			$this->db->FailTrans();
			return false; //Если не удалось записать в базу
		}
		unset($f);
		$id = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id;
	}

	// Обновление статьи
	public function UpdatePost($arr){
		$f['id'] = mysql_real_escape_string(trim($arr['id']));
		$f['title'] = mysql_real_escape_string(trim($arr['title']));
		$f['content_preview'] = mysql_real_escape_string(trim($arr['content_preview']));
		$f['content'] = mysql_real_escape_string(trim($arr['content']));
		$f['page_description'] = mysql_real_escape_string(trim($arr['page_description']));
		$f['page_title'] = mysql_real_escape_string(trim($arr['page_title']));
		$f['page_keywords'] = mysql_real_escape_string(trim($arr['page_keywords']));
		$f['translit'] = G::StrToTrans($arr['title']);
		$f['visible'] = 1;
		if(isset($arr['visible']) && $arr['visible'] == "on"){
			$f['visible'] = 0;
		}
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."post", $f, "id = ".$id)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		//return true;
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}

	// Удаление статьи
	public function DelPage($id){
		$sql = "DELETE FROM "._DB_PREFIX_."post WHERE id = ".$id;
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}

	// Сортировка статей
	public function Reorder($arr){
		foreach($arr['ord'] as $id=>$ord){
			$sql = "UPDATE "._DB_PREFIX_."post
				SET ord = ".$ord."
				WHERE id_page = ".$id;
			$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		}
	}
}?>