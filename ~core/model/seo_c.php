<?php
class SEO{
	public $db;
	public $fields;
	private $usual_fields;
	public $list;
	public function __construct (){
		$this->db =& $GLOBALS['db'];
		$this->usual_fields = array("id", "url", "text", "id_author", "creation_date", "visible");
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
		$sql = "SELECT ".implode(", ",$this->usual_fields).",
			name AS username
			FROM "._DB_PREFIX_."seo_text
			LEFT JOIN "._DB_PREFIX_."user
			ON id_author = id_user
			WHERE id = ".$id_seo_text;
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
		$sql = "SELECT ".implode(", ",$this->usual_fields).",
			name AS username
			FROM "._DB_PREFIX_."seo_text
			LEFT JOIN "._DB_PREFIX_."user
			ON id_author = id_user
			ORDER BY id desc ".
			$limit;
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
		$f['id_author'] = trim($arr['id_author']);
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
		$f['id_author'] = trim($arr['id_author']);
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

	// Поиск слов (тегов) по строке
	public function GerWord($str){
		$sql = "SELECT word
			FROM "._DB_PREFIX_."semantic_core
			WHERE word like '".$str."%'";
		$this->list = $this->db->GetArray($sql);
		return $this->list;
	}

	// Рандомное добавление сеотекста товарам
	public function productSeotext($cnt_prod = 300){
		$sql = 'SELECT * FROM '._DB_PREFIX_.'seotext_formats';
		$seotext = $this->db->GetArray($sql);
		if(!$seotext){
			return false;
		}
		$sql = 'SELECT p.translit
				FROM '._DB_PREFIX_.'product AS p
				WHERE (SELECT COUNT(*) FROM '._DB_PREFIX_.'seo_text AS s WHERE s.url = CONCAT(\''.Link::Product("', p.translit, '").'\')) = 0
				ORDER BY RAND() LIMIT '.$cnt_prod;
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		// Заносим в БД сеотекст к товарам
		$sql = 'INSERT INTO '._DB_PREFIX_.'seo_text (url, text) VALUES';
		foreach($arr as $val){
			$rand_seotext = $seotext[array_rand($seotext)];
			switch($rand_seotext['type']){
				case 1:
					if(!isset($arr_cities)){
						// Выбор массива городов из БД
						$sql1 = 'SELECT title
								FROM '._DB_PREFIX_.'locations_cities';
						$res = $this->db->GetArray($sql1);
						if(!$res){
							return false;
						}
						$arr_cities=array();
						foreach($res as $v){
							$arr_cities[] = $v['title'];
						}
					}
					$rand_arr = $arr_cities;
					break;
				case 2:
					if(!isset($arr_manufactures)){
						// Выбор массива предприятий из БД
						$sql1 = 'SELECT name
								FROM '._DB_PREFIX_.'segmentation
								WHERE type = 1';
						$res = $this->db->GetArray($sql1);
						if(!$res){
							return false;
						}
						$arr_manufactures=array();
						foreach($res as $v){
							$arr_manufactures[] = $v['name'];
						}
					}
					$rand_arr = $arr_manufactures;
					break;
				case 3:
					if(!isset($arr_shops)){
						// Выбор массива магазинов из БД
						$sql1 = 'SELECT name
								FROM '._DB_PREFIX_.'segmentation
								WHERE type = 2';
						$res = $this->db->GetArray($sql1);
						if(!$res){
							return false;
						}
						$arr_shops=array();
						foreach($res as $v){
							$arr_shops[] = $v['name'];
						}
					}
					$rand_arr = $arr_shops;
					break;
			}
			$rand_injection = implode(', ', array_rand(array_flip($rand_arr), $rand_seotext['quantity']));
			$sql .= '('.$this->db->Quote(Link::Product($val['translit'])).', '.$this->db->Quote(sprintf($rand_seotext['format'], $rand_injection)).')'.(next($arr)?', ':null);
		}
		if (!$this->db->Query($sql)){
			return false;
		}
		return true;
	}

	// Страница по id
	public function getFieldsFormatById($id){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."seotext_formats
			WHERE id = ".$id;
		$res = $this->db->GetOneRowArray($sql);
		if(!$res){
			return false;
		}
		return $res;
	}

	// Добавление списка в seotext_formats
	public function addSeotextFormats($data){
		$f['format'] = trim($data['format']);
		$f['quantity'] = $data['quantity'];
		$f['type'] = $data['type'];
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'seotext_formats', $f)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	// Выборка форматов сеотекста
	public function getSeotextFormats($where = false, $limit = false){
		$sql = 'SELECT * FROM '._DB_PREFIX_.'seotext_formats'.
			($where?$where:null).
			' ORDER BY id DESC'.
			($limit?$limit:null);
		$res = $this->db->GetArray($sql);
		if(!$res){
			return false;
		}
		return $res;
	}

	// Изменение формата сеотекста
	public function updateSeotextFormats($data){
		$f['format'] = trim($data['format']);
		$f['quantity'] = $data['quantity'];
		$f['type'] = $data['type'];
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_.'seotext_formats', $f, 'id = '.$data['id'])){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	// Удаление строки в таблице xt_seotext_formats
	public function de1SeotextFormats($id){
		$sql = 'DELETE FROM '._DB_PREFIX_.'seotext_formats WHERE id = '.$id;
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}
}