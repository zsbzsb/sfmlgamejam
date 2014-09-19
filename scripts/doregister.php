<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/feedback.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/validation.php';

$username = htmlspecialchars(trim(RequirePostVariable('username')));
$password = htmlspecialchars(trim(RequirePostVariable('password')));
$email = htmlspecialchars(trim(RequirePostVariable('email')));

if (strlen($username) > 20) Error('Username max length is 20 characters.');
else if (strlen($username) == 0) Error('Username can not be blank.');
else if (strlen($password) == 0) Error('Password can not be blank.');
else if (strlen($email) == 0) Error('Email can not be blank.');
else if (!EmailValid($email)) Error('Email address is invalid.');

if ($session->TryRegister($username, $password, $email)) Success('/register/thanks');
else Error('Username or Email is already in use.');

?>
