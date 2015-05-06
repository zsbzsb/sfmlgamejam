<?php

$news = $cache->get('news_feed_news');
if ($news == null)
{
  $stmt = $dbconnection->prepare('SELECT id, title, date, summary FROM news WHERE date <= ? ORDER BY date DESC;');
  $stmt->execute(array(time()));
  $news = $stmt->fetchAll();

  $cache->set('news_feed_news', $news, CACHE_TIME);
}


?>