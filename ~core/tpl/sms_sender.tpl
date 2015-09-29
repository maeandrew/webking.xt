<form id="sms_form" style="display: none;">
	<label for="sender">Отправитель:</label>
	<input type="text" name="sender" disabled id="sender" value="<?=$GLOBALS['CONFIG']['invoice_logo_text']?>"/>
	<label for="reciever">Получатель:</label>
	<input type="text" name="reciever" id="reciever" value="<?=$_GET['reciever']?>"/>
	<label for="text">Текст сообщения:</label>
	<textarea name="text" id="text" ><?=$_GET['text']?></textarea>
	<input type="submit" class="confirm" value="Отправить"/>
</form>