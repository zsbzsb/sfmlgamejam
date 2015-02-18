<?php

function Success($URL, $Message = '')
{
	header('Content-Type: application/json');
  echo '{ "success": true, "error": "", "url": "'.$URL.'", "message": "'.$Message.'" }';
  exit();
}

function Error($ErrorMessage)
{
	header('Content-Type: application/json');
  echo '{ "success": false, "error": "'.$ErrorMessage.'", "message": "" }';
  exit();
}

function RequirePostVariable($Variable)
{
  if (!isset($_POST[$Variable])) Error($Variable.' is not set.');
  else return htmlspecialchars(trim($_POST[$Variable]));
}

?>
