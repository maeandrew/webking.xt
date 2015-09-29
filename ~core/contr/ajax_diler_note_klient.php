<?php

$id_order = $_POST['id_order'];
$note_diler = $_POST['note_diler'];

$order = new Orders();

$order->SetNote_diler($id_order, $note_diler);

?>