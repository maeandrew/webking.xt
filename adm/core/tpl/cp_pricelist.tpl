<h1><?=$h1?></h1>
<br>
<div id="pricelist_list">
	<ul class="header">
		<li class="order">№ заказа</li>
		<li class="name">Название прайса</li>
		<li class="set">Сет</li>
		<li class="visibility">Видимость</li>
		<li class="execute"></li>
	</ul>
	<ul id="sortable">
		<?foreach($list as $item){?>
			<li class="pricelist" id="pricelist-<?=$item['id'];?>" <?=$item['order'] == null?'class="sold"':null;?>>
				<section class="icon-dragplace"></section>
				<section class="order">
					<span><?=$item['order'] == null?'-':$item['order'];?></span>
					<input type="hidden" name="order" value="<?=$item['order'];?>"/>
				</section>
				<section class="name"><span><?=$item['name'];?></span><input type="hidden" name="name" value="<?=$item['name'];?>"/>
				</section>
				<section class="set">
					<span><?=str_replace(";", " &nbsp; ", $GLOBALS['CONFIG']['correction_set_'.$item['set']])?></span>
					<select name="correction_set" class="hidden" title="Корректировочный сет">
						<?$i = 0;
						while(isset($GLOBALS['CONFIG']['correction_set_'.$i])){?>
							<option class="set<?=$i?>" value="<?=$i?>" <?=($item['set'] == $i)?'selected':null?> ><?=str_replace(";", " &nbsp; ", $GLOBALS['CONFIG']['correction_set_'.$i])?></option>
							<?$i++;
						}?>
					</select>
				</section>
				<section class="visibility">
					<?if($item['visibility'] == 1){?>
						<span>
							<img src="../images/eye.svg"alt="Видимый"/>
						</span>
						<input type="hidden" name="visibility" checked="true" />
					<?}else{?>
						<span>
							<img src="../images/eye-blocked.svg" alt="Скрытый"/>
						</span>
						<input type="hidden" name="visibility"/>
					<?}?>
				</section>
				<section class="execute input-s">
					<div class="icon-delete" title="Удалить">t</div>
					<div class="icon-edit" title="Редактировать">e</div>
					<?if($item['visibility'] == 0){?>
					<div class="icon-run" title="Выполнить">f</div>
					<?}?>
				</section>
				<section class="edit hidden input-s">
					<div class="icon-cancel" title="Отменить">n</div>
					<div class="icon-save" title="Сохранить">y</div>
				</section>
				<div class="clear"></div>
			</li>
		<?}?>
	</ul>
	<div class="pricelist" id="newprice">
		<section class="order">
			<input type="text" name="order" class="input-s">
		</section>
		<section class="name">
			<input type="text" name="name" class="input-s">
		</section>
		<section class="set">
			<select name="correction_set" title="Корректировочный сет" class="input-s">
				<?$i = 0;
				while(isset($GLOBALS['CONFIG']['correction_set_'.$i])){?>
					<option class="set<?=$i?>" value="<?=$i?>"><?=str_replace(";", " &nbsp; ", $GLOBALS['CONFIG']['correction_set_'.$i])?></option>
					<?$i++;
				}?>
			</select>
		</section>
		<section class="visibility">
			<input type="checkbox" name="visibility" class="input-s"/>
		</section>
		<section class="create">
			<div class="icon-cancel" title="Отменить">n</div>
			<div class="icon-save" title="Сохранить">y</div>
		</section>
		<div class="clear"></div>
	</div>
	<div class="controls">
		<section class="addonemore">+</section>
	</div>
