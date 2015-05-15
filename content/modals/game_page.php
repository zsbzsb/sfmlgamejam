<?php

require 'jam.php';

$game = $cache->get('jam_'.$id.'_game_'.$gameid);
if ($game == null)
{
  $stmt = $dbconnection->prepare('SELECT games.*, users.username AS submitter FROM games JOIN users ON users.id = games.submitterid WHERE games.id = ? AND games.jamid = ?;');
  $stmt->execute(array($gameid, $id));

  if ($stmt->rowCount() == 0)
  {
    header('Location: '.$routes->generate('games_list', array('id' => $id)));
    die();
  }
  else
  {
    $game = $stmt->fetchAll()[0];

    $stmt = $dbconnection->prepare('SELECT url FROM images WHERE gameid = ?;');
    $stmt->execute(array($game['id']));

    $game['images'] = $stmt->fetchAll();

    $stmt = $dbconnection->prepare('SELECT title, url FROM links WHERE gameid = ?;');
    $stmt->execute(array($game['id']));

    $game['links'] = $stmt->fetchAll();

    $cache->set('jam_'.$id.'_game_'.$gameid, $game, CACHE_TIME);
  }
}

$title = $game['name'];

?>
