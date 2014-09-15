<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/settings/globals.php';

function CreateDBConnection()
{
  global $DATABASE_CONNECTION;
  global $DATABASE_USERNAME;
  global $DATABASE_PASSWORD;
  return new PDO($DATABASE_CONNECTION, $DATABASE_USERNAME, $DATABASE_PASSWORD, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}

$dbconnection = CreateDBConnection();
?>
