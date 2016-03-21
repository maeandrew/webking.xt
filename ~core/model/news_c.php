<?php
class News{
	public $db;
	public $fields;
	public $images;
	private $usual_fields;
	public $list;
	public function __construct (){
		$this->db =& $GLOBALS['db'];
		$this->usual_fields = array("id_news", "title", "translit", "descr_short", "descr_full", "date", "visible", "ord", "page_title", "page_description", "page_keywords", "indexation");
	}
	// Страница по транслиту
	public function SetFieldsByRewrite($rewrite, $all = 0){
		$visible = "AND visible = 1";
		if($all == 1){
			$visible = '';
		}
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."news
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
	public function SetFieldsById($id_news, $all = 0){
		$visible = "AND visible = 1";
		if($all == 1){
			$visible = '';
		}
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."news
			WHERE id_news = \"$id_news\"
			$visible
			ORDER BY ord";
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		$sqlImage = "SELECT src
			FROM "._DB_PREFIX_."image_news
			WHERE id_news = \"$id_news\"";
		$this->fields['Img'] = $this->db->GetArray ($sqlImage);
		return true;
	}


	// Список (0 - только видимые. 1 - все, и видимые и невидимые)
	public function NewsList($param = 0, $limit = ""){
		$where = "WHERE visible = 1 ";
		if($param == 1){
			$where = '';
		}
		if($limit != ""){
			$limit = "LIMIT $limit";
		}
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."news
			$where
			ORDER BY date desc, ord $limit";
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}

	public function NewsList1(){
		$date2 = time()-3600*24*30;
		$sql = "SELECT cm.Id_coment,
			(CASE
				WHEN cm.author = 4028 THEN cm.author_name
				ELSE (SELECT name FROM "._DB_PREFIX_."user WHERE id_user = cm.author)
			END) AS username,
			cm.url_coment,cm.author, cm.date_comment, cm.text_coment,
			cm.visible, p.name
			FROM "._DB_PREFIX_."coment AS cm
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON cm.url_coment = p.id_product
			WHERE UNIX_TIMESTAMP(cm.date_comment) > ".$date2."
			ORDER BY cm.date_comment desc";
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}

	//Получение списка комментариев для продукта
	public function GetCommentListById($id_product){
		$sql = "SELECT cm.Id_coment,
			(CASE
				WHEN cm.author = 4028 THEN cm.author_name
				ELSE (SELECT name FROM "._DB_PREFIX_."user WHERE id_user = cm.author)
			END) AS username,
			cm.url_coment,cm.author, cm.date_comment, cm.text_coment,
			cm.visible, p.name
			FROM "._DB_PREFIX_."coment AS cm
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON cm.url_coment = p.id_product
			WHERE cm.url_coment =".$id_product."
			ORDER BY cm.date_comment desc";
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}
	// get comments count by date
	public function GetCommentsCountByDate($date){
		$sql = "SELECT '".$date."' AS date, IFNULL((SELECT COUNT(c.Id_coment)
			FROM "._DB_PREFIX_."coment AS c
			WHERE DATE_FORMAT(from_unixtime(c.data_coment),'%d-%m-%Y') = '".$date."'
			GROUP BY DATE_FORMAT(from_unixtime(c.data_coment),'%d-%m-%Y')), 0) AS count";
		if(!$arr = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $arr;
	}
	public function ShowComent($Id_coment){
		$this->db->StartTrans();
		$sql = "UPDATE "._DB_PREFIX_."coment SET visible = 1 WHERE Id_coment = ".$Id_coment;
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			G::DieLoger("SQL error - $sql");
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function HideComent($Id_coment){
		$this->db->StartTrans();
		$sql = "UPDATE "._DB_PREFIX_."coment SET visible = 0 WHERE Id_coment = ".$Id_coment;
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			G::DieLoger("SQL error - $sql");
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function DropComent($Id_coment){
		$sql = "DELETE FROM "._DB_PREFIX_."coment WHERE Id_coment =  $Id_coment";
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}

	public function GetComent(){
		$sql = "SELECT Id_coment
			FROM "._DB_PREFIX_."coment
			WHERE visible=1";
		$arr = $this->db->GetArray($sql,"Id_coment");
		return $arr;
	}

	// Добавить
	public function AddNews($arr){
		$f['title'] = trim($arr['title']);
		$f['descr_short'] = trim($arr['descr_short']);
		$f['descr_full'] = trim($arr['descr_full']);
		list($d,$m,$y) = explode(".", trim($arr['date']));
		$f['date'] = mktime(0, 0, 0, $m , $d, $y);
		$f['translit'] = G::StrToTrans($f['title']);
		$f['visible'] = 1;
		$f['indexation'] = (isset($arr['indexation']) && $arr['indexation'] == "on")?1:0;
		if(isset($arr['visible']) && $arr['visible'] == "on"){
			$f['visible'] = 0;
		}
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'news', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id_news = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id_news;
	}
	// Обновление статьи
	public function UpdateNews($arr){
		$f['id_news'] = trim($arr['id_news']);
		$f['title'] = trim($arr['title']);
		$f['page_description'] = trim($arr['page_description']);
		$f['page_title'] = trim($arr['page_title']);
		$f['page_keywords'] = trim($arr['page_keywords']);
		$f['descr_short'] = trim($arr['descr_short']);
		$f['descr_full'] = trim($arr['descr_full']);
		list($d,$m,$y) = explode(".", trim($arr['date']));
		$f['date'] = mktime(0, 0, 0, $m , $d, $y);
		$f['translit'] = G::StrToTrans($f['title']);
		$f['visible'] = 1;
		$f['indexation'] = (isset($arr['indexation']) && $arr['indexation'] == "on")?1:0;
		if(isset($arr['visible']) && $arr['visible'] == "on"){
			$f['visible'] = 0;
		}
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."news", $f, "id_news = {$f['id_news']}")){
			$this->db->FailTrans();
			return false;
		}
		$id_news = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return true;
	}
	// Удаление страницы
	public function DelNews($id_news){
		$sql = "DELETE FROM "._DB_PREFIX_."news WHERE `id_news` = $id_news";
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}
	// Сортировка страниц
	public function Reorder($arr){
		foreach($arr['ord'] as $id_news=>$ord){
			$sql = "UPDATE "._DB_PREFIX_."news SET `ord` = $ord
				WHERE id_news = $id_news";
			$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		}
	}

