<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>

<div id="warehouseae">
    <form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
		<select name="id_supplier" class="input-l">
			<option disabled selected>-- Выберите поставщика --</option>
			<?foreach($nonWarehouses as $w){?>
				<option value="<?=$w['id_user']?>"><?=$w['name']?></option>
			<?}?>
		</select>
		<button name="smb" type="submit" id="form_submit" class="btn-l-default save-btn">Добавить</button>
    </form>
</div>
<?if(isset($success)){ unset($success);?>
	<script>
	setTimeout(function(){
		$('.notification').slideUp();
	}, 1500);
	</script>
<?}?>
<p><a href="/adm/warehouses/">Список поставщиков склада</a></p>
