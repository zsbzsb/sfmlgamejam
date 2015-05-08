<?php

$stmt = $dbconnection->prepare('SELECT votesperuser, status, currentround FROM jams WHERE id = ?;');
$stmt->execute(array($jamid));

if ($stmt->rowCount() == 0) SendResponse(array('success' => false, 'message' => 'Invalid jam specified.'));
else
{
  $jam = $stmt->fetchAll()[0];

  if ($jam['status'] == JamStatus::ThemeVoting && $jam['currentround'] == $round)
  {
    $stmt = $dbconnection->prepare('SELECT themes.id, votes.id AS voteid FROM themes LEFT JOIN votes ON themes.id = votes.themeid AND votes.voterid = ? WHERE themes.jamid = ? AND themes.round = ?;');
    $stmt->execute(array($session->GetUserID(), $jamid, $round));
    $validthemes = $stmt->fetchAll();
    $existingvotecount = 0;
    $failed = false;

    // count existing votes
    foreach ($validthemes as $validtheme)
    {
      if ($validtheme['voteid'] != null) $existingvotecount++;
    }

    // ensure that we always handle neutral (0) votes first
    usort($votes, 'CompareVotes');

    foreach ($votes as $vote)
    {
      if ($vote['value'] == 0)
      {
        $stmt = $dbconnection->prepare('DELETE FROM votes WHERE jamid = ? AND round = ? AND voterid = ? AND themeid = ?;');
        $stmt->execute(array($jamid, $round, $session->GetUserID(), $vote['themeid']));

        $existingvotecount -= $stmt->rowCount();
      }
      else
      {
        $found = false;
        $existingid = -1;

        foreach ($validthemes as $validtheme)
        {
          if ($validtheme['id'] == $vote['themeid'])
          {
            $found = true;
            if ($validtheme['voteid'] != null) $existingid = $validtheme['voteid'];
            break;
          }
        }

        $votevalue = $vote['value'] > 0 ? 1 : -1;

        if ($existingid != -1 && $found)
        {
          $stmt = $dbconnection->prepare('UPDATE votes SET value = ? WHERE id = ?;');
          $stmt->execute(array($votevalue, $existingid));
        }
        else if ($existingvotecount < $jam['votesperuser'] && $found)
        {
          $stmt = $dbconnection->prepare('INSERT INTO votes (voterid, themeid, round, value, jamid) VALUES (?, ?, ?, ?, ?);');
          $stmt->execute(array($session->GetUserID(), $vote['themeid'], $round, $votevalue, $jamid));

          $existingvotecount++;
        }
        else
        {
          $failed = true;
        }
      }
    }

    if (!$failed) SendResponse(array('success' => true));
    else SendResponse(array('success' => false, 'message' => 'You have already submitted the maximum number of votes.'));
  }
  else SendResponse(array('success' => false, 'message' => 'Jam is no longer recieving votes.'));
}

function CompareVotes($A, $B)
{
  if ($A['value'] == $B['value']) return 0;
  else return abs($A['value']) < abs($B['value']) ? -1 : 1;
}

?>
