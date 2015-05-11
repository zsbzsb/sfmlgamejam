<?php

require SCRIPTROOT.'jamstates.php';

$stmt = $dbconnection->prepare('SELECT * FROM jams ORDER BY suggestionsbegin ASC;');
$stmt->execute();
$jams = $stmt->fetchAll();

foreach ($jams as $key => $jam)
{
  VerifyJamState($jams[$key]);
}

$stmt = $dbconnection->prepare('SELECT * FROM news ORDER BY date DESC;');
$stmt->execute();
$news = $stmt->fetchAll();

?>
