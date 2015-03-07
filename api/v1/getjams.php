<?php

if (!isset($startdate)) $startdate = 0;
if (!isset($enddate)) $enddate = PHP_INT_MAX;

$stmt = $dbconnection->prepare('SELECT id, title, suggestionsstart, suggestionsend, jamstart FROM jams WHERE jamstart >= ? AND jamstart <= ? ORDER BY jamstart ASC;');
$stmt->execute(array($startdate, $enddate));

$rows = $stmt->fetchAll();
SendResponse($rows);

?>
