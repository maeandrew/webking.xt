<h3>График спроса (своя версия)</h3>
	<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
		<div class="mdl-tabs__tab-bar">
				<a href="#retail" class="mdl-tabs__tab is-active">Розница</a>
				<a href="#opt" class="mdl-tabs__tab">Опт</a>
		</div>
		<div class="mdl-tabs__panel is-active" id="retail">
			<div class="mdl-cell--hide-phone clearfix toggle one range_wrap">
				<?if(!empty($values)){?>
					<input type="hidden" name="roz_id_chart" value="<?=$values[0]['id_chart']?>">
					<?foreach($values[0] as $key => $value){
						// var_dump(strpos($key, 'value_'));
						if(strpos($key, 'value_') !== false){?>
							<div class="slider_wrap">
								<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$value?>" step="1" tabindex="0">
							</div>
						<?}
					}
				}else{?>
					<div class="slider_wrap">
						<input id="inr_1" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_1']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>январь</span>
					</div>
					<div class="slider_wrap">
						<input id="inr_2" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_2']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>февраль</span>
					</div>
					<div class="slider_wrap">
						<input id="inr_3" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_3']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>март</span>
					</div>
					<div class="slider_wrap">
						<input id="inr_4" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_4']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>апрель</span>
					</div>
					<div class="slider_wrap">
						<input id="inr_5" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_5']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>май</span>
					</div>
					<div class="slider_wrap">
						<input id="inr_6" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_6']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>июнь</span>
					</div>
					<div class="slider_wrap">
						<input id="inr_7" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_7']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>июль</span>
					</div>
					<div class="slider_wrap">
						<input id="inr_8" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_8']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>август</span>
					</div>
					<div class="slider_wrap">
						<input id="inr_9" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_9']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>сентябрь</span>
					</div>
					<div class="slider_wrap">
						<input id="inr_10" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_10']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>октябрь</span>
					</div>
					<div class="slider_wrap">
						<input id="inr_11" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_11']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>ноябрь</span>
					</div>
					<div class="slider_wrap">
						<input id="inr_12" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_12']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>декабрь</span>
					</div>
				<?}?>
			</div>
		</div>
		<div class="mdl-tabs__panel" id="opt">
			<div class="mdl-cell--hide-phone clearfix toggle two range_wrap">
				<?if(!empty($values)){?>
					<input type="hidden" name="opt_id_chart" value="<?=$values[1]['id_chart']?>">
					<?foreach($values[1] as $key => $value){
						if(strpos($key, 'value_') !== false){?>
							<div class="slider_wrap">
								<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$value?>" step="1" tabindex="0">
							</div>
						<?}
					}
				}else{?>
					<div class="slider_wrap">
						<input id="ino_1" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_1']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>январь</span>
					</div>
					<div class="slider_wrap">
						<input id="ino_2" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_2']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>февраль</span>
					</div>
					<div class="slider_wrap">
						<input id="ino_3" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_3']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>март</span>
					</div>
					<div class="slider_wrap">
						<input id="ino_4" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_4']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>апрель</span>
					</div>
					<div class="slider_wrap">
						<input id="ino_5" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_5']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>май</span>
					</div>
					<div class="slider_wrap">
						<input id="ino_6" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_6']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>июнь</span>
					</div>
					<div class="slider_wrap">
						<input id="ino_7" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_7']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>июль</span>
					</div>
					<div class="slider_wrap">
						<input id="ino_8" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_8']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>август</span>
					</div>
					<div class="slider_wrap">
						<input id="ino_9" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_9']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>сентябрь</span>
					</div>
					<div class="slider_wrap">
						<input id="ino_10" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_10']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>октябрь</span>
					</div>
					<div class="slider_wrap">
						<input id="ino_11" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_11']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>ноябрь</span>
					</div>
					<div class="slider_wrap">
						<input id="ino_12" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_12']:5?>" step="1" tabindex="0" oninput="СhangeValue($(this).attr('id'));">
						<div class="range_num">5</div>
						<span>декабрь</span>
					</div>
				<?}?>
			</div>
		</div>
	</div>
