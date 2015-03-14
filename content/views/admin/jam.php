<?php

$createjam = !isset($id);

if (!$createjam)
{
  $stmt = $dbconnection->prepare('SELECT * FROM jams WHERE id = ?;');
  $stmt->execute(array($id));
  $rows = $stmt->fetchAll();
  if ($stmt->rowCount() == 0)
  {
    header('Location: '.$routes->generate('admin'));
    die();
  }
  $jam = $rows[0];
}

?>

<div class="row">
  <h2 class="text-center"><?php echo $createjam ? 'Create' : 'Edit' ?> Jam<?php if (!$createjam) echo ' - ['.$jam['title'].']' ?></h2>
</div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <form role="form" id="jamform">
      <?php require TEMPLATEROOT.'formfeedback.php'; ?>
      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" placeholder="Enter Title" value="<?php if (!$createjam) echo $jam['title']; ?>" />
      </div>
      <div class="form-group">
        <label for="suggestionsstart">Suggestions Start*</label>
        <div class="input-group date" id="suggestionsstartcontainer">
          <input type="text" class="form-control" id="suggestionsstart" placeholder="Select a Date" value="<?php if (!$createjam) echo date($DATETIME_FORMAT, $jam['suggestionsstart']); ?>" />
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
      </div>
      <div class="form-group">
        <label for="suggestionsend">Suggestions End*</label>
        <div class="input-group date" id="suggestionsendcontainer">
          <input type="text" class="form-control" id="suggestionsend" placeholder="Select a Date" value="<?php if (!$createjam) echo date($DATETIME_FORMAT, $jam['suggestionsend']); ?>" />
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
      </div>
      <div class="form-group">
        <label for="jamstart">Jam Start*</label>
        <div class="input-group date" id="jamstartcontainer">
          <input type="text" class="form-control" id="jamstart" placeholder="Select a Date" value="<?php if (!$createjam) echo date($DATETIME_FORMAT, $jam['jamstart']); ?>" />
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
      </div>
      <button type="submit" class="btn btn-success pull-right disabled" id="jamsubmit"><?php echo $createjam ? 'Create' : 'Save' ?></button>
    </form>
    <span><small>*All times are entered in UTC</small></span>
  </div>
</div>

<script>
CreateJam = <?php echo $createjam ? 'true' : 'false'; ?>;
JamID = <?php echo !$createjam ? $id : -1; ?>;

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

    ValidateForm();
  }

  // hookup the submit button
  BindButtonClick($('#jamsubmit'), OnSubmit);

  // register textboxes for validation
  BindTextboxChanged($('#title'), ValidateForm);
  BindTextboxChanged($('#suggestionsstart'), ValidateForm);
  BindTextboxChanged($('#suggestionsend'), ValidateForm);
  BindTextboxChanged($('#jamstart'), ValidateForm);

  // validate form and update min/max dates when the selected date-time changes
  $('#suggestionsstartcontainer').on('dp.change', function(e) {
    $('#suggestionsendcontainer').data('DateTimePicker').setMinDate(e.date);
    ValidateForm();
  });
  $('#suggestionsendcontainer').on('dp.change', function(e) {
    $('#suggestionsstartcontainer').data('DateTimePicker').setMaxDate(e.date);
    $('#jamstartcontainer').data('DateTimePicker').setMinDate(e.date);
    ValidateForm();
  });
  $('#jamstartcontainer').on('dp.change', function(e) {
    ValidateForm();
  });
});

function OnSubmit() {
  if (ValidateForm()) {
    Submit();
  }
};

function ValidateForm() {
  valid = true;

  if ($('#title').val().length == 0) valid = false;
  if ($('#suggestionsstart').val().length == 0) valid = false;
  if ($('#suggestionsend').val().length == 0) valid = false;
  if ($('#jamstart').val().length == 0) valid = false;
  if (GetTimeStamp('#suggestionsstart') >= GetTimeStamp('#suggestionsend')) valid = false;
  if (GetTimeStamp('#suggestionsend') >= GetTimeStamp('#jamstart')) valid = false;

  EnableButton($('#jamsubmit'), valid);
  return valid;
};

function Submit() {
  EnableButton($('#jamsubmit'), false);
  EnableFormInput('#jamform', false);

  animation = DotAnimation($('#jamsubmit'));

  title = $('#title').val();
  suggestionsstart = GetTimeStamp('#suggestionsstart');
  suggestionsend = GetTimeStamp('#suggestionsend');
  jamstart = GetTimeStamp('#jamstart');

  success = false;
  
  Post(CreateJam ? '/api/v1/jams/create' : '/api/v1/jams/update', { id:JamID, title:title, suggestionsstart:suggestionsstart, suggestionsend:suggestionsend, jamstart:jamstart })
    .done(function(result) {
      if (result.success) {
        SuccessFeedback('Jam has been successfully ' + (CreateJam ? 'created' : 'updated') + ', redirecting...');
        success = true;
        Redirect('<?php echo $routes->generate('admin'); ?>');
      }
      else ErrorFeedback(result.message);
    })
    .fail(function() {
      ErrorFeedback('An unexpected error happened, please try again.');
    })
    .always(function() {
      if (!success) {
        EnableButton($('#jamsubmit'), true);
        EnableFormInput('#jamform', true);
      }

      StopAnimation(animation);
      $('#jamsubmit').html(CreateJam ? 'Create' : 'Save');
    });
};
</script>
