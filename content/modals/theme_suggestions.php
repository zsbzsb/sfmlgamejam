<?php

require 'jam.php';

if ($session->IsLoggedIn())
{
  $stmt = $dbconnection->prepare('SELECT id, name FROM themes WHERE jamid = ? AND submitterid = ?;');
  $stmt->execute(array($jam['id'], $session->GetUserID()));

  $themes = $stmt->fetchAll();
}

$title = $jam['title'];

?>
