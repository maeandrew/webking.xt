<h1><?=$h1?></h1>
<?if(isset($errm) && isset($msg)){?>
	<div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?>
	<div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div>
<?}?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
		<colgroup>
			<col width="100%">
			<col width="250px">
		</colgroup>
		<thead>
			<tr>
				<td class="left">Значение</td>
				<td class="left"></td>
			</tr>
		</thead>
		<tbody>
			<?if(!empty($list)){
				foreach($list as $i){?>
					<tr class="values_list_item" data-id="<?=$i['id']?>">
						<td class="value"><?=$i['value']?></td>
						<td class="right actions">
							<button class="btn-m-green-inv edit_value"><i class="icon-edit">e</i></button>
							<button class="btn-m-red delete_value"><i class="icon-delete">t</i></button>
						</td>
					</tr>
				<?}
			}else{?>
				<tr class="no_items">
					<td colspan="2">
						<div class="notification warning">
							<span class="strong">Нет записей</span>
						</div>
					</td>
				</tr>
			<?}?>
			<tr class="add_value_to_list">
				<td>
					<input type="hidden" name="id_specification" value="<?=$id_specification?>">
					<input type="text" name="value" class="input-m" required placeholder="Введите новое значение">
				</td>
				<td><button class="btn-m-green add_value">Добавить</button></td>
			</tr>
			<tr class="values_list_item template hidden">
				<td class="value"><?=$i['value']?></td>
				<td class="right actions">
					<button class="btn-m-green-inv edit_value"><i class="icon-edit">e</i></button>
					<button class="btn-m-red delete_value"><i class="icon-delete">t</i></button>
				</td>
			</tr>
		</tbody>
	</table>
<script>
	$(function(){
		function addSpecValue(parent, event){
			var id_specification = parent.find('[name="id_specification"]').val(),
				value = parent.find('[name="value"]').val();
			if(value){
				event.preventDefault();
				ajax('specification', 'addSpecValue', {id_specification: id_specification, value: value}).done(function(data){
					var template = $('.template').clone();
					template.data('id', data).removeClass('hidden template').find('.value').html(value);
					template.insertBefore($('.add_value_to_list'));
					parent.find('[name="value"]').val('').focus();
				});
				if($('.no_items')){
					$('.no_items').remove();
				}
			}
		}
		function updateSpecValue(parent, event){
			var id = parent.data('id'),
				value = parent.find('.new_value').val();
			ajax('specification', 'updateSpecValue', {id: id, value: value}).done(function(){
				parent.find('.value').html(value);
				parent.find('.save_value').attr('class', 'btn-m-green-inv edit_value').find('i').html('e');
			});
		}
		$('.add_value_to_list').on('click', '.add_value', function(event){
			var parent = $(this).closest('tr');
			addSpecValue(parent, event);
		}).on('keyup', '[name="value"]', function(event){
			var parent = $(this).closest('tr'),
				key = event.keyCode || event.which;
			if(key == '13'){
				addSpecValue(parent, event);
			}
		});
		$('.list').on('click', '.delete_value', function(event){
			event.preventDefault();
			var parent = $(this).closest('tr'),
				id = parent.data('id');
			ajax('specification', 'deleteSpecValue', {id: id}).done(function(){
				parent.remove();
			});
		}).on('click', '.edit_value', function(event){
			event.preventDefault();
			var parent = $(this).closest('tr'),
				id = parent.data('id'),
				current_value = parent.find('.value').html();
			parent.find('.value').html('<input class="input-m new_value" value="'+parent.find('.value').html()+'">').find('.new_value').focus();
			parent.find('.edit_value').attr('class', 'btn-m-green save_value').find('i').html('y');
		}).on('click', '.save_value', function(event){
			var parent = $(this).closest('tr');
			updateSpecValue(parent, event);
		}).on('keyup', '.new_value', function(event){
			var parent = $(this).closest('tr'),
				key = event.keyCode || event.which;
			if(key == '13'){
				updateSpecValue(parent, event);
			}else if(key == '27'){
				parent.find('.value').html(parent.find('.new_value').val());
				parent.find('.save_value').attr('class', 'btn-m-green-inv edit_value').find('i').html('e');
			}
		});
	});
</script>