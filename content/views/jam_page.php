<div class="row">
  <h2 class="text-center"><?=$jam['title']?></h2>
  <h4 class="text-center"><?= date(DATE_FORMAT, JamBegins($jam)).' to '.date(DATE_FORMAT, SubmissionsBegin($jam)); ?></h4>
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
