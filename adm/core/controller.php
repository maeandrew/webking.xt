<?php
$tpl_center = '';
$tpl_sidebar_l = '';
$tpl_sidebar_r = '';
$GLOBALS['__page_title'] = 'Администрирование';
//die($GLOBALS['CurrentController'] . '.php');
/*
 * Загрузка контроллера
 */

// products on moderation count
$sql = "SELECT COUNT(id) AS cnt
		FROM "._DB_PREFIX_."temp_products
		WHERE moderation_status = 0";
$res = $db->GetOneRowArray($sql);
$tpl->Assign("moderationCount", $res['cnt']);

// graphics on moderation count
$sql = "SELECT COUNT(*) AS count
		FROM "._DB_PREFIX_."chart
		WHERE moderation = 0 ";
$res = $db->GetOneRowArray($sql);
$tpl->Assign("GraphCount", $res['count']);

// comment count
$sql = "SELECT COUNT(id_coment) AS cnt_c
		FROM "._DB_PREFIX_."coment
		WHERE visible = 0";
$res = $db->GetOneRowArray($sql);
$tpl->Assign("commentCount", $res['cnt_c']);

// duplicates count
$sql = "SELECT COUNT(id_product) AS cnt_d
		FROM "._DB_PREFIX_."product
		WHERE visible = 1
		AND (duplicate = 1 OR duplicate_user > 0)";
$res = $db->GetOneRowArray($sql);
$tpl->Assign("duplicateCount", $res['cnt_d']);

// wishes count
$sql = "SELECT COUNT(id_wishes) AS cnt_w
		FROM "._DB_PREFIX_."wishes
		WHERE visible = 0";
$res = $db->GetOneRowArray($sql);
$tpl->Assign("wishesCount", $res['cnt_w']);

require($GLOBALS['PATH_contr'].$GLOBALS['CurrentController'].'.php');
// ------------------------ Сквозные блоки ------------------------
// ---- center ----
// ---- sidebar ----
if(!in_array($GLOBALS['CurrentController'], $GLOBALS['NoSidebarTemplControllers'])){
	unset($parsed_res);

	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'] . 'sb_adm_menu.tpl')
	);
	if(true == $parsed_res['issuccess']) {
		$tpl_sidebar_l .= $parsed_res['html'];
	}
}
// ------------------------ Сквозные блоки ------------------------
$GLOBALS['__center'] = $tpl_center;
$GLOBALS['__sidebar_l'] = $tpl_sidebar_l;
$GLOBALS['__sidebar_r'] = $tpl_sidebar_r;
// ------------------------ Для дебага
/*
  echo "title - ".strlen($GLOBALS['__page_title']);
  echo "<br>descr - ".strlen($GLOBALS['__page_description']);
  echo "<br>h1 - ".strlen($GLOBALS['__page_h1']);
  // */
?>