</div>
<script>
$(function(){
	$('#sortable').sortable({
		cursor: 'move',
		axis: 'y',
		update: function(event, ui){
			var data = $(this).sortable('toArray');
			$.ajax({
				type: 'POST',
				url: URL_base+'ajaxpricelists',
				data: {
					data: data,
					action: 'sort'
				}
			});
		}
	});
	$('#sortable').disableSelection();

	/* Добавление */
	$('div#pricelist_list').on('click', '.addonemore', function(){
		$(this).slideUp('fast');
		$('#newprice').slideDown();
	}).on('click', '.create .icon-cancel', function(){
		$('#newprice input').val('');
		$('#newprice select').val(0);
		$('#newprice').slideUp('fast');
		$('.addonemore').slideDown();
	}).on('click', '.execute .icon-delete', function(){
		var parent = $(this).closest('.pricelist').attr('id');
		var id = parseInt(parent.replace(/\D+/g,""));
		if(confirm('Удалить прайс-лист "'+$('#'+parent+' .name').text()+'"?') == true){
			$.ajax({
				type: 'POST',
				url: URL_base+'ajaxpricelists',
				cache: false,
				dataType : "json",
				data: {
					id: id,
					action: 'delete'
				}
			});
			$('#pricelist-'+id).slideUp();
		}
	}).on('click', '.create .icon-save', function(){
		var parent = $(this).closest('.pricelist').attr('id');
		var order = $('#'+parent+' input[name="order"]').val();
		var name = $('#'+parent+' input[name="name"]').val();
		var set = $('#'+parent+' select[name="correction_set"]').val();
		var settext = $('#'+parent+' select[name="correction_set"] option[value="'+set+'"]').text();
		var visi = $('#'+parent+' input[name="visibility"]').prop('checked');
		var visitext = '<span><img src="../images/eye.svg"alt="Видимый"/></span><input type="hidden" name="visibility" checked="true" class="input-s">';
		var visibility = 1;
		var buttons = '<div class="icon-delete" title="Удалить">t</div><div class="icon-edit" title="Редактировать">e</div>';
		if(visi == false){
			buttons = '<div class="icon-delete" title="Удалить">t</div><div class="icon-edit" title="Редактировать">e</div><div class="icon-run" title="Выполнить">f</div>';
			visitext = '<span><img src="../images/eye-blocked.svg"alt="Скрытый"/></span><input type="hidden" name="visibility" class="input-s">';
			visibility = 0
		}
		if(order != '' && name != ''){
			$.ajax({
				type: 'POST',
				url: URL_base+'ajaxpricelists',
				cache: false,
				dataType : "json",
				data: {
					action: 'add',
					order: order,
					name: name,
					set: set,
					visibility: visibility
				}
			}).done(function(id){
				$('#sortable').append('<li class="pricelist" id="pricelist-'+id+'"><section class="icon-dragplace"></section><section class="order"><span>'+order+'</span><input type="hidden" name="order" value="'+order+'" class="input-s"></section><section class="name"><span>'+name+'</span><input type="hidden" name="name" value="'+name+'" class="input-s"></section><section class="set"><span>'+settext+'</span><select name="correction_set" title="Корректировочный сет"><?$i = 0;while(isset($GLOBALS['CONFIG']['correction_set_'.$i])){?><option class="set<?=$i?>" value="<?=$i?>"><?=str_replace(";", " &nbsp; ", $GLOBALS['CONFIG']['correction_set_'.$i])?></option><?$i++;}?></select></section><section class="visibility">'+visitext+'</section><section class="execute">'+buttons+'</section><section class="edit hidden"><div class="icon-cancel" title="Отменить">n</div><div class="icon-save" title="Сохранить">y</div></section><div class="clear"></div></li>');
				$('#pricelist-'+id+' span').removeClass('hidden');
				$('#pricelist-'+id+' .execute').removeClass('hidden');
				$('#pricelist-'+id+' .edit').addClass('hidden');
				$('#pricelist-'+id+' select').addClass('hidden');
				$('#pricelist-'+id+' option.set'+set).attr('selected', true);
				$('#newprice input').val('');
				$('#newprice select').val(0);
				$('#newprice').addClass('hidden');
				$('.addonemore').slideDown();
			});
		}
	}).on('click', '.execute .icon-run', function(){
		var parent = $(this).closest('.pricelist').attr('id');
		var order = $('#'+parent+' input[name="order"]').val();
		var set = $('#'+parent+' select[name="correction_set"]').val();
		$.ajax({
			type: 'POST',
			url: URL_base+'ajaxpricelists',
			cache: false,
			dataType : "json",
			data: {
				action: 'run',
				order: order,
				set: set
			},
			success: alert('Все ОК!')
		});
	}).on('click', '.execute .icon-edit', function(){
		var parent = $(this).closest('.pricelist').attr('id');
		$('#'+parent+' span').addClass('hidden');
		$('#'+parent+' .execute, #'+parent+' .edit').toggleClass('hidden');
		$('#'+parent+' select').removeClass('hidden');
		$('#'+parent+' .order input, #'+parent+' .name input').prop('type', 'text');
		$('#'+parent+' .visibility input').prop('type', 'checkbox');
		var order = $('#'+parent+' input[name="order"]').val();
		var name = $('#'+parent+' input[name="name"]').val();
		var set = $('#'+parent+' select[name="correction_set"]').val();
		var settext = $('#'+parent+' select[name="correction_set"] option[value="'+set+'"]').text();
		var visi = $('#'+parent+' input[name="visibility"]').prop('checked');
		var visitext = '<img src="../images/eye.svg"alt="Видимый"/>';
		var visibility = 1;
	}).on('click', '.edit .icon-cancel', function(){
		var parent = $(this).closest('.pricelist').attr('id');
		$('#'+parent+' span').removeClass('hidden');
		$('#'+parent+' .execute, #'+parent+' .edit').toggleClass('hidden');
		$('#'+parent+' select').addClass('hidden');
		$('#'+parent+' .order input, #'+parent+' .name input').prop('type', 'hidden');
		$('#'+parent+' .visibility input').prop('type', 'hidden');
	}).on('click', '.edit .icon-save', function(){
		var parent = $(this).closest('.pricelist').attr('id');
		var id = parseInt(parent.replace(/\D+/g,""));
		var order = $('#'+parent+' input[name="order"]').val();
		var name = $('#'+parent+' input[name="name"]').val();
		var set = $('#'+parent+' select[name="correction_set"]').val();
		var settext = $('#'+parent+' select[name="correction_set"] option[value="'+set+'"]').text();
		var visi = $('#'+parent+' input[name="visibility"]').prop('checked');
		var visitext = '<span><img src="../images/eye.svg"alt="Видимый"/></span><input type="hidden" name="visibility" checked="true" class="input-s">';
		var visibility = 1;
		var buttons = '<div class="icon-delete" title="Удалить">t</div><div class="icon-edit" title="Редактировать">e</div>';
		if(visi == false){
			buttons = '<div class="icon-delete" title="Удалить">t</div><div class="icon-edit" title="Редактировать">e</div><div class="icon-run" title="Выполнить">f</div>';
			visitext = '<span><img src="../images/eye-blocked.svg"alt="Скрытый"/></span><input type="hidden" name="visibility" class="input-s">';
			visibility = 0
		}
		if(order != '' && name != ''){
			$.ajax({
				type: 'POST',
				url: URL_base+'ajaxpricelists',
				cache: false,
				dataType : "json",
				data: {
					action: 'update',
					id: id,
					order: order,
					name: name,
					set: set,
					visibility: visibility
				}
			});
			$('#pricelist-'+id).html('<section class="icon-dragplace"></section><section class="order"><span>'+order+'</span><input type="hidden" name="order" value="'+order+'"/></section><section class="name"><span>'+name+'</span><input type="hidden" name="name" value="'+name+'"/></section><section class="set"><span>'+settext+'</span><select name="correction_set" title="Корректировочный сет"><?$i = 0;while(isset($GLOBALS['CONFIG']['correction_set_'.$i])){?><option class="set<?=$i?>" value="<?=$i?>"><?=str_replace(";", " &nbsp; ", $GLOBALS['CONFIG']['correction_set_'.$i])?></option><?$i++;}?></select></section><section class="visibility">'+visitext+'</section><section class="execute">'+buttons+'</section><section class="edit hidden"><div class="icon-cancel" title="Отменить">n</div><div class="icon-save" title="Сохранить">y</div></section><div class="clear"></div>');
			$('#'+parent+' span').removeClass('hidden');
			$('#'+parent+' .execute').removeClass('hidden');
			$('#'+parent+' .edit').addClass('hidden');
			$('#'+parent+' select').addClass('hidden');
			$('#'+parent+' option.set'+set).attr('selected', true);
			$('#'+parent+' .order input, #'+parent+' .name input').prop('type', 'hidden');
			$('#'+parent+' .visibility input').prop('type', 'hidden');
		}
	});
});
</script>