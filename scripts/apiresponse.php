<?php

function EmailValid($Email)
{
  return filter_var($Email, FILTER_VALIDATE_EMAIL);
}

function URLValid($URL)
{
  return preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $URL);
}

function SendResponse($Response)
{
  global $SESSION;

  // if the session id is set in the cookies we will also send it in the response body
  if (isset($_COOKIE[$SESSION['tokenid']])) $Response['token'] = $_COOKIE[$SESSION['tokenid']];

  header('Content-type: application/json');
  echo json_encode($Response);
  die();
}

?>
