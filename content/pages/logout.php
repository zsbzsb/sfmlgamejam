<?php

$session->Logout();

header('Location: '.$routes->generate('home'));

?>
