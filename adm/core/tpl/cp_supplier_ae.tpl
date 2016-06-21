<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>

<div id="supplierae" class="grid">
	<form action="<?=$GLOBALS['URL_request']?>" method="post" class="row">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12">
					<label for="name">Имя:</label><?=isset($errm['name'])?"<span class=\"errmsg\">".$errm['name']."</span><br>":null?>
					<input type="text" name="name" id="name" class="input-l" value="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null?>" autofocus>
				</div>
				<div class="col-md-12">
					<label for="email">E-mail:</label><?=isset($errm['email'])?"<span class=\"errmsg\">".$errm['email']."</span><br>":null?>
					<input type="text" name="email" id="email" class="input-l" pattern="(^([\w\.]+)@([\w]+)\.([\w]+)$)|(^$)" value="<?=isset($_POST['email'])?htmlspecialchars($_POST['email']):null?>">
				</div>
				<div class="col-md-12">
					<label for="passwd">Пароль:</label><?=isset($errm['passwd'])?"<span class=\"errmsg\">".$errm['passwd']."</span><br>":null?>
					<input type="password" name="passwd" id="passwd" class="input-l" value="<?=isset($_POST['passwd'])?htmlspecialchars($_POST['passwd']):null?>">
				</div>
				<div class="col-md-12">
					<label for="article">Артикул:</label><?=isset($errm['article'])?"<span class=\"errmsg\">".$errm['article']."</span><br>":null?>
					<input type="text" name="article" id="article" class="input-l" value="<?=isset($_POST['article'])?htmlspecialchars($_POST['article']):null?>">
				</div>
				<div class="col-md-12">
					<label for="phone">Адрес:<!-- Телефоны --></label><?=isset($errm['phone'])?"<span class=\"errmsg\">".$errm['phone']."</span><br>":null?>
					<textarea name="phone" id="phone" class="input-l" rows="3" cols="80"><?=isset($_POST['phone'])?htmlspecialchars($_POST['phone']):null?></textarea>
				</div>
				<div class="col-md-12">
					<label for="place">Телефоны:<!-- Место --></label><?=isset($errm['place'])?"<span class=\"errmsg\">".$errm['place']."</span><br>":null?>
					<input type="text" name="place" id="place" class="input-l" value="<?=isset($_POST['place'])?htmlspecialchars($_POST['place']):null?>">
				</div>
				<div class="col-md-12">
					<label for="currency_rate">Курс $:</label><?=isset($errm['currency_rate'])?"<span class=\"errmsg\">".$errm['currency_rate']."</span><br>":null?>
					<input type="text" name="currency_rate" id="currency_rate" class="input-l" value="<?=isset($_POST['currency_rate'])?htmlspecialchars($_POST['currency_rate']):null?>">
				</div>
				<div class="col-md-12">
					<label for="koef_nazen_mopt">Мелкооптовая наценка:</label><?=isset($errm['koef_nazen_mopt'])?"<span class=\"errmsg\">".$errm['koef_nazen_mopt']."</span><br>":null?>
					<input type="text" name="koef_nazen_mopt" id="koef_nazen_mopt" class="input-l" value="<?=isset($_POST['koef_nazen_mopt'])?htmlspecialchars($_POST['koef_nazen_mopt']):null?>">
				</div>
				<div class="col-md-12">
					<label for="koef_nazen_opt">Оптовая наценка:</label><?=isset($errm['koef_nazen_opt'])?"<span class=\"errmsg\">".$errm['koef_nazen_opt']."</span><br>":null?>
					<input type="text" name="koef_nazen_opt" id="koef_nazen_opt" class="input-l" value="<?=isset($_POST['koef_nazen_opt'])?htmlspecialchars($_POST['koef_nazen_opt']):null?>">
				</div>
				<div class="col-md-12">
					<label for="descr">Комментарий:</label><?=isset($errm['descr'])?"<span class=\"errmsg\">".$errm['descr']."</span><br>":null?>
					<textarea name="descr" id="descr" class="input-l" rows="3" cols="80"><?=isset($_POST['descr'])?htmlspecialchars($_POST['descr']):null?></textarea>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="hidden">
				<label for="filial">Филиал</label>
				<select name="filial" id="filial" class="input-l">
					<?foreach($filials as $filial){?>
						<option value="<?=$filial['id']?>" <?=(isset($_POST['filial']) && $_POST['filial'] == $filial['id'])?"selected":null;?>><?=$filial['title']?></option>
					<?}?>
				</select>
			</div>
			<label for="is_partner">Партнер &nbsp;
			<input type="checkbox"  name="is_partner" id="is_partner" class="input-l" <?=isset($_POST['is_partner'])&&($_POST['is_partner'])?'checked="checked" value="on"':null?>>
			</label>
			<label for="make_csv">Автоматически формировать ~.csv файл
			<input type="checkbox"  name="make_csv" id="make_csv" class="input-l" <?=isset($_POST['make_csv'])&&($_POST['make_csv'])?'checked="checked" value="on"':null?>>
			</label>
		</div>
		<div class="col-md-4">
			<label for="send_mail_order">Автоматически отправлять email в сводной накладной
				<input type="checkbox"  name="send_mail_order" id="send_mail_order" <?=isset($_POST['send_mail_order'])&&($_POST['send_mail_order'])?'checked="checked" value="on"':null?>>
			</label>
		</div>
		<div class="col-md-4">
			<input type="text" name="real_email" id="real_email" class="input-l" placeholder="email поставщика" value="<?=isset($_POST['real_email'])?htmlspecialchars($_POST['real_email']):null?>">
		</div>
		<div class="col-md-4">
			<input type="text" name="real_phone" id="real_phone" class="input-l" placeholder="номер телефона поставщика для SMS" value="<?=isset($_POST['real_phone'])?htmlspecialchars($_POST['real_phone']):null?>">
		</div>
		<div class="col-md-12">
			<label for="active">Отключить поставщика &nbsp;
				<input type="checkbox"  name="active" id="active" class="input-l" <?=isset($_POST['active'])&&(!$_POST['active'])?'checked="checked" value="on"':null?>>
			</label>
			<label for="warehouse">Поставщик склада &nbsp;
				<input type="checkbox"  name="warehouse" id="warehouse" class="input-l" <?=isset($_POST['warehouse'])&&($_POST['warehouse'])?'checked="checked" value="on"':null?>>
			</label>
			<?if(isset($GLOBALS['REQAR'][1])){?>
				<p><a href="<?=$GLOBALS['URL_base']?>cabinet_admin_supplier/<?=$_POST['id_user']?>">Установить эксклюзивные товары</a></p>
			<?}?>
			
			<input type="hidden" name="gid" id="gid" value="<?=isset($_POST['gid'])?$_POST['gid']:0?>">
			<input type="hidden" name="id_user" id="id_user" value="<?=isset($_POST['id_user'])?$_POST['id_user']:0?>">
			<button type="submit" name="clear-assort" class="btn-l-red-inv fr save-btn" onclick="if(confirm('Все товары поставщика будут удалены из ассортимента!\nДействие необратимо!')){window.location.href = '/cart/clear/';}else{return false;}">Очистить поставщика</button>
			<button name="smb" type="submit" class="btn-l-default save-btn">Сохранить</button>
		</div>
	</form>
	<?if(isset($GLOBALS['REQAR'][1])){?>
		<h2>Дополнительная информация</h2>
		<a href="<?=_base_url;?>/adm/assortment/<?=$GLOBALS['REQAR'][1];?>">Ассортимент поставщика</a>
		<div class="row">
			<div class="col-md-4">
				<table border="0" cellpadding="0" cellspacing="0" class="list paper_shadow_1">
					<thead>
						<tr>
							<td colspan="2">Акты сверки</td>
						</tr>
					</thead>
					<tr class="animate">
						<td>Акт сверки цен поставщика</td>
						<td>
							<a href="<?=$GLOBALS['URL_base']?>adm/act_supplier/<?=$id_supplier?>" target="_blank" title="Откроется в новой вкладке" class="btn-m-lblue fr">Открыть</a>
						</td>
					</tr>
					<tr class="animate">
						<td>Новая с ценами</td>
						<td>
							<a href="<?=$GLOBALS['URL_base']?>adm/act_supplier/<?=$id_supplier?>?type=new&price=true" target="_blank" title="Откроется в новой вкладке" class="btn-m-lblue fr">Открыть</a>
						</td>
					</tr>
					<tr class="animate">
						<td>Новая без цен</td>
						<td>
							<a href="<?=$GLOBALS['URL_base']?>adm/act_supplier/<?=$id_supplier?>?type=new&price=false" target="_blank" title="Откроется в новой вкладке" class="btn-m-lblue fr">Открыть</a>
						</td>
					</tr>
					<tr class="animate">
						<td>Сверх-новая с ценами</td>
						<td>
							<a href="<?=$GLOBALS['URL_base']?>adm/act_supplier/<?=$id_supplier?>?type=wide" target="_blank" title="Откроется в новой вкладке" class="btn-m-lblue fr">Открыть</a>
						</td>
					</tr>
					<tr class="animate">
						<td>Многоразовая без цен</td>
						<td>
							<a href="<?=$GLOBALS['URL_base']?>adm/act_supplier/<?=$id_supplier?>?type=multiple" target="_blank" title="Откроется в новой вкладке" class="btn-m-lblue fr">Открыть</a>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<!-- <a href="<?=$GLOBALS['URL_base']?>adm/act_supplier/<?=$id_supplier?>" target="_blank" class="btn-m-lblue fr">Акт сверки цен поставщика</a>
		<a href="<?=$GLOBALS['URL_base']?>adm/act_supplier/<?=$id_supplier?>?type=new&price=true" target="_blank" class="btn-m-lblue fr">Новая с ценами</a>
		<a href="<?=$GLOBALS['URL_base']?>adm/act_supplier/<?=$id_supplier?>?type=new&price=false" target="_blank" class="btn-m-lblue fr">Новая без цен</a>
		<a href="<?=$GLOBALS['URL_base']?>adm/act_supplier/<?=$id_supplier?>?type=wide" target="_blank" class="btn-m-lblue fr">Сверх-новая с ценами</a>
		<a href="<?=$GLOBALS['URL_base']?>adm/act_supplier/<?=$id_supplier?>?type=multiple" target="_blank" class="btn-m-lblue fr">Многоразовая без цен</a> -->
		<!-- <form action="<?=Link::Custom('cabinet', 'price1');?>" method="post">
			<button name="price" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">Новая с ценами</button>
			<button name="no-price" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">Новая без цен</button>
			<button name="wide" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">Сверх-новая с ценами</button>
			<button name="multiple" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">Многоразовая без цен</button>
		</form> -->
	<?}?>
