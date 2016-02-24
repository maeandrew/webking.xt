<h1><?=$h1?></h1>
<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null;?>
<table class = "list">
	<thead>
		<col width="5%">
		<col width="25%">
		<col width="25%">
		<col width="25%">
		<col width="20%">
		<tr>
			<td class="left"></td>
			<td class="left">Категория</td>
			<td class="left">Характеристика</td>
			<td class="left">Значение</td>
			<td class="center">Количество</td>
		</tr>
	</thead>
	<tbody>
		<? $i=$GLOBALS['Start'] + 1;
		foreach($list as $value){
		//print_r($value);?>
			<tr>
				<td><?=$i++?></td>
				<td><?=$value['name'];?></td>
				<td><?=$value['caption'];?></td>
				<td><?=$value['value'];?></td>
				<td class="center"><div data-target="unload_option" data-cat="<?=$value['id_category']?>" data-spec="<?=$value['id_caption']?>" data-val="<?=$value['value']?>" class="btn-m-default-inv open_modal"><?=$value['count'];?></div></td>
			</tr>
		<?}?>
	</tbody>
</table>
<script>
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
</script>
<div class="modal_hidden" id="unload_option">
	<ul id="list">
		
	</ul>
	<a href="#" class="close_modal icon-del">n</a>
</div>