<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null;?>
<form action="<?=$GLOBALS['URL_request']?>" method="get">
	<table class="list">
		<colgroup>
			<col width="10%">
			<col width="10%">
			<col width="10%">
			<col width="5%">
			<col width="15%">
			<col width="45%">
			<col width="5%">
		</colgroup>
		<thead>
			<tr class="filter">
				<td>Фильтры:</td>
				<td>
					<select name="sid" class="input-m">
						<option value="0" <?=isset($_GET['sid']) && $_GET['sid'] == 0?'selected':null;?>>x-torg.com</option>
						<option value="1" <?=isset($_GET['sid']) && $_GET['sid'] == 1?'selected':null;?>>xt.ua</option>
					</select>
				</td>
				<td></td>
				<td></td>
				<td></td>
				<td class="left" colspan="2">
					<button type="submit" name="smb" class="btn-m-default">Применить</button>
					<button type="submit" name="clear_filters" class="btn-m-default-inv">Сбросить</button>
				</td>
			</tr>
			<tr>
				<td class="left">IP</td>
				<td class="left">Сайт</td>
				<td class="left">Пользователь</td>
				<td class="left">Кол-во подключений</td>
				<td class="left">Последнее подключение</td>
				<td class="left">UserAgent</td>
				<td class="left">Блокировать</td>
			</tr>
		</thead>
		<tbody>
			<?if(!empty($list)){
				foreach($list as $value){?>
					<tr data-id="<?=$value['id'];?>">
						<td><?=$value['ip'];?></td>
						<td><?=$value['sid']==0?'x-torg.com':'xt.ua';?></td>
						<td><?=isset($value['email'])?$value['email']:'-';?></td>
						<td><?=$value['connections'];?></td>
						<td><?=$value['last_connection'];?></td>
						<td><?=$value['user_agent'];?></td>
						<td><input type="checkbox" class="block_ip_js" <?=$value['block']==1?'checked':null;?>></td>
					</tr>
				<?}
			}?>
		</tbody>
	</table>
</form>
<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null;?>
<script>
	$(function(){
		$('.block_ip_js').on('click', function(){
			$.ajax({
				url: URL_base+'ajaxmonitoring',
				type: "POST",
				cache: false,
				dataType : "json",
				data: {
					action: 'blockIP',
					id: $(this).closest('tr').data('id'),
					block: $(this).is(':checked')
				}
			}).done(function(data){
				// console.log('data');
			});
		});
	});
</script>