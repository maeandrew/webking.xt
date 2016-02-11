<h1><?=$h1?></h1>
<span class="icon-option open_modal" data-target="unload_option" title="Настроить выгрузку">o</span>
<table>
	<tbody>
		<?foreach($list as $value){?>
			<tr>
				<td><?=$value['name'];?></td>
				<td><?=$value['caption'];?></td>
				<td><?=$value['value'];?></td>
			</tr>
		<?}?>
	</tbody>
</table>
<div class="modal_opened" id="unload_option">
	<ul id="list">
		
	</ul>
	<a href="#" class="close_modal icon-del">n</a>
</div>