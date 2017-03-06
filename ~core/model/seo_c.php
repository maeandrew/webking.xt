<?php
class Seo {
	public $db;
	public $fields;
	private $usual_fields;
	public $list;
	public function __construct (){
		$this->db =& $GLOBALS['db'];
		$this->usual_fields = array('id', 'url', 'text', 'id_author', 'creation_date', 'visible');
	}
	// Проверка наличия такого url
	//
	public function SetFieldsByUrl($url, $all = 0){
		$sql = 'SELECT '.implode(', ',$this->usual_fields).'
			FROM '._DB_PREFIX_.'seo_text
			WHERE url = '.$this->db->Quote($url);
		// if(strpos($sql, "/sort") == true){
		// 	$sql=substr_replace($sql, "'", strpos($sql, "/sort"));
		// 	}
		// if(substr($url, -1) == '/'){
		// 	$sql=substr_replace($sql, substr($url, 0, strlen($url)-1)."'", strpos($sql, $url));
		// 	}
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		return true;
	}
	// Страница по id
	public function SetFieldsById($id_seo_text, $all = 0){
		$sql = 'SELECT '.implode(', ',$this->usual_fields).',
			name AS username
			FROM '._DB_PREFIX_.'seo_text
			LEFT JOIN '._DB_PREFIX_.'user
			ON id_author = id_user
			WHERE id = '.$id_seo_text;
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		return true;
	}
	// Список SeoText
	public function SeoTextList($limit = ''){
		$sql = 'SELECT st.id, st.url, st.creation_date,
			st.visible, u.name AS username
			FROM '._DB_PREFIX_.'seo_text AS st
			LEFT JOIN '._DB_PREFIX_.'user AS u
				ON st.id_author = u.id_user
			ORDER BY st.id DESC '.
			$limit;
		if(!$this->list = $this->db->GetArray($sql)){
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
		if(!$this->db->Update(_DB_PREFIX_.'seo_text', $f, 'id = '.$f['id'])){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	// Удаление страницы
	public function DelSeoText($id_seo_text){
		$sql = 'DELETE FROM '._DB_PREFIX_.'seo_text WHERE id = '.$id_seo_text;
		$this->db->Query($sql) or G::DieLoger('<b>SQL Error - </b>'.$sql);
		return true;
	}

	// Поиск слов (тегов) по строке
	public function GerWord($str){
		$sql = 'SELECT word
			FROM '._DB_PREFIX_.'semantic_core
			WHERE word like \''.$str.'%\'';
		$this->list = $this->db->GetArray($sql);
		return $this->list;
	}

	// Рандомное добавление сеотекста товарам
	public function productSeotext($cnt_prod = 300){
		$sql = 'SELECT * FROM '._DB_PREFIX_.'seotext_formats';
		if(!$formats = $this->db->GetArray($sql)){
			return false;
		}
		foreach($formats as $format){
			$format_by_types[$format['type']][] = $format;
		}
		$sql = 'SELECT p.translit, p.id_product
				FROM '._DB_PREFIX_.'product AS p
				WHERE (SELECT COUNT(*) FROM '._DB_PREFIX_.'seo_text AS s WHERE s.url = CONCAT(\''.Link::Product("', p.translit, '").'\')) = 0
				AND id_product IN (SELECT id_product FROM xt_cat_prod WHERE main = 1)
				ORDER BY RAND() LIMIT '.$cnt_prod;
		if(!$arr = $this->db->GetArray($sql)){
			return false;
		}
		function random_keywords($id_product, $id_category = false, $result = array()){
			global $db;
			if(!$id_category){
				$sql1 = 'SELECT c.id_category, c.pid, c.page_keywords FROM '._DB_PREFIX_.'cat_prod as cp LEFT JOIN '._DB_PREFIX_.'category AS c ON c.id_category = cp.id_category WHERE cp.id_product = '.$id_product.' AND cp.main = 1';
			}else{
				$sql1 = 'SELECT c.id_category, c.pid, c.page_keywords FROM '._DB_PREFIX_.'category AS c WHERE c.id_category = '.$id_category;
			}
			$res = $db->GetOneRowArray($sql1);
			if($res['page_keywords'] !== ''){
				$result[] = $res['page_keywords'];
			}
			if($res['pid'] != 0){
				$result = random_keywords($id_product, $res['pid'], $result);
			}
			return $result;
		}
		// Заносим в БД сеотекст к товарам
		$sql = 'INSERT INTO '._DB_PREFIX_.'seo_text (url, text) VALUES ';
		foreach($arr as $k=>$val){
			$rand_injection = '';
			if(!isset($arr_cities)){
				// Выбор массива городов из БД
				$sql1 = 'SELECT title
						FROM '._DB_PREFIX_.'locations_cities';
				$res = $this->db->GetArray($sql1);
				if(!$res){
					return false;
				}
				foreach($res as $v){
					$arr_cities[] = $v['title'];
				}
			}
			$rand_seotext = $format_by_types[1][array_rand($format_by_types[1])];
			$rand_injection .= sprintf($rand_seotext['format'], implode(', ', array_rand(array_flip($arr_cities), $rand_seotext['quantity'])));
			$rand_injection .= '<br><br>';

			if(!isset($arr_manufactures)){
				// Выбор массива предприятий из БД
				$sql1 = 'SELECT name
						FROM '._DB_PREFIX_.'segmentation
						WHERE type = 1';
				$res = $this->db->GetArray($sql1);
				if(!$res){
					return false;
				}
				foreach($res as $v){
					$arr_manufactures[] = $v['name'];
				}
			}
			$rand_seotext = $format_by_types[2][array_rand($format_by_types[2])];
			$rand_injection .= sprintf($rand_seotext['format'], implode(', ', array_rand(array_flip($arr_manufactures), $rand_seotext['quantity'])));
			$rand_injection .= '<br><br>';

			if(!isset($arr_shops)){
				// Выбор массива магазинов из БД
				$sql1 = 'SELECT name
						FROM '._DB_PREFIX_.'segmentation
						WHERE type = 2';
				$res = $this->db->GetArray($sql1);
				if(!$res){
					return false;
				}
				foreach($res as $v){
					$arr_shops[] = $v['name'];
				}
			}
			$rand_seotext = $format_by_types[3][array_rand($format_by_types[3])];
			$rand_injection .= sprintf($rand_seotext['format'], implode(', ', array_rand(array_flip($arr_shops), $rand_seotext['quantity'])));
			$rand_injection .= '<br><br>';

			if(!isset($arr_keywords)){
				$res = random_keywords($val['id_product']);
				$text = '';
				$rand_injection .= 'Теги: ';
				foreach($res as $value){
					if($value){
						$keywords = explode(', ', $value);
						if(count($keywords) > 5){
							$result = implode(', ', array_rand(array_flip($keywords), 5));
						}else{
							$result = implode(', ', $keywords);
						}
						if($result != ''){
							$text .= ($text != ''?', ':null).$result;
						}
					}
				}
				$rand_injection .= $text;
			}
			$sql .= '('.$this->db->Quote(Link::Product($val['translit'])).', '.$this->db->Quote($rand_injection).')'.($arr[$k+1]?', ':null);
		}
		if(!$this->db->Query($sql)){
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