<?php

$id_order = $_POST['id_order'];
$note_customer = $_POST['note_customer'];

$order = new Orders();

$order->SetNote_customer($id_order, $note_customer);

?>