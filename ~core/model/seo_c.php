<?php
class SEO{
	public $db;
	public $fields;
	private $usual_fields;
	public $list;
	public function __construct (){
		$this->db =& $GLOBALS['db'];
		$this->usual_fields = array("id", "url", "text", "author", "date_create", "visible");
	}
	// Проверка наличия такого url
	public function SetFieldsByUrl($url, $all = 0){
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."seo_text
			WHERE url = ".$this->db->Quote($url);
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		return true;
	}
	// Страница по id
	public function SetFieldsById($id_seo_text, $all = 0){

		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."seo_text
			WHERE id = \"$id_seo_text\"";
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		return true;
	}
	// Список SeoText
	public function SeoTextList($limit = ""){

		if($limit != ""){
			$limit = " limit $limit";
		}
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."seo_text
			ORDER BY id desc $limit";
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}

	// Добавить
	public function AddSeoText($arr){
		$f['url'] = trim($arr['url']);
		$f['text'] = trim($arr['text']);
		$f['visible'] = 0 + $arr['visible'];
		$f['author'] = trim($arr['author']);

		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'seo_text', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id_seo_text = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id_seo_text;
	}
	// Обновление
	public function UpdateSeoText($arr){
		$f['url'] = trim($arr['url']);
		$f['text'] = trim($arr['text']);
		$f['visible'] = (int)$arr['visible'];
		$f['author'] = trim($arr['author']);
		$f['id'] = trim($arr['id']);

		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."seo_text", $f, "id = {$f['id']}")){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	// Удаление страницы
	public function DelSeoText($id_seo_text){
		$sql = "DELETE FROM "._DB_PREFIX_."seo_text WHERE id =  $id_seo_text";
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}

	// Поиск
	public function Search($query){
		$sql = "SELECT id_seo_text, title, translit, SUBSTRING(content, 1,300) as content
			FROM "._DB_PREFIX_."seo_text
			WHERE visible = 1 AND title like \"%$query%\" OR content like \"%$query%\"";
		$this->list = $this->db->GetArray($sql);
		foreach($this->list as $li_id=>$li){
			$this->list[$li_id]['content'] = preg_replace("#<.*?(>|$)#is"," ",$li['content']);
		}
	}
}
?>