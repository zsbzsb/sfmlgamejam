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

      foreach ($news as $article)
      {
        echo '
          <a href="'.$routes->generate('news_article', array('id' => $article['id'])).'">
            <div class="row">
              <h4 class="pull-left inline">'.$article['title'].'</h4>
              <h4 class="pull-right inline">'.date(DATETIME_FORMAT, $article['date']).'</h4>
            </div>
          </a>
          <div class="row">
            <blockquote>
              <p>'.$article['summary'].'</p>
            </blockquote>
          </div>
          <hr />';
      }

      if (count($news) == 0) echo '<h4 class="pull-left">Nothing was found :(</h4>';

    ?>
  </div>

  <!-- Upcoming Jams -->
  <div class="col-md-4 col-md-offset-1">
    <h3 id="jams">Upcoming Jams</h3>
    <?php

      foreach ($jams as $jam)
      {
        echo '
          <div class="row">
            <a href="'.$routes->generate('jam_page', array('id' => $jam['id'])).'">
              <h4 class="pull-left inline">'.$jam['title'].'</h4>
              <h4 class="pull-right inline">'.date(DATETIME_FORMAT, JamBegins($jam)).'</h4>
            </a>
          </div>
          <hr />';
      }

      if (count($jams) == 0) echo '<h4 class="pull-left">Nothing was found :(</h4>';

    ?>
  </div>
</div>
