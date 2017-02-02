<?php

/** Проверка формы добавления страницы
 * @param array $_POST
 * @return bool, array
 */

function Page_form_validate(){
	$errm = array();
	$err=0;

	$varname = 'id_page';
	if (isset($_POST[$varname])){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'IsInt'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Не выбрана страница.";
		$err=1;
	}

	$varname = 'title';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}
	$varname = 'editor';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>0, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Страница должна содержать текст.";
		$err=1;
	}
	return array($err, $errm);
}

function User_form_validate($nocheck=array()){
	$errm = array();
	$err=0;
	$varname = 'id_user';
	if (!in_array($varname, $nocheck))
	if (isset($_POST[$varname])){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'IsInt'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Пользователь не выбран.";
		$err=1;
	}

	$varname = 'email';
	if (!in_array($varname, $nocheck))
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_email'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	$varname = 'phone';
	if (!in_array($varname, $nocheck))
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>10, 'Lmax'=>12, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	$varname = 'passwd';
	if (!in_array($varname, $nocheck))
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>4, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Пользователю должен быть назначен пароль.";
		$err=1;
	}

	$varname = 'name';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>0, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Пользователь должен иметь имя.";
		$err=1;
	}


	return array($err, $errm);
}

function Contragent_form_validate($nocheck=array()){
	$errm = array();
	$err=0;

	$varname = 'id_user';
	if (isset($_POST[$varname])){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'IsInt'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Пользователь не выбран.";
		$err=1;
	}

	$varname = 'email';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_email'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	$varname = 'passwd';
	if (!in_array($varname, $nocheck))
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>4, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Пользователю должен быть назначен пароль.";
		$err=1;
	}

	$varname = 'name';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>0, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Пользователь должен иметь имя.";
		$err=1;
	}

	$varname = 'site';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>0, 'PM_url'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}

	return array($err, $errm);
}

function Supplier_form_validate($nocheck=array()){
	$errm = array();
	$err=0;

	$varname = 'id_user';
	if (isset($_POST[$varname])){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'IsInt'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Пользователь не выбран.";
		$err=1;
	}

	$varname = 'email';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_email'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	$varname = 'passwd';
	if (!in_array($varname, $nocheck))
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>4, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Пользователю должен быть назначен пароль.";
		$err=1;
	}

	$varname = 'name';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>0, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Пользователь должен иметь имя.";
		$err=1;
	}

	$varname = 'currency_rate';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>0, 'IsFloat'=>1);
		$_POST[$varname] = str_ireplace(",", ".", $_POST[$varname]);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}

	return array($err, $errm);
}

function Parser_site_form_validate($nocheck=array()){
	$errm = array();
	$err=0;

	$varname = 'title';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_glob'=>1);
		$_POST[$varname] = str_ireplace(",", ".", $_POST[$varname]);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}
	return array($err, $errm);
}
function Cat_form_validate(){
	$errm = array();
	$err=0;

	$varname = 'pid';
	if (isset($_POST[$varname])){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'IsInt'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Не выбрана категория-предок.";
		$err=1;
	}

	$varname = 'name';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	return array($err, $errm);
}

