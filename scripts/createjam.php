<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/session/loginsession.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/scripts/feedback.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/scripts/validation.php';

RequireAuthentication(true);

$title = RequirePostVariable('title');
$suggestionsstart = RequirePostVariable('suggestionsstart');
$suggestionsend = RequirePostVariable('suggestionsend');
$jamstart = RequirePostVariable('jamstart');

if (strlen($title) == 0) Error('Title can not be blank');
else if ($suggestionsstart >= $suggestionsend) Error('Suggestions Start must come before Suggestions End');
else if ($suggestionsend >= $jamstart) Error('Suggestions End must come before Jam Start');

$stmt = $dbconnection->prepare('INSERT INTO jams (title, suggestionsstart, suggestionsend, jamstart) VALUES (?, ?, ?, ?);');
$stmt->execute(array($title, $suggestionsstart, $suggestionsend, $jamstart));
Success('/admin');

?>
