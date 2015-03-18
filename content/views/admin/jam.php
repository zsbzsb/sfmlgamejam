<div class="row">
  <h2 class="text-center"><?php echo $createjam ? 'Create' : 'Edit' ?> Jam<?php if (!$createjam) echo ' - ['.$jam['title'].']' ?></h2>
</div>

<?php if (!$createjam) $offset = 0; ?>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <form role="form" id="jamform">
      <?php require TEMPLATEROOT.'formfeedback.php'; ?>
      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" placeholder="Enter Title" value="<?php if (!$createjam) echo $jam['title']; ?>" />
      </div>
      <div class="form-group">
        <label for="themesperuser">Theme Submissions Per User</label>
        <br>
        <input type="number" class="form-control" id="themesperuser" min="1" value="5" />
      </div>
      <div class="checkbox">
        <label for="autoapprovethemes">
          <input type="checkbox" id="autoapprovethemes" checked />
          Auto Approve Themes
        </label>
      </div>
      <div class="form-group">
        <label for="initialvotingrounds">Initial Voting Rounds</label>
        <br>
        <input type="number" class="form-control" id="initialvotingrounds" min="1" value="3" />
      </div>
      <div class="form-group">
        <label for="votesperuser">Votes Per User</label>
        <br>
        <input type="number" class="form-control" id="votesperuser" min="1" value="5" />
      </div>
      <div class="form-group">
        <label for="topthemesinfinal">Top Themes in Final</label>
        <br>
        <input type="number" class="form-control" id="topthemesinfinal" min="1" value="3" />
      </div>
      <div class="form-group">
        <label for="suggestionsbegin">Suggestions Begin*</label>
        <div class="input-group date" id="suggestionsbeginpicker">
          <input type="text" class="form-control" id="suggestionsbegin" placeholder="Select a Date" value="<?php if (!$createjam) echo date($DATETIME_FORMAT, $offset += $jam['suggestionsbegin']); ?>" />
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
      </div>
      <div class="form-group">
        <label for="approvalsbegin">Approvals Begin*</label>
        <div class="input-group date" id="approvalsbeginpicker">
          <input type="text" class="form-control" id="approvalsbegin" placeholder="Select a Date" value="<?php if (!$createjam) echo date($DATETIME_FORMAT, $offset += $jam['suggestionslength']); ?>" />
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
      </div>
      <div class="form-group">
        <label for="votingbegins">Voting Begins*</label>
        <div class="input-group date" id="votingbeginspicker">
          <input type="text" class="form-control" id="votingbegins" placeholder="Select a Date" value="<?php if (!$createjam) echo date($DATETIME_FORMAT, $offset += $jam['approvallength']); ?>" />
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
      </div>
      <div class="form-group">
        <label for="themeannounce">Theme Announce*</label>
        <div class="input-group date" id="themeannouncepicker">
          <input type="text" class="form-control" id="themeannounce" placeholder="Select a Date" value="<?php if (!$createjam) echo date($DATETIME_FORMAT, $offset += $jam['votinglength']); ?>" />
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
      </div>
      <div class="form-group">
        <label for="jambegins">Jam Begins*</label>
        <div class="input-group date" id="jambeginspicker">
          <input type="text" class="form-control" id="jambegins" placeholder="Select a Date" value="<?php if (!$createjam) echo date($DATETIME_FORMAT, $offset += $jam['themeannouncelength']); ?>" />
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
      </div>
      <div class="form-group">
        <label for="jamends">Jam Ends*</label>
        <div class="input-group date" id="jamendspicker">
          <input type="text" class="form-control" id="jamends" placeholder="Select a Date" value="<?php if (!$createjam) echo date($DATETIME_FORMAT, $offset += $jam['jamlength']); ?>" />
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
      </div>
      <div class="form-group">
        <label for="submissionsend">Game Submissions End*</label>
        <div class="input-group date" id="submissionsendpicker">
          <input type="text" class="form-control" id="submissionsend" placeholder="Select a Date" value="<?php if (!$createjam) echo date($DATETIME_FORMAT, $offset += $jam['submissionslength']); ?>" />
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
JamID = <?php echo !$createjam ? $jam['id'] : -1; ?>;
Pickers = ['#suggestionsbegin', '#approvalsbegin', '#votingbegins', '#themeannounce', '#jambegins', '#jamends', '#submissionsend'];

