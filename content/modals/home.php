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
if ($jams == null)
{
  $stmt = $dbconnection->prepare('SELECT * FROM jams WHERE suggestionsbegin >= ? AND status != ? ORDER BY suggestionsbegin ASC;');
  $stmt->execute(array(time(), JamStatus::Disabled));
  $jams = $stmt->fetchAll();

  foreach ($jams as &$jam)
  {
    VerifyJamState($jam);
  }

  $cache->set('home_jams', $jams, CACHE_TIME);
}

?>
