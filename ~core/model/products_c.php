<?php
class Products {
	public $db;
	public $fields;
	public $list;
	private $usual_fields;
	private $usual_fields_sup;
	private $usual_fields_cart;
	/** Конструктор
	 * @return
 	 */
 	public function __construct (){
		$this->db =& $GLOBALS['db'];
		$this->usual_fields = array("p.id_product", "p.art", "p.name", "p.translit", "p.descr", "p.descr_xt_short",
			"p.descr_xt_full", "p.country", "p.img_1", "p.img_2", "p.img_3", "p.sertificate", "p.price_opt", "p.duplicate",
			"p.price_mopt", "p.inbox_qty", "p.min_mopt_qty", "p.max_supplier_qty", "p.weight","p.height","p.width","p.length",
			"p.volume", "p.qty_control", "p.price_coefficient_opt", "p.price_coefficient_mopt",
			"p.visible", "p.ord", "p.note_control", "un.unit_xt AS units", "p.prod_status", "p.old_price_mopt",
			"p.old_price_opt", "p.mopt_correction_set", "p.opt_correction_set", "p.filial", "cp.id_category",
			"p.popularity", "p.duplicate_user", "p.duplicate_comment", "p.duplicate_date", "p.edit_user",
			"p.edit_date", "p.create_user", "p.create_date", "p.id_unit", "p.page_title", "p.page_description",
			"p.page_keywords", "p.count_views", "notation_price", "instruction", "p.indexation");
		$this->usual_fields_cart = array("p.id_product", "p.art", "p.name", "p.translit", "p.descr",
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
			"tp.moderation_status", "tp.comment", "tp.creation_date", "tp.images");
	}

