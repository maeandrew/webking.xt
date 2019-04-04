<h1><?=$h1?></h1>
<div class="grid cron_list">
	<table class="list paper_shadow_1" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<td>ID</td>
				<td>Название</td>
				<td>Год</td>
				<td>Месяц</td>
				<td>День</td>
				<td>Час</td>
				<td>Минута</td>
				<td>Последний запуск</td>
				<td>Активный</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			<?if(!empty($tasks)){
				foreach($tasks as $task){?>
					<tr>
						<td><?=$task['id']?></td>
						<td><?=$task['title']?></td>
						<td><?=$task['year']?></td>
						<td><?=$task['mon']?></td>
						<td><?=$task['mday']?></td>
						<td><?=$task['hours']?></td>
						<td><?=$task['minutes']?></td>
						<td><?=$task['last_run']?></td>
						<td><?=$task['active']==1?'Да':'Нет'?></td>
						<td>
							<!-- <a href="/adm/cronedit/<?=$task['id']?>" class="btn-m-green">Редактировать</a> -->
							<?if(strstr($task['title'], '***')){?>
          					 <a href="/adm/cronrun/<?=$task['id']?>" class="btn-m-blue">Выполнить</a>
        					<?}?>						
							<!-- <a href="/adm/crondel/<?=$task['id']?>" class="btn-m-red-inv">Удалить</a> -->
						</td>
					</tr>
				<?}
			}else{?>
				<tr>
					<td colspan="10">Нет ни одной задачи.</td>
				</tr>
			<?}?>
		</tbody>
	</table>
</div>