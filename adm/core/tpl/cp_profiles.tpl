<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
		<thead>
			<tr>
				<td class="center">ID</td>
				<td class="left">Имя</td>
				<td class="center">Псевдоним</td>
				<td class="center">Пользователей</td>
				<td class="right"></td>
			</tr>
		</thead>
		<?if(!empty($list)){
			foreach($list as $value){?>
				<tr>
					<td class="center"><?=$value['id_profile'];?></td>
					<td class="left"><?=$value['name'];?></td>
					<td class="center"><?=$value['caption'];?></td>
					<td class="center"><?=$value['users_count'];?></td>
					<td class="right">
						<a href="/adm/profilesedit/<?=$value['id_profile'];?>" class="btn-m-green-inv">Изменить</button>
						<a href="/adm/permissions/<?=$value['id_profile'];?>" class="btn-m-orange-inv">Права доступа</button>
					</td>
				</tr>
			<?}
		}?>
	</table>
</form>