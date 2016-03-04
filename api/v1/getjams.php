<?php

$stmt = $dbconnection->prepare('SELECT id, title, suggestionsbegin, suggestionslength, approvallength, themeannouncelength, jamlength, submissionslength, judginglength, status, currentround FROM jams ORDER BY suggestionsbegin DESC;');
$stmt->execute();

$rows = $stmt->fetchAll();
SendResponse($rows);

?>
