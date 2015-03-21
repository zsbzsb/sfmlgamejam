<?php

$news = $cache->get('news_article_'.$id);
if ($news == null)
{
  $stmt = $dbconnection->prepare('SELECT id, title, date, content FROM news WHERE id = ? AND date <= ? ORDER BY date;');
  $stmt->execute(array($id, time()));

  if ($stmt->rowCount() == 0)
  {
    header('Location: '.$routes->generate('news'));
    die();
  }
  else
  {
    $news = $stmt->fetchAll()[0];
    $cache->set('news_article_'.$id, $news, CACHE_TIME);
  }
}


?>