<?php

$stmt = $dbconnection->prepare('SELECT * FROM jams ORDER BY suggestionsbegin ASC;');
$stmt->execute();
$jams = $stmt->fetchAll();

foreach ($jams as &$jam)
{
  VerifyJamState($jam);
}

?>