$(function() {
  // initialize the date-time pickers and register for validation
  for (var i = 0; i < Pickers.length; i++) {
    $(Pickers[i] + 'picker').datetimepicker();
    BindTextboxChanged($(Pickers[i]), ValidateForm);
  }

  // set min/max dates if we are editing a jam
  if (!CreateJam) {
    for (var i = 0; i < Pickers.length; i++) {
      if (i > 0) GetPicker(Pickers[i] + 'picker').maxDate(GetPicker(Pickers[i - 1] + 'picker').date());
      if (i + 1 < Pickers.length) GetPicker(Pickers[i] + 'picker').minDate(GetPicker(Pickers[i + 1] + 'picker').date());
    }
    
    ValidateForm();
  }

  // hookup the submit button
  BindButtonClick($('#jamsubmit'), OnSubmit);

  // register textboxes for validation
  BindTextboxChanged($('#title'), ValidateForm);
  BindTextboxChanged($('#themesperuser'), ValidateForm);
  BindTextboxChanged($('#initialvotingrounds'), ValidateForm);
  BindTextboxChanged($('#votesperuser'), ValidateForm);
  BindTextboxChanged($('#topthemesinfinal'), ValidateForm);

  // validate form and update min/max dates when the selected date-time changes
  for (var i = 0; i < Pickers.length; i++) {
    (function(i) {
      $(Pickers[i] + 'picker').on('dp.change', function(e) {
        if (i > 0) GetPicker(Pickers[i - 1] + 'picker').maxDate(e.date);
        if (i + 1 < Pickers.length) GetPicker(Pickers[i + 1] + 'picker').minDate(e.date);

        ValidateForm();
      });
    })(i);
  }
});

function OnSubmit() {
  if (ValidateForm()) {
    Submit();
  }
};

function ValidateForm() {
  valid = true;

  if ($('#title').val().length == 0) valid = false;
  if (!IsNumber('#themesperuser') || parseInt($('#themesperuser').val(), 10) <= 0) valid = false;
  if (!IsNumber('#initialvotingrounds') || parseInt($('#initialvotingrounds').val(), 10) <= 0) valid = false;
  if (!IsNumber('#votesperuser') || parseInt($('#votesperuser').val(), 10) <= 0) valid = false;
  if (!IsNumber('#topthemesinfinal') || parseInt($('#topthemesinfinal').val(), 10) <= 0) valid = false;

  for (var i = 0; i < Pickers.length; i++) {
    if ($(Pickers[i]).val().length == 0) {
      valid = false;
      break
    }
  }

  EnableButton($('#jamsubmit'), valid);
  return valid;
};

function Submit() {
  EnableButton($('#jamsubmit'), false);
  EnableFormInput('#jamform', false);

  animation = DotAnimation($('#jamsubmit'));

  title = $('#title').val();
  themesperuser = parseInt($('#themesperuser').val(), 10);
  autoapprovethemes = $('autoapprovethemes').is(':checked');
  initialvotingrounds = parseInt($('#initialvotingrounds').val(), 10);
  votesperuser = parseInt($('#votesperuser').val(), 10);
  topthemesinfinal = parseInt($('#topthemesinfinal').val(), 10);

  suggestionsbegin = GetTimeStamp('#suggestionsbeginpicker');
  suggestionslength = GetTimeStamp('#approvalsbeginpicker') - GetTimeStamp('#suggestionsbeginpicker');
  approvallength = GetTimeStamp('#votingbeginspicker') - GetTimeStamp('#approvalsbeginpicker');
  votinglength = GetTimeStamp('#themeannouncepicker') - GetTimeStamp('#votingbeginspicker');
  themeannouncelength = GetTimeStamp('#jambeginspicker') - GetTimeStamp('#themeannouncepicker');
  jamlength = GetTimeStamp('#jamendspicker') - GetTimeStamp('#jambeginspicker');
  submissionslength = GetTimeStamp('#submissionsendpicker') - GetTimeStamp('#jamendspicker');

  success = false;
  
  Post(CreateJam ? '/api/v1/jams/create' : '/api/v1/jams/update', {
      id:JamID,
      title:title,
      themesperuser:themesperuser,
      autoapprovethemes:autoapprovethemes,
      initialvotingrounds:initialvotingrounds,
      votesperuser:votesperuser,
      topthemesinfinal:topthemesinfinal,
      suggestionsbegin:suggestionsbegin,
      suggestionslength:suggestionslength,
      approvallength:approvallength,
      votinglength:votinglength,
      themeannouncelength:themeannouncelength,
      jamlength:jamlength,
      submissionslength
    })
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
