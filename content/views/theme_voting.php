<?php require TEMPLATEROOT.'jam_header.php'; ?>

<h3 class="text-center">Theme Voting</h3>
<br>

<?php

if ($jam['status'] >= JamStatus::ThemeVoting)
{
  echo '
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <ol class="breadcrumb text-center">';

  for ($i = 0; $i <= $jam['initialvotingrounds']; $i++)
  {
    $text = $i != $jam['initialvotingrounds'] ? 'Round '.($i + 1) : 'Final Round';
    if ($jam['currentround'] <= $jam['initialvotingrounds'] - $i) echo '<li><a href="'.$routes->generate('theme_voting', array('id' => $id, 'round' => $jam['initialvotingrounds'] - $i)).'">'.$text.'</a></li>';
    else echo '<li>'.$text.'</li>';
  }

  echo '
        </ol>
      </div>
    </div>';
}

?>

<div class="row">
  <div class="col-md-6 col-md-offset-3">

<?php

if ($jam['status'] < JamStatus::ThemeVoting)
{
  echo '<h4 class="text-center">Voting is currently closed</h4>';
}
else if (!isset($round))
{
  echo '<h4 class="text-center">Select a round to vote or view the results</h4>';
}
else if ($round != $jam['currentround'] || $jam['status'] != JamStatus::ThemeVoting)
{
  echo '
    <h4 class="text-center">Results for '.$rounddescription.'</h4>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th></th>
          <th>Theme</th>
          <th>Score</th>
          <th>-1</th>
          <th>1+</th>
          <th>Votes</th>
        </tr>
      </thead>
      <tbody>';

  foreach ($themes as $theme)
  {
    echo '
      <tr>
        <td>'.$theme['rank'].'</td>
        <td>'.$theme['name'].'</td>
        <td>'.$theme['finalscore'].'</td>
        <td>'.$theme['downvotes'].'</td>
        <td>'.$theme['upvotes'].'</td>
        <td>'.$theme['totalvotes'].'</td>
      </tr>';
    }

  echo '
      </tbody>
    </table>';
}
else if (!$session->IsLoggedIn())
{
  echo '<h4 class="text-center">You must be <a href="'.$routes->generate('login').'">logged in</a> to vote</h4>';
}
else
{
  require TEMPLATEROOT.'formfeedback.php';

  echo '
    <table class="table table-striped table-bordered">
    <h4 class="text-center" id="totalvotesdisplay"></h4>
      <col width="20">
      <col width="20">
      <col width="20">
      <thead>
        <tr>
          <th>-1</th>
          <th>0</th>
          <th>1+</th>
          <th>Theme</th>
        </tr>
      </thead>
      <tbody>';

  foreach ($themes as $theme)
  {
    $group = 'theme'.$theme['id'];
    $votevalue = 0;

    foreach ($votes as $vote)
    {
      if ($vote['themeid'] == $theme['id'])
      {
        $votevalue = $vote['value'];
        break;
      }
    }

    echo '
      <tr class="voterow" vote="'.$votevalue.'" themeid="'.$theme['id'].'">
        <td><input type="radio" autocomplete="off" name="'.$group.'" class="downvote" '.($votevalue == -1 ? 'checked' : '').' /></td>
        <td><input type="radio" autocomplete="off" name="'.$group.'" class="removevote" '.($votevalue == 0 ? 'checked' : '').' /></td>
        <td><input type="radio" autocomplete="off" name="'.$group.'" class="upvote" '.($votevalue == 1 ? 'checked' : '').' /></td>
        <td>'.$theme['name'].'</td>
      </tr>';
    }

  echo '
      </tbody>
    </table>
    <button type="submit" class="btn btn-success pull-right" id="votesubmit">Vote</button>
    <span id="unsavedchangesnotification"><small>*You have unsaved vote(s)</small></span>';
}

?>

  </div>
</div>

<script>
JamID = <?=$id?>;
TotalVotes = <?=isset($votes) ? count($votes) : 0?>;
MaximumVotes = <?=$jam['votesperuser']?>;
Round = <?=isset($round) ? $round : 1?>;
RoundDescription = '<?=$rounddescription?>';
ChangesSaved = true;

$(function() {
  BindButtonClick($('#votesubmit'), Submit);
  BindCheckboxChanged($('.downvote'), function(obj) { ChangeVote(obj, -1); });
  BindCheckboxChanged($('.removevote'), function(obj) { ChangeVote(obj, 0); });
  BindCheckboxChanged($('.upvote'), function(obj) { ChangeVote(obj, 1); });

  UpdateVoteDisplay();
});

function ChangeVote(obj, Vote) {
  if ($(obj).is(':checked')) {
    var row = $(obj).parents('.voterow');

    if (row.attr('vote') == 0 && Vote != 0)
      TotalVotes++;
    else if (row.attr('vote') != 0 && Vote == 0)
      TotalVotes--;

    row.attr('vote', Vote);

    ChangesSaved = false;
    UpdateVoteDisplay();
  }
};

function UpdateVoteDisplay() {
  $('#totalvotesdisplay').html('You have cast ' + TotalVotes + ' / ' + MaximumVotes + ' votes for ' + RoundDescription + (!ChangesSaved ? '*' : ''));
  $('#unsavedchangesnotification').css('display', ChangesSaved ? 'none' : 'inline');

  var max = TotalVotes >= MaximumVotes;

  $('.downvote').attr('disabled', max);
  $('.upvote').attr('disabled', max);
};

function Submit() {
  function EnableVoting(Enabled) {
    EnableButton($('#votesubmit'), Enabled);
    $('.downvote').attr('disabled', !Enabled);
    $('.removevote').attr('disabled', !Enabled);
    $('.upvote').attr('disabled', !Enabled);
  };

  EnableVoting(false);

  var animation = DotAnimation($('#votesubmit'));
  var postdata = { jamid:JamID, round:Round, votes:{} };
  var count = 0;
  
  $('.voterow').each(function(Index, Row) {
    postdata['votes'][count++] = { themeid:$(Row).attr('themeid'), value:$(Row).attr('vote') };
  });

  function ResumeInput() {
    EnableVoting(true);
    UpdateVoteDisplay();

    StopAnimation(animation);
    $('#votesubmit').html('Vote');
  };

  Post('/api/v1/themes/voting/vote', postdata)
    .done(function(result) {
      if (result.success) {
        SuccessFeedback('Your vote(s) have been saved.');
        ChangesSaved = true;
        ResumeInput();
      }
      else {
        ErrorFeedback(result.message);
        ResumeInput();
      }
    })
    .fail(function() {
      ErrorFeedback('An unexpected error happened, please try again.');
      ResumeInput();
    });
};
</script>
