<?php

$stmt = $dbconnection->prepare('SELECT * FROM themes WHERE id = ? AND jamid = ?;');
$stmt->execute(array($themeid, $id));
$themes = $stmt->fetchAll();
if (count($themes) == 0)
{
  header('Location: '.$routes->generate('admin'));
  die();
}

$theme = $themes[0];

?>
