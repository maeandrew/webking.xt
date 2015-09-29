<?php

class Manufacturers{

	public $db;

	public $fields;
	public $list;

	/** Конструктор
	 * @return
	 */
	public function __construct (){

		$this->db =& $GLOBALS['db'];
	}

	// по id
	public function SetFieldsById($manufacturer_id, $all=0){

		$manufacturer_id = mysql_real_escape_string($manufacturer_id);

		$sql = "SELECT manufacturer_id, name, translit, m_image, ord
				FROM "._DB_PREFIX_."manufacturers
				WHERE manufacturer_id = \"$manufacturer_id\"
				order by ord, name";

		$this->fields = $this->db->GetOneRowArray($sql);

		if (!$this->fields)
			return false;
		else
			return true;
	}

	// по translit
	public function SetFieldsByTranslit($translit, $all=0){

		$translit = mysql_real_escape_string($translit);

		$sql = "SELECT manufacturer_id, name, translit, m_image, ord
				FROM "._DB_PREFIX_."manufacturers
				WHERE translit = \"$translit\"";

		$this->fields = $this->db->GetOneRowArray($sql);

		if (!$this->fields)
			return false;
		else
			return true;
	}


	// Список
	public function ManufacturersList(){

		$sql = "SELECT manufacturer_id, name, translit, m_image, ord
				FROM "._DB_PREFIX_."manufacturers
				order by ord, name";

		$this->list = $this->db->GetArray($sql);

		if (!$this->list)
			return false;
		else
			return true;
	}

	// Список производителей с количеством товаров
	public function ManufacturersListProductsCnt(){

		$sql = "SELECT m.manufacturer_id, COUNT(p.id_product) cnt
				FROM "._DB_PREFIX_."manufacturers AS m LEFT JOIN "._DB_PREFIX_."product AS p
				ON m.manufacturer_id=p.manufacturer_id
				GROUP BY m.name
				ORDER BY cnt";

		$list = $this->db->GetArray($sql);
        $this->list = array();
		foreach ($list as $li){
			$this->list[$li['manufacturer_id']] = $li['cnt'];
		}

		if (!$this->list)
			return false;
		else
			return true;
	}


	// Добавить
	public function AddManufacturer($arr){

		$name = mysql_real_escape_string(trim($arr['name']));
		$translit = G::StrToTrans($name);
		$m_image = mysql_real_escape_string(trim($arr['m_image']));

		$sql = "INSERT INTO "._DB_PREFIX_."manufacturers (`name`, `translit`, `m_image`)
				VALUES (\"$name\", \"$translit\", \"$m_image\")";

		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");

		$_id = $this->db->GetInsId();

		return $_id;
	}


	// Обновление
	public function UpdateManufacturer($arr){

		$manufacturer_id = mysql_real_escape_string(trim($arr['manufacturer_id']));
		$name = mysql_real_escape_string(trim($arr['name']));
		$translit = G::StrToTrans($name);
		$m_image = mysql_real_escape_string(trim($arr['m_image']));

		$sql = "UPDATE "._DB_PREFIX_."manufacturers SET `name` = \"$name\", `translit` = \"$translit\", `m_image` = \"$m_image\"
				WHERE manufacturer_id = $manufacturer_id";

		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");

		return true;
	}


	// Удаление
	public function DelManufacturer($_id){

		$sql = "DELETE FROM "._DB_PREFIX_."manufacturers WHERE `manufacturer_id` =  $_id";
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");

		return true;
	}


	// Сортировка
	public function Reorder($arr){

		foreach ($arr['ord'] as $_id=>$ord){
			$sql = "UPDATE "._DB_PREFIX_."manufacturers SET `ord` = $ord
					WHERE manufacturer_id = $_id";

			$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		}
	}

}

?>