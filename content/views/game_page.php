<?php require TEMPLATEROOT.'jam_header.php'; ?>

<img class="gamelogo" alt="<?=$game['name']?>" src="<?=$game['thumbnailurl']?>" />
<h2 class="text-center aftertag" aftertag="the game"><?=$game['name']?></h2>
<h3 class="text-center">Created by <?=$game['submitter'].(strlen($game['partner']) > 0 ? ' and '.$game['partner'] : '')?></h3>

<br>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <?php

      foreach ($game['images'] as $image)
      {
        echo '
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
            <a class="thumbnail popupimage" href="#" imagelink="'.$image['url'].'">
              <div class="gamebox">
                <img alt="" src="'.$image['url'].'" />
              </div>
            </a>
          </div>';
      }

    ?>
  </div>
</div>

<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <ol class="breadcrumb text-center">
      <?php

        foreach ($game['links'] as $link)
        {
          echo '<li><a href="'.$link['url'].'" target="_blank">'.$link['title'].'</a></li>';
        }

      ?>
    </ol>
    <br>
    <?php

      require SCRIPTROOT.'markdown.php';

      echo ParseMarkdown($game['description']);

    ?>
    <br>
    <hr/>
    <h5 class="text-center">Comments and Judging coming soon!</h5>
  </div>
</div>

<div class="modal" id="imagemodal" role="dialog" aria-hidden="true" aria-labelledby="imagemodal-title">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="imagemodal-title">View Screenshot</h4>
      </div>
      <div class="modal-body">
        <a id="bigpopuplink" href="#" target="_blank"><img id="bigpopupimage" alt="" src="" /></a>
      </div>
    </div>
  </div>
</div>

<script>
$(function() {
  BindButtonClick($('.popupimage'), function(obj) {
    $('#bigpopupimage').attr('src', $(obj).attr('imagelink'));
    $('#bigpopuplink').attr('href', $(obj).attr('imagelink'));
    $('#imagemodal').modal('show');
  });
});
</script>
