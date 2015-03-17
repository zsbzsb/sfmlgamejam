<?php

$jams = $cache->get('jams_list_jams');
$jams = null; // todo remove this line
if ($jams == null)
{
  $stmt = $dbconnection->prepare('SELECT * FROM jams WHERE status != ? ORDER BY suggestionsbegin DESC;');
  $stmt->execute(array(JamStatus::Disabled));
  $jams = $stmt->fetchAll();

  foreach ($jams as &$jam)
  {
    VerifyJamState($jam);
  }

  $cache->set('jams_list_jams', $jams, CACHE_TIME);
}

?>
