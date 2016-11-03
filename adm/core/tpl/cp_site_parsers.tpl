<h1><?=$h1?></h1>
<div class="grid">
	<div class="row">
		<form action="<?=$_SERVER['REQUEST_URI']?>/" class="col-md-12" method="post" enctype="multipart/form-data">
			<input type="file" name="urls" class="input-m">
			<!-- <input type="text" name="url" class="input-m" value="<?=isset($_POST['url'])?$_POST['url']:null;?>"> -->
			<button name="parse" class="btn-m-red">Парсить! Вперед!</button>
		</form>
	</div>
	<ul class="unload_links row hidden">
		<li class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<a href="/csv_prom_new/" title=""><img src="/adm/images/prom_ua.png" alt="prom_ua">zona220<span class="icon-option notactive">o</span></a>
		</li>
	</ul>
</div>