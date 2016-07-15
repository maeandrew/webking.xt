<?if(isset($GLOBALS['REQAR'][1]) && $_SESSION['member']['gid'] == _ACL_REMOTE_CONTENT_ && $_SESSION['member']['id_user'] != $_POST['create_user']) die("Access denied");?>
<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>
<div id="productae">
	<form action="<?=$GLOBALS['URL_request']?>" method="post" class="grid" id="product_form">
		<div class="prod_head">
			<?if($GLOBALS['CurrentController'] == 'productedit'){?>
				<div class="fl head_block">
					<span class="product_name"><?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null?></span>
					<span class="article"><b>Артикул:</b> <?=isset($_POST['art'])?htmlspecialchars($_POST['art']):null?></span>
				</div>
				<div class="fr">
					<span><b>Наличие:</b> <?=($_POST['price_opt'] > 0 || $_POST['price_mopt'] > 0)  && $_POST['visible'] != 0?'Есть':'Нет'?></span>
					<button name="smb_duplicate" type="submit" class="btn-m-lblue">Дублировать</button>
					<span class="product_view"><a href="<?=$GLOBALS['URL_base'].$_POST['translit']?>.html" target="_blank">Просмотр товара</a></span>
					<input type="hidden" name="id_product" id="id_product" value="<?=isset($_POST['id_product'])?$_POST['id_product']:0?>">
					<button name="smb_new" type="submit" class="btn-m-default">Сохранить и создать новый</button>
					<button name="smb" type="submit" class="btn-m-default fr">Сохранить</button>
				</div>
			<?}else{?>
				<button name="smb" type="submit" class="btn-m-default fr prod_add_js">Сохранить</button>
			<?}?>
		</div>
		<div id="second_navigation">
			<div class="second_nav_menu">
				<ul class="nav">
					<?if($GLOBALS['CurrentController'] == 'productedit'){?>
						<li class="active"><a href="#nav_comment">Вопросы по товару</a></li>
					<?}?>
					<li <?=$GLOBALS['CurrentController'] == 'productadd'?'class="active"':null?>><a href="#nav_product">Товар, фото, видео</a></li>
					<li><a href="#nav_seo">SEO</a></li>
					<li><a href="#nav_content">Контент товара</a></li>
					<li><a href="#nav_params">Параметры товара</a></li>
					<li><a href="#nav_delivery">Доставка</a></li>
					<li><a href="#nav_connection">Категория и связь</a></li>
					<li><a href="#nav_information">Информация</a></li>
					<?if($_SESSION['member']['gid'] != _ACL_REMOTE_CONTENT_){?><li><a href="#nav_visible">Видимость и индексация</a></li><?}?>
					<?if($GLOBALS['CurrentController'] == 'productedit' && $_SESSION['member']['gid'] != _ACL_REMOTE_CONTENT_){?>
						<li><a href="#nav_delete">Удаление товара</a></li>
					<?}?>
					<li class="main_photo">
						<img src="<?if(isset($_POST['images'])){
							echo file_exists($GLOBALS['PATH_root'].'..'.$_POST['images'][0]['src'])?htmlspecialchars($_POST['images'][0]['src']):'/images/nofoto.png';
						}else{
							echo '/images/nofoto.png';
						}?>" alt="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null?>">
					</li>
				</ul>
			</div>
			<div class="tabs-panel">
				<?if($GLOBALS['CurrentController'] == 'productedit'){?>
				<div id="nav_comment">
					<h2>Вопросы по товару</h2>
					<?if(isset($list_comment) && count($list_comment)){?>
						<form action="<?=$GLOBALS['URL_request']?>" method="post">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
								<col width="75%">
								<col width="1%">
								<col width="23%">
								<col width="1%">
								<thead>
								  <tr>
									<td class="left">Комментарий</td>
									<td class="left">Видимость</td>
									<td class="left">Товар</td>
									<td class="left"></td>
								  </tr>
								</thead>
								<tbody>
								<?foreach($list_comment as $i){?>
									<?$interval = date_diff(date_create(date("d.m.Y", strtotime($i['date_comment']))), date_create(date("d.m.Y")));?>
									<tr class="coment<?=$i['Id_coment']?> animate <?if(!$i['visible'] && $interval->format('%a') < 3){?>bg-lyellow<?}?>">
										<td><span class="date"><?=date("d.m.Y", strtotime($i['date_comment']))?></span> <?=!$i['visible']?'<span class="invisible">скрытый</span>':null?><br><?=$i['text_coment']?></td>
										<td class="center np"><input type="checkbox" id="pop_<?=$i['Id_coment']?>" name="pop_<?=$i['Id_coment']?>" <?if(isset($pops1[$i['Id_coment']])){?>checked="checked"<?}?> onchange="SwitchPops1(this, <?=$i['Id_coment']?>)"></td>
										<td><a href="<?='/product/'.$i['url_coment']?>"><?=$i['name']?></a></td>
										<td class="center np actions"><a class="icon-delete" onClick="if(confirm('Комментарий будет удален.\nПродолжить?') == true){dropComent(<?=$i['Id_coment']?>);};">t</a></td>
									</tr>
								<?}?>
									<tr>
										<td>&nbsp;</td>
										<td class="center"><input class="btn-m-default-inv" type="submit" name="smb" id="form_submit" value="&uarr;&darr;"></td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
								</tbody>
							</table>
						</form>
					<?}else{?>
						<div class="notification warning"> <span class="strong">Комментариев нет</span></div>
					<?}?>
				</div>
				<?}?>
				<div id="nav_product">
					<h2>Товар, фото, видео</h2>
					<div class="row">
						<div class="col-md-2">
							<label for="art">Артикул:</label><?=isset($errm['art'])?"<span class=\"errmsg\">".$errm['art']."</span><br>":null?>
							<input type="text" class="input-m" value="<?=isset($_POST['art'])?$_POST['art']:$last_article?>" disabled="disabled">
							<input type="hidden" name="art" id="art" class="input-m" value="<?=isset($_POST['art'])?$_POST['art']:$last_article?>">
						</div>
						<div class="col-md-10">
							<label for="name">Название:</label><?=isset($errm['name'])?"<span class=\"errmsg\">".$errm['name']."</span><br>":null?>
							<input required type="text" name="name" id="name" class="input-m" value="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null?>">
						</div>
						
						<div class="col-md-12">
							<?if(isset($_POST['translit'])){?>
								<div id="translit">
									<label>URL сраницы:</label>
									<p><?=$GLOBALS['URL_base'].$_POST['translit']?>.html</p>
									<a href="#" id="updtrans" class="refresh_btn icon-font" title="Нажимать, только при полной замене товара" onclick="updateTranslit();">f</a>
								</div>
							<?}?>
						</div>
					</div>
					<label>Изображения товара на x-torg.com:</label>
					<div class="row" id="preview1">
						<div class="col-md-2">
							<img class="pic_block" id="i1" src="<?=(isset($_POST['img_1'])&&$_POST['img_1']!='')?str_replace("/efiles/", "/efiles/_thumb/", $_POST['img_1']):"/images/nofoto.png"?>">
						</div>
						<div class="col-md-10">
							<input type="text" id="img_1" name="img_1" class="input-m" value="<?=isset($_POST['img_1'])?$_POST['img_1']:null?>">
						</div>
					</div>
					<div class="row" id="preview2">
						<div class="col-md-2">
							<img class="pic_block" id="i2" src="<?=(isset($_POST['img_2'])&&$_POST['img_2']!='')?str_replace("/efiles/", "/efiles/_thumb/", $_POST['img_2']):"/images/nofoto.png"?>">
						</div>
						<div class="col-md-10">
							<input type="text" id="img_2" name="img_2" class="input-m" value="<?=isset($_POST['img_2'])?$_POST['img_2']:null?>">
						</div>
					</div>
					<div class="row" id="preview3">
						<div class="col-md-2">
							<img class="pic_block" id="i3" src="<?=(isset($_POST['img_3'])&&$_POST['img_3']!='')?str_replace("/efiles/", "/efiles/_thumb/", $_POST['img_3']):"/images/nofoto.png"?>">
						</div>
						<div class="col-md-10">
							<input type="text" id="img_3" name="img_3" class="input-m" value="<?=isset($_POST['img_3'])?$_POST['img_3']:null?>">
						</div>
					</div>
					<label>Изображения товара xt.ua:</label>
					<div id="photobox">
						<div class="previews">
							<?if(isset($_POST['images']) && !empty($_POST['images'])){
								foreach($_POST['images'] as $photo){
									if(isset($photo['src'])){?>
										<div class="image_block dz-preview dz-image-preview <?=$photo['visible']==0?'implicit':null?>">
											<div class="sort_handle"><span class="icon-font">s</span></div>
											<div class="image">
												<img data-dz-thumbnail src="<?=$photo['src']?>"/>
											</div>
											<div class="name">
												<span class="dz-filename" data-dz-name><?=$photo['src']?></span>
												<span class="dz-size" data-dz-size></span>
											</div>
											<div class="visibility">
												<p><span class="icon-font hide_photo_js" title="Скрыть/отобразить">v</span></p>
											</div>
											<div class="controls">
												<p><span class="icon-font del_photo_js" title="Удалить" data-dz-remove>t</span></p>
											</div>
											<input type="hidden" name="images[]" value="<?=$photo['src']?>">
											<input type="hidden" name="images_visible[]" value="<?=$photo['visible']==0?'0':'1'?>">
										</div>
									<?}
								}
							}?>
						</div>
						<div class="image_block_new drop_zone animate">
							<div class="dz-default dz-message">Перетащите сюда фото или нажмите для загрузки.</div>
							<input type="file" multiple="multiple" class="dz-hidden-input" style="visibility: hidden; position: absolute; top: 0px; left: 0px; height: 0px; width: 0px;">
						</div>
					</div>
					<label>Видео о товарe:</label>
					<p class="add_video">Добавить видео <span class="icon-font">a</span></p>
					<ul class="video_block">
						<?if(isset($_POST['video']) && !empty($_POST['video'])){
							foreach ($_POST['video'] as $key => $value) {?>
								<li><input type="text" name="video[]" class="input-m" value="<?=$value?>"><span class="icon-font remove_video">t</span></li>
							<?}
						}?>
					</ul>
				</div>
				<div id="nav_seo" chass="hidden">
					<h2>SEO</h2>
					<div class="row">
						<div class="col-md-12">							
							<label for="page_title">Мета-заголовок (title):</label>
							<p class="hint">Перед текстом будет автоматически добавлен ключ - "<span><?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null?>.</span>"</p>
							<?=isset($errm['page_title'])?"<span class=\"errmsg\">".$errm['page_title']."</span><br>":null?>
							<input type="text" name="page_title" id="page_title" class="input-m" value="<?=isset($_POST['page_title']) && !empty($_POST['page_title'])?htmlspecialchars($_POST['page_title']):'Купить в Украине с доставкой - оптовый интернет магазин ХТ.'?>">
							<label for="page_description">Мета-описание (description):</label>
							<p class="hint">Перед текстом будет автоматически добавлен ключ - "<span><?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null?>.</span>"</p>
							<?=isset($errm['page_description'])?"<span class=\"errmsg\">".$errm['page_description']."</span><br>":null?>
							<textarea name="page_description" id="page_description" size="20" cols="223" rows="5" class="input-m"><?=isset($_POST['page_description']) && !empty($_POST['page_description'])?htmlspecialchars($_POST['page_description']):'ХТ - крупнейший интернет-магазине в Украине &#10003;. Продажа крупным оптом, оптом и в розницу. &#9990; (050)3098420, (067)5741013 Адресная доставка Киев, Харьков, Одесса, Днепропетровск, Запорожье, Львов.'?></textarea>
							<label for="keywords">Ключевые слова (keywords):</label>
							<?=isset($errm['page_keywords'])?"<span class=\"errmsg\">".$errm['page_keywords']."</span><br>":null?>
							<textarea class="input-m" name="page_keywords" id="keywords" cols="10" rows="5"><?=isset($_POST['page_keywords'])?htmlspecialchars($_POST['page_keywords']):null?></textarea>
						</div>
					</div>
				</div>
				<div id="nav_content">
					<h2>Контент товара</h2>
					<div class="row">
						<?if($GLOBALS['CurrentController'] == 'productedit'){?>
							<div class="col-md-12">
								<label>Привязанные характеристики:</label>
								<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
									<colgroup>
										<col width="30%">
										<col width="30%">
										<col width="30%">
										<col width="10%">
									</colgroup>
									<thead>
										<tr>
											<td class="left">Описание характеристики</td>
											<td class="left">Единицы измерения</td>
											<td class="left">Значение</td>
											<td class="left">Управление</td>
										</tr>
									</thead>
									<tbody>
										<?$ids = array();
										if(!empty($product_specs)){
											foreach($product_specs as $i){
												$ids[] = $i['id_spec'];?>
												<tr id="spec<?=$i['id_spec']?>" class="animate">
													<td>
														<?=$i['caption']?>
													</td>
													<td>
														<?=$i['units']?>
													</td>
													<td>
														<input  data-id-type="<?=$i['id_spec']?>" list="features" class="input-m itemvalue" type="text" name="value" onchange="insertValueLink($(this));" value="<?=$i['value']?>">
														<input type="hidden" name="id_spec_prod" value="<?=$i['id']?>">
														<input type="hidden" name="id_spec" value="<?=$i['id_spec']?>">
														<datalist id="features">


															<option value="Firefox">
															<option value="Chrome">
															<option value="Opera">
															<option value="Safari">
														</datalist>
													</td>
													<td class="left actions">
														<nobr>
															<?if(isset($i['id']) && $i['id'] > 0){?>
																<a class="btn-m-green-inv" href="/adm/productedit/<?=$_POST['id_product']?>/?action=update_spec&id_spec_prod=<?=$i['id']?>&id_spec=<?=$i['id_spec']?>&value=" onclick="insertValueLink($(this)); return false;">Обновить</a>
																<a class="btn-m-red-inv" href="/adm/productedit/<?=$_POST['id_product']?>/?action=delete_spec&id_spec_prod=<?=$i['id']?>" onclick="return confirm('Точно удалить?');">Удалить</a>
															<?}?>
														</nobr>
													</td>
												</tr>
											<?}
										}else{?>
											<tr id="empty2" class="animate">
												<td colspan="4">Не привязано ни одной характеристики</td>
											</tr>
										<?}?>
									</tbody>
								</table>
							</div>
							<div class="col-md-12">
								<label for="sid">Добавление характеристики:</label>
								<?=isset($errm['sid'])?"<span class=\"errmsg\">".$errm['sid']."</span><br>":null?>
								<select name="sid" id="sid" class="select_unit input-m">
									<?$i = 0;
									foreach($specs as $s){
										if(!in_array($s['id'], $ids)){
											$i++;?>
											<option value="<?=$s['id']?>"><?=$s['caption']?>
											<?if($s['units'] !== ''){
												echo('('.$s['units'].')');
											}?>
											</option>
										<?}
									}
									if($i == 0){?>
										 <option disabled="disabled" selected="selected">Все характеристики добавлены</option>
									<?}?>
								</select>
								<input type="text" class="units_input input-m" <?=$i == 0?'disabled="disabled"':null;?>>
								<button class="btn-m-default addspec" <?=$i == 0?'disabled="disabled"':null;?> onclick="insertSpecToProd($(this));">Добавить</button>
							</div>
						<?}?>
						<div class="col-md-12">
							<label for="descr">Описание x-torg.com:</label><?=isset($errm['descr'])?"<span class=\"errmsg\">".$errm['descr']."</span><br>":null?>
							<textarea name="descr" id="descr" class="input-m" rows="5" cols="50"><?=isset($_POST['descr'])?htmlspecialchars($_POST['descr']):null?></textarea>
							<label for="descr">Описание xt.ua(краткое):</label><?=isset($errm['descr'])?"<span class=\"errmsg\">".$errm['descr']."</span><br>":null?>
							<textarea name="descr_xt_short" id="descr_xt_short" class="input-m" rows="5" cols="50"><?=isset($_POST['descr_xt_short'])?htmlspecialchars($_POST['descr_xt_short']):null?></textarea>
							<label for="descr">Описание xt.ua(полное):</label><?=isset($errm['descr'])?"<span class=\"errmsg\">".$errm['descr']."</span><br>":null?>
							<textarea name="descr_xt_full" id="descr_xt_full" class="input-m" rows="5" cols="50"><?=isset($_POST['descr_xt_full'])?htmlspecialchars($_POST['descr_xt_full']):null?></textarea>
							<label>Инструкция подлинности:</label>
							<textarea name="instruction" cols="30" rows="6"><?=isset($_POST['instruction'])?htmlspecialchars($_POST['instruction']):null?></textarea>
							<label for="note_control"><b>Требовать заполнение примечания &nbsp;</b>
								<input type="checkbox" name="note_control" id="note_control" class="input-m" <?=isset($_POST['note_control'])&&($_POST['note_control'])?'checked="checked" value="on"':null?>>
							</label>
						</div>
					</div>
				</div>
				<div id="nav_params">
					<h2>Параметры товара</h2>
					<label for="id_unit_xt">Единицы измерения для x-torg.com</label>
					<select class="input-m" name="id_unit" id="id_unit_xt" style="width:150px;">
						<?foreach($unitslist as $value){?>
							<option value="<?=$value['id']?>"<?=(isset($_POST['id_unit']) && $_POST['id_unit'] == $value['id'])?'selected="true"':null?>><?=$value['unit_xt']?></option>
						<?}?>
					</select>
					<label for="id_unit_prom">Единицы измерения для prom.ua</label>
					<input type="text" class="input-m" id="id_unit_prom" value="<?=isset($_POST['unit_prom'])?$_POST['unit_prom']:null?>" disabled="disabled" style="width:150px;">
					<label for="min_mopt_qty">Минимальное количество по мелкому опту:</label><?=isset($errm['min_mopt_qty'])?"<span class=\"errmsg\">".$errm['min_mopt_qty']."</span><br>":null?>
					<input type="text" name="min_mopt_qty" id="min_mopt_qty" class="input-m" value="<?=isset($_POST['min_mopt_qty'])?htmlspecialchars($_POST['min_mopt_qty']):1?>">
					<label for="inbox_qty">Количество в ящике:</label><?=isset($errm['inbox_qty'])?"<span class=\"errmsg\">".$errm['inbox_qty']."</span><br>":null?>
					<input type="text" name="inbox_qty" id="inbox_qty" class="input-m" value="<?=isset($_POST['inbox_qty'])?htmlspecialchars($_POST['inbox_qty']):1?>">
					<label for="qty_control">
						<input style="vertical-align:middle;" type="checkbox" name="qty_control" id="qty_control" class="input-m" <?=isset($_POST['qty_control'])&&($_POST['qty_control'])?'checked="checked" value="on"':null?>>
						<b>Необходима кратность &nbsp;</b>
					</label>
					<input type="hidden" name="price_opt" value="<?=isset($_POST['price_opt'])?htmlspecialchars($_POST['price_opt']):0?>">
					<input type="hidden" name="price_coefficient_opt" id="price_coefficient_opt" class="input-m" value="<?=isset($_POST['price_coefficient_opt'])?htmlspecialchars($_POST['price_coefficient_opt']):1?>">
					<input type="hidden" name="price_mopt" value="<?=isset($_POST['price_mopt'])?htmlspecialchars($_POST['price_mopt']):0?>">
					<input type="hidden" name="price_coefficient_mopt" id="price_coefficient_mopt" class="input-m" value="<?=isset($_POST['price_coefficient_mopt'])?htmlspecialchars($_POST['price_coefficient_mopt']):1?>">
				</div>
				<div id="nav_delivery">
					<h2>Доставка</h2>
					<div class="fl">
						<label for="height">Высота (cм):</label>
						<input type="number" min="0" step="0.01" name="height" id="height" class="input-m" value="<?=isset($_POST['height'])?htmlspecialchars($_POST['height']):0?>">
					</div>
					<div class="fl">
						<label for="width">Ширина (см):</label>
						<input type="number" min="0" step="0.01" name="width" id="width" class="input-m" value="<?=isset($_POST['width'])?htmlspecialchars($_POST['width']):0?>">
					</div>
					<div class="fl">
						<label for="length">Длина (см):</label>
						<input type="number" min="0" step="0.01" name="length" id="length" class="input-m" value="<?=isset($_POST['length'])?htmlspecialchars($_POST['length']):0?>">
					</div>
					<label for="coefficient_volume">Коэффициент реального обьема:</label>
					<input type="number" min="0" step="0.01" name="coefficient_volume" id="coefficient_volume" class="input-m" value="<?=isset($_POST['coefficient_volume'])?htmlspecialchars($_POST['coefficient_volume']):1?>">
					<label class="weight">Объем:
						<span>
							<?if(isset($_POST['weight']) ){
								if($_POST['weight'] == 0){?>
									Заполните поля (ВхШхД)
								<?}else{
									echo htmlspecialchars($_POST['weight']).' м3';
								}
							}else{?>
								-
							<?}?>
						</span>
					</label>
					<input type="hidden" name="weight" id="weight" class="input-m" value="<?=isset($_POST['weight'])?htmlspecialchars($_POST['weight']):0?>">
					<label for="volume">Вес:</label><?=isset($errm['volume'])?"<span class=\"errmsg\">".$errm['volume']."</span><br>":null?>
					<input type="text" name="volume" id="volume" class="input-m" value="<?=isset($_POST['volume'])?htmlspecialchars($_POST['volume']):0?>">
				</div>
				<div id="nav_connection">
					<h2>Категория и связь</h2>
					<label>Категория:</label><?=isset($errm['categories_ids'])?"<span class=\"errmsg\">".$errm['categories_ids']."</span><br>":null?>
					<?foreach($_POST['categories_ids'] as $k=>$cid){?>
						<div class="catblock">
							<select required name="categories_ids[]" class="input-m">
								<option selected="true" disabled value="0"> &nbsp;&nbsp;выберите категорию...</option>
								<?foreach($list as $item){?>
									<option <?=($item['id_category'] == $cid['id_category'])?'selected="true"':null?> value="<?=$item['id_category']?>"><?=str_repeat("&nbsp;&nbsp;&nbsp;", $item['category_level'])?> <?=$item['name']?></option>
								<?}?>
							</select>
							<span class="icon-font delcat" title="Удалить">t</span>
							<input type="radio" name="main_category" id="" class="input-m" value="<?=$k?>" <?=($cid['main'] == '1')?'checked':null?> required /> Сделать основной
						</div>
					<?}?>
					<?if($GLOBALS['CurrentController'] == 'productadd'){?>
						<input type="hidden" name="categories_ids[]" value="<?=$GLOBALS['CONFIG']['new_catalog_id'];?>">
					<?}?>
					<div id="addlink"><a class="dashed" href="javascript://" onclick="AddCat(this)">Добавить категорию</a></div>
					<?if($GLOBALS['CurrentController'] == 'productedit'){?>
						<label>Cопутствующие товары:</label>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
							<colgroup>
								<col width="20%">
								<col width="20%">
								<col width="50%">
								<col width="10%">
							</colgroup>
							<thead>
								<tr>
									<td class="left">Изображение товара</td>
									<td class="left">Артикул</td>
									<td class="left">Название товара</td>
									<td class="left">Управление</td>
								</tr>
							</thead>
							<tbody>
								<?if(!empty($related_prods_list)){
									foreach($related_prods_list as $rpl){?>
										<tr id="rel_prod<?=$rpl['id_product']?>" class="animate">
											<td>
												<img class="pic_block" src="<?=$rpl['img_1']?>" alt="<?=$rpl['name']?>">
											</td>
											<td>
												<?=$rpl['art']?>
											</td>
											<td>
												<?=$rpl['name']?>
											</td>
											<td class="left actions">
												<nobr>
													<button class="btn-m-red-inv" onclick="if(confirm('Точно удалить?')){editRelatedProds(<?=$rpl['id_product']?>, 'remove');} return false;">Удалить</button>
												</nobr>
											</td>
										</tr>
									<?}
								}else{?>
									<tr id="empty2" class="animate">
										<td colspan="4">Не привязано ни одного товара</td>
									</tr>
								<?}?>
							</tbody>
						</table>
						<div class="row">
							<div class="col-md-12">
								<p>Привязать товар по артикулу:</p>
								<p>Обязательно выберите вариант из выпадающего списка!</p>
								<input list="character" class="input-m" id="article" name="article">
								<datalist id="character"></datalist>
								<button class="btn-m-default addspec" onclick="editRelatedProds($('#article').val().substr($('#article').val().lastIndexOf('|') + 2), 'insert'); return false;">Привязать</button>
							</div>
						</div>
					<?}?>
					<?if($_SESSION['member']['gid'] != _ACL_REMOTE_CONTENT_){?>
						<label>Данные поставщика:</label>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1 supplier">
							<colgroup>
								<col width="10%">
								<col width="20%">
								<col width="15%">
								<col width="35%">
								<col width="15%">
								<col width="5%">
							</colgroup>
							<thead>
								<tr>
									<td class="center">Артикул</td>
									<td>Имя</td>
									<td>№ телефона</td>
									<td class="center">Цена</td>
									<td class="center">Наличие</td>
									<td></td>
								</tr>
							</thead>
							<tbody>
								<?if(!empty($suppliers_info)){
									foreach($suppliers_info as $k => $si){?>
										<tr class="animate supp_js">
											<td class="center"><?=$si['article']?><input type="hidden" class="id_assortiment" name="id_assortiment[]" value="<?=$si['id_assortiment']?>"></td>
											<td class="supp_name_js"><?=$si['name']?></td>
											<td>
												<?if($si['real_phone'] == '380'){
													echo 'не указан';
												}else{
													echo $si['real_phone'];
												}?>
											</td>
											<td>
												<div class="select_price fl">
													<label>Цена в:</label>
													<select name="inusd[]" class="input-m">
														<option value="0">ГРН</option>
														<option value="1" <?=$si['inusd']=='1'?'selected':null?>>USD</option>
													</select>
												</div>
												<div class="fl price">
													<label>Опт:</label><input type="number" name="price_opt_otpusk[]" min="0" step="0.01" class="input-m" value="<?=$si['inusd']=='1'?$si['price_opt_otpusk_usd']:$si['price_opt_otpusk']?>">
												</div>
												<div class="fr price">
													<label>Розница:</label><input type="number" name="price_mopt_otpusk[]" min="0" step="0.01" class="input-m" value="<?=$si['inusd']=='1'?$si['price_mopt_otpusk_usd']:$si['price_mopt_otpusk']?>">
												</div>
											</td>
											<td>
												<input type="number" name="product_limit[]" min="0" value="<?=$si['product_limit']?>" class="input-m">
											</td>
											<td>
												<input type="hidden" name="id_supplier[]" value="<?=$si['id_supplier']?>">
												<span class="icon-font del_supp_js">t</span>
											</td>
										</tr>
									<?}
								}else{?>
									<tr id="empty2" class="animate">
										<td colspan="4">Нет посавщиков</td>
									</tr>
								<?}?>
							</tbody>
						</table>
						<label>Добавление поставщика:</label>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1 add_supplier">
							<colgroup>
								<col width="20%">
								<col width="60%">
								<col width="10%">
								<col width="10%">
							</colgroup>
							<thead>
								<tr>
									<td class="center">Артикул</td>
									<td class="center">Цена</td>
									<td class="center">Наличие</td>
									<td></td>
								</tr>
							</thead>
							<tbody>
								<tr class="animate">
									<td>
										<input list="data_sup_art" type="text" id="sup_art" class="input-m" placeholder="S100" autocomplete="off">
										<datalist id="data_sup_art"></datalist>
									</td>
									<td>
										<div class="select_price fl">
											<label class="inusd fl">Цена в:</label>
											<select name="inusd[]" id="sup_inusd" class="input-m">
												<option value="0">ГРН</option>
												<option value="1">USD</option>
											</select>
										</div>
										<div class="fr price">
											<label>Розничная</label><input type="number" min="0" step="0.01" id="sup_price_mopt" class="input-m" placeholder="По умолчанию в (грн)">
										</div>
										<div class="fr price">
											<label>Оптовая</label><input type="number" min="0" step="0.01" id="sup_price_opt" class="input-m" placeholder="По умолчанию в (грн)">
										</div>
									</td>
									<td>
										<input type="number" min="0" value="1000000" id="sup_product_limit" class="input-m">
									</td>
									<td>
										<button id="add_sup_js" class="btn-m-default fr">Привязать</button>
									</td>
								</tr>
							</tbody>
						</table>
					<?}?>
					<label>Привязанные сегментации:</label>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1 segmentations">
						<colgroup>
							<col width="10%">
							<col width="55%">
							<col width="15%">
							<col width="15%">
							<col width="5%">
						</colgroup>
						<thead>
							<tr>
								<td class="left">Тип</td>
								<td class="left">Название</td>
								<td class="left">Дата</td>
								<td class="left">Кол-во дней</td>
								<td class="left"></td>
							</tr>
						</thead>
						<tbody>
							<?if(!empty($segmentations)){
								foreach($segmentations as $s){?>
									<tr class="animate segment_js">
										<td class="type_name"><?=$s['type_name']?></td>
										<td class="name"><?=$s['name']?></td>
										<td><?=$s['date']?></td>
										<td><?=$s['count_days']?></td>
										<td class="left actions">
											<span class="icon-font del_segment">t</span>
											<input type="hidden" class="id_segment" value="<?=$s['id']?>">
										</td>
									</tr>
								<?}
							}else{?>
								<tr class="animate empty">
									<td colspan="12" class="center">Не привязано ни одной сегментации</td>
								</tr>
							<?}?>
						</tbody>
					</table>
					<label for="segment_type">Добавление сегментации:</label>
					<select id="segment_type" class="input-m">
						<?if(isset($list_segment_types) && !empty($list_segment_types)){?>
							<option></option>
							<?foreach($list_segment_types as $lst){?>
								<option value="<?=$lst['id']?>"><?=$lst['type_name']?></option>
							<?}
						}else{?>
							<option>Нет сегментаций</option>
						<?}?>
					</select>
					<select id="segment_list" class="input-m">
						<option></option>
					</select>
					<button class="btn-m-default add_segment">Добавить</button>
				</div>
				<div id="nav_information">
					<h2>Информация</h2>
					<label for="opt_correction_set">Набор корректироки по оптовой цене:</label>
					<select name="opt_correction_set" id="opt_correction_set" disabled="disabled" class="input-m">
						<option value="0">Без корректировки</option>
						<?$i = 0;
						while(isset($GLOBALS['CONFIG']['correction_set_'.$i])){?>
							<option value="<?=$i?>" <?=(isset($_POST['opt_correction_set']) && $_POST['opt_correction_set'] == $i)?'selected':null?> ><?=$GLOBALS['CONFIG']['correction_set_'.$i]?></option>
							<?$i++;
						}?>
					</select>
					<label for="mopt_correction_set">Набор корректироки по розничной цене:</label>
					<select name="mopt_correction_set" id="mopt_correction_set" disabled="disabled" class="input-m">
						<option value="0">Без корректировки</option>
						<?$i = 0;
						while(isset($GLOBALS['CONFIG']['correction_set_'.$i])){?>
							<option value="<?=$i?>" <?=(isset($_POST['mopt_correction_set']) && $_POST['mopt_correction_set'] == $i)?'selected':null?>><?=$GLOBALS['CONFIG']['correction_set_'.$i]?></option>
							<?$i++;
						}?>
					</select>
					<div class="edition">
						Дата, время добавления товара: <b><?=isset($_POST['create_date'])?$_POST['create_date']:'-';?></b><br>
						Автор: <b><?=isset($_POST['createusername'])?$_POST['createusername']:'-'?></b>
					</div>
					<?if($GLOBALS['CurrentController'] == 'productedit'){?>
						<div class="edition">
							Дата, время редактирования товара: <b><?=isset($_POST['edit_date'])?$_POST['edit_date']:'-';?></b><br>
							Редактор: <b><?=isset($_POST['username'])?$_POST['username']:'-'?></b>
						</div>
						<label>Просмотры на сайте: <span><?=$_POST['count_views']?></span></label>
					<?}?>
					<label for="notation_price">Примечание: </label>
					<textarea name="notation_price" id="notation_price" cols="30" rows="10"><?=isset($_POST['notation_price'])?htmlspecialchars($_POST['notation_price']):null?></textarea>
				</div>
				<?if($_SESSION['member']['gid'] != _ACL_REMOTE_CONTENT_){?><div id="nav_visible">
					<h2>Видимость и индексация</h2>
					<label for="visible"><b>Скрыть товар &nbsp;</b>
						<input type="checkbox" name="visible" id="visible" class="input-m" <?=isset($_POST['visible'])&&(!$_POST['visible'])?'checked="checked" value="on"':null?>>
					</label>
					<label for="indexation"><b>Индексация &nbsp;</b>
						<input type="checkbox" name="indexation" id="indexation" class="input-m" <?=(isset($_POST['indexation']) && $_POST['indexation'] != 1) || !isset($_POST['indexation'])?null:'checked="checked" value="on"'?>>
					</label>
					<label for="access_assort"><b>Добавление в ассортимент &nbsp;</b>
						<input type="checkbox" name="access_assort" id="access_assort" class="input-m" <?=(isset($_POST['access_assort']) && $_POST['access_assort'] != 1) || !isset($_POST['access_assort'])?null:'checked="checked" value="on"'?>>
					</label>
				</div>
				<div id="nav_delete">
					<h2>Удаление товара</h2>
					<label>Внимание! При удалении товара, он удалится из таблицы спецификаций, карзины, сопутствующих товаров, сегментации,
							ассортимента поставщика, избранных товаров, посещаемых товаров, листа ожидания.
					</label>
					<a class="btn-m-red delete_prod" onclick="if(confirm('Точно удалить товар?')){DelProds(<?=$_POST['id_product']?>);} return false;">Удалить товар</a>
				</div><?}?>
			</div>
		</div>
	</form>
