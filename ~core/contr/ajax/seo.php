<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
    if(isset($_POST['action'])){
        $SEO = new SEO();
        switch($_POST['action']){
            case "getWord":
                //Вернуть слова начинающиеся с приходящей строки
                $words = $SEO->GerWord($_POST['str']);
                if($words){
                    foreach($words as $word) {
                        $txt .= "<li>" .$word. "</li>";
                    }
                    echo $txt;
                }else{
                    echo 'no matches found';
                }
                break;
            default:
                break;
        }
    }
    exit();
}