<?php

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
  $stmt = $dbconnection->prepare('SELECT id, title, jamstart FROM jams WHERE jamstart >= ? ORDER BY jamstart ASC;');
  $stmt->execute(array(time()));
  $jams = $stmt->fetchAll();

  $cache->set('home_jams', $jams, CACHE_TIME);
}

?>
