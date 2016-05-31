<form action="<?=$GLOBALS['URL_request']?>" method="post">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
		<thead>
			<tr>
				<td class="left">ID</td>
				<td class="left">name</td>
				<td class="center">caption</td>
				<td class="left"></td>
			</tr>
		</thead>
		<?if(!empty($list)){
			foreach($list as $value){?>
				<tr>
					<td><?=$value['id_profile'];?></td>
					<td><?=$value['name'];?></td>
					<td><?=$value['caption'];?></td>
					<td><a href="/adm/<?=$controller?>edit/<?=$value['id_profile'];?>" class="btn-m-green-inv">Редактировать</button></td>
				</tr>
			<?}
		}?>
	</table>
</form>