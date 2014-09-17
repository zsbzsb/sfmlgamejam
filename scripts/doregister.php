<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';

function Error($ErrorMessage)
{
  echo '{ "success": false, "error": "'.$ErrorMessage.'" }';
  exit();
}

function RequirePostVariable($Variable)
{
  if (!isset($_POST[$Variable])) Error($Variable." is not set.");
  else return $_POST[$Variable];
}

$username = trim(RequirePostVariable('username'));
$password = trim(RequirePostVariable('password'));
$email = trim(RequirePostVariable('email'));

if (strlen($username) > 20) Error('Username max length is 20 characters.');
else if (strlen($username) == 0) Error('Username can not be blank.');
else if (strlen($password) == 0) Error('Password can not be blank.');
else if (strlen($email) == 0) Error('Email can not be blank.');

if ($session->TryRegister($username, $password, $email))
{
  echo '{ "success": true, "error": "", "url": "/register/thanks/" }';
  exit();
}
else Error('Username or Email is already in use.');

?>