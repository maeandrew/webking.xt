<h1><?=$h1?></h1>
<br>
<?print_r($list_types)?>
<?if(isset($list_types) && !empty($list_types)){?>
		print_r('111111');
	<div id="second_navigation">
		<ul class="second_nav_manu">
			<li><a href="#">Пуруру</a></li>

			<?foreach ($list_types as $f){?>
				<li><a href="<?=$f[0]['alias']?>"><?=$f[0]['type_name']?></a></li>
			<?}?>
		</ul>
		<div class="tabs-panel">

		</div>
	</div>
<?}else{?>
	<div class="notification warning">
		<span class="strong">Информация отсутствует</span>
	</div>
<?}?>
<script>
	$("#second_navigation").tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
	$("#second_navigation li").removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
</script>

<table>
	<tbody>
		<tr>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
</table>