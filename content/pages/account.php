<div class="row">
  <h2 class="text-center">Account Panel</h2>
  <h3 class="text-center">Edit Profile</h3>
</div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <form role="form" id="profileform">
      <?php require TEMPLATEROOT.'formfeedback.php'; ?>
      <div class="form-group">
        <label for="avatar">Avatar</label>
        <input type="text" class="form-control" id="avatar" placeholder="Image Link" value="<?php echo $session->GetInfo()['avatar']; ?>" />
      </div>
      <div class="form-group">
        <label for="website">Website</label>
        <input type="text" class="form-control" id="website" placeholder="Website Link" value="<?php echo $session->GetInfo()['website']; ?>" />
      </div>
      <div class="form-group">
        <label for="about">Profile Summary</label>
         <ul class="nav nav-tabs" data-tabs="tabs">
           <li class="active"><a href="#edit" data-toggle="tab">Edit</a></li>
           <li><a href="#preview" data-toggle="tab">Preview</a></li>
         </ul>
         <div id="my-tab-content" class="tab-content">
           <div class="tab-pane active" id="edit">
             <textarea class="form-control" id="about" placeholder="Write about Yourself ;)"><?php echo $session->GetInfo()['about']; ?></textarea>
           </div>
           <div class="tab-pane" id="preview">
           </div>
         </div>
      </div>
      <button type="button" class="btn btn-success pull-right" id="profilesubmit">Save</button>
    </form>
  </div>
</div>

<script>
$(function() {
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) { if (e.target.childNodes[0].data == 'Preview') { LoadPreview(); } })
  BindButtonClick($('#profilesubmit'), Submit);
});

function LoadPreview() {
  $('#preview').css('min-height', $('#edit').css('height'));

  animation = DotAnimation($('#preview'), 'Loading');
  text = $('#about').val();

  Post('/api/v1/markdown/preview', { text:text })
    .done(function(result) {
      StopAnimation(animation);
      $('#preview').html(result.result);
    })
    .fail(function() {
      StopAnimation(animation);
      $('#preview').html('Failed to load the preview :(');
    });
};

function Submit() {
  EnableButton($('#profilesubmit'), false);
  EnableFormInput('#profileform', false);

  animation = DotAnimation($('#profilesubmit'));

  var avatar = $('#avatar').val();
  var website = $('#website').val();
  var about = $('#about').val();

  Post('/api/v1/profile/update', { avatar:avatar, website:website, about:about })
    .done(function(result) {
      if (result.success) SuccessFeedback('Your profile has been updated successfully');
      else ErrorFeedback(result.message);
    })
    .fail(function() {
      ErrorFeedback('An unexpected error happened when trying to update your profile');
    })
    .always(function() {
      EnableButton($('#profilesubmit'), true);
      EnableFormInput('#profileform', true);

      StopAnimation(animation);
      $('#profilesubmit').html('Save');
    });
};
</script>
