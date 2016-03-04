<?php

require SCRIPTROOT.'jamstates.php';

$stmt = $dbconnection->prepare('SELECT * FROM jams ORDER BY suggestionsbegin DESC;');
$stmt->execute();

$rows = $stmt->fetchAll();
$jams = array();

foreach ($rows as $row)
{
  $jam = array();

  $jam['id'] = $row['id'];
  $jam['title'] = $row['title'];
  $jam['status'] = $row['status'];
  $jam['suggestionsbegin'] = SuggestionsBegin($row);
  $jam['votingbegins'] = VotingBegins($row);
  $jam['themeannounce'] = ThemeAnnounce($row);
  $jam['jambegins'] = JamBegins($row);
  $jam['submissionsbegin'] = SubmissionsBegin($row);
  $jam['submissionsend'] = SubmissionsEnd($row);
  $jam['judgingends'] = JudgingEnds($row);

  array_push($jams, $jam);
}

SendResponse($jams);

?>
