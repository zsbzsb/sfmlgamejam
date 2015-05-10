<?php if (isset($jam['selectedtheme'])) echo '<h2 class="text-center text-primary aftertag" aftertag="is the chosen theme">\''.$jam['selectedtheme'].'\'</h2>'; ?>
<h3 class="text-center timer aftertag" id="countdowntimer" aftertag="<?= $jam['status'] < JamStatus::Complete ? JamCountdownString($jam['status']) : ''?>"></h3>

<script>
TimerEnabled = <?php echo $jam['status'] < JamStatus::Complete ? 'true' : 'false'; ?>;
RemainingTime = <?=JamRemainingTime($jam)?>;

$(function() {
  if (TimerEnabled) TimerAnimation($('#countdowntimer'), RemainingTime);
});
</script>
