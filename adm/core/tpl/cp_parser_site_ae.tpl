<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?>
	<div class="notification error">
		<span class="strong">Ошибка!</span>
		<?=$msg?>
	</div>
<?}elseif(isset($msg)){?>
	<div class="notification success">
		<span class="strong">Сделано!</span>
		<?=$msg?>
	</div>
<?}?>
<div id="parser_sites_ae" data-id="<?=isset($_POST['id'])?$_POST['id']:0?>" class="grid">
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" class="row">
		<?=isset($_POST['id'])?'<input type="hidden" name="id" value="'.$_POST['id'].'">':null?>
		<div class="col-md-12">
			<label for="title">Название:</label>
			<?=isset($errm['title'])?"<span class=\"errmsg\">".$errm['title']."</span><br>":null?>
			<input type="text" class="input-m" name="title" required value="<?=isset($_POST['title'])?$_POST['title']:null;?>">
		</div>
		<div class="col-md-12">
			<label for="id_category">Категория:</label>
			<select name="id_category" class="input-m">
				<option disabled <?=!isset($_POST['id_category'])?'selected="selected"':null?>>Выребирте категорию</option>
				<?if(!empty($categories)){
					foreach($categories as $key => $item){?>
						<option <?=(next($categories)['pid'] == $item['id_category'])?'disabled':null?> <?=isset($_POST['id_category']) && $_POST['id_category'] == $item['id_category']?'selected="selected"':null;?> value="<?=$item['id_category']?>"><?=str_repeat('&nbsp;&nbsp;', $item['category_level'])?><?=$item['name']?></option>
					<?}
				}?>
			</select>
		</div>
		<div class="col-md-12">
			<label for="id_supplier">Поставщик:</label>
			<select name="id_supplier" class="input-m">
				<option disabled <?=!isset($_POST['id_supplier'])?'selected="selected"':null?>>Выребирте поставщика</option>
				<?if(!empty($suppliers)){
					foreach($suppliers as $key => $item){?>
						<option value="<?=$item['id_user']?>" <?=isset($_POST['id_supplier']) && $_POST['id_supplier'] == $item['id_user']?'selected="selected"':null;?>><?=$item['article']?> - <?=$item['name']?></option>
					<?}
				}?>
			</select>
		</div>
		<div class="col-md-12">
			<label for="active">Активность:</label>
			<select name="active" class="input-m">
				<option value="1" <?=isset($_POST['active']) && $_POST['active'] == 1?'selected="selected"':null;?>>Включен</option>
				<option value="0" <?=isset($_POST['active']) && $_POST['active'] == 0?'selected="selected"':null;?>>Выключен</option>
			</select>
		</div>
		<div class="col-md-12">
			<button class="btn-js btn-m-default save-btn" name="submit">Сохранить</button>
		</div>
	</form>
</div>