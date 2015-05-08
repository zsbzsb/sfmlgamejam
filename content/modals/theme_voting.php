<?php

require 'jam.php';

if (isset($round) && ($round > $jam['initialvotingrounds'] || $round < $jam['currentround']))
{
  header('location: '.$routes->generate('theme_voting', array('id' => $id)));
  die();
}

if (isset($round) && $session->IsLoggedIn() && $jam['status'] == JamStatus::ThemeVoting)
{
  $themes = $cache->get('themes_voting_vote'.$round);
  if ($themes == null)
  {
    $stmt = $dbconnection->prepare('SELECT id, name FROM themes WHERE jamid = ? AND round = ?;');
    $stmt->execute(array($id, $round));
    $themes = $stmt->fetchAll();

    $cache->set('themes_voting_vote'.$round, $themes, CACHE_TIME);
  }

  shuffle($themes);

  $stmt = $dbconnection->prepare('SELECT themeid, value FROM votes WHERE jamid = ? AND round = ? AND voterid = ?;');
  $stmt->execute(array($id, $round, $session->GetUserID()));
  $votes = $stmt->fetchAll();
}
else if (isset($round) && $jam['status'] >= JamStatus::ThemeVoting)
{
  // todo load results
}

$title = $jam['title'];

?>
