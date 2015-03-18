<div class="row">
  <div class="jumbotron">
    <h2 class="text-center" id="timebigdisplay"></h2>
    <br>
    <h5 class="text-center">Server time is currently displayed in UTC</h5>
  </div>
</div>

<script>
$(function() {
  UpdateBigTime();
  window.setInterval(function() {
    UpdateBigTime();
  }, 100);
});

function UpdateBigTime() {
  $('#timebigdisplay').html(moment.utc().format('MM/DD/YYYY hh:mm:ss A'));
};
</script>