function Product_form_validate(){
	$errm = array();
	$err=0;

	$varname = 'categories_ids';
	if (isset($_POST[$varname]) && count($_POST[$varname])){

		foreach ($_POST[$varname] as &$id){
			if ($id != 0){
				$flag = true;
			}
		}
		if(isset($flag)){
			foreach ($_POST[$varname] as &$id){
				$id = trim($id);
				$carr = array('Lmin'=>1, 'IsInt'=>1);
				list($errf, $errmsg) = G::CheckV($id, $carr);
				if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
			}
		}else{
			$errm[$varname] = "Не выбрана категория.";
			$err=1;
		}

	}else{
		$errm[$varname] = "Не выбрана категория.";
		$err=1;
	}

	$varname = 'name';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	/*$varname = 'descr';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	$varname = 'country';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	$varname = 'units';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}*/

	// $varname = 'price_opt';
	// if (isset($_POST[$varname])){
	// 	$_POST[$varname] = trim($_POST[$varname]);
	// 	$carr = array('Lmax'=>10, 'IsFloat'=>1);
	// 	$_POST[$varname] = str_ireplace(",", ".", $_POST[$varname]);
	// 	list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
	// 	if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	// }else{
	// 	$errm[$varname] = "Поле обязательно для заполнения.";
	// 	$err=1;
	// }

	// $varname = 'price_mopt';
	// if (isset($_POST[$varname])){
	// 	$_POST[$varname] = trim($_POST[$varname]);
	// 	$carr = array('Lmax'=>10, 'IsFloat'=>1);
	// 	$_POST[$varname] = str_ireplace(",", ".", $_POST[$varname]);
	// 	list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
	// 	if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	// }else{
	// 	$errm[$varname] = "Поле обязательно для заполнения.";
	// 	$err=1;
	// }

	$varname = 'inbox_qty';
	if (isset($_POST[$varname])){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmax'=>8, 'IsInt'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	$varname = 'min_mopt_qty';
	if (isset($_POST[$varname])){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmax'=>7, 'IsInt'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	// $varname = 'weight';
	// if (isset($_POST[$varname])){
	// 	$_POST[$varname] = trim($_POST[$varname]);
	// 	$carr = array('Lmax'=>10, 'IsFloat'=>1);
	// 	$_POST[$varname] = str_ireplace(",", ".", $_POST[$varname]);
	// 	list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
	// 	if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	// }else{
	// 	$errm[$varname] = "Поле обязательно для заполнения.";
	// 	$err=1;
	// }

	$varname = 'volume';
	if (isset($_POST[$varname])){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmax'=>10, 'IsFloat'=>1);
		$_POST[$varname] = str_ireplace(",", ".", $_POST[$varname]);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	// $varname = 'max_supplier_qty';
	// if (isset($_POST[$varname])){
	// 	$_POST[$varname] = trim($_POST[$varname]);
	// 	$carr = array('Lmax'=>10, 'IsInt'=>1);
	// 	list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
	// 	if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	// }else{
	// 	$errm[$varname] = "Поле обязательно для заполнения.";
	// 	$err=1;
	// }

	// $varname = 'price_coefficient_opt';
	// if (isset($_POST[$varname])){
	// 	$_POST[$varname] = str_replace(",", ".", trim($_POST[$varname]));
	// 	$carr = array('Lmax'=>6, 'IsFloat'=>1);
	// 	$_POST[$varname] = str_ireplace(",", ".", $_POST[$varname]);
	// 	list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
	// 	if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	// }else{
	// 	$errm[$varname] = "Поле обязательно для заполнения.";
	// 	$err=1;
	// }

	// $varname = 'price_coefficient_mopt';
	// if (isset($_POST[$varname])){
	// 	$_POST[$varname] = str_replace(",", ".", trim($_POST[$varname]));
	// 	$carr = array('Lmax'=>6, 'IsFloat'=>1);
	// 	$_POST[$varname] = str_ireplace(",", ".", $_POST[$varname]);
	// 	list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
	// 	if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	// }else{
	// 	$errm[$varname] = "Поле обязательно для заполнения.";
	// 	$err=1;
	// }

	// $varname = 'manufacturer_id';
	// if (isset($_POST[$varname])){
	// 	$_POST[$varname] = trim($_POST[$varname]);
	// 	$carr = array('Lmax'=>10, 'IsInt'=>1);
	// 	list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
	// 	if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	// }else{
	// 	$errm[$varname] = "Поле обязательно для заполнения.";
	// 	$err=1;
	// }

	return array($err, $errm);
}

function Manufacturer_form_validate(){
	$errm = array();
	$err=0;

	$varname = 'manufacturer_id';
	if (isset($_POST[$varname])){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'IsInt'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Не выбран производитель.";
		$err=1;
	}

	$varname = 'name';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	return array($err, $errm);
}

function News_form_validate(){
	$errm = array();
	$err=0;

	$varname = 'id_news';
	if (isset($_POST[$varname])){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'IsInt'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Не выбрана новость.";
		$err=1;
	}

	$varname = 'title';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	$varname = 'descr_short';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>0, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	$varname = 'descr_full';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>0, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	$varname = 'date';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>0, 'PM_date'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	return array($err, $errm);
}

function Post_form_validate(){
	$errm  = array();
	$err = 0;

	$varname = 'id';
	if (isset($_POST[$varname])){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'IsInt'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Не выбрана статья.";
		$err = 1;
	}

	$varname = 'title';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err = 1;
	}

	$varname = 'content_preview';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>0, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err = 1;
	}

	$varname = 'content';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>0, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err = 1;
	}

	$varname = 'date';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>0, 'PM_date'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err = 1;
	}
	return array($err, $errm);
}

function City_form_validate(){
	$errm = array();
	$err=0;

	$varname = 'id_region';
	if (isset($_POST[$varname])){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'IsInt'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Не выбрана область.";
		$err = 1;
	}

	$varname = 'title';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	return array($err, $errm);
}

