<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/feedback.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/validation.php';

RequireAuthentication(true);

$id = RequirePostVariable('id');
$title = RequirePostVariable('title');
$suggestionsstart = RequirePostVariable('suggestionsstart');
$suggestionsend = RequirePostVariable('suggestionsend');
$jamstart = RequirePostVariable('jamstart');

if (strlen($title) == 0) Error('Title can not be blank');
else if ($suggestionsstart >= $suggestionsend) Error('Suggestions Start must come before Suggestions End');
else if ($suggestionsend >= $jamstart) Error('Suggestions End must come before Jam Start');

$stmt = $dbconnection->prepare('UPDATE jams SET title = ?, suggestionsstart = ?, suggestionsend = ?, jamstart = ? WHERE id = ?;');
$stmt->execute(array($title, $suggestionsstart, $suggestionsend, $jamstart, $id));
Success('/admin');

?>
