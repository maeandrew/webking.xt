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
	<canvas id="last_orders_count" height="200" style="position: relative;"></canvas>

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
		</div> -->





	<?//print_r($data_graph)?>
	<?foreach ($data_graph as $key => $val) {
		//globals $val["value"];
		?>
		<div class="stat_year mdl-color--grey-100 mdl-cell--hide-phone clearfix" style="display:none;">
			<!-- <div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_1']?>" step="1" tabindex="0">
			</div> -->
			<?for ($i=1; $i <= 12; $i++){?>
				<div class="slider_wrap">
					<input class="mdl-slider mdl-js-slider value_<?=$i?>" type="range" min="0" max="10" value="<?=$val['value_'.$i]?>" step="1" tabindex="0">
				</div>
			<?}?>

			<? if(empty($val['name_user'])){ ?>
				<span>Добавил: <?=$val['name']?></span>
			<?}else{?>
				<span>Добавил: <?=$val['name_user']?></span>
			<?}?>
			<p>Статус: <?=$val['status']?></p>
			<?if($val['name'] == $_SESSION['member']['name']){?>
				<a style="float:right" onclick="ModalGraph(<?=$val['id_graphics']?>)">Редактирование</a>
			<?}else{?>
				<a style="float:right" onclick="ModalGraph(<?=$val['id_graphics']?>)">Создать на основе</a>
			<?}?>
		</div>
<?}?>
	<script>
	$(function(){
		var options = {
			bezierCurve : true,
			scaleShowGridLines : true,
			scaleShowLabels: false,
			scaleShowHorizontalLines: true

		}
		/*var data = {
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
		var myLineChart = new Chart(ctx).Line(data, options);*/
		var data = {
			labels: <?=json_encode($labels);?>,
			datasets: [
				{
					label: "Заказов",
					fillColor: "rgba(101,224,252,0)",
					strokeColor: "rgba(255,87,34,0.5)",

					pointStrokeColor: "transparent",
					pointHighlightFill: "transparent",
					pointHighlightStroke: "rgba(101,224,252,1)",
					data: <?=isset($chart_ords)?json_encode($chart_ords):'null';?>
				},
				{
					label: "Заказов",
					fillColor: "rgba(255,255,255,0)",
					strokeColor: "rgba(1,139,6,0.5)",

					pointStrokeColor: "transparent",
					pointHighlightFill: "transparent",
					pointHighlightStroke: "rgba(255,235,59,0)",
					data: <?=json_encode($chart_ords_ly);?>
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
		var ctx2 = document.getElementById("last_orders_count").getContext("2d");
		var myLineChart2 = new Chart(ctx2).Line(data, options);
		var chart1;
	});
	</script>