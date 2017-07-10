<?php
class Specification{
	public $db;
	public $fields;
	private $usual_fields;
	public $list;
	/** Конструктор
		 * @return
	 	 */
	public function __construct(){
		$this->db =& $GLOBALS['db'];
		$this->usual_fields = array('id', 'caption', 'service_caption', 'units');
	}

	public function SpecExistsByCaption($caption){
		$sql = 'SELECT *
			FROM '._DB_PREFIX_.'specs
			WHERE caption = '.$this->db->Quote($caption);
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res;
	}

	// по id
	public function SetFieldsById($id){
		$sql = "SELECT ".implode(', ', $this->usual_fields)."
			FROM "._DB_PREFIX_."specs
			WHERE id = $id";
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		return true;
	}

	// Список
	public function SetList($param = 0, $limit = ''){
		if($limit != ''){
			$limit = " limit $limit";
		}
		$sql = "SELECT *
			FROM "._DB_PREFIX_."specs
			ORDER BY caption
			$limit";
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}

	public function SetListByCatId($id_cat){
		$sql = 'SELECT id_cat, caption, units, sc.id, id_spec
			FROM '._DB_PREFIX_.'specs_cats AS sc
			LEFT JOIN '._DB_PREFIX_.'specs AS s
				ON s.id = sc.id_spec
			WHERE id_cat = '.$id_cat.'
			ORDER BY sc.id_spec';
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}
	//Выбрать характеристики у каждого продукта
	public function SetListByProdId($id_product){
		$sql = "SELECT s.id AS id_spec, s.caption, s.service_caption, sp.id, sp.value, svl.value AS list_value, s.units
			FROM "._DB_PREFIX_."specs_prods AS sp
				LEFT JOIN "._DB_PREFIX_."specs AS s ON s.id = sp.id_spec
				LEFT JOIN "._DB_PREFIX_."specs_values_list AS svl ON svl.id = sp.id_value
			WHERE id_prod = $id_product
			UNION
			SELECT s.id, s.caption, s.service_caption, NULL, NULL, NULL, s.units
			FROM "._DB_PREFIX_."specs_cats AS sc
				LEFT JOIN "._DB_PREFIX_."specs AS s ON s.id = sc.id_spec
			WHERE sc.id_cat = (
				SELECT MAX(id_category)
			    FROM "._DB_PREFIX_."cat_prod
			    WHERE id_product = $id_product
					AND id_category <> 469
			    GROUP BY id_product
			)
			AND s.id NOT IN (
				SELECT id_spec
				FROM "._DB_PREFIX_."specs_prods
				WHERE id_prod = $id_product
			)
			ORDER BY id_spec";
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}

	public function AddValue($data){
		$f['id_spec'] = $data['id_specification'];
		$f['value'] = $data['value'];
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'specs_values_list', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id;
	}

