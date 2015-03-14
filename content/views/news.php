<div class="row">
  <h2 class="text-center">News Feed</h2>
</div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <?php

      foreach ($news as $article)
      {
        echo '
          <a href="'.$routes->generate('news_article', array('id' => $article['id'])).'">
            <div class="row">
              <h4 class="pull-left inline">'.$article['title'].'</h4>
              <h4 class="pull-right inline">'.date($DATETIME_FORMAT, $article['date']).'</h4>
            </div>
          </a>
          <div class="row">
            <blockquote>
              <p>'.$article['summary'].'</p>
            </blockquote>
          </div>
          <hr />';
      }

      if (count($news) == 0) echo '<h4 class="text-center">Nothing was found :(</h4>';

    ?>
  </div>
</div>
