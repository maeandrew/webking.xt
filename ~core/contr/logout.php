<?php
	if(G::IsLogged()){
		if(isset($_COOKIE['sm_login'])){
			setcookie('sm_login', '', time() - 30, "/");
		}
		G::Logout();
	}
	header('Location: '._base_url);
	exit();
?>