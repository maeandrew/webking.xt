<script>
	var filterLink = new Object();
	var params = new Object();
		// console.log(filterLink);
	<?if(isset($GLOBALS['Filters'])){?>
		filterLink = <?=json_encode($GLOBALS['Filters'])?>;
	<?}?>
	<?if(isset($GLOBALS['Price_range'])){?>
		params['price_range'] = '<?=implode(',', $GLOBALS['Price_range']);?>';
	<?}?>
	<?if(isset($GLOBALS['Sort'])){?>
		params['sort'] = '<?=$GLOBALS['Sort']?>';
	<?}?>
	params['filters'] = filterLink;

	/** Фильтр по цене */
	$(function(){
		// Автопереключение на панель фильтров
		<?if($GLOBALS['Filters'] || isset($GLOBALS['Price_range'])){?>
			$('[data-nav="filter"]').click();
		<?}?>
		// Инициализация слайдера цен
		$("#slider_price").slider({
			range: true,
			min: <?=$min_price?>,
			max: <?=$max_price?>,
			values: [<?=isset($GLOBALS['Price_range'][0]) ? $GLOBALS['Price_range'][0] : $min_price?>,
					 <?=isset($GLOBALS['Price_range'][1]) ? $GLOBALS['Price_range'][1] : $max_price?>],
			step: <?=floor(($max_price - $min_price) * 0.01)?>,
			slide: function(event, ui) {
				/*$("#amount").html(ui.values[0]+" грн - "+Math.round(ui.values[1])+" грн");*/
				$('#minPrice').val(ui.values[0]);
				$('#maxPrice').val(Math.round(ui.values[1]));
				$('[data-nav="filter"]').addClass('active');
			},
			stop: function(event, ui) {
				var price_range = ui.values[0] + ',' + ui.values[1];
				$.cookie('price_range', price_range, {expires: 2, path: '/'});
				params['price_range'] = price_range;
				// console.log(params);
			}
		});
		/*$("#amount").append($("#slider_price").slider("values", 0)+" грн - "+$("#slider_price").slider("values", 1 )+" грн");*/
		
		// Добавление/удаление элементов в массиве
		$('.filters input').on('change', function(){
			var dataSpec = $(this).data('spec');
			var dataValue = $(this).data('value');
			if(filterLink[dataSpec] === undefined){
				filterLink[dataSpec] = [];
				filterLink[dataSpec].push(dataValue);
			}else if(filterLink[dataSpec] !== undefined){
				for(var key in filterLink){
					if(key == dataSpec){
						var index = $.inArray(dataValue, filterLink[key])
						if(index >= 0){
							filterLink[key].splice(index, 1);
						}else{
							filterLink[dataSpec].push(dataValue);
						}
					}
				}
			}

			if(filterLink[dataSpec].length === 0){
				delete filterLink[dataSpec];
			}
			params['filters'] = filterLink;
			console.log(filterLink);
		});

		// Клик на "Применить"
		$('#applyFilter').on('click', function(e){
			e.preventDefault();
			ajax('products', 'getFilterLink', {params: params, segment: '<?=(isset($GLOBALS['Segment']))?$GLOBALS['Segment']:null;?>', rewrite: '<?=$GLOBALS['Rewrite'];?>'}).done(function(data){
				// console.log(data);
				window.location.href = data;
			}).fail(function(data){
				removeLoadAnimation('.filters');
			});
		});

		//Очистить фильтры
		$("#clear_filter").click(function() {
			$(this).addClass('active');
			window.location.href = '<?=Link::Category($GLOBALS['Rewrite'], array('clear'=>true))?>';
		});

		//Сделать не активные ссылки у отключенных фильтров
		//	$('.disabled').click(function(event) {
		//		event.preventDefault();
		//	});
		
		/*Смена позиции кнопок блока фильтра*/
		$('.panel_container_js').on("scroll", function(){				
			changeFiltersBtnsPosition();
		});

		/* Проверка ценового диапазона и события применить */
		$('.priceField').keyup(function(e){
			var value = $(this).val().replace(/[^0-9.]/gi,"");
			if(value.length > 0 && value.length <= 9){
				$('input[name="column[]"]').prop('disabled',true).closest('label').addClass('is-disabled').css('color', 'gray');
				$(this).val(value);
			}else{
				$('input[name="column[]"]').prop('disabled',false).closest('label').removeClass('is-disabled').css('color', '');
				$(this).val('');
			}

			var price_range = $('#minPrice').val() + ',' + $('#maxPrice').val();
					$.cookie('price_range', price_range, {
						expires: 2,
						path: '/'
					});
					params['price_range'] = price_range;

			if(event.keyCode === 13){
				e.preventDefault();
				addLoadAnimation('.filters');
				ajax('products', 'getFilterLink', {params: params, rewrite: '<?=$GLOBALS['Rewrite'];?>'}).done(function(data){
					// console.log(data);
					window.location.href = data;
				}).fail(function(data){
					removeLoadAnimation('.filters');
				});
			}
		});
	});
