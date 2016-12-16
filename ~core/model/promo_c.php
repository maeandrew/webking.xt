<?
class promo {
	public $db;

	public function __construct(){
		$this->db = $GLOBALS['db'];
	}

	public static function IsActivePromo(){
		if(isset($_SESSION['cart']['promo'])){
			return true;
		}
		return false;
	}
	public static function HasGift(){
		// Чтобы Получить подарок по агентскому промо-коду, у клиента не должно быть ни одного заказа после активации привязки к агенту
		global $Products;
		if(self::IsActivePromo() && !empty($Products->GetGiftsList($_SESSION['cart']['promo']))){
			return true;
		}
		return false;
	}

	/**
	 * Добавление или удаление товаров к промокоду
	 * @param [type] $id_product
	 * @param [type] $promocode
	 * @param [type] $add     1/0
	 */
	public function TogglePromocodeGift($id_product, $promocode, $add){
		$f['id_product'] = $id_product;
		if(!$f['id_promo'] = $this->GetPromoIdByCode($promocode)){
			return false;
		}
		$this->db->StartTrans();
		if($add == 1){
			$result = $this->db->Insert(_DB_PREFIX_.'promo_gifts', $f);
		}else{
			$result = $this->db->DeleteRowsFrom(_DB_PREFIX_.'promo_gifts', array('id_promo = \''.$f['id_promo'].'\'', 'id_product = '.$f['id_product']));
		}
		if(!$result){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	public function GetPromoIdByCode($code){
		$sql = 'SELECT id FROM '._DB_PREFIX_.'promo_code
			WHERE code = "'.$code.'"';
		if(!$res = $this->db->GetOneRowArray($sql)){
			return false;
		}
		return $res['id'];
	}
}