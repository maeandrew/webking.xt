<div id="content">
	<p class="color-grey" style="font-weight: 300; font-style: italic;">Опубликовано:
		<?if(date("d") == date("d", $data['date'])){?>
			Сегодня
		<?}elseif(date("d")-1 == date("d", $data['date'])){?>
			Вчера
		<?}else{
			echo date("d.m.Y", $data['date']);
		}?></p>
	<div class="content_page">
		<?=$data['descr_full']?>
    </div>
	<a href="<?=Link::Custom('news');?>">Другие новости</a>
</div><!--id="content"-->