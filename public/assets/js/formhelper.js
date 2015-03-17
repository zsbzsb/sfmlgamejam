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

function BindTextboxChanged(Textbox, Callback) {
  Textbox.bind('change keypress paste input', function() { Callback(); });
};

function BindButtonClick(Button, Callback) {
  Button.bind("click", function() { Callback(); return false; });
};

function Redirect(URL) {
  window.location.replace(URL);
};

function LoadPreview(EditContainer, PreviewContainer) {
  PreviewContainer.css('min-height', EditContainer.css('height'));

  animation = DotAnimation(PreviewContainer, 'Loading');
  text = EditContainer.val();

  Post('/api/v1/markdown/preview', { text:text })
    .done(function(result) {
      StopAnimation(animation);
      PreviewContainer.html(result.result);
    })
    .fail(function() {
      StopAnimation(animation);
      PreviewContainer.html('Failed to load the preview :(');
    });
};

function GetPicker(PickerID) {
  return $(PickerID).data('DateTimePicker');
};

function GetTimeStamp(PickerID) {
  datetime = GetPicker(PickerID).date();
  // convert local time into utc time *without* changing the offset
  // this ensures that times are entered as utc
  return datetime.add(datetime.utcOffset(), 'minutes').unix();
};

function IsNumber(Element) {
  return $(Element).val().match(/^[0-9]$/);
};

function Post(URL, Data) {
  jsondata = JSON.stringify(Data);

  return $.ajax({
    type: 'POST',
    url: URL, 
    data: jsondata,
    contentType: 'application/json',
    dataType: 'json' });
};
