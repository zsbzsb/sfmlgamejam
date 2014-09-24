<?php $Title = "Create Jam"; $RequiresAdmin = true; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<script src="/js/moment.min.js"></script>
<script src="/js/bootstrap-datetimepicker.min.js"></script>
<link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

<div class="row">
  <h2 class="text-center">Create a Jam</h2>
</div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <form role="form" id="form">
      <div class="alert alert-dismissible hide" role="alert" id="feedback"><button type="button" class="close" id="feedback-hide"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><span id="feedback-content"></span></div>
      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" placeholder="Enter Title" />
      </div>
      <div class="form-group">
        <label for="suggestionsstart">Suggestions Start*</label>
        <div class="input-group date" id="suggestionsstartcontainer">
          <input type="text" class="form-control" id="suggestionsstart" placeholder="Select a Date" />
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
      </div>
      <div class="form-group">
        <label for="suggestionsend">Suggestions End*</label>
        <div class="input-group date" id="suggestionsendcontainer">
          <input type="text" class="form-control" id="suggestionsend" placeholder="Select a Date" />
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
      </div>
      <div class="form-group">
        <label for="jamstart">Jam Start*</label>
        <div class="input-group date" id="jamstartcontainer">
          <input type="text" class="form-control" id="jamstart" placeholder="Select a Date" />
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
      </div>
      <button type="submit" class="btn btn-success pull-right disabled" id="submit">Create</button>
    </form>
    <span><small>*All times are entered in UTC</small></small>
  </div>
</div>

<!-- Custom Feedback -->
<script src="/js/feedback.js"></script>

<script>
$(function() {
  $('#suggestionsstartcontainer').datetimepicker();
  $('#suggestionsendcontainer').datetimepicker();
  $('#jamstartcontainer').datetimepicker();
  RegisterTextbox($('#title'));
  RegisterTextbox($('#suggestionsstart'));
  RegisterTextbox($('#suggestionsend'));
  RegisterTextbox($('#jamstart'));
  $('#suggestionsstartcontainer').on('dp.change', function(e) {
    $('#suggestionsendcontainer').data('DateTimePicker').setMinDate(e.date);
    RequestValidateForm();
  });
  $('#suggestionsendcontainer').on('dp.change', function(e) {
    $('#suggestionsstartcontainer').data('DateTimePicker').setMaxDate(e.date);
    $('#jamstartcontainer').data('DateTimePicker').setMinDate(e.date);
    RequestValidateForm();
  });
  $('#jamstartcontainer').on('dp.change', function(e) {
    RequestValidateForm();
  });
});

function GetTimeStamp(PickerID) {
  return moment.utc($(PickerID).val() + ' UTC').unix();
};

function ValidateForm() {
  var valid = true;

  if ($('#title').val().length == 0) valid = false;
  if ($('#suggestionsstart').val().length == 0) valid = false;
  if ($('#suggestionsend').val().length == 0) valid = false;
  if ($('#jamstart').val().length == 0) valid = false;
  if (GetTimeStamp('#suggestionsstart') >= GetTimeStamp('#suggestionsend')) valid = false;
  if (GetTimeStamp('#suggestionsend') >= GetTimeStamp('#jamstart')) valid = false;

  return valid;
};

function Submit() {
  var title = $('#title').val();
  var suggestionsstart = GetTimeStamp('#suggestionsstart');
  var suggestionsend = GetTimeStamp('#suggestionsend');
  var jamstart = GetTimeStamp('#jamstart');
  
  Post('/scripts/createjam.php', {title:title, suggestionsstart:suggestionsstart, suggestionsend:suggestionsend, jamstart:jamstart});
};
</script>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>
