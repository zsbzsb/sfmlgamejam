<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/feedback.php';

$username = trim(RequirePostVariable('username'));
$password = trim(RequirePostVariable('password'));

if (strlen($username) > 20) Error('Username max length is 20 characters.');
else if (strlen($username) == 0) Error('Username can not be blank.');
else if (strlen($password) == 0) Error('Password can not be blank.');

if ($session->TryLogin($username, $password)) Success("/account");
else Error('Username or Password is incorrect.');

?>
