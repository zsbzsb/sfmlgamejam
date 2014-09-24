<?php $Title = "Admin Panel"; $Active = "Admin"; $RequiresAdmin = true; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<div class="row">

</div>

<div class="row">
  <div class="col-md-2">
    <div class="panel panel-default">
      <div class="panel-heading">Admin Panel</div>
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
                  $stmt = $dbconnection->prepare("SELECT * FROM jams;");
                  $stmt->execute();
                  $rows = $stmt->fetchAll();
                  foreach ($rows as $row)
                  {
                    echo '
                    <tr>
                      <td>'.$row['title'].'</td>
                      <td>'.date($DATETIME_FORMAT, $row['suggestionsstart']).'</td>
                      <td>'.date($DATETIME_FORMAT, $row['suggestionsend']).'</td>
                      <td>'.date($DATETIME_FORMAT, $row['jamstart']).'</td>
                    </tr>';
                  }
                ?>
              </tbody>
            </table>
            <a href="/admin/createjam" class="btn btn-info pull-right" id="newjam">Create Jam</a>
          </div>
          <div class="tab-pane" id="news">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>
