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
			<label for="file">Парсинг по Прайс-листу:</label>
			<input type="file" name="file" class="input-m">
		</div>
		
		<div class="input_number">
			 <p><input type="number" size="2" name="num" min="1" max="10" value="1"></p>
			
		</div>
		
		<div class="col-md-12">
			<button name="parse" class="btn-m-red">Парсинги по сохраненым файлам Excel</button>
		</div>

<p>-----------------------------------------------------------------------------------------------------------</p>
	
		<div class="col-md-12">
			<button name="parse_XML" class="btn-m-red"">Парсинги по сохраненым файлам XML !</button>
		</div>


	</form>
</div>
