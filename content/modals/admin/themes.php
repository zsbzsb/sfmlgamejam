<?php

require SCRIPTROOT.'jamstates.php';

$stmt = $dbconnection->prepare('SELECT * FROM jams WHERE id = ?;');
$stmt->execute(array($id));

if ($stmt->rowCount() == 0)
{
  header('Location: '.$routes->generate('admin'));
  die();
}
else
{
  $jam = $stmt->fetchAll()[0];
  VerifyJamState($jam);
}

$stmt = $dbconnection->prepare('SELECT themes.id, themes.name, themes.isapproved, users.username FROM themes JOIN users ON themes.submitterid = users.id WHERE jamid = ? ORDER BY themes.name;');
$stmt->execute(array($id));

$themes = $stmt->fetchAll();

$canedit = $jam['status'] == JamStatus::ReceivingSuggestions || $jam['status'] == JamStatus::WaitingThemeApprovals;

?>
