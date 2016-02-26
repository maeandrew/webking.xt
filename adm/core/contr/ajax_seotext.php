<?if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$Seo = new SEO();
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case "get_word":
				//Вернуть слова начинающиеся с приходящей строки
				$str = $_POST['str'];
				$words = $Seo->GerWord($str);
				foreach($words as $word) {
					$txt .= "<li>" .$word. "</li>";
				}
				echo $txt;
			break;
			default:
			break;
		}
		exit();
	}
}

?>