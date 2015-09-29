<?php

	// ---- center ----
	unset($parsed_res);

	// --------------------------------------------------------------------------------------

	/*if (isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		$item_id = $GLOBALS['REQAR'][1];
	}else{
		echo "Не указан id.";
		die();
	}*/

	$items = new Items();
	$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
	$db->Query("DROP TABLE `"._DB_PREFIX_."category_seq`;");
	$db->Query("TRUNCATE TABLE `"._DB_PREFIX_."product`;");
	$db->Query("TRUNCATE TABLE `"._DB_PREFIX_."cat_prod`;");
	$dbtree->Clear(array('visible'=>'1', 'pid'=>'0', 'name'=>'root', 'translit'=>''));
//die();

print_r($dbtree->ERRORS);
print_r($dbtree->ERRORS_MES);


	$tpl->Assign('msg', "catalog is empty");


	$parsed_res = array('issuccess' => TRUE,
	 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl'));

	// --------------------------------------------------------------------------------------

	if (TRUE == $parsed_res['issuccess']) {
		$tpl_center .= $parsed_res['html'];
	}

	// ---- right ----

// ---------------------------------------------------------------------

	function _iconv($txt){
		return iconv("UTF-8", "windows-1251", $txt);
	}
?>