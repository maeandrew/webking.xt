<!-- Bootstrap styles -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">

<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="/plugins/jquery.fileupload.css">
<link rel="stylesheet" href="/plugins/jquery.fileupload-ui.css">
		

<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>
<div id="newsae">
    <form action="<?=$GLOBALS['URL_request']?>" method="post">
		<?if(isset($_POST['id_news']) && $_POST['id_news']){?>
			<span class="fr"><a href="<?=$GLOBALS['URL_base']?>news/<?=isset($_POST['translit'])?$_POST['translit']:null?>">Посмотреть страницу</a></span>
		<?}?>
		<label for="title">Заголовок:</label><?=isset($errm['title'])?"<span class=\"errmsg\">".$errm['title']."</span><br>":null?>
		<input type="text" name="title" id="title" class="input-l" value="<?=isset($_POST['title'])?htmlspecialchars($_POST['title']):null?>"/>
        <div id="translit"><?=isset($_POST['translit'])?$_POST['translit']:null?></div>
        <div class="row seo_block">
			<div class="col-md-12">
				<label for="page_title">Мета-заголовок (title):</label>
				<?=isset($errm['page_title'])?"<span class=\"errmsg\">".$errm['page_title']."</span><br>":null?>
				<input type="text" name="page_title" id="page_title" class="input-l" value="<?=isset($_POST['page_title'])?htmlspecialchars($_POST['page_title']):null?>">
				<label for="page_description">Мета-описание (description):</label>
				<?=isset($errm['page_description'])?"<span class=\"errmsg\">".$errm['page_description']."</span><br>":null?>
				<textarea name="page_description" id="page_description" size="20" cols="223" rows="5" class="input-l"><?=isset($_POST['page_description'])?htmlspecialchars($_POST['page_description']):null?></textarea>
				<label for="keywords">Ключевые слова (keywords):</label>
				<?=isset($errm['page_keywords'])?"<span class=\"errmsg\">".$errm['page_keywords']."</span><br>":null?>
				<textarea class="input-l" name="page_keywords" id="keywords" cols="10" rows="5"><?=isset($_POST['page_keywords'])?htmlspecialchars($_POST['page_keywords']):null?></textarea>
			</div>
		</div>
        <label for="descr_short">Короткое описание:</label><?=isset($errm['descr_short'])?"<span class=\"errmsg\">".$errm['descr_short']."</span><br>":null?>
		<textarea name="descr_short" id="descr_short" class="input-l" rows="18" cols="195"><?=isset($_POST['descr_short'])?htmlspecialchars($_POST['descr_short']):null?></textarea>
		<p><b>Полное описание:</b></p><?=isset($errm['descr_full'])?"<span class=\"errmsg\"><br>".$errm['descr_full']."</span>":null?>
		<textarea name="descr_full" id="descr_full" rows="38" cols="200"><?=isset($_POST['descr_full'])?htmlspecialchars($_POST['descr_full']):null?></textarea>
		<!-- <div id="edit-container">
			<div id="editor" onkeyup="moreStuff();"><?=isset($_POST['descr_full'])?htmlspecialchars($_POST['descr_full']):null?></div>
		</div>
		<script>
			var editor = ace.edit("editor");
			editor.setTheme("ace/theme/dreamweaver");
			//editor.setTheme("ace/theme/clouds_midnight");
			editor.setFontSize(15);
			editor.getSession().setUseWrapMode(true);
			editor.getSession().setMode("ace/mode/html");
			function moreStuff(){
				document.getElementById('descr_full').value = editor.getValue();
			}
		</script> -->

		
		<div class="container">
			<!-- The file upload form used as target for the file upload widget -->
			<form id="fileupload" action="" method="POST" enctype="multipart/form-data">
				<input type="file" name="files[]" multiple>
				<!-- The fileupload-buttonbar contains buttons to add/delete files -->
				<div class="fileupload-buttonbar">
					<!-- The fileinput-button span is used to style the file input field as button -->
					<span class="btn btn-success fileinput-button">
						<i class="glyphicon glyphicon-plus"></i>
						<span>Загрузить изображение...</span>
						<!-- <input type="file" name="files[]" multiple> -->
					</span>
					<button type="button" class="btn btn-danger delete">
						<i class="glyphicon glyphicon-trash"></i>
						<span>Удалить</span>
					</button>
					<input type="checkbox" class="toggle">
					<!-- The global file processing state -->
					<span class="fileupload-process"></span>
				</div>
				<!-- The table listing the files available for upload/download -->
				<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
			</form>
		</div>
		<!-- The blueimp Gallery widget -->
		<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
			<div class="slides"></div>
			<h3 class="title"></h3>
			<a class="prev">‹</a>
			<a class="next">›</a>
			<a class="close">×</a>
			<a class="play-pause"></a>
			<ol class="indicator"></ol>
		</div>
		<!-- The template to display files available for upload -->
		<script id="template-upload" type="text/x-tmpl">
		{% for (var i=0, file; file=o.files[i]; i++) { %}
			<tr class="template-upload fade">
				<td>
					<span class="preview"></span>
				</td>
				<td>
					<p class="name">{%=file.name%}</p>
					<strong class="error text-danger"></strong>
				</td>

				<td>
					<p class="size">Processing...</p>
					<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
				</td>
			</tr>
		{% } %}
		</script>
		<!-- The template to display files available for download -->
		<script id="template-download" type="text/x-tmpl">
		{% for (var i=0, file; file=o.files[i]; i++) { %}
			<tr class="template-download fade">
				<td>
					<span class="preview">
						{% if (file.thumbnailUrl) { %}
							<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
						{% } %}
					</span>
				</td>
				<td>
					<p class="name">
						{% if (file.url) { %}
							<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
						{% } else { %}
							<span>{%=file.name%}</span>
						{% } %}
					</p>
					{% if (file.error) { %}
						<div><span class="label label-danger">Error</span> {%=file.error%}</div>
					{% } %}
				</td>
				<td>
					<p class="source">
						{% if (file.url) { %}
							<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.url%}</a>
						{% } else { %}
							<span>{%=file.name%}</span>
						{% } %}
					</p>		
				</td>
				<td>
					<span class="size">{%=o.formatFileSize(file.size)%}</span>
				</td>
				<td>
					{% if (file.deleteUrl) { %}
						<button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
							<i class="glyphicon glyphicon-trash"></i>
							<span>Удалить</span>
						</button>
						<input type="checkbox" name="delete" value="1" class="toggle">
					{% } else { %}
						<button class="btn btn-warning cancel">
							<i class="glyphicon glyphicon-ban-circle"></i>
							<span>Cancel</span>
						</button>
					{% } %}
				</td>
			</tr>
		{% } %}
		</script>

		




		<label for="date">Дата:</label><?=isset($errm['date'])?"<span class=\"errmsg\">".$errm['date']."</span><br>":null?>
		<input type="text" name="date" id="date" class="input-l wa" value="<?=(isset($_POST['date'])&&!isset($errm['date']))?date("d.m.Y", $_POST['date']):date("d.m.Y", time())?>"/>
		<div id="nav_visible">
			<h2 class="blue-line">Видимость и индексация</h2>
			<p><b>Скрыть новость &nbsp;</b><input class="vam" type="checkbox" name="visible" id="visible" <?=isset($_POST['visible'])&&(!$_POST['visible'])?'checked="checked" value="on"':null?>/></p>
			<label for="indexation"><b>Индексация &nbsp;</b>
				<input type="checkbox" name="indexation" id="indexation" class="input-m" <?=(isset($_POST['indexation']) && $_POST['indexation'] != 1) || !isset($_POST['indexation'])?null:'checked="checked" value="on"'?>>
			</label>
		</div>
		<p>
			<b>Разослать новость &nbsp;</b>
			<input class="vam" type="checkbox" value="1" name="news_distribution" id="news_distribution"/>
			<input class="vam input-l wa" type="text" name="limit_from" placeholder="с какого начать"/>
			<input class="vam input-l wa" type="text" name="limit_howmuch" placeholder="сколько выбрать"/>
		</p>
		<input type="hidden" name="id_news" id="id_news" value="<?=isset($_POST['id_news'])?$_POST['id_news']:0;?>">
		<input name="smb" type="submit" id="form_submit1" class="save-btn btn-l-default" value="Сохранить">
		<input name="test_distribution" type="submit" id="form_subm1it" class="btn-l-blue" value="Тестовая рассылка">
    </form>
</div>
<script>
	//Текстовый редактор
	CKEDITOR.replace( 'descr_short', {
	    customConfig: 'custom/ckeditor_config_img.js'
	});
	CKEDITOR.replace( 'descr_full', {
	    customConfig: 'custom/ckeditor_config_img.js'
	});
</script>

<script src="/js/jquery-2.1.4.min.js"></script>
<!-- // <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="/plugins/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- blueimp Gallery script -->
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The basic File Upload plugin -->
<script src="/plugins/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="/plugins/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="/plugins/jquery.fileupload-image.js"></script>
<!-- The File Upload user interface plugin -->
<script src="/plugins/jquery.fileupload-ui.js"></script>


<script src="/plugins/jquery.iframe-transport.js"></script>

<!-- The main application script -->
<script src="/plugins/mainUpload.js"></script>