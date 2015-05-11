<?php

require SCRIPTROOT.'jamstates.php';

$jams = $cache->get('jams_list_jams');
if ($jams == null)
{
  $stmt = $dbconnection->prepare('SELECT * FROM jams WHERE status != ? ORDER BY suggestionsbegin DESC;');
  $stmt->execute(array(JamStatus::Disabled));
  $jams = $stmt->fetchAll();

  foreach ($jams as $key => $jam)
  {
    VerifyJamState($jams[$key]);
  }

  $cache->set('jams_list_jams', $jams, CACHE_TIME);
}

?>
