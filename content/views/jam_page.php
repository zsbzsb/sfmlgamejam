<div class="row">
  <h2 class="text-center"><?=$jam['title']?></h2>
  <h4 class="text-center"><?= date(DATE_FORMAT, JamBegins($jam)).' to '.date(DATE_FORMAT, SubmissionsBegin($jam)); ?></h4>
  <h2 class="text-center timer" id="countdowntimer" timer-tag="<?=JamCountdownString($jam['status'])?>"></h2>
  <hr />
</div>

<script>
TimerEnabled = <?php echo $jam['status'] < JamStatus::Complete ? 'true' : 'false'; ?>;
RemainingTime = <?=JamRemainingTime($jam)?>;

$(function() {
  if (TimerEnabled) TimerAnimation($('#countdowntimer'), RemainingTime);
});
</script>
