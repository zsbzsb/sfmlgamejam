<?php

$stmt = $dbconnection->prepare('DELETE FROM news WHERE id = ?;');
$stmt->execute(array($id));

SendResponse(array('success' => true));

?>
