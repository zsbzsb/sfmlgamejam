<?php

function JamStatusString($Status)
{
  switch ($Status)
  {
    case JamStatus::Complete: return 'Jam Finished';
    case JamStatus::RecievingGameSubmissions: return 'Recieving Game Submissions';
    case JamStatus::JamRunning: return 'In Progress';
    case JamStatus::ThemeAnnounced: return 'Preparing to Start';
    case JamStatus::ThemeVoting: return 'Voting on Theme';
    case JamStatus::WaitingThemeApprovals: return 'Preparing to Vote';
    case JamStatus::RecievingSuggestions: return 'Recieving Theme Suggestions';
    case JamStatus::WaitingSuggestionsStart: return 'Scheduled';
  }
}

// this function can possibly be very heavy with DB operations
// ensure that it is only called when a cache expires
function VerifyJamState(&$Jam)
{
echo 'ver'; // todo remove this line
  global $dbconnection;

  $time = time();
  $length = $Jam['suggestionsbegin'] + $Jam['suggestionslength'] + $Jam['approvallength'] + $Jam['votinglength'] + $Jam['themeannouncelength'] + $Jam['jamlength'] + $Jam['submissionslength']

  if ($time > $length)
  {
    $status = JamStatus::Complete;
  }
  else if ($time > $length -= $Jam['submissionslength'])
  {
    $status = JamStatus::RecievingGameSubmissions;
  }
  else if ($time > $length -= $Jam['jamlength'])
  {
    $status = JamStatus::JamRunning;
  }
  else if ($time > $length -= $Jam['themeannouncelength'])
  {
    $status = JamStatus::ThemeAnnounced;
  }
  else if ($time > $length -= $Jam['votinglength'])
  {
    $status = JamStatus::ThemeVoting;
  }
  else if ($time > $length -= $Jam['approvallength'])
  {
    $status = JamStatus::WaitingThemeApprovals;
  }
  else if ($time > $length -= $Jam['suggestionslength'])
  {
    $status = JamStatus::RecievingSuggestions;
  }
  else
  {
    $status = JamStatus::WaitingSuggestionsStart;
  }

  $round = $Jam['currentround'];
  $selectedtheme = $Jam['selectedthemeid'];

  if ($status == JamStatus::ThemeVoting || ($status > JamStatus::ThemeVoting && $selectedtheme == SelectedTheme::NotSelected))
  {
    // we need to figure out what round we are in
    // remember we must maintain the integrity of the data
    // so... if lots of time has been skipped we must still advance one round at a time

    // first find how far we have advanced into the voting period
    $timeoffset = $time - ($Jam['suggestionsbegin'] + $Jam['suggestionslength'] + $Jam['approvallength']);

    // next find out how long each round should last
    // round length = voting length / total rounds [inital rounds + the final round(1)]
    $roundlength = $Jam['votinglength'] / ($Jam['initialvotingrounds'] + 1);

    // track the round offset - after each iteration it will be increased by the round length
    $roundoffet = 0;

    // if no round is selected setup rounds
    if ($round == CurrentRound::NotSelected)
    {
      $round = $Jam['initialvotingrounds'];
      SetupInitialRounds($Jam['id'], $Jam['initialvotingrounds']);
    }

    // loop over each round and check if the round needs to be advanced
    for ($i = $Jam['initialvotingrounds']; $i >= 0; $i--)
    {
      // check if the timeoffset falls within this round
      // if it does advance the round if needed and break the loop
      if ($timeoffset >= $roundoffset && ($timeoffset < ($roundoffset + $roundlength) || $i == CurrentRound::FinalRound))
      {
        if ($round != $i)
        {
          $round = $i;
          if ($round == CurrentRound::FinalRound)
          {
            SetupFinalRound($Jam['id'], $Jam['initialvotingrounds'], $Jam['topthemesinfinal']);
          }
        }
        break;
      }
      // previously selected round is no longer the active round
      // so advance one round ahead
      else if ($round > $i)
      {
        $round = $i;
      }

      $roundoffet += $roundlength;
    }

    if ($status > JamStatus::ThemeVoting && $selectedtheme == SelectedTheme::NotSelected)
    {
      // todo calculate the theme that won
    }

    if ($status != $Jam['status'] || $round != $Jam['currentround'] || $selectedtheme != $Jam['selectedthemeid'])
    {
      $stmt = $dbconnection->prepare('UPDATE jams SET status = ?, currentround = ?, selectedthemeid = ? WHERE id = ?;');
      $stmt->execute(array($status, $round, $selectedtheme));
      $Jam['status'] = $status;
      $Jam['currentround'] = $round;
      $Jam['selectedthemeid'] = $selectedtheme;
    }
  }
}


