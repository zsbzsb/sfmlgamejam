<?php

if (strlen($avatar) > 0 && !URLValid($avatar)) $error = 'Avatar is not a valid link.';
else if (strlen($website) > 0 && !URLValid($website)) $error = 'Website is not a valid link.';

if (isset($error)) SendResponse(array('success' => false, 'message' => $error));
else
{
  $stmt = $dbconnection->prepare('UPDATE users SET avatar = ?, website = ?, about = ? WHERE id = ?;');
  $stmt->execute(array($avatar, $website, $about, $session->GetUserID()));

  SendResponse(array('success' => true));
}
?>
