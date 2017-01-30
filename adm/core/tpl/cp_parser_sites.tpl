<h1><?=$h1?></h1>
<div class="grid sites_list">
	<table class="list paper_shadow_1" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<td>ID</td>
				<td>Название</td>
				<td>id поставщика</td>
				<td>id категории</td>
				<td>Активный</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			<?if(!empty($sites)){
				foreach($sites as $site){?>
					<tr>
						<td><?=$site['id']?></td>
						<td><?=$site['title']?></td>
						<td><?=$site['id_supplier']?></td>
						<td><?=$site['id_category']?></td>
						<td><?=$site['active']==1?'Да':'Нет'?></td>
						<td>
							<a href="/adm/parser_sitesedit/<?=$site['id']?>" class="btn-m-green">Редактировать</a>
						</td>
					</tr>
				<?}
			}else{?>
				<tr>
					<td colspan="5">Нет ни одного сайта, но его все-еще можно добавить <a href="/adm/parser_siteadd/">здесь</a></td>
				</tr>
			<?}?>
		</tbody>
	</table>
</div>