<?php
	unset($parsed_res);
	$Wishes = new Wishes();
	$Page = new Page();
	$Page->PagesList();
	$tpl->Assign('list_menu', $Page->list);
	$header = 'Пожелания и предложения';
	$GLOBALS['IERA_LINKS'][] = array(
		'title' => $header,
		'url' => _base_url.'/wishes/'
	);
	$tpl->Assign('header', $header);

	$WishesList = $Wishes->GetWishesList();
	if(!empty($WishesList)){
		$tpl->Assign('wishes', $WishesList);
	}

	// если отправили пожелание
	if(isset($_POST['sub_wis'])){
		if(isset($_SESSION['member']) && $_SESSION['member']['id_user'] != 4028){
			$arr['author'] = $_SESSION['member']['id_user'];
			$arr['author_name'] = $_SESSION['member']['name'];
		}else{
			$arr['author'] = 4028;
			$arr['author_name'] = $_POST['feedback_author'];
		}
		if(isset($_POST['id_reply'])){
			$arr['id_reply'] = $_POST['id_reply'];
		}
		$arr['author_email'] = $_POST['feedback_authors_email'];
		$text = nl2br($_POST['feedback_text'], false);
		$arr['text_wishes'] = stripslashes($text);
		$Wishes->AddWishes($arr);
		header('Location: '._base_url.'/wishes/');
		exit();
	}

	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_wishes.tpl')
	);
	if(true == $parsed_res['issuccess']){
		$tpl_center .= $parsed_res['html'];
	}
?>