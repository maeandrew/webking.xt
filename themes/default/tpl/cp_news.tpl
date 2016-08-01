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
	<div class="share_social_block">
		<span>Поделистья:</span>
		<a href="http://vk.com/share.php?url=<?=Link::Custom($GLOBALS['CurrentController'], $GLOBALS['Rewrite']);?>&title=<?=$data['title']?>&description=<?=strip_tags($data['descr_short'])?>&image=[IMAGE]&noparse=true" target="_blank" class="vk" title="Вконтакте" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false"><img src="<?=$GLOBALS['URL_img_theme']?>vk.svg" alt="Вконтакте"></a>
		<a href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=<?=Link::Product($GLOBALS['Rewrite']);?>&st.comments=<?=$data['title']?>" target="_blank" class="ok" title="Однокласники" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false"><img src="<?=$GLOBALS['URL_img_theme']?>odnoklassniki.svg" alt="Однокласники"></a>
		<a href="https://plus.google.com/share?url=<?=Link::Custom($GLOBALS['CurrentController'], $GLOBALS['Rewrite']);?>" target="_blank" class="g_pl" title="google+" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false"><img src="<?=$GLOBALS['URL_img_theme']?>google-plus.svg" alt="google+"></a>
		<a href="http://www.facebook.com/sharer.php?u=<?=Link::Custom($GLOBALS['CurrentController'], $GLOBALS['Rewrite']);?>" target="_blank" class="f" title="Facebook" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false"><img src="<?=$GLOBALS['URL_img_theme']?>facebook.svg" alt="Facebook"></a>
		<a href="https://twitter.com/share?url=<?=Link::Custom($GLOBALS['CurrentController'], $GLOBALS['Rewrite']);?>&text=<?=$data['title']?>" target="_blank" class="tw" title="Twitter" onclick="popupWin = window.open(this.href,'contacts','location,width=500,height=400,top=100,left=100'); popupWin.focus(); return false"><img src="<?=$GLOBALS['URL_img_theme']?>twitter.svg" alt="Twitter"></a>
	</div>	
</div><!--id="content"-->