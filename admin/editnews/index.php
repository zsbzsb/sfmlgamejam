<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';

$addnews = !isset($_GET['id']);
$newsid = ($addnews ? -1 : trim($_GET['id']));
if (!$addnews)
{
  $stmt = $dbconnection->prepare('SELECT * FROM news WHERE id = ?;');
  $stmt->execute(array($newsid));
  $rows = $stmt->fetchAll();
  if ($stmt->rowCount() == 0)
  {
    header('Location: /admin');
    die();
  }
  $news = $rows[0];
}

?>

<?php $Title = ($addnews ? 'Add' : 'Edit').' News'; $RequiresAdmin = true; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<div class="row">
  <h2 class="text-center"><?php echo $addnews ? 'Add' : 'Edit' ?> News</h2>
</div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <form role="form" id="form">
      <div class="alert alert-dismissible hide" role="alert" id="feedback"><button type="button" class="close" id="feedback-hide"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><span id="feedback-content"></span></div>
      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" placeholder="Enter Title" value="<?php if (!$addnews) echo $news['title']; ?>" />
      </div>
      <div class="form-group">
        <label for="date">Date*</label>
        <div class="input-group date" id="datecontainer">
          <input type="text" class="form-control" id="date" placeholder="Select a Date" value="<?php if (!$addnews) echo date($DATETIME_FORMAT, $news['date']); ?>" />
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
      </div>
      <div class="form-group">
        <label for="summary">Summary</label>
        <input type="text" class="form-control" id="summary" placeholder="Enter Summary" value="<?php if (!$addnews) echo $news['summary']; ?>" />
      </div>
      <div class="form-group">
        <label for="about">Content</label>
         <ul class="nav nav-tabs" data-tabs="tabs">
           <li class="active"><a href="#edit" data-toggle="tab">Edit</a></li>
           <li><a href="#preview" data-toggle="tab">Preview</a></li>
         </ul>
         <div id="my-tab-content" class="tab-content">
           <div class="tab-pane active" id="edit">
             <textarea class="form-control" id="content" placeholder="News Content"><?php if (!$addnews) echo $news['content']; ?></textarea>
           </div>
           <div class="tab-pane" id="preview">
           </div>
         </div>
      </div>
      <button type="submit" class="btn btn-success pull-right disabled" id="submit"><?php echo $addnews ? 'Add' : 'Save' ?></button>
    </form>
    <span><small>*All times are entered in UTC</small></span>
  </div>
</div>

<!-- Custom Feedback -->
<script src="/js/feedback.js"></script>

<!-- DateTime Picker -->
<script src="/js/moment.min.js"></script>
<script src="/js/bootstrap-datetimepicker.min.js"></script>
<link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

<script>
var AddNews = <?php echo $addnews ? 'true' : 'false'; ?>;
var NewsID = <?php echo $newsid; ?>;

$(function() {
  // initialize the date-time picker
  $('#datecontainer').datetimepicker();

  // register textboxes for validation
  RegisterTextbox($('#title'));
  RegisterTextbox($('#date'));
  RegisterTextbox($('#summary'));
  RegisterTextbox($('#content'));


  // validate form when the selected date-time changes
  $('#datecontainer').on('dp.change', function(e) {
    RequestValidateForm();
  });

  // handle activation of the preview tab
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) { if (e.target.childNodes[0].data == 'Preview') { LoadPreview(); } })
});

function LoadPreview() {
  $('#preview').css('min-height', $('#edit').css('height'));
  DotAnimation($('#preview'), 'Loading');
  var text = $('#content').val();
  $.post('/scripts/markdownpreview.php', {text:text}, function(result) {
    StopAnimation($('#preview'));
    $('#preview').html(result.message);
  }, 'json');
};

function GetTimeStamp(PickerID) {
  return moment.utc($(PickerID).val().replace('UTC', '') + ' UTC').unix();
};

function ValidateForm() {
  var valid = true;

  if ($('#title').val().length == 0) valid = false;
  if ($('#date').val().length == 0) valid = false;
  if ($('#summary').val().length == 0) valid = false;
  if ($('#content').val().length == 0) valid = false;

  return valid;
};

function Submit() {
  var title = $('#title').val();
  var date = GetTimeStamp('#date');
  var summary = $('#suggestionsend').val();
  var jamstart = $('#jamstart').val();

  Post(AddNews ? '/scripts/addnews.php' : '/scripts/updatenews.php', {id:NewsID, title:title, date:date, summary:summary, content:content});
};
</script>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>
