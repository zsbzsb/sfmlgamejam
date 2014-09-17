<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';

$session->Logout();

header('Location: /home');

?>
