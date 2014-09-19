var InProgress = false;

$(function() {
  $('#feedback-hide').bind("click", function() { $('#feedback').addClass('hide'); });
  $('#submit').bind("click", function() { if (!ValidateForm()) return false; InProgress = true; EnableForm(false); Submit(); return false; });
});

function RegisterTextbox(Textbox) {
  Textbox.bind("change keypress paste input", function() { RequestValidateForm() });
};

function RequestValidateForm() {
  EnableForm(ValidateForm());
};

function EnableForm(Valid) {
  if (!InProgress) {
    if (Valid) $('#submit').removeClass('disabled');
    else $('#submit').addClass('disabled');
    $("#form :input").attr('disabled', false);
    StopWaitingAnimation();
  }
  else {
    $('#submit').addClass('disabled');
    $("#form :input").attr('disabled', true);
    StartWaitingAnimation();
  }
};

function StartWaitingAnimation() {
  DotAnimation($('#submit'));
};

function StopWaitingAnimation() {
  StopAnimation($('#submit'));
};

function SuccessFeedback(Message) {
  $('#feedback-content').html(Message);
  $('#feedback').removeClass('hide alert-danger');
  $('#feedback').addClass('alert-success');
};

function ErrorFeedback(Message) {
  $('#feedback-content').html(Message);
  $('#feedback').removeClass('hide alert-success');
  $('#feedback').addClass('alert-danger');
};

function Post(URL, Data, SuccessMessage = 'Success! You are now being redirected...') {
  $.post(URL, Data, function(result) {
    if (!result.success) {
      InProgress = false;
      EnableForm(true);
      ErrorFeedback(result.error);
    }
    else {
      StopWaitingAnimation();
      SuccessFeedback(SuccessMessage);
      if (result.url.length > 0) window.location.replace(result.url);
      else {
        InProgress = false;
        EnableForm(true);
      }
    }
  }, 'json');
};
