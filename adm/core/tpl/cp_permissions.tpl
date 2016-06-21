<div class="permissions">
	<h1><?=$h1;?></h1>
	<div class="row">
		<div class="col-md-3">
			<ul>
				<?foreach($profiles_list as $profile){?>
					<li class="<?=$profile['id_profile'] == $current_profile['id_profile']?'active':null?>">
						<a href="<?=_base_url?>/adm/permissions/<?=$profile['id_profile']?>/"><?=!empty($profile['caption'])?$profile['caption']:$profile;?></a>
					</li>
				<?}?>
			</ul>
		</div>
		<div class="col-md-9">
			<form action="<?=$GLOBALS['URL_request']?>" method="post">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
					<colgroup>
						<col width="40%"/>
						<col width="14%"/>
						<col width="14%"/>
						<col width="14%"/>
						<col width="14%"/>
						<col width="5%"/>
					</colgroup>
					<thead>
						<tr>
							<td class="left">Страница</td>
							<td class="center">Просмотр</td>
							<td class="center">Добавление</td>
							<td class="center">Редактирование</td>
							<td class="center">Удаление</td>
							<td class="center">Все</td>
						</tr>
					</thead>
					<?if(!empty($list)){
						foreach($list as $value){?>
							<tr class="controller">
								<td class="left"><?=$value;?></td>
								<td class="center"><input type="checkbox" class="" <?=$current_profile['permissions'][$value]['view'] == 1 || $current_profile['permissions'] == 1?'checked':null;?>/></td>
								<td class="center"><input type="checkbox" class="" <?=$current_profile['permissions'][$value]['add'] == 1 || $current_profile['permissions'] == 1?'checked':null;?>/></td>
								<td class="center"><input type="checkbox" class="" <?=$current_profile['permissions'][$value]['edit'] == 1 || $current_profile['permissions'] == 1?'checked':null;?>/></td>
								<td class="center"><input type="checkbox" class="" <?=$current_profile['permissions'][$value]['del'] == 1 || $current_profile['permissions'] == 1?'checked':null;?>/></td>
								<td class="center"><input type="checkbox" class="all" <?=($current_profile['permissions'][$value]['view'] == 1 && $current_profile['permissions'][$value]['add'] == 1 && $current_profile['permissions'][$value]['edit'] == 1 && $current_profile['permissions'][$value]['del'] == 1) || $current_profile['permissions'] == 1?'checked':null;?>/></td>
							</tr>
						<?}
					}?>
				</table>
			</form>
		</div>
	</div>
</div>