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
          <input type="text" class="form-control" id="suggestionsbegin" placeholder="Select a Date" />
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
      </div>
      <div class="form-group">
        <label for="approvalsbegin">Approvals Begin*</label>
        <div class="input-group date" id="approvalsbeginpicker">
          <input type="text" class="form-control" id="approvalsbegin" placeholder="Select a Date" />
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
      </div>
      <div class="form-group">
        <label for="votingbegins">Voting Begins*</label>
        <div class="input-group date" id="votingbeginspicker">
          <input type="text" class="form-control" id="votingbegins" placeholder="Select a Date" />
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
      </div>
      <div class="form-group">
        <label for="themeannounce">Theme Announce*</label>
        <div class="input-group date" id="themeannouncepicker">
          <input type="text" class="form-control" id="themeannounce" placeholder="Select a Date" />
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
      </div>
      <div class="form-group">
        <label for="jambegins">Jam Begins*</label>
        <div class="input-group date" id="jambeginspicker">
          <input type="text" class="form-control" id="jambegins" placeholder="Select a Date" />
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
      </div>
      <div class="form-group">
        <label for="jamends">Jam Ends*</label>
        <div class="input-group date" id="jamendspicker">
          <input type="text" class="form-control" id="jamends" placeholder="Select a Date" />
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
      </div>
      <div class="form-group">
        <label for="submissionsend">Game Submissions End*</label>
        <div class="input-group date" id="submissionsendpicker">
          <input type="text" class="form-control" id="submissionsend" placeholder="Select a Date" />
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

$(function() {
  // initialize the date-time pickers
  $('#suggestionsbeginpicker').datetimepicker();
  $('#approvalsbeginpicker').datetimepicker();
  $('#votingbeginspicker').datetimepicker();
  $('#themeannouncepicker').datetimepicker();
  $('#jambeginspicker').datetimepicker();
  $('#jamendspicker').datetimepicker();
  $('#submissionsendpicker').datetimepicker();

  // set min/max dates if we are editing a jam
  if (!CreateJam) {
    
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
  BindTextboxChanged($('#suggestionsbegin'), ValidateForm);
  BindTextboxChanged($('#approvalsbegin'), ValidateForm);
  BindTextboxChanged($('#votingbegins'), ValidateForm);
  BindTextboxChanged($('#themeannounce'), ValidateForm);
  BindTextboxChanged($('#jambegins'), ValidateForm);
  BindTextboxChanged($('#jamends'), ValidateForm);
  BindTextboxChanged($('#submissionsend'), ValidateForm);

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
  if (GetTimeStamp('#suggestionsstartcontainer') >= GetTimeStamp('#suggestionsendcontainer')) valid = false;
  if (GetTimeStamp('#suggestionsendcontainer') >= GetTimeStamp('#jamstartcontainer')) valid = false;

  EnableButton($('#jamsubmit'), valid);
  return valid;
};

function Submit() {
  EnableButton($('#jamsubmit'), false);
  EnableFormInput('#jamform', false);

  animation = DotAnimation($('#jamsubmit'));

  title = $('#title').val();
  suggestionsstart = GetTimeStamp('#suggestionsstartcontainer');
  suggestionsend = GetTimeStamp('#suggestionsendcontainer');
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
