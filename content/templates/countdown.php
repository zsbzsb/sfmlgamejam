<h2 class="text-center timer" id="countdowntimer" timer-tag="<?= $jam['status'] < JamStatus::Complete ? JamCountdownString($jam['status']) : ''?>"></h2>

<script>
TimerEnabled = <?php echo $jam['status'] < JamStatus::Complete ? 'true' : 'false'; ?>;
RemainingTime = <?=JamRemainingTime($jam)?>;

$(function() {
  if (TimerEnabled) TimerAnimation($('#countdowntimer'), RemainingTime);
});
</script>
