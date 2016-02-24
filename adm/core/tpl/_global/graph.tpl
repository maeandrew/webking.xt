<h1>Графики спроса</h1>
<?if(isset($data_graph) && !empty($data_graph)){
	$values = array();
	foreach($data_graph as $key => $val) {
		for($i=1; $i <= 12; $i++) {
			if($val['opt'] == 0){
				$values[$val['id_graphics']]['mopt'][] = $val['value_'.$i];
			}else{
				$values[$val['opt']]['opt'][] = $val['value_'.$i];
			}
		}
	}
	$labels = array( 'январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь');
	$labels_min = array(1);
	$chart_regi = array(10);?>
	<div id="flex" style="display:flex;  justify-content:space-around;flex-wrap: wrap;width:100%;">
		<?$a = 1;?>
		<script>
			var curve = {};
		</script>
		<?foreach($data_graph as $key => $val){
			unset($chart_ords);
			if($val['opt'] == 0){?>
				<div class="stat_years mdl-color--grey-100 mdl-cell--hide-phone clearfix" style="flex-grow:0;flex-shrink:0;flex-basis:100%; width:100%;">

					<?for ($i=1; $i <= 12; $i++){
						$chart_ords[] = round($val['value_'.$i]*10);?>
						<input class="hidden" type="range" min="0" max="10" value="<?=$val['value_'.$i]?>" step="1" tabindex="0">
					<?}?>
					<div style="width:25%;position: relative;float:left;">
						<?if(isset($val['name_user'])){ ?>
							<p>Добавил: <?=$val['name_user']?></p>
						<?}elseif(isset($val['name'])){?>
							<p>Добавил: <?=$val['name']?></p>
						<?}else{?>
							<p>Добавил: Неизвестный</p>
						<?}?>
						<br><a href="<?=$GLOBALS['URL_base'].$val['translit']['translit']?>"><?=$val['name']['name']?></a>
						<p>Создан: <?=$val['creation_date']?></p>
						<!-- <p style="margin-top:-70px;">Категория: <?=$val['id_category']?></p> -->
					</div>
					<div style="width:50%;position: relative;float:left;">
						<canvas id="charts_<?=$a?>" class="chart" height="100" style="position: relative;height:100px;width:100% !important;"></canvas>
					</div>
					<script>
						var options = {
							bezierCurve: true,
							scaleShowGridLines: true,
							scaleShowLabels: false,
							scaleShowHorizontalLines: false,
							pointDot: false,
							pointHitDetectionRadius: 30,
							datasetFill: false,
						};
						curve[<?=$a?>] = {
							labels: <?=json_encode($labels);?>,
							datasets: [
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
								},
								{
									label: "Розница",
									strokeColor: "rgba(1,139,6,0.5)",
									pointStrokeColor: "rgba(1,139,6,.7)",
									pointHighlightFill: "rgba(1,139,6,1)",
									pointHighlightStroke: "transparent",
									data: <?=json_encode($values[$val['id_graphics']]['mopt']);?>
								},
								{
									label: "Опт",
									fillColor: "rgba(101,224,252,0)",
									strokeColor: "rgba(255,139,6,.7)",
									pointStrokeColor: "transparent",
									pointHighlightFill: "transparent",
									pointHighlightStroke: "rgba(101,224,253,1)",
									data: <?=json_encode($values[$val['id_graphics']]['opt']);?>
								}
							]
						};
						$(function(){
							var ctx = document.getElementById("charts_<?=$a?>").getContext("2d");
							var myLineChart = new Chart(ctx).Line(curve[<?=$a?>], options);
						});
					</script>

					<div class="moderations" data-id="<?=$val['id_graphics']?>">
						<p style="padding-left: 100px;"><b>Модерация</b></p>
						<span class="legenda" style="width:100px"><i></i> - Оптовый</span>
						<p><input type="checkbox" name="option1" value="<?=$val['id_graphics']?>" <?=isset($val['moderation']) && $val['moderation'] != 0?'checked':''?>>Пройдена</p>
						<br>
				<?php $a++; ?>
			<?}else{?>
						<span class="legenda" style="width:100px"><i style="background: rgb(255,139,6);"></i> - Розничный</span>
						<p><input type="checkbox" name="option2" value="<?=$val['id_graphics']?>" class="opt" <?=isset($val['moderation']) && $val['moderation'] != 0?'checked':''?>>Пройдена</p>
					</div>
				</div>
			<?}?>
		<?}?>
	</div>
	<style>
		.moderations{float:right;position:relative;width:25%;padding-left: 20px;}
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
			float: left;
			clear: both;
		}
		.legenda i {
			content: "";
			display: inline-block;
			width: 10px;
			height: 10px;
			background: rgb(1,139,6);
		}
		#top_block_graph :nth-child(4){
			background: rgb(123, 192, 126);
			margin-left: 11px;

		}
		.material-icons {
			margin-right: 0;
		}
	</style>
<?}?>