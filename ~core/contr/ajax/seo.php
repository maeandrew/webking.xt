<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
    if(isset($_POST['action'])){
        $SEO = new SEO();
        switch($_POST['action']){
            case "getWord":
                //Вернуть слова начинающиеся с приходящей строки
                $str = $_POST['str'];
                $words = $SEO->GerWord($str);
                foreach($words as $word) {
                    $txt .= "<li>" .$word. "</li>";
                }
                echo $txt;
                break;
            default:
                break;
        }
    }
    exit();
}