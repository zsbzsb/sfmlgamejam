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

if (isset($error)) SendResponse(array('success' => false, 'message' => $error));
else
{
  $stmt = $dbconnection->prepare('INSERT INTO jams (title, themesperuser, autoapprovethemes, initialvotingrounds, votesperuser, topthemesinfinal, suggestionsbegin, suggestionslength, approvallength, votinglength, themeannouncelength, jamlength, submissionslength, status, currentround, selectedthemeid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);');
  $stmt->execute(array($title, $themesperuser, $autoapprovethemes ? 1 : 0, $initialvotingrounds, $votesperuser, $topthemesinfinal, $suggestionsbegin, $suggestionslength, $approvallength, $votinglength, $themeannouncelength, $jamlength, $submissionslength, JamStatus::WaitingSuggestionsStart, CurrentRound::NotSelected, SelectedTheme::NotSelected));

  SendResponse(array('success' => true));
}

?>