function Warehouse_form_validate(){
	$errm = array();
	$err=0;

	$varname = 'id_city';
	if (isset($_POST[$varname])){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'IsInt'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Не выбрана область.";
		$err = 1;
	}

	$varname = 'id_shipping_company';
	if (isset($_POST[$varname])){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'IsInt'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Не выбрана область.";
		$err = 1;
	}

	$varname = 'id_dealer';
	if (isset($_POST[$varname])){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'IsInt'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Не выбрана область.";
		$err = 1;
	}

	$varname = 'warehouse';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	return array($err, $errm);
}

function Specification_form_validate(){
	$errm = array();
	$err=0;

	$varname = 'id';
	if (isset($_POST[$varname])){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'IsInt'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Не выбран id.";
		$err=1;
	}

	$varname = 'caption';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	$varname = 'name';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}
}

function Unit_form_validate(){
	$errm = array();
	$err=0;

	$varname = 'id';
	if (isset($_POST[$varname])){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'IsInt'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Не выбран id.";
		$err=1;
	}

	$varname = 'unit_xt';
	if(isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	$varname = 'unit_prom';
	if(isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}
}

function Parking_form_validate(){
	$errm = array();
	$err=0;

	$varname = 'id_parking';
	if (isset($_POST[$varname])){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'IsInt'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Не выбран id.";
		$err=1;
	}

	$varname = 'name';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	return array($err, $errm);
}

function Region_form_validate(){
	$errm = array();
	$err=0;

	$varname = 'title';
	if(isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	return array($err, $errm);
}

function Shipping_companies_form_validate(){
	$errm = array();
	$err=0;

	$varname = 'title';
	if(isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	return array($err, $errm);
}






function DeliveryService_form_validate(){
	$errm = array();
	$err=0;

	$varname = 'id_delivery_service';
	if (isset($_POST[$varname])){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'IsInt'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Не выбран id.";
		$err=1;
	}

	$varname = 'name';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	return array($err, $errm);
}

function Delivery_form_validate(){
	$errm = array();
	$err=0;

	$varname = 'id_delivery';
	if (isset($_POST[$varname])){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'IsInt'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Не выбран id.";
		$err=1;
	}

	$varname = 'name';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	return array($err, $errm);
}

function Config_form_validate(){
	$errm = array();
	$err=0;

	$varname = 'id_config';
	if (isset($_POST[$varname])){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'IsInt'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Не выбран id.";
		$err=1;
	}

	$varname = 'name';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	$varname = 'caption';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	$varname = 'value';
	$_POST[$varname] = trim($_POST[$varname]);
	$carr = array('Lmin'=>0, 'Lmax'=>400000, 'PM_glob'=>1);
	list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
	if (!$errf){ $errm[$varname] = $errmsg; $err=1;}

	return array($err, $errm);
}

function Customer_form_validate($nocheck=array()){
	$errm = array();
	$err=0;

	$varname = 'email';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>1, 'Lmax'=>255, 'PM_email'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	$varname = 'passwd';
	if (!in_array($varname, $nocheck))
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>4, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Пользователю должен быть назначен пароль.";
		$err=1;
	}

	$varname = 'name';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>0, 'Lmax'=>255, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	$varname = 'descr';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>0, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	$varname = 'address_ur';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>0, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	$varname = 'cont_person';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>0, 'Lmax'=>255, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	$varname = 'phones';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$carr = array('Lmin'=>0, 'PM_glob'=>1);
		list($errf, $errmsg) = G::CheckV($_POST[$varname], $carr);
		if (!$errf){ $errm[$varname] = $errmsg; $err=1;}
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err=1;
	}

	return array($err, $errm);
}

function Seotext_form_validate(){
	$errm = array();
	$err = 0;

	$varname = 'url';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
		$Seo = new Seo();
		if(!$GLOBALS['CurrentController'] == 'seotextedit' && $Seo->SetFieldsByUrl($_POST[$varname] === false)){
			$errm[$varname] = "Такой URL уже есть в базе.";
			$err = 1;
		};
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err = 1;
	}

	$varname = 'text';
	if (isset($_POST[$varname]) && $_POST[$varname]){
		$_POST[$varname] = trim($_POST[$varname]);
	}else{
		$errm[$varname] = "Поле обязательно для заполнения.";
		$err = 1;
	}

	$varname = 'visible';
	if (isset($_POST[$varname])){
		$_POST[$varname] = 1;
	}else{
		$_POST[$varname] = 0;
	}

	return array($err, $errm);
}