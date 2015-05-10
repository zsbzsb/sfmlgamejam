<?php

require SCRIPTROOT.'jamstates.php';

$jam = $cache->get('jam_'.$id);
if ($jam == null)
{
  $stmt = $dbconnection->prepare('SELECT jams.*, themes.name AS selectedtheme FROM jams LEFT JOIN themes ON themes.id = jams.selectedthemeid WHERE jams.id = ? AND jams.status != ?;');
  $stmt->execute(array($id, JamStatus::Disabled));

  if ($stmt->rowCount() == 0)
  {
    header('Location: '.$routes->generate('jams'));
    die();
  }
  else
  {
    $jam = $stmt->fetchAll()[0];
    VerifyJamState($jam);
    $cache->set('jam_'.$id, $jam, CACHE_TIME);
  }
}

?>
