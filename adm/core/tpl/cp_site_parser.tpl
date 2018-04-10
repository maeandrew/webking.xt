<h1><?=$h1?></h1>
<div class="grid" id="parser_ae">
	<form action="<?=$_SERVER['REQUEST_URI']?>/" method="post" enctype="multipart/form-data" class="row">

		<div class="col-md-12">
			<p>Добавить товаров</p>
			<input type="number" size="2" name="num" min="1" max="100000" value="10"  class="num_parser">
			<?if(!empty($sites)){?>
				<select name="site" id="site" class="input-m">
					<?foreach($sites as $site){?>
						<option value="<?=$site['id']?>"><?=$site['title']?></option>
					<?}?>
				</select>
			<?}else{?>
				Нет ни одного доступного сайта для парсинга
			<?}?>
			
		<button name="parse_URL" class="btn-m-red"">Парсинги по XML_url !</button>
		
<p>=======================================================================================================================================================</p>
<p>=======================================================================================================================================================</p>
		<div class="col-md-12">
			<label for="file">Парсинг по файлам:</label>
			<input type="file" name="file" class="input-m">

			<button name="parse" class="btn-m-red">Парсинги по файлам Excel</button>
			<button name="parse_XML" class="btn-m-red"">Парсинги по файлам XML !</button>
			
		</div>
<p>=======================================================================================================================================================</p>
<p>=======================================================================================================================================================</p>	<button name="test" class="btn-m-red"">Тест захода на URL !</button>
	</form>
</div>
