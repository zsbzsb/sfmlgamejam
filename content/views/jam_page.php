<div class="row">
  <h2 class="text-center"><?=$jam['title']?></h2>
  <h4 class="text-center text-muted"><?= date(DATE_FORMAT, JamBegins($jam)).' to '.date(DATE_FORMAT, SubmissionsBegin($jam)); ?></h4>
  <?php require TEMPLATEROOT.'countdown.php'; ?>
  <hr />
</div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <ol class="breadcrumb text-center">
      <li><?= $jam['status'] == JamStatus::ReceivingSuggestions ? '<a href="'.$routes->generate('theme_suggestions', array('id' => $id)).'">Theme Suggestions</a>' : 'Theme Suggestions' ?></li>
      <li><?= $jam['status'] >= JamStatus::ThemeVoting ? '<a href="'.$routes->generate('theme_voting', array('id' => $id)).'">Theme Voting</a>' : 'Theme Voting' ?></li>
      <li><?= $jam['status'] >= JamStatus::JamRunning ? '<a href="'.$routes->generate('game_submissions', array('id' => $id)).'">GameSubmissions</a>' : 'Game Submissions' ?></li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <p>
      <?php

        if ($jam['status'] == JamStatus::WaitingSuggestionsStart)
          echo 'The jam has been scheduled and is currently waiting for theme suggestions to open. Once they open you will be able to submit your theme suggestions.';
        else if ($jam['status'] == JamStatus::ReceivingSuggestions)
          echo 'The jam is currently recieving theme suggestions. During this time feel free to submit your theme ideas so that they can be voted on.';
        else if ($jam['status'] == JamStatus::WaitingThemeApprovals)
          echo 'The jam has recieved theme suggestions and is currently waiting until voting on theme suggestions to open.';
        else if ($jam['status'] == JamStatus::ThemeVoting)
          echo 'The jam is now recieving votes to select the theme. There is multiple rounds and the winning themes from each round will advance to the final round. The theme that wins the final round will then be chosen as the theme of the jam. So get out and vote as every vote counts!';
        else if ($jam['status'] == JamStatus::ThemeAnnounced)
          echo 'The theme has been announced and this is the prep time. You can start designing your game and planning now, but you will need to wait a bit to start coding.';
        else if ($jam['status'] == JamStatus::JamRunning)
          echo 'The jam is now in progress, so what are you doing reading this? Grab that coffee and get back to coding ;)';
        else if ($jam['status'] == JamStatus::ReceivingGameSubmissions)
          echo 'The jam is now finished, but there is still time for you to submit that awesome game you made - so get that submission in so you can get it ranked.';
        else if ($jam['status'] == JamStatus::Complete)
          echo 'Well now that the jam is over you can look back over all the games and see the cool things that came out of this jam. And I am sure the game creators wouldn\'t mind if you still wanted to try out their games.';

      ?>
    </p>
  </div>
</div>
