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
		$str_page = '';
		$filter = $GLOBALS['Filters'];
		if(isset($GLOBALS['Page_id']) && $GLOBALS['Page_id'] !== 1){
			$str_page = 'p'.$GLOBALS['Page_id'];
		}

		foreach($params as $key => $param){
			switch ($key) {
				case 'filter':

					if(isset($filter[$param[0]])){
						foreach($filter[$param[0]] as $key => $fil){
							if($param[1] == $fil) {
								if(count($filter[$param[0]]) > 1){
									unset($filter[$param[0]][$key]);
								}else{
									unset($filter[$param[0]]);
								}

							}else{
								$filter[$param[0]][] = $param[1];
							}
						}
					}else{
						$filter[$param[0]][] = $param[1];
					}

					break;
				case 'page': $str_page = 'p'.$param;
					break;
				case 'sort': ;
					break;
			}
		}

		if(isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == $rewrite) {
			if (isset($filter) && !empty($filter)) {

				foreach ($filter as $key => $filters) {
					$str_filter .= ($str_filter !== '' ? ';' : '') . $key . "=" . implode(',', $filters);
				}
			}
		}

		return _base_url.'/'.$rewrite. ($str_filter ?  '/' . $str_filter : '')  . ($str_page ? '/' . $str_page : '');
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