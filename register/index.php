<?php $Title = "Register"; $Active = "Register"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<div class="row">
  <h2 class="text-center">Create an Account</h2>
</div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <form role="form" id="registerform">
      <div class="alert alert-dismissible hide" role="alert" id="feedback"><button type="button" class="close" id="feedback-hide"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><span id="feedback-content"></span></div>
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" placeholder="PieMaker" />
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
          <input type="checkbox" id="acceptterms">I have read and accepted the <a target="_blank" href="/terms">Terms of Use</a>
        </label>
      </div>
      <button type="submit" class="btn btn-success pull-right disabled" id="register">Register</button>
    </form>
  </div>
</div>

<script>
var InProgress = false;
var InProgressAnimation;

$(function() {
  RegisterTextbox($('#username'));
  RegisterTextbox($('#password'));
  RegisterTextbox($('#confirmpassword'));
  RegisterTextbox($('#email'));
  $('#acceptterms').bind("change", function() { ValidateForm(); });
  $('#register').bind("click", function() { Register(); return false; });
  $('#feedback-hide').bind("click", function() { $('#feedback').addClass('hide'); });
});

function RegisterTextbox(Textbox) {
  Textbox.bind("change keypress paste input", function() { ValidateForm(); });
};

function ValidateForm() {
  var valid = true;

  if ($('#username').val().length == 0) valid = false;
  if ($('#password').val().length == 0) valid = false;
  if ($('#confirmpassword').val() != $('#password').val()) valid = false;
  if (!(/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i).test($('#email').val())) valid = false;
  if (!$('#acceptterms').is(":checked")) valid = false;

  EnableForm(valid);
  return valid;
};

function EnableForm(Valid) {
  if (!InProgress) {
    if (Valid) $('#register').removeClass('disabled');
    else $('#register').addClass('disabled');
    $("#registerform :input").attr('disabled', false);
    StopWaitingAnimation();
  }
  else {
    $('#register').addClass('disabled');
    $("#registerform :input").attr('disabled', true);
    StartWaitingAnimation();
  }
};

function StartWaitingAnimation() {
  $('#register').html('.');
  InProgressAnimation = window.setInterval(function() {
    if ($('#register').html().length > 5) $('#register').html('.');
    else $('#register').append('.');
  }, 500);
};

function StopWaitingAnimation() {
  window.clearInterval(InProgressAnimation);
  $('#register').html('Register');
};

function Register() {
  if (!ValidateForm()) return;
  InProgress = true;
  EnableForm(false);
  var username = $('#username').val();
  var password = $('#password').val();
  var email = $('#email').val();
  $.post("/scripts/doregister.php", {username:username, password:password, email:email}, function(result) {
    if (!result.success) {
      InProgress = false;
      EnableForm(true);
      $('#feedback-content').html(result.error);
      $('#feedback').removeClass('hide alert-success');
      $('#feedback').addClass('alert-danger');
    }
    else {
      StopWaitingAnimation();
      $('#feedback-content').html('Success! You are now being redirected...');
      $('#feedback').removeClass('hide alert-danger');
      $('#feedback').addClass('alert-success');
      window.location.replace(result.url);
    }
  }, 'json');
};
</script>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>
