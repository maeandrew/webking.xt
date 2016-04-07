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
	 * @param array $params массив дополнительных настроек (страница, фильтр, сортировка)
	 */
	public static function Category($rewrite, $params = array()){
		$str_filter = $str_sort = $str_page = $price_range = '';
		$clear = false;
		if(!isset($params['clear']) || $params['clear'] === false){
			// $filter = isset($GLOBALS['Filters'])?$GLOBALS['Filters']:array();
			if(isset($GLOBALS['Sort']) && $GLOBALS['Sort'] !== ''){
				$str_sort = 'sort='.$GLOBALS['Sort'];
			}
			if(isset($GLOBALS['Page_id']) && $GLOBALS['Page_id'] !== 1){
				$str_page = 'p'.$GLOBALS['Page_id'];
			}
			if(isset($GLOBALS['Price_range']) && $GLOBALS['Price_range'] !== ''){
				$price_range = 'price_range='.$GLOBALS['Price_range'][0].','.$GLOBALS['Price_range'][1];
			}
		}else{
			$clear = $params['clear'];
		}
		foreach($params as $key => $param){
			switch($key){
				case 'filters':
					$filter = $param;
					break;
				case 'filter':
					if(isset($filter[$param[0]])){
						if(in_array($param[1], $filter[$param[0]])){
							foreach($filter[$param[0]] as $key => $fil){
								if($param[1] == $fil){
									if(count($filter[$param[0]]) > 1){
										unset($filter[$param[0]][$key]);
									}else{
										unset($filter[$param[0]]);
									}
								}
							}
						}else{
							$filter[$param[0]][] = $param[1];
						}
					}else{
						$filter[$param[0]][] = $param[1];
					}
					break;
				case 'page':
					$str_page = '';
					if($param != 1) {
						$str_page = 'p'.$param;
					}
					break;
				case 'sort':
					$str_sort = 'sort='.$param;
					break;
				case 'price_range':
					$price_range = 'price_range='.$param;
					break;
			}
		}

		// if(isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == $rewrite) {
			if(isset($filter) && is_array($filter) && !empty($filter)){
				foreach($filter as $key => $filters){
					$str_filter .= ($str_filter !== '' ? ';' : '') . $key . "=" . implode(',', $filters);
				}
			}
		// }
		// if($clear){
		// 	return _base_url.'/'.$rewrite;
		// }
		return _base_url.'/'.$rewrite. ($str_filter ?  '/' . $str_filter : ''). ($price_range ? '/' . $price_range : '') . ($str_sort ?  '/' . $str_sort : '') . ($str_page ? '/' . $str_page : '');
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