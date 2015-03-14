<?php

require SCRIPTROOT.'markdown.php';

$showfeed = !isset($id);

if (!$showfeed)
{
  $stmt = $dbconnection->prepare('SELECT * FROM news WHERE id = ? AND date <= ?;');
  $stmt->execute(array($id, time()));
  $rows = $stmt->fetchAll();
  if ($stmt->rowCount() == 0)
  {
    header('Location: '.$routes->generate('news'));
    die();
  }
  $news = $rows[0];
}

?>

<div class="row">
  <h2 class="text-center"><?php echo $showfeed ? 'News Feed' : $news['title']; ?></h2>
  <?php if (!$showfeed) echo '<h4 class="text-center">'.date($DATETIME_FORMAT, $news['date']).'</h4>'; ?>
</div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <?php

      if (!$showfeed) echo '<hr />'.ParseMarkdown($news['content']);
      else
      {
        $stmt = $dbconnection->prepare('SELECT id, title, date, summary FROM news WHERE date <= ? ORDER BY date;');
        $stmt->execute(array(time()));
        $rows = $stmt->fetchAll();
        foreach ($rows as $row)
        {
          echo '
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
      }

    ?>
  </div>
</div>
