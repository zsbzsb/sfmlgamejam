<div class="row">
  <h2 class="text-center">Game Jams</h2>
</div>

<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <table class="table table-striped table-bordered clickabletable">
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
              <tr class="jamrow" jamviewurl="'.$routes->generate('jam_page', array('id' => $jam['id'])).'">
                <td>'.$jam['title'].'</td>
                <td>'.date(DATETIME_FORMAT, $jam['suggestionsbegin']).'</td>
                <td>'.date(DATETIME_FORMAT, $jam['suggestionsbegin'] + $jam['suggestionslength'] + $jam['approvallength'] + $jam['themeannouncelength']).'</td>
                <td>'.JamStatusString($jam['status']).'</td>
              </tr>';
          }
        ?>
      </tbody>
    </table>
    <?php if (count($jams) == 0) echo 'Nothing was found :('; ?>
  </div>
</div>

<script>
$(function() {
  $('.jamrow').click(function() {
    Redirect($(this).attr('jamviewurl'));
  });
});
</script>
