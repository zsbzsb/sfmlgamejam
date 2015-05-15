<?php require TEMPLATEROOT.'jam_header.php'; ?>

<h3 class="text-center">Submit Your Theme Ideas (try to be creative)</h3>
<br>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <?php

    if ($jam['status'] != JamStatus::ReceivingSuggestions)
    {
      echo '<h4 class="text-center">Suggestions are currently closed</h4>';
    }
    else if (!$session->IsLoggedIn())
    {
      echo '<h4 class="text-center">You must be <a href="'.$routes->generate('login').'">logged in</a> to suggest themes</h4>';
    }
    else
    {
      echo '<form role="form" id="suggestionsform">';
      require TEMPLATEROOT.'formfeedback.php';

      for ($i = 0; $i < $jam['themesperuser']; $i++)
      {
        echo '<div class="form-group">
                <label for="theme'.$i.'">Theme '.($i + 1).'</label>
                <input type="text" class="form-control themesuggestion" value="'.($i < count($themes) ? $themes[$i]['name'] : '').'" currentid="'.($i < count($themes) ? $themes[$i]['id'] : '-1').'" />
              </div>';
      }

      echo '<button type="submit" class="btn btn-success pull-right disabled" id="suggestionssubmit">Save</button><span><small>No offensive language is permitted</small></span></form>';
    }

    ?>
  </div>
</div>

<script>
JamID = <?=$id?>;
ThemeCount = <?=$jam['themesperuser']?>;

$(function() {
  BindButtonClick($('#suggestionssubmit'), Submit);
  BindTextboxChanged($('.themesuggestion'), ValidateForm);

  ValidateForm();
});

function OnSubmit() {
  if (ValidateForm()) {
    Submit();
  }
};

function ValidateForm() {
  var valid = false;

  var suggestions = $('.themesuggestion');

  for (var i = 0; i < suggestions.length; i++) {
    if ($(suggestions[i]).val().length > 0 || $(suggestions[i]).attr('currentid') != -1) {
      valid = true;
      break;
    }
  }

  EnableButton($('#suggestionssubmit'), valid);
  return valid;
};

function Submit() {
  EnableButton($('#suggestionssubmit'), false);
  EnableFormInput('#suggestionsform', false);

  var animation = DotAnimation($('#suggestionssubmit'));

  var suggestions = $('.themesuggestion');
  var postdata = {};
  var count = 0;

  for (var i = 0; i < suggestions.length; i++) {
    var name = $(suggestions[i]).val();
    var currentid = $(suggestions[i]).attr('currentid');

    if (name.length > 0 || currentid != -1) {
      postdata[count++] = { name:name, id:currentid };
    }
  }

  function ResumeInput() {
    EnableButton($('#suggestionssubmit'), true);
    EnableFormInput('#suggestionsform', true);

    StopAnimation(animation);
    $('#suggestionssubmit').html('Save');
  };

  function SendSuggestion(Suggestions, Index, Count) {
    var data = { jamid:JamID, themename:Suggestions[Index]['name'] };
    if (Suggestions[Index]['id'] != -1) data['themeid'] = Suggestions[Index]['id'];

    Post('/api/v1/themes/suggestions/submit', data)
      .done(function(result) {
        if (result.success) {
          if (Index < Count - 1)
            SendSuggestion(Suggestions, Index + 1, Count);
          else {
            SuccessFeedback('Your theme suggestions have been saved, redirecting...');
            Redirect('<?=$routes->generate('jam_page', array('id' => $id))?>');
          }
        }
        else {
          ErrorFeedback(result.message);
          ResumeInput();
        }
      })
      .fail(function() {
        ErrorFeedback('An unexpected error happened, please try again.');
        ResumeInput();
      });
  };

  SendSuggestion(postdata, 0, count);
};
</script>
