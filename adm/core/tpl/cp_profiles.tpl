<form action="<?=$GLOBALS['URL_request']?>" method="post">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
		<thead>
			<tr>
				<td class="center">ID</td>
				<td class="center">Имя</td>
				<td class="center">Псевдоним</td>
				<td class="center">Пользователей</td>
				<td class="right"></td>
			</tr>
		</thead>
		<?if(!empty($list)){
			foreach($list as $value){?>
				<tr>
					<td class="center"><?=$value['id_profile'];?></td>
					<td class="center"><?=$value['name'];?></td>
					<td class="center"><?=$value['caption'];?></td>
					<td class="center"><?=$value['users_count'];?></td>
					<td class="right"><a href="/adm/profilesedit/<?=$value['id_profile'];?>" class="btn-m-green-inv">Изменить</button></td>
				</tr>
			<?}
		}?>
	</table>
</form>