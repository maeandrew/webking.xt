<h1><?=$h1?></h1>
<div class="grid" id="parser_ae">
	<form action="<?=$_SERVER['REQUEST_URI']?>/" method="post" enctype="multipart/form-data" class="row">
		<div class="col-md-12">
			<label for="site">Сайт:</label>
			<?if(!empty($sites)){?>
				<select name="site" id="site" class="input-m">
					<?foreach($sites as $site){?>
						<option value="<?=$site['id']?>"><?=$site['title']?></option>
					<?}?>
				</select>
			<?}else{?>
				Нет ни одного доступного сайта для парсинга
			<?}?>
		</div>
		<div class="col-md-12">
			<label for="file">Прайс-лист:</label>
			<input type="file" name="file" class="input-m">
		</div>
		<div class="col-md-12">
			<label for="test"><input type="checkbox" name="test" class="input-m"> - Тестовый запуск</label>
		</div>
		<div class="col-md-12">
			<button name="parse" class="btn-m-red">Вперед!</button>
		</div>
	</form>
</div>