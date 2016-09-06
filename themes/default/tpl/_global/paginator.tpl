<div class="paginator">
	<ul>
		<?=isset($pages['first'])?$pages['first']:null;?>
		<?=isset($pages['prev'])?$pages['prev']:null;?>
		<?=implode('', $pages['main']);?>
		<?=isset($pages['next'])?$pages['next']:null;?>
		<?=isset($pages['last'])?$pages['last']:null;?>
	</ul>
	<?if($last_page >= 8){?>
		<form action="<?=$_SERVER['REQUEST_URI']?>" class="paginator_specific_page_block">
			<input type="number" name="paginator_specific_page" min="1" max="<?=$last_page?>" class="paginator_specific_page" placeholder="Введите номер страницы">
			<button type="submit" class="paginator_specific_page_btn mdl-button mdl-js-button">Перейти</button>		
		</form>
	<?}?>
</div>