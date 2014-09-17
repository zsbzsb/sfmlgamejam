var InProgress = false;
var InProgressAnimation;
var SubmitDefault = 'Submit';

$(function() {
  SubmitDefault = $('#submit').html();
  $('#feedback-hide').bind("click", function() { $('#feedback').addClass('hide'); });
  $('#submit').bind("click", function() { if (!ValidateForm()) return false; InProgress = true; EnableForm(false); Submit(); return false; });
});

function RegisterTextbox(Textbox) {
  Textbox.bind("change keypress paste input", function() { EnableForm(ValidateForm()); });
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
  $('#submit').html('.');
  InProgressAnimation = window.setInterval(function() {
    if ($('#submit').html().length > 5) $('#submit').html('.');
    else $('#submit').append('.');
  }, 500);
};

function StopWaitingAnimation() {
  window.clearInterval(InProgressAnimation);
  $('#submit').html(SubmitDefault);
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

function Post(URL, Data) {
  $.post(URL, Data, function(result) {
    if (!result.success) {
      InProgress = false;
      EnableForm(true);
      ErrorFeedback(result.error);
    }
    else {
      StopWaitingAnimation();
      SuccessFeedback("Success! You are now being redirected...");
      window.location.replace(result.url);
    }
  }, 'json');
};
