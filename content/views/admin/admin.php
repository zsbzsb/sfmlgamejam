<div class="row">
  <h2 class="text-center">Administration Panel</h2>
</div>

<div class="row">
  <div class="col-md-2">
    <div class="panel panel-default">
      <div class="panel-heading">Settings</div>
      <div class="panel-body">
        <ul class="nav nav-pills nav-stacked" data-tabs="tabs">
          <li class="active"><a href="#jams" data-toggle="tab">Jams</a></li>
          <li><a href="#news" data-toggle="tab">News</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="col-md-10">
    <div class="panel panel-default">
      <div class="panel-body">
        <div id="my-tab-content" class="tab-content">
          <div class="tab-pane active" id="jams">
            <table class="table table-striped clickabletable">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Suggestions Open</th>
                  <th>Jam Start</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php

                  foreach ($jams as $jam)
                  {
                    echo '
                      <tr class="jamrow" jamtitle="'.$jam['title'].'" jamediturl="'.$routes->generate('jamadmin', array('id' => $jam['id'])).'" themesediturl="'.$routes->generate('themeadmin', array('id' => $jam['id'])).'">
                        <td>'.$jam['title'].'</td>
                        <td>'.date(DATETIME_FORMAT, $jam['suggestionsbegin']).'</td>
                        <td>'.date(DATETIME_FORMAT, $jam['suggestionsbegin'] + $jam['suggestionslength'] + $jam['approvallength'] + $jam['themeannouncelength']).'</td>
                        <td>'.JamStatusString($jam['status']).'</td>
                      </tr>';
                  }

                ?>
              </tbody>
            </table>
            <a href="<?php echo $routes->generate('jamadmin'); ?>" class="btn btn-info pull-right" id="newjam">Create Jam</a>
          </div>
          <div class="tab-pane" id="news">
            <table class="table table-striped clickabletable">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Date</th>
                  <th>Summary</th>
                </tr>
              </thead>
              <tbody>
                <?php

                  foreach ($news as $article)
                  {
                    echo '
                      <tr class="newsrow" newsid ="'.$article['id'].'" newstitle="'.$article['title'].'" newsediturl="'.$routes->generate('newsadmin', array('id' => $article['id'])).'">
                        <td>'.$article['title'].'</td>
                        <td>'.date(DATETIME_FORMAT, $article['date']).'</td>
                        <td>'.$article['summary'].'</td>
                      </tr>';
                  }

                ?>
              </tbody>
            </table>
            <a href="<?php echo $routes->generate('newsadmin'); ?>" class="btn btn-info pull-right" id="newjam">Add News</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="jammodal" role="dialog" aria-hidden="true" aria-labelledby="jammodal-title">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="jammodal-title">Jam Options</h4>
      </div>
      <div class="modal-body">
        <a href="#" class="btn btn-info" id="editjam">Edit Jam</a>
        <a href="#" class="btn btn-info" id="viewthemes">View Themes</a>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="newsmodal" role="dialog" aria-hidden="true" aria-labelledby="newsmodal-title">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="newsmodal-title">News Options</h4>
      </div>
      <div class="modal-body">
        <a href="#" class="btn btn-info" id="editnews">Edit News</a>
        <button type="button" class="btn btn-danger" id="deletenews" newsid="-1" newstitle="">Delete News</button>
      </div>
    </div>
  </div>
</div>

<script>
$(function() {
  $('.jamrow').click(function() {
    $('#editjam').attr('href', $(this).attr('jamediturl'));
    $('#viewthemes').attr('href', $(this).attr('themesediturl'));
    $('#jammodal-title').html('Jam Options - [' +  $(this).attr('jamtitle') + ']');
    $('#jammodal').modal('show');
  });

  $('.newsrow').click(function() {
    $('#editnews').attr('href', $(this).attr('newsediturl'));
    $('#deletenews').attr('newsid', $(this).attr('newsid'));
    $('#deletenews').attr('newstitle', $(this).attr('newstitle'));
    $('#newsmodal-title').html('News Options - [' +  $(this).attr('newstitle') + ']');
    $('#newsmodal').modal('show');
  });

  $('#deletenews').click(function() {
    if (confirm('Are you sure you want to delete the news article "' + $(this).attr('newstitle') + '"?')) {
      id = $(this).attr('newsid');

      Post('/api/v1/news/delete', { id:id })
        .always(function() {
          Redirect('<?=$routes->generate('admin')?>');
        });
    }
  });
});
</script>
