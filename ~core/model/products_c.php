<?php
class Products {
	public $db;
	public $fields;
	public $list;
	public $filter;
	public $price_range;
	private $usual_fields;
	private $usual_fields_sup;
	private $usual_fields_cart;
	/** Конструктор
	 * @return
	 */
	public function __construct(){
		$this->db =& $GLOBALS['db'];
		$this->SetProductsListByFilter();
		$this->SetMinMaxPrice();
		$this->usual_fields = array("p.id_product", "p.art", "p.name", "p.translit", "p.descr", "p.descr_xt_short",
			"p.descr_xt_full", "p.country", "p.img_1", "p.img_2", "p.img_3", "p.sertificate", "p.price_opt", "p.duplicate",
			"p.price_mopt", "p.inbox_qty", "p.min_mopt_qty", "p.max_supplier_qty", "p.weight","p.height","p.width","p.length",
			"p.volume", "p.coefficient_volume", "p.qty_control", "p.price_coefficient_opt", "p.price_coefficient_mopt",
			"p.visible", "p.ord", "p.note_control", "un.unit_xt AS units", "p.prod_status", "p.old_price_mopt",
			"p.old_price_opt", "p.mopt_correction_set", "p.opt_correction_set", "p.filial",
			"p.popularity", "p.duplicate_user", "p.duplicate_comment", "p.duplicate_date", "p.edit_user",
			"p.edit_date", "p.create_user", "p.create_date", "p.id_unit", "p.page_title", "p.page_description",
			"p.page_keywords", "p.notation_price", "p.instruction", "p.indexation", "p.access_assort", "p.limit_per_order");
		$this->usual_fields_cart = array("p.id_product", "p.art", "p.name", "p.translit", "p.descr", "c.note",
			"p.country", "p.img_1", "p.img_2", "p.img_3", "p.sertificate", "p.price_opt", "p.price_mopt",
			"p.inbox_qty", "p.min_mopt_qty", "p.max_supplier_qty", "p.weight", "p.volume", "p.qty_control",
			"p.price_coefficient_opt", "p.price_coefficient_mopt", "p.visible", "p.ord", "p.note_control",
			"un.unit_xt AS units", "p.prod_status", "p.old_price_mopt", "p.old_price_opt", "p.mopt_correction_set",
			"p.opt_correction_set", "p.popularity", "p.duplicate", "p.filial", "p.page_title", "p.page_description", "p.page_keywords");
		$this->usual_fields_sup = array("p.id_product", "p.art", "p.name", "p.translit", "p.descr",
			"p.country", "p.img_1", "p.img_2", "p.img_3", "p.sertificate", "p.price_opt", "p.price_mopt",
			"p.inbox_qty", "p.min_mopt_qty", "p.max_supplier_qty","p.weight", "p.volume", "p.qty_control",
			"p.price_coefficient_opt", "p.price_coefficient_mopt", "p.visible", "p.ord", "un.unit_xt AS units",
			"p.prod_status", "p.old_price_mopt", "p.old_price_opt", "p.mopt_correction_set", "p.opt_correction_set",
			"p.filial", "p.popularity", "p.duplicate", "p.page_title", "p.page_description", "p.page_keywords");
		$this->usual_fields_suplir = array("p.id_product", "p.art", "p.name", "p.translit", "p.descr",
			"p.country", "p.img_1", "p.img_2", "p.img_3", "p.sertificate", "p.price_opt", "p.price_mopt",
			"p.inbox_qty", "p.min_mopt_qty", "p.max_supplier_qty", "p.weight", "p.volume", "p.qty_control",
			"p.price_coefficient_opt", "p.price_coefficient_mopt", "p.visible", "p.ord", "p.note_control",
			"un.unit_xt AS units", "a.sup_comment", "p.prod_status", "p.old_price_mopt", "p.old_price_opt",
			"p.duplicate", "p.mopt_correction_set", "p.opt_correction_set", "p.filial", "cp.id_category",
			"p.popularity", "p.page_title", "p.page_description", "p.page_keywords");
		$this->usual_fields_search = array("p.id_product",  "p.art", "p.name", "p.translit", "p.descr",
			"p.country", "p.img_1", "p.img_2", "p.img_3", "p.sertificate", "p.price_opt", "p.price_mopt",
			"p.inbox_qty", "p.min_mopt_qty", "p.max_supplier_qty", "p.weight", "p.volume", "p.qty_control",
			"p.price_coefficient_opt", "p.price_coefficient_mopt", "p.visible", "p.ord", "p.note_control",
			"un.unit_xt AS units", "p.prod_status", "p.old_price_mopt", "p.old_price_opt", "p.mopt_correction_set",
			"p.opt_correction_set", "p.filial", "p.duplicate", "p.popularity", "p.page_title", "p.page_description", "p.page_keywords");
		$this->usual_fields_temp_prods = array("tp.id", "tp.name", "tp.descr", "tp.img_1", "tp.img_2",
			"tp.img_3", "tp.id_unit", "tp.min_mopt_qty", "tp.inbox_qty", "tp.price_mopt", "tp.price_opt",
			"tp.qty_control", "tp.weight", "tp.volume", "tp.product_limit", "tp.id_supplier",
			"tp.moderation_status", "tp.comment", "tp.creation_date", "tp.images", "tp.height", "tp.width", "tp.length", "tp.coefficient_volume");
	}
	/**
	 * Получить список сопутствующих товаров
	 * @param integer	$id           id основного товара
	 * @param integer	$category_id  категория, в которой искать похожие товары
	 * @param integer	$howfar       [description]
	 * @param integer	$howmany      [description]
	 * @param integer	$min_interval [description]
	 */
	public function GetRelatedProducts($id, $category_id, $howfar = 10000, $howmany = 20, $min_interval = 50){
		$to_right = $id + $howfar + $min_interval;
		$from_left = $id - $howfar - $min_interval;
		$sql = "SELECT p.id_product, p.name, p.translit, p.img_1, p.price_mopt
			FROM "._DB_PREFIX_."product AS p
			LEFT JOIN "._DB_PREFIX_."assortiment AS a
				ON p.id_product = a.id_product
			LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
				ON p.id_product = cp.id_product
			WHERE id_category = ".$category_id."
			AND p.id_product BETWEEN ".$from_left." AND ".$to_right."
			AND p.id_product <> ".$id."
			AND p.visible = 1
			AND a.product_limit > 0
			AND (p.price_opt > 0 OR p.price_mopt > 0)
			GROUP BY p.id_product
			ORDER BY RAND()
			LIMIT ".$howmany;
		$result = $this->db->GetArray($sql);
		if(!$result){
			return false;
		}
		return $result;
	}

	/**
	 * Удаление нулевых позиций поставщиков (с 0 лимитом, но активных)
	 */
	public function Re_null(){
		$this->db->StartTrans();
		$sql = "UPDATE "._DB_PREFIX_."assortiment
			SET active = 0
			WHERE product_limit = 0
			AND active = 1";
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		$this->db->CompleteTrans();
	}