</script>
<div class="filters">
	<div id="filterButtons" class="filterButtons">
		<button id="applyFilter" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent mdl-js-ripple-effect">Применить</button>
		<button id="clear_filter" class="mdl-button mdl-js-button mdl-js-ripple-effect">Сбросить</button>
	</div>
	<div class="filter_block price_range_block">
		<p>Ценовой диапазон</p>
		<div id="priceFields">
			<div class="mdl-textfield mdl-js-textfield">
				<input id="minPrice" class="mdl-textfield__input priceField" type="text" pattern="-?[0-9]*(\.[0-9]+)?" value="<?=isset($GLOBALS['Price_range'][0]) ? $GLOBALS['Price_range'][0] : $min_price?>">
				<label class="mdl-textfield__label" for="minPrice"></label>
				<span class="mdl-textfield__error">ВВЕДИТЕ ЧИСЛО!</span>
			</div>
			<div class="priceValute"><p>грн -</p></div>
			<div class="mdl-textfield mdl-js-textfield">
				<input id="maxPrice" class="mdl-textfield__input priceField" type="text" pattern="-?[0-9]*(\.[0-9]+)?" value="<?=isset($GLOBALS['Price_range'][1]) ? $GLOBALS['Price_range'][1] : $max_price?>">
				<label class="mdl-textfield__label" for="maxPrice"></label>
				<span class="mdl-textfield__error">ВВЕДИТЕ ЧИСЛО!</span>
			</div>
			<div class="priceValute"><p>грн</p></div>
		</div>
		<ul>
			<li>
				<div id="slider_price"></div>
			</li>
		</ul>
	</div>
	<?if(isset($filter_cat) && is_array($filter_cat)){
		foreach($filter_cat as $spec){?>
			<div class="filter_block">
				<p><?=$spec['caption']?></p>
				<ul>
					<?foreach($spec['values'] as $value){
						$present = (isset($visible_fil) && !in_array($value['value'], $visible_fil))?false:true;?>
						<li>
							<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect <?=$value['checked']?>">
								<input <?= ($present || in_array($value['id'][0], $id_filter)) ? "" : "disabled";?> type="checkbox" class="mdl-checkbox__input" data-spec="<?=$value['id'][0]?>" data-value="<?=$value['id'][1]?>" <?=$value['checked']?>>
								<span>
									<span class="mdl-checkbox__label"><?=$value['value']?> <?=$value['units']?></span>
								</span>
							</label>
						</li>
					<?}?>
					<div class="more <?=count($spec['values'])>5?'hid':'hidden';?>"><i class="material-icons">expand_more</i><span>Больше</span></div>
				</ul>
			</div>
		<?}
	}?>
</div>
<script>
	$(document).ready(function() {
		$('.more').click(function(event) {
			if ($(this).hasClass('hid')) {
				$(this).closest('.filter_block').find('li:nth-child(n+6)').css({"display": "block"});
				$(this).removeClass('hid').find('.material-icons').empty().html("expand_less").next('span').empty().html("Скрыть");
			}else{
				$(this).closest('.filter_block').find('li:nth-child(n+6)').css({"display": "none"});
				$(this).addClass('hid').find('.material-icons').empty().html("expand_more").next('span').empty().html("Больше");
			}
		});
	});
</script>