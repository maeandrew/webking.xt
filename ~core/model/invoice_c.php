<?php
class Invoice{
	public $fields;
	public $list;
	private $db;
	public function __construct (){
		$this->db =& $GLOBALS['db'];
	}

	public function GetOrderData($id_order){
		$and['o.id_order'] = $id_order;
		$sql = "SELECT (SELECT "._DB_PREFIX_."supplier.article FROM "._DB_PREFIX_."supplier WHERE "._DB_PREFIX_."supplier.id_user = osp.id_supplier_mopt) AS article_mopt,
			i.src AS image,
			o.id_order,
			o.id_order_status,
			o.id_pretense_status,
			o.id_return_status,
			o.note2,
			o.strachovka,
			o.sum_discount,
			o.target_date,
			osp.*,
			p.art,
			p.checked,
			p.img_1,
			p.inbox_qty,
			p.instruction,
			p.name,
			p.units,
			p.weight, p.volume,
			s.article,
			u.unit_xt AS unit
			FROM "._DB_PREFIX_."osp AS osp
				LEFT JOIN "._DB_PREFIX_."order o
					ON osp.id_order = o.id_order
				LEFT JOIN "._DB_PREFIX_."supplier AS s
					ON osp.id_supplier = s.id_user
				LEFT JOIN "._DB_PREFIX_."product AS p
					ON osp.id_product = p.id_product
				LEFT JOIN "._DB_PREFIX_."image AS i
					ON osp.id_product = i.id_product AND i.ord = 0 AND i.visible = 1
				LEFT JOIN "._DB_PREFIX_."units AS u
					ON u.id = p.id_unit
			".$this->db->GetWhere($and)."
			GROUP BY osp.id_order, osp.id_product, osp.id_supplier
			ORDER BY p.name";
		//print_r($sql);
		$arr = $this->db->GetArray($sql);
		if(empty($arr) == true){
			return false;
		}else{
			return $arr;
		}
	}

	public function GetOrderData_fakt($id_order, $filial = false){
		$and['o.id_order'] = $id_order;
		$sql = "SELECT (SELECT "._DB_PREFIX_."supplier.article FROM xt_supplier WHERE "._DB_PREFIX_."supplier.id_user = osp.id_supplier_mopt) AS article_mopt,
			s.article, p.name, o.id_order, p.art, o.id_order_status, osp.id_product, p.img_1, osp.site_price_opt, osp.site_price_mopt, p.inbox_qty, osp.box_qty,
			osp.opt_qty, osp.mopt_qty, osp.supplier_quantity_opt, osp.supplier_quantity_mopt, osp.opt_sum, osp.mopt_sum, o.strachovka, osp.id_supplier, osp.id_supplier_mopt, o.target_date,
			osp.contragent_qty, osp.contragent_mqty, osp.contragent_sum, osp.contragent_msum, osp.fact_qty, osp.fact_sum, osp.fact_mqty, osp.fact_msum,
			osp.return_qty, osp.return_sum, osp.return_mqty, osp.return_msum, o.id_pretense_status, o.id_return_status, p.weight, p.volume,
			osp.note_opt, osp.note_mopt, osp.contragent_qty, osp.contragent_mqty, osp.contragent_sum, osp.contragent_msum, i.src AS image
			FROM "._DB_PREFIX_."osp osp
			LEFT JOIN "._DB_PREFIX_."order o ON osp.id_order=o.id_order
			LEFT JOIN "._DB_PREFIX_."supplier s ON osp.id_supplier=s.id_user
			LEFT JOIN "._DB_PREFIX_."product p ON osp.id_product=p.id_product
			LEFT JOIN "._DB_PREFIX_."image AS i ON osp.id_product=i.id_product
				AND i.ord = 0 AND i.visible = 1
			".$this->db->GetWhere($and).
			" GROUP BY osp.id_order, osp.id_product, osp.id_supplier
			ORDER BY p.name";
		$arr = $this->db->GetArray($sql);
		if(empty($arr) == true){
			return false;
		}else{
			return $arr;
		}
	}

