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
  $themes = $cache->get('themes_voting_results'.$round);
  if ($themes == null)
  {
    $stmt = $dbconnection->prepare('SELECT id, name FROM themes WHERE jamid = ? AND round = ?;');
    $stmt->execute(array($id, $round));
    $themes = $stmt->fetchAll();

    foreach ($themes as &$theme)
    {
      $stmt = $dbconnection->prepare('SELECT value FROM votes WHERE themeid = ? AND round = ?;');
      $stmt->execute(array($theme['id'], $round));
      $votes = $stmt->fetchAll();

      $theme['totalvotes'] = count($votes);
      $theme['finalscore'] = 0;
      $theme['downvotes'] = 0;
      $theme['upvotes'] = 0;

      foreach ($votes as $vote)
      {
        $value = $vote['value'];

        $theme['finalscore'] += $value;
        if ($value < 0) $theme['downvotes'] += 1;
        else if ($value > 0) $theme['upvotes'] += 1;
      }

      unset($votes);
    }

    usort($themes, 'OrderThemes');

    $cache->set('themes_voting_results'.$round, $themes, 0);
  }
}

$title = $jam['title'];

$rounddescription = isset($round) ? $round != 0 ? 'Round '.($jam['initialvotingrounds'] + 1 - $round) : 'the Final Round' : '';

function OrderThemes($A, $B)
{
  if ($A['finalscore'] == $B['finalscore']) return 0;
  else return abs($A['finalscore']) < abs($B['finalscore']) ? 1 : -1;
}

?>
