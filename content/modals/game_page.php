<?php

require 'jam.php';

$game = $cache->get('jam_'.$id.'_game_'.$gameid);
if ($game == null)
{
  $stmt = $dbconnection->prepare('SELECT games.*, users.username AS submitter FROM games INNER JOIN users ON users.id = games.submitterid WHERE games.id = ? AND games.jamid = ?;');
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

$ratingstate = RatingState::NotReady;

if ($jam['status'] == JamStatus::ReceivingGameSubmissions || $jam['status'] == JamStatus::Judging)
{
  $ratingstate = $session->IsLoggedIn() ? RatingState::Ready : RatingState::NeedLogin;
}
else if ($jam['status'] == JamStatus::Complete)
  $ratingstate = RatingState::Complete;

if ($ratingstate == RatingState::Ready)
{
  $stmt = $dbconnection->prepare('SELECT categoryid, value FROM ratings LEFT JOIN categories ON categories.id = ratings.categoryid WHERE categories.jamid = ? AND ratings.gameid = ? AND ratings.userid = ?;');
  $stmt->execute(array($id, $gameid, $session->GetUserID()));
  $ratings = $stmt->fetchAll();

  $categories = $jam['categories'];

  foreach ($categories as $catkey => $category)
  {
    foreach ($ratings as $rating)
    {
      if ($rating['categoryid'] == $category['id'])
      {
        $categories[$catkey]['rating'] = $rating['value'];
        break;
      }
    }
  }
}
else if ($ratingstate == RatingState::Complete)
{
  // TODO load final results
}

$title = $game['name'];

?>
