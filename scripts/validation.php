<?php

function EmailValid($Email)
{
  return filter_var($Email, FILTER_VALIDATE_EMAIL);
}

function URLValid($URL)
{
  return preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $URL);
}

?>
