<?php
/**
 * Created by JetBrains PhpStorm.
 * Date: 16.05.12
 * Time: 23:01
 * To change this template use File | Settings | File Templates.
 */
error_reporting('E_ALL');
ini_set('display_errors', '1');
setlocale(LC_ALL, 'ru_RU');

require_once('morphy.functions.php');

if (!isset($_POST['host']) || !isset($_POST['user']) || !isset($_POST['password'])) {

   echo  <<<HTML
<form action="update.php" method="POST" >
<input type="text" name="host" value="localhost">
<input type="text" name="user" value="root">
<input type="text" name="password" value="">
<input type="submit">
</form>
HTML;

}

else

{
    mysql_connect($_POST['host'],$_POST['user'],$_POST['password']) or die('Database: Failed to connect. Check your credentials.');
    mysql_set_charset('utf-8');

    mysql_select_db('xtorg_db') or die('Failed to select database');


        $min = 58000;

        $qry = "SELECT MAX(id_product) FROM xt_product";
        $result = mysql_fetch_array(mysql_query($qry)) or die(mysql_error());
        $max = 58250;


    $total = 0;

        for ($i=$min; $i <= $max; $i++) {

            $qry = "SELECT name FROM xt_product WHERE id_product='$i'";
            $name = mysql_fetch_array(mysql_query($qry));


                $name_index = Words2BaseForm($name[0]);
                $qry = "UPDATE xt_product SET name_index='$name_index' WHERE id_product='$i'";
                mysql_query($qry);
                $total++;

        }
    echo "<br>$total records processed<br>";


}