</div>
<div id="preview-template" class="hidden">
	<div class="image_block dz-preview dz-file-preview implicit">
		<div class="sort_handle"><span class="icon-font">s</span></div>
		<div class="image">
			<img data-dz-thumbnail />
		</div>
		<div class="name">
			<span class="dz-filename" data-dz-name></span>
			<span class="dz-size" data-dz-size></span>
		</div>
		<div class="visibility">
			<p><span class="icon-font hide_u_photo_js" title="Скрыть/отобразить">v</span></p>
		</div>
		<div class="controls">
			<p><span class="icon-font del_u_photo_js" title="Удалить">t</span></p>
		</div>
		<input type="hidden" name="images_visible[]" value="0">
	</div>
</div>
<div id="templates" class="hidden">
	<div class="catblock hidden">
		<select required name="categories_ids[]" class="input-m">
			<option selected="true" disabled value="0"> &nbsp;&nbsp;выберите категорию...</option>
			<?foreach($list as $item){?>
				<option  value="<?=$item['id_category']?>"><?=str_repeat("&nbsp;&nbsp;&nbsp;", $item['category_level'])?> <?=$item['name']?></option>
			<?}?>
		</select>
		<span class="icon-font delcat" title="Удалить">t</span>
		<input type="radio" name="main_category" id="" class="input-m" value="" required /> Сделать основной
	</div>
