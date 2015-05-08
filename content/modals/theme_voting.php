<?php

require 'jam.php';

if (isset($round) && ($round > $jam['initialvotingrounds'] || $round < $jam['currentround']))
{
  header('location: '.$routes->generate('theme_voting', array('id' => $id)));
  die();
}

if (isset($round) && $session->IsLoggedIn() && $round == $jam['currentround'] && $jam['status'] == JamStatus::ThemeVoting)
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
else if (isset($round) && (($round != $jam['currentround'] && $jam['status'] == JamStatus::ThemeVoting) ||  $jam['status'] > JamStatus::ThemeVoting))
{
  $themes = $cache->get('themes_voting_results'.$round);
  if ($themes == null)
  {
    $stmt = $dbconnection->prepare('SELECT themes.name AS themename, votes.value, votes.themeid FROM votes JOIN themes ON themes.id = votes.themeid WHERE votes.jamid = ? AND votes.round = ?;');
    $stmt->execute(array($id, $round));
    $votes = $stmt->fetchAll();
    $themes = array();
    $count = 0;

    foreach ($votes as $vote)
    {
      $theme = null;
      $index = -1;
      for ($i = 0; $i < count($themes); $i++)
      {
        if ($themes[$i]['id'] == $vote['themeid'])
        {
          $theme = $themes[$i];
          $index = $i;
          break;
        }
      }

      if ($theme == null) $theme = array('id' => $vote['themeid'], 'name' => $vote['themename'], 'totalvotes' => 0, 'finalscore' => 0, 'downvotes' => 0, 'upvotes' => 0);

      $theme['totalvotes'] += 1;
      $theme['finalscore'] += $vote['value'];
      if ($vote['value'] < 0) $theme['downvotes'] += 1;
      else if ($vote['value'] > 0) $theme['upvotes'] += 1;

      if ($index != -1) $themes[$index] = $theme;
      else $themes[$count++] = $theme;
    }

    unset($votes);

    usort($themes, 'OrderThemes');

    $rank = 0;
    $tie = 0;
    for ($i = 0; $i < count($themes); $i++)
    {
      if (!isset($score) || $score > $themes[$i]['finalscore'])
      {
        $score = $themes[$i]['finalscore'];
        $rank += $tie + 1;
        $tie = 0;
      }
      else $tie++;

      $themes[$i]['rank'] = $rank;
    }

    $cache->set('themes_voting_results'.$round, $themes, 0);
  }
}

$title = $jam['title'];

$rounddescription = isset($round) ? $round != CurrentRound::FinalRound ? 'Round '.($jam['initialvotingrounds'] + 1 - $round) : 'the Final Round' : '';

function OrderThemes($A, $B)
{
  if ($A['finalscore'] == $B['finalscore']) return 0;
  else return abs($A['finalscore']) < abs($B['finalscore']) ? -1 : 1;
}

?>