	/**
	 * Установить данные о товаре по его id
	 * @param integer $id_product	id товара
	 * @param integer $visible	учитывать видимость товара 1 - да, 0 - нет
	 * @param integer $active	учитывать активность товара 1 - да, 0 - нет
	 */
	public function SetFieldsById($id_product, $visible = 1, $active = 0){
		$sql = 'SELECT p.*,
				un.unit_xt AS units,
				(CASE WHEN (SELECT COUNT(*) FROM '._DB_PREFIX_.'assortiment AS a LEFT JOIN '._DB_PREFIX_.'user AS u ON u.id_user = a.id_supplier WHERE a.id_product = p.id_product AND a.active = 1 AND u.active = 1) > 0 THEN 1 ELSE 0 END) AS active,
				pv.count_views,
				un.unit_prom,
				(SELECT COUNT(c.Id_coment) FROM '._DB_PREFIX_.'coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1) AS c_count,
				(SELECT AVG(c.rating) FROM '._DB_PREFIX_.'coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_rating,
				(SELECT COUNT(c.Id_coment) FROM '._DB_PREFIX_.'coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_mark
			FROM '._DB_PREFIX_.'product AS p
				LEFT JOIN '._DB_PREFIX_.'units AS un ON un.id = p.id_unit
				LEFT JOIN '._DB_PREFIX_.'prod_views AS pv ON pv.id_product = p.id_product
			WHERE p.id_product = '.$id_product.
			($visible == 1?' AND p.visible = 1 ':null).
			($active == 1?' HAVING active = 1 ':null).'
			LIMIT 1';
		$arr = $this->db->GetOneRowArray($sql);
		if(!$arr){
			return false;
		}
		$arr['categories_ids'] = $this->GetCatsOfProduct($id_product);
		$coef_price_opt =  explode(';', $GLOBALS['CONFIG']['correction_set_'.$arr['opt_correction_set']]);
		$coef_price_mopt =  explode(';', $GLOBALS['CONFIG']['correction_set_'.$arr['mopt_correction_set']]);
		for($i=0; $i<=3; $i++){
			$arr['prices_opt'][$i] = round($arr['price_opt']* $coef_price_opt[$i], 2);
			$arr['prices_mopt'][$i] = round($arr['price_mopt']* $coef_price_mopt[$i], 2);
		}
		// $arr[0]['main_category'] = $maincatarr;
		$this->fields = $arr;
		return true;
	}

	/**
	 * Проверка доступности артикула
	 * @param integer	$art		Артикул нового товара
	 * @param array		$art_arr	Массив с имеющимися артикулами
	 */
	public function SetFieldsBySupComment($sup_comment, $id_supplier){
		$sql = 'SELECT p.*,
				un.unit_xt AS units,
				(CASE WHEN (SELECT COUNT(*) FROM '._DB_PREFIX_.'assortiment AS a LEFT JOIN '._DB_PREFIX_.'user AS u ON u.id_user = a.id_supplier WHERE a.id_product = p.id_product AND a.active = 1 AND u.active = 1) > 0 THEN 1 ELSE 0 END) AS active,
				pv.count_views,	un.unit_prom,
				(SELECT COUNT(c.Id_coment) FROM '._DB_PREFIX_.'coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1) AS c_count,
				(SELECT AVG(c.rating) FROM '._DB_PREFIX_.'coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_rating,
				(SELECT COUNT(c.Id_coment) FROM '._DB_PREFIX_.'coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_mark,
				(SELECT MIN(a.price_opt_otpusk) FROM '._DB_PREFIX_.'assortiment AS a WHERE a.id_product = p.id_product AND a.active = 1) AS price_opt_otpusk,
				(SELECT MIN(a.price_mopt_otpusk) FROM '._DB_PREFIX_.'assortiment AS a WHERE a.id_product = p.id_product AND a.active = 1) AS price_mopt_otpusk
			FROM '._DB_PREFIX_.'product AS p
				LEFT JOIN '._DB_PREFIX_.'units AS un ON un.id = p.id_unit
				LEFT JOIN '._DB_PREFIX_.'prod_views AS pv ON pv.id_product = p.id_product
			WHERE p.id_product IN (SELECT a.id_product FROM '._DB_PREFIX_.'assortiment AS a WHERE a.sup_comment = '.$this->db->Quote($sup_comment).' AND a.id_supplier = '.$id_supplier.')
			LIMIT 1';
		$arr = $this->db->GetOneRowArray($sql);
		if(!$arr){
			return false;
		}
		$coef_price_opt = explode(';', $GLOBALS['CONFIG']['correction_set_'.$arr['opt_correction_set']]);
		$coef_price_mopt = explode(';', $GLOBALS['CONFIG']['correction_set_'.$arr['mopt_correction_set']]);
		$base_coef_price_opt = explode(';', $GLOBALS['CONFIG']['correction_set_0']);
		$base_coef_price_mopt = explode(';', $GLOBALS['CONFIG']['correction_set_0']);
		for($i=0; $i<=3; $i++){
			$arr['prices_opt'][$i] = round($arr['price_opt']*$coef_price_opt[$i], 2);
			$arr['prices_mopt'][$i] = round($arr['price_mopt']*$coef_price_mopt[$i], 2);
			$arr['base_prices_opt'][$i] = round($arr['price_opt']*$base_coef_price_opt[$i], 2);
			$arr['base_prices_mopt'][$i] = round($arr['price_mopt']*$base_coef_price_mopt[$i], 2);
		}
		$arr['categories_ids'] = $this->GetCatsOfProduct($arr['id_product']);
		$this->fields = $arr;
		return true;
	}

	public function GetSupComments($id_supplier){
		$sql = "SELECT id_assortiment, sup_comment FROM "._DB_PREFIX_."assortiment
			WHERE id_supplier = ".$id_supplier;
		if(!$result = $this->db->GetArray($sql, 'id_assortiment')){
			return false;
		}
		foreach ($result as &$value) {
			$value = $value['sup_comment'];
		}
		return $result;
	}
	/**
	 * Товар по rewrite
	 * @param string  $rewrite		rewrite товара
	 * @param integer $visibility	учитывать видимость товара 1 - нет, 0 - да
	 * @return bool
	 */
	public function SetFieldsByRewrite($rewrite, $visibility = 0){
		$sql = 'SELECT p.*,
				un.unit_xt AS units,
				(CASE WHEN (SELECT COUNT(*) FROM '._DB_PREFIX_.'assortiment AS a LEFT JOIN '._DB_PREFIX_.'user AS u ON u.id_user = a.id_supplier WHERE a.id_product = p.id_product AND a.active = 1 AND u.active = 1) > 0 THEN 1 ELSE 0 END) AS active,
				pv.count_views,	un.unit_prom,
				(SELECT COUNT(c.Id_coment) FROM '._DB_PREFIX_.'coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1) AS c_count,
				(SELECT AVG(c.rating) FROM '._DB_PREFIX_.'coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_rating,
				(SELECT COUNT(c.Id_coment) FROM '._DB_PREFIX_.'coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_mark,
				(SELECT MIN(a.price_opt_otpusk) FROM '._DB_PREFIX_.'assortiment AS a WHERE a.id_product = p.id_product AND a.active = 1) AS price_opt_otpusk,
				(SELECT MIN(a.price_mopt_otpusk) FROM '._DB_PREFIX_.'assortiment AS a WHERE a.id_product = p.id_product AND a.active = 1) AS price_mopt_otpusk
			FROM '._DB_PREFIX_.'product AS p
				LEFT JOIN '._DB_PREFIX_.'units AS un ON un.id = p.id_unit
				LEFT JOIN '._DB_PREFIX_.'prod_views AS pv ON pv.id_product = p.id_product
			WHERE p.translit = '.$this->db->Quote($rewrite).'
			LIMIT 1';
		if(!$arr = $this->db->GetOneRowArray($sql)){
			return false;
		}
		$coef_price_opt = explode(';', $GLOBALS['CONFIG']['correction_set_'.$arr['opt_correction_set']]);
		$coef_price_mopt = explode(';', $GLOBALS['CONFIG']['correction_set_'.$arr['mopt_correction_set']]);
		$base_coef_price_opt = explode(';', $GLOBALS['CONFIG']['correction_set_0']);
		$base_coef_price_mopt = explode(';', $GLOBALS['CONFIG']['correction_set_0']);
		for($i=0; $i<=3; $i++){
			$arr['prices_opt'][$i] = round($arr['price_opt']*$coef_price_opt[$i], 2);
			$arr['prices_mopt'][$i] = round($arr['price_mopt']*$coef_price_mopt[$i], 2);
			$arr['base_prices_opt'][$i] = round($arr['price_opt']*$base_coef_price_opt[$i], 2);
			$arr['base_prices_mopt'][$i] = round($arr['price_mopt']*$base_coef_price_mopt[$i], 2);
		}
		$arr['categories_ids'] = $this->GetCatsOfProduct($arr['id_product']);
		$this->fields = $arr;
		return true;
	}

	/**
	 * Получить характеристики товара
	 * @param integer $id_product id товара
	 */
	public function GetSpecificationList($id_product){
		$sql = "SELECT s.id, s.caption, s.units, (CASE WHEN sp.value IS NOT NULL THEN sp.value ELSE svl.value END) AS value
			FROM "._DB_PREFIX_."specs_prods AS sp
			LEFT JOIN "._DB_PREFIX_."specs AS s
				ON s.id = sp.id_spec
			LEFT JOIN "._DB_PREFIX_."specs_values_list AS svl
				ON sp.id_value = svl.id
			WHERE sp.id_prod = ".$id_product."
			ORDER BY s.id";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		$new_arr = [];
		foreach($arr as $value){
			if(!isset($new_arr[$value['id']])){
				$new_arr[$value['id']] = $value;
			}
			$new_arr[$value['id']]['values'][] = $value['value'];
			unset($new_arr[$value['id']]['value']);
		}
		return $new_arr;
	}

	/**
	 * Получить артикул товара по его id
	 * @param integer $id_product id товара
	 */
	public function GetArtByID($id_product){
		$sql = "SELECT art
			FROM "._DB_PREFIX_."product
			WHERE id_product = ".$id_product;
		$arr = $this->db->GetOneRowArray($sql);
		if(!$arr){
			return false;
		}
		return $arr;
	}

	/**
	 * Получить комментарии к товару по его id
	 * @param integer $id_product id товара
	 */
	public function GetComentByProductId($id_product){
		$sql = "SELECT cm.Id_coment, cm.text_coment, cm.author AS id_author,
				(CASE
					WHEN cm.author = 4028 THEN cm.author_name
					WHEN cm.author = 007 THEN (SELECT name_c FROM "._DB_PREFIX_."contragent WHERE id_user = cm.author_name)
					ELSE (SELECT name FROM "._DB_PREFIX_."user WHERE id_user = cm.author)
				END) AS name,
				cm.date_comment, cm.visible, cm.rating, cm.pid_comment,
				(CASE WHEN (SELECT COUNT(*)
					FROM "._DB_PREFIX_."osp AS osp
					LEFT JOIN "._DB_PREFIX_."order AS o
						ON osp.id_order = o.id_order
						AND o.id_order_status = 2
					WHERE osp.id_product = ".$id_product."
					AND o.id_customer = cm.author) > 0 THEN 1 ELSE 0 END) AS purchase
				FROM "._DB_PREFIX_."coment AS cm
				WHERE cm.url_coment = ".$id_product."
				ORDER BY cm.date_comment DESC";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		foreach($arr as $k=>&$v){
			if($v['pid_comment'] !== null) {
				foreach($arr as &$val){
					if($val['Id_coment'] == $v['pid_comment']){
						$val['answer'][] = $v;
					}
				}
				unset($arr[$k]);
			}
		}
		return $arr;
	}

	/**
	 * Записать комментарий к товару
	 * @param string	$text			текст комментария
	 * @param ?			$author			автор комментария
	 * @param string	$author_name	имя автора
	 * @param string	$authors_email	e-mail автора
	 * @param integer	$id_product		id товара
	 * @param integer	$rating			оценка товара
	 */

	public function SubmitProductComment($text, $author, $author_name, $authors_email = false, $id_product, $rating=null, $pid_comment=null, $visible=null){
		if(empty($text)){
			return false;
		}
		$f['text_coment'] = trim($text);
		$f['url_coment'] = trim($id_product);
		$f['author'] = trim($author);
		$f['author_name'] = trim($author_name);
		$f['rating'] = trim($rating);
		if(isset($authors_email)){
			$f['user_email'] = trim($authors_email);
		}
		if(!empty($pid_comment)) {
			$f['pid_comment'] = $pid_comment;
		}
		if(!empty($visible)) {
			$f['visible'] = $visible;
		}
		unset($text, $rating, $id_product, $authors_email, $author, $author_name);
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'coment', $f)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		unset($f);
		return true;
	}

	/**
	 * Получить видео товара по его id
	 * @param integer $id_product id товара
	 */
	public function GetVideoById($id_product){
		$sql = "SELECT url
			FROM "._DB_PREFIX_."video
			WHERE id_product = ".$id_product."
			ORDER BY id_video";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		foreach($arr as &$value){
			$value = $value['url'];
		}
		return $arr;
	}

	/**
	 * Добавление и удаление видео товара
	 * @param integer	$id_product		id товара
	 * @param array		$arr			массив ссылок на видео
	 */
	public function UpdateVideo($id_product, $arr){
		$sql = "DELETE FROM "._DB_PREFIX_."video WHERE id_product=".$id_product;
		$this->db->StartTrans();
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		$this->db->CompleteTrans();
		$f['id_product'] = trim($id_product);
		foreach($arr as &$value){
			if(empty($value)){
				return false;
			}
			$f['url'] = trim($value);
			$this->db->StartTrans();
			if(!$this->db->Insert(_DB_PREFIX_.'video', $f)){
				$this->db->FailTrans();
				return false;
			}
			$this->db->CompleteTrans();
		}
		unset($id_product);
		unset($f);
		return true;
	}

	/**
	 * Получить id категории по ее артикулу
	 * @param integer	$art	артикул категории
	 */
	public function GetCategoryIdByArt($art){
		$sql = "SELECT c.id_category
			FROM "._DB_PREFIX_."category AS c
			WHERE c.art = ".$art;
		$arr = $this->db->GetOneRowArray($sql);
		if(!$arr){
			return false;
		}
		return $arr['id_category'];
	}

	/**
	 * Получить id товара по его артикулу
	 * @param integer	$art	артикул товара
	 */
	public function GetIdByArt($art){
		$sql = "SELECT p.id_product
			FROM "._DB_PREFIX_."product AS p
			WHERE p.art = '".$art."'";
		$arr = $this->db->GetOneRowArray($sql);
		if(!$arr){
			return false;
		}
		return $arr['id_product'];
	}
	/**
	 * Получить id товара по арт поставщика sup_comment
	 * @param integer	$art	артикул товара
	 */
	public function  GetIdBysup_comment($id_supplier, $sup_comment){
		$sql = "SELECT a.id_product
			FROM "._DB_PREFIX_."assortiment AS a
			WHERE a.sup_comment = '".$sup_comment."' and a.id_supplier = ".$id_supplier;
		$arr = $this->db->GetOneRowArray($sql);
		if(!$arr){
			return false;
		}
		return $arr['id_product'];
	}
	/**
	 * Получение массива id_products по артикулу и по его началу
	 * @param integer	$art	идентификатор товара
	 */
	public function GetIdOneRowArrayByArt($art){
		$sql = "SELECT p.id_product, CONCAT(p.art,' - ',p.name) AS response
			FROM "._DB_PREFIX_."product AS p
			WHERE p.art = ".$art;
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		return $arr;
	}
	/**
	 * Получение массива id_products по артикулу и по его началу
	 * @param integer	$art	идентификатор товара
	 */
	public function GetIdnameArrayByArt($art){
		$sql = "SELECT p.id_product, p.name
			FROM "._DB_PREFIX_."product AS p
			WHERE p.art = ".$art;
		$arr = $this->db->GetOneRowArray($sql);
		if(!$arr){
			return false;
		}
		return $arr;
	}
	/**
	 * [SetProductsListDropDownSearch description]
	 * @param boolean $and [description]
	 */
	public function SetProductsListDropDownSearch($and = false){
		$where = "";
		if($and !== FALSE && count($and)){
			$where = " AND ";
			foreach($and as $k=>$v){
				if($k=='customs'){
					foreach($v as $a){
						$where_a[] = $a;
					}
				}else{
					$where_a[] = "$k=\"$v\"";
				}
			}
			$where .= implode(" AND ", $where_a);
		}
		$sql = "SELECT DISTINCT a.active, i.src AS image,
			p.img_1, p.name, p.id_product, p.translit
			FROM "._DB_PREFIX_."product AS p
			LEFT JOIN "._DB_PREFIX_."image AS i
				ON i.id_product = p.id_product
				AND i.ord = 0 AND i.visible = 1
			LEFT JOIN "._DB_PREFIX_."assortiment AS a
				ON a.id_product = p.id_product
			LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
				ON cp.id_product = a.id_product
			LEFT JOIN "._DB_PREFIX_."supplier AS s
				ON s.id_user = a.id_supplier
			LEFT JOIN "._DB_PREFIX_."units AS un
				ON un.id = p.id_unit
			WHERE a.active = 1
			AND (p.price_mopt > 0 OR p.price_opt > 0)
			".$where."
			GROUP BY a.id_product
			LIMIT 10";
		$res = $this->db->GetArray($sql);
		if(!$res){
			return false;
		}else{
			return $res;
		}
	}
	/**
	 * [SetProductsList4Search description]
	 * @param boolean $and    [description]
	 * @param string  $limit  [description]
	 * @param integer $gid    [description]
	 * @param array   $params [description]
	 */
	public function SetProductsList4Search($and = false, $limit='', $gid=0, $params = array()){
		$where = "";
		if($and !== FALSE && count($and)){
			$where = " AND ";
			foreach($and as $k=>$v){
				if($k=='customs'){
					foreach($v as $a){
						$where_a[] = $a;
					}
				}else{
					$where_a[] = "$k=\"$v\"";
				}
			}
			$where .= implode(" AND ", $where_a);
		}
		$group_by = '';
		if(isset($params['GROUP_BY'])){
			$group_by = ' GROUP BY '.$params['GROUP_BY'];
		}else{
			$group_by = ' GROUP BY p.id_product';
		}
		foreach($params AS $p){
			if(isset($p)){
				if($p!=null){
					$order_by = $p.', a.active DESC';
				}
			}else{
				$order_by = ' a.active DESC';
			}
		}
		$prices_zero = '';
		if(!isset($params['sup_cab'])){
				$prices_zero = ' AND (p.price_opt > 0 OR p.price_mopt > 0) ';
		}
		if(in_array($gid, array(_ACL_SUPPLIER_, _ACL_ADMIN_, _ACL_MODERATOR_, _ACL_SEO_))){
			$sql = "SELECT DISTINCT a.active, s.available_today, pv.count_views,
				".implode(", ",$this->usual_fields).",
				(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1) AS c_count,
				(SELECT AVG(c.rating) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_rating,
				(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_mark
				FROM "._DB_PREFIX_."product AS p
				LEFT JOIN "._DB_PREFIX_."assortiment AS a
					ON a.id_product = p.id_product
				LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
					ON cp.id_product = a.id_product
				LEFT JOIN "._DB_PREFIX_."units AS un
					ON un.id = p.id_unit
				LEFT JOIN "._DB_PREFIX_."supplier AS s
					ON s.id_user = a.id_supplier
				LEFT JOIN "._DB_PREFIX_."prod_views AS pv
					ON pv.id_product = p.id_product
				WHERE p.visible = 1
				AND a.product_limit > 0
				".$where."
				".$group_by."
				ORDER BY ".$order_by."
				".$limit;
		}else{
			$sql = "SELECT DISTINCT a.active, s.available_today, pv.count_views, p.id_product, p.art, p.name, p.translit, p.descr, p.descr_xt_short, p.descr_xt_full,
				p.country, p.img_1, p.img_2, p.img_3, p.sertificate, (CASE WHEN p.price_opt =0 THEN p.price_mopt ELSE p.price_opt END) AS price_opt, p.duplicate, p.price_mopt,
				p.inbox_qty, p.min_mopt_qty, p.max_supplier_qty, p.weight, p.height, p.width, p.length, p.volume, p.coefficient_volume, p.qty_control, p.price_coefficient_opt,
				p.price_coefficient_mopt, p.visible, p.ord, p.note_control, un.unit_xt AS units, p.prod_status, p.old_price_mopt, p.old_price_opt, p.mopt_correction_set,
				p.opt_correction_set, p.filial, p.popularity, p.duplicate_user, p.duplicate_comment, p.duplicate_date, p.edit_user, p.edit_date, p.create_user, p.create_date,
				p.id_unit, p.page_title, p.page_description, p.page_keywords, p.notation_price,	p.instruction, p.indexation, p.access_assort,
				(SELECT COUNT(c.Id_coment) FROM xt_coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1) AS c_count,
				(SELECT AVG(c.rating) FROM xt_coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_rating,
				(SELECT COUNT(c.Id_coment) FROM xt_coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_mark
				FROM "._DB_PREFIX_."product AS p
				LEFT JOIN "._DB_PREFIX_."assortiment AS a
					ON a.id_product = p.id_product
				LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
					ON cp.id_product = a.id_product
				LEFT JOIN "._DB_PREFIX_."units AS un
					ON un.id = p.id_unit
				LEFT JOIN "._DB_PREFIX_."supplier AS s
					ON s.id_user = a.id_supplier
				LEFT JOIN "._DB_PREFIX_."prod_views AS pv
					ON pv.id_product = p.id_product
				WHERE p.visible = 1
				AND a.product_limit > 0
				".$where."
				".$prices_zero."
				".$group_by."
				ORDER BY ".$order_by."
				".$limit;
		}
		$res = $this->db->GetArray($sql);
		foreach($res as &$v){
			$coef_price_opt = explode(';', $GLOBALS['CONFIG']['correction_set_'.$v['opt_correction_set']]);
			$coef_price_mopt = explode(';', $GLOBALS['CONFIG']['correction_set_'.$v['mopt_correction_set']]);
			$base_coef_price_opt = explode(';', $GLOBALS['CONFIG']['correction_set_0']);
			$base_coef_price_mopt = explode(';', $GLOBALS['CONFIG']['correction_set_0']);
			for($i=0; $i<=3; $i++){
				$v['prices_opt'][$i] = round($v['price_opt']* $coef_price_opt[$i], 2);
				$v['prices_mopt'][$i] = round($v['price_mopt']* $coef_price_mopt[$i], 2);
				$v['base_prices_opt'][$i] = round($v['price_opt']* $base_coef_price_opt[$i], 2);
				$v['base_prices_mopt'][$i] = round($v['price_mopt']* $base_coef_price_mopt[$i], 2);
			}
		}
		if(!$res){
			return false;
		}
		return $res;
	}
	/*
	 * Выбор категрий в которых находится искомый товар
	 */
	public function SetCategories4Search($and = false){
		$sql = 'SELECT c.id_category, c.category_level, c.name, c.pid, c.translit, COUNT(p.id_product) AS count
			FROM '._DB_PREFIX_.'cat_prod cp
				LEFT JOIN '._DB_PREFIX_.'category AS c
					ON c.id_category = cp.id_category
				LEFT JOIN '._DB_PREFIX_.'product AS p
					ON p.id_product = cp.id_product'.
			$this->db->GetWhere($and).'
				AND (CASE WHEN (SELECT COUNT(*) FROM '._DB_PREFIX_.'assortiment AS a LEFT JOIN '._DB_PREFIX_.'user AS u ON u.id_user = a.id_supplier WHERE a.id_product = p.id_product AND a.active = 1 AND u.active = 1) > 0 THEN 1 ELSE 0 END) = 1
				AND c.sid = 1
				AND c.visible = 1
				AND p.visible = 1
			GROUP BY c.id_category';
		$res = $this->db->GetArray($sql);
		if(!$res){
			return false;
		}
		return $res;
	}

	/**
	 * [SetProductsList4csv description]
	 */
	public function SetProductsList4csv(){
		$date = date("Y-m-d", (time()+3600*24*2));
		$sql = "SELECT p.name, p.price_mopt,
			p.id_product, p.translit
			FROM "._DB_PREFIX_."product AS p
			LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
				ON p.id_product = cp.id_product
			LEFT JOIN "._DB_PREFIX_."assortiment AS a
				ON p.id_product = a.id_product
			WHERE a.active = 1
			AND cp.id_category IN (".$GLOBALS['CONFIG']['price_csv_categories'].")
			GROUP BY p.id_product";
		$res = $this->db->GetArray($sql);
		if(!$res){
			return false;
		}
		return $res;
	}
	/**
	 * [SetProductsList4csvProm description]
	 */
	public function SetProductsList4csvProm(){
		$sql = "SELECT p.art, p.name, p.translit, p.descr,
		 (CASE WHEN p.img_1 <> '' THEN p.img_1 ELSE (SELECT max(src) FROM "._DB_PREFIX_."image as img WHERE p.id_product = img.id_product and ord = 0) END) AS img_1,
			un.unit_prom AS units, p.price_opt, p.name_index,
			p.price_mopt, p.opt_correction_set,
			p.mopt_correction_set, p.min_mopt_qty,
			p.inbox_qty, (SELECT prom_id
				FROM "._DB_PREFIX_."category AS c
				LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
					ON c.id_category = cp.id_category
				WHERE cp.id_product = p.id_product
				GROUP BY p.id_product) AS prom_id
			FROM "._DB_PREFIX_."product AS p
			LEFT JOIN "._DB_PREFIX_."units AS un
				ON un.id = p.id_unit
			WHERE p.price_mopt <> 0 and  p.id_product IN (SELECT id_product FROM "._DB_PREFIX_."assortiment LEFT JOIN "._DB_PREFIX_."user ON "._DB_PREFIX_."user.id_user = "._DB_PREFIX_."assortiment.id_supplier WHERE "._DB_PREFIX_."user.active + "._DB_PREFIX_."assortiment.active = 2) 
			HAVING img_1 is not null";
		$res = $this->db->GetArray($sql);
		if(!$res){
			return false;
		}
		return $res;
	}
	/**
	 * [SetProductsList4csvTatet description]
	 */
	public function SetProductsList4csvTatet(){
		$value = "SELECT value
			FROM "._DB_PREFIX_."config
			WHERE name = 'tatet_catlist' AND sid = 1";
			$res = $this->db->GetOneRowArray($value);
		$sql = "SELECT p.art, p.name, p.descr,
			un.unit_xt AS units, p.img_1, p.price_opt, p.name_index,
			p.price_mopt, p.opt_correction_set,
			p.mopt_correction_set, p.min_mopt_qty,
			p.inbox_qty, cp.id_category,
			(SELECT name
				FROM "._DB_PREFIX_."category AS c
				WHERE cp.id_category = c.id_category) AS catname
			FROM "._DB_PREFIX_."product AS p
			LEFT JOIN "._DB_PREFIX_."units AS un
				ON un.id = p.id_unit
			LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
				ON cp.id_product = p.id_product
			WHERE p.price_mopt > 0
			AND p.visible = 1
			AND p.min_mopt_qty = 1
			AND cp.id_category IN (".$res['value'].")";
		$res = $this->db->GetArray($sql);
		if(!$res){
			return false;
		}
		return $res;
	}
	/**
	 * [SetProductsList4SuppliersCSV description]
	 * @param [type] $id_order    [description]
	 * @param [type] $id_supplier [description]
	 */
	public function SetProductsList4SuppliersCSV($id_order, $id_supplier){
		$where = "((osp.id_supplier = ".$id_supplier."
				AND osp.opt_qty > 0
				AND osp.contragent_qty <= 0
				AND osp.note_opt NOT LIKE '%Отмена#%')
			OR (osp.id_supplier_mopt = ".$id_supplier."
				AND osp.mopt_qty > 0
				AND osp.contragent_mqty <= 0
				AND osp.note_mopt NOT LIKE '%Отмена#%'))";
		$sql = "SELECT osp.id_order, osp.id_supplier,
			osp.id_supplier_mopt, osp.price_opt_otpusk,
			osp.price_mopt_otpusk, osp.note_opt,
			osp.supplier_quantity_opt AS opt_qty,
			osp.supplier_quantity_mopt AS mopt_qty,
			osp.note_mopt, p.name, p.art, un.unit_xt AS units
			FROM "._DB_PREFIX_."osp AS osp
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON p.id_product = osp.id_product
			LEFT JOIN "._DB_PREFIX_."units AS un
				ON un.id = p.id_unit
			WHERE ".$where."
			AND osp.id_order IN (".trim(implode(", ", $id_order)).")
			GROUP BY p.id_product, osp.id_order";
		$res = $this->db->GetArray($sql);
		if(!$res){
			return false;
		}
		return $res;
	}
	/**
	 * [SetProductsList description]
	 * @param boolean $and    [description]
	 * @param string  $limit  [description]
	 * @param integer $gid    [description]
	 * @param array   $params [description]
	 */
	public function SetProductsList($and = false, $limit = null, $params = array()){
		if($this->filter === false) return false;
		$where2 = $this->filter;
		$selectsegm = isset($GLOBALS['Segment'])?' AND p.id_product IN (SELECT id_product FROM xt_segment_prods WHERE id_segment IN (SELECT id FROM xt_segmentation WHERE id = '.$GLOBALS['Segment'].'))':null;
		$group_by = '';
		if(isset($params['group_by'])){
			$group_by = ' GROUP BY '.$params['group_by'];
		}
		$prices_zero = '';
		if(!isset($params['sup_cab'])){
			$prices_zero = ' AND (price_opt > 0 OR p.price_mopt > 0) ';
		}
		if(isset($params['order_by'])){
			if($params['order_by'] != null){
				$order_by = $params['order_by'];
				if(strpos($params['order_by'], 'popularity') === false){
					$ob = 1;
				}
			}
		}else{
			$order_by = 'price_opt asc';
		}
		if(isset($params['administration'])){
			// SQL выборки для админки
			$sql = '(SELECT 0 AS sort, a.active, pv.count_views,
				'.implode(', ', $this->usual_fields).'
				FROM '._DB_PREFIX_.'product AS p
				LEFT JOIN '._DB_PREFIX_.'assortiment AS a
					ON p.id_product = a.id_product
				LEFT JOIN '._DB_PREFIX_.'cat_prod AS cp
					ON cp.id_product = p.id_product
				LEFT JOIN '._DB_PREFIX_.'units AS un
					ON un.id = p.id_unit
				LEFT JOIN '._DB_PREFIX_.'prod_views AS pv
					ON pv.id_product = p.id_product
				'.$this->db->GetWhere($and).'
				AND (p.price_opt > 0 OR p.price_mopt > 0)
				AND a.active = 1
				AND p.visible = 1
				'.$group_by.')
				UNION
				(SELECT 1 AS sort, a.active, pv.count_views,
				'.implode(', ', $this->usual_fields).'
				FROM '._DB_PREFIX_.'product AS p
				LEFT JOIN '._DB_PREFIX_.'assortiment AS a
					ON p.id_product = a.id_product
				LEFT JOIN '._DB_PREFIX_.'cat_prod AS cp
					ON cp.id_product = p.id_product
				LEFT JOIN '._DB_PREFIX_.'units AS un
					ON un.id = p.id_unit
				LEFT JOIN '._DB_PREFIX_.'prod_views AS pv
					ON pv.id_product = p.id_product
				'.$this->db->GetWhere($and).'
				AND ((p.price_opt <= 0 OR p.price_mopt <= 0)
				OR p.visible = 0)
				'.$group_by.')
				ORDER BY '.$order_by.'
				'.$limit;
		}else{
			$sql = 'SELECT
				p.*,
				(CASE WHEN p.price_opt = 0 THEN p.price_mopt ELSE p.price_opt END) AS price_opt,
				pv.count_views,
				un.unit_xt AS units,
				cp.id_category,
				(CASE WHEN (SELECT COUNT(*) FROM '._DB_PREFIX_.'assortiment AS a LEFT JOIN '._DB_PREFIX_.'user AS u ON u.id_user = a.id_supplier WHERE a.id_product = p.id_product AND a.active = 1 AND u.active = 1) > 0 THEN 1 ELSE 0 END) AS active,
				(SELECT COUNT(c.Id_coment) FROM '._DB_PREFIX_.'coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1) AS c_count,
				(SELECT AVG(c.rating) FROM '._DB_PREFIX_.'coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_rating,
				(SELECT COUNT(c.Id_coment) FROM '._DB_PREFIX_.'coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_mark
			FROM '._DB_PREFIX_.'cat_prod AS cp
				RIGHT JOIN '._DB_PREFIX_.'product AS p
					ON cp.id_product = p.id_product
				LEFT JOIN '._DB_PREFIX_.'units AS un
					ON un.id = p.id_unit
				LEFT JOIN '._DB_PREFIX_.'prod_views AS pv
					ON pv.id_product = p.id_product'.
			$this->db->GetWhere($and)
			.$where2
			.$selectsegm
			.$this->price_range
			.' GROUP BY p.id_product'.
			(isset($params['active'])?' HAVING active = '.$params['active']:null)
			.' ORDER BY active DESC, p.visible DESC, '.
			$order_by.'
			'.$limit;
		}
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		// Формируем оптовые и мелкооптовые цены на товары для вывода на экран при различных скидках
		// Достаем значения (коэфициенты) с глобальной переменной "CONFIG" и умножаем на цену
		// Добавляем эти значения в массив $list
		foreach($this->list as &$v){
			$coef_price_opt = explode(';', $GLOBALS['CONFIG']['correction_set_'.$v['opt_correction_set']]);
			$coef_price_mopt = explode(';', $GLOBALS['CONFIG']['correction_set_'.$v['mopt_correction_set']]);
			$base_coef_price_opt = explode(';', $GLOBALS['CONFIG']['correction_set_0']);
			$base_coef_price_mopt = explode(';', $GLOBALS['CONFIG']['correction_set_0']);
			for($i=0; $i<=3; $i++){
				$v['prices_opt'][$i] = round($v['price_opt']* $coef_price_opt[$i], 2);
				$v['prices_mopt'][$i] = round($v['price_mopt']* $coef_price_mopt[$i], 2);
				$v['base_prices_opt'][$i] = round($v['price_opt']* $base_coef_price_opt[$i], 2);
				$v['base_prices_mopt'][$i] = round($v['price_mopt']* $base_coef_price_mopt[$i], 2);
			}
		}
		return true;
	}
	public function GetGiftsList($promo = false){
		if($promo){
			$gift = ' AND p.id_product IN (SELECT id_product FROM '._DB_PREFIX_.'promo_gifts WHERE id_promo = (SELECT DISTINCT id FROM '._DB_PREFIX_.'promo_code WHERE code = \''.$promo.'\'))';
		}
		$sql = 'SELECT p.*,
			(CASE WHEN p.price_opt = 0 THEN p.price_mopt ELSE p.price_opt END) AS price_opt,
			(CASE WHEN (SELECT COUNT(*) FROM '._DB_PREFIX_.'assortiment AS a LEFT JOIN '._DB_PREFIX_.'user AS u ON u.id_user = a.id_supplier WHERE a.id_product = p.id_product AND a.active = 1 AND u.active = 1) > 0 THEN 1 ELSE 0 END) AS active
			FROM '._DB_PREFIX_.'product AS p
			WHERE p.gift = 1'.(isset($gift)?$gift:null).'
			HAVING active = 1';
		if(!$res = $this->db->GetArray($sql)){
			return false;
		}
		foreach($res as &$p){
			$coef_price_opt = explode(';', $GLOBALS['CONFIG']['correction_set_'.$p['opt_correction_set']]);
			$coef_price_mopt = explode(';', $GLOBALS['CONFIG']['correction_set_'.$p['mopt_correction_set']]);
			$base_coef_price_opt = explode(';', $GLOBALS['CONFIG']['correction_set_0']);
			$base_coef_price_mopt = explode(';', $GLOBALS['CONFIG']['correction_set_0']);
			for($i=0; $i<=3; $i++){
				$p['prices_opt'][$i] = round($p['price_opt']* $coef_price_opt[$i], 2);
				$p['prices_mopt'][$i] = round($p['price_mopt']* $coef_price_mopt[$i], 2);
				$p['base_prices_opt'][$i] = round($p['price_opt']* $base_coef_price_opt[$i], 2);
				$p['base_prices_mopt'][$i] = round($p['price_mopt']* $base_coef_price_mopt[$i], 2);
			}
		}
		return $res;
	}
	/**
	 * Добавление графика (по категории)
	 * @param [type] $data [description]
	 */
	public function AddInsertGraph($data){
		$arr['id_author'] = $_SESSION['member']['id_user'];
		$arr['id_category'] = $_POST['id_category'];
		$arr['name_user'] = $_POST['name_user'];
		$arr['text'] = $_POST['text'];
		$arr['opt'] = 0;
		$arr['moderation'] = 0;
		if ($_POST['opt'] == 1) {
			$arr['opt'] = $_POST['opt'];
		}
		if ($_POST['moderation'] == 1) {
			$arr['moderation'] = $_POST['moderation'];
		}
		foreach($_POST['values'] as $k=>$val){
			$k++;
			$arr['value_'.$k] = $val;
		}
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'graph', $arr)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	/**
	 * Обновляем данные графика спроса в таблице
	 * @param $data
	 * @return bool
	 */
	public function UpdateDemandChartNoModeration($data){
		$sql = "DELETE FROM "._DB_PREFIX_."chart
				WHERE id_chart IN(".$data['id_charts'].")";
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		unset($data['id_charts']);
		if(!$this->AddDemandCharts($data)){
			return false;
		}
		return true;
	}

	/**
	 * Добавление двух графиков (по категории)
	 * @param [type] $data [description]
	 */
	public function AddDemandCharts($data){
		$arr['id_author'] = $_SESSION['member']['id_user'];
		$arr['id_category'] = $data['id_category'];
		//$arr['name_user'] = $data['name_user'];
		$arr['comment'] = $data['text'];
		$arr['moderation'] = 0;
		if(_acl::isAllow('admin_panel')){
			$arr['moderation'] = 1;
		}
		$arr['opt'] = 0;
		foreach($data['values']['roz'] as $k => $val){
			$arr['value_'.($k+1)] = $val;
		}
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'chart', $arr)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();

		$arr['opt'] = 1;
		foreach($data['values']['opt'] as $k => $val){
			$arr['value_'.($k+1)] = $val;
		}
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'chart', $arr)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	/**
	 * [UpdateDemandChart description]
	 * @param [type]  $graph [description]
	 * @param boolean $mode  [description]
	 */
	public function UpdateDemandChart($chart, $mode=false){
		$id_chart = $chart['id_chart'];
		$where = "id_chart = ".$id_chart;
		if($mode == true){
			$arr['moderation'] = $chart['moderation'];
//			if ($chart['mode'] == 'opt') {
//				$where = "opt = ".$id_chart;
//			}
		}else{
			$arr['id_author'] = $_SESSION['member']['id_user'];
			$arr['id_category'] = $chart['id_category'];
			//$arr['name_user'] = $chart['name_user'];
			$arr['comment'] = $chart['text'];
			$arr['moderation'] = 0;
			if(_acl::isAllow('admin_panel')){
				$arr['moderation'] = 1;
			}
			$arr['opt'] = 0;
			if ($chart['opt'] == 1) {
				$arr['opt'] = $chart['opt'];
			}
			foreach($chart['values'] as $k=>$val){
				$k++;
				$arr['value_'.$k] = $val;
			}
		}
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."chart", $arr, $where)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	/**
	 * Поиск графика
	 * @param [type] $id_chart [description]
	 */
	public function SearchDemandChart($id_chart){
		$sql = "SELECT * FROM "._DB_PREFIX_."chart WHERE id_chart = ".$id_chart;
		$result = $this->db->GetOneRowArray($sql);
		return $result;
	}

	// Поиск двух графиков
	public function SearchTwoGraph($id_chart){
		$sql = "SELECT * FROM "._DB_PREFIX_."graph r JOIN "._DB_PREFIX_."graph o WHERE r.id_chart = ".$id_chart."AND o.opt = r.id_chart";
		$result = $this->db->GetArray($sql);
		return $result;
	}
	/**
	 * Выборка графика
	 * @param boolean $id_category [description]
	 */
	public function GetGraphList($id_category = false, $id_author = false, $limit = false){
		$where = '';
		if($id_category || $id_author){
			$where = 'WHERE ch.moderation = 1';
		}
		$where .= $id_category?' AND ch.id_category = '.$id_category:null;
		$where .= $id_author?' AND ch.id_author = '.$id_author:null;
		$sql = "SELECT ch.*, u.name AS user_name
				FROM "._DB_PREFIX_."chart ch
				LEFT JOIN "._DB_PREFIX_."user u ON u.id_user = ch.id_author
				".$where."
				ORDER BY creation_date DESC".($limit !== false?$limit:'');
		$result = $this->db->GetArray($sql);
		return $result;
	}

	/**
	 * Выборка среднеарифметических данных графика по категории
	 * @param bool|false $id_category
	 * @return bool
	 */
	public function AvgDemandChartCategory($id_category = false){
		$values = '';
		for($i = 1; $i<=12; $i++) {
			$values .= "ROUND(AVG(value_$i), 1) AS value_$i, ";
		}
		$values = substr($values, 0, -2);
		$sql = "SELECT COUNT(id_chart) AS count, opt, ".$values." FROM "._DB_PREFIX_."chart
				WHERE id_category = ".$id_category." AND moderation = 1 GROUP BY opt";
		$result = $this->db->GetArray($sql);
		if(!$result){
			return false;
		}
		return $result;
	}

	/**
	 * Выборка всех графиков по Id категории
	 * @param $id_category
	 * @return bool
	 */
	public function GetAllChartsByCategory($id_category){
		$sql = "SELECT c.*, u.name AS name_user FROM "._DB_PREFIX_."chart c
				LEFT JOIN "._DB_PREFIX_."user u ON u.id_user = c.id_author
				WHERE c.id_category = ".$id_category." AND c.moderation = 1
				ORDER BY c.id_chart DESC";
		$result = $this->db->GetArray($sql);
		if(!$result){
			return false;
		}
		$res = array();
		foreach($result as &$v){
			$res[$v['id_author']][] = $v;
		}
		return $res;
	}

	/**
	 * Выборка товаров для главной
	 */
	public function GetRandomList(){
		// $sql = 'SELECT p.*,
		// 	(CASE WHEN p.price_opt = 0 THEN p.price_mopt ELSE p.price_opt END) AS price_opt,
		// 	pv.count_views,
		// 	un.unit_xt AS units,
		// 	cp.id_category,
		// 	(CASE WHEN (SELECT COUNT(*) FROM '._DB_PREFIX_.'assortiment AS a LEFT JOIN '._DB_PREFIX_.'user AS u ON u.id_user = a.id_supplier WHERE a.id_product = p.id_product AND a.active = 1 AND u.active = 1) > 0 THEN 1 ELSE 0 END) AS active,
		// 	(SELECT COUNT(c.Id_coment) FROM '._DB_PREFIX_.'coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1) AS c_count,
		// 	(SELECT AVG(c.rating) FROM '._DB_PREFIX_.'coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_rating,
		// 	(SELECT COUNT(c.Id_coment) FROM '._DB_PREFIX_.'coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_mark
		// 	FROM '._DB_PREFIX_.'cat_prod AS cp
		// 		RIGHT JOIN '._DB_PREFIX_.'product AS p
		// 			ON cp.id_product = p.id_product
		// 		LEFT JOIN '._DB_PREFIX_.'units AS un
		// 			ON un.id = p.id_unit
		// 		LEFT JOIN '._DB_PREFIX_.'prod_views AS pv
		// 			ON pv.id_product = p.id_product
		// 	GROUP BY p.id_product
		// 	HAVING active = 1
		// 	ORDER BY RAND()
		// 	LIMIT 15';
		// $sql = "SELECT *, pv.count_views,
		// 		FROM "._DB_PREFIX_."product p
		// 		JOIN "._DB_PREFIX_."prod_status s
		// 		LEFT JOIN "._DB_PREFIX_."prod_views AS pv
		// 			ON pv.id_product = p.id_product
		// 		WHERE p.prod_status = s.id
		// 		AND s.id = 3 ORDER BY";
		/*$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}*/
		$sql = "SELECT p.*, pv.count_views, un.unit_xt AS units, cp.id_category, a.active, a.price_opt_otpusk, a.price_mopt_otpusk,
				(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1) AS c_count,
				(SELECT AVG(c.rating) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_rating,
				(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_mark,
				(SELECT s.available_today FROM "._DB_PREFIX_."supplier AS s WHERE s.id_user = a.id_supplier) AS available_today
				FROM "._DB_PREFIX_."cat_prod AS cp
					RIGHT JOIN "._DB_PREFIX_."product AS p ON cp.id_product = p.id_product
					LEFT JOIN "._DB_PREFIX_."units AS un ON un.id = p.id_unit
					LEFT JOIN "._DB_PREFIX_."assortiment AS a ON a.id_product = p.id_product
					LEFT JOIN "._DB_PREFIX_."prod_views AS pv ON pv.id_product = p.id_product
				WHERE cp.id_product IS NOT NULL AND (p.price_opt > 0 OR p.price_mopt > 0)
				AND p.prod_status = 3 AND p.visible = 1 GROUP BY p.id_product  ORDER BY RAND() LIMIT 10";
		$result = $this->db->GetArray($sql);
		if(!$result){
			return false;
		}
		foreach($result as &$v){
			$coef_price_opt = explode(';', $GLOBALS['CONFIG']['correction_set_'.$v['opt_correction_set']]);
			$coef_price_mopt = explode(';', $GLOBALS['CONFIG']['correction_set_'.$v['mopt_correction_set']]);
			$base_coef_price_opt = explode(';', $GLOBALS['CONFIG']['correction_set_0']);
			$base_coef_price_mopt = explode(';', $GLOBALS['CONFIG']['correction_set_0']);
			for($i=0; $i<=3; $i++){
				$v['prices_opt'][$i] = round($v['price_opt']* $coef_price_opt[$i], 2);
				$v['prices_mopt'][$i] = round($v['price_mopt']* $coef_price_mopt[$i], 2);
				$v['base_prices_opt'][$i] = round($v['price_opt']* $base_coef_price_opt[$i], 2);
				$v['base_prices_mopt'][$i] = round($v['price_mopt']* $base_coef_price_mopt[$i], 2);
			}
		}
		return $result;
	}
	/**
	 * [SetProductsListByFilter description]
	 */
	public function SetProductsListByFilter(){
		if(isset($GLOBALS['Filters']) && is_array($GLOBALS['Filters'])) {
			$time_start = G::getmicrotime(true);
			$fl_v = '';
			foreach ($GLOBALS['Filters'] as $key => $filter) {
				if ($fl_v != '') $fl_v .= ' AND ';
				$fl_v .= 'sp.id_prod IN (SELECT DISTINCT sp.id_prod FROM '._DB_PREFIX_.'specs_prods AS sp WHERE sp.id_spec = '.$key.'
				AND (sp.value IN (SELECT (CASE WHEN sp2.value IS NOT NULL THEN sp2.value ELSE svl.value END) as value
						FROM xt_specs_prods AS sp2
							LEFT JOIN '._DB_PREFIX_.'specs_values_list AS svl ON sp2.id_value = svl.id
						WHERE sp2.id IN ('.implode(', ',$filter).')
					) OR sp.id_value IN (SELECT sp2.id_value
						FROM '._DB_PREFIX_.'specs_prods AS sp2
						WHERE sp2.id IN ('.implode(', ',$filter).'))
					)
				)';
			}
			$sql = "SELECT DISTINCT sp.id_prod
				FROM "._DB_PREFIX_."specs_prods AS sp
				HAVING ".$fl_v;
			$result = $this->db->GetArray($sql);
			if($result){
				foreach($result as &$res){
					$res = $res['id_prod'];
				}
				if(is_array($result)){
					$this->filter = ' AND p.id_product IN (' . implode(',', $result) . ')';
				}
			}else{
				$this->filter = false;
			}
		}
		return true;
	}
	/**
	 * [GetMinMaxPrice description]
	 * @param boolean $and    [description]
	 * @param string  $limit  [description]
	 * @param integer $gid    [description]
	 * @param array   $params [description]
	 */
	public function GetMinMaxPrice($and = false, $limit = '', $gid = 0, $params = array()){
		$sql = 'SELECT MIN(p.price_opt) as min_price, MAX(p.price_opt) as max_price
				FROM '._DB_PREFIX_.'cat_prod AS cp
					RIGHT JOIN '._DB_PREFIX_.'product AS p ON cp.id_product = p.id_product
					LEFT JOIN '._DB_PREFIX_.'units AS un ON un.id = p.id_unit
					LEFT JOIN '._DB_PREFIX_.'assortiment AS a ON a.id_product = p.id_product'.
				$this->db->GetWhere($and).
				$this->filter."
				AND p.price_opt > 0";
		$this->list = $this->db->GetOneRowArray($sql);
		if(!$this->list){
			return false;
		}
		return $this->list;
	}
	/**
	 * [SetMinMaxPrice description]
	 */
	public function SetMinMaxPrice(){
		$this->price_range = '';
		if(isset($GLOBALS['Price_range'])){
			$this->price_range = " AND p.price_opt BETWEEN " . $GLOBALS['Price_range'][0]. " AND " . $GLOBALS['Price_range'][1];
		}
	}
	/**
	 * [SetProductsList1 description]
	 * @param [type] $id_supplier [description]
	 */
	public function SetProductsList1($id_supplier, $order = null, $limit, $filters = array(), $params = ''){
		$where = '';
		if(!empty($filters)){
			$where .= 'WHERE ';
			if($filters['edited_time'][0] && $filters['edited_time'][0] !== '' && $filters['edited_time'][1] && $filters['edited_time'][1] !== ''){
				$where .= 'a.edited_time BETWEEN "'.$filters['edited_time'][0].'" AND "'.$filters['edited_time'][1].'" AND ';
			}elseif($filters['edited_time'][0] && $filters['edited_time'][0] !== '' && !$filters['edited_time'][1]){
				$where .= 'a.edited_time >= "'.$filters['edited_time'][0].'" AND ';
			}elseif($filters['edited_time'][1] && $filters['edited_time'][1] !== '' && !$filters['edited_time'][0]){
				$where .= 'a.edited_time <= "'.$filters['edited_time'][1].'" AND ';
			}
			unset($filters['edited_time']);
			if($filters !== FALSE && count($filters)){
				foreach($filters as $k=>$v){
					$where_a[] = "$k=\"$v\"";
				}
				$where .= implode(" AND ", $where_a);
			}
		}
		// SQL выборки для админки
		$sql = 'SELECT DISTINCT '.implode(', ', $this->usual_fields).',
			pv.count_views, a.*,
			(CASE WHEN (SELECT COUNT(*) FROM '._DB_PREFIX_.'assortiment AS a LEFT JOIN '._DB_PREFIX_.'user AS u ON u.id_user = a.id_supplier WHERE a.id_product = p.id_product AND a.active = 1 AND u.active = 1) > 0 THEN 1 ELSE 0 END) AS active,
			(SELECT name FROM xt_user WHERE id_user = p.edit_user) AS edit_username
			FROM '._DB_PREFIX_.'product AS p
			LEFT JOIN '._DB_PREFIX_.'assortiment AS a
				ON a.id_product = p.id_product
			LEFT JOIN '._DB_PREFIX_.'units AS un
				ON un.id = p.id_unit
			LEFT JOIN '._DB_PREFIX_.'prod_views AS pv
				ON pv.id_product = p.id_product '.
			$where.'
			GROUP BY p.id_product '.
			$params.' '.
			(($order !== null)?" ORDER BY ".$order:null).
			$limit;
		if(!$this->list = $this->db->GetArray($sql)){
			return false;
		}
		return true;
	}
	/**
	 * [SetProductsListFilter description]
	 * @param boolean $and    [description]
	 * @param string  $limit  [description]
	 * @param integer $gid    [description]
	 * @param array   $params [description]
	 */
	public function SetProductsListFilter($and = false, $limit='', $gid = 0, $params = array()){
		$where = "";
		if($and !== FALSE && count($and)){
			$where = " WHERE ";
			foreach($and as $k=>$v){
				if($k=='customs'){
					foreach ($v as $a){
						$where_a[] = $a;
					}
				}else{
					$where_a[] = "$k=\"$v\"";
				}
			}
			$where .= implode(" AND ", $where_a);
		}
		$group_by = '';
		if(isset($params['GROUP_BY'])){
			$group_by = ' GROUP BY '.$params['GROUP_BY'];
		}
		if(is_numeric($limit)){
			$limit = "LIMIT $limit";
		}
		if(isset($params['order_by'])){
			if($params['order_by']!=null){
				$order_by = $params['order_by'];
			}
		}else{
			$order_by = 'ord, name';
		}

		$sql = "SELECT DISTINCT  pv.count_views, a.active, ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."product AS p
			LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
				ON cp.id_product = p.id_product
			LEFT JOIN "._DB_PREFIX_."assortiment AS a
				ON a.id_product = p.id_product
			LEFT JOIN "._DB_PREFIX_."units AS un
				ON un.id = p.id_unit
			LEFT JOIN "._DB_PREFIX_."prod_views AS pv
				ON pv.id_product = p.id_product
			".$where."
			AND p.visible = 1
			AND (p.price_opt > 0 OR p.price_mopt > 0)
			AND a.active = 1
			".$group_by."
			ORDER BY ".$order_by."
			".$limit;
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}
	/**
	 * функция для отображения результатов поиска без дублей ( нет категорий)
	 * @param boolean $and    [description]
	 * @param string  $limit  [description]
	 * @param integer $gid    [description]
	 * @param array   $params [description]
	 */
	public function SetProductsListOldSearch($and = false, $limit='', $gid=0, $params = array()){
		$where = " ";
		if($and !== FALSE && count($and)){
			//$where = " AND ";
			foreach($and as $k=>$v){
				if($k=='customs'){
					foreach($v as $a){
						$where_a[] = $a;
					}
				}else{
					$where_a[] = "$k=\"$v\"";
				}
			}
			$where .= implode(" AND ", $where_a);
		}
		if(is_numeric($limit)){
			$limit = "LIMIT $limit";
		}
		$group_by = '';
		if(isset($params['GROUP_BY'])){
			$group_by = ' GROUP BY '.$params['GROUP_BY'];
		}else{
			$group_by = ' GROUP By p.id_product';
		}
		if(isset($params['order_by'])){
			if($params['order_by'] != null){
				$order_by = $params['order_by'];
			}
		}else{
			$order_by = 'ord, name';
		}
		$prices_zero = '';
		if(!isset($params['sup_cab'])){
			$prices_zero = ' AND (p.price_opt > 0 OR p.price_mopt > 0) ';
		}
		if($gid == _ACL_SUPPLIER_ || $gid == _ACL_ADMIN_ || $gid == _ACL_MODERATOR_ || $gid == _ACL_SEO_){
			// ,(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1) AS c_count,
			// 	(SELECT AVG(c.rating) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_rating,
			// 	(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_mark
			$sql = "SELECT DISTINCT a.active, a.price_opt_otpusk, a.price_mopt_otpusk, s.available_today, pv.count_views,
				".implode(", ",$this->usual_fields).",
				(CASE WHEN p.price_opt = 0 THEN 0 ELSE 1 END) AS ordered
				FROM "._DB_PREFIX_."product AS p
				LEFT JOIN "._DB_PREFIX_."assortiment AS a
					ON a.id_product = p.id_product
				LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
					ON cp.id_product = a.id_product
				LEFT JOIN "._DB_PREFIX_."supplier AS s
					ON s.id_user = a.id_supplier
				LEFT JOIN "._DB_PREFIX_."units AS un
					ON un.id = p.id_unit
				LEFT JOIN "._DB_PREFIX_."prod_views AS pv
					ON pv.id_product = p.id_product
				WHERE ".(($gid == _ACL_SUPPLIER_)?"p.access_assort = 1 AND ":null) .$where."
				".$group_by."
				ORDER BY ordered DESC, ".$order_by."
				".$limit;
		}else{
			if(!isset($params['rel_search'])){
				// $sups_ids = implode(",",$this->GetSuppliersIdsForCurrentDateDiapason());
				$sql = "SELECT DISTINCT ".implode(", ",$this->usual_fields_search).",
					(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1) AS c_count,
					(SELECT AVG(c.rating) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_rating,
					(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_mark
					FROM "._DB_PREFIX_."product AS p
					LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
						ON cp.id_product = p.id_product
					LEFT JOIN "._DB_PREFIX_."assortiment AS a
						ON a.id_product = p.id_product
					LEFT JOIN "._DB_PREFIX_."supplier AS s
						ON s.id_user = a.id_supplier
					LEFT JOIN "._DB_PREFIX_."units AS un
						ON un.id = p.id_unit
					WHERE p.visible = 1
					AND a.active = 1
					AND ".$where."
					".$prices_zero."
					".$group_by."
					ORDER BY ".$order_by."
					".$limit;
			}else{
				$sql = "SELECT DISTINCT a.active, ".implode(", ",$this->usual_fields).", pv.count_views,
					(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1) AS c_count,
					(SELECT AVG(c.rating) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_rating,
					(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_mark
					FROM "._DB_PREFIX_."product AS p
					LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
						ON cp.id_product = p.id_product
					LEFT JOIN "._DB_PREFIX_."assortiment AS a
						ON a.id_product = p.id_product
					LEFT JOIN "._DB_PREFIX_."supplier AS s
						ON s.id_user = a.id_supplier
					LEFT JOIN "._DB_PREFIX_."units AS un
						ON un.id = p.id_unit
					LEFT JOIN "._DB_PREFIX_."prod_views AS pv
						ON pv.id_product = p.id_product
					WHERE p.visible = 1
					AND ".$where."
					".$group_by."
					ORDER BY active DESC
					".$limit;
				// $sups_ids = implode(",",$this->GetSuppliersIdsForCurrentDateDiapason());
				$sql = "SELECT DISTINCT ".implode(", ",$this->usual_fields_search).$params['rel_search'].",
					(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1) AS c_count,
					(SELECT AVG(c.rating) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_rating,
					(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_mark
					FROM "._DB_PREFIX_."product AS p
					LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
						ON cp.id_product = p.id_product
					LEFT JOIN "._DB_PREFIX_."assortiment AS a
						ON a.id_product = p.id_product
					LEFT JOIN "._DB_PREFIX_."supplier AS s
						ON s.id_user = a.id_supplier
					LEFT JOIN "._DB_PREFIX_."units AS un
						ON un.id = p.id_unit
					WHERE p.visible = 1
					AND a.active = 1
					AND ".$wherep."
					".$prices_zero."
					".$group_by."
					ORDER BY ".$order_by."
					".$limit;
			}
		}
		$res = $this->db->GetArray($sql);
		foreach($res as &$v){
			$coef_price_opt = explode(';', $GLOBALS['CONFIG']['correction_set_'.$v['opt_correction_set']]);
			$coef_price_mopt = explode(';', $GLOBALS['CONFIG']['correction_set_'.$v['mopt_correction_set']]);
			$base_coef_price_opt = explode(';', $GLOBALS['CONFIG']['correction_set_0']);
			$base_coef_price_mopt = explode(';', $GLOBALS['CONFIG']['correction_set_0']);
			for($i=0; $i<=3; $i++){
				$v['prices_opt'][$i] = round($v['price_opt']* $coef_price_opt[$i], 2);
				$v['prices_mopt'][$i] = round($v['price_mopt']* $coef_price_mopt[$i], 2);
				$v['base_prices_opt'][$i] = round($v['price_opt']* $base_coef_price_opt[$i], 2);
				$v['base_prices_mopt'][$i] = round($v['price_mopt']* $base_coef_price_mopt[$i], 2);
			}
		}
		if(!$res){
			return false;
		}else{
			return $res;
		}
	}
	/**
	 * [GetProductsCnt description]
	 * @param boolean $and    [description]
	 * @param integer $gid    [description]
	 * @param array   $params [description]
	 */
	public function GetProductsCnt($and = false, $gid = 0, $params = array()){
		if($this->filter === false) return false;
		$where2 = $this->filter;

		// if (isset($GLOBALS['Segment'])){
		// 	$selectsegm= ' AND p.id_product IN (SELECT id_product FROM xt_segment_prods
		// 			WHERE id_segment IN  (SELECT id FROM xt_segmentation WHERE id='.$GLOBALS['Segment'].'))';
		// } else $selectsegm= '';
		$sql = 'SELECT COUNT(DISTINCT p.id_product) AS cnt
			FROM '._DB_PREFIX_.'cat_prod AS cp
				INNER JOIN '._DB_PREFIX_.'product AS p
					ON cp.id_product = p.id_product'.
			$this->db->GetWhere($and)
			.$where2.
			' AND (CASE WHEN (SELECT COUNT(*) FROM '._DB_PREFIX_.'assortiment AS a LEFT JOIN '._DB_PREFIX_.'user AS u ON u.id_user = a.id_supplier WHERE a.id_product = p.id_product AND a.active = 1 AND u.active = 1) > 0 THEN 1 ELSE 0 END) = 1';
		$res = $this->db->GetOneRowArray($sql);
		if(!$res){
			return 0;
		}
		return $res['cnt'];
	}
	/**
	 * [SetProductsListSupCab description]
	 * @param boolean $and     [description]
	 * @param string  $limit   [description]
	 * @param string  $order_by [description]
	 */
	public function SetProductsListSupCab($and = false, $limit = '', $order_by = 'a.inusd, p.name'){
		$where = "";
		if($and !== FALSE && count($and)){
			foreach($and as $k=>$v){
				$where_a[] = "$k=\"$v\"";
			}
			$where .= implode(' AND ', $where_a);
		}
		if(is_numeric($limit)){
			$limit = 'LIMIT '.$limit;
		}
		$group_by = ' GROUP BY p.id_product';
		$sql = 'SELECT DISTINCT '.implode(', ',$this->usual_fields_suplir).',
			a.inusd, i.src AS image,
			(SELECT MIN(assort.price_mopt_otpusk)
				FROM '._DB_PREFIX_.'assortiment AS assort
				WHERE assort.active = 1
				AND assort.id_product = p.id_product
				AND price_mopt_otpusk > 0
				GROUP BY assort.id_product) AS min_mopt_price,
			(SELECT MIN(assort.price_opt_otpusk)
				FROM '._DB_PREFIX_.'assortiment AS assort
				WHERE assort.active = 1
				AND assort.id_product = p.id_product
				AND price_opt_otpusk > 0
				GROUP BY assort.id_product) AS min_opt_price
			FROM '._DB_PREFIX_.'product AS p
			LEFT JOIN '._DB_PREFIX_.'image AS i
				ON i.id_product = p.id_product
				AND i.ord = 0 AND i.visible = 1
			LEFT JOIN '._DB_PREFIX_.'cat_prod AS cp
				ON cp.id_product = p.id_product
			LEFT JOIN '._DB_PREFIX_.'units AS un
				ON un.id = p.id_unit
			LEFT JOIN '._DB_PREFIX_.'assortiment AS a
				ON a.id_product = p.id_product
			WHERE '.$where.'
			'.$group_by.'
			ORDER BY '.$order_by.'
			'.$limit;
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}else{
			return true;
		}
	}
	/**
	 * [GetProductsCntSupCab description]
	 * @param boolean $and    [description]
	 * @param string  $params [description]
	 */
	public function GetProductsCntSupCab($and = false, $params = ''){
		$where = '';
		if(isset($arr['edited_time'])){
			if($and['edited_time'][0] && $and['edited_time'][0] !== '' && $and['edited_time'][1] && $and['edited_time'][1] !== ''){
				$where .= 'a.edited_time BETWEEN "'.$and['edited_time'][0].'" AND "'.$and['edited_time'][1].'" AND ';
			}elseif($and['edited_time'][0] && $and['edited_time'][0] !== '' && !$and['edited_time'][1]){
				$where .= 'a.edited_time >= "'.$and['edited_time'][0].'" AND ';
			}elseif($and['edited_time'][1] && $and['edited_time'][1] !== '' && !$and['edited_time'][0]){
				$where .= 'a.edited_time <= "'.$and['edited_time'][1].'" AND ';
			}
			unset($and['edited_time']);
		}
		if($and !== FALSE && count($and)){
			foreach($and as $k=>$v){
				$where_a[] = "$k=\"$v\"";
			}
			$where .= implode(" AND ", $where_a);
		}
		$sql = 'SELECT DISTINCT p.id_product,
			(CASE WHEN (SELECT COUNT(*) FROM '._DB_PREFIX_.'assortiment AS a LEFT JOIN '._DB_PREFIX_.'user AS u ON u.id_user = a.id_supplier WHERE a.id_product = p.id_product AND a.active = 1 AND u.active = 1) > 0 THEN 1 ELSE 0 END) AS active
			FROM '._DB_PREFIX_.'product AS p
			LEFT JOIN '._DB_PREFIX_.'assortiment AS a
				ON p.id_product = a.id_product
			WHERE '.$where.' '.
			$params;
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return 0;
		}
		return count($arr);
	}
	/**
	 * [SetProductsListFromArr description]
	 * @param [type] $arr    [description]
	 * @param string $limit  [description]
	 * @param array  $params [description]
	 */
	public function SetProductsListFromArr($arr, $limit='', $params = array()){


		$sql = 'SELECT
				p.*,
				(CASE WHEN p.price_opt = 0 THEN p.price_mopt ELSE p.price_opt END) AS price_opt,
				pv.count_views,
				un.unit_xt AS units,
				cp.id_category,
				(CASE WHEN (SELECT COUNT(*) FROM '._DB_PREFIX_.'assortiment AS a LEFT JOIN '._DB_PREFIX_.'user AS u ON u.id_user = a.id_supplier WHERE a.id_product = p.id_product AND a.active = 1 AND u.active = 1) > 0 THEN 1 ELSE 0 END) AS active,
				(SELECT COUNT(c.Id_coment) FROM '._DB_PREFIX_.'coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1) AS c_count,
				(SELECT AVG(c.rating) FROM '._DB_PREFIX_.'coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_rating,
				(SELECT COUNT(c.Id_coment) FROM '._DB_PREFIX_.'coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_mark
			FROM '._DB_PREFIX_.'cat_prod AS cp
				RIGHT JOIN '._DB_PREFIX_.'product AS p
					ON cp.id_product = p.id_product
				LEFT JOIN '._DB_PREFIX_.'units AS un
					ON un.id = p.id_unit
				LEFT JOIN '._DB_PREFIX_.'prod_views AS pv
					ON pv.id_product = p.id_product
				LEFT JOIN "._DB_PREFIX_."cart_product AS c
					ON p.id_product = c.id_product
					AND c.id_cart = '.$_SESSION['cart']['id'].
			$this->db->GetWhere($and)
			.$where2
			.$selectsegm
			.$this->price_range
			.' GROUP BY p.id_product
			ORDER BY active DESC, p.visible DESC, '.
			$order_by.' '.$limit;
		$in = implode(", ", $arr);
		if(is_numeric($limit)){
			$limit = "limit $limit";
		}
		// $order_by = 'c.id_cart_product ASC';
		$order_by = 'p.art';
		if(isset($params['order_by'])){
			$order_by = $params['order_by'];
		}
		if(isset($_SESSION['cart']['id'])){
			$sql = "SELECT p.id_product, p.art, p.name, p.translit, p.descr, p.descr_xt_short, p.descr_xt_full,
				p.country, p.img_1, p.img_2, p.img_3, p.sertificate,
				(CASE WHEN p.price_opt = 0 THEN p.price_mopt ELSE p.price_opt END) AS price_opt,
				p.duplicate, p.price_mopt,
				p.inbox_qty, p.min_mopt_qty, p.max_supplier_qty, p.weight, p.height, p.width, p.length, p.volume,
				p.coefficient_volume, p.qty_control, p.price_coefficient_opt, p.price_coefficient_mopt,
				p.visible, p.ord, p.note_control, un.unit_xt AS units, p.prod_status, p.old_price_mopt, p.old_price_opt,
				p.mopt_correction_set, p.opt_correction_set, p.filial, p.popularity, p.duplicate_user,
				p.duplicate_comment, p.duplicate_date, p.edit_user, p.edit_date, p.create_user, p.create_date, p.id_unit,
				p.page_title, p.page_description, p.page_keywords, p.notation_price, p.instruction,
				p.indexation, p.access_assort
				FROM "._DB_PREFIX_."product AS p
				LEFT JOIN "._DB_PREFIX_."units AS un
					ON un.id = p.id_unit
				LEFT JOIN "._DB_PREFIX_."cart_product AS c
					ON p.id_product = c.id_product
					AND c.id_cart = ".$_SESSION['cart']['id']."
				WHERE p.id_product IN (".$in.")
				ORDER BY ".$order_by."
				".$limit;
		}else{
			$sql = "SELECT p.id_product, p.art, p.name, p.translit, p.descr, p.descr_xt_short,
				p.descr_xt_full, p.country, p.img_1, p.img_2, p.img_3, p.sertificate,
				(CASE WHEN p.price_opt =0 THEN p.price_mopt ELSE p.price_opt END) AS price_opt,
				p.duplicate, p.price_mopt,
				p.inbox_qty, p.min_mopt_qty, p.max_supplier_qty, p.weight, p.height, p.width, p.length,
				p.volume, p.coefficient_volume, p.qty_control, p.price_coefficient_opt, p.price_coefficient_mopt,
				p.visible, p.ord, p.note_control, un.unit_xt AS units, p.prod_status, p.old_price_mopt, p.old_price_opt,
				p.mopt_correction_set, p.opt_correction_set, p.filial, p.popularity, p.duplicate_user,
				p.duplicate_comment, p.duplicate_date, p.edit_user, p.edit_date, p.create_user, p.create_date,
				p.id_unit, p.page_title, p.page_description, p.page_keywords, p.notation_price, p.instruction,
				p.indexation, p.access_assort
				FROM "._DB_PREFIX_."product AS p
				LEFT JOIN "._DB_PREFIX_."units AS un
					ON un.id = p.id_unit
				WHERE p.id_product IN (".$in.")
				ORDER BY ".$order_by."
				".$limit;
		}
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		//Формируем оптовые и мелкооптовые цены на товары для вывода на экран при различных скидках
		//Достаем значения (коэфициенты) с глобальной переменной "CONFIG" и умножаем на цену
		//Добавляем эти значения в массв $list
		foreach($this->list as $k => &$v){
			$coef_price_opt = explode(';', $GLOBALS['CONFIG']['correction_set_'.$v['opt_correction_set']]);
			$coef_price_mopt = explode(';', $GLOBALS['CONFIG']['correction_set_'.$v['mopt_correction_set']]);
			$base_coef_price_opt = explode(';', $GLOBALS['CONFIG']['correction_set_0']);
			$base_coef_price_mopt = explode(';', $GLOBALS['CONFIG']['correction_set_0']);
			for($i=0; $i<=3; $i++){
				$v['prices_opt'][$i] = round($v['price_opt']* $coef_price_opt[$i], 2);
				$v['prices_mopt'][$i] = round($v['price_mopt']* $coef_price_mopt[$i], 2);
				$v['base_prices_opt'][$i] = round($v['price_opt']* $base_coef_price_opt[$i], 2);
				$v['base_prices_mopt'][$i] = round($v['price_mopt']* $base_coef_price_mopt[$i], 2);
			}
		}
		return true;
	}
	/**
	 * [SetPromoProductsListFromArr description]
	 * @param [type] $arr  [description]
	 * @param [type] $code [description]
	 */
	public function SetPromoProductsListFromArr($arr, $code){
		$in = implode(", ", $arr);
		$sql = "SELECT ".implode(", ",$this->usual_fields_cart).",
			a.price_mopt_otpusk*(1-(pc.percent/100)) AS price
			FROM "._DB_PREFIX_."product AS p
			LEFT JOIN "._DB_PREFIX_."assortiment AS a
				ON a.id_product = p.id_product
			LEFT JOIN "._DB_PREFIX_."supplier AS s
				ON s.id_user = a.id_supplier
			LEFT JOIN "._DB_PREFIX_."promo_code AS pc
				ON pc.id_supplier = s.id_user
			LEFT JOIN "._DB_PREFIX_."units AS un
				ON un.id = p.id_unit
			WHERE p.id_product IN (".$in.")
			AND p.visible = 1
			AND pc.code = ".$code;
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}
	/**
	 * [SetExclusivList description]
	 * @param [type] $id_supplier [description]
	 */
	public function SetExclusivList($id_supplier){
		$sql = "SELECT p.id_product
			FROM "._DB_PREFIX_."product p
			WHERE p.exclusive_supplier = $id_supplier";
		$this->list = $this->db->GetArray($sql, 'id_product');
		if(!$this->list){
			return false;
		}
		return true;
	}
	/**
	 * [SetExclusiveSupplier description]
	 * @param [type] $id_product  [description]
	 * @param [type] $id_supplier [description]
	 * @param [type] $active      [description]
	 */
	public function SetExclusiveSupplier($id_product, $id_supplier, $active){
		$this->db->StartTrans();
		$f['exclusive_supplier'] = $id_supplier;
		if(!$active){
			$f['exclusive_supplier'] = 0;
		}
		if(!$this->db->Update(_DB_PREFIX_."product", $f, "id_product = ".$id_product)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
	}
	/**
	 * [GetAssort description]
	 * @param [type] $id_product  [description]
	 * @param [type] $id_supplier [description]
	 */
	public function GetAssort($id_product, $id_supplier){
		$sql = 'SELECT * FROM '._DB_PREFIX_.'assortiment
			WHERE id_product = '.$id_product.'
			AND id_supplier = '.$id_supplier;
		$res = $this->db->GetOneRowArray($sql);
		if(!$res){
			return false;
		}
		return $res;
	}
	/**
	 * Обновление позиции ассортимента (ajax)
	 * @param [type] $data [description]
	 */
	public function UpdateAssort($data){
		$assort = $this->GetAssort($data['id_product'], $data['id_supplier']);
		$Suppliers = new Suppliers();
		$Suppliers->SetFieldsById($data['id_supplier'], 1);
		$supplier = $Suppliers->fields;
		if(isset($data['price'])){
			if($assort['inusd'] == 1){
				$f['price_'.$data['mode'].'_otpusk'] = $data['price']*($supplier['currency_rate'] == 0?$GLOBALS['CONFIG']['currency_rate']:$supplier['currency_rate']);
				$f['price_'.$data['mode'].'_otpusk_usd'] = $data['price'];
			}else{
				$f['price_'.$data['mode'].'_otpusk'] = $data['price'];
				$f['price_'.$data['mode'].'_otpusk_usd'] = $data['price']/($supplier['currency_rate'] == 0?$GLOBALS['CONFIG']['currency_rate']:$supplier['currency_rate']);
			}
			$f['price_'.$data['mode'].'_recommend'] = $f['price_'.$data['mode'].'_otpusk']*$supplier['koef_nazen_'.$data['mode']];
			if($supplier['single_price'] == 1 && isset($data['mode']) && $data['mode'] == 'mopt'){
				$data['mode'] = 'opt';
				if($assort['inusd'] == 1){
					$f['price_'.$data['mode'].'_otpusk'] = $data['price']*($supplier['currency_rate'] == 0?$GLOBALS['CONFIG']['currency_rate']:$supplier['currency_rate']);
					$f['price_'.$data['mode'].'_otpusk_usd'] = $data['price'];
				}else{
					$f['price_'.$data['mode'].'_otpusk'] = $data['price'];
					$f['price_'.$data['mode'].'_otpusk_usd'] = $data['price']/($supplier['currency_rate'] == 0?$GLOBALS['CONFIG']['currency_rate']:$supplier['currency_rate']);
				}
				$f['price_'.$data['mode'].'_recommend'] = $f['price_'.$data['mode'].'_otpusk']*$supplier['koef_nazen_'.$data['mode']];
			}
		}
		if(isset($data['comment'])){
			$f['sup_comment'] = $data['comment'];
		}
		if(isset($data['inusd'])){
			$f['inusd'] = $data['inusd'];
		}
		if(isset($data['active'])){
			$f['product_limit'] = ($data['active'] == 0)?0:10000000;
			$f['active'] = $data['active'];
		}
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."assortiment", $f, "id_product = ".$data['id_product']." AND id_supplier = ".$data['id_supplier'])){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		$this->RecalcSitePrices(array($data['id_product']));
		return $this->GetAssort($data['id_product'], $data['id_supplier']);
	}

	/**
	 * Обновление данных Ассортимента с админки
	 * @param [type] $arr [description]
	 */
	public function UpdateAssortWithAdm($arr){
		// Проверка перед update. Если изменений нет, то update не делать
		$sql = "SELECT * FROM "._DB_PREFIX_."assortiment WHERE id_assortiment = ".$arr['id_assortiment'];
		$res = $this->db->GetOneRowArray($sql);
		$i = 0;
		foreach($arr as $k => &$v){
			if(isset($res[$k]) && $res[$k] != $v){
				$i++;
			}
		}
		if($i > 0){
			$suppliers = new Suppliers();
			$suppliers->SetFieldsById($arr['id_supplier'], 1);
			$supp_fields = $suppliers->fields;
			if(isset($arr['product_limit'])){
				$f['product_limit'] = trim($arr['product_limit']);
			}
			$f['inusd'] = $arr['inusd'];
			if($arr['inusd'] != 1){
				$f['price_opt_otpusk'] = trim($arr['price_opt_otpusk']);
				$f['price_mopt_otpusk'] = trim($arr['price_mopt_otpusk']);
				$f['price_opt_otpusk_usd'] = round($arr['price_opt_otpusk']/$supp_fields['currency_rate'], 2);
				$f['price_mopt_otpusk_usd'] = round($arr['price_mopt_otpusk']/$supp_fields['currency_rate'], 2);
			}else{
				$f['price_opt_otpusk'] = round($arr['price_opt_otpusk_usd']*$supp_fields['currency_rate'], 2);
				$f['price_mopt_otpusk'] = round($arr['price_mopt_otpusk_usd']*$supp_fields['currency_rate'], 2);
				$f['price_opt_otpusk_usd'] = trim($arr['price_opt_otpusk_usd']);
				$f['price_mopt_otpusk_usd'] = trim($arr['price_mopt_otpusk_usd']);
			}
			$f['price_opt_recommend'] = $f['price_opt_otpusk']*$supp_fields['koef_nazen_opt'];
			$f['price_mopt_recommend'] = $f['price_mopt_otpusk']*$supp_fields['koef_nazen_mopt'];
			$this->db->StartTrans();
			if (!$this->db->Update(_DB_PREFIX_.'assortiment', $f, "id_assortiment = {$arr['id_assortiment']}")) {
				$this->db->FailTrans();
				return false;
			}
			$this->db->CompleteTrans();
			$this->RecalcSitePrices(array($res['id_product']));
			unset($res);
			return true;
		}
	}

	/**
	 * [InitProduct description]
	 * @param [type] $id_product [description]
	 */
	public function InitProduct($id_product){
		$_SESSION['Assort']['products'][$id_product] = array(
			'price_opt_otpusk' => 0,
			'price_opt_otpusk_usd' => 0,
			'price_opt_recommend' => 0,
			'price_mopt_otpusk' => 0,
			'price_mopt_otpusk_usd' => 0,
			'price_mopt_recommend' => 0,
			'product_limit' => 0,
			'active' => 0,
			'sup_comment' => 0
		);
	}
	/**
	 * [FillAssort description]
	 * @param [type] $id_supplier [description]
	 */
	public function FillAssort($id_supplier){
		$sql = "SELECT a.id_product, a.id_supplier,
			a.price_opt_recommend, a.price_mopt_recommend,
			a.price_opt_otpusk, a.price_mopt_otpusk,
			a.price_opt_otpusk_usd, a.price_mopt_otpusk_usd,
			a.product_limit, a.sup_comment, a.active
			FROM "._DB_PREFIX_."assortiment AS a
			WHERE a.id_supplier = ".$id_supplier."
			ORDER BY a.id_product";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		unset($_SESSION['Assort']);
		foreach($arr as $i){
			$_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk'] = $i['price_opt_otpusk'];
			$_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk_usd'] = $i['price_opt_otpusk_usd'];
			$_SESSION['Assort']['products'][$i['id_product']]['price_opt_recommend'] = $i['price_opt_recommend'];
			$_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk'] = $i['price_mopt_otpusk'];
			$_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk_usd'] = $i['price_mopt_otpusk_usd'];
			$_SESSION['Assort']['products'][$i['id_product']]['price_mopt_recommend'] = $i['price_mopt_recommend'];
			$_SESSION['Assort']['products'][$i['id_product']]['product_limit'] = $i['product_limit'];
			$_SESSION['Assort']['products'][$i['id_product']]['active'] = $i['active'];
			$_SESSION['Assort']['products'][$i['id_product']]['sup_comment'] = $i['sup_comment'];
		}
		return true;
	}
	/**
	 * [SetAssortList description]
	 * @param [type] $id_supplier [description]
	 */
	public function SetAssortList($id_supplier){
		$sql = "SELECT a.id_product, a.id_supplier,
			a.price_opt_recommend, a.price_mopt_recommend,
			a.price_opt_otpusk, a.price_mopt_otpusk,
			a.price_opt_otpusk_usd, a.price_mopt_otpusk_usd,
			a.product_limit, a.sup_comment, a.active
			FROM "._DB_PREFIX_."assortiment AS a
			WHERE a.id_supplier = ".$id_supplier."
			ORDER BY a.id_product";
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}
	/**
	 * [SwitchActiveEDInAssort description]
	 * @param [type] $id_product [description]
	 * @param [type] $active     [description]
	 */
	public function SwitchActiveEDInAssort($id_product, $active){
		$_SESSION['Assort']['products'][$id_product]['active'] = $active;
		$f['active'] = $active;
		$this->db->StartTrans();
		$this->db->Update(_DB_PREFIX_."assortiment", $f, "id_product = ".$id_product);
		$this->RecalcSitePrices(array($id_product));
		$this->db->CompleteTrans();
	}
	/**
	 * [AddToAssort description]
	 * @param [type] $id_product [description]
	 */
	public function AddToAssort($id_product, $id_supplier){
		if($id_supplier == $_SESSION['member']['id_user']){
			$this->InitProduct($id_product);
		}
		$f['id_supplier']           = $id_supplier;
		$f['id_product']            = trim($id_product);
		$f['price_opt_recommend']   = 0;
		$f['price_mopt_recommend']  = 0;
		$f['price_opt_otpusk']      = 0;
		$f['price_mopt_otpusk']     = 0;
		$f['price_opt_otpusk_usd']  = 0;
		$f['price_mopt_otpusk_usd'] = 0;
		$f['product_limit']         = 0;
		$f['active']                = 0;
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'assortiment', $f)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	/**
	 * [DelFromAssort description]
	 * @param [type] $id_product  [description]
	 * @param [type] $id_supplier [description]
	 */
	public function DelFromAssort($id_product, $id_supplier){
		$this->db->StartTrans();
		$this->db->DeleteRowsFrom(_DB_PREFIX_."assortiment", array('id_product = '.$id_product, 'id_supplier = '.$id_supplier));
		$this->db->CompleteTrans();
		$this->RecalcSitePrices(array($id_product));
	}
	/**
	 * Привязка поставщика к товару с админки
	 * @param [type] $arr [description]
	 */
	public function AddToAssortWithAdm($arr){
		$suppliers = new Suppliers();
		$suppliers->SetFieldsById($arr['id_supplier'], 1);
		$supp_fields = $suppliers->fields;
		$f['id_product'] = $arr['id_product'];
		$f['id_supplier'] = $arr['id_supplier'];
		// $f['product_limit'] = trim($arr['product_limit']);
		$f['inusd'] = $arr['inusd'];
		if($arr['inusd'] != 1){
			$f['price_opt_otpusk'] = trim($arr['price_opt_otpusk']);
			$f['price_mopt_otpusk'] = trim($arr['price_mopt_otpusk']);
			$f['price_opt_otpusk_usd'] = round($arr['price_opt_otpusk']/$supp_fields['currency_rate'], 2);
			$f['price_mopt_otpusk_usd'] = round($arr['price_mopt_otpusk']/$supp_fields['currency_rate'], 2);
		}else{
			$f['price_opt_otpusk'] = round($arr['price_opt_otpusk_usd']*$supp_fields['currency_rate'], 2);
			$f['price_mopt_otpusk'] = round($arr['price_mopt_otpusk_usd']*$supp_fields['currency_rate'], 2);
			$f['price_opt_otpusk_usd'] = trim($arr['price_opt_otpusk_usd']);
			$f['price_mopt_otpusk_usd'] = trim($arr['price_mopt_otpusk_usd']);
		}
		$f['price_opt_recommend'] = $f['price_opt_otpusk']*$supp_fields['koef_nazen_opt'];
		$f['price_mopt_recommend'] = $f['price_mopt_otpusk']*$supp_fields['koef_nazen_mopt'];
		$f['edited'] = date('Y-m-d');
		if(isset($arr['sup_comment']) && $arr['sup_comment'] !== ''){
			$f['sup_comment'] = $arr['sup_comment'];
		}
		$this->db->StartTrans();
		//Заполнение массива для проверки на совпадения
		$check['id_product'] = $arr['id_product'];
		$check['id_supplier'] = $arr['id_supplier'];
		if(!$this->db->Insert(_DB_PREFIX_.'assortiment', $f)){
			$this->db->FailTrans();
			return true;
		}
		$this->db->CompleteTrans();
		$this->RecalcSitePrices(array($arr['id_product']));
		return false;
	}


	/**
	 * Отвязываем поставщика от товара
	 * @param [type] $id_assort  [description]
	 * @param [type] $id_product [description]
	 */
	public function DelFromAssortWithAdm($id_assort, $id_product){
		$this->db->StartTrans();
		$this->db->DeleteRowFrom(_DB_PREFIX_."assortiment", "id_assortiment", $id_assort);
		$this->db->CompleteTrans();
		$this->RecalcSitePrices(array($id_product));
		return true;
		// $this->db->StartTrans();
		// $this->db->DeleteRowsFrom(_DB_PREFIX_."assortiment", array("id_product = $id_product", "id_supplier = ".$_SESSION['member']['id_user']));
		// $this->RecalcSitePrices(array($id_product));
		// $this->db->CompleteTrans();
	}

	/**
	 * Пересчет цен на сайте
	 * @param [type] $ids_products [description]
	 */
	public function RecalcSitePrices($ids_products = array()){
		// if(!empty($ids_products)){
		// 	foreach($ids_products as $id_product){
		// 		$products_array[$id_product] = array();
		// 	}
		// }
		set_time_limit(3600);
		ini_set('memory_limit', '512M');
		$sql = 'SELECT a.id_product,
				a.price_opt_recommend,
				a.price_mopt_recommend
			FROM '._DB_PREFIX_.'assortiment AS a
			WHERE a.active = 1'
			// .' AND a.id_product = 26802';
			.(!empty($ids_products)?' HAVING a.id_product IN ('.implode(', ', $ids_products).')':null);
		unset($ids_products);
		$arr = $this->db->GetArray($sql);
		if(!empty($arr)){
			foreach($arr as &$p){
				$products_array[$p['id_product']][] = $p;
			}
			foreach($products_array as $k=>&$product){
				foreach($product as &$p){
					if($p['price_mopt_recommend'] > 0 && (!isset($result_prices[$k]['mopt']) || $p['price_mopt_recommend'] < $result_prices[$k]['mopt'])){
						$result_prices[$k]['mopt'] = $p['price_mopt_recommend'];
					}
					if($p['price_opt_recommend'] > 0 && (!isset($result_prices[$k]['opt']) || $p['price_opt_recommend'] < $result_prices[$k]['opt'])){
						$result_prices[$k]['opt'] = $p['price_opt_recommend'];
					}
				}
			}
			if(!$this->UpdateSitePricesMassive($result_prices)){
				return false;
			}
			set_time_limit(300);
			ini_set('memory_limit', '192M');
		}
		return true;
	}
	/**
	 * [UpdateSitePricesMassive description]
	 * @param [type] $arr [description]
	 */
	public function UpdateSitePricesMassive($arr){
		if(!empty($arr)){
			foreach($arr AS $k=>&$a){
				// if($a['opt'] > 100){
				// 	$f['price_opt'] = "CEILING(".$a['opt']."*price_coefficient_opt)";
				// }else{
				// }
				$f['price_opt'] = 'ROUND('.(isset($a['opt'])?$a['opt']:0).'*price_coefficient_opt, 2)';
				// if ($a['mopt'] > 100) {
				// 	$f['price_mopt'] = "CEILING(".$a['mopt']."*price_coefficient_mopt)";
				// }else{
				// }
				$f['price_mopt'] = 'ROUND('.(isset($a['mopt'])?$a['mopt']:0).'*price_coefficient_mopt, 2)';
				$this->db->StartTrans();
				if(!$this->db->UpdatePro(_DB_PREFIX_.'product', $f, 'id_product = '.$k)){
					$this->db->FailTrans();
					return false;
				}
				$this->db->CompleteTrans();
			}
		}
		return true;
	}
	/**
	 * Добавление
	 * @param [type] $arr [description]
	 */
	public function AddProduct($arr){
		if(isset($arr['art'])){
			$f['art'] = trim($arr['art']);
		}else{
			$f['art'] = $this->CheckArticle($this->GetLastArticle()+1);
		}
		$f['name'] = isset($arr['name']) && trim($arr['name']) !== ''?trim($arr['name']):'Товар - '.$f['art'];
		$f['translit'] = G::StrToTrans($f['name']);
		if(isset($arr['dupl_idproduct'])){
			$f['dupl_idproduct'] = trim($arr['dupl_idproduct']);
		}
		if(isset($arr['descr'])){
			$f['descr'] = trim($arr['descr']);
		}
		if(isset($arr['descr_xt_short'])){
			$f['descr_xt_short'] = trim($arr['descr_xt_short']);
		}
		if(isset($arr['descr_xt_full'])){
			$f['descr_xt_full'] = trim($arr['descr_xt_full']);
		}
		if(isset($arr['img_1'])){
			$f['img_1'] = trim($arr['img_1']);
		}
		if(isset($arr['img_2'])){
			$f['img_2'] = trim($arr['img_2']);
		}
		if(isset($arr['img_3'])){
			$f['img_3'] = trim($arr['img_3']);
		}
		if(isset($arr['price_opt'])){
			$f['price_opt'] = trim($arr['price_opt']);
		}
		if(isset($arr['price_mopt'])){
			$f['price_mopt'] = trim($arr['price_mopt']);
		}
		if(isset($arr['inbox_qty'])){
			$f['inbox_qty'] = trim($arr['inbox_qty']);
		}
		if(isset($arr['min_mopt_qty'])){
			$f['min_mopt_qty'] = trim($arr['min_mopt_qty']);
		}
		if(isset($arr['price_coefficient_opt'])){
			$f['price_coefficient_opt'] = trim($arr['price_coefficient_opt']);
		}
		if(isset($arr['price_coefficient_mopt'])){
			$f['price_coefficient_mopt'] = trim($arr['price_coefficient_mopt']);
		}
		if(isset($arr['height'])){
			$f['height'] = trim($arr['height']);
		}
		if(isset($arr['width'])){
			$f['width'] = trim($arr['width']);
		}
		if(isset($arr['length'])){
			$f['length'] = trim($arr['length']);
		}
		if(isset($arr['volume'])){
			$f['volume'] = trim($arr['volume']);
		}
		if(isset($arr['coefficient_volume'])){
			$f['coefficient_volume'] = $arr['coefficient_volume'];
		}
		if(isset($arr['notation_price'])){
			$f['notation_price'] = trim($arr['notation_price']);
		}
		if(isset($arr['instruction'])){
			$f['instruction'] = trim($arr['instruction']);
		}
		if(isset($arr['height']) && isset($arr['width']) && isset($arr['length']) && $arr['height'] != 0 && $arr['width'] != 0 && $arr['length'] != 0){
			$f['weight'] = ($arr['height'] * $arr['width'] * $arr['length']) * 0.000001; //обьем в м3
		}else{
			if(isset($arr['weight'])){
				$f['weight'] = trim($arr['weight']);
			}
		}
		$f['prod_status'] = 3;
		$f['id_unit'] = isset($arr['id_unit'])?$arr['id_unit']:1;
		$f['qty_control'] = (isset($arr['qty_control']) && $arr['qty_control'] == "on")?1:0;
		$f['visible'] = (isset($arr['visible']) && $arr['visible'] == "on")?0:1;
		$f['note_control'] = (isset($arr['note_control']) && ($arr['note_control'] == "on" || $arr['note_control'] == "1"))?1:0;
		$f['create_user'] = isset($arr['create_user'])?$arr['create_user']:$_SESSION['member']['id_user'];
		$f['indexation'] = (isset($arr['indexation']) && $arr['indexation'] == '1')?1:0;

		// Добавляем товар в бд
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'product', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id_product = $this->db->GetLastId();
		$this->db->CompleteTrans();
		if(isset($arr['categories_ids'])){
			$this->UpdateProductCategories($id_product, $arr['categories_ids'], isset($arr['main_category'])?$arr['main_category']:null);
		}
		// Пересчитывать нечего при добавлении товара, так как нужен хотябы один поставщик на этот товар,
		// а быть его на данном этапе не может
		//$this->RecalcSitePrices(array($id_product));
		return $id_product;
	}
	/**
	 * Запись просмотренных товаров
	 * @param [type] $id_product [description]
	 * @param [type] $id_user    [description]
	 */
	public function AddViewProduct($id_product, $id_user){
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'visited_products', array('id_product' => $id_product, 'id_user' => $id_user))){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	/**
	 * Обновление счетчика просмотренных товаров
	 * @param [type] $count_views [description]
	 * @param [type] $id_product  [description]
	 */
	public function UpdateViewsProducts($count_views, $id_product){
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."prod_views", array('count_views' => $count_views = $count_views + 1), "id_product = ".$id_product)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	/**
	 * Заполнение соответствий категории-товар
	 * @param [type] $id_product     [description]
	 * @param [type] $categories_arr [description]
	 */
	public function UpdateProductCategories($id_product, $categories_arr, $main = null){
		// уникализируем массив на случай выбора одинаковых категорий в админке
		$categories_arr = array_unique($categories_arr);
		// вырезаем нулевую категорию, т.к. товар не может лежать в корне магазина и не принадлежать категории
		//		foreach($categories_arr as $k=>$v){
		//			if($v == 1){
		//				unset($categories_arr[$k]);
		//			}
		//		}

		// Записываем данные в таблицу соответствий категория-товар
		$sql = "DELETE FROM "._DB_PREFIX_."cat_prod  WHERE id_product = ".$id_product."
				AND id_category NOT IN (SELECT c.id_category FROM "._DB_PREFIX_."category c WHERE c.sid = 0)";
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		foreach($categories_arr as $key => $id){
			$f[$key]['id_product'] = $id_product;
			$f[$key]['id_category'] = $id;
			$f[$key]['main'] = (isset($main) && $key == $main) || count($categories_arr) == 1?1:0;
		}
		$this->db->StartTrans();
		if(!$this->db->InsertArr(_DB_PREFIX_.'cat_prod', $f)){
			$this->db->FailTrans();
			return false;
		}
		unset($f);
		$this->db->CompleteTrans();
		return true;
	}
	/**
	 * Обновление
	 * @param [type] $arr [description]
	 */
	public function UpdateProduct($arr){
		$f['edit_user'] = trim($_SESSION['member']['id_user']);
		$f['edit_date'] = date('Y-m-d H:i:s');
		$id_product = trim($arr['id_product']);
		if(isset($arr['name']) && $arr['name'] !== ''){
			$f['art'] = trim($arr['art']);
			$f['name'] = trim($arr['name']);
			// $f['translit'] = G::StrToTrans($arr['name']);//ВП убрал обновление урла при сохранении
			$f['descr'] = trim($arr['descr']);
			$f['descr_xt_short'] = trim($arr['descr_xt_short']);
			$f['descr_xt_full'] = trim($arr['descr_xt_full']);
			//$f['country'] = trim($arr['country']);
			$f['img_1'] = trim($arr['img_1']);
			$f['img_2'] = trim($arr['img_2']);
			$f['img_3'] = trim($arr['img_3']);
			// if(isset($arr['images']) && $arr['images'] != ''){
			// 	$f['img_1'] = trim(isset($arr['images'][0])?$arr['images'][0]:null);
			// 	$f['img_2'] = trim(isset($arr['images'][1])?$arr['images'][1]:null);
			// 	$f['img_3'] = trim(isset($arr['images'][2])?$arr['images'][2]:null);
			// }elseif(!isset($arr['images']) && isset($arr['removed_images'])){
			// 	$f['img_1'] = null;
			// 	$f['img_2'] = null;
			// 	$f['img_3'] = null;
			// }
			if(isset($arr['page_description'])){
				$f['page_description'] = trim($arr['page_description']);
			}
			if(isset($arr['page_title'])){
				$f['page_title'] = trim($arr['page_title']);
			}
			if(isset($arr['page_keywords'])){
				$f['page_keywords'] = trim($arr['page_keywords']);
			}
			//$f['sertificate'] = trim($arr['sertificate']);
			$f['price_opt'] = trim($arr['price_opt']);
			$f['price_mopt'] = trim($arr['price_mopt']);
			$f['inbox_qty'] = trim($arr['inbox_qty']);
			$f['min_mopt_qty'] = trim($arr['min_mopt_qty']);
			//$f['max_supplier_qty'] = trim($arr['max_supplier_qty']);
			//$f['manufacturer_id'] = trim($arr['manufacturer_id']);
			$f['price_coefficient_opt'] = trim($arr['price_coefficient_opt']);
			$f['price_coefficient_mopt'] = trim($arr['price_coefficient_mopt']);
			$f['height'] = trim($arr['height']);
			$f['width'] = trim($arr['width']);
			$f['length'] = trim($arr['length']);
			if($arr['height'] != 0 && $arr['width'] != 0 && $arr['length'] != 0){
				$f['weight'] = ($arr['height'] * $arr['width'] * $arr['length']) * 0.000001; //обьем в м3
			}else{
				$f['weight'] = trim($arr['weight']);
			}
			$f['volume'] = trim($arr['volume']);
			$f['coefficient_volume'] = $arr['coefficient_volume'];
			$f['opt_correction_set'] = isset($arr['opt_correction_set'])?trim($arr['opt_correction_set']):0;
			$f['mopt_correction_set'] = isset($arr['mopt_correction_set'])?trim($arr['mopt_correction_set']):0;
			$f['qty_control'] = (isset($arr['qty_control']) && $arr['qty_control'] == "on")?1:0;
			$f['visible'] = (isset($arr['visible']) && $arr['visible'] == "on")?0:1;
			$f['note_control'] = (isset($arr['note_control']) && ($arr['note_control'] === "on" || $arr['note_control'] == "1"))?1:0;
			$f['id_unit'] = trim($arr['id_unit']);
			$f['notation_price'] = trim($arr['notation_price']);
			$f['instruction'] = trim($arr['instruction']);
			$f['indexation'] = (isset($arr['indexation']) && $arr['indexation'] == "on")?1:0;
			$f['access_assort'] = (isset($arr['access_assort']) && $arr['access_assort'] == "on")?1:0;
		}
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_.'product', $f, "id_product = $id_product")){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		if(isset($arr['name'])){
			$this->UpdateProductCategories($id_product, $arr['categories_ids'], $arr['main_category']);
			$this->RecalcSitePrices(array($id_product));
		}
		return true;
	}
	/**
	 * [UpdateTranslit description]
	 * @param [type] $id_product [description]
	 */
	public function UpdateTranslit($id_product){
		$f['edit_user'] = trim($_SESSION['member']['id_user']);
		$f['edit_date'] = date('Y-m-d H:i:s');
		$this->SetFieldsById($id_product, 1);
		$f['translit'] = G::StrToTrans($this->fields['name']);
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."product", $f, "id_product = ".$id_product)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();

		return $f['translit'];
	}
	/**
	 * Удаление
	 * @param [type] $id_product [description]
	 */
	public function DelProduct($id_product){
		$this->db->StartTrans();
		// // удаляем привязку к фото
		// if(!$this->db->Execute('DELETE FROM '._DB_PREFIX_.'xt_image WHERE id_product = '.$id_product)){
		// 	$this->db->FailTrans();
		// 	return 1;
		// }
		// удаляем товар с таблицы product
		if(!$this->db->Execute('DELETE FROM '._DB_PREFIX_.'product WHERE id_product = '.$id_product)){
			$this->db->FailTrans();
			return 1;
		}
		//удаляем товар с таблицы, где привязываем его к категориям
		if(!$this->db->Execute('DELETE FROM '._DB_PREFIX_.'cat_prod WHERE id_product = '.$id_product)){
			$this->db->FailTrans();
			return 2;
		}
		//отвязываем спецификации
		if(!$this->db->Execute('DELETE FROM '._DB_PREFIX_.'specs_prods WHERE id_prod = '.$id_product)){
			$this->db->FailTrans();
			return 3;
		}
		//удаляем из корзины
		if(!$this->db->Execute('DELETE FROM '._DB_PREFIX_.'cart_product WHERE id_product = '.$id_product)){
			$this->db->FailTrans();
			return 4;
		}
		//удаляем из таблицы сопутствующих товаров
		if(!$this->db->Execute('DELETE FROM '._DB_PREFIX_.'related_prods WHERE id_prod = '.$id_product.' OR id_related_prod = '.$id_product)){
			$this->db->FailTrans();
			return 5;
		}
		//отвязываем товар от сегментации
		if(!$this->db->Execute('DELETE FROM '._DB_PREFIX_.'segment_prods WHERE id_product = '.$id_product)){
			$this->db->FailTrans();
			return 6;
		}
		//удаляем товар из ассортимента поставщика
		if(!$this->db->Execute('DELETE FROM '._DB_PREFIX_.'assortiment WHERE id_product = '.$id_product)){
			$this->db->FailTrans();
			return 7;
		}
		//удаляем товар из таблицы любимых товаров
		if(!$this->db->Execute('DELETE FROM '._DB_PREFIX_.'favorites WHERE id_product = '.$id_product)){
			$this->db->FailTrans();
			return 8;
		}
		//удаляем товар с таблицы посещаемых товаров
		if(!$this->db->Execute('DELETE FROM '._DB_PREFIX_.'visited_products WHERE id_product = '.$id_product)){
			$this->db->FailTrans();
			return 9;
		}
		//удаляем этот товар с листа ожидания
		if(!$this->db->Execute('DELETE FROM '._DB_PREFIX_.'waiting_list WHERE id_product = '.$id_product)){
			$this->db->FailTrans();
			return 10;
		}
		$this->db->CompleteTrans();
		//$this->RecalcSitePrices(array($id_product));
		return true;
	}
	/**
	 * Сортировка
	 * @param [type] $arr [description]
	 */
	public function Reorder($arr){
		$this->db->StartTrans();
		foreach($arr['ord'] as $id_product=>$ord){
			$sql = "UPDATE "._DB_PREFIX_."product SET `ord` = $ord
				WHERE id_product = $id_product";
			$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		}
		$this->db->CompleteTrans();
	}
	/**
	 * Генерация массива строк для экспорта в прайс-лист//
	 * @param [type] $list [description]
	 */
	public function GetExportRowsPrice($list){
		$r = array();
		$ii = 0;
		$sql = "SELECT p.art, p.name as prod_name,
			p.price_mopt, p.min_mopt_qty, c.name as cat_name
			FROM "._DB_PREFIX_."product AS p
			LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
				ON cp.id_product = p.id_product
			LEFT JOIN "._DB_PREFIX_."category AS c
				ON c.id_category = cp.id_category
			WHERE p.price_mopt > 0
			ORDER BY p.art ASC";
		$list = $this->db->GetArray($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		foreach($list as $i){
			$r[$ii]['art'] = $i['art'];
			$r[$ii]['prod_name'] = $i['prod_name'];
			$r[$ii]['price_mopt'] = $i['price_mopt'];
			$r[$ii]['min_mopt_qty'] = $i['min_mopt_qty'];
			$r[$ii]['cat_name'] = $i['cat_name'];
			$ii++;
		}
		return array($r);
	}
	/**
	 * Генерация и выдача для скачивания файла excel (Экспорт)
	 * @param [type] $header [description]
	 * @param [type] $rows   [description]
	 */
	public function GenExcelFileFullPrice($header, $rows){
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()
					->setCreator("Generator xtorg")
					->setLastModifiedBy("Generator xtorg")
					->setTitle("Products")
					->setSubject("Generator xtorg: products")
					->setDescription("Generator xtorg.")
					->setKeywords("office 2007 openxml php")
					->setCategory("result file");
		$sheetPHPExcel = $objPHPExcel->getActiveSheet();
		$sheetPHPExcel->getDefaultStyle()
					  ->getFont()
					  ->setName('Arial');
		$sheetPHPExcel->getDefaultStyle()
					  ->getFont()
					  ->setSize(10);
		$sheetPHPExcel->getDefaultColumnDimension()
					  ->setWidth(15);
		$sheetPHPExcel->getDefaultRowDimension()
					  ->setRowHeight(20);
		//устанавливаем данные
		// Header
		$ii=1;
		foreach($header as $h){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr($ii+64).'1', $h);
			$sheetPHPExcel->getStyle(chr($ii+64).'1')->getFont()->setBold(true);
			$ii++;
		}
		$ii=2;
		foreach($rows as $r){
			$char = 0;
			$price = round($r['price_mopt']*1.15,2);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$char)+64).$ii, $r['art']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$char)+64).$ii, $r['prod_name']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$char)+64).$ii, $price);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$char)+64).$ii, $r['min_mopt_qty']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$char)+64).$ii, $r['cat_name']);
			$ii++;
		}
		//устанавливаем ширину
		$sheetPHPExcel->getColumnDimension('A')->setWidth(8);
		$sheetPHPExcel->getColumnDimension('B')->setWidth(75);
		$sheetPHPExcel->getColumnDimension('C')->setWidth(8);
		$sheetPHPExcel->getColumnDimension('D')->setWidth(10);
		$sheetPHPExcel->getColumnDimension('E')->setWidth(55);
		//отдаем пользователю в браузер
		include("PHPExcel/Writer/Excel5.php");
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="price.xls"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
	}
	/**
	 * Генерация и выдача для скачивания файла excel (Экспорт)
	 * @param [type] $header    [description]
	 * @param [type] $rows      [description]
	 * @param [type] $cats_cols [description]
	 */
	public function GenExcelFile($header, $rows, $cats_cols){
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()
					->setCreator("Generator xtorg")
					->setLastModifiedBy("Generator xtorg")
					->setTitle("Products")
					->setSubject("Generator xtorg: products")
					->setDescription("Generator xtorg.")
					->setKeywords("office 2007 openxml php")
					->setCategory("result file");
		$objPHPExcel->getActiveSheet()
					->getDefaultStyle()
					->getFont()
					->setName('Arial');
		$objPHPExcel->getActiveSheet()
					->getDefaultStyle()
					->getFont()
					->setSize(10);
		$objPHPExcel->getActiveSheet()
					->getDefaultColumnDimension()
					->setWidth(15);
		$objPHPExcel->getActiveSheet()
					->getDefaultRowDimension()
					->setRowHeight(15);
		// Header
		$ii=1;
		foreach($header as $h){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr($ii+64).'1', $h);
			$objPHPExcel->getActiveSheet()->getStyle(chr($ii+64).'1')->getFont()->setBold(true);
			$ii++;
		}
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(70);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(70);
		$ii=2;
		foreach($rows as $r){
			$charcnt = 0;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r['art']);
			for($zz=0;$zz<$cats_cols;$zz++){
				if(isset($r['cat_'.$zz])){
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r['cat_'.$zz]);
				}else{
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, '');
				}
			}
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r['name']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r['sertificate']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r['img_1']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r['img_2']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r['img_3']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r['max_supplier_qty']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r['price_coefficient_opt']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r['price_coefficient_mopt']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r['descr']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r['country']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r['inbox_qty']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r['min_mopt_qty']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r['qty_control']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r['visible']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r['translit']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r['volume']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r['weight']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r['note_control']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r['id_unit']);
			$ii++;
		}
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="products.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
	/**
	 * Генерация массива строк для экспорта
	 * @param [type] $list [description]
	 */
	public function GetExportRows($list){
		$r = array();
		$ii = 0;
		$jj = 0;
		$cats_cols = 0;
		foreach($list as $i){
			$jj=0;
			$r[$ii]['art'] = $i['art'];
			$catarr = $this->GetCatsOfProduct($i['id_product']);
			$cats_cols_tmp = 0;
			foreach($catarr as $cat){
				$r[$ii]['cat_'.$cats_cols_tmp] = $cat['art'];
				$cats_cols_tmp++;
			}
			if($cats_cols_tmp>$cats_cols) $cats_cols=$cats_cols_tmp;
			$r[$ii]['name'] = $i['name'];
			$r[$ii]['sertificate'] = $i['sertificate'];
			$r[$ii]['img_1'] = $i['img_1'];
			$r[$ii]['img_2'] = $i['img_2'];
			$r[$ii]['img_3'] = $i['img_3'];
			$r[$ii]['max_supplier_qty'] = $i['max_supplier_qty'];
			$r[$ii]['price_coefficient_opt'] = $i['price_coefficient_opt'];
			$r[$ii]['price_coefficient_mopt'] = $i['price_coefficient_mopt'];
			$r[$ii]['descr'] = $i['descr'];
			$r[$ii]['country'] = $i['country'];
			$r[$ii]['inbox_qty'] = $i['inbox_qty'];
			$r[$ii]['min_mopt_qty'] = $i['min_mopt_qty'];
			$r[$ii]['qty_control'] = $i['qty_control'];
			$r[$ii]['visible'] = $i['visible'];
			$r[$ii]['translit'] = $i['translit'];
			$r[$ii]['volume'] = $i['volume'];
			$r[$ii]['weight'] = $i['weight'];
			$r[$ii]['note_control'] = $i['note_control'];
			$r[$ii]['id_unit'] = $i['id_unit'];
			$ii++;
		}
		return array($r,$cats_cols);
	}
	/**
	 * [GetCatsOfProduct description]
	 * @param [type] $id_product [description]
	 */
	public function GetCatsOfProduct($id_product){
		$sql = "SELECT cp.id_category, cp.main, c.art
			FROM "._DB_PREFIX_."cat_prod AS cp
			LEFT JOIN "._DB_PREFIX_."category AS c
				ON c.id_category = cp.id_category
			WHERE c.sid = 1
			AND cp.id_product = ".$id_product;
		return $this->db->GetArray($sql);
	}
	/**
	 * Проверка загруженного файла
	 * @param [type] $filename [description]
	 */
	public function CheckProductsFile($filename){
		$objPHPExcel1 = PHPExcel_IOFactory::load($filename);
		$objPHPExcel1->setActiveSheetIndex(0);
		$aSheet = $objPHPExcel1->getActiveSheet();
		//этот массив будет содержать массивы содержащие в себе значения ячеек каждой строки
		$array = array();
		//получим итератор строки и пройдемся по нему циклом
		foreach($aSheet->getRowIterator() as $row){
			//получим итератор ячеек текущей строки
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); // Включить пустые ячейки
			//пройдемся циклом по ячейкам строки
			$item = array();
			foreach($cellIterator as $cell){
				//заносим значения ячеек одной строки в отдельный массив
				array_push($item, $cell->getCalculatedValue());
			}
			//заносим массив со значениями ячеек отдельной строки в "общий массв строк"
			array_push($array, $item);
		}

		$str = '';
		foreach ($array as $key => $value) {
			if ($key > 0) {
				if($id_product = $this->GetIdByArt($value[0])){
					$str .= $str != ''?', '.$value[0]:$value[0];
				}
			}
		}
		if ($str == '') {
			if(!$arr = $this->CompleteProductsFile($array)){
				return false;
			}else{
				return $arr;
			}
		}else{
			return $str;
		}
	}
	/**
	 * Обработка загруженного файла
	 * @param [type] $filename [description]
	 */
	public function ProcessProductsFile($filename){
		$objPHPExcel = PHPExcel_IOFactory::load($filename);
		$objPHPExcel->setActiveSheetIndex(0);
		$aSheet = $objPHPExcel->getActiveSheet();
		//этот массив будет содержать массивы содержащие в себе значения ячеек каждой строки
		$array = array();
		//получим итератор строки и пройдемся по нему циклом
		foreach($aSheet->getRowIterator() as $row){
			//получим итератор ячеек текущей строки
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); // Включить пустые ячейки
			//пройдемся циклом по ячейкам строки
			$item = array();
			foreach($cellIterator as $cell){
				//заносим значения ячеек одной строки в отдельный массив
				array_push($item, $cell->getCalculatedValue());
			}
			//заносим массив со значениями ячеек отдельной строки в "общий массв строк"
			array_push($array, $item);
		}
		return $this->CompleteProductsFile($array);
	}
	/**
	 * [CompleteProductsFile description]
	 * @param [type] $array [description]
	 */
	public function CompleteProductsFile($array){
		// Вычисление кол-ва категорий
		$cols_cnt=0;
		foreach($array[0] as $h){
			if(preg_match("#Категория [\d]+#is", $h)){
				$cols_cnt++;
			}
		}
		$total_updated = 0;
		$total_added = 0;
		// проход по массиву строк
		for($ii=1; isset($array[$ii]); $ii++){
			$cnt = 0;
			$f['art'] = $array[$ii][$cnt++];
			$f['categories_ids'] = array();
			for($jj = 0; $jj < $cols_cnt; $jj++){
				if($array[$ii][$cnt] != ''){
					$f['categories_ids'][] = $this->GetCategoryIdByArt($array[$ii][$cnt]);
				}else{
					$f['categories_ids'][] = 0;
				}
				$cnt++;
			}
			$f['name'] = $array[$ii][$cnt++];
			$f['sertificate'] = $array[$ii][$cnt] == '/efiles/image/'?'':$array[$ii][$cnt];
			$cnt++;
			$f['img_1'] = $array[$ii][$cnt] == '/efiles/image/'?'':$array[$ii][$cnt];
			$cnt++;
			$f['img_2'] = $array[$ii][$cnt] == '/efiles/image/'?'':$array[$ii][$cnt];
			$cnt++;
			$f['img_3'] = $array[$ii][$cnt] == '/efiles/image/'?'':$array[$ii][$cnt];
			$cnt++;
			$f['max_supplier_qty'] = $array[$ii][$cnt++];
			$f['price_coefficient_opt'] = $array[$ii][$cnt++];
			$f['price_coefficient_mopt'] = $array[$ii][$cnt++];
			$f['descr'] = $array[$ii][$cnt++];
			$f['country'] = $array[$ii][$cnt++];
			$f['inbox_qty'] = $array[$ii][$cnt++];
			$f['min_mopt_qty'] = $array[$ii][$cnt++];
			$f['qty_control'] = $array[$ii][$cnt++] == 1?"on":"off";
			$f['visible'] = $array[$ii][$cnt++] == 0?"on":"off";
			$cnt++;
			$f['volume'] = $array[$ii][$cnt++];
			$f['weight'] = $array[$ii][$cnt++];
			$f['note_control'] = $array[$ii][$cnt++];
			$f['id_unit'] = $array[$ii][$cnt++];
			$f['price_opt'] = 0;
			$f['price_mopt'] = 0;
			$f['manufacturer_id'] = 0;
			$f['edit_user'] = $_SESSION['member']['id_user'];
			$f['edit_date'] = date('Y-m-d H:i:s');
			if($id_product = $this->GetIdByArt($f['art'])){
				$f['id_product'] = $id_product;
				$this->UpdateProduct($f);
				$total_updated++;
			}else{
				$this->AddProduct($f);
				$total_added++;
			}
		}
		return array($total_added,$total_updated);
	}
	/**
	 * Генерация массива строк для экспорта ассортимента
	 * @param [type] $list        [description]
	 * @param [type] $id_supplier [description]
	 */
	public function GetExportAssortRows($list, $id_supplier){
		ini_set('memory_limit', '512M');
		$sql = "SELECT DISTINCT a.id_product, a.price_opt_otpusk,
			a.price_mopt_otpusk, a.product_limit, a.sup_comment
			FROM "._DB_PREFIX_."assortiment AS a
			WHERE a.id_supplier = ".$id_supplier."
			AND a.inusd = 0";
		$arr = $this->db->GetArray($sql, 'id_product');
		foreach($list as $i){
			if(isset($arr[$i['id_product']])){
				$result[] = array(
					'art_sup' => $id_supplier,
					'art' => $i['art'],
					'name' => $i['name'],
					'price_opt_otpusk' => round($arr[$i['id_product']]['price_opt_otpusk'], 2),
					'price_mopt_otpusk' => round($arr[$i['id_product']]['price_mopt_otpusk'], 2),
					'product_limit' => $arr[$i['id_product']]['product_limit'],
					'sup_comment' => $arr[$i['id_product']]['sup_comment']
				);
			}
		}
		unset($arr);
		ini_set('memory_limit', '192M');
		return $result;
	}
	/**
	 * [GetExportAssortRowsUSD description]
	 * @param [type] $list        [description]
	 * @param [type] $id_supplier [description]
	 */
	public function GetExportAssortRowsUSD($list, $id_supplier){
		$sql = "SELECT a.id_product, a.price_opt_otpusk_usd AS price_opt_otpusk,
			a.price_mopt_otpusk_usd AS price_mopt_otpusk, a.product_limit, a.sup_comment
			FROM "._DB_PREFIX_."assortiment AS a
			WHERE a.id_supplier = ".$id_supplier."
			AND a.inusd = 1";
		$arr = $this->db->GetArray($sql, 'id_product');
		foreach($list as $i){
			if(isset($arr[$i['id_product']])){
				$result[] = array(
					'art_sup' => $id_supplier,
					'art' => $i['art'],
					'name' => $i['name'],
					'price_opt_otpusk' => round($arr[$i['id_product']]['price_opt_otpusk'], 2),
					'price_mopt_otpusk' => round($arr[$i['id_product']]['price_mopt_otpusk'], 2),
					'product_limit' => $arr[$i['id_product']]['product_limit'],
					'sup_comment' => $arr[$i['id_product']]['sup_comment']
				);
			}
		}
		return $result;
	}
	/**
	 * [GetExcelAssortColumnsArray description]
	 */
	public function GetExcelAssortColumnsArray(){
		$ii=0;
		$ca[$ii++] = array('h'=>'Артикул', 						'n' => 'art', 					'w'=>'9');
		$ca[$ii++] = array('h'=>'Название', 					'n' => 'name', 					'w'=>'48');
		$ca[$ii++] = array('h'=>'Лимит товара на период',		'n' => 'product_limit', 		'w'=>'22');
		$ca[$ii++] = array('h'=>'Цена от ящика отпускная', 		'n' => 'price_opt_otpusk', 		'w'=>'22');
		$ca[$ii++] = array('h'=>'Цена отпускная', 				'n' => 'price_mopt_otpusk',		'w'=>'14');
		$ca[$ii++] = array('h'=>'Артикул поставщика',			'n' => 'sup_comment', 			'w'=>'50');
		return $ca;
	}
	/**
	 * Генерация и выдача для скачивания файла excel Ассортимент (Экспорт)
	 * @param [type] $rows [description]
	 */
	public function GenExcelAssortFile($rows, $filename = false){
		ini_set('memory_limit', '512M');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()
					->setCreator("Generator xtorg")
					->setLastModifiedBy("Generator xtorg")
					->setTitle("Products")
					->setSubject("Generator xtorg: products")
					->setDescription("Generator xtorg.")
					->setKeywords("office 2007 openxml php")
					->setCategory("result file");
		$objPHPExcel->getActiveSheet()
					->getDefaultStyle()
					->getFont()
					->setName('Arial');
		$objPHPExcel->getActiveSheet()
					->getDefaultStyle()
					->getFont()
					->setSize(10);
		$objPHPExcel->getActiveSheet()
					->getDefaultColumnDimension()
					->setWidth(15);
		$objPHPExcel->getActiveSheet()
					->getDefaultRowDimension()
					->setRowHeight(15);
		$ca = $this->GetExcelAssortColumnsArray();
		$ii = 1;
		foreach($ca as $i){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr($ii+64).'1', $i['h']);
			$objPHPExcel->getActiveSheet()->getStyle(chr($ii+64).'1')->getFont()->setBold(true);
			$ii++;
		}
		$charcnt = 0;
		foreach($ca as $i){
			$objPHPExcel->getActiveSheet()->getColumnDimension(chr((++$charcnt)+64))->setWidth($i['w']);
		}
		$ii = 2;
		if(!empty($rows)){
			foreach($rows as $r){
				$charcnt = 0;
				foreach($ca as $i){
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r[$i['n']]);
				}
				$ii++;
			}
		}else{
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, '');
		}
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.($filename?$filename:'assortment').'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		ini_set('memory_limit', '192M');
	}
	/**
	 * Обработка загруженного файла ассортимента
	 * @param [type] $file [description]
	 */
	public function ProcessAssortimentFile($file, $usd){
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		$objPHPExcel->setActiveSheetIndex(0);
		$aSheet = $objPHPExcel->getActiveSheet();
		//этот массив будет содержать массивы содержащие в себе значения ячеек каждой строки
		$array = array();
		$ca = $this->GetExcelAssortColumnsArray();
		//получим итератор строки и пройдемся по нему циклом
		foreach($aSheet->getRowIterator() as $k => $row){
			//получим итератор ячеек текущей строки
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); // Включить пустые ячейки
			//пройдемся циклом по ячейкам строки
			$item = array();
			foreach($cellIterator as $cell){
				//заносим значения ячеек одной строки в отдельный массив
				array_push($item, $cell->getCalculatedValue());
			}
			//заносим массив со значениями ячеек отдельной строки в "общий массив строк"
			if($k > 1){
				array_push($array, $item);
			}else{
				$heading = $item;
			}
		}
		// проход по первой строке
		foreach($ca as $k => $i){
			if($i['h'] != $heading[$k]){
				$_SESSION['errm'][] = "Неверный формат файла";
				return array(0, 0);
			}
			$keys[] = $i['n'];
		}
		$total_updated = 0;
		$total_added = 0;
		// проход по массиву строк
		global $Supplier;
		$id_supplier = $Supplier->fields['id_user'];
		$koef_nazen_opt = $Supplier->fields['koef_nazen_opt'];
		$koef_nazen_mopt = $Supplier->fields['koef_nazen_mopt'];
		$currency_rate = $Supplier->fields['currency_rate'] > 0?$Supplier->fields['currency_rate']:$GLOBALS['CONFIG']['currency_rate'];
		foreach($array as $row){
			$res = array_combine($keys, $row);
			if($id_product = $this->GetIdByArt($res['art'])){
				$recalc_array[] = $id_product;
				$res['active'] = 0;
				if($res['product_limit'] > 0 && (($res['price_opt_otpusk'] != 0) || ($res['price_mopt_otpusk'] != 0))){
					$res['active'] = 1;
				}
				if($usd){
					$res['price_mopt_otpusk_usd'] = $res['price_mopt_otpusk'];
					$res['price_mopt_otpusk'] = $res['price_mopt_otpusk']*$currency_rate;
					$res['price_opt_otpusk_usd'] = $res['price_opt_otpusk'];
					$res['price_opt_otpusk'] = $res['price_opt_otpusk']*$currency_rate;
				}else{
					$res['price_mopt_otpusk_usd'] = $res['price_mopt_otpusk']/$currency_rate;
					$res['price_opt_otpusk_usd'] = $res['price_opt_otpusk']/$currency_rate;
				}
				if($this->IsInAssort($id_product, $id_supplier)){
					$res['id_product'] = $id_product;
					$res['id_supplier'] = $id_supplier;
					// $this->UpdateAssort($res);
					$this->UpdateSupplierAssortiment($res, $koef_nazen_opt, $koef_nazen_mopt, $usd);
					$total_updated++;
				}else{
					$this->AddProductToAssort($id_product, $id_supplier, $res, $koef_nazen_opt, $koef_nazen_mopt, $usd);
					$total_added++;
				}
			}
		}
		$this->RecalcSitePrices($recalc_array);
		return array($total_added, $total_updated);
	}
	/**
	 * [IsInAssort description]
	 * @param [type] $id_product  [description]
	 * @param [type] $id_supplier [description]
	 */
	public function IsInAssort($id_product, $id_supplier){
		$sql = "SELECT id_product
			FROM "._DB_PREFIX_."assortiment
			WHERE id_product = ".$id_product."
			AND id_supplier = ".$id_supplier;
		if(empty($this->db->GetArray($sql))){
			return false;
		}
		return true;
	}
	//Обновление асортимента из XML 
	public function ProcessAssortimentXML($array){
		$this->db->StartTrans();
		foreach ($array as $key => $value) {
		$this->db->Query($value) or G::DieLoger("<b>SQL Error - </b>$sql");
		}
		$this->db->CompleteTrans();	
		return true;
	}
	/**
	 * [AddProductToAssort description]
	 * @param [type]  $id_product      [description]
	 * @param [type]  $id_supplier     [description]
	 * @param [type]  $arr             [description]
	 * @param [type]  $koef_nazen_opt  [description]
	 * @param [type]  $koef_nazen_mopt [description]
	 * @param boolean $inusd           [description]
	 */
	public function AddProductToAssort($id_product, $id_supplier, $arr, $koef_nazen_opt, $koef_nazen_mopt, $inusd = false){
		$f['id_product']			= $id_product;
		$f['id_supplier']			= $id_supplier;
		$f['price_opt_otpusk']		= trim($arr['price_opt_otpusk']);
		$f['price_mopt_otpusk']		= trim($arr['price_mopt_otpusk']);
		$f['price_opt_otpusk_usd']	= trim($arr['price_opt_otpusk_usd']);
		$f['price_mopt_otpusk_usd']	= trim($arr['price_mopt_otpusk_usd']);
		$f['price_opt_recommend']	= $f['price_opt_otpusk']*$koef_nazen_opt;
		$f['price_mopt_recommend']	= $f['price_mopt_otpusk']*$koef_nazen_mopt;
		$f['product_limit']			= trim($arr['product_limit']);
		$f['active']				= trim($arr['active']);
		if(!isset($arr['sup_comment'])){
			$arr['sup_comment'] = null;
		}
		$f['inusd'] = 0;
		if($inusd === true){
			$f['inusd'] = 1;
		}
		$f['sup_comment'] = trim($arr['sup_comment']);
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'assortiment', $f)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		$this->RecalcSitePrices(array($id_product));
		return true;
	}
	/**
	 * Обновление
	 * @param [type]  $arr             [description]
	 * @param [type]  $koef_nazen_opt  [description]
	 * @param [type]  $koef_nazen_mopt [description]
	 * @param boolean $inusd           [description]
	 */
	public function UpdateSupplierAssortiment($arr, $koef_nazen_opt, $koef_nazen_mopt, $inusd = false){
		$f['price_opt_otpusk']		= $arr['price_opt_otpusk'];
		$f['price_mopt_otpusk']		= $arr['price_mopt_otpusk'];
		$f['price_opt_otpusk_usd']	= $arr['price_opt_otpusk_usd'];
		$f['price_mopt_otpusk_usd']	= $arr['price_mopt_otpusk_usd'];
		$f['price_opt_recommend']	= $f['price_opt_otpusk']*$koef_nazen_opt;
		$f['price_mopt_recommend']	= $f['price_mopt_otpusk']*$koef_nazen_mopt;
		$f['product_limit']			= $arr['product_limit'];
		$f['active']				= $arr['active'];
		if(!isset($arr['sup_comment'])){
			$arr['sup_comment'] = null;
		}
		$f['inusd'] = 0;
		if($inusd === true){
			$f['inusd'] = 1;
		}
		$f['sup_comment'] = trim($arr['sup_comment']);
		$id_supplier = $arr['id_supplier'];
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."assortiment", $f, "id_product = ".$arr['id_product']." AND id_supplier = ".$id_supplier)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	/**
	 * [UpdatePriceSupplierAssortiment description]
	 * @param [type] $kurs_griwni [description]
	 */
	public function UpdatePriceSupplierAssortiment($kurs_griwni){
		$sql = "UPDATE "._DB_PREFIX_."supplier AS s
				SET s.currency_rate = $kurs_griwni";
		if(!$this->db->Execute($sql)){
			return false;
		}
		$sql = "UPDATE "._DB_PREFIX_."assortiment AS a
				LEFT JOIN "._DB_PREFIX_."supplier AS s ON a.id_supplier = s.id_user
				SET a.price_opt_otpusk = (a.price_opt_otpusk_usd*s.currency_rate),
				a.price_mopt_otpusk = (a.price_mopt_otpusk_usd*s.currency_rate),
				a.price_opt_recommend = (a.price_opt_otpusk_usd*s.currency_rate*s.koef_nazen_opt),
				a.price_mopt_recommend = (a.price_mopt_otpusk_usd*s.currency_rate*s.koef_nazen_mopt)
				WHERE a.inusd = 1";
		if(!$this->db->Execute($sql)){
			return false;
		}
		$sql = "SELECT DISTINCT id_product FROM "._DB_PREFIX_."assortiment WHERE inusd = 1";
		$arr = $this->db->GetArray($sql);
		foreach($arr as $v){
			$id_products[] = $v['id_product'];
		}
		if(!$this->RecalcSitePrices($id_products)){
			return false;
		}
		return true;
	}
	/**
	 * [UpdatePriceRecommendAssortment description]
	 */
	public function UpdatePriceRecommendAssortment(){
		$sql = "UPDATE "._DB_PREFIX_."assortiment AS a
			LEFT JOIN "._DB_PREFIX_."supplier AS s
				ON a.id_supplier = s.id_user
		SET a.price_opt_recommend = ROUND(a.price_opt_otpusk*s.koef_nazen_opt, 2),
			a.price_mopt_recommend = ROUND(a.price_mopt_otpusk*s.koef_nazen_mopt, 2)
		WHERE a.active = 1";
		$this->db->StartTrans();
		if(!$this->db->Execute($sql)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		$this->RecalcSitePrices();
		return true;
	}
	/**
	 * [UpdateOldPrice1 description]
	 */
	public function UpdateOldPrice1(){
		$sql = "UPDATE "._DB_PREFIX_."product
			SET old_price_mopt = price_mopt,
				old_price_opt = price_opt
			WHERE MOD(id_product, 2) = 1";
		if(!$this->db->Execute($sql)){
			return false;
		}
	}
	/**
	 * [UpdateOldPrice2 description]
	 */
	public function UpdateOldPrice2(){
		$sql = "UPDATE "._DB_PREFIX_."product
			SET old_price_mopt = price_mopt,
				old_price_opt = price_opt
			WHERE MOD(id_product,2) = 0";
		if(!$this->db->Execute($sql)){
			return false;
		}
	}

	/**
	 * @param $id_category
	 * @param $id_product
	 * @param bool|false $rand
	 * @param bool|false $limit
	 * @return mixed
	 */
	public function GetPopularsOfCategory($id_category, $id_product, $rand = false, $limit = false){
		$sql = 'SELECT p.id_product, p.art, p.`name`, p.translit, p.price_opt, p.price_mopt,
			p.min_mopt_qty, p.descr, p.img_1, p.opt_correction_set, p.mopt_correction_set, p.units
			'.(!$rand?', COUNT(*) AS count':null).'
			FROM '._DB_PREFIX_.'product p
			'.(!$rand?' LEFT JOIN '._DB_PREFIX_.'osp o ON o.id_product = p.id_product':null).'
			LEFT JOIN '._DB_PREFIX_.'cat_prod cp ON p.id_product = cp.id_product
			WHERE p.visible = 1
			AND (CASE WHEN (SELECT COUNT(*) FROM '._DB_PREFIX_.'assortiment AS a LEFT JOIN '._DB_PREFIX_.'user AS u ON u.id_user = a.id_supplier WHERE a.id_product = p.id_product AND a.active = 1 AND u.active = 1) > 0 THEN 1 ELSE 0 END) = 1
			AND p.id_product <> '.$id_product.'
			AND cp.id_category = '.$id_category.
			(!$rand?' GROUP BY o.id_product':null).'
			ORDER BY '.($rand?'RAND()':'count DESC').
			($limit?' LIMIT '.$limit:null);
		if(!$arr = $this->db->GetArray($sql,"id_product")){
			return false;
		}
		foreach($arr as &$p){
			$p['images'] = $this->GetPhotoById($p['id_product']);
			$coef_price_opt =  explode(';', $GLOBALS['CONFIG']['correction_set_'.$p['opt_correction_set']]);
			$coef_price_mopt =  explode(';', $GLOBALS['CONFIG']['correction_set_'.$p['mopt_correction_set']]);
			for($i=0; $i<=3; $i++){
				$p['prices_opt'][$i] = round($p['price_opt']* $coef_price_opt[$i], 2);
				$p['prices_mopt'][$i] = round($p['price_mopt']* $coef_price_mopt[$i], 2);
			}
		}
		return $arr;
	}
	//выбор товаров для слайдера.'ORDER BY RAND()'
	public function GetProductSlaider($limit = false){
		$sql = 'SELECT p.id_product, p.art, p.`name`, p.translit, p.price_opt, p.price_mopt,
			p.min_mopt_qty, p.descr, p.img_1, p.opt_correction_set, p.mopt_correction_set, p.units
			FROM '._DB_PREFIX_.'product p where p.id_product in (SELECT o.id_product FROM '._DB_PREFIX_.'osp o where o.id_order = '.$GLOBALS['CONFIG']['order_slaider'].')'.($limit?' LIMIT '.$limit:null);
		if(!$arr = $this->db->GetArray($sql)){
			return false;
		}
		foreach($arr as &$p){
			$p['name'] = mb_strimwidth($p['name'], 0, 50, "...");
			$p['images'] = $this->GetPhotoById($p['id_product']);
			$coef_price_opt =  explode(';', $GLOBALS['CONFIG']['correction_set_'.$p['opt_correction_set']]);
			$coef_price_mopt =  explode(';', $GLOBALS['CONFIG']['correction_set_'.$p['mopt_correction_set']]);
			for($i=0; $i<=3; $i++){
				$p['prices_opt'][$i] = round($p['price_opt']* $coef_price_opt[$i], 2);
				$p['prices_mopt'][$i] = round($p['price_mopt']* $coef_price_mopt[$i], 2);
			}
		}
		return $arr;
	}
	/**
	 * Статистика продаж товаров в период
	 * @param boolean $and [description]
	 */
	public function GetSalesStatistic($and=false){
		$dates = false;
		$date_where = array();
		if(isset($and['target_date_start'])){
			$date_where[] = "target_date > ".$and['target_date_start'];
			unset($and['target_date_start']);
			$dates = true;
		}
		if(isset($and['target_date_end'])){
			$date_where[] = "target_date < ".$and['target_date_end'];
			unset($and['target_date_end']);
			$dates = true;
		}
		$dw = "";
		if($dates){
			$dw = " AND ".implode(" AND ", $date_where);
		}
		$sql = "SELECT osp.id_product, p.art, p.name,
			COUNT(osp.id_product) AS orders_cnt,
			ROUND(SUM(osp.contragent_qty),2) AS contragent_qty,
			ROUND(SUM(osp.contragent_mqty),2) AS contragent_mqty,
			ROUND(SUM(osp.contragent_sum),2) AS contragent_sum,
			ROUND(SUM(osp.contragent_msum),2) AS contragent_msum
			FROM "._DB_PREFIX_."osp AS osp
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON osp.id_product = p.id_product
			LEFT JOIN "._DB_PREFIX_."order AS o
				ON osp.id_order = o.id_order
			WHERE o.id_order_status = 2
			".$this->db->GetWhere($and).
			$dw."
			GROUP BY osp.id_product";
		$arr = $this->db->GetArray($sql);
		return $arr;
	}
	/**
	 * Объявление полей для экспорта "Заказы по поставщикам"
	 */
	public function GetExcelStatColumnsArray(){
		$ii=0;
		$ca[$ii++] = array('h'=>'Артикул',			'n' => 'art',		'w'=>'14');
		$ca[$ii++] = array('h'=>'Название',			'n' => 'name',		'w'=>'30');
		$ca[$ii++] = array('h'=>'Кол-во заказов',	'n' => 'orders_cnt','w'=>'16');
		$ca[$ii++] = array('h'=>'Кол-во шт.',		'n' => 'total_qty',	'w'=>'16');
		$ca[$ii++] = array('h'=>'Сумма',			'n' => 'total_sum',	'w'=>'20');
		return $ca;
	}
	/**
	 * Генерация и выдача для скачивания файла excel "Заказы по поставщикам"
	 * @param [type] $rows [description]
	 */
	public function GenExcelStatFile($rows){
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Generator xtorg")
									 ->setLastModifiedBy("Generator xtorg")
									 ->setTitle("Products")
									 ->setSubject("Generator xtorg: products")
									 ->setDescription("Generator xtorg.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("result file");
		$objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Arial');
		$objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(15);
		$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);
		$ca = $this->GetExcelStatColumnsArray();
		$ii=1;
		foreach($ca as $i){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr($ii+64).'1', $i['h']);
			$objPHPExcel->getActiveSheet()->getStyle(chr($ii+64).'1')->getFont()->setBold(true);
			$ii++;
		}
		$charcnt = 0;
		foreach($ca as $i){
			$objPHPExcel->getActiveSheet()->getColumnDimension(chr((++$charcnt)+64))->setWidth($i['w']);
		}
		$ii=2;
		foreach($rows as $r){
			$charcnt = 0;
			foreach($ca as $i){
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r[$i['n']]);
			}
			$ii++;
		}
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Статистика продаж.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
	/**
	 * Получить айдишники работающих поставщиков в доступный для заказа диапазон дат
	 */
	public function GetSuppliersIdsForCurrentDateDiapason(){
		$Order = new Orders();
		$sql = "SELECT s.id_user as id_supplier
			FROM "._DB_PREFIX_."supplier s
			LEFT JOIN "._DB_PREFIX_."user u
				ON s.id_user = u.id_user
			WHERE u.active = 1";
		$arr = $this->db->GetArray($sql);
		$days_qty = $GLOBALS['CONFIG']['order_day_end'] - $GLOBALS['CONFIG']['order_day_start'];
		$ids = array();
		foreach($arr as $i){
			for($ii=0; $ii<=$days_qty; $ii++){
				$d = time()+3600*24*($GLOBALS['CONFIG']['order_day_start']+$ii);
				if($Order->IsAvailableSupplierInDate($i['id_supplier'], $d)){
					$ids[] = $i['id_supplier'];
				}
			}
		}
		if(count($ids)){
			return $ids;
		}else{
			return array('NULL');
		}
	}
	/**
	 * Получить поставщиков для товара
	 * @param [type] $id_product [description]
	 */
	public function GetSuppliersForProduct($id_product){
		$sql = "SELECT a.id_supplier, s.article, a.product_limit,
			ROUND(a.price_opt_otpusk,2) as price_opt_otpusk,
			ROUND(a.price_opt_recommend,2) as price_opt_recommend,
			ROUND(a.price_mopt_otpusk,2) as price_mopt_otpusk,
			ROUND(a.price_mopt_recommend,2) as price_mopt_recommend
			FROM "._DB_PREFIX_."assortiment AS a
			LEFT JOIN "._DB_PREFIX_."supplier AS s
				ON s.id_user = a.id_supplier
			WHERE a.id_product = $id_product";
		$arr = $this->db->GetArray($sql);
		return $arr;
	}
	/**
	 * Получить поставщиков для товара по id
	 * @param [type] $id_product [description]
	 */
	public function GetSuppliersInfoForProduct($id_product, $id_supplier = false){
		$sql = "SELECT a.id_supplier, s.article, s.real_phone, a.product_limit,
			a.active, a.inusd, u.name, a.id_assortiment,
			ROUND(a.price_opt_otpusk,2) as price_opt_otpusk,
			ROUND(a.price_mopt_otpusk,2) as price_mopt_otpusk,
			ROUND(a.price_opt_otpusk_usd,2) as price_opt_otpusk_usd,
			ROUND(a.price_mopt_otpusk_usd,2) as price_mopt_otpusk_usd
			FROM "._DB_PREFIX_."assortiment AS a
			LEFT JOIN "._DB_PREFIX_."supplier AS s
				ON s.id_user = a.id_supplier
			LEFT JOIN "._DB_PREFIX_."user AS u
				ON u.id_user = a.id_supplier
			WHERE a.id_product = $id_product".
			(!empty($id_supplier)?" AND a.id_supplier = $id_supplier":null).
			" ORDER BY a.id_assortiment";
		$arr = $this->db->GetArray($sql);
		return $arr;
	}
	/**
	 * [GetExportSupPricesRows description]
	 * @param [type] $arr [description]
	 */
	public function GetExportSupPricesRows($arr){
		$suppliers = array();
		$suppliers_qty = 0;
		$ii=0;
		foreach($arr as $i){
			$suppliers = $this->GetSuppliersForProduct($i['id_product']);
			if(count($suppliers)>$suppliers_qty){
				$suppliers_qty = count($suppliers);
			}
			$result[$ii]['article'] = $i['art'];
			$result[$ii]['name'] = $i['name'];
			$result[$ii]['price_opt'] = $i['price_opt'];
			$result[$ii]['price_mopt'] = $i['price_mopt'];
			$jj=1;
			foreach($suppliers as $s){
				$result[$ii]['sup_article_'.$jj] = $s['article'];
				$result[$ii]['sup_product_limit_'.$jj] = $s['product_limit'];
				$result[$ii]['sup_price_opt_otpusk_'.$jj] = $s['price_opt_otpusk'];
				$result[$ii]['sup_price_opt_recommend_'.$jj] = $s['price_opt_recommend'];
				$result[$ii]['sup_price_mopt_otpusk_'.$jj] = $s['price_mopt_otpusk'];
				$result[$ii]['sup_price_mopt_recommend_'.$jj] = $s['price_mopt_recommend'];
				$jj++;
			}
			$ii++;
		}
		return array($result, $suppliers_qty);
	}
	/**
	 * Объявление полей для экспорта товаров с поставщиками и ценами
	 * @param [type] $suppliers_qty [description]
	 */
	public function GetExcelSupPricesColumnsArray($suppliers_qty){
		$ii=0;
		$ca[$ii++] = array('h'=>'Артикул', 										'n' => 'article',							'w'=>'14');
		$ca[$ii++] = array('h'=>'Название', 									'n' => 'name', 								'w'=>'40');
		$ca[$ii++] = array('h'=>'Цена сайта опт',								'n' => 'price_opt',	 						'w'=>'16');
		$ca[$ii++] = array('h'=>'Цена сайта мелк опт',							'n' => 'price_mopt',	 					'w'=>'16');
		for($jj=1; $jj<=$suppliers_qty; $jj++){
			$ca[$ii++] = array('h'=>'Арт поставщ '.$jj, 						'n' => 'sup_article_'.$jj, 					'w'=>'20');
			$ca[$ii++] = array('h'=>'Лимит товара '.$jj, 						'n' => 'sup_product_limit_'.$jj, 			'w'=>'30');
			$ca[$ii++] = array('h'=>'Цена от ящика '.$jj, 						'n' => 'sup_price_opt_otpusk_'.$jj, 		'w'=>'30');
			$ca[$ii++] = array('h'=>'Цена среднерыночная '.$jj, 				'n' => 'sup_price_opt_recommend_'.$jj, 		'w'=>'30');
			$ca[$ii++] = array('h'=>'Цена отпускная от мин кол-ва '.$jj, 		'n' => 'sup_price_mopt_otpusk_'.$jj, 		'w'=>'30');
			$ca[$ii++] = array('h'=>'Цена среднерыночная от мин кол-ва '.$jj, 	'n' => 'sup_price_mopt_recommend_'.$jj, 	'w'=>'30');
		}
		return $ca;
	}
	/**
	 * Генерация и выдача для скачивания файла excel товаров с поставщиками и ценами
	 * @param [type] $rows          [description]
	 * @param [type] $suppliers_qty [description]
	 */
	public function GenExcelSupPricesFile($rows,$suppliers_qty){
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Generator xtorg")
									 ->setLastModifiedBy("Generator xtorg")
									 ->setTitle("Products")
									 ->setSubject("Generator xtorg: products")
									 ->setDescription("Generator xtorg.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("result file");
		$objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Arial');
		$objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(15);
		$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);
		$ca = $this->GetExcelSupPricesColumnsArray($suppliers_qty);
		$ii=1;
		foreach($ca as $i){
			$colString = PHPExcel_Cell::stringFromColumnIndex($ii-1);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colString.'1', $i['h']);
			$objPHPExcel->getActiveSheet()->getStyle($colString.'1')->getFont()->setBold(true);
			$ii++;
		}
		$charcnt = 0;
		foreach($ca as $i){
			$colString = PHPExcel_Cell::stringFromColumnIndex($charcnt++);
			$objPHPExcel->getActiveSheet()->getColumnDimension($colString)->setWidth($i['w']);
		}
		$ii=2;
		foreach($rows as $r){
			$charcnt = 0;
			foreach($ca as $i){
				$colString = PHPExcel_Cell::stringFromColumnIndex($charcnt++);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colString.$ii, isset($r[$i['n']])?$r[$i['n']]:'');
			}
			$ii++;
		}
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Товары с ценами поставщиков.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
	/**
	 * Список производителей
	 */
	public function GetManufacturers(){
		$sql = "SELECT manufacturer_id, name
			FROM "._DB_PREFIX_."manufacturers
			order by ord, name";
		return $this->db->GetArray($sql);
	}
	/**
	 * [GetCountNameIndex description]
	 */
	public function GetCountNameIndex(){
		$qry = "SELECT id_product
			FROM "._DB_PREFIX_."product
			WHERE name_index IS NULL";
		$result = $this->db->GetArray($qry);
		if(!$result){
			return false;
		}
		return $result;
	}
	/**
	 * [GetName description]
	 * @param [type] $i [description]
	 */
	public function GetName($i){
		$qry = "SELECT name
			FROM "._DB_PREFIX_."product
			WHERE id_product='$i'";
		$name = $this->db->GetArray($qry);
		if(!$name){
			return false;
		}
		return $name[0]['name'];
	}
	/**
	 * [Morphy description]
	 * @param [type] $i          [description]
	 * @param [type] $name_index [description]
	 */
	public function Morphy($i, $name_index){
		$qry = "UPDATE "._DB_PREFIX_."product
			SET name_index='$name_index'
			WHERE id_product='$i'";
		$this->db->Query($qry);
	}
	/**
	 * [PriceListProductCount description]
	 */
	public function PriceListProductCount(){
		$sql = 'SELECT c.id_category, c.category_level, c.name,
			c.pid, c.visible, COUNT(p.id_product) AS products
			FROM '._DB_PREFIX_.'category AS c
			LEFT JOIN '._DB_PREFIX_.'cat_prod AS cp
				ON c.id_category = cp.id_category
			LEFT JOIN '._DB_PREFIX_.'product AS p
				ON p.id_product = cp.id_product AND (p.price_opt > 0 OR p.price_mopt > 0)
			WHERE c.visible = 1
			AND c.sid = 1
			AND c.category_level > 0
			GROUP BY c.id_category
			ORDER BY c.category_level, c.position DESC';
		if(!$arr = $this->db->GetArray($sql)){
			return false;
		}
		return $arr;
	}
	/**
	 * [PriceListProductsByCat description]
	 * @param [type] $id_category [description]
	 */
	public function PriceListProductsByCat($id_category){
		$and = "AND (p.price_opt <> 0 OR p.price_mopt <> 0) ";
		$sql = "SELECT *
			FROM "._DB_PREFIX_."category AS c
			LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
				ON c.id_category = cp.id_category
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON cp.id_product=p.id_product
			WHERE c.id_category = ".$id_category."
			".$and."
			ORDER BY p.art ASC";
		$count = $this->db->GetArray($sql);
		if(!$count){
			return false;
		}
		return $count;
	}
	/**
	 * [AddPriceList description]
	 * @param [type] $pricelist [description]
	 */
	public function AddPriceList($pricelist){
		$sql = "SELECT MAX(ord) AS ord
			FROM "._DB_PREFIX_."pricelists";
		$arr = $this->db->GetOneRowArray($sql);
		$f['order'] = $pricelist['order'];
		$f['name'] = $pricelist['name'];
		$f['set'] = $pricelist['set'];
		$f['visibility'] = $pricelist['visibility'];
		$f['ord'] = $arr['ord']+1;
		if(!$this->db->Insert(_DB_PREFIX_.'pricelists', $f)){
			$this->db->FailTrans();
			return false;
		}
		$sql = "SELECT MAX(ID) AS id
			FROM "._DB_PREFIX_."pricelists";
		$arr = $this->db->GetOneRowArray($sql);
		return $arr['id'];
	}
	/**
	 * [SortPriceLists description]
	 * @param [type] $pricelists [description]
	 */
	public function SortPriceLists($pricelists){
		foreach($pricelists as $k=>$v){
			$sql = "UPDATE "._DB_PREFIX_."pricelists
				SET ord = ".$k."
				WHERE id = ".substr(strstr($v,'-'),1);
			$this->db->Query($sql);
		}
		return true;
	}
	/**
	 * [UpdatePriceList description]
	 * @param [type] $pricelist [description]
	 */
	public function UpdatePriceList($pricelist){
		$f['order'] = $pricelist['order'];
		$f['name'] = $pricelist['name'];
		$f['set'] = $pricelist['set'];
		$f['visibility'] = $pricelist['visibility'];
		if(!$this->db->Update(_DB_PREFIX_."pricelists", $f, "id = ".$pricelist['id'])){
			$this->db->FailTrans();
			return false;
		}
		return true;
	}
	/**
	 * [UpdateSetByOrder description]
	 * @param [type] $pricelist [description]
	 */
	public function UpdateSetByOrder($pricelist){
		$f['opt_correction_set'] = $pricelist['set'];
		$f['mopt_correction_set'] = $pricelist['set'];
		$sql = "SELECT id_product
			FROM "._DB_PREFIX_."osp
			WHERE id_order = ".$pricelist['order'];
		$arr = $this->db->GetArray($sql);
		$err = 0;
		foreach($arr as $product){
			if(!$this->db->Update(_DB_PREFIX_."product", $f, "id_product = ".$product['id_product'])){
				$err++;
			}
		}
		if($err > 0){
			return false;
		}
		return true;
	}
	/**
	 * [DeletePriceList description]
	 * @param [type] $id [description]
	 */
	public function DeletePriceList($id){
		$sql = "DELETE
			FROM "._DB_PREFIX_."pricelists
			WHERE id = ".$id;
		if(!$this->db->Query($sql)){
			return false;
		}
		return true;
	}
	/**
	 * [GetPricelistFullList description]
	 */
	public function GetPricelistFullList(){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."pricelists
			ORDER BY ord";
		$arr = $this->db->GetArray($sql);
		if(!$arr === true){
			return false;
		}
		return $arr;
	}
	/**
	 * [GetPricelistById description]
	 * @param [type] $id [description]
	 */
	public function GetPricelistById($id){
		$sql = "SELECT pl.id, pl.order, pl.name AS price_name, p.id_product,
			p.art, p.translit, p.name, p.img_1, p.min_mopt_qty, p.inbox_qty, un.unit_xt AS units,
			p.price_mopt, p.price_opt, p.opt_correction_set, p.mopt_correction_set,
			c.id_category, c.name AS cat_name, c.category_level,
			osp.note, osp.sort
			FROM "._DB_PREFIX_."pricelists AS pl
			LEFT JOIN "._DB_PREFIX_."osp AS osp
				ON osp.id_order = pl.order
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON p.id_product = osp.id_product
			LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
				ON cp.id_product = p.id_product
			LEFT JOIN "._DB_PREFIX_."category AS c
				ON c.id_category = cp.id_category
			LEFT JOIN "._DB_PREFIX_."units AS un
				ON un.id = p.id_unit
			WHERE pl.id = ".$id."
				AND cp.main = 1
			GROUP BY p.id_product
			ORDER BY osp.sort ASC";
		if(!$arr = $this->db->GetArray($sql)){
			return false;
		}
		return $arr;
	}
	/**
	 * [GetPricelistProducts description]
	 */
	public function GetPricelistProducts(){
		$sql = "SELECT osp.id_product
			FROM "._DB_PREFIX_."osp AS osp
			LEFT JOIN "._DB_PREFIX_."pricelists AS pl
				ON osp.id_order = pl.order
			WHERE pl.visibility = 1";
		$arr = $this->db->GetArray($sql);
		foreach($arr as $a){
			$prods[] = $a['id_product'];
		}
		if(!isset($prods)){
			return false;
		}
		return $prods;
	}
	/**
	 * [ProductReport description]
	 * @param [type] $diff [description]
	 */
	public function ProductReport($diff){
		$sql = "SELECT p.id_product, p.art, p.name
			FROM "._DB_PREFIX_."product AS p
			LEFT JOIN "._DB_PREFIX_."assortiment AS a
				ON a.id_product = p.id_product
			WHERE (SELECT MAX(assort.price_mopt_otpusk)/MIN(assort.price_mopt_otpusk)
				FROM "._DB_PREFIX_."assortiment AS assort
				WHERE assort.active = 1
				AND assort.id_product = p.id_product
				GROUP BY assort.id_product) > ".$diff."
			AND (p.price_mopt > 0 OR price_opt > 0)
			AND a.active = 1
			GROUP BY p.id_product
			ORDER BY p.id_product ASC";
		$arr = $this->db->GetArray($sql);
		foreach($arr as $k=>$a){
			$sql = "SELECT s.article, a.price_mopt_otpusk
				FROM "._DB_PREFIX_."assortiment AS a
				LEFT JOIN "._DB_PREFIX_."supplier AS s
					ON s.id_user = a.id_supplier
				WHERE a.active = 1
				AND a.id_product = ".$a['id_product']."
				GROUP BY a.id_supplier";
			$arr[$k]['suppliers'] = $this->db->GetArray($sql);
		}
		if(!$arr === true){
			return false;
		}
		return $arr;
	}
	/**
	 * [AddSupplierProduct description]
	 * @param [type] $data [description]
	 */
	public function AddSupplierProduct($data){
		$f['name'] = $data['name'];
		$f['descr'] = nl2br($data['descr'], false);
		$f['images'] = $data['images'];
		$f['img_1'] = isset($data['img_1'])?$data['img_1']:null;
		$f['img_2'] = isset($data['img_2'])?$data['img_1']:null;
		$f['img_3'] = isset($data['img_3'])?$data['img_1']:null;
		$f['id_unit'] = $data['id_unit'];
		$f['min_mopt_qty'] = $data['min_mopt_qty'];
		$f['inbox_qty'] = $data['inbox_qty'];
		$f['price_mopt'] = str_replace(',','.', $data['price_mopt']);
		$f['price_opt'] = str_replace(',','.', $data['price_opt']);
		$f['qty_control'] = 0;
		if(isset($data['qty_control']) && $data['qty_control'] == 1){
			$f['qty_control'] = $data['qty_control'];
		}
		$f['weight'] = number_format((float) $data['weight'], 3);
		$f['volume'] = $data['volume'];
		$f['height'] = $data['height'];
		$f['width'] = $data['width'];
		$f['length'] = $data['length'];
		$f['coefficient_volume'] = $data['coefficient_volume'];
		$f['product_limit'] = $data['product_limit'];
		$f['moderation_status'] = 0;
		$this->db->StartTrans();
		if(isset($data['id'])){
			if(!$this->db->Update(_DB_PREFIX_.'temp_products', $f, "id = ".$data['id'])){
				$this->db->FailTrans();
				return false;
			}
		}else{
			$f['id_supplier'] = $_SESSION['member']['id_user'];
			if(!$this->db->Insert(_DB_PREFIX_.'temp_products', $f)){
				$this->db->FailTrans();
				return false;
			}
		}
		$this->db->CompleteTrans();
		return true;
	}
	/**
	 * [GetProductsOnModeration description]
	 * @param [type] $id_supplier [description]
	 */
	public function GetProductsOnModeration($id_supplier = null){
		$sql = "SELECT ".implode(", ",$this->usual_fields_temp_prods).",
			ms.name AS status_name, unit_xt AS units
			FROM "._DB_PREFIX_."temp_products AS tp
			LEFT JOIN "._DB_PREFIX_."units AS u
				ON u.id = tp.id_unit
			LEFT JOIN "._DB_PREFIX_."moderation_statuses AS ms
				ON ms.id = tp.moderation_status";
		if(isset($id_supplier)){
			$sql .= " WHERE id_supplier = ".$id_supplier;
		}
		$sql .= " ORDER BY tp.moderation_status ASC, creation_date DESC";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		return $arr;
	}
	/**
	 * Проверка наличия картинки в базах
	 * @param [type] $path [description]
	 */
	public function CheckImages($path){
		$sql = "SELECT COUNT(*) AS count
			FROM "._DB_PREFIX_."image
			WHERE src LIKE '%".$path."'";
		$arr = $this->db->GetOneRowArray($sql);
		if($arr['count'] > 1){
			return false;
		}
		return true;
	}
	/**
	 * [SetModerationStatus description]
	 * @param [type] $id      [description]
	 * @param [type] $status  [description]
	 * @param [type] $comment [description]
	 */
	public function SetModerationStatus($id, $status, $comment = null){
		$f['id'] = $id;
		$f['moderation_status'] = $status;
		if($comment != ''){
			$f['comment'] = $comment;
		}
		if(!$this->db->Update(_DB_PREFIX_.'temp_products', $f, "id = ".$f['id'])){
			$this->db->FailTrans();
			return false;
		}
		return true;
	}
	/**
	 * [GetProductOnModeration description]
	 * @param [type] $id [description]
	 */
	public function GetProductOnModeration($id){
		$sql = "SELECT ".implode(", ",$this->usual_fields_temp_prods).",
			ms.name AS status_name
			FROM "._DB_PREFIX_."temp_products AS tp
			LEFT JOIN "._DB_PREFIX_."moderation_statuses AS ms
				ON ms.id = tp.moderation_status
			WHERE tp.id = ".$id;
		$arr = $this->db->GetOneRowArray($sql);
		if(!$arr){
			return false;
		}
		return $arr;
	}
	/**
	 * [DeleteProductFromModeration description]
	 * @param [type] $id_product [description]
	 */
	public function DeleteProductFromModeration($id_product){
		$prod = $this->GetProductOnModeration($id_product);
		$images = explode(';', $prod['images']);
		foreach($images as $image){
			if($image != '' && $this->CheckPhotosOnModeration(basename($image))){
				unlink($_SERVER['DOCUMENT_ROOT'].str_replace( _base_url, '/', $image));
			}
		}
		if($prod['img_1'] != '' && $this->CheckPhotosOnModeration(basename($prod['img_1']))){
			unlink($_SERVER['DOCUMENT_ROOT'].str_replace(_base_url, '/', $prod['img_1']));
		}
		if($prod['img_2'] != '' && $this->CheckPhotosOnModeration(basename($prod['img_2']))){
			unlink($_SERVER['DOCUMENT_ROOT'].str_replace(_base_url, '/', $prod['img_2']));
		}
		if($prod['img_3'] != '' && $this->CheckPhotosOnModeration(basename($prod['img_3']))){
			unlink($_SERVER['DOCUMENT_ROOT'].str_replace(_base_url, '/', $prod['img_3']));
		}
		$this->db->StartTrans();
		if(!$this->db->DeleteRowsFrom(_DB_PREFIX_."temp_products", array("id = ".$id_product))){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	/**
	 * [AcceptProductModeration description]
	 * @param [type] $data [description]
	 */
	public function AcceptProductModeration($data){
		$product = $this->GetProductOnModeration($data['id']);
		$f['art'] = $data['art'];
		$f['name'] = $product['name'];
		$f['translit'] = G::StrToTrans($product['name']);
		$f['descr'] = $product['descr'];
		$f['inbox_qty'] = $product['inbox_qty'];
		$f['min_mopt_qty'] = $product['min_mopt_qty'];
		if(isset($product['qty_control'])){
			$f['qty_control'] = $product['qty_control'];
		}
		$f['sertificate'] = '';
		$f['country'] = '';
		$f['max_supplier_qty'] = 0;
		$f['manufacturer_id'] = 0;
		$f['weight'] = ($product['height'] * $product['width'] * $product['length']) * 0.000001;
		$f['volume'] = str_replace(',','.', $product['weight']);
		$f['height'] = $product['height'];
		$f['width'] = $product['width'];
		$f['length'] = $product['length'];
		$f['coefficient_volume'] = $product['coefficient_volume'];
		$f['edit_user'] = trim($_SESSION['member']['id_user']);
		$f['edit_date'] = date('Y-m-d H:i:s');
		$f['create_user'] = $product['id_supplier'];
		$f['id_unit'] = $product['id_unit'];
		$f['prod_status'] = 3;
		$f['indexation'] = 1;
		$Images = new Images();
		if(isset($product['images']) && $product['images'] != ''){
			foreach(explode(';', $product['images']) as $k=>$image){
				$to_resize[] = $newname = $data['art'].($k == 0?'':'-'.$k).'.jpg';
				$structure = $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/';
				$structure_bd = '/product_images/original/'.date('Y').'/'.date('m').'/'.date('d').'/';
				$Images->checkStructure($structure);
				copy($_SERVER['DOCUMENT_ROOT'].str_replace(_base_url, '/', $image), $structure.$newname);
				$images_arr[] = $structure_bd.$newname;
				$visible[] = 1;
			}
		}else{
			$images_arr =  array();
		}
		$Images->resize(false, $to_resize);
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'product', $f)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		$sql = "SELECT MAX(id_product) AS id_product
			FROM "._DB_PREFIX_."product";
		$res = $this->db->GetOneRowArray($sql);
		$sql = "SELECT koef_nazen_mopt, koef_nazen_opt
			FROM "._DB_PREFIX_."supplier
			WHERE id_user = ".$product['id_supplier'];
		$sup = $this->db->GetOneRowArray($sql);
		$id = $res['id_product'];
		$a['id_product'] = $id ;
		$this->UpdatePhoto($id, $images_arr, $visible);
		$a['id_supplier'] = $product['id_supplier'];
		$a['price_mopt_otpusk'] = str_replace(',','.', $product['price_mopt']);
		$a['price_opt_otpusk'] = str_replace(',','.', $product['price_opt']);
		$a['price_mopt_recommend'] = str_replace(',','.', $product['price_mopt']*$sup['koef_nazen_mopt']);
		$a['price_opt_recommend'] = str_replace(',','.', $product['price_opt']*$sup['koef_nazen_opt']);
		$a['product_limit'] = $product['product_limit'];
		$a['sup_comment'] = '';
		$a['edited'] = date('Y-m-d');
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'assortiment', $a)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return $id;
	}
	/**
	 * [GetPromoProducts description]
	 * @param [type] $promo_code [description]
	 * @param string $limit      [description]
	 */
	public function GetPromoProducts($promo_code, $limit = ''){
		if(is_numeric($limit)){
			$limit = "LIMIT $limit";
		}
		$sql = "SELECT p.id_product, p.art, p.name, p.translit, p.descr,
			p.img_1, p.img_2, p.img_3, p.inbox_qty, p.min_mopt_qty,
			p.qty_control, 1+pc.percent/100 AS percent, p.visible, un.unit_xt AS units,
			a.price_mopt_otpusk*(1+(pc.percent/100)) AS price_mopt
			FROM "._DB_PREFIX_."product AS p
			LEFT JOIN "._DB_PREFIX_."assortiment AS a
				ON a.id_product = p.id_product
			LEFT JOIN "._DB_PREFIX_."supplier AS s
				ON s.id_user = a.id_supplier
			LEFT JOIN "._DB_PREFIX_."promo_code AS pc
				ON pc.id_supplier = s.id_user
			LEFT JOIN "._DB_PREFIX_."units AS un
				ON un.id = p.id_unit
			WHERE pc.code = ". $promo_code."
			AND (a.price_opt_otpusk > 0 OR a.price_mopt_otpusk > 0)
			$limit";
		$arr = $this->db->GetArray($sql);
		if(empty($arr)){
			return false;
		}
		return $arr;
	}
	/**
	 * [GetPromoProductsCnt description]
	 * @param [type] $promo_code [description]
	 */
	public function GetPromoProductsCnt($promo_code){
		$sql = "SELECT COUNT(a.id_product) AS cnt
			FROM "._DB_PREFIX_."assortiment AS a
			LEFT JOIN "._DB_PREFIX_."supplier AS s
				ON s.id_user = a.id_supplier
			LEFT JOIN "._DB_PREFIX_."promo_code AS pc
				ON pc.id_supplier = s.id_user
			WHERE pc.code = ".$promo_code."
			AND (a.price_opt_otpusk > 0 OR a.price_mopt_otpusk > 0)
			GROUP BY a.id_supplier";
		$arr = $this->db->GetOneRowArray($sql);
		if(!$arr['cnt']){
			return 0;
		}
		return $arr['cnt'];
	}
	/**
	 * [UpdateProductsPopularity description]
	 */
	public function UpdateProductsPopularity(){
		$this->db->StartTrans();
		$sql = "UPDATE "._DB_PREFIX_."product AS p
			SET popularity = (
				SELECT COUNT(id_order) AS orders
			FROM "._DB_PREFIX_."osp AS osp
			LEFT JOIN "._DB_PREFIX_."order AS o
				ON osp.id_order = o.id_order
			WHERE p.id_product = osp.id_product
			AND o.creation_date > UNIX_TIMESTAMP(DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 30 DAY))
			GROUP BY osp.id_product)";
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		$this->db->CompleteTrans();
	}
	/**
	 * [GetProductRating description]
	 * @param [type] $id_product [description]
	 */
	public function GetProductRating($id_product){
		$sql = "SELECT * FROM "._DB_PREFIX_."product_rating AS pr WHERE pr.id_product = ".$id_product;
		$arr = $this->db->GetArray($sql);
		if(empty($arr)){
			return false;
		}
		return $arr;
	}
	/**
	 * [ToggleDuplicate description]
	 * @param [type] $id_product        [description]
	 * @param [type] $duplicate_user    [description]
	 * @param [type] $duplicate_comment [description]
	 */
	public function ToggleDuplicate($id_product, $duplicate_user, $duplicate_comment){
		$sql = "SELECT duplicate
			FROM "._DB_PREFIX_."product
			WHERE id_product = ".$id_product;
		$arr = $this->db->GetOneRowArray($sql);
		$f['duplicate'] = 0;
		$f['duplicate_user'] = $duplicate_user;
		$f['duplicate_comment'] = $duplicate_comment;
		$f['duplicate_date'] = date('Y-m-d H:i:s');
		if($arr['duplicate'] == 0){
			$f['duplicate'] = 1;
		}
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."product", $f, "id_product = ".$id_product)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	/**
	 * [GetDuplicateProducts description]
	 * @param string $limit [description]
	 */
	public function GetDuplicateProducts($limit = ''){
		if($limit != ''){
			$limit = "LIMIT $limit";
		}
		$sql = "SELECT ".implode(', ',$this->usual_fields).", pv.count_views,
			u.email
			FROM "._DB_PREFIX_."product AS p
			LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
				ON p.id_product = cp.id_product
			LEFT JOIN "._DB_PREFIX_."user AS u
				ON p.duplicate_user = u.id_user
			LEFT JOIN "._DB_PREFIX_."units AS un
				ON un.id = p.
			LEFT JOIN "._DB_PREFIX_."prod_views AS pv
				ON pv.id_product = p.id_product
			WHERE p.visible = 1
			AND (p.duplicate = 1 OR p.duplicate_user > 0)
			GROUP BY id_product
			$limit";
		$arr = $this->db->GetArray($sql);
		if(empty($arr)){
			return false;
		}
		return $arr;
	}

	/**
	 * СОПУЦТВУЕЩИЕ ТОВАРЫ
	 */

	/**
	 * Добавление товара
	 * @param [type] $id_product      [description]
	 * @param [type] $id_related_prod [description]
	 */
	public function AddRelatedProduct($id_product, $id_related_prod){
		$f['id_prod'] = trim($id_product);
		$f['id_related_prod'] = trim($id_related_prod);
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'related_prods', $f)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	/**
	 * Удаление товара
	 * @param [type] $id_product      [description]
	 * @param [type] $id_related_prod [description]
	 */
	public function DelRelatedProduct($id_product, $id_related_prod){
		$this->db->StartTrans();
		$sql = "DELETE FROM "._DB_PREFIX_."related_prods WHERE `id_prod` = ".$id_product." AND `id_related_prod` = ".$id_related_prod;
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		$this->db->CompleteTrans();
		return true;
	}
	/**
	 * Получение массива сопуцтвующих товаров
	 * @param [type] $id_product [description]
	 */
	public function GetArrayRelatedProducts($id_product){
		$sql = "SELECT a.active, p.*
			FROM "._DB_PREFIX_."related_prods AS rp
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON p.id_product = rp.id_related_prod
			LEFT JOIN "._DB_PREFIX_."assortiment AS a
				ON a.id_product = rp.id_related_prod
			WHERE rp.id_prod = ".$id_product;
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		return $arr;
	}

	/**
	 * PHOTO ACTIONS
	 */

	/**
	 * Проверить, нет ли такого фото в другом товаре
	 * @param [type] $image [description]
	 */
	public function CheckPhotosOnModeration($image){
		$sql = "SELECT COUNT(id) AS count
			FROM "._DB_PREFIX_."temp_products
			WHERE img_1 LIKE '%".$image."'
			OR img_2 LIKE '%".$image."'
			OR img_3 LIKE '%".$image."'
			OR images LIKE '%".$image."%'";
		$arr = $this->db->GetOneRowArray($sql);
		if($arr['count'] > 1){
			return false;
		}
		return true;
	}
	/**
	 * Получить список изображений по id товара
	 * @param [type] $id [description]
	 */
	public function GetPhotoById($id, $visible = false){
		$sql = "SELECT src, visible
			FROM "._DB_PREFIX_."image
			WHERE id_product = ".$id.
			($visible === false?' AND visible = 1':null)."
			ORDER BY ord";
		if(!$arr = $this->db->GetArray($sql)){
			return false;
		}
		return $arr;
	}
	/**
	 * Добавление и удаление фото
	 * @param [type] $id_product [description]
	 * @param [type] $arr        [description]
	 */
	public function UpdatePhoto($id_product, $arr, $visible = null){
		$sql = "DELETE FROM "._DB_PREFIX_."image WHERE id_product=".$id_product;
		$this->db->StartTrans();
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		$this->db->CompleteTrans();
		$f['id_product'] = trim($id_product);
		if(isset($arr) && !empty($arr)){
			foreach($arr as $k=>$src){
				if(empty($src)){
					return false; //Если URL пустой
				}
				$f['src'] = trim($src);
				$f['ord'] = $k;
				$f['visible'] = isset($visible[$k])?$visible[$k]:0;
				$this->db->StartTrans();
				if(!$this->db->Insert(_DB_PREFIX_.'image', $f)){
					$this->db->FailTrans();
					return false; //Если не удалось записать в базу
				}
				$this->db->CompleteTrans();
			}
		}
		unset($id_product);
		unset($f);
		return true;//Если все ок
	}
	/**
	 * Проверка доступности артикула
	 * @param integer	$art		Артикул нового товара
	 * @param array		$art_arr	Массив с имеющимися артикулами
	 */
	public function CheckArticle($art, $art_arr = null){
		ini_set('memory_limit', '256M');
		if($art_arr == null){
			$sql = "SELECT art
				FROM "._DB_PREFIX_."product
				WHERE art <> ''";
			$art_arr = $this->db->GetArray($sql);
			foreach ($art_arr as &$value) {
				$value = (int) $value['art'];
			}
		}
		if(in_array($art, $art_arr)){
			$art = $this->CheckArticle($art+1, $art_arr);
		}
		ini_set('memory_limit', '192M');
		return $art;
	}
	/**
	 * Отвязка товаров от категории "Новинки" по истечению определенного срока
	 */
	public function ClearNewCategory(){
		$sql = "DELETE FROM "._DB_PREFIX_."cat_prod
			WHERE id_category = ".$GLOBALS['CONFIG']['new_catalog_id']."
			AND (SELECT p.create_date
				FROM "._DB_PREFIX_."product AS p
				WHERE p.id_product = "._DB_PREFIX_."cat_prod.id_product) < (NOW() - INTERVAL ".$GLOBALS['CONFIG']['new_products_lifetime']." DAY)";
		$this->db->StartTrans();
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}
	/**
	 * Вернуть все фильтры для заданной категории
	 * @param [type] $id_category id категории
	 */
	public function GetFilterFromCategory($id_category){
		$sql = "SELECT s.id, s.caption, s.units,
			sp.id AS id_val,
			(CASE WHEN sp.value IS NOT NULL THEN sp.value ELSE svl.value END) AS value,
			sc.id AS id_specs_cats, sc.position
		FROM
			xt_cat_prod AS cp
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON cp.id_product = p.id_product
			LEFT JOIN "._DB_PREFIX_."specs_prods AS sp
				ON cp.id_product = sp.id_prod
			LEFT JOIN "._DB_PREFIX_."specs AS s
				ON sp.id_spec = s.id
			LEFT JOIN "._DB_PREFIX_."specs_cats AS sc
				ON s.id = sc.id_spec AND sc.id_cat = cp.id_category
			LEFT JOIN "._DB_PREFIX_."specs_values_list AS svl
				ON sp.id_value = svl.id
		WHERE cp.id_category ".(is_array($id_category)?'IN ('.implode(', ', $id_category).')':'= '.$id_category)."
			AND s.id IS NOT NULL
		GROUP BY s.id, value";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		return $arr;
	}

	/**
	 * Вернуть выключенные фильтры для заданной категории
	 * @param [type] $id_category id категории
	 */
	public function GetNoFilterFromCategory($id_category){
		$sql = "SELECT s.id, s.caption, s.units, sp.id as id_val, sp.value, sp.id_prod, sc.id_spec
			FROM "._DB_PREFIX_."cat_prod AS cp
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON cp.id_product = p.id_product
			LEFT JOIN "._DB_PREFIX_."specs_prods AS sp
				ON cp.id_product = sp.id_prod
			LEFT JOIN "._DB_PREFIX_."specs AS s
				ON sp.id_spec = s.id
			JOIN "._DB_PREFIX_."specs_cats AS sc ON sp.id_spec = sc.id_spec
			WHERE cp.id_category ".(is_array($id_category)?'IN ('.implode(', ', $id_category).')':'= '.$id_category)."
			AND sp.value <> ''

			AND p.visible > 0 AND (p.price_opt >0 OR p.price_mopt>0)
			GROUP BY s.id";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		return $arr;
	}

	public function UpdateFilterFromCategory($id_category){
		$sql = "UPDATE "._DB_PREFIX_."specs_cats
		SET 'visible' = 0 WHERE 'id_spec' = '.$id_spec.' AND 'id_cat' =  '.$id_cat.'";
		$this->db->StartTrans();
		$res = $this->db->Execute($sql);

		$this->db->CompleteTrans();
		return true;
	}

	/**
	 * Вернуть выключенные фильтры для заданной категории
	 * @param [type] $id_category id категории
	 */
	public function GetChangeFilterFromCategory($id_category){
		$sql = "SELECT s.id, s.caption, s.units, sp.id as id_val, sp.value
			FROM "._DB_PREFIX_."cat_prod AS cp
			LEFT JOIN "._DB_PREFIX_."product AS p ON cp.id_product = p.id_product
			LEFT JOIN "._DB_PREFIX_."specs_prods AS sp
				ON cp.id_product = sp.id_prod
			LEFT JOIN "._DB_PREFIX_."specs AS s
				ON sp.id_spec = s.id
			LEFT JOIN "._DB_PREFIX_."specs_cats AS sc ON sp.id_spec = sc.id_spec
			WHERE cp.id_category ".(is_array($id_category)?'IN ('.implode(', ', $id_category).')':'= '.$id_category)."
			AND s.id IS NOT NULL
			AND sp.value <> ''
			AND sc.visible <> '1'
			AND p.visible > 0 AND (p.price_opt >0 OR p.price_mopt>0)
			GROUP BY s.id, sp.value";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		return $arr;
	}
	/**
	 * Вернуть актуальные фильтры с учетом выбраных
	 * @param [type] $add_filters [description]
	 * @param [type] $id_category [description]
	 */
	public function GetFilterFromCategoryNow($add_filters = null, $id_category){
		$spec_str = '';
		$cnt_active_filter = 0;
		if($add_filters){
			foreach($add_filters as $spec => $filter){
				if($spec_str != ''){
					$spec_str .= "OR ";
				}
				$spec_str .= "(sp.id_spec IN (" . $spec . ") AND sp.value IN (SELECT sp1.value FROM "._DB_PREFIX_."specs_prods AS sp1 WHERE sp1.id IN (" . implode(',', $filter) . "))) ";
				$cnt_active_filter++;
			}

			$sql = "SELECT *
			FROM "._DB_PREFIX_."specs_prods as sp1
			WHERE  sp1.id_prod IN (SELECT sp.id_prod
				FROM "._DB_PREFIX_."specs_prods as sp
				WHERE ". $spec_str ."
				AND sp.id_prod IN (SELECT cp.id_product FROM "._DB_PREFIX_."cat_prod as cp WHERE cp.id_category = ".$id_category." )
				GROUP BY sp.id_prod
				HAVING COUNT(sp.id_prod) = ".$cnt_active_filter.")";
			$arr = $this->db->GetArray($sql);
		}
		if(!$arr){
			return false;
		}
		return true;
	}
	/**
	 * [GetCntFilterNow description]
	 * @param [type] $id_categorys [description]
	 */
	public function GetCntFilterNow($id_category){
		$sql = "SELECT sp.id as id_val, sp.value, COUNT(sp.id_prod) as cnt, s.caption
			FROM "._DB_PREFIX_."cat_prod AS cp
			LEFT JOIN "._DB_PREFIX_."specs_prods AS sp
				ON cp.id_product = sp.id_prod
			LEFT JOIN "._DB_PREFIX_."specs AS s
				ON sp.id_spec = s.id
			WHERE cp.id_category ".(is_array($id_category)?'IN ('.implode(', ', $id_category).')':'= '.$id_category)."
			-- AND sp.id_prod IN ()
			AND s.id IS NOT NULL
			AND sp.value <> ''
			GROUP BY s.id, sp.value";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		return true;
	}
	/**
	 * [DuplicateProduct description]
	 * @param [type] $data [description]
	 */
	public function DuplicateProduct($data){
		// creating new article
		$art = $this->CheckArticle((int) $this->GetLastArticle());
		// duplicating main product information & category
		$this->SetFieldsById($data['id_product']);
		$old_product_info = $this->fields;
		$old_product_info['art'] = $art;
		// $old_product_info['dupl_idproduct'] = $data['id_product'];
		$old_product_info['name'] .= ' '.$art.' - Измените название!!!!';
		if(!$id_product = $this->AddProduct($old_product_info)){
			return false;
		}
		// duplicating product assortment
		$sql = "SELECT * FROM "._DB_PREFIX_."assortiment AS a
			WHERE a.id_product = ".$data['id_product'];
		$res = $this->db->GetArray($sql);
		if(!empty($res)){
			foreach ($res as &$value) {
				$value['id_product'] = $id_product;
				$this->AddToAssortWithAdm($value);
			}
		}
		// duplicating product specifications
		$sql = "SELECT * FROM "._DB_PREFIX_."specs_prods as s
			WHERE s.id_prod = ".$data['id_product'];
		$res = $this->db->GetArray($sql);
		if(!empty($res)){
			$specifications = new Specification();
			foreach($res as $value){
				$specifications->AddSpecToProd($value, $id_product);
			}
		}
		// duplicating product segmentation
		$sql = "SElECT * FROM "._DB_PREFIX_."segment_prods AS sp
		WHERE sp.id_product = ".$data['id_product'];
		$res = $this->db->GetArray($sql);
		if(!empty($res)){
			$segmentation = new Segmentation();
			foreach($res as $value){
				$segmentation->AddSegmentInProduct($id_product, $value['id_segment']);
			}
		}
		// duplicating product videos
		if(!empty($res = $this->GetVideoById($data['id_product']))){
			$this->UpdateVideo($id_product, $res);
		}
		// duplicating product images
		if(!empty($res = $this->GetPhotoById($data['id_product']))){
			foreach($res as &$value){
				$value = $value['src'];
			}
			$this->UpdatePhoto($id_product, $res);
		}
		return $id_product;
	}
	/**
	 * [SetFieldsForMonitoringSpecifications description]
	 * @param [type] $params [description]
	 */
	public function SetFieldsForMonitoringSpecifications($params){
		foreach($params as $key => $value){

		}
	}
	/**
	 * Находим все значения, которые привязаны к типу товара
	 * @param  [type] $id_spec    [description]
	 * @param  [type] $id_category [description]
	 * @return [type]        [description]
	 */
	public function getValuesItem($id_spec, $id_category){
		$sql = "SELECT DISTINCT sp.value
			FROM "._DB_PREFIX_."specs_prods AS sp
				INNER JOIN "._DB_PREFIX_."cat_prod AS cp
					ON sp.id_prod = cp.id_product
			WHERE sp.id_spec = $id_spec
			AND cp.id_category IN ($id_category)
			AND sp.value IS NOT NULL";
		$res = $this->db->GetArray($sql);
		if (!$res){
			return false;
		}
		return $res;
	}
	/**
	 * Получить последний артикул в БД
	 */
	public function GetLastArticle(){
		$sql = "SELECT id_product, art
			FROM "._DB_PREFIX_."product
			WHERE id_product = (SELECT MAX(id_product) FROM "._DB_PREFIX_."product)";
		$res = $this->db->GetOneRowArray($sql);
		if(!$res){
			return false;
		}
		return $res['art'];
	}
	/**
	 * [generateNavigation description]
	 * @param  [type]  $list [description]
	 * @param  integer $lvl  [description]
	 * @return [type]        [description]
	 */
	public function generateNavigation($list, $lvl = 0, $no_rel = false, $search = false){
		if(isset($GLOBALS['CURRENT_ID_CATEGORY'])){
			$id_cat = $GLOBALS['CURRENT_ID_CATEGORY'];
		}
		$lvl++;
		$arr['clear']='true';
		if(isset($_POST['idsegment'])){
			$arr['segment'] = $_POST['idsegment'];
		}
		$ul = '<ul '.($lvl == 1?'class="navigation allSections" ':'').'data-lvl="'.$lvl.'">';
		foreach($list as $l){
			$ul .= '<li class="link_wrap'.(isset($GLOBALS['current_categories']) && in_array($l['id_category'], $GLOBALS['current_categories'])?' active':null).'">';
			$ul .= '<a'.($no_rel || (!isset($GLOBALS['current_categories']) && $GLOBALS['CurrentController'] != 'product')?null:' rel="nofollow"') .($search?' href="/search?query='.$_SESSION['search']['query'].'&search_category='.$l['id_category'].'':' href="'.Link::Category($l['translit'],$arr)).'">';
			if(!empty($l['subcats']) && !isset($_GET['debug'])){
				$ul .= '<span class="more_cat material-icons">&#xE315;</span>';
			}
			$ul .= (isset($l['count'])?'<span class="count">'.$l['count'].'</span>':null).'<span class="text">'.$l['name'].'</span></a>';
			if(!empty($l['subcats']) && !isset($_GET['debug'])){
				$ul .= $this->generateNavigation($l['subcats'], $lvl, ((isset($id_cat) && $id_cat == $l['id_category']) || $no_rel)?true:null, $search);
			}
			$ul .= '</li>';
		}
		$ul .= '</ul>';
		return $ul;
	}

	/**
	 * Построить иерархический массив по списку категорий
	 * @param  [type] $categories Массив идентификаторов категорий
	 * @return [type]         Иерархический массив
	 */
	public function navigation($categories, $count_cat=false){
		$dbtree = new dbtree(_DB_PREFIX_ . 'category', 'category', $this->db);
		//Достаем категории 1-го уровня
		$navigation = $dbtree->GetCategories(array('id_category', 'category_level', 'name', 'translit', 'pid'), 1);
		//Перебираем категории 2-го и 3-го уровня, отсекая ненужные
		foreach ($navigation as $key1 => &$l1) {
			$l1['count'] = 0;
			$level2 = $dbtree->GetSubCats($l1['id_category'], 'all');
			foreach ($level2 as $key2 => &$l2) {
				$l2['count'] = 0;
				$level3 = $dbtree->GetSubCats($l2['id_category'], 'all');
				foreach ($level3 as $key3 => &$l3) {
					if (!in_array($l3['id_category'], $categories)) {
						unset($level3[$key3]);
					} elseif ($count_cat){
						$l3['count'] = $count_cat[$l3['id_category']];
						$l2['count'] += $l3['count'];
					}
				}
				if (in_array($l2['id_category'], $categories) || !empty($level3)) {
					$l2['subcats'] = $level3;
					if ($count_cat && isset($count_cat[$l2['id_category']])){
						$l2['count'] += $count_cat[$l2['id_category']];
					}
					$l1['count'] += $l2['count'];
				} else {
					unset($level2[$key2]);
				}
			}
			if (in_array($l1['id_category'], $categories) || !empty($level2)) {
				$l1['subcats'] = $level2;
				if ($count_cat && isset($count_cat[$l1['id_category']])){
					$l1['count'] += $count_cat[$l1['id_category']];
				}
			} else {
				unset($navigation[$key1]);
			}
		}
		return $navigation;
	}
	public function GetCatBreadCrumbs($id_product){
		$sql = "SELECT c.id_category
				FROM "._DB_PREFIX_."category c
				LEFT JOIN xt_cat_prod cp ON c.id_category = cp.id_category
				WHERE c.sid=1 AND cp.id_product = ".$id_product." AND cp.main = 1";
		if(!$res = $this->db->GetOneRowArray($sql)){
			$sql = "SELECT MIN(c.id_category) AS id_category
				FROM "._DB_PREFIX_."category c
				LEFT JOIN xt_cat_prod cp ON c.id_category = cp.id_category
				WHERE c.sid=1 AND cp.id_product = ".$id_product;
			if(!$res = $this->db->GetOneRowArray($sql)){
				return false;
			}
		}
		return $res['id_category'];
	}

	public function generateCategory(){
		$sql ='SELECT c.id_category, c.name, c.category_level, c.pid,
				(CASE
					WHEN c.category_level = 1 THEN c.id_category
					WHEN c.category_level = 2 THEN c.pid
					ELSE (SELECT c2.pid FROM '._DB_PREFIX_.'category AS c2 WHERE c2.id_category = c.pid)
				END) AS sort,
				(CASE
					WHEN c.category_level = 2 THEN c.id_category
					WHEN c.category_level = 3 THEN c.pid
					ELSE 0
				END) AS sort2
			FROM '._DB_PREFIX_.'category AS c
			WHERE c.category_level <> 0
				AND c.sid = 1
			ORDER BY sort, sort2, category_level';
			// AND c.id_category <> 493
			// AND c.pid NOT IN (493)
			// AND c.pid NOT IN (SELECT id_category FROM xt_category WHERE pid = 493)
			// AND c.category_level <> 4
		return $this->db->GetArray($sql);
	}

	public function AddPhotoProduct($data){
		// try to create new product
		if(!$id_product = $this->AddProduct($data)){
			return false;
		}
		$article = $this->GetArtByID($id_product);
		// try to add photos to the new product
		foreach($data['images'] as $k => $image){
			$to_resize[] = $newname = $article['art'].($k == 0?'':'-'.$k).'.jpg';
			$file = pathinfo($image['src']);
			$path = $GLOBALS['PATH_root'].$file['dirname'].'/';
			$bd_path = $file['dirname'];
			rename($path.$file['basename'], $path.$newname);
			$images_arr[] = $file['dirname'].'/'.$newname;
			$visibility[] = $image['visible'] == 'true'?1:0;
		}
		//Проверяем ширину и высоту загруженных изображений, и если какой-либо из показателей выше 1000px, уменяьшаем размер
		foreach($images_arr as $filename){
			$size = getimagesize($GLOBALS['PATH_root'].$filename); //Получаем ширину, высоту, тип картинки
			if($size[0] > 1000 || $size[1] > 1000){
				$ratio = $size[0]/$size[1]; //коэфициент соотношения сторон
				//Определяем размеры нового изображения
				if(max($size[0], $size[1]) == $size[0]){
					$width = 1000;
					$height = 1000/$ratio;
				}elseif(max($size[0], $size[1]) == $size[1]){
					$width = 1000*$ratio;
					$height = 1000;
				}
			}else{
				$width = $size[0];
				$height = $size[1];
			}
			$res = imagecreatetruecolor($width, $height);
			imagefill($res, 0, 0, imagecolorallocate($res, 255, 255, 255));
			$src = $size['mime'] == 'image/jpeg'?imagecreatefromjpeg($GLOBALS['PATH_root'].$filename):imagecreatefrompng($GLOBALS['PATH_root'].$filename);
			imagecopyresampled($res, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
			imagejpeg($res, $GLOBALS['PATH_root'].$filename);
		}
		$Images = new Images();
		$Images->resize(false, $to_resize);
		$this->UpdatePhoto($id_product, $images_arr, $visibility);
		// try to add videos
		if(!empty($_POST['video'])){
			$this->UpdateVideo($id_product, $_POST['video']);
		}
		// try to add new product to supplier's assort
		$Suppliers = new Suppliers();
		$id_supplier = $Suppliers->GetSupplierIdByArt($data['art_supplier']);
		if(!$this->AddToAssort($id_product, $id_supplier)){
			return false;
		}

		// Добавление данных в таблицу photo_batch
		$date = date('Y-m-d');
		$id_author  = $_SESSION['member']['id_user'];
		$id_batch = $this->GetIdPhotoBatch($date, $id_supplier, $id_author);
		if($id_batch){
			$this->AddPhotoBatchProducts($id_batch, $id_product);
		}else{
			$f['date'] = date('Y-m-d');
			$f['id_supplier'] = $id_supplier;
			$f['id_author'] = $id_author;
			$this->db->StartTrans();
			if(!$this->db->Insert(_DB_PREFIX_.'photo_batch', $f)){
				$this->db->FailTrans();
				return false;
			}
			$this->db->CompleteTrans();
			$id_batch = $this->GetIdPhotoBatch($date, $id_supplier, $id_author);
			$this->AddPhotoBatchProducts($id_batch, $id_product);
		}
		return $id_product;
	}

	// Достаем id записи из таблицы photo_batch
	public function GetIdPhotoBatch($date, $id_supplier, $id_author){
		$sql = "SELECT id FROM "._DB_PREFIX_."photo_batch
			WHERE date = '".$date."' AND id_supplier = ".$id_supplier."
			AND id_author =".$id_author;
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res['id'];
	}

	// Добавление данных в таблицу photo_batch_products
	public function AddPhotoBatchProducts($id_photo_batch, $id_product){
		$f['id_photo_batch'] = $id_photo_batch;
		$f['id_product'] = $id_product;
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'photo_batch_products', $f)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	public function GetProductsByIdUser($id_user, $date = false, $id_supplier = false){
		$sql= "SELECT p.id_product, p.`name`, p.translit, p.indexation,
				p.create_date, p.create_user, a.id_supplier AS id_supplier
				FROM "._DB_PREFIX_."product p
				LEFT JOIN "._DB_PREFIX_."assortiment a ON a.id_product = p.id_product
				LEFT JOIN "._DB_PREFIX_."supplier s ON s.id_user = a.id_supplier
				LEFT JOIN "._DB_PREFIX_."user u ON s.id_user = u.id_user
				WHERE p.sid = 1 AND p.create_user = ".$id_user.
				($date?' AND p.create_date LIKE \''.$date.'%\'':'').
				($id_supplier?' AND a.id_supplier = '.$id_supplier:'').
				" GROUP BY p.create_date, a.id_supplier
				ORDER BY create_date DESC";
		if(!$res = $this->db->GetArray($sql)){
			return false;
		}
		foreach ($res as &$v){
			$v['images'] = $this->GetPhotoById($v['id_product'], true);
			$v['videos'] = $this->GetVideoById($v['id_product']);
		}
		return $res;
	}

	public function GetBatchesFhoto($id_photographer = false, $limit = false){
		$where = $id_photographer?' WHERE pb.id_author = '.$id_photographer:null;
		$sql = "SELECT pb.*, s.article, u.name, COUNT(pbp.id_product) AS count_product,
				(SELECT COUNT(*) FROM "._DB_PREFIX_."image i WHERE i.visible = 1 AND i.id_product IN
				(SELECT pbp2.id_product FROM "._DB_PREFIX_."photo_batch_products pbp2
				WHERE pbp2.id_photo_batch = pb.id)) AS image_visible,
				(SELECT COUNT(*) FROM "._DB_PREFIX_."image i WHERE i.visible = 0 AND i.id_product IN
				(SELECT pbp3.id_product FROM "._DB_PREFIX_."photo_batch_products pbp3
				WHERE pbp3.id_photo_batch = pb.id)) AS image_unvisible
				FROM "._DB_PREFIX_."photo_batch pb
				LEFT JOIN "._DB_PREFIX_."photo_batch_products pbp ON pbp.id_photo_batch = pb.id
				LEFT JOIN "._DB_PREFIX_."supplier s ON s.id_user = pb.id_supplier
				LEFT JOIN "._DB_PREFIX_."product p ON p.id_product = pbp.id_product
				LEFT JOIN "._DB_PREFIX_."user u ON u.id_user = s.id_user"
				.$where." GROUP BY pbp.id_photo_batch ORDER BY pb.id DESC"
				.($limit?' LIMIT'.$limit:'');
		if(!$res = $this->db->GetArray($sql)){
			return false;
		}
//		if($limit){
//			foreach ($res as $k => &$v) {
//				$v['products'] = $this->GetProductsByIdUser($v['id_author'], $v['date'], $v['id_supplier']);
//			}
//		}
		return $res;
	}

	public function UploadEstimate($file, $comment){
		$f['id_user'] = $_SESSION['member']['id_user'];
		$f['comment'] = trim($comment);
		$f['file'] = trim($file);
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'estimate', $f)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	//Вывод подкатегорий сверху, над списком товаров
	public function GetSubCatsTop($ID){
		if(isset($GLOBALS['Segment'])){
			$level_cat = "SELECT category_level FROM "._DB_PREFIX_."category WHERE id_category = ".$ID;
			$res = $this->db->GetOneRowArray($level_cat);
			if($res['category_level'] == 1){
				$sql = "SELECT * FROM "._DB_PREFIX_."category WHERE visible = 1 AND sid = 1 AND
						id_category IN (SELECT pid
						FROM "._DB_PREFIX_."category AS c4 WHERE id_category IN (SELECT cp.id_category
						FROM "._DB_PREFIX_."segment_prods AS sp
						LEFT JOIN "._DB_PREFIX_."cat_prod AS cp ON cp.id_product = sp.id_product
						LEFT JOIN "._DB_PREFIX_."category AS c ON c.id_category = cp.id_category
						WHERE id_segment = ".$GLOBALS['Segment']."
						GROUP BY c.id_category))
						AND pid = ".$ID;
			}elseif($res['category_level'] == 2){
				$sql = "SELECT * FROM "._DB_PREFIX_."category WHERE visible = 1 AND sid = 1 AND
						id_category IN (SELECT cp.id_category FROM "._DB_PREFIX_."segment_prods AS sp
						LEFT JOIN "._DB_PREFIX_."cat_prod AS cp ON cp.id_product = sp.id_product
						LEFT JOIN "._DB_PREFIX_."category AS c ON c.id_category = cp.id_category
						WHERE id_segment = ".$GLOBALS['Segment']." AND pid = ".$ID."
						GROUP BY c.id_category)";
			}elseif($res['category_level'] == 3){
				return false;
			}
		}else{
			$sql = "SELECT * FROM "._DB_PREFIX_."category WHERE pid = ".$ID." AND visible = 1 AND sid = 1 ORDER BY position";
		}
		if(isset($sql)){
			$res = $this->db->GetArray($sql);
		}
		return $res;
	}
	public function GetUncategorisedProducts($where_art = false, $limit = false){
		$sql = "SELECT id_product, art, `name`, translit, visible, indexation FROM	"._DB_PREFIX_."product
			WHERE id_product NOT IN (SELECT	id_product FROM	"._DB_PREFIX_."cat_prod
			WHERE id_category IN (SELECT id_category FROM "._DB_PREFIX_."category WHERE sid = 1))"
			.($where_art !== false?$where_art:'')." ORDER BY visible DESC, indexation DESC ".($limit !== false?$limit:'');
		if(!$res = $this->db->GetArray($sql)){
			return false;
		}
		return $res;
	}
	public function GetDoublesProducts($limit = false, $group = false){
		$sql = "SELECT p.id_product, p.art, p.`name`, p.translit, p.visible
				FROM "._DB_PREFIX_."product p,(SELECT translit FROM "._DB_PREFIX_."product
				GROUP BY translit HAVING COUNT(translit)>1) t
				WHERE t.translit = p.translit".($group !== false? ' ORDER BY translit':'').($limit !== false?$limit:'');
		if(!$res = $this->db->GetArray($sql)){
			return false;
		}
		if($group !== false){
			$array_double = array();
			foreach ($res as &$v){
				$array_double[$v['translit']][] = $v;
			}
			return $array_double;
		}
		return $res;
	}

	public function GetNopriceProducts($limit = false){
		$sql = "SELECT id_product, `name`, translit, price_mopt, price_opt FROM "._DB_PREFIX_."product
				WHERE (price_mopt = 0 AND price_opt <> 0) OR (price_opt = 0 AND price_mopt <> 0) AND visible = 1
				ORDER BY price_opt
				".($limit !== false?$limit:'');
		if(!$res = $this->db->GetArray($sql)){
			return false;
		}
		return $res;
	}

	public function UpdateActivityProducttSupplier($id_supplier){
		$sql = "UPDATE "._DB_PREFIX_."assortiment SET product_limit = 0
				WHERE id_supplier = ".$id_supplier;
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	// Удаляем из ассортимента поставщика
	public function deleteSupplierAssort($id_assort){
		$sql = "DELETE FROM "._DB_PREFIX_."assortiment WHERE id_assortiment =".$id_assort;
		$this->db->StartTrans();
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		$this->db->CompleteTrans();
		return true;
	}

	// Обновляет ассортимент поставщика
	public function updateActiveAssort($id_assort, $active){
		$product_limit = $active==1?10000000:0;
		$sql = "UPDATE "._DB_PREFIX_."assortiment SET product_limit = ".$product_limit."
				WHERE id_assortiment = ".$id_assort;
		$this->db->StartTrans();
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		$this->db->CompleteTrans();
		return true;
	}

	// Вывод новинок категории
	public function getNewProducts($category, $id_product){
		$sql = "SELECT DISTINCT a.active, ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."product AS p
			LEFT JOIN "._DB_PREFIX_."units AS un
				ON un.id = p.id_unit
			LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
				ON cp.id_product = p.id_product
			LEFT JOIN "._DB_PREFIX_."assortiment AS a
				ON a.id_product = p.id_product
			WHERE p.id_product<>".$id_product." AND p.prod_status = 3
			AND (p.price_opt>0 OR p.price_mopt>0) AND a.active = 1
			AND p.visible = 1 AND cp.id_category = ".$category;
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		foreach($arr as &$v){
			$v['images'] = $this->GetPhotoById($v['id_product']);
			$v['videos'] = $this->GetVideoById($v['id_product']);
			$coef_price_opt =  explode(';', $GLOBALS['CONFIG']['correction_set_'.$v['opt_correction_set']]);
			$coef_price_mopt =  explode(';', $GLOBALS['CONFIG']['correction_set_'.$v['mopt_correction_set']]);
			for($i=0; $i<=3; $i++){
				$v['prices_opt'][$i] = round($v['price_opt']* $coef_price_opt[$i], 2);
				$v['prices_mopt'][$i] = round($v['price_mopt']* $coef_price_mopt[$i], 2);
			}
		}
		return $arr;
	}

	// Вывод 50 товаров для ссылок
	public function getLinkProducts($id_product){
		$count = 0;
		$step = $id_product;
		$l_prods = '';
		while($count < 100){
			$step = $id_product<5000?$step+5:$step-5;
			$l_prods .= $step.($count!=99?', ':null);
			$count++;
		}
		$sql = 'SELECT p.name, p.translit FROM '._DB_PREFIX_.'product AS p
			WHERE p.visible = 1
			AND (CASE WHEN (SELECT COUNT(*) FROM '._DB_PREFIX_.'assortiment AS a LEFT JOIN '._DB_PREFIX_.'user AS u ON u.id_user = a.id_supplier WHERE a.id_product = p.id_product AND a.active = 1 AND u.active = 1) > 0 THEN 1 ELSE 0 END) = 1
			AND p.id_product IN('.$l_prods.') LIMIT 50';
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		return $arr;
	}

	// Выбор товаров для добавления категории
	public function getArrayProductsById($id_products, $sort = false){
		$sql = "SELECT id_product, `name`, art, translit, descr_xt_full, img_1
				FROM "._DB_PREFIX_."product	WHERE id_product IN (".implode(', ', $id_products).")".
				($sort!==false?$sort:'');
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		foreach ($arr as &$v){
			$v['images'] = $this->GetPhotoById($v['id_product'], true);
			$v['videos'] = $this->GetVideoById($v['id_product']);
		}
		return $arr;
	}

	// Добавление/обновление категории у товара
	public function FillCategoryByIdProduct($id_category, $id_products, $main){
		if($main == 1){
			$sql = "DELETE FROM " . _DB_PREFIX_ . "cat_prod
				WHERE id_product IN (" . implode(', ', $id_products) . ")";
			$this->db->StartTrans();
			if(!$this->db->Query($sql)){
				$this->db->FailTrans();
				return false;
			}
			$this->db->CompleteTrans();
		}
		foreach($id_products as $v){
			$sql = "INSERT INTO "._DB_PREFIX_."cat_prod
			(id_category, id_product, main) VALUES
			(".$id_category.", ".$v.", ".$main.")";
			$sql2 = "UPDATE "._DB_PREFIX_."product
			SET edit_user = ".$_SESSION['member']['id_user']." , edit_date = '".date('Y-m-d H:m:i')."'  WHERE id_product = ".$v;
			$this->db->StartTrans();
			if(!$this->db->Query($sql) || !$this->db->Query($sql2)){
				$this->db->FailTrans();
				return false;
			}
			$this->db->CompleteTrans();
		}
		return true;
	}

	public function GetProductsWithoutImages($limit = 10){
		$sql = "SELECT id_product, art FROM "._DB_PREFIX_."product
			WHERE id_product NOT IN (SELECT i.id_product FROM "._DB_PREFIX_."image AS i)
			ORDER BY RAND()";
		if(!$result = $this->db->GetArray($sql)){
			return false;
		}
		return $result;
	}
}
