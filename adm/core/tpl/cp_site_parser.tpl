<h1><?=$h1?></h1>
<div class="grid" id="parser_ae">
	<form action="<?=$_SERVER['REQUEST_URI']?>/" method="post" enctype="multipart/form-data" class="row">

		<div class="col-md-12">
			
		</div>
<p>=======================================================================================================================================================</p>
<p>=======================================================================================================================================================</p>
		<div class="col-md-12">
			<label for="file">Парсинг по Прайс-листу:</label>
			<p>Добавить товаров</p>
			<input type="number" size="2" name="num" min="1" max="10000" value="1">
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
			<input type="file" name="file" class="input-m">
			<button name="parse" class="btn-m-red">Парсинги по сохраненым файлам Excel</button>
		</div>
<p>=======================================================================================================================================================</p>
<p>=======================================================================================================================================================</p>
	<div class="col-md-12">
		<label for="file">Парсинг по файлу xml:</label>
		<p>Добавить товаров</p>
			<input type="number" size="2" name="num" min="1" max="10000" value="1">
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
		<input type="file" name="filexml" class="input-m">

		<button name="parse_XML" class="btn-m-red"">Парсинги по сохраненым файлам XML !</button>
	</div>
<p>=======================================================================================================================================================</p>
<p>=======================================================================================================================================================</p>
<div class="col-md-12">
	<label for="file">Парсинги по url :</label>
	<p>Добавить товаров</p>
			<input type="number" size="2" name="num" min="1" max="10000" value="1">
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
	<button name="parse_URL" class="btn-m-red"">Парсинги по url !</button>
</div>
<p>=======================================================================================================================================================</p>
<p>=======================================================================================================================================================</p>

<div class="col-md-12">
	<p>Добавить товаров</p>
	<button name="parse_NL_xml" class="btn-m-red"">Парсингм НОВУЮ ЛИНИЮ !</button>
</div>
<p>=======================================================================================================================================================</p>
<p>=======================================================================================================================================================</p>
<div class="col-md-12">
	<p>Добавить товаров</p>
	<button name="test" class="btn-m-red"">Тест захода на URL !</button>
</div>
<p>=======================================================================================================================================================</p>
<p>=======================================================================================================================================================</p>
	</form>
</div>
