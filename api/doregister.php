<?php

if (strlen($username) > 20) $error = 'Username max length is 20 characters.';
else if (strlen($username) == 0) $error = 'Username can not be blank.';
else if (strlen($password) == 0) $error = 'Password can not be blank.';
else if (strlen($email) == 0) $error = 'Email can not be blank.';
else if (!EmailValid($email)) $error = 'Email address is invalid.';

if (isset($error)) SendResponse(array('success' => false, 'message' => $error));
else if ($session->TryRegister($username, $password, $email)) SendResponse(array('success' => true));
else SendResponse(array('success' => false, 'message' => 'Username or Email is already in use.'));

?>
