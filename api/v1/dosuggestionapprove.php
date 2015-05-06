<?php

$stmt = $dbconnection->prepare('SELECT jams.status FROM themes JOIN jams ON themes.jamid = jams.id WHERE themes.id = ?;');
$stmt->execute(array($themeid));

$jamstatus = $stmt->rowCount() != 0 ? $stmt->fetchAll()[0]['status'] : JamStatus::Disabled;

if ($jamstatus != JamStatus::ReceivingSuggestions && $jamstatus != JamStatus::WaitingThemeApprovals) SendResponse(array('success' => false, 'message' => 'Jam is in an invalid state.'));
else
{
  $stmt = $dbconnection->prepare('UPDATE themes SET isapproved = ? WHERE id = ?;');
  $stmt->execute(array($isapproved ? 1 : 0, $themeid));

  SendResponse(array('success' => true));
}

?>