	public function LastNews(){
		$sql = "SELECT date, title, translit, descr_short FROM "._DB_PREFIX_."news ORDER BY date DESC";
		$res = $this->db->GetOneRowArray($sql);
		return $res;
	}
	// Добавление и удаление фото
	public function UpdatePhoto($id_news, $arr){
		//$id_news = '430';
		$sql = "DELETE FROM "._DB_PREFIX_."image_news WHERE id_news=".$id_news;
		$this->db->StartTrans();// echo '1'; die();
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		$this->db->CompleteTrans();
		$f['id_news'] = trim($id_news);
		if(isset($arr) && !empty($arr)){
			foreach ($arr as $k=>$src) {
				if(empty($src)){
					return false; //Если URL пустой
				}
				$f['src'] = trim($src);
				$this->db->StartTrans();
				if(!$this->db->Insert(_DB_PREFIX_.'image_news', $f)){
					$this->db->FailTrans();
					return false; //Если не удалось записать в базу
				}
				$this->db->CompleteTrans();
			}
		}

		unset($id_news);
		unset($f);
		return true;//Если все ок
	}

	//Достать Id новости
//	public function GetID($id){
//		$sql = "SELECT id
//			FROM "._DB_PREFIX_."news
//			WHERE id_news = ".$id;
//		$arr = $this->db->GetOneRowArray($sql);
//		if(!$arr){
//			return false;
//		}else{
//			return $arr;
//		}
//	}
}
?>