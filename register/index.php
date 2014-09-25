<?php $Title = 'Register'; $Active = 'Register'; $RequiresGuest = true; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<div class="row">
  <h2 class="text-center">Create an Account</h2>
</div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <form role="form" id="form">
      <div class="alert alert-dismissible hide" role="alert" id="feedback"><button type="button" class="close" id="feedback-hide"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><span id="feedback-content"></span></div>
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" placeholder="JohnThreeSixteen" />
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
      <button type="submit" class="btn btn-success pull-right disabled" id="submit">Register</button>
    </form>
  </div>
</div>

<!-- Custom Feedback -->
<script src="/js/feedback.js"></script>

<script>
$(function() {
  RegisterTextbox($('#username'));
  RegisterTextbox($('#password'));
  RegisterTextbox($('#confirmpassword'));
  RegisterTextbox($('#email'));
  $('#acceptterms').bind("change", function() { RequestValidateForm(); });
});

function ValidateForm() {
  var valid = true;

  if ($('#username').val().length == 0) valid = false;
  if ($('#password').val().length == 0) valid = false;
  if ($('#confirmpassword').val() != $('#password').val()) valid = false;
  if (!(/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i).test($('#email').val())) valid = false;
  if (!$('#acceptterms').is(":checked")) valid = false;

  return valid;
};

function Submit() {
  var username = $('#username').val();
  var password = $('#password').val();
  var email = $('#email').val();
  
  Post('/scripts/doregister.php', {username:username, password:password, email:email});
};
</script>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>
