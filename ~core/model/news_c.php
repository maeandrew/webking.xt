<?php
class News{
	public $db;
	public $fields;
	public $images;
	private $usual_fields;
	public $list;
	public function __construct (){
		$this->db =& $GLOBALS['db'];
		$this->usual_fields = array('id_news', 'title', 'translit',
			'descr_short', 'descr_full', 'date', 'visible', 'ord',
			'page_title', 'page_description', 'page_keywords',
			'indexation', 'sid', 'thumbnail', 'date_update', 'id_user');
	}
	/**
	 * Получить поля новости по транслиту
	 * @param string  $rewrite Транслит новости
	 * @param boolean $visible true - показать только видимые новости, false - все
	 * @param integer $sid     идентификатор магазина
	 */
	public function SetFieldsByRewrite($rewrite, $visible = true, $sid = null){
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."news
			WHERE translit = ".$this->db->Quote($rewrite).
			($visible?' AND visible = 1':null).
			(isset($sid)?' AND sid = '.$sid:null);
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		return true;
	}
	/**
	 * Получить поля новости по id
	 * @param integer $id_news id новости
	 * @param boolean $visible true - показать только видимые новости, false - все
	 * @param integer $sid     идентификатор магазина
	 */
	public function SetFieldsById($id_news, $visible = true, $sid = null){
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."news
			WHERE id_news = '".$id_news."'".
			($visible?' AND visible = 1':null).
			(isset($sid)?' AND sid = '.$sid:null)."
			ORDER BY ord";
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		$sqlImage = "SELECT id_news, src
			FROM "._DB_PREFIX_."image_news
			WHERE id_news = '".$id_news."'";
		$this->fields['Img'] = $this->db->GetArray($sqlImage);
		if(isset($this->fields[id_user])) {
			$sqlUser = "SELECT `name`
				FROM " . _DB_PREFIX_ . "user
				WHERE id_user = '" . $this->fields[id_user] . "'";
			$this->fieldsU = $this->db->GetOneRowArray($sqlUser);
			foreach ($this->fieldsU as $v) {
				$this->fields['user'] = $v;
			}
		}
		return true;
	}

	// Список (0 - только видимые. 1 - все, и видимые и невидимые)
	public function NewsList($param = 0, $limit = "", $sid = null){
		$where = " WHERE visible = 1 ".(isset($sid)?' AND sid = '.$sid:null);
		if($param == 1){
			$where = isset($sid)?' WHERE sid = '.$sid:null;
		}
		if($limit != ""){
			$limit = "LIMIT $limit";
		}
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."news".
			$where."
			ORDER BY date desc, ord".
			$limit;
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}

