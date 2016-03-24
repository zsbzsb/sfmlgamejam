<?php

$createjam = !isset($id);

if (!$createjam)
{
  $stmt = $dbconnection->prepare('SELECT * FROM jams WHERE id = ?;');
  $stmt->execute(array($id));

  if ($stmt->rowCount() == 0)
  {
    header('Location: '.$routes->generate('admin'));
    die();
  }

  $jam = $stmt->fetchAll()[0];

  $stmt = $dbconnection->prepare('SELECT id, name, description FROM categories WHERE jamid = ?;');
  $stmt->execute(array($jam['id']));

  $jam['categories'] = $stmt->fetchAll();
}

?>
