<?php

REQUIRE SCRIPTROOT.'markdown.php';

SendResponse(array('result' => ParseMarkdown($text)));

?>
