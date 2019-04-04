<h1><?=$h1?></h1>
<div class="grid">
	<ul class="unload_links row">
		<li class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<a href="/csv_prom/" title="Кликни для выгрузки"><img src="/adm/images/prom_ua.png" alt="prom_ua">prom.ua</a>
		</li>
		<li class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<a href="/csv_prom_new/" title="Кликни для выгрузки"><img src="/adm/images/prom_ua.png" alt="prom_ua">prom.ua <span class="icon-option notactive">o</span></a>
		</li>
		<li class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<a href="/csv_barabashovo/" title="Кликни для выгрузки"><img src="/adm/images/barabashovo_ua.png" alt="barabashovo_ua">barabashovo.ua</a>
		</li>
		<li class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<a href="/csv_etov/" title="Кликни для выгрузки"><img src="/adm/images/etov_ua.png" alt="etov_ua">etov.ua</a>
		</li>
		<li class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<a href="/csv_tatet/" title="Кликни для выгрузки" id="tatet">
				<img src="/adm/images/tatet_ua logo.png" alt="tatet_ua">
				tatet.ua <span class="icon-option open_modal" data-target="unload_option" title="Настроить выгрузку">o</span>
			</a>
		</li>
	</ul>
	<div class="modal_hidden" id="unload_option">
		<h3 class="logo"></h3>
		<p><b>Выгружать только</b></p>
		<ul id="list">
			<?
			$i = 0;
			foreach ($category_list as $cl){?>
				<li><input type="checkbox" name="<?=$cl['translit']?>" id="checkbox<?=$i?>" value="<?=$cl['id_category']?>"><label for="checkbox<?=$i?>"><span class="color-grey"><?=$cl['art']?></span> - <?=$cl['name']?> (<span class="quantity"><?=$cl['products']?></span>)</label></li>
			<?$i++;
			}?>
		</ul>
		<div class="btn_block fr">
			<input type="hidden" name="modalName">
<!-- 			<button class="btn-m-lblue">Сохранить и Выгрузить</button> -->
			<button id="save" class="btn-m-default">Сохранить</button>
			<a href="" title="Кликни для выгрузки" class="btn-m-green fr">Выгрузить</a>
		</div>
	</div>
</div>
<script>
	$(function(){
		$('.icon-option').click(function(event){
			event.preventDefault();
			var modalName = $(this).parent().attr('id');
			var href = $(this).parent().attr('href');
			$('[class^="modal_"] .btn_block  > a').attr('href', href);
			$('input[name="modalName"]').val(modalName);
			$('[class^="modal_"] > h3').html('');
			$(this).parent().find('img').clone().appendTo('[class^="modal_"] > h3');
			var nameOption = modalName+'_catlist';
			ajax('configs','getOption', {nameOption: nameOption}).done(function(valueOption){
				var arrOption = valueOption['value'].split(',');
				arrOption.forEach(function(i){
					$('input[type="checkbox"][value="'+i+'"]').attr("checked", "checked");
				});
			});
		});
	});

	//Формирование массива выбранных категорий
	$('#save').on('click', function() {
		var arr = [];
		var modalName = $(this).parent().find('input[name="modalName"]').val();
		$('#list input:checked').each(function(i){
			arr[i] = $(this).val();
		});
		var value = arr.join(',');
		var nameOption = modalName+'_catlist';
		ajax('configs','updateOption', {nameOption: nameOption, valueOption: value});
	});
</script>