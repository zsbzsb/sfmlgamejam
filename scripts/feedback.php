<?php

function Success($URL, $Message = '')
{
  echo '{ "success": true, "error": "", "url": "'.$URL.'", "message": "'.$Message.'" }';
  exit();
}

function Error($ErrorMessage)
{
  echo '{ "success": false, "error": "'.$ErrorMessage.'", "message": "" }';
  exit();
}

function RequirePostVariable($Variable)
{
  if (!isset($_POST[$Variable])) Error($Variable." is not set.");
  else return $_POST[$Variable];
}

?>
