<?php

function CreateDBConnection()
{
  global $DATABASE;

  return new PDO($DATABASE['connection'], $DATABASE['username'], $DATABASE['password'], array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}

?>
