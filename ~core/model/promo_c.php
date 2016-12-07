<?
class promo {

	public static function IsActivePromo(){
		if(isset($_SESSION['cart']['promo'])){
			return true;
		}
		return false;
	}
	public static function HasGift(){
		global $Products;
		// $_SESSION['cart']['promo']
		if(self::IsActivePromo() && !empty($Products->GetGiftsList())){
			return true;
		}
		return false;
	}
}