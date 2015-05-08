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
  Textbox.bind('change keypress paste input', function() { Callback(this); });

  var last = Textbox.val();

  window.setInterval(function() {
    var text = Textbox.val();

    if (text != last) {
      last = text;
      Callback(this);
    }
  }, 100);
};

function BindButtonClick(Button, Callback) {
  Button.bind('click', function() { Callback(this); return false; });
};

function BindCheckboxChanged(Checkbox, Callback) {
  Checkbox.bind('change', function() { Callback(this) });
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
  numbermatch = /^[0-9]*$/;
  return numbermatch.test($(Element).val());
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
