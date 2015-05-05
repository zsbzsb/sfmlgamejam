<?php

require SCRIPTROOT.'jamstates.php';

$jam = $cache->get('jam_'.$id);
if ($jam == null)
{
  $stmt = $dbconnection->prepare('SELECT * FROM jams WHERE id = ?;');
  $stmt->execute(array($id));

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
