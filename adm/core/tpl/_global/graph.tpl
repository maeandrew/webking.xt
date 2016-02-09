<?php
	/*$values = array();
 	foreach ($data_graph as $key => $val) {
 		for($i=1; $i <= 12; $i++) {
 			$values['value_'.$i][] = $val['value_'.$i];
 		}
 	}*/
 	?>
<!-- 	<div class="stat_year mdl-color--grey-100 mdl-cell--hide-phone clearfix" style="margin-top:-500px;"></div>
 	<div class="stat_year mdl-color--grey-100 mdl-cell--hide-phone clearfix" style="transform: rotate(-90deg);margin-top:-500px;">
 	<? /* foreach($values as &$v){
 		$v = array_sum($v)/count($v);*/ ?>
 			<div class="slider_wrap">
 				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$v?>" step="0.1" tabindex="0" disabled>
 			</div>
 		<? //} ?>
 	<a href="#" class="slide_all">Просмотреть</a>
	</div>
 	<? /* foreach ($data_graph as $key => $val) {*/ ?>
	<div style="border-bottom:1px solid #000;display:flex;justify-content:space-around;">
		 	<div class="stat_year mdl-color--grey-100 mdl-cell--hide-phone clearfix" style="transform: rotate(-90deg);flex-basis:75%;clear:both;">
		 		<div class="slider_wrap">
		 			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_1']?>" step="1" tabindex="0" disabled>
		 		</div>
		 		<div class="slider_wrap">
		 			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_2']?>" step="1" tabindex="0" disabled>
		 		</div>
		 		<div class="slider_wrap">
		 			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_3']?>" step="1" tabindex="0" disabled>
		 		</div>
		 		<div class="slider_wrap">
		 			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_4']?>" step="1" tabindex="0" disabled>
		 		</div>
		 		<div class="slider_wrap">
		 			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_5']?>" step="1" tabindex="0" disabled>
		 		</div>
		 		<div class="slider_wrap">
		 			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_6']?>" step="1" tabindex="0" disabled>
		 		</div>
		 		<div class="slider_wrap">
		 			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_7']?>" step="1" tabindex="0" disabled>
		 		</div>
		 		<div class="slider_wrap">
		 			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_8']?>" step="1" tabindex="0" disabled>
		 		</div>
		 		<div class="slider_wrap">
		 			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_9']?>" step="1" tabindex="0" disabled>
		 		</div>
		 		<div class="slider_wrap">
		 			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_10']?>" step="1" tabindex="0" disabled>
		 		</div>
		 		<div class="slider_wrap">
		 			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_11']?>" step="1" tabindex="0" disabled>
		 		</div>
		 		<div class="slider_wrap">
		 			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_12']?>" step="1" tabindex="0" disabled>
		 		</div>
		 	</div>

		 	<div class="stat_years mdl-color--grey-100 mdl-cell--hide-phone clearfix" style="flex-grow:0;flex-shrink:0;flex-basis:25%;padding-top:50px;text-align:left;margin-top:-60px;">

		 		<? if(isset($val['name_user'])){ ?>
		 				<p>Добавил: <?=$val['name_user']?></p>
		 				<p>Создан: <?=$val['creation_date']?></p>
		 			<?}elseif(isset($val['name'])){?>
		 				<p>Добавил: <?=$val['name']?></p>
		 				<p>Создан: <?=$val['creation_date']?></p>
		 			<?}else{?>
		 				<p>Добавил: Незарегистрированный пользователь</p>
		 				<p>Создан: <?=$val['creation_date']?></p>
		 			<?}?>

		 		</div>
		 </div>
		 <? //} ?>
		 <style>
		 	.slider_wrap {
		 	    width: 8%;
		 	    position: relative;
		 	    float: left;
		 	    overflow: hidden;
		 	    height: 200px;
		 	}
		 </style>
-->

<h1>Графики спроса</h1>
<?print_r($data_graph[0]['translit']);?>
<?if(isset($data_graph) && !empty($data_graph)){
	$values = array();
	foreach($data_graph as $key => $val) {
		for($i=1; $i <= 12; $i++) {
			$values['value_'.$i][] = $val['value_'.$i];
		}
	}
	foreach($values as &$v){
		$v = array_sum($v)/count($v);
		$chart_ords[] = round($v*10);
	}
	$labels = array( 'январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь');
	$labels_min = array(1);
	$chart_regs = array(24,59,44);
	$chart_regi = array(99);
	$chart_ords_ly = array(24,59,44,24,59,44,24,59,44,24,59,44);
	?>
	<div id="flex" style="display:flex;  justify-content:space-around;flex-wrap: wrap;width:100%;">
		<? $a = 1;?>
		<script>
			var curve = {};
			// for (var i = 0; i < 10; i++) {
			// 	curve[i] = i;
			// };
			console.log(curve);
		</script>
		<?foreach ($data_graph as $key => $val) {
			//globals $val["value"];
			unset($chart_ords);
			?>

			<div class="stat_years mdl-color--grey-100 mdl-cell--hide-phone clearfix" style="flex-grow:0;flex-shrink:0;flex-basis:100%;">


				<?for ($i=1; $i <= 12; $i++){
					$chart_ords[] = round($val['value_'.$i]*10);?>
					<input class="hidden" type="range" min="0" max="10" value="<?=$val['value_'.$i]?>" step="1" tabindex="0">
				<?}?>
				<canvas id="charts_<?=$a?>" height="100" width="700" style="position: relative;margin-left:200px;"></canvas>
					<script>
						// curve[<?=$a?>] = <?=json_encode($chart_ords);?>;
					// var c = 0;
					// window['curve'+c] = c++;
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
					},
					{
						label: "Второй график",
						fillColor: "rgba(101,224,252,0)",
						strokeColor: "rgba(255,235,59,1)",
						pointStrokeColor: "transparent",
						pointHighlightFill: "transparent",
						pointHighlightStroke: "rgba(101,224,253,1)",
						data: <?=json_encode($chart_ords_ly);?>
					}
				]
			};
			$(function(){
				// console.log(curve);
				var ctx = document.getElementById("charts_<?=$a?>").getContext("2d");
				var myLineChart = new Chart(ctx).Line(curve[<?=$a?>], options);
			});
		</script>


			<? if(isset($val['name_user'])){ ?>
					<p style="margin-top:-70px;">Добавил: <?=$val['name_user']?></p>

				<?}elseif(isset($val['name'])){?>
					<p style="margin-top:-70px;">Добавил: <?=$val['name']?></p>

				<?}else{?>
					<p style="margin-top:-70px;">Добавил: Неизвестный</p>


				<?}?>

					<br><a style="float:left;" href="<?=$GLOBALS['URL_base'].$val['translit']['translit']?>">Категория</a>

					<p style="margin-top:-70px;">Создан: <?=$val['creation_date']?></p>
					<!-- <p style="margin-top:-70px;">Категория: <?=$val['id_category']?></p> -->

				  <form style="float:right;position:relative;">
					   <p><b>Модерация</b></p>
					   <p><input type="checkbox" name="option1" value="a1" checked>Пройдена<Br></p>
					   <!-- <p><input type="submit" value="Отправить"></p> -->
				  </form>
			</div>
			<?php $a++; ?>
		<?}?>
	</div>
	<script>
		// var curve = {};
		// for (var i = 0; i < 10; i++) {
		// 	curve[i] = i;
		// };
		console.log(curve);
	</script>
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

<?}?>