<!-- <div class="select_go" style="margin-top: 15px;margin-left: 77px;">

	<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-2">

	<span class="mdl-switch__label" style="float: left;margin-left: -130px;">Розница</span>

	<input type="checkbox" id="switch-2" class="mdl-switch__input">
	<span class="mdl-switch__label">Опт</span>
	</label>
	</div>
	<?if(!empty($values)){
		foreach($values as $key => $value){
			// var_dump(strpos($key, 'value_'));
			if(strpos($key, 'value_') !== false){?>
				<div class="slider_wrap">
					<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$value?>" step="1" tabindex="0">
				</div>
			<?}
		}
	}else{?>
		<div class="mdl-color--grey-100 mdl-cell--hide-phone clearfix toggle one">
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_1']:5?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_2']:5?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_3']:5?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_4']:5?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_5']:5?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_6']:5?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_7']:5?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_8']:5?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_9']:5?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_10']:5?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_11']:5?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_12']:5?>" step="1" tabindex="0">
			</div>
		</div>

		<div class="mdl-color--grey-100 mdl-cell--hide-phone clearfix toggle two hidden">
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_1']:5?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_2']:5?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_3']:5?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_4']:5?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_5']:5?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_6']:5?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_7']:5?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_8']:5?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_9']:5?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_10']:5?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_11']:5?>" step="1" tabindex="0">
			</div>
			<div class="slider_wrap">
				<input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_12']:5?>" step="1" tabindex="0">
			</div>
		</div>
	<?}?> 
-->
<div class="mdl-grid bottom_panel">
	<div class=" mdl-cell mdl-cell--5-col">
		<div class="mdl-textfield mdl-js-textfield">
			<textarea class="mdl-textfield__input" type="text" rows="1" id="text" name="text" required="required"><?=!empty($values)?$values[0]['comment']:null;?></textarea>
			<label class="mdl-textfield__label" for="text">Примечания к графику:</label>
		</div>
	</div>  
	<div class="mdl-cell mdl-cell--5-col">
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label <?=G::isLogged() || (G::isLogged() && $_SESSION['member']['gid'] == 1)?'hidden':null;?>">
			<input class="mdl-textfield__input" type="text" id="name_user" value="">
			<label class="mdl-textfield__label" for="name_user">Имя на графике:</label>
		</div>
	</div>
	<div class="mdl-cell mdl-cell--2-col">
		<div id="user_bt">
			<?if(!empty($values)){?>
				<a href="#" class="update btn_js mdl-button mdl-js-button mdl-js-ripple-effect">Обновить</a> <!-- onclick="ModalDemandChart()" -->
			<?}else{?>
				<a href="#" class="save btn_js mdl-button mdl-js-button mdl-js-ripple-effect">Сохранить</a> <!-- onclick="ModalDemandChart()" -->
			<?}?>
		</div>
	</div>
</div>
<script>
	$('.select_go label').on('change', function() {
		$('.mdl-color--grey-100.toggle').toggleClass('hidden');
		/*console.log('trues');
		if($(this).is(':checked')){
			 console.log('trues');
			$('.mdl-color--grey-100').eq(0).not(':has(div.hidden)').addClass('hidden');
			$('.mdl-color--grey-100').eq(1).hasClass('hidden').removeClass('hidden');
		}else{
			$('.mdl-color--grey-100').eq(1).not(':has(div.hidden)').addClass('hidden');
			$('.mdl-color--grey-100').eq(0).hasClass('hidden').removeClass('hidden');}*/
	});

	// $('body').on('change', 'input[type="range"]', function(event) {
	//   event.preventDefault();
	//   $(this).closest('.slider_wrap').find('.mdl-tooltip').text($(this).val());
	// });

	function СhangeValue(id){
		$('#'+id).closest('.slider_wrap').find('.range_num').text($('#'+id).val());
	}
</script>