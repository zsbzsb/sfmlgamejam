<div class="row">
  <h2 class="text-center">Login to Your Account</h2>
</div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <form role="form" id="loginform">
      <?php require TEMPLATEROOT.'formfeedback.php'; ?>
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" placeholder="JohnFourteenSix" />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Enter Password" />
      </div>
      <button type="submit" class="btn btn-success pull-right disabled" id="loginsubmit">Login</button>
    </form>
  </div>
</div>

<script>
$(function() {
  BindButtonClick($('#loginsubmit'), OnSubmit);
  BindTextboxChanged($('#username'), ValidateForm);
  BindTextboxChanged($('#password'), ValidateForm);
});

function OnSubmit() {
  if (ValidateForm()) {
    Submit();
  }
};

function ValidateForm() {
  valid = true;

  if ($('#username').val().length == 0) valid = false;
  if ($('#password').val().length == 0) valid = false;


  EnableButton($('#loginsubmit'), valid);
  return valid;
};

function Submit() {
  EnableButton($('#loginsubmit'), false);
  EnableFormInput('#loginform', false);

  animation = DotAnimation($('#loginsubmit'));

  username = $('#username').val();
  password = $('#password').val();

  success = false;

  Post('/api/v1/account/login', { username:username, password:password })
    .done(function(result) {
      if (result.success) {
        SuccessFeedback('You have been successfully logged in, redirecting...');
        success = true;
        Redirect('<?php echo $routes->generate('account'); ?>');
      }
      else ErrorFeedback(result.message);
    })
    .fail(function() {
      ErrorFeedback('An unexpected error happened, please try again.');
    })
    .always(function() {
      if (!success) {
        EnableButton($('#loginsubmit'), true);
        EnableFormInput('#loginform', true);
      }

      StopAnimation(animation);
      $('#loginsubmit').html('Login');
    });
};
</script>
