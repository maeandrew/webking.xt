<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>
<div id="segmentations_ae">
	<form action="<?=$GLOBALS['URL_request']?>" method="post">
		<div class="row">
			<div class="col-md-6 col-xs-12">
				<?if(isset($_POST['id'])){?>
					<input type="hidden" name="id" value="<?=$_POST['id']?>">
				<?}?>
				<label for="type">Выбор сегментации:</label>
				<select name="type" id="type" class="input-m">
					<?if(isset($typelist) && !empty($typelist)){
						foreach ($typelist as $t){?>
							<option <?=$t['id']==$_POST['type']?'selected':null;?> value="<?=$t['id']?>" data-date="<?=$t['use_date']?>"><?=$t['type_name']?></option>
						<?}
					}else{?>
						<option>Список пуст</option>
					<?}?>
				</select>
				<label for="name">Название:</label>
				<input type="text" name="name" class="input-m" value="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null?>" required>
				<div class="developments">
					<label for="date">Дата:</label>
					<input type="date" name="date" id="date" class="input-m" value="<?=isset($_POST['date'])?htmlspecialchars($_POST['date']):null?>">
					<label for="count_days">Количество дней:</label>
					<input type="number" name="count_days" min="0" max="999" id="count_days" class="input-m" value="<?=isset($_POST['count_days'])?htmlspecialchars($_POST['count_days']):null?>">
				</div>
				<button type="submit" name="smb" class="btn-m-default save-btn">Сохранить</button>
			</div>
		</div>
	</form>
</div>
<script>
	$(function(){
		// Показать|Скрыть блок событий
		$('#type').on('change', function() {
			var id_type = $(this).val(),
				use_date = $('option[value="'+id_type+'"]').data('date');
			if(use_date == 1){
				$('.developments').slideDown().find('input').attr('required', 'required');
			}else{
				$('.developments').slideUp().find('input[name="date"], input[name="count_days"]').removeAttr('required');
			};
		});
	});
</script>