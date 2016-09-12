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
		$this->usual_fields = array('id_page', 'title', 'title_ua', 'translit',
			'content', 'content_ua', 'new_content', 'ord', 'visible', 'ptype',
			'page_title', 'page_title_ua', 'page_description', 'page_description_ua',
			'page_keywords', 'page_keywords_ua', 'indexation', 'sid');
	}

	// Страница по транслиту
	public function SetFieldsByRewrite($rewrite, $all = 0){
		$visible = "AND visible = 1";
		if($all == 1){
			$visible = '';
		}
		$sql = "SELECT ".implode(', ', $this->usual_fields)."
			FROM "._DB_PREFIX_."page
			WHERE translit = ".$this->db->Quote($rewrite)."
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
			$where = 'WHERE sid = 1';
		}elseif($param == "menu"){
			$where .= "AND ptype = 'menu' AND sid = 1";
		}
		$sql = "SELECT ".implode(', ', $this->usual_fields)."
			FROM "._DB_PREFIX_."page
			".$where."
			ORDER BY ord";
		$this->list = $this->db->GetArray($sql);
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
			AND sid = 1
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
		if(isset($arr['title'])){
			$f['title'] = trim($arr['title']);
			$f['translit'] = G::StrToTrans($arr['title']);
		}
		if(isset($arr['title_ua'])){
			$f['title_ua'] = trim($arr['title_ua']);
		}
		if(isset($arr['editor'])){
			$f['content'] = trim($arr['editor']);
		}
		if(isset($arr['editor_ua'])){
			$f['content_ua'] = trim($arr['editor_ua']);
		}
		if(isset($arr['page_description'])){
			$f['page_description'] = trim($arr['page_description']);
		}
		if(isset($arr['page_description_ua'])){
			$f['page_description_ua'] = trim($arr['page_description_ua']);
		}
		if(isset($arr['page_title'])){
			$f['page_title'] = trim($arr['page_title']);
		}
		if(isset($arr['page_title_ua'])){
			$f['page_title_ua'] = trim($arr['page_title_ua']);
		}
		if(isset($arr['page_keywords'])){
			$f['page_keywords'] = trim($arr['page_keywords']);
		}
		if(isset($arr['page_keywords_ua'])){
			$f['page_keywords_ua'] = trim($arr['page_keywords_ua']);
		}
		if(isset($arr['ptype'])){
			$f['ptype'] = trim($arr['ptype']);
		}
		$f['indexation'] = (isset($arr['indexation']) && $arr['indexation'] == "on") ? 1 : 0;
		$f['visible'] = 1;
		if(isset($arr['visible']) && $arr['visible'] == "on"){
			$f['visible'] = 0;
		}
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'page', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id_page = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id_page;
	}

	// Обновление статьи
	public function UpdatePage($arr){
		if(isset($arr['title'])){
			$f['title'] = trim($arr['title']);
			$f['translit'] = G::StrToTrans($arr['title']);
		}
		if(isset($arr['title_ua'])){
			$f['title_ua'] = trim($arr['title_ua']);
		}
		if(isset($arr['editor'])){
			$f['content'] = trim($arr['editor']);
		}
		if(isset($arr['editor_ua'])){
			$f['content_ua'] = trim($arr['editor_ua']);
		}
		if(isset($arr['page_description'])){
			$f['page_description'] = trim($arr['page_description']);
		}
		if(isset($arr['page_description_ua'])){
			$f['page_description_ua'] = trim($arr['page_description_ua']);
		}
		if(isset($arr['page_title'])){
			$f['page_title'] = trim($arr['page_title']);
		}
		if(isset($arr['page_title_ua'])){
			$f['page_title_ua'] = trim($arr['page_title_ua']);
		}
		if(isset($arr['page_keywords'])){
			$f['page_keywords'] = trim($arr['page_keywords']);
		}
		if(isset($arr['page_keywords_ua'])){
			$f['page_keywords_ua'] = trim($arr['page_keywords_ua']);
		}
		if(isset($arr['ptype'])){
			$f['ptype'] = trim($arr['ptype']);
		}
		$f['indexation'] = (isset($arr['indexation']) && $arr['indexation'] == "on") ? 1 : 0;
		$f['visible'] = 1;
		if(isset($arr['visible']) && $arr['visible'] == "on"){
			$f['visible'] = 0;
		}
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."page", $f, "id_page = {$arr['id_page']}")){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
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