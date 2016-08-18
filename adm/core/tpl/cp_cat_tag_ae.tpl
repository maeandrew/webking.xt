<h1><?=$h1?>: "<?=$_POST['name']?>"</h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>

<div id="cat_tag_page">
    <ul class="list">
    	<input type="hidden" id="id_category" name="id_category" value="<?=$_POST['id_category']?>">
    	<li class="headrow">
    		<div class="tag_name col"><a>Название</a></div>
    		<div class="tag_keys col"><a>Ключи</a></div>
    		<div class="tag_level col"><a>Критерий</a></div>
    		<div class="edit col"><a>Действия</a></div>
    	</li>
    	<? print_r($leveladdapply) ?>
    	<?foreach($level as $l){?>
			<li class="levelrow row<?=$l['tag_level']?>">
				<div class="tag_level_name col">
					<?if($l['tag_level_name']){?>
						<p><?=$l['tag_level_name']?></p>
						<input type="text" name="tag_level_name" id="tag_level_name" class="input-m"  value="<?echo $l['tag_level_name'] ? $l['tag_level_name'] : null ;?>" style="display: none;"/>
					<?}else{?>
						<input type="text" name="tag_level_name" id="tag_level_name" class="needed input-m" value=""/>
					<?}?>
				</div>
	    		<div class="edit col">
					<?if($l['tag_level_name']){?>
		    			<a class="edit row<?=$l['tag_level']?>" href="#edit">edit</a>
		    			<a class="delete row<?=$l['tag_level']?>" href="#delete">delete</a>
						<a class="apply row<?=$l['tag_level']?> hidden" href="#apply">apply</a>
						<a class="discard row<?=$l['tag_level']?> hidden" href="#discard">discard</a>
					<?}else{?>
						<a class="apply row<?=$l['tag_level']?>" href="#apply">apply</a>
		    		<?}?>
	    		</div>
    		</li>
			<?foreach($l['tags'] as $t){?>
		    	<li class="tagrow row<?=$t['tag_id']?>">
					<div class="tag_name col">
						<p><?=$t['tag_name']?></p>
						<input type="text" name="tag_name" id="tag_name"class="input-m" value="<?echo $t['tag_name'] ? $t['tag_name'] : null ;?>" style="display: none;"/>
					</div>
					<div class="tag_keys col">
						<p><?=$t['tag_keys']?></p>
						<textarea name="tag_keys" id="tag_keys" class="input-m" style="display: none;"><?echo $t['tag_keys'] ? $t['tag_keys'] : null ;?></textarea>
					</div>
					<div class="tag_level col">
						<p><?=$t['tag_level']?></p>
						<input type="text" name="tag_level" id="tag_level" class="input-m" value="<?echo $t['tag_level'] ? $t['tag_level'] : null ;?>" style="display: none;"/>
					</div>
		    		<div class="edit col ">
		    			<a class="edit row<?=$t['tag_id']?>" href="#edit">edit</a>
		    			<a class="delete row<?=$t['tag_id']?>" href="#delete">delete</a>
						<a class="apply row<?=$t['tag_id']?> hidden" href="#apply">apply</a>
						<a class="discard row<?=$t['tag_id']?> hidden" href="#discard">discard</a>
		    		</div>
		    	</li>
		    <?$i[] = $t['tag_id'];}?>
		<?}$ii = max($i)+1;?>


		<li class="tagrow addrow row<?=$ii?>" style="display: none;">
			<div class="tag_name col">
				<input type="text" name="tag_name" id="tag_name" class="input-m" />
			</div>
			<div class="tag_keys col">
				<textarea name="tag_keys" id="tag_keys" class="input-m"></textarea>
			</div>
			<div class="tag_level col">
				<input type="text" name="tag_level" id="tag_level" class="input-m" />
			</div>
			<div class="edit col">
				<a class="addapply row<?=$ii?>" href="#apply">apply</a>
				<a class="discard row<?=$ii?>" href="#discard">discard</a>
			</div>
		</li>
	</ul>
	<a href="#add" class="icon-add add">a</a>
	<h2>Критерии</h2>
	<ul class="leveltable list">
		<div class="headrow">
			<span class="tag_level_id col">№</span>
			<span class="tag_level_name col">Название</span>
		</div>
		<?foreach($level as $l){?>
	    	<li class="leveltablerow levelinforow<?=$l['tag_level']?>">
				<span class="tag_level_id col"><?=$l['tag_level']?></span>
				<span class="tag_level_name col"><?=$l['tag_level_name']?></span>
    		</li>
		<?}?>
	</ul>
</div>