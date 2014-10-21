<?php

//////////////////////////////////////////////////////////////////////////////////////////////////
// PAGES | HTTP GET requests only
//////////////////////////////////////////////////////////////////////////////////////////////////

// Home
$routes->map('GET', '/', array('source' => 'home.php', 'title' => 'Home', 'active' => 'home'), null);
$routes->map('GET', '/home', array('source' => 'home.php', 'title' => 'Home', 'active' => 'home'), 'home');

// Register
$routes->map('GET', '/register', array('source' => 'register.php', 'title' => 'Register', 'active' => 'register', 'guestsonly' => true), 'register');

// Register Thanks
$routes->map('GET', '/register/thanks', array('source' => 'register_thanks.php', 'title' => 'Thanks for Registering!', 'usersonly' => true), 'register_thanks');

// Login
$routes->map('GET', '/login', array('source' => 'login.php', 'title' => 'Login', 'active' => 'login', 'guestsonly' => true), 'login');

// Account Panel
$routes->map('GET', '/account', array('source' => 'account.php', 'title' => 'Account Panel', 'usersonly' => true), 'account');

// Logout
$routes->map('GET', '/logout', array('source' => 'logout.php'), 'logout');

// Terms of Use
$routes->map('GET', '/terms', array('source' => 'terms.php', 'title' => 'Terms of Use'), 'terms');

// NON EXISTANT ROUTES
$routes->map('GET', '/news', array('source' => 'news.php', 'title' => 'News', 'active' => 'news'), 'news');
$routes->map('GET', '/jams', array('source' => 'jams.php', 'title' => 'Jams', 'active' => 'jams'), 'jams');
$routes->map('GET', '/rules', array('source' => 'rules.php', 'title' => 'Rules', 'active' => 'rules'), 'rules');

// Admin Panel
$routes->map('GET', '/admin', array('source' => 'admin.php', 'title' => 'Admin Panel', 'active' => 'admin', 'adminsonly' => true), 'admin');

//////////////////////////////////////////////////////////////////////////////////////////////////
// API | HTTP POST requests only
//////////////////////////////////////////////////////////////////////////////////////////////////

$routes->map('POST', '/api/v1/account/login', array('source' => 'dologin.php', 'postvariables' => array('username', 'password')), null);
$routes->map('POST', '/api/v1/account/register', array('source' => 'doregister.php', 'postvariables' => array('username', 'password', 'email')), null);

?>