	public function DeleteValue($id){
		$this->db->StartTrans();
		if(!$this->db->DeleteRowsFrom(_DB_PREFIX_.'specs_values_list', array("id = $id"))){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function UpdateValue($data){
		$f['value'] = $data['value'];
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_.'specs_values_list', $f, "id = {$data['id']}")){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function GetValuesList($id){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."specs_values_list AS svl
			WHERE svl.id_spec = $id";
		if(!$arr = $this->db->GetArray($sql)){
			return false;
		}
		return $arr;
	}
	// Добавление
	public function Add($arr){
		// $f['id'] = trim($arr['id']);
		$f['caption'] = trim($arr['caption']);
		$f['service_caption'] = trim($arr['service_caption'])?trim($arr['service_caption']):$f['caption'];
		if(isset($arr['units'])){
			$f['units'] = trim($arr['units']);
		}
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'specs', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id;
	}

	public function AddSpecToCat($arr){
		$f['id_spec'] = trim($arr['id_specification']);
		$f['id_cat'] = trim($arr['id_category']);
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'specs_cats', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id;
	}

	public function AddSpecToProd($arr, $id_product){
		$f['id_spec'] = trim($arr['id_spec']);
		$f['id_prod'] = $id_product;
		$f['value'] = trim($arr['value']) == ''?NULL:trim($arr['value']);
		$f['id_value'] = trim($arr['id_value']) == ''?NULL:trim($arr['id_value']);
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'specs_prods', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id;
	}

	// Обновление
	public function Update($arr){
		$f['id'] = trim($arr['id']);
		$f['caption'] = trim($arr['caption']);
		$f['service_caption'] = trim($arr['service_caption'])?trim($arr['service_caption']):$f['caption'];
		$f['units'] = trim($arr['units']);
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."specs", $f, "id = {$f['id']}")){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	// Обновление характеристик у продукта
	public function UpdateSpecsInProducts($arr){
		$f['id'] = trim($arr['id_spec_prod']);
		$f['value'] = trim($arr['value']) == ''?NULL:trim($arr['value']);
		$f['id_value'] = trim($arr['id_value']) == ''?NULL:trim($arr['id_value']);
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."specs_prods", $f, "id = {$f['id']}")){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	// Обновление значения характеристик у продуктов по характеристике из выбраного раздела
	public function UpdateSpecsValueMonitoring($arr){
		$sql = "UPDATE "._DB_PREFIX_."specs_prods
			SET value = '".$arr['value']."'
			WHERE id_spec = ".$arr['id_spec']."
			AND value = '".$arr['oldValue']."'
			AND id_prod IN (SELECT id_product FROM "._DB_PREFIX_."cat_prod WHERE id_category = ".$arr['id_category'].")";
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	public function UpdateByName($caption, $units){
		$f['caption'] = trim($caption);
		$f['units'] = trim($units);
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."specs", $f, "caption = '".$units."'")){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	// Удаление
	public function Del($id){
		$sql = "DELETE FROM "._DB_PREFIX_."specs WHERE id =  $id";
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}

	//Удаление характеристик из категорий
	public function DelSpecFromCat($arr){
		$sql = "DELETE FROM "._DB_PREFIX_."specs_cats
			WHERE id_spec = ".$this->db->Quote($arr['id_specification'])."
			AND id_cat = ".$this->db->Quote($arr['id_category']);
		$this->db->StartTrans();
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		$this->db->CompleteTrans();
		return true;
	}
	
	public function DelSpecFromProd($id){
		$sql = "DELETE FROM "._DB_PREFIX_."specs_prods WHERE id = ".$id;
		$this->db->StartTrans();
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		$this->db->CompleteTrans();
		return true;
	}

	// Сортировка страниц
	public function Reorder($arr){
		foreach ($arr['ord'] as $id=>$ord){
			$sql = "UPDATE "._DB_PREFIX_."specs SET `ord` = $ord
					WHERE id = $id";
			$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		}
	}
	public function ReorderInCategory($arr, $id_category){
		$this->db->StartTrans();
		foreach($arr as $position => $id_spec){
			$sql = "UPDATE "._DB_PREFIX_."specs_cats
				SET position = $position
				WHERE id_spec = $id_spec
				AND id_cat = $id_category";
			$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		}
		$this->db->CompleteTrans();
	}

	public function GetSpecsForCats(){
		$sql = "SELECT sc.*, c.name, s.caption
			FROM "._DB_PREFIX_."specs_cats AS sc
			LEFT JOIN "._DB_PREFIX_."category AS c
			ON c.id_category = sc.id_cat
			LEFT JOIN "._DB_PREFIX_."specs AS s
			ON sc.id_spec = s.id";
		$res = $this->db->GetArray($sql);
		if(!$res){
			return false;
		}
		return $res;
	}

	// Список
	public function GetMonitoringList($limit = false, $where = false){
		ini_set('memory_limit', '512M');
		//достаем из БД характеристики
		$sql = "SELECT id AS id_caption, caption, units FROM  "._DB_PREFIX_."specs";
		$specifications = $this->db->GetArray($sql, 'id_caption');
		if(!$specifications){
			return false;
		}

		//достаем из БД имена категорий
		$sql = "SELECT id_category, name FROM  "._DB_PREFIX_."category";
		$categories = $this->db->GetArray($sql, 'id_category');
		if(!$categories){
			return false;
		}

		$sql = "SELECT cp.id_category, sp.id_spec AS id_caption, sp.value, count(*) AS count
			FROM "._DB_PREFIX_."specs_prods AS sp
			LEFT JOIN "._DB_PREFIX_."cat_prod AS cp ON sp.id_prod = cp.id_product AND sp.id_prod IS NOT NULL
			WHERE sp.value <> '' AND cp.id_category IS NOT NULL
			GROUP BY cp.id_category, sp.id_spec, sp.value";
		if($where){
			$sql .= " HAVING ";
			$i = 0;
			foreach($where as $key => $value){
				if($value != ''){
					$sql .= $key.' = '.$this->db->Quote($value);
					if($i != count($where)-1){
						$sql .= ' AND ';
					}
				}
				$i++;
			}
		}
		$sql .= " ORDER BY cp.id_category, sp.id_spec".
			($limit?" LIMIT".$limit:'');
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}

		foreach($this->list as &$v){
			$v['name'] = $categories[$v['id_category']]['name'];
			$v['caption'] = $specifications[$v['id_caption']]['caption'];
			$v['units'] = $specifications[$v['id_caption']]['units'];
		}
		unset($categories, $specifications);
		ini_set('memory_limit', '192M');
		return true;
	}

	// Список
	public function GetProdlistModeration($category = null, $spec, $value){
		$category ? $category = "cp.id_category = ".$category: '';
		if ($spec && $category) {
			$spec = " AND s.id = ".$spec;
		}elseif($spec && !$category){
			$spec = "s.id = ".$spec;
		}else{
			$spec = "";
		}

		$sql = "SELECT sp.id_prod, p.name
			FROM "._DB_PREFIX_."specs_prods AS sp
			LEFT JOIN "._DB_PREFIX_."specs AS s ON s.id = sp.id_spec
			LEFT JOIN "._DB_PREFIX_."cat_prod AS cp ON sp.id_prod = cp.id_product AND sp.id_prod IS NOT NULL
			LEFT JOIN "._DB_PREFIX_."product AS p ON sp.id_prod = p.id_product
			WHERE ".$category
			.$spec."
			AND sp.value = '".$value."'";
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return $this->list;
	}

}
