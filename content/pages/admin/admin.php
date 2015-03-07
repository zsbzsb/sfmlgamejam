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
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Theme Suggestions Start</th>
                  <th>Theme Suggestions End</th>
                  <th>Jam Start</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $stmt = $dbconnection->prepare('SELECT * FROM jams ORDER BY jamstart ASC;');
                  $stmt->execute();
                  $rows = $stmt->fetchAll();
                  foreach ($rows as $row)
                  {
                    echo '
                    <tr class="jamrow" jamtitle="'.$row['title'].'" jamediturl="'.$routes->generate('jamadmin', array('id' => $row['id'])).'" themesediturl="'.$routes->generate('themeadmin', array('id' => $row['id'])).'">
                      <td>'.$row['title'].'</td>
                      <td>'.date($DATETIME_FORMAT, $row['suggestionsstart']).'</td>
                      <td>'.date($DATETIME_FORMAT, $row['suggestionsend']).'</td>
                      <td>'.date($DATETIME_FORMAT, $row['jamstart']).'</td>
                    </tr>';
                  }
                ?>
              </tbody>
            </table>
            <a href="<?php echo $routes->generate('jamadmin'); ?>" class="btn btn-info pull-right" id="newjam">Create Jam</a>
          </div>
          <div class="tab-pane" id="news">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Date</th>
                  <th>Summary</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $stmt = $dbconnection->prepare('SELECT * FROM news ORDER BY date DESC;');
                  $stmt->execute();
                  $rows = $stmt->fetchAll();
                  foreach ($rows as $row)
                  {
                    echo '
                    <tr class="newsrow" newstitle="'.$row['title'].'" newsediturl="'.$routes->generate('newsadmin', array('id' => $row['id'])).'">
                      <td>'.$row['title'].'</td>
                      <td>'.date($DATETIME_FORMAT, $row['date']).'</td>
                      <td>'.$row['summary'].'</td>
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
    $('#newsmodal-title').html('News Options - [' +  $(this).attr('newstitle') + ']');
    $('#newsmodal').modal('show');
  });
});
</script>
