<?php require TEMPLATEROOT.'jam_header.php'; ?>

<h3 class="text-center">Submit Your Game</h3>
<br>

<?php

if ($jam['status'] == JamStatus::JamRunning || $jam['status'] == JamStatus::ReceivingGameSubmissions)
{
  echo '
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <form role="form" id="gameform">';

  require TEMPLATEROOT.'formfeedback.php';

  echo '
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" placeholder="GenOne1" value="'.(isset($game) ? $game['name'] : '').'" />
          </div>
          <div class="form-group">
            <label for="partner">Partner</label>
            <input type="text" class="form-control" id="partner" placeholder="Your Buddy" value="'.(isset($game) ? $game['partner'] : '').'" />
          </div>
          <div class="form-group">
            <label for="thumbnail">Thumbnail / Logo Link</label>
            <input type="text" class="form-control" id="thumbnail" placeholder="Spiffy Image Link" value="'.(isset($game) ? $game['thumbnailurl'] : '').'" />
          </div>
          <div class="form-group">
            <label>Screenshots</label>
            <table class="table table-striped table-bordered" id="screenshots">
              <col width="auto">
              <col width="100">
              <thead>
                <tr>
                  <th>URL</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>';
  if (isset($game))
  {
    foreach ($game['images'] as $image)
    {
      echo '<tr class="screenshotrow"><td><input type="text" style="width: 100%;" class="url" value="'.$image['url'].'" /></td><td><button type="button" class="btn btn-danger removerow">Remove</button></td></tr>';
    }
  }

  echo '
                <tr><td colspan="2"><button type="button" class="btn btn-info" id="addscreenshot">Add</button></tr></td>
              </tbody>
            </table>
          </div>
          <div class="form-group">
            <label>Download Links</label>
            <table class="table table-striped table-bordered" id="links">
              <col width="auto">
              <col width="auto">
              <col width="100">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>URL</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>';

  if (isset($game))
  {
    foreach ($game['links'] as $link)
    {
      echo '<tr class="linkrow"><td><input type="text" style="width: 100%;" class="title" value="'.$link['title'].'" /></td><td><input type="text" style="width: 100%;" class="url" value="'.$link['url'].'" /></td><td><button type="button" class="btn btn-danger removerow">Remove</button></td></tr>';
    }
  }

  echo '
                <tr><td colspan="3"><button type="button" class="btn btn-info" id="addlink">Add</button></tr></td>
              </tbody>
            </table>
          </div>
          <div class="form-group">
            <label for="about">Game Description</label>
            <ul class="nav nav-tabs" data-tabs="tabs">
              <li class="active"><a href="#edit" data-toggle="tab">Edit</a></li>
              <li><a href="#preview" data-toggle="tab">Preview</a></li>
            </ul>
            <div id="my-tab-content" class="tab-content">
              <div class="tab-pane active" id="edit">
                <textarea class="form-control" id="description" placeholder="Describe Your Game ;)">'.(isset($game) ? $game['description'] : '').'</textarea>
              </div>
              <div class="tab-pane" id="preview"></div>
            </div>
          </div>
          <button type="submit" class="btn btn-success pull-right disabled" id="gamesubmit">Submit</button>
        </form>
      </div>
    </div>';
}
else echo '<h4 class="text-center">Game submissions are closed</h4>';

?>

<script>
JamID = <?=$id?>;

$(function() {
  BindButtonClick($('#gamesubmit'), OnSubmit);
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) { if (e.target.childNodes[0].data == 'Preview') { LoadPreview($('#description'), $('#preview')); } })

  BindButtonClick($('#addscreenshot'), function(obj) {
    AddRow(obj, $('<tr class="screenshotrow"><td><input type="text" style="width: 100%;" class="url" /></td><td><button type="button" class="btn btn-danger removerow">Remove</button></td></tr>'));
  });

  BindButtonClick($('#addlink'), function(obj) {
    AddRow(obj, $('<tr class="linkrow"><td><input type="text" style="width: 100%;" class="title" /></td><td><input type="text" style="width: 100%;" class="url" /></td><td><button type="button" class="btn btn-danger removerow">Remove</button></td></tr>'));
  });

  BindButtonClick($('.removerow'), RemoveRow);
  BindTextboxChanged($('#name'), ValidateForm);
  BindTextboxChanged($('#thumbnail'), ValidateForm);
  BindTextboxChanged($('#description'), ValidateForm);
  BindTextboxChanged($('.screenshotrow > td > .url'), ValidateForm);
  BindTextboxChanged($('.linkrow > td > .title'), ValidateForm);
  BindTextboxChanged($('.linkrow > td > .url'), ValidateForm);

  ValidateForm();
});

function AddRow(obj, Row) {
  Row.find('.removerow').click(function() { RemoveRow(this) });
  Row.find('input').each(function(i, input) {
    if ($(input).attr('type') == 'text') BindTextboxChanged($(input), ValidateForm);
  });
  $(obj).parents('tr:first').before(Row);

  ValidateForm();
};

function RemoveRow(obj) {
  $(obj).parents('tr:first').remove();

  ValidateForm();
};

function ValidateForm() {
  var valid = true;

  if ($('#name').val().length == 0) valid = false;
  if ($('#thumbnail').val().length == 0) valid = false;
  if ($('#description').val().length == 0) valid = false;

  $('.linkrow').each(function(i, row) {
    var title = $(row).find('.title').val();
    var url = $(row).find('.url').val();

    if ((title.length > 0 && url.length == 0) || (title.length == 0 && url.length > 0)) valid = false;
  });

  EnableButton($('#gamesubmit'), valid);
  return valid;
};

function OnSubmit() {
  if (ValidateForm()) {
    Submit();
  }
};

function Submit() {
  EnableButton($('#gamesubmit'), false);
  EnableFormInput('#gameform', false);

  var animation = DotAnimation($('#gamesubmit'));

  var name = $('#name').val();
  var partner = $('#partner').val();
  var thumbnail = $('#thumbnail').val();
  var description = $('#description').val();
  var images = {};
  var links = {};
  var count = 0;

  $('.screenshotrow').each(function(i, row) {
    var url = $(row).find('.url').val();

    if (url.length > 0)
      images[count++] = { url:url };
  });

  count = 0;

  $('.linkrow').each(function(i, row) {
    var title = $(row).find('.title').val();
    var url = $(row).find('.url').val();

    if (title.length > 0 && url.length > 0)
      links[count++] = { title:title, url:url };
  });

  var success = false;

  Post('/api/v1/games/submit', { jamid:JamID, name:name, partner:partner, thumbnail:thumbnail, description:description, images:images, links:links })
    .done(function(result) {
      if (result.success) {
        SuccessFeedback('Your game submission was successful, redirecting...');
        success = true;
        Redirect('<?=$routes->generate('games_list', array('id' => $id))?>');
      }
      else ErrorFeedback(result.message);
    })
    .fail(function() {
      ErrorFeedback('An unexpected error happened, please try again.');
    })
    .always(function() {
      if (!success) {
        EnableButton($('#gamesubmit'), true);
        EnableFormInput('#gameform', true);
      }

      StopAnimation(animation);
      $('#gamesubmit').html('Submit');
    });
};
</script>