</div>
<!-- <?if(isset($cal)){?>
	<h2>Календарь поставщика</h2>
	<div class="row">
		<div class="col-md-4">
			<table border="0" cellpadding="0" cellspacing="0" class="list paper_shadow_1" style="width: 400px;">
				<thead>
					<tr>
						<td>Дата</td>
						<td>День</td>
					</tr>
				</thead>
				<?foreach($cal as $c){?>
					<tr class="animate">
						<td>
						 	<p><span <?=(isset($c['red']))?'style="color:Red"':null;?>><?=$c['d_word']?></span>, <?=$c['date_dot']?></p>
						</td>
						<td>
						 	<p>
							 	<?if(isset($c['day'])){?>
							 		<input id="day<?=$c['date_']?>" type="checkbox" <?if($c['active'] == 0){?>disabled="disabled"<?}?> <?if($c['day']){?>checked="checked"<?}?> onchange="SwitchSupplierDate('<?=$c['date_dot']?>', 'day');">
							 	<?}else{?>
							 		-
							 	<?}?>
							</p>
						</td>
					</tr>
				<?}?>
			</table>
		</div>
	</div>
<?}?> -->
<div class="clear"></div>
<script type="text/javascript">
	$('#send_mail_order').click(function(){
		var real_email = $('#real_email').val();
		if(real_email == ''){
			if(confirm('Заполните поле c E-mail\'ом поставщика')){
				$('#real_email').animate({
					"background-color": "#faa"
				}).animate({
					"background-color": "#fdd"
				}).animate({
					"background-color": "#faa"
				}).animate({
					"background-color": "#fff"
				});
			}
			$('#send_mail_order').removeAttr('checked');
		}else{
			$('#send_mail_order').attr('checked','checked').val('on');
		}
	});
</script>