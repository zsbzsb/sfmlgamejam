<div class="row">
  <h2 class="text-center">Login to Your Account</h2>
</div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <form role="form" id="form">
      <div class="alert alert-dismissible hide" role="alert" id="feedback"><button type="button" class="close" id="feedback-hide"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><span id="feedback-content"></span></div>
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" placeholder="JohnFourteenSix" />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Enter Password" />
      </div>
      <button type="submit" class="btn btn-success pull-right disabled" id="submit">Login</button>
    </form>
  </div>
</div>

<!-- Custom Feedback -->
<script src="/js/feedback.js"></script>

<script>
$(function() {
  RegisterTextbox($('#username'));
  RegisterTextbox($('#password'));
});

function ValidateForm() {
  var valid = true;

  if ($('#username').val().length == 0) valid = false;
  if ($('#password').val().length == 0) valid = false;

  return valid;
};

function Submit() {
  var username = $('#username').val();
  var password = $('#password').val();

  Post('/dologin', {username:username, password:password<?php if (isset($_GET['return'])) echo ', return:"'.$_GET['return'].'"'; ?>})
};
</script>