	public function GetRelatedProducts($id, $category_id, $howfar=10000, $howmany=20, $min_interval = 50){
		$from_right = $id + $min_interval ;
		$to_right = $id + $howfar + $min_interval;
		$from_left = $id - $howfar - $min_interval;
		$to_left = $id - $min_interval;
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
		}else{
			return $result;
		}
	}

	// Удаление нулевых позиций поставщиков (с 0 лимитом, но активных)
	public function Re_null(){
		$this->db->StartTrans();
		$sql = "UPDATE "._DB_PREFIX_."assortiment
			SET active = 0
			WHERE product_limit = 0
			AND active = 1";
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		$this->db->CompleteTrans();
	}

	// Товар по id
	public function SetFieldsById($id_product, $all=0){
		$visible = "AND p.visible = 1";
		if($all == 1){
			$visible = '';
		}

		$id_product = mysql_real_escape_string($id_product);
		$sql = "SELECT ".implode(", ",$this->usual_fields).",
			un.unit_prom, a.product_limit,
			(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1) AS c_count,
			(SELECT AVG(c.rating) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_rating,
			(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_mark,
			(SELECT name FROM "._DB_PREFIX_."user WHERE id_user = p.edit_user) AS username,
			(SELECT name FROM "._DB_PREFIX_."user WHERE id_user = p.create_user) AS createusername
			FROM "._DB_PREFIX_."product AS p
			LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
				ON cp.id_product = p.id_product
			LEFT JOIN "._DB_PREFIX_."units AS un
				ON un.id = p.id_unit
			LEFT JOIN "._DB_PREFIX_."assortiment AS a
				ON a.id_product = p.id_product
			WHERE p.id_product = ".$id_product."
			".$visible."
			ORDER BY cp.id";
		$arr = $this->db->GetArray($sql);
		// print_r($arr);
		if(!$arr){
			return false;
		}
		$catarr = array();
		foreach ($arr as $p){
			$catarr[] = $p['id_category'];
		}
		$arr[0]['categories_ids'] = $catarr;
		$this->fields = $arr[0];
		return true;
	}

	//Артикул по Id
	public function GetArtByID($id){
		$sql = "SELECT art
			FROM "._DB_PREFIX_."product
			WHERE id_product = ".$id;
		$arr = $this->db->GetOneRowArray($sql);
		if(!$arr){
			return false;
		}else{
			return $arr;
		}
	}
	// // Товар по id
	// public function SetFieldsById($id_product, $all=0){
	// 	$visible = "AND p.visible = 1";
	// 	if($all == 1){
	// 		$visible = '';
	// 	}

	// 	$id_product = mysql_real_escape_string($id_product);
	// 	$sql = "SELECT ".implode(", ",$this->usual_fields).",
	// 		u.name AS username,ucr.name AS createname, un.unit_prom, a.product_limit,
	// 		(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1) AS c_count,
	// 		(SELECT AVG(c.rating) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_rating,
	// 		(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_mark
	// 		FROM "._DB_PREFIX_."product AS p
	// 		LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
	// 			ON cp.id_product = p.id_product
	// 		LEFT JOIN "._DB_PREFIX_."user AS u
	// 			ON u.id_user = p.edit_user
	// 		LEFT JOIN "._DB_PREFIX_."user AS ucr
	// 			ON u.id_user = p.create_user
	// 		LEFT JOIN "._DB_PREFIX_."units AS un
	// 			ON un.id = p.id_unit
	// 		LEFT JOIN "._DB_PREFIX_."assortiment AS a
	// 			ON a.id_product = p.id_product
	// 		WHERE p.id_product = ".$id_product."
	// 		".$visible."
	// 		ORDER BY cp.id";
	// 	$arr = $this->db->GetArray($sql);
	// 	if(!$arr){
	// 		return false;
	// 	}
	// 	$catarr = array();
	// 	foreach ($arr as $p){
	// 		$catarr[] = $p['id_category'];
	// 	}
	// 	$arr[0]['categories_ids'] = $catarr;
	// 	$this->fields = $arr[0];
	// 	return true;
	// }

	/**
	 * Получить комментарии к товару по его id
	 * @param int $id_product		идентификатор товара
	 */
	public function GetComentByProductId($id_product){
		$sql = "SELECT cm.text_coment,
			(CASE
				WHEN cm.author = 4028 THEN cm.author_name
				WHEN cm.author = 007 THEN (SELECT name_c FROM "._DB_PREFIX_."contragent WHERE id_user = cm.author_name)
				ELSE (SELECT name FROM "._DB_PREFIX_."user WHERE id_user = cm.author)
			END) AS name,
			cm.date_comment, cm.visible, cm.rating
			FROM "._DB_PREFIX_."coment AS cm
			WHERE cm.url_coment = ".$id_product."
			AND cm.visible = 1
			ORDER BY cm.date_comment ASC";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		return $arr;
	}

	/**
	 * Записать комментарий к товару
	 * @param string $text			текст комментария
	 * @param ? $author				автор комментария
	 * @param ? $author_name		имя автора
	 * @param string $authors_email e-mail автора
	 * @param ? $put           		?
	 * @param int $rating 			оценка товара
	 */
	public function GetComentProducts($text, $author, $author_name, $authors_email, $put, $rating=null){
		if(empty($text)){
			return false; //Если имя пустое
		}
		$f['text_coment'] = mysql_real_escape_string(trim($text));
		$f['url_coment'] = mysql_real_escape_string(trim($put));
		$f['author'] = mysql_real_escape_string(trim($author));
		$f['author_name'] = mysql_real_escape_string(trim($author_name));
		$f['rating'] = mysql_real_escape_string(trim($rating));
		$f['user_email'] = mysql_real_escape_string(trim($authors_email));
		unset($text);
		unset($rating);
		unset($put);
		unset($authors_email);
		unset($author);
		unset($author_name);
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'coment', $f)){
			$this->db->FailTrans();
			return false; //Если не удалось записать в базу
		}
		unset($f);
		$this->db->CompleteTrans();
		return true;//Если все ок
	}

	/**
	 * Получить видео по id товара
	 * @param int $id_product		идентификатор товара
	 */
	public function GetIdByVideo($id_product){
		$sql = "SELECT url
			FROM "._DB_PREFIX_."video
			WHERE id_product = ".$id_product."
			ORDER BY id_video";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		 foreach ($arr as $value) {
			$res[] = $value['url'];
		}
		return $res;
	}

	// Добавление и удаление видео
	public function UpdateVideo($id_product, $arr){
		$sql = "DELETE FROM "._DB_PREFIX_."video WHERE id_product=".$id_product;
		$this->db->StartTrans();
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		$this->db->CompleteTrans();
		$f['id_product'] = mysql_real_escape_string(trim($id_product));
		foreach ($arr as &$value) {
			if(empty($value)){
				return false; //Если URL пустой
			}
			$f['url'] = mysql_real_escape_string(trim($value));
			$this->db->StartTrans();
			if(!$this->db->Insert(_DB_PREFIX_.'video', $f)){
				$this->db->FailTrans();
				return false; //Если не удалось записать в базу
			}
			$this->db->CompleteTrans();
		}
		unset($id_product);
		unset($f);
		return true;//Если все ок
	}

	/**
	 * Получить id категории по ее артикулу
	 * @param int $art		артикул категории
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
	 * @param int $art		артикул товара
	 */
	public function GetIdByArt($art){
		$sql = "SELECT p.id_product
			FROM "._DB_PREFIX_."product AS p
			WHERE p.art = ".$art;
		$arr = $this->db->GetOneRowArray($sql);
		if(!$arr){
			return false;
		}
		return $arr['id_product'];
	}

	/**
	 * Получение массива id_products по артикулу и по его началу
	 * @param int $art идентификатор товара
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
		$sql = "SELECT DISTINCT a.active,
			".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."product AS p
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
		if($gid == _ACL_SUPPLIER_ || $gid == _ACL_ADMIN_ || $gid == _ACL_MODERATOR_ || $gid == _ACL_SEO_optimizator_){
			$sql = "SELECT DISTINCT a.active, s.available_today,
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
				WHERE p.visible = 1
				AND a.product_limit > 0
				".$where."
				".$group_by."
				ORDER BY ".$order_by."
				".$limit;
		}else{
			$sql = "SELECT DISTINCT a.active, s.available_today,
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
				WHERE p.visible = 1
				AND a.product_limit > 0
				".$where."
				".$prices_zero."
				".$group_by."
				ORDER BY ".$order_by."
				".$limit;
		}
		$res = $this->db->GetArray($sql);
		if(!$res){
			return false;
		}
		return $res;
	}

	public function SetProductsList4csv(){
		$date = date("Y-m-d", (time()+3600*24*2));
		$sql = "SELECT p.name, p.price_mopt,
			p.id_product, p.translit
			FROM "._DB_PREFIX_."product AS p
			LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
				ON p.id_product = cp.id_product
			LEFT JOIN "._DB_PREFIX_."assortiment AS a
				ON p.id_product = a.id_product
			LEFT JOIN "._DB_PREFIX_."calendar_supplier AS cs
				ON a.id_supplier = cs.id_supplier
			WHERE a.active = 1
			AND cs.date = '".$date."'
			AND cs.work_day = 1
			AND cp.id_category IN (".$GLOBALS['CONFIG']['price_csv_categories'].")
			GROUP BY p.id_product";
		$res = $this->db->GetArray($sql);
		if(!$res){
			return false;
		}
		return $res;
	}

	public function SetProductsList4csvProm(){
		$sql = "SELECT p.art, p.name, p.descr, p.img_1,
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
			WHERE p.price_mopt > 0
			AND p.visible = 1";
		$res = $this->db->GetArray($sql);
		if(!$res){
			return false;
		}
		return $res;
	}

	public function SetProductsList4csvTatet(){
		$value = "SELECT value
			FROM "._DB_PREFIX_."config
			WHERE name = 'tatet_catlist'";
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

	public function SetProductsList4SuppliersCSV($id_order, $id_supplier){
		$id_supplier = mysql_real_escape_string(trim($id_supplier));
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
			AND osp.id_order IN (".mysql_real_escape_string(trim(implode(", ", $id_order))).")
			GROUP BY p.id_product, osp.id_order";
		$res = $this->db->GetArray($sql);
		if(!$res){
			return false;
		}
		return $res;
	}

	public function SetProductsList($and = false, $limit = '', $gid = 0, $params = array()){
		$where = "";
		if($and !== FALSE && count($and)){
			$where = " AND ";
			foreach ($and as $k=>$v){
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
		if($limit == '' || isset($params['ajax'])){
			$qqq = 1;
		}
		$group_by = '';
		if(isset($params['group_by'])){
			$group_by = ' GROUP BY '.$params['group_by'];
		}
		$prices_zero = '';
		if(!isset($params['sup_cab'])){
			$prices_zero = ' AND (p.price_opt > 0 OR p.price_mopt > 0) ';
		}
		if(isset($params['order_by'])){
			if($params['order_by'] != null){
				$order_by = $params['order_by'];
				if(strpos($params['order_by'], 'popularity') === false){
					$ob = 1;
				}
			}
		}else{
			$order_by = ' popularity DESC';
		}
		// var_dump($order_by);
		if(isset($params['administration'])){
			// SQL выборки для админки
			$sql = "(SELECT '0' AS sort, a.active,
				".implode(", ",$this->usual_fields)."
				FROM "._DB_PREFIX_."product AS p
				LEFT JOIN "._DB_PREFIX_."assortiment AS a
					ON p.id_product = a.id_product
				LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
					ON cp.id_product = p.id_product
				LEFT JOIN "._DB_PREFIX_."units AS un
					ON un.id = p.id_unit
				WHERE (p.price_opt > 0 OR p.price_mopt > 0)
				AND a.active = 1
				AND p.visible = 1
				".$where."
				".$group_by.")
				UNION
				(SELECT '1' AS sort, a.active,
				".implode(", ",$this->usual_fields)."
				FROM "._DB_PREFIX_."product AS p
				LEFT JOIN "._DB_PREFIX_."assortiment AS a
					ON p.id_product = a.id_product
				LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
					ON cp.id_product = p.id_product
				LEFT JOIN "._DB_PREFIX_."units AS un
					ON un.id = p.id_unit
				WHERE ((p.price_opt <= 0 OR p.price_mopt <= 0)
				OR p.visible = 0)
				".$where."
				".$group_by.")
				ORDER BY ".$order_by."
				".$limit;
		}else{
			if($gid == _ACL_SUPPLIER_ || $gid == _ACL_ADMIN_ || $gid == _ACL_MODERATOR_ || $gid == _ACL_SEO_optimizator_){
				$sql = "SELECT ".implode(", ",$this->usual_fields).",
					a.price_opt_otpusk, a.price_mopt_otpusk,
					(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1) AS c_count,
					(SELECT AVG(c.rating) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_rating,
					(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_mark
					FROM "._DB_PREFIX_."product AS p
					LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
						ON cp.id_product = p.id_product
					LEFT JOIN "._DB_PREFIX_."assortiment AS a
						ON a.id_product = p.id_product
					LEFT JOIN "._DB_PREFIX_."units AS un
						ON un.id = p.id_unit
					WHERE p.id_product IS NOT NULL
					".$where."
					".$group_by."
					ORDER BY ".$order_by."
					".$limit;
			}else{
				if(isset($params['rel_search'])){
					// $sups_ids = implode(",",$this->GetSuppliersIdsForCurrentDateDiapason());
					$sql = "SELECT a.price_opt_otpusk, a.price_mopt_otpusk,
						".implode(", ",$this->usual_fields).$params['rel_search'].",
						s.available_today,
						(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1) AS c_count,
						(SELECT AVG(c.rating) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_rating,
						(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_mark
						FROM "._DB_PREFIX_."product AS p
						LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
							ON cp.id_product = p.id_product
						LEFT JOIN "._DB_PREFIX_."units AS un
							ON un.id = p.id_unit
						LEFT JOIN "._DB_PREFIX_."assortiment AS a
							ON a.id_product = p.id_product
						LEFT JOIN "._DB_PREFIX_."supplier AS s
							ON s.id_user = a.id_supplier
						WHERE p.visible = 1
						".$prices_zero."
						".$where."
						AND a.active = 1
						".$group_by."
						ORDER BY rel DESC
						".$limit;
				}else{
					// $sups_ids = implode(", ",$this->GetSuppliersIdsForCurrentDateDiapason());
					$sql = '';
					if(!isset($ob)){
						$sql .= "(SELECT a.active, a.price_opt_otpusk, a.price_mopt_otpusk,
						".implode(", ",$this->usual_fields).", s.available_today,
						(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1) AS c_count,
						(SELECT AVG(c.rating) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_rating,
						(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_mark
						FROM "._DB_PREFIX_."product AS p
						LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
							ON cp.id_product = p.id_product
						LEFT JOIN "._DB_PREFIX_."units AS un
							ON un.id = p.id_unit
						LEFT JOIN "._DB_PREFIX_."assortiment AS a
							ON a.id_product = p.id_product
						LEFT JOIN "._DB_PREFIX_."supplier AS s
							ON s.id_user = a.id_supplier
						WHERE p.visible = 1
						AND p.prod_status = 3
						".$prices_zero."
						".$where."
						AND a.active = 1
						".$group_by."
						ORDER BY active DESC, ".$order_by.") UNION (
						SELECT *
							FROM (";
						$where .= " AND p.prod_status <> 3";
					}
					if(isset($qqq)){
						$sql .= '(';
					}
					$sql .= "SELECT a.active, a.price_opt_otpusk, a.price_mopt_otpusk,
						".implode(", ",$this->usual_fields).", s.available_today,
						(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1) AS c_count,
						(SELECT AVG(c.rating) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_rating,
						(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_mark
						FROM "._DB_PREFIX_."product AS p
						LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
							ON cp.id_product = p.id_product
						LEFT JOIN "._DB_PREFIX_."units AS un
							ON un.id = p.id_unit
						LEFT JOIN "._DB_PREFIX_."assortiment AS a
							ON a.id_product = p.id_product
						LEFT JOIN "._DB_PREFIX_."supplier AS s
							ON s.id_user = a.id_supplier
						WHERE p.visible = 1
						".$prices_zero."
						".$where."
						AND a.active = 1
						".$group_by;
					if(isset($qqq)){
						$sql .= ") UNION
							(SELECT a.active, a.price_opt_otpusk, a.price_mopt_otpusk,
							".implode(", ",$this->usual_fields).", s.available_today,
							(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1) AS c_count,
							(SELECT AVG(c.rating) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_rating,
							(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_mark
							FROM "._DB_PREFIX_."product AS p
							LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
								ON cp.id_product = p.id_product
							LEFT JOIN "._DB_PREFIX_."units AS un
								ON un.id = p.id_unit
							LEFT JOIN "._DB_PREFIX_."assortiment AS a
								ON a.id_product = p.id_product
							LEFT JOIN "._DB_PREFIX_."supplier AS s
								ON s.id_user = a.id_supplier
							WHERE p.visible = 1
							AND p.price_opt <= 0
							AND p.price_mopt <= 0
							AND a.active = 0
							".$where."
							".$group_by.") ";
					}
					$sql .= " ORDER BY active DESC, $order_by";
					if(!isset($ob)){
						$sql .= ") AS combined)";
					}
					$sql .= " $limit";
				}
			}
		}
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}

	public function SetProductsList1($s){
		// SQL выборки для админки
		$sql = "SELECT DISTINCT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."product AS p
			LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
				ON cp.id_product = p.id_product
			LEFT JOIN "._DB_PREFIX_."assortiment AS a
				ON a.id_product = p.id_product
			LEFT JOIN "._DB_PREFIX_."units AS un
				ON un.id = p.id_unit
			WHERE a.id_supplier = ".$s."
			GROUP BY p.id_product";
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}else{
			return true;
		}
	}

	public function SetProductsListFilter($and = false, $limit='', $gid=0, $params = array ()){
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
		$sql = "SELECT DISTINCT a.active, ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."product AS p
			LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
				ON cp.id_product = p.id_product
			LEFT JOIN "._DB_PREFIX_."assortiment AS a
				ON a.id_product = p.id_product
			LEFT JOIN "._DB_PREFIX_."units AS un
				ON un.id = p.id_unit
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
		}else{
			return true;
		}
	}

	//функция для отображения результатов поиска без дублей ( нет категорий)
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
		if($gid == _ACL_SUPPLIER_ || $gid == _ACL_ADMIN_ || $gid == _ACL_MODERATOR_ || $gid == _ACL_SEO_optimizator_){
			$sql = "SELECT DISTINCT a.active, a.price_opt_otpusk, a.price_mopt_otpusk, s.available_today,
				".implode(", ",$this->usual_fields).",
				(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1) AS c_count,
			(SELECT AVG(c.rating) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_rating,
			(SELECT COUNT(c.Id_coment) FROM "._DB_PREFIX_."coment AS c WHERE c.url_coment = p.id_product AND c.visible = 1 AND c.rating IS NOT NULL AND c.rating > 0) AS c_mark
				FROM "._DB_PREFIX_."product AS p
				LEFT JOIN "._DB_PREFIX_."assortiment AS a
					ON a.id_product = p.id_product
				LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
					ON cp.id_product = a.id_product
				LEFT JOIN "._DB_PREFIX_."supplier AS s
						ON s.id_user = a.id_supplier
				LEFT JOIN "._DB_PREFIX_."units AS un
					ON un.id = p.id_unit
				WHERE ".$where."
				".$group_by."
				ORDER BY ".$order_by."
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
				$sql = "SELECT DISTINCT a.active, ".implode(", ",$this->usual_fields).",
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
		if(!$res){
			return false;
		}else{
			return $res;
		}
	}

	public function GetProductsCnt($and = false, $gid = 0, $params = array()){
		$where = "";
		if($and !== FALSE && count($and)){
			$where = " AND ";
			foreach ($and as $k=>$v){
				if($k=='customs'){
					foreach($v as $a){
						$where_a[] = $a;
					}
				}else{
					$where_a[] = "$k = \"$v\"";
				}
			}
			$where .= implode(" AND ", $where_a);
		}
		$group_by = '';
		if(isset($params['group_by'])){
			$group_by = ' GROUP BY '.$params['group_by'];
		}
		$prices_zero = '';
		if(!isset($params['sup_cab'])){
			$prices_zero = ' AND (p.price_opt > 0 OR p.price_mopt > 0) ';
		}
		$sql = "SELECT COUNT(DISTINCT p.id_product) AS cnt
			FROM "._DB_PREFIX_."product AS p
			LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
				ON p.id_product = cp.id_product
			LEFT JOIN "._DB_PREFIX_."assortiment AS a
				ON a.id_product = p.id_product
			LEFT JOIN "._DB_PREFIX_."supplier AS s
				ON s.id_user = a.id_supplier
			WHERE ";
		// $sups_ids = implode(",",$this->GetSuppliersIdsForCurrentDateDiapason());
		if(in_array($gid, array(_ACL_SUPPLIER_, _ACL_ADMIN_, _ACL_MODERATOR_, _ACL_SEO_optimizator_))){
			$sql .= "p.id_product IS NOT NULL
				".$where;
		}else{
			$sql .= "p.visible = 1
				".$where."
				AND (p.price_opt > 0 OR p.price_mopt > 0)
				AND a.active = 1";
		}
		$cnt = $this->db->GetOneRowArray($sql);
		if(!$cnt['cnt']){
			return 0;
		}
		return $cnt['cnt'];
	}

	public function SetProductsListBySupplier($id_supplier){
		$group_by = ' GROUP BY a.id_product';
		$sql = "SELECT DISTINCT a.id_assortiment,
			a.id_product, a.price_opt_otpusk,
			a.price_mopt_otpusk, a.active,
			a.product_limit, a.sup_comment
			FROM "._DB_PREFIX_."assortiment a
			WHERE a.id_supplier = ".$id_supplier."
			".$group_by;
		$res = $this->db->GetArray($sql);
		if(!$res){
			return false;
		}else{
			return $res;
		}
	}

	public function SetProductsListSupCab($and = false, $limit = '', $orderby = 'a.inusd, p.name'){
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
			a.inusd,
			(SELECT MIN(assort.price_mopt_otpusk)
				FROM '._DB_PREFIX_.'assortiment AS assort
				LEFT JOIN '._DB_PREFIX_.'calendar_supplier AS cs
					ON (cs.id_supplier = assort.id_supplier AND cs.date = (CURDATE() + INTERVAL 2 DAY))
				WHERE cs.work_day = 1
				AND assort.active = 1
				AND assort.id_product = p.id_product
				AND price_mopt_otpusk > 0
				GROUP BY assort.id_product) AS min_mopt_price,
			(SELECT MIN(assort.price_opt_otpusk)
				FROM '._DB_PREFIX_.'assortiment AS assort
				LEFT JOIN '._DB_PREFIX_.'calendar_supplier AS cs
					ON (cs.id_supplier = assort.id_supplier AND cs.date = (CURDATE() + INTERVAL 2 DAY))
				WHERE cs.work_day = 1
				AND assort.active = 1
				AND assort.id_product = p.id_product
				AND price_opt_otpusk > 0
				GROUP BY assort.id_product) AS min_opt_price
			FROM '._DB_PREFIX_.'product AS p
			LEFT JOIN '._DB_PREFIX_.'cat_prod AS cp
				ON cp.id_product = p.id_product
			LEFT JOIN '._DB_PREFIX_.'units AS un
				ON un.id = p.id_unit
			LEFT JOIN '._DB_PREFIX_.'assortiment AS a
				ON a.id_product = p.id_product
			WHERE '.$where.'
			'.$group_by.'
			ORDER BY '.$orderby.'
			'.$limit;
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}else{
			return true;
		}
	}

	public function GetProductsCntSupCab($and = false, $params = ''){
		$where = " ";
		if($and !== FALSE && count($and)){
			foreach($and as $k=>$v){
				$where_a[] = "$k=\"$v\"";
			}
			$where .= implode(" AND ", $where_a);
		}
		$sql = "SELECT COUNT(DISTINCT p.id_product) as cnt
			FROM "._DB_PREFIX_."product AS p
			LEFT JOIN "._DB_PREFIX_."assortiment AS a
				ON p.id_product = a.id_product
			WHERE ".$where.
			$params;
		$arr = $this->db->GetOneRowArray($sql);
		if(!$arr){
			return 0;
		}else{
			return $arr['cnt'];
		}
	}

	public function SetProductsListFromArr($arr, $limit='', $params = array()){
		$in = implode(", ", $arr);
		if(is_numeric($limit)){
			$limit = "limit $limit";
		}
		$order_by = 'p.ord, p.name';
		if(isset($params['order_by'])){
			$order_by = $params['order_by'];
		}
		$sql = "SELECT ".implode(", ",$this->usual_fields_cart)."
			FROM "._DB_PREFIX_."product AS p
			LEFT JOIN "._DB_PREFIX_."units AS un
				ON un.id = p.id_unit
			WHERE p.id_product IN (".$in.")
			AND p.visible = 1
			ORDER BY ".$order_by."
			".$limit;
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}

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
		}else{
			return true;
		}
	}

	public function SetExclusivList($id_supplier){
		$sql = "SELECT p.id_product
			FROM "._DB_PREFIX_."product p
			WHERE p.exclusive_supplier = $id_supplier";
		$this->list = $this->db->GetArray($sql, 'id_product');
		if(!$this->list){
			return false;
		}else{
			return true;
		}
	}

	public function SetExclusiveSupplier($id_product, $id_supplier, $active){
		$this->db->StartTrans();
		$f['exclusive_supplier'] = $id_supplier;
		if(!$active){
			$f['exclusive_supplier'] = 0;
		}
		if(!$this->db->Update(_DB_PREFIX_."product", $f, "id_product = {$id_product}")){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
	}

	// Обновление позиции ассортимента (ajax)
	public function UpdateAssort($id_product, $opt, $price_otpusk, $price_recommend, $nacen, $product_limit = null, $active = 0, $sup_comment, $inusd = 'false', $currency_rate){
		if(!isset($_SESSION['Assort']['products'][$id_product])){
			$this->InitProduct($id_product);
		}
		if($opt == 1){
			$_SESSION['Assort']['products'][$id_product]['price_opt_otpusk'] = $price_otpusk;
			$_SESSION['Assort']['products'][$id_product]['price_opt_recommend'] = $price_otpusk*$nacen;
			$_SESSION['Assort']['products'][$id_product]['price_opt_otpusk_usd'] = $price_otpusk/$currency_rate;
			$_SESSION['Assort']['products'][$id_product]['sup_comment'] = $sup_comment;
		}else{
			$_SESSION['Assort']['products'][$id_product]['price_mopt_otpusk'] = $price_otpusk;
			$_SESSION['Assort']['products'][$id_product]['price_mopt_recommend'] = $price_otpusk*$nacen;
			$_SESSION['Assort']['products'][$id_product]['price_mopt_otpusk_usd'] = $price_otpusk/$currency_rate;
			$_SESSION['Assort']['products'][$id_product]['sup_comment'] = $sup_comment;
		}
		if($product_limit == null){
			$_SESSION['Assort']['products'][$id_product]['product_limit'] = 0;
		}else{
			$_SESSION['Assort']['products'][$id_product]['product_limit'] = $product_limit;
		}
		$_SESSION['Assort']['products'][$id_product]['active'] = $active;
		if($_SESSION['Assort']['products'][$id_product]['price_opt_otpusk'] == 0 &&
			$_SESSION['Assort']['products'][$id_product]['price_mopt_otpusk'] == 0 &&
			$_SESSION['Assort']['products'][$id_product]['active'] == 0){
			unset($_SESSION['Assort']['products'][$id_product]);
		}
		$this->db->StartTrans();
		// $this->db->DeleteRowsFrom(_DB_PREFIX_."assortiment", array ("id_product = $id_product", "id_supplier = ".$_SESSION['member']['id_user']));
		$f['id_product'] = mysql_real_escape_string(trim($id_product));
		$f['id_supplier'] = mysql_real_escape_string(trim($_SESSION['member']['id_user']));
		$f['price_opt_recommend'] = mysql_real_escape_string(trim($_SESSION['Assort']['products'][$id_product]['price_opt_recommend']));
		$f['price_mopt_recommend'] = mysql_real_escape_string(trim($_SESSION['Assort']['products'][$id_product]['price_mopt_recommend']));
		$f['price_opt_otpusk'] = mysql_real_escape_string(trim($_SESSION['Assort']['products'][$id_product]['price_opt_otpusk']));
		$f['price_mopt_otpusk'] = mysql_real_escape_string(trim($_SESSION['Assort']['products'][$id_product]['price_mopt_otpusk']));
		$f['price_opt_otpusk_usd'] = mysql_real_escape_string(trim($_SESSION['Assort']['products'][$id_product]['price_opt_otpusk_usd']));
		$f['price_mopt_otpusk_usd'] = mysql_real_escape_string(trim($_SESSION['Assort']['products'][$id_product]['price_mopt_otpusk_usd']));
		$f['product_limit'] = mysql_real_escape_string(trim($_SESSION['Assort']['products'][$id_product]['product_limit']));
		$f['active'] = mysql_real_escape_string(trim($_SESSION['Assort']['products'][$id_product]['active']));
		$f['sup_comment'] = mysql_real_escape_string(trim($_SESSION['Assort']['products'][$id_product]['sup_comment']));

		if(!$this->db->Update(_DB_PREFIX_."assortiment", $f, "id_product = $id_product AND id_supplier = ".$_SESSION['member']['id_user'])){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		//$f[''] = mysql_real_escape_string(trim($arr['']));
		// if(!$this->db->Insert(_DB_PREFIX_.'assortiment', $f)){
		// 	$this->db->FailTrans();
		// 	return false;
		// }
		$this->RecalcSitePrices(array($id_product));
	}

	public function InitProduct($id_product){
		$_SESSION['Assort']['products'][$id_product]['price_opt_otpusk'] = 0;
		$_SESSION['Assort']['products'][$id_product]['price_opt_otpusk_usd'] = 0;
		$_SESSION['Assort']['products'][$id_product]['price_opt_recommend'] = 0;
		$_SESSION['Assort']['products'][$id_product]['price_mopt_otpusk'] = 0;
		$_SESSION['Assort']['products'][$id_product]['price_mopt_otpusk_usd'] = 0;
		$_SESSION['Assort']['products'][$id_product]['price_mopt_recommend'] = 0;
		$_SESSION['Assort']['products'][$id_product]['product_limit'] = 0;
		$_SESSION['Assort']['products'][$id_product]['active'] = 0;
		$_SESSION['Assort']['products'][$id_product]['sup_comment'] = 0;
	}

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
	}

	public function AddToAssort($id_product){
		$this->InitProduct($id_product);
		$suppliers = new suppliers();
		$this->db->StartTrans();
		$f['id_product'] = mysql_real_escape_string(trim($id_product));
		$f['id_supplier'] = mysql_real_escape_string(trim($_SESSION['member']['id_user']));
		$f['price_opt_recommend'] = 0;
		$f['price_mopt_recommend'] = 0;
		$f['price_opt_otpusk'] = 0;
		$f['price_mopt_otpusk'] = 0;
		$f['price_opt_otpusk_usd'] = 0;
		$f['price_mopt_otpusk_usd'] = 0;
		$f['product_limit'] = 0;
		$f['active'] = 0;
		if(!$this->db->Insert(_DB_PREFIX_.'assortiment', $f)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
	}

	public function SwitchActiveEDInAssort($id_product, $active){
		$_SESSION['Assort']['products'][$id_product]['active'] = $active;
		$f['active'] = $active;
		$this->db->StartTrans();
		$this->db->Update(_DB_PREFIX_."assortiment", $f, "id_product = {$id_product}");
		$this->RecalcSitePrices(array($id_product));
		$this->db->CompleteTrans();
	}

	public function DelFromAssort($id_product){
		unset($_SESSION['Assort']['products'][$id_product]);
		$this->db->StartTrans();
		$this->db->DeleteRowsFrom(_DB_PREFIX_."assortiment", array("id_product = $id_product", "id_supplier = ".$_SESSION['member']['id_user']));
		$this->RecalcSitePrices(array($id_product));
		$this->db->CompleteTrans();
	}
	/*
	 * Пересчет цен на сайте
 	 */
 	public function RecalcSitePrices($ids_products = null){
 		set_time_limit(3600);
 		ini_set('memory_limit', '400M');
		//$time_start = microtime(true);
 		$sql = "SELECT a.id_product, a.id_supplier, a.active,
 			a.price_opt_recommend, a.price_mopt_recommend,
 			a.price_opt_otpusk, a.price_mopt_otpusk, s.filial,
 			p.price_mopt AS old_price_mopt, p.price_opt AS old_price_opt
			FROM "._DB_PREFIX_."assortiment AS a
			LEFT JOIN "._DB_PREFIX_."calendar_supplier AS cs
				ON (cs.id_supplier = a.id_supplier OR cs.id_supplier = a.id_supplier)
			LEFT JOIN "._DB_PREFIX_."supplier AS s
				ON cs.id_supplier = s.id_user
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON p.id_product = a.id_product
			WHERE a.active = 1
			AND a.id_supplier != 0
			AND ((a.price_opt_otpusk != 0 AND a.price_opt_recommend != 0)
			OR (a.price_mopt_otpusk != 0 AND a.price_mopt_recommend != 0))";
		if(is_array($ids_products)){
			$sql .= " AND a.id_product IN (".implode(", ", $ids_products).")
				AND cs.date = DATE_ADD(CURRENT_DATE, INTERVAL 2 DAY)
				AND cs.work_day = 1
				GROUP BY a.id_supplier, a.id_product";
			$arr = $this->db->GetArray($sql);
			foreach($arr as $p){
				$mass[$p['id_product']][] = $p;
			}
		}else{ // пересчет всех товаров ассортимента
			$sql .= " AND cs.date = DATE_ADD(CURRENT_DATE, INTERVAL 2 DAY)
				AND cs.work_day = 1
				GROUP BY a.id_supplier, a.id_product";
			$arr = $this->db->GetArray($sql);
			$ids_products = array();
			foreach($arr as $p){
				$ids_products[] = $p['id_product'];
				$mass[$p['id_product']][] = $p;
			}
			$ids_products = array_unique($ids_products);
		}
		$return = array();
		foreach($ids_products as $k=>$id_product){
			$prices['opt_counter'] = 0;
			$prices['mopt_counter'] = 0;
			$opt_sr = $mopt_sr = 0;
			if(isset($mass[$id_product]) == true){
				$return[$id_product]['filial'] = 1;
				foreach($mass[$id_product] as $p){
					if($p['price_opt_recommend'] > 0){
						$prices[$id_product]['opt'][] = $p['price_opt_recommend'];
						$prices['opt_counter']++;
					}
					if($p['price_mopt_recommend'] > 0){
						$prices[$id_product]['mopt'][] = $p['price_mopt_recommend'];
						$prices['mopt_counter']++;
					}
					if($p['filial'] > 1){
						$return[$id_product]['filial'] = $p['filial'];
					}
				}
				if($prices['opt_counter'] > 0){
					$opt_sr = min($prices[$id_product]['opt']);
				}
				if($prices['mopt_counter'] > 0){
					$mopt_sr = min($prices[$id_product]['mopt']);
				}
				if($opt_sr != $mass[$id_product][0]['old_price_opt'] || $mopt_sr != $mass[$id_product][0]['old_price_mopt']){
					$return[$id_product]['opt_sr'] = $opt_sr;
					$return[$id_product]['mopt_sr'] = $mopt_sr;
				}else{
					unset($return[$id_product]);
				}
				unset($prices[$id_product]);
				unset($mass[$id_product]);
			}else{
				$sql = "SELECT p.id_product, p.price_mopt AS old_price_mopt,
					p.price_opt AS old_price_opt
					FROM "._DB_PREFIX_."product AS p
					WHERE p.id_product = ".$id_product;
				$arr = $this->db->GetOneRowArray($sql);
				$m = $arr;
				if($m['old_price_opt'] != 0 || $m['old_price_mopt'] != 0){
					$return[$id_product]['filial'] = 1;
					$return[$id_product]['opt_sr'] = 0;
					$return[$id_product]['mopt_sr'] = 0;
				}
			}
			unset($ids_products[$k]);
		}
		if(!$this->UpdateSitePricesMassive($return)){
			return false;
		}
		ini_set('memory_limit', '192M');
		//$time_end = microtime(true);
		//$time = $time_end - $time_start;
		//echo "execution time <b>$time</b> seconds\n";
		return true;
	}

	public function UpdateSitePricesMassive($arr){
		if(!empty($arr)){
			foreach($arr AS $k=>$a){
				$f['price_opt'] = "ROUND(".$a['opt_sr']."*price_coefficient_opt, 2)";
				$f['price_mopt'] = "ROUND(".$a['mopt_sr']."*price_coefficient_mopt, 2)";
				$f['filial'] = $a['filial'];
				$this->db->StartTrans();
				if(!$this->db->UpdatePro(_DB_PREFIX_."product", $f, "id_product = {$k}")){
					$this->db->FailTrans();
					return false;
				}
				$this->db->CompleteTrans();
			}
		}
		return true;
	}

	public function UpdateSitePrices($id_product, $opt_sr, $mopt_sr){
		$f['price_opt'] = "ROUND(".$opt_sr."*price_coefficient_opt, 2)";
		$f['price_mopt'] = "ROUND(".$mopt_sr."*price_coefficient_mopt, 2)";
		if(!$this->db->UpdatePro(_DB_PREFIX_."product", $f, "id_product = {$id_product}")){
			$this->db->FailTrans();
			return false;
		}
		return true;
	}

	// Добавление
	public function AddProduct($arr){
		$f['art'] = mysql_real_escape_string(trim($arr['art']));
		$f['name'] = mysql_real_escape_string(trim($arr['name']));
		$f['translit'] = G::StrToTrans($arr['name']);
		$f['descr'] = mysql_real_escape_string(trim($arr['descr']));
		$f['descr_xt_short'] = mysql_real_escape_string(trim($arr['descr_xt_short']));
		$f['descr_xt_full'] = mysql_real_escape_string(trim($arr['descr_xt_full']));
		//$f['country'] = mysql_real_escape_string(trim($arr['country']));
		$f['img_1'] = mysql_real_escape_string(trim($arr['img_1']));
		$f['img_2'] = mysql_real_escape_string(trim($arr['img_2']));
		$f['img_3'] = mysql_real_escape_string(trim($arr['img_3']));
		// if(isset($arr['images']) && $arr['images'] != ''){
		// 	if(isset($arr['smb_duplicate'])){
		// 			$f['img_1'] = mysql_real_escape_string(trim(isset($arr['images']['0'])?$arr['images']['0']:null));
		// 			$f['img_2'] = mysql_real_escape_string(trim(isset($arr['images']['1'])?$arr['images']['1']:null));
		// 			$f['img_3'] = mysql_real_escape_string(trim(isset($arr['images']['2'])?$arr['images']['2']:null));
		// 	}else{
		// 		foreach($arr['images'] as $k=>$image){
		// 			$newname = $arr['art'].($k == 0?'':'-'.$k).'.jpg';
		// 			$file = pathinfo(str_replace('/'.str_replace($GLOBALS['PATH_root'], '', $GLOBALS['PATH_product_img']), '', $image));
		// 			$bd_path = str_replace($GLOBALS['PATH_root'].'..', '', $GLOBALS['PATH_product_img']).$file['dirname'];
		// 			$images_arr[] = $bd_path.'/'.$newname;
		// 		}
		// 		$f['img_1'] = mysql_real_escape_string(trim(isset($images_arr['0'])?$images_arr['0']:null));
		// 		$f['img_2'] = mysql_real_escape_string(trim(isset($images_arr['1'])?$images_arr['1']:null));
		// 		$f['img_3'] = mysql_real_escape_string(trim(isset($images_arr['2'])?$images_arr['2']:null));
		// 	}
		// }
		// $f['sertificate'] = mysql_real_escape_string(trim($arr['sertificate']));
		$f['price_opt'] = mysql_real_escape_string(trim($arr['price_opt']));
		$f['price_mopt'] = mysql_real_escape_string(trim($arr['price_mopt']));
		$f['inbox_qty'] = mysql_real_escape_string(trim($arr['inbox_qty']));
		$f['max_supplier_qty'] = mysql_real_escape_string(trim($arr['max_supplier_qty']));
		$f['min_mopt_qty'] = mysql_real_escape_string(trim($arr['min_mopt_qty']));
		// $f['manufacturer_id'] = mysql_real_escape_string(trim($arr['manufacturer_id']));
		$f['price_coefficient_opt'] = mysql_real_escape_string(trim($arr['price_coefficient_opt']));
		$f['price_coefficient_mopt'] = mysql_real_escape_string(trim($arr['price_coefficient_mopt']));
		$f['height'] = mysql_real_escape_string(trim($arr['height']));
		$f['width'] = mysql_real_escape_string(trim($arr['width']));
		$f['length'] = mysql_real_escape_string(trim($arr['length']));
		if($arr['height'] != 0 && $arr['width'] != 0 && $arr['length'] != 0){
			$f['weight'] = ($arr['height'] * $arr['width'] * $arr['length']) * 0.000001; //обьем в м3
		}else{
			$f['weight'] = mysql_real_escape_string(trim($arr['weight']));
		}
		$f['volume'] = mysql_real_escape_string(trim($arr['volume']));
		$f['qty_control'] = (isset($arr['qty_control']) && $arr['qty_control'] == "on")?1:0;
		$f['visible'] = (isset($arr['visible']) && $arr['visible'] == "on")?0:1;
		$f['note_control'] = (isset($arr['note_control']) && ($arr['note_control'] == "on" || $arr['note_control'] == "1"))?1:0;
		$f['id_unit'] = mysql_real_escape_string(trim($arr['id_unit']));
		$f['create_user'] = mysql_real_escape_string(trim($_SESSION['member']['id_user']));
		$f['notation_price'] = mysql_real_escape_string(trim($arr['notation_price']));
		$f['instruction'] = mysql_real_escape_string(trim($arr['instruction']));
		$f['indexation'] = (isset($arr['indexation']) && $arr['indexation'] == "on")?1:0;
		// Добавляем товар в бд
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'product', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id_product = $this->db->GetInsId();
		if(!$this->UpdateProductCategories($id_product, $arr['categories_ids'])){
			$this->db->FailTrans();
			return false;
		}
		// Пересчитывать нечего при добавлении товара, так как нужен хотябы один поставщик на этот товар,
		// а быть его на данном этапе не может
		//$this->RecalcSitePrices(array($id_product));
		$this->db->CompleteTrans();
		return $id_product;
	}

	//Запись просмотренных товаров
	public function AddViewProduct($id_product, $id_user){
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'visited_products', array('id_product' => $id_product, 'id_user' => $id_user))){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	//Обновление счетчика просмотренных товаров
	public function UpdateViewsProducts($count_views, $id_product){
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."product", array('count_views' => $count_views = $count_views + 1), "id_product = {$id_product}")){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	// Заполнение соответствий категории-товар
	public function UpdateProductCategories($id_product, $categories_arr){

		// уникализируем массив на случай выбора одинаковых категорий в админке
		$categories_arr = array_unique($categories_arr);
		// вырезаем нулевую категорию, т.к. товар не может лежать в корне магазина и не принадлежать категории
		foreach($categories_arr as $k=>$v){
			if($v == 0) unset($categories_arr[$k]);
		}
		// Записываем данные в таблицу соответствий категория-товар
		$sql = "DELETE FROM "._DB_PREFIX_."cat_prod WHERE id_product=$id_product";
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		$ii=0;
		foreach($categories_arr as $id){
			$f[$ii]['id_product'] = $id_product;
			$f[$ii++]['id_category'] = $id;
		}
		if(!$this->db->InsertArr(_DB_PREFIX_.'cat_prod', $f)){
			return false;
		}
		return true;
	}

	// Обновление
	public function UpdateProduct($arr){
		$f['edit_user'] = mysql_real_escape_string(trim($_SESSION['member']['id_user']));
		$f['edit_date'] = date('Y-m-d H:i:s');
		$id_product = mysql_real_escape_string(trim($arr['id_product']));
		if(isset($arr['name']) && $arr['name'] !== ''){
			$f['art'] = mysql_real_escape_string(trim($arr['art']));
			$f['name'] = mysql_real_escape_string(trim($arr['name']));
			//$f['translit'] = G::StrToTrans($arr['name']);
			$f['descr'] = mysql_real_escape_string(trim($arr['descr']));
			$f['descr_xt_short'] = mysql_real_escape_string(trim($arr['descr_xt_short']));
			$f['descr_xt_full'] = mysql_real_escape_string(trim($arr['descr_xt_full']));
			//$f['country'] = mysql_real_escape_string(trim($arr['country']));
			$f['img_1'] = mysql_real_escape_string(trim($arr['img_1']));
			$f['img_2'] = mysql_real_escape_string(trim($arr['img_2']));
			$f['img_3'] = mysql_real_escape_string(trim($arr['img_3']));
			// if(isset($arr['images']) && $arr['images'] != ''){
			// 	$f['img_1'] = mysql_real_escape_string(trim(isset($arr['images'][0])?$arr['images'][0]:null));
			// 	$f['img_2'] = mysql_real_escape_string(trim(isset($arr['images'][1])?$arr['images'][1]:null));
			// 	$f['img_3'] = mysql_real_escape_string(trim(isset($arr['images'][2])?$arr['images'][2]:null));
			// }elseif(!isset($arr['images']) && isset($arr['removed_images'])){
			// 	$f['img_1'] = null;
			// 	$f['img_2'] = null;
			// 	$f['img_3'] = null;
			// }
			if(isset($arr['page_description'])){
				$f['page_description'] = mysql_real_escape_string(trim($arr['page_description']));
			}
			if(isset($arr['page_title'])){
				$f['page_title'] = mysql_real_escape_string(trim($arr['page_title']));
			}
			if(isset($arr['page_keywords'])){
				$f['page_keywords'] = mysql_real_escape_string(trim($arr['page_keywords']));
			}
			//$f['sertificate'] = mysql_real_escape_string(trim($arr['sertificate']));
			$f['price_opt'] = mysql_real_escape_string(trim($arr['price_opt']));
			$f['price_mopt'] = mysql_real_escape_string(trim($arr['price_mopt']));
			$f['inbox_qty'] = mysql_real_escape_string(trim($arr['inbox_qty']));
			$f['min_mopt_qty'] = mysql_real_escape_string(trim($arr['min_mopt_qty']));
			$f['max_supplier_qty'] = mysql_real_escape_string(trim($arr['max_supplier_qty']));
			//$f['manufacturer_id'] = mysql_real_escape_string(trim($arr['manufacturer_id']));
			$f['price_coefficient_opt'] = mysql_real_escape_string(trim($arr['price_coefficient_opt']));
			$f['price_coefficient_mopt'] = mysql_real_escape_string(trim($arr['price_coefficient_mopt']));
			$f['height'] = mysql_real_escape_string(trim($arr['height']));
			$f['width'] = mysql_real_escape_string(trim($arr['width']));
			$f['length'] = mysql_real_escape_string(trim($arr['length']));
			if($arr['height'] != 0 && $arr['width'] != 0 && $arr['length'] != 0){
				$f['weight'] = ($arr['height'] * $arr['width'] * $arr['length']) * 0.000001; //обьем в м3
			}else{
				$f['weight'] = mysql_real_escape_string(trim($arr['weight']));
			}
			$f['volume'] = mysql_real_escape_string(trim($arr['volume']));
			$f['opt_correction_set'] = isset($arr['opt_correction_set'])?mysql_real_escape_string(trim($arr['opt_correction_set'])):0;
			$f['mopt_correction_set'] = isset($arr['mopt_correction_set'])?mysql_real_escape_string(trim($arr['mopt_correction_set'])):0;
			$f['qty_control'] = (isset($arr['qty_control']) && $arr['qty_control'] == "on")?1:0;
			$f['visible'] = (isset($arr['visible']) && $arr['visible'] == "on")?0:1;
			$f['note_control'] = (isset($arr['note_control']) && ($arr['note_control'] === "on" || $arr['note_control'] == "1"))?1:0;
			$f['id_unit'] = mysql_real_escape_string(trim($arr['id_unit']));
			$f['notation_price'] = mysql_real_escape_string(trim($arr['notation_price']));
			$f['instruction'] = mysql_real_escape_string(trim($arr['instruction']));
			$f['indexation'] = (isset($arr['indexation']) && $arr['indexation'] == "on")?1:0;
		}
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."product", $f, "id_product = {$id_product}")){
			$this->db->FailTrans();
			return false;
		}
		if(isset($arr['name'])){
			if(!$this->UpdateProductCategories($id_product, $arr['categories_ids'])){
				$this->db->FailTrans();
				return false;
			}
			$this->RecalcSitePrices(array($id_product));
			$this->db->CompleteTrans();
		}
		return true;
	}

	public function UpdateTranslit($id_product){
		$f['edit_user'] = mysql_real_escape_string(trim($_SESSION['member']['id_user']));
		$f['edit_date'] = date('Y-m-d H:i:s');
		$this->db->StartTrans();
		$this->SetFieldsById($id_product);
		$f['translit'] = G::StrToTrans($this->fields['name']);
		if(!$this->db->Update(_DB_PREFIX_."product", $f, "id_product = {$id_product}")){
			$this->db->FailTrans();
			return false;
		}
		return $f['translit'];
	}

	// Удаление
	public function DelProduct($id_product){
		$this->db->StartTrans();
		$this->db->DeleteRowFrom(_DB_PREFIX_."product", "id_product", $id_product);
		$this->db->DeleteRowFrom(_DB_PREFIX_."cat_prod", "id_product", $id_product);
		//$this->RecalcSitePrices(array($id_product));
		$this->db->CompleteTrans();
		return true;
	}

	// Сортировка
	public function Reorder($arr){
		$this->db->StartTrans();
		foreach($arr['ord'] as $id_product=>$ord){
			$sql = "UPDATE "._DB_PREFIX_."product SET `ord` = $ord
				WHERE id_product = $id_product";
			$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		}
		$this->db->CompleteTrans();
	}

	// Генерация массива строк для экспорта в прайс-лист//
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

	// Генерация и выдача для скачивания файла excel (Экспорт)
	public function GenExcelFileFullPrice($header, $rows){
		require($GLOBALS['PATH_sys'].'excel/Classes/PHPExcel.php');
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

	// Генерация и выдача для скачивания файла excel (Экспорт)
	public function GenExcelFile($header, $rows, $cats_cols){
		require($GLOBALS['PATH_sys'].'excel/Classes/PHPExcel.php');
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

	// Генерация массива строк для экспорта
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

	public function GetCatsOfProduct($id_product){
		$sql = "SELECT cp.id_category, c.art
			FROM "._DB_PREFIX_."cat_prod AS cp
			LEFT JOIN "._DB_PREFIX_."category AS c
				ON c.id_category = cp.id_category
			WHERE cp.id_product = ".$id_product;
		$arr = $this->db->GetArray($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return $arr;
	}

	// Проверка загруженного файла

	public function CheckProductsFile($filename){
		require($GLOBALS['PATH_sys'].'excel/Classes/PHPExcel/IOFactory.php');
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

	// Обработка загруженного файла
	public function ProcessProductsFile($filename){
		require($GLOBALS['PATH_sys'].'excel/Classes/PHPExcel/IOFactory.php');
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

	// Генерация массива строк для экспорта ассортимента
	public function GetExportAssortRows($list, $id_supplier){
		$r = array();
		$ii = 0;
		$jj = 0;
		foreach($list as $i){
			$sql = "SELECT a.id_product, a.price_opt_otpusk,
				a.price_mopt_otpusk, a.product_limit, a.sup_comment
				FROM "._DB_PREFIX_."assortiment AS a
				WHERE a.id_supplier = ".$id_supplier."
				AND a.inusd = 0";
			$arr = $this->db->GetArray($sql, 'id_product');
			$jj = 0;
			if(isset($arr[$i['id_product']])){
				$r[$ii]['art_sup'] = $id_supplier;
				$r[$ii]['art'] = $i['art'];
				$r[$ii]['name'] = $i['name'];
				$r[$ii]['price_opt_otpusk'] = round($arr[$i['id_product']]['price_opt_otpusk'], 2);
				$r[$ii]['price_mopt_otpusk'] = round($arr[$i['id_product']]['price_mopt_otpusk'], 2);
				$r[$ii]['product_limit'] = $arr[$i['id_product']]['product_limit'];
				$r[$ii]['sup_comment'] = $arr[$i['id_product']]['sup_comment'];
			}
			$ii++;
		}
		return $r;
	}

	public function GetExportAssortRowsUSD($list, $id_supplier){
		$r = array();
		$ii = 0;
		$jj = 0;
		foreach($list as $i){
			$sql = "SELECT a.id_product, a.price_opt_otpusk_usd AS price_opt_otpusk,
				a.price_mopt_otpusk_usd AS price_mopt_otpusk, a.product_limit, a.sup_comment
				FROM "._DB_PREFIX_."assortiment AS a
				WHERE a.id_supplier = ".$id_supplier."
				AND a.inusd = 1";
			$arr = $this->db->GetArray($sql, 'id_product');
			$jj = 0;
			if(isset($arr[$i['id_product']])){
				$r[$ii]['art_sup'] = $id_supplier;
				$r[$ii]['art'] = $i['art'];
				$r[$ii]['name'] = $i['name'];
				$r[$ii]['price_opt_otpusk'] = round($arr[$i['id_product']]['price_opt_otpusk'], 3);
				$r[$ii]['price_mopt_otpusk'] = round($arr[$i['id_product']]['price_mopt_otpusk'], 3);
				$r[$ii]['product_limit'] = $arr[$i['id_product']]['product_limit'];
				$r[$ii]['sup_comment'] = $arr[$i['id_product']]['sup_comment'];
			}
			$ii++;
		}
		return $r;
	}

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

	// Генерация и выдача для скачивания файла excel Ассортимент (Экспорт)
	public function GenExcelAssortFile($rows){
		require($GLOBALS['PATH_sys'].'excel/Classes/PHPExcel.php');
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
		foreach($rows as $r){
			$charcnt = 0;
			foreach($ca as $i){
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr((++$charcnt)+64).$ii, $r[$i['n']]);
			}
			$ii++;
		}
  		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="assortiment.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}

	// Обработка загруженного файла ассортимента
	public function ProcessAssortimentFile($filename){
		require($GLOBALS['PATH_sys'].'excel/Classes/PHPExcel/IOFactory.php');
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
		$ca = $this->GetExcelAssortColumnsArray();
		// проход по первой строке
		$ii=0;
		foreach($ca as $i){
			if($i['h'] != $array[0][$ii++]){
				$_SESSION['errm'][] = "Неверный формат файла";
				return array(0,0);
			}
		}
		$total_updated = 0;
		$total_added = 0;
		// проход по массиву строк
		for($ii=1; isset($array[$ii]); $ii++){
			$cnt = 0;
			$f = array();
			foreach($ca as $i){
				$f[$i['n']] = $array[$ii][$cnt++];
			}
			if($id_product = $this->GetIdByArt($f['art'])){
				global $Supplier;
				$id_supplier = $Supplier->fields['id_user'];
				$koef_nazen_opt = $Supplier->fields['koef_nazen_opt'];
				$koef_nazen_mopt = $Supplier->fields['koef_nazen_mopt'];
				$f['active'] = 0;
				if($f['product_limit'] > 0 && (($f['price_opt_otpusk'] != 0) || ($f['price_mopt_otpusk'] != 0))){
					$f['active'] = 1;
				}
				$f['price_mopt_otpusk_usd'] = $f['price_mopt_otpusk']/$Supplier->fields['currency_rate'];
				$f['price_opt_otpusk_usd'] = $f['price_opt_otpusk']/$Supplier->fields['currency_rate'];
				if($this->IsInAssort($id_product, $id_supplier)){
					$f['id_product'] = $id_product;
					$this->UpdateSupplierAssortiment($f, $koef_nazen_opt, $koef_nazen_mopt, false);
					$total_updated++;
				}else{
					$this->AddProductToAssort($id_product, $id_supplier, $f, $koef_nazen_opt, $koef_nazen_mopt, false);
					$total_added++;
				}
			}
		}
		return array($total_added,$total_updated);
	}

	// Обработка загруженного файла ассортимента
	public function ProcessAssortimentFileUSD($filename){
		require($GLOBALS['PATH_sys'].'excel/Classes/PHPExcel/IOFactory.php');
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
		$ca = $this->GetExcelAssortColumnsArray();
		// проход по первой строке
		$ii=0;
		foreach($ca as $i){
			if($i['h'] != $array[0][$ii++]){
				$_SESSION['errm'][] = "Неверный формат файла";
				return array(0,0);
			}
		}
		$total_updated = 0;
		$total_added = 0;
		// проход по массиву строк
		for($ii=1; isset($array[$ii]); $ii++){
			$cnt = 0;
			$f = array();
			foreach($ca as $i){
				$f[$i['n']] = $array[$ii][$cnt++];
			}
			if($id_product = $this->GetIdByArt($f['art'])){
				global $Supplier;
				$id_supplier = $Supplier->fields['id_user'];
				$koef_nazen_opt = $Supplier->fields['koef_nazen_opt'];
				$koef_nazen_mopt = $Supplier->fields['koef_nazen_mopt'];
				$f['active'] = 0;
				if($f['product_limit'] > 0 && (($f['price_opt_otpusk'] != 0) || ($f['price_mopt_otpusk'] != 0))){
					$f['active'] = 1;
				}
				$f['price_mopt_otpusk_usd'] = $f['price_mopt_otpusk'];
				$f['price_mopt_otpusk'] = $f['price_mopt_otpusk']*$Supplier->fields['currency_rate'];
				$f['price_opt_otpusk_usd'] = $f['price_opt_otpusk'];
				$f['price_opt_otpusk'] = $f['price_opt_otpusk']*$Supplier->fields['currency_rate'];
				if($this->IsInAssort($id_product, $id_supplier)){
					$f['id_product'] = $id_product;
					$this->UpdateSupplierAssortiment($f, $koef_nazen_opt, $koef_nazen_mopt, true);
					$total_updated++;
				}else{
					$this->AddProductToAssort($id_product, $id_supplier, $f, $koef_nazen_opt, $koef_nazen_mopt, true);
					$total_added++;
				}
			}
		}
		return array($total_added,$total_updated);
	}

	public function IsInAssort($id_product, $id_supplier){
		$sql = "SELECT id_product
			FROM "._DB_PREFIX_."assortiment
			WHERE id_product = ".$id_product."
			AND id_supplier = ".$id_supplier;
		$arr = $this->db->GetArray($sql);
		if(count($arr)){
			return true;
		}else{
			return false;
		}
	}

	public function AddProductToAssort($id_product, $id_supplier, $arr, $koef_nazen_opt, $koef_nazen_mopt, $inusd = false){
		$this->db->StartTrans();
		$f['id_product'] = $id_product;
		$f['id_supplier'] = $id_supplier;
		$f['price_opt_otpusk'] = mysql_real_escape_string(trim($arr['price_opt_otpusk']));
		$f['price_mopt_otpusk'] = mysql_real_escape_string(trim($arr['price_mopt_otpusk']));
		$f['price_opt_otpusk_usd'] = mysql_real_escape_string(trim($arr['price_opt_otpusk_usd']));
		$f['price_mopt_otpusk_usd'] = mysql_real_escape_string(trim($arr['price_mopt_otpusk_usd']));
		$f['price_opt_recommend'] = $f['price_opt_otpusk']*$koef_nazen_opt;
		$f['price_mopt_recommend'] = $f['price_mopt_otpusk']*$koef_nazen_mopt;
		$f['product_limit'] = mysql_real_escape_string(trim($arr['product_limit']));
		$f['active'] = mysql_real_escape_string(trim($arr['active']));
		if(!isset($arr['sup_comment'])){
			$arr['sup_comment'] = null;
		}
		$f['inusd'] = 0;
		if($inusd === true){
			$f['inusd'] = 1;
		}
		$f['sup_comment'] = mysql_real_escape_string(trim($arr['sup_comment']));
		if(!$this->db->Insert(_DB_PREFIX_.'assortiment', $f)){
			$this->db->FailTrans();
			return false;
		}
		$this->RecalcSitePrices(array($id_product));
		$this->db->CompleteTrans();
	}

	// Обновление
	public function UpdateSupplierAssortiment($arr, $koef_nazen_opt, $koef_nazen_mopt, $inusd = false){
		$id_product = mysql_real_escape_string(trim($arr['id_product']));
		$f['price_opt_otpusk'] = mysql_real_escape_string(trim($arr['price_opt_otpusk']));
		$f['price_mopt_otpusk'] = mysql_real_escape_string(trim($arr['price_mopt_otpusk']));
		$f['price_opt_otpusk_usd'] = mysql_real_escape_string(trim($arr['price_opt_otpusk_usd']));
		$f['price_mopt_otpusk_usd'] = mysql_real_escape_string(trim($arr['price_mopt_otpusk_usd']));
		$f['price_opt_recommend'] = $f['price_opt_otpusk']*$koef_nazen_opt;
		$f['price_mopt_recommend'] = $f['price_mopt_otpusk']*$koef_nazen_mopt;
		$f['product_limit'] = mysql_real_escape_string(trim($arr['product_limit']));
		$f['active'] = mysql_real_escape_string(trim($arr['active']));
		if(!isset($arr['sup_comment'])){
			$arr['sup_comment'] = null;
		}
		$f['inusd'] = 0;
		if($inusd === true){
			$f['inusd'] = 1;
		}
		$f['sup_comment'] = mysql_real_escape_string(trim($arr['sup_comment']));
		$this->db->StartTrans();
		global $Supplier;
		$id_supplier = $Supplier->fields['id_user'];
		if(!$this->db->Update(_DB_PREFIX_."assortiment", $f, "id_product = {$id_product} AND id_supplier = {$id_supplier}")){
			$this->db->FailTrans();
			return false;
		}
		$this->RecalcSitePrices(array($id_product));
		$this->db->CompleteTrans();
		return true;
	}

	public function UpdatePriceSupplierAssortiment($kurs_griwni){
		$sql = "UPDATE "._DB_PREFIX_."assortiment AS a
			LEFT JOIN "._DB_PREFIX_."supplier AS s
				ON a.id_supplier = s.id_user
			SET a.price_opt_otpusk = (a.price_opt_otpusk*(".$kurs_griwni."/s.currency_rate)),
				a.price_mopt_otpusk = (a.price_mopt_otpusk*(".$kurs_griwni."/s.currency_rate))";
		if(!$this->db->Execute($sql)){
			return false;
		}
		$sql = "UPDATE "._DB_PREFIX_."supplier AS s
			SET s.currency_rate = $kurs_griwni
			";
		if(!$this->db->Execute($sql)){
			return false;
		}
		return true;
	}

	public function UpdatePriceRecommendAssortiment(){
		$sql = "UPDATE "._DB_PREFIX_."assortiment AS a
			LEFT JOIN "._DB_PREFIX_."supplier AS s
				ON a.id_supplier = s.id_user
			SET a.price_opt_recommend = (a.price_opt_otpusk*s.koef_nazen_opt),
				a.price_mopt_recommend = (a.price_mopt_otpusk*s.koef_nazen_mopt)
			WHERE a.edited > '".date('Y.m.j', strtotime("-1 day".date('d.m.Y')))." 21:15:00'";
		if(!$this->db->Execute($sql)){
			return false;
		}
		$sql2 = "SELECT DISTINCT a.id_product
			FROM "._DB_PREFIX_."assortiment AS a
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON p.id_product = a.id_product
			WHERE p.visible = 1
			AND a.edited > '".date('Y.m.j', strtotime("-1 day".date('d.m.Y')))." 21:15:00'";
		$res = $this->db->GetArray($sql2);
		if(!empty($res)){
			foreach($res as &$i){
				$id_product[] = $i['id_product'];
			}
			$this->RecalcSitePrices($id_product);
		}
		return true;
	}

	public function UpdateOldPrice1(){
		$sql = "UPDATE "._DB_PREFIX_."product
			SET old_price_mopt = price_mopt,
				old_price_opt = price_opt
			WHERE MOD(id_product, 2) = 1";
		if(!$this->db->Execute($sql)){
			return false;
		}
	}
	public function UpdateOldPrice2(){
		$sql = "UPDATE "._DB_PREFIX_."product
			SET old_price_mopt = price_mopt,
				old_price_opt = price_opt
			WHERE MOD(id_product,2) = 0";
		if(!$this->db->Execute($sql)){
			return false;
		}
	}
	public function GetPopularsOfCategory($id_category, $forDisplay = false){
		if(!$forDisplay){
			$sql = "SELECT id_product
				FROM "._DB_PREFIX_."popular_products
				WHERE id_category = $id_category";
		}else{
			$sql = "SELECT p.id_product, pp.id_category,
				p.name as name,
				p.translit, p.img_1, p.price_mopt
				FROM "._DB_PREFIX_."popular_products AS pp
				LEFT JOIN "._DB_PREFIX_."product AS p
				ON p.id_product = pp.id_product
				WHERE p.price_mopt > 0
				LIMIT ".$GLOBALS['CONFIG']['populars_on_page'];
		}
		$arr = $this->db->GetArray($sql,"id_product");
		return $arr;
	}

	// Добавление популярного продукта
	public function SetPopular($id_product, $id_category){
		$this->db->StartTrans();
		$f['id_product'] = mysql_real_escape_string($id_product);
		$f['id_category'] = mysql_real_escape_string($id_category);
		if(!$this->db->Insert(_DB_PREFIX_.'popular_products', $f)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
	}

	// Удаление популярного продукта
	public function DelPopular($id_product, $id_category){
		$this->db->StartTrans();
		$this->db->DeleteRowsFrom(_DB_PREFIX_."popular_products", array ("id_product = $id_product", "id_category = ".$id_category));
		$this->db->CompleteTrans();
	}

	//Очистка списка популярных товаров
	public function ClearPopular(){
		$this->db->StartTrans();
		$sql = "DELETE FROM "._DB_PREFIX_."popular_products";
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		$this->db->CompleteTrans();
	}

	// Статистика продаж товаров в период
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

	// Объявление полей для экспорта "Заказы по поставщикам"
	public function GetExcelStatColumnsArray(){
		$ii=0;
		$ca[$ii++] = array('h'=>'Артикул', 						'n' => 'art',					'w'=>'14');
		$ca[$ii++] = array('h'=>'Название', 					'n' => 'name', 					'w'=>'30');
		$ca[$ii++] = array('h'=>'Кол-во заказов',				'n' => 'orders_cnt',			'w'=>'16');
		$ca[$ii++] = array('h'=>'Кол-во шт.', 					'n' => 'total_qty', 			'w'=>'16');
		$ca[$ii++] = array('h'=>'Сумма', 						'n' => 'total_sum', 			'w'=>'20');
		return $ca;
	}

	// Генерация и выдача для скачивания файла excel "Заказы по поставщикам"
	public function GenExcelStatFile($rows){
		require($GLOBALS['PATH_sys'].'excel/Classes/PHPExcel.php');
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

	// Получить айдишники работающих поставщиков в доступный для заказа диапазон дат
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

	// Получить поставщиков для товара
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

	// Получить поставщиков для товара
	public function GetSuppliersInfoForProduct($id_product){
		$sql = "SELECT a.id_supplier, s.article, s.phones, a.product_limit, u.name,
			ROUND(a.price_opt_otpusk,2) as price_opt_otpusk,
			ROUND(a.price_mopt_otpusk,2) as price_mopt_otpusk
			FROM "._DB_PREFIX_."assortiment AS a
			LEFT JOIN "._DB_PREFIX_."supplier AS s
				ON s.id_user = a.id_supplier
			LEFT JOIN "._DB_PREFIX_."user AS u
				ON u.id_user = a.id_supplier
			WHERE a.id_product = $id_product";
		$arr = $this->db->GetArray($sql);
		return $arr;
	}

	public function GetExportSupPricesRows($arr){
		$suppliers = array();
		$suppliers_qty = 0;
		$ii=0;
		foreach($arr as $i){
			$suppliers = $this->GetSuppliersForProduct($i['id_product']);
			if(count($suppliers)>$suppliers_qty){
				$suppliers_qty = count($suppliers);
			}
			$rE[$ii]['article'] = $i['art'];
			$rE[$ii]['name'] = $i['name'];
			$rE[$ii]['price_opt'] = $i['price_opt'];
			$rE[$ii]['price_mopt'] = $i['price_mopt'];
			$jj=1;
			foreach($suppliers as $s){
				$rE[$ii]['sup_article_'.$jj] = $s['article'];
				$rE[$ii]['sup_product_limit_'.$jj] = $s['product_limit'];
				$rE[$ii]['sup_price_opt_otpusk_'.$jj] = $s['price_opt_otpusk'];
				$rE[$ii]['sup_price_opt_recommend_'.$jj] = $s['price_opt_recommend'];
				$rE[$ii]['sup_price_mopt_otpusk_'.$jj] = $s['price_mopt_otpusk'];
				$rE[$ii]['sup_price_mopt_recommend_'.$jj] = $s['price_mopt_recommend'];
				$jj++;
			}
			$ii++;
		}
		return array($rE, $suppliers_qty);
	}

	// Объявление полей для экспорта товаров с поставщиками и ценами
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

	// Генерация и выдача для скачивания файла excel товаров с поставщиками и ценами
	public function GenExcelSupPricesFile($rows,$suppliers_qty){
		require($GLOBALS['PATH_sys'].'excel/Classes/PHPExcel.php');
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

	// Список производителей
	public function GetManufacturers(){
		$sql = "SELECT manufacturer_id, name
			FROM "._DB_PREFIX_."manufacturers
			order by ord, name";
		return $this->db->GetArray($sql);
	}

	public function GetCountNameIndex(){
		$qry = "SELECT id_product
			FROM "._DB_PREFIX_."product
			WHERE name_index IS NULL";
		$result = $this->db->GetArray($qry);
		if(!$result){
			return false;
		}else{
			return $result;
		}
	}

	public function GetName($i){
		$qry = "SELECT name
			FROM "._DB_PREFIX_."product
			WHERE id_product='$i'";
		$name = $this->db->GetArray($qry);
		if(!$name){
			return false;
		}else{
			return $name[0]['name'];
		}
	}

	public function Morphy($i, $name_index){
		$qry = "UPDATE "._DB_PREFIX_."product
			SET name_index='$name_index'
			WHERE id_product='$i'";
		$this->db->Query($qry);
	}

	public function PriceListProductCount(){
		$sql = "SELECT c.id_category, c.category_level, c.name,
			c.pid, c.visible, COUNT(p.id_product) AS products
			FROM "._DB_PREFIX_."category AS c
			LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
				ON c.id_category = cp.id_category
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON (p.id_product = cp.id_product AND (p.price_opt > 0 OR p.price_mopt > 0))
			WHERE c.visible = 1
			AND c.category_level > 0
			GROUP BY c.id_category
			ORDER BY c.category_level";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}else{
			return $arr;
		}
	}

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
		}else{
			return $count;
		}
	}

	public function AddPriceList($pricelist){
		$sql = "SELECT MAX(ord) AS ord
			FROM "._DB_PREFIX_."pricelists";
		$arr = $this->db->GetOneRowArray($sql);
		$f['order'] = mysql_real_escape_string($pricelist['order']);
		$f['name'] = mysql_real_escape_string($pricelist['name']);
		$f['set'] = mysql_real_escape_string($pricelist['set']);
		$f['visibility'] = mysql_real_escape_string($pricelist['visibility']);
		$f['ord'] = mysql_real_escape_string($arr['ord']+1);
		if(!$this->db->Insert(_DB_PREFIX_.'pricelists', $f)){
			$this->db->FailTrans();
			return false;
		}
		$sql = "SELECT MAX(ID) AS id
			FROM "._DB_PREFIX_."pricelists";
		$arr = $this->db->GetOneRowArray($sql);
		return $arr['id'];
	}

	public function SortPriceLists($pricelists){
		foreach($pricelists as $k=>$v){
			$sql = "UPDATE "._DB_PREFIX_."pricelists
				SET ord = ".$k."
				WHERE id = ".eregi_replace("([^0-9])", "", $v);
			$this->db->Query($sql);
		}
		return true;
	}

	public function UpdatePriceList($pricelist){
		$f['order'] = mysql_real_escape_string($pricelist['order']);
		$f['name'] = mysql_real_escape_string($pricelist['name']);
		$f['set'] = mysql_real_escape_string($pricelist['set']);
		$f['visibility'] = mysql_real_escape_string($pricelist['visibility']);
		if(!$this->db->Update(_DB_PREFIX_."pricelists", $f, "id = {$pricelist['id']}")){
			$this->db->FailTrans();
			return false;
		}
		return true;
	}

	public function UpdateSetByOrder($pricelist){
		$f['opt_correction_set'] = mysql_real_escape_string($pricelist['set']);
		$f['mopt_correction_set'] = mysql_real_escape_string($pricelist['set']);
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
		}else{
			return true;
		}
	}

	public function DeletePriceList($id){
		$sql = "DELETE
			FROM "._DB_PREFIX_."pricelists
			WHERE id = ".$id;
		if(!$this->db->Query($sql)){
			return false;
		}else{
			return $id;
		}
	}

	public function GetPricelistFullList(){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."pricelists
			ORDER BY ord";
		$arr = $this->db->GetArray($sql);
		if(!$arr === true){
			return false;
		}else{
			return $arr;
		}
	}

	public function GetPricelistById($id){
		$sql = "SELECT pl.id, pl.order, pl.name AS price_name, p.id_product,
			p.art, p.name, p.img_1, p.min_mopt_qty, p.inbox_qty, un.unit_xt AS units,
			p.price_mopt, p.price_opt, p.opt_correction_set, p.mopt_correction_set,
			c.id_category, c.id_category, c.name AS cat_name, c.category_level
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
			GROUP BY p.id_product";
		$arr = $this->db->GetArray($sql);
		if(!$arr === true){
			return false;
		}else{
			return $arr;
		}
	}

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
		}else{
			return $prods;
		}
	}

	public function ProductReport($diff){
		$sql = "SELECT p.id_product, p.art, p.name
			FROM "._DB_PREFIX_."product AS p
			LEFT JOIN "._DB_PREFIX_."assortiment AS a
				ON a.id_product = p.id_product
			WHERE (SELECT MAX(assort.price_mopt_otpusk)/MIN(assort.price_mopt_otpusk)
				FROM "._DB_PREFIX_."assortiment AS assort
				LEFT JOIN "._DB_PREFIX_."calendar_supplier AS cs
					ON (cs.id_supplier = assort.id_supplier AND cs.date = (CURDATE() + INTERVAL 2 DAY))
				WHERE cs.work_day = 1
				AND assort.active = 1
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
				LEFT JOIN "._DB_PREFIX_."calendar_supplier AS cs
					ON (cs.id_supplier = a.id_supplier AND cs.date = (CURDATE() + INTERVAL 2 DAY))
				WHERE cs.work_day = 1
				AND a.active = 1
				AND a.id_product = ".$a['id_product']."
				GROUP BY a.id_supplier";
			$arr[$k]['suppliers'] = $this->db->GetArray($sql);
		}
		if(!$arr === true){
			return false;
		}else{
			return $arr;
		}
	}

	public function AddSupplierProduct($data){
		$f['name'] = mysql_real_escape_string($data['name']);
		$f['descr'] = mysql_real_escape_string(nl2br($data['descr'], false));
		$f['images'] = mysql_real_escape_string($data['images']);
		$f['img_1'] = mysql_real_escape_string($data['img_1']);
		$f['img_2'] = mysql_real_escape_string($data['img_2']);
		$f['img_3'] = mysql_real_escape_string($data['img_3']);
		$f['id_unit'] = mysql_real_escape_string($data['id_unit']);
		$f['min_mopt_qty'] = mysql_real_escape_string($data['min_mopt_qty']);
		$f['inbox_qty'] = mysql_real_escape_string($data['inbox_qty']);
		$f['price_mopt'] = str_replace(',','.', mysql_real_escape_string($data['price_mopt']));
		$f['price_opt'] = str_replace(',','.', mysql_real_escape_string($data['price_opt']));
		$f['qty_control'] = 0;
		if(isset($data['qty_control']) && $data['qty_control'] == 1){
			$f['qty_control'] = mysql_real_escape_string($data['qty_control']);
		}
		$f['weight'] = str_replace(',','.', mysql_real_escape_string($data['weight']));
		$f['volume'] = str_replace(',','.', mysql_real_escape_string($data['volume']));
		$f['product_limit'] = mysql_real_escape_string($data['product_limit']);
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
		$sql .= " ORDER BY tp.moderation_status ASC";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		return $arr;
	}

	//Проверка наличия картинки в базах
	public function CheckImages($path){
		$sql = "SELECT COUNT(id) AS count
			FROM "._DB_PREFIX_."image
			WHERE src LIKE '%".$path."'";
		$arr = $this->db->GetOneRowArray($sql);
		if($arr['count'] > 1){
			return false;
		}
		return true;
	}

	public function SetModerationStatus($id, $status, $comment = null){
		$f['id'] = mysql_real_escape_string($id);
		$f['moderation_status'] = mysql_real_escape_string($status);
		if($comment != ''){
			$f['comment'] = mysql_real_escape_string($comment);
		}
		if(!$this->db->Update(_DB_PREFIX_.'temp_products', $f, "id = ".$f['id'])){
			$this->db->FailTrans();
			return false;
		}
		return true;
	}

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

	public function AcceptProductModeration($data){
		$product = $this->GetProductOnModeration($data['id']);
		$f['art'] = mysql_real_escape_string($data['art']);
		$f['name'] = mysql_real_escape_string($product['name']);
		$f['translit'] = G::StrToTrans($product['name']);
		$f['descr'] = mysql_real_escape_string($product['descr']);
		$stamp = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].'/images/stamp.png');
		$sx = imagesx($stamp);
		$sy = imagesy($stamp);
		$marge_right = 0;
		$marge_bottom = 0;
		$f['img_1'] = '';
		$f['img_2'] = '';
		$f['img_3'] = '';
		for($i = 1; $i <= 3; $i++){
			if($product['img_'.$i] != ''){
				if($i > 1){
					$newname = $data['art']."-".$i.".jpg";
				}else{
					$newname = $data['art'].".jpg";
				}
				$im = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'].str_replace(_base_url, '/', $product['img_'.$i]));
				$ix = imagesx($im);
				$iy = imagesy($im);
				if($ix >= $iy){
					$nwidth = round($iy*0.9);
					$marge_right = ($ix - $nwidth)/2;
					$marge_bottom = ($iy - $nwidth)/2;
				}else{
					$nwidth = round($ix*0.9);
					$marge_right = ($ix - $nwidth)/2;
					$marge_bottom = ($iy - $nwidth)/2;
				}
				copy($_SERVER['DOCUMENT_ROOT'].str_replace(_base_url, '/', $product['img_'.$i]), $_SERVER['DOCUMENT_ROOT']."/efiles/image/".$newname);
				$f['img_'.$i] = mysql_real_escape_string(str_replace($_SERVER['DOCUMENT_ROOT'], '/', "/efiles/image/".$newname));
			}
		}
		$images = new Images();
		if(isset($product['images']) && $product['images'] != ''){
			foreach(explode(';', $product['images']) as $k=>$image){
				$newname = $data['art'].($k == 0?'':'-'.$k).'.jpg';
				$structure = $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/';
				$structure_bd = '/product_images/original/'.date('Y').'/'.date('m').'/'.date('d').'/';
				$images->checkStructure($structure);
				copy($_SERVER['DOCUMENT_ROOT'].str_replace(_base_url, '/', $image), $structure.$newname);
				$images_arr[] = $structure_bd.$newname;
				$images->resize();
			}
		}else{
			$images_arr =  array();
		}
		$f['inbox_qty'] = mysql_real_escape_string($product['inbox_qty']);
		$f['min_mopt_qty'] = mysql_real_escape_string($product['min_mopt_qty']);
		if(isset($product['qty_control'])){
			$f['qty_control'] = mysql_real_escape_string($product['qty_control']);
		}
		$f['sertificate'] = '';
		$f['country'] = '';
		$f['max_supplier_qty'] = 0;
		$f['manufacturer_id'] = 0;
		$f['weight'] = str_replace(',','.', mysql_real_escape_string($product['weight']));
		$f['volume'] = str_replace(',','.', mysql_real_escape_string($product['volume']));
		$f['id_unit'] = mysql_real_escape_string($product['id_unit']);
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
		$id = mysql_real_escape_string($res['id_product']);
		$a['id_product'] = $id ;
		$this->UpdatePhoto($id, $images_arr);
		$a['id_supplier'] = mysql_real_escape_string($product['id_supplier']);
		$a['price_mopt_otpusk'] = str_replace(',','.', mysql_real_escape_string($product['price_mopt']));
		$a['price_opt_otpusk'] = str_replace(',','.', mysql_real_escape_string($product['price_opt']));
		$a['price_mopt_recommend'] = str_replace(',','.', mysql_real_escape_string($product['price_mopt']*$sup['koef_nazen_mopt']));
		$a['price_opt_recommend'] = str_replace(',','.', mysql_real_escape_string($product['price_opt']*$sup['koef_nazen_opt']));
		$a['product_limit'] = mysql_real_escape_string($product['product_limit']);
		$a['sup_comment'] = '';
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'assortiment', $a)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return $id;
	}

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
		}else{
			return $arr['cnt'];
		}
	}

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

	public function GetProductRating($id_product){
		$sql = "SELECT * FROM "._DB_PREFIX_."product_rating AS pr WHERE pr.id_product = ".$id_product;
		$arr = $this->db->GetArray($sql);
		if(empty($arr)){
			return false;
		}
		return $arr;
	}

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

	public function GetDuplicateProducts($limit = ''){
		if($limit != ''){
			$limit = "LIMIT $limit";
		}
		$sql = "SELECT ".implode(', ',$this->usual_fields).",
			u.email
			FROM "._DB_PREFIX_."product AS p
			LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
				ON p.id_product = cp.id_product
			LEFT JOIN "._DB_PREFIX_."user AS u
				ON p.duplicate_user = u.id_user
			LEFT JOIN "._DB_PREFIX_."units AS un
				ON un.id = p.id_unit
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
	// public function GetDuplicateProducts($limit = ''){
	// 	if($limit != ''){
	// 		$limit = "LIMIT $limit";
	// 	}
	// 	$sql = "SELECT ".implode(', ',$this->usual_fields).",
	// 		u.email
	// 		FROM "._DB_PREFIX_."product AS p
	// 		LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
	// 			ON p.id_product = cp.id_product
	// 		LEFT JOIN "._DB_PREFIX_."user AS u
	// 			ON p.duplicate_user = u.id_user
	// 		LEFT JOIN "._DB_PREFIX_."units AS un
	// 			ON un.id = p.id_unit
	// 		WHERE p.duplicate = 1
	// 		OR p.duplicate_user > 0
	// 		GROUP BY id_product
	// 		$limit";
	// 	$arr = $this->db->GetArray($sql);
	// 	if(empty($arr)){
	// 		return false;
	// 	}
	// 	return $arr;
	// }

	/*Сопуцтвуещие товары*/


	//Добавление товара
	public function AddRelatedProduct($id_product, $id_related_prod){
		$f['id_prod'] = mysql_real_escape_string(trim($id_product));
		$f['id_related_prod'] = mysql_real_escape_string(trim($id_related_prod));
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'related_prods', $f)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
	}

	// Удаление товара
	public function DelRelatedProduct($id_product, $id_related_prod){
		$this->db->StartTrans();
		$sql = "DELETE FROM "._DB_PREFIX_."related_prods WHERE `id_prod` = ".$id_product." AND `id_related_prod` = ".$id_related_prod;
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		$this->db->CompleteTrans();
		return true;
	}

	//Получение массива сопуцтвующих товаров
	public function GetArrayRelatedProducts($id_product){
		$sql = "SELECT p.id_product, p.*
			FROM "._DB_PREFIX_."related_prods AS rp
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON p.id_product = rp.id_related_prod
			WHERE rp.id_prod = ".$id_product;
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}else{
			return $arr;
		}
	}

	/**
	 * PHOTO ACTIONS
	 */

	// Проверить, нет ли такого фото в другом товаре
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

	// Получить список изображений по id товара
	public function GetPhotoById($id){
		$sql = "SELECT src
			FROM "._DB_PREFIX_."image
			WHERE id_product = ".$id."
			ORDER BY ord";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		foreach($arr as $value){
			$res[] = $value['src'];
		}
		return $arr;
	}

	// Добавление и удаление фото
	public function UpdatePhoto($id_product, $arr){
		$sql = "DELETE FROM "._DB_PREFIX_."image WHERE id_product=".$id_product;
		$this->db->StartTrans();
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		$this->db->CompleteTrans();
		$f['id_product'] = mysql_real_escape_string(trim($id_product));
		if(isset($arr) && !empty($arr)){
			foreach ($arr as $k=>$src) {
				if(empty($src)){
					return false; //Если URL пустой
				}
				$f['src'] = mysql_real_escape_string(trim($src));
				$f['ord'] = mysql_real_escape_string(trim($k));
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


	//Проверка Артикула
	/**
	 * @param int $art Артикул нового товара
	 * @param array $art_arr Массив с имеющимися артикулами
	 */
	public function CheckArticle($art, $art_arr = null){
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
		return $art;
	}
}?>