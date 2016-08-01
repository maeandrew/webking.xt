<div class="supplier_search fright">
	<form method="post" target="_blank" action="/supplier_search">
		<input type="text" name="art_product" class="input-m" placeholder="Проверка наличия товара">
		<input type="submit" class="mdl-button mdl-js-button mdl-button--raised" id="form_submit" value="Искать">
	</form>
</div>
<div id="supplier_manager_cabinet">
	<form action="" method="post" class="clearfix ">
		<input type="hidden" name="sort" value="<?=isset($_POST['sort'])?$_POST['sort']:null;?>">
		<div class="table_thead clearfix mdl-grid">
			<div class="article mdl-cell mdl-cell--1-col">
				<a href="#" data-value="article asc" class="sort_article">Арт.<sup></sup></a>
				<input type="text" value="<?=isset($_POST['filter_article'])?htmlspecialchars($_POST['filter_article']):null?>" name="filter_article"/>
			</div>
			<div class="name mdl-cell mdl-cell--3-col">
				<a href="#" data-value="name asc" class="sort_name">Имя<sup></sup></a>
				<input type="search" value="<?=isset($_POST['filter_name'])?htmlspecialchars($_POST['filter_name']):null?>" name="filter_name"/>
			</div>
			<div class="place mdl-cell mdl-cell--3-col">Контакты</div>
			<div class="email mdl-cell mdl-cell--1-col">
				<a href="#" data-value="email asc" class="sort_emai">E-mail<sup></sup></a>
				<input type="search" value="<?=isset($_POST['filter_email'])?htmlspecialchars($_POST['filter_email']):null?>" name="filter_email"/>
			</div>
			<!--<div class="next_update_date mdl-cell mdl-cell--1-col">
				<a href="#" data-value="next_update_date asc" class="sort_next_update_date">Рабочий день<sup></sup></a>
			</div>-->
			<div class="currency mdl-cell mdl-cell--1-col">
				<a href="#" data-value="inusd desc, currency_rate asc" class="sort_currency_rate">Курс доллара<sup></sup></a>
			</div>
			<div class="login mdl-cell mdl-cell--1-col">Вход в кабинет</div>
			<div class="toggle mdl-cell mdl-cell--1-col">
				<a href="#" data-value="active desc" class="sort_active">Вкл/Выкл<sup></sup></a>
			</div>
			<input type="submit" name="smb" value="Фильтр"/>
		</div>
	</form>
	<?if(isset($supplier_list) && is_array($supplier_list)){?>
		<div class="table">			
			<?foreach($supplier_list as $s){?>
				<div class="tr">
					<div class="article td"><?=$s['article'];?></div>
					<div class="name td"><?=$s['name']?></div>
					<div class="place td"><?=isset($s['place'])?$s['place']:'-';?></div>
					<div class="email td"><?=isset($s['email']) && $s['email'] != ''?$s['email']:'-';?></div>
					<!-- красное если осталось меньше месяца или дата в прошлом -->
					<!--<div class="next_update_date td <?=strtotime($s['next_update_date'])-time() <= 60*60*24*7*4?'color-red':null?>"><?=date("d.m.Y", strtotime($s['next_update_date']));?></div>-->
					<div class="currency td"><?=$s['inusd'] > 0?number_format($s['currency_rate'], 2, ",", ""):'-';?></div>
					<div class="login td">
						<?if($s['active'] == 1){?>
							<a href="#" onclick="sm_login('<?=$s['email']?>');" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Войти</a>
						<?}?>
					</div>
					<div class="toggle td">
						<a href="?id=<?=$s['id_user']?>&toggle_supplier=<?=$s['active'] == 0?'1':'0';?>" class="mdl-button mdl-js-button mdl-button--raised <?=$s['active'] == 0?'color-green':'color-red';?>"><?=$s['active'] == 0?'Вкл.':'Выкл.';?></a>
					</div>
				</div>
			<?}?>			
		</div>
	<?}else{?>
		Нету поставщиков по данному фильтру.
	<?}?>
</div>
<script>
	$(function(){
		var input = $('[name="sort"]'),
			sorts = input.val().split('; ');
		for (var i of sorts){
			$('[data-value="'+i+'"]').find('sup').html(parseInt(sorts.indexOf(i)+1));
		}
		$('[class*="sort_"]').click(function(e){
			// var cls = $(this).prop('class');
			var form = $(this).closest('form'),
				nvalue = $(this).data("value"),
				ivalue;
			ovalue = input.val();
			if(e.ctrlKey){
				input.val('');
				if(ovalue.length > 0){
					if(ovalue.indexOf(nvalue) > -1){
						ivalue = ovalue.replace(nvalue+'; ', '');
					}else{
						ivalue = ovalue+nvalue+'; ';
					}
				}else{
					ivalue = nvalue+'; ';
				}
				input.val(ivalue);
				var sorts = ivalue.split('; ');
				$('[class*="sort_"]').find("sup").html("");
				for (var i of sorts){
					$('[data-value="'+i+'"]').find('sup').html(parseInt(sorts.indexOf(i)+1));
				}
				$(document).keyup(function(e){
					form.submit();
				});
			}else{
				if(ovalue.indexOf(nvalue) > -1 && ovalue.length-nvalue.length <= 2){
					input.val('');
				}else{
					input.val(nvalue+'; ');
				}
				form.submit();
			}
		});
	});
	function sm_login(email){
		ajax('auth', 'login', {email: email, passwd: 0}, 'json');
	}
</script>