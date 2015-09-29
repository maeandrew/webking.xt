<?
require($GLOBALS['PATH_sys'].'kcaptcha_c.php');
$captcha = new KCAPTCHA();

$_SESSION['captcha_keystring'] = $captcha->getKeyString();

?>