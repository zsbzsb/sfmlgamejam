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

// News
$routes->map('GET', '/news/[i:id]?', array('source' => 'news.php', 'title' => 'News', 'active' => 'news'), 'news');

// Jams
$routes->map('GET', '/jams/[i:id]?', array('source' => 'jams.php', 'title' => 'Jams', 'active' => 'jams'), 'jams');

// Rules
$routes->map('GET', '/rules', array('source' => 'rules.php', 'title' => 'Rules', 'active' => 'rules'), 'rules');

// Admin Panel
$routes->map('GET', '/admin', array('source' => 'admin/admin.php', 'title' => 'Admin Panel', 'active' => 'admin', 'adminsonly' => true), 'admin');

// Jam Admin
$routes->map('GET', '/admin/jam/[i:id]?', array('source' => 'admin/jam.php', 'title' => 'Jam Admin', 'active' => 'admin', 'adminsonly' => true), 'jamadmin');

// Themes Admin
$routes->map('GET', '/admin/themes/[i:id]', array('source' => 'admin/theme.php', 'title' => 'Theme Admin', 'active' => 'admin', 'adminsonly' => true), 'themeadmin');

// News Admin
$routes->map('GET', '/admin/news/[i:id]?', array('source' => 'admin/news.php', 'title' => 'News Admin', 'active' => 'admin', 'adminsonly' => true), 'newsadmin');

//////////////////////////////////////////////////////////////////////////////////////////////////
// API | HTTP POST requests only
//////////////////////////////////////////////////////////////////////////////////////////////////

// Login
$routes->map('POST', '/api/v1/account/login', array('source' => 'v1/dologin.php', 'postvariables' => array('username', 'password'), 'guestsonly' => true), null);

// Register
$routes->map('POST', '/api/v1/account/register', array('source' => 'v1/doregister.php', 'postvariables' => array('username', 'password', 'email'), 'guestsonly' => true), null);

// Markdown Preview
$routes->map('POST', '/api/v1/markdown/preview', array('source' => 'v1/getmarkdownpreview.php', 'postvariables' => array('text')), null);

// Profile Update
$routes->map('POST', '/api/v1/profile/update', array('source' => 'v1/doprofileupdate.php', 'postvariables' => array('avatar', 'website', 'about'), 'usersonly' => true), null);

// Get Jams
$routes->map('POST', '/api/v1/jams', array('source' => 'v1/getjams.php', 'optionalvariables' => array('startdate', 'enddate')), null);

// Jam Create
$routes->map('POST', '/api/v1/jams/create', array('v1/source' => 'dojamcreate.php', 'postvariables' => array('title', 'suggestionsstart', 'suggestionsend', 'jamstart'), 'adminsonly' => true), null);

// Jam Update
$routes->map('POST', '/api/v1/jams/update', array('v1/source' => 'dojamupdate.php', 'postvariables' => array('id', 'title', 'suggestionsstart', 'suggestionsend', 'jamstart'), 'adminsonly' => true), null);

// Get News
$routes->map('POST', '/api/v1/news', array('v1/source' => 'getnews.php', 'optionalvariables' => array('beforedate', 'afterdate')), null);

// News Add
$routes->map('POST', '/api/v1/news/add', array('v1/source' => 'donewsadd.php', 'postvariables' => array('title', 'date', 'summary', 'content'), 'adminsonly' => true), null);

// News Update
$routes->map('POST', '/api/v1/news/update', array('v1/source' => 'donewsupdate.php', 'postvariables' => array('id', 'title', 'date', 'summary', 'content'), 'adminsonly' => true), null);

?>
