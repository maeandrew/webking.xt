<?if(isset($msg_type)){?>
	<div class="msg-<?=$msg_type?>">
		<p><?=$msg?></p>
	</div>
<?}else{?>
	<p><?=$msg?></p>
<?}?>