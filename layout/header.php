<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';

if ((isset($RequiresAuthentication) && $RequiresAuthentication) || (isset($RequiresAdmin) && $RequiresAdmin))
  RequireAuthentication(isset($RequiresAdmin) && $RequiresAdmin);
else if (isset($RequiresGuest) && $RequiresGuest)
  RequireGuest()

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Meta -->
    <title>SFML Game Jam<?php if (isset($Title)) echo ' - '.$Title; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="/css/custom-theme.css" rel="stylesheet">

    <!-- JQuery -->
    <script src="/js/jquery-2.1.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="/js/bootstrap.min.js"></script>

    <!-- Custom Animation -->
    <script src="/js/animation.js"></script>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/images/logo.png" />
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/"><img src="/images/logo.png" alt="" class="navbar-logo"></a>
          <a class="navbar-brand" href="/">SFML Game Jam</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <?php if(!isset($Active)) $Active = ""; ?>
            <li<?php if ($Active == "Home") echo ' class="active"'; ?>><a href="/home">Home</a></li>
            <li<?php if ($Active == "News") echo ' class="active"'; ?>><a href="/news">News</a></li>
            <li<?php if ($Active == "Jams") echo ' class="active"'; ?>><a href="/jams">Jams</a></li>
            <li<?php if ($Active == "Rules") echo ' class="active"'; ?>><a href="/rules">Rules</a></li>
            <?php if ($session->GetStatus() == AccountStatus::Admin) echo '<li'.($Active == "Admin" ? ' class="active"' : '').'><a href="/admin">Admin</a></li>'; ?>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <?php
              if ($session->IsLoggedIn()) echo '<li><a href="/account">Welcome '.$session->GetUsername().'</a></li><li><a href="/logout" id="logoutlink"><span class="glyphicon glyphicon-off"></span></a></li>';
              else echo '<li'.($Active == "Login" ? ' class="active"' : '').'><a href="/login">Login</a></li><li'.($Active == "Register" ? ' class="active"' : '').'><a href="/register">Register</a></li>';
            ?>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container" id="contentarea">
