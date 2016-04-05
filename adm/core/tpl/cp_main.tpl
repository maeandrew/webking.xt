<h1>Администрирование</h1>
<div class="homepage grid">
	<div class="row">
		<div class="col-md-4 col-sm-12">
			<a href="/adm/users/5/"class="top_block_wrap block animate">
				<div class="fsec fl bg-lblue color-white animate paper_shadow_1"><span class="admicon clients"></span></div>
				<div class="ssec fr animate">
					<span class="color-default">
						<?if($statistics[$today]['stat_regs']['count'] < $statistics[$yesterday]['stat_regs']['count']){?>
							<span class="icon-arrowdown">d</span>
						<?}elseif($statistics[$today]['stat_regs']['count'] > $statistics[$yesterday]['stat_regs']['count']){?>
							<span class="icon-arrowup">u</span>
						<?}?>
						<?=$statistics[$today]['stat_regs']['count'];?>/<?=$statistics[$yesterday]['stat_regs']['count'];?>
					</span>
					<span class="color-default animate sub">Новых клиентов</span>
				</div>
			</a>
		</div>
		<div class="col-md-4 col-sm-12">
			<a href="/adm/orders/"class="top_block_wrap block animate">
				<div class="fsec fl bg-red color-white animate paper_shadow_1"><span class="admicon orders"></span></div>
				<div class="ssec fr animate">
					<span class="color-default">
						<?if($statistics[$today]['stat_ords']['count'] < $statistics[$yesterday]['stat_ords']['count']){?>
							<span class="icon-arrowdown">d</span>
						<?}elseif($statistics[$today]['stat_ords']['count'] > $statistics[$yesterday]['stat_ords']['count']){?>
							<span class="icon-arrowup">u</span>
						<?}?>
						<?=$statistics[$today]['stat_ords']['count'];?>
					</span>
					<span class="color-default animate sub">Новых заказов</span>
				</div>
			</a>
		</div>
		<div class="col-md-4 col-sm-12">
			<a href="/adm/coment/"class="top_block_wrap block animate">
				<div class="fsec fl bg-purple color-white animate paper_shadow_1"><span class="admicon reviews"></span></div>
				<div class="ssec fr animate">
					<span class="color-default">
						<?if($statistics[$today]['stat_comm']['count'] < $statistics[$yesterday]['stat_comm']['count']){?>
							<span class="icon-arrowdown">d</span>
						<?}elseif($statistics[$today]['stat_comm']['count'] > $statistics[$yesterday]['stat_comm']['count']){?>
							<span class="icon-arrowup">u</span>
						<?}?>
						<?=$statistics[$today]['stat_comm']['count'];?>
					</span>
					<span class="color-default animate sub">Новых отзывов</span>
				</div>
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-sm-12">
			<div class="block">
				<h2>Новых клиентов</h2>
				<canvas id="myChart" class="chart"></canvas>
			</div>
		</div>
		<div class="col-md-6 col-sm-12">
			<div class="block">
				<h2>Заказов</h2>
				<div class="title">
					<span class="this_year"> - Текущий год</span>
					<span class="last_year"> - Прошедший год</span>
				</div>
				<canvas id="last_orders_count" class="chart"></canvas>
			</div>
		</div>
	</div>
	<!-- Функции ручного запуска -->
	<div class="control_functions_wrapp">
		<div class="row">
			<div class="col-md-9 col-sm-12">
				<div class="block">
					<h2>Последние отзывы</h2>
					<?if(isset($comments) && !empty($comments)){?>
						<a href="/adm/coment/" class="title">Посмотреть все</a>
						<table class="list" width="100%" border="0" cellspacing="0" cellpadding="0">
							<thead>
								<tr>
									<th colspan="1">Автор</th>
									<th colspan="1">Комментарий</th>
									<th colspan="1">Дата</th>
								</tr>
							</thead>
							<colgroup>
								<col width="20%">
								<col width="60%">
								<col width="20%">
							</colgroup>
							<tbody>
								<?$i = 0;
								while($i < 4){?>
									<tr>
										<td><?=($comments[$i]['username']);?></td>
										<td><?=($comments[$i]['text_coment']);?></td>
										<td><?=date("d-m-Y в H:i", strtotime($comments[$i]['date_comment']));?></td>
									</tr>
									<?$i++;
								}?>
							</tbody>
						</table>
					<?}else{?>
						В данный момент нет ни одного отзыва
					<?}?>
				</div>
			</div>
			<div class="col-md-3 col-sm-12 col-xs-12">
				<div class="block drystats">
					<h2>Сухие цифры</h2>
					<table class="list">
						<colgroup>
							<col width="80%">
							<col width="20%">
						</colgroup>
						<tbody>
							<tr>
								<td>Категорий:</td>
								<td><b><?=$cat_cnt?></b></td>
							</tr>
							<tr>
								<td>Товаров:</td>
								<td><b><?=$items_cnt?></b></td>
							</tr>
							<tr>
								<td>Товаров в продаже:</td>
								<td><b><?=$active_tov?></b></td>
							</tr>
							<tr>
								<td>Подписаных клиентов:</td>
								<td><b><?=$subscribed_cnt?></b></td>
							</tr>
							<tr>
								<td>Последний артикул:</td>
								<td><b><?=$last_article?></b></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="block">
			<h2>Функции ручного управления</h2>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list">
				<colgroup>
					<col width="85%">
					<col width="15%">
				</colgroup>
				<tbody>
					<?if(isset($_SESSION['member']) && ($_SESSION['member']['gid'] == _ACL_ADMIN_ || $_SESSION['member']['gid'] == _ACL_SEO_)){?>
						<form action="<?=$GLOBALS['URL_request']?>" method="post">
							<tr>
								<td>
									<label>Статусы товаров</label>
								</td>
								<td>
									<button type="submit" id="form_submit" class="btn-m-green size_s fr" name="update_statuses">Обновить</button>
								</td>
							</tr>
							<tr>
								<td>
									<label>Хиты продаж</label>
								</td>
								<td>
									<button type="submit" id="form_submit" class="btn-m-green size_s fr" name="update_statuses_hit">Обновить</button>
								</td>
							</tr>
							<tr>
								<td>
									<label>Популярные товары</label>
								</td>
								<td>
									<button type="submit" id="form_submit" class="btn-m-green size_s fr" name="update_popular">Обновить</button>
								</td>
							</tr>
							<tr>
								<td>
									<label>Сортировка товаров</label>
								</td>
								<td>
									<button type="submit" id="form_submit" class="btn-m-green size_s fr" name="update_prodazi">Обновить</button>
								</td>
							</tr>
						</form>
					<?}?>
				</tbody>
			</table>
			<hr>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list">
				<colgroup>
					<col width="85%">
					<col width="15%">
				</colgroup>
				<tbody>
					<?if(isset($_SESSION['member']) && $_SESSION['member']['gid'] == _ACL_ADMIN_){?>
						<tr>
							<td>
								<label>Пересчитать все цены товаров на сайте</label>
							</td>
							<td>
								<a class="btn-m-lblue size_s fr" href="/adm/main/recalc_supplier_prices/">Пересчитать</a>
							</td>
						</tr>
						<tr>
							<td>
								<label>Убрать позиции с нулевым лимитом с сайта</label>
							</td>
							<td><a class="btn-m-lblue size_s fr" href="/adm/main/recalc_null/">Убрать</a></td>
						</tr>
					<?}?>
					<tr>
						<form action="<?=$GLOBALS['URL_request']?>" method="post">
							<td>
								<label>Заполнить таблицу поиска</label>
								<input type="text" name="name_index_status" class="hidden" value="1">
							</td>
							<td>
								<button type="submit" class="btn-m-lblue size_s fr">Заполнить</button>
							</td>
						</form>
					</tr>
					<tr>
						<form action="/adm/product_report" method="post" style="clear: both; padding-top: 20px;">
							<td>
								<label for="show_list" class="fl">Показать список товаров, с указанной разбежностью цен по поставщикам (%)</label>
								<input type="text" name="diff" id="show_list" class="input-m size_s fr">
							</td>
							<td>
								<button type="submit" id="diff" class="btn-m-lblue size_s fr" name="check">Показать</button>
							</td>
						</form>
					</tr>
				</tbody>
			</table>
			<hr>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list">
				<colgroup>
					<col width="85%">
					<col width="15%">
				</colgroup>
				<tbody>
					<?if($_SESSION['member']['gid'] == _ACL_ADMIN_){?>
						<tr>
							<td>
								<form id="image_resize" action="<?=$GLOBALS['URL_base'];?>adm/main/new_resize_product_images/" method="POST">
									<label class="fд">Создание уменьшенных копий изображений товаров в отдельной папке на сервере.</label>
									<label class="fr" title="Удалить существующие миниатюры и создать их заново.">Пересоздать <input type="checkbox" name="resize_all" id="resize_all"></label>
								</form>
							</td>
							<td>
								<button type="submit" name="image_resize" form="image_resize" class="btn-m-red size_s fr">Создать</button>
								<!-- <a title="Создание уменьшенных копий изображений товаров в отдельной папке на сервере." href="" class="btn-m-red size_s fr">Создать</a> -->
								<!-- <a title="Создание уменьшенных копий изображений товаров в отдельной папке на сервере." href="/adm/main/gen_resize_product_images/" class="btn-m-red size_s fr">Выполнить</a> -->
							</td>
						</tr>
						<tr>
							<td>
								<label for="kurs_griwni" class="fl">Пересчитать все цены поставщиков по курсу</label>
								<input type="text" name="kurs_griwni" id="kurs_griwni" class="input-m size_s fr">
							</td>
							<td>
								<button type="submit" id="form_submit" class="btn-m-red size_s fr" name="kurs">Пересчитать</button>
							</td>
						</tr>
						<tr>
							<td>
								<label for="date" class="fl">Очистить базу, удалив заказы, оформленные ранее выбранной даты (дд.мм.гггг).</label>
								<input type="text" name="date" id="date" class="input-m size_s fr">
							</td>
							<td>
								<button type="submit" class="size_s fr btn-m-red" name="smb" onclick="return confirm('Вы точно хотите очистить базу!?');">Очистить</button>
							</td>
						</tr>
					<?}?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?foreach(array_reverse($week_stats) AS $k=>$v){
	$labels[] = date('d.m', strtotime($k));
	$chart_ords[] = $v['chart_ords']['count'];
	$chart_ords_ly[] = $v['chart_ords_ly']['count'];
	$chart_regs[] = $v['chart_regs']['count'];
}?>
<script>
	$(function(){
		var options = {
			bezierCurve : true,
			scaleShowGridLines : true,
			scaleShowLabels: true
		}
		var data = {
			labels: <?=json_encode($labels);?>,
			datasets: [
				{
					label: "Регистраций",
					fillColor: "rgba(101,224,252,0.2)",
					strokeColor: "rgba(101,224,252,1)",
					pointColor: "rgba(101,224,252,1)",
					pointStrokeColor: "#fff",
					pointHighlightFill: "#fff",
					pointHighlightStroke: "rgba(101,224,252,1)",
					data: <?=json_encode($chart_regs);?>
				}
			]
		};
		var ctx = document.getElementById("myChart").getContext("2d");
		var myLineChart = new Chart(ctx).Line(data, options);
		var data = {
			labels: <?=json_encode($labels);?>,
			datasets: [
				{
					label: "Заказов",
					fillColor: "rgba(255,64,64,0.2)",
					strokeColor: "rgba(255,64,64,1)",
					pointColor: "rgba(255,64,64,1)",
					pointStrokeColor: "#fff",
					pointHighlightFill: "#fff",
					pointHighlightStroke: "rgba(255,64,64,1)",
					data: <?=json_encode($chart_ords);?>
				},
				{
					label: "Заказов",
					fillColor: "rgba(255,235,59,0.235",
					strokeColor: "rgba(255,235,59,1)",
					pointColor: "rgba(255,235,59,1)",
					pointStrokeColor: "#fff",
					pointHighlightFill: "#fff",
					pointHighlightStroke: "rgba(255,235,59,1)",
					data: <?=json_encode($chart_ords_ly);?>
				}
			]
		};
		var ctx2 = document.getElementById("last_orders_count").getContext("2d");
		var myLineChart2 = new Chart(ctx2).Line(data, options);
		var chart1;
	});
</script>