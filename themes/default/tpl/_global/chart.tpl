<h3>График спроса (своя версия)</h3>
	<div class="mdl-tabs mdl-js-tabs">
		<div class="mdl-tabs__tab-bar">
				<a href="#retail" class="mdl-tabs__tab is-active">Розница</a>
				<a href="#opt" class="mdl-tabs__tab">Опт</a>
		</div>
		<?$iter = 0;
			$index = 0;
			$labels = array( 'январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь');?>
		<div class="mdl-tabs__panel is-active" id="retail">
			<div class="mdl-cell--hide-phone clearfix toggle one range_wrap">
				<?if(!empty($values)){?>
					<input type="hidden" name="roz_id_chart" value="<?=$values[0]['id_chart']?>">
					<?foreach($values[0] as $key => $value){
						if(strpos($key, 'value_') !== false){?>
							<div class="slider_wrap">
								<input id="inr_<?=++$iter?>" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$value?>" step="1" tabindex="0" data-prevnum="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num"><?=$value?></div>
								<span><?=$labels[$index++]?></span>
							</div>
						<?}
					}
				}else{?>
					<?for ($i=1; $i <= 12; $i++){?>
						<div class="slider_wrap">
							<input id="inr_<?=++$iter?>" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['roz']['value_'+$i]:5?>" step="1" tabindex="0" data-prevnum="0" oninput="СhangeValue($(this).attr('id'));">
							<div class="range_num"><?=isset($val)?$val['roz']['value_'+$i]:5?></div>
							<span><?=$labels[$index++]?></span>
						</div>
					<?}
				}?>
			</div>
		</div>
		<?$iter = 0;
			$index = 0;?>
		<div class="mdl-tabs__panel" id="opt">
			<div class="mdl-cell--hide-phone clearfix toggle two range_wrap">
				<?if(!empty($values)){?>
					<input type="hidden" name="opt_id_chart" value="<?=$values[1]['id_chart']?>">
					<?foreach($values[1] as $key => $value){
						if(strpos($key, 'value_') !== false){?>
							<div class="slider_wrap">
								<input id="ino_<?=++$iter?>" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$value?>" step="1" tabindex="0" data-prevnum="0" oninput="СhangeValue($(this).attr('id'));">
								<div class="range_num"><?=$value?></div>
								<span><?=$labels[$index++]?></span>
							</div>
						<?}
					}
				}else{?>
					<?for ($k=1; $k <= 12; $k++){?>
						<div class="slider_wrap">
							<input id="ino_<?=++$iter?>" class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=isset($val)?$val['opt']['value_'+$k]:5?>" step="1" tabindex="0" data-prevnum="0" oninput="СhangeValue($(this).attr('id'));">
							<div class="range_num"><?=isset($val)?$val['opt']['value_'+$k]:5?></div>
							<span><?=$labels[$index++]?></span>
						</div>
					<?}
				}?>
			</div>
		</div>
	</div>
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
				<a href="#" class="update btn_js mdl-button mdl-js-button" data-isadmin="<?=isset($_SESSION['member']) && $_SESSION['member']['gid'] == 1?'true':'false';?>">Обновить</a> <!-- onclick="ModalDemandChart()" -->
			<?}else{?>
				<a href="#" class="save btn_js mdl-button mdl-js-button" data-isadmin="<?=isset($_SESSION['member']) && $_SESSION['member']['gid'] == 1?'true':'false';?>">Сохранить</a> <!-- onclick="ModalDemandChart()" -->
			<?}?>
		</div>
	</div>
</div>