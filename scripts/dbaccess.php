<?php

function CreateDBConnection()
{
  global $DATABASE;

  try
  {
    return new PDO($DATABASE['connection'], $DATABASE['username'], $DATABASE['password'], array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  }
  catch (Exception $e)
  {
    if (SHOW_ERRORS)
    {
      echo 'Failed to connect to the database, please ensure the DB is running and the connection settings are correct.';
      die();
    }
    else
    {
      ErrorPage(500);
    }
  }
}

?>
