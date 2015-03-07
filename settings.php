<?php

// global settings
// adjust this per install

$DATABASE = array
(
    'connection' => 'pgsql:host=localhost;dbname=sfmlgamejam;',
    'username' => 'postgres',
    'password' => 'password'
);

$SESSION = array
(
    'tokenid' => 'SessionID',
    'timeout' => (30/*days*/) * (24/*hours*/) * (60/*minutes*/) * (60/*seconds*/)
);

$DATETIME_FORMAT = 'm/d/Y h:i A';

define('CACHE_TIME', 60 * 2);

?>
