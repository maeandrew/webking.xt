<!-- <div id="content">
	<div class="content_page">
		<ul class="pages_list">
			<?foreach($data as $key => $value){?>
				<?$title = explode(' | ', $value['title']);?>
				<li>
					<div class="fleft identifier color-sgrey"><?=$cnt;?>.</div>
					<div class="fleft"><a href="/post/<?=$value['id']?>/<?=$value['translit'];?>/"><?=$title[0];?></a></div>
				</li>
				<?$cnt--;
			}?>
		</ul>
	</div>
</div>
 -->
<ul class="postslist">
	<?$cnt = count($data);
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
					<a href="/post/<?=$i['id']?>/<?=$i['translit'];?>/">Читать статью</a>
				</div>
			</div>
		</li>
		<?$cnt--;
	}?>
</ul>