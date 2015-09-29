<?php
       
$id_order = $_POST['id_order'];
$note_klient = $_POST['note_klient'];



$order = new Orders();


$order->SetNote_klient($id_order, $note_klient);

?>