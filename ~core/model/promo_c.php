<?
class promo {

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
}