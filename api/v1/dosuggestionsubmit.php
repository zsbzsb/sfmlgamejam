<?php

$isupdate = isset($themeid);

$stmt = $dbconnection->prepare('SELECT themesperuser, status FROM jams WHERE id = ?;');
$stmt->execute(array($jamid));

if ($stmt->rowCount() == 0) SendResponse(array('success' => false, 'message' => 'Invalid jam specified.'));
else
{
  $jam = $stmt->fetchAll()[0];

  if ($jam['status'] == JamStatus::ReceivingSuggestions)
  {
    $stmt = $dbconnection->prepare('SELECT COUNT(*) from themes WHERE jamid = ? AND submitterid = ?;');
    $stmt->execute(array($jamid, $session->GetUserID()));
    $existingthemecount = $stmt->fetchAll()[0]['count'];

    if ($existingthemecount < $jam['themesperuser'] || $isupdate)
    {
      if (!$isupdate)
      {
        $stmt = $dbconnection->prepare('INSERT INTO themes (name, jamid, submitterid, isapproved, round) VALUES (?, ?, ?, ?, ?);');
        $stmt->execute(array($themename, $jamid, $session->GetUserID(), 0, CurrentRound::NotSelected));
      }
      else
      {
        $stmt = $dbconnection->prepare('UPDATE themes SET name = ?, isapproved = ? WHERE id = ? AND jamid = ? AND submitterid = ?;');
        $stmt->execute(array($themename, 0, $themeid, $jamid, $session->GetUserID()));
      }

      SendResponse(array('success' => true));
    }
    else SendResponse(array('success' => false, 'message' => 'You have already submitted the maximum number of themes.'));
  }
  else SendResponse(array('success' => false, 'message' => 'Jam is no longer recieving suggestions.'));
}

?>
