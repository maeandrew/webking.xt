<h1><?=$h1?></h1>
<br>
<?if (isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div>
<?}elseif(isset($errm)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div><?}?>
<br>