<div class="row">
  <h2 class="text-center">Edit Theme</h2>
</div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <form role="form" id="editform">
      <?php require TEMPLATEROOT.'formfeedback.php'; ?>
      <div class="form-group">
        <label for="theme">Theme</label>
        <input type="text" class="form-control" id="theme" value="<?=$theme['name']?>" />
      </div>
      <button type="submit" class="btn btn-success pull-right disabled" id="editsubmit">Save</button>
    </form>
  </div>
</div>

<script>
ThemeID = <?=$themeid?>;

$(function() {
  BindButtonClick($('#editsubmit'), OnSubmit);
  BindTextboxChanged($('#theme'), ValidateForm);

  ValidateForm();
});

function OnSubmit() {
  if (ValidateForm()) {
    Submit();
  }
};

function ValidateForm() {
  var valid = true;

  if ($('#theme').val().length == 0) valid = false;

  EnableButton($('#editsubmit'), valid);
  return valid;
};

function Submit() {
  EnableButton($('#editsubmit'), false);
  EnableFormInput('#editform', false);

  var animation = DotAnimation($('#editsubmit'));

  var theme = $('#theme').val();

  var success = false;

  Post('/api/v1/themes/edit', { id:ThemeID, name:theme })
    .done(function(result) {
      if (result.success) {
        SuccessFeedback('Theme has been saved, redirecting...');
        success = true;
        Redirect('<?=$routes->generate('theme_admin', array('id' => $id))?>');
      }
      else ErrorFeedback(result.message);
    })
    .fail(function() {
      ErrorFeedback('An unexpected error happened, please try again.');
    })
    .always(function() {
      if (!success) {
        EnableButton($('#editsubmit'), true);
        EnableFormInput('#editform', true);
      }

      StopAnimation(animation);
      $('#editsubmit').html('Save');
    });
};
</script>
