<?php

abstract class AccountStatus
{
  const Banned = -1;
  const WaitingActivation = 0;
  const Normal = 1;
  const Admin = 2;
  const Owner = 3;
}

abstract class JamStatus
{
  const Disabled = -1;
  const WaitingSuggestionsStart = 0;
  const RecievingSuggestions = 1;
  const WaitingThemeApprovals = 2;
  const ThemeVoting = 3;
  const WaitingJamStart = 4;
  const JamRunning = 5;
  const RecievingGameSubmissions = 6;
  const Complete = 7;
}

abstract class CurrentRound
{
  const Final = 0;
}

?>