	public function SetListComment($limit = false){
		$sql = "SELECT cm.Id_coment, (CASE WHEN cm.author = 4028 THEN cm.author_name ELSE
				(SELECT name FROM xt_user WHERE id_user = cm.author) END) AS username, cm.url_coment,cm.author,
				cm.date_comment, cm.text_coment, cm.visible, p.name, cm.rating, p.translit, cm.pid_comment,
				(CASE
					WHEN (SELECT COUNT(*) FROM xt_coment AS c2 WHERE c2.pid_comment = cm.Id_coment) > 0
					THEN (SELECT MAX(c2.date_comment) FROM xt_coment AS c2 WHERE c2.pid_comment = cm.Id_coment)
				   ELSE cm.date_comment
				END) AS sort
				FROM xt_coment AS cm
				LEFT JOIN xt_product AS p ON cm.url_coment = p.id_product
				WHERE cm.pid_comment IS NULL".
				($limit !== false?' ORDER BY sort DESC'.$limit:'');
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		if($limit !== false) {
			foreach ($this->list as &$v) {
				$sql = "SELECT cm.Id_coment, (CASE WHEN cm.author = 4028 THEN cm.author_name ELSE (SELECT name FROM xt_user WHERE id_user = cm.author) END) AS username,
					cm.url_coment,cm.author, cm.date_comment,
					cm.text_coment, cm.visible, p.name, cm.rating, p.translit, cm.pid_comment
					FROM xt_coment AS cm
					LEFT JOIN xt_product AS p ON cm.url_coment = p.id_product
					WHERE cm.pid_comment = ".$v['Id_coment']."
					ORDER BY data_coment DESC";
				$v['answer'] = $this->db->GetArray($sql);
			}
		}


//		if($limit !== false){
//			foreach($this->list as $k=>&$v){
//				if($v['pid_comment'] !== null) {
//					foreach($this->list as &$val){
//						if($val['Id_coment'] == $v['pid_comment']){
//							$val['answer'][] = $v;
//						}
//					}
//					unset($this->list[$k]);
//				}
//			}
//		}
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
		$f['title']				= trim($arr['title']);
		$f['descr_short']		= trim($arr['descr_short']);
		$f['descr_full']		= trim($arr['descr_full']);
		list($d,$m,$y)			= explode(".", trim($arr['date']));
		$f['date']				= mktime(0, 0, 0, $m , $d, $y);
		$f['translit']			= G::StrToTrans($f['title']);
		$f['sid']				= $arr['sid'];
		$f['indexation']		= (isset($arr['indexation']) && $arr['indexation'] == "on")?1:0;
		$f['visible']			= isset($arr['visible']) && $arr['visible'] == "on"?0:1;
		$f['date_update']   	= Date('Y-m-d H:i:s');
		$f['id_user']			= $_SESSION['member'][id_user];
		$f['page_title']		= trim($arr['page_title']);
		$f['page_description']	= trim($arr['page_description']);
		$f['page_keywords']		= trim($arr['page_keywords']);
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
		if(strpos($arr['thumb'], '/temp/') !== false){
			$images = new Images();
			$path = $GLOBALS['PATH_news_img'].$arr['id_news'].'/';
			$images->checkStructure($path);
			$file = pathinfo($GLOBALS['PATH_global_root'].$arr['thumb']);
			if(preg_match('/[А-Яа-яЁё]/u', $arr['thumb'])){
				$file['filename'] = G::StrToTrans($file['filename']);
				$file['basename'] = $file['filename'].'.'.$file['extension'];
			}
			$new_file = $path.$file['basename'];
			rename($GLOBALS['PATH_global_root'].$arr['thumb'], $new_file);
			$arr['thumb'] = str_replace($GLOBALS['PATH_global_root'], '/', $new_file);
		}
		$f['title']				= trim($arr['title']);
		$f['descr_short']		= trim($arr['descr_short']);
		$f['descr_full']		= trim($arr['descr_full']);
		$f['thumbnail']			= trim($arr['thumb']);
		list($d,$m,$y)			= explode(".", trim($arr['date']));
		$f['date']				= mktime(0, 0, 0, $m , $d, $y);
		$f['translit']			= G::StrToTrans($f['title']);
		$f['sid']				= $arr['sid'];
		$f['indexation']		= isset($arr['indexation']) && $arr['indexation'] == "on"?1:0;
		$f['visible']			= isset($arr['visible']) && $arr['visible'] == "on"?0:1;
		$f['date_update']			= Date('Y-m-d H:i:s');
		$f['id_user']			= $_SESSION['member'][id_user];
		$f['page_title']		= trim($arr['page_title']);
		$f['page_description']	= trim($arr['page_description']);
		$f['page_keywords']		= trim($arr['page_keywords']);
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."news", $f, "id_news = {$arr['id_news']}")){
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
		$sqlWay = "SELECT src FROM "._DB_PREFIX_."image_news WHERE `id_news` = $id_news";
		$arr = $this->db->GetArray($sqlWay);
		foreach($arr as $k=>$del_arr){
			foreach($del_arr as $k=>$del_image){
				unlink(str_replace('adm\core/../', '', $GLOBALS['PATH_root']).$del_image);
			}
		}
		rmdir(str_replace('adm\core/../../', '', $GLOBALS['PATH_news_img']).$id_news);
		$sqlImg = "DELETE FROM "._DB_PREFIX_."image_news WHERE `id_news` = $id_news";
		$this->db->Query($sqlImg) or G::DieLoger("<b>SQL Error - </b>$sql");
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
	/**
	 * Получить последнюю новость
	 * @param integer	$sid	id магазина
	 */
	public function GetNews($count = 1, $rand = false){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."news
			WHERE visible = 1
			AND sid = 1
			".($rand?' AND translit <> '.$this->db->Quote($GLOBALS['Rewrite']):'')."
			ORDER BY ".($rand?'RAND()':'date DESC')."
			LIMIT ".$count;
		if($count > 1){
			$res = $this->db->GetArray($sql);
		}else{
			$res = $this->db->GetOneRowArray($sql);
		}
		return $res;
	}

	/**
	 * Добавление и удаление фото
	 * @param integer	$id_news		id новости
	 * @param array		$images_arr		массив фотографий
	 */
	public function UpdatePhoto($id_news, $images_arr = array()){
		$sql = "DELETE FROM "._DB_PREFIX_."image_news WHERE id_news = ".$id_news;
		$this->db->StartTrans();
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		$this->db->CompleteTrans();
		$f['id_news'] = $id_news;
		if(isset($images_arr) && !empty($images_arr)){
			$images = new Images();
			$path = $GLOBALS['PATH_news_img'].$id_news.'/';
			$images->checkStructure($path);
			foreach($images_arr as $src){
				if(strpos($src, '\temp/')){
					$new_path = '/'.str_replace('\temp/', '/'.$id_news.'/', $src);
					rename($GLOBALS['PATH_global_root'].$src, $GLOBALS['PATH_global_root'].$new_path);
					$src = $new_path;
				}
				$f['src'] = $src;
				$this->db->StartTrans();
				if(!$this->db->Insert(_DB_PREFIX_.'image_news', $f)){
					$this->db->FailTrans();
					return false;
				}
				$this->db->CompleteTrans();
			}
		}
		unset($id_news, $sql, $new_path, $f);
		return true;
	}

	public function RandomNews($translit){
		$sql = "SELECT * FROM "._DB_PREFIX_."news
			WHERE visible = 1 AND sid = 1 AND translit <>'".$translit."'
			ORDER BY RAND() LIMIT 4";
		$res = $this->db->GetArray($sql);
		return $res;
	}
}