</div>
<script type="text/javascript">
	// AjexFileManager.init({
	// 	returnTo: 'function'
	// });
	var url = URL_base+'productadd/';

	$(function(){
		if($('.catblock:not(.hidden)').length > 1){
			$('.delcat').show();
		}else{
			$('.delcat').hide();
		}
		//Удаляем div выбора дополнительной категории
		$("body").on('click', '.delcat', function(){
			$(this).closest(".catblock").remove();
			if($('.catblock:not(.hidden)').length > 1){
				$('.delcat').show();
			}else{
				$('.delcat').hide();
			}
			AddValueMainCategory();
		});
		//Подтягиваем значения типов характеристик из БД
		$('.itemvalue').focus(function(){
			var idcat='';
			var cat = $('#nav_connection select[name="categories_ids[]"]');
			cat.each(function(){
				idcat += $(this).val() + ',';
			});
			idcat = idcat.substring(0, idcat.length - 1);
			$('#features').html('');
			$.ajax({
				url: URL_base + 'ajaxspecifications',
				type: "POST",
				cache: false,
				dataType: "html",
				data: {
					"action": 'getValuesOfTypes',
					"id": $(this).data('idType'),
					"idcat": idcat
				}
			}).done(function (data) {
				$('#features').html(data);
			}).fail(function () {

			});
		});

		//Заполнение списка артикулов
		$("#article").keyup(function() {
			var inputvalue = $(this).val();
			dataList(inputvalue);
		});
		//$("#second_navigation").tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
		//$("#second_navigation li").removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );

		//Пересчет обьема при вводе
		$("#height, #width, #length").keyup(function( event ) {
			var height = $("#height").val(),
				width = $("#width").val(),
				length = $("#length").val(),
				volume = 0;
			volume = height * width * length;
			$(".weight span").html(((volume*0.000001).toFixed(6))+" м3");
		});

		//Добавление видео
		$(".add_video").on('click', function() {
			$(".video_block").append('<li><input type="text" name="video[]" class="input-m"><span class="icon-font remove_video">t</span></li>');
		});

		//Удаление видео
		$("body").on('click', '.remove_video', function() {
			if(confirm('Вы точно хотите удалить видео?')){
				$(this).parent().remove();
			}
		});

		//Загрузка Фото на сайт
		var dropzone = new Dropzone(".drop_zone", {
			method: 'POST',
			url: url+"?upload=true",
			clickable: true,
			previewsContainer: '.previews',
			previewTemplate: document.querySelector('#preview-template').innerHTML
		});
		var return_arr = new Array();
		dropzone.on('addedfile', function(file){
			//askaboutleave();
		}).on('success', function(file, path){
			file.previewElement.innerHTML += '<input type="hidden" name="images[]" value="'+path+'">';
		}).on('removedfile', function(file){
			var date = new Date(),
				year = date.getFullYear(),
				month = date.getMonth(),
				day = date.getDate(),
				removed_file2 = '/product_images/original/'+year+'/'+(month+1)+'/'+day+'/'+file.name;
			$('.previews').append('<input type="hidden" name="removed_images[]" value="'+removed_file2+'">');
		});
		dropzone.on('dragend', function(event) {
			event.preventDefault();
			/* Act on the event */
		});

		//Сортировка фото
		$('.previews').sortable({
			items: ".image_block",
			handle: ".sort_handle",
			connectWith: ".previews",
			containment: ".previews",
			placeholder: "ui-sortable-placeholder",
			axis: "y",
			scroll: false,
			tolerance: "pointer",
			out: function(){
				if ($('.previews .image_block:first-of-type').hasClass('implicit')) {
					$('.previews .image_block:first-of-type').removeClass('implicit');
				}
				$('#photobox .image_block:first-of-type [name="images_visible[]"]').val("1");
				var main_photo = $('.previews .image_block:first-of-type').find('input[name="images[]"]').val();
				$('.main_photo img').attr('src', main_photo);
			}
		});

		//Удаление фото
		$("body").on('click', '.del_photo_js', function(e) {
			//e.stopPropagation();
			if(confirm('Изобрежение будет удалено.')){
				var path = $(this).closest('.image_block'),
				removed_file = path.find('input[name="images[]"]').val();
				RemovedFile(path, removed_file);
			}
		});

		//Удаление только что загруженных фото
		$("body").on('click', '.del_u_photo_js', function(e) {
			e.stopPropagation();
			if(confirm('Изобрежение будет удалено.')){
				var path = $(this).closest('.image_block'),
				removed_file = path.find('input[name="images[]"]').val().replace('/../','/');
				RemovedFile(path, removed_file);
			}
		});
		
		$('#photobox .image_block:first-of-type [name="images_visible[]"]').val("1");
		$('.previews').on('click', '.hide_photo_js, .hide_u_photo_js', function(event) {
			var path = $(this).closest('.image_block');
			console.log($(this));
			$('#photobox .image_block:first-of-type [name="images_visible[]"]').val("1");

			if (path.hasClass('implicit')) {
				
				path.find('[name="images_visible[]"]').val("1");
				path.removeClass('implicit');

				// hidden_images = path.find('.image img').attr('src');

				// var arr = path.closest('.previews').find('[name="hidden_images[]"]');
				// arr.each(function(index, el) {
				// 	if (hidden_images == el.value) {
				// 		$(el).remove();
				// 	};
				// });
			}else{
				
				path.find('[name="images_visible[]"]').val("0");
				path.addClass('implicit');

				// hidden_images = path.find('.image img').attr('src');
				// path.closest('.previews').append('<input type="hidden" name="hidden_images[]" value="0">');

			}
		});

		//Прокрустка страницы
		$('a[href^=#nav_]').on('click', function(event) {
			event.preventDefault();
			var href = $(this).attr('href');
			if($("div").is("#nav_comment")){
				offsetTop = href === "#nav_comment" ? 0 : $(href).offset().top;
			}else{
				offsetTop = href === "#nav_product" ? 0 : $(href).offset().top;
			}
			$('html, body').animate({
				scrollTop: offsetTop
			}, 300);
		});

		//Заполнение списка артикулов поставщиков
		$("#sup_art").keyup(function() {
			var inputvalue = $(this).val();
			dataListSupplier(inputvalue);
		});

		//Привязка поставщика к товару
		$('#add_sup_js').on('click', function(event) {
			event.preventDefault();
			var art = $('#sup_art').val().split('-'),
				inusd = $('#sup_inusd').val(),
				price_opt = $('#sup_price_opt').val(),
				price_mopt = $('#sup_price_mopt').val(),
				product_limit = $('#sup_product_limit').val();
			art = art[0];
			if(art != ''){
				if(price_opt != ''){
					if(price_mopt != ''){
						$.ajax({
							url: URL_base+'ajaxproducts',
							type: "POST",
							cache: false,
							dataType: "json",
							data: {
								"action":'add_supplier',
								"art": art
							}
						}).done(function(data){
							if(!data){
								alert('Такого поставщика не существует! Проверьте правильность введенного артикула!');
							}else{
								//Добавляем поставщика в таблицу 'Данные поставщика'
								var html_string = inusd_sel = not_inusd_sel = '';
								if(inusd == 1){
									inusd_sel = 'selected="selected"';
								}else{
									not_inusd_sel = 'selected="selected"';
								}
								if(data.real_phone == '380'){
									data.real_phone = 'не указан';
								}
								//Формируем html для вставки
								html_string = '<tr class="animate supp_js">';
								html_string += '<td class="center">'+art+'</td>';
								html_string += '<td class="supp_name_js">'+data.name+'</td>';
								html_string += '<td>'+data.real_phone+'</td>';
								html_string += '<td><div class="select_price fl"><label>Цена в:</label><select name="inusd[]" class="input-m"><option value="0" '+not_inusd_sel+'>ГРН</option><option value="1" '+inusd_sel+'>USD</option></select></div><div class="fl price"><label>Опт:</label><input type="number" name="price_opt_otpusk[]" min="0" step="0.01" class="input-m" value="'+price_opt+'"></div><div class="fr price"><label>Розница:</label><input type="number" name="price_mopt_otpusk[]" min="0" step="0.01" class="input-m" value="'+price_mopt+'"></div></td>';
								html_string += '<td><input type="number" name="product_limit[]" min="0" value="'+product_limit+'" class="input-m"></td>';
								html_string += '<td class="center"><input type="hidden" name="id_supplier[]" value="'+data.id_user+'"><span class="icon-font del_supp_js">t</span></td>';
								html_string += '</tr>';

								if($('.supplier tr').is('#empty2')){
									$('.supplier #empty2').remove();
								}
								$('.supplier tbody').append(html_string);

								//Очистка полей ввода
								$('.compulsory').removeClass('compulsory');
								$('.sup_notation').remove();
								$('#sup_art, #sup_price_opt, #sup_price_mopt').val('');
								$('#sup_inusd [value="0"]').attr('selected', 'selected');
								// $('#sup_inusd [value="'+inusd+'"]').attr('selected', 'selected');
								$('#sup_product_limit').val('1000000');
							}
						});
					}else{
						$('#sup_price_mopt').addClass('compulsory').parent().find('.sup_notation').remove();
						$('#sup_price_mopt').parent().append('<span class="sup_notation">Заполните поле</span>');
					}
				}else{
					$('#sup_price_opt').addClass('compulsory').parent().find('.sup_notation').remove();
					$('#sup_price_opt').parent().append('<span class="sup_notation">Заполните поле</span>');
				}
			}else{
				$('#sup_art').addClass('compulsory').parent().find('.sup_notation').remove();
				$('#sup_art').parent().append('<span class="sup_notation">Заполните поле</span>');
			}
		});

		//Отвязка постащика от товара
		$('body').on('click', '.del_supp_js',function() {
			var parent_path = $(this).closest('.supp_js'),
				supp_name = parent_path.find('.supp_name_js').text();
			if(confirm('Вы хотите отвязать поставщика \n\"'+supp_name+'\" от данного товара?')){
				if (parent_path.find('input').is('.id_assortiment')) {
					var id_assort = parent_path.find('.id_assortiment').val();
					$('#nav_connection').append('<input type="hidden" name="del_from_assort[]" value="'+id_assort+'">');
				};
				parent_path.remove();
			};
		});

		//Подгрузка доступных сегментаций
		var segment_info = '';
		$('#segment_type').on('change', function(){
			var type = $(this).val();
			if(type != ''){
				$.ajax({
					url: URL_base+'ajaxproducts',
					type: "POST",
					cache: false,
					dataType: "json",
					data: {
						"action":'get_segment_list',
						"type": type
					}
				}).done(function(data){
					var optionlist ='';
					segment_info = data;
					$.each(data, function(k, v){
						optionlist += '<option value="'+v['id']+'">'+v['name']+'</option>';
					});
					$('#segment_list').html(optionlist);
				});
			}else{
				$('#segment_list').html('<option></option>');
			}
		});

		//Добавление сегментаций
		$('.add_segment').on('click', function(event) {
			event.preventDefault();
			var segment = $('#segment_list').val();
			if(segment != ''){
				$.each(segment_info, function(k, v){
					if(v['id'] == segment){
						var html_string = '';
						if(v['use_date'] == 0){
							v['date'] = '';
							v['count_days'] = '';
						}
						html_string = '<tr class="animate segment_js">';
						html_string += '<td class="type_name">'+v['type_name']+'</td>';
						html_string += '<td class="name">'+v['name']+'</td>';
						html_string += '<td>'+v['date']+'</td>';
						html_string += '<td>'+v['count_days']+'</td>';
						html_string += '<td><input type="hidden" name="id_segment[]" value="'+v['id']+'"><span class="icon-font del_segment">t</span></td>';
						html_string += '</tr>';
						if($('.segmentations tr').is('.empty')){
							$('.segmentations .empty').remove();
						}
						$('#segment_list option[value="'+segment+'"]').remove();
						$('.segmentations tbody').append(html_string);
					}
				});
			}else{
				alert('Выберите сегмент для добавления!')
			}
		});

		//Отвязка сегментации от продукта
		$('body').on('click', '.del_segment',function() {
			var parent_path = $(this).closest('.segment_js'),
				type_name = parent_path.find('.type_name').text(),
				name = parent_path.find('.name').text();
			if(confirm('Вы хотите отвязать '+type_name+'\n\"'+name+'\" от данного товара?')){
				if (parent_path.find('input').is('.id_segment')) {
					var id_segment = parent_path.find('.id_segment').val();
					$('#nav_connection').append('<input type="hidden" name="del_segment_prod[]" value="'+id_segment+'">');
				};
				parent_path.remove();
			};
		});
	});

	//Присваиваем value для input[name="main_category"]
	function AddValueMainCategory(){
		var i = 0;
		$('input[name="main_category"]').each(function (index) {
			$(this).val(i++);
		});
	}

	//Скрываем информационное окно через 3сек
	if($("div").is(".notification")){
		setTimeout(function(){
			$("div.content > .notification").slideUp();
		},3000);
	}
	//Инициализация перехода по меню при скролле
	$('body').scrollspy({
		target: '.second_nav_menu'
	});

	//Текстовый редактор
	CKEDITOR.replace( 'descr', {
	    customConfig: 'custom/ckeditor_config.js'
	});
	CKEDITOR.replace( 'descr_xt_short', {
	    customConfig: 'custom/ckeditor_config.js'
	});
	CKEDITOR.replace( 'descr_xt_full', {
	    customConfig: 'custom/ckeditor_config.js'
	});

	function RemovedFile (path, removed_file){
		path.closest('.previews').append('<input type="hidden" name="removed_images[]" value="'+removed_file+'">');
		path.remove();
	}

	function insertValueLink(link) {
		var id_spec_prod = link.closest('tr').find('[name="id_spec_prod"]').val(),
			id_spec = link.closest('tr').find('[name="id_spec"]').val(),
			value = link.closest('tr').find('[name="value"]').val();
		$.ajax({
			url: URL_base+'ajaxproducts',
			type: "POST",
			cache: false,
			dataType : "json",
			data: {
				"action": 'specification_update',
				"id_spec_prod": id_spec_prod,
				"id_spec": id_spec,
				"value": value,
				"id_product": <?=isset($_POST['id_product'])?$_POST['id_product']:'null';?>
			}
		});
		// var href = link.attr('href');
		// href += link.closest('tr').find('[name="value"]').val();
		// window.location.replace(href);
	}
	function updateTranslit(){
		$.ajax({
			url: URL_base+'ajaxproducts',
			type: "POST",
			cache: false,
			dataType: "json",
			data: {
				"action":'update_translit',
				"id_product": <?=isset($_POST['id_product'])?$_POST['id_product']:'null';?>
			}
		}).done(function(data){
			$('#translit p').text(data);
			$('#updtrans').animate({  borderSpacing: 360 }, {
				step: function(now,fx) {
					$(this).css('-webkit-transform','rotate('+now+'deg)');
					$(this).css('-moz-transform','rotate('+now+'deg)');
					$(this).css('transform','rotate('+now+'deg)');
				},
				duration:'slow'
			},'linear');
		});
	}
	function insertSpecToProd(link) {
		var value = link.prev().val(),
			id_spec = link.prev().prev().val();
		$.ajax({
			url: URL_base+'ajaxproducts',
			type: "POST",
			cache: false,
			dataType : "json",
			data: {
				"action": 'specification_update',
				"id_spec_prod": null,
				"id_spec": id_spec,
				"value": value,
				"id_product": <?=isset($_POST['id_product'])?$_POST['id_product']:'null';?>
			}
		});
	}
	function dataList(article) {
		$.ajax({
			url: URL_base+'ajaxproducts',
			type: "POST",
			cache: false,
			dataType : "json",
			data: {
				"action": 'datalist',
				"article": article,
				"id_product": <?=isset($_POST['id_product'])?$_POST['id_product']:'null';?>
			}
		}).done(function(data){
			var optionlist = '';
			$.each(data, function(k, v){
				// if(v !=){
					optionlist += '<option>'+v['response']+' | '+v['id_product']+'</option>';
				// }
			});

			// $('#character option').remove();
			$('#character').html(optionlist);
		});
	}
	//Формирование Списка Поставщиков
	function dataListSupplier(article) {
		$.ajax({
			url: URL_base+'ajaxproducts',
			type: "POST",
			cache: false,
			dataType : "json",
			data: {
				"action": 'datalist_supplier',
				"article": article
			}
		}).done(function(data){
			var optionlist = '';
			$.each(data, function(k, v){
				// if(v !=){
					optionlist += '<option>'+v['response']+'</option>';
				// }
			});
			$('#data_sup_art').html(optionlist);
		});
	}
	function editRelatedProds(id, action) {
		$.ajax({
			url: URL_base+'ajaxproducts',
			type: "POST",
			cache: false,
			dataType : "json",
			data: {
				"action": action+'_related',
				"id_prod": <?=isset($_POST['id_product'])?$_POST['id_product']:'null';?>,
				"id_related_prod": id
			}
		}).done(function(){
			location.reload();
		});

	}
	//Удаление товара
	function DelProds(id, action) {
		url = '/adm/productdel/'+id;
		$(location).attr('href',url);
	}

	function insertValueImg1(filePath) {
		document.getElementById('img_1').value = filePath;
		var re = /(\/efiles\/)(.*?)/;
		filePath = filePath.replace(re, "$1_thumb/$2");
		document.getElementById('i1').src = filePath;
		return;
	}
	function insertValueImg2(filePath) {
		document.getElementById('img_2').value = filePath;
		var re = /(\/efiles\/)(.*?)/;
		filePath = filePath.replace(re, "$1_thumb/$2");
		document.getElementById('i2').src = filePath;
		return;
	}
	function insertValueImg3(filePath) {
		document.getElementById('img_3').value = filePath;
		var re = /(\/efiles\/)(.*?)/;
		filePath = filePath.replace(re, "$1_thumb/$2");
		document.getElementById('i3').src = filePath;
		return;
	}
	// function insertValueSertificate(filePath){
	// 	document.getElementById('sertificate').value = filePath;
	// }
	function AddCat(){
		$('#templates .catblock').clone().insertBefore('#addlink').removeClass('hidden');
		if($('.catblock:not(.hidden)').length > 1){
			$('.delcat').show();
		}else{
			$('.delcat').hide();
		}
		AddValueMainCategory();
	}

	$(window).scroll(function(){
		//Фиксация Заголовка продукта
		if($(this).scrollTop() >= 100){
			if(!$('.prod_head').hasClass('fixed_head')){
				var width = $('#productae').width();
				$('.prod_head').css("width", width).addClass('fixed_head');
				$('#second_navigation').css("margin-top", "50px");
			}
		}else{
			if($('.prod_head').hasClass('fixed_head')){
				$('.prod_head').removeClass('fixed_head');
				$('#second_navigation').css("margin-top", "0");
			}
		}

		/* Плавающий блок secons меню*/
		var params = $('#second_navigation ul');
		var start = 100;
		if($(this).scrollTop() >= start){
			params.css("top", $(this).scrollTop()-start);
		}else{
			params.css("top", '0');
		}
	});
</script>