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
					<!-- <a href="#" class="checkout btn_js" data-name="graph" onclick="ModalGraph()">Добавить мнение</a> -->

					<div id="tt7" class="icon material-icons"><a href="#" class="down_graph"><i class="material-icons">close</i></a></div>
					<div class="mdl-tooltip" for="tt7">
					Скрыть
					</div>
				</div>
				<div id="user_bt" style="float:right;right: 5px;display:block;position:relative;">
					<!-- <a href="#" class="checkout btn_js" data-name="graph" onclick="ModalGraph()">Добавить мнение</a> -->

					<div id="tt3" class="icon material-icons"><a href="#" onclick="ModalGraph()"><i class="material-icons">add</i></a></div>
					<div class="mdl-tooltip" for="tt3">
					Добавить мнение
					</div>
				</div>
				<div id="icon_graph" class="icon" style="display:block;position:relative;float:right;right:10px;">
					<a href="#" class="slide_all">
						<i class="material-icons">details</i>
					</a>
				</div>
				<div class="mdl-tooltip" for="icon_graph">
					Просмотреть
				</div>
			</div>
		<?}?>
		<!-- <div class="ones">Горячо</div>
		<div class="ones">Горячо</div>
		<div class="ones">Горячо</div> -->

		<div class="opacity_line"></div>

		<canvas id="last_orders_count" height="200" style="position: relative;"></canvas>
	</div>
<?php
/*if($data_graph){
	print_r($data_graph);
}else{*/
$values = array();
foreach ($data_graph as $key => $val) {
	for($i=1; $i <= 12; $i++) {
		$values['value_'.$i][] = $val['value_'.$i];
	}
}
?>

<?foreach($values as &$v){
	$v = array_sum($v)/count($v);
	$chart_ords[] = round($v*10);
}
$labels = array( 'январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь');
$labels_min = array(1,2,3,4,5,6,7,8,9,10,11,12);
$chart_regs = array(24,59,44);
$chart_regi = array(99);
$chart_ords_ly = array(24,59,44,24,59,44,24,59,44,24,59,44);
?>
	<!-- <div class="slider_wrap">
		<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$v?>" step="0.1" tabindex="0" disabled>
	</div> -->

	<style>
		#last_orders_count{
			height: 158px;
		}
	</style>
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
				}
			]
		};
		$(function(){
			console.log(curve);
			var ctx = document.getElementById("last_orders_count").getContext("2d");
			var myLineChart = new Chart(ctx).Line(curve, options);
		});
	</script>

	<!-- <div id="header">
		    <button title="Zoom in on selected data" id="keep-data" disabled="disabled">Keep</button>
		    <button title="Remove selected data" id="exclude-data" disabled="disabled">Exclude</button>
		    <button title="Export data as CSV" id="export-data">Export</button>
		    <div class="controls">
		      <strong id="rendered-count"></strong>/<strong id="selected-count"></strong><strong id="data-count"></strong>
		      <div class="fillbar"><div id="selected-bar"><div id="rendered-bar">&nbsp;</div></div></div>
		      Загрузка <strong id="opacity"></strong> готово.
		      <span class="settings">
		        <button id="hide-ticks">Hide Ticks</button>
		        <button id="show-ticks" disabled="disabled">Show Ticks</button>
		        <button id="dark-theme">Dark</button>
		        <button id="light-theme" disabled="disabled">Light</button>
		      </span>
		    </div>
		    <div style="clear:both;"></div>
		  </div>
		  <div id="chart">
		    <canvas id="background"></canvas>
		    <canvas id="foreground"></canvas>
		    <canvas id="highlight"></canvas>
		    <svg></svg>
		  </div>
		  <div id="wrap">
		    <div class="third" id="controls">

		    </div>
		    <div  class="third">
		      <small>
		        Last rendered <strong id="render-speed"></strong> lines
		      </small>
		      <h3>Группы графиков</h3>
		      <p id="legend">
		      </p>
		    </div>
		    <div class="third">
		      <h3>25 записей <input type="text" id="search" placeholder="Искать..."/></h3>
		      <p id="food-list">
		      </p>
		    </div>
		  </div> -->

		  	<!-- <a href="#" class="slide_all" style="display:block;position:relative;top:-157px;float:right;right:50px;">
		  				<i class="material-icons">remove_red_eye</i>
		  			</a> -->
			<!-- <div id="icon_graph" class="icon material-icons" style="display:block;position:relative;top:-157px;float:right;right:40px;">
				<a href="#" class="slide_all">
					<i class="material-icons">remove_red_eye</i>
				</a>
			</div>
			<div class="mdl-tooltip" for="icon_graph">
			Просмотреть
			</div>
	-->

<!--
<canvas id="last_orders_count" height="200" style="position: relative;"></canvas> -->
<div id="flex" style="display:flex;  justify-content:space-around;flex-wrap: wrap;width:100%;">
	<? $a = 1;?>
	<?foreach ($data_graph as $key => $val) {
		//globals $val["value"];
		unset($chart_ords);
		?>

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


		<? if(isset($val['name_user'])){ ?>
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
/* 	.parent_opacity_line .opacity_line:first-child {
	height: 65px;
	width: 100%;
	position: absolute;
	opacity: 0.1;
	background-color: red;
} */
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
	/* .parent_opacity_line .opacity_line:last-child {
		height: 65px;
		top:130px;
		width: 100%;
		position: absolute;
		opacity: 0.1;
		background-color: green;
	} */


</style>
</div>

<?}?>