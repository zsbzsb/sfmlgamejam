<?php

require SCRIPTROOT.'jamstates.php';

$news = $cache->get('home_news');
if ($news == null)
{
  $stmt = $dbconnection->prepare('SELECT id, title, date, summary FROM news WHERE date <= ? ORDER BY date DESC LIMIT 3;');
  $stmt->execute(array(time()));
  $news = $stmt->fetchAll();

  $cache->set('home_news', $news, CACHE_TIME);
}


$jams = $cache->get('home_jams');
$jams = null;
if ($jams == null)
{
  $stmt = $dbconnection->prepare('SELECT * FROM jams WHERE (suggestionsbegin + suggestionslength + approvallength + themeannouncelength + jamlength) >= ? AND status != ? ORDER BY suggestionsbegin ASC;');
  $stmt->execute(array(time(), JamStatus::Disabled));
  $jams = $stmt->fetchAll();

  foreach ($jams as $key => $jam)
  {
    VerifyJamState($jams[$key]);
  }

  $cache->set('home_jams', $jams, CACHE_TIME);
}

?>
