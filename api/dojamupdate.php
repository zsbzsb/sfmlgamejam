<?php

if (strlen($title) == 0) $error = 'Title can not be blank';
else if ($suggestionsstart >= $suggestionsend) $error = 'Suggestions Start must come before Suggestions End';
else if ($suggestionsend >= $jamstart) $error = 'Suggestions End must come before Jam Start';

if (isset($error)) SendResponse(array('success' => false, 'message' => $error));
else
{
  $stmt = $dbconnection->prepare('UPDATE jams SET title = ?, suggestionsstart = ?, suggestionsend = ?, jamstart = ? WHERE id = ?;');
  $stmt->execute(array($title, $suggestionsstart, $suggestionsend, $jamstart, $id));

  SendResponse(array('success' => true));
}

?>
