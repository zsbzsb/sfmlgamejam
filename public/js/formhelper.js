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

function EnableButton(Button, Enabled) {
  if (Enabled) Button.removeClass('disabled');
  else Button.addClass('disabled');
};

function EnableFormInput(Form, Enabled) {
  $(Form + ' :input').attr('disabled', !Enabled);
};

function BindTextboxChanged(Textbox, Callback)
{
  Textbox.bind('change keypress paste input', function() { Callback(); });
};

function BindButtonClick(Button, Callback)
{
  Button.bind("click", function() { Callback(); return false; });
};

function Redirect(URL)
{
  window.location.replace(URL);
};

function Post(URL, Data)
{
  jsondata = JSON.stringify(Data);

  return $.ajax({
    type: 'POST',
    url: URL, 
    data: jsondata,
    contentType: 'application/json',
    dataType: 'json' });
};
