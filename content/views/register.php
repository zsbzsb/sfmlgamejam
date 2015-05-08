<div class="row">
  <h2 class="text-center">Create an Account</h2>
  <h4 class="text-center">Or <a href="<?= $routes->generate('login') ?>">login</a> to your account</h4>
</div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <form role="form" id="registerform">
      <?php require TEMPLATEROOT.'formfeedback.php'; ?>
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" placeholder="JohnThreeSixteen" maxlength="20" />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Enter Password" />
      </div>
      <div class="form-group">
        <label for="confirmpassword">Confirm Password</label>
        <input type="password" class="form-control" id="confirmpassword" placeholder="Confirm Password" />
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" placeholder="Email Address" />
      </div>
      <div class="checkbox">
        <label>
          <input type="checkbox" id="acceptterms">I have read and accepted the <a target="_blank" href="<?php echo $routes->generate('terms'); ?>">Terms of Use</a>
        </label>
      </div>
      <button type="submit" class="btn btn-success pull-right disabled" id="registersubmit">Register</button>
    </form>
  </div>
</div>

<script>
$(function() {
  BindButtonClick($('#registersubmit'), OnSubmit);
  BindTextboxChanged($('#username'), ValidateForm);
  BindTextboxChanged($('#password'), ValidateForm);
  BindTextboxChanged($('#confirmpassword'), ValidateForm);
  BindTextboxChanged($('#email'), ValidateForm);
  BindCheckboxChanged($('#acceptterms'), ValidateForm);
});

function OnSubmit() {
  if (ValidateForm()) {
    Submit();
  }
};

function ValidateForm() {
  var valid = true;

  if ($('#username').val().length == 0) valid = false;
  if ($('#password').val().length == 0) valid = false;
  if ($('#confirmpassword').val() != $('#password').val()) valid = false;
  if (!(/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i).test($('#email').val())) valid = false;
  if (!$('#acceptterms').is(':checked')) valid = false;

  EnableButton($('#registersubmit'), valid);
  return valid;
};

function Submit() {
  EnableButton($('#registersubmit'), false);
  EnableFormInput('#registerform', false);

  var animation = DotAnimation($('#registersubmit'));

  var username = $('#username').val();
  var password = $('#password').val();
  var email = $('#email').val();

  var success = false;

  Post('/api/v1/account/register', { username:username, password:password, email:email })
    .done(function(result) {
      if (result.success) {
        SuccessFeedback('You have been successfully registered, redirecting...');
        success = true;
        Redirect('<?php echo $routes->generate('register_thanks'); ?>');
      }
      else ErrorFeedback(result.message);
    })
    .fail(function() {
      ErrorFeedback('An unexpected error happened, please try again.');
    })
    .always(function() {
      if (!success) {
        EnableButton($('#registersubmit'), true);
        EnableFormInput('#registerform', true);
      }

      StopAnimation(animation);
      $('#registersubmit').html('Register');
    });
};
</script>
