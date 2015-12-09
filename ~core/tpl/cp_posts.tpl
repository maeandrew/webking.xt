<ul class="postslist">
	<?$cnt = count($data);
	if(!empty($data)){
		foreach($data as $i){
			$title = explode(' | ', $i['title']);?>
			<li class="col-sm-6 col-md-4 col-lg-3">
				<div class="item animate">
					<div class="item_title"><?=$title[0];?></div>
					<div class="item_date">
						<?if(date('d-m-Y') == date('d-m-Y', strtotime($i['date']))){?>
							Сегодня
						<?}elseif(date('d-m-Y', strtotime(date('d-m-Y').' -1 day')) == date('d-m-Y', strtotime($i['date']))){?>
							Вчера
						<?}else{
							echo date('d-m-Y', strtotime($i['date']));
						}?>
					</div>
					<div class="item_description"><?=isset($i['content_preview'])?$i['content_preview']:null;?></div>
					<div class="read_more">
						<a href="<?=Link::Custom('post', $i['translit']);?>">Читать статью</a>
					</div>
				</div>
			</li>
			<?$cnt--;
		}
	}else{?>
		Пока нет ни одной статьи
	<?}?>
</ul>