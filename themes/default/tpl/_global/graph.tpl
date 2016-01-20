<?php
if(empty($data_graph) || $data_graph == 0){?>
	<div class="mdl-color--grey-100 mdl-cell--hide-phone clearfix">
		<div class="slider_wrap">
			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_1']?>" step="1" tabindex="0">
		</div>
		<div class="slider_wrap">
			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_2']?>" step="1" tabindex="0">
		</div>
		<div class="slider_wrap">
			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_3']?>" step="1" tabindex="0">
		</div>
		<div class="slider_wrap">
			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_4']?>" step="1" tabindex="0">
		</div>
		<div class="slider_wrap">
			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_5']?>" step="1" tabindex="0">
		</div>
		<div class="slider_wrap">
			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_6']?>" step="1" tabindex="0">
		</div>
		<div class="slider_wrap">
			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_7']?>" step="1" tabindex="0">
		</div>
		<div class="slider_wrap">
			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_8']?>" step="1" tabindex="0">
		</div>
		<div class="slider_wrap">
			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_9']?>" step="1" tabindex="0">
		</div>
		<div class="slider_wrap">
			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_10']?>" step="1" tabindex="0">
		</div>
		<div class="slider_wrap">
			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_11']?>" step="1" tabindex="0">
		</div>
		<div class="slider_wrap">
			<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_12']?>" step="1" tabindex="0">
		</div>
	</div>
<?}else{
	$values = array();
	foreach ($data_graph as $key => $val) {
		for($i=1; $i <= 12; $i++) {
			$values['value_'.$i][] = $val['value_'.$i];
		}
	}
	?>
	<div class="stat_year mdl-color--grey-100 mdl-cell--hide-phone clearfix">
		<?foreach($values as &$v){
			$v = array_sum($v)/count($v);?>
				<div class="slider_wrap">
					<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$v?>" step="0.1" tabindex="0" disabled>
				</div>
			<?
		}?>
		<a href="#" class="slide_all">Просмотреть</a>
	</div>
	<?//print_r($data_graph)?>
	<?foreach ($data_graph as $key => $val) {
		//globals $val["value"];
		?>
		<div class="stat_year mdl-color--grey-100 mdl-cell--hide-phone clearfix" style="display:none;">
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_1']?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_2']?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_3']?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_4']?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_5']?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_6']?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_7']?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_8']?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_9']?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_10']?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_11']?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['value_12']?>" step="1" tabindex="0">
			</div>
			<? if(is_null($val['name_user'])){ ?>
				<span>Добавил: <?=$val['name']?></span>
			<?}else{?>
				<span>Добавил: <?=$val['name_user']?></span>
			<?}?>
			<p>Статус: <?=$val['status']?></p>
		</div>
<?} }?>