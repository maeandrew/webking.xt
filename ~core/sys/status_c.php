<?php
class Status {

	public $table;
	public $db;
	public $fields;
	private $usual_fields;

	public function __construct (){
		$this->db =& $GLOBALS['db'];
		$this->table = "prod_status";
		$this->usual_fields = array("s.id, s.name, s.description, s.class");
	}

	public function GetStstusById($id){
		$id = $this->db->Quote($id);
		$sql = "SELECT ".implode(", ",$this->usual_fields)."
				FROM "._DB_PREFIX_.$this->table." AS s, "._DB_PREFIX_."product AS p
				WHERE p.prod_status = s.id AND p.id_product = \"$id\"";
		$this->fields = $this->db->GetOneRowArray($sql);
		if(!$this->fields){
			return false;
		}else{
			return $this->fields;
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
		if($this->db->Query($sql)){
			return true;
		}else{
			return "<b>SQL Error - </b>$sql";
		}
		$this->db->CompleteTrans();
	}

	public function ClearStatus($id_status){
		$sql = "UPDATE "._DB_PREFIX_."product AS p SET p.prod_status = '1'
				WHERE p.prod_status = ".$id_status;
		if($this->db->Query($sql)){
			return true;
		}else{
			return "<b>SQL Error - </b>$sql";
		}
	}

	public function GetWarehouseProducts(){
		$sql = "SELECT "._DB_PREFIX_."assortiment.id_product
				FROM "._DB_PREFIX_."warehouse_supplier LEFT JOIN "._DB_PREFIX_."assortiment
				ON "._DB_PREFIX_."warehouse_supplier.id_supplier = "._DB_PREFIX_."assortiment.id_supplier
				WHERE "._DB_PREFIX_."assortiment.product_limit <> 0";
		$arr = $this->db->GetArray($sql);
		if(!$arr){
			return false;
		}else{
			return $arr;
		}
	}

	public function UpdateStatuses(){
		$this->ClearStatus('3');
		$sql = "UPDATE "._DB_PREFIX_."product AS p SET p.prod_status = '3'
				WHERE p.id_product = (
				SELECT p.id_product
				FROM "._DB_PREFIX_."cat_prod AS cp
				WHERE p.id_product = cp.id_product
				AND cp.id_category = ".$GLOBALS['CONFIG']['new_catalog_id'].")";
		if($this->db->Query($sql)){
			return true;
		}else{
			return "<b>SQL Error - </b>$sql";
		}
	}

	public function UpdateStatus($id_product, $id_status){
		$this->ClearStatus($id_status);
		$sql = "UPDATE "._DB_PREFIX_."product AS p
				SET p.prod_status = ".$id_status."
				WHERE p.id_product = ".$id_product;
		if($this->db->Query($sql)){
			return true;
		}
		return false;
	}

	public function UpdateStatus_Sale($id_product, $id_status){
		$this->ClearStatus($id_status);
		$sql = "UPDATE "._DB_PREFIX_."product
				SET `prod_status` = \"$id_status\"
				WHERE id_product = \"$id_product\"";
		if($this->db->Query($sql)){
			return true;
		}
		return false;
	}

	public function UpdateInUSD($id_product, $inusd, $id_supplier){
		$i = $inusd == 'true'?'1':'0';
		$sql = "UPDATE "._DB_PREFIX_."assortiment
			SET inusd = ".$i."
			WHERE id_product = ".$id_product."
			AND id_supplier = ".$id_supplier;
		$this->db->StartTrans();
		if(!$this->db->Query($sql)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function UpdateStatuses_Hit(){
		$this->ClearStatus('2');
		$sql = "UPDATE "._DB_PREFIX_."product AS p
			SET p.prod_status = '2'
			WHERE p.id_product = (
				SELECT osp.id_product
				FROM "._DB_PREFIX_."osp AS osp
				LEFT JOIN "._DB_PREFIX_."order AS o
				ON osp.id_order = o.id_order
				WHERE osp.id_product = p.id_product
				AND o.id_order_status = 2
				AND o.creation_date > (UNIX_TIMESTAMP() - 3600*24*7)
				GROUP BY osp.id_product
				HAVING COUNT(osp.id_product) >= ".$GLOBALS['CONFIG']['min_hit_quantity']."
				LIMIT 500
			)";
		if($this->db->Query($sql)){
			return true;
		}else{
			return "<b>SQL Error - </b>$sql";
		}
	}

	public function UpdateStatuses_Popular(){
		$sql = "SELECT id_category
				FROM "._DB_PREFIX_."category c
				WHERE c.visible = 1
				AND c.category_level = 1";
		$main_categories = $this->db->GetArray($sql);
		$mass = array();
		$i = 1;
		foreach($main_categories AS $m){
			$sql = "SELECT osp.id_product , cp.id_category
				FROM "._DB_PREFIX_."osp osp,
				"._DB_PREFIX_."order o,
				"._DB_PREFIX_."product p,
				"._DB_PREFIX_."cat_prod cp
				WHERE osp.id_product = p.id_product
				AND osp.id_order = o.id_order
				AND o.id_order_status = 2
				AND creation_date > (UNIX_TIMESTAMP() - 3600*24*7)
				AND cp.id_product = p.id_product
				AND p.price_mopt > 0
				AND cp.id_category in (
					SELECT id_category
					FROM "._DB_PREFIX_."category c
					WHERE c.pid = ".$m['id_category']."
					OR c.pid in (
						SELECT id_category
						FROM "._DB_PREFIX_."category c
						WHERE c.pid = ".$m['id_category']."
					)
				)
				GROUP BY osp.id_product
				HAVING COUNT(osp.id_product) >= 1
				ORDER BY COUNT(osp.id_product) DESC
				LIMIT 3";
			$res = $this->db->GetArray($sql);
			if($res){
				if($res[0]){
					$mass[$i] = $res[0];
				}
				if($res[1]){
					$mass[$i+10] = $res[1];
				}
				if($res[2]){
					$mass[$i+20] = $res[2];
				}
				$i++;
			}
		}
		ksort($mass);
		if($this->db->Query("TRUNCATE TABLE "._DB_PREFIX_."popular_products")){
			$this->db->StartTrans();
			foreach($mass AS $m){
				if(!$m || !$this->db->Insert(_DB_PREFIX_."popular_products", $m)){
					$this->db->FailTrans();
					return false;
				}
			}
			$this->db->CompleteTrans();
			return true;
		}
	}
}
?>
