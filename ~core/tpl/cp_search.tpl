<div id="content">
	<?if(isset($query)){?>
		<h3>Результаты поиска по запросу «<?=$query?>».</h3>
	<?}else{?>
		<h3>Поиск</h3>
	<?}?>
	<div class="content_page">
	<br>
	<form name="f_search" action="<?=_base_url?>/search/" method="post" class="f_search">
		<span class="site_search">
		<input name="query" type="text" value="<?=isset($query)?htmlspecialchars($query):null?>" size="70">
		<input name="smb" id="form_submit" type="submit" class="search_btn" value="">
		</span>
	</form>
	<?if (isset($c_list) && count($c_list)){?>
		<br><h1>Категории:</h1><br>
		<?foreach ($c_list as $li){?>

			<a href="<?=_base_url?>/products/<?=$li['id_category']?>/<?=$li['translit']?>/"><?=$li['name']?></a>
			<br><br>
		<?}?>
	<?}?>
	<?if (isset($p_list) && count($p_list)){?>
		<br><rh1>Страницы:</rh1><br>
		<?foreach ($p_list as $li){?>

			<a href="<?=_base_url?>/page/<?=$li['translit']?>/"><?=$li['title']?></a>
			<p><?=$li['content']?>...</p>
			<br>
		<?}?>
	<?}?>
	<br>
	<a href="<?=_base_url?>/cat/">Карта каталога</a>
	<br>
  </div>
</div>
