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
	public static function Category($rewrite, $params = array()){
		$str_filter = '';
		if($GLOBALS['Rewrite'] ==  $rewrite) {
			if (isset($GLOBALS['Filters']) && !empty($GLOBALS['Filters'])) {

				foreach ($GLOBALS['Filters'] as $key => $filters) {
					$str_filter .= ($str_filter !== '' ? ';' : '') . $key . "=" . implode(',', $filters);
				}
			}
		}
		$str_page = '';
		if(isset($GLOBALS['Page_id']) && $GLOBALS['Page_id'] !== 1){
			$str_page = 'p='.$GLOBALS['Page_id'];
		}

		foreach($params as $key => $param){
			switch ($key) {
				case 'filter': ;
					break;
				case 'page': $str_page = 'p'.$param;
					break;
				case 'sort': ;
					break;
			}
		}

		return _base_url.'/'.$rewrite.'/'.$str_filter.'/'.$str_page;
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