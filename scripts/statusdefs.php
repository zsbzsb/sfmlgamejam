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
  const ReceivingSuggestions = 1;
  const WaitingThemeApprovals = 2;
  const ThemeVoting = 3;
  const ThemeAnnounced = 4;
  const JamRunning = 5;
  const ReceivingGameSubmissions = 6;
  const Judging = 7;
  const Complete = 8;
}

abstract class RatingState
{
  const NotReady = 0;
  const NeedLogin = 1;
  const OwnGame = 2;
  const Ready = 3;
  const Complete = 4;
}

abstract class CurrentRound
{
  const NotSelected = -1;
  const FinalRound = 0;
}

abstract class SelectedTheme
{
  const NotSelected = -1;
}

?>
