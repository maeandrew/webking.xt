
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>Экспорт поставщиков</title>
	<style>
	body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,label,fieldset,img,input,textarea,p,blockquote,th,td { 
	margin:0; padding:0;border: 0;outline: 0;font-size: 100%;vertical-align: baseline}
:focus {outline:0}
html,body {height:100%}
body {font-family: "Trebuchet MS", Helvetica, sans-serif; font-size: 12px; color: #333;}


.logo{font-size: 28px; color: #00F; font-weight: bold;}

.undln{text-decoration:underline;}
.lb{border-left:1px dashed #000;padding-left:5px;}

.table_header{margin-left:3px;width:800px;}
.table_header .top td{padding:10px 0 15px 0;font-size:14px;}
.table_header .first_col{width: 150px;}
.table_header .second_col{width: 300px;}
.table_header .top span.invoice{margin-left:20px;font-size:18px;text-decoration:underline;}

.bl{border-left:1px solid #000;}
.br{border-right:1px solid #000;}
.bt{border-top:1px solid #000;}
.bb{border-bottom:1px solid #000 !important;}
.bn{border:none !important;}

.bnb{border-bottom:none !important;}

.blf{border-left:1px solid #FFF;}
.brf{border-right:1px solid #FFF;}
.bbf{border-bottom:1px solid #FFF;}

.table_main{margin:10px 0 0 1px;}
.table_main td{padding:1px 1px 0;font-size:12px; text-align:center; border-right:1px #000 solid;border-bottom:1px #000 solid;vertical-align: middle;}
.table_main td.name{padding:1px;font-size:12px; text-align:left; border-right:1px #000 solid;border-bottom:1px #000 solid;}
.table_main .hdr td{font-weight: bold;padding: 1px;}

.table_main .main td{height:50px;}
.table_main .main td.img{width:56px;}

.table_sum{margin:10px 0 0 1px;}
.table_sum td{padding:1px 1px 0;font-size:12px; text-align:center; vertical-align: middle;}
.table_sum td.name{padding:1px;font-size:12px; text-align:left;}


tr.min td{height: 1px; font-size: 1px;line-height: 1px;margin: 0px;padding: 0px;}

.adate{font-size: 11px;margin-left: 177px;}
.note_red{color:Red;font-size: 14px; font-weight:900;}
.note_grin{color:#00FF00;font-size: 18px; font-weight:900;}
	</style>
</head>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div><br>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><br><?}?>


<!--<a href="<?=$GLOBALS['URL_request']?>/export">Экспорт в excel</a>-->
                        <table border="0" cellpadding="0" cellspacing="0" style="width: 802px;" class="table_main">
                            <tr>

                                 <td><p><?=$header['id_clienta']?></p></a></p></td>
                                 <td><p><?=$header['name']?></p></a></p></td>
                                 <td><p><?=$header['mail']?></p></a></p></td>
                                 <td><p><?=$header['cont_person']?></p></a></p></td>
                                 <td><p><?=$header['telef']?></p></a></p></td>
                                 <td><p><?=$header['data_regist']?></p></a></p></td>
                                 <td><p><?=$header['filial']?></p></td>


                            </tr>

                            
                          <?foreach ($supplier as $i){?>
                            <tr>
                                 

                                 <td><p><?=$i['id_user']?></p></a></p></td>
                                 <td><p><?=$i['article']?></p></a></p></td>
                                 <td><p><?=$i['phones']?></p></a></p></td>
                                  <td><p><?=$i['place']?></p></a></p></td>                               
                                 <td><p><?=$i['name']?></p></a></p></td>
                                 <td><p><?=$i['email']?></p></a></p></td>
                                 <td><p>1</p></td>                                

                                 

                            </tr>
                          <?}?>

                        </table>

                       

