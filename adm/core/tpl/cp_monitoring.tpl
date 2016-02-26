<h1><?=$h1?></h1>
<br>
<?if(isset($list_types) && !empty($list_types)){?>
	<div id="second_navigation">
		<ul class="second_nav_manu">
			<?foreach ($list_types as $f){?>
				<li><a href="<?=$f['alias']?>"><?=$f['type_name']?></a></li>
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

<table>
	<tbody>
		<tr>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
</table>