<?php

// Home
$routes->map('GET','/', array('source' => 'home.php', 'title' => 'Home', 'active' => 'home'), null);
$routes->map('GET','/home', array('source' => 'home.php', 'title' => 'Home', 'active' => 'home'), 'home');

// Register
$routes->map('GET','/register', array('source' => 'register.php', 'title' => 'Register', 'active' => 'register'), 'register');

// Register Thanks
$routes->map('GET','/register/thanks', array('source' => 'register_thanks.php', 'title' => 'Thanks for Registering!'), 'register_thanks');

// Login
$routes->map('GET','/login', array('source' => 'login.php', 'title' => 'Login', 'active' => 'login'), 'login');

// Account Panel
$routes->map('GET','/account', array('source' => 'account.php', 'title' => 'Account Panel'), 'account');

// Logout
$routes->map('GET','/logout', array('source' => 'logout.php'), 'logout');

// Terms of Use
$routes->map('GET','/terms', array('source' => 'terms.php', 'title' => 'Terms of Use'), 'terms');

$routes->map('GET','/news', array('source' => 'news.php', 'title' => 'News', 'active' => 'news'), 'news');
$routes->map('GET','/jams', array('source' => 'jams.php', 'title' => 'Jams', 'active' => 'jams'), 'jams');
$routes->map('GET','/rules', array('source' => 'rules.php', 'title' => 'Rules', 'active' => 'rules'), 'rules');

?>
