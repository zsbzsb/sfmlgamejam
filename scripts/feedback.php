<?php

function Success($URL)
{
  echo '{ "success": true, "error": "", "url": "'.$URL.'" }';
  exit();
}

function Error($ErrorMessage)
{
  echo '{ "success": false, "error": "'.$ErrorMessage.'" }';
  exit();
}

function RequirePostVariable($Variable)
{
  if (!isset($_POST[$Variable])) Error($Variable." is not set.");
  else return $_POST[$Variable];
}

?>
