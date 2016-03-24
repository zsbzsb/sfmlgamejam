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
    <?php

      if ($ratingstate == RatingState::NotReady)
        echo '<h5 class="text-center">Judging will be available soon!</h5>';
      else if ($ratingstate == RatingState::NeedLogin)
        echo '<h5 class="text-center">You must be <a href="'.$routes->generate('login').'">logged in</a> to judge games.</h5>';
      else if ($ratingstate == RatingState::OwnGame)
        echo '<h5 class="text-center">Try voting on some other <a href="'.$routes->generate('games_list', array('id' => $id)).'">games</a> instead of your own ;)</h5>';
      else if ($ratingstate == RatingState::Ready)
      {
        require TEMPLATEROOT.'formfeedback.php';

        echo '
          <h4 class="text-center">Rate this game!</h4>
          <table class="table table-striped table-bordered">
            <col width="auto">
            <col width="20">
            <col width="20">
            <col width="20">
            <col width="20">
            <col width="20">
            <col width="20">
            <col width="20">
            <col width="20">
            <col width="20">
            <col width="20">
            <thead>
              <tr>
                <th>Judging Category</th>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
                <th>8</th>
                <th>9</th>
                <th>10</th>
              </tr>
            </thead>
            <tbody>';

        foreach ($categories as $category)
        {
          $group = 'rating'.$category['id'];
          $rating = isset($category['rating']) ? $category['rating'] : '-1';

          echo '<tr class="ratingrow" rating="'.$rating.'" categoryid="'.$category['id'].'"><td>'.$category['name'].'</td>';

          for ($i = 1; $i <= 10; $i++)
          {
            echo '<td><input type="radio" autocomplete="off" name="'.$group.'" class="rate'.$i.'" '.($rating == $i ? 'checked' : '').' /></td>';
          }

          echo '</tr>';
        }

        echo '
            </tbody>
          </table>
          <button type="submit" class="btn btn-success pull-right" id="ratingsubmit">Rate</button>';
      }
      else if ($ratingstate == RatingState::Complete)
        echo '<h5 class="text-center">Final results will be available soon!</h5>';

    ?>
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
JamID = <?=$id?>;
GameID = <?=$gameid?>;

$(function() {
  BindButtonClick($('.popupimage'), function(obj) {
    $('#bigpopupimage').attr('src', $(obj).attr('imagelink'));
    $('#bigpopuplink').attr('href', $(obj).attr('imagelink'));
    $('#imagemodal').modal('show');
  });

  BindButtonClick($('#ratingsubmit'), Submit);

  for (var i = 1; i <= 10; i++) {
    (function(i) {
      BindCheckboxChanged($('.rate' + i), function(obj) { ChangeRating(obj, i); });
    })(i)
  }
});

function ChangeRating(obj, Rating) {
  if ($(obj).is(':checked')) {
    $(obj).parents('.ratingrow').attr('rating', Rating);
  }
}

function Submit() {
  function EnableJudging(Enabled) {
    EnableButton($('#ratingsubmit'), Enabled);

    for (var i = 1; i <= 10; i++) {
      $('.rate' + i).attr('disabled', !Enabled);
    }
  };

  EnableJudging(false);

  var animation = DotAnimation($('#ratingsubmit'));
  var postdata = { jamid:JamID, gameid:GameID, ratings:{} };
  var count = 0;

  $('.ratingrow').each(function(Index, Row) {
    var categoryid = $(Row).attr('categoryid');
    var rating = $(Row).attr('rating');

    if (rating != -1) {
      postdata['ratings'][count++] = { categoryid:categoryid, value:rating };
    }
  });

  Post('/api/v1/games/judging/submit', postdata)
    .done(function(result) {
      if (result.success) {
        SuccessFeedback('Your rating(s) for this game have been saved.');
      }
      else {
        ErrorFeedback(result.message);
      }
    })
    .fail(function() {
      ErrorFeedback('An unexpected error happened, please try again.');
    })
    .always(function() {
      EnableJudging(true);

      StopAnimation(animation);
      $('#ratingsubmit').html('Rate');
    });
}
</script>
