<style>
	.editProdSpecValue, .applyProdSpecValue {
		margin-left: 5px;
		font-size: 18px;
		border-radius: 50%;
	}

	.editProdSpecValue:hover {
		color: #E8981D;
		text-shadow: 2px 2px 4px rgba(150, 150, 150, 1);
		cursor: pointer;
	}

	.applyProdSpecValue:hover {
		color: #E8981D;
		text-shadow: 2px 2px 4px rgba(150, 150, 150, 1);
		cursor: pointer;
	}

	.inputSpecVal {
		/* height: 25px; */
	}

	.specValName {
		text-overflow: ellipsis; /* не работает */
	}
</style>

<h1><?=$h1?></h1>
<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null;?>
<form action="<?=$GLOBALS['URL_request']?>" method="get" class="orders">
	<table class = "list">
		<colgroup>
			<col width="5%">
			<col width="25%">
			<col width="25%">
			<col width="25%">
			<col width="20%">
		</colgroup>
		<thead>
			<tr class="filter">
				<td>Фильтры:</td>
				<td>
					<select name="id_category" class="input-m">
						<option value="0">Все</option>
						<?foreach($cat_spec as $k=>$item){
							if($k != 0 && $k == $_GET['id_category']){
								$specifications = $item['specs'];
							}?>
							<option <?=$k == $_GET['id_category']?'selected="true"':null?> value="<?=$k;?>"><?=$item['name'];?></option>
						<?}?>
					</select>
				</td>
				<td>
					<select name="id_caption" class="input-m">
						<option value="0">Все</option>
						<?foreach($specifications as $k=>$item){?>
							<option <?=$k == $_GET['id_caption']?'selected="true"':null?> value="<?=$k;?>"><?=$item;?></option>
						<?}?>
					</select>
				</td>
				<td class="left">
					<button type="submit" name="smb" class="btn-m-default">Применить</button>
				</td>
				<td class="center">
					<button type="submit" name="clear_filters" class="btn-m-default-inv">Сбросить</button>
				</td>
			</tr>
			<tr>
				<td class="left"></td>
				<td class="left">Категория</td>
				<td class="left">Характеристика</td>
				<td class="left">Значение</td>
				<td class="center">Количество</td>
			</tr>
		</thead>
		<tbody>
			<?$i = $GLOBALS['Start']+1;
			foreach($list as $value){?>
				<tr>
					<td><?=$i++?></td>
					<td><?=$value['name'];?></td>
					<td><?=$value['caption'];?></td>
					<td><span class="specValName"><?=$value['value'];?></span>
						<span class="gray"><?=$value['units'];?></span>
						<input class="inputSpecVal hidden" type="text" value="123ghj">
						<i class="icon-font editcat editProdSpecValue">e</i>
						<i class="icon-font addprod applyProdSpecValue hidden">a</i>
					</td>
					<td class="center">
						<div data-target="unload_option" data-cat="<?=$value['id_category']?>" data-spec="<?=$value['id_caption']?>" data-val="<?=$value['value']?>" class="btn-m-default-inv open_modal"><?=$value['count'];?></div>
					</td>
				</tr>
			<?}?>
		</tbody>
	</table>
</form>
<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null;?>
<script>
	$(function(){
		$('.center .btn-m-default-inv').click(function(){
			var id_category = $(this).data('cat'),
					spec = $(this).data('spec'),
					value = $(this).data('val');
			$.ajax({
				url: URL_base+'ajaxspecifications',
				type: "POST",
				cache: false,
				dataType : "html",
				data: {
					"action": 'get_prodlist_moderation',
					"id_category": id_category,
					"specification": spec,
					"value": value
				}
			}).done(function(data){
				$('#list').html(data);
			});
		});
		$('#unload_option #list').on('click', 'a', function(){
			console.log('trololo');
			$(this).addClass('clicked');
		});

		$('.editcat').on('click', function(){
			var value = $(this).closest('td').find('.specValName').html();
			$(this).closest('td').find('.inputSpecVal').removeClass('hidden');
			$(this).closest('td').find('.inputSpecVal').val(value);
			$(this).closest('td').find('.specValName').addClass('hidden');
			$(this).closest('td').find('.addprod').removeClass('hidden');
			$(this).addClass('hidden');
		});

		$('.addprod').on('click', function(){
			$(this).closest('td').find('.editcat').removeClass('hidden');
			$(this).closest('td').find('.inputSpecVal').addClass('hidden');
			var oldVal = $(this).closest('td').find('.specValName').html();
			var newVal = $(this).closest('td').find('.inputSpecVal').val();
			$(this).closest('td').find('.specValName').html(newVal);
			$(this).closest('td').find('.specValName').removeClass('hidden');
			$(this).addClass('hidden');

			ajax('ajaxmonitoring', 'ChangeSpecificationValue',  {value: newVal, oldValue: oldVal, id_spec: id_spec, id_category: id_category}).done(function(data){
				closest('data');
			});

		});

	});
</script>
<div class="modal_hidden" id="unload_option">
	<ul id="list"></ul>
	<!-- <a href="#" class="close_modal icon-del">n</a> -->
</div>