<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';

$createjam = !isset($_GET['id']);
$jamid = ($createjam ? -1 : trim($_GET['id']));
if (!$createjam)
{
  $stmt = $dbconnection->prepare('SELECT * FROM jams WHERE id = ?;');
  $stmt->execute(array($jamid));
  $rows = $stmt->fetchAll();
  if ($stmt->rowCount() == 0)
  {
    header('Location: /admin');
    die();
  }
  $jam = $rows[0];
}

?>

<?php $Title = ($createjam ? 'Create' : 'Edit').' Jam'; $RequiresAdmin = true; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<div class="row">
  <h2 class="text-center"><?php echo $createjam ? 'Create' : 'Edit' ?> Jam</h2>
</div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <form role="form" id="form">
      <div class="alert alert-dismissible hide" role="alert" id="feedback"><button type="button" class="close" id="feedback-hide"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><span id="feedback-content"></span></div>
      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" placeholder="Enter Title" value="<?php if (!$createjam) echo $jam['title']; ?>" />
      </div>
      <div class="form-group">
        <label for="suggestionsstart">Suggestions Start*</label>
        <div class="input-group date" id="suggestionsstartcontainer">
          <input type="text" class="form-control" id="suggestionsstart" placeholder="Select a Date" value="<?php if (!$createjam) echo date($DATETIME_FORMATISO, $jam['suggestionsstart']); ?>" />
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
      </div>
      <div class="form-group">
        <label for="suggestionsend">Suggestions End*</label>
        <div class="input-group date" id="suggestionsendcontainer">
          <input type="text" class="form-control" id="suggestionsend" placeholder="Select a Date" value="<?php if (!$createjam) echo date($DATETIME_FORMATISO, $jam['suggestionsend']); ?>" />
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
      </div>
      <div class="form-group">
        <label for="jamstart">Jam Start*</label>
        <div class="input-group date" id="jamstartcontainer">
          <input type="text" class="form-control" id="jamstart" placeholder="Select a Date" value="<?php if (!$createjam) echo date($DATETIME_FORMATISO, $jam['jamstart']); ?>" />
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
      </div>
      <button type="submit" class="btn btn-success pull-right disabled" id="submit"><?php echo $createjam ? 'Create' : 'Save' ?></button>
    </form>
    <span><small>*All times are entered in UTC</small></span>
  </div>
</div>

<!-- Custom Feedback -->
<script src="/js/feedback.js"></script>

<!-- DateTime Picker -->
<script src="/js/moment.min.js"></script>
<script src="/js/bootstrap-datetimepicker.min.js"></script>
<link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

<script>
var CreateJam = <?php echo $createjam ? 'true' : 'false'; ?>;
var JamID = <?php echo $jamid; ?>;

$(function() {
  // initialize the date-time pickers
  $('#suggestionsstartcontainer').datetimepicker();
  $('#suggestionsendcontainer').datetimepicker();
  $('#jamstartcontainer').datetimepicker();

  // set min/max dates if we are editing a jam
  if (!CreateJam) {
    $('#suggestionsendcontainer').data('DateTimePicker').setMinDate($('#suggestionsstart').val());
    $('#suggestionsstartcontainer').data('DateTimePicker').setMaxDate($('#suggestionsend').val());
    $('#jamstartcontainer').data('DateTimePicker').setMinDate($('#suggestionsend').val());
    RequestValidateForm();
  }

  // register textboxes for validation
  RegisterTextbox($('#title'));
  RegisterTextbox($('#suggestionsstart'));
  RegisterTextbox($('#suggestionsend'));
  RegisterTextbox($('#jamstart'));

  // validate form and update min/max dates when the selected date-time changes
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
var d = $(PickerID).val().replace('UTC', '') + ' UTC';
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
  
  Post(CreateJam ? '/scripts/createjam.php' : '/scripts/updatejam.php', {id:JamID, title:title, suggestionsstart:suggestionsstart, suggestionsend:suggestionsend, jamstart:jamstart});
};
</script>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>
