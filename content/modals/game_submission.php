<?php

require 'jam.php';

if ($jam['status'] == JamStatus::JamRunning || $jam['status'] == JamStatus::ReceivingGameSubmissions)
{
  $stmt = $dbconnection->prepare('SELECT * FROM games WHERE jamid = ? AND submitterid = ?;');
  $stmt->execute(array($id, $session->GetUserID()));

  if ($stmt->rowCount() > 0)
  {
    $game = $stmt->fetchAll()[0];

    $stmt = $dbconnection->prepare('SELECT url FROM images WHERE gameid = ?;');
    $stmt->execute(array($game['id']));

    $game['images'] = $stmt->fetchAll();

    $stmt = $dbconnection->prepare('SELECT title, url FROM links WHERE gameid = ?;');
    $stmt->execute(array($game['id']));

    $game['links'] = $stmt->fetchAll();
  }
}

?>
