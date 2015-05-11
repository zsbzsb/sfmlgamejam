<?php

if (strlen($name) == 0) $error = 'Name can not be blank';

if (isset($error)) SendResponse(array('success' => false, 'message' => $error));
else
{
  $stmt = $dbconnection->prepare('UPDATE themes SET name = ? WHERE id = ?;');
  $stmt->execute(array($name, $id));

  SendResponse(array('success' => true));
}

?>
