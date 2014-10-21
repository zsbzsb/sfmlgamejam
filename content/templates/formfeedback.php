<div class="alert alert-dismissible hide" role="alert" id="feedback"><button type="button" class="close" id="feedback-hide"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><span id="feedback-content"></span></div>

<script>
$(function() {
  $('#feedback-hide').bind("click", function() { $('#feedback').addClass('hide'); });
});
</script>
