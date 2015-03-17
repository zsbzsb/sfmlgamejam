<?php

$createjam = !isset($id);

if (!$createjam)
{
  $stmt = $dbconnection->prepare('SELECT * FROM jams WHERE id = ?;');
  $stmt->execute(array($id));
  $jams = $stmt->fetchAll();
  if (count($jams) == 0)
  {
    header('Location: '.$routes->generate('admin'));
    die();
  }

  $jam = $jams[0];
}

?>
