<?php

$news = $cache->get('news_news');
if ($news == null)
{
  $stmt = $dbconnection->prepare('SELECT id, title, date, summary FROM news WHERE date <= ? ORDER BY date;');
  $stmt->execute(array(time()));
  $news = $stmt->fetchAll();

  $cache->set('news_news', $news, CACHE_TIME);
}


?>