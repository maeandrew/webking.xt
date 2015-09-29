<?php
unset($parsed_res);
$Mailer = new Mailer();
$Mailer->SendConsulRequest($_POST);
header('Location: /');
?>