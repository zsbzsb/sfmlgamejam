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
        <a class="navbar-brand" href="/"><img src="/assets/images/logo.png" alt="" class="navbar-logo"></a>
        <a class="navbar-brand" href="/">SFML Game Jam</a>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <?php $active = isset($target['active']) ? $target['active'] : ''; ?>
          <li<?php if ($active == 'home') echo ' class="active"'; ?>><a href="<?php echo $routes->generate('home'); ?>">Home</a></li>
          <li<?php if ($active == 'news') echo ' class="active"'; ?>><a href="<?php echo $routes->generate('news'); ?>">News</a></li>
          <li<?php if ($active == 'jams') echo ' class="active"'; ?>><a href="<?php echo $routes->generate('jams'); ?>">Jams</a></li>
          <li<?php if ($active == 'rules') echo ' class="active"'; ?>><a href="<?php echo $routes->generate('rules'); ?>">Rules</a></li>
          <?php if ($session->GetStatus() == AccountStatus::Admin || $session->GetStatus() == AccountStatus::Owner) echo '<li'.($active == "admin" ? ' class="active"' : '').'><a href="'.$routes->generate('admin').'">Admin</a></li>'; ?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <?php
            if ($session->IsLoggedIn()) echo '<li><a href="'.$routes->generate('account').'">Welcome '.$session->GetUsername().'</a></li><li><a href="'.$routes->generate('logout').'" id="logoutlink"><span class="glyphicon glyphicon-off"></span></a></li>';
            else echo '<li'.($active == "login" ? ' class="active"' : '').'><a href="'.$routes->generate('login').'">Login</a></li><li'.($active == "register" ? ' class="active"' : '').'><a href="'.$routes->generate('register').'">Register</a></li>';
          ?>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container" id="contentarea">
