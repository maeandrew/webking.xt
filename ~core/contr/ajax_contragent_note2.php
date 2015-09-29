<?php
$id_order = $_POST['id_order'];
$note2 = $_POST['note2'];
$order = new Orders();
$order->SetNote2($id_order, $note2);
?>