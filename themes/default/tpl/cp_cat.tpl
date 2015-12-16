<div id="content">
<h1>Карта каталога</h1>
<br>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div><br>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><br><?}?>
<table width="400px" border="0" cellspacing="0" cellpadding="0" class="list">
	<tbody>
		<?$ii=0;$prev_level=0;
			foreach($list as $i){
				if($i['category_level']){?>
				<tr id="block_<?=$i['pid']?>_<?=$i['id_category']?>">
					<td><span style="margin-left:<?=$i['category_level']*18-18?>px;"><a href="<?= _base_url.'/products/'.$i['id_category'].'/'.$i['translit']?>"><?=$i['name']?></a></span></td>
				</tr>
			<?}
		}?>
	</tbody>
</table>
</div>