<?php
class pages{
	var $pages = array();
	var $cnt_pages;																		// количество страниц
	var $cur_page_id;																	// айдишник конкретной страницы
	var $cnt_rows;																		// количество всего записей, кот. необходимо разбить на страницы
	//------------------------------------------------------------------------------- constructor
	function pages($page_id, $cnt_rows){												// приходит какую страницу отображать и скоко всего записей, кот. необходимо разбить на страницы
		$this->cur_page_id = $page_id;
		$this->cnt_rows = $cnt_rows;
		$this->CalcCntPage();
		if($this->cur_page_id > $this->cnt_pages){
			$_GET['page_id'] = $this->cur_page_id = ceil($this->cnt_pages);
		}
		$ii = 0;
		if($this->cnt_pages > 5){
			if($this->cur_page_id <= 4){
				$con1 = 1;
				$con2 = 5;
				$this->pages['last'] = $this->cnt_pages;
				$this->pages['np'] = $con2+1;
			}elseif($this->cnt_pages - $this->cur_page_id < 4){
				$con1 = $this->cnt_pages-4;
				$con2 = $this->cnt_pages;
				$this->pages['first'] = 1;
				$this->pages['lp'] = $con1-1;
			}else{

				$con1 = $this->cur_page_id-2;
				$con2 = $this->cur_page_id+2;
				$this->pages['first'] = 1;
				$this->pages['last'] = $this->cnt_pages;

				$this->pages['lp'] = $con1-1;
				$this->pages['np'] = $con2+1;
			}
		}else{
			$con1 = 1;
			$con2 = $this->cnt_pages;
		}
		for( ; $con1 <= $con2 ; $con1++){
			if($con1 <= $this->cnt_pages+1){
				$this->pages[] = $con1;
			}
		}
	}
	//------------------------------------------------------------------------------
	function GetPage(){
		return $this->cur_page_id;
	}
	//------------------------------------------------------------------------------
	function CalcCntPage(){
		$this->cnt_pages = $this->cnt_rows/$GLOBALS['Limit_db'];
		$this->cnt_pages = ceil($this->cnt_pages);
		// количество страниц равно количеству строк разделить на количество на одной странице
	}
	//------------------------------------------------------------------------------
	//------------------------------------------------------------------------------
	function ShowPages(){																// выводит всю строку страниц
		$URL_TMP = preg_replace("#/p[\d]+#is", '', $GLOBALS['URL_request']);			// урл текущей страницы без page_id=N
		$string_array = explode("?", $URL_TMP);
		$URL_TMP = $string_array[0]; // строка после вопросительного знака
		$URL_TMP = preg_replace("#/$#is", '', $URL_TMP);
		$tpl =& $GLOBALS['tpl'];
		$name = array();
		foreach($this->pages as $key=>$title){
			if(is_numeric($key)){														// для исключения пред. и следующ
				if($this->cur_page_id != $title){
					if(strstr($URL_TMP, '/adm')) {
						$url = $URL_TMP.'/p'.$title.'/';
					}else{
						$url = Link::Category($GLOBALS['Rewrite'], array('page' => $title));
					}
					isset($string_array[1])?$url .= '?'.$string_array[1]:null;
					//$name[] =  '<a class="page" href='.$url.'>'.$title.'</a>';
					$name[] = '<li class="page'.$title.'"><a href="'.$url.'" class="animate bg-white color-grey">'.$title.'</a></li>';
				}else{
					$name[] = '<li class="page'.$title.' active"><a href="#">'.$title.'</a></li>';
				}
			}else{
				if($title == '/p1/'){
					$this->pages[$key] = '/';
				}
			}
		}// end foreach
		$tpl->Assign('PAGE', $name);

		$p = (strstr($URL_TMP, '/adm')?'/p':'');
		if(isset($this->pages['lp'])){
			$tpl->Assign('LP', 'more_horiz');
			isset($string_array[1])?$this->pages['lp'] .= '?'.$string_array[1]:null;
			$tpl->Assign('URL_LP', $URL_TMP.$p.$this->pages['lp']);
		}
		if(isset($this->pages['np'])){
			$tpl->Assign('NP', 'more_horiz');
			isset($string_array[1])?$this->pages['np'] .= '?'.$string_array[1]:null;
			$tpl->Assign('URL_NP', $URL_TMP.$p.$this->pages['np']);
		}
		if(isset($this->pages['first'])){
			$tpl->Assign('FIRST', 1);
			isset($string_array[1])?$this->pages['first'] .= '?'.$string_array[1]:null;
			$tpl->Assign('URL_FIRST', $URL_TMP.$p.$this->pages['first']);
		}
		if(isset($this->pages['last'])){
			$tpl->Assign('LAST', $this->cnt_pages);
			isset($string_array[1])?$this->pages['last'] .= '?'.$string_array[1]:null;
			$tpl->Assign('URL_LAST', $URL_TMP.$p.$this->pages['last']);
		}
		$parsed_content = $tpl->Parse($GLOBALS['PATH_tpl'].'pages.tpl');

		// $page_base = 'http://'.$_SERVER['HTTP_HOST'].$URL_TMP.'/';
		if($GLOBALS['CurrentController'] == 'products'){
			$page_base = Link::Category($GLOBALS['Rewrite']);
		}else{
			$page_base = Link::Custom($GLOBALS['CurrentController'], $GLOBALS['Rewrite']);
		}
		if($this->cnt_pages > 1){
			$prev = $page_base.'p'.($this->cur_page_id-1).'/';
			$next = $page_base.'p'.($this->cur_page_id+1).'/';
			$GLOBALS['meta_canonical'] = $page_base.'p'.$this->cur_page_id.'/';
			if($this->cur_page_id == 1){
				$GLOBALS['meta_next'] = $next;
				$GLOBALS['meta_canonical'] = $page_base;
			}elseif($this->cur_page_id == $this->cnt_pages){
				$GLOBALS['meta_prev'] = $prev;
			}else{
				if($this->cur_page_id == 2){
					$GLOBALS['meta_prev'] = $page_base;
				}else{
					$GLOBALS['meta_prev'] = $prev;					
				}
				$GLOBALS['meta_next'] = $next;
			}
		}else{
			$GLOBALS['meta_canonical'] = $page_base;
		}

		//$GLOBALS['page_count'] = $this->pages['last'];
		//print_r($this->pages[2]);
//		print_r($parsed_content); die();
		return $parsed_content;
	}
		//------------------------------------------------------------------------------
}?>