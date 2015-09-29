<?php

$id_order = $_POST['id_order'];
$note = $_POST['note'];

$order = new Orders();

$order->SetNote($id_order, $note);
