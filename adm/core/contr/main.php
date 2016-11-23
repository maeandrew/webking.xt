<?php
if(!_acl::isAllow('admin_panel')){
	die("Access denied");
}
if($_SESSION['member']['gid'] == _ACL_REMOTE_CONTENT_){
	header('Location: /adm/productadd/');
	exit;
}
$Page = new Page();
$Products = new Products();
if(isset($_POST['name_index_status'])){
	require_once($GLOBALS['PATH_model'].'morphy.functions.php');
	$count = $Products->GetCountNameIndex();
	$total = 0;
	foreach($count as $value){
		$i = $value['id_product'];
		$name = $Products->GetName($i);
		$name_index = Words2BaseForm($name);
		$Products->Morphy($i, $name_index);
		$total++;
	}
	echo "<script>alert('Обработано записей: ".$total.".');window.location.replace('".$GLOBALS['URL_base']."adm');</script>";
}
// Пересчитать цены поставщиков по новому курсу
if(isset($_POST['kurs']) && isset($_POST['kurs_griwni'])){
	if($Products->UpdatePriceSupplierAssortiment($_POST['kurs_griwni'])){
		echo "<script>alert('Цены пересчитаны');window.location.replace('".$GLOBALS['URL_base']."adm');</script>";
	}else{
		echo "<script>alert('Что-то пошло не так');</script>";
	}
}

