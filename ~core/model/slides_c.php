<?php
class Slides {
	public $db;
	public $fields;
	private $usual_fields;
	public $list;
	public function __construct (){
		$this->db =& $GLOBALS['db'];
		$this->usual_fields = array("id", "title", "image", "content", "slider", "visibility", "ord");
	}

	// Страница по id
	public function SetFieldsById($id, $all = 0){
		$visibility = "AND visibility = 1";
		if($all == 1){
			$visibility = '';
		}
		$id = $this->db->Quote($id);
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."slides
			WHERE id = ".$id."
			".$visibility."
			ORDER BY ord";
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}
		return true;
	}

	// Страница по названию слайдера
	public function SetFieldsBySlider($slider, $all = 0){
		$visibility = "AND visibility = 1";
		if($all == 1){
			$visibility = '';
		}
		$slider = $this->db->Quote($slider);
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."slides
			WHERE slider = '".$slider."'
			".$visibility."
			ORDER BY ord";
		$this->fields = $this->db->GetArray($sql);
		if(!$this->fields){
			return false;
		}
		return true;
	}

	// Список (0 - только видимые. 1 - все, и видимые и невидимые)
	public function SlidesList($param = 0, $limit = ""){
		$where = "WHERE visibility = 1 ";
		if($param == 1){
			$where = '';
		}
		if($limit != ""){
			$limit = " limit $limit";
		}
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
			FROM "._DB_PREFIX_."slides
			".$where."
			ORDER BY ord".
			$limit;
		$this->list = $this->db->GetArray($sql);
		if(!$this->list){
			return false;
		}
		return true;
	}

	public function AddSlide($arr){
		$sql = "SELECT MAX(ord) AS ord
			FROM "._DB_PREFIX_."slides
			WHERE slider = '".$arr['slider']."'";
		$arr2 = $this->db->GetOneRowArray($sql);
		$f['image'] = $this->db->Quote(trim($arr['image']));
		$f['title'] = $this->db->Quote(trim($arr['title']));
		$f['content'] = $arr['content'];
		$f['slider'] = $this->db->Quote(trim($arr['slider']));
		$f['visibility'] = $this->db->Quote(trim($arr['visibility']));
		$f['ord'] = $this->db->Quote($arr2['ord']+1);
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'slides', $f)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		$sql = "SELECT MAX(ID) AS id
			FROM "._DB_PREFIX_."slides";
		$ret = $this->db->GetOneRowArray($sql);
		return $ret['id'];
	}
	// Сортировка слайдов
	public function SortSlides($slides){
		foreach($slides as $k=>$v){
			$sql = "UPDATE "._DB_PREFIX_."slides
				SET ord = ".$k."
				WHERE id = ".eregi_replace("([^0-9])", "", $v);
			$this->db->StartTrans();
			$this->db->Query($sql);
			$this->db->CompleteTrans();
		}
		return true;
	}

	// Обновление слайда
	public function UpdateSlide($arr){
		$f['title'] = $this->db->Quote(trim($arr['title']));
		$f['image'] = $this->db->Quote(trim($arr['image']));
		$f['content'] = $arr['content'];
		$f['slider'] = $this->db->Quote(trim($arr['slider']));
		$f['visibility'] = $this->db->Quote(trim($arr['visibility']));
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_."slides", $f, "id = ".$arr['id'])){
			$this->db->FailTrans();
			return false;
		}
		$id = $this->db->GetInsId();
		$this->db->CompleteTrans();
		return true;
	}

	// Удаление слайда
	public function DeleteSlide($id){
		$sql = "DELETE
			FROM "._DB_PREFIX_."slides
			WHERE id = ".$id;
		$this->db->StartTrans();
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		$this->db->CompleteTrans();
		return $id;
	}
}
?>