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
      
    ?>
    <a href="#">
      <div class="row">
        <h4 class="pull-left inline">Now Ready</h4>
        <h4 class="pull-right inline">8-15-13</h4>
      </div>
    </a>
    <div class="row">
      <blockquote>
        <p>This is a testing news feed. It should go and go and go and go until we never get back. Willi wonka has lots of candy like that.</p>
      </blockquote>
    </div>
  </div>

<!-- Upcoming Jams -->
  <div class="col-md-3 col-md-offset-2">
    <h3 id="jams">Upcoming Jams</h3>
    <?php
      $jams = $cache->get("home_jams");
      if ($jams == null)
      {
        $stmt = $dbconnection->prepare('SELECT id, title, jamstart FROM jams WHERE jamstart >= ? ORDER BY jamstart ASC;');
        $stmt->execute(array(time()));
        $rows = $stmt->fetchAll();
        foreach ($rows as $row)
        {
          $jams.= '
          <div class="row">
            <a href="/jams/viewjam/?id='.$row['id'].'">
              <h4 class="pull-left inline">'.$row['title'].'</h4>
              <h4 class="pull-right inline">'.date($DATETIME_FORMAT, $row['jamstart']).'</h4>
            </a>
          </div>';
        }
        if ($stmt->rowCount() == 0) $jams = '<h4 class="pull-left">Nothing was found :(</h4>';
        $cache->set('home_jams', $jams, 60 * 2);
      }
      echo $jams;
    ?>
  </div>
</div>
