<?php

if (strlen($name) == 0) $error = 'Name can not be blank.';
else if (strlen($description) == 0) $error = 'Description can not be blank.';
else if (strlen($thumbnail) == 0 || !URLValid($thumbnail)) $error = 'Thumbnail is not a valid link.';
else if (count($images) > 10) $error = 'Max images is 10.';
else if (count($links) > 10) $error = 'Max links is 10.';

if (!isset($error))
{
  foreach ($images as $image)
  {
    if (!URLValid($image['url']))
    {
      $error = '"'.$image['url'].'" is not a valid link.';
      break;
    }
  }
}

if (!isset($error))
{
  foreach ($links as $link)
  {
    if (strlen($link['title']) == 0)
    {
      '"'.$link['url'].'" title can not be blank';
      break;
    }
    else if (!URLValid($link['url']))
    {
      $error = '"'.$link['url'].'" is not a valid link.';
      break;
    }
  }
}

if (isset($error))
{
  SendResponse(array('success' => false, 'message' => $error));
  die();
}

$stmt = $dbconnection->prepare('SELECT themesperuser, status FROM jams WHERE id = ?;');
$stmt->execute(array($jamid));

if ($stmt->rowCount() == 0) SendResponse(array('success' => false, 'message' => 'Invalid jam specified.'));
else
{
  $jam = $stmt->fetchAll()[0];

  if ($jam['status'] == JamStatus::JamRunning || $jam['status'] == JamStatus::ReceivingGameSubmissions)
  {
    $stmt = $dbconnection->prepare('SELECT id from games WHERE jamid = ? AND submitterid = ?;');
    $stmt->execute(array($jamid, $session->GetUserID()));

    if ($stmt->rowCount() > 0)
    {
      $gameid = $stmt->fetchAll()[0]['id'];

      $stmt = $dbconnection->prepare('UPDATE games SET name = ?, description = ?, partner = ?, thumbnailurl = ? WHERE id = ? AND jamid = ? AND submitterid = ?;');
      $stmt->execute(array($name, $description, $partner, $thumbnail, $gameid, $jamid, $session->GetUserID()));

      $stmt = $dbconnection->prepare('DELETE FROM images WHERE gameid = ?;');
      $stmt->execute(array($gameid));

      $stmt = $dbconnection->prepare('DELETE FROM links WHERE gameid = ?;');
      $stmt->execute(array($gameid));
    }
    else
    {
      $stmt = $dbconnection->prepare('INSERT INTO games (name, description, submitterid, partner, thumbnailurl, jamid) VALUES (?, ?, ?, ?, ?, ?);');
      $stmt->execute(array($name, $description, $session->GetUserID(), $partner, $thumbnail, $jamid));

      $gameid = $dbconnection->lastInsertId('games_id_seq');
    }

    foreach ($images as $image)
    {
      $stmt = $dbconnection->prepare('INSERT INTO images (url, gameid) VALUES (?, ?);');
      $stmt->execute(array($image['url'], $gameid));
    }

    foreach ($links as $link)
    {
      $stmt = $dbconnection->prepare('INSERT INTO links (title, url, gameid) VALUES (?, ?, ?);');
      $stmt->execute(array($link['title'], $link['url'], $gameid));
    }

    SendResponse(array('success' => true));
  }
  else SendResponse(array('success' => false, 'message' => 'Jam is no longer recieving game submissions.'));
}



?>
