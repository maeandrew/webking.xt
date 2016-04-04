<div class="paginator">
	<ul>
		<?=isset($pages['first'])?$pages['first']:null;?>
		<?=isset($pages['prev'])?$pages['prev']:null;?>
		<?=implode('', $pages['main']);?>
		<?=isset($pages['next'])?$pages['next']:null;?>
		<?=isset($pages['last'])?$pages['last']:null;?>
	</ul>
</div>