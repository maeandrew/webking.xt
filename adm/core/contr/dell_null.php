<?php
require('/home/xtorg/x-torg.com/www/~core/sys/db_c.php');
require('/home/xtorg/x-torg.com/www/~core/sys/dbtree_c.php');
require('/home/xtorg/x-torg.com/www/~core/sys/pages_c.php');
require('/home/xtorg/x-torg.com/www/~core/sys/acl_c.php');
require('/home/xtorg/x-torg.com/www/~core/model/products_c.php');


	$GLOBALS['DOMAIN'] = '179053.xtorg.web.hosting-test.net';

	$GLOBALS['DB']['HOST']  = "xtorg.mysql.ukraine.com.ua";
	$GLOBALS['DB']['NAME']= "xtorg_db";
	$GLOBALS['DB']['USER']    = "xtorg_db";
	$GLOBALS['DB']['PASSWORD']= "sayLt23f";
	define('_DB_PREFIX_', "xt_");

	$db = new mysqlDb($GLOBALS['DB']['HOST'], $GLOBALS['DB']['USER'], $GLOBALS['DB']['PASSWORD'], $GLOBALS['DB']['NAME']);
	$GLOBALS['db'] =& $db;
	$Products = new Products();
	$db->StartTrans();
		$Products->Re_null();
	$db->CompleteTrans();
?>