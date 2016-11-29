<?switch($id_profile){
	case _ACL_SUPPLIER_:?>
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
		<div class="col-md-12">
			<label for="is_partner">Партнер &nbsp;
				<input type="checkbox" name="is_partner" id="is_partner" class="input-l" <?=isset($_POST['is_partner'])&&($_POST['is_partner'])?'checked="checked" value="on"':null?>>
			</label>
		</div>
		<div class="col-md-12">
			<label for="make_csv">Формировать ~.csv файл
				<input type="checkbox" name="make_csv" id="make_csv" class="input-l" <?=isset($_POST['make_csv'])&&($_POST['make_csv'])?'checked="checked" value="on"':null?>>
			</label>
		</div>
		<div class="col-md-12">
			<label for="send_mail_order">Рассылка накладной
				<input type="checkbox"  name="send_mail_order" id="send_mail_order" <?=isset($_POST['send_mail_order'])&&($_POST['send_mail_order'])?'checked="checked" value="on"':null?>>
			</label>
		</div>
		<div class="col-md-12">
			<label for="real_email">Email для рассылки:</label><?=isset($errm['real_email'])?"<span class=\"errmsg\">".$errm['real_email']."</span><br>":null?>
			<input type="text" name="real_email" id="real_email" class="input-l" placeholder="email поставщика" value="<?=isset($_POST['real_email'])?htmlspecialchars($_POST['real_email']):null?>">
		</div>
		<div class="col-md-12">
			<label for="real_phone">Телефон для рассылки:</label><?=isset($errm['real_phone'])?"<span class=\"errmsg\">".$errm['real_phone']."</span><br>":null?>
			<input type="text" name="real_phone" id="real_phone" class="input-l" placeholder="номер телефона поставщика для SMS" value="<?=isset($_POST['real_phone'])?htmlspecialchars($_POST['real_phone']):null?>">
		</div>
		<?break;
	default:
		# code...
		break;
}