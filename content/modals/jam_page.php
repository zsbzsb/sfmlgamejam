<?php

require SCRIPTROOT.'jamstates.php';

$jam = $cache->get('jam_page_'.$id);
if ($jam == null)
{
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
    $cache->set('jam_page_'.$id, $jam, CACHE_TIME);
  }
}

$title = $jam['title'];

?>
