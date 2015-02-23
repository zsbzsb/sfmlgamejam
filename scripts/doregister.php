<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/session/loginsession.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/scripts/feedback.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/scripts/validation.php';

$username = RequirePostVariable('username');
$password = RequirePostVariable('password');
$email = RequirePostVariable('email');

if (strlen($username) > 20) Error('Username max length is 20 characters.');
else if (strlen($username) == 0) Error('Username can not be blank.');
else if (strlen($password) == 0) Error('Password can not be blank.');
else if (strlen($email) == 0) Error('Email can not be blank.');
else if (!EmailValid($email)) Error('Email address is invalid.');

if ($session->TryRegister($username, $password, $email)) Success('/register/thanks');
else Error('Username or Email is already in use.');

?>
