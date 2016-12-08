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
		if(self::IsActivePromo() && !empty($Products->GetGiftsList($_SESSION['cart']['promo']))){
			return true;
		}
		return false;
	}
}