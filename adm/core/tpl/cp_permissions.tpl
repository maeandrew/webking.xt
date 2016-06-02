<ul>
	<?foreach($profiles_list as $profile){?>
		<li><a href="<?=_base_url?>/adm/permissions/<?=$profile['id_profile']?>/"><?=!empty($profile['caption'])?$profile['caption']:$profile['name'];?></a></li>
	<?}?>
</ul>
<form action="<?=$GLOBALS['URL_request']?>" method="post">
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
			foreach($current_profile['permissions'] as $value){?>
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