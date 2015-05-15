<?php require TEMPLATEROOT.'jam_header.php'; ?>

<h3 class="text-center">Find, Play, and Review Games!</h3>

<?php

if ($jam['status'] == JamStatus::JamRunning || $jam['status'] == JamStatus::ReceivingGameSubmissions)
{
  if ($session->IsLoggedIn()) echo '<h5 class="text-center"><a href="'.$routes->generate('game_submission', array('id' => $id)).'">Submit (or edit) your game submission</a></h5>';
  else echo '<h5 class="text-center">You must be <a href="'.$routes->generate('login').'">logged in</a> to submit your game</h5>';
}

?>

<br>

<div class="row">
  <div class="col-md-12">
    <div class="row">
      <?php

        foreach ($games as $game)
        {
          echo '
            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
              <a class="thumbnail" href="'.$routes->generate('game_page', array('id' => $id, 'gameid' => $game['id'])).'">
                <div class="gamebox">
                  <img alt="'.$game['name'].'" src="'.$game['thumbnailurl'].'" />
                  <div>'.$game['name'].'</div>
                </div>
              </a>
            </div>';
        }

        if (count($games) == 0) echo '<h4 class="text-center">No games were found :(</h4>';

      ?>
    </div>
  </div>
</div>
