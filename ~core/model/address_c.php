<?php
class Address {
	public $db;

	public function __construct (){
		$this->db =& $GLOBALS['db'];
	}
	public function GetListByUserId($id_user){
		$sql = "SELECT a.*, lr.title AS region, lc.title AS city,
			sc.title AS shipping_company, ld.title AS delivery
			FROM "._DB_PREFIX_."address AS a
			LEFT JOIN "._DB_PREFIX_."locations_delivery_type AS ld ON ld.id = a.id_delivery
			LEFT JOIN "._DB_PREFIX_."locations_cities AS lc ON lc.id = a.id_city
			LEFT JOIN "._DB_PREFIX_."locations_regions AS lr ON lr.id = a.id_region
			LEFT JOIN "._DB_PREFIX_."shipping_companies AS sc ON sc.id = a.id_delivery_service
			WHERE a.visible = 1 AND a.id_user = ".$id_user;
		if(!$res = $this->db->GetArray($sql)){
			return false;
		}
		return $res;
	}
	public function GetPrimaryAddress($id_user){
		$sql = "SELECT * FROM "._DB_PREFIX_."address
		WHERE `primary` = 1
		AND id_user = ".$id_user;
		if(!$res = $this->db->GetArray($sql)){
			return false;
		}
		return $res;
	}
	public function GetAddressById($id_address){
		$sql ="SELECT a.*, lr.title AS region_title, lc.title AS city_title,
			dt.title AS delivery_type_title, sc.title AS shipping_company_title
			FROM "._DB_PREFIX_."address AS a
			LEFT JOIN "._DB_PREFIX_."locations_cities AS lc
				ON lc.id = a.id_city
			LEFT JOIN "._DB_PREFIX_."locations_regions AS lr
				ON lr.id = a.id_region
			LEFT JOIN "._DB_PREFIX_."shipping_companies AS sc
				ON sc.id = a.id_delivery_service
			LEFT JOIN "._DB_PREFIX_."locations_delivery_type AS dt
				ON dt.id = a.id_delivery
			WHERE a.id = ".$id_address;
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res;
	}
	// Вывод адреса доставки в заказах
	public function getAddressOrder($id_order){
		$sql = "SELECT a.*, lr.title AS region, lc.title AS city, sc.title AS shipping_company, ld.title AS delivery
				FROM "._DB_PREFIX_."address a
				LEFT JOIN "._DB_PREFIX_."locations_delivery_type ld ON ld.id = a.id_delivery_service
				LEFT JOIN "._DB_PREFIX_."locations_cities lc ON lc.id = a.id_city
				LEFT JOIN "._DB_PREFIX_."locations_regions lr ON lr.id = a.id_region
				LEFT JOIN "._DB_PREFIX_."shipping_companies sc ON sc.id = a.id_delivery_service
				WHERE a.id = (SELECT id_address FROM "._DB_PREFIX_."order WHERE id_order = ".$id_order.")";
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res;
	}








