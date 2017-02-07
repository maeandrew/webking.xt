<div id="content">
	<?if($GLOBALS['CurrentController'] == 'main'){?>
		<input type="checkbox" id="read_more" class="hidden">
		<div class="content_page">
			<?=$data['new_content'];?>
		</div>
		<?if(strlen($data['new_content']) >= 500){?>
			<label for="read_more">Читать полностью</label>
		<?}?>
	<?}else{?>
		<div class="content_page">
            <?=$data['new_content']?>
		</div>
	<?}?>
	<?if(isset($sdescr)){
		echo $sdescr;
	}?>
</div><!--id="content"-->

