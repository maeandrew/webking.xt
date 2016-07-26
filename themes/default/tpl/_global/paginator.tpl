<div class="paginator">
	<ul>
		<?=isset($pages['first'])?$pages['first']:null;?>
		<?=isset($pages['prev'])?$pages['prev']:null;?>
		<?=implode('', $pages['main']);?>
		<?=isset($pages['next'])?$pages['next']:null;?>
		<?=isset($pages['last'])?$pages['last']:null;?>
	</ul>
	<form action="" class="paginator_specific_page_block">
		<input type="text" name="paginator_specific_page" class="paginator_specific_page" placeholder="Введите номер страницы">
		<button type="submit" class="paginator_specific_page_btn mdl-button mdl-js-button mdl-js-ripple-effect">Перейти</button>		
	</form>
</div>