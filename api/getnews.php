<?php

if (!isset($afterdate)) $afterdate = 0;
if (!isset($beforedate)) $beforedate = time();

if ($beforedate > time()) $beforedate = time(); 

$stmt = $dbconnection->prepare('SELECT id, title, date, summary, content FROM news WHERE date >= ? AND date <= ? ORDER BY date ASC;');
$stmt->execute(array($afterdate, $beforedate));

$rows = $stmt->fetchAll();
SendResponse($rows);

?>
