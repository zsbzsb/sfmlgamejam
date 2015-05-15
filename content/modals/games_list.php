<?php

require 'jam.php';

$games = $cache->get('games_list_jam'.$id);
if ($games == null)
{
  $stmt = $dbconnection->prepare('SELECT id, name, thumbnailurl FROM games WHERE jamid = ?;');
  $stmt->execute(array($id));
  $games = $stmt->fetchAll();

  $cache->set('games_list_jam'.$id, $games, CACHE_TIME);
}

$title = $jam['title'];

?>
