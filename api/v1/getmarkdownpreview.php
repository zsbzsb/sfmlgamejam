<?php

REQUIRE SCRIPTROOT.'parsedown/Parsedown.php';

$parser = new Parsedown();

SendResponse(array('result' => preg_replace("/\r\n|\r|\n/", '', $parser->text($text))));

?>
