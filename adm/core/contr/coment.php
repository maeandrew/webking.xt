<?php
if(!_acl::isAllow('news')){
	die("Access denied");
}
$News = new News();

// если администратором был написан ответ к комментарию
if(isset($_POST['sub_com'])){
	$Products = new Products();
	$text = nl2br($_POST['feedback_text'], false);
	$text = stripslashes($text);
	$rating = isset($_POST['rating'])?$_POST['rating']:0;
	$pid_comment = isset($_POST['pid_comment'])?$_POST['pid_comment']:false;
	$author = $_SESSION['member']['id_user'];
	$author_name = $_SESSION['member']['name'];
	$authors_email = $_SESSION['member']['email'];
	$id_product = $_POST['url_coment'];
	$Products->SubmitProductComment($text, $author, $author_name, $authors_email, $id_product, $rating, $pid_comment, 1);
	header("Location: ".$_SERVER["HTTP_REFERER"]);
}

// ---- center ----
/*Pagination*/
if(isset($_GET['limit']) && is_numeric($_GET['limit'])){
	$GLOBALS['Limit_db'] = $_GET['limit'];
}
if((isset($_GET['limit']) && $_GET['limit'] != 'all')||(!isset($_GET['limit']))){
	if(isset($_POST['page_nbr']) && is_numeric($_POST['page_nbr'])){
		$_GET['page_id'] = $_POST['page_nbr'];
	}
	$News->SetListComment();
	$cnt = count($News->list);
	$tpl->Assign('cnt', $cnt);
	$GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
	$limit = ' LIMIT '.$GLOBALS['Start'].','.$GLOBALS['Limit_db'];
}else{
	$GLOBALS['Limit_db'] = 0;
	$limit = '';
}
unset($parsed_res);
$h1 = 'Вопросы по товару';
$tpl->Assign('h1', $h1);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = $h1;
// die('Ошибка при формировании списка новостей.');
if($News->SetListComment($limit)){
	$tpl->Assign('list', $News->list);
}
//$tpl->Assign('id_category', $id_category);
$pops1 = $News->GetComent();
$tpl->Assign('pops1', $pops1);
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_coment.tpl')
);
if(TRUE == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}
// ---- right ----
?>