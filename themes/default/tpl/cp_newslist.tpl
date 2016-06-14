<ul class="newslist">
	<?if(!empty($list)){
		foreach($list as $i){?>
			<li>
				<div class="item animate mdl-grid">
					<a href="<?=Link::Custom('news', $i['translit']);?>"><h3 class="item_title mdl-cell mdl-cell--12-col mdl-cell--12-col-phone"><?=$i['title']?></h3></a>
					<div class="item_date mdl-cell mdl-cell--12-col mdl-cell--12-col-phone">
						<?if(date('d-m-Y') == date("d-m-Y", $i['date'])){?>
							Сегодня
						<?}elseif(date('d-m-Y', strtotime(date('d-m-Y').' -1 day')) == date('d-m-Y', $i['date'])){?>
							Вчера
						<?}else{
							echo date("d.m.Y", $i['date']);
						}?>
					</div>
					<div class="item_description">
						<div class="item_thumb <?=!isset($i['thumbnail'])?'hidden':null;?>"><img src="<?=$i['thumbnail']?>" alt=""></div>
						<div class="item_descr"><?=$i['descr_short']?></div>
					</div>
					<div class="read_more mdl-cell--12-col mdl-cell--12-col-phone">
						<a href="<?=Link::Custom('news', $i['translit']);?>">Читать новость</a>
					</div>
				</div>
			</li>
		<?}
	}else{?>
		Новостей нет
	<?}?>
</ul>
