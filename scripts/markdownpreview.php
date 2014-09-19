<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/feedback.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/parsedown/Parsedown.php';

$text = htmlspecialchars(trim(RequirePostVariable('text')));

$parser = new Parsedown();
Success('', preg_replace("/\r\n|\r|\n/", '', $parser->text($text)));

?>
