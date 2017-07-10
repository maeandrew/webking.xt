<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>
<div id="specificationae">
    <form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
        <div class="row">
            <div class="col-md-12">
                <label for="caption">Название:</label><?=isset($errm['caption'])?"<span class=\"errmsg\">".$errm['caption']."</span><br>":null?>
                <input type="text" name="caption" id="caption" class="input-l" value="<?=isset($_POST['caption'])?htmlspecialchars($_POST['caption']):null?>">
            </div>
        </div>
    	<div class="row">
    		<div class="col-md-12">
    			<label for="service_caption">Служебное название:</label><?=isset($errm['service_caption'])?"<span class=\"errmsg\">".$errm['service_caption']."</span><br>":null?>
				<input type="text" name="service_caption" id="service_caption" class="input-l" value="<?=isset($_POST['service_caption'])?htmlspecialchars($_POST['service_caption']):null?>">
    		</div>
    	</div>
        <div class="row">
            <div class="col-md-12">
                <label for="units">Единицы измерения:</label><?=isset($errm['units'])?"<span class=\"errmsg\">".$errm['units']."</span><br>":null?>
				<input type="text" name="units" id="units" class="input-l" value="<?=isset($_POST['units'])?htmlspecialchars($_POST['units']):null?>">
    		</div>
    	</div>
		<div class="row">
    		<div class="col-md-12">
    			<input type="hidden" name="id" id="id" value="<?=isset($_POST['id'])?$_POST['id']:0?>">
				<button name="smb" type="submit" class="save-btn btn-l-default">Сохранить</button>
    		</div>
    	</div>
    </form>
</div>