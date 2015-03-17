<div class="row">
  <h2 class="text-center">Game Jams</h2>
</div>

<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
      <div class="panel-body">
        <table class="table table-striped">
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
              }

            ?>
          </tbody>
        </table>
        <?php if (count($jams) == 0) echo 'Nothing was found :('; ?>
      </div>
    </div>
  </div>
</div>
