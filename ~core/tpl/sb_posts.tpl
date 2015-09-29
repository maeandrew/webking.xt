<?if(!empty($posts)){?>
	<div class="sb_block">
		<h4>Статьи</h4>
		<div class="sb_container">
			<?foreach($posts as $k=>$i){
				if($k < 3){?>
					<div class="dl">
						<div class="post_title">
							<a title="Читать полностью" href="<?=_base_url;?>/post/<?=$i['id']?>/<?=$i['translit']?>/"><?=$i['title']?></a>
						</div>
						<div class="published_date">Опубликовано:
							<?if(date("d") == date("d", strtotime($i['date']))){?>
								Сегодня
							<?}elseif(date("d")-1 == date("d", strtotime($i['date']))){?>
								Вчера
							<?}else{
								echo date("d.m.Y", strtotime($i['date']));
							}?>
						</div>
						<p><?=$i['content_preview'];?></p>
					</div>
				<?}
			}?>
			<a href="<?=_base_url;?>/posts/" class="fright">Все статьи</a>
		</div>
	</div>
<?}?>