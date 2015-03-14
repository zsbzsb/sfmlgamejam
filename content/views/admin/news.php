<?php

$addnews = !isset($id);

if (!$addnews)
{
  $stmt = $dbconnection->prepare('SELECT * FROM news WHERE id = ?;');
  $stmt->execute(array($id));
  $rows = $stmt->fetchAll();
  if ($stmt->rowCount() == 0)
  {
    header('Location: '.$routes->generate('admin'));
    die();
  }
  $news = $rows[0];
}

?>

<div class="row">
  <h2 class="text-center"><?php echo $addnews ? 'Add' : 'Edit' ?> News<?php if (!$addnews) echo ' - ['.$news['title'].']' ?></h2>
</div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <form role="form" id="newsform">
      <?php require TEMPLATEROOT.'formfeedback.php'; ?>
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
      <button type="submit" class="btn btn-success pull-right disabled" id="newssubmit"><?php echo $addnews ? 'Add' : 'Save' ?></button>
    </form>
    <span><small>*All times are entered in UTC</small></span>
  </div>
</div>

<script>
AddNews = <?php echo $addnews ? 'true' : 'false'; ?>;
NewsID = <?php echo !$addnews ? $id : -1; ?>;

$(function() {
  // initialize the date-time picker
  $('#datecontainer').datetimepicker();

  // hookup the submit button
  BindButtonClick($('#newssubmit'), OnSubmit);

  // register textboxes for validation
  BindTextboxChanged($('#title'), ValidateForm);
  BindTextboxChanged($('#date'), ValidateForm);
  BindTextboxChanged($('#summary'), ValidateForm);
  BindTextboxChanged($('#content'), ValidateForm);


  // validate form when the selected date-time changes
  $('#datecontainer').on('dp.change', function(e) {
    ValidateForm();
  });

  // handle activation of the preview tab
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) { if (e.target.childNodes[0].data == 'Preview') { LoadPreview($('#content'), $('#preview')); } })
});

function OnSubmit() {
  if (ValidateForm()) {
    Submit();
  }
};

function ValidateForm() {
  valid = true;

  if ($('#title').val().length == 0) valid = false;
  if ($('#date').val().length == 0) valid = false;
  if ($('#summary').val().length == 0) valid = false;
  if ($('#content').val().length == 0) valid = false;

  EnableButton($('#newssubmit'), valid);
  return valid;
};

function Submit() {
  EnableButton($('#newssubmit'), false);
  EnableFormInput('#newsform', false);

  animation = DotAnimation($('#newssubmit'));

  title = $('#title').val();
  date = GetTimeStamp('#date');
  summary = $('#summary').val();
  content = $('#content').val();

  success = false;
  
  Post(AddNews ? '/api/v1/news/add' : '/api/v1/news/update', { id:NewsID, title:title, date:date, summary:summary, content:content })
    .done(function(result) {
      if (result.success) {
        SuccessFeedback('News has been successfully ' + (AddNews ? 'added' : 'updated') + ', redirecting...');
        success = true;
        Redirect('<?php echo $routes->generate('admin'); ?>');
      }
      else ErrorFeedback(result.message);
    })
    .fail(function() {
      ErrorFeedback('An unexpected error happened, please try again.');
    })
    .always(function() {
      if (!success) {
        EnableButton($('#newssubmit'), true);
        EnableFormInput('#newsform', true);
      }

      StopAnimation(animation);
      $('#newssubmit').html(AddNews ? 'Add' : 'Save');
    });
};
</script>
