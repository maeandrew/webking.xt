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
		$this->usual_fields = array('id', 'title', 'translit', 'content_preview', 'content', 'date', 'visible', 'ord', 'page_title', 'page_description', 'page_keywords', 'indexation', 'thumbnail', "date_update", "id_user");
	}

	// Статья по id
	public function SetFieldsById($id, $all=0){
		$visible = "AND visible = 1";
		if($all == 1){
			$visible = '';
		}
		$sql = "SELECT ".implode(', ', $this->usual_fields)."
			FROM "._DB_PREFIX_."post
			WHERE id = '".$id."'
			".$visible."
			ORDER BY ord";
		$this->fields = $this->db->GetOneRowArray($sql);
		if(isset($this->fields[id_user])) {
			$sqlUser = "SELECT `name`
				FROM " . _DB_PREFIX_ . "user
				WHERE id_user = '" . $this->fields[id_user] . "'";
			$this->fieldsU = $this->db->GetOneRowArray($sqlUser);
			foreach ($this->fieldsU as $v) {
				$this->fields['user'] = $v;
			}
		}
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
		list($d,$m,$y)		= explode(".", trim($arr['date']));
		$f['date']			= mktime(0, 0, 0, $m , $d, $y);
		$f['title'] = trim($arr['title']);
		$f['content_preview'] = trim($arr['content_preview']);
		$f['content'] = trim($arr['content']);
		$f['page_title'] = trim($arr['page_title']);
		$f['page_keywords'] = trim($arr['page_keywords']);
		$f['page_description'] = trim($arr['page_description']);
		$f['translit'] = G::StrToTrans($arr['title']);
		$f['visible'] = 1;
		$f['indexation'] = (isset($arr['indexation']) && $arr['indexation'] == "on")?1:0;
		$f['date_update']   = Date('Y-m-d H:i:s');
		$f['id_user']		= $_SESSION['member'][id_user];
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

//		$f['id'] = trim($arr['id']);
		list($d,$m,$y)		= explode(".", trim($arr['date']));
		$f['date']			= mktime(0, 0, 0, $m , $d, $y);
		$f['title'] = trim($arr['title']);
		$f['content_preview'] = trim($arr['content_preview']);
		$f['content'] = trim($arr['content']);
		$f['page_description'] = trim($arr['page_description']);
		$f['page_title'] = trim($arr['page_title']);
		$f['page_keywords'] = trim($arr['page_keywords']);
		$f['translit'] = G::StrToTrans($arr['title']);
		$f['visible'] = 1;
		$f['indexation'] = (isset($arr['indexation']) && $arr['indexation'] == "on")?1:0;
		$f['date_update']   = Date('Y-m-d H:i:s');
		$f['id_user']		= $_SESSION['member'][id_user];
		if(isset($arr['visible']) && $arr['visible'] == "on"){
			$f['visible'] = 0;
		}
//		print_r($f); die();
		$this->db->StartTrans();
		if(!$sql = $this->db->Update(_DB_PREFIX_."post", $f, "id = ".$arr['id'])){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		//return true;
//		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}

	// Удаление статьи
	public function DelPage($id){
		$imgdel = scandir((str_replace('adm\core/../', '', $GLOBALS['PATH_root'])).'post_images/'.$id);
		foreach($imgdel as $k=>$del_img){
			if($del_img!='.' && $del_img!='..') {
				unlink(str_replace('adm\core/../', '', $GLOBALS['PATH_root']) . 'post_images/' . $id . '/' . $del_img);
			}
		}
		rmdir(str_replace('adm\core/../../', '', $GLOBALS['PATH_post_img']).$id);
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
	// Статья по id
	public function LastPost(){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."post
			ORDER BY date";
		$res = $this->db->GetOneRowArray($sql);
		if(empty($res)){
			return false;
		}
		return $res;
	}

	// Добавление и удаление фото
	public function UpdatePhoto($id, $thumb = null){
		if(isset($thumb) && $thumb !='') {
			if(!file_exists($GLOBALS['PATH_global_root'] . 'post_images/' . $id.'/')){
				mkdir($GLOBALS['PATH_global_root'] . 'post_images/' . $id);
			}
			if( strpos ( $thumb, '/temp/') == true) {
				rename($GLOBALS['PATH_global_root'] . $thumb, $GLOBALS['PATH_global_root'] . str_replace('temp/', $id . '/thumb_', $thumb));
				$thumb = str_replace('temp/', $id . '/thumb_', $thumb);
			}
			if (empty($thumb)) {
				return false; //Если URL пустой
			}
			$sql = "UPDATE "._DB_PREFIX_."post SET `thumbnail` = '".$thumb."'
					WHERE id = $id";
			$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		}
		unset($id);
		unset($thumb);
		return true;//Если все ок
	}

}?>