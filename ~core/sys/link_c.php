<?php
/**
* Типизирование ссылок на сайте
*/
class Link {

	/**
	 * Генерация ссылки на товар
	 * @param string $rewrite идентификатор товара
	 */
	public static function Product($rewrite){
		return _base_url.'/'.$rewrite.'.html';
	}

	/**
	 * Генерация ссылки на раздел
	 * @param string $rewrite идентификатор раздела
	 */
	public static function Category($rewrite){
		return _base_url.'/'.$rewrite.'/';
	}

	/**
	 * Генерация ссылки на другие страницы
	 * @param string $controller идентификатор контроллера
	 * @param string $rewrite идентификатор статьи
	 */
	public static function Custom($controller, $rewrite = null){
		$controller = $controller=='main'?'':$controller;
		if(isset($rewrite)){
			$url = _base_url.'/'.$controller.'/'.$rewrite.'/';
		}else{
			$url = _base_url.'/'.$controller;
		}
		return $url;
	}

}?>