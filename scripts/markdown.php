<?php

REQUIRE SCRIPTROOT.'parsedown/Parsedown.php';

function ParseMarkdown($Markdown)
{
  $parser = new Parsedown();

  return(preg_replace("/\r\n|\r|\n/", '', $parser->text($Markdown)));
}

?>
