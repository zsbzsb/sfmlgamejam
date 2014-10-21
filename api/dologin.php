<?php

if ($session->TryLogin($username, $password)) SendResponse(array('success' => true));
else SendResponse(array('success' => false, 'message' => 'Username or Password was incorrect.'));

?>
