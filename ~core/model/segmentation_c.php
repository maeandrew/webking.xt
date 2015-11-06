<?php
class Segmentation {
	public $db;
	public $fields;
	private $usual_fields;
	public $list;
	public function __construct (){
		$this->db =& $GLOBALS['db'];
		$this->usual_fields = array("s.id", "s.name", "s.type", "s.date", "s.count_days");
	}

	//Добавление Сегментации
	public function AddSegmentation($arr){
		$type_fields = $this->GetSegmentationType($_POST['type']);
		$f['name'] = mysql_real_escape_string(trim($arr['name']));
		$f['type'] = mysql_real_escape_string($arr['type']);
		if($type_fields[0]['use_date'] == 1){
			$f['date'] = $arr['date'] != ''?mysql_real_escape_string(trim($arr['date'])):null;
			$f['count_days'] = $arr['count_days'] != ''?mysql_real_escape_string(trim($arr['count_days'])):null;
		}
		$this->db->StartTrans();
		unset($arr);
		if(!$this->db->Insert(_DB_PREFIX_.'segmentation', $f)){
			$this->db->FailTrans();
			return false; //Если не удалось записать в базу
		}
		unset($f);
		$this->db->CompleteTrans();
		return true;//Если все ок
	}

	//Привязка Сегментации к продукту
	public function AddSegmentInProduct($id_product,$id_segment){
		$f['id_product'] = $id_product;
		$f['id_segment'] = $id_segment;
		$this->db->StartTrans();
		unset($arr);
		if($this->db->ValidationFields(_DB_PREFIX_.'segment_prods',$f)){
			$this->db->Insert(_DB_PREFIX_.'segment_prods', $f);
			unset($f);
			$this->db->CompleteTrans();
			return true;//Если все ок
		}
		$this->db->FailTrans();
		return false; //Если не удалось записать в базу
	}

	//Получение списка типа или типов сегментаций
	public function GetSegmentationType($id = false){
		$where = '';
		if($id){
			$where = "WHERE id = ".$id;
		}
		$sql = "SELECT * FROM "._DB_PREFIX_."segmentation_type
			".$where."
			ORDER BY id";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		return $arr;
	}

	//Получение списка сегментаций по типу
	public function GetSegmentation($type = false){
		$where = '';
		if($type){
			$where = "WHERE s.type = ".$type;
		}
		$sql = "SELECT ".implode(", ",$this->usual_fields).",
			st.type_name, st.alias, st.use_date
			FROM "._DB_PREFIX_."segmentation AS s
			LEFT JOIN "._DB_PREFIX_."segmentation_type AS st
				ON st.id = s.type
			".$where."
			ORDER BY s.id";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		return $arr;
	}

	//Получение списка сегментаций для продукта
	public function GetSegmentationsForProduct($id_product){
		$sql = "SELECT s.id, s.name, s.date, s.count_days,
			st.type_name, st.use_date
			FROM "._DB_PREFIX_."segment_prods AS sp
			LEFT JOIN "._DB_PREFIX_."segmentation AS s
				ON s.id = sp.id_segment
			LEFT JOIN "._DB_PREFIX_."segmentation_type AS st
				ON st.id = s.type
			WHERE sp.id_product = '".$id_product."'
			ORDER BY st.id, sp.id";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}
		return $arr;
	}

	// Удаление пожелания
	public function DelSegmentInProduct($id_product, $id_segment){
		$sql = "DELETE FROM "._DB_PREFIX_."segment_prods
			WHERE id_product = '".$id_product."'
			AND id_segment = ".$id_segment;
		$this->db->StartTrans();
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		$this->db->CompleteTrans();
		return true;
	}

}
?>