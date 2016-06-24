<?php
class Paginator{
	var $pages = array();
	// количество страниц
	var $pages_count;
	// номер текущей страницы
	var $active_page;
	// количество элементов, кот. необходимо разбить на страницы
	var $items_count;
	// Количество элементов на одной странице
	var $items_per_page;

	function __construct($active_page, $items_count, $items_per_page){
		// получаем кол-во элементов на одной странице
		$this->items_per_page = $items_per_page;
		// принимаем номер активной страницы
		$this->active_page = $active_page;
		// принимаем кол-во элементов, кот. необходимо разбить на страницы
		$this->items_count = $items_count;
		$this->CalcCntPage();
		if($this->pages_count > 5){
			if($this->active_page <= 4){
				$start = 1;
				$end = 5;
				$this->pages['next'] = $end+1;
				$this->pages['last'] = $this->pages_count;
			}elseif($this->pages_count - $this->active_page < 4){
				$start = $this->pages_count-4;
				$end = $this->pages_count;
				$this->pages['first'] = 1;
				$this->pages['prev'] = $start-1;
			}else{
				$start = $this->active_page-2;
				$end = $this->active_page+2;
				$this->pages['first'] = 1;
				$this->pages['last'] = $this->pages_count;

				$this->pages['prev'] = $start-1;
				$this->pages['next'] = $end+1;
			}
		}else{
			$start = 1;
			$end = $this->pages_count;
		}
		while($start <= $end){
			$this->pages[] = $start;
			$start++;
		}
		unset($start, $end);
	}
	/**
	 * получить активную страницу
	 */
	function GetPage(){
		return $this->active_page;
	}
	/**
	 * определяем количество страниц
	 */
	function CalcCntPage(){
		$this->pages_count = ceil($this->items_count/$this->items_per_page);
	}
	/**
	 * возвращает макет пагинации
	 */
	function ShowPages(){
		$tpl =& $GLOBALS['tpl'];
		// урл текущей страницы без page_id=N
		$res = explode("?", preg_replace('/\/p[0-9]+/', '', $_SERVER['REQUEST_URI']));
		$base_url = preg_replace('/\/$/', '', $res[0]);
		$get_string = isset($res[1])?$res[1]:null;
		$template = array();
		$pages = array();
		foreach($this->pages as $key=>$page){
			// Если числовые страницы
			// if(is_numeric($key)){
				if($this->active_page == $page){
					$pages['main'][] = '<li class="page'.$page.' active"><a href="#">'.$page.'</a></li>';
				}else{
					if(strstr($base_url, '/adm')){
						$url = $base_url.'/p'.$page;
					}else{
						if($GLOBALS['CurrentController'] == 'products'){
							$url = Link::Category($GLOBALS['Rewrite'], array('page' => $page));
						}else{
							$url = $base_url.'/p'.$page;
						}
					}
					$url .= isset($get_string)?'?'.$get_string:null;
					if(is_numeric($key)){
						$pages['main'][] = '<li class="page'.$page.'"><a href="'.$url.'" class="animate">'.$page.'</a></li>';
					}else{
						if(in_array($key, array('prev', 'next'))){
							$page = '<i class="material-icons">more_horiz</i>';
							if(strstr($base_url, '/adm')){
								$page = '...';
							}
						}
						$pages[$key] = '<li class="'.$key.'"><a href="'.$url.'" class="animate">'.$page.'</a></li>';
					}
				}
		}
		$tpl->Assign('pages', $pages);
		$parsed_content = $tpl->Parse($GLOBALS['PATH_tpl_global'].'paginator.tpl');
		// print_r(Link::Category($GLOBALS['Rewrite']));
		if(isset($GLOBALS['Rewrite'])){
			if($GLOBALS['CurrentController'] == 'products'){
				$page_base = Link::Category($GLOBALS['Rewrite']);
			}else{
				$page_base = Link::Custom($GLOBALS['CurrentController'], $GLOBALS['Rewrite']);
			}
			$GLOBALS['meta_canonical'] = Link::Category($GLOBALS['Rewrite']);
			if($this->pages_count > 1){
				$prev = Link::Category($GLOBALS['Rewrite'], array('page' => $this->active_page-1));
				$next = Link::Category($GLOBALS['Rewrite'], array('page' => $this->active_page+1));
				// $GLOBALS['meta_canonical'] = $page_base;
				if($this->active_page == 1){
					$GLOBALS['meta_next'] = $next;
					// $GLOBALS['meta_canonical'] = $page_base;
				}elseif($this->active_page == $this->pages_count){
					$GLOBALS['meta_prev'] = $prev;
				}else{
					if($this->active_page == 2){
						// $GLOBALS['meta_prev'] = $page_base;
					}else{
						$GLOBALS['meta_prev'] = $prev;
					}
					$GLOBALS['meta_next'] = $next;
				}
			}
		}
		// var_dump($GLOBALS['meta_canonical']);
		// print_r('<br>');
		// var_dump($GLOBALS['meta_next']);
		// print_r('<br>');
		// var_dump($GLOBALS['meta_prev']);
		// print_r('<br>');
		return $parsed_content;
	}
		//------------------------------------------------------------------------------
}?>