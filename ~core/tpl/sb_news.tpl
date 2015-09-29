<?if(!empty($list)){?>
	<div class="sb_block">
		<h4>Последние новости</h4>
		<div class="sb_container">
			<?foreach($list as $i){?>
				<div class="dl">
					<div class="news_title">
						<a title="Читать новость" href="<?=_base_url;?>/news/<?=$i['id_news']?>/<?=$i['translit']?>/"><?=$i['title']?></a>
					</div>
					<div class="published_date">Опубликовано:
						<?if(date("d") == date("d", $i['date'])){?>
							Сегодня
						<?}elseif(date("d")-1 == date("d", $i['date'])){?>
							Вчера
						<?}else{
							echo date("d.m.Y", $i['date']);
						}?>
					</div>
					<p><?=$i['descr_short'];?></p>
				</div>
			<?}?>
			<a href="<?=_base_url;?>/newslist/" class="fright">Все новости</a>
		</div>
	</div>
<?}?>