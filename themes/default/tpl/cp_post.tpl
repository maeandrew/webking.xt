<?if(isset($list)){?>
	<ul class="postslist">
		<?$cnt = count($list);
		if(!empty($list)){
			foreach($list as $i){
				$title = explode(' | ', $i['title']);?>
				<li>
					<div class="item animate">
						<div class="item_title"><?=$title[0];?></div>
						<div class="item_date">
							<?if(date('d-m-Y') == date('d-m-Y', strtotime($i['date']))){?>
							Сегодня
							<?}elseif(date('d-m-Y', strtotime(date('d-m-Y').' -1 day')) == date('d-m-Y', strtotime($i['date']))){?>
							Вчера
							<?}else{echo date('d-m-Y', strtotime($i['date']));}?>
						</div>
						<div class="item_description">
							<div class="item_thumb"><img class="image" src="<?=$i['thumbnail']?>" alt=""></div>
							<div class="item_descr"><?=$i['content_preview']?></div>
						</div>
						<div class="read_more mdl-cell--12-col mdl-cell--12-col-phone">
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
<?}else{?>	
	<div id="content">
		<h3 class="item_title"><?=$data['title']?></h3>		
		<p class="content_date color-grey">Опубликовано:
			<?if(date("d") == date("d", strtotime($data['date']))){?>
				Сегодня
			<?}elseif(date("d")-1 == strtotime(date("d", $data['date']))){?>
				Вчера
			<?}else{
				echo strtotime(date("d.m.Y", $data['date']));
			}?></p>
		<div class="content_page">
			<?=$data['content']?>
		</div>
		<div class="content_news"><a href="<?=Link::Custom('post');?>">Другие статьи</a></div>
	</div><!--id="content"-->
<?}?>