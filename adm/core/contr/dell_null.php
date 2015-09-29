<?php
require('/home/xtorg/x-torg.com/www/~core/sys/db_c.php');
require('/home/xtorg/x-torg.com/www/~core/sys/dbtree_c.php');
require('/home/xtorg/x-torg.com/www/~core/sys/pages_c.php');
require('/home/xtorg/x-torg.com/www/~core/sys/acl_c.php');
require('/home/xtorg/x-torg.com/www/~core/model/products_c.php');

define ('DB_CACHE', false);

	$GLOBALS['DOMAIN'] = '179053.xtorg.web.hosting-test.net';

	$GLOBALS['DB_HOST']  = "xtorg.mysql.ukraine.com.ua";
	$GLOBALS['DB_NAME']= "xtorg_db";
	$GLOBALS['DB_USER']    = "xtorg_db";
	$GLOBALS['DB_PASSWORD']= "sayLt23f";
	define('_DB_PREFIX_', "xt_");
	
	$db = new mysqlDb($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD'], $GLOBALS['DB_NAME']);
	$GLOBALS['db'] =& $db;
	$product = new Products();
	$db->StartTrans();
		$product->Re_null();
	$db->CompleteTrans();
?>