<?php







	$success = false;







	if (isset($GLOBALS['REQAR'][1])){

		$Page = new Page();

		$Page->PagesList();

		$tpl->Assign('list_menu', $Page->list);

	}else{

		header('Location: '. _base_url.'/404/');

		exit();

	}



	unset($parsed_res);






if (isset($GLOBALS['REQAR'][1])){

    	if ($id_user1 = $Users->CheckPwdChangeKey1($GLOBALS['REQAR'][1])){



	    	$success = 'changed';





    	}else{

    		$tpl->Assign('msg', 'Неправильный адрес. Попробуйте скопировать адрес из письма приглашения более точно.');

            $tpl->Assign('errm', 1);

    	}

	}





	if ($success == 'changed'){

		$tpl->Assign('msg', "Ваш E-mail был удален из базы почтовой рассылки. Если Вы захотите возобновить рассылку - откоректируйте пожалуйста свои данные в личном кабинете");

		$parsed_res = array('issuccess' => TRUE,

 							'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl'));

	}else{

		$parsed_res = array('issuccess' => TRUE,

 							'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_remind1.tpl'));

	}



	if (TRUE == $parsed_res['issuccess']) {

		$tpl_center .= $parsed_res['html'];



	}



?>