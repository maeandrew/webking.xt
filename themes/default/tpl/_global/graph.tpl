<?if(isset($data_graph) && !empty($data_graph)){?>
	<div class="stat_year mdl-color--grey-100 mdl-cell--hide-phone clearfix">
		<div class="parent_opacity_line" style="position: relative;padding:0 0 10px 50px;">
			<?if(isset($_SESSION['member'])){?>
				<div id="top_block_graph">
					<span>График спроса</span>
					<span style="margin-left: 130px;margin-right: 20px;"><!-- Легенда:  --></span>
					<span class="legenda"></span> - Оптовый
					<span class="legenda"></span> - Розничный
					<div style="float:right;right:1px;display:block;position:relative;">
						<div id="tt7" class="icon material-icons">
							<a href="#" class="down_graph"><i class="material-icons">close</i></a>
						</div>
						<div class="mdl-tooltip" for="tt7">Скрыть</div>
					</div>
					<div id="user_bt" style="float:right;right: 5px;display:block;position:relative;">
						<div id="tt3" class="icon material-icons">
							<a href="#" onclick="ModalGraph()"><i class="material-icons">add</i></a>
						</div>
						<div class="mdl-tooltip" for="tt3">Добавить мнение</div>
					</div>
					<div id="icon_graph" class="icon" style="display:block;position:relative;float:right;right:10px;">
						<a href="#" class="slide_all"><i class="material-icons">details</i></a>
					</div>
					<div class="mdl-tooltip" for="icon_graph">Просмотреть</div>
				</div>
			<?}?>
			<div class="opacity_line"></div>
			<canvas id="last_orders_count" height="200" style="position: relative;"></canvas>
		</div>
		<?php
		$values = array();
		foreach ($data_graph as $key => $val) {
			for($i=1; $i <= 12; $i++) {
				$values['value_'.$i][] = $val['value_'.$i];
			}
		}?>

		<?foreach($values as &$v){
			$v = array_sum($v)/count($v);
			$chart_ords[] = round($v*10);
		}
		$labels = array( 'январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь');
		$labels_min = array(1);
		$chart_regs = array(24,59,44);
		$chart_regi = array(99);
		$chart_ords_ly = array(24,29,24,28,39,34,34,35,27,29,25,24);
		?>
		<script>
			var options = {
				bezierCurve: true,
				scaleShowGridLines: true,
				scaleShowLabels: false,
				scaleShowHorizontalLines: false,
				pointDot: false,
				pointHitDetectionRadius: 30,
				datasetFill: false,
			},
			curve = {
				labels: <?=json_encode($labels);?>,
				datasets: [
					{
						label: "Заказов",
						strokeColor: "rgba(1,139,6,0.5)",
						pointStrokeColor: "rgba(1,139,6,1)",
						pointHighlightFill: "rgba(1,139,6,1)",
						pointHighlightStroke: "transparent",
						data: <?=json_encode($chart_ords);?>
					},
					{
						label: "Регистраций",
						fillColor: "rgba(101,224,252,0)",
						strokeColor: "rgba(1,139,6,1)",
						pointStrokeColor: "transparent",
						pointHighlightFill: "transparent",
						pointHighlightStroke: "rgba(101,224,253,1)",
						data: <?=json_encode($chart_regi);?>
					},
					{
						label: "Регистраций",
						fillColor: "rgba(101,224,252,0)",
						strokeColor: "rgba(1,139,6,1)",
						pointStrokeColor: "transparent",
						pointHighlightFill: "transparent",
						pointHighlightStroke: "rgba(101,224,253,1)",
						data: <?=json_encode($labels_min);?>
					}
				]
			};
			$(function(){
				var ctx = document.getElementById("last_orders_count").getContext("2d");
				var myLineChart = new Chart(ctx).Line(curve, options);
			});
		</script>

		<div id="flex" style="display:flex;  justify-content:space-around;flex-wrap: wrap;width:100%;">
			<? $a = 1;?>
			<?foreach($data_graph as $key => $val){
				unset($chart_ords);?>
				<div class="stat_years mdl-color--grey-100 mdl-cell--hide-phone clearfix" style="flex-grow:0;flex-shrink:0;flex-basis:25%;margin-top: 2em; display:none;">
					<?for ($i=1; $i <= 12; $i++){
						$chart_ords[] = round($val['value_'.$i]*10);?>
						<input class="hidden" type="range" min="0" max="10" value="<?=$val['value_'.$i]?>" step="1" tabindex="0">
					<?}?>
					<canvas id="charts_<?=$a?>" height="100" style="position: relative;"></canvas>
					<script>

						$(function(){
							$('.stat_years').slideUp();
							curve = {
								labels: <?=json_encode($labels_min);?>,
								datasets: [
									{
										label: "Заказов",
										strokeColor: "rgba(1,139,6,0.5)",
										pointStrokeColor: "rgba(1,139,6,1)",
										pointHighlightFill: "rgba(1,139,6,1)",
										pointHighlightStroke: "transparent",
										data: <?=json_encode($chart_ords);?>
									},
									{
										label: "Регистраций",
										fillColor: "rgba(101,224,252,0)",
										strokeColor: "rgba(1,139,6,1)",
										pointStrokeColor: "transparent",
										pointHighlightFill: "transparent",
										pointHighlightStroke: "rgba(101,224,253,1)",
										data: <?=json_encode($chart_regi);?>
									}
								]
							};
							var ctx = document.getElementById("charts_<?=$a?>").getContext("2d");
							var myLineChart = new Chart(ctx).Line(curve, options);
						});
					</script>
					<?if(isset($val['name_user'])){?>
						<p>Добавил: <?=$val['name_user']?></p>
						<p>Создан: <?=$val['creation_date']?></p>
					<?}elseif(isset($val['name'])){?>
						<p>Добавил: <?=$val['name']?></p>
						<p>Создан: <?=$val['creation_date']?></p>
					<?}else{?>
						<p>Добавил: Test</p>
					<?}?>
					<?if(isset($val['name']) && $val['name'] == $_SESSION['member']['name']){?>
						<br><a style="float:left;" onclick="ModalGraph(<?=$val['id_graphics']?>)">Редактирование</a>
					<?}else{?>
						<br><a style="float:left;" onclick="ModalGraph(<?=$val['id_graphics']?>)">Создать на основе</a>
					<?}?>
				</div>
				<?php $a++; ?>
			<?}?>
		</div>
		<style>
			#last_orders_count{
				height: 158px;
			}
			#top_block_graph .material-icons {
				font-size: 17px;
			}
			#top_block_graph{
				opacity: 0;
				z-index: 1000;
				-webkit-transition: all .4s cubic-bezier(.4,0,.2,1);
				-o-transition: all .4s cubic-bezier(.4,0,.2,1);
				transition: all .4s cubic-bezier(.4,0,.2,1);
			}
			.stat_year:hover #top_block_graph {
				opacity: 1 !important;
			}
			.parent_opacity_line .opacity_line {
					top: 33%;
					bottom: 33%;
					width: 100%;
					position: absolute;
					opacity: 1;
					background-color: #fff;
					margin-left: -49px;
			}
			.ones {
				position: absolute;
				top: 40px;
				left: 10px;
			}
			.stat_year {
				padding: 0 !important;
			}
			.ones:nth-child(2) {top: 85px;z-index: 11;}
			.ones:nth-child(3) {top: 132px;}
			.legenda {
				content: "";
				display: inline-block;
				width: 10px;
				height: 10px;
				background: rgb(250, 166, 140);

			}
			#top_block_graph :nth-child(4){
				background: rgb(123, 192, 126);
				margin-left: 11px;

			}
			.material-icons {
				margin-right: 0;
			}
		</style>
	</div>
<?}?>