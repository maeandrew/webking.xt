<?php

	if (G::IsLogged()){
		G::Logout();
		header('Location: '.$GLOBALS['URL_base'].'adm/');
    	exit();
	}

?>