<div id="content">
	<h3 class="item_title"><?=$data['title']?></h3>
	<p class="content_date color-grey">Опубликовано:
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
	<div class="content_news">
		<? foreach($randoms_news as $news){?>
			<a href="<?=Link::Custom('news', $news['translit']);?>" class="random_news <?=!isset($news['thumbnail'])?'hidden':null;?>">
				<div class="image_container">
					<img src="<?=$news['thumbnail']?>">
				</div>
				<p><?=$news['title']?></p>
			</a>
		<?}?>
		<a class="other_news" href="<?=Link::Custom('news');?>">Другие новости</a>
	</div>
</div><!--id="content"-->