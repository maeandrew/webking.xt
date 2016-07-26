<?$values = array();
print_r($chart);
foreach($chart as $key => $val){
	for($i=1; $i <= 12; $i++) {
		if($val['opt'] == 0 && $val['count'] > 0){
			$values['mopt'][] = $val['value_'.$i];
		}elseif($val['opt'] == 1 && $val['count'] > 0){
			$values['opt'][] = $val['value_'.$i];
		}
	}
}
$labels = array( 'январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь');
$labels_min = array(1);
$chart_regi = array(10);?>
<div class="flex_container">
	<script>var curve = {};</script>
	<canvas id="chart_<?=isset($chart['id_chart'])?$chart['id_chart']:'avg';?>" class="chart" height="150"></canvas>
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
		curve = {
			labels: <?=json_encode($labels);?>,
			datasets: [
				{
					label: "",
					fillColor: "rgba(101,224,252,0)",
					strokeColor: "rgba(1,139,6,1)",
					pointStrokeColor: "transparent",
					pointHighlightFill: "transparent",
					pointHighlightStroke: "rgba(101,224,253,1)",
					data: <?=json_encode($chart_regi);?>
				},
				{
					label: "",
					fillColor: "rgba(101,224,252,0)",
					strokeColor: "rgba(1,139,6,1)",
					pointStrokeColor: "transparent",
					pointHighlightFill: "transparent",
					pointHighlightStroke: "rgba(101,224,253,1)",
					data: <?=json_encode($labels_min);?>
				},
				<?if (isset($values['mopt'])){?>
					{
						label: "Розница",
						strokeColor: "#018b06",
						pointStrokeColor: "rgba(1,139,6,.7)",
						pointHighlightFill: "#018b06",
						pointHighlightStroke: "transparent",
						data: <?=json_encode($values['mopt']);?>
					},
				<?}
				if (isset($values['opt'])){?>
					{
						label: "Опт",
						fillColor: "rgba(101,224,252,0)",
						strokeColor: "#FF5722",
						pointStrokeColor: "transparent",
						pointHighlightFill: "#FF5722",
						pointHighlightStroke: "rgba(101,224,253,1)",
						data: <?=json_encode($values['opt']);?>
					}
				<?}?>
			]
		};
		$(function(){
			var ctx = document.getElementById("chart_<?=isset($chart['id_chart'])?$chart['id_chart']:'avg';?>").getContext("2d");
			var myLineChart = new Chart(ctx).Line(curve, options);
		});
	</script>
</div>