	public function GetOrderData_prise($id_order){
		$and['o.id_order'] = $id_order;
		$sql = "SELECT   (SELECT  "._DB_PREFIX_."supplier.article FROM xt_supplier WHERE "._DB_PREFIX_."supplier.id_user=osp.id_supplier_mopt) AS article_mopt,
			s.article, p.name, o.id_order, p.art, o.id_order_status, osp.id_product, p.img_1, p.inbox_qty, osp.box_qty, osp.opt_qty, osp.mopt_qty,
			osp.opt_sum, osp.mopt_sum, p.price_opt, p.price_mopt, o.target_date, p.weight, p.volume, osp.note_opt, osp.note_mopt
			FROM "._DB_PREFIX_."osp osp
			LEFT JOIN "._DB_PREFIX_."order o ON osp.id_order=o.id_order
			LEFT JOIN "._DB_PREFIX_."supplier s ON osp.id_supplier=s.id_user
			LEFT JOIN "._DB_PREFIX_."product p ON osp.id_product=p.id_product
			".$this->db->GetWhere($and)."
			GROUP BY osp.id_order, osp.id_product, osp.id_supplier
			ORDER BY p.name";
		$arr = $this->db->GetArray($sql) or G::DieLoger("SQL - error: $sql");
		return $arr;
	}

	public function GetOrderData_m_diler($id_order){
		$and['o.id_order'] = $id_order;
		$sql = "SELECT o.id_order, o.note2, o.note, o.target_date
			FROM  "._DB_PREFIX_."order o
			".$this->db->GetWhere($and)."
			GROUP BY o.id_order";
		$arr = $this->db->GetArray($sql) or G::DieLoger("SQL - error: $sql");
		return $arr;
	}

	public function GenCustomerInvoiceExcel(){
		if(!file_exists("invoice_customer1.xls")){
			exit("No template file.\n");
		}
		require($GLOBALS['PATH_sys'].'excel/Classes/PHPExcel.php');
		$objPHPExcel = PHPExcel_IOFactory::load($GLOBALS['PATH_root']."invoice_customer1.xls");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
		$objWriter->save($GLOBALS['PATH_root']."1234.htm");
		echo date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB\r\n";
	}

	public function GetSuppliersList($art){
		$sql = "SELECT p.art, p.name, u.name AS supp_name, s.article, s.place, s.phones, a.price_mopt_otpusk, a.price_opt_otpusk, a.active
			FROM "._DB_PREFIX_."assortiment AS a, "._DB_PREFIX_."user AS u, "._DB_PREFIX_."product AS p, "._DB_PREFIX_."supplier AS s
			WHERE p.art =\"$art\"
			AND p.id_product = a.id_product
			AND s.id_user = a.id_supplier
			AND s.id_user = u.id_user
			ORDER BY s.article";
		$arr = $this->db->GetArray($sql) or $arr = 0;
		return $arr;
	}

	public function GetSoldProductsListByKey($key){
		$sql = "SELECT osp.id_order, p.id_product, p.name, p.art,
			p.img_1, p.img_2, p.img_3, p.descr, p.inbox_qty,
			p.min_mopt_qty, p.qty_control, p.weight, p.height,
			p.width, p.length, p.coefficient_volume, p.volume,
			a.product_limit, a.price_opt_otpusk, a.price_opt_recommend,
			a.price_mopt_otpusk, a.price_mopt_recommend, a.inusd,
			a.price_mopt_otpusk_usd, a.price_opt_otpusk_usd,
			s.article,
			(SELECT u.unit_xt
			FROM "._DB_PREFIX_."units AS u
			WHERE p.id_unit = u.id) AS unit
			FROM "._DB_PREFIX_."osp AS osp
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON p.id_product = osp.id_product
			LEFT JOIN "._DB_PREFIX_."assortiment AS a
				ON (a.id_supplier = osp.id_supplier
					OR a.id_supplier = osp.id_supplier_mopt)
				AND p.id_product = a.id_product
			LEFT JOIN "._DB_PREFIX_."supplier AS s
				ON (s.id_user = osp.id_supplier
					OR s.id_user = osp.id_supplier_mopt)
			WHERE osp.note_opt LIKE '%".$key."%'
			OR osp.note_mopt LIKE '%".$key."%'
			ORDER BY p.id_product";
		$arr = $this->db->GetArray($sql) or $arr = 0;
		return $arr;
	}
}
?>