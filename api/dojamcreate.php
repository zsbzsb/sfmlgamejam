<?php

if (strlen($title) == 0) $error = 'Title can not be blank';
else if ($suggestionsstart >= $suggestionsend) $error = 'Suggestions Start must come before Suggestions End';
else if ($suggestionsend >= $jamstart) $error = 'Suggestions End must come before Jam Start';

if (isset($error)) SendResponse(array('success' => false, 'message' => $error));
else
{
  $stmt = $dbconnection->prepare('INSERT INTO jams (title, suggestionsstart, suggestionsend, jamstart) VALUES (?, ?, ?, ?);');
  $stmt->execute(array($title, $suggestionsstart, $suggestionsend, $jamstart));

  SendResponse(array('success' => true));
}

?>
