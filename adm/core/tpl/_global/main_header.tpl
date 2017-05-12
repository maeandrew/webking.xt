<div class="topline">
	Перейти на <a href="<?=$GLOBALS['URL_base']?>">сайт</a><?if(isset($_SESSION['member'])){?> | Вы вошли как <a href="<?=$GLOBALS['URL_base']?>adm/login/"><?=$_SESSION['member']['email']?></a> | <a href="/adm/logout/">Выход</a><?}?>
</div>
<?if(isset($self_edit) && ($self_edit == '1')){?>
	<div class="subline">
		<a class="menuUserInfBtn btn-m-red" href="<?=$GLOBALS['URL_base'];?>cabinet" style="line-height: 20px; margin: 2px; right: 1%; position: absolute;">Вернуться в мой кабинет</a>
	</div>
<?}?>
<div class="subline"<?if(isset($self_edit) && ($self_edit == '1')){?> style="display: none;" <?}?>>
	<div class="breadcrumps">
		<?if(count($GLOBALS['IERA_LINKS']) > 1){
			for($ii = 0; isset($GLOBALS['IERA_LINKS'][$ii]); $ii++){
				$i = $GLOBALS['IERA_LINKS'][$ii];
				if (isset($GLOBALS['IERA_LINKS'][$ii+1])){?>
					<a href="<?=$i['url']?>"><?=$i['title']?></a>
				<?}else{?>
					<?=$i['title']?>
				<?}?>
				<?=isset($GLOBALS['IERA_LINKS'][$ii+1])?'<span> &rarr; </span>':null?>
			<?}
		}else{
			echo '&nbsp;';
		}?>
	</div>
	<div class="supplier_search">
		<form method="post" target="_blank" action="/supplier_search">
			<input type="text" name="art_product" class="input-m" placeholder="Проверка наличия товара">
			<button type="submit" class="btn-m-default" id="form_submit">Искать</button>
		</form>
	</div>
	<div class="art_search">
		<form method="post" action="<?=$GLOBALS['URL_base']?>adm/artsearch">
			<?if(isset($_GET['err']) && ($_GET['err'] == 404)){
				echo "<p style='left: -150px; top: -10%; font-weight: 600; position: absolute; text-align: center; color: #f00;' class='error'>Запись не найдена.<br>Повторите поиск.</p>";
			}?>
			<input type="text" name="art" class="input-m" placeholder="Поиск по артикулу...">
			<button type="submit" name="art_search_button" class="btn-m-default" id="form_submit">Искать</button>
		</form>
	</div>
	<div class="clear"></div>
</div>