	public function AddRegion($data){
		$f['title'] = $data['title'];
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'locations_regions', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id;
	}
	public function UpdateRegion($data){
		$f['title'] = $data['title'];
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_.'locations_regions', $f, 'id = '.$data['id'])){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	public function DeleteRegion($id){
		$sql = "DELETE FROM "._DB_PREFIX_."locations_regions WHERE id = ".$id;
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}
	public function GetRegionsList(){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."locations_regions AS lr";

		if(!$res = $this->db->GetArray($sql, 'id')){
			return false;

		}
		return $res;
	}
	public function GetRegionByTitle($title){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."locations_regions AS lr
			WHERE lr.title = ".$this->db->Quote($title);
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res;
	}
	/**
	 * [GetRegionById description]
	 * @param [type] $id [description]
	 */
	public function GetRegionById($id){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."locations_regions AS lr
			WHERE lr.id = ".$id;
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res;
	}





	public function AddCity($data){
		$f['title'] = $data['title'];
		$f['id_region'] = $data['id_region'];
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'locations_cities', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id;
	}
	public function UpdateCity($data){
		$f['title'] = $data['title'];
		$f['id_region'] = $data['id_region'];
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_.'locations_cities', $f, 'id = '.$data['id'])){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	public function DeleteCity($id){
		$sql = "DELETE FROM "._DB_PREFIX_."locations_cities WHERE id = ".$id;
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}
	public function GetCitiesList($region = false, $limit = false){
		$sql = "SELECT lc.*
			FROM "._DB_PREFIX_."locations_cities AS lc";
			if($region !== false){
			if(is_integer($region)){
				$sql .= " WHERE lc.id_region = ".$region;
			}else{
				$sql .= " LEFT JOIN "._DB_PREFIX_."locations_regions AS lr ON lr.id = lc.id_region
				WHERE lr.title = ".$this->db->Quote($region);
			}
		}
		if($limit){
			$sql .= ' LIMIT '.$limit;
		}
		if(!$res = $this->db->GetArray($sql, 'id')){
			return false;
		}
		return $res;
	}
	public function GetCityByTitle($title, $id_region = false){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."locations_cities AS lc
			WHERE lc.title = ".$this->db->Quote($title);
			if($id_region){
				$sql .= " AND lc.id_region = ".$id_region;
			}
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res;
	}
	public function GetCityById($id){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."locations_cities AS lc
			WHERE lc.id = ".$id;
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res;
	}







	public function AddWarehouse($data){
		$f['warehouse'] = $data['warehouse'];
		$f['id_city'] = $data['id_city'];
		$f['id_dealer'] = $data['id_dealer'];
		$f['id_shipping_company'] = $data['id_shipping_company'];
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'locations_warehouses', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id;
	}
	public function UpdateWarehouse($data){
		$f['warehouse'] = $data['warehouse'];
		$f['id_city'] = $data['id_city'];
		$f['id_dealer'] = $data['id_dealer'];
		$f['id_shipping_company'] = $data['id_shipping_company'];
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_.'locations_warehouses', $f, 'id = '.$data['id'])){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	public function DeleteWarehouse($id){
		$sql = "DELETE FROM "._DB_PREFIX_."locations_warehouses WHERE id = ".$id;
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}
	public function GetWarehouseById($id){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."locations_warehouses AS lw
			WHERE lw.id = ".$id;
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res;
	}
	public function GetWarehousesList($where = false, $limit = false){
		$sql = "SELECT lw.*
			FROM "._DB_PREFIX_."locations_warehouses AS lw";
		if(!empty($where)){
			$sql .= ' WHERE '.implode(' AND ', $where);
		}
		if($limit){
			$sql .= ' LIMIT '.$limit;
		}
		if(!$res = $this->db->GetArray($sql, 'id')){
			return false;
		}
		return $res;
	}






	public function AddShippingCompany($data){
		$f['title'] = $data['title'];
		$f['courier'] = $data['courier'];
		$f['has_api'] = $data['has_api'];
		$f['api_key'] = $data['api_key'];
		$f['api_prefix'] = $data['api_prefix'];
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'shipping_companies', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id;
	}
	public function UpdateShippingCompany($data){
		$f['title'] = $data['title'];
		$this->db->StartTrans();
		if(!$this->db->Update(_DB_PREFIX_.'shipping_companies', $f, 'id = '.$data['id'])){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	public function DeleteShippingCompany($id){
		$sql = "DELETE FROM "._DB_PREFIX_."shipping_companies WHERE id = ".$id;
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		return true;
	}
	public function GetShippingCompanyById($id){
		$sql = "SELECT *
			FROM "._DB_PREFIX_."shipping_companies AS sc
			WHERE sc.id = ".$id;
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res;
	}
	public function GetShippingCompaniesList($where = false, $limit = false){
		$sql = "SELECT sc.*
			FROM "._DB_PREFIX_."shipping_companies AS sc";
		if(!empty($where)){
			$sql .= ' WHERE '.implode(' AND ', $where);
		}
		if($limit){
			$sql .= ' LIMIT '.$limit;
		}
		if(!$res = $this->db->GetArray($sql, 'id')){
			return false;
		}
		return $res;
	}







	public function AddAddress($data){
		$f['title'] = $data['title'];
		$f['id_user'] = isset($data['id_user'])?$data['id_user']:$_SESSION['member']['id_user'];
		$f['id_region'] = $data['id_region'];
		$f['id_city'] = $data['id_city'];
		$f['id_delivery'] = $data['id_delivery'];
		$f['id_delivery_service'] = $data['id_delivery_service'];
		if(!empty($data['delivery_department'])){
			$f['delivery_department'] = $data['delivery_department'];
		}
		if(!empty($data['address'])){
			$f['address'] = $data['address'];
		}
		$this->db->StartTrans();
		if(!$this->db->Insert(_DB_PREFIX_.'address', $f)){
			$this->db->FailTrans();
			return false;
		}
		$id_address = $this->db->GetLastId();
		$this->db->CompleteTrans();
		return $id_address;
	}
	public function DeleteAddress($id){
		$sql = "SELECT COUNT(*) AS count FROM "._DB_PREFIX_."order
				WHERE id_address = ".$id." AND id_customer = ".$_SESSION['member']['id_user'];
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		if($res['count'] == 0){
			$sql = "DELETE FROM "._DB_PREFIX_."address WHERE id = ".$id;
		}else{
			$sql = "UPDATE "._DB_PREFIX_."address SET visible = 0 WHERE id = ".$id;
		}
		$this->db->StartTrans();
		$this->db->Query($sql) or G::DieLoger("<b>SQL Error - </b>$sql");
		$this->db->CompleteTrans();
		return true;
	}

	public function GetShippingCompanies($courier = false){
		$sql = "SELECT * FROM "._DB_PREFIX_."shipping_companies
			".($courier?'WHERE courier = 1':null);
		if(!$res = $this->db->GetArray($sql)){
			return false;
		}
		return $res;
	}
	public function getCity($company, $data){
		$warehouses = $this->getWarehouses($company, $data);
		if(empty($warehouses)){
			return false;
		}
		return $warehouses[0];
	}
	public function getWarehouses($company, $data){
		$sql = "SELECT id, id_city, warehouse AS name FROM "._DB_PREFIX_."locations_warehouses
			WHERE id_shipping_company = ".$company['id']."
			AND id_city = (SELECT lc.id FROM "._DB_PREFIX_."locations_cities AS lc WHERE lc.title = '".$data['city']."' AND lc.id_region = (SELECT lr.id FROM "._DB_PREFIX_."locations_regions AS lr WHERE lr.title = '".$data['region']."'))";
		if(!$res = $this->db->GetArray($sql)){
			return false;
		}
		return $res;
	}
	public function NonAPI($company, $function, $data = false){
		return $this->$function($company, $data);
	}
	public function UseAPI($company, $function, $data = false){
		$function = $company['api_prefix'].$function;
		return $this->$function($company, $data);
	}

	private function npgetCity($company, $data){
		$api = new NovaPoshtaApi2($company['api_key']);
		$city = $api->getCity($data['city'], $data['region']);
		if(!empty($city['data'][0])){
			return $city['data'][0];
		}
		return false;
	}
	private function npgetWarehouses($company, $data){
		$api = new NovaPoshtaApi2($company['api_key']);
		$warehouses = $api->getWarehouses($_POST['ref']);
		if(!empty($warehouses['data'][0])){
			foreach($warehouses['data'] as &$warehouse){
				$warehouse = array('id' => $warehouse['Ref'], 'name' => $warehouse['DescriptionRu']);
			}
			return $warehouses['data'];
		}
		return false;
	}

	private function itgetCity($company, $data){
		$key = explode(';', $company['api_key']);
		$api = new IntimeApi2($key[0], $key[1]);
		$city = $api->getSettlementCode($data['city'], $data['region']);
		if(!empty($city)){
			return array('Ref' => $city);
		}
		return false;
	}
	private function itgetWarehouses($company, $data){
		$key = explode(';', $company['api_key']);
		$api = new IntimeApi2($key[0], $key[1]);
		$warehouses = $api->getDepartmentsList($data['city'], $data['region']);
		if(!empty($warehouses)){
			foreach($warehouses as &$warehouse){
				$warehouse = array('id' => $warehouse['Code'], 'name' => '№'.$warehouse['AppendField'][10]['AppendFieldValue'].': '.$warehouse['AppendField'][0]['AppendFieldValue']);
			}
			asort($warehouses);
			return $warehouses;
		}
		return false;
	}

	private function delgetCity($company, $data){
		$key = explode(';', $company['api_key']);
		$api = new IntimeApi2($key[0], $key[1]);
		$city = $api->getSettlementCode($data['city'], $data['region']);
		if(!empty($city)){
			return array('Ref' => $city);
		}
		return false;
	}
	private function delgetWarehouses($company, $data){
		$key = explode(';', $company['api_key']);
		$api = new IntimeApi2($key[0], $key[1]);
		$warehouses = $api->getDepartmentsList($data['city']);
		if(!empty($warehouses)){
			foreach($warehouses as &$warehouse){
				$warehouse = array('id' => $warehouse['Code'], 'name' => '№'.$warehouse['AppendField'][10]['AppendFieldValue'].': '.$warehouse['AppendField'][0]['AppendFieldValue']);
			}
			asort($warehouses);
			return $warehouses;
		}
		return false;
	}

}
