<div class="row">
  <div class="jumbotron">
    <h2 class="text-center">Hello and welcome to the SFML Game Jam website!</h2>
  </div>
</div>

<div class="row">

  <!-- News -->
  <div class="col-md-7">
    <h3 id="news">News</h3>
    <?php

      $news = $cache->get('home_news');
      if ($news == null)
      {
        $stmt = $dbconnection->prepare('SELECT id, title, date, summary FROM news WHERE date <= ? ORDER BY date DESC LIMIT 3;');
        $stmt->execute(array(time()));
        $rows = $stmt->fetchAll();
        foreach ($rows as $row)
        {
          $news.= '
            <a href="'.$routes->generate('news', array('id' => $row['id'])).'">
              <div class="row">
                <h4 class="pull-left inline">'.$row['title'].'</h4>
                <h4 class="pull-right inline">'.date($DATETIME_FORMAT, $row['date']).'</h4>
              </div>
            </a>
            <div class="row">
              <blockquote>
                <p>'.$row['summary'].'</p>
              </blockquote>
            </div>
            <hr />';
        }
        if ($stmt->rowCount() == 0) $news = '<h4 class="pull-left">Nothing was found :(</h4>';
        $cache->set('home_news', $news, CACHE_TIME);
      }
      echo $news;

    ?>
  </div>

  <!-- Upcoming Jams -->
  <div class="col-md-3 col-md-offset-2">
    <h3 id="jams">Upcoming Jams</h3>
    <?php

      $jams = $cache->get('home_jams');
      if ($jams == null)
      {
        $stmt = $dbconnection->prepare('SELECT id, title, jamstart FROM jams WHERE jamstart >= ? ORDER BY jamstart ASC;');
        $stmt->execute(array(time()));
        $rows = $stmt->fetchAll();
        foreach ($rows as $row)
        {
          $jams.= '
            <div class="row">
              <a href="'.$routes->generate('jams', array('id' => $row['id'])).'">
                <h4 class="pull-left inline">'.$row['title'].'</h4>
                <h4 class="pull-right inline">'.date($DATETIME_FORMAT, $row['jamstart']).'</h4>
              </a>
            </div>
            <hr />';
        }
        if ($stmt->rowCount() == 0) $jams = '<h4 class="pull-left">Nothing was found :(</h4>';
        $cache->set('home_jams', $jams, CACHE_TIME);
      }
      echo $jams;

    ?>
  </div>

</div>
