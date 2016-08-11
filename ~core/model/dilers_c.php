<?php



class Dilers extends Users{



	/*

	public $db;



	public $fields;

	public $list;

	*/

	private $usual_fields;





	/** Конструктор

	 * @return

	 */

	public function __construct(){

		parent::__construct();

		$this->usual_fields = array("id_user");

	}



	

public function SetFieldsById($id, $all=0){



		global $Users;

		$Users->SetFieldsById($id, $all);

		

		$active = "AND active = 1";



		if ($all == 1){}

			$active = '';



		$id = mysql_real_escape_string($id);



		$sql = "SELECT ".implode(", ",$this->usual_fields)."

				FROM "._DB_PREFIX_."manager

				WHERE id_user = \"$id\"

				$active";



		$this->fields = $this->db->GetOneRowArray($sql);



		if (!$this->fields)

			return false;

		else{

			$this->fields = array_merge($this->fields, $Users->GetFields());

			return true;

		}

	}	

	

	

	

	

	

	

	/* Добавление

	 * 

	 */

	



	/* Обновление

	 * 

	 */

	

	

	public function GetOrders($order_by='o.target_date desc'){

		

		$id_contragent = $this->fields['id_user'];

		// *****************************************************************В работе

		$sql = "SELECT o.target_date, o.id_order, o.id_order_status, o.skey, SUM(osp.opt_sum+osp.mopt_sum) AS sum, 

				o.id_pretense_status, o.id_return_status, o.note,  u.name as name_customer, o.sum_discount, o.discount

				FROM "._DB_PREFIX_."order o, "._DB_PREFIX_."osp osp, "._DB_PREFIX_."user u

				WHERE o.id_order = osp.id_order



				AND o.id_order_status IN (1,6)

				AND o.id_customer = u.id_user

				GROUP BY id_order

				ORDER BY $order_by";

		

		$arr = $this->db->GetArray($sql);

		

		$date = time()+3600*24;

		$date2 = time()-3600*24*30;//echo time()-3600*24*10;

		// Выполненные за месяц

		$sql = "SELECT o.target_date, o.id_order, o.id_order_status, o.skey, SUM(osp.opt_sum+osp.mopt_sum) AS sum,

				o.id_pretense_status, o.id_return_status, o.note, u.name as name_customer, o.sum_discount, o.discount

				FROM "._DB_PREFIX_."order o, "._DB_PREFIX_."osp osp, "._DB_PREFIX_."user u

				WHERE o.id_order = osp.id_order

				

				AND o.target_date>\"$date2\"

				AND o.target_date<\"$date\"

				AND o.id_order_status IN (2,4,5)

				AND o.id_customer = u.id_user

				GROUP BY id_order

				ORDER BY $order_by";

		

		$arr2 = $this->db->GetArray($sql);

		if ($order_by == "o.id_order_status asc")

			$arr = array_merge($arr2, $arr);

		else

			$arr = array_merge($arr, $arr2);

			

		return $arr;

	}

	

	

	

	

	// Заполнение или обновление календаря контрагента

	

	

	

	

}

?>