if(isset($GLOBALS['REQAR'][1]) && $GLOBALS['REQAR'][1] == 'random_seo_text'){
	$Seo = new Seo();
	if($Seo->productSeotext((int) $_POST['quantity'])){
		echo "<script>alert('Тексты установлены');window.location.replace('".$GLOBALS['URL_base']."adm');</script>";
	}else{
		echo "<script>alert('Что-то пошло не так');</script>";
	}
}
// пересчитать все цены поставщиков
if(isset($GLOBALS['REQAR'][1]) && $GLOBALS['REQAR'][1] == 'recalc_product_prices'){
	if($Products->UpdatePriceRecommendAssortment()){
		echo "<script>alert('Цены пересчитаны');window.location.replace('".$GLOBALS['URL_base']."adm');</script>";
	}else{
		echo "<script>alert('Что-то пошло не так');</script>";
	}
}
if(isset($GLOBALS['REQAR'][1]) && $GLOBALS['REQAR'][1] == 'recalc_null'){
	$db->StartTrans();
	$Products->Re_null();
	$db->CompleteTrans();
	echo "<script>alert('Нули удалены');window.location.replace('".$GLOBALS['URL_base']."adm');</script>";
}
if(isset($_POST['smb']) && isset($_POST['date'])){
	$Order = new Orders();
	$date = mysql_real_escape_string($_POST['date']);
	if($Order->ClearDB($date)){
		echo "<script>alert('База очищена');window.location.replace('".$GLOBALS['URL_base']."adm');</script>";
	}else{
		echo "<script>alert('Возникли проблемы при очистке базы.');</script>";
	}
}elseif(isset($_POST['update_statuses'])){
	$Status = new Status();
	if($Status->UpdateStatuses()){
		echo "<script>alert('Статусы обновлены');window.location.replace('".$GLOBALS['URL_base']."adm');</script>";
	}else{
		echo "<script>alert('Возникли проблемы при обновлении статусов.');</script>";
	}
}elseif(isset($_POST['update_statuses_hit'])){
	$Status = new Status();
	if($Status->UpdateStatuses_Hit()){
		echo "<script>alert('Статусы обновлены');window.location.replace('".$GLOBALS['URL_base']."adm');</script>";
	}else{
		echo "<script>alert('Возникли проблемы при обновлении статусов.');</script>";
	}
}elseif(isset($_POST['update_popular'])){
	$Status = new Status();
	if($Status->UpdateStatuses_Popular()){
		echo "<script>alert('Статусы обновлены');window.location.replace('".$GLOBALS['URL_base']."adm');</script>";
	}else{
		echo "<script>alert('Возникли проблемы при обновлении статусов.');</script>";
	}
}elseif(isset($_POST['update_prodazi'])){
	$Status = new Status();
	if($Status->UpdateProductsPopularity()){
		echo "<script>alert('Статусы обновлены');window.location.replace('".$GLOBALS['URL_base']."adm');</script>";
	}else{
		echo "<script>alert('Возникли проблемы при обновлении статусов.');</script>";
	}
}elseif(isset($_POST['sitemap'])){
	if($res === false){
		echo "<script>alert('Возникли проблемы при генерации карты сайта.');</script>";
	} else if($res = G::SiteMap($_POST['sitemap']=='all'?null:$_POST['sitemap'])){
		$tpl->Assign('sitemap_files', $res);
	}
}
// генерация уменьшенных изображений товаров
if(isset($GLOBALS['REQAR'][1]) && $GLOBALS['REQAR'][1] == 'gen_resize_product_images'){
	$images_limit = 100000;
	if(isset($GLOBALS['REQAR'][2]) && is_numeric($GLOBALS['REQAR'][2])){
		$images_limit = $GLOBALS['REQAR'][2];
	}
	set_time_limit(60);
	require($GLOBALS['PATH_sys'].'img_c.php');
	$ii = 0;
	$aa = 0;
	$bb = 0;
	foreach(glob($GLOBALS['PATH_root'].'../efiles/image/'."*.jpg") as $filepath){
		$filename = preg_replace("#^(.*)/(.*?)$#is", "\$2", $filepath);
		if(!is_file($GLOBALS['PATH_root'].'../efiles/_thumb/image/'.$filename)){
			$a = new img(120, 90);
			$a->GenFileInfo($filepath);
			$a->target = 'save';
			$a->change($GLOBALS['PATH_root'].'../efiles/_thumb/image/'.$filename);
			unset($a);
			//echo "$filename - ok<br>";
			$aa++;
		}
		if(!is_file($GLOBALS['PATH_root'].'../efiles/image/500/'.$filename)){
			$i = new img(250, 250);
			$i->GenFileInfo($filepath);
			$i->target='save';
			$i->change($GLOBALS['PATH_root'].'../efiles/image/500/'.$filename);
			unset($i);
			//echo "$filename - ok<br>";
			$ii++;
		}
		if(!is_file($GLOBALS['PATH_root'].'../efiles/image/500/'.$filename)){
			$b = new img(500, 500);
			$b->GenFileInfo($filepath);
			$b->target='save';
			$b->change($GLOBALS['PATH_root'].'../efiles/image/500/'.$filename);
			unset($b);
			//echo "$filename - ok<br>";
			$bb++;
		}
		if($ii >= $images_limit) break;
		if($aa >= $images_limit) break;
		if($bb >= $images_limit) break;
	}
	echo "<script>alert('Сгенерировано изображений: 120x90 - ".$aa.", 250x250 - ".$ii.", 500x500 - ".$bb."');window.location.replace('".$GLOBALS['URL_base']."adm');</script>";
}
// генерация уменьшенных изображений товаров
if(isset($GLOBALS['REQAR'][1]) && $GLOBALS['REQAR'][1] == 'new_resize_product_images'){
	$resize_all = false;
	if(isset($_POST['resize_all'])){
		$resize_all = true;
	}
	$Images = new Images();
	$response = $Images->resize($resize_all);
	if(isset($response['msg']) && !empty($response['msg'])){
		foreach($response['msg']['done'] as $key => $value){
			if(!isset($str)){
				$str = $key.' - '.$value;
			}else{
				$str .= ', '.$key.' - '.$value;
			}
		}
	}else{
		$str = 'Ошибка';
	}
	echo "<script>alert('Сгенерировано изображений: ".$str."');</script>";
	// echo "<script>alert('Сгенерировано изображений: 120x90 - ".$aa.", 250x250 - ".$ii.", 500x500 - ".$bb."');</script>";
}
// /efiles/_thumb/image/


// Dashboard statistics
$News = new News();
$Users = new Users();
$Orders = new Orders();

// dates
$today = date('d-m-Y');
$tpl->Assign('today', $today);
$statistics[$today]['stat_regs'] = $Users->GetRegisteredUsersListByDate($today);
$statistics[$today]['stat_ords'] = $Orders->GetOrdersCountListByDate($today);
$statistics[$today]['stat_comm'] = $News->GetCommentsCountByDate($today);
$yesterday = date('d-m-Y', strtotime($today.' -1 day'));
$tpl->Assign('yesterday', $yesterday);
$statistics[$yesterday]['stat_regs'] = $Users->GetRegisteredUsersListByDate($yesterday);
$statistics[$yesterday]['stat_ords'] = $Orders->GetOrdersCountListByDate($yesterday);
$statistics[$yesterday]['stat_comm'] = $News->GetCommentsCountByDate($yesterday);
for($i=0; $i <= 8; $i++){
	$dates[] = date('d-m-Y', strtotime($today.' -'.$i.' week'));
}
$tpl->Assign('statistics', $statistics);

