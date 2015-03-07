<?php

if (strlen($title) == 0) $error = 'Title can not be blank';
else if (strlen($summary) == 0) $error = 'Summary can not be blank';
else if (strlen($content) == 0) $error = 'Content can not be blank';

if (isset($error)) SendResponse(array('success' => false, 'message' => $error));
else
{
  $stmt = $dbconnection->prepare('UPDATE news SET title = ?, date = ?, summary = ?, content = ? WHERE id = ?;');
  $stmt->execute(array($title, $date, $summary, $content, $id));

  SendResponse(array('success' => true));
}

?>
