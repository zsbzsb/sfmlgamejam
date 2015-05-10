<?php

if (strlen($title) == 0) $error = 'Title can not be blank';
else if ($themesperuser <= 0) $error = 'Themes per user must be greater than 0';
else if ($initialvotingrounds <= 0) $error = 'Initial voting rounds must be greater than 0';
else if ($votesperuser <= 0) $error = 'Votes per user must be greater than 0';
else if ($topthemesinfinal <= 0) $error = 'Top themes in final must be greater than 0';
else if ($suggestionsbegin <= 0) $error = 'Suggestions begin must be greater than 0';
else if ($suggestionslength <= 0) $error = 'Suggestions length must be greater than 0';
else if ($approvallength <= 0) $error = 'Approval length must be greater than 0';
else if ($votinglength <= 0) $error = 'Voting length must be greater than 0';
else if ($themeannouncelength <= 0) $error = 'Theme announce length must be greater than 0';
else if ($jamlength <= 0) $error = 'Jam length must be greater than 0';
else if ($submissionslength <= 0) $error = 'Submissions length must be greater than 0';
else if ($judginglength <= 0) $error = 'Judging length must be greater than 0';

if (isset($error)) SendResponse(array('success' => false, 'message' => $error));
else
{
// TODO current round is not reset as it cause issues with voting
// find a way to handle this

  $stmt = $dbconnection->prepare('UPDATE jams SET title = ?, themesperuser = ?, autoapprovethemes = ?, initialvotingrounds = ?, votesperuser = ?, topthemesinfinal = ?, suggestionsbegin = ?, suggestionslength = ?, approvallength = ?, votinglength = ?, themeannouncelength = ?, jamlength = ?, submissionslength = ?, judginglength = ?, status = ? WHERE id = ?;');
  $stmt->execute(array($title, $themesperuser, $autoapprovethemes ? 1 : 0, $initialvotingrounds, $votesperuser, $topthemesinfinal, $suggestionsbegin, $suggestionslength, $approvallength, $votinglength, $themeannouncelength, $jamlength, $submissionslength, $judginglength, JamStatus::WaitingSuggestionsStart, $id));

  SendResponse(array('success' => true));
}

?>