//Получение статистики по недельно
$today_num = date('w'); //Number day for this week
$mon = mktime(0, 0, 0, date("m") , date("d")-$today_num+1, date("Y"));
$sun = mktime(0, 0, 0, date("m") , date("d")+(7-$today_num), date("Y"));
$monday_week = date('d-m-Y',$mon);
$sunday_week = date('d-m-Y',$sun);
$weeks[] = array('monday' => $monday_week, 'sunday' => $sunday_week);
$last_year_weeks[] = array('monday' => date('d-m-Y',strtotime($monday_week.'-1 year')) , 'sunday' => date('d-m-Y',strtotime($sunday_week.'-1 year')));
for($i=0; $i < 9; $i++){
	$sunday_week = date('d-m-Y', strtotime($sunday_week.' -7 day'));
	$monday_week = date('d-m-Y', strtotime($monday_week.' -7 day'));
	$weeks[] = array('monday' => $monday_week , 'sunday' => $sunday_week);
	$last_year_weeks[] = array('monday' => date('d-m-Y',strtotime($monday_week.'-1 year')) , 'sunday' => date('d-m-Y',strtotime($sunday_week.'-1 year')));
}
foreach($weeks as $k => $v){
	if($k == 0){
		$week_stats[$v['sunday']]['chart_regs'] = $Users->GetRegisteredUsersListByWeek($v['monday'], $today);
		$week_stats[$v['sunday']]['chart_ords'] = $Orders->GetOrdersCountListByWeek($v['monday'], $today);
		$week_stats[$v['sunday']]['chart_ords_ly'] = $Orders->GetOrdersCountListByWeek($last_year_weeks[$k]['monday'], date('d-m-Y',strtotime($today.'-1 year')));
	}else{
		$week_stats[$v['sunday']]['chart_regs'] = $Users->GetRegisteredUsersListByWeek($v['monday'], $v['sunday']);
		$week_stats[$v['sunday']]['chart_ords'] = $Orders->GetOrdersCountListByWeek($v['monday'], $v['sunday']);
		$week_stats[$v['sunday']]['chart_ords_ly'] = $Orders->GetOrdersCountListByWeek($last_year_weeks[$k]['monday'], $last_year_weeks[$k]['sunday']);
	}
}
$tpl->Assign('week_stats', $week_stats);

// get last comments list
$News->SetListComment();
$tpl->Assign('comments', $News->list);

// categories count
$sql = "SELECT COUNT(*) AS cnt
	FROM "._DB_PREFIX_."category
	WHERE sid = 1";
$res = $db->GetOneRowArray($sql);
$tpl->Assign("cat_cnt", $res['cnt']);

// subscribed users count
$sql = "SELECT COUNT(*) AS cnt
	FROM "._DB_PREFIX_."user AS u
	WHERE u.news = 1
	AND u.email NOT LIKE '%@x-torg.com'";
$res = $db->GetOneRowArray($sql);
$tpl->Assign("subscribed_cnt", $res['cnt']);

// products count
$sql = "SELECT COUNT(*) AS cnt
	FROM "._DB_PREFIX_."product";
$res = $db->GetOneRowArray($sql);
$tpl->Assign("items_cnt", $res['cnt']);

// get last article
$tpl->Assign('last_article', $Products->GetLastArticle());

// active products count
$sql = 'SELECT COUNT(*) AS cnt
	FROM '._DB_PREFIX_.'product AS p
	WHERE (CASE WHEN (SELECT COUNT(*) FROM '._DB_PREFIX_.'assortiment AS a LEFT JOIN '._DB_PREFIX_.'user AS u ON u.id_user = a.id_supplier WHERE a.id_product = p.id_product AND a.active = 1 AND u.active = 1) > 0 THEN 1 ELSE 0 END) = 1';
$res = $db->GetOneRowArray($sql);
$tpl->Assign("active_tov", $res['cnt']);

unset($parsed_res);
include($GLOBALS['PATH_block'].'cp_main.php');
