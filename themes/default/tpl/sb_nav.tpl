<div class="wrapper">
	<div class="catalog">
		<ul class="main_nav">
			<li data-nav="organization">
				<i class="material-icons">work</i>Для организаций
				<label class="info_key">?</label>
				<div class="info_description">
					<p>Поле для ввода примечания к товару.</p>
				</div>
			</li>
			<li data-nav="store">
				<i class="material-icons">store</i>Для магазинов
				<label class="info_key">?</label>
				<div class="info_description">
					<p>Поле для ввода примечания к товару.</p>
				</div>
			</li>
			<li class="active" data-nav="all_section">
				<i class="material-icons">list</i>Все разделы
				<label class="info_key">?</label>
				<div class="info_description">
					<p>Поле для ввода примечания к товару.</p>
				</div>
			</li>
			<li data-nav="filter">
				<i class="material-icons">filter_list</i>
				<span>
					<span class="title">Фильтры</span>
					<span class="included_filters"><? if(isset($cnt) && $cnt > 0) echo "($cnt)";?></span>
				</span>
			</li>
		</ul>
		<?if(isset($sbheader) && isset($nav)){ ?>
			<?=$nav;?>
		<?}?>
	</div>
	<div class="xt_news">
		<a href="<?=Link::Custom('news', $news['translit']);?>">
			<h6 class="min news_title"><?=$news['title']?></h6>
			<div class="min news_description"><?=$news['descr_short']?></div>
			<div class="min news_date">
				<?if(date('d-m-Y') == date("d-m-Y", $news['date'])){?>
					Опубликовано Сегодня
				<?}elseif(date('d-m-Y', strtotime(date('d-m-Y').' -1 day')) == date('d-m-Y', $news['date'])){?>
					Опубликовано Вчера
				<?}else{?>
					Опубликовано
				<?  echo date("d.m.Y", $news['date']);
				}?>
			</div>
		</a>
		<div class="min news_more">
			<a href="<?=Link::Custom('news');?>">Все новости >>></a>
		</div>
	</div>
	<?if($post != false){?>
		<div class="xt_news" style="margin-bottom:50px;">
			<a href="<?=Link::Custom('news', $news['translit']);?>">
				<h6 class="min news_title"><?=$post['title']?></h6>
				<img style="margin-top:15px;">
				<div class="min news_description"><?=$post['content_preview']?></div>
				<div class="min news_date">
					<?if(date('d-m-Y') == $post['date']){?>
						Опубликовано Сегодня
					<?}elseif($post['date']){?>
						Опубликовано Вчера
					<?}else{?>
						Опубликовано
					<?echo $post['date'];
					}?>
				</div>
			</a>
			<div class="min news_more">
				<a href="<?=Link::Custom('post');?>">Все статьи >>></a>
			</div>
		</div>
	<?}?>
</div>
<style>
	.xt_news {
		padding: 0 15px;
	}
	.min {
		padding-top: 15px;
	}
	.xt_news h6 {
		color: #000;
		margin: 0;
	}
	.xt_news .news_description {
		font-size: 13px;
	}
	.xt_news .news_date,
	.news_more {
		font-style: italic;
	}
	/*hr {
		width: 90%;
		margin: 15px auto 0;
	}*/
	.xt_news img {
		width: 100%;
	    height: 160px;
	    box-sizing: border-box;
	    background-color: #999;
	}
</style>