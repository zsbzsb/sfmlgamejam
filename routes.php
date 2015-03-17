<?php

//////////////////////////////////////////////////////////////////////////////////////////////////
// PAGES | HTTP GET requests only
//////////////////////////////////////////////////////////////////////////////////////////////////

// Home
$routes->map('GET', '/', array('source' => 'home', 'title' => 'Home', 'active' => 'home'), null);
$routes->map('GET', '/home', array('source' => 'home', 'title' => 'Home', 'active' => 'home'), 'home');

// Register
$routes->map('GET', '/account/register', array('source' => 'register', 'title' => 'Register', 'active' => 'register', 'guestsonly' => true), 'register');

// Register Thanks
$routes->map('GET', '/account/register/thanks', array('source' => 'register_thanks', 'title' => 'Thanks for Registering!', 'usersonly' => true), 'register_thanks');

// Login
$routes->map('GET', '/account/login', array('source' => 'login', 'title' => 'Login', 'active' => 'login', 'guestsonly' => true), 'login');

// Account Panel
$routes->map('GET', '/account/panel', array('source' => 'account', 'title' => 'Account Panel', 'usersonly' => true), 'account');

// Logout
$routes->map('GET', '/account/logout', array('source' => 'logout'), 'logout');

// Terms of Use
$routes->map('GET', '/terms', array('source' => 'terms', 'title' => 'Terms of Use'), 'terms');

// News Feed
$routes->map('GET', '/news', array('source' => 'news_feed', 'title' => 'News', 'active' => 'news'), 'news');

// News Article
$routes->map('GET', '/news/[i:id]', array('source' => 'news_article', 'title' => 'News', 'active' => 'news'), 'news_article');

// Jams
$routes->map('GET', '/jams', array('source' => 'jams_list', 'title' => 'Game Jams', 'active' => 'jams'), 'jams');

// Rules
$routes->map('GET', '/rules', array('source' => 'rules', 'title' => 'Rules', 'active' => 'rules'), 'rules');

// Admin Panel
$routes->map('GET', '/admin', array('source' => 'admin/admin', 'title' => 'Admin Panel', 'active' => 'admin', 'adminsonly' => true), 'admin');

// Jam Admin
$routes->map('GET', '/admin/jam/[i:id]?', array('source' => 'admin/jam', 'title' => 'Jam Admin', 'active' => 'admin', 'adminsonly' => true), 'jamadmin');

// Themes Admin
$routes->map('GET', '/admin/themes/[i:id]', array('source' => 'admin/theme', 'title' => 'Theme Admin', 'active' => 'admin', 'adminsonly' => true), 'themeadmin');

// News Admin
$routes->map('GET', '/admin/news/[i:id]?', array('source' => 'admin/news', 'title' => 'News Admin', 'active' => 'admin', 'adminsonly' => true), 'newsadmin');

//////////////////////////////////////////////////////////////////////////////////////////////////
// API | HTTP POST requests only
//////////////////////////////////////////////////////////////////////////////////////////////////

// Login
$routes->map('POST', '/api/v1/account/login', array('source' => 'v1/dologin', 'postvariables' => array('username', 'password'), 'guestsonly' => true), null);

// Register
$routes->map('POST', '/api/v1/account/register', array('source' => 'v1/doregister', 'postvariables' => array('username', 'password', 'email'), 'guestsonly' => true), null);

// Markdown Preview
$routes->map('POST', '/api/v1/markdown/preview', array('source' => 'v1/getmarkdownpreview', 'postvariables' => array('text')), null);

// Profile Update
$routes->map('POST', '/api/v1/profile/update', array('source' => 'v1/doprofileupdate', 'postvariables' => array('avatar', 'website', 'about'), 'usersonly' => true), null);

// Get Jams
$routes->map('POST', '/api/v1/jams', array('source' => 'v1/getjams', 'optionalvariables' => array('startdate', 'enddate')), null);

// Jam Create
$routes->map('POST', '/api/v1/jams/create', array('source' => 'v1/dojamcreate', 'postvariables' => array('title', 'suggestionsstart', 'suggestionsend', 'jamstart'), 'adminsonly' => true), null);

// Jam Update
$routes->map('POST', '/api/v1/jams/update', array('source' => 'v1/dojamupdate', 'postvariables' => array('id', 'title', 'suggestionsstart', 'suggestionsend', 'jamstart'), 'adminsonly' => true), null);

// Get News
$routes->map('POST', '/api/v1/news', array('source' => 'v1/getnews', 'optionalvariables' => array('beforedate', 'afterdate')), null);

// News Add
$routes->map('POST', '/api/v1/news/add', array('source' => 'v1/donewsadd', 'postvariables' => array('title', 'date', 'summary', 'content'), 'adminsonly' => true), null);

// News Update
$routes->map('POST', '/api/v1/news/update', array('source' => 'v1/donewsupdate', 'postvariables' => array('id', 'title', 'date', 'summary', 'content'), 'adminsonly' => true), null);

// News Delete
$routes->map('POST', '/api/v1/news/delete', array('source' => 'v1/donewsdelete', 'postvariables' => array('id')), null);

?>
