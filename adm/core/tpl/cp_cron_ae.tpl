<h1><?=$h1?></h1>
<?if(isset($errm) && isset($msg)){?>
	<div class="notification error">
		<span class="strong">Ошибка!</span>
		<?=$msg?>
	</div>
<?}elseif(isset($msg)){?>
	<div class="notification success">
		<span class="strong">Сделано!</span>
		<?=$msg?>
	</div>
<?}?>
<div id="cronae" class="grid">
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" class="row">
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-12">
					<label for="title">Название задачи:</label><?=isset($errm['title'])?"<span class=\"errmsg\">".$errm['title']."</span><br>":null?>
					<input type="text" name="title" id="title" class="input-m" value="<?=isset($_POST['title'])?htmlspecialchars($_POST['title']):null?>" autofocus>
				</div>
				<div class="col-md-12">
					<label for="description">Описание задачи:</label><?=isset($errm['description'])?"<span class=\"errmsg\">".$errm['description']."</span><br>":null?>
					<p>Что будет выполнять задача.</p>
					<textarea name="description" id="description" class="input-m" rows="4" cols="80"><?=isset($_POST['description'])?htmlspecialchars($_POST['description']):null?></textarea>
				</div>
				<div class="col-md-12">
					<label for="alias">Алиас (уникальное название функции):</label><?=isset($errm['alias'])?"<span class=\"errmsg\">".$errm['alias']."</span><br>":null?>
					<p>Допустимые символы - "a-Z", "0-9" и "_".</p>
					<p>ВАЖНО! Название функции может начинаться только с буквы латинского алфавита "a-Z"</p>
					<input type="text" name="alias" id="alias" class="input-m" pattern="(^[\d\w_]+$)" value="<?=isset($_POST['alias'])?$_POST['alias']:null?>" required>
				</div>
				<div class="col-md-12">
					<label for="editor">Скрипт:</label>
					<p>Этот код будет записан в файл <span>_____</span>.php</p>
					<div id="edit-container">
						<div id="editor" onkeyup="moreStuff();"><?=isset($_POST['post_editor'])?htmlspecialchars($_POST['post_editor']):null;?></div>
					</div>
					<input type="hidden" name="post_editor" id="post_editor" value="<?=isset($_POST['post_editor'])?htmlspecialchars($_POST['post_editor']):null;?>">
				</div>
				<div class="col-md-12">
					<label for="active">Активность:</label><?=isset($errm['active'])?"<span class=\"errmsg\">".$errm['active']."</span><br>":null?>
					<select name="active" id="active" class="input-m">
						<option value="0" <?=isset($_POST['active']) && $_POST['active'] == '0'?'selected':null;?>>Отключен</option>
						<option value="1" <?=isset($_POST['active']) && $_POST['active'] == '1'?'selected':null;?>>Включен</option>
					</select>
				</div>
				<div class="col-md-12">
					<label>Триггер запуска</label>
					<p>Например:<br>
					* * * * * - ежеминутный запуск задачи<br>
					* * * 0,12 30 - выполнение задачи каждый день в 0:30 и в 12:30<br>
					* * * 8-20 * - выполнение задачи каждый день каждую минуту с 8:00 до 20:59 </p>
					<table class="list trigger paper_shadow_1" border="0" cellspacing="0" cellpadding="0">
						<thead>
							<tr>
								<td class="center">Год</td>
								<td class="center">Месяц</td>
								<td class="center">День</td>
								<td class="center">Час</td>
								<td class="center">Минута</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<input type="text" id="year" name="year" class="input-m" value="<?=isset($_POST['year'])?$_POST['year']:'*';?>">
								</td>
								<td>
									<input type="text" id="mon" name="mon" class="input-m" value="<?=isset($_POST['mon'])?$_POST['mon']:'*';?>">
								</td>
								<td>
									<input type="text" id="mday" name="mday" class="input-m" value="<?=isset($_POST['mday'])?$_POST['mday']:'*';?>">
								</td>
								<td>
									<input type="text" id="hours" name="hours" class="input-m" value="<?=isset($_POST['hours'])?$_POST['hours']:'*';?>">
								</td>
								<td>
									<input type="text" id="minutes" name="minutes" class="input-m" value="<?=isset($_POST['minutes'])?$_POST['minutes']:'*';?>">
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<?if(isset($_POST['id'])){?>
				<input type="hidden" name="id" id="id" value="<?=$_POST['id']?>">
			<?}?>
			<button name="smb" type="submit" id="form_submit" class="btn-m-default save-btn">Сохранить</button>
		</div>
	</form>
</div>
<script>
	var editor = ace.edit('editor');
	// editor.setTheme('ace/theme/dreamviewer');
	editor.setTheme('ace/theme/clouds_midnight');
	editor.setFontSize(15);
	editor.getSession().setUseWrapMode(true);
	editor.getSession().setMode('ace/mode/php');
	function moreStuff(){
		document.getElementById('post_editor').value = editor.getValue();
	}
	$(function(){

	});
</script>