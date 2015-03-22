<div class="row">
  <h2 class="text-center"><?=$jam['title']?></h2>
  <h4 class="text-center"><?= date(DATE_FORMAT, JamBegins($jam)).' to '.date(DATE_FORMAT, SubmissionsBegin($jam)); ?></h4>
  <h2 class="text-center timer" id="countdowntimer" timer-tag="<?=JamCountdownString($jam['status'])?>"></h2>
  <hr />
</div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <ol class="breadcrumb text-center">
      <li><?= $jam['status'] >= JamStatus::ReceivingSuggestions ? '<a href="#">Theme Suggestions</a>' : 'Theme Suggestions' ?></li>
      <li><?= $jam['status'] >= JamStatus::ThemeVoting ? '<a href="#">Theme Voting</a>' : 'Theme Voting' ?></li>
      <li><?= $jam['status'] >= JamStatus::JamRunning ? '<a href="#">GameSubmissions</a>' : 'Game Submissions' ?></li>
    </ol>
  </div>
</div>

<script>
TimerEnabled = <?php echo $jam['status'] < JamStatus::Complete ? 'true' : 'false'; ?>;
RemainingTime = <?=JamRemainingTime($jam)?>;

$(function() {
  if (TimerEnabled) TimerAnimation($('#countdowntimer'), RemainingTime);
});
</script>