// this function is not intended to be called directly
// if it is called from outside VerifyJamState(...) you are going to break something
// YOU HAVE BEEN WARNED ;)
function SetupInitialRounds($JamID, $RoundCount)
{
  global $dbconnection;

  $stmt = $dbconnection->prepare('SELECT * FROM themes WHERE jamid = ? AND isapproved = ?;');
  $stmt->execute(array($JamID, true));
  $themes = $stmt->fetchAll();

  if ($count = count($themes) == 0) return;

  $themesperround = intval(floor(floatval($count) / floatval($RoundCount)));
  $round = 1;
  $count = 0;

  foreach ($themes as $theme)
  {
    $stmt = $dbconnection->prepare('UPDATE themes SET round = ? WHERE id = ?;');
    $stmt->execute(array($round, $theme['id']));

    $count++;
    if ($count == $themesperround && $round < $RoundCount)
    {
      $round++;
      $count = 0;
    }
  }
}


// this function is not intended to be called directly
// if it is called from outside VerifyJamState(...) you are going to break something
// THIS IS NOT THE HOLODECK 8)
function SetupFinalRound($JamID, $RoundCount, $TopThemesinFinal)
{
  global $dbconnection;

  $finalthemes = array();
  $finalthemescount = 0;

  for ($i = $RoundCount; $i > 0; $i--)
  {
    $stmt = $dbconnection->prepare('SELECT * FROM themes WHERE jamid = ? AND round = ?;');
    $stmt->execute(array($JamID, $i));
    $themes = $stmt->fetchAll();

    if (count($themes) == 0) continue;

    foreach ($themes as &$theme)
    {
      $stmt = $dbconnection->prepare('SELECT value FROM votes WHERE themeid = ? AND round = ?;');
      $stmt->execute(array($theme['id'], $i));
      $votes = $stmt->fetchAll();

      $theme['votes'] = 0;
      foreach ($votes as $vote)
      {
        $theme['votes'] += $vote['value'];
      }
    }

    usort($themes, 'CompareThemeVotes');

    $gotalltop = false;
    for ($c = 0; $c < count($themes) && !$gotalltop; $c++)
    {
      $finalthemes[$finalthemescount++] = $themes[$c];

      if ($c + 1 == $TopThemesinFinal)
      {
        if ($c + 1 < count($themes) && $themes[$c]['votes'] > $themes[$c + 1]['votes'])
        {
          $gotalltop = true;
        }
      }
    }
  }

  // reset all rounds
  $stmt = $dbconnection->prepare('UPDATE themes SET round = ? WHERE jamid = ?;');
  $stmt->execute(array(CurrentRound::NotSelected, $JamID));

  foreach ($finalthemes as $theme)
  {
    $stmt = $dbconnection->prepare('UPDATE themes SET round = ? WHERE id = ?;');
    $stmt->execute(array(CurrentRound::FinalRound, $theme['id']));
  }
}

function CompareThemeVotes($A, $B)
{
  if ($A['votes'] == $B['votes'] return 0;
  else return ($A['votes'] < $B['votes']) ? 1 : -1;
}

?>
