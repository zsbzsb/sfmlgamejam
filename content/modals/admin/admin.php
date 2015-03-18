<?php

require SCRIPTROOT.'jamstates.php';

$stmt = $dbconnection->prepare('SELECT * FROM jams ORDER BY suggestionsbegin ASC;');
$stmt->execute();
$jams = $stmt->fetchAll();

foreach ($jams as &$jam)
{
  VerifyJamState($jam);
}

$stmt = $dbconnection->prepare('SELECT * FROM news ORDER BY date DESC;');
$stmt->execute();
$news = $stmt->fetchAll();

?>
