<?php $Title = 'Account Panel'; $RequiresAuthentication = true; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<div class="row">
  <h2 class="text-center">Account Panel</h2>
  <h3 class="text-center">Edit Profile</h3>
</div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <form role="form" id="form">
      <div class="alert alert-dismissible hide" role="alert" id="feedback"><button type="button" class="close" id="feedback-hide"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><span id="feedback-content"></span></div>
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
      <button type="button" class="btn btn-success pull-right" id="submit">Save</button>
    </form>
  </div>
</div>

<!-- Custom Feedback -->
<script src="/js/feedback.js"></script>

<script>
$(function() {
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) { if (e.target.childNodes[0].data == 'Preview') { LoadPreview(); } })
});

function LoadPreview() {
  $('#preview').css('min-height', $('#edit').css('height'));
  DotAnimation($('#preview'), 'Loading');
  var text = $('#about').val();
  $.post('/scripts/markdownpreview.php', {text:text}, function(result) {
    StopAnimation($('#preview'));
    $('#preview').html(result.message);
  }, 'json');
}

function ValidateForm() {
  return true;
};

function Submit() {
  var avatar = $('#avatar').val();
  var website = $('#website').val();
  var about = $('#about').val();

  Post('/scripts/updateprofile.php', {avatar:avatar, website:website, about:about}, 'Profile was updated successfully.')
};
</script>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>
