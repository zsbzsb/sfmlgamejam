<?php

if (strlen($title) == 0) $error = 'Title can not be blank';
else if (strlen($summary) == 0) $error = 'Summary can not be blank';
else if (strlen($content) == 0) $error = 'Content can not be blank';

if (isset($error)) SendResponse(array('success' => false, 'message' => $error));
else
{
  $stmt = $dbconnection->prepare('INSERT INTO news (title, date, summary, content) VALUES (?, ?, ?, ?);');
  $stmt->execute(array($title, $date, $summary, $content));

  SendResponse(array('success' => true));
}

?>
