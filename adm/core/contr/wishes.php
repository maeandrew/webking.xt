<?php
	if(!_acl::isAllow('wishes')){
		die("Access denied");
	}
	$Wishes = new Wishes();
	// ---- center ----
	unset($parsed_res);
	$tpl->Assign('h1', 'Пожелания и предложения');
	$ii = count($GLOBALS['IERA_LINKS']);
	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Пожелания и предложения";

	$WishesList = $Wishes->GetWishesList(true);
	if(!empty($WishesList)){
		$tpl->Assign('wishes', $WishesList);
	}

	// Отправка ответа
	if(isset($_POST['sub_wis'])){
		$arr['author'] = $_SESSION['member']['id_user'];
		$arr['author_name'] = $_SESSION['member']['name'];
		$arr['id_reply'] = $_POST['id_reply'];
		$arr['author_email'] = $_POST['feedback_authors_email'];
		$text = nl2br($_POST['feedback_text'], false);
		$arr['text_wishes'] = stripslashes($text);
		$arr['visible'] = 1;
		$Wishes->AddWishes($arr);
		header('Location: '._base_url.'/wishes/');
		exit();
	}

	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_wishes.tpl')
	);
	if(TRUE == $parsed_res['issuccess']){
		$tpl_center .= $parsed_res['html'];
	}
	// ---- right ----
?>