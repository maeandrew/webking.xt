<?php
class Page {
	public $db;
	public $fields;
	public $list;
	/** Конструктор
	 * @return
	 */
	public function __construct (){
		$this->db =& $GLOBALS['db'];
		$this->usual_fields = array('id_page', 'title', 'translit', 'content', 'new_content', 'ord', 'visible', 'ptype', 'page_title', 'page_description', 'page_keywords');
	}
	// Страница по транслиту
	public function SetFieldsByTranslit($translit, $all = 0){
		$visible = "AND visible = 1";
		if($all == 1){
			$visible = '';
		}
		$translit = mysql_real_escape_string($translit);
		$sql = "SELECT ".implode(', ', $this->usual_fields)."
			FROM "._DB_PREFIX_."page
			WHERE translit = '".$translit."'
			".$visible."
			ORDER BY ord";
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		return true;
	}
	// Страница по id
	public function SetFieldsById($id_page, $all=0){
		$visible = "AND visible = 1";
		if($all == 1){
			$visible = '';
		}
		$id_page = mysql_real_escape_string($id_page);
		$sql = "SELECT ".implode(', ', $this->usual_fields)."
			FROM "._DB_PREFIX_."page
			WHERE id_page = '".$id_page."'
			".$visible."
			ORDER BY ord";
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		return true;
	}
	// Список страниц (0 - только видимые. 1 - все, и видимые и невидимые)
	public function PagesList($param=0){
		$where = "WHERE visible = 1 ";
		if($param == 1){
			$where = '';
		}elseif($param == "menu"){
			$where .= "AND ptype=\"menu\"";
		}
		$sql = "SELECT ".implode(', ', $this->usual_fields)."
			FROM "._DB_PREFIX_."page
			".$where."
			ORDER BY ord";
		$this->list = $this->db->GetArray($sql);
		//print_r($this->list);die();
		if (!$this->list)
			return false;
		else
			return true;
	}

	// Список страниц (0 - только видимые. 1 - все, и видимые и невидимые)
	public function PagesListByType($type){
		$sql = "SELECT ".implode(', ', $this->usual_fields)."
			FROM "._DB_PREFIX_."page
			WHERE ptype = '".$type."'
			AND visible = 1
			ORDER BY ord";
		$arr = $this->db->GetArray($sql);
		return $arr;
	}

	public function GetPagesTypesList(){
		$sql = "SELECT name, caption
			FROM "._DB_PREFIX_."page_type";
		return $this->db->GetArray($sql);
	}

	// Добавить статью
	public function AddPage($arr){
		$title = mysql_real_escape_string(trim($arr['title']));
		$content = mysql_real_escape_string(trim($arr['pcontent']));
		$ptype = mysql_real_escape_string(trim($arr['ptype']));
		$translit = G::StrToTrans($title);
		$visible = 1;
		if(isset($arr['visible']) && $arr['visible'] == "on"){
			$visible = 0;
		}
		$sql = "INSERT INTO "._DB_PREFIX_."page (title, translit, content, visible, ptype)
			VALUES ('".$title."', '".$translit."', '".$content."', ".$visible.", '".$ptype."')";
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		$id_page = $this->db->GetInsId();
		return $id_page;
	}

	// Обновление статьи
	public function UpdatePage($arr){
		$id_page = mysql_real_escape_string(trim($arr['id_page']));
		$title = mysql_real_escape_string(trim($arr['title']));
		$page_description = mysql_real_escape_string(trim($arr['page_description']));
		$page_title = mysql_real_escape_string(trim($arr['page_title']));
		$page_keywords = mysql_real_escape_string(trim($arr['page_keywords']));
		$content = mysql_real_escape_string(trim($arr['pcontent']));
		$ptype = mysql_real_escape_string(trim($arr['ptype']));
		$translit = G::StrToTrans($title);
		$visible = 1;
		if(isset($arr['visible']) && $arr['visible'] == "on"){
			$visible = 0;
		}
		$sql = "UPDATE "._DB_PREFIX_."page
			SET title = '".$title."',
				translit = '".$translit."',
				content = '".$content."',
				ptype = '".$ptype."',
				page_description = '".$page_description."',
				page_title = '".$page_title."',
				page_keywords = '".$page_keywords."',
				visible = ".$visible."
			WHERE id_page = ".$id_page;
		//return true;
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}

	// Удаление страницы
	public function DelPage($id_page){
		$sql = "DELETE FROM "._DB_PREFIX_."page WHERE id_page = ".$id_page;
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}

	// Сортировка страниц
	public function Reorder($arr){
		foreach($arr['ord'] as $id_page=>$ord){
			$sql = "UPDATE "._DB_PREFIX_."page
				SET ord = ".$ord."
				WHERE id_page = $id_page";
			$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		}
	}
	// Поиск
	public function Search($query){
		$sql = "SELECT id_page, title, translit,
				SUBSTRING(content, 1,300) as contentб
				ord, visible, ptype
			FROM "._DB_PREFIX_."page
			WHERE visible = 1
			AND title LIKE '%".$query."%'
			OR content LIKE '%".$query."%'";
		$this->list = $this->db->GetArray($sql);
		foreach($this->list as $li_id=>$li){
			$this->list[$li_id]['content'] = preg_replace("#<.*?(>|$)#is"," ",$li['content']);
		}
	}
}
?>