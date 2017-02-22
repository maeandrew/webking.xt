
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<a href="#" class="test_button balance">Проверить баланс</a>
<a href="#" class="test_button rest_fiz">Выписки</a>
 
<?
 
$pass="tct38dkXWTM0TaxCwIHKftp7paq56jA7";
 
$card = '4149497829562356';
 
 
$data  = '<oper>cmt</oper>';
$data .= '<wait>0</wait>';
$data .= '<test>0</test>';
$data .= '<payment id="">';
$data .= '<prop name="sd" value="16.01.2017" />';
$data .= '<prop name="ed" value="16.01.2017" />';
$data .= '<prop name="card" value="'.$card.'" />';
$data .= '</payment>';
$sign =sha1(md5($data.$pass));
 
 
?>
 
<div id="result"></div>
 
 
<script>
    $(function(){
        $('.test_button.balance').on('click', function(){
            checkBalance();
        });
        $('.test_button.rest_fiz').on('click', function(){
            checkRest();
        });
    });
    function checkBalance(){
        var xml = ''+'<\?xml version="1.0" encoding="UTF-8"\?>'+'<request version="1.0">'+
              '<merchant>'+
                '<id>125401</id>'+
                '<signature>'+'<?=$sign?>'+'</signature>'+
             '</merchant>'+
              '<data>'+'<?=$data?>'+
              '</data>'+
            '</request>';
        var link = 'https://api.privatbank.ua/p24api/balance';
        sendRequest(xml, link);
    }
    function checkRest(){
        var xml = ''+'<\?xml version="1.0" encoding="UTF-8"\?>'+
            '<request version="1.0">'+
                '<merchant>'+
                    '<id>125401</id>'+
                    '<signature><?=$sign?></signature>'+
                '</merchant>'+
                '<data><?=$data?></data>'+
            '</request>';
        var link = 'https://api.privatbank.ua/p24api/rest_fiz';
        sendRequest(xml, link);
    }
    function sendRequest(xml, link){
        var request = new XMLHttpRequest();
        request.open("POST", link, false);
        request.send(xml);
        document.getElementById('result').innerHTML = request.responseText;
    }
</script>
<?php die(); ?>