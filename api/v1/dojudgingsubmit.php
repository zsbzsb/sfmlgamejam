<?php

foreach ($ratings as $rating)
{
  if ($rating['value'] < 1 || $rating['value'] > 10)
  {
    $error = "Rating value is out of range.";
    break;
  }
}

if (isset($error))
{
  SendResponse(array('success' => false, 'message' => $error));
  die();
}

$stmt = $dbconnection->prepare('SELECT jams.status FROM jams INNER JOIN games ON jams.id = games.jamid WHERE jams.id = ? AND games.id = ?;');
$stmt->execute(array($jamid, $gameid));

if ($stmt->rowCount() == 0) SendResponse(array('success' => false, 'message' => 'Invalid jam or game specified.'));
else
{
  $status = $stmt->fetchAll()[0]['status'];

  if ($status == JamStatus::ReceivingGameSubmissions || $status == JamStatus::Judging)
  {
    $stmt = $dbconnection->prepare('SELECT id FROM categories WHERE jamid = ?;');
    $stmt->execute(array($jamid));
    $categories = $stmt->fetchAll();

    foreach ($categories as $category)
    {
      $stmt = $dbconnection->prepare('DELETE FROM ratings WHERE categoryid = ? AND gameid = ? AND userid = ?;');
      $stmt->execute(array($category['id'], $gameid, $session->GetUserID()));

      foreach ($ratings as $rating)
      {
        if ($rating['categoryid'] == $category['id'])
        {
          $stmt = $dbconnection->prepare('INSERT INTO ratings (categoryid, gameid, userid, value) VALUES (?, ?, ?, ?);');
          $stmt->execute(array($category['id'], $gameid, $session->GetUserID(), $rating['value']));
          break;
        }
      }
    }

    SendResponse(array('success' => true));
  }
  else SendResponse(array('success' => false, 'message' => 'Jam is no longer recieving ratings for the games.'));
}

?>
