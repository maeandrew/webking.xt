<div class="supplier_search fright">
	<form method="post" target="_blank" action="/supplier_search">
		<input type="text" name="art_product" class="input-m" placeholder="Проверка наличия товара">
		<input type="submit" class="btn-m-lblue" id="form_submit" value="Искать">
	</form>
</div>
<div id="supplier_manager_cabinet">
	<form action="" method="post" class="clearfix">
		<input type="hidden" name="sort" value="<?=isset($_POST['sort'])?$_POST['sort']:null;?>">
		<div class="table_thead clearfix">
			<div class="article">
				<a href="#" data-value="article asc" class="sort_article">Арт.<sup></sup></a>
				<input type="text" value="<?=isset($_POST['filter_article'])?htmlspecialchars($_POST['filter_article']):null?>" name="filter_article"/>
			</div>
			<div class="name">
				<a href="#" data-value="name asc" class="sort_name">Имя<sup></sup></a>
				<input type="search" value="<?=isset($_POST['filter_name'])?htmlspecialchars($_POST['filter_name']):null?>" name="filter_name"/>
			</div>
			<div class="place">Контакты</div>
			<div class="email">
				<a href="#" data-value="email asc" class="sort_emai">E-mail<sup></sup></a>
				<input type="search" value="<?=isset($_POST['filter_email'])?htmlspecialchars($_POST['filter_email']):null?>" name="filter_email"/>
			</div>
			<div class="next_update_date">
				<a href="#" data-value="next_update_date asc" class="sort_next_update_date">Рабочий день<sup></sup></a>
			</div>
			<div class="currency">
				<a href="#" data-value="inusd desc, currency_rate asc" class="sort_currency_rate">Курс доллара<sup></sup></a>
			</div>
			<div class="login">Вход в кабинет</div>
			<div class="toggle">
				<a href="#" data-value="active desc" class="sort_active">Вкл/Выкл<sup></sup></a>
			</div>
			<input type="submit" name="smb" value="Фильтр"/>
		</div>
	</form>
	<?if(isset($supplier_list) && is_array($supplier_list)){?>
		<table class="table">
			<tbody>
			<?foreach($supplier_list as $s){?>
				<tr>
					<td class="article"><?=$s['article'];?></td>
					<td class="name"><?=$s['name']?></td>
					<td class="place"><?=isset($s['place'])?$s['place']:'-';?></td>
					<td class="email"><?=isset($s['email']) && $s['email'] != ''?$s['email']:'-';?></td>
					<!-- красное если осталось меньше месяца или дата в прошлом -->
					<td class="next_update_date <?=strtotime($s['next_update_date'])-time() <= 60*60*24*7*4?'color-red':null?>"><?=date("d.m.Y", strtotime($s['next_update_date']));?></td>
					<td class="currency"><?=$s['inusd'] > 0?number_format($s['currency_rate'], 2, ",", ""):'-';?></td>
					<td class="login">
						<a href="/login/?email=<?=$s['email']?>&passwd=0" class="btn-m-green <?=$s['active'] == 0?'hidden':'';?>">Войти</a>
					</td>
					<td class="toggle">
						<a href="?id=<?=$s['id_user']?>&toggle_supplier=<?=$s['active'] == 0?'1':'0';?>" class="btn-m-<?=$s['active'] == 0?'green':'red';?>-inv"><?=$s['active'] == 0?'Вкл.':'Выкл.';?></a>
					</td>
				</tr>
			<?}?>
			</tbody>
		</table>
	<?}else{?>
		Нету поставщиков по данному фильтру.
	<?}?>
</div>
<script>
	$(function(){
		var input = $('[name="sort"]'),
			sorts = input.val().split('; ');
		for (var i of sorts){
			console.log(i);
			$('[data-value="'+i+'"]').find('sup').html(parseInt(sorts.indexOf(i)+1));
		}
		$('[class*="sort_"]').click(function(e){
			// console.log($(this));
			// var cls = $(this).prop('class');
			var form = $(this).closest('form'),
				nvalue = $(this).data("value"),
				ivalue;
			ovalue = input.val();
			if(e.ctrlKey){
				console.log('ctrl+click');
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
					console.log('ctrl up');
					form.submit();
				});
			}else if(e.shiftKey){
				console.log('shift+click');
			}else if(e.altKey){
				console.log('alt+click');
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
</script>