<div class="row">
  <h2 class="text-center"><?=$news['title']?></h2>
  <h4 class="text-center"><?=date($DATETIME_FORMAT, $news['date'])?></h4>
</div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <hr />
    <?php

      require SCRIPTROOT.'markdown.php';

      echo ParseMarkdown($news['content']);

    ?>
  </